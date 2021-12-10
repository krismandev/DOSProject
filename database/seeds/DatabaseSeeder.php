<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSPVSeeder::class);
        // $this->call(UserSFSeeder::class);
        $this->call(UserAdminSeeder::class);
    }
}
