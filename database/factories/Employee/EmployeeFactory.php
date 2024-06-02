<?php

namespace Database\Factories\Employee;

use App\Models\Employee\EmployeePosition;
use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EmployeeFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstNameMale(),
            'last_name' => fake()->lastName('male'),
            'patronymic' => 'A',
            'workplace_id' => 1,
            'workplace_type' => Firehouse::class,
            'can_be_unit_driver' => false,
            'can_be_unit_commander' => false,
            'position_id' => EmployeePosition::getFirefighterId(),
        ];
    }

    public function unitDriver(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'can_be_unit_driver' => true,
            ];
        });
    }

    public function unitCommander(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'can_be_unit_commander' => true,
            ];
        });
    }
}
