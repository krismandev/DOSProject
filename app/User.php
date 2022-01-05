<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'kode', 'password','role','user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sales_force()
    {
        return $this->hasOne(SalesForce::class,"user_id","id");
    }

    public function dos()
    {
        return $this->hasMany(Dos::class,"user_id","id");
    }

    public function spv()
    {
        return $this->hasOne(Spv::class,"user_id","id");
    }

    public function spv_pic()
    {
        return $this->hasMany(Spv::class,"pic_id","id");
    }

    public function jumlahDosByStatusKunjungan($status,$awal,$akhir)
    {
        $sum = Dos::where("user_id",$this->id)->where("status","approved")->where("status_kunjungan",$status)
        ->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $sum;
    }

    public function jumlahDosByKeteranganKunjungan($keterangan_kunjungan,$awal,$akhir)
    {
        $sum = Dos::where("user_id",$this->id)->where("status","approved")->where("keterangan_kunjungan",$keterangan_kunjungan)
        ->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
        return $sum;
    }

}
