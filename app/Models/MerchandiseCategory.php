<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchandiseCategory extends Model
{
    public function merchandises() {
        return $this->hasMany('App\Models\Merchandise');
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
