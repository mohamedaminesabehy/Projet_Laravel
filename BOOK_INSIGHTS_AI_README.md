# 📚 RÉSUMÉS AI DES LIVRES - Guide Complet

## 🎯 Vue d'ensemble

Le système de **Résumés AI des livres** analyse automatiquement tous les avis d'un livre et génère un résumé structuré avec Google Gemini AI.

### ✨ Fonctionnalités

- ✅ Résumé automatique des avis en français
- ✅ Extraction des points positifs (avec comptage des mentions)
- ✅ Extraction des points négatifs
- ✅ Identification des thèmes principaux
- ✅ Statistiques de sentiment (% positif/neutre/négatif)
- ✅ Notes et scores moyens
- ✅ Génération par lots ou individuelle

---

## 📊 Structure de la base de données

### Table `book_insights`

| Champ | Type | Description |
|-------|------|-------------|
| `id` | BIGINT | Identifiant unique |
| `book_id` | BIGINT | Référence au livre (clé étrangère) |
| `reviews_summary` | TEXT | Résumé narratif des avis |
| `positive_points` | JSON | Liste des points positifs |
| `negative_points` | JSON | Liste des points négatifs |
| `top_themes` | JSON | Thèmes principaux du livre |
| `sentiment_distribution` | JSON | Distribution % des sentiments |
| `total_reviews` | INT | Nombre d'avis analysés |
| `average_rating` | DECIMAL(3,2) | Note moyenne |
| `average_sentiment` | DECIMAL(3,2) | Score sentiment moyen |
| `last_generated_at` | TIMESTAMP | Date de dernière génération |

---

## 🚀 Utilisation

### 1️⃣ Générer un insight pour UN livre (test)

```bash
C:\php\php.exe test_book_insight.php
```

**Résultat attendu :**
```
✅ SUCCÈS ! Insight généré en 2.79s

📝 RÉSUMÉ
Les avis sur "L'Art de la Guerre" d'André Malraux sont mitigés...

✅ POINTS POSITIFS (4)
  • Histoire touchante et émouvante - mentionné 1 fois
  • Livre incroyable - mentionné 1 fois
  ...
```

### 2️⃣ Générer les insights pour TOUS les livres

```bash
C:\php\php.exe generate_book_insights.php
```

**Fonctionnement :**
- Traite 5 livres par lot
- Pause de 3 secondes entre chaque livre
- Skip les livres qui ont déjà un insight récent
- Logs détaillés de progression

---

## 🔍 Accéder aux données

### Depuis le code PHP

```php
use App\Models\Book;

// Récupérer un livre avec son insight
$book = Book::with('insight')->find(1);

if ($book->insight) {
    echo $book->insight->reviews_summary;
    print_r($book->insight->positive_points);
    print_r($book->insight->top_themes);
}
```

### Depuis Blade (vue)

```blade
@if($book->insight)
    <div class="ai-summary">
        <h3>🤖 Ce que les lecteurs en pensent</h3>
        <p>{{ $book->insight->reviews_summary }}</p>
        
        @if(!empty($book->insight->positive_points))
            <h4>✅ Points forts :</h4>
            <ul>
                @foreach($book->insight->positive_points as $point)
                    <li>{{ $point }}</li>
                @endforeach
            </ul>
        @endif
        
        @if(!empty($book->insight->top_themes))
            <p><strong>Thèmes :</strong> 
                {{ implode(', ', $book->insight->top_themes) }}
            </p>
        @endif
    </div>
@endif
```

---

## 🎨 Exemple de rendu

```
┌───────────────────────────────────────────────────────┐
│ 📖 L'Art de la Guerre - André Malraux                │
├───────────────────────────────────────────────────────┤
│ 🤖 Ce que les lecteurs en pensent (6 avis)           │
│                                                       │
│ Les avis sont mitigés. Certains lecteurs ont trouvé  │
│ l'histoire touchante tandis que d'autres ont relevé  │
│ des incohérences dans le récit.                      │
│                                                       │
│ ✅ Points forts :                                     │
│  • Histoire touchante (1 mention)                    │
│  • Ambiance très bien rendue (1 mention)            │
│                                                       │
│ ⚠️  Points à noter :                                  │
│  • Personnages non attachants (1 mention)            │
│  • Passages répétitifs (1 mention)                   │
│                                                       │
│ 🏷️ Thèmes : Guerre, Histoire, Émotion                │
│                                                       │
│ 📊 Note moyenne : 3.0/5                              │
│ 📈 Sentiment : 33% positif, 33% neutre, 33% négatif  │
└───────────────────────────────────────────────────────┘
```

