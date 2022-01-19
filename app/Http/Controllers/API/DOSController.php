<?php

namespace App\Http\Controllers\API;

use App\Dos;
use App\Http\Controllers\Controller;
use App\SalesForce;
use App\Spv;
use App\User;
use App\Utilities\ResponseMessage;
use App\Utilities\ResponseUtility;
use CURLFile;
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


            $dataMessage = [
                "kegiatan"=>$dos->kegiatan,
                "waktu"=> $dos->waktu,
                "tanggal"=>$dos->tanggal,
                "longitude"=>$dos->long,
                "latitude"=>$dos->lat,
                "odp"=>$dos->odp,
                "produk"=>$dos->produk,
                "kkontak"=>$user->kode,
                "status_kunjungan"=>$dos->status_kunjungan,
                "keterangan_kunjungan"=>$dos->keterangan_kunjungan,
                "keterangan_tambahan"=>$dos->keterangan_tambahan,
                "path"=>realpath("public/storage/foto_dos/".$filenameSave)
            ];

            $this->sendToBot($dataMessage);


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

    public function sendToBot($data)
    {
        $BOT_TOKEN  = env("BOT_TOKEN");
        $CHAT_ID = env("GROUP_ID");

        $post_fields = array(
            'chat_id'   => $CHAT_ID,
            'photo'     => new CURLFile($data["path"]),
            'caption' => "Kegiatan: ".$data["kegiatan"]."\n".
                        "Waktu: ".$data["waktu"]. " \n ".
                        "Tanggal: ".$data["tanggal"]. " \n ".
                        "Longitue: ".$data["longitude"]. " \n ".
                        "Latitude: ".$data["latitude"]. " \n ".
                        "ODP: ".$data["odp"]. " \n ".
                        "Produk: ".$data["produk"]. " \n ".
                        "KKontak: ".$data["kkontak"]. " \n ".
                        "Status Kunjungan: ".$data["status_kunjungan"]. " \n ".
                        "Keterangan Kunjungan: ".$data["keterangan_kunjungan"]. " \n ".
                        "Keterangan Tambahan: ".$data["keterangan_tambahan"]. " \n ",
            "parse_mode"=>"HTML"
        );

        $API = "https://api.telegram.org/bot".$BOT_TOKEN."/sendPhoto?chat_id=".$CHAT_ID;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $API);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
