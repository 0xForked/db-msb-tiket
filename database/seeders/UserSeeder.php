<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            $user = UserFactory::data();
            DB::table('users')->insert($user);

            $user_id = DB::getPdo()->lastInsertId();

            if ($i % 5 === 0) {
                DB::table('passengers')->insert([
                    UserFactory::dataPassenger($user_id, $user['phone'], $user['email']),
                    UserFactory::dataPassenger($user_id, null, null),
                ]);
            } else {
                DB::table('passengers')->insert([
                    UserFactory::dataPassenger($user_id, $user['phone'], $user['email']),
                ]);
            }

            $faker = Faker::create('id_ID');
            DB::table('emergency_contacts')->insert([
                'user_id' => $user_id,
                'name' => $faker->name,
                'phone' => $faker->e164PhoneNumber,
                'relation' => 'parent'
            ]);
        }
    }
}
