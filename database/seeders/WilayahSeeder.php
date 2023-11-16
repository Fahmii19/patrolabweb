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
            'kode' => 'WIL001',
            'nama' => 'RIAU',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Wilayah::create([
            'kode' => 'WIL002',
            'nama' => 'JAKARTA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
