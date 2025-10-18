<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "integ_laravel";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== TABLES EXISTANTES DANS LA BASE DE DONNÉES ===\n\n";
    
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📊 Total de tables : " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        echo "   • $table\n";
    }
    
    echo "\n=== FIN ===\n";
    
} catch(PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "\n";
}
?>
