<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spv extends Model
{
    protected $fillable = ["user_id","agency"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
