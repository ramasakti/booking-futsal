<?php

namespace App\Http\Controllers;

use App\Models\LapanganModel;
use App\Models\TurnamenModel;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $lapangan = LapanganModel::with('foto')->get();
        $turnamens = TurnamenModel::all();
        return view('index', compact('lapangan', 'turnamens'));
    }
}
