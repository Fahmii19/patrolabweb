<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::create([
            'name' => 'Province 01',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        Province::create([
            'name' => 'Province 02',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Province::create([
            'name' => 'Province 03',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Province::create([
            'name' => 'Province 04',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
