<?php

namespace Database\Seeders;

use App\Models\CheckPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheckpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckPoint::create([
            'name' => 'Checkpoint 01',
            'location' => 'Location Checkpoint 01',
            'location_long_lat' => '104.735846710;-2.9588216',
            'qr_code' => 'AABBCC112233',
            'danger_status' => 'LOW',
            'status' => 'ACTIVED',
            'round_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        CheckPoint::create([
            'name' => 'Checkpoint 02',
            'location' => 'Location Checkpoint 02',
            'location_long_lat' => '104.735846710;-2.9588216',
            'qr_code' => 'AABBCC445566',
            'danger_status' => 'MIDDLE',
            'status' => 'ACTIVED',
            'round_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        CheckPoint::create([
            'name' => 'Checkpoint 03',
            'location' => 'Location Checkpoint 03',
            'location_long_lat' => '104.735846710;-2.9588216',
            'qr_code' => 'AABBCC778899',
            'danger_status' => 'HIGH',
            'status' => 'INACTIVED',
            'round_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        CheckPoint::create([
            'name' => 'Checkpoint 04',
            'location' => 'Location Checkpoint 04',
            'location_long_lat' => '104.735846710;-2.9588216',
            'qr_code' => 'AABBCC005588',
            'danger_status' => 'HIGH',
            'status' => 'ACTIVED',
            'round_id' => 4,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
