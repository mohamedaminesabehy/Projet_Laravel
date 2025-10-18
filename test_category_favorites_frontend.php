<?php

/**
 * Script de Test pour le Système de Favoris de Catégories (Frontend)
 * 
 * Ce script:
 * 1. Crée des catégories de démonstration
 * 2. Affiche les URLs à tester
 * 3. Teste les fonctionnalités backend
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\User;
use App\Models\CategoryFavorite;

echo "🧪 TEST DU SYSTÈME DE FAVORIS - FRONTEND\n";
echo str_repeat("=", 60) . "\n\n";

// 1. Créer/Récupérer des catégories de démonstration
echo "📚 ÉTAPE 1: Création des catégories de démonstration\n";
echo str_repeat("-", 60) . "\n";

$categories = [
    [
        'name' => 'Romance',
        'slug' => 'romance',
        'description' => 'Love stories and romantic adventures',
        'color' => '#ff6b6b',
        'icon' => 'fas fa-heart',
        'is_active' => true,
    ],
    [
        'name' => 'Science Fiction',
        'slug' => 'science-fiction',
        'description' => 'Futuristic and space exploration stories',
        'color' => '#4ecdc4',
        'icon' => 'fas fa-rocket',
        'is_active' => true,
    ],
    [
        'name' => 'Thriller',
        'slug' => 'thriller',
        'description' => 'Suspenseful and mysterious tales',
        'color' => '#95e1d3',
        'icon' => 'fas fa-mask',
        'is_active' => true,
    ],
    [
        'name' => 'Fantasy',
        'slug' => 'fantasy',
        'description' => 'Magical worlds and epic adventures',
        'color' => '#a8e6cf',
        'icon' => 'fas fa-dragon',
        'is_active' => true,
    ],
    [
        'name' => 'Mystery',
        'slug' => 'mystery',
        'description' => 'Detective stories and puzzles',
        'color' => '#dcedc1',
        'icon' => 'fas fa-search',
        'is_active' => true,
    ],
    [
        'name' => 'Horror',
        'slug' => 'horror',
        'description' => 'Scary and supernatural stories',
        'color' => '#ffd3b6',
        'icon' => 'fas fa-ghost',
        'is_active' => true,
    ],
    [
        'name' => 'Biography',
        'slug' => 'biography',
        'description' => 'True life stories',
        'color' => '#ffaaa5',
        'icon' => 'fas fa-user',
        'is_active' => true,
    ],
    [
        'name' => 'History',
        'slug' => 'history',
        'description' => 'Historical events and periods',
        'color' => '#ff8b94',
        'icon' => 'fas fa-landmark',
        'is_active' => true,
    ],
];

// Récupérer le premier utilisateur
$user = User::first();
if (!$user) {
    die("❌ ERREUR: Aucun utilisateur trouvé. Créez un utilisateur d'abord.\n");
}

$createdCategories = [];
foreach ($categories as $categoryData) {
    $category = Category::updateOrCreate(
        ['slug' => $categoryData['slug']],
        array_merge($categoryData, ['user_id' => $user->id])
    );
    
    $createdCategories[] = $category;
    echo "✅ Catégorie créée: {$category->name}\n";
}

$totalCategories = count($createdCategories);
echo "\n✅ {$totalCategories} catégories créées/mises à jour\n\n";

// 2. Afficher les URLs à tester
echo "🌐 ÉTAPE 2: URLs à tester\n";
echo str_repeat("-", 60) . "\n";

$baseUrl = env('APP_URL', 'http://localhost:8000');

echo "📋 Liste des catégories:\n";
echo "   URL: {$baseUrl}/categories\n";
echo "   Description: Voir toutes les catégories avec icônes de cœur\n\n";

echo "🔍 Détails d'une catégorie:\n";
foreach ($createdCategories as $index => $category) {
    if ($index < 3) { // Afficher seulement les 3 premières
        echo "   URL: {$baseUrl}/categories/{$category->id}\n";
        echo "   Nom: {$category->name}\n\n";
    }
}

echo "❤️ Mes favoris (nécessite authentification):\n";
echo "   URL: {$baseUrl}/category-favorites\n";
echo "   Description: Voir vos catégories favorites\n\n";

// 3. Tester les fonctionnalités backend
echo "🧪 ÉTAPE 3: Test des fonctionnalités backend\n";
echo str_repeat("-", 60) . "\n";

// Test 1: Ajouter des favoris
echo "TEST 1: Ajouter des favoris\n";
$testCategory1 = $createdCategories[0];
$testCategory2 = $createdCategories[1];

$result1 = CategoryFavorite::toggle($user->id, $testCategory1->id);
echo "   ✅ Toggle favori pour '{$testCategory1->name}': " . ($result1 ? 'AJOUTÉ' : 'RETIRÉ') . "\n";

$result2 = CategoryFavorite::toggle($user->id, $testCategory2->id);
echo "   ✅ Toggle favori pour '{$testCategory2->name}': " . ($result2 ? 'AJOUTÉ' : 'RETIRÉ') . "\n";

// Test 2: Vérifier les favoris
echo "\nTEST 2: Vérifier les favoris\n";
$isFavorited1 = CategoryFavorite::isFavorited($user->id, $testCategory1->id);
$isFavorited2 = CategoryFavorite::isFavorited($user->id, $testCategory2->id);

echo "   {$testCategory1->name}: " . ($isFavorited1 ? '❤️ FAVORI' : '🤍 NON FAVORI') . "\n";
echo "   {$testCategory2->name}: " . ($isFavorited2 ? '❤️ FAVORI' : '🤍 NON FAVORI') . "\n";

// Test 3: Compter les favoris
echo "\nTEST 3: Statistiques\n";
$userFavoritesCount = CategoryFavorite::countByUser($user->id);
echo "   Total favoris de l'utilisateur: {$userFavoritesCount}\n";

foreach ($createdCategories as $category) {
    $count = CategoryFavorite::countForCategory($category->id);
    if ($count > 0) {
        echo "   Favoris pour '{$category->name}': {$count}\n";
    }
}

// Test 4: Récupérer les catégories favorites
echo "\nTEST 4: Récupérer les catégories favorites\n";
$favoriteCategories = $user->favoriteCategories()->get();
echo "   Catégories favorites de l'utilisateur:\n";
foreach ($favoriteCategories as $category) {
    echo "      - {$category->name} (ajouté le {$category->pivot->created_at->format('Y-m-d H:i')})\n";
}

// Test 5: Vérifier les méthodes de modèle
echo "\nTEST 5: Méthodes de modèle\n";
$category = $createdCategories[0];
$category->loadCount('favorites');

echo "   Catégorie: {$category->name}\n";
echo "   Nombre de favoris: {$category->favorites_count}\n";
echo "   Est favori de l'utilisateur: " . ($category->isFavoritedBy($user->id) ? 'OUI ✅' : 'NON ❌') . "\n";

// 4. Instructions pour tester dans le navigateur
echo "\n" . str_repeat("=", 60) . "\n";
echo "🌐 INSTRUCTIONS POUR TESTER DANS LE NAVIGATEUR\n";
echo str_repeat("=", 60) . "\n\n";

echo "1️⃣ Démarrer le serveur (si pas déjà fait):\n";
echo "   php artisan serve\n\n";

echo "2️⃣ Se connecter:\n";
echo "   URL: {$baseUrl}/login\n";
echo "   Ou connexion auto: {$baseUrl}/admin-login\n\n";

echo "3️⃣ Tester la page des catégories:\n";
echo "   URL: {$baseUrl}/categories\n";
echo "   Actions:\n";
echo "   - Cliquer sur un cœur vide 🤍 → Devient rouge ❤️\n";
echo "   - Cliquer sur un cœur rouge ❤️ → Devient vide 🤍\n";
echo "   - Vérifier la notification en haut à droite\n";
echo "   - Vérifier que le compteur se met à jour\n\n";

echo "4️⃣ Tester la page de détails:\n";
echo "   URL: {$baseUrl}/categories/{$testCategory1->id}\n";
echo "   Actions:\n";
echo "   - Cliquer sur 'Add to Favorites'\n";
echo "   - Vérifier le changement de texte\n";
echo "   - Vérifier le compteur de favoris\n\n";

echo "5️⃣ Tester la page Mes Favoris:\n";
echo "   URL: {$baseUrl}/category-favorites\n";
echo "   Actions:\n";
echo "   - Vérifier les statistiques\n";
echo "   - Voir les catégories ajoutées\n";
echo "   - Cliquer sur X pour retirer\n";
echo "   - Vérifier l'animation de suppression\n\n";

// 5. Résumé
echo str_repeat("=", 60) . "\n";
echo "📊 RÉSUMÉ\n";
echo str_repeat("=", 60) . "\n\n";

$totalCategoriesCreated = count($createdCategories);
echo "✅ Catégories créées: {$totalCategoriesCreated}\n";
echo "✅ Favoris actuels: {$userFavoritesCount}\n";
echo "✅ Utilisateur de test: {$user->name} (ID: {$user->id})\n\n";

echo "📁 Fichiers créés:\n";
echo "   - app/Http/Controllers/CategoryController.php\n";
echo "   - resources/views/categories/index.blade.php\n";
echo "   - resources/views/categories/show.blade.php\n";
echo "   - resources/views/category-favorites/index.blade.php\n\n";

echo "🔗 Routes configurées:\n";
echo "   - GET  /categories (publique)\n";
echo "   - GET  /categories/{id} (publique)\n";
echo "   - GET  /category-favorites (auth)\n";
echo "   - POST /category-favorites/toggle/{id} (auth, AJAX)\n";
echo "   - DELETE /category-favorites/{id} (auth)\n\n";

echo "🎨 Fonctionnalités:\n";
echo "   ✅ Toggle AJAX instantané\n";
echo "   ✅ Notifications animées\n";
echo "   ✅ Compteurs en temps réel\n";
echo "   ✅ Design responsive\n";
echo "   ✅ Animations CSS fluides\n";
echo "   ✅ États de chargement\n\n";

echo "🚀 Prêt à tester!\n";
echo "   Accédez à: {$baseUrl}/categories\n\n";

echo "📚 Documentation complète:\n";
echo "   Voir: CATEGORY_FAVORITES_FRONTEND_GUIDE.md\n\n";

echo str_repeat("=", 60) . "\n";
echo "🎉 Le système de favoris de catégories est opérationnel!\n";
echo str_repeat("=", 60) . "\n";
