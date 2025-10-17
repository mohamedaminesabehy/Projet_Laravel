<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Review;
use App\Jobs\AnalyzeReviewSentiment;

echo "🔍 Recherche des avis non analysés...\n\n";

$reviews = Review::whereNull('analyzed_at')->get();

echo "📊 Trouvé : " . $reviews->count() . " avis à analyser\n\n";

if ($reviews->isEmpty()) {
    echo "✅ Aucun avis à analyser !\n";
    exit(0);
}

foreach ($reviews as $review) {
    echo "Analyse de l'avis #{$review->id}... ";
    
    try {
        AnalyzeReviewSentiment::dispatch($review);
        echo "✅ Envoyé pour analyse\n";
    } catch (Exception $e) {
        echo "❌ Erreur : " . $e->getMessage() . "\n";
    }
}

echo "\n✅ Terminé ! Vérifiez /admin/sentiment dans quelques secondes.\n";
