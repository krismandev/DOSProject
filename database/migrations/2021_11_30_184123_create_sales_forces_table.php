<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesForcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_forces', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("hp")->nullable();
            $table->string("ktp")->nullable();
            $table->string("agency")->nullable();
            $table->string("spv_id")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('sales_forces');
    }
}
