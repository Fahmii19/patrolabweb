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
            "name" => "Gate 01",
            "status" => "ACTIVED",
            "project_id" => 1,
            "created_at" => now(),
            "updated_at" => null,
        ]);
        Gate::create([
            "name" => "Gate 02",
            "status" => "ACTIVED",
            "project_id" => 1,
            "created_at"  => now(),
            "updated_at" => null,
        ]);
        Gate::create([
            "name" => "Gate 03",
            "status" => "ACTIVED",
            "project_id" => 2,
            "created_at"  => now(),
            "updated_at" => null,
        ]);
        Gate::create([
            "name" => "Gate 04",
            "status" => "ACTIVED",
            "project_id" => 2,
            "created_at"  => now(),
            "updated_at" => null,
        ]);
    }
}
