<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $table = 'merchandise';

    protected $fillable = [
        'name', 'price', 'has_image', 'available',
    ];

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
        $merchandises = json_decode(file_get_contents($path), true);

        if (is_null($index)) {
            return $merchandises;
        }
        return $merchandises[$index]['id'];
    }

    public function available() {
        $available = collect();

        foreach ($this->all() as $merchandise) {
            if ($merchandise->available) {
                $available->push($merchandise);
            }
        }
        return $available;
    }

    public function unavailable() {
        $unavailable = collect();

        foreach ($this->all() as $merchandise) {
            if (!$merchandise->available) {
                $unavailable->push($merchandise);
            }
        }
        return $unavailable;
    }

    public function imageUrl($merchandise_id) {
        $id = ($merchandise_id === 0 || $this->findOrFail($merchandise_id)->has_image) ? $merchandise_id : 0;
        return url('img/merchandise/' . $id . '.jpg');
    }
}
