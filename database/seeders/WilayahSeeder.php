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
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Wilayah::create([
            'kode' => 'kowil02',
            'nama' => 'Wilayah 02',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Wilayah::create([
            'kode' => 'kowil03',
            'nama' => 'Wilayah 03',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Wilayah::create([
            'kode' => 'kowil04',
            'nama' => 'Wilayah 04',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
