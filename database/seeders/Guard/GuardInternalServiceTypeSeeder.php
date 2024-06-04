<?php

namespace Database\Seeders\Guard;

use App\Models\Guard\GuardInternalServiceType;
use Illuminate\Database\Seeder;

class GuardInternalServiceTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $data = [
             [
                 'name' => GuardInternalServiceType::TYPE_GATE_CHECK,
             ],
             [
                 'name' => GuardInternalServiceType::TYPE_TERRITORY_PATROL,
             ],
             [
                 'name' => GuardInternalServiceType::TYPE_SAFETY_CONTROL,
             ],
             [
                 'name' => GuardInternalServiceType::TYPE_EQUIPMENT_USE_CONTROL,
             ],
         ];

         foreach ($data as $item) {
             GuardInternalServiceType::create($item);
         }
    }
}
