<?php

namespace Database\Seeders\Emergency;

use App\Models\Emergency\EmergencyType;
use Illuminate\Database\Seeder;

class EmergencyTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $data = [
             [
                 'name' => EmergencyType::TYPE_FIRE,
             ],
             [
                 'name' => EmergencyType::TYPE_TRAINING,
             ],
             [
                 'name' => EmergencyType::TYPE_DROWNING,
             ],
             [
                 'name' => EmergencyType::TYPE_TYPHOON,
             ],
             [
                 'name' => EmergencyType::TYPE_STORM,
             ],
             [
                 'name' => EmergencyType::TYPE_HURRICANE,
             ],
             [
                 'name' => EmergencyType::TYPE_SEARCH_WORKS,
             ],
             [
                 'name' => EmergencyType::TYPE_POLICE_ASSISTANCE,
             ],
             [
                 'name' => EmergencyType::TYPE_TERRORISTIC_ATTACK,
             ],
             [
                 'name' => EmergencyType::TYPE_MINE_CLEARANCE,
             ],
             [
                 'name' => EmergencyType::TYPE_POPULATION_MOVEMENT,
             ],
         ];

         foreach ($data as $item) {
             EmergencyType::create($item);
         }
    }
}
