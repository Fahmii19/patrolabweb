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
            'code' => 'kowil01',
            'name' => 'Wilayah 01',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Wilayah::create([
            'code' => 'kowil02',
            'name' => 'Wilayah 02',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Wilayah::create([
            'code' => 'kowil03',
            'name' => 'Wilayah 03',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Wilayah::create([
            'code' => 'kowil04',
            'name' => 'Wilayah 04',
            'province_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
