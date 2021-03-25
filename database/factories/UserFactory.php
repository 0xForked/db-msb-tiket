<?php

namespace Database\Factories;

use Faker\Provider\en_US\Person;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserFactory
{

    public static function data(): array
    {
        $faker = Faker::create('id_ID');

        return [
            'phone' => $faker->e164PhoneNumber,
            'email' => $faker->email,
            'password' => Hash::make('secret'),
        ];
    }

    public static function dataPassenger($user_id, $phone, $email): array
    {
        $faker = Faker::create('id_ID');

        $gender = $faker->randomElement(['male', 'female']);

        return [
            'user_id' => $user_id,
            'title' => (($gender === 'male') ? 'mr' : 'ms'),
            'identity_number' => $faker->nik(),
            'name' => $faker->name($gender),
            'phone' => $phone ?? $faker->e164PhoneNumber,
            'email' => $email ?? $faker->email,
            'date_of_birth' => $faker->date(),
        ];
    }
}
