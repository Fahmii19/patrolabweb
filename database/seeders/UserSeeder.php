<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'super-admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
        ]);

        $admin_area = User::create([
            'name' => 'admin-area',
            'access_area' => '1,2',
            'email' => 'admin.area@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
        ]);

        $user = User::create([
            'guard_id' => '1',
            'name' => 'agus',
            'email' => 'agus@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
        ]);

        $super_admin->assignRole('super-admin');
        $admin_area->assignRole('admin-area');
        $user->assignRole('user');
    }
}