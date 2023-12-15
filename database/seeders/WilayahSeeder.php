<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wilayah::create([
            'kode' => 'kowil01',
            'nama' => 'Wilayah 01',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Wilayah::create([
            'kode' => 'kowil02',
            'nama' => 'Wilayah 02',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Wilayah::create([
            'kode' => 'kowil03',
            'nama' => 'Wilayah 03',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Wilayah::create([
            'kode' => 'kowil04',
            'nama' => 'Wilayah 04',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
