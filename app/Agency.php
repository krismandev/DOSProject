<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = ["name"];

    public function spv()
    {
        return $this->hasMany(Spv::class,"agency_id","id");
    }
}
