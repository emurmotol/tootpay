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
}
