<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomOrder;

class CustomOrderSeeder extends Seeder
{
    public function run(): void
    {
        CustomOrder::create([
            'customer_name' => 'John Doe',
            'order_name' => '3-Tier Wedding Cake',
            'description' => 'White chocolate cake with vanilla frosting, decorated with fresh flowers. Should serve 100 people.',
            'status' => 'in_progress',
        ]);

        CustomOrder::create([
            'customer_name' => 'Jane Smith',
            'order_name' => 'Birthday Cake with Custom Design',
            'description' => 'Chocolate cake with buttercream frosting, custom superhero theme decoration for 7-year-old boy.',
            'status' => 'not_made',
        ]);

        CustomOrder::create([
            'customer_name' => 'Michael Johnson',
            'order_name' => 'Corporate Event Cupcakes',
            'description' => '200 assorted cupcakes for corporate event. Mix of vanilla, chocolate, and red velvet with company logo toppers.',
            'status' => 'finished',
        ]);

        CustomOrder::create([
            'customer_name' => 'Sarah Williams',
            'order_name' => 'Anniversary Cake',
            'description' => 'Two-tier red velvet cake with cream cheese frosting. Gold accents and "Happy 25th Anniversary" message.',
            'status' => 'not_made',
        ]);
    }
}
