<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Système de Favoris - CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .header h1 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
        }

        .test-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .test-section h2 {
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .test-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            margin: 5px;
        }

        .test-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .test-button:active {
            transform: translateY(0);
        }

        .test-button.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .test-button.danger {
            background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        }

        .result {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            max-height: 400px;
            overflow-y: auto;
        }

        .result.success {
            border-color: #38ef7d;
            background: #e8f5e9;
        }

        .result.error {
            border-color: #f45c43;
            background: #ffebee;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .status-badge.success {
            background: #38ef7d;
            color: white;
        }

        .status-badge.error {
            background: #f45c43;
            color: white;
        }

        .user-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .category-selector {
            padding: 10px 15px;
            border: 2px solid #667eea;
            border-radius: 10px;
            font-size: 14px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-vial"></i> Test du Système de Favoris - CRUD Complet</h1>
            <p>Interface de test pour vérifier toutes les opérations sur les favoris de catégories</p>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-user-circle"></i> Informations Utilisateur</h2>
            <div class="user-info" id="userInfo">
                <p><strong>Utilisateur:</strong> <span id="userName">Chargement...</span></p>
                <p><strong>Email:</strong> <span id="userEmail">Chargement...</span></p>
                <p><strong>Favoris actuels:</strong> <span id="favCount">0</span></p>
            </div>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-list"></i> Sélection de Catégorie</h2>
            <select id="categorySelector" class="category-selector">
                <option value="">Chargement...</option>
            </select>
            <button class="test-button" onclick="loadCategories()">
                <i class="fas fa-sync"></i> Recharger
            </button>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-toggle-on"></i> Test 1: TOGGLE (Ajouter/Retirer)</h2>
            <button class="test-button" onclick="testToggle()">
                <i class="fas fa-heart"></i> Tester Toggle
            </button>
            <div id="result-toggle" class="result" style="display: none;"></div>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-check"></i> Test 2: CHECK (Vérifier Statut)</h2>
            <button class="test-button" onclick="testCheck()">
                <i class="fas fa-search"></i> Vérifier Statut
            </button>
            <div id="result-check" class="result" style="display: none;"></div>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-plus"></i> Test 3: STORE (Créer)</h2>
            <button class="test-button success" onclick="testStore()">
                <i class="fas fa-plus-circle"></i> Créer Favori
            </button>
            <div id="result-store" class="result" style="display: none;"></div>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-trash"></i> Test 4: DESTROY (Supprimer)</h2>
            <button class="test-button danger" onclick="testDestroy()">
                <i class="fas fa-trash-alt"></i> Supprimer Favori
            </button>
            <div id="result-destroy" class="result" style="display: none;"></div>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-chart-bar"></i> Test 5: STATISTICS</h2>
            <button class="test-button" onclick="testStatistics()">
                <i class="fas fa-chart-line"></i> Obtenir Statistiques
            </button>
            <div id="result-statistics" class="result" style="display: none;"></div>
        </div>

        <div class="test-section">
            <h2><i class="fas fa-list-ul"></i> Test 6: USER FAVORITES</h2>
            <button class="test-button" onclick="testUserFavorites()">
                <i class="fas fa-heart"></i> Lister Mes Favoris
            </button>
            <div id="result-user-favorites" class="result" style="display: none;"></div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let categories = [];

        // Charger les catégories au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            loadCategories();
            loadUserInfo();
        });

        async function loadCategories() {
            try {
                const response = await fetch('/categories');
                const html = await response.text();
                
                // Parser le HTML pour extraire les catégories
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const categoryCards = doc.querySelectorAll('.category-card');
                
                const selector = document.getElementById('categorySelector');
                selector.innerHTML = '<option value="">Sélectionnez une catégorie</option>';
                
                categoryCards.forEach(card => {
                    const name = card.querySelector('h3, h4')?.textContent.trim();
                    const id = card.querySelector('.favorite-btn')?.dataset.categoryId;
                    
                    if (id && name) {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        selector.appendChild(option);
                    }
                });
            } catch (error) {
                console.error('Erreur chargement catégories:', error);
            }
        }

        async function loadUserInfo() {
            // Charger via les stats
            try {
                const response = await fetch('/category-favorites/statistics', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('favCount').textContent = data.statistics.total_favorites;
                }
            } catch (error) {
                console.error('Erreur chargement info user:', error);
            }
        }

        function getCategoryId() {
            const id = document.getElementById('categorySelector').value;
            if (!id) {
                alert('Veuillez sélectionner une catégorie');
                throw new Error('No category selected');
            }
            return id;
        }

        function showResult(elementId, content, isSuccess = true) {
            const element = document.getElementById(elementId);
            element.style.display = 'block';
            element.className = 'result ' + (isSuccess ? 'success' : 'error');
            element.innerHTML = '<pre>' + JSON.stringify(content, null, 2) + '</pre>';
        }

        async function testToggle() {
            try {
                const categoryId = getCategoryId();
                const response = await fetch(`/category-favorites/toggle/${categoryId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                showResult('result-toggle', data, data.success);
                loadUserInfo();
            } catch (error) {
                showResult('result-toggle', { error: error.message }, false);
            }
        }

        async function testCheck() {
            try {
                const categoryId = getCategoryId();
                const response = await fetch(`/category-favorites/check/${categoryId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const data = await response.json();
                showResult('result-check', data, data.success);
            } catch (error) {
                showResult('result-check', { error: error.message }, false);
            }
        }

        async function testStore() {
            try {
                const categoryId = getCategoryId();
                const response = await fetch('/category-favorites', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ category_id: categoryId })
                });
                
                const data = await response.json();
                showResult('result-store', data, data.success);
                loadUserInfo();
            } catch (error) {
                showResult('result-store', { error: error.message }, false);
            }
        }

        async function testDestroy() {
            try {
                const categoryId = getCategoryId();
                const response = await fetch(`/category-favorites/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                showResult('result-destroy', data, data.success);
                loadUserInfo();
            } catch (error) {
                showResult('result-destroy', { error: error.message }, false);
            }
        }

        async function testStatistics() {
            try {
                const response = await fetch('/category-favorites/statistics', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const data = await response.json();
                showResult('result-statistics', data, data.success);
            } catch (error) {
                showResult('result-statistics', { error: error.message }, false);
            }
        }

        async function testUserFavorites() {
            try {
                const response = await fetch('/category-favorites/user', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const data = await response.json();
                showResult('result-user-favorites', data, data.success);
            } catch (error) {
                showResult('result-user-favorites', { error: error.message }, false);
            }
        }
    </script>
</body>
</html>
