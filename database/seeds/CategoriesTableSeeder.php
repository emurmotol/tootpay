<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Category::json() as $category) {
            Category::create($category);
        }
    }
}
