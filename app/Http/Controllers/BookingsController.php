<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BookingsModel;
use App\Models\LapanganModel;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;

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
        // validasi data
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'tanggal'     => 'required|date',
            'jam'         => 'required',
            'durasi'      => 'required|integer|min:1',
            'total_bayar' => 'required|numeric|min:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $lapangan = LapanganModel::find($request->lapangan_id);

        // simpan booking dulu dengan status pending
        $booking = BookingsModel::create([
            'user_id'     => Auth::user()->id,
            'lapangan_id' => $request->lapangan_id,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam,
            'durasi_jam'  => $request->durasi,
            'total_harga' => $lapangan->harga * $request->durasi,
            'total_bayar' => $request->total_bayar,
            'status'      => 'pending'
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey    = env('MIDTRANS_SECRET_KEY');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // Data transaksi
        $params = [
            'transaction_details' => [
                'order_id'     => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount' => $booking->nominal,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id'       => $booking->lapangan_id,
                    'price'    => $booking->nominal,
                    'quantity' => 1,
                    'name'     => 'Booking Lapangan #' . $booking->lapangan_id,
                ]
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        try {
            return response()->json([
                'success'   => true,
                'snapToken' => $snapToken,
                'bookingId' => $booking->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update($id, Request $request) {}
}
