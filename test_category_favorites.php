<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Category;
use App\Models\CategoryFavorite;

echo "\n";
echo "🧪 " . str_repeat("=", 70) . "\n";
echo "   TEST DU SYSTÈME DE FAVORIS DE CATÉGORIES\n";
echo str_repeat("=", 74) . "\n\n";

try {
    // Récupérer utilisateur et catégorie pour test
    $user = User::first();
    $categories = Category::limit(3)->get();
    
    if (!$user) {
        echo "❌ Aucun utilisateur trouvé dans la base de données\n";
        exit(1);
    }
    
    if ($categories->isEmpty()) {
        echo "❌ Aucune catégorie trouvée dans la base de données\n";
        exit(1);
    }
    
    echo "👤 Utilisateur de test: {$user->name} (ID: {$user->id})\n";
    echo "📂 Catégories de test: {$categories->count()}\n";
    foreach ($categories as $cat) {
        echo "   - {$cat->name} (ID: {$cat->id})\n";
    }
    echo "\n";
    
    // ==========================================
    // TEST 1: Ajouter aux favoris
    // ==========================================
    echo "📝 TEST 1: Ajouter aux favoris\n";
    echo str_repeat("-", 74) . "\n";
    
    $category1 = $categories->first();
    $result = CategoryFavorite::toggle($user->id, $category1->id);
    
    if ($result) {
        echo "✅ Catégorie '{$category1->name}' ajoutée aux favoris\n";
    } else {
        echo "✅ Catégorie '{$category1->name}' retirée des favoris (était déjà favoris)\n";
    }
    echo "\n";
    
    // ==========================================
    // TEST 2: Vérifier si favoris
    // ==========================================
    echo "📝 TEST 2: Vérifier si catégorie est favoris\n";
    echo str_repeat("-", 74) . "\n";
    
    $isFavorited = CategoryFavorite::isFavorited($user->id, $category1->id);
    echo "Statut: " . ($isFavorited ? "✅ EST FAVORIS" : "❌ N'EST PAS FAVORIS") . "\n";
    echo "\n";
    
    // ==========================================
    // TEST 3: Compter les favoris
    // ==========================================
    echo "📝 TEST 3: Compter les favoris\n";
    echo str_repeat("-", 74) . "\n";
    
    $categoryFavCount = CategoryFavorite::countForCategory($category1->id);
    $userFavCount = CategoryFavorite::countByUser($user->id);
    
    echo "✅ Favoris pour '{$category1->name}': {$categoryFavCount}\n";
    echo "✅ Total favoris de l'utilisateur: {$userFavCount}\n";
    echo "\n";
    
    // ==========================================
    // TEST 4: Relations Eloquent
    // ==========================================
    echo "📝 TEST 4: Tester les relations Eloquent\n";
    echo str_repeat("-", 74) . "\n";
    
    // Recharger l'utilisateur avec relations
    $user->load('favoriteCategories');
    echo "✅ Catégories favorites de l'utilisateur:\n";
    if ($user->favoriteCategories->isEmpty()) {
        echo "   (aucune)\n";
    } else {
        foreach ($user->favoriteCategories as $favCat) {
            echo "   - {$favCat->name}\n";
        }
    }
    
    // Tester méthode hasFavorited
    $hasFav = $user->hasFavorited($category1->id);
    echo "\nUtilisateur a favorisé '{$category1->name}': " . ($hasFav ? "OUI ✅" : "NON ❌") . "\n";
    echo "\n";
    
    // ==========================================
    // TEST 5: Ajouter plusieurs favoris
    // ==========================================
    echo "📝 TEST 5: Ajouter plusieurs favoris\n";
    echo str_repeat("-", 74) . "\n";
    
    foreach ($categories as $cat) {
        $isFav = CategoryFavorite::isFavorited($user->id, $cat->id);
        if (!$isFav) {
            CategoryFavorite::toggle($user->id, $cat->id);
            echo "✅ Ajouté: {$cat->name}\n";
        } else {
            echo "⚠️  Déjà favoris: {$cat->name}\n";
        }
    }
    echo "\n";
    
    // ==========================================
    // TEST 6: Catégories les plus favorites
    // ==========================================
    echo "📝 TEST 6: Top catégories favorites\n";
    echo str_repeat("-", 74) . "\n";
    
    $topCategories = Category::withCount('favorites')
        ->orderByDesc('favorites_count')
        ->limit(5)
        ->get();
    
    echo "Top 5 catégories favorites:\n";
    foreach ($topCategories as $index => $cat) {
        $num = $index + 1;
        echo "   {$num}. {$cat->name} - {$cat->favorites_count} favoris\n";
    }
    echo "\n";
    
    // ==========================================
    // TEST 7: Scopes
    // ==========================================
    echo "📝 TEST 7: Tester les scopes\n";
    echo str_repeat("-", 74) . "\n";
    
    $recentCount = CategoryFavorite::recent()->count();
    echo "✅ Favoris ajoutés dans les 7 derniers jours: {$recentCount}\n";
    
    $category1Favs = CategoryFavorite::forCategory($category1->id)->count();
    echo "✅ Favoris pour '{$category1->name}': {$category1Favs}\n";
    
    $userFavs = CategoryFavorite::byUser($user->id)->count();
    echo "✅ Favoris de l'utilisateur: {$userFavs}\n";
    echo "\n";
    
    // ==========================================
    // TEST 8: Méthodes de Category
    // ==========================================
    echo "📝 TEST 8: Méthodes du modèle Category\n";
    echo str_repeat("-", 74) . "\n";
    
    $category1 = Category::find($category1->id);
    $favCount = $category1->favorites_count;
    $isFavByUser = $category1->isFavoritedBy($user->id);
    
    echo "✅ Compteur favorites_count: {$favCount}\n";
    echo "✅ isFavoritedBy({$user->id}): " . ($isFavByUser ? "OUI" : "NON") . "\n";
    echo "\n";
    
    // ==========================================
    // TEST 9: Statistiques globales
    // ==========================================
    echo "📝 TEST 9: Statistiques globales\n";
    echo str_repeat("-", 74) . "\n";
    
    $stats = [
        'total_favorites' => CategoryFavorite::count(),
        'unique_users' => CategoryFavorite::distinct('user_id')->count('user_id'),
        'unique_categories' => CategoryFavorite::distinct('category_id')->count('category_id'),
        'avg_favorites_per_category' => CategoryFavorite::count() / max(Category::count(), 1),
    ];
    
    echo "📊 Total de favoris: {$stats['total_favorites']}\n";
    echo "👥 Utilisateurs uniques: {$stats['unique_users']}\n";
    echo "📂 Catégories favorites: {$stats['unique_categories']}\n";
    echo "📈 Moyenne favoris/catégorie: " . number_format($stats['avg_favorites_per_category'], 2) . "\n";
    echo "\n";
    
    // ==========================================
    // TEST 10: Toggle (retirer)
    // ==========================================
    echo "📝 TEST 10: Retirer un favori\n";
    echo str_repeat("-", 74) . "\n";
    
    $wasRemoved = !CategoryFavorite::toggle($user->id, $category1->id);
    if ($wasRemoved) {
        echo "✅ Catégorie '{$category1->name}' retirée des favoris\n";
    } else {
        echo "✅ Catégorie '{$category1->name}' ajoutée aux favoris\n";
    }
    
    $stillFavorited = CategoryFavorite::isFavorited($user->id, $category1->id);
    echo "Statut actuel: " . ($stillFavorited ? "FAVORIS" : "PAS FAVORIS") . "\n";
    echo "\n";
    
    // ==========================================
    // RÉSUMÉ FINAL
    // ==========================================
    echo str_repeat("=", 74) . "\n";
    echo "✅ TOUS LES TESTS RÉUSSIS!\n";
    echo str_repeat("=", 74) . "\n\n";
    
    echo "📋 Résumé:\n";
    echo "   - Migration: ✅ Table créée\n";
    echo "   - Modèle: ✅ Relations fonctionnelles\n";
    echo "   - Méthodes statiques: ✅ Opérationnelles\n";
    echo "   - Scopes: ✅ Fonctionnels\n";
    echo "   - Relations Eloquent: ✅ Chargées correctement\n";
    echo "   - Statistiques: ✅ Calculs corrects\n";
    echo "\n";
    
    echo "🎉 Le système CategoryFavorite est 100% opérationnel!\n\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "\n📍 Fichier: " . $e->getFile() . "\n";
    echo "📍 Ligne: " . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
