<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        $admin_area1 = User::create([
            'name' => 'Admin Area1',
            'access_area' => '1',
            'email' => 'admin.area1@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        $admin_area2 = User::create([
            'name' => 'Admin Area2',
            'access_area' => '2',
            'email' => 'admin.area2@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        $admin_area3 = User::create([
            'name' => 'Admin Area3',
            'access_area' => '1,2,3',
            'email' => 'admin.area@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        // Membuat seeder untuk guard dari user agus
        Guard::create([
            'badge_number' => '123',
            'name' => 'Guard Agus',
            'position' => 'Jabatan Agus',
            'img_avatar' => null,
            'dob' => '1999-01-01', //birth_date
            'gender' => 'MALE',
            'email' => 'agus@gmail.com',
            'wa' => '0123456789',
            'address' => 'Alamat Guard Agus',
            'shift_id' => 1,
            'pleton_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        $user = User::create([
            'guard_id' => '1',
            'no_badge' => '001',
            'name' => 'agus',
            'email' => 'agus@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        $super_admin->assignRole('super-admin');
        $admin_area1->assignRole('admin-area');
        $admin_area2->assignRole('admin-area');
        $admin_area3->assignRole('admin-area');
        $user->assignRole('user');
    }
}