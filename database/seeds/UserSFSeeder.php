<?php

use App\SalesForce;
use App\User;
use Illuminate\Database\Seeder;

class UserSFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sf1 = User::create([
            "name"=>"Budi",
            "kode"=>"SPBDI01",
            "password"=> bcrypt("zzzzzzzz"),
            "role"=>"sf"
        ]);

        SalesForce::create([
            "user_id"=>$sf1->id,
            "hp"=>"082281164684",
            "ktp"=>"240123434324425",
            "spv_id"=>1,
            "status"=>"active"
        ]);
    }
}
