<?php

namespace App\Http\Controllers;

use App\Spv;
use Illuminate\Http\Request;

class DashboardDataController extends Controller
{
    public function dashDosPerSpv()
    {
        $awal = date("Y-m-d",strtotime("-7 days"));
        $akhir = date("Y-m-d");
        $spv = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->orderBy("name","asc")->get();
        return view("dashboard.data_dashboard.dos_perspv",compact(["spv","awal","akhir"]));
    }
}
