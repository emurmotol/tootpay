<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'email', 'phone_number', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role',
            'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    public function tootCards() {
        return $this->belongsToMany('App\Models\TootCard',
            'user_toot_card', 'user_id', 'toot_card_id')->withTimestamps();
    }

    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role) {
        if ($this->roles()->find($role)) {
            return true;
        }
        return false;
    }

    public static function adminJson($field = null) {
        $path  = resource_path('assets/json/admin.json');
        $admin = collect(json_decode(file_get_contents($path), true));

        if (is_null($field)) {
            return $admin->all();
        }
        return $admin[$field];
    }

    public static function cashiersJson($index = null) {
        $path  = resource_path('assets/json/cashiers.json');
        $cashiers = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $cashiers->all();
        }
        return $cashiers[$index];
    }

    public static function cardholdersJson($index = null) {
        $path  = resource_path('assets/json/cardholders.json');
        $cardholders = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $cardholders->all();
        }
        return $cardholders[$index];
    }

    public function administrators() {
        $administrators = collect();

        foreach ($this->all() as $user) {
            if ($user->hasRole(Role::json(0))) {
                $administrators->push($user);
            }
        }
        return $administrators;
    }

    public function cashiers() {
        $cashiers = collect();

        foreach ($this->all() as $user) {
            if ($user->hasRole(Role::json(1))) {
                $cashiers->push($user);
            }
        }
        return $cashiers;
    }

    public function cardholders() {
        $cardholders = collect();

        foreach ($this->all() as $user) {
            if ($user->hasRole(Role::json(2))) {
                $cardholders->push($user);
            }
        }
        return $cardholders;
    }
}
