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
        // $guard = 
        // Guard::create([
        //     'no_badge' => '123456',
        //     'nama' => 'AGUS',
        //     'ttl' => '1990-01-01',
        //     'jenis_kelamin' => 'laki-laki',
        //     'email' => 'agus@gmail.com',
        //     'wa' => '08123456789',
        //     'alamat' => 'Jl. Raya',
        //     'id_wilayah' => 1,
        //     'id_area' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Guard::create([
        //     'no_badge' => '654321',
        //     'nama' => 'YUDI',
        //     'ttl' => '1990-01-01',
        //     'jenis_kelamin' => 'laki-laki',
        //     'email' => 'yudi@gmail.com',
        //     'wa' => '0812431313',
        //     'alamat' => 'Jl. Rumah',
        //     'id_wilayah' => 1,
        //     'id_area' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // PivotGuardProject::create([
        //     'id_guard' => $guard->id,
        //     'id_project' => 1
        // ]);
        Guard::create([
            'badge_number' => '001',
            'name' => 'Guard 01',
            'img_avatar' => null,
            'dob' => '1999-01-01', //birth_date
            'gender' => 'MALE',
            'email' => 'guard01@gmail.com',
            'wa' => '01234567891',
            'address' => 'Alamat Guard 01',
            'shift_id' => 1,
            'pleton_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Guard::create([
            'badge_number' => '002',
            'name' => 'Guard 02',
            'img_avatar' => null,
            'dob' => '1999-02-02', //birth_date
            'gender' => 'MALE',
            'email' => 'guard02@gmail.com',
            'wa' => '01234567892',
            'address' => 'Alamat Guard 02',
            'shift_id' => 2,
            'pleton_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        Guard::create([
            'badge_number' => '003',
            'name' => 'Guard 03',
            'img_avatar' => null,
            'dob' => '1999-03-03', //birth_date
            'gender' => 'FEMALE',
            'email' => 'guard03@gmail.com',
            'wa' => '01234567893',
            'address' => 'Alamat Guard 03',
            'shift_id' => 3,
            'pleton_id' => 4,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }

}
