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
        Aset::create([
            'code' => 'koset01',
            'name' => 'Aset 01',
            'status' => 'ACTIVED',
            'asset_master_type' => 'PATROL',
            'short_desc' => 'Deskripsi singkat Aset 01',
            'images' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Aset::create([
            'code' => 'koset02',
            'name' => 'Aset 02',
            'status' => 'INACTIVED',
            'asset_master_type' => 'PATROL',
            'short_desc' => 'Deskripsi singkat Aset 02',
            'images' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Aset::create([
            'code' => 'koset03',
            'name' => 'Aset 03',
            'status' => 'ACTIVED',
            'asset_master_type' => 'CLIENT',
            'short_desc' => 'Deskripsi singkat Aset 03',
            'images' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Aset::create([
            'code' => 'koset04',
            'name' => 'Aset 04',
            'status' => 'INACTIVED',
            'asset_master_type' => 'CLIENT',
            'short_desc' => 'Deskripsi singkat Aset 04',
            'images' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
