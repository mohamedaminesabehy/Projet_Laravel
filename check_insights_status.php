<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Review;
use App\Models\Book;
use App\Models\BookInsight;

echo "=== ÉTAT DES AI INSIGHTS ===\n\n";

// Vérifier les livres avec leurs avis
$books = Book::withCount(['reviews', 'reviews as analyzed_reviews_count' => function($query) {
    $query->whereNotNull('analyzed_at');
}])->get();

foreach ($books as $book) {
    echo "📚 Livre ID {$book->id}: {$book->title}\n";
    echo "   Total avis: {$book->reviews_count}\n";
    echo "   Avis analysés: {$book->analyzed_reviews_count}\n";
    
    $insight = BookInsight::where('book_id', $book->id)->first();
    if ($insight) {
        echo "   ✅ BookInsight existe (ID: {$insight->id})\n";
        echo "   Résumé: " . substr($insight->summary, 0, 100) . "...\n";
    } else {
        echo "   ❌ Pas de BookInsight\n";
        if ($book->analyzed_reviews_count >= 3) {
            echo "   ⚠️  PROBLÈME: {$book->analyzed_reviews_count} avis analysés mais pas de BookInsight!\n";
        }
    }
    echo "\n";
}

// Vérifier les avis non analysés
$unanalyzedReviews = Review::whereNull('analyzed_at')->count();
echo "📊 Avis non analysés: $unanalyzedReviews\n";

if ($unanalyzedReviews > 0) {
    echo "\n⚠️  Il y a des avis qui n'ont pas été analysés!\n";
    echo "   Solution: Visitez la page Admin > Sentiment Analysis et cliquez sur 'Bulk Analyze'\n";
}
