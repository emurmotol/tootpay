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
        // todo: bcrypt() the password
        User::create(User::adminJson())->roles()->attach(Role::find(Role::json(0)));
        
        // todo: bcrypt() the password
        foreach (User::cashiersJson() as $cashier) {
            User::create($cashier)->roles()->attach(Role::find(Role::json(1)));
        }

        foreach (User::cardholdersJson() as $cardholder) {
            // todo: bcrypt() the password
            $user = User::create($cardholder);
            $user->roles()->attach(Role::find(Role::json(2)));
            
            $faker = Faker::create();
            $toot_card = TootCard::create([
                "id" => $faker->creditCardNumber,    
                "pin_code" => bcrypt($faker->randomNumber(6)),    
                "load" => floatval($faker->randomNumber(3)),
                "points" => floatval($faker->randomNumber(2)),
                "expires_at" => Carbon::now()->addYear(Setting::value('expire_year_count')),
            ]);
            $user->tootCards()->attach($toot_card);
        }
    }
}
