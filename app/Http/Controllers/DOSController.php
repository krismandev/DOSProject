<?php

namespace App\Http\Controllers;

use App\Dos;
use App\SalesForce;
use App\Spv;
use Illuminate\Http\Request;

class DOSController extends Controller
{
    public function reportDOS()
    {
        $spv_ids = Spv::where("pic_id",auth()->user()->id)->pluck("id");
        // dd($spv_ids);
        $user_sf_ids = SalesForce::whereIn("spv_id",$spv_ids)->pluck("user_id");
        // dd($user_sf_ids);
        $dos = Dos::whereIn("user_id",$user_sf_ids)->orderBy("created_at","desc")->where("status","pending")->get();
        return view("dashboard.dos.reportDos",compact(["dos"]));
    }

    public function approveDOS($id){
        $dos = Dos::find($id);
        $dos->update([
            "status"=>"approved"
        ]);
        return response()->json([
            "message"=>"success"
        ]);
    }

    public function declineDOS($id){
        $dos = Dos::find($id);
        $dos->update([
            "status"=>"declined"
        ]);
        return response()->json([
            "message"=>"success"
        ]);
    }
}
