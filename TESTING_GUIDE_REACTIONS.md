# 🧪 Guide de Test - Review Reactions

## ✅ Tests Rapides à Effectuer

### 1. Test de l'Interface Admin

#### A. Accéder au Dashboard des Réactions
```
URL: http://127.0.0.1:8000/admin/review-reactions
```

**Vérifications:**
- ✅ Page charge sans erreur
- ✅ 4 cartes statistiques affichées (Total, Likes, Dislikes, Ratio)
- ✅ Filtres fonctionnels (Type, Dates, Recherche)
- ✅ Tableau vide (normal si pas de données)
- ✅ Menu "Réactions" actif dans la sidebar

#### B. Accéder aux Analytics
```
URL: http://127.0.0.1:8000/admin/review-reactions/analytics/dashboard
```

**Vérifications:**
- ✅ Graphique de tendance (Chart.js)
- ✅ Graphique de distribution (Donut)
- ✅ Tables "Top Avis" et "Top Users"
- ✅ Filtres de date fonctionnels

### 2. Test du Composant Blade

#### A. Créer une page de test
Créez un fichier: `resources/views/test-reactions.blade.php`

```blade
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Test Review Reactions</h1>
    
    @php
        // Récupérer un avis pour tester
        $review = App\Models\Review::with('reactions', 'user', 'book')->first();
    @endphp
    
    @if($review)
        <div class="card">
            <div class="card-body">
                <h5>{{ $review->book->title ?? 'Livre' }}</h5>
                <p>Par: {{ $review->user->name ?? 'Utilisateur' }}</p>
                <p>Note: {{ $review->rating }}/5</p>
                <p>{{ $review->comment }}</p>
                
                <hr>
                
                <h6>Composant de Réaction:</h6>
                <x-review-reactions :review="$review" />
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Aucun avis trouvé. Créez d'abord un avis pour tester.
        </div>
    @endif
</div>
@endsection
```

#### B. Ajouter une route temporaire
Dans `routes/web.php`:
```php
Route::get('/test-reactions', function() {
    return view('test-reactions');
})->middleware('auth')->name('test.reactions');
```

#### C. Tester
```
URL: http://127.0.0.1:8000/test-reactions
```

**Vérifications:**
- ✅ Boutons Like/Dislike affichés
- ✅ Compteurs à 0 initialement
- ✅ Styles Bootstrap appliqués
- ✅ Tooltips "Utile" / "Pas utile"

### 3. Test des Fonctionnalités AJAX

#### A. Créer une réaction (Like)
1. Ouvrir la console navigateur (F12)
2. Cliquer sur le bouton "👍 Like"
3. Vérifier:
   - ✅ Requête POST vers `/reviews/{id}/reactions`
   - ✅ Réponse JSON avec `success: true`
   - ✅ Bouton devient actif (background gradient)
   - ✅ Compteur passe à 1
   - ✅ Toast notification affichée

#### B. Changer de réaction (Like → Dislike)
1. Cliquer sur le bouton "👎 Dislike"
2. Vérifier:
   - ✅ Like désactivé
   - ✅ Dislike activé
   - ✅ Compteur Like = 0, Dislike = 1
   - ✅ Pas de doublon en base

#### C. Retirer une réaction
1. Cliquer à nouveau sur le bouton actif
2. Vérifier:
   - ✅ Bouton désactivé
   - ✅ Compteur revient à 0
   - ✅ Réaction supprimée de la BDD

### 4. Test de la Base de Données

#### A. Vérifier la structure
```sql
DESCRIBE review_reactions;
```

**Colonnes attendues:**
- id (primary key)
- review_id (foreign key)
- user_id (foreign key)
- reaction_type (enum: like, dislike)
- created_at
- updated_at

#### B. Insérer des données de test
```sql
-- Créer quelques réactions de test
INSERT INTO review_reactions (review_id, user_id, reaction_type, created_at, updated_at)
VALUES 
(1, 1, 'like', NOW(), NOW()),
(1, 2, 'dislike', NOW(), NOW()),
(2, 1, 'like', NOW(), NOW());
```

#### C. Tester la contrainte unique
```sql
-- Ceci devrait échouer (duplicate)
INSERT INTO review_reactions (review_id, user_id, reaction_type)
VALUES (1, 1, 'like');
```
**Résultat attendu:** Erreur "Duplicate entry"

### 5. Test des Relations Eloquent

Dans `php artisan tinker`:

```php
// Charger un avis avec ses réactions
$review = App\Models\Review::with('reactions')->first();
$review->reactions; // Collection de réactions

// Compter les likes
$review->likes_count;

// Compter les dislikes
$review->dislikes_count;

// Score
$review->reaction_score; // likes - dislikes

// Vérifier si un utilisateur a réagi
$review->hasUserReacted(1);

// Obtenir la réaction d'un utilisateur
$review->getUserReaction(1);

// Réactions d'un utilisateur
$user = App\Models\User::with('reviewReactions')->first();
$user->reviewReactions;
$user->likes_given_count;
$user->dislikes_given_count;
```

### 6. Test des Scopes

```php
use App\Models\ReviewReaction;

// Toutes les likes
ReviewReaction::likes()->count();

// Toutes les dislikes
ReviewReaction::dislikes()->count();

// Réactions pour un avis spécifique
ReviewReaction::forReview(1)->get();

// Réactions par un utilisateur
ReviewReaction::byUser(1)->get();
```

