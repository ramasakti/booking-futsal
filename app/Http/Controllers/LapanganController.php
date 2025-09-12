<?php

namespace App\Http\Controllers;

use App\Models\FotoLapanganModel;
use App\Models\LapanganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = LapanganModel::with('foto')->get();
        return view('lapangan.index', [
            "title" => "Lapangan",
            "lapangan" => $lapangan
        ]);
    }

    public function create()
    {
        return view('lapangan.create', [
            "title" => "Tambah Lapangan Baru"
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'harga' => 'required',
        ]);

        // Parsing nilai harga
        $harga = (int) preg_replace('/[^0-9]/', '', $request->harga);

        // Variabel untuk menampung file yang diupload
        $fotoPaths = [];

        // Simpan file yang diupload ke file
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto_lapangan'), $filename);
                $fotoPaths[] = 'foto_lapangan/' . $filename;
            }
        }

        // Simpan data lapangan ke db
        $lapangan = LapanganModel::create([
            'nama_lapangan' => $request->nama_lapangan,
            'harga' => $harga,
            'deskripsi' => $request->deskripsi ?? ''
        ]);

        // Simpan foto ke database
        foreach ($fotoPaths as $path) {
            FotoLapanganModel::create([
                'lapangan_id' => $lapangan->id,
                'foto' => $path,
            ]);
        }

        return redirect('/lapangan')->with('success', 'Berhasil menambah lapangan baru');
    }

    public function edit($id)
    {
        $lapangan = LapanganModel::find($id);
        return view('lapangan.edit', [
            "title" => "Edit Lapangan",
            "lapangan" => $lapangan
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'harga' => 'required',
        ]);

        // Parsing nilai harga
        $harga = (int) preg_replace('/[^0-9]/', '', $request->harga);

        // Ambil data lapangan
        $lapangan = LapanganModel::with('foto')->where('id', $id)->first();

        // Jika ada file yang dihapus, maka hapus file dan database file
        if ($request->hapus_foto) {
            foreach ($request->hapus_foto as $hapus_foto) {
                $foto = FotoLapanganModel::find($hapus_foto);
                $path = public_path($foto->foto);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $foto->delete();
            }
        }

        // Jika ada foto baru, maka simpan filenya dan simpan ke db
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto_lapangan'), $filename);
                $fotoPaths = 'foto_lapangan/' . $filename;

                FotoLapanganModel::create([
                    'lapangan_id' => $lapangan->id,
                    'foto' => $fotoPaths,
                ]);
            }
        }

        // Simpan perubahan data lapangan
        $lapangan->nama_lapangan = $request->nama_lapangan;
        $lapangan->harga = $harga;
        $lapangan->save();

        return redirect('/lapangan')->with('success', 'Berhasil update lapangan');
    }

    public function destroy($id)
    {
        // Ambil data lapangan
        $lapangan = LapanganModel::find($id);

        // Cek apakah data masih ada untuk memastikan race condition
        if (!$lapangan) {
            return back()->with('failed', 'Gagal menghapus lapangan! Data tidak ditemukan');
        }

        // Ambil data foto
        $foto = FotoLapanganModel::where('lapangan_id', $id)->get();

        // Hapus pada file dan db
        foreach ($foto as $foto) {
            if (File::exists($foto->foto)) {
                File::delete($foto->foto);
            }
            $foto->delete();
        }

        // Hapus data lapangan
        $lapangan->delete();

        return back()->with('success', 'Berhasil hapus lapangan');
    }
}
