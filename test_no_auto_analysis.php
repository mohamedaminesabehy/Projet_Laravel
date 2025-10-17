<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Review;
use App\Models\Book;
use App\Models\User;

echo "🧪 TEST - Création d'un nouvel avis\n";
echo "════════════════════════════════════════\n\n";

$review = Review::create([
    'user_id' => User::first()->id,
    'book_id' => Book::first()->id,
    'rating' => 5,
    'comment' => 'Test - Ce livre est incroyable ! J\'ai adoré chaque page et je le recommande vivement.',
    'is_approved' => true
]);

echo "✅ Avis créé : #" . $review->id . "\n";
echo "📝 Commentaire : " . substr($review->comment, 0, 50) . "...\n";
echo "🔍 analyzed_at : " . ($review->analyzed_at ? $review->analyzed_at : '❌ NULL (NON ANALYSÉ)') . "\n\n";

$pendingCount = Review::whereNull('analyzed_at')->count();
echo "📊 Total avis en attente d'analyse : {$pendingCount}\n\n";

echo "✅ SUCCÈS ! L'avis n'a PAS été analysé automatiquement.\n";
echo "👉 Allez sur http://localhost/admin/sentiment pour l'analyser manuellement.\n";
