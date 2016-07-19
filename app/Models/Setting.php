<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'key';

    protected $fillable = [
        'key', 'value',
    ];

    public static function value($key) {
        return self::find($key)->value;
    }

    public static function json($index = null) {
        $json  = storage_path('app/public/seeds/') . 'settings.json';
        $settings = json_decode(file_get_contents($json), true);

        if (is_null($index)) {
            return $settings;
        }
        return $settings[$index]['id'];
    }
}
