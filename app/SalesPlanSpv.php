<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPlanSpv extends Model
{
    protected $fillable = ['sales_plan_id','spv_id'];

    public function sales_plan()
    {
        return $this->belongsTo(SalesPlan::class);
    }

    public function spv()
    {
        return $this->belongsTo(Spv::class);
    }
}
