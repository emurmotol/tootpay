<?php

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        foreach (PaymentMethod::json() as $payment_method) {
            PaymentMethod::create($payment_method);
        }
    }
}
