<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesForce extends Model
{
    protected $fillable = ["user_id","hp","ktp","agency","spv_id","status"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spv()
    {
        return $this->belongsTo(Spv::class);
    }

    public function target($tanggal_awal, $tanggal_akhir)
    {

        $target = Setting::where("name","target_dos")->first();
        $target = intval($target->value);

        $awal = strtotime($tanggal_awal);
        $akhir = strtotime($tanggal_akhir);

        $dateDiff = $akhir - $awal;

        $jumlah_hari = round($dateDiff / (60*60*24));

        $jumlah_target = $target * $jumlah_hari;
        return $jumlah_target;
    }

    public function jumlahBertemu($awal,$akhir)
    {
        $sf = SalesForce::find($this->id);
        $user_id = $sf->user_id;
        $jumlah_bertemu = Dos::where("user_id",$user_id)->where("status_kunjungan","BERTEMU")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $jumlah_bertemu;
    }

    public function jumlahTidakBertemu($awal,$akhir)
    {
        $sf = SalesForce::find($this->id);
        $user_id = $sf->user_id;
        $jumlah_bertemu = Dos::where("user_id",$user_id)->where("status_kunjungan","TIDAK BERTEMU")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $jumlah_bertemu;
    }

    public function jumlahKunjungan($awal,$akhir)
    {
        $sf = SalesForce::find($this->id);
        $user_id = $sf->user_id;

        $jumlah_kunjungan = Dos::where("user_id",$user_id)->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
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
}
