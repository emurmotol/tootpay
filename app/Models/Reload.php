<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reload extends Model
{
    protected $fillable = [
        'load_amount',
    ];

    public function transactions() {
        return $this->belongsToMany(Transaction::class, 'reload_transaction');
    }

    public function transaction($transaction_id) {
        $transaction = Transaction::find($transaction_id);
        $toot_card = TootCard::find($transaction->tootCards()->first()->id);
        $load = $toot_card->load;
        $toot_card->load = $load + $transaction->orders()->first()->total;
        $toot_card->save();

        $transaction->status_response_id = 11;
        $transaction->save();
    }

    public static function ids($transactions) {
        $reload_ids = collect();

        if ($transactions->count()) {
            foreach ($transactions as $transaction) {
                $_reload_ids = $transaction->reloads()->getRelatedIds();

                if ($_reload_ids->count()) {
                    foreach ($_reload_ids as $reload_id) {
                        $_reload_id = collect($reload_id)->forget('pivot');
                        $reload_ids->push($_reload_id);
                    }
                }
            }
        }
        return $reload_ids->toArray();
    }
}
