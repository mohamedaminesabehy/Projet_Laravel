# Guide de Test - AI Insights

## 📋 Vue d'ensemble

Le système AI Insights génère automatiquement des résumés intelligents des livres basés sur les avis des utilisateurs.

**Requis pour générer un AI Insight :**
- Au moins **3 avis analysés** par livre
- Les avis doivent avoir été traités par l'analyse de sentiment (Gemini AI)

## 🚀 Comment tester

### Étape 1 : Ajouter des données de test

1. **Connectez-vous en tant qu'admin** : http://127.0.0.1:8000/signin
   - Email : admin@example.com (ou créez un compte admin)

2. **Ajoutez un livre** via le panel admin
   - Allez dans la gestion des livres
   - Créez au moins 1 livre de test

3. **Ajoutez au moins 3 avis** pour ce livre
   - Connectez-vous avec différents comptes utilisateurs
   - Ou créez 3 avis manuellement dans la base de données
   - Les avis doivent avoir du contenu varié (positif, neutre, négatif)

### Étape 2 : Analyser les avis

1. **Allez sur la page d'analyse de sentiment** : http://127.0.0.1:8000/admin/sentiment

2. **Cliquez sur "Analyser en masse"**
   - Tous les avis non analysés seront traités
   - L'analyse de sentiment sera effectuée par Gemini AI
   - **NOUVEAU** : Si un livre atteint 3+ avis analysés, un BookInsight sera automatiquement généré !

3. **Vérifiez le message de succès**
   - Exemple : "3 avis analysé(s) avec succès ! 1 AI Insight(s) généré(s) !"

### Étape 3 : Voir les AI Insights

1. **Allez sur la page AI Insights** : http://127.0.0.1:8000/ai-insights

2. **Vous devriez maintenant voir votre livre** avec :
   - Un résumé généré par l'IA
   - Les points positifs et négatifs
   - Les thèmes principaux
   - La distribution des sentiments
   - La note moyenne

## 🛠️ Génération manuelle des insights

Si vous avez déjà des avis analysés mais pas de BookInsights, exécutez :

```powershell
C:\php\php.exe generate_missing_insights.php
```

Ce script va :
- Trouver tous les livres avec ≥3 avis analysés mais sans BookInsight
- Générer automatiquement les insights manquants
- Afficher un rapport détaillé

## 🔍 Diagnostic

Pour vérifier l'état de vos données :

```powershell
C:\php\php.exe check_insights_db.php
```

Affichera :
- Nombre total de livres
- Nombre d'avis (total et analysés)
- Nombre de BookInsights générés
- Détails par livre

## 📊 Fonctionnement technique

### Flux automatique (recommandé)

```
1. Utilisateur ajoute un avis
2. Admin clique sur "Analyser en masse" dans /admin/sentiment
3. Le système analyse les avis avec Gemini AI
4. Pour chaque livre avec ≥3 avis analysés :
   └─> Génération automatique du BookInsight
5. L'insight apparaît immédiatement dans /ai-insights
```

### Ce qui est analysé pour chaque BookInsight

- **Résumé général** : Synthèse de l'opinion des lecteurs
- **Points positifs** : Aspects appréciés (avec nombre de mentions)
- **Points négatifs** : Aspects critiqués (avec nombre de mentions)
- **Thèmes principaux** : 5 thèmes récurrents
- **Distribution des sentiments** : % positif/neutre/négatif
- **Statistiques** : Note moyenne, sentiment moyen

## 🐛 Dépannage

### AI Insights affiche "0 Livres Disponibles"

**Causes possibles :**

1. **Pas assez d'avis analysés**
   - Solution : Ajoutez au moins 3 avis par livre et analysez-les

2. **Les avis ne sont pas analysés**
   - Solution : Allez dans /admin/sentiment et cliquez "Analyser en masse"

3. **BookInsight pas encore généré**
   - Solution : Exécutez `C:\php\php.exe generate_missing_insights.php`

### Vérifier les logs

Les logs Laravel sont dans `storage/logs/laravel.log` :

```powershell
Get-Content storage\logs\laravel.log -Tail 50
```

Cherchez :
- `Generating book insight` - Génération d'un insight
- `Book insight generated successfully` - Succès
- `Error generating book insight` - Erreur

## 📝 Exemple de scénario complet

```powershell
# 1. Assurez-vous que la base de données est à jour
C:\php\php.exe artisan migrate

# 2. Ajoutez manuellement via l'interface web :
#    - 1 livre "Le Petit Prince"
#    - 3 avis pour ce livre

# 3. Analysez les avis
#    Allez sur http://127.0.0.1:8000/admin/sentiment
#    Cliquez "Analyser en masse"

# 4. Vérifiez l'AI Insight
#    Allez sur http://127.0.0.1:8000/ai-insights
#    Vous devriez voir "Le Petit Prince" avec son insight

# 5. (Optionnel) Régénérer manuellement si besoin
C:\php\php.exe generate_missing_insights.php
```

## ✅ Checklist de validation

- [ ] Au moins 1 livre créé
- [ ] Au moins 3 avis pour ce livre
- [ ] Avis analysés (sentiment_score, analyzed_at non null)
- [ ] BookInsight existe dans book_insights table
- [ ] Le livre apparaît dans /ai-insights
- [ ] Le résumé est affiché correctement

---

**Note importante** : Le système génère automatiquement les BookInsights lors de l'analyse en masse. Vous n'avez normalement pas besoin d'exécuter `generate_missing_insights.php` sauf si vous avez des avis déjà analysés avant cette mise à jour.
