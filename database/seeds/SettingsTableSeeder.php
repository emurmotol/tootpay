<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings_json  = storage_path('app/public/seeds/') . 'settings.json';
        $settings = json_decode(file_get_contents($settings_json), true);

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
