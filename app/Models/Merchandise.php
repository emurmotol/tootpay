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

    public function tootCards() {
        return $this->belongsToMany(TootCard::class, 'merchandise_purchase')->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany(User::class, 'merchandise_purchase')->withTimestamps();
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

    public static function orderId() {
        $default = 1;
        $merchandise_purchase = DB::table('merchandise_purchase');

        if (count($merchandise_purchase->get())) {
            return $merchandise_purchase->orderBy('order_id', 'desc')->groupBy('order_id')->first()->order_id + $default;
        }
        return $default;
    }

    public static function queueNumber() {
        $default = 1;
        $merchandise_purchase = DB::table('merchandise_purchase')->select(DB::raw('queue_number, status, date(created_at) as date'))
            ->where('status', '=', config('static.status')[9])
            ->having('date', '=', Carbon::now()->toDateString());

        if (count($merchandise_purchase->get())) {
            return $merchandise_purchase->orderBy('queue_number', 'desc')->groupBy('queue_number')->first()->queue_number + $default;
        }
        return $default;
    }

    public static function dailySales($date) {
        return DB::table('merchandise_purchase')
            ->select(DB::raw('status, merchandise_id as merchandise, sum(quantity) as qty, sum(total) as sales, date(created_at) as date'))
            ->where('status', '=', config('static.status')[10])
            ->having('date', '=', $date)
            ->groupBy('merchandise_id', 'date')
            ->get();
    }

    public static function monthlySales($month) {
        return DB::table('merchandise_purchase')
            ->select(DB::raw("status, sum(total) as sales, date(created_at) as date, DATE_FORMAT(created_at, '%Y-%m') as month"))
            ->where('status', '=', config('static.status')[10])
            ->having('month', '=', $month)
            ->groupBy('date')
            ->get();
    }

    public static function yearlySales($year) {
        return DB::table('merchandise_purchase')
            ->select(DB::raw("status, sum(total) as sales, DATE_FORMAT(created_at,'%m') as month, DATE_FORMAT(created_at,'%Y') as year"))
            ->where('status', '=', config('static.status')[10])
            ->having('year', '=', $year)
            ->groupBy('month', 'year')
            ->get();
    }

    public static function pending($toot_card_id) {
        return DB::table('merchandise_purchase')->select('order_id')
            ->where('toot_card_id', '=', $toot_card_id)
            ->where('status', '=', config('static.status')[4])
            ->get();
    }

    public static function onHold($toot_card_id) {
        return DB::table('merchandise_purchase')->select('order_id')
            ->where('toot_card_id', '=', $toot_card_id)
            ->where('status', '=', config('static.status')[11])
            ->get();
    }

    public static function queued($toot_card_id) {
        return DB::table('merchandise_purchase')->select('order_id')
            ->where('toot_card_id', '=', $toot_card_id)
            ->where('status', '=', config('static.status')[9])
            ->get();
    }

    public static function orders($order_id) {
        return DB::table('merchandise_purchase')->where('order_id', '=', $order_id); // get() is called in view
    }

    public static function groupOrders($orders) {
        return collect($orders)->pluck('order_id', 'order_id');
    }
}
