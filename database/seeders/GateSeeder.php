<?php

namespace Database\Seeders;

use App\Models\Gate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gate::create([
            "code" => "koget01",
            "name" => "Gate 01",
            "status" => "ACTIVED",
            "patrol_area_id" => 1,
            "created_at" => now(),
            "updated_at" => null,
        ]);
        Gate::create([
            "code" => "koget02",
            "name" => "Gate 02",
            "status" => "ACTIVED",
            "patrol_area_id" => 1,
            "created_at"  => now(),
            "updated_at" => null,
        ]);
        Gate::create([
            "code" => "koget03",
            "name" => "Gate 03",
            "status" => "ACTIVED",
            "patrol_area_id" => 2,
            "created_at"  => now(),
            "updated_at" => null,
        ]);
        Gate::create([
            "code" => "koget04",
            "name" => "Gate 04",
            "status" => "ACTIVED",
            "patrol_area_id" => 2,
            "created_at"  => now(),
            "updated_at" => null,
        ]);
    }
}
