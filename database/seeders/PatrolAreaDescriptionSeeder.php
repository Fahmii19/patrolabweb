<?php

namespace Database\Seeders;

use App\Models\PatrolAreaDescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrolAreaDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatrolAreaDescription::create([
            'description' => 'deskripsi patrol area 01',
            'img_desc_location' => null,
            'patrol_area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PatrolAreaDescription::create([
            'description' => 'deskripsi patrol area 02',
            'img_desc_location' => null,
            'patrol_area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PatrolAreaDescription::create([
            'description' => 'deskripsi patrol area 03',
            'img_desc_location' => null,
            'patrol_area_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
