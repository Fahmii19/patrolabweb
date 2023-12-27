<?php

namespace Database\Seeders;

use App\Models\PatrolArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrolAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatrolArea::create([
            'code' => 'copatrol01',
            'name' => 'Patrol Area 1',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PatrolArea::create([
            'code' => 'copatrol02',
            'name' => 'Patrol Area 2',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        PatrolArea::create([
            'code' => 'copatrol03',
            'name' => 'Patrol Area 3',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
