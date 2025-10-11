@extends('layouts.app')

@section('content')
<!-- Categories Page -->
<div class="categories-page">
    <!-- Hero Section -->
    <div class="categories-hero">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">📚 Explore Categories</h1>
                <p class="hero-subtitle">Discover books by your favorite categories</p>
                @auth
                <div class="user-favorites-badge">
                    <i class="fas fa-heart"></i>
                    <span>{{ $userFavoritesCount }} Favorite{{ $userFavoritesCount !== 1 ? 's' : '' }}</span>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="categories-section py-5">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- AI Recommendations Widget -->
            @auth
            <div class="ai-recommendations-widget mb-5" id="aiRecommendations" style="display: none;">
                <div class="ai-widget-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ai-icon">
                            <i class="fas fa-magic"></i>
                        </div>
                        <div>
                            <h3 class="ai-widget-title mb-1">
                                <i class="fas fa-sparkles"></i> AI Recommendations for You
                            </h3>
                            <p class="ai-widget-subtitle mb-0">Personalized categories based on your favorites</p>
                        </div>
                    </div>
                    <button class="btn-refresh-recommendations" onclick="loadAIRecommendations()" title="Refresh recommendations">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <div class="ai-widget-body" id="recommendationsContent">
                    <div class="loading-spinner text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Generating AI recommendations...</p>
                    </div>
                </div>

                <div class="ai-insights mt-3" id="aiInsights" style="display: none;">
                    <!-- Insights will be populated by JavaScript -->
                </div>
            </div>
            @endauth

            <div class="categories-grid">
                @forelse($categories as $category)
                <div class="category-card" data-category-id="{{ $category->id }}">
                    <div class="category-card-header" style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }}22, {{ $category->color ?? '#764ba2' }}44);">
                        <div class="category-icon">
                            @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                            @else
                            <i class="fas fa-book"></i>
                            @endif
                        </div>
                        
                        <!-- Favorite Heart Button -->
                        @auth
                        <button type="button" 
                                class="favorite-btn {{ $category->is_favorited ? 'is-favorited' : '' }}" 
                                data-category-id="{{ $category->id }}"
                                data-favorited="{{ $category->is_favorited ? 'true' : 'false' }}"
                                onclick="console.log('✅ ONCLICK DIRECT FONCTIONNE! ID:', this.dataset.categoryId);"
                                title="{{ $category->is_favorited ? 'Remove from favorites' : 'Add to favorites' }}">
                            <i class="heart-icon {{ $category->is_favorited ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="favorite-btn favorite-login-required" title="Login to add favorites">
                            <i class="heart-icon far fa-heart"></i>
                        </a>
                        @endauth
                    </div>

                    <div class="category-card-body">
                        <h3 class="category-name">{{ $category->name }}</h3>
                        
                        @if($category->description)
                        <p class="category-description">{{ Str::limit($category->description, 80) }}</p>
                        @endif

                        <div class="category-stats">
                            <div class="stat-item">
                                <i class="fas fa-book"></i>
                                <span>{{ $category->books_count }} {{ Str::plural('book', $category->books_count) }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-heart"></i>
                                <span class="favorites-count">{{ $category->favorites_count }}</span>
                                <span class="favorites-text">{{ Str::plural('favorite', $category->favorites_count) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('categories.show', $category) }}" class="btn-view-category">
                            View Books <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i>
                        No categories available at the moment.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
/* Categories Page Styles */
.categories-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.categories-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    animation: fadeInDown 0.8s ease;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.8s ease;
}

.user-favorites-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    animation: pulse 2s infinite;
}

.user-favorites-badge i {
    color: #ff6b6b;
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

/* Category Card */
.category-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease;
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.category-card-header {
    padding: 2rem;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.category-icon {
    font-size: 3rem;
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
}

/* Favorite Heart Button */
.favorite-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: white;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer !important;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 100;
    pointer-events: auto !important;
}

.favorite-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.favorite-btn.favorite-login-required {
    opacity: 0.6;
}

.heart-icon {
    font-size: 1.3rem;
    transition: all 0.3s ease;
    color: #ddd;
    pointer-events: none; /* Les clics passent à travers l'icône vers le bouton */
}

/* Heart filled (favorited) */
.favorite-btn.is-favorited .heart-icon {
    color: #ff6b6b;
    animation: heartBeat 0.3s ease;
}

/* Heart animation on click */
@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.3); }
    50% { transform: scale(0.9); }
    75% { transform: scale(1.1); }
}

