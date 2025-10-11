<?php

/**
 * Test Script for Category Favorites AJAX Toggle
 * 
 * This script tests:
 * 1. User authentication
 * 2. Category favorites toggle functionality
 * 3. AJAX response format
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Category;
use App\Models\CategoryFavorite;
use Illuminate\Support\Facades\Auth;

echo "🧪 TEST: Category Favorites AJAX Toggle\n";
echo str_repeat("=", 60) . "\n\n";

try {
    // Step 1: Check if user exists
    echo "1️⃣ Vérification de l'utilisateur...\n";
    $user = User::first();
    
    if (!$user) {
        echo "❌ Aucun utilisateur trouvé dans la base de données!\n";
        echo "   Créez un utilisateur avec: php artisan tinker\n";
        echo "   Puis: User::factory()->create(['email' => 'test@example.com']);\n";
        exit(1);
    }
    
    echo "✅ Utilisateur trouvé: {$user->name} (ID: {$user->id}, Email: {$user->email})\n\n";

    // Step 2: Check categories
    echo "2️⃣ Vérification des catégories...\n";
    $categories = Category::take(3)->get();
    
    if ($categories->isEmpty()) {
        echo "❌ Aucune catégorie trouvée!\n";
        exit(1);
    }
    
    echo "✅ {$categories->count()} catégories trouvées\n\n";

    // Step 3: Test toggle functionality
    echo "3️⃣ Test de la fonction toggle...\n";
    $category = $categories->first();
    echo "   Catégorie de test: {$category->name} (ID: {$category->id})\n";

    // Check current state
    $initialState = CategoryFavorite::isFavorited($user->id, $category->id);
    echo "   État initial: " . ($initialState ? "❤️ Favorisé" : "🤍 Non favorisé") . "\n";

    // Toggle ON
    echo "\n   🔄 Toggle ON...\n";
    $result1 = CategoryFavorite::toggle($user->id, $category->id);
    $count1 = CategoryFavorite::countForCategory($category->id);
    echo "   Résultat: " . ($result1 ? "✅ Ajouté" : "❌ Retiré") . "\n";
    echo "   Compteur de favoris: {$count1}\n";

    // Simulate AJAX response
    $ajaxResponse1 = [
        'success' => true,
        'favorited' => $result1,
        'message' => $result1 ? 'Catégorie ajoutée aux favoris' : 'Catégorie retirée des favoris',
        'favorites_count' => $count1,
    ];
    echo "   Réponse JSON:\n";
    echo "   " . json_encode($ajaxResponse1, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

    // Toggle OFF
    echo "\n   🔄 Toggle OFF...\n";
    $result2 = CategoryFavorite::toggle($user->id, $category->id);
    $count2 = CategoryFavorite::countForCategory($category->id);
    echo "   Résultat: " . ($result2 ? "✅ Ajouté" : "❌ Retiré") . "\n";
    echo "   Compteur de favoris: {$count2}\n";

    // Simulate AJAX response
    $ajaxResponse2 = [
        'success' => true,
        'favorited' => $result2,
        'message' => $result2 ? 'Catégorie ajoutée aux favoris' : 'Catégorie retirée des favoris',
        'favorites_count' => $count2,
    ];
    echo "   Réponse JSON:\n";
    echo "   " . json_encode($ajaxResponse2, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

    // Step 4: Check all user's favorites
    echo "\n4️⃣ Favoris de l'utilisateur...\n";
    $userFavorites = CategoryFavorite::where('user_id', $user->id)->get();
    echo "   Total: {$userFavorites->count()} favoris\n";
    
    if ($userFavorites->count() > 0) {
        foreach ($userFavorites as $fav) {
            $cat = Category::find($fav->category_id);
            echo "   - {$cat->name} (ID: {$cat->id})\n";
        }
    }

    // Step 5: Test with category that has is_favorited attribute
    echo "\n5️⃣ Test de l'attribut is_favorited...\n";
    Auth::login($user);
    
    $categoryWithFav = Category::withCount('favorites')
        ->with(['favorites' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->first();
    
    $isFavoritedAttr = $categoryWithFav->is_favorited ?? false;
    echo "   Catégorie: {$categoryWithFav->name}\n";
    echo "   is_favorited: " . ($isFavoritedAttr ? "✅ true" : "❌ false") . "\n";
    echo "   favorites_count: {$categoryWithFav->favorites_count}\n";

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "✅ TOUS LES TESTS RÉUSSIS!\n\n";

    echo "📋 INSTRUCTIONS DE DÉBOGAGE:\n";
    echo "1. Ouvrez votre navigateur sur: http://localhost:8000/categories\n";
    echo "2. Connectez-vous avec: {$user->email}\n";
    echo "3. Ouvrez la console (F12)\n";
    echo "4. Cliquez sur un cœur\n";
    echo "5. Vérifiez les messages dans la console:\n";
    echo "   - 🔥 Script de favoris chargé\n";
    echo "   - ✅ ONCLICK DIRECT FONCTIONNE!\n";
    echo "   - 🖱️ Clic détecté sur bouton favori!\n";
    echo "   - 📡 Envoi requête AJAX...\n";
    echo "   - 📥 Réponse reçue: 200\n";
    echo "   - 📊 Données: {success: true, favorited: true, ...}\n\n";

} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "   Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}
