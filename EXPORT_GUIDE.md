# 📥 Guide d'Exportation des Statistiques BookShare

## 🎯 Comment Exporter en PDF

### Méthode 1 : Export PDF (Recommandé)

1. **Cliquer sur "Export Report"** dans le dashboard
2. **Sélectionner "PDF"** 
3. **Choisir vos options** (période, graphiques, etc.)
4. **Cliquer "Download Report"**

#### 📌 Une nouvelle page s'ouvre avec des instructions :

```
┌──────────────────────────────────────────────┐
│  📄 INSTRUCTIONS POUR SAUVEGARDER EN PDF:    │
│                                              │
│  1. La boîte de dialogue d'impression       │
│     va s'ouvrir                             │
│                                              │
│  2. Sélectionnez "Microsoft Print to PDF"   │
│     ou "Enregistrer au format PDF"          │
│                                              │
│  3. Choisissez votre dossier                │
│                                              │
│  4. Cliquez sur "Enregistrer"               │
└──────────────────────────────────────────────┘
```

5. **Suivre les instructions** qui apparaissent
6. **Dialogue d'impression s'ouvre automatiquement**
7. **Choisir l'imprimante** : 
   - Windows : "Microsoft Print to PDF"
   - Chrome : "Enregistrer au format PDF"
8. **Cliquer sur "Imprimer"** ou "Enregistrer"
9. **Choisir le dossier** de destination (par exemple : Téléchargements)
10. **Donner un nom** au fichier (ex: `statistiques_reviews_2025-10-09.pdf`)
11. **Cliquer "Enregistrer"** ✅

---

## 📊 Comment Exporter en Excel

### Méthode : Export Excel Direct

1. **Cliquer sur "Export Report"**
2. **Sélectionner "Excel"**
3. **Configurer les options**
4. **Cliquer "Download Report"**
5. **Le fichier .xls se télécharge automatiquement** dans votre dossier Téléchargements
6. **Ouvrir avec Excel** ou LibreOffice Calc

#### ⚠️ Si Excel ne s'ouvre pas :

**Solution 1 : Ouvrir manuellement**
- Aller dans "Téléchargements"
- Trouver le fichier `review_statistics_*.xls`
- Clic droit → "Ouvrir avec" → "Microsoft Excel"

**Solution 2 : Changer l'extension**
- Si le fichier ne s'ouvre pas, renommer en `.xlsx`
- Exemple : `review_statistics.xls` → `review_statistics.xlsx`

---

## 📋 Comment Exporter en CSV

### Méthode : Export CSV (Le plus simple)

1. **Cliquer sur "Export Report"**
2. **Sélectionner "CSV"**
3. **Configurer les options**
4. **Cliquer "Download Report"**
5. **Le fichier .csv se télécharge automatiquement**
6. **Double-cliquer** pour ouvrir dans Excel

#### ✅ Avantages du CSV :
- ✅ Compatible avec tous les tableurs
- ✅ Encodage UTF-8 (accents préservés)
- ✅ Sections bien organisées
- ✅ Totaux et pourcentages calculés

---

## 🎨 Contenu des Exports

### Tous les formats incluent :

#### 📈 **Statistiques Résumées**
- Total des reviews
- Reviews approuvés
- Reviews en attente
- Reviews rejetés
- Note moyenne
- Taux d'approbation

#### ⭐ **Distribution des Notes**
- Répartition 1-5 étoiles
- Comptage par note
- Pourcentages
- Visualisations

#### 🏆 **Top 10 Livres**
- Meilleurs livres par note
- Nombre de reviews par livre
- Auteurs
- Classement

#### 📝 **Détails des Reviews** (optionnel)
- ID de la review
- Titre du livre
- Nom du reviewer
- Note et commentaire
- Statut (approuvé/pending/rejeté)
- Date de création

---

## 🔧 Dépannage

### Problème : "Le fichier PDF ne se télécharge pas"

**Solution :**
1. Vérifiez que les popups sont autorisées
2. Essayez avec un autre navigateur (Chrome recommandé)
3. Désactivez les bloqueurs de popups
4. Essayez l'export CSV ou Excel à la place

### Problème : "Excel dit que le fichier est corrompu"

**Solution :**
1. Cliquez sur "Oui" pour récupérer le contenu
2. Excel ouvrira quand même le fichier
3. Ou utilisez l'export CSV qui fonctionne toujours

### Problème : "Les accents sont bizarres dans Excel"

**Solution pour CSV :**
1. Ouvrir Excel vide
2. Fichier → Importer → Données texte
3. Choisir le fichier CSV
4. Sélectionner "UTF-8" comme encodage
5. Cliquer "Terminer"

---

## 💡 Conseils Pro

### 🎯 Pour de meilleurs résultats :

**Export PDF :**
- ✅ Utilisez Chrome ou Edge pour de meilleurs rendus
- ✅ Désactivez les en-têtes/pieds de page dans les options d'impression
- ✅ Choisissez orientation "Portrait"

**Export Excel :**
- ✅ Le fichier s'ouvre directement dans Excel
- ✅ Toutes les couleurs et styles sont préservés
- ✅ Vous pouvez modifier les données après export

**Export CSV :**
- ✅ Le plus universel et fiable
- ✅ Compatible avec Google Sheets, Numbers, etc.
- ✅ Facile à importer dans d'autres systèmes

---

## 📍 Où Trouver Vos Fichiers

**Emplacement par défaut :**
```
C:\Users\[VotreNom]\Downloads\
```

**Nom des fichiers :**
- PDF : `review_statistics_2025-10-09_143022.pdf`
- Excel : `review_statistics_2025-10-09_143022.xls`
- CSV : `review_statistics_2025-10-09.csv`

---

## ❓ Questions Fréquentes

**Q : Puis-je personnaliser le nom du fichier ?**
R : Oui ! Dans le modal d'export, il y a un champ "File Name" optionnel.

**Q : Combien de données puis-je exporter ?**
R : Toutes ! Il n'y a pas de limite. Utilisez les filtres de période pour cibler vos besoins.

**Q : Les graphiques sont-ils inclus ?**
R : Oui, si vous cochez "Include Charts & Graphs" dans les options.

**Q : Puis-je exporter plusieurs périodes ?**
R : Oui, exportez séparément ou utilisez une large période qui couvre tout.

---

## 📞 Besoin d'Aide ?

Si vous rencontrez des problèmes :
1. Consultez ce guide
2. Essayez un format différent (CSV est le plus fiable)
3. Contactez le support technique

---

**Dernière mise à jour :** Octobre 2025  
**Version :** 1.0
