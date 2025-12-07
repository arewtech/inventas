<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Kantor MA',
            ],
            [
                'name' => 'Ruang Osim',
            ]
        ];

        foreach ($locations as $location) {
            \App\Models\Location::create($location);
        }
    }
}
