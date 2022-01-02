<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHpToSpvs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spvs', function (Blueprint $table) {
            $table->string("hp")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('spvs', 'hp'))
        {
            Schema::table('spvs', function (Blueprint $table)
            {
                $table->dropColumn('hp');
            });
        }
    }
}
