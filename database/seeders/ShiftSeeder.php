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
                'nama' => 'Shift Pagi',
                'mulai' => '08:01:00',
                'selesai' => '14:00:00',
                'created_at' => '2023-04-13 16:14:36',
                'updated_at' => '2023-04-13 16:16:23'
            ],
            [
                'nama' => 'Shift Siang',
                'mulai' => '16:01:00',
                'selesai' => '00:00:00',
                'created_at' => '2023-04-13 16:15:25',
                'updated_at' => '2023-04-13 16:15:25'
            ],
            [
                'nama' => 'Shift Malam',
                'mulai' => '00:01:00',
                'selesai' => '08:00:00',
                'created_at' => '2023-04-13 16:15:53',
                'updated_at' => '2023-04-13 16:16:06'
            ],
        ]);
    }
}
