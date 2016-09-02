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
}
