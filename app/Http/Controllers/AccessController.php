<?php

namespace App\Http\Controllers;

use App\Models\AccessRole;
use App\Models\MenuModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function accessRoleIndex()
    {
        $roles = RoleModel::all();

        return view("access.index", [
            "title" => "Akses Role",
            "roles" => $roles
        ]);
    }

    public function accessRole($id_role)
    {
        // semua menu yang ada di sistem
        $menus = MenuModel::with('children')->whereNull('parent_id')->orderBy('order')->get();

        // id-id menu yang sudah dimiliki role (akan kita pakai untuk 'checked')
        $checkedMenuIds = AccessRole::where('role_id', $id_role)->pluck('menu_id')->toArray();

        return view('access.role', [
            'title' => 'Akses Role',
            'menus' => $menus,
            'checkedMenuIds' => $checkedMenuIds,
        ]);
    }

    public function giveAndDropAccessRole(Request $request)
    {
        $request->validate([
            "role_id" => "required",
            "menu_id" => "required",
            "action" => "required"
        ]);

        if ($request->action === "give") {
            $access = AccessRole::create([
                "role_id" => $request->role_id,
                "menu_id" => $request->menu_id
            ]);
        } else {
            AccessRole::where("role_id", $request->role_id)->where("menu_id", $request->menu_id)->delete();
        }

        return response()->json([
            "message" => "Berhasil {$request->action} akses role!",
            "payload" => $access ?? null
        ], 201);
    }
}
