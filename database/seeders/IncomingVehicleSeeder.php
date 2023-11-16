<?php

namespace Database\Seeders;

use App\Models\IncomingVehicle;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IncomingVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IncomingVehicle::create([
            'id_wilayah' => '1',
            'id_project' => '1',
            'id_area' => '1',
            'gate_code' => 'GMPTG1',
            'lokasi' => 'Pintu Masuk Pertagas',
            'rfid_masuk' => 12334,
            'no_kartu' => 12334,
            'plat' => 'BM1234ABB',
            'pemilik_kartu' => 'Bhori',
            'status' => 'karyawan',
            'tanggal_masuk' => '2023-04-13 16:30:58',
            'foto_masuk' => 'foto.jpg',
        ]);

        IncomingVehicle::create([
            'id_wilayah' => '1',
            'id_project' => '1',
            'id_area' => '1',
            'gate_code' => 'GMPTG1',
            'lokasi' => 'Pintu Masuk Pertagas',
            'rfid_masuk' => 12334,
            'no_kartu' => 12334,
            'plat' => 'BM1233BU',
            'pemilik_kartu' => 'Edy',
            'status' => 'tamu',
            'tanggal_masuk' => '2023-04-13 16:30:58',
            'foto_masuk' => 'foto1.jpg',
        ]);
    }
}
