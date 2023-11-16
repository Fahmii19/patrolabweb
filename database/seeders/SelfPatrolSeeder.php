<?php

namespace Database\Seeders;

use App\Models\SelfPatrol;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SelfPatrolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SelfPatrol::create([
            'id_guard' => 1,
            'id_wilayah' => 1,
            'id_project' => 1,
            'id_area' => 1,
            'tanggal' => '2023-04-04',
            'status_lokasi' => 'aman',
            'deskripsi' => 'kondisi aman terkendali tidak ada indikasi',
            'foto' => '["self-patrol/1681357761-1.jpg", "self-patrol/1681357761-2.jpg"]',
            'created_at' => '2023-04-13 10:49:21',
            'updated_at' => '2023-04-13 10:49:21'
        ]);

        SelfPatrol::create([
            'id_guard' => 1,
            'id_wilayah' => 2,
            'id_project' => 3,
            'id_area' => 1,
            'tanggal' => '2023-04-04',
            'status_lokasi' => 'pencurian',
            'deskripsi' => '-',
            'foto' => '["self-patrol/1681357786-1.png"]',
            'created_at' => '2023-04-13 10:49:46',
            'updated_at' => '2023-04-13 10:49:46'
        ]);

        SelfPatrol::create([
            'id_guard' => 1,
            'id_wilayah' => 1,
            'id_project' => 1,
            'id_area' => 1,
            'tanggal' => '2023-04-04',
            'status_lokasi' => 'aman',
            'deskripsi' => '-',
            'foto' => null,
            'created_at' => '2023-04-13 11:54:42',
            'updated_at' => '2023-04-13 11:54:42'
        ]);
    }
}
