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
            'id' => 'asetpatrolcheckpointlog-id01',
            'asset_code_log' => 'code aset 01',
            'asset_name_log' => 'aset 01',
            'checkpoint_note_log' => 'note asset 1 checkpoint 1',
            'status' => 'SAFE',
            'asset_unsafe_option_log' => 'safe',
            'patrol_checkpoint_log_id' => 'patrolcheckpoint-id01',
            'asset_patrol_checkpoint_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        AssetPatrolCheckpointLog::create([
            'id' => 'asetpatrolcheckpointlog-id02',
            'asset_code_log' => 'code aset 02',
            'asset_name_log' => 'aset 02',
            'checkpoint_note_log' => 'note asset 2 checkpoint 1',
            'status' => 'UNSAFE',
            'asset_unsafe_option_log' => 'Rusak',
            'asset_unsafe_option_id' => 2,
            'patrol_checkpoint_log_id' => 'patrolcheckpoint-id01',
            'asset_patrol_checkpoint_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        AssetPatrolCheckpointLog::create([
            'id' => 'asetpatrolcheckpointlog-id03',
            'asset_code_log' => 'code aset 01',
            'asset_name_log' => 'aset 01',
            'checkpoint_note_log' => 'note asset 1 checkpoint 2',
            'status' => 'SAFE',
            'asset_unsafe_option_log' => 'safe',
            'patrol_checkpoint_log_id' => 'patrolcheckpoint-id02',
            'asset_patrol_checkpoint_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        AssetPatrolCheckpointLog::create([
            'id' => 'asetpatrolcheckpointlog-id04',
            'asset_code_log' => 'code aset 02',
            'asset_name_log' => 'aset 02',
            'checkpoint_note_log' => 'note asset 2 checkpoint 2',
            'status' => 'SAFE',
            'asset_unsafe_option_log' => 'safe',
            'patrol_checkpoint_log_id' => 'patrolcheckpoint-id03',
            'asset_patrol_checkpoint_id' => 4,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        AssetPatrolCheckpointLog::create([
            'id' => 'asetpatrolcheckpointlog-id05',
            'asset_code_log' => 'code aset 04',
            'asset_name_log' => 'aset 04',
            'checkpoint_note_log' => 'note asset 4 checkpoint 3',
            'status' => 'SAFE',
            'asset_unsafe_option_log' => 'safe',
            'patrol_checkpoint_log_id' => 'patrolcheckpoint-id06',
            'asset_patrol_checkpoint_id' => 5,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
