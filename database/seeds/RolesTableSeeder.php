<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Role::json() as $role) {
            Role::create($role);
        }
    }
}
