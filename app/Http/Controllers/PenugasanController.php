<?php

namespace App\Http\Controllers;

use App\Odc;
use App\Penugasan;
use App\Spv;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    public function getPenugasan()
    {
        $penugasans = Penugasan::orderBy('tanggal_mulai',"desc")->get();
        $spvs = Spv::orderBy("id","asc")->get();
        $odcs = Odc::orderBy("nama_sto","asc")->get();
        return view("dashboard.sales_plan.penugasan",compact(["penugasans","spvs","odcs"]));
    }

    public function storePenugasan(Request $request)
    {
        $request->validate([
            "odc_id"=>"required",
            "spv_id"=> "required",
            "keterangan"=> "required",
            "odp"=> "required",
            "tanggal_mulai"=> "required",
            "tanggal_selesai"=> "required"
        ]);

        $penugasan = Penugasan::create([
            "odc_id"=>$request->odc_id,
            "spv_id"=> $request->spv_id,
            "keterangan"=> $request->keterangan,
            "odp"=> $request->odp,
            "tanggal_mulai"=> date('Y-m-d',strtotime($request->tanggal_mulai)),
            "tanggal_selesai"=>date('Y-m-d',strtotime($request->tanggal_selesai))
        ]);

        return redirect()->back()->with("success","Berhasil membuat penugasan");
    }
}
