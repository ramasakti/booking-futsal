<?php

namespace App\Http\Controllers;

use App\Models\InstitusiModel;
use Illuminate\Http\Request;
use App\Models\KelasModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $institusies = session('institusies');
        $kelas = collect([]);
        $walas = collect([]);

        // Kepala Sekolah
        if (session('roles')->contains('Kepala Sekolah')) {
            $kelas = KelasModel::whereIn('institusi_id', $institusies->pluck('institusi_id'))->get();
            $guru = User::with(['userRole.role', 'userInstitusi'])
                ->where('userRole.role', 'Wali Kelas')
                ->get();
            dd($guru);
        }
        // Tata Usaha
        else if (session('roles')->contains('Admin')) {
            $kelas = KelasModel::whereIn('institusi_id', $institusies->pluck('institusi_id'))->get();
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
            $institusies = InstitusiModel::all();
            $kelas = KelasModel::all();
            $walas = User::with(['userRole.role', 'userInstitusi'])
                ->whereHas('userRole.role', function ($query) {
                    $query->where('role', 'Wali Kelas');
                })
                ->get();
        }

        return view("kelas.index", [
            "title" => "Data Kelas",
            "institusies" => $institusies,
            "kelas" => $kelas,
            "walas" => $walas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "institusi_id" => "required",
            "jenjang" => "required",
            "nama_kelas" => "required",
            "walas_id" => "required"
        ]);

        KelasModel::create([
            "institusi_id" => $request->institusi_id,
            "jenjang" => $request->jenjang,
            "nama_kelas" => $request->nama_kelas,
            "walas_id" => $request->walas_id
        ]);

        return back()->with("success", "Berhasil menambahkan kelas!");
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "institusi_id" => "required",
            "jenjang" => "required",
            "nama_kelas" => "required",
            "walas_id" => "required"
        ]);

        $kelas = KelasModel::find($id);
        $kelas->institusi_id = $request->institusi_id;
        $kelas->jenjang = $request->jenjang;
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->walas = $request->walas;
        $kelas->save();

        return back()->with('success', 'Berhasil penyesuaian kelas!');
    }

    public function destroy($id)
    {
        $kelas = KelasModel::find($id);
        $kelas->delete();

        return back()->with('success', 'Berhasil hapus kelas!');
    }
}
