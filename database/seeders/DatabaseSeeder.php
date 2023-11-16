<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AreaSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GuardSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\WilayahSeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(WilayahSeeder::class);
        // $this->call(ProjectSeeder::class);
        // $this->call(AreaSeeder::class);
        // $this->call(GuardSeeder::class);
        // $this->call(SelfPatrolSeeder::class);
        // $this->call(AsetSeeder::class);
        // $this->call(ShiftSeeder::class);
        // $this->call(AtensiSeeder::class);
        // $this->call(IncomingVehicleSeeder::class);
        // $this->call(OutcomingVehicleSeeder::class);
        
       
    }
}
