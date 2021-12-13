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
            "name"=>"aNTO",
            "kode"=>"SPANT02",
            "password"=> bcrypt("zzzzzzzz"),
            "role"=>"sf"
        ]);

        SalesForce::create([
            "user_id"=>$sf1->id,
            "hp"=>"082281164685",
            "ktp"=>"240123434324424",
            "spv_id"=>1,
            "status"=>"active"
        ]);
    }
}
