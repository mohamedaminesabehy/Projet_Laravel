<?php

/**
 * Script d'analyse par lots des avis non analysés
 * Évite les timeouts en traitant 10 avis à la fois avec des pauses
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Review;
use App\Jobs\AnalyzeReviewSentiment;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   ANALYSE PAR LOTS - SENTIMENT AI                         ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Paramètres
$batchSize = 10;      // Nombre d'avis par lot
$pauseBetweenBatches = 2; // Pause en secondes entre les lots

// Compter les avis à analyser
$totalReviews = Review::whereNull('analyzed_at')->count();

if ($totalReviews === 0) {
    echo "✅ Tous les avis sont déjà analysés !\n";
    exit(0);
}

echo "📊 Total d'avis à analyser : $totalReviews\n";
echo "📦 Taille des lots : $batchSize avis\n";
echo "⏱️  Pause entre lots : {$pauseBetweenBatches}s\n\n";

$totalProcessed = 0;
$batchNumber = 1;
$startTime = time();

while ($totalProcessed < $totalReviews) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📦 LOT #{$batchNumber}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    // Récupérer le lot suivant
    $reviews = Review::whereNull('analyzed_at')
        ->limit($batchSize)
        ->get();
    
    if ($reviews->isEmpty()) {
        break;
    }
    
    $batchStart = microtime(true);
    
    // Analyser chaque avis
    foreach ($reviews as $index => $review) {
        $reviewStart = microtime(true);
        
        try {
            echo "  [" . ($index + 1) . "/{$reviews->count()}] Avis #{$review->id} ... ";
            
            AnalyzeReviewSentiment::dispatch($review);
            
            $reviewTime = round(microtime(true) - $reviewStart, 2);
            echo "✅ ({$reviewTime}s)\n";
            
            $totalProcessed++;
            
        } catch (Exception $e) {
            echo "❌ Erreur : " . $e->getMessage() . "\n";
        }
    }
    
    $batchTime = round(microtime(true) - $batchStart, 2);
    $progress = round(($totalProcessed / $totalReviews) * 100, 1);
    
    echo "\n";
    echo "  ⏱️  Temps du lot : {$batchTime}s\n";
    echo "  📈 Progression : {$totalProcessed}/{$totalReviews} ({$progress}%)\n";
    
    // Pause entre les lots (sauf pour le dernier)
    if ($totalProcessed < $totalReviews && $reviews->count() === $batchSize) {
        echo "  💤 Pause de {$pauseBetweenBatches}s...\n";
        sleep($pauseBetweenBatches);
    }
    
    echo "\n";
    $batchNumber++;
}

$totalTime = time() - $startTime;
$minutes = floor($totalTime / 60);
$seconds = $totalTime % 60;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   ✅ ANALYSE TERMINÉE !                                    ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";
echo "📊 Résumé :\n";
echo "  • Avis traités : {$totalProcessed}\n";
echo "  • Temps total : {$minutes}m {$seconds}s\n";
echo "  • Temps moyen par avis : " . round($totalTime / max($totalProcessed, 1), 2) . "s\n\n";
echo "🌐 Consultez les résultats sur : http://localhost/admin/sentiment\n\n";
