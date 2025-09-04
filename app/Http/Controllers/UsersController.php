<?php

namespace App\Http\Controllers;

use App\Models\InstitusiModel;
use Illuminate\Http\Request;
use App\Models\RoleModel;
use App\Models\User;
use App\Models\UserInstitusiModel;
use App\Models\UserRoleModel;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $title = "Users";
        $users = User::with('userRole.role')->get();
        $roles = RoleModel::all();

        return view('user.index', compact('title', 'users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'role_id' => 'required',
            'institusi_id' => 'required'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Membuat user baru
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                ]);

                // Menghubungkan user dengan role
                UserRoleModel::create([
                    'user_id' => $user->id,
                    'role_id' => $request->role_id
                ]);
            });

            return back()->with('success', 'Berhasil membuat user!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal membuat user. ' . $th->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
            'role_id' => 'required',
            'institusi_id' => 'required'
        ]);

        try {
            DB::transaction(function () use ($user, $request) {
                // Update user
                $user->name = $request->name;
                $user->email = $request->email;
                $user->username = $request->username;
                $user->save();

                // Hapus dan masukkan kembali role
                $user->roles()->delete();
                $user->roles()->create(['role_id' => $request->role_id]);

                // Hapus dan masukkan kembali institusi
                $user->institusi()->delete();
                $user->institusi()->create(['institusi_id' => $request->institusi_id]);
            });

            return back()->with('success', 'Berhasil update user!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal mengupdate user: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return back()->with('success', 'Berhasil hapus user!');
    }

    public function detail($id)
    {
        $user = User::find($id);

        return response()->json([
            "message" => "Data Detail User {$user->username}",
            "payload" => $user
        ], 200);
    }
}
