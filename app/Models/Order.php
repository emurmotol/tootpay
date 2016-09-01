<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    protected $fillable = [
        'merchandise_id', 'quantity', 'total',
    ];

    public function merchandises() {
        return $this->belongsTo(Merchandise::class);
    }

    public function transactions() {
        return $this->belongsToMany(Transaction::class, 'order_transaction')->withTimestamps();
    }

    public static function byTransaction($transaction_id) {
        return self::where('transaction_id', $transaction_id)->get();
    }

    public static function removedByUser($ids) {
        return self::whereNotIn('id', $ids)->get();
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

    public static function transaction($transaction, $user_id, $orders) {
        $_transaction = Transaction::create($transaction->toArray());
        $_transaction->users()->attach($user_id);
        $_transaction->orders()->saveMany($orders->toArray());
        return $_transaction->id;
    }
}
