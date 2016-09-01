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
        return $this->belongsToMany(User::class, 'user_transaction')->withTimestamps();
    }

    public function tootCards() {
        return $this->belongsToMany(TootCard::class, 'user_transaction')->withTimestamps();
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_transaction')->withTimestamps();
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
            $queue_number = $transactions->orderBy('queue_number', 'desc')->groupBy('queue_number')->first()->queue_number;
            return $queue_number + $default;
        }
        return $default;
    }

    public static function createdBy($toot_card_id, $status_response_id, $payment_method_id) {
        return TootCard::find($toot_card_id)->transactions()
            ->where('status_response_id', $status_response_id)
            ->where('payment_method_id', $payment_method_id);
    }
}
