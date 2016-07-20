<?php

use Illuminate\Database\Seeder;
use App\Models\MerchandiseCategory;

class MerchandiseCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (MerchandiseCategory::json() as $merchandise_category) {
            MerchandiseCategory::create($merchandise_category);
        }
    }
}
