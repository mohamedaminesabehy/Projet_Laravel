<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Book;
use App\Models\Review;
use App\Models\BookInsight;
use App\Models\User;

echo "=== TEST SUPPRESSION DYNAMIQUE DES BOOKINSIGHTS ===\n\n";

// 1. Trouver ou créer un livre
$book = Book::first();
if (!$book) {
    echo "❌ Aucun livre trouvé. Créez un livre d'abord.\n";
    exit;
}

echo "📚 Livre utilisé: " . $book->title . " (ID: {$book->id})\n\n";

// 2. Vérifier l'état actuel
$reviewCount = $book->reviews()->count();
$analyzedCount = $book->reviews()->whereNotNull('analyzed_at')->count();
$hasInsight = BookInsight::where('book_id', $book->id)->exists();

echo "État AVANT le test:\n";
echo "  - Total avis: $reviewCount\n";
echo "  - Avis analysés: $analyzedCount\n";
echo "  - BookInsight existe: " . ($hasInsight ? "✅ OUI" : "❌ NON") . "\n\n";

// 3. Si pas assez d'avis, créer des avis de test
$users = User::limit(5)->get();
if ($users->count() === 0) {
    echo "❌ Aucun utilisateur trouvé.\n";
    exit;
}

// Créer 3 avis analysés si nécessaire (avec des utilisateurs différents)
$userIndex = 0;
while ($analyzedCount < 3) {
    // Utiliser un utilisateur différent pour chaque avis
    $user = $users[$userIndex % $users->count()];
    
    // Vérifier si cet utilisateur a déjà un avis sur ce livre
    $existingReview = Review::where('book_id', $book->id)
        ->where('user_id', $user->id)
        ->first();
    
    if (!$existingReview) {
        $review = Review::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rating' => rand(3, 5),
            'comment' => 'Test review ' . ($analyzedCount + 1),
            'is_approved' => true,
            'analyzed_at' => now(),
            'sentiment_score' => 0.8,
            'sentiment_label' => 'positive',
        ]);
        $analyzedCount++;
        echo "✅ Avis de test #{$analyzedCount} créé (ID: {$review->id}, User: {$user->id})\n";
    }
    
    $userIndex++;
    
    // Éviter une boucle infinie
    if ($userIndex > $users->count() * 3) {
        echo "⚠️  Pas assez d'utilisateurs disponibles pour créer 3 avis.\n";
        break;
    }
}

// 4. Créer un BookInsight si nécessaire
if (!$hasInsight) {
    BookInsight::create([
        'book_id' => $book->id,
        'summary' => 'Résumé de test généré',
        'positive_aspects' => ['Test 1', 'Test 2'],
        'negative_aspects' => ['Test négatif'],
        'average_sentiment' => 0.75,
        'total_reviews_analyzed' => $analyzedCount,
    ]);
    echo "✅ BookInsight de test créé\n\n";
}

// 5. Rafraîchir l'état
$book->refresh();
$reviewCount = $book->reviews()->count();
$analyzedCount = $book->reviews()->whereNotNull('analyzed_at')->count();
$hasInsight = BookInsight::where('book_id', $book->id)->exists();

echo "État APRÈS préparation:\n";
echo "  - Total avis: $reviewCount\n";
echo "  - Avis analysés: $analyzedCount\n";
echo "  - BookInsight existe: " . ($hasInsight ? "✅ OUI" : "❌ NON") . "\n\n";

// 6. TEST: Supprimer les avis un par un jusqu'à < 3
echo "=== DÉBUT DU TEST DE SUPPRESSION ===\n\n";

$reviews = $book->reviews()->whereNotNull('analyzed_at')->get();

foreach ($reviews as $index => $review) {
    $remainingBefore = $book->reviews()->whereNotNull('analyzed_at')->count();
    
    echo "📌 Suppression de l'avis ID: {$review->id}\n";
    echo "   Avis analysés AVANT suppression: $remainingBefore\n";
    
    // Supprimer l'avis (ceci devrait déclencher l'événement deleted)
    $review->delete();
    
    // Vérifier l'état après
    $book->refresh();
    $remainingAfter = $book->reviews()->whereNotNull('analyzed_at')->count();
    $insightExists = BookInsight::where('book_id', $book->id)->exists();
    
    echo "   Avis analysés APRÈS suppression: $remainingAfter\n";
    echo "   BookInsight existe: " . ($insightExists ? "✅ OUI" : "❌ NON") . "\n";
    
    // Vérifier la logique
    if ($remainingAfter < 3 && $insightExists) {
        echo "   ⚠️  PROBLÈME: BookInsight devrait être supprimé!\n";
    } elseif ($remainingAfter < 3 && !$insightExists) {
        echo "   ✅ SUCCÈS: BookInsight supprimé automatiquement!\n";
    }
    
    echo "\n";
    
    // Si on descend sous 3, arrêter
    if ($remainingAfter < 3) {
        echo "🎯 Test terminé: Moins de 3 avis analysés atteint.\n";
        break;
    }
}

// 7. État final
echo "\n=== ÉTAT FINAL ===\n";
$finalReviews = $book->reviews()->whereNotNull('analyzed_at')->count();
$finalInsight = BookInsight::where('book_id', $book->id)->exists();

echo "Avis analysés restants: $finalReviews\n";
echo "BookInsight existe: " . ($finalInsight ? "✅ OUI" : "❌ NON") . "\n\n";

if ($finalReviews < 3 && !$finalInsight) {
    echo "✅ ✅ ✅ TEST RÉUSSI! La suppression automatique fonctionne correctement.\n";
} elseif ($finalReviews < 3 && $finalInsight) {
    echo "❌ ❌ ❌ TEST ÉCHOUÉ! Le BookInsight persiste alors qu'il devrait être supprimé.\n";
    echo "\n⚠️  DIAGNOSTIC:\n";
    echo "Le code dans Review.php n'est peut-être pas actif.\n";
    echo "Vérifiez que le fichier app/Models/Review.php contient bien la méthode booted().\n";
} else {
    echo "ℹ️  Test incomplet: Il reste $finalReviews avis analysés (>= 3).\n";
}
