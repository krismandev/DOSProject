<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $fillable = ["spv_id","odc_id","odp","keterangan","tanggal_mulai","tanggal_selesai"];

    public function spv()
    {
        return $this->belongsTo(Spv::class);
    }

    public function odc()
    {
        return $this->belongsTo(Odc::class);
    }
}
