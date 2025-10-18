<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Review;

// Récupérer le premier avis
$firstReview = Review::orderBy('created_at', 'asc')->first();
$totalReviews = Review::count();

echo "Total avis: $totalReviews\n";
echo "Premier avis créé le: " . ($firstReview ? $firstReview->created_at : 'Aucun avis trouvé') . "\n";

if ($firstReview) {
    echo "Premier avis ID: " . $firstReview->id . "\n";
    echo "Premier avis créé par: User ID " . $firstReview->user_id . "\n";
}
