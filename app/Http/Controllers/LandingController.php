<?php

namespace App\Http\Controllers;

use App\Models\LapanganModel;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $lapangan = LapanganModel::with('foto')->get();
        return view('index', compact('lapangan'));
    }
}
