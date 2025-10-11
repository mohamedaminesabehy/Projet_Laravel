<?php

require_once 'vendor/autoload.php';

// Boot Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

echo "=== Test des Catégories ===\n\n";

try {
    // Afficher les catégories existantes
    echo "Catégories existantes :\n";
    $categories = Category::all(['id', 'name', 'slug', 'color', 'icon', 'user_id', 'is_active']);
    
    if ($categories->count() > 0) {
        foreach ($categories as $category) {
            echo "- ID: {$category->id}, Nom: {$category->name}, Slug: {$category->slug}, User: {$category->user_id}\n";
        }
    } else {
        echo "Aucune catégorie trouvée.\n";
        
        // Créer des catégories de test
        echo "\nCréation de catégories de test...\n";
        
        $testCategories = [
            ['name' => 'Romans', 'description' => 'Livres de fiction', 'color' => '#D16655', 'icon' => 'fas fa-book'],
            ['name' => 'Sciences', 'description' => 'Livres scientifiques', 'color' => '#2E4A5B', 'icon' => 'fas fa-flask'],
            ['name' => 'Art', 'description' => 'Livres sur l\'art', 'color' => '#BD7579', 'icon' => 'fas fa-palette'],
        ];
        
        foreach ($testCategories as $categoryData) {
            $category = Category::create(array_merge($categoryData, [
                'is_active' => true,
                'user_id' => 1
            ]));
            echo "✅ Catégorie créée: {$category->name} (ID: {$category->id})\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n=== Test terminé ===\n";