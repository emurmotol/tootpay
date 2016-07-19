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
        $roles_json  = storage_path('app/public/seeds/') . 'roles.json';
        $roles = json_decode(file_get_contents($roles_json), true);
        $admin = $roles[0]['id'];
        $cashier = $roles[1]['id'];
        $cardholder = $roles[2]['id'];

        $admin_json  = storage_path('app/public/seeds/') . 'admin.json';
        $admin_data = json_decode(file_get_contents($admin_json), true);

        $password = $admin_data['password'];
        $toot_card_count = config('static.toot_card_count');

        $faker = Faker::create();

        $user = new User();
        $user->fill($admin_data)->save();
        $user->roles()->attach(Role::find($admin));

        for ($_cashier = 1; $_cashier <= 2; $_cashier++) {
            $user = new User();
            $user->id = '00' . $faker->randomDigitNotNull . $faker->date('Y') . $faker->randomNumber(4, true);
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->phone_number = '09' . $faker->randomNumber(9);
            $user->password = $password;
            $user->save();
            $user->roles()->attach(Role::find($cashier));
        }

        for ($_cardholder = 1; $_cardholder <= $toot_card_count; $_cardholder++) {
            $user = new User();
            $user->id = '00' . $faker->randomDigitNotNull . $faker->date('Y') . $faker->randomNumber(4, true);
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->phone_number = '09' . $faker->randomNumber(9);
            $user->password = $password;
            $user->save();
            $user->roles()->attach(Role::find($cardholder));

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
