<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public static function transaction($transaction, $user_id, $orders, $other = null) {
        $queue_number = null;
        $status_response_id = $transaction->get('status_response_id');
        $payment_method_id = $transaction->get('payment_method_id');

        if ($user_id != User::find(User::guestJson('id'))->id) {

            if ($status_response_id != 12) {
                $queue_number = Transaction::queueNumber();
                $transaction->put('queue_number', $queue_number);
            }
        }
        $_transaction = Transaction::create($transaction->toArray());

        $user = User::find($user_id);

        foreach ($orders as $order) {
            $_order = Order::create($order);
            $_transaction->orders()->attach($_order);
        }
        $toot_card = $user->tootCards()->first();

        if(!is_null($toot_card)) {
            $_transaction->users()->attach($user_id, ['toot_card_id' => $toot_card->id]);

            if ($payment_method_id == 6 && !is_null($other)) {
                $cash_extension = CashExtension::create([
                    'toot_card_id' => $toot_card->id,
                    'amount' => $other
                ]);
                $_transaction->cashExtensions()->attach($cash_extension);
            }
            sendEmail($user->email, 'dashboard.client._partials.notifications.email.purchase_information', $_transaction);
        } else {
            $_transaction->users()->attach($user_id);
        }
        return Transaction::response($status_response_id, $payment_method_id, $_transaction->id, $queue_number);
    }

    public static function ids($transactions) {
        $order_ids = collect();

        if ($transactions->count()) {
            foreach ($transactions as $transaction) {
                $_order_ids = $transaction->orders()->getRelatedIds();

                if ($_order_ids->count()) {
                    foreach ($_order_ids as $order_id) {
                        $_order_id = collect($order_id)->forget('pivot');
                        $order_ids->push($_order_id);
                    }
                }
            }
        }
        return $order_ids->toArray();
    }
}
