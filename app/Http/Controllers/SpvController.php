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
        $pics = User::where("role","pic")->orderBy("name","asc")->get();
        $agencies = Agency::all();
        // dd($agencies);
        return view("dashboard.spv",compact(['spvs','agencies','pics']));
    }

    public function storeSpv(Request $request)
    {
        $request->validate([
            "name" => "required",
            "kode" => "required|unique:users,kode",
            "agency_id"=>"required"
        ]);

        // dd($request->agency_id);
        $user = User::create([
            "name" => $request->name,
            "kode" => $request->kode,
            "password" => "12345678",
            "role" => "spv"
        ]);

        $spv = Spv::create([
            "user_id"=>$user->id,
            "agency_id" => $request->agency_id,
            "pic_id" => $request->pic_id,
        ]);

        return redirect()->back()->with("success","Berhasil menambah data");


    }
}
