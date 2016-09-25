<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashExtension extends Model
{
    protected $fillable = [
        'toot_card_id', 'amount',
    ];

    public function transactions() {
        return $this->belongsToMany(Transaction::class, 'cash_extension_transaction');
    }

    public function tootCard() {
        return $this->belongsTo(TootCard::class);
    }

    public static function ids($transactions) {
        $cash_extension_ids = collect();

        if ($transactions->count()) {
            foreach ($transactions as $transaction) {
                $_cash_extension_ids = $transaction->cashExtensions()->getRelatedIds();

                if ($_cash_extension_ids->count()) {
                    foreach ($_cash_extension_ids as $cash_extension_id) {
                        $_cash_extension_id = collect($cash_extension_id)->forget('pivot');
                        $cash_extension_ids->push($_cash_extension_id);
                    }
                }
            }
        }
        return $cash_extension_ids->toArray();
    }
}
