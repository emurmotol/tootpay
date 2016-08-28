<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function operationDays() {
        return $this->belongsToMany(OperationDay::class,
            'merchandise_operation_day', 'merchandise_id', 'operation_day_id')->withTimestamps();
    }

    public static function searchFor($keyword, $model = null) {
        if (!is_null($model)) {
            return $model->search(strtolower($keyword));
        }
        return self::search(strtolower($keyword));
    }

    public static function sort($sort, $model = null) {
        if (!is_null($model)) {
            if ($sort == str_slug(trans('sort.merchandises')[0])) {
                return $model->orderBy('name', 'asc');
            }

            if ($sort == str_slug(trans('sort.merchandises')[1])) {
                return $model->orderBy('updated_at', 'desc');
            }

            if ($sort == str_slug(trans('sort.merchandises')[2])) {
                return $model->orderBy('price', 'desc');
            }

            if ($sort == str_slug(trans('sort.merchandises')[3])) {
                return $model->orderBy('price', 'asc');
            }
        }

        if ($sort == str_slug(trans('sort.merchandises')[0])) {
            return self::orderBy('name', 'asc');
        }

        if ($sort == str_slug(trans('sort.merchandises')[1])) {
            return self::orderBy('updated_at', 'desc');
        }

        if ($sort == str_slug(trans('sort.merchandises')[2])) {
            return self::orderBy('price', 'desc');
        }

        if ($sort == str_slug(trans('sort.merchandises')[3])) {
            return self::orderBy('price', 'asc');
        }
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function merchandiseCategory() {
        return $this->belongsTo(MerchandiseCategory::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public static function json($name) {
        $path = resource_path('assets/json/merchandises/' . $name . '.json');
        $merchandises = collect(json_decode(file_get_contents($path), true));
        return $merchandises->all();
    }

    public static function availableEvery($day) {
        return self::whereIn('id', self::availability($day));
    }

    public static function available() {
        return self::whereIn('id', self::availability(date("w", strtotime(Carbon::now()))));
    }

    public static function availability($day) {
        return OperationDay::find($day)->merchandises()->getRelatedIds()->all();
    }

    public static function unavailable() {
        return self::whereNotIn('id', self::availability(date("w", strtotime(Carbon::now()))));
    }

    public static function byCategory($merchandise_category_id) {
        return self::where('merchandise_category_id', $merchandise_category_id);
    }

    public function image($merchandise_id) {
        $default_image_name = config('static.merchandises.default_image_name');

        if (!$merchandise_id) {
            return url('img/merchandises/' . $default_image_name . '.jpg');
        }
        $merchandise = $this->findOrFail($merchandise_id);
        $file_name = $merchandise->has_image ? str_slug($merchandise->name) : $default_image_name;
        return url('img/merchandises/' . $file_name . '.jpg');
    }

    public static function dailySales($date) {
        return DB::table('merchandise_purchase')
            ->select(DB::raw('status, merchandise_id as merchandise, sum(quantity) as qty, sum(total) as sales, date(created_at) as date'))
            ->where('status', '=', 11)
            ->having('date', '=', $date)
            ->groupBy('merchandise_id', 'date')
            ->get();
    }

    public static function monthlySales($month) {
        return DB::table('merchandise_purchase')
            ->select(DB::raw("status, sum(total) as sales, date(created_at) as date, DATE_FORMAT(created_at, '%Y-%m') as month"))
            ->where('status', '=', 11)
            ->having('month', '=', $month)
            ->groupBy('date')
            ->get();
    }

    public static function yearlySales($year) {
        return DB::table('merchandise_purchase')
            ->select(DB::raw("status, sum(total) as sales, DATE_FORMAT(created_at,'%m') as month, DATE_FORMAT(created_at,'%Y') as year"))
            ->where('status', '=', 11)
            ->having('year', '=', $year)
            ->groupBy('month', 'year')
            ->get();
    }
}
