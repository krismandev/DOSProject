<?php

namespace App\Http\Controllers;

use App\Kelurahan;
use App\SalesPlan;
use App\SalesPlanKelurahan;
use App\SalesPlanSpv;
use App\Spv;
use Illuminate\Http\Request;

class SalesPlanController extends Controller
{
    public function getSalesPlan()
    {
        $sales_plans = SalesPlan::orderBy('tanggal','desc')->get();
        foreach ($sales_plans as $item) {
            foreach ($item->sales_plan_kelurahan as $sls_pln_kelurahan) {
                $sls_pln_kelurahan->kelurahan;
            }
            foreach ($item->sales_plan_spv as $sls_pln_spv) {
                $sls_pln_spv->spv->user;
            }
        }
        return view('dashboard.sales_plan.sales_plan',compact(['sales_plans']));
    }

    public function createSalesPlan()
    {
        $spvs = Spv::join("users","spvs.user_id","=","users.id")->select("spvs.*","users.name")->orderBy("name","asc")->get();
        $kelurahans = Kelurahan::orderBy('gab','asc')->get();
        return view('dashboard.sales_plan.create_sales_plan',compact(['kelurahans','spvs']));
    }

    public function addKelurahan()
    {
        $kelurahans = Kelurahan::orderBy('gab','asc')->get();
        return response()->json([
            'data'=>$kelurahans
        ]);
    }

    public function storeSalesPlan(Request $request)
    {
        $request->validate([
            "deskripsi" => "required",
            "tanggal" => "required",
            "kelurahan_id" => "required",
            "spv_id" => "required",
        ]);

        // dd($request->all());
        $plan = SalesPlan::create([
            "deskripsi"=> $request->deskripsi,
            "tanggal"=> $request->tanggal
        ]);

        $kelurahan_ids = $request->kelurahan_id;
        // dd($kelurahan_ids);
        $spv_ids = $request->spv_id;
        foreach ($kelurahan_ids as $id) {
            if($id != null){
                $plan_kelurahan = SalesPlanKelurahan::create([
                    "sales_plan_id"=>$plan->id,
                    "kelurahan_id"=> $id
                ]);
            }

        }
        foreach ($spv_ids as $id) {
            $plan_spv = SalesPlanSpv::create([
                "sales_plan_id"=>$plan->id,
                "spv_id"=> $id
            ]);
        }

        return redirect()->route('getSalesPlan')->with("success","Berhasil menambah plan");
    }
}
