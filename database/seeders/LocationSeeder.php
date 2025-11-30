<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::create([
            'name' => 'Main Store',
            'description' => 'Our flagship store with a cozy and warm atmosphere. Features a spacious bakery display area and comfortable seating for customers.',
            'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800',
        ]);

        Location::create([
            'name' => 'Kitchen Area',
            'description' => 'Professional kitchen where all our delicious baked goods are made fresh daily. Equipped with modern baking equipment and facilities.',
            'image' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800',
        ]);

        Location::create([
            'name' => 'Display Counter',
            'description' => 'Beautiful display counter showcasing our fresh pastries, cakes, and breads. Everything is arranged to make your choice easy and appealing.',
            'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800',
        ]);
    }
}
