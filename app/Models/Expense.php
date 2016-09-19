<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    protected $fillable = [
        'name', 'amount', 'description',
    ];

    public static function daily($date) {
        return self::whereDate('created_at', '=', $date)->get();
    }

    public static function monthly($month) {
        return self::selectRaw('date(created_at) as _date, sum(amount) as _amount')
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), '=', $month)
            ->groupBy('_date')
            ->get();
    }

    public static function yearly($year) {
        return self::selectRaw("sum(amount) as _amount, DATE_FORMAT(created_at, '%m') as _month, DATE_FORMAT(created_at, '%Y') as _year")
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '=', $year)
            ->groupBy('_month', '_year')
            ->get();
    }
}
