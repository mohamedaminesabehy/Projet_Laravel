<?php

/**
 * Test rapide de l'API Gemini
 * 
 * Usage: php test_gemini_quick.php
 */

require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\AI\GeminiService;
use App\Services\AI\SentimentAnalyzer;
use App\Models\Review;

echo "🧪 Test de l'API Google Gemini pour l'analyse de sentiment\n";
echo str_repeat("=", 60) . "\n\n";

// Test 1: Configuration
echo "1️⃣  Vérification de la configuration...\n";
$gemini = new GeminiService();

if (!$gemini->isConfigured()) {
    echo "   ❌ ERREUR: Gemini n'est pas configuré correctement\n";
    echo "   Vérifiez GEMINI_API_KEY dans votre fichier .env\n";
    exit(1);
}
echo "   ✅ Configuration OK\n\n";

// Test 2: Communication de base
echo "2️⃣  Test de communication avec Gemini...\n";
$response = $gemini->generateContent("Dis simplement 'Bonjour' en français");

if ($response && $response['success']) {
    echo "   ✅ Communication OK\n";
    echo "   Réponse: " . substr($response['text'], 0, 50) . "...\n\n";
} else {
    echo "   ❌ ERREUR: Impossible de communiquer avec Gemini\n";
    echo "   Vérifiez votre connexion internet et l'API key\n";
    exit(1);
}

// Test 3: Analyse de sentiment
echo "3️⃣  Test d'analyse de sentiment...\n";

// Créer un avis de test en mémoire
$testReview = new Review();
$testReview->id = 999;
$testReview->rating = 5;
$testReview->comment = "J'ai absolument adoré ce livre ! L'intrigue était captivante, les personnages attachants et le style d'écriture fluide. Une vraie pépite que je recommande à tous.";
$testReview->book = (object)[
    'title' => 'Le Test Book',
    'author' => 'Test Author'
];

$analyzer = new SentimentAnalyzer($gemini);
$analysis = $analyzer->analyze($testReview);

if ($analysis) {
    echo "   ✅ Analyse réussie !\n\n";
    echo "   📊 Résultats:\n";
    echo "   ├─ Sentiment: " . $analysis['sentiment_label'] . "\n";
    echo "   ├─ Score: " . number_format($analysis['sentiment_score'], 2) . "\n";
    echo "   ├─ Toxicité: " . number_format($analysis['toxicity_score'], 2) . "\n";
    echo "   ├─ Résumé: " . ($analysis['ai_summary'] ?? 'N/A') . "\n";
    echo "   ├─ Thèmes: " . implode(', ', $analysis['ai_topics'] ?? []) . "\n";
    echo "   ├─ Revue manuelle: " . ($analysis['requires_manual_review'] ? 'OUI ⚠️' : 'NON ✅') . "\n";
    echo "   └─ Confiance: " . number_format($analysis['confidence'], 2) . "\n\n";
} else {
    echo "   ❌ ERREUR lors de l'analyse\n";
    echo "   Vérifiez les logs dans storage/logs/laravel.log\n";
    exit(1);
}

// Test 4: Statistiques (si des reviews existent)
echo "4️⃣  Vérification de la base de données...\n";
$totalReviews = Review::count();
$analyzedReviews = Review::whereNotNull('analyzed_at')->count();

echo "   📈 Statistiques:\n";
echo "   ├─ Total d'avis: " . $totalReviews . "\n";
echo "   └─ Avis analysés: " . $analyzedReviews . "\n\n";

if ($analyzedReviews > 0) {
    $stats = [
        'positive' => Review::where('sentiment_label', 'positive')->count(),
        'neutral' => Review::where('sentiment_label', 'neutral')->count(),
        'negative' => Review::where('sentiment_label', 'negative')->count(),
    ];
    
    echo "   🎯 Répartition des sentiments:\n";
    echo "   ├─ Positifs: " . $stats['positive'] . "\n";
    echo "   ├─ Neutres: " . $stats['neutral'] . "\n";
    echo "   └─ Négatifs: " . $stats['negative'] . "\n\n";
}

// Résumé final
echo str_repeat("=", 60) . "\n";
echo "✅ TOUS LES TESTS SONT PASSÉS !\n\n";
echo "🎉 Le système d'analyse de sentiment est opérationnel.\n\n";
echo "📌 Prochaines étapes:\n";
echo "   1. Lancez le queue worker: php artisan queue:work\n";
echo "   2. Créez un nouvel avis via l'interface web\n";
echo "   3. Consultez l'analyse sur /admin/sentiment\n\n";
echo "💡 Astuce: Changez QUEUE_CONNECTION=sync dans .env\n";
echo "   pour que l'analyse soit immédiate (pas besoin de worker)\n";
echo str_repeat("=", 60) . "\n";
