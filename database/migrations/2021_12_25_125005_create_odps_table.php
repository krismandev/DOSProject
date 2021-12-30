<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->string("nama_odp")->nullable();
            $table->string("sto")->nullable();
            $table->string("lat")->nullable();
            $table->string("long")->nullable();
            $table->string("alamat")->nullable();
            $table->string("merk_olt")->nullable();
            $table->date("tanggal_go_live")->nullable();
            $table->string("project")->nullable();
            $table->string("id_valins")->nullable();
            $table->string("label_barcode_odp")->nullable();
            $table->string("mitra")->nullable();
            $table->string("kendala")->nullable();
            $table->string("permintaan")->nullable();
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
        Schema::dropIfExists('odps');
    }
}
