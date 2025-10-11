<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Romance', 'color' => '#FF5E84', 'icon' => 'fas fa-heart'],
            ['name' => 'Science Fiction', 'color' => '#4E7CFF', 'icon' => 'fas fa-rocket'],
            ['name' => 'Thriller', 'color' => '#9747FF', 'icon' => 'fas fa-mask'],
            ['name' => 'Fantasy', 'color' => '#00C48C', 'icon' => 'fas fa-dragon'],
            ['name' => 'Biographie', 'color' => '#FFC700', 'icon' => 'fas fa-user-tie'],
            ['name' => 'Histoire', 'color' => '#FF6B35', 'icon' => 'fas fa-landmark'],
            ['name' => 'Jeunesse', 'color' => '#FF9F1C', 'icon' => 'fas fa-child'],
            ['name' => 'Philosophie', 'color' => '#2EC4B6', 'icon' => 'fas fa-brain'],
            ['name' => 'Cuisine', 'color' => '#E71D36', 'icon' => 'fas fa-utensils'],
            ['name' => 'Voyage', 'color' => '#011627', 'icon' => 'fas fa-globe'],
        ];

        foreach ($categories as $index => $categoryData) {
            Category::firstOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'user_id' => 1, // Admin par défaut
                    'name' => $categoryData['name'],
                    'slug' => Str::slug($categoryData['name']),
                    'description' => 'Description pour ' . $categoryData['name'],
                    'color' => $categoryData['color'],
                    'icon' => $categoryData['icon'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}