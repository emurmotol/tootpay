<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Setting::json() as $setting) {
            Setting::create($setting);
        }
    }
}
