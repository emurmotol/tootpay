<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        $merchandises_json  = storage_path('app/public/seeds/') . 'merchandises.json';
        $merchandises = json_decode(file_get_contents($merchandises_json), true);

        foreach ($merchandises as $_merchandise) {
            $merchandise = new Merchandise();
            $merchandise->name = $_merchandise['name'];
            $merchandise->price = $_merchandise['price'];
            $merchandise->available = rand(0, 1);
            $merchandise->save();
        }
    }
}
