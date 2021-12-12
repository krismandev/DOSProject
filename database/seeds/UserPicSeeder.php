<?php

use App\User;
use Illuminate\Database\Seeder;

class UserPicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pic = User::create([
            "name"=>"Prima",
            "kode"=>"PICPRM01",
            "password"=> bcrypt("zzzzzzzz"),
            "role"=>"pic"
        ]);
    }
}
