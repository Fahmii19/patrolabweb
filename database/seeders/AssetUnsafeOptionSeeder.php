<?php

namespace Database\Seeders;

use App\Models\AssetUnsafeOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetUnsafeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetUnsafeOption::create([
            'option_condition' => 'Hilang',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        AssetUnsafeOption::create([
            'option_condition' => 'Rusak',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        AssetUnsafeOption::create([
            'option_condition' => 'Pencurian',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
