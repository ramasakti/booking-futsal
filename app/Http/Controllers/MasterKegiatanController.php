<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use Illuminate\Http\Request;

class MasterKegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = MasterKegiatanModel::all();

        return view("master_kegiatan.index", [
            "title" => "Master Kegiatan",
            "kegiatans" => $kegiatans
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "kegiatan" => "required",
            "deskripsi" => "required"
        ]);

        MasterKegiatanModel::create([
            "kegiatan" => $request->kegiatan,
            "deskripsi" => $request->deskripsi
        ]);

        return back()->with("success", "Berhasil menambahkan kegiatan!");
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "kegiatan" => "required",
            "deskripsi" => "required"
        ]);

        MasterKegiatanModel::where("id", $id)->update([
            "kegiatan" => $request->kegiatan,
            "deskripsi" => $request->deskripsi
        ]);

        return back()->with("success", "Berhasil mengubah kegiatan!");
    }

    public function destroy($id)
    {
        MasterKegiatanModel::where("id", $id)->delete();

        return back()->with("success", "Berhasil hapus kegiatan!");
    }
}
