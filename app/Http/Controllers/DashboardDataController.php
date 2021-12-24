<?php

namespace App\Http\Controllers;

use App\Dos;
use App\SalesForce;
use App\Spv;
use Illuminate\Http\Request;

class DashboardDataController extends Controller
{
    public function dashDosPerSpv()
    {
        $awal = date("Y-m-d",strtotime("-1 days"));
        $akhir = date("Y-m-d");
        $spv = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->orderBy("name","asc")->get();
        return view("dashboard.data_dashboard.dos_perspv",compact(["spv","awal","akhir"]));
    }

    public function dashDosPerSpvFiltered(Request $request)
    {
        $awal = date("Y-m-d",strtotime($request->awal));
        $akhir = date("Y-m-d",strtotime($request->akhir));
        $spv = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->orderBy("name","asc")->get();
        return view("dashboard.data_dashboard.dos_perspv",compact(["spv","awal","akhir"]));
    }

    public function dashDosPerSales()
    {
        $awal = date("Y-m-d",strtotime("-1 days"));
        $akhir = date("Y-m-d");

        $spv = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->orderBy("name","asc")->get();
        $spv_selected = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->first();

        $sales_forces = SalesForce::where("spv_id",$spv_selected->id)->join("users","sales_forces.user_id","=","users.id")
            ->select("sales_forces.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")
            ->get();
        return view('dashboard.data_dashboard.dos_persales',compact(["awal","akhir","spv","spv_selected","sales_forces"]));
    }

    public function dashDosPerSalesFiltered(Request $request)
    {
        $awal = date("Y-m-d",strtotime($request->awal));
        $akhir = date("Y-m-d",strtotime($request->akhir));

        $spv = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->orderBy("name","asc")->get();
        $spv_selected = Spv::where("spvs.id",$request->spv_id)->join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->first();

        $sales_forces = SalesForce::where("spv_id",$spv_selected->id)->join("users","sales_forces.user_id","=","users.id")
            ->select("sales_forces.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")
            ->get();
        return view('dashboard.data_dashboard.dos_persales',compact(["awal","akhir","spv","spv_selected","sales_forces"]));
    }

    public function dashEvaluasiDosSf()
    {
        $awal = date("Y-m-d",strtotime("-90 days"));
        $akhir = date("Y-m-d");

        $waktu_kunjungans = Dos::distinct()->get("waktu");
        $keterangan_kunjungans = Dos::distinct()->get("keterangan_kunjungan");
        $spv = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.id as id_user","users.name as name","users.kode as kode","users.role as role")->orderBy("name","asc")->get();
        return view("dashboard.data_dashboard.evaluasi_sf",compact(["awal","akhir","waktu_kunjungans","spv","keterangan_kunjungans"]));
    }
}
