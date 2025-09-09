<?php

namespace App\Http\Controllers;

use App\Models\BookingsModel;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($id)
    {
        $booking = BookingsModel::find($id);

        if (!$booking) {
            return abort(404);
        }

        return view('invoice.index', compact('booking'));
    }
}
