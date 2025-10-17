<?php

/**
 * Script de génération des insights (résumés AI) pour tous les livres
 * Analyse les avis de chaque livre et génère un résumé structuré
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Services\AI\BookReviewSummarizer;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   GÉNÉRATION DES INSIGHTS LIVRES - AI                      ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Paramètres
$booksPerBatch = 5;      // Nombre de livres par lot
$pauseBetweenBooks = 3;   // Pause en secondes entre chaque livre

// Trouver les livres éligibles (au moins 3 avis analysés)
$eligibleBooks = Book::has('reviews', '>=', 3)
    ->with(['reviews' => function($query) {
        $query->whereNotNull('analyzed_at');
    }])
    ->get();

$totalBooks = $eligibleBooks->count();

if ($totalBooks === 0) {
    echo "⚠️  Aucun livre avec au moins 3 avis analysés trouvé.\n";
    echo "   Assurez-vous d'avoir exécuté l'analyse de sentiment des avis d'abord.\n\n";
    exit(0);
}

echo "📚 Livres éligibles : {$totalBooks}\n";
echo "📦 Taille des lots : {$booksPerBatch}\n";
echo "⏱️  Pause entre livres : {$pauseBetweenBooks}s\n\n";

// Initialiser le service
$summarizer = app(BookReviewSummarizer::class);

$totalProcessed = 0;
$success = 0;
$failed = 0;
$skipped = 0;
$batchNumber = 1;
$startTime = time();

foreach ($eligibleBooks as $book) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📖 Livre #{$book->id}: {$book->title}\n";
    echo "   Auteur: {$book->author}\n";
    
    $reviewsCount = $book->reviews()->whereNotNull('analyzed_at')->count();
    echo "   Avis analysés: {$reviewsCount}\n";
    
    // Vérifier si l'insight existe déjà
    if ($book->insight()->exists()) {
        $existingInsight = $book->insight;
        echo "   ℹ️  Insight existant (généré le " . $existingInsight->last_generated_at->format('d/m/Y H:i') . ")\n";
        
        if (!$existingInsight->needsRegeneration()) {
            echo "   ⏭️  Passer (insight récent)\n\n";
            $skipped++;
            $totalProcessed++;
            continue;
        }
        
        echo "   🔄 Régénération nécessaire...\n";
    }
    
    $bookStart = microtime(true);
    
    try {
        $insight = $summarizer->generateInsight($book);
        
        $bookTime = round(microtime(true) - $bookStart, 2);
        
        if ($insight) {
            echo "   ✅ Insight généré ! ({$bookTime}s)\n";
            echo "   📊 Résumé: " . substr($insight->reviews_summary, 0, 80) . "...\n";
            echo "   ✨ Points positifs: " . count($insight->positive_points) . "\n";
            echo "   ⚠️  Points négatifs: " . count($insight->negative_points) . "\n";
            $success++;
        } else {
            echo "   ❌ Échec de la génération ({$bookTime}s)\n";
            $failed++;
        }
        
    } catch (Exception $e) {
        echo "   ❌ Erreur : " . $e->getMessage() . "\n";
        $failed++;
    }
    
    $totalProcessed++;
    $progress = round(($totalProcessed / $totalBooks) * 100, 1);
    echo "   📈 Progression : {$totalProcessed}/{$totalBooks} ({$progress}%)\n\n";
    
    // Pause entre les livres (sauf le dernier)
    if ($totalProcessed < $totalBooks && $totalProcessed % $booksPerBatch === 0) {
        echo "   💤 Pause de {$pauseBetweenBooks}s...\n\n";
        sleep($pauseBetweenBooks);
    }
}

$totalTime = time() - $startTime;
$minutes = floor($totalTime / 60);
$seconds = $totalTime % 60;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   ✅ GÉNÉRATION TERMINÉE !                                 ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "📊 Résumé :\n";
echo "  • Total traité : {$totalProcessed}\n";
echo "  • ✅ Succès : {$success}\n";
echo "  • ❌ Échecs : {$failed}\n";
echo "  • ⏭️  Passés : {$skipped}\n";
echo "  • ⏱️  Temps total : {$minutes}m {$seconds}s\n";

if ($success > 0) {
    echo "  • ⚡ Temps moyen : " . round($totalTime / $success, 2) . "s par livre\n";
}

echo "\n👀 Consultez les résultats :\n";
echo "   • Page d'un livre : http://localhost/books/{id}\n";
echo "   • Le résumé AI s'affichera automatiquement\n\n";
