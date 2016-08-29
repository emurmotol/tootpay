<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;
use App\Models\OperationDay;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        $monday_friday = explode('_', '1_5');
        $week_days = explode('_', '1_2_3_4_5');

        foreach (Merchandise::json('1_2_3_4_5') as $m) {
            $merchandise = Merchandise::create($m);

            if ($m['category_id'] == 1) {
                continue;
            }

            app('App\Http\Controllers\Merchandise\MerchandiseController')->makeImage(resource_path('assets/img/merchandises/' . str_slug($merchandise->name) . '.jpg'), $merchandise);
            foreach($week_days as $day) {
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

        foreach (Merchandise::json('1_5') as $m) {
            $merchandise = Merchandise::create($m);
            app('App\Http\Controllers\Merchandise\MerchandiseController')->makeImage(resource_path('assets/img/merchandises/' . str_slug($merchandise->name) . '.jpg'), $merchandise);
            foreach($monday_friday as $day) {
                $merchandise->operationDays()->attach($day);
            }
        }
    }
}
