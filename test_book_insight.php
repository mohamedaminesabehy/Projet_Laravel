<?php

/**
 * Script de test - Générer l'insight pour UN seul livre
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Services\AI\BookReviewSummarizer;

echo "🧪 TEST - Génération d'insight pour un livre\n";
echo "════════════════════════════════════════════\n\n";

// Trouver un livre avec des avis analysés
$book = Book::has('reviews', '>=', 3)
    ->with(['reviews' => function($query) {
        $query->whereNotNull('analyzed_at');
    }])
    ->first();

if (!$book) {
    echo "❌ Aucun livre avec au moins 3 avis analysés trouvé.\n";
    echo "   Lancez d'abord l'analyse des avis avec : C:\\php\\php.exe analyze_reviews_batch.php\n";
    exit(1);
}

echo "📖 Livre sélectionné :\n";
echo "   ID: {$book->id}\n";
echo "   Titre: {$book->title}\n";
echo "   Auteur: {$book->author}\n\n";

$reviewsCount = $book->reviews()->whereNotNull('analyzed_at')->count();
echo "📊 Avis analysés : {$reviewsCount}\n\n";

echo "🤖 Génération de l'insight avec Gemini AI...\n";
echo "⏳ Cela peut prendre 5-10 secondes...\n\n";

$startTime = microtime(true);

try {
    $summarizer = app(BookReviewSummarizer::class);
    $insight = $summarizer->generateInsight($book);
    
    $duration = round(microtime(true) - $startTime, 2);
    
    if ($insight) {
        echo "✅ SUCCÈS ! Insight généré en {$duration}s\n\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📝 RÉSUMÉ\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo wordwrap($insight->reviews_summary, 70) . "\n\n";
        
        if (!empty($insight->positive_points)) {
            echo "✅ POINTS POSITIFS (" . count($insight->positive_points) . ")\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            foreach ($insight->positive_points as $point) {
                echo "  • {$point}\n";
            }
            echo "\n";
        }
        
        if (!empty($insight->negative_points)) {
            echo "⚠️  POINTS NÉGATIFS (" . count($insight->negative_points) . ")\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            foreach ($insight->negative_points as $point) {
                echo "  • {$point}\n";
            }
            echo "\n";
        }
        
        if (!empty($insight->top_themes)) {
            echo "🏷️  THÈMES PRINCIPAUX (" . count($insight->top_themes) . ")\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "  " . implode(', ', $insight->top_themes) . "\n\n";
        }
        
        echo "📊 STATISTIQUES\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "  • Note moyenne: {$insight->average_rating}/5\n";
        echo "  • Sentiment moyen: {$insight->average_sentiment}\n";
        echo "  • Sentiment positif: {$insight->sentiment_distribution['positive']}%\n";
        echo "  • Sentiment neutre: {$insight->sentiment_distribution['neutral']}%\n";
        echo "  • Sentiment négatif: {$insight->sentiment_distribution['negative']}%\n";
        echo "  • Total avis: {$insight->total_reviews}\n\n";
        
        echo "👀 Voir le résumé sur la page du livre :\n";
        echo "   http://localhost/books/{$book->id}\n\n";
        
    } else {
        echo "❌ ÉCHEC ! L'insight n'a pas pu être généré.\n";
        echo "   Vérifiez les logs : storage/logs/laravel.log\n\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERREUR : " . $e->getMessage() . "\n";
    echo "   Trace : " . $e->getTraceAsString() . "\n\n";
}
