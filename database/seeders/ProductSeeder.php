<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all categories
        $hat = Category::where('name', 'hat')->first();
        $shirt = Category::where('name', 'shirt')->first();
        $jacket = Category::where('name', 'jacket')->first();
        $trouser = Category::where('name', 'trouser')->first();
        $short = Category::where('name', 'short')->first();
        $shoe = Category::where('name', 'shoe')->first();

        $products = [
            // Hats (2 products)
            [
                'category_id' => $hat->id,
                'name' => 'Baseball Cap',
                'price' => 24.99,
                'stock' => 50,
                'description' => 'Classic baseball cap with adjustable strap.'
            ],
            [
                'category_id' => $hat->id,
                'name' => 'Beanie',
                'price' => 19.99,
                'stock' => 30,
                'description' => 'Warm winter beanie made from acrylic wool.'
            ],

            // Shirts (2 products)
            [
                'category_id' => $shirt->id,
                'name' => 'Cotton T-Shirt',
                'price' => 29.99,
                'stock' => 100,
                'description' => '100% cotton t-shirt, available in multiple colors.'
            ],
            [
                'category_id' => $shirt->id,
                'name' => 'Polo Shirt',
                'price' => 39.99,
                'stock' => 75,
                'description' => 'Classic polo shirt with embroidered logo.'
            ],

            // Jackets (2 products)
            [
                'category_id' => $jacket->id,
                'name' => 'Denim Jacket',
                'price' => 79.99,
                'stock' => 25,
                'description' => 'Classic denim jacket with front pockets.'
            ],
            [
                'category_id' => $jacket->id,
                'name' => 'Winter Parka',
                'price' => 129.99,
                'stock' => 20,
                'description' => 'Warm winter parka with hood and insulation.'
            ],

            // Trousers (2 products)
            [
                'category_id' => $trouser->id,
                'name' => 'Slim Fit Jeans',
                'price' => 59.99,
                'stock' => 60,
                'description' => 'Slim fit jeans with stretch for comfort.'
            ],
            [
                'category_id' => $trouser->id,
                'name' => 'Chino Pants',
                'price' => 49.99,
                'stock' => 45,
                'description' => 'Casual chino pants perfect for everyday wear.'
            ],

            // Shorts (2 products)
            [
                'category_id' => $short->id,
                'name' => 'Cargo Shorts',
                'price' => 34.99,
                'stock' => 40,
                'description' => 'Cargo shorts with multiple pockets.'
            ],
            [
                'category_id' => $short->id,
                'name' => 'Athletic Shorts',
                'price' => 27.99,
                'stock' => 55,
                'description' => 'Lightweight athletic shorts for sports and exercise.'
            ],

            // Shoes (2 products)
            [
                'category_id' => $shoe->id,
                'name' => 'Running Shoes',
                'price' => 89.99,
                'stock' => 35,
                'description' => 'Lightweight running shoes with cushioning.'
            ],
            [
                'category_id' => $shoe->id,
                'name' => 'Casual Sneakers',
                'price' => 69.99,
                'stock' => 50,
                'description' => 'Comfortable casual sneakers for everyday wear.'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
