<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        // Ensure faker is initialized
        if (!$this->faker) {
            $this->faker = app(Faker::class);
        }

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
