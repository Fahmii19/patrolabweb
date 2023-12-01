<?php

namespace Database\Seeders;

use App\Models\Aset;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Aset::create([
        //     'kode' => 'AS1',
        //     'nama' => 'Strada 4x4',
        //     'status' => 'Aktif',
        //     'created_at' => '2023-04-13 16:01:45',
        //     'updated_at' => '2023-04-13 16:01:47',
        // ]);

        // Aset::create([
        //     'kode' => 'AS2',
        //     'nama' => 'Fortuner',
        //     'status' => 'Aktif',
        //     'created_at' => '2023-04-13 16:02:47',
        //     'updated_at' => '2023-04-13 16:02:50',
        // ]);

        // Aset::create([
        //     'kode' => 'AS3',
        //     'nama' => 'Kawasaki KLX',
        //     'status' => 'Aktif',
        //     'created_at' => '2023-04-13 16:03:14',
        //     'updated_at' => '2023-04-13 16:03:16',
        // ]);

        Aset::create([
            'code' => 'koset01',
            'name' => 'Aset 01',
            'status' => 'ACTIVED',
            'asset_master_type' => 'PATROL',
            'short_desc' => 'Deskripsi singkat Aset 01',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Aset::create([
            'code' => 'koset02',
            'name' => 'Aset 02',
            'status' => 'INACTIVED',
            'asset_master_type' => 'PATROL',
            'short_desc' => 'Deskripsi singkat Aset 02',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Aset::create([
            'code' => 'koset03',
            'name' => 'Aset 03',
            'status' => 'ACTIVED',
            'asset_master_type' => 'CLIENT',
            'short_desc' => 'Deskripsi singkat Aset 03',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Aset::create([
            'code' => 'koset04',
            'name' => 'Aset 04',
            'status' => 'INACTIVED',
            'asset_master_type' => 'CLIENT',
            'short_desc' => 'Deskripsi singkat Aset 04',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
