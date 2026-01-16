<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Desserts',
                'description' => 'Sweet treats and desserts',
                'is_active' => true,
            ],
            [
                'name' => 'Cakes',
                'description' => 'Various types of cakes',
                'is_active' => true,
            ],
            [
                'name' => 'Cookies',
                'description' => 'Delicious cookies and biscuits',
                'is_active' => true,
            ],
            [
                'name' => 'Beverages',
                'description' => 'Refreshing drinks',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
}
