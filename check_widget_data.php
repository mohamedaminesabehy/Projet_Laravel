<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Book;

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║   VÉRIFICATION DES DONNÉES DU WIDGET HOMEPAGE              ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Compter les livres avec insights
$booksWithInsights = Book::whereHas('insight')->count();
echo "📚 Livres avec insights AI : {$booksWithInsights}\n\n";

if ($booksWithInsights > 0) {
    echo "✅ Le widget devrait s'afficher !\n\n";
    
    // Afficher les 6 premiers livres qui seront montrés
    $topBooks = Book::with(['insight', 'reviews'])
        ->whereHas('insight')
        ->withCount('reviews')
        ->orderBy('reviews_count', 'desc')
        ->take(6)
        ->get();
    
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Top 6 livres qui s'afficheront dans le widget :\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    foreach ($topBooks as $index => $book) {
        $num = $index + 1;
        $dominantSentiment = $book->insight->getDominantSentiment();
        echo "{$num}. 📖 {$book->title}\n";
        echo "   👤 Auteur: {$book->author}\n";
        echo "   💬 Avis: {$book->reviews_count}\n";
        echo "   ⭐ Sentiment: " . ucfirst($dominantSentiment['sentiment']) . " ({$dominantSentiment['percentage']}%)\n";
        echo "   📝 Résumé: " . substr($book->insight->reviews_summary, 0, 80) . "...\n\n";
    }
    
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📍 Pour voir le widget :\n";
    echo "   1. Ouvrez http://localhost:8000\n";
    echo "   2. Scrollez juste après la bannière hero\n";
    echo "   3. Vous verrez la section violette avec les 6 cartes\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
} else {
    echo "❌ Aucun livre avec insight AI trouvé !\n";
    echo "⚠️  Le widget ne s'affichera pas.\n\n";
    echo "💡 Solution : Exécutez 'C:\\php\\php.exe generate_book_insights.php'\n";
}

echo "\n";
