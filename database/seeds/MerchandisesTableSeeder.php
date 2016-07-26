<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;
use App\Models\OperationDay;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Merchandise::json() as $m) {
            $merchandise = Merchandise::create($m);
            $merchandise->operationDays()->attach(OperationDay::orderByRaw('rand()')->first());
        }
    }
}
