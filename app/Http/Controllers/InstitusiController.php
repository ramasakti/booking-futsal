<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstitusiModel;

class InstitusiController extends Controller
{
    public function index()
    {
        $institusi = InstitusiModel::all();

        return view('institusi.index', [
            "title" => "Institusi",
            "institusi" => $institusi
        ]);
    }

    public function detail($id)
    {
        $institusi = InstitusiModel::find($id);

        return response()->json($institusi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'institusi' => 'required'
        ]);

        InstitusiModel::create([
            'institusi' => $request->institusi
        ]);

        return back()->with('success', 'Berhasil menambahkan institusi');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'institusi' => 'required'
        ]);

        $institusi = InstitusiModel::find($id);
        $institusi->institusi = $request->institusi;
        $institusi->save();

        return back()->with('success', 'Berhasil edit institusi');
    }

    public function destroy($id)
    {
        $institusi = InstitusiModel::find($id);
        $institusi->delete();

        return back()->with('success', 'Berhasil hapus institusi');
    }
}
