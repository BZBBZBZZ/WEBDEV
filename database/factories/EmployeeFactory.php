<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        $positions = [
            'Head Baker',
            'Pastry Chef',
            'Sales Assistant',
            'Manager',
            'Assistant Baker',
            'Cashier',
            'Kitchen Helper',
            'Store Supervisor',
        ];

        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement($positions),
            'image' => "https://picsum.photos/seed/" . uniqid() . "/400/400",
        ];
    }
}
