<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPlan extends Model
{
    protected $fillable = ['deskripsi','tanggal'];

    public function sales_plan_kelurahan()
    {
        return $this->hasMany(SalesPlanKelurahan::class,'sales_plan_id','id');
    }

    public function sales_plan_spv()
    {
        return $this->hasMany(SalesPlanSpv::class,'sales_plan_id','id');
    }
}
