<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BookingsModel;
use App\Models\LapanganModel;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingsController extends Controller
{
    public function index()
    {
        if (session('roles')->pluck('role')->pluck('role')->contains('Pelanggan')) {
            $bookings = BookingsModel::with('lapangan')->where('user_id', Auth::user()->id)->get();
        } else {
            $bookings = BookingsModel::all();
        }

        return view('booking.index', [
            "title" => "Data Booking",
            "bookings" => $bookings
        ]);
    }

    public function booking()
    {
        $lapangans = LapanganModel::all();
        $selected_lapangan = new LapanganModel();

        $lapangan_id = request('lapangan_id');
        if ($lapangan_id) {
            $selected_lapangan = LapanganModel::with('foto')->where('id', $lapangan_id)->first();
        }

        return view('booking.booking', [
            "title" => "Booking Lapangan",
            "lapangans" => $lapangans,
            "selected_lapangan" => $selected_lapangan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'tanggal'     => 'required|date',
            'jam'         => 'required',
            'durasi'      => 'required|integer|min:1',
            'total_bayar' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $lapangan = LapanganModel::findOrFail($request->lapangan_id);

        // gunakan lockForUpdate untuk mencegah race condition pada saldo
        $user = User::where('id', Auth::user()->id)->lockForUpdate()->first();

        $totalHarga = (int) $lapangan->harga * (int) $request->durasi;
        $userSaldo  = (int) $user->saldo;
        $requestedCash = (int) $request->total_bayar; // nominal cash yg ingin dibayar user (dari frontend)

        // hitung batas minimal dan maksimal cash yang bisa dibayar setelah memperhitungkan saldo
        if ($userSaldo >= $totalHarga) {
            $minCash = 0;
            $maxCash = 0;
        } else {
            // minimal DP 50% dari totalHarga, dikurangi saldo user
            $minDp = (int) ceil($totalHarga * 0.5);
            $minCash = max(0, $minDp - $userSaldo);
            $maxCash = max(0, $totalHarga - $userSaldo);
        }

        // validasi requestedCash di server
        if ($requestedCash < $minCash || $requestedCash > $maxCash) {
            return response()->json([
                'success' => false,
                'message' => "Jumlah pembayaran tidak sesuai. Harus antara {$minCash} dan {$maxCash}.",
            ], 422);
        }

        // hitung saldo yang dipakai
        $saldoUsed = min($userSaldo, $totalHarga - $requestedCash);
        $cashToPay = $requestedCash;
        $totalPaid = $saldoUsed + $cashToPay; // nilai dp secara total (saldo + cash)

        $paymentReference = 'BOOK-' . uniqid() . '-' . time();
        $snapToken = null;

        try {
            DB::beginTransaction();

            // jika ada pembayaran via midtrans, buat token terlebih dahulu.
            if ($cashToPay > 0) {
                Config::$serverKey    = env('MIDTRANS_SECRET_KEY');
                Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                Config::$isSanitized  = true;
                Config::$is3ds        = true;

                $params = [
                    'transaction_details' => [
                        'order_id'     => $paymentReference,
                        'gross_amount' => $cashToPay,
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email'      => $user->email,
                    ],
                    'item_details' => [
                        [
                            'id'       => $lapangan->id,
                            'price'    => $cashToPay,
                            'quantity' => 1,
                            'name'     => 'Booking Lapangan #' . $lapangan->nama_lapangan,
                        ]
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
            }

            // Simpan booking (pastikan kolom saldo_used & bayar_midtrans sudah ditambahkan)
            $booking = BookingsModel::create([
                'user_id'           => $user->id,
                'lapangan_id'       => $lapangan->id,
                'tanggal'           => $request->tanggal,
                'jam_mulai'         => $request->jam,
                'durasi_jam'        => $request->durasi,
                'total_harga'       => $totalHarga,
                'total_bayar'       => $totalPaid, // saldoUsed + cashToPay
                'saldo_used'        => $saldoUsed,
                'bayar_midtrans'    => $cashToPay,
                'status'            => $cashToPay > 0 ? 'pending_payment' : 'paid',
                'payment_reference' => $paymentReference,
                'token'             => $snapToken
            ]);

            // kurangi saldo user & catat history (jika ada saldoUsed)
            if ($saldoUsed > 0) {
                $user->saldo = $user->saldo - $saldoUsed;
                $user->save();

                DB::table('saldo_histories')->insert([
                    'user_id' => $user->id,
                    'booking_id' => $booking->id,
                    'tipe' => 'use',
                    'jumlah' => $saldoUsed,
                    'keterangan' => 'Potongan saldo untuk booking ' . $booking->id,
                    'created_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'snapToken' => $snapToken,
                'bookingReference' => $paymentReference,
                'pakaiSaldo' => $saldoUsed,
                'bayarMidtrans' => $cashToPay,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            // pastikan tidak bocor error sensitif ke user di produksi
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function status($id)
    {
        try {
            $booking = BookingsModel::find($id);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking tidak ditemukan',
                ], 404);
            }

            Config::$serverKey    = env('MIDTRANS_SECRET_KEY');
            Config::$isProduction = false;
            Config::$isSanitized  = true;
            Config::$is3ds        = true;

            $status = Transaction::status($booking->payment_reference);

            if ($status->transaction_status === 'settlement') {
                // hanya update kalau belum final
                if (!in_array($booking->status, ['success', 'cancel'])) {
                    $booking->status = 'paid';
                    $booking->save();
                }
            }

            return response()->json([
                'success' => true,
                'payload' => $status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancel($id)
    {
        $booking = BookingsModel::with('pemesan')->where('id', $id)->firstOrFail();

        if ($booking->status === 'cancel') {
            return back()->with('info', 'Booking sudah dibatalkan sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // lock user row
            $user = User::where('id', $booking->user_id)->lockForUpdate()->first();

            $saldoToReturn = 0;
            $saldoUsed = (int) ($booking->saldo_used ?? 0);
            $bayarMidtrans = (int) ($booking->bayar_midtrans ?? 0);

            // Refund saldo yang dipakai selalu dikembalikan
            $saldoToReturn += $saldoUsed;

            // Tangani Midtrans
            if ($bayarMidtrans > 0 && $booking->payment_reference) {
                Config::$serverKey    = env('MIDTRANS_SECRET_KEY');
                Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                Config::$isSanitized  = true;
                Config::$is3ds        = true;

                try {
                    $status = Transaction::status($booking->payment_reference);
                    $txStatus = $status->transaction_status ?? null;
                } catch (\Exception $e) {
                    // jika status tidak ditemukan atau error, anggap tidak settled
                    $txStatus = null;
                    Log::warning('Midtrans status check failed: ' . $e->getMessage());
                }

                // Jika sudah settled/capture => tidak bisa cancel di Midtrans, kita kembalikan ke saldo user
                if (in_array($txStatus, ['settlement', 'capture'])) {
                    $saldoToReturn += $bayarMidtrans;
                } else {
                    // belom settled -> coba cancel transaksi di Midtrans (jika ada)
                    try {
                        Transaction::cancel($booking->payment_reference);
                    } catch (\Exception $e) {
                        // ignore error cancel, log saja
                        Log::warning('Midtrans cancel failed: ' . $e->getMessage());
                    }
                    // Karena belum settled, tidak perlu tambahkan bayarMidtrans ke saldo (tidak dibayarkan)
                }
            }

            // Tambahkan saldo kembali ke user (jika ada)
            if ($saldoToReturn > 0) {
                $user->saldo += $saldoToReturn;
                $user->save();

                DB::table('saldo_histories')->insert([
                    'user_id' => $user->id,
                    'booking_id' => $booking->id,
                    'tipe' => 'refund',
                    'jumlah' => $saldoToReturn,
                    'keterangan' => 'Refund pembatalan booking #' . $booking->id,
                    'created_at' => now()
                ]);
            }

            // Update status booking
            $booking->status = 'cancel';
            $booking->save();

            DB::commit();
            return back()->with('success', 'Booking dibatalkan dan saldo dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cancel booking failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal batal booking: ' . $e->getMessage());
        }
    }

    public function accept($id)
    {
        $booking = BookingsModel::find($id);
        $booking->status = 'success';
        $booking->save();

        return back()->with('success', 'Berhasil terima booking');
    }

    public function jadwal(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $lapangan_id = $request->query('lapangan_id');

        if (!$tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal Wajib Diisi!',
                'payload' => null
            ], 422);
        }

        $booking = DB::table('bookings')
            ->select(
                'bookings.*',
                'users.name AS booking_name',
                'lapangan.nama_lapangan'
            )
            ->join('users', 'users.id', 'bookings.user_id')
            ->join('lapangan', 'lapangan.id', 'bookings.lapangan_id')
            ->where('tanggal', $tanggal)
            ->where('bookings.status', 'success');

        if ($lapangan_id) {
            $booking->where('bookings.lapangan_id', $lapangan_id);
        }

        $booking = $booking->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Booking',
            'payload' => $booking
        ], 200);
    }

    public function callback() {}
}
