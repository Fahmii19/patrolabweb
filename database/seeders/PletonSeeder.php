<?php

namespace Database\Seeders;

use App\Models\Pleton;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PletonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pleton::create([
            "code" => "kode pleton 01",
            "name" => "Pleton 01",
            "status" => "ACTIVED",
            "area_id" => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        Pleton::create([
            "code" => "kode pleton 02",
            "name" => "Pleton 02",
            "status" => "ACTIVED",
            "area_id" => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        Pleton::create([
            "code" => "kode pleton 03",
            "name" => "Pleton 03",
            "status" => "ACTIVED",
            "area_id" => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        Pleton::create([
            "code" => "kode pleton 04",
            "name" => "Pleton 04",
            "status" => "ACTIVED",
            "area_id" => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        Pleton::create([
            "code" => "kode pleton 05",
            "name" => "Pleton 05",
            "status" => "ACTIVED",
            "area_id" => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        Pleton::create([
            "code" => "kode pleton 06",
            "name" => "Pleton 06",
            "status" => "ACTIVED",
            "area_id" => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
