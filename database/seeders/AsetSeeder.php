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
            'kode' => 'AS1',
            'nama' => 'Strada 4x4',
            'status' => 'Aktif',
            'created_at' => '2023-04-13 16:01:45',
            'updated_at' => '2023-04-13 16:01:47',
        ]);

        Aset::create([
            'kode' => 'AS2',
            'nama' => 'Fortuner',
            'status' => 'Aktif',
            'created_at' => '2023-04-13 16:02:47',
            'updated_at' => '2023-04-13 16:02:50',
        ]);

        Aset::create([
            'kode' => 'AS3',
            'nama' => 'Kawasaki KLX',
            'status' => 'Aktif',
            'created_at' => '2023-04-13 16:03:14',
            'updated_at' => '2023-04-13 16:03:16',
        ]);
    }
}
