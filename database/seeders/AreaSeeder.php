<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'kode' => 'AREA001',
            'nama' => 'ZAMRUD',
            'id_project' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
