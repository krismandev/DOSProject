<?php

use App\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin1 = User::create([
            "name"=>"Krisman",
            "kode"=>"ADM001",
            "password"=> bcrypt("zzzzzzzz"),
            "role"=>"admin"
        ]);
    }
}
