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
            "address" => "Alamat Guard 01",
            "badge_number" => "001",
            "email" => "email1@guard.com",
            "gender" => "MALE",
            "img_avatar" => null,
            "name" => "Guard 01",
            "pleton_id" => 1,
            "dob" => "1999-01-01", //birth_date
            "shift_id" => 1,
            "password" => bcrypt("passwordGuard01"),
            "role" => "guard",
        ]);
        Guard::create([
            "address" => "Alamat Guard 02",
            "badge_number" => "002",
            "email" => "email2@guard.com",
            "gender" => "FEMALE",
            "img_avatar" => null,
            "name" => "Guard 02",
            "pleton_id" => 2,
            "dob" => "1999-02-02", //birth_date
            "shift_id" => 2,
            "password" => bcrypt("passwordGuard02"),
            "role" => "guard",
        ]);
    }

}
