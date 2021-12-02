<?php

use App\Spv;
use App\User;
use Illuminate\Database\Seeder;

class UserSPVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spv1 = User::create([
            "name"=>"FITRAH RAHMANSYAH",
            "kode"=>"SVFRH01",
            "password"=> bcrypt("zzzzzzzz"),
            "role"=>"spv"
        ]);

        Spv::create([
            "user_id"=>$spv1->id,
            "agency"=>"CV.SAIN ANUGRAH JAYA"
        ]);
    }
}
