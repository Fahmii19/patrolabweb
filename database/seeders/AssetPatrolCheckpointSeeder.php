<?php

namespace Database\Seeders;

use App\Models\CheckpointAssetPatrol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetPatrolCheckpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckpointAssetPatrol::create([
            'asset_master_id' => 1,
            'checkpoint_id' => 1,
            'checkpoint_note' => 'note asset patrol 1',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
