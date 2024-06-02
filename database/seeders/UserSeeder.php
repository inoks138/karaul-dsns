<?php

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $guardChiefs = [
            [
                'name' => 'Chief Guard 1',
                'email' => 'chief.guard+1@mail.com',
                'role_id' => Role::getGuardChiefId(),
                'employee_id' => Employee::search('Chief-1')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Chief Guard 2',
                'email' => 'chief.guard+2@mail.com',
                'role_id' => Role::getGuardChiefId(),
                'employee_id' => Employee::search('Chief-2')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Chief Guard 3',
                'email' => 'chief.guard+3@mail.com',
                'role_id' => Role::getGuardChiefId(),
                'employee_id' => Employee::search('Chief-3')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Chief Guard 4',
                'email' => 'chief.guard+4@mail.com',
                'role_id' => Role::getGuardChiefId(),
                'employee_id' => Employee::search('Chief-4')->first()->id,
                'password' => Hash::make('12345678'),
            ],
        ];
        $dispatchers = [
            [
                'name' => 'Dispatcher 1',
                'email' => 'dispatcher+1@mail.com',
                'role_id' => Role::getDispatcherId(),
                'employee_id' => Employee::search('Dispatcher-1')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Dispatcher 2',
                'email' => 'dispatcher+2@mail.com',
                'role_id' => Role::getDispatcherId(),
                'employee_id' => Employee::search('Dispatcher-2')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Dispatcher 3',
                'email' => 'dispatcher+3@mail.com',
                'role_id' => Role::getDispatcherId(),
                'employee_id' => Employee::search('Dispatcher-3')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Dispatcher 4',
                'email' => 'dispatcher+4@mail.com',
                'role_id' => Role::getDispatcherId(),
                'employee_id' => Employee::search('Dispatcher-4')->first()->id,
                'password' => Hash::make('12345678'),
            ],
        ];
        $secretaries = [
            [
                'name' => 'Secretary 1',
                'email' => 'secretary+1@mail.com',
                'role_id' => Role::getSecretaryId(),
                'employee_id' => Employee::search('Secretary-1')->first()->id,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Dispatcher 2',
                'email' => 'secretary+2@mail.com',
                'role_id' => Role::getSecretaryId(),
                'employee_id' => Employee::search('Secretary-2')->first()->id,
                'password' => Hash::make('12345678'),
            ],
        ];

        $data = array_merge(
            $guardChiefs,
            $dispatchers,
            $secretaries
        );

        foreach ($data as $item) {
            User::factory()->create($item);
        }
    }
}
