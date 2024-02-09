<?php

namespace Database\Seeders;

use App\Models\PatrolAccidentalLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrolAccidentalLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatrolAccidentalLog::create([
            'id' => 'patrolaccidentallog-id01',
            'accidental_location' => 'Lokasi self patrol 01',
            'accidental_long_lat_log' => '123;456',
            'description' => 'deskripsi self patrol 1',
            'images' => '170494756701184c9aa5c2bc044fa91d22881208b7d01.png',
            'location_condition_log' => 'kondisi lokasi 01',
            'shift_start_time_log' => date('H:i:s', strtotime('23:59:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('23:59:00')),
            'guard_id' => 1,
            'location_condition_option_id' => 1,
            'pleton_id' => 2,
            'shift_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        PatrolAccidentalLog::create([
            'id' => 'patrolaccidentallog-id02',
            'accidental_location' => 'Lokasi self patrol 02',
            'accidental_long_lat_log' => '456;789',
            'description' => 'deskripsi self patrol 2',
            'images' => '1704945869329898abd7bdfa14994aebdb23c4dca9e09.png',
            'location_condition_log' => 'kondisi lokasi 02',
            'shift_start_time_log' => date('H:i:s', strtotime('23:59:00')),
            'shift_end_time_log' => date('H:i:s', strtotime('23:59:00')),
            'guard_id' => 2,
            'location_condition_option_id' => 2,
            'pleton_id' => 3,
            'shift_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
