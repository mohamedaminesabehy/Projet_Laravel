<?php
// Connexion directe à la base de données
$host = 'localhost';
$dbname = 'integ_laravel';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DIAGNOSTIC AI INSIGHTS ===\n\n";
    
    // Compter les avis
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM reviews");
    $totalReviews = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM reviews WHERE analyzed_at IS NOT NULL");
    $analyzedReviews = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "📝 AVIS :\n";
    echo "   Total : $totalReviews\n";
    echo "   Analysés : $analyzedReviews\n";
    echo "   Non analysés : " . ($totalReviews - $analyzedReviews) . "\n\n";
    
    // Compter les BookInsights
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM book_insights");
    $totalInsights = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "🤖 AI INSIGHTS :\n";
    echo "   Total : $totalInsights\n\n";
    
    // Afficher les 5 derniers avis
    $stmt = $pdo->query("
        SELECT r.id, r.book_id, r.rating, r.comment, r.created_at, r.analyzed_at,
               r.sentiment_label, r.sentiment_score,
               b.title as book_title
        FROM reviews r
        JOIN books b ON r.book_id = b.id
        ORDER BY r.created_at DESC
        LIMIT 5
    ");
    
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📋 5 DERNIERS AVIS :\n";
    echo str_repeat('-', 80) . "\n";
    foreach ($reviews as $review) {
        $analyzed = $review['analyzed_at'] ? '✅ ANALYSÉ' : '❌ NON ANALYSÉ';
        echo "ID {$review['id']} | Livre: {$review['book_title']}\n";
        echo "  Note: {$review['rating']}/5 | Créé: {$review['created_at']}\n";
        echo "  Status: $analyzed\n";
        if ($review['analyzed_at']) {
            echo "  Sentiment: {$review['sentiment_label']} (Score: {$review['sentiment_score']})\n";
        }
        echo "\n";
    }
    
    // Grouper les avis par livre
    $stmt = $pdo->query("
        SELECT book_id, 
               COUNT(*) as total_reviews,
               SUM(CASE WHEN analyzed_at IS NOT NULL THEN 1 ELSE 0 END) as analyzed_reviews,
               b.title as book_title
        FROM reviews r
        JOIN books b ON r.book_id = b.id
        GROUP BY book_id, b.title
        HAVING total_reviews >= 3
    ");
    
    $bookStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($bookStats) > 0) {
        echo "\n� LIVRES AVEC 3+ AVIS :\n";
        echo str_repeat('-', 80) . "\n";
        foreach ($bookStats as $stat) {
            echo "Livre ID {$stat['book_id']}: {$stat['book_title']}\n";
            echo "  Avis total: {$stat['total_reviews']}\n";
            echo "  Avis analysés: {$stat['analyzed_reviews']}\n";
            
            // Vérifier si BookInsight existe
            $stmtInsight = $pdo->prepare("SELECT id, last_generated_at FROM book_insights WHERE book_id = ?");
            $stmtInsight->execute([$stat['book_id']]);
            $insight = $stmtInsight->fetch(PDO::FETCH_ASSOC);
            
            if ($insight) {
                echo "  ✅ BookInsight existe (généré le {$insight['last_generated_at']})\n";
            } else {
                echo "  ❌ BookInsight MANQUANT!\n";
                if ($stat['analyzed_reviews'] >= 3) {
                    echo "  ⚠️  PROBLÈME: {$stat['analyzed_reviews']} avis analysés mais pas de BookInsight!\n";
                } else {
                    echo "  ℹ️  Raison: Seulement {$stat['analyzed_reviews']}/3 avis analysés\n";
                }
            }
            echo "\n";
        }
    } else {
        echo "\n⚠️  AUCUN livre n'a 3 avis ou plus\n\n";
    }
    
    // Vérifier la configuration de la queue
    $envFile = file_get_contents(__DIR__ . '/.env');
    if (preg_match('/QUEUE_CONNECTION=(.+)/', $envFile, $matches)) {
        $queueConnection = trim($matches[1]);
        echo "⚙️  CONFIGURATION :\n";
        echo "   QUEUE_CONNECTION = $queueConnection\n\n";
    }
    
    echo "=== FIN DU DIAGNOSTIC ===\n";
    
} catch (PDOException $e) {
    echo "❌ ERREUR DE CONNEXION : " . $e->getMessage() . "\n";
}
?>