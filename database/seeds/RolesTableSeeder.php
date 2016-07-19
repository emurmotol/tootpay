<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles_json  = storage_path('app/public/seeds/') . 'roles.json';
        $roles = json_decode(file_get_contents($roles_json), true);

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
