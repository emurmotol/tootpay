<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
    ];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public static function json($index = null) {
        $path  = resource_path('assets/json/payment_methods.json');
        $payment_methods = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $payment_methods->all();
        }
        return $payment_methods[$index]['id'];
    }
}
