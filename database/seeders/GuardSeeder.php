<?php

namespace Database\Seeders;

use App\Models\Guard;
use Illuminate\Database\Seeder;
use App\Models\PivotGuardProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard = 
        Guard::create([
            'no_badge' => '123456',
            'nama' => 'AGUS',
            'ttl' => '1990-01-01',
            'jenis_kelamin' => 'laki-laki',
            'email' => 'agus@gmail.com',
            'wa' => '08123456789',
            'alamat' => 'Jl. Raya',
            'id_wilayah' => 1,
            'id_area' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Guard::create([
            'no_badge' => '654321',
            'nama' => 'YUDI',
            'ttl' => '1990-01-01',
            'jenis_kelamin' => 'laki-laki',
            'email' => 'yudi@gmail.com',
            'wa' => '0812431313',
            'alamat' => 'Jl. Rumah',
            'id_wilayah' => 1,
            'id_area' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PivotGuardProject::create([
            'id_guard' => $guard->id,
            'id_project' => 1
        ]);

    }

}
