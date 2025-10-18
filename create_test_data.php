<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Review;
use App\Services\AI\SentimentAnalyzer;
use App\Services\AI\BookReviewSummarizer;

echo "=== CRÉATION DE DONNÉES DE TEST POUR AI INSIGHTS ===\n\n";

// Créer une catégorie si elle n'existe pas
$category = Category::firstOrCreate(
    ['name' => 'Fiction'],
    ['description' => 'Livres de fiction', 'slug' => 'fiction']
);
echo "✅ Catégorie créée : {$category->name}\n";

// Créer un utilisateur admin si nécessaire
$admin = User::where('email', 'admin@example.com')->first();
if (!$admin) {
    $admin = User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);
    echo "✅ Utilisateur admin créé : {$admin->email} (mot de passe: password)\n";
} else {
    echo "✅ Utilisateur admin existant : {$admin->email}\n";
}

// Créer 3 utilisateurs de test
$users = [];
for ($i = 1; $i <= 3; $i++) {
    $user = User::firstOrCreate(
        ['email' => "user{$i}@example.com"],
        [
            'name' => "Utilisateur Test {$i}",
            'password' => bcrypt('password'),
            'role' => 'user',
        ]
    );
    $users[] = $user;
    echo "✅ Utilisateur {$i} créé : {$user->email}\n";
}

// Créer un livre de test
$book = Book::firstOrCreate(
    ['isbn' => '978-2-07-061275-8'],
    [
        'title' => 'Le Petit Prince',
        'author' => 'Antoine de Saint-Exupéry',
        'category_id' => $category->id,
        'price' => 9.99,
        'stock' => 50,
        'description' => 'Un conte philosophique et poétique sous l\'apparence d\'un conte pour enfants.',
        'cover_image' => 'placeholder.jpg',
        'status' => 'available',
        'user_id' => $admin->id,
    ]
);
echo "\n✅ Livre créé : {$book->title} (ID: {$book->id})\n\n";

// Avis de test (variés en sentiment)
$reviewsData = [
    [
        'user' => $users[0],
        'rating' => 5,
        'comment' => 'Un chef-d\'œuvre intemporel ! L\'histoire est magnifique et les personnages sont attachants. Le renard et sa leçon sur l\'apprivoisement m\'ont particulièrement touché. Une lecture émouvante que je recommande à tous.',
    ],
    [
        'user' => $users[1],
        'rating' => 4,
        'comment' => 'Très bon livre avec une belle morale. J\'ai apprécié la profondeur des messages philosophiques. Cependant, certains passages étaient un peu lents à mon goût. Dans l\'ensemble, une excellente lecture.',
    ],
    [
        'user' => $users[2],
        'rating' => 5,
        'comment' => 'Extraordinaire ! Ce livre m\'a fait rire et pleurer. Les illustrations sont superbes et l\'histoire est captivante du début à la fin. Un vrai trésor de la littérature française.',
    ],
];

echo "📝 Création de " . count($reviewsData) . " avis...\n";

$analyzer = app(SentimentAnalyzer::class);
$createdReviews = [];

foreach ($reviewsData as $index => $data) {
    // Créer l'avis
    $review = Review::create([
        'book_id' => $book->id,
        'user_id' => $data['user']->id,
        'rating' => $data['rating'],
        'comment' => $data['comment'],
        'is_approved' => true,
        'status' => 'approved',
    ]);
    
    echo "   • Avis #{$review->id} de {$data['user']->name} : {$data['rating']}/5\n";
    
    // Analyser l'avis immédiatement
    try {
        $analysis = $analyzer->analyze($review);
        
        if ($analysis) {
            $review->update([
                'sentiment_score' => $analysis['sentiment_score'],
                'sentiment_label' => $analysis['sentiment_label'],
                'toxicity_score' => $analysis['toxicity_score'],
                'ai_summary' => $analysis['ai_summary'],
                'ai_topics' => json_encode($analysis['ai_topics']),
                'requires_manual_review' => $analysis['requires_manual_review'],
                'analyzed_at' => now(),
            ]);
            echo "     ✅ Analysé : Sentiment {$analysis['sentiment_label']} ({$analysis['sentiment_score']})\n";
        }
    } catch (\Exception $e) {
        echo "     ❌ Erreur d'analyse : " . $e->getMessage() . "\n";
    }
    
    $createdReviews[] = $review;
}

echo "\n📊 Génération du BookInsight...\n";

try {
    $summarizer = app(BookReviewSummarizer::class);
    $insight = $summarizer->generateInsight($book);
    
    if ($insight) {
        echo "✅ BookInsight généré avec succès !\n\n";
        echo "=== RÉSUMÉ ===\n";
        echo $insight->reviews_summary . "\n\n";
        
        echo "=== POINTS POSITIFS ===\n";
        foreach ($insight->positive_points as $point) {
            echo "  + {$point}\n";
        }
        
        if (!empty($insight->negative_points)) {
            echo "\n=== POINTS NÉGATIFS ===\n";
            foreach ($insight->negative_points as $point) {
                echo "  - {$point}\n";
            }
        }
        
        echo "\n=== THÈMES PRINCIPAUX ===\n";
        foreach ($insight->top_themes as $theme) {
            echo "  • {$theme}\n";
        }
        
        echo "\n=== STATISTIQUES ===\n";
        echo "  Note moyenne : {$insight->average_rating}/5\n";
        echo "  Sentiment moyen : {$insight->average_sentiment}\n";
        echo "  Distribution :\n";
        echo "    - Positif : {$insight->sentiment_distribution['positive']}%\n";
        echo "    - Neutre : {$insight->sentiment_distribution['neutral']}%\n";
        echo "    - Négatif : {$insight->sentiment_distribution['negative']}%\n";
    } else {
        echo "❌ Le BookInsight n'a pas pu être généré (conditions non remplies)\n";
    }
} catch (\Exception $e) {
    echo "❌ Erreur lors de la génération du BookInsight : " . $e->getMessage() . "\n";
}

echo "\n=== TEST TERMINÉ ===\n";
echo "🌐 Visitez http://127.0.0.1:8000/ai-insights pour voir le résultat !\n";

?>
