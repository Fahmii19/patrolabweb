<?php

namespace Database\Seeders;

use App\Models\CheckpointAssetClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetClientCheckpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CheckpointAssetClient::create([
            'asset_master_id' => 3,
            'checkpoint_id' => 1,
            'checkpoint_note' => 'note asset client 3',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
        CheckpointAssetClient::create([
            'asset_master_id' => 4,
            'checkpoint_id' => 2,
            'checkpoint_note' => 'note asset client 4',
            'status' => 'ACTIVED',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
