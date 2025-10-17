<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Models\BookInsight;
use App\Models\Review;

echo "=== DIAGNOSTIC AI INSIGHTS ===\n\n";

$books = Book::withCount([
    'reviews',
    'reviews as analyzed_reviews_count' => function($q) {
        $q->whereNotNull('analyzed_at');
    }
])->get();

foreach ($books as $book) {
    echo "Livre ID {$book->id}: {$book->title}\n";
    echo "  Total avis: {$book->reviews_count}\n";
    echo "  Avis analysés: {$book->analyzed_reviews_count}\n";
    
    $insight = BookInsight::where('book_id', $book->id)->first();
    
    if ($insight) {
        echo "  BookInsight: ✓ OUI (ID: {$insight->id})\n";
        echo "    - Summary: " . substr($insight->summary, 0, 100) . "...\n";
        echo "    - Points positifs: " . count($insight->positive_points ?? []) . "\n";
        echo "    - Points négatifs: " . count($insight->negative_points ?? []) . "\n";
    } else {
        echo "  BookInsight: ✗ NON\n";
        
        if ($book->analyzed_reviews_count >= 3) {
            echo "    ⚠️  PROBLÈME: Ce livre a {$book->analyzed_reviews_count} avis analysés mais pas de BookInsight!\n";
        } else {
            echo "    ℹ️  Normal: Besoin de minimum 3 avis analysés (actuellement {$book->analyzed_reviews_count})\n";
        }
    }
    echo "\n";
}

echo "TOTAL BookInsights dans la base: " . BookInsight::count() . "\n";
echo "TOTAL Livres: " . Book::count() . "\n";
echo "TOTAL Avis: " . Review::count() . "\n";
echo "TOTAL Avis analysés: " . Review::whereNotNull('analyzed_at')->count() . "\n";
