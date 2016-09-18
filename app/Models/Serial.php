<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    protected $fillable = [
        'tag',
    ];

    public static function hasNew() {
        $count = self::all()->count();
        $temp_count = intval(Setting::value('serial_count'));

        if ($count != $temp_count) {
            $serial_count = Setting::find('serial_count');
            $serial_count->value = $count;
            $serial_count->save();
            return true;
        }
        return false;
    }

    public static function tag() {
        if (self::hasNew()) {
            return self::all()->last()->tag;
        }
        return null;
    }
}
