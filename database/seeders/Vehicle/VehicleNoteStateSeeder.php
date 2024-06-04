<?php

namespace Database\Seeders\Vehicle;

use App\Models\Vehicle\VehicleNoteState;
use Illuminate\Database\Seeder;

class VehicleNoteStateSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => VehicleNoteState::STATE_OPERATIONAL_CALCULATION,
            ],
            [
                'name' => VehicleNoteState::STATE_RESERVE,
            ],
            [
                'name' => VehicleNoteState::STATE_REPAIR,
            ],
            [
                'name' => VehicleNoteState::STATE_CONSERVATION,
            ],
            [
                'name' => VehicleNoteState::STATE_OTHER,
            ],
        ];

        foreach ($data as $item) {
            VehicleNoteState::create([
                'name' => $item['name'],
            ]);
        }
    }
}
