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
}
