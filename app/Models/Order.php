<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'transaction_id', 'merchandise_id', 'quantity', 'total',
    ];

    public function transactions() {
        return $this->belongsTo(Transaction::class);
    }

    public function merchandises() {
        return $this->belongsTo(Merchandise::class);
    }
}
