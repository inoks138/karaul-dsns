<?php

namespace Database\Seeders\Vehicle;

use App\Models\Vehicle\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $data = [
             [
                 'name' => VehicleType::TYPE_GENERAL,
             ],
             [
                 'name' => VehicleType::TYPE_LADDER,
             ],
             [
                 'name' => VehicleType::TYPE_SUPPORT,
             ],
         ];

         foreach ($data as $item) {
             VehicleType::create($item);
         }
    }
}
