<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\CategoryFavorite;

echo "═══════════════════════════════════════════════════════\n";
echo "🔍 DIAGNOSTIC SYSTÈME DE FAVORIS\n";
echo "═══════════════════════════════════════════════════════\n\n";

// 1. Vérifier les tables
echo "📊 1. VÉRIFICATION DES TABLES\n";
echo "---------------------------------------------------\n";
$tables = DB::select('SHOW TABLES');
$tableNames = array_map(function($table) {
    $values = array_values((array)$table);
    return $values[0];
}, $tables);

$requiredTables = ['users', 'categories', 'category_favorites'];
foreach ($requiredTables as $table) {
    $exists = in_array($table, $tableNames);
    echo ($exists ? "✅" : "❌") . " Table '$table': " . ($exists ? "existe" : "MANQUANTE") . "\n";
}
echo "\n";

// 2. Vérifier les données
echo "📦 2. VÉRIFICATION DES DONNÉES\n";
echo "---------------------------------------------------\n";
$usersCount = DB::table('users')->count();
$categoriesCount = DB::table('categories')->count();
$favoritesCount = DB::table('category_favorites')->count();

echo "👥 Utilisateurs: $usersCount\n";
echo "📚 Catégories: $categoriesCount\n";
echo "❤️  Favoris: $favoritesCount\n\n";

// 3. Tester les modèles
echo "🧪 3. TEST DES MODÈLES\n";
echo "---------------------------------------------------\n";

try {
    // Test User model
    $user = User::first();
    if ($user) {
        echo "✅ User model: OK (ID: {$user->id}, Email: {$user->email})\n";
        
        // Test relations
        try {
            $favs = $user->categoryFavorites;
            echo "✅ User->categoryFavorites(): OK ({$favs->count()} favoris)\n";
        } catch (Exception $e) {
            echo "❌ User->categoryFavorites(): ERREUR - " . $e->getMessage() . "\n";
        }
        
        try {
            $favCats = $user->favoriteCategories;
            echo "✅ User->favoriteCategories(): OK ({$favCats->count()} catégories)\n";
        } catch (Exception $e) {
            echo "❌ User->favoriteCategories(): ERREUR - " . $e->getMessage() . "\n";
        }
    } else {
        echo "⚠️  Aucun utilisateur trouvé\n";
    }
} catch (Exception $e) {
    echo "❌ User model: ERREUR - " . $e->getMessage() . "\n";
}

try {
    // Test Category model
    $category = Category::first();
    if ($category) {
        echo "✅ Category model: OK (ID: {$category->id}, Nom: {$category->name})\n";
        
        // Test relations
        try {
            $favs = $category->favorites;
            echo "✅ Category->favorites(): OK ({$favs->count()} favoris)\n";
        } catch (Exception $e) {
            echo "❌ Category->favorites(): ERREUR - " . $e->getMessage() . "\n";
        }
        
        try {
            $users = $category->favoritedBy;
            echo "✅ Category->favoritedBy(): OK ({$users->count()} utilisateurs)\n";
        } catch (Exception $e) {
            echo "❌ Category->favoritedBy(): ERREUR - " . $e->getMessage() . "\n";
        }
    } else {
        echo "⚠️  Aucune catégorie trouvée\n";
    }
} catch (Exception $e) {
    echo "❌ Category model: ERREUR - " . $e->getMessage() . "\n";
}

try {
    // Test CategoryFavorite model
    $favorite = CategoryFavorite::first();
    if ($favorite) {
        echo "✅ CategoryFavorite model: OK (ID: {$favorite->id})\n";
    } else {
        echo "⚠️  Aucun favori trouvé\n";
    }
} catch (Exception $e) {
    echo "❌ CategoryFavorite model: ERREUR - " . $e->getMessage() . "\n";
}

echo "\n";

// 4. Tester les méthodes statiques
echo "🔧 4. TEST DES MÉTHODES STATIQUES\n";
echo "---------------------------------------------------\n";

if ($user && $category) {
    try {
        $isFavorited = CategoryFavorite::isFavorited($user->id, $category->id);
        echo "✅ CategoryFavorite::isFavorited(): OK (Résultat: " . ($isFavorited ? "OUI" : "NON") . ")\n";
    } catch (Exception $e) {
        echo "❌ CategoryFavorite::isFavorited(): ERREUR - " . $e->getMessage() . "\n";
    }
    
    try {
        $count = CategoryFavorite::countForCategory($category->id);
        echo "✅ CategoryFavorite::countForCategory(): OK (Nombre: $count)\n";
    } catch (Exception $e) {
        echo "❌ CategoryFavorite::countForCategory(): ERREUR - " . $e->getMessage() . "\n";
    }
    
    try {
        $count = CategoryFavorite::countByUser($user->id);
        echo "✅ CategoryFavorite::countByUser(): OK (Nombre: $count)\n";
    } catch (Exception $e) {
        echo "❌ CategoryFavorite::countByUser(): ERREUR - " . $e->getMessage() . "\n";
    }
}

echo "\n";

// 5. Tester la structure de la table
echo "🏗️  5. STRUCTURE DE LA TABLE category_favorites\n";
echo "---------------------------------------------------\n";
$columns = DB::select("DESCRIBE category_favorites");
foreach ($columns as $col) {
    echo "  • {$col->Field} ({$col->Type}) " . ($col->Null === 'NO' ? '[REQUIS]' : '[OPTIONNEL]') . "\n";
}

echo "\n";

// 6. Afficher un exemple de données
echo "📝 6. EXEMPLES DE DONNÉES\n";
echo "---------------------------------------------------\n";
$examples = DB::table('category_favorites')->limit(5)->get();
if ($examples->count() > 0) {
    foreach ($examples as $ex) {
        echo "  ID: {$ex->id} | User: {$ex->user_id} | Category: {$ex->category_id} | Créé: {$ex->created_at}\n";
    }
} else {
    echo "  ⚠️  Aucun favori en base de données\n";
}

echo "\n";

// 7. Test de création d'un favori
echo "➕ 7. TEST DE CRÉATION DE FAVORI\n";
echo "---------------------------------------------------\n";

if ($user && $category) {
    try {
        // Vérifier d'abord si le favori existe
        $exists = CategoryFavorite::where('user_id', $user->id)
                                  ->where('category_id', $category->id)
                                  ->exists();
        
        if ($exists) {
            echo "ℹ️  Un favori existe déjà pour User {$user->id} et Category {$category->id}\n";
        } else {
            // Créer un favori de test
            $favorite = CategoryFavorite::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);
            echo "✅ Favori créé avec succès! (ID: {$favorite->id})\n";
            
            // Supprimer immédiatement pour ne pas polluer
            $favorite->delete();
            echo "🗑️  Favori de test supprimé\n";
        }
    } catch (Exception $e) {
        echo "❌ Erreur lors de la création: " . $e->getMessage() . "\n";
        echo "📋 Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
}

echo "\n═══════════════════════════════════════════════════════\n";
echo "✨ FIN DU DIAGNOSTIC\n";
echo "═══════════════════════════════════════════════════════\n";
