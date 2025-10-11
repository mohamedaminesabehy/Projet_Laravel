<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // S'assurer qu'on a des utilisateurs et des livres
        if (User::count() < 10) {
            User::factory(20)->create();
        }

        // Utiliser les catégories existantes ou en créer si nécessaire
        if (Category::count() < 5) {
            $categories = [
                ['name' => 'Autre', 'color' => '#6c757d', 'icon' => 'fas fa-book'],
            ];

            foreach ($categories as $categoryData) {
                Category::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($categoryData['name'])],
                    [
                        'name' => $categoryData['name'],
                        'slug' => \Illuminate\Support\Str::slug($categoryData['name']),
                        'description' => 'Catégorie ' . $categoryData['name'],
                        'color' => $categoryData['color'],
                        'icon' => $categoryData['icon'],
                        'is_active' => true,
                    ]
                );
            }
        }

        if (Book::count() < 10) {
            Book::factory(30)->create();
        }

        $users = User::all();
        $books = Book::all();

        // Générer 75 avis aléatoirement distribués
        for ($i = 0; $i < 75; $i++) {
            $user = $users->random();
            $book = $books->random();

            // Éviter les doublons (un utilisateur ne peut avoir qu'un avis par livre)
            if (!Review::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                ]);
            }
        }

        // Ajouter quelques avis spéciaux
        // Avis 5 étoiles
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $book = $books->random();

            if (!Review::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
                Review::factory()
                    ->fiveStars()
                    ->approved()
                    ->create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                    ]);
            }
        }

        // Avis 1 étoile
        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $book = $books->random();

            if (!Review::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
                Review::factory()
                    ->oneStar()
                    ->approved()
                    ->create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                    ]);
            }
        }

        // Quelques avis en attente d'approbation
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $book = $books->random();

            if (!Review::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
                Review::factory()
                    ->pending()
                    ->create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                    ]);
            }
        }

        $this->command->info('Avis générés avec succès !');
        $this->command->info('Total des avis créés : ' . Review::count());
        $this->command->info('Avis approuvés : ' . Review::where('is_approved', true)->count());
        $this->command->info('Avis en attente : ' . Review::where('is_approved', false)->count());
    }
}