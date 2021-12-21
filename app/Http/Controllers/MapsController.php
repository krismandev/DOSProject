<?php

namespace App\Http\Controllers;

use App\Dos;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function getMaps()
    {
        $dos = Dos::all();
        return view("dashboard.maps",compact(["dos"]));
    }
}
