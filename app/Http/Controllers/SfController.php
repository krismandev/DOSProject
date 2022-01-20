<?php

namespace App\Http\Controllers;

use App\SalesForce;
use App\Spv;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SfController extends Controller
{
    public function getSf()
    {
        $sfs = User::where("role","sf")->orderBy("created_at","desc")->get();
        $spvs = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.name")->orderBy("name","asc")->get();
        return view('dashboard.sf',compact(["sfs","spvs"]));
    }

    public function storeSf(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "kode"=>"required|unique:users,kode",
            "spv_id"=>"required",
        ]);

        $user = User::create([
            "name"=> $request->name,
            "kode"=>$request->kode,
            "password"=>bcrypt($request->kode),
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

    public function updateSf(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "kode"=>"required",
            "spv_id"=>"required",
            "hp"=>"required",
            "ktp"=>"required"
        ]);

        $user = User::find($request->user_id);
        $sf = $user->sales_force;
        DB::beginTransaction();

        try {
            $user->update([
                "name" => $request->name,
                "kode" => $request->kode
            ]);

            $sf->update([
                "spv_id"=>$request->spv_id,
                "hp" => $request->hp,
                "ktp" => $request->ktp
            ]);
            DB::commit();
            return redirect()->back()->with("success","Berhasil memperbarui data");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error",$e->getMessage());
        }

    }
}
