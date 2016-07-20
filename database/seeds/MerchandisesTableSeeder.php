<?php

use Illuminate\Database\Seeder;
use App\Models\Merchandise;

class MerchandisesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Merchandise::json() as $merchandise) {
            Merchandise::create($merchandise);
        }
    }
}
