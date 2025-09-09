<?php

namespace App\Http\Controllers;

use App\Models\BookingsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('roles')->pluck('role')->pluck('role')->contains('Pelanggan')) {
            $bookings = BookingsModel::where('user_id', Auth::user()->id)->get();
        } else {
            $bookings = BookingsModel::all();
        }

        return view('dashboard', [
            "title" => "Dashboard",
            "bookings" => $bookings
        ]);
    }
}
