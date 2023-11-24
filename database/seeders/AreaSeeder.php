<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'code' => 'korea01',
            'name' => 'Area 01',
            'project_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Area::create([
            'code' => 'korea02',
            'name' => 'Area 02',
            'project_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Area::create([
            'code' => 'korea03',
            'name' => 'Area 03',
            'project_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