---

## ⚙️ Configuration

### Conditions requises

1. **Minimum 3 avis analysés** par livre
2. Les avis doivent avoir `analyzed_at` non NULL
3. Clé API Gemini valide dans `.env`

### Paramètres modifiables

**Dans `generate_book_insights.php` :**
```php
$booksPerBatch = 5;      // Livres par lot
$pauseBetweenBooks = 3;   // Pause en secondes
```

---

## 🔄 Régénération automatique

Le système détermine automatiquement qu'un insight doit être régénéré si :

1. **Jamais généré** (`last_generated_at` est NULL)
2. **Ancien** (plus de 30 jours)
3. **Nouveaux avis** (nombre d'avis actuel > `total_reviews`)

Vérifier avec :
```php
if ($book->insight->needsRegeneration()) {
    // Régénérer...
}
```

---

## 📝 API du Service

### BookReviewSummarizer

```php
use App\Services\AI\BookReviewSummarizer;

$summarizer = app(BookReviewSummarizer::class);

// Générer pour un livre
$insight = $summarizer->generateInsight($book);

// Générer pour plusieurs livres (max 10)
$results = $summarizer->generateBulkInsights(10);
// Retourne : ['success' => 5, 'failed' => 0, 'skipped' => 3]
```

---

## 🛠️ Dépannage

### Problème : "Not enough reviews to generate insight"

**Solution :** Le livre doit avoir au moins 3 avis **analysés** (avec `analyzed_at` non NULL).

```bash
# Vérifier combien d'avis analysés
C:\php\php.exe artisan tinker --execute="echo App\Models\Book::find(1)->reviews()->whereNotNull('analyzed_at')->count();"
```

### Problème : "Failed to parse Gemini response"

**Solution :** Vérifier les logs et réessayer.

```bash
# Voir les logs
Get-Content storage\logs\laravel.log -Tail 50
```

### Problème : Insight pas à jour après nouveaux avis

**Solution :** Régénérer manuellement

```bash
C:\php\php.exe test_book_insight.php
```

---

## 📊 Statistiques

Pour obtenir des statistiques globales :

```php
use App\Models\BookInsight;

$total = BookInsight::count();
$recent = BookInsight::where('last_generated_at', '>=', now()->subDays(7))->count();
$avgReviews = BookInsight::avg('total_reviews');

echo "Insights générés : {$total}\n";
echo "Récents (7 jours) : {$recent}\n";
echo "Moy. avis/livre : {$avgReviews}\n";
```

---

## 🎯 Prochaines étapes recommandées

1. ✅ **Afficher sur la page publique du livre**
   - Créer `resources/views/books/show.blade.php`
   - Intégrer le résumé AI

2. ✅ **Dashboard admin**
   - Page `/admin/insights`
   - Liste de tous les livres avec insights
   - Bouton "Générer" / "Régénérer"

3. ✅ **Tâche planifiée**
   - Régénération automatique hebdomadaire
   - `app/Console/Kernel.php` → schedule

4. ✅ **Widget homepage**
   - Afficher les insights des livres populaires
   - "Ce que nos lecteurs adorent"

---

## 📞 Support

- **Logs :** `storage/logs/laravel.log`
- **Test rapide :** `C:\php\php.exe test_book_insight.php`
- **Génération masse :** `C:\php\php.exe generate_book_insights.php`

---

## ✅ Checklist de vérification

- [ ] Migration `book_insights` exécutée
- [ ] Au moins 1 livre avec 3+ avis analysés
- [ ] Clé Gemini API valide dans `.env`
- [ ] Test unitaire réussi
- [ ] Génération en masse testée
- [ ] Insight visible en base de données

**Statut actuel : 🎉 SYSTÈME OPÉRATIONNEL !**
