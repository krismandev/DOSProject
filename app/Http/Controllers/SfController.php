<?php

namespace App\Http\Controllers;

use App\SalesForce;
use App\Spv;
use App\User;
use Illuminate\Http\Request;

class SfController extends Controller
{
    public function getSf()
    {
        $sfs = User::where("role","sf")->orderBy("name")->get();
        $spvs = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.name")->orderBy("name","asc")->get();
        return view('dashboard.sf',compact(["sfs","spvs"]));
    }

    public function storeSf(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "kode"=>"required|unique:users,kode",
            "spv_id"=>"required",
            "hp"=>"required",
            "ktp"=>"required"
        ]);

        $user = User::create([
            "name"=> $request->name,
            "kode"=>$request->kode,
            "password"=>bcrypt($request->hp),
            "role"=>"sf"
        ]);

        $sf = SalesForce::create([
            "user_id"=>$user->id,
            "hp" => $request->hp,
            "ktp" => $request->ktp,
            "agency" => $request->agency,
            "spv_id" => $request->spv_id,
            "status"=>"active",
        ]);

        return back()->with("success","Berhasil menambah data sales force");
    }
}
