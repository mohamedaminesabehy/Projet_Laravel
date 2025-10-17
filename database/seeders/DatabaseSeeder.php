<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories first (predefined ones to avoid duplicates)
        $this->call([
            CategorySeeder::class,
        ]);

        // Create test users
        User::factory(20)->create();

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed reviews with all related data
        $this->call([
            ReviewSeeder::class,
        ]);
    }
}
