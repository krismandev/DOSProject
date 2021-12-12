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
}
