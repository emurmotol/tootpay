<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(SettingsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class); // todo toot card seeder called here
        $this->call(MerchandiseCategoriesTableSeeder::class);
        $this->call(MerchandisesTableSeeder::class);
    }
}
