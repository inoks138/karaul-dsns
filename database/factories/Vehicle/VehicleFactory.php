<?php

namespace Database\Factories\Vehicle;

use App\Models\Employee\EmployeePosition;
use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class VehicleFactory extends Factory
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
            'vehicle_model_id' => 1,
            'firehouse_id' => 1,
            'license_plate' => fake()->unique()->text('8'),
        ];
    }
}
