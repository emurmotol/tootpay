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

    public function transactions() {
        return $this->belongsToMany(Transaction::class, 'load_share_transaction')->withTimestamps();
    }

    public static function fromTo($toot_card_id, $user_id, $load_amount) {
        $toot_card_sender = TootCard::find($toot_card_id);
        $sender_load = $toot_card_sender->load;
        $toot_card_sender->load = $sender_load - $load_amount;
        $toot_card_sender->save();

        $toot_card_receiver = User::find($user_id)->tootCards()->first();
        $receiver_load = $toot_card_receiver->load;
        $toot_card_receiver->load = $receiver_load + $load_amount;
        $toot_card_receiver->save();
    }
}
