<?php

use Illuminate\Database\Seeder;
use App\Models\OperationDay;

class OperationDaysTableSeeder extends Seeder
{
    public function run()
    {
        foreach (OperationDay::json() as $operation_day) {
            OperationDay::create($operation_day);
        }
    }
}
