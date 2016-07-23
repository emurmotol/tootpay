<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class MerchandiseCategory extends Model
{
    use Eloquence;

    protected $searchableColumns = [
        'name',
    ];

    protected $fillable = [
        'name',
    ];

    public function merchandises() {
        return $this->hasMany(Merchandise::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public static function json($index = null) {
        $path  = resource_path('assets/json/merchandise_categories.json');
        $merchandise_category = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $merchandise_category->all();
        }
        return $merchandise_category[$index];
    }
}
