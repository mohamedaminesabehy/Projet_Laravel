<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Review;
use App\Jobs\AnalyzeReviewSentiment;

echo "=== ANALYSE MANUELLE DES AVIS ===\n\n";

$reviews = Review::whereNull('analyzed_at')->get();
$count = $reviews->count();

echo "📝 Avis à analyser : $count\n\n";

if ($count === 0) {
    echo "✅ Tous les avis sont déjà analysés !\n";
} else {
    foreach ($reviews as $review) {
        echo "Analyse de l'avis #{$review->id}...\n";
        try {
            AnalyzeReviewSentiment::dispatch($review);
            echo "  ✅ Job dispatché pour l'avis #{$review->id}\n\n";
        } catch (\Exception $e) {
            echo "  ❌ Erreur : {$e->getMessage()}\n\n";
        }
    }
    
    echo "✅ Tous les jobs ont été dispatchés!\n";
    echo "⏳ Attendez quelques secondes que les analyses se terminent...\n";
}
?>