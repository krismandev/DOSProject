<?php

namespace App\Http\Controllers;

use App\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function getAgency()
    {
        $agencies = Agency::all();
        return view('dashboard.agency',compact(['agencies']));
    }

    public function storeAgency(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);

        Agency::create([
            "name" => $request->name
        ]);
        return redirect()->back()->with("success","Berhasil menambah data");
    }
}
