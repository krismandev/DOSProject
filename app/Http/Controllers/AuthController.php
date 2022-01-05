<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            "kode" => "required",
            "password"=>"required",
        ]);
        $creds = $request->only(['kode','password']);

        if (auth()->attempt($creds)) {
            if (auth()->user()->role != "sf") {
                return redirect()->route("home");
            }else{
                return redirect()->back()->with("error","Password atau username salah");
            }
        }else{
            return redirect()->back()->with("error","Password atau username salah");
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route("login");
    }
}
