<?php

namespace App\Http\Controllers;

use App\Dos;
use App\Odp;
use Str;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function getMaps()
    {
        $dos = Dos::where("status","approved")->get();
        foreach ($dos as $item) {
            $item->kkontak = $item->user->kode;
            $item->spv_id = $item->user->sales_force->spv->id;
            $item->spv = $item->user->sales_force->spv;
            $item->spv_name = $item->user->sales_force->spv->user->name;
        }
        $dos_json = $dos->toJson();
        $odp = Odp::where("lat","!=",null)->where("lat","!=",null)->where("lat","!=","#NAME?")->where("long","!=","#NAME?")->where("lat","!=","")->where("long","!=","")->get();

        foreach ($odp as $item) {
            $tanggal_go_live = strtotime($item->tanggal_go_live);
            $tanggal_sekarang = strtotime(date("Y-m-d"));

            $dateDiff = $tanggal_sekarang - $tanggal_go_live;

            $bulan = ceil($dateDiff/(60*60*24*30));
            $item->umur_dalam_bulan = $bulan;
            // dd($bulan);
            if ($bulan <= 3) {
                $item->keterangan_umur = "Kurang dari 3 bulan";
            }elseif ($bulan >= 4 && $bulan <= 6) {
                $item->keterangan_umur = "4 sampai 6 bulan";
            }else{
                $item->keterangan_umur = "Lebih dari 1 tahun";
            }
        }
        $odp_json = $odp->toJson();
        return view("dashboard.maps",compact(["dos","odp","dos_json","odp_json"]));
    }
}
