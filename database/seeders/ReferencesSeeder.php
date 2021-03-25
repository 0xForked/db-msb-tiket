<?php

namespace Database\Seeders;

use Database\Factories\AirportFactory;
use Database\Factories\BankFactory;
use Database\Factories\CityFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name' => 'indonesia',
            'code' => 'ina'
        ]);

        DB::table('cities')->insert(CityFactory::data());

        foreach (AirportFactory::data() as $airport) {
            DB::table('airports')->insert($airport);
            $airport_id = DB::getPdo()->lastInsertId();
            DB::table('covid_clinics')->insert([[
                'airport_id' => $airport_id,
                'title' => 'Swab Test Antigen oleh Siloam',
                'description' => 'Test deteksi virus covid-19 dari sample cairan hidung',
                'price' => '249000'
            ],[
                'airport_id' => $airport_id,
                'title' => 'Swab Test PCR oleh Siloam',
                'description' => 'Saat ini menjadi test paling akurat dan dianjurkan oleh WHO',
                'price' => '1350000'
            ]]);
        }

        DB::table('banks')->insert(BankFactory::data());

        DB::table('classes')->insert([
            ['name' => 'ekonomi'],
            ['name' => 'premium ekonomi'],
            ['name' => 'bisnis'],
            ['name' => 'first'],
        ]);

        DB::table('facilities')->insert([
            ['name' => 'bagasi'],
            ['name' => 'kursi'],
        ]);
    }
}
