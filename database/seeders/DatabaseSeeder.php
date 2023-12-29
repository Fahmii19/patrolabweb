<?php

namespace Database\Seeders;

use App\Models\PatrolCheckpointLog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            BranchSeeder::class,
            ProjectSeeder::class,
            AreaSeeder::class,
            PatrolAreaSeeder::class,
            PatrolAreaDescriptionSeeder::class,
            NoticeBoardSeeder::class,
            GateSeeder::class,
            ShiftSeeder::class,
            PletonSeeder::class,
            PletonPatrolSeeder::class,
            UserSeeder::class,
            GuardSeeder::class,
            AsetSeeder::class,
            AssetUnsafeOptionSeeder::class,
            RoundSeeder::class,
            CheckpointSeeder::class,
            AssetClientCheckpointSeeder::class,
            AssetPatrolCheckpointSeeder::class,
            PatrolCheckpointLogSeeder::class,
            AssetPatrolCheckpointLogSeeder::class
        ]);
    }
}
