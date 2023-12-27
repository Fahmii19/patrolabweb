<?php

namespace Database\Seeders;

use App\Models\NoticeBoard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticeBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NoticeBoard::create([
            'title' => 'Pengumuman 01',
            'description' => 'Deskripsi 01',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        NoticeBoard::create([
            'title' => 'Pengumuman 02',
            'description' => 'Deskripsi 02',
            'area_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        NoticeBoard::create([
            'title' => 'Pengumuman 03',
            'description' => 'Deskripsi 03',
            'area_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
