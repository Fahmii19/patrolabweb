<?php

namespace Database\Seeders;

use App\Models\Round;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Whoops\Run;

class RoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Round::create([
            'name' => 'Round 01',
            'status' => 'ACTIVED',
            'patrol_area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        Round::create([
            'name' => 'Round 01',
            'status' => 'ACTIVED',
            'patrol_area_id' => 2,
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
