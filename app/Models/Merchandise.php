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

    public function getAvailable() {
        $available = collect();

        foreach ($this->all() as $merchandise) {
            if ($merchandise->available) {
                $available->push($merchandise);
            }
        }
        return $available;
    }

    public function getUnavailable() {
        $unavailable = collect();

        foreach ($this->all() as $merchandise) {
            if (!$merchandise->available) {
                $unavailable->push($merchandise);
            }
        }
        return $unavailable;
    }

    public function getImageUrl($merchandise_id) {
        $id = ($merchandise_id === 0 || $this->findOrFail($merchandise_id)->has_image) ? $merchandise_id : 0;
        return url('img/merchandise/' . $id . '.jpg');
    }
}
