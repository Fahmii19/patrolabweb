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
            'img_location' => null,
            'project_id' => 1,
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Area::create([
            'code' => 'korea02',
            'name' => 'Area 02',
            'img_location' => null,
            'project_id' => 2,
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Area::create([
            'code' => 'korea03',
            'name' => 'Area 03',
            'img_location' => null,
            'project_id' => 3,
            'status' => 'INACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
