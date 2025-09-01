<?php

namespace App\Http\Controllers;

use App\Models\InstitusiModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInstitusiModel;

class UserInstitusiController extends Controller
{
    public function userInstitusiIndex()
    {
        $users = User::with(["userInstitusi.institusi"])->get();

        return view("user_institusi.index", [
            "title" => "User Institusi",
            "users" => $users
        ]);
    }

    public function userInstitusi($id_user)
    {
        $user = User::find($id_user);
        $institusies = InstitusiModel::all();
        $userInstitusies = UserInstitusiModel::with("institusi")->where("user_id", $id_user)->pluck('institusi_id');

        return view("user_institusi.user", [
            "title" => "Institusi User {$user->username}",
            "institusies" => $institusies,
            "userInstitusies" => $userInstitusies
        ]);
    }

    public function giveAndDropUserInstitusi(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "institusi_id" => "required",
            "action" => "required"
        ]);

        if ($request->action === "give") {
            $role = UserInstitusiModel::create([
                "user_id" => $request->user_id,
                "institusi_id" => $request->institusi_id
            ]);
        } else {
            UserInstitusiModel::where("user_id", $request->user_id)->where("institusi_id", $request->institusi_id)->delete();
        }

        return response()->json([
            "message" => "Berhasil {$request->action} user institusi!",
            "payload" => $role ?? null
        ], 201);
    }
}
