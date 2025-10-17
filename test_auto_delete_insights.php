<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use App\Models\BookInsight;
use App\Services\AI\SentimentAnalyzer;
use App\Services\AI\BookReviewSummarizer;

echo "=== TEST DE SUPPRESSION AUTOMATIQUE DES BOOKINSIGHTS ===\n\n";

// Récupérer le livre existant
$book = Book::first();
if (!$book) {
    die("Aucun livre trouvé. Veuillez d'abord créer un livre.\n");
}

echo "Livre: {$book->title}\n\n";

// Créer 3 utilisateurs de test
echo "1. Création de 3 utilisateurs de test...\n";
$users = [];
for ($i = 1; $i <= 3; $i++) {
    $users[] = User::create([
        'name' => "Testeur $i",
        'email' => "test{$i}_" . time() . "@example.com",
        'password' => bcrypt('password'),
    ]);
}
echo "   ✓ 3 utilisateurs créés\n\n";

// Créer 3 avis
echo "2. Création de 3 avis...\n";
$reviews = [];
$comments = [
    "Excellent livre, je recommande vivement !",
    "Très bon ouvrage, bien écrit.",
    "Un livre intéressant avec de bonnes idées."
];

foreach ($users as $index => $user) {
    $reviews[] = Review::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'rating' => 4 + ($index % 2), // 4 ou 5
        'comment' => $comments[$index],
        'is_approved' => true,
    ]);
}
echo "   ✓ 3 avis créés\n\n";

// Analyser les avis
echo "3. Analyse des avis avec Gemini AI...\n";
$geminiService = app(\App\Services\AI\GeminiService::class);
$analyzer = new SentimentAnalyzer($geminiService);
foreach ($reviews as $review) {
    $analyzer->analyze($review);
}
echo "   ✓ 3 avis analysés\n\n";

// Générer le BookInsight
echo "4. Génération du BookInsight...\n";
$summarizer = new BookReviewSummarizer($geminiService);
$insight = $summarizer->generateInsight($book);
if ($insight) {
    echo "   ✓ BookInsight créé (ID: {$insight->id})\n\n";
} else {
    die("   ✗ Échec de création du BookInsight\n");
}

// Vérification
echo "5. Vérification de l'état:\n";
$analyzedCount = $book->reviews()->whereNotNull('analyzed_at')->count();
$hasInsight = BookInsight::where('book_id', $book->id)->exists();
echo "   - Avis analysés: {$analyzedCount}\n";
echo "   - BookInsight existe: " . ($hasInsight ? "OUI" : "NON") . "\n\n";

// Test de suppression
echo "6. Test de suppression des avis un par un...\n";
foreach ($reviews as $index => $review) {
    $review->delete();
    $remaining = $book->reviews()->count();
    $analyzedRemaining = $book->reviews()->whereNotNull('analyzed_at')->count();
    $insightExists = BookInsight::where('book_id', $book->id)->exists();
    
    echo "   Après suppression de l'avis " . ($index + 1) . ":\n";
    echo "     - Avis restants: {$remaining}\n";
    echo "     - Avis analysés restants: {$analyzedRemaining}\n";
    echo "     - BookInsight existe: " . ($insightExists ? "OUI ✓" : "NON ✗") . "\n";
    
    if ($analyzedRemaining < 3 && $insightExists) {
        echo "     - ⚠️ ERREUR: BookInsight devrait être supprimé!\n";
    } else if ($analyzedRemaining < 3 && !$insightExists) {
        echo "     - ✓ OK: BookInsight correctement supprimé\n";
    }
    echo "\n";
}

// Nettoyage final
echo "7. Nettoyage final...\n";
foreach ($users as $user) {
    $user->delete();
}
echo "   ✓ Utilisateurs de test supprimés\n\n";

echo "=====================================\n";
echo "TEST TERMINÉ !\n";
echo "Résultat: BookInsight automatiquement supprimé quand < 3 avis analysés\n";
