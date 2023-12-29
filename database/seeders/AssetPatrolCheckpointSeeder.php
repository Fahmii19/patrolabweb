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
            'checkpoint_note' => 'note asset 1 checkpoint 1',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        CheckpointAssetPatrol::create([
            'asset_master_id' => 2,
            'checkpoint_id' => 1,
            'checkpoint_note' => 'note asset 2 checkpoint 1',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        CheckpointAssetPatrol::create([
            'asset_master_id' => 1,
            'checkpoint_id' => 2,
            'checkpoint_note' => 'note asset 1 checkpoint 2',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        CheckpointAssetPatrol::create([
            'asset_master_id' => 2,
            'checkpoint_id' => 2,
            'checkpoint_note' => 'note asset 2 checkpoint 2',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        CheckpointAssetPatrol::create([
            'asset_master_id' => 4,
            'checkpoint_id' => 3,
            'checkpoint_note' => 'note asset 4 checkpoint 3',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
