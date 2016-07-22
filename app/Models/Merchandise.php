<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $fillable = [
        'name', 'price', 'merchandise_category_id', 'has_image', 'available',
    ];

    public function merchandiseCategory() {
        return $this->belongsTo('App\Models\MerchandiseCategory');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function setAvailableAttribute($value)
    {
        $this->attributes['available'] = ($value == 'on') ? true : false;
    }

    public static function json($index = null) {
        $path  = resource_path('assets/json/merchandises.json');
        $merchandises = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $merchandises->all();
        }
        return $merchandises[$index]['id'];
    }

    public static function available() {
        $available = collect();

        foreach (self::all() as $merchandise) {
            if ($merchandise->available) {
                $available->push($merchandise);
            }
        }
        return $available->all();
    }

    public static function unavailable() {
        $unavailable = collect();

        foreach (self::all() as $merchandise) {
            if (!$merchandise->available) {
                $unavailable->push($merchandise);
            }
        }
        return $unavailable->all();
    }

    public static function byCategory($merchandise_category_id) {
        $merchandises = collect();

        foreach (self::all() as $merchandise) {
            if ($merchandise->merchandise_category_id == $merchandise_category_id) {
                $merchandises->push($merchandise);
            }
        }
        return $merchandises->all();
    }

    public static function image($merchandise_id) {
        $id = ($merchandise_id === 0 || self::findOrFail($merchandise_id)->has_image) ? $merchandise_id : 0;
        return url('img/merchandises/' . $id . '.jpg');
    }
}
