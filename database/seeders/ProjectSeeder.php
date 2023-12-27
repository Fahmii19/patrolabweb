<?php

namespace Database\Seeders;

use App\Models\ProjectModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectModel::create([
            'code' => 'kojek01',
            'name' => 'Proyek 01',
            'city_id' => 1,
            'branch_id' => 1,
            'address' => 'Lokasi Proyek 01',
            'location_long_lat' => '104.756554;-2.990934',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        ProjectModel::create([
            'code' => 'kojek02',
            'name' => 'Proyek 02',
            'city_id' => 1,
            'branch_id' => 1,
            'address' => 'Lokasi Proyek 02',
            'location_long_lat' => '104.756554;-2.990934',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        ProjectModel::create([
            'code' => 'kojek03',
            'name' => 'Proyek 03',
            'city_id' => 1,
            'branch_id' => 1,
            'address' => 'Lokasi Proyek 03',
            'location_long_lat' => '104.756554;-2.990934',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
