<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;
use App\Models\OperationDay;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        $days = explode('_', '1_2_3_4_5_6');

        foreach (Merchandise::json('1_2_3_4_5_6') as $m) {
            $merchandise = Merchandise::create($m);
            app('App\Http\Controllers\Merchandise\MerchandiseController')->makeImage(resource_path('assets/img/merchandises/' . str_slug($merchandise->name) . '.jpg'), $merchandise);

            foreach($days as $day) {
                $merchandise->operationDays()->attach($day);
            }
        }

        foreach(OperationDay::hasOperation(true) as $day) {
            foreach (Merchandise::json($day->id) as $m) {
                $merchandise = Merchandise::create($m);
                app('App\Http\Controllers\Merchandise\MerchandiseController')->makeImage(resource_path('assets/img/merchandises/' . str_slug($merchandise->name) . '.jpg'), $merchandise);
                $merchandise->operationDays()->attach($day->id);
            }
        }
    }
}
