<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
