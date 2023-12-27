<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name' => 'City 01',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        City::create([
            'name' => 'City 02',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        City::create([
            'name' => 'City 03',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
