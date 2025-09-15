<?php

namespace App\Http\Controllers;

use App\Models\BookingsModel;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($booking_id)
    {
        $booking = BookingsModel::with(['pemesan', 'lapangan'])
            ->where('payment_reference', $booking_id)
            ->first();

        if (!$booking) {
            return abort(404);
        }

        return view('invoice.index', compact('booking'));
    }
}
