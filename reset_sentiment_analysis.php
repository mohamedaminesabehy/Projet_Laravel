<?php

/**
 * Script de réinitialisation des analyses de sentiment
 * Remet tous les avis à l'état "non analysé"
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Review;
use Illuminate\Support\Facades\DB;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   RÉINITIALISATION DES ANALYSES DE SENTIMENT              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Compter les avis actuellement analysés
$analyzedCount = Review::whereNotNull('analyzed_at')->count();
$totalReviews = Review::count();

echo "📊 État actuel :\n";
echo "  • Total des avis : {$totalReviews}\n";
echo "  • Avis analysés : {$analyzedCount}\n";
echo "  • Avis non analysés : " . ($totalReviews - $analyzedCount) . "\n\n";

if ($analyzedCount === 0) {
    echo "✅ Aucune analyse à réinitialiser !\n";
    exit(0);
}

echo "⚠️  Êtes-vous sûr de vouloir réinitialiser toutes les analyses ?\n";
echo "   Cette action va supprimer toutes les données d'analyse IA.\n\n";
echo "   Appuyez sur ENTRÉE pour continuer, ou CTRL+C pour annuler...\n";
// fgets(STDIN); // Décommenté si vous voulez une confirmation

echo "\n🔄 Réinitialisation en cours...\n\n";

// Réinitialiser tous les champs d'analyse
$updated = DB::table('reviews')->update([
    'sentiment_score' => null,
    'sentiment_label' => null,
    'toxicity_score' => null,
    'ai_summary' => null,
    'ai_topics' => null,
    'requires_manual_review' => false,
    'analyzed_at' => null,
]);

echo "✅ Réinitialisation terminée !\n\n";

// Vérifier l'état final
$finalAnalyzed = Review::whereNotNull('analyzed_at')->count();
$finalPending = Review::whereNull('analyzed_at')->count();

echo "📊 Nouvel état :\n";
echo "  • Avis analysés : {$finalAnalyzed}\n";
echo "  • Avis en attente d'analyse : {$finalPending}\n\n";

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   ✅ SUCCÈS !                                              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "👉 Prochaines étapes :\n";
echo "   1. Allez sur : http://localhost/admin/sentiment\n";
echo "   2. Vous verrez le badge avec {$finalPending} avis en attente\n";
echo "   3. Cliquez sur 'Analyser en masse' pour analyser 10 avis à la fois\n\n";
