<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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

        $category = $this->faker->randomElement($categories);
        $name = $category['name'];

        return [
            'user_id' => $this->faker->numberBetween(1, 5), // Supposons qu'il y a 5 utilisateurs admin
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
            'color' => $category['color'],
            'icon' => $category['icon'],
            'is_active' => $this->faker->boolean(90), // 90% de chance d'être active
        ];
    }
}