<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoldCard extends Model
{
    protected $fillable = [
        'price',
    ];

    public function transactions() {
        return $this->belongsToMany(Transaction::class, 'sold_card_transaction');
    }

    public static function ids($transactions) {
        $sold_card_ids = collect();

        if ($transactions->count()) {
            foreach ($transactions as $transaction) {
                $_sold_card_ids = $transaction->soldCards()->getRelatedIds();

                if ($_sold_card_ids->count()) {
                    foreach ($_sold_card_ids as $sold_card_id) {
                        $_sold_card_id = collect($sold_card_id)->forget('pivot');
                        $sold_card_ids->push($_sold_card_id);
                    }
                }
            }
        }
        return $sold_card_ids->toArray();
    }
}
