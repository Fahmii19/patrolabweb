<?php

namespace Database\Seeders;

use App\Models\PatrolCheckpointLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrolCheckpointLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatrolCheckpointLog::create([
            'created_by' => 3,
            'pleton_id' => 1,
            'shift_id' => 1,
            'checkpoint_id' => 1,
            'business_date' => date('Y-m-d', strtotime('2023-12-19')),
            'shift_start_time_log' => date('H:i:s', strtotime('23:59:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('09:01:00')),
            'checkpoint_name_log' => 'Checkpoint 01',
            'checkpoint_location_log' => 'Location Checkpoint 01',
            'checkpoint_location_long_lat_log' => '123;456',
            'checkpoint_location_long_lat' => '123;456',
            'created_at' => date('Y-m-d H:i:s', strtotime('2023-12-20 23:59:00')),
            'updated_at' => null,
        ]);

        PatrolCheckpointLog::create([
            'created_by' => 3,
            'pleton_id' => 2,
            'shift_id' => 2,
            'checkpoint_id' => 2,
            'business_date' => date('Y-m-d', strtotime('2023-12-20')),
            'shift_start_time_log' => date('H:i:s', strtotime('09:05:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('17:01:00')),
            'checkpoint_name_log' => 'Checkpoint 02',
            'checkpoint_location_log' => 'Location Checkpoint 02',
            'checkpoint_location_long_lat_log' => '456;789',
            'checkpoint_location_long_lat' => '456;789',
            'created_at' => date('Y-m-d H:i:s', strtotime('2023-12-20 09:05:00')),
            'updated_at' => null,
        ]);

        PatrolCheckpointLog::create([
            'created_by' => 3,
            'pleton_id' => 3,
            'shift_id' => 1,
            'checkpoint_id' => 1,
            'business_date' => date('Y-m-d', strtotime('2023-12-21')),
            'shift_start_time_log' => date('H:i:s', strtotime('23:59:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('09:01:00')),
            'checkpoint_name_log' => 'Checkpoint 01',
            'checkpoint_location_log' => 'Location Checkpoint 01',
            'checkpoint_location_long_lat_log' => '123;456',
            'checkpoint_location_long_lat' => '123;456',
            'created_at' => date('Y-m-d H:i:s', strtotime('2023-12-21 23:59:00')),
            'updated_at' => null,
        ]);

        PatrolCheckpointLog::create([
            'created_by' => 3,
            'pleton_id' => 4,
            'shift_id' => 2,
            'checkpoint_id' => 2,
            'business_date' => date('Y-m-d', strtotime('2023-12-21')),
            'shift_start_time_log' => date('H:i:s', strtotime('09:07:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('17:10:00')),
            'checkpoint_name_log' => 'Checkpoint 02',
            'checkpoint_location_log' => 'Location Checkpoint 02',
            'checkpoint_location_long_lat_log' => '456;789',
            'checkpoint_location_long_lat' => '456;789',
            'created_at' => date('Y-m-d H:i:s', strtotime('2023-12-21 09:10:00')),
            'updated_at' => null,
        ]);

        PatrolCheckpointLog::create([
            'created_by' => 3,
            'pleton_id' => 4,
            'shift_id' => 3,
            'checkpoint_id' => 3,
            'business_date' => date('Y-m-d', strtotime('2023-12-22')),
            'shift_start_time_log' => date('H:i:s', strtotime('23:59:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('09:01:00')),
            'checkpoint_name_log' => 'Checkpoint 03',
            'checkpoint_location_log' => 'Location Checkpoint 03',
            'checkpoint_location_long_lat_log' => '789;123',
            'checkpoint_location_long_lat' => '789;123',
            'created_at' => date('Y-m-d H:i:s', strtotime('2023-12-22 23:59:00')),
            'updated_at' => null,
        ]);
    }
}
