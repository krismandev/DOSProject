<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Spv;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            "agency_id"=>"required",
            "pic_id"=>"required",
            "hp" => "required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "kode" => $request->kode,
            "password" => bcrypt($request->hp),
            "role" => "spv"
        ]);

        $spv = Spv::create([
            "user_id"=>$user->id,
            "agency_id" => $request->agency_id,
            "pic_id" => $request->pic_id,
            "hp"=> $request->hp,
        ]);

        return redirect()->back()->with("success","Berhasil menambah data");
    }

    public function updateSpv(Request $request)
    {
        $request->validate([
            "name" => "required",
            "user_id" => "required",
            "kode" => "required",
            "agency_id"=>"required",
            "pic_id"=>"required",
            "hp" => "required"
        ]);

        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);
            $spv = $user->spv;
            $user->update([
                "name"=>$request->name,
                "kode"=>$request->kode
            ]);

            $spv->update([
                "agency_id" => $request->agency_id,
                "pic_id" => $request->pic_id,
                "hp"=>$request->hp
            ]);
            DB::commit();
            return redirect()->back()->with("success","Berhasil memperbarui data");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error",$e->getMessage());
        }
    }
}
