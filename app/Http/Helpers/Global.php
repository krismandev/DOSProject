<?php

use App\Dos;

function jumlahByKeteranganKunjungan($keterangan,$awal,$akhir){
    $sum = Dos::where("status","approved")->where("keterangan_kunjungan",$keterangan)
    ->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
    return $sum;
}

function transformDate($value, $format = 'Y-m-d')
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon::createFromFormat($format, $value);
    }
}

?>
