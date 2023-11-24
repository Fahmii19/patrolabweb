<?php

namespace Database\Seeders;

use App\Models\Round;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Whoops\Run;

class RoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Round::create([
            'id_wilayah' => 1,
            'id_project' => 1,
            'id_area' => 1,
            'rute' => 'Rute 01',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        Round::create([
            'id_wilayah' => 2,
            'id_project' => 3,
            'id_area' => 4,
            'rute' => 'Rute 02',
            'status' => 'tidak aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
