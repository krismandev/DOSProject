<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dos extends Model
{
    protected $fillable = ["user_id","foto","kegiatan","tanggal","waktu","product","long","lat","odp","produk","status_kunjungan","keterangan_kunjungan","keterangan_tambahan","status","id_dos","gab_kelurahan"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
