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
        $dos = Dos::all();
        foreach ($dos as $item) {
            $item->kkontak = $item->user->kode;
        }
        $dos_json = $dos->toJson();
        $odp = Odp::where("lat","!=",null)->where("lat","!=",null)->where("lat","!=","#NAME?")->where("long","!=","#NAME?")->get();
        foreach ($odp as $item) {
            // $item->lat = substr_replace($item->lat, "", -1);
            // $item->long = substr_replace($item->long, "", -1);
            // dd($item->lat);

            // $lat_awal = $item->lat;
            // $lat_target = '&deg';
            // $lat_ganti = [''];
            // $item->lat = Str::replaceArray($lat_target,$lat_ganti,$lat_awal);

            // $new_lat = str_replace(chr(248),"",$item->lat);
            // dd($new_lat);

            $item->lat = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $item->lat);
            $item->long = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $item->long);
            // $arr_lat = str_split($item->lat,1);
            // dd($arr_lat);
        }
        // dd($odp);
        return view("dashboard.maps",compact(["dos","odp","dos_json"]));
    }
}
