<?php

namespace App\Http\Controllers\API;

use App\Dos;
use App\Http\Controllers\Controller;
use App\SalesForce;
use App\Spv;
use App\User;
use App\Utilities\ResponseMessage;
use App\Utilities\ResponseUtility;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DOSController extends Controller
{
    public function storeDos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kegiatan"=>"required|in:D2D,OC,OT",
            "waktu"=>"required|in:09.00 - 12.00, 12.00 - 16.00, 16.00 - 19.00",
            "produk"=>"required|in:INDIHOME,OBIT",
            "long"=>"required",
            "lat"=>"required",
            "odp"=>"required",
            "status_kunjungan"=>"required|in:BERTEMU, TIDAK BERTEMU",
            "keterangan_kunjungan"=>"required|in:SUDAH PAKAI KOMPETITOR,PIKIR2 KEMBALI,RUMAH KOSONG,TIDAK BERPENGHUNI,KEBERATAN DENGAN HARGA,DEAL,SUDAH BERLANGGANAN",
            "keterangan_tambahan"=>"nullable",
            "foto"=>"required|file|image",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        try {
            $user = Auth::user();

            if ($request->hasFile("foto")) {
                $filenameWithExt = $request->file("foto")->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file("foto")->getClientOriginalExtension();
                $filenameSave = $filename.'_'.time().'.'.$extension;
                $path = $request->file("foto")->storeAs("public/foto_dos",$filenameSave);
            }

            $dos = Dos::create([
                "user_id"=>$user->id,
                "foto"=>"public/foto_dos".$filenameSave,
                "kegiatan"=>$request->kegiatan,
                "tanggal" => date("Y-m-d"),
                "waktu"=> $request->waktu,
                "produk"=>$request->produk,
                "long"=>$request->long,
                "lat"=>$request->lat,
                "odp"=>$request->odp,
                "status_kunjungan"=>$request->status_kunjungan,
                "keterangan_kunjungan"=>$request->keterangan_kunjungan,
                "keterangan_tambahan"=>$request->keterangan_tambahan ?? null,
                "status"=>"pending"
            ]);

            $message = ResponseMessage::SUCCESS;
            return ResponseUtility::makeResponse($dos,$message,200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return ResponseUtility::makeResponse(null,$message,400);
        }

    }

    public function getTodayDos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "limit"=>"required"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }


        try {
            $user = Auth::user();
            $tanggal = date("Y-m-d");
            $dos = Dos::where("user_id",$user->id)->where("tanggal",$tanggal)->orderBy("created_at","desc")->paginate($request->limit);
            $total = $dos->total();
            $dos = $dos->getCollection();

            foreach ($dos as $item) {
                $item->user = User::find($item->user_id);
                $item->foto = env("APP_URL").Storage::url($item->foto);
                $item->user->sf_data = SalesForce::where("user_id",$item->user_id)->first();
                unset($item->user_id);
            }

            $message = ResponseMessage::SUCCESS;

            return ResponseUtility::makeResponse($dos,$message,200,true,$total,$request->limit,ceil($total/$request->limit));
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return ResponseUtility::makeResponse(null,$message,400);
        }

    }

    public function getDetailDos($id)
    {
        $dos = Dos::find($id);
        $dos->user;
        $dos->user->sales_force;
        $message = ResponseMessage::SUCCESS;
        return ResponseUtility::makeResponse($dos,$message,200);
    }
}
