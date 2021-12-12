<?php

use App\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agency = Agency::create([
            "name" => "Infomedia"
        ]);
    }
}
