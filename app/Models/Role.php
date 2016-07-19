<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users() {
        return $this->belongsToMany('App\Models\User',
            'user_role', 'role_id', 'user_id');
    }

    public static function id($user_id) {
        $role = User::find($user_id)->roles()->first();
        return $role->pivot->role_id;
    }

    public static function json($index = null) {
        $path  = resource_path('assets/json/roles.json');
        $roles = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $roles->all();
        }
        return $roles[$index]['id'];
    }
}
