<?php

namespace App\Http\Controllers;

use App\Models\TurnamenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TurnamenController extends Controller
{
    public function index()
    {
        $turnamen = TurnamenModel::all();
        return view('turnamen.index', [
            "title" => "Turnamen",
            "turnamen" => $turnamen
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_turnamen' => 'required',
            'banner' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'biaya' => 'required',
        ]);

        

        return back()->with('success', 'Berhasil tambah turnamen');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama_turnamen' => 'required',
            'banner' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'biaya' => 'required',
        ]);

        return back()->with('success', 'Berhasil edit turnamen');
    }

    public function destroy($id)
    {
        $turnamen = TurnamenModel::find($id);

        if (!$turnamen) {
            return back()->with('failed', 'Gagal! Turnamen tidak ditemukan');
        }

        $path = public_path($turnamen->banner);
        if (File::exists($path)) {
            File::delete($path);
        }

        $turnamen->delete();

        return back()->with('success', 'Berhasil delete turnamen');
    }
}
