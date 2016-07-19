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
        $password = config('static.admin.password');
        $roles = config('static.roles');
        $toot_card_count = config('static.toot_card_count');

        $faker = Faker::create();

        $user = new User();
        $user->fill(config('static.admin'))->save();
        $user->roles()->attach(Role::find($roles[0]['id']));

        for ($cashier = 1; $cashier <= 2; $cashier++) {
            $user = new User();
            $user->id = '00' . $faker->randomDigitNotNull . $faker->date('Y') . $faker->randomNumber(4, true);
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->phone_number = '09' . $faker->randomNumber(9);
            $user->password = $password;
            $user->save();
            $user->roles()->attach(Role::find($roles[1]['id']));
        }

        for ($cardholder = 1; $cardholder <= $toot_card_count; $cardholder++) {
            $user = new User();
            $user->id = '00' . $faker->randomDigitNotNull . $faker->date('Y') . $faker->randomNumber(4, true);
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->phone_number = '09' . $faker->randomNumber(9);
            $user->password = $password;
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
