<?php

namespace Database\Seeders;

use App\Models\AssetPatrolCheckpointLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetPatrolCheckpointLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetPatrolCheckpointLog::create([
            'asset_code_log' => 'code aset 01',
            'asset_name_log' => 'aset 01',
            'checkpoint_note_log' => 'note asset 1 checkpoint 1',
            'status' => 'SAFE',
            'patrol_checkpoint_log_id' => 1,
            'asset_patrol_checkpoint_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        AssetPatrolCheckpointLog::create([
            'asset_code_log' => 'code aset 02',
            'asset_name_log' => 'aset 02',
            'checkpoint_note_log' => 'note asset 2 checkpoint 1',
            'status' => 'UNSAFE',
            'asset_unsafe_option_id' => 2,
            'patrol_checkpoint_log_id' => 1,
            'asset_patrol_checkpoint_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        AssetPatrolCheckpointLog::create([
            'asset_code_log' => 'code aset 01',
            'asset_name_log' => 'aset 01',
            'checkpoint_note_log' => 'note asset 1 checkpoint 2',
            'status' => 'SAFE',
            'patrol_checkpoint_log_id' => 2,
            'asset_patrol_checkpoint_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        AssetPatrolCheckpointLog::create([
            'asset_code_log' => 'code aset 02',
            'asset_name_log' => 'aset 02',
            'checkpoint_note_log' => 'note asset 2 checkpoint 2',
            'status' => 'SAFE',
            'patrol_checkpoint_log_id' => 3,
            'asset_patrol_checkpoint_id' => 4,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        AssetPatrolCheckpointLog::create([
            'asset_code_log' => 'code aset 04',
            'asset_name_log' => 'aset 04',
            'checkpoint_note_log' => 'note asset 4 checkpoint 3',
            'status' => 'SAFE',
            'patrol_checkpoint_log_id' => 6,
            'asset_patrol_checkpoint_id' => 5,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
