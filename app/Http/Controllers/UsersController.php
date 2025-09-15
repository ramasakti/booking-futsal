<?php

namespace App\Http\Controllers;

use App\Models\InstitusiModel;
use Illuminate\Http\Request;
use App\Models\RoleModel;
use App\Models\User;
use App\Models\UserInstitusiModel;
use App\Models\UserRoleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        ]);

        try {
            DB::transaction(function () use ($request) {
                $filename = '';
                if ($request->hasFile('avatar')) {
                    $file = $request->file('avatar');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('avatar'), $filename);
                }
                
                // Membuat user baru
                $user = User::create([
                    'name' => $request->name,
                    'avatar' => $filename,
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
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Gagal membuat user. ' . $th->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $user = User::with('userRole')->where('id', $id)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
            'role_id' => 'required',
        ]);

        try {
            DB::transaction(function () use ($user, $request) {
                // Update foto profil user
                if ($user->avatar && $request->hasFile('avatar')) {
                    $path = public_path('avatar/' . $user->avatar);
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('avatar');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('avatar'), $filename);
                    $user->avatar = $filename;
                }

                // Update user
                $user->name = $request->name;
                $user->email = $request->email;
                $user->username = $request->username;
                $user->save();

                // Hapus dan masukkan kembali role
                $user->userRole()->delete();
                $user->userRole()->create(['role_id' => $request->role_id]);
            });

            return back()->with('success', 'Berhasil update user!');
        } catch (\Exception $e) {
            dd($e);
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
