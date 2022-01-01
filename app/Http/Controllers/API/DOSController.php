<?php

namespace App\Http\Controllers\API;

use App\Dos;
use App\Http\Controllers\Controller;
use App\SalesForce;
use App\Spv;
use App\User;
use App\Utilities\ResponseMessage;
use App\Utilities\ResponseUtility;
use Image;


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
            "waktu"=>"required|in:09.00 - 12.00,12.00 - 16.00,16.00 - 19.00",
            "produk"=>"required|in:INDIHOME,ORBIT",
            "long"=>"required",
            "lat"=>"required",
            "odp"=>"required",
            // "status_kunjungan"=>"required|in:BERTEMU,TIDAK BERTEMU",
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

                $filenameTest = time().'.'.$extension;

                $destinationPath = public_path('/storage/foto_dos');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 755, false);
                }
                $image = $request->file('foto');
                $img = Image::make($image->path());
                $img->orientate()->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filenameSave);


                // $filepath = $request->file('foto')->storeAs(
                //     'public/foto_dos',
                //     $filenameSave,
                //     'local'
                // );
                // $path = $request->file("foto")->storeAs("public/foto_dos",$filenameSave);
            }

            if ($request->keterangan_kunjungan == "RUMAH KOSONG" || $request->keterangan_kunjungan == "TIDAK BERPENGHUNI") {
                $status_kunjungan = "TIDAK BERTEMU";
            }else{
                $status_kunjungan = "BERTEMU";
            }

            $id_dos = date("Ymd")."-".Dos::max("id")."-".$user->kode;
            $dos = Dos::create([
                "user_id"=>$user->id,
                "foto"=>"foto_dos/".$filenameSave,
                "kegiatan"=>$request->kegiatan,
                "tanggal" => date("Y-m-d"),
                "waktu"=> $request->waktu,
                "produk"=>$request->produk,
                "long"=>$request->long,
                "lat"=>$request->lat,
                "odp"=>$request->odp,
                "status_kunjungan"=>$status_kunjungan,
                "keterangan_kunjungan"=>$request->keterangan_kunjungan,
                "keterangan_tambahan"=>$request->keterangan_tambahan ?? null,
                "status"=>"pending",
                "id_dos"=>$id_dos
            ]);

            $message = ResponseMessage::SUCCESS;
            return ResponseUtility::makeResponse($dos,$message,200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return ResponseUtility::makeResponse(null,$message,400);
        }

    }

    public function getTodayDos()
    {

        try {
            $user = Auth::user();
            $tanggal = date("Y-m-d");
            $dos = Dos::where("user_id",$user->id)->orderBy("created_at","desc")->paginate(8);
            $total = $dos->total();
            $dos = $dos->getCollection();

            foreach ($dos as $item) {
                $item->kkontak = $item->user->kode;
                $item->user = User::find($item->user_id);
                $item->foto = asset("storage/".$item->foto);
                $item->user->sf_data = SalesForce::where("user_id",$item->user_id)->first();

                unset($item->user_id);
            }
            $message = ResponseMessage::SUCCESS;
            return ResponseUtility::makeResponse($dos,$message,200,true,$total,8,ceil($total/8));
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
        $dos->kkontak = $dos->user->kode;
        $message = ResponseMessage::SUCCESS;
        return ResponseUtility::makeResponse($dos,$message,200);
    }
}
