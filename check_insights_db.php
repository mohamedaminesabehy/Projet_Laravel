<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "integ_laravel";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DIAGNOSTIC AI INSIGHTS DATABASE ===\n\n";
    
    // Compter les livres
    $stmt = $conn->query("SELECT COUNT(*) as count FROM books");
    $totalBooks = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "📚 Total de livres : $totalBooks\n";
    
    // Compter les avis
    $stmt = $conn->query("SELECT COUNT(*) as count FROM reviews");
    $totalReviews = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "📝 Total d'avis : $totalReviews\n";
    
    // Compter les avis analysés
    $stmt = $conn->query("SELECT COUNT(*) as count FROM reviews WHERE analyzed_at IS NOT NULL");
    $analyzedReviews = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "✅ Avis analysés : $analyzedReviews\n";
    
    // Compter les book_insights
    $stmt = $conn->query("SELECT COUNT(*) as count FROM book_insights");
    $totalInsights = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "💡 Total BookInsights : $totalInsights\n\n";
    
    // Liste des livres
    $stmt = $conn->query("
        SELECT b.id, b.title, b.author, 
               COUNT(r.id) as review_count,
               COUNT(CASE WHEN r.analyzed_at IS NOT NULL THEN 1 END) as analyzed_count,
               (SELECT COUNT(*) FROM book_insights WHERE book_id = b.id) as has_insight
        FROM books b
        LEFT JOIN reviews r ON r.book_id = b.id
        GROUP BY b.id, b.title, b.author
    ");
    
    echo "📖 Détails par livre :\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "   • Livre #{$row['id']} : {$row['title']}\n";
        echo "     Auteur : {$row['author']}\n";
        echo "     Avis total : {$row['review_count']}\n";
        echo "     Avis analysés : {$row['analyzed_count']}\n";
        echo "     BookInsight : " . ($row['has_insight'] > 0 ? '✅ Oui' : '❌ Non') . "\n\n";
    }
    
    echo "=== FIN DU DIAGNOSTIC ===\n";
    
} catch(PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "\n";
}
?>
