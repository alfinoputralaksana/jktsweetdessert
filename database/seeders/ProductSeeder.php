<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'Chocolate Brownies',
                'description' => 'Rich and fudgy chocolate brownies',
                'price' => 25000,
                'stock' => 50,
                'category' => 'Desserts',
            ],
            [
                'name' => 'Red Velvet Cake',
                'description' => 'Classic red velvet cake with cream cheese frosting',
                'price' => 150000,
                'stock' => 10,
                'category' => 'Cakes',
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'description' => 'Homemade chocolate chip cookies',
                'price' => 20000,
                'stock' => 100,
                'category' => 'Cookies',
            ],
            [
                'name' => 'Strawberry Cheesecake',
                'description' => 'Creamy cheesecake with fresh strawberries',
                'price' => 120000,
                'stock' => 15,
                'category' => 'Cakes',
            ],
            [
                'name' => 'Tiramisu',
                'description' => 'Italian classic tiramisu dessert',
                'price' => 80000,
                'stock' => 20,
                'category' => 'Desserts',
            ],
            [
                'name' => 'Oreo Cookies',
                'description' => 'Delicious oreo-flavored cookies',
                'price' => 18000,
                'stock' => 80,
                'category' => 'Cookies',
            ],
            [
                'name' => 'Matcha Latte',
                'description' => 'Refreshing matcha green tea latte',
                'price' => 30000,
                'stock' => 60,
                'category' => 'Beverages',
            ],
            [
                'name' => 'Chocolate Cake',
                'description' => 'Moist chocolate cake with chocolate frosting',
                'price' => 130000,
                'stock' => 12,
                'category' => 'Cakes',
            ],
        ];

        foreach ($products as $product) {
            $category = $categories->where('name', $product['category'])->first();
            
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
