<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Models\BookInsight;

echo "=== NETTOYAGE DES BOOKINSIGHTS INVALIDES ===\n\n";

// Récupérer tous les BookInsights
$insights = BookInsight::all();

$deletedCount = 0;

foreach ($insights as $insight) {
    $book = Book::find($insight->book_id);
    
    if (!$book) {
        echo "BookInsight ID {$insight->id}: Livre supprimé - SUPPRESSION\n";
        $insight->delete();
        $deletedCount++;
        continue;
    }
    
    // Compter les avis analysés
    $analyzedCount = $book->reviews()->whereNotNull('analyzed_at')->count();
    
    echo "BookInsight ID {$insight->id} pour '{$book->title}':\n";
    echo "  - Avis analysés: {$analyzedCount}\n";
    
    if ($analyzedCount < 3) {
        echo "  - ⚠️  Moins de 3 avis analysés - SUPPRESSION\n";
        $insight->delete();
        $deletedCount++;
    } else {
        echo "  - ✓ OK (au moins 3 avis analysés)\n";
    }
    echo "\n";
}

echo "=====================================\n";
echo "Total BookInsights supprimés: {$deletedCount}\n";
echo "BookInsights restants: " . BookInsight::count() . "\n";
