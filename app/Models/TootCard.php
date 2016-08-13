<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class TootCard extends Model
{
    use Eloquence;

    protected $searchableColumns = [
        'id', 'load', 'points',
    ];

    public $incrementing = false;

    protected $dates = ['expires_at'];

    protected $fillable = [
        'id', 'pin_code', 'load', 'points', 'is_active', 'expires_at',
    ];

    public function users() {
        return $this->belongsToMany(User::class,
            'user_toot_card', 'toot_card_id', 'user_id');
    }

    public function reload() {
        return $this->belongsToMany(User::class,
            'reloads', 'toot_card_id', 'user_id');
    }

    public function merchandises() {
        return $this->belongsToMany(Merchandise::class, 'purchases');
    }

    public function setIsActiveAttribute($value) {
        $this->attributes['is_active'] = ($value == 'on') ? 1 : 0;
    }

    public static function searchFor($keyword, $model = null) {
        if (!is_null($model)) {
            return $model->search(strtolower($keyword));
        }
        return self::search(strtolower($keyword));
    }

    public static function sort($sort, $model = null) {
        if (!is_null($model)) {
            if ($sort == str_slug(trans('sort.toot_cards')[0])) {
                return $model->orderBy('updated_at', 'desc');
            }
        } else {
            if ($sort == str_slug(trans('sort.toot_cards')[0])) {
                return self::orderBy('updated_at', 'desc');
            }
        }
    }
}
