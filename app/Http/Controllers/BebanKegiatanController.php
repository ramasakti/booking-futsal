<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BebanKegiatanModel;
use App\Models\KelasModel;
use Illuminate\Support\Facades\Auth;

class BebanKegiatanController extends Controller
{
    public function index()
    {
        $institusies = session('institusies')->pluck('institusi_id');
        $kelas = collect([]);
        // Kepala Sekolah
        if (session('roles')->contains('Kepala Sekolah')) {
            $kelas = KelasModel::whereIn('institusi_id', $institusies)->get();
        }
        // Tata Usaha
        else if (session('roles')->contains('Admin')) {
            $kelas = KelasModel::whereIn('institusi_id', $institusies)->get();
        }
        // Wali Kelas
        else if (session('roles')->contains('Wali Kelas')) {
            $kelas = KelasModel::whereIn('walas_id', Auth::user()->id)->get();
        }
        // Mitra Kelas
        else if (session('roles')->contains('Mitra Kelas')) {
            $kelas = KelasModel::whereIn('mitra_id', Auth::user()->id)->get();
        }
        // Super Admin
        else {
            $kelas = KelasModel::all();
        }

        return view("beban_kegiatan.index", [
            "title" => "Beban Kegiatan",
            "kelas" => $kelas
        ]);
    }
}
