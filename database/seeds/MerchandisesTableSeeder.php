<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        $merchandises_json  = storage_path('app/public/seeds/') . 'merchandises.json';
        $merchandises = json_decode(file_get_contents($merchandises_json), true);

        foreach ($merchandises as $merchandise) {
            $_merchandises = new Merchandise();
            $_merchandises->name = $merchandise['name'];
            $_merchandises->price = $merchandise['price'];
            $_merchandises->available = rand(0, 1);
            $_merchandises->save();
        }
    }
}
