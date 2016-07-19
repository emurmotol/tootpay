<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users() {
        return $this->belongsToMany('App\Models\User',
            'user_role', 'role_id', 'user_id');
    }

    public static function getId($user_id) {
        $role = User::find($user_id)->roles()->first();
        return $role->pivot->role_id;
    }

//    public function rootUrl($user_id) {
//        if (User::isAdministrator($user_id)) {
//            return url('admin/dashboard');
//        } elseif (User::isCashier($user_id)) {
//            return url('cashier/dashboard');
//        } elseif (User::isCardholder($user_id)) {
//            return url('cardholder/dashboard');
//        }
//    }
}
