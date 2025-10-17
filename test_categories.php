<?php

// Test simple pour vérifier le système de catégories
require_once 'vendor/autoload.php';

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// Test basique de connexion à la base de données
try {
    echo "=== Test du Système de Catégories ===\n\n";
    
    // Test 1: Vérifier la structure de la table
    echo "1. Vérification de la structure de la table categories...\n";
    $columns = DB::select("DESCRIBE categories");
    
    $expectedColumns = ['id', 'name', 'slug', 'description', 'color', 'icon', 'is_active', 'user_id', 'created_at', 'updated_at'];
    $actualColumns = array_column($columns, 'Field');
    
    $missing = array_diff($expectedColumns, $actualColumns);
    if (empty($missing)) {
        echo "✅ Toutes les colonnes sont présentes\n";
    } else {
        echo "❌ Colonnes manquantes: " . implode(', ', $missing) . "\n";
    }
    
    // Test 2: Vérifier les données existantes
    echo "\n2. Vérification des données existantes...\n";
    $categoriesCount = DB::table('categories')->count();
    echo "Nombre de catégories: {$categoriesCount}\n";
    
    if ($categoriesCount > 0) {
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            echo "- {$category->name} (ID: {$category->id}, User: {$category->user_id})\n";
        }
    }
    
    // Test 3: Vérifier les utilisateurs
    echo "\n3. Vérification des utilisateurs...\n";
    $usersCount = DB::table('users')->count();
    echo "Nombre d'utilisateurs: {$usersCount}\n";
    
    if ($usersCount > 0) {
        $users = DB::table('users')->get(['id', 'name', 'email']);
        foreach ($users as $user) {
            echo "- {$user->name} (ID: {$user->id})\n";
        }
    }
    
    echo "\n=== Tests terminés avec succès ===\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}