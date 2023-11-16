<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'asset',
                'fitur' => 'menu',
                'name'  =>  'Menu Aset',
            ], 
            [
                'title' => 'asset',
                'fitur' => 'index',
                'name'  => 'Melihat data Aset',
            ],
            [
                'title' => 'asset',
                'fitur' => 'create',
                'name'  =>  'Membuat data Aset',
            ],
            [
                'title' => 'asset',
                'fitur' => 'edit',
                'name'  => 'Mengedit data Aset',
            ],
            [
                'title' => 'asset',
                'fitur' => 'show',
                'name'  => 'Melihat detail data Aset',
            ],
            [
                'title' => 'asset',
                'fitur' => 'destroy',
                'name'  => 'Menghapus data Aset',
            ]

        ];

        foreach ($data as $item) {
            Permission::create($item);
        }
    }
}
