<?php

namespace Database\Seeders;

use App\Models\LocationConditionOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationConditionOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LocationConditionOption::create([
            'option_condition' => 'Kondisi lokasi 01',
            'description' => 'Deksripsi kondisi lokasi 01',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        LocationConditionOption::create([
            'option_condition' => 'Kondisi lokasi 02',
            'description' => 'Deksripsi kondisi lokasi 02',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        LocationConditionOption::create([
            'option_condition' => 'Kondisi lokasi 03',
            'description' => 'Deksripsi kondisi lokasi 03',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
