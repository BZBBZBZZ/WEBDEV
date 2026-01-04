<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $bakeryItems = [
            'Croissant',
            'Donut',
            'Bagel',
            'Muffin',
            'Cupcake',
            'Bread Roll',
            'Danish',
            'Eclair',
            'Pretzel',
            'Scone',
            'Tart',
            'Pie',
            'Cake',
            'Cookie',
            'Brownie',
            'Macaron',
            'Baguette',
            'Sourdough',
            'Cinnamon Roll',
            'Cheesecake',
            'Tiramisu',
            'Panettone',
            'Strudel',
            'Waffle'
        ];

        $name = $this->faker->randomElement($bakeryItems);

        return [
            'name' => $name,
            'image' => "https://picsum.photos/seed/" . uniqid() . "/640/480",
            'short_description' => $this->faker->sentence(10),
            'long_description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(15000, 50000),
            'weight' => $this->faker->numberBetween(80, 500) ,
        ];
    }
}
