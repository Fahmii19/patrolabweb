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

        $admin_area = User::create([
            'name' => 'Admin Area',
            'access_area' => '1,2',
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
        $admin_area->assignRole('admin-area');
        $user->assignRole('user');
    }
}