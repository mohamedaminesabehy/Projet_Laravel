<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\Review;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Diagnostic des avis pour l'analyse de sentiment ===\n\n";

// 1. Vérifier le nombre total d'avis
$totalReviews = Review::count();
echo "1. Total des avis en base: {$totalReviews}\n";

// 2. Vérifier les avis analysés vs non analysés
$analyzedReviews = Review::whereNotNull('analyzed_at')->count();
$unanalyzedReviews = Review::whereNull('analyzed_at')->count();

echo "2. Avis analysés: {$analyzedReviews}\n";
echo "3. Avis non analysés: {$unanalyzedReviews}\n\n";

// 3. Afficher les détails des avis non analysés
if ($unanalyzedReviews > 0) {
    echo "=== Détails des avis non analysés ===\n";
    $reviews = Review::whereNull('analyzed_at')->with(['book', 'user'])->get();
    
    foreach ($reviews as $review) {
        echo "ID: {$review->id}\n";
        echo "Livre: " . ($review->book ? $review->book->title : 'N/A') . "\n";
        echo "Utilisateur: " . ($review->user ? $review->user->name : 'N/A') . "\n";
        echo "Note: {$review->rating}/5\n";
        echo "Commentaire: " . substr($review->comment, 0, 100) . "...\n";
        echo "Créé le: {$review->created_at}\n";
        echo "Approuvé: " . ($review->is_approved ? 'Oui' : 'Non') . "\n";
        echo "---\n";
    }
}

// 4. Vérifier la configuration Gemini
echo "\n=== Configuration Gemini ===\n";
$geminiKey = env('GEMINI_API_KEY');
$geminiModel = env('GEMINI_MODEL');

echo "GEMINI_API_KEY: " . ($geminiKey ? 'Configuré (' . substr($geminiKey, 0, 10) . '...)' : 'NON CONFIGURÉ') . "\n";
echo "GEMINI_MODEL: " . ($geminiModel ?: 'NON CONFIGURÉ') . "\n";

// 5. Vérifier les jobs en attente
try {
    $pendingJobs = \Illuminate\Support\Facades\DB::table('jobs')->count();
    echo "\n=== Jobs en attente ===\n";
    echo "Jobs en queue: {$pendingJobs}\n";
} catch (Exception $e) {
    echo "\nErreur lors de la vérification des jobs: " . $e->getMessage() . "\n";
}

echo "\n=== Fin du diagnostic ===\n";