<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\KelasModel;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::with(['userRole.role', 'userInstitusi.institusi'])->where('id', Auth::user()->id)->first();
            $request->session()->put('roles', $user->userRole);
            $request->session()->put('institusies', $user->userInstitusi);

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('failed', 'Gagal! Username atau password salah!');
    }

    public function login()
    {
        return view('welcome');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
