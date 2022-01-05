<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PicController extends Controller
{
    public function getPic()
    {
        $pics = User::where("role","pic")->orderBy("name")->get();
        return view('dashboard.pic',compact(["pics"]));

    }

    public function storePic(Request $request)
    {
        $request->validate([
            "name" => "required",
            "kode" => "required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "kode"=> $request->kode,
            "role"=>"pic",
            "password" => bcrypt("12345678")
        ]);

        return redirect()->back()->with("success","Berhasil menambah akun PIC");
    }

    public function updatePic(Request $request)
    {
        $request->validate([
            "name" => "required",
            "kode" => "required"
        ]);

        $pic = User::find($request->user_id);
        $pic->update([
            "name" => $request->name,
            "kode" => $request->kode
        ]);

        return redirect()->back()->with("success","Berhasil update data");
    }
}
