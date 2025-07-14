<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = RoleModel::all();

        return view("role.index", [
            "title" => "Role",
            "roles" => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "role" => "required"
        ]);

        RoleModel::create([
            "role" => $request->role
        ]);

        return back()->with("success", "Berhasil menambahkan role!");
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "role" => "required"
        ]);

        RoleModel::where("id", $id)->update(["role" => $request->role]);

        return back()->with("success", "Berhasil mengubah role!");
    }

    public function destroy($id)
    {
        RoleModel::where("id", $id)->delete();

        return back()->with("success", "Berhasil hapus role!");
    }
}
