<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadShare extends Model
{
    protected $fillable = [
        'from_toot_card_id', 'to_toot_card_id', 'load_amount',
    ];

    public function tootCards() {
        return $this->hasMany(TootCard::class);
    }
}
