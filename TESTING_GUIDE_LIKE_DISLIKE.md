# 🧪 Guide de Test - Système Like/Dislike

## Préparation

### 1. Vérifier la Base de Données

```bash
# Vérifier que la table review_reactions existe
php artisan migrate:status
```

Si la migration n'est pas exécutée :
```bash
php artisan migrate
```

### 2. Créer des Données de Test

```bash
# Si vous avez des seeders
php artisan db:seed

# Ou créer manuellement :
# - Au moins 2 utilisateurs
# - Au moins 1 livre
# - Au moins 2-3 avis
```

### 3. Lancer le Serveur

```bash
php artisan serve
```

Accédez à : `http://localhost:8000/reviews`

---

## 🎯 Scénarios de Test

### Test 1 : Utilisateur Non Connecté
**Objectif** : Vérifier que les boutons sont désactivés

1. Ouvrir `/reviews` sans être connecté
2. **Résultat attendu** :
   - ✅ Les boutons Like/Dislike sont grisés
   - ✅ Tooltip "Connectez-vous pour réagir" au survol
   - ✅ Les compteurs s'affichent correctement
   - ✅ Impossible de cliquer sur les boutons

---

### Test 2 : Première Réaction (Like)
**Objectif** : Créer un like

1. Se connecter avec un utilisateur
2. Aller sur `/reviews`
3. Cliquer sur le bouton **👍 Like** d'un avis (pas le vôtre)
4. **Résultat attendu** :
   - ✅ Bouton devient bleu (actif)
   - ✅ Compteur de likes passe de X à X+1
   - ✅ Animation pulse sur le bouton
   - ✅ Score mis à jour
   - ✅ Notification de succès (toast)

5. **Vérification BD** :
   ```sql
   SELECT * FROM review_reactions WHERE review_id = ? AND user_id = ?
   ```
   - ✅ Une ligne avec `reaction_type = 'like'`

---

### Test 3 : Changer de Réaction (Like → Dislike)
**Objectif** : Modifier une réaction existante

1. Avoir déjà un like actif (Test 2)
2. Cliquer sur le bouton **👎 Dislike**
3. **Résultat attendu** :
   - ✅ Bouton Like se désactive (gris)
   - ✅ Bouton Dislike devient rouge (actif)
   - ✅ Compteur likes diminue de 1
   - ✅ Compteur dislikes augmente de 1
   - ✅ Score recalculé correctement
   - ✅ Animation de transition

4. **Vérification BD** :
   ```sql
   SELECT * FROM review_reactions WHERE review_id = ? AND user_id = ?
   ```
   - ✅ Même ligne, mais `reaction_type = 'dislike'`

---

### Test 4 : Annuler une Réaction (Toggle Off)
**Objectif** : Supprimer sa réaction

1. Avoir une réaction active (like ou dislike)
2. Cliquer à nouveau sur le **même bouton**
3. **Résultat attendu** :
   - ✅ Bouton redevient gris (inactif)
   - ✅ Compteur diminue de 1
   - ✅ Score mis à jour
   - ✅ Animation de retour

4. **Vérification BD** :
   ```sql
   SELECT COUNT(*) FROM review_reactions WHERE review_id = ? AND user_id = ?
   ```
   - ✅ Résultat = 0 (ligne supprimée)

---

### Test 5 : Auteur de l'Avis
**Objectif** : Vérifier qu'on ne peut pas réagir à son propre avis

1. Se connecter avec l'utilisateur qui a créé un avis
2. Aller sur `/reviews`
3. Trouver son propre avis
4. **Résultat attendu** :
   - ✅ Pas de boutons Like/Dislike interactifs
   - ✅ Affichage simple des statistiques (lecture seule)
   - ✅ Message type : "👍 5  👎 2"

---

### Test 6 : Multiples Utilisateurs
**Objectif** : Vérifier l'indépendance des réactions

1. Utilisateur A : Like l'avis #1
2. Utilisateur B : Dislike l'avis #1
3. Utilisateur C : Like l'avis #1
4. **Résultat attendu** :
   - ✅ Compteur likes = 2
   - ✅ Compteur dislikes = 1
   - ✅ Score = 1 (2-1)
   - ✅ Chaque utilisateur voit son propre bouton actif

---

### Test 7 : Persistance après Refresh
**Objectif** : Vérifier que les réactions sont sauvegardées

