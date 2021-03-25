<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeOrderBySchedule([1, 10], 2);
        $this->makeOrderBySchedule([11, 32], 4);
        $this->makeOrderBySchedule([32, 50], 5);
    }

    private function makeOrderBySchedule($user_id_between, $schedule_id): void
    {
        $available_sheets = [];

        $users = DB::table('users')
            ->whereBetween('id', $user_id_between)
            ->get();

        foreach ($users as $user) {
            $passengers = DB::table('passengers')
                ->where('user_id', $user->id)
                ->get(['id']);

            $schedule = DB::table('schedules')
                ->join('routes',
                    'routes.schedule_id',
                    '=', 'schedules.id')
                ->where('schedules.id', $schedule_id)
                ->first([
                    'schedules.origin as origin',
                    'schedules.airplane_id as airplane_id',
                    'routes.price as price',
                    'routes.id as route_id'
                ]);

            $airport_clinic = DB::table('airports')
                ->join(
                'covid_clinics',
                'covid_clinics.airport_id',
                '=',
                'airports.id'
                )->where('airports.iata', $schedule->origin)
                ->first([
                    'covid_clinics.id as clinic_id',
                    'covid_clinics.price as clinic_price'
                ]);

            $faker = Faker::create('id_ID');
            $auto = $faker->randomElement(['18', '12', '15', '21', '22', '12']);

            DB::table('orders')->insert([
                'number' => Str::random(16),
                'user_id' => $user->id,
                'schedule_id' => $schedule_id,
                'covid_clinic_id' => ($user->id % 2 === 0)
                    ? null
                    : $airport_clinic->clinic_id,
                'date' => '2021-02-' . $auto
            ]);

            $order_id = DB::getPdo()->lastInsertId();

            foreach ($passengers as $passenger) {
                if (empty($available_sheets)) {
                    $airplane_sheets = DB::table('airplane_has_sheets')
                        ->where('airplane_id', $schedule->airplane_id)
                        ->get('id');

                    foreach ($airplane_sheets as $sheet) {
                        $available_sheets[] = $sheet->id;
                    }
                }

                DB::table('order_items')->insert([
                    'order_id' => $order_id,
                    'passenger_id' => $passenger->id,
                    'sheet_id' => end($available_sheets),
                    'booking_code' => Str::random(),
                    'ticket_code' => Str::random(8),
                    'price' => $schedule->price,
                    'total' => ((int)$schedule->price + (($user->id % 2 === 0)
                        ? 0 : (int)$airport_clinic->clinic_price))
                ]);

                array_pop($available_sheets);

                $order_item_id = DB::getPdo()->lastInsertId();
                $route_facility = DB::table('route_has_facilities')
                    ->where('route_id', $schedule->route_id)
                    ->first('id');

                DB::table('order_item_facilities')->insert([
                    'order_item_id' => $order_item_id,
                    'facility_id' => $route_facility->id,
                    'price' => '0'
                ]);
            }

            $this->updateCurrentPrice($order_id);

            DB::table('order_has_payments')->insert([
                'order_id' => $order_id,
                'method' => 'BANK_TRANSFER',
                'status' => 'PAID'
            ]);

        }
    }

    private function updateCurrentPrice($order_id)
    {
        $order_items = DB::table('orders')
            ->join('order_items',
                'order_items.order_id',
                '=', 'orders.id')
            ->where('orders.id', $order_id)
            ->get([
                'order_items.total as total',
            ]);

        $price = 0;
        foreach ($order_items as $item) {
            $price += $item->total;
        }

        DB::table('orders')
            ->where('id', $order_id)
            ->update(['total_price' => $price]);
    }
}
