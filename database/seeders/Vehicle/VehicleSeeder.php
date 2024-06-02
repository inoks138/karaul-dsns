<?php

namespace Database\Seeders\Vehicle;

use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\VehicleModel;
use App\Models\Vehicle\VehicleType;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Vehicle::factory()->count(2)->create([
            'vehicle_model_id' => VehicleModel::where('name', 'АЦ-40 (43118)-235')->first()->id,
        ]);
        Vehicle::factory()->create([
            'vehicle_model_id' => VehicleModel::where('name', 'АЦ-60 (65111)-264.01')->first()->id,
        ]);
        Vehicle::factory()->create([
            'vehicle_model_id' => VehicleModel::where('name', 'АД-30 (131) ПМ 506')->first()->id,
        ]);
        Vehicle::factory()->create([
            'vehicle_model_id' => VehicleModel::where('name', 'ПНС–110 (43114)–140')->first()->id,
        ]);
    }
}
