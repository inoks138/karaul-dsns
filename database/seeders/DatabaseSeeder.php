<?php

namespace Database\Seeders;

use Database\Seeders\Employee\EmployeePositionSeeder;
use Database\Seeders\Employee\EmployeeSeeder;
use Database\Seeders\Vehicle\VehicleModelSeeder;
use Database\Seeders\Vehicle\VehicleSeeder;
use Database\Seeders\Vehicle\VehicleTypeSeeder;
use Database\Seeders\Workplace\DetachmentSeeder;
use Database\Seeders\Workplace\FirehouseSeeder;
use Database\Seeders\Workplace\HeadquarterSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HeadquarterSeeder::class,
            DetachmentSeeder::class,
            FirehouseSeeder::class,
            EmployeePositionSeeder::class,
            EmployeeSeeder::class,
            VehicleTypeSeeder::class,
            VehicleModelSeeder::class,
            VehicleSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
