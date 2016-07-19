<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (config('static.roles') as $role) {
            Role::create($role);
        }
    }
}
