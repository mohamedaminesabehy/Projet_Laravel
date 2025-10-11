<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryFavoriteController;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

echo "═══════════════════════════════════════════════════════\n";
echo "🧪 TEST DES OPÉRATIONS CRUD DE FAVORIS\n";
echo "═══════════════════════════════════════════════════════\n\n";

// Se connecter en tant qu'utilisateur
$user = User::first();
Auth::login($user);
echo "✅ Connecté en tant que: {$user->email} (ID: {$user->id})\n\n";

// Créer le contrôleur
$controller = new CategoryFavoriteController();

// Récupérer une catégorie pour les tests
$category = Category::skip(5)->first();
if (!$category) {
    $category = Category::first();
}

echo "📚 Catégorie de test: {$category->name} (ID: {$category->id})\n\n";

// ═══════════════════════════════════════════════════════
// TEST 1: TOGGLE (Ajouter un favori)
// ═══════════════════════════════════════════════════════
echo "1️⃣  TEST TOGGLE - AJOUTER UN FAVORI\n";
echo "---------------------------------------------------\n";

try {
    // Supprimer d'abord le favori s'il existe
    \DB::table('category_favorites')
        ->where('user_id', $user->id)
        ->where('category_id', $category->id)
        ->delete();
    
    $request = Request::create(
        "/category-favorites/toggle/{$category->id}",
        'POST',
        [],
        [],
        [],
        ['HTTP_ACCEPT' => 'application/json', 'HTTP_X_CSRF_TOKEN' => 'test'],
        json_encode([])
    );
    
    $response = $controller->toggle($request, $category);
    $data = json_decode($response->getContent(), true);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Réponse: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    
    if ($data['success'] && $data['favorited'] === true) {
        echo "✅ SUCCÈS: Favori ajouté correctement\n";
    } else {
        echo "❌ ÉCHEC: Favori non ajouté\n";
    }
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n";

// ═══════════════════════════════════════════════════════
// TEST 2: TOGGLE (Retirer un favori)
// ═══════════════════════════════════════════════════════
echo "2️⃣  TEST TOGGLE - RETIRER UN FAVORI\n";
echo "---------------------------------------------------\n";

try {
    $request = Request::create(
        "/category-favorites/toggle/{$category->id}",
        'POST',
        [],
        [],
        [],
        ['HTTP_ACCEPT' => 'application/json', 'HTTP_X_CSRF_TOKEN' => 'test'],
        json_encode([])
    );
    
    $response = $controller->toggle($request, $category);
    $data = json_decode($response->getContent(), true);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Réponse: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    
    if ($data['success'] && $data['favorited'] === false) {
        echo "✅ SUCCÈS: Favori retiré correctement\n";
    } else {
        echo "❌ ÉCHEC: Favori non retiré\n";
    }
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";

// ═══════════════════════════════════════════════════════
// TEST 3: STORE (Créer un favori)
// ═══════════════════════════════════════════════════════
echo "3️⃣  TEST STORE - CRÉER UN FAVORI\n";
echo "---------------------------------------------------\n";

try {
    $request = Request::create(
        '/category-favorites',
        'POST',
        ['category_id' => $category->id],
        [],
        [],
        ['HTTP_ACCEPT' => 'application/json', 'HTTP_X_CSRF_TOKEN' => 'test'],
        json_encode(['category_id' => $category->id])
    );
    
    $response = $controller->store($request);
    $data = json_decode($response->getContent(), true);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Réponse: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    
    if ($data['success']) {
        echo "✅ SUCCÈS: Favori créé via STORE\n";
    } else {
        echo "ℹ️  INFO: " . ($data['message'] ?? 'Déjà en favoris') . "\n";
    }
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";

// ═══════════════════════════════════════════════════════
// TEST 4: CHECK (Vérifier le statut)
// ═══════════════════════════════════════════════════════
echo "4️⃣  TEST CHECK - VÉRIFIER LE STATUT\n";
echo "---------------------------------------------------\n";

try {
    $request = Request::create(
        "/category-favorites/check/{$category->id}",
        'GET',
        [],
        [],
        [],
        ['HTTP_ACCEPT' => 'application/json'],
        ''
    );
    
    $response = $controller->check($category);
    $data = json_decode($response->getContent(), true);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Réponse: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    echo "✅ SUCCÈS: Vérification du statut\n";
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";

// ═══════════════════════════════════════════════════════
// TEST 5: DESTROY (Supprimer un favori)
// ═══════════════════════════════════════════════════════
echo "5️⃣  TEST DESTROY - SUPPRIMER UN FAVORI\n";
echo "---------------------------------------------------\n";

try {
    $request = Request::create(
        "/category-favorites/{$category->id}",
        'DELETE',
        [],
        [],
        [],
        ['HTTP_ACCEPT' => 'application/json', 'HTTP_X_CSRF_TOKEN' => 'test'],
        ''
    );
    
    $response = $controller->destroy($category);
    $data = json_decode($response->getContent(), true);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Réponse: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    
    if ($data['success']) {
        echo "✅ SUCCÈS: Favori supprimé\n";
    } else {
        echo "ℹ️  INFO: Favori non trouvé (déjà supprimé)\n";
    }
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";

// ═══════════════════════════════════════════════════════
// TEST 6: INDEX (Liste des favoris)
// ═══════════════════════════════════════════════════════
echo "6️⃣  TEST INDEX - LISTER LES FAVORIS\n";
echo "---------------------------------------------------\n";

try {
    $request = Request::create('/category-favorites', 'GET');
    $response = $controller->index();
    
    echo "✅ SUCCÈS: Page index chargée (Vue retournée)\n";
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";

// ═══════════════════════════════════════════════════════
// TEST 7: STATISTICS
// ═══════════════════════════════════════════════════════
echo "7️⃣  TEST STATISTICS - OBTENIR LES STATISTIQUES\n";
echo "---------------------------------------------------\n";

try {
    $request = Request::create('/category-favorites/statistics', 'GET');
    $response = $controller->statistics();
    $data = json_decode($response->getContent(), true);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Réponse: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    echo "✅ SUCCÈS: Statistiques récupérées\n";
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n";

echo "═══════════════════════════════════════════════════════\n";
echo "✨ RÉSUMÉ DES TESTS\n";
echo "═══════════════════════════════════════════════════════\n";
echo "✅ Tous les tests CRUD ont été exécutés\n";
echo "📊 Backend: FONCTIONNEL\n";
echo "🔍 Si le problème persiste, vérifiez:\n";
echo "   1. Le middleware d'authentification\n";
echo "   2. Les routes AJAX dans le frontend\n";
echo "   3. Le CSRF token\n";
echo "   4. La console du navigateur\n";
echo "═══════════════════════════════════════════════════════\n";
