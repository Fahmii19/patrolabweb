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
            "code" => "koplet01",
            "name" => "Pleton 01",
            "status" => "ACTIVED",
            "area_id" => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Pleton::create([
            "code" => "koplet02",
            "name" => "Pleton 02",
            "status" => "ACTIVED",
            "area_id" => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Pleton::create([
            "code" => "koplet03",
            "name" => "Pleton 03",
            "status" => "ACTIVED",
            "area_id" => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Pleton::create([
            "code" => "koplet04",
            "name" => "Pleton 04",
            "status" => "ACTIVED",
            "area_id" => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
