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
        User::create(User::adminJson())->roles()->attach(Role::find(Role::json(0)));

        foreach (User::cashiersJson() as $cashier) {
            User::create($cashier)->roles()->attach(Role::find(Role::json(1)));
        }

        foreach (User::cardholdersJson() as $cardholder) {
            $user = User::create($cardholder);
            $user->roles()->attach(Role::find(Role::json(2)));

            $toot_card = new TootCard();
            $faker = Faker::create();
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
