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

        $user = User::create([
            'guard_id' => '1',
            'name' => 'agus',
            'no_badge' => '123456',
            'email' => 'agus@gmail.com',
            'password' => Hash::make('123456'),
            'status' => 'ACTIVED',
        ]);

        $super_admin->assignRole('super-admin');
        $user->assignRole('user');
    }
}
