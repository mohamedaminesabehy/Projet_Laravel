<?php

require_once 'vendor/autoload.php';

// Boot Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

echo "=== Slugs des Catégories ===\n\n";

try {
    $categories = Category::all(['id', 'name', 'slug']);
    
    foreach ($categories as $category) {
        echo "ID: {$category->id} - Nom: {$category->name} - Slug: {$category->slug}\n";
    }
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}

echo "\n=== Fin ===\n";