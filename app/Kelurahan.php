<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $guarded = [];

    public function sales_plan_kelurahan()
    {
        return $this->hasMany(SalesPlanKelurahan::class,'kelurahan_id','id');
    }
}
