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
}
