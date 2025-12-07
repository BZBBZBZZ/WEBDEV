<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        
        for ($i = 0; $i < 130; $i++) {
            Product::factory()->create([
                'category_id' => $categories->random()->id
            ]);
        }
        $manualProducts = [
            [
                'name' => 'Red Velvet Cake',
                'image' => 'https://picsum.photos/seed/redvelvet/640/480',
                'short_description' => 'Moist red velvet cake with cream cheese frosting.',
                'long_description' => 'Our signature red velvet cake is made with premium cocoa and topped with rich cream cheese frosting. Perfect for special occasions.',
                'price' => 45000.00,
                'weight' => 500,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Chocolate Croissant',
                'image' => 'https://picsum.photos/seed/croissant/640/480',
                'short_description' => 'Buttery croissant filled with rich chocolate.',
                'long_description' => 'Flaky, buttery croissant with premium dark chocolate filling. Baked fresh daily.',
                'price' => 25000.00,
                'weight' => 150,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Cheese Danish',
                'image' => 'https://picsum.photos/seed/danish/640/480',
                'short_description' => 'Sweet danish pastry with creamy cheese filling.',
                'long_description' => 'Traditional danish pastry with smooth cream cheese filling and a light glaze.',
                'price' => 22000.00,
                'weight' => 200,
                'category_id' => $categories->where('name', 'Asin')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Blueberry Muffin',
                'image' => 'https://picsum.photos/seed/muffin/640/480',
                'short_description' => 'Fresh blueberry muffin with vanilla essence.',
                'long_description' => 'Moist vanilla muffin packed with fresh blueberries. A perfect breakfast treat.',
                'price' => 18000.00,
                'weight' => 180,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Garlic Bread',
                'image' => 'https://picsum.photos/seed/garlicbread/640/480',
                'short_description' => 'Crispy bread with aromatic garlic butter.',
                'long_description' => 'Fresh baked bread slices topped with our special garlic butter blend and herbs.',
                'price' => 15000.00,
                'weight' => 250,
                'category_id' => $categories->where('name', 'Gurih')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Lemon Tart',
                'image' => 'https://picsum.photos/seed/lemontart/640/480',
                'short_description' => 'Tangy lemon tart with crispy pastry base.',
                'long_description' => 'Refreshing lemon curd filling in a buttery pastry shell, topped with meringue.',
                'price' => 35000.00,
                'weight' => 180,
                'category_id' => $categories->where('name', 'Asam')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Spicy Sambal Bread',
                'image' => 'https://picsum.photos/seed/sambalbread/640/480',
                'short_description' => 'Traditional bread with spicy sambal topping.',
                'long_description' => 'Soft bread topped with authentic Indonesian sambal for those who love spicy flavors.',
                'price' => 20000.00,
                'weight' => 220,
                'category_id' => $categories->where('name', 'Pedas')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Vanilla Eclair',
                'image' => 'https://picsum.photos/seed/eclair/640/480',
                'short_description' => 'Classic eclair filled with vanilla pastry cream.',
                'long_description' => 'Light choux pastry filled with smooth vanilla cream and topped with chocolate glaze.',
                'price' => 28000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Pretzel Roll',
                'image' => 'https://picsum.photos/seed/pretzel/640/480',
                'short_description' => 'Soft pretzel roll with coarse salt.',
                'long_description' => 'Traditional German-style pretzel roll with a golden crust and coarse salt topping.',
                'price' => 16000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Asin')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Strawberry Shortcake',
                'image' => 'https://picsum.photos/seed/strawberry/640/480',
                'short_description' => 'Light sponge cake with fresh strawberries.',
                'long_description' => 'Fluffy sponge cake layered with fresh strawberries and whipped cream.',
                'price' => 42000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Sourdough Bread',
                'image' => 'https://picsum.photos/seed/sourdough/640/480',
                'short_description' => 'Artisan sourdough bread with tangy flavor.',
                'long_description' => 'Traditional sourdough bread with a crispy crust and tangy, chewy interior.',
                'price' => 32000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Asam')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Chili Cheese Bread',
                'image' => 'https://picsum.photos/seed/chilicheese/640/480',
                'short_description' => 'Spicy bread with melted cheese and chili.',
                'long_description' => 'Soft bread topped with spicy chili flakes and melted cheese. Perfect for spice lovers.',
                'price' => 24000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Pedas')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Butter Croissant',
                'image' => 'https://picsum.photos/seed/buttercroissant/640/480',
                'short_description' => 'Classic French butter croissant.',
                'long_description' => 'Authentic French croissant made with premium butter, flaky and golden brown.',
                'price' => 22000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Gurih')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Apple Cinnamon Roll',
                'image' => 'https://picsum.photos/seed/appleroll/640/480',
                'short_description' => 'Sweet roll with apple and cinnamon filling.',
                'long_description' => 'Warm cinnamon roll filled with sweet apple pieces and topped with cream cheese glaze.',
                'price' => 26000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Herb Focaccia',
                'image' => 'https://picsum.photos/seed/focaccia/640/480',
                'short_description' => 'Italian flatbread with fresh herbs.',
                'long_description' => 'Traditional Italian focaccia bread topped with fresh rosemary and olive oil.',
                'price' => 28000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Gurih')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Lime Cheesecake',
                'image' => 'https://picsum.photos/seed/limecheese/640/480',
                'short_description' => 'Creamy cheesecake with fresh lime zest.',
                'long_description' => 'Rich and creamy cheesecake with a refreshing lime flavor and graham cracker crust.',
                'price' => 38000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Asam')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Jalapeño Cornbread',
                'image' => 'https://picsum.photos/seed/cornbread/640/480',
                'short_description' => 'Spicy cornbread with jalapeño peppers.',
                'long_description' => 'Traditional cornbread with a kick of jalapeño peppers and a hint of sweetness.',
                'price' => 21000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Pedas')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Bacon Quiche',
                'image' => 'https://picsum.photos/seed/baconquiche/640/480',
                'short_description' => 'Savory quiche with crispy bacon pieces.',
                'long_description' => 'Rich egg custard filled with crispy bacon and cheese in a flaky pastry crust.',
                'price' => 35000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Gurih')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Chocolate Chip Cookie',
                'image' => 'https://picsum.photos/seed/chocochip/640/480',
                'short_description' => 'Classic chocolate chip cookie.',
                'long_description' => 'Soft and chewy cookie loaded with premium chocolate chips. A timeless favorite.',
                'price' => 12000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Manis')->first()?->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Salted Caramel Brownie',
                'image' => 'https://picsum.photos/seed/brownie/640/480',
                'short_description' => 'Fudgy brownie with salted caramel swirl.',
                'long_description' => 'Rich, fudgy chocolate brownie with a salted caramel swirl and a hint of sea salt.',
                'price' => 30000.00,
                'weight' => 160,
                'category_id' => $categories->where('name', 'Asin')->first()?->id ?? $categories->random()->id,
            ],
        ];

        foreach ($manualProducts as $product) {
            Product::create($product);
        }
    }
}
