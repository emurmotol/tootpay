<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OperationDay extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'day',
    ];

    public function setDayAttribute($value) {
        $this->attributes['day'] = ucfirst($value);
    }

    public function merchandises() {
        return $this->belongsToMany(Merchandise::class,
            'merchandise_operation_day', 'operation_day_id', 'merchandise_id')->withTimestamps();
    }

    public static function json($index = null) {
        $path = resource_path('assets/json/operation_days.json');
        $operation_days = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $operation_days->all();
        }
        return $operation_days[$index]['id'];
    }

    public static function purchaseDates() {
        return DB::table('purchases')->select(DB::raw('date(created_at) as date'))->groupBy('date')->orderBy('date', 'asc')->get();
    }
}
