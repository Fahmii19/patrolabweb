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
            'code' => 'copatrol1-1',
            'name' => 'Patrol Area 1-1',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        PatrolArea::create([
            'code' => 'copatrol1-2',
            'name' => 'Patrol Area 1-2',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        PatrolArea::create([
            'code' => 'copatrol1-3',
            'name' => 'Patrol Area 1-3',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PatrolArea::create([
            'code' => 'copatrol02-1',
            'name' => 'Patrol Area 2-1',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        PatrolArea::create([
            'code' => 'copatrol02-2',
            'name' => 'Patrol Area 2-2',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        PatrolArea::create([
            'code' => 'copatrol02-3',
            'name' => 'Patrol Area 2-3',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        PatrolArea::create([
            'code' => 'copatrol03-1',
            'name' => 'Patrol Area 3-1',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        PatrolArea::create([
            'code' => 'copatrol03-2',
            'name' => 'Patrol Area 3-2',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        PatrolArea::create([
            'code' => 'copatrol03-3',
            'name' => 'Patrol Area 3-3',
            'img_location' => null,
            'location_long_lat' => null,
            'status' => 'ACTIVED',
            'area_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