/* Loading state */
.favorite-btn.loading {
    pointer-events: none;
    opacity: 0.6;
}

.favorite-btn.loading .heart-icon {
    animation: spin 0.5s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Category Card Body */
.category-card-body {
    padding: 1.5rem;
}

.category-name {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

.category-description {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.6;
}

.category-stats {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    padding: 1rem 0;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.9rem;
}

.stat-item i {
    color: #667eea;
}

.btn-view-category {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.btn-view-category:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

/* Success notification */
.favorite-notification {
    position: fixed;
    top: 100px;
    right: 20px;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 9999;
    animation: slideInRight 0.3s ease;
}

.favorite-notification.success {
    border-left: 4px solid #48bb78;
}

.favorite-notification.removed {
    border-left: 4px solid #f56565;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* AI Recommendations Widget Styles */
.ai-recommendations-widget {
    background: linear-gradient(135deg, #667eea22 0%, #764ba244 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.15);
    border: 2px solid rgba(102, 126, 234, 0.3);
    animation: fadeInUp 0.6s ease;
}

.ai-widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.ai-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    animation: pulse 2s infinite;
}

.ai-widget-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.ai-widget-subtitle {
    color: #718096;
    font-size: 0.95rem;
}

.btn-refresh-recommendations {
    background: white;
    border: 2px solid #667eea;
    color: #667eea;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.btn-refresh-recommendations:hover {
    background: #667eea;
    color: white;
    transform: rotate(180deg);
}

.ai-widget-body {
    min-height: 100px;
}

.recommendation-card {
    background: white;
    border-radius: 12px;
    padding: 1.2rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-left: 4px solid transparent;
}

.recommendation-card:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.recommendation-card.confidence-high {
    border-left-color: #48bb78;
}

.recommendation-card.confidence-medium {
    border-left-color: #ed8936;
}

.recommendation-card.confidence-low {
    border-left-color: #4299e1;
}

.recommendation-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.recommendation-content {
    flex: 1;
}

.recommendation-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.3rem;
}

.recommendation-reason {
    font-size: 0.85rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.recommendation-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: #a0aec0;
}

.recommendation-stats span {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.confidence-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.confidence-badge.high {
    background: #c6f6d5;
    color: #276749;
}

.confidence-badge.medium {
    background: #feebc8;
    color: #c05621;
}

.confidence-badge.low {
    background: #bee3f8;
    color: #2c5282;
}

.btn-view-recommendation {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-view-recommendation:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.ai-insights {
    background: white;
    border-radius: 12px;
    padding: 1.2rem;
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.insight-item {
    flex: 1;
    min-width: 200px;
    text-align: center;
}

.insight-value {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.insight-label {
    font-size: 0.85rem;
    color: #718096;
    margin-top: 0.3rem;
}

.no-recommendations {
    text-align: center;
    padding: 2rem;
    color: #718096;
}

.no-recommendations i {
    font-size: 3rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}
</style>

@endsection

@push('scripts')
<script>
// =============== AI RECOMMENDATIONS FUNCTIONS ===============
async function loadAIRecommendations() {
    const widget = document.getElementById('aiRecommendations');
    const content = document.getElementById('recommendationsContent');
    const insights = document.getElementById('aiInsights');
    
    if (!widget) return;
    
    // Check if user has favorites (from badge in header)
    const favoriteBadge = document.querySelector('.user-favorites-badge span');
    if (favoriteBadge) {
        const favoritesText = favoriteBadge.textContent;
        const favoritesCount = parseInt(favoritesText.match(/\d+/)?.[0] || 0);
        
        // Hide widget if no favorites
        if (favoritesCount === 0) {
            widget.style.display = 'none';
            return;
        }
    }
    
    // Show widget
    widget.style.display = 'block';
    
    // Show loading
    content.innerHTML = `
        <div class="loading-spinner text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Generating AI recommendations...</p>
        </div>
    `;
    
    try {
        const response = await fetch('/categories/ai-recommendations', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        console.log('AI Recommendations:', data);
        
        if (data.success && data.recommendations && data.recommendations.length > 0) {
            // Display recommendations
            content.innerHTML = data.recommendations.map(rec => {
                const category = rec.category;
                const confidenceClass = rec.confidence || 'low';
                const color = category.color || '#667eea';
                
                return `
                    <div class="recommendation-card confidence-${confidenceClass}">
                        <div class="recommendation-icon" style="background: ${color}22; color: ${color};">
                            <i class="${category.icon || 'fas fa-book'}"></i>
                        </div>
                        <div class="recommendation-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="recommendation-name">${category.name}</div>
                                    <div class="recommendation-reason">
                                        <i class="fas fa-lightbulb" style="color: #f6ad55;"></i>
                                        ${rec.reasons ? rec.reasons.join(' • ') : 'Recommended for you'}
                                    </div>
                                    <div class="recommendation-stats">
                                        <span><i class="fas fa-book"></i> ${category.books_count || 0} books</span>
                                        <span><i class="fas fa-heart"></i> ${category.favorites_count || 0} favorites</span>
                                        <span class="confidence-badge ${confidenceClass}">${confidenceClass} match</span>
                                    </div>
                                </div>
                                <a href="/categories/${category.id}" class="btn-view-recommendation">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            // Display insights
            if (data.insights) {
                const ins = data.insights;
                insights.style.display = 'block';
                insights.innerHTML = `
                    <div class="insight-item">
                        <div class="insight-value">${ins.total_favorites || 0}</div>
                        <div class="insight-label">Your Favorites</div>
                    </div>
                    <div class="insight-item">
                        <div class="insight-value">${ins.total_books_in_favorites || 0}</div>
                        <div class="insight-label">Books in Favorites</div>
                    </div>
                    <div class="insight-item">
                        <div class="insight-value" style="font-size: 1rem; padding: 0.5rem;">
                            ${ins.recommendation_quality || 'Good'}
                        </div>
                        <div class="insight-label">Recommendation Quality</div>
                    </div>
                `;
            }
        } else {
            content.innerHTML = `
                <div class="no-recommendations">
                    <i class="fas fa-magic"></i>
                    <p class="mb-2"><strong>No recommendations yet</strong></p>
                    <p>Start adding categories to your favorites to get personalized AI recommendations!</p>
                </div>
            `;
            insights.style.display = 'none';
        }
        
    } catch (error) {
        console.error('Error loading AI recommendations:', error);
        content.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                Failed to load AI recommendations. Please try again later.
            </div>
        `;
    }
}

// Load recommendations on page load for authenticated users
document.addEventListener('DOMContentLoaded', function() {
    @auth
    // Only load AI recommendations if user has favorites
    const userFavoritesCount = {{ $userFavoritesCount ?? 0 }};
    
    if (userFavoritesCount > 0) {
        // Load AI recommendations after a short delay
        setTimeout(() => {
            loadAIRecommendations();
        }, 500);
    } else {
        // Hide the widget completely if no favorites
        const widget = document.getElementById('aiRecommendations');
        if (widget) {
            widget.style.display = 'none';
        }
    }
    @endauth
    
    console.log('🔥 Script de favoris chargé');
    console.log('📍 URL actuelle:', window.location.href);
    console.log('🔍 Nombre total de boutons <button> dans le DOM:', document.querySelectorAll('button').length);
    
    // CSRF Token setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('❌ CSRF Token non trouvé! Ajoutez <meta name="csrf-token" content="{{ csrf_token() }}"> dans le head');
        return;
    }
    const csrfTokenValue = csrfToken.getAttribute('content');
    console.log('✅ CSRF Token trouvé');

    // Get all favorite buttons
    const favoriteButtons = document.querySelectorAll('.favorite-btn:not(.favorite-login-required)');
    console.log(`✅ ${favoriteButtons.length} boutons de favoris trouvés`);
    
    // Test: Add a temporary border to all buttons to verify they're found
    favoriteButtons.forEach(btn => {
        btn.style.border = '2px solid red';
        console.log('🎨 Bordure rouge ajoutée au bouton:', btn.dataset.categoryId);
    });

    favoriteButtons.forEach(button => {
        console.log('➕ Ajout listener sur bouton:', button.dataset.categoryId);
        
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('🖱️ Clic détecté sur bouton favori!');
            console.log('Bouton cliqué:', this);
            console.log('Classe du bouton:', this.className);

            const categoryId = this.getAttribute('data-category-id');
            const isFavorited = this.getAttribute('data-favorited') === 'true';
            
            console.log(`Catégorie ID: ${categoryId}, Est favori: ${isFavorited}`);

            // Add loading state
            this.classList.add('loading');

            try {
                console.log(`📡 Envoi requête AJAX vers: /category-favorites/toggle/${categoryId}`);
                
                // Call API to toggle favorite
                const response = await fetch(`/category-favorites/toggle/${categoryId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfTokenValue,
                        'Accept': 'application/json'
                    }
                });

                console.log('📥 Réponse reçue:', response.status);
                const data = await response.json();
                console.log('📊 Données:', data);

                if (data.success) {
                    // Update button state
                    const heartIcon = this.querySelector('.heart-icon');
                    
                    if (data.favorited) {
                        // Added to favorites
                        this.classList.add('is-favorited');
                        this.setAttribute('data-favorited', 'true');
                        this.setAttribute('title', 'Remove from favorites');
                        heartIcon.classList.remove('far');
                        heartIcon.classList.add('fas');
                        
                        // Show notification
                        showNotification('success', data.message);
                    } else {
                        // Removed from favorites
                        this.classList.remove('is-favorited');
                        this.setAttribute('data-favorited', 'false');
                        this.setAttribute('title', 'Add to favorites');
                        heartIcon.classList.remove('fas');
                        heartIcon.classList.add('far');
                        
                        // Show notification
                        showNotification('removed', data.message);
                    }

                    // Update favorites count in the card
                    const card = this.closest('.category-card');
                    const favoritesCountElement = card.querySelector('.favorites-count');
                    if (favoritesCountElement) {
                        favoritesCountElement.textContent = data.favorites_count;
                    }

                    // Update user's total favorites count in header
                    updateUserFavoritesCount(data.favorited ? 1 : -1);
                    
                    // Reload AI recommendations after adding/removing favorites
                    @auth
                    if (typeof loadAIRecommendations === 'function') {
                        setTimeout(() => {
                            loadAIRecommendations();
                        }, 500);
                    }
                    @endauth
                }

            } catch (error) {
                console.error('❌ Erreur lors du toggle:', error);
                showNotification('error', 'An error occurred. Please try again.');
            } finally {
                // Remove loading state
                this.classList.remove('loading');
                console.log('✅ Loading state retiré');
            }
        });
    });

    // Show notification function
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `favorite-notification ${type}`;
        
        const icon = type === 'success' ? 'fa-heart' : (type === 'removed' ? 'fa-heart-broken' : 'fa-exclamation-circle');
        const iconColor = type === 'success' ? '#48bb78' : (type === 'removed' ? '#f56565' : '#f6ad55');
        
        notification.innerHTML = `
            <i class="fas ${icon}" style="color: ${iconColor}; font-size: 1.2rem;"></i>
            <span style="font-weight: 500;">${message}</span>
        `;

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Update user's total favorites count
    function updateUserFavoritesCount(delta) {
        const badge = document.querySelector('.user-favorites-badge span');
        if (badge) {
            const currentText = badge.textContent;
            const currentCount = parseInt(currentText.match(/\d+/)[0]);
            const newCount = currentCount + delta;
            badge.textContent = `${newCount} Favorite${newCount !== 1 ? 's' : ''}`;
        }
    }
});

// Add slideOutRight animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
