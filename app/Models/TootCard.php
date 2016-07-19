<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TootCard extends Model
{
    public $incrementing = false;

    protected $dates = ['expires_at'];

    protected $fillable = [
        'id', 'pin_code', 'load', 'points', 'expires_at',
    ];

    public function users() {
        return $this->belongsToMany('App\Models\User',
            'user_toot_card', 'toot_card_id', 'user_id');
    }

    public static function id($user_id) {
        $toot_card = User::find($user_id)->tootCards()->first();
        return $toot_card->pivot->toot_card_id;
    }

    public static function userId($toot_card_id) {
        $toot_card = self::find($toot_card_id)->users()->first();
        return $toot_card->pivot->user_id;
    }

    public function expired() {
        $expired = collect();

        foreach ($this->all() as $toot_card) {
            if ($toot_card->expires_at->lte($toot_card->created_at)) {
                $expired->push($toot_card);
            }
        }
        return $expired;
    }

    public function active() {
        $active = collect();

        foreach ($this->all() as $toot_card) {
            if ($toot_card->expires_at->gt($toot_card->created_at)) {
                $active->push($toot_card);
            }
        }
        return $active;
    }

    public function renewed() {
        return 0;
    }
}
