<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odc extends Model
{
    protected $fillable = ["nama_odc","nama_sto"];

    public function penugasan()
    {
        return $this->hasMany(Penugasan::class,"odc_id","id");
    }
}
