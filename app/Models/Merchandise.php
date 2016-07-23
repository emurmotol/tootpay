<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Merchandise extends Model
{
    use Eloquence;

    protected $searchableColumns = [
        'name', 'price',
    ];

    protected $fillable = [
        'name', 'price', 'merchandise_category_id', 'has_image', 'available',
    ];

    public function merchandiseCategory() {
        return $this->belongsTo(MerchandiseCategory::class);
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
        return self::where('available', true);
    }

    public static function unavailable() {
        return self::where('available', false);
    }

    public static function byCategory($merchandise_category_id) {
        return self::where('merchandise_category_id', $merchandise_category_id);
    }

    public static function image($merchandise_id) {
        $id = ($merchandise_id === 0 || self::findOrFail($merchandise_id)->has_image) ? $merchandise_id : 0;
        return url('img/merchandises/' . $id . '.jpg');
    }
}
