<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dos', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("foto");
            $table->string("kegiatan")->nullable();
            $table->date("tanggal")->nullable();
            $table->string("waktu")->nullable();
            $table->string("produk")->nullable();
            $table->string("long")->nullable();
            $table->string("lat")->nullable();
            $table->string("odp")->nullable();
            $table->string("status_kunjungan")->nullable();
            $table->string("keterangan_kunjungan")->nullable();
            $table->string("keterangan_tambahan")->nullable();
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dos');
    }
}
