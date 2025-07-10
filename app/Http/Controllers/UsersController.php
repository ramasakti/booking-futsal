<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleModel;
use App\Models\User;
use App\Models\UserRoleModel;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = RoleModel::all();
        return view('user.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        UserRoleModel::create([
            'user_id' => $user,
            'role_id' => $request->role_id
        ]);

        return back()->with('success', 'Berhasil membuat user!');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'role_id' => 'required'
        ]);

        // Update user
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();

        // Hapus semua role
        UserRoleModel::where('user_id', $id)->delete();

        // Masukkan ulang role
        UserRoleModel::create([
            'user_id' => $id,
            'role_id' => $request->role_id
        ]);

        return back()->with('success', 'Berhasil update user!');
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
