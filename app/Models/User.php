<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Sofa\Eloquence\Eloquence;

class User extends Authenticatable
{
    use Eloquence;

    protected $searchableColumns = [
        'id', 'name', 'email', 'phone_number',
    ];

    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'email', 'phone_number', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class,
            'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    public function tootCards() {
        return $this->belongsToMany(TootCard::class,
            'user_toot_card', 'user_id', 'toot_card_id')->withTimestamps();
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords(strtolower($value));
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

    public static function searchFor($keyword, $model = null) {
        if (!is_null($model)) {
            return $model->search(strtolower($keyword));
        }
        return self::search(strtolower($keyword));
    }

    public static function sort($sort, $model = null) {
        if (!is_null($model)) {
            if ($sort == str_slug(trans('sort.users')[0])) {
                return $model->orderBy('name', 'asc');
            }

            if ($sort == str_slug(trans('sort.users')[1])) {
                return $model->orderBy('updated_at', 'desc');
            }
        } else {
            if ($sort == str_slug(trans('sort.users')[0])) {
                return self::orderBy('name', 'asc');
            }

            if ($sort == str_slug(trans('sort.users')[1])) {
                return self::orderBy('updated_at', 'desc');
            }
        }
    }

    public static function adminJson($field = null) {
        $path  = resource_path('assets/json/users/admin.json');
        $admin = collect(json_decode(file_get_contents($path), true));

        if (is_null($field)) {
            return $admin->all();
        }
        return $admin[$field];
    }

    public static function cashiersJson($index = null) {
        $path  = resource_path('assets/json/users/cashiers.json');
        $cashiers = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $cashiers->all();
        }
        return $cashiers[$index];
    }

    public static function cardholdersJson($index = null) {
        $path  = resource_path('assets/json/users/cardholders.json');
        $cardholders = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $cardholders->all();
        }
        return $cardholders[$index];
    }

    public static function administrators() {
        $administrators = collect();

        foreach (self::all() as $user) {
            if ($user->hasRole(Role::json(0))) {
                $administrators->push($user);
            }
        }
        return $administrators->all();
    }

    public static function cashiers() {
        $cashiers = collect();

        foreach (self::all() as $user) {
            if ($user->hasRole(Role::json(1))) {
                $cashiers->push($user);
            }
        }
        return $cashiers->all();
    }

    public static function cardholders() {
        $cardholders = collect();

        foreach (self::all() as $user) {
            if ($user->hasRole(Role::json(2))) {
                $cardholders->push($user);
            }
        }
        return $cardholders->all();
    }
}
