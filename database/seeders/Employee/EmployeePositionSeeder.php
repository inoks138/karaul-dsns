<?php

namespace Database\Seeders\Employee;

use App\Models\Employee\EmployeePosition;
use Illuminate\Database\Seeder;

class EmployeePositionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $data = [
             [
                 'name' => EmployeePosition::POSITION_GUARD_CHIEF,
             ],
             [
                 'name' => EmployeePosition::POSITION_DISPATCHER,
             ],
             [
                 'name' => EmployeePosition::POSITION_SECRETARY,
             ],
             [
                 'name' => EmployeePosition::POSITION_FIREFIGHTER,
             ],
         ];

         foreach ($data as $item) {
             EmployeePosition::create($item);
         }
    }
}
