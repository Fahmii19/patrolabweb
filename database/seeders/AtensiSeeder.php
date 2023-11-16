<?php

namespace Database\Seeders;

use App\Models\Atensi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AtensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $atensis = [
            [
                'id_user' => 1,
                'id_wilayah' => 1,
                'id_project' => 1,
                'id_area' => 1,
                'judul_atensi' => 'Atensi 1',
                'prioritas' => 'High',
                'tanggal_mulai' => '2023-04-13 16:22:06',
                'tanggal_selesai' => '2023-04-13 16:22:09',
                'deskripsi' => 'Deskripsi Atensi',
                'created_at' => '2023-04-13 16:22:17',
                'updated_at' => '2023-04-13 16:22:20',
            ],
            [
                'id_user' => 1,
                'id_wilayah' => 2,
                'id_project' => 3,
                'id_area' => 1,
                'judul_atensi' => 'Atensi 2',
                'prioritas' => 'Low',
                'tanggal_mulai' => '2023-04-13 16:22:06',
                'tanggal_selesai' => '2023-04-13 16:22:09',
                'deskripsi' => 'Deskripsi Atensi',
                'created_at' => '2023-04-13 16:22:17',
                'updated_at' => '2023-04-13 16:22:20',
            ],
            [
                'id_user' => 1,
                'id_wilayah' => 1,
                'id_project' => 1,
                'id_area' => 1,
                'judul_atensi' => 'Atensi 3',
                'prioritas' => 'Medium',
                'tanggal_mulai' => '2023-04-12 16:22:06',
                'tanggal_selesai' => '2023-04-13 16:22:09',
                'deskripsi' => 'Deskripsi Atensi',
                'created_at' => '2023-04-13 16:22:17',
                'updated_at' => '2023-04-13 16:22:20',
            ],
        ];

        foreach ($atensis as $atensi) {
            Atensi::create($atensi);
        }
    }
}