1. Créer une réaction (like)
2. Actualiser la page (F5)
3. **Résultat attendu** :
   - ✅ Bouton Like toujours actif (bleu)
   - ✅ Compteur identique
   - ✅ Score identique

---

### Test 8 : Requête AJAX Échouée
**Objectif** : Tester la gestion d'erreur

1. Ouvrir la console développeur (F12)
2. Onglet Network → Bloquer les requêtes vers `/reviews/*/reactions`
3. Essayer de cliquer sur Like
4. **Résultat attendu** :
   - ✅ Notification d'erreur s'affiche
   - ✅ Bouton ne reste pas en état loading
   - ✅ Compteurs ne changent pas
   - ✅ Message : "Impossible de traiter votre réaction..."

---

### Test 9 : Clics Rapides (Double Click)
**Objectif** : Éviter les requêtes multiples

1. Cliquer rapidement 5 fois sur Like
2. **Résultat attendu** :
   - ✅ Une seule requête envoyée
   - ✅ État loading bloque les autres clics
   - ✅ Compteur n'augmente qu'une fois

---

### Test 10 : Responsive Design
**Objectif** : Vérifier sur mobile

1. Ouvrir DevTools (F12)
2. Mode responsive (Ctrl+Shift+M)
3. Tester sur différentes tailles :
   - iPhone SE (375px)
   - iPad (768px)
   - Desktop (1920px)

4. **Résultat attendu** :
   - ✅ Boutons s'adaptent à la taille
   - ✅ Texte lisible
   - ✅ Espacement correct
   - ✅ Pas de débordement
   - ✅ Animations fluides

---

## 🐛 Résolution de Problèmes

### Problème : Erreur 419 (Token CSRF)
**Solution** :
- Vérifier que `<meta name="csrf-token">` est dans `app.blade.php`
- Vérifier que le JavaScript récupère bien le token

### Problème : Boutons ne réagissent pas
**Solution** :
1. Ouvrir la console (F12)
2. Chercher des erreurs JavaScript
3. Vérifier que Bootstrap est chargé
4. Vérifier que le JavaScript est dans `@push('scripts')`

### Problème : Compteurs ne se mettent pas à jour
**Solution** :
1. Vérifier la réponse API dans Network
2. Vérifier la fonction `updateReactionButtons()`
3. Vérifier les sélecteurs `.count`, `.btn-like`, etc.

### Problème : Style incorrect
**Solution** :
1. Vérifier que le CSS est dans `@push('styles')`
2. Vérifier qu'il n'y a pas de conflit avec d'autres CSS
3. Inspecter l'élément pour voir les classes appliquées

---

## ✅ Checklist Complète

### Fonctionnalités
- [ ] Like fonctionne
- [ ] Dislike fonctionne
- [ ] Changement like → dislike
- [ ] Changement dislike → like
- [ ] Annulation de réaction (toggle)
- [ ] Compteurs corrects
- [ ] Score correct
- [ ] Auteur ne peut pas réagir à son avis
- [ ] Non-connecté ne peut pas réagir
- [ ] Persistance après refresh

### Interface
- [ ] Animations hover
- [ ] Animations click
- [ ] Bouton actif (couleur)
- [ ] Bouton inactif (gris)
- [ ] État loading
- [ ] Notifications toast
- [ ] Tooltips informatifs
- [ ] Design responsive mobile
- [ ] Design responsive tablette
- [ ] Pas de bugs visuels

### Sécurité
- [ ] Token CSRF présent
- [ ] Authentification vérifiée
- [ ] Validation serveur
- [ ] Protection double-click
- [ ] Gestion des erreurs

---

## 📊 Résultats Attendus

### Performance
- Temps de réponse API : < 200ms
- Animation fluide : 60fps
- Pas de lag sur mobile

### Compatibilité
- Chrome ✅
- Firefox ✅
- Safari ✅
- Edge ✅
- Mobile iOS ✅
- Mobile Android ✅

---

## 🎉 Test Réussi Si...

- ✅ Tous les scénarios passent
- ✅ Pas d'erreur en console
- ✅ Interface fluide et intuitive
- ✅ Données correctement persistées
- ✅ Responsive sur tous les appareils

**Félicitations ! Le système Like/Dislike fonctionne parfaitement !** 🚀
