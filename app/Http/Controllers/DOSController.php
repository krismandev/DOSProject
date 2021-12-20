<?php

namespace App\Http\Controllers;

use App\Dos;
use App\Exports\DosExport;
use App\SalesForce;
use App\Spv;

use App\User;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DOSController extends Controller
{
    public function reportDOS()
    {
        $spv_ids = Spv::where("pic_id",auth()->user()->id)->pluck("id");
        // dd($spv_ids);
        $user_sf_ids = SalesForce::whereIn("spv_id",$spv_ids)->pluck("user_id");
        // dd($user_sf_ids);
        $data = Dos::whereIn("user_id",$user_sf_ids)->orderBy("created_at","desc")->where("status","pending");
        $jumlah = $data->count();
        $dos = $data->get();
        return view("dashboard.dos.reportDos",compact(["dos","jumlah"]));
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

    public function getRekapDos()
    {
        $spvs = User::where("role","spv")->orderBy("name")->get();
        return view("dashboard.dos.rekapDos",compact(["spvs"]));
    }

    public function getRekapDosBySpv($id)
    {
        $user_spv = User::find($id);
        $spv = $user_spv->spv;
        // dd($spv);
        $awal = date("Y-m-d",strtotime("-7 days"));
        $akhir = date("Y-m-d");
        $user_sf_ids = SalesForce::where("spv_id",$spv->id)->pluck("user_id");
        $dos = Dos::whereIn("user_id",$user_sf_ids)->orderBy("created_at","desc")->get();
        return view("dashboard.dos.rekapDosBySpv",compact(["user_spv","dos","spv","awal","akhir"]));
    }

    public function dataRekapDosBySpv($id,$awal,$akhir)
    {
        $user_spv = User::find($id);
        $spv = $user_spv->spv;
        // dd($spv);
        $user_sf_ids = SalesForce::where("spv_id",$spv->id)->pluck("user_id");
        $dos = Dos::whereIn("user_id",$user_sf_ids)->whereDate('created_at','>=',$awal)->whereDate('created_at','<=',$akhir)->with("user")->orderBy("created_at","desc");
        $data = DataTables::of($dos)->toJson();
        // dd($data);
        return $data;
    }

    public function exportDataDos($id,$awal,$akhir)
    {
        $user_spv = User::find($id);
        $file_name = "DOS_SPV_".$user_spv->name."_".$awal."_".$akhir.".xlsx";
        return Excel::download(new DosExport($id,$awal,$akhir),$file_name);
    }

}
