<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Review;
use App\Models\Book;
use App\Models\BookInsight;
use App\Models\User;
use App\Jobs\AnalyzeReviewSentiment;

echo "=== TEST GÉNÉRATION AUTOMATIQUE AI INSIGHTS ===\n\n";

// 1. Trouver un livre sans insights
$book = Book::whereDoesntHave('insight')->first();

if (!$book) {
    // Créer un nouveau livre si aucun n'existe
    $book = Book::create([
        'title' => 'Test Book for Auto Insights ' . time(),
        'author' => 'Test Author',
        'isbn' => 'TEST' . rand(100000, 999999),
        'category_id' => \App\Models\Category::first()->id ?? 1,
        'description' => 'Livre de test pour la génération automatique d\'insights',
        'price' => 19.99,
        'stock_quantity' => 10,
        'is_available' => true,
    ]);
    echo "✅ Nouveau livre créé: {$book->title} (ID: {$book->id})\n\n";
} else {
    echo "✅ Livre trouvé sans insights: {$book->title} (ID: {$book->id})\n\n";
}

// 2. Supprimer les anciens avis de test sur ce livre
Review::where('book_id', $book->id)->delete();
echo "🧹 Anciens avis supprimés\n\n";

// 3. Créer 3 utilisateurs différents pour respecter la contrainte unique
$users = [];
for ($i = 1; $i <= 3; $i++) {
    $user = User::firstOrCreate(
        ['email' => "testuser{$i}_" . time() . "@example.com"],
        [
            'name' => "Test User $i",
            'password' => bcrypt('password'),
        ]
    );
    $users[] = $user;
}
echo "✅ 3 utilisateurs de test créés\n\n";

// 4. Créer 3 avis sur le livre avec différents utilisateurs
$reviewTexts = [
    "Excellent livre ! J'ai adoré l'histoire et les personnages sont très attachants. Je le recommande vivement à tous les amateurs du genre.",
    "Livre correct mais j'ai trouvé certains passages un peu longs. L'intrigue reste intéressante malgré tout.",
    "Un chef-d'œuvre ! L'auteur a su créer un univers captivant. Je n'ai pas pu m'arrêter de lire jusqu'à la fin.",
];

echo "📝 Création de 3 avis et analyse automatique...\n\n";

foreach ($users as $index => $user) {
    $review = Review::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'rating' => [5, 4, 5][$index], // Notes: 5, 4, 5
        'comment' => $reviewTexts[$index],
        'status' => 'approved', // Approuvé directement pour le test
    ]);
    
    echo "  ✅ Avis {$review->id} créé (User: {$user->name})\n";
    
    // Déclencher l'analyse automatique (synchrone pour le test)
    $job = new AnalyzeReviewSentiment($review);
    
    try {
        $job->handle(app(\App\Services\AI\SentimentAnalyzer::class));
        echo "  ✅ Analyse sentiment complétée pour l'avis {$review->id}\n";
    } catch (\Exception $e) {
        echo "  ❌ Erreur d'analyse: {$e->getMessage()}\n";
    }
    
    echo "\n";
}

// 5. Vérifier le nombre d'avis analysés
sleep(2); // Attendre un peu pour s'assurer que tout est terminé

$book->refresh();
$analyzedCount = $book->reviews()->whereNotNull('analyzed_at')->count();
echo "📊 Avis analysés pour '{$book->title}': $analyzedCount\n\n";

// 6. Vérifier si le BookInsight a été généré automatiquement
sleep(3); // Attendre la génération asynchrone

$insight = BookInsight::where('book_id', $book->id)->first();

if ($insight) {
    echo "✅ ✅ ✅ SUCCÈS! BookInsight généré automatiquement!\n\n";
    echo "═══════════════════════════════════════════════════════════\n";
    echo "📚 RÉSUMÉ AI GÉNÉRÉ POUR: {$book->title}\n";
    echo "═══════════════════════════════════════════════════════════\n\n";
    echo "Total Avis: {$insight->total_reviews}\n";
    echo "Note Moyenne: " . number_format($insight->average_rating, 2) . "/5 ⭐\n\n";
    echo "📝 Résumé:\n" . str_repeat('-', 60) . "\n";
    echo $insight->summary . "\n";
    echo str_repeat('-', 60) . "\n\n";
    
    // Afficher la distribution des sentiments
    $sentiments = json_decode($insight->sentiment_distribution, true);
    echo "😊 Distribution des Sentiments:\n";
    echo "  Positifs: " . ($sentiments['positive'] ?? 0) . "%\n";
    echo "  Neutres:  " . ($sentiments['neutral'] ?? 0) . "%\n";
    echo "  Négatifs: " . ($sentiments['negative'] ?? 0) . "%\n\n";
    
    // Afficher les thèmes
    echo "🏷️  Thèmes Principaux:\n";
    foreach ($insight->top_themes as $theme) {
        echo "  • $theme\n";
    }
    echo "\n";
    
    echo "✅ Le système AI Insights fonctionne parfaitement en mode automatique!\n";
    echo "✅ Chaque nouvel avis déclenche l'analyse + génération d'insights si ≥3 avis\n";
} else {
    echo "❌ ERREUR: BookInsight NON généré automatiquement\n";
    echo "Vérifiez les logs Laravel pour plus de détails\n";
    
    // Essayer de générer manuellement pour voir l'erreur
    echo "\n🔧 Tentative de génération manuelle...\n";
    try {
        $summarizer = app(\App\Services\AI\BookReviewSummarizer::class);
        $manualInsight = $summarizer->generateInsight($book);
        
        if ($manualInsight) {
            echo "✅ Génération manuelle réussie! Il y a peut-être un problème avec les jobs asynchrones\n";
            echo "💡 Solution: Assurez-vous que 'queue' est configuré sur 'sync' dans .env\n";
        } else {
            echo "❌ Même la génération manuelle a échoué\n";
        }
    } catch (\Exception $e) {
        echo "❌ Erreur: {$e->getMessage()}\n";
    }
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "FIN DU TEST\n";
echo "═══════════════════════════════════════════════════════════\n";
