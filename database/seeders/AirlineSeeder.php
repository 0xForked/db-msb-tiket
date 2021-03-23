<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('airlines')->insert([
            [
                'code' => 'ga',
                'name' => 'garuda indonesia',
            ],
            [
                'code' => 'jt',
                'name' => 'lion air',
            ],
            [
                'code' => 'id',
                'name' => 'batik air',
            ],
            [
                'code' => 'qg',
                'name' => 'citilink',
            ],
        ]);
    }
}
