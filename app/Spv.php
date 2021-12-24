<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spv extends Model
{
    protected $fillable = ["user_id","agency_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales_force()
    {
        return $this->hasMany(SalesForce::class,"spv_id","id");
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function jumlahSf()
    {
        $total = SalesForce::where("spv_id",$this->id)->count();
        return $total;
    }

    public function target($tanggal_awal, $tanggal_akhir)
    {
        $jumlah_sf = $this->jumlahSf();


        $target = Setting::where("name","target_dos")->first();
        $target = intval($target->value);

        $awal = strtotime($tanggal_awal);
        $akhir = strtotime($tanggal_akhir);

        $dateDiff = $akhir - $awal;

        $jumlah_hari = round($dateDiff / (60*60*24));

        $jumlah_target = $target * $jumlah_sf * $jumlah_hari;
        return $jumlah_target;
    }

    public function jumlahBertemu($awal,$akhir)
    {
        $user_sf_ids = SalesForce::where("spv_id",$this->id)->pluck("user_id");
        $jumlah_bertemu = Dos::whereIn("user_id",$user_sf_ids)->where("status_kunjungan","BERTEMU")->where("status","approved")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $jumlah_bertemu;
    }

    public function jumlahTidakBertemu($awal,$akhir)
    {
        $user_sf_ids = SalesForce::where("spv_id",$this->id)->pluck("user_id");
        $jumlah_bertemu = Dos::whereIn("user_id",$user_sf_ids)->where("status_kunjungan","TIDAK BERTEMU")->where("status","approved")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $jumlah_bertemu;
    }

    public function jumlahKunjungan($awal,$akhir)
    {
        $user_sf_ids = SalesForce::where("spv_id",$this->id)->pluck("user_id");
        // dd($user_sf_ids);
        $jumlah_kunjungan = Dos::whereIn("user_id",$user_sf_ids)->where("status","approved")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $jumlah_kunjungan;
    }

    public function persentase($awal,$akhir)
    {
       $jumlah_target = $this->target($awal,$akhir);
       $jumlah_kunjungan = $this->jumlahKunjungan($awal,$akhir);
       if ($jumlah_target == 0 || $jumlah_kunjungan == 0) {
           return 0;
       }
       $persentase = $jumlah_kunjungan / $jumlah_target * 100;
    //    return $persentase;
       return round($persentase,2);
    }

    public function jumlahByKeteranganKunjungan($keterangan,$awal,$akhir)
    {
        $user_sf_ids = SalesForce::where("spv_id",$this->id)->pluck("user_id");
        $jumlah = Dos::whereIn("user_id",$user_sf_ids)->where("keterangan_kunjungan",$keterangan)->where("status","approved")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $jumlah;
    }
}
