<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\KelasModel;
use App\Models\UserRoleModel;

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
        $request->validate(
            [
                'nama' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
                'password.required' => 'Password wajib diisi.'
            ]
        );

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        UserRoleModel::create([
            'user_id' => $user->id,
            'role_id' => 3,
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
