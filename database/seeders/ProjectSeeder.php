<?php

namespace Database\Seeders;

use App\Models\ProjectModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectModel::create([
            'nama_project' => 'PERTAGAS',
            'wilayah' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProjectModel::create([
            'nama_project' => 'PERTAMINA',
            'wilayah' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProjectModel::create([
            'nama_project' => 'PARKIR 1',
            'wilayah' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
