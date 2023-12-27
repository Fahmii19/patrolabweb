<?php

namespace Database\Seeders;

use App\Models\PletonPatrolArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PletonPatrolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PletonPatrolArea::create([
            'pleton_id' => 1,
            'patrol_area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PletonPatrolArea::create([
            'pleton_id' => 2,
            'patrol_area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PletonPatrolArea::create([
            'pleton_id' => 3,
            'patrol_area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
