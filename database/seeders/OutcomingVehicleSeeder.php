<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutcomingVehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OutcomingVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OutcomingVehicle::create([
            'id_wilayah' => '1',
            'id_project' => '1',
            'id_area' => '1',
            'gate_code' => 'GMPTG1',
            'lokasi' => 'Pintu Keluar Pertagas',
            'rfid_keluar' => 12334,
            'no_kartu' => 12334,
            'plat' => 'BM1234ABB',
            'pemilik_kartu' => 'Bhori',
            'status' => 'karyawan',
            'tanggal_keluar' => '2023-04-13 16:30:58',
            'foto_keluar' => 'foto.jpg',
        ]);

        OutcomingVehicle::create([
            'id_wilayah' => '1',
            'id_project' => '1',
            'id_area' => '1',
            'gate_code' => 'GMPTG1',
            'lokasi' => 'Pintu Keluar Pertagas',
            'rfid_keluar' => 12334,
            'no_kartu' => 12334,
            'plat' => 'BM1233BU',
            'pemilik_kartu' => 'Edy',
            'status' => 'tamu',
            'tanggal_keluar' => '2023-04-13 16:30:58',
            'foto_keluar' => 'foto1.jpg',
        ]);
    }
}
