<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function loadShares() {
        return $this->belongsToMany(LoadShare::class, 'load_share_transaction')->withTimestamps();
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

        $orders = Order::selectRaw('merchandise_id as _item, sum(quantity) as _count, sum(total) as _total')
            ->whereIn('id', Order::ids($transaction))
            ->groupBy('_item')
            ->get()
            ->toArray();

        if (count($orders)) {
            $sales->push($orders);
        }

        $reloads = Reload::selectRaw('count(id) as _count, sum(load_amount) as _total')
            ->whereIn('id', Reload::ids($transaction))
            ->first();

        if ($reloads->_count) {
            $sales->push([collect($reloads)->put('_item', 'Toot (Reload)')->toArray()]);
        }

        $sold_cards = SoldCard::selectRaw('count(id) as _count, sum(price) as _total')
            ->whereIn('id', SoldCard::ids($transaction))
            ->first();

        if ($sold_cards->_count) {
            $sales->push([collect($sold_cards)->put('_item', 'Toot (Card)')->toArray()]);
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
            ->get()
            ->toArray();

        if (count($orders)) {
            $sales->push($orders);
        }

        $reloads = Reload::selectRaw("sum(load_amount) as _total, DATE_FORMAT(created_at, '%m') as _month, DATE_FORMAT(created_at, '%Y') as _year")
            ->whereIn('id', Reload::ids($transaction))
            ->first();

        if (intval($reloads->_total)) {
            $sales->push([$reloads->toArray()]);
        }

        $sold_cards = SoldCard::selectRaw("sum(price) as _total, DATE_FORMAT(created_at, '%m') as _month, DATE_FORMAT(created_at, '%Y') as _year")
            ->whereIn('id', SoldCard::ids($transaction))
            ->first();

        if (intval($sold_cards->_total)) {
            $sales->push([$sold_cards->toArray()]);
        }

        $_sales = collect();

        foreach ($sales->collapse()->groupBy('_month')->toArray() as $key => $value) {
            $_sales->push([
                '_month' => $key,
                '_total' => collect($value)->sum('_total')
            ]);
        }
        return $_sales;
    }

    public static function response($status_response_id, $payment_method_id, $transaction_id, $queue_number) {
        $response = [
            'status' => StatusResponse::find($status_response_id)->name,
            'queue_number' => $queue_number,
            'transaction_id' => $transaction_id,
            'payment_method' => PaymentMethod::find($payment_method_id)->name
        ];
        $status = collect($response);
        Log::debug($status->toArray());
        return response()->make($status->toJson());
    }

    public static function pendingAndCash() {
        return self::where('payment_method_id', 1)
            ->where('status_response_id', 5)
            ->orderBy('queue_number', 'desc')
            ->get();
    }

    public static function setStatusResponse($transaction_id, $status_response_id) {
        $transaction = Transaction::find($transaction_id);
        $reload = $transaction->reloads();
        $sold_card = $transaction->soldCards();

        if (!is_null($reload->first())) {
            TootCard::saveLoad($transaction->users()->first()->tootCards()->first()->id, $reload->first()->load_amount);
            $transaction->status_response_id = 11;
            $transaction->save();
            return StatusResponse::def(11);
        } else if (!is_null($sold_card->first())) {
            $toot_card = TootCard::find($sold_card->first()->tootCard->id);
            $toot_card->is_active = true;
            $toot_card->save();
            $transaction->status_response_id = 11;
            $transaction->save();
            return StatusResponse::def(11);
        } else {
            $transaction->queue_number = self::queueNumber();
            $transaction->status_response_id = $status_response_id;
            $transaction->save();
        }
        return self::response($status_response_id, $transaction->payment_method_id, $transaction->id, $transaction->queue_number);
    }
}
