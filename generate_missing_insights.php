<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Services\AI\BookReviewSummarizer;

echo "=== GÉNÉRATION DES AI INSIGHTS MANQUANTS ===\n\n";

// Trouver les livres avec au moins 3 avis analysés mais sans BookInsight
$books = Book::whereHas('reviews', function($query) {
    $query->whereNotNull('analyzed_at');
}, '>=', 3)
->doesntHave('insight')
->get();

echo "📚 Livres trouvés avec ≥3 avis analysés mais sans AI Insight : " . $books->count() . "\n\n";

if ($books->isEmpty()) {
    echo "✅ Tous les livres éligibles ont déjà leur AI Insight !\n";
    echo "\nINFO : Un livre a besoin d'au moins 3 avis analysés pour générer un AI Insight.\n";
    exit(0);
}

$summarizer = app(BookReviewSummarizer::class);
$successCount = 0;
$failedCount = 0;

foreach ($books as $book) {
    echo "📖 Traitement : {$book->title} (ID: {$book->id})\n";
    
    $reviewCount = $book->reviews()->whereNotNull('analyzed_at')->count();
    echo "   • Avis analysés : {$reviewCount}\n";
    
    try {
        $insight = $summarizer->generateInsight($book);
        
        if ($insight) {
            echo "   ✅ AI Insight généré avec succès !\n";
            echo "   • Résumé : " . substr($insight->reviews_summary, 0, 100) . "...\n";
            echo "   • Note moyenne : {$insight->average_rating}/5\n";
            echo "   • Sentiment moyen : {$insight->average_sentiment}\n";
            $successCount++;
        } else {
            echo "   ❌ Échec de la génération (conditions non remplies)\n";
            $failedCount++;
        }
    } catch (\Exception $e) {
        echo "   ❌ Erreur : " . $e->getMessage() . "\n";
        $failedCount++;
    }
    
    echo "\n";
}

echo "=== RÉSULTATS ===\n";
echo "✅ Succès : {$successCount}\n";
echo "❌ Échecs : {$failedCount}\n";
echo "📊 Total traité : " . ($successCount + $failedCount) . "\n";

?>