### 7. Test de Sécurité

#### A. Protection contre les réactions à son propre avis
1. Se connecter en tant qu'auteur d'un avis
2. Essayer de liker son propre avis
3. Vérifier:
   - ✅ Boutons désactivés ou masqués
   - ✅ Message "Vous ne pouvez pas réagir à votre propre avis"
   - ✅ Erreur 403 si tentative via API directe

#### B. Protection CSRF
1. Essayer une requête POST sans token CSRF
2. Vérifier:
   - ✅ Erreur 419 (Token mismatch)

#### C. Authentification requise
1. Se déconnecter
2. Essayer d'accéder à `/reviews/1/reactions`
3. Vérifier:
   - ✅ Redirection vers `/login`
   - ✅ Message d'erreur approprié

### 8. Test Admin - Opérations CRUD

#### A. Liste des réactions
```
URL: /admin/review-reactions
```
- ✅ Affiche toutes les réactions
- ✅ Pagination fonctionne (si > 20 items)
- ✅ Filtres par type, date, recherche
- ✅ Tri par colonnes

#### B. Voir détails
1. Cliquer sur l'icône "👁️ Voir"
2. Vérifier:
   - ✅ Informations complètes de la réaction
   - ✅ Détails de l'utilisateur
   - ✅ Détails de l'avis
   - ✅ Statistiques de l'avis

#### C. Supprimer une réaction
1. Cliquer sur l'icône "🗑️ Supprimer"
2. Confirmer
3. Vérifier:
   - ✅ Message de succès
   - ✅ Réaction supprimée de la liste
   - ✅ Réaction supprimée de la BDD

#### D. Suppression en masse
1. Cocher plusieurs cases
2. Cliquer "Supprimer sélection"
3. Confirmer
4. Vérifier:
   - ✅ Toutes sélections supprimées
   - ✅ Message indique le nombre supprimé

### 9. Test des Analytics

#### A. Graphiques
1. Accéder à `/admin/review-reactions/analytics/dashboard`
2. Vérifier:
   - ✅ Graphique de tendance charge
   - ✅ Données affichées correctement
   - ✅ Légende visible
   - ✅ Graphique donut charge
   - ✅ Couleurs distinctes (vert/rouge)

#### B. Filtres de date
1. Sélectionner une période personnalisée
2. Cliquer "Filtrer"
3. Vérifier:
   - ✅ Graphiques mis à jour
   - ✅ Statistiques recalculées
   - ✅ Tables filtrées

#### C. Tables statistiques
- ✅ Top 10 avis les plus réactifs
- ✅ Top 10 utilisateurs les plus actifs
- ✅ Top 10 avis les plus likés
- ✅ Top 10 avis les plus dislikés

### 10. Test de Performance

#### A. Charge avec données massives
```php
// Dans tinker
use App\Models\ReviewReaction;

// Créer 1000 réactions aléatoires
for ($i = 0; $i < 1000; $i++) {
    ReviewReaction::create([
        'review_id' => rand(1, 10),
        'user_id' => rand(1, 10),
        'reaction_type' => rand(0, 1) ? 'like' : 'dislike',
    ]);
}
```

Vérifier:
- ✅ Pagination fonctionne bien
- ✅ Filtres rapides
- ✅ Graphiques performants

## 🐛 Problèmes Communs et Solutions

### Erreur: "Class 'ReviewReaction' not found"
**Solution:** 
```bash
composer dump-autoload
php artisan optimize:clear
```

### Boutons ne réagissent pas au clic
**Solution:**
1. Vérifier console JS (F12)
2. Confirmer que Bootstrap JS est chargé
3. Vérifier `<meta name="csrf-token">`

### Compteurs ne se mettent pas à jour
**Solution:**
1. Vérifier Network tab (F12)
2. Confirmer réponse API contient `counts`
3. Vérifier `data-review-id` correct

### Graphiques ne s'affichent pas
**Solution:**
1. Vérifier que Chart.js est chargé
2. Ouvrir console pour erreurs JS
3. Confirmer données passées au graphique

## ✅ Checklist Finale

- [ ] Migration réussie
- [ ] Routes listées correctement
- [ ] Page admin charge sans erreur
- [ ] Composant Blade s'affiche
- [ ] AJAX fonctionne (like/dislike)
- [ ] Toggle et changement de réaction
- [ ] Admin peut voir la liste
- [ ] Admin peut voir les détails
- [ ] Admin peut supprimer
- [ ] Analytics affiche les graphiques
- [ ] Filtres fonctionnent
- [ ] Sécurité testée (propre avis, CSRF, auth)
- [ ] Relations Eloquent fonctionnent
- [ ] Performance acceptable

## 🎯 Cas d'Usage Réels

### Scénario 1: Utilisateur Normal
1. Se connecter
2. Consulter un livre
3. Lire les avis
4. Liker les avis utiles
5. Disliker les avis non pertinents
6. Changer d'avis (toggle)

### Scénario 2: Admin Modérateur
1. Se connecter en admin
2. Vérifier le dashboard des réactions
3. Identifier les avis les plus controversés
4. Consulter les détails
5. Supprimer les réactions suspectes
6. Analyser les tendances

### Scénario 3: Analyse Business
1. Accéder aux analytics
2. Observer les tendances sur 30 jours
3. Identifier les livres avec meilleure réception
4. Voir quels utilisateurs sont les plus engagés
5. Prendre décisions basées sur données

Bon test! 🚀
