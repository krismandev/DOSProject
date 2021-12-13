<?php

namespace App\Http\Controllers;

use App\Dos;
use Illuminate\Http\Request;

class DOSController extends Controller
{
    public function reportDOS()
    {
        $dos = Dos::orderBy("created_at","desc")->where("status","pending")->get();
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
