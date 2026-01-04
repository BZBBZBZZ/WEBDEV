<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $bakeryItems = [
            'Croissant', 'Donut', 'Bagel', 'Muffin', 'Cupcake',
            'Bread Roll', 'Danish', 'Eclair', 'Pretzel', 'Scone',
            'Tart', 'Pie', 'Cake', 'Cookie', 'Brownie',
            'Macaron', 'Baguette', 'Sourdough', 'Cinnamon Roll',
            'Cheesecake', 'Tiramisu', 'Panettone', 'Strudel', 'Waffle'
        ];

        $adjectives = [
            'Premium', 'Delicious', 'Fresh', 'Artisan', 'Homemade',
            'Classic', 'Special', 'Golden', 'Crispy', 'Soft'
        ];

        $name = Arr::random($adjectives) . ' ' . Arr::random($bakeryItems);

        $shortDescriptions = [
            'Freshly baked with premium ingredients.',
            'Made daily with love and care.',
            'Traditional recipe with modern twist.',
            'Perfect for breakfast or snack time.',
            'Soft, fluffy, and delicious.',
            'Crispy outside, tender inside.',
            'A timeless favorite for all ages.',
            'Rich flavors in every bite.',
        ];

        $longDescriptions = [
            'Our signature product made with the finest ingredients sourced locally. Each piece is carefully crafted by our experienced bakers to ensure consistent quality and taste.',
            'A perfect blend of traditional baking methods and modern techniques. This product has been a customer favorite for years.',
            'Handcrafted daily in small batches to maintain freshness and quality. Made without preservatives or artificial flavors.',
            'Experience the authentic taste that has made us famous. Every bite delivers satisfaction and happiness.',
        ];

        return [
            'name' => $name,
            'image' => "https://picsum.photos/seed/" . uniqid() . "/640/480",
            'short_description' => Arr::random($shortDescriptions),
            'long_description' => Arr::random($longDescriptions),
            'price' => Arr::random([15000, 18000, 20000, 22000, 25000, 28000, 30000, 35000, 40000, 45000, 50000]),
            'weight' => rand(80, 500),
        ];
    }
}
