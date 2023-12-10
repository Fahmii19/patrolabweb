<?php

namespace Database\Seeders;

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
            UserSeeder::class,
            WilayahSeeder::class,
            AreaSeeder::class,
            AsetSeeder::class,
            AssetUnsafeOptionSeeder::class,
            AssetClientCheckpointSeeder::class,
            AssetPatrolCheckpointSeeder::class,
            BranchSeeder::class,
            ProjectSeeder::class,
            RoundSeeder::class,
            CheckpointSeeder::class,
            ShiftSeeder::class,
            PletonSeeder::class,
            GuardSeeder::class,
        ]);
    }
}
