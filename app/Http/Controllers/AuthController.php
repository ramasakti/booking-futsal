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
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginField = $credentials['email'];
        $password = $credentials['password'];

        // Cari user berdasarkan email atau username
        $user = User::where('email', $loginField)
            ->orWhere('username', $loginField)
            ->first();

        if ($user && Auth::attempt([
            filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => $loginField,
            'password' => $password,
        ])) {
            // Ambil user beserta role-nya
            $user = User::with('userRole.role')->where('id', Auth::user()->id)->first();
            $request->session()->put('roles', $user->userRole);

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('failed', 'Gagal! Username atau password salah!');
    }

    public function register()
    {
        return view('register');
    }

    public function registering(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar akun! Silahkan login.');
    }

    public function login()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
