<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = [
        'queue_number', 'payment_method_id', 'status_response_id',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'user_toot_card_transaction')->withTimestamps();
    }

    public function tootCards() {
        return $this->belongsToMany(TootCard::class, 'user_toot_card_transaction')->withTimestamps();
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_transaction')->withTimestamps();
    }

    public function reloads() {
        return $this->belongsToMany(Reload::class, 'reload_transaction')->withTimestamps();
    }

    public function soldCards() {
        return $this->belongsToMany(SoldCard::class, 'sold_card_transaction')->withTimestamps();
    }

    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function statusResponse() {
        return $this->belongsTo(StatusResponse::class);
    }

    public static function queueNumber() {
        $default = 1;
        $transactions = self::where('status_response_id', '=', 10)
            ->whereDate('created_at', '=', Carbon::now()->toDateString());

        if ($transactions->count()) {
            $queue_number = $transactions->orderBy('queue_number', 'desc')
                ->groupBy('queue_number')->first()->queue_number;
            return $queue_number + $default;
        }
        return $default;
    }

    public static function createdBy($toot_card_id, $status_response_id, $payment_method_id) {
        return TootCard::find($toot_card_id)->transactions()
            ->where('status_response_id', $status_response_id)
            ->where('payment_method_id', $payment_method_id);
    }

    public static function dailySales($date) {
        $transaction = self::where('status_response_id', 11)
            ->whereDate('created_at', '=', $date)
            ->get();

        $sales = collect();

        $orders = Order::selectRaw('merchandise_id as item, sum(quantity) as _quantity, sum(total) as _total')
            ->whereIn('id', Order::ids($transaction))
            ->groupBy('item')
            ->get()
            ->toArray();

        if (count($orders)) {
            $sales->push($orders);
        }

        $reloads = Reload::selectRaw('count(id) as _quantity, sum(load_amount) as _total')
            ->whereIn('id', Reload::ids($transaction))
            ->first();

        if ($reloads->_quantity) {
            $sales->push([collect($reloads)->put('item', 'Toot (Reload)')->toArray()]);
        }

        $sold_cards = SoldCard::selectRaw('count(id) as _quantity, sum(price) as _total')
            ->whereIn('id', SoldCard::ids($transaction))
            ->first();

        if ($sold_cards->_quantity) {
            $sales->push([collect($sold_cards)->put('item', 'Toot (Card)')->toArray()]);
        }
        return $sales->collapse();
    }

    public static function monthlySales($month) {
        $transaction = self::where('status_response_id', 11)
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), '=', $month)
            ->get();

        $sales = collect();

        $orders = Order::selectRaw('date(created_at) as _date, sum(total) as _total')
            ->whereIn('id', Order::ids($transaction))
            ->groupBy('_date')
            ->get()
            ->toArray();

        if (count($orders)) {
            $sales->push($orders);
        }

        $reloads = Reload::selectRaw('date(created_at) as _date, sum(load_amount) as _total')
            ->whereIn('id', Reload::ids($transaction))
            ->first();

        if (intval($reloads->_total)) {
            $sales->push([$reloads->toArray()]);
        }

        $sold_cards = SoldCard::selectRaw('date(created_at) as _date, sum(price) as _total')
            ->whereIn('id', SoldCard::ids($transaction))
            ->first();

        if (intval($sold_cards->_total)) {
            $sales->push([$sold_cards->toArray()]);
        }

        $_sales = collect();

        foreach ($sales->collapse()->groupBy('_date')->toArray() as $key => $value) {
            $_sales->push([
                '_date' => $key,
                '_total' => collect($value)->sum('_total')
            ]);
        }
        return $_sales;
    }

    public static function yearlySales($year) {
        $transaction = self::where('status_response_id', 11)
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '=', $year)
            ->get();

        $sales = collect();

        $orders = Order::selectRaw("sum(total) as _total, DATE_FORMAT(created_at, '%m') as _month, DATE_FORMAT(created_at, '%Y') as _year")
            ->whereIn('id', Order::ids($transaction))
            ->groupBy('_month', '_year')
            ->get();
    }
}
