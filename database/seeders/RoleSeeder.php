<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $data = [
             [
                 'name' => Role::ROLE_GUARD_CHIEF,
             ],
             [
                 'name' => Role::ROLE_DISPATCHER,
             ],
             [
                 'name' => Role::ROLE_SECRETARY,
             ],
         ];

         foreach ($data as $item) {
             Role::create($item);
         }
    }
}
