<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'code' => 'koranch01',
            'name' => 'Branch 01',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Branch::create([
            'code' => 'koranch02',
            'name' => 'Branch 02',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Branch::create([
            'code' => 'koranch03',
            'name' => 'Branch 03',
            'status' => 'INACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
