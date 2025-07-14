<?php

namespace App\Http\Controllers;

use App\Models\UserRoleModel;
use Illuminate\Http\Request;
use App\Models\User;

class UserRoleController extends Controller
{
    public function userRoleIndex()
    {
        $users = User::with(["userRole.role"])->get();

        return view("user_role.index", [
            "title" => "Akses Role",
            "users" => $users
        ]);
    }

    public function giveAndDropUserRole(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "role_id" => "required",
            "action" => "required"
        ]);

        if ($request->action === "give") {
            $role = UserRoleModel::create([
                "user_id" => $request->user_id,
                "role_id" => $request->role_id
            ]);
        } else {
            UserRoleModel::where("user_id", $request->user_id)->where("role_id", $request->role_id)->delete();
        }

        return response()->json([
            "message" => "Berhasil {$request->action} user role!",
            "payload" => $role ?? null
        ], 201);
    }
}
