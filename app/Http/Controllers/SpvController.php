<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Spv;
use App\User;
use Illuminate\Http\Request;

class SpvController extends Controller
{
    public function getSpv()
    {
        $spvs = User::where("role","spv")->orderBy("name","asc")->get();
        $agencies = Agency::all();
        return view("dashboard.spv",compact(['spvs','agencies']));
    }

    public function storeSpv(Request $request)
    {
        $request->validate([
            "name" => "required",
            "kode" => "required",
            "agency_id"=>"required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "kode" => $request->kode,
            "password" => "12345678",
            "role" => "spv"
        ]);

        $spv = Spv::create([
            "user_id"=>$user->id,
            "agency_id" => $request->agency_id
        ]);

        return redirect()->back()->with("success","Berhasil menambah data");


    }
}
