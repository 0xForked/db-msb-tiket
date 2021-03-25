<?php

namespace Database\Seeders;

use Database\Factories\AirlineFactory;
use Database\Factories\AirportFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (AirlineFactory::data() as $airline) {
            DB::table('airlines')->insert($airline);

            $airline_id = DB::getPdo()->lastInsertId();

            for ($i = 1; $i <= 1; $i++) {
                DB::table('airplanes')->insert([
                    'airline_id' => $airline_id,
                    'type' => 'COMMERCIAL',
                    'engine_count' => "2",
                    'engine_type' => 'JET',
                    'manufacture' => 'BOIENG737'
                ]);

                $airplane_id = DB::getPdo()->lastInsertId();

                for ($s_name = 1; $s_name <= 21; $s_name++) {
                    for ($s_numb = 1; $s_numb <= 6; $s_numb++) {
                        $sheet = $this->numberToAlphabet($s_name) . $s_numb;
                        DB::table('airplane_has_sheets')->insert([
                            'airplane_id' => $airplane_id,
                            'name' => $sheet
                        ]);
                    }
                }
            }
        }

        $this->runSchedulesSeeder();
    }

    private function runSchedulesSeeder(): void
    {
        foreach (AirportFactory::dataSchedule() as $schedule) {
            // schedule
            DB::table('schedules')->insert($schedule);

            $schedule_id = DB::getPdo()->lastInsertId();

            // schedule_has_classes
            DB::table('schedule_has_classes')->insert([
                'schedule_id' => $schedule_id ,
                'class_id' => 1
            ]);

            // route
            if ($schedule['origin'] === 'MDC' && $schedule['destination'] === 'CGK') {
                DB::table('routes')->insert([
                    [
                        'schedule_id' => $schedule_id,
                        'depart_time' => '07:00',
                        'arrive_time' => '10:00',
                        'origin' => 'MDC',
                        'destination' => 'UPG',
                        'transit' => 'UPG',
                        'price' => '900000'
                    ],
                    [
                        'schedule_id' => $schedule_id,
                        'depart_time' => '10:00',
                        'arrive_time' => '11:30',
                        'origin' => 'UPG',
                        'destination' => 'CGK',
                        'transit' => NULL,
                        'price' => '400000'
                    ]
                ]);
                $this->runRouteHasFacilities(1);
                $this->runRouteHasFacilities(2);
            } else if ($schedule['origin'] === 'CGK' && $schedule['destination'] === 'JOG') {
                DB::table('routes')->insert([
                    'schedule_id' => $schedule_id,
                    'depart_time' => '07:00',
                    'arrive_time' => '08:30',
                    'origin' => 'CJK',
                    'destination' => 'JOG',
                    'transit' => NULL,
                    'price' => '650000'
                ]);
                $this->runRouteHasFacilities(DB::getPdo()->lastInsertId());
            } else if ($schedule['origin'] === 'CGK' && $schedule['destination'] === 'PNK') {
                DB::table('routes')->insert([
                    'schedule_id' => $schedule_id,
                    'depart_time' => '07:00',
                    'arrive_time' => '11:00',
                    'origin' => 'CJK',
                    'destination' => 'PNK',
                    'transit' => NULL,
                    'price' => '1250000'
                ]);
                $this->runRouteHasFacilities(DB::getPdo()->lastInsertId());
            } else {
                DB::table('routes')->insert([
                    'schedule_id' => $schedule_id,
                    'depart_time' => '07:00',
                    'arrive_time' => '11:00',
                    'origin' => $schedule['origin'],
                    'destination' =>  $schedule['destination'],
                    'transit' => NULL,
                    'price' => '950000'
                ]);
                $this->runRouteHasFacilities(DB::getPdo()->lastInsertId());
            }
        }
    }

    private function runRouteHasFacilities($id): void
    {
        DB::table('route_has_facilities')->insert([
            'route_id' => $id,
            'facility_id' => 1,
            'price' => null
        ]);
    }

    private function numberToAlphabet($number): string
    {
        $number = (int)$number;
        if ($number <= 0) {
            return '';
        }

        $alphabet = '';
        while($number !== 0) {
            $p = ($number - 1) % 26;
            $number = (int)(($number - $p) / 26);
            $alphabet = chr(65 + $p) . $alphabet;
        }

        return ucwords($alphabet);
    }
}
