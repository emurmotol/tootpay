<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (config('static.merchandises') as $merchandise) {
            $merchandises = new Merchandise();
            $merchandises->name = $merchandise['name'];
            $merchandises->price = $merchandise['price'];
            $merchandises->available = rand(0, 1);
            $merchandises->save();
        }
    }
}
