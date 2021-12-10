<?php

namespace App\Http\Controllers;

use App\Spv;
use App\User;
use Illuminate\Http\Request;

class SpvController extends Controller
{
    public function getSpv()
    {
        $spvs = User::where("role","spv")->orderBy("name","asc")->get();
        return view("dashboard.spv",compact(['spvs']));
    }

    public function storeSpv(Request $request)
    {
        $request->validate([
            "name" => "required",
            "kode" => "required",
            "agency"=>"required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "kode" => $request->kode,
            "password" => "12345678",
            "role" => "spv"
        ]);

        $spv = Spv::create([
            "user_id"=>$user->id,
            "agency" => $request->agency
        ]);

        return redirect()->back()->with("success","Berhasil menambah data");


    }
}
