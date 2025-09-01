<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OCRController extends Controller
{
    public function index()
    {
        return view('ocr.index', [
            'title' => "OCR"
        ]);
    }

    public function process(Request $request)
    {
        return response()->json([
            'payload' => $request->text
        ], 200);
    }
}
