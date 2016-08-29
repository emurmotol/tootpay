<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(SettingsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OperationDaysTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(MerchandisesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(StatusResponsesTableSeeder::class);
    }
}
