<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPlanKelurahan extends Model
{
    protected $fillable = ['sales_plan_id','kelurahan_id'];

    public function sales_plan()
    {
        return $this->belongsTo(SalesPlan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}
