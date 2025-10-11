<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positiveComments = [
            'Excellent livre ! Je le recommande vivement.',
            'Une histoire captivante du début à la fin.',
            'L\'auteur a un style d\'écriture remarquable.',
            'Un ouvrage incontournable dans sa catégorie.',
            'J\'ai dévoré ce livre en une soirée !',
            'Les personnages sont très bien développés.',
            'Une intrigue palpitante et bien menée.',
            'Ce livre m\'a beaucoup fait réfléchir.',
            'Un chef-d\'œuvre de la littérature française.',
            'Une lecture enrichissante et divertissante.',
            'L\'histoire est touchante et émouvante.',
            'Un livre qui marque et qu\'on n\'oublie pas.',
            'Les descriptions sont magnifiques et vivantes.',
            'Un style fluide et agréable à lire.',
            'Ce livre mérite tous les éloges qu\'on peut en faire.',
        ];

        $neutralComments = [
            'Un livre correct, sans plus.',
            'L\'histoire est intéressante mais prévisible.',
            'Quelques longueurs mais dans l\'ensemble c\'est bien.',
            'Un bon divertissement pour passer le temps.',
            'Les personnages manquent un peu de profondeur.',
            'L\'intrigue est classique mais efficace.',
            'Une lecture agréable même si pas exceptionnelle.',
            'Le style de l\'auteur ne m\'a pas transcendé.',
            'Un livre qui se lit facilement.',
            'Certains passages sont un peu répétitifs.',
        ];

        $negativeComments = [
            'J\'ai eu du mal à rentrer dans l\'histoire.',
            'Le début est très lent, ça ne décolle qu\'à la fin.',
            'Les personnages ne sont pas attachants.',
            'L\'intrigue manque de cohérence.',
            'Trop de descriptions, pas assez d\'action.',
            'La fin est décevante après un bon début.',
            'Le style d\'écriture est lourd et pompeux.',
            'L\'histoire ne m\'a pas du tout convaincu.',
            'Des incohérences dans le récit.',
            'Je n\'ai pas réussi à finir ce livre.',
        ];

        $rating = $this->faker->numberBetween(1, 5);
        
        // Sélection du commentaire selon la note
        if ($rating >= 4) {
            $comment = $this->faker->randomElement($positiveComments);
        } elseif ($rating >= 3) {
            $comment = $this->faker->randomElement($neutralComments);
        } else {
            $comment = $this->faker->randomElement($negativeComments);
        }

        // Parfois ajouter plus de détails au commentaire
        if ($this->faker->boolean(30)) {
            $additionalDetails = [
                ' Les dialogues sont particulièrement réussis.',
                ' L\'ambiance est très bien rendue.',
                ' Les rebondissements sont nombreux.',
                ' C\'est ma première lecture de cet auteur.',
                ' Je vais lire d\'autres livres de cette série.',
                ' L\'écriture est fluide et moderne.',
                ' Les thèmes abordés sont profonds.',
                ' Une belle découverte littéraire.',
                ' Je recommande à tous les amateurs du genre.',
                ' Un livre à lire absolument.',
            ];
            $comment .= $this->faker->randomElement($additionalDetails);
        }

        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'rating' => $rating,
            'comment' => $comment,
            'is_approved' => $this->faker->boolean(80), // 80% de chance d'être approuvé
        ];
    }

    /**
     * Indicate that the review is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    /**
     * Indicate that the review is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }

    /**
     * Create a 5-star review.
     */
    public function fiveStars(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 5,
            'comment' => $this->faker->randomElement([
                'Absolument parfait ! Un chef-d\'œuvre.',
                'Exceptionnel ! Je le recommande à tous.',
                'Un livre magnifique, émouvant et bien écrit.',
                'Incontournable ! Une lecture extraordinaire.',
                'Parfait du début à la fin. Bravo à l\'auteur !',
            ]),
        ]);
    }

    /**
     * Create a 1-star review.
     */
    public function oneStar(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 1,
            'comment' => $this->faker->randomElement([
                'Très décevant, je ne recommande pas.',
                'Impossible de finir ce livre, trop ennuyeux.',
                'Une histoire sans intérêt avec des personnages fades.',
                'Aucun suspense, très prévisible.',
                'Perte de temps, il existe bien mieux dans ce genre.',
            ]),
        ]);
    }
}