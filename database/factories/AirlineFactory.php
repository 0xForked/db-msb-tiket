<?php

namespace Database\Factories;

class AirlineFactory
{
    public static function data(): array
    {
        return [
            [
                'name' => 'PT. Garuda Indonesia',
                'type' => 'COMMERCIAL',
                'callsign' => 'GARUDA',
                'icao' => 'GIA',
                'iata' => 'GA',
            ],[
                'name' => 'PT. Citilink Indonesia',
                'type' => 'COMMERCIAL',
                'callsign' => 'CITILINK',
                'icao' => 'CTV',
                'iata' => 'QG',
            ],[
                'name' => 'PT. Sriwijaya Air',
                'type' => 'COMMERCIAL',
                'callsign' => 'SRIWIJAYA',
                'icao' => 'SJY',
                'iata' => 'SJ',
            ],[
                'name' => 'PT. Lion Mentari Airlines',
                'type' => 'COMMERCIAL',
                'callsign' => 'LION',
                'icao' => 'LNI',
                'iata' => 'JT',
            ],[
                'name' => 'PT. BATIK AIR INDONESIA',
                'type' => 'COMMERCIAL',
                'callsign' => 'BATIK',
                'icao' => 'BTK',
                'iata' => 'ID',
            ],
        ];
    }
}
