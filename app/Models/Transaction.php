<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'queue_number', 'payment_method_id', 'status_response_id',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_transaction')->withTimestamps();
    }

    public function tootCards() {
        return $this->belongsToMany(TootCard::class, 'user_transaction')->withTimestamps();
    }

    public function paymentMethods() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function statusResponses() {
        return $this->belongsTo(StatusResponse::class);
    }
}
