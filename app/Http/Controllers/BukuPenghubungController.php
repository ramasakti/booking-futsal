<?php

namespace App\Http\Controllers;

use App\Models\{
    BukuPenghubungModel,
    KelasModel
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BukuPenghubungController extends Controller
{
    public function catatan(Request $request)
    {
        $roles = Auth::user()->role_names;
        $catatan = collect([]);
        $kelas = KelasModel::all();

        if ($roles->contains("Kepala Sekolah")) {
            if ($request->kelas && $request->tanggal) {
                $catatan = BukuPenghubungModel::where('kelas_id', $request->kelas)
                    ->where('tanggal', $request->tanggal)
                    ->get();
            }
        } else if ($roles->contains("Admin")) {
            if ($request->kelas && $request->tanggal) {
                $catatan = BukuPenghubungModel::where('kelas_id', $request->kelas)
                    ->where('tanggal', $request->tanggal)
                    ->get();
            }
        } else if ($roles->contains("Walas")) {
            $kelas = KelasModel::where('walas_id', Auth::user()->id)->first();
            $catatan = BukuPenghubungModel::where('kelas_id', $kelas->id)
                ->where('tanggal', $request->tanggal)
                ->get();
        }

        return view("catatan.index", [
            "title" => "Catatan Kelas",
            "catatan" => $catatan,
            "kelas" => $kelas
        ]);
    }

    public function catatanKelas($id_kelas)
    {
        return view();
    }

    public function create()
    {
        return view("catatan.create", [
            "title" => "",
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "id_siswa" => "required",
            "kelas_id" => "required",
            "tanggal" => "required",
            "catatan" => "required",
        ]);

        BukuPenghubungModel::create([
            "id_siswa" => $request->id_siswa,
            "kelas_id" => $request->kelas_id,
            "tanggal" => $request->tanggal,
            "catatan" => $request->catatan,
        ]);

        return back()->with('success', 'Berhasil membuat catatan');
    }

    public function edit($id)
    {
        $catatan = BukuPenghubungModel::find($id);

        return view("catatan.edit", [

        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "catatan" => "required"
        ]);

        BukuPenghubungModel::where('id', $id)->update(["catatan" => $request->catatan]);

        return back()->with('success', 'Berhasil update catatan');
    }

    public function destroy($id)
    {
        $catatan = BukuPenghubungModel::find($id);
        $catatan->delete();

        return back()->with('success', 'Berhasil hapus catatan');
    }
}
