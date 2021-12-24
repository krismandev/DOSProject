<?php

use App\Dos;

function jumlahByKeteranganKunjungan($keterangan,$awal,$akhir){
    $sum = Dos::where("status","approved")->where("keterangan_kunjungan",$keterangan)
    ->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
    return $sum;
}

?>
