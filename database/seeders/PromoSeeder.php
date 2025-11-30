<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use App\Models\Product;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promo1 = Promo::create([
            'name' => 'Weekend Special',
            'discount_percentage' => 20,
            'start_date' => Carbon::now()->subDays(1),
            'end_date' => Carbon::now()->addDays(7),
        ]);

        $promo2 = Promo::create([
            'name' => 'Flash Sale',
            'discount_percentage' => 30,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(3),
        ]);

        $promo3 = Promo::create([
            'name' => 'Holiday Discount',
            'discount_percentage' => 15,
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(14),
        ]);

        $products = Product::all();
        
        if ($products->count() >= 3) {
            $promo1->products()->attach($products->random(2)->pluck('id'));
            $promo2->products()->attach($products->random(3)->pluck('id'));
            $promo3->products()->attach($products->random(2)->pluck('id'));
        }
    }
}
