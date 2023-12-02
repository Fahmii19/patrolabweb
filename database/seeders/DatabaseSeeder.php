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
            BranchSeeder::class,
            ProjectSeeder::class,
            RoundSeeder::class,
            CheckpointSeeder::class,
        ]);
    }
}
