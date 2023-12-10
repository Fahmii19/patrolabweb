<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shift')->insert([
            [
                'name' => 'Shift Pagi',
                'start_time' => '08:01:00',
                'end_time' => '16:00:00',
                'created_at' => now(),
                'updated_at' => null
            ],
            [
                'name' => 'Shift Siang',
                'start_time' => '16:01:00',
                'end_time' => '00:00:00',
                'created_at' => now(),
                'updated_at' => null
            ],
            [
                'name' => 'Shift Malam',
                'start_time' => '00:01:00',
                'end_time' => '08:00:00',
                'created_at' => now(),
                'updated_at' => null
            ],
        ]);
    }
}
