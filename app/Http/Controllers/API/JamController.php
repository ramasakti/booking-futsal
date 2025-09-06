<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BookingsModel;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class JamController extends Controller
{
    public function getJamKosongByLapanganAndTanggal($lapangan_id, $tanggal)
    {
        $bookings = BookingsModel::where('lapangan_id', $lapangan_id)
            ->where('tanggal', $tanggal)
            ->where('status', 'success')
            ->get();

        $allSlots = [];
        for ($i = 0; $i < 24; $i++) {
            $allSlots[] = sprintf("%02d:00", $i);
        }

        $bookedSlots = [];
        foreach ($bookings as $b) {
            $mulai = Carbon::parse($b->jam_mulai)->hour;
            $durasi = $b->durasi_jam;

            for ($i = 0; $i < $durasi; $i++) {
                $jam = $mulai + $i;
                if ($jam < 24) { // jaga jaga kalau lewat dari 23:00
                    $bookedSlots[] = sprintf("%02d:00", $jam);
                }
            }
        }

        $availableSlots = array_values(array_diff($allSlots, $bookedSlots));

        return response()->json([
            'success' => true,
            'message' => 'Data Jam Kosong Lapangan',
            'payload' => $availableSlots
        ], 200);
    }
}
