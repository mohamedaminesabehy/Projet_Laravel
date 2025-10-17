<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Les Mystères de Paris',
            'L\'Art de la Guerre',
            'Le Petit Prince',
            'Les Misérables',
            'Vingt mille lieues sous les mers',
            'Le Comte de Monte-Cristo',
            'Notre-Dame de Paris',
            'L\'Étranger',
            'Germinal',
            'Madame Bovary',
            'Le Rouge et le Noir',
            'Les Fleurs du mal',
            'Candide',
            'L\'Assommoir',
            'Bel-Ami',
            'La Peste',
            'Le Père Goriot',
            'Les Trois Mousquetaires',
            'L\'Avare',
            'Cyrano de Bergerac',
        ];

        $authors = [
            'Victor Hugo',
            'Alexandre Dumas',
            'Gustave Flaubert',
            'Émile Zola',
            'Albert Camus',
            'Marcel Proust',
            'Honoré de Balzac',
            'Jules Verne',
            'Molière',
            'Voltaire',
            'Charles Baudelaire',
            'Guy de Maupassant',
            'Stendhal',
            'Jean-Paul Sartre',
            'Simone de Beauvoir',
            'André Malraux',
            'François Rabelais',
            'Paul Verlaine',
            'Arthur Rimbaud',
            'Jean Cocteau',
        ];

        $publishers = [
            'Gallimard',
            'Flammarion',
            'Seuil',
            'Albin Michel',
            'Grasset',
            'Fayard',
            'Pocket',
            'Le Livre de Poche',
            'Points',
            'Folio',
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'author' => $this->faker->randomElement($authors),
            'isbn' => $this->faker->isbn13(),
            'description' => $this->faker->paragraphs(3, true),
            'category_id' => function () {
                // Utiliser une catégorie existante ou créer "Autre" si aucune n'existe
                return Category::inRandomOrder()->first()?->id ?? Category::create([
                    'name' => 'Autre',
                    'slug' => 'autre',
                    'description' => 'Catégorie générale',
                    'color' => '#6c757d',
                    'icon' => 'fas fa-book',
                    'is_active' => true,
                ])->id;
            },
            'price' => $this->faker->randomFloat(2, 5.99, 49.99),
            'cover_image' => 'https://picsum.photos/300/400?random=' . $this->faker->numberBetween(1, 1000),
            'publication_date' => $this->faker->dateTimeBetween('-20 years', 'now')->format('Y-m-d'),
            'pages' => $this->faker->numberBetween(50, 800),
            'language' => $this->faker->randomElement(['fr', 'en', 'es', 'it']),
            'publisher' => $this->faker->randomElement($publishers),
            'is_available' => $this->faker->boolean(85), // 85% de chance d'être disponible
            'stock_quantity' => $this->faker->numberBetween(0, 50),
        ];
    }

    /**
     * Indicate that the book is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
            'is_available' => false,
        ]);
    }

    /**
     * Indicate that the book is a bestseller.
     */
    public function bestseller(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => $this->faker->numberBetween(20, 100),
            'is_available' => true,
        ]);
    }
}