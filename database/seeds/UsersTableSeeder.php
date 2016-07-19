<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use App\Models\Role;
use App\Models\TootCard;
use Carbon\Carbon;
use App\Models\Setting;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $seeds_path = storage_path('app/public/seeds/');

        $roles_json  = $seeds_path . 'roles.json';
        $roles = json_decode(file_get_contents($roles_json), true);

        $admin_json  = $seeds_path . 'admin.json';
        $admin = json_decode(file_get_contents($admin_json), true);

        $user = new User();
        $user->fill($admin)->save();
        $user->roles()->attach(Role::find($roles[0]['id']));

        $cashier_json  = $seeds_path . 'cashiers.json';
        $cashiers = json_decode(file_get_contents($cashier_json), true);

        foreach ($cashiers as $cashier) {
            $user = new User();
            $user->fill($cashier);
            $user->save();
            $user->roles()->attach(Role::find($roles[1]['id']));
        }

        $faker = Faker::create();

        $cardholder_json  = $seeds_path . 'cardholders.json';
        $cardholders = json_decode(file_get_contents($cardholder_json), true);

        foreach ($cardholders as $cardholder) {
            $user = new User();
            $user->fill($cardholder);
            $user->save();
            $user->roles()->attach(Role::find($roles[2]['id']));

            $toot_card = new TootCard();
            $toot_card->id = $faker->creditCardNumber;
            $toot_card->pin_code = $faker->randomNumber(6);
            $toot_card->load = floatval($faker->randomNumber(3));
            $toot_card->points = floatval($faker->randomNumber(2));
            $toot_card->expires_at = Carbon::now()->addYear(Setting::value('expire_year_count'));
            $toot_card->save();
            $user->tootCards()->attach($toot_card);
        }
    }
}
