<?php

namespace App\Http\Controllers;

use App\Dos;
use Illuminate\Http\Request;

class DOSController extends Controller
{
    public function reportDOS()
    {
        $dos = Dos::orderBy("created_at","desc")->get();
        return view("dashboard.dos.reportDos",compact(["dos"]));
    }
}
