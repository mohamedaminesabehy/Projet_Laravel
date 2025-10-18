@extends('layouts.app')

@section('content')
<!-- Modern Categories Page with Enhanced Design -->
<div class="modern-categories-page">
    <!-- Enhanced Hero Section with Gradient Background -->
    <div class="modern-categories-hero">
        <div class="container">
            <div class="hero-content-wrapper text-center">
                <!-- Animated Icon Container -->
                <div class="hero-icon-container">
                    <div class="hero-book-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
                
                <!-- Modern Typography -->
                <h1 class="modern-hero-title">Explore Categories</h1>
                <p class="modern-hero-subtitle">Discover amazing books organized by your favorite categories and interests</p>
                
                <!-- Enhanced User Favorites Badge -->
                @auth
                <div class="modern-favorites-badge">
                    <div class="badge-icon-wrapper">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="badge-content">
                        <span class="badge-count">{{ $userFavoritesCount }}</span>
                        <span class="badge-text">Favorite{{ $userFavoritesCount !== 1 ? 's' : '' }}</span>
                    </div>
                </div>
                @endauth
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="hero-decoration">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
        </div>
    </div>

    <!-- Modern Categories Content Section -->
    <div class="modern-categories-section py-5">
        <div class="container">
            <!-- Enhanced Alert Messages -->
            @if(session('success'))
            <div class="modern-alert success-alert" role="alert">
                <div class="alert-icon-wrapper">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
                <button type="button" class="modern-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="modern-alert error-alert" role="alert">
                <div class="alert-icon-wrapper">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-message">{{ session('error') }}</div>
                </div>
                <button type="button" class="modern-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Enhanced AI Recommendations Widget -->
            @auth
            <div class="modern-ai-recommendations-widget mb-5" id="aiRecommendations" style="display: none;">
                <div class="ai-widget-header-modern">
                    <div class="ai-header-content">
                        <div class="ai-icon-modern">
                            <i class="fas fa-magic"></i>
                            <div class="ai-sparkles">
                                <div class="sparkle sparkle-1"></div>
                                <div class="sparkle sparkle-2"></div>
                                <div class="sparkle sparkle-3"></div>
                            </div>
                        </div>
                        <div class="ai-header-text">
                            <h3 class="ai-widget-title-modern">
                                AI Recommendations for You
                            </h3>
                            <p class="ai-widget-subtitle-modern">Personalized categories based on your reading preferences</p>
                        </div>
                    </div>
                    <button class="modern-refresh-btn" onclick="loadAIRecommendations()" title="Refresh recommendations">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <div class="ai-widget-body-modern" id="recommendationsContent">
                    <div class="modern-loading-spinner text-center py-4">
                        <div class="loading-circle">
                            <div class="loading-dot dot-1"></div>
                            <div class="loading-dot dot-2"></div>
                            <div class="loading-dot dot-3"></div>
                        </div>
                        <p class="loading-text">Generating AI recommendations...</p>
                    </div>
                </div>

                <div class="modern-ai-insights mt-3" id="aiInsights" style="display: none;">
                    <!-- Insights will be populated by JavaScript -->
                </div>
            </div>
            @endauth

            <!-- Modern Categories Grid -->
            <div class="modern-categories-grid">
                @forelse($categories as $category)
                <div class="modern-category-card" data-category-id="{{ $category->id }}">
                    <!-- Enhanced Card Header with Gradient Background -->
                    <div class="modern-card-header" style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }}15, {{ $category->color ?? '#764ba2' }}25);">
                        <!-- Modern Category Icon -->
                        <div class="modern-category-icon">
                            @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                            @else
                            <i class="fas fa-book"></i>
                            @endif
                        </div>
                        
                        <!-- Enhanced Favorite Heart Button -->
                        @auth
                        <button type="button" 
                                class="modern-favorite-btn {{ $category->is_favorited ? 'is-favorited' : '' }}" 
                                data-category-id="{{ $category->id }}"
                                data-favorited="{{ $category->is_favorited ? 'true' : 'false' }}"
                                onclick="console.log('✅ ONCLICK DIRECT FONCTIONNE! ID:', this.dataset.categoryId);"
                                title="{{ $category->is_favorited ? 'Remove from favorites' : 'Add to favorites' }}">
                            <div class="heart-wrapper">
                                <i class="modern-heart-icon {{ $category->is_favorited ? 'fas' : 'far' }} fa-heart"></i>
                            </div>
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="modern-favorite-btn favorite-login-required" title="Login to add favorites">
                            <div class="heart-wrapper">
                                <i class="modern-heart-icon far fa-heart"></i>
                            </div>
                        </a>
                        @endauth
                    </div>

                    <!-- Modern Card Body -->
                    <div class="modern-card-body">
                        <h3 class="modern-category-name">{{ $category->name }}</h3>
                        
                        @if($category->description)
                        <p class="modern-category-description">{{ Str::limit($category->description, 80) }}</p>
                        @endif

                        <!-- Enhanced Category Statistics -->
                        <div class="modern-category-stats">
                            <div class="modern-stat-item">
                                <div class="stat-icon-container">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">{{ $category->books_count }}</span>
                                    <span class="stat-label">{{ Str::plural('book', $category->books_count) }}</span>
                                </div>
                            </div>
                            <div class="modern-stat-item">
                                <div class="stat-icon-container">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number favorites-count">{{ $category->favorites_count }}</span>
                                    <span class="stat-label favorites-text">{{ Str::plural('favorite', $category->favorites_count) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Modern View Category Button -->
                        <a href="{{ route('categories.show', $category) }}" class="modern-view-btn">
                            <span class="btn-text">Explore Books</span>
                            <div class="btn-icon-wrapper">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Enhanced Empty State -->
                <div class="modern-empty-state">
                    <div class="empty-state-container">
                        <div class="empty-state-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="empty-state-title">No Categories Available</h3>
                        <p class="empty-state-description">
                            We're working on adding amazing book categories for you to explore. 
                            Check back soon for exciting new content!
                        </p>
                        <a href="{{ route('home') }}" class="modern-cta-button">
                            <i class="fas fa-home"></i>
                            <span>Back to Home</span>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
/* ===============================================
   MODERN CATEGORIES PAGE STYLES
   Enhanced design with professional aesthetics
   =============================================== */

/* Main Page Container */
.modern-categories-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Enhanced Hero Section */
.modern-categories-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 6rem 0 5rem;
    position: relative;
    overflow: hidden;
}

.modern-categories-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    opacity: 0.4;
}

.hero-content-wrapper {
    text-align: center;
    position: relative;
    z-index: 2;
}

.hero-icon-container {
    margin-bottom: 2rem;
    animation: bookFloat 3s ease-in-out infinite;
}

.hero-book-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.hero-book-icon i {
    font-size: 3rem;
    color: white;
    filter: drop-shadow(0 4px 20px rgba(0, 0, 0, 0.2));
}

.modern-hero-title {
    font-size: 4rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    animation: fadeInUp 0.8s ease-out;
}

.modern-hero-subtitle {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 400;
    max-width: 700px;
    margin: 0 auto 2.5rem;
    line-height: 1.6;
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

/* Enhanced Favorites Badge */
.modern-favorites-badge {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    padding: 1rem 2rem;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: fadeInUp 0.8s ease-out 0.4s both;
}

.badge-icon-wrapper {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: heartPulse 2s ease-in-out infinite;
}

.badge-icon-wrapper i {
    font-size: 1.5rem;
    color: white;
}

.badge-content {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.badge-count {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.badge-text {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

/* Floating Decorative Elements */
.hero-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.floating-element {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.element-1 {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.element-2 {
    width: 60px;
    height: 60px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
}

.element-3 {
    width: 100px;
    height: 100px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

/* Modern Categories Content Section */
.modern-categories-section {
    padding: 4rem 0;
}

/* Enhanced Alert Styling */
.modern-alert {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    border: none;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    animation: slideInDown 0.5s ease-out;
    position: relative;
    overflow: hidden;
}

.modern-alert::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
}

.success-alert {
    background: linear-gradient(135deg, #48bb7810, #48bb7820);
    color: #2f855a;
}

.error-alert {
    background: linear-gradient(135deg, #f5656510, #f5656520);
    color: #c53030;
}

.alert-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: currentColor;
    color: white;
    font-size: 1.3rem;
}

.alert-content {
    flex: 1;
}

.alert-message {
    font-weight: 600;
    font-size: 1rem;
}

.modern-alert-close {
    background: none;
    border: none;
    color: currentColor;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    opacity: 0.7;
}

.modern-alert-close:hover {
    background: rgba(0, 0, 0, 0.1);
    opacity: 1;
}

/* Enhanced AI Recommendations Widget */
.modern-ai-recommendations-widget {
    background: linear-gradient(135deg, #667eea15, #764ba225);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 15px 50px rgba(102, 126, 234, 0.15);
    border: 2px solid rgba(102, 126, 234, 0.2);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.6s ease;
}

.modern-ai-recommendations-widget::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.ai-widget-header-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.ai-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.ai-icon-modern {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    position: relative;
    animation: pulse 2s infinite;
}

.ai-sparkles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.sparkle {
    position: absolute;
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    animation: sparkle 2s ease-in-out infinite;
}

.sparkle-1 {
    top: 15%;
    right: 20%;
    animation-delay: 0s;
}

.sparkle-2 {
    bottom: 20%;
    left: 15%;
    animation-delay: 0.7s;
}

.sparkle-3 {
    top: 60%;
    right: 15%;
    animation-delay: 1.4s;
}

.ai-widget-title-modern {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
}

.ai-widget-subtitle-modern {
    color: #718096;
    font-size: 1rem;
    margin: 0;
}

.modern-refresh-btn {
    background: white;
    border: 2px solid #667eea;
    color: #667eea;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.modern-refresh-btn:hover {
    background: #667eea;
    color: white;
    transform: rotate(180deg) scale(1.1);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Modern Loading Spinner */
.modern-loading-spinner {
    padding: 3rem 0;
}

.loading-circle {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.loading-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    animation: loadingBounce 1.4s ease-in-out infinite both;
}

.dot-1 { animation-delay: -0.32s; }
.dot-2 { animation-delay: -0.16s; }
.dot-3 { animation-delay: 0s; }

.loading-text {
    color: #718096;
    font-size: 1rem;
    font-weight: 500;
}

/* Modern Categories Grid */
.modern-categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2.5rem;
    margin-top: 2rem;
}

/* Modern Category Card */
.modern-category-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    animation: fadeInUp 0.6s ease;
}

.modern-category-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.modern-card-header {
    padding: 3rem 2.5rem;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modern-category-icon {
    width: 90px;
    height: 90px;
    background: white;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    color: #667eea;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
}

/* Enhanced Favorite Heart Button */
.modern-favorite-btn {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: white;
    border: none;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    z-index: 100;
    pointer-events: auto;
}

.modern-favorite-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.modern-favorite-btn.favorite-login-required {
    opacity: 0.6;
}

.heart-wrapper {
    position: relative;
}

.modern-heart-icon {
    font-size: 1.4rem;
    transition: all 0.3s ease;
    color: #ddd;
    pointer-events: none;
}

/* Heart filled (favorited) */
.modern-favorite-btn.is-favorited .modern-heart-icon {
    color: #ff6b6b;
    animation: heartBeat 0.4s ease;
}

/* Heart animation on click */
@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.3); }
    50% { transform: scale(0.9); }
    75% { transform: scale(1.1); }
}

/* Loading state */
.modern-favorite-btn.loading {
    pointer-events: none;
    opacity: 0.6;
}

.modern-favorite-btn.loading .modern-heart-icon {
    animation: spin 0.5s linear infinite;
}

/* Modern Card Body */
.modern-card-body {
    padding: 2.5rem;
}

.modern-category-name {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.modern-category-description {
    color: #718096;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* Enhanced Category Statistics */
.modern-category-stats {
    display: flex;
    gap: 2rem;
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}

.modern-stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.stat-icon-container {
    width: 45px;
    height: 45px;
    background: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-icon-container i {
    font-size: 1.2rem;
    color: #667eea;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: #718096;
    font-weight: 500;
}

/* Modern View Button */
.modern-view-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.2rem 2rem;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.modern-view-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.modern-view-btn:hover::before {
    left: 100%;
}

.modern-view-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-icon-wrapper {
    width: 35px;
    height: 35px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.modern-view-btn:hover .btn-icon-wrapper {
    transform: translateX(5px);
}

/* Enhanced Empty State */
.modern-empty-state {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    padding: 4rem 2rem;
}

.empty-state-container {
    text-align: center;
    max-width: 500px;
}

.empty-state-icon {
    margin-bottom: 2rem;
    animation: float 3s ease-in-out infinite;
}

.empty-state-icon i {
    font-size: 5rem;
    color: #cbd5e0;
}

.empty-state-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-state-description {
    font-size: 1.1rem;
    color: #718096;
    line-height: 1.6;
    margin-bottom: 2.5rem;
}

.modern-cta-button {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem 2.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.modern-cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Animations */
@keyframes bookFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

@keyframes heartPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0); }
    50% { opacity: 1; transform: scale(1); }
}

@keyframes loadingBounce {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Success notification */
.favorite-notification {
    position: fixed;
    top: 100px;
    right: 20px;
    background: white;
    padding: 1.25rem 1.75rem;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 9999;
    animation: slideInRight 0.3s ease;
    border-left: 4px solid currentColor;
}

.favorite-notification.success {
    color: #48bb78;
}

.favorite-notification.removed {
    color: #f56565;
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

/* Responsive Design */
@media (max-width: 768px) {
    .modern-hero-title {
        font-size: 2.8rem;
    }
    
    .modern-hero-subtitle {
        font-size: 1.1rem;
    }
    
    .modern-categories-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .modern-category-card {
        margin: 0 1rem;
    }
    
    .modern-category-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .modern-ai-recommendations-widget {
        padding: 2rem;
    }
    
    .ai-header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .modern-categories-hero {
        padding: 4rem 0 3rem;
    }
    
    .modern-hero-title {
        font-size: 2.2rem;
    }
    
    .hero-book-icon {
        width: 80px;
        height: 80px;
    }
    
    .hero-book-icon i {
        font-size: 2.5rem;
    }
    
    .modern-card-body {
        padding: 2rem;
    }
    
    .modern-category-stats {
        padding: 1rem;
    }
}
</style>
<style>
   

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
    const favoriteBadge = document.querySelector('.modern-favorites-badge .badge-count');
    if (favoriteBadge) {
        const favoritesCount = parseInt(favoriteBadge.textContent || 0);
        
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
        <div class="modern-loading-spinner text-center py-4">
            <div class="loading-circle">
                <div class="loading-dot dot-1"></div>
                <div class="loading-dot dot-2"></div>
                <div class="loading-dot dot-3"></div>
            </div>
            <p class="loading-text">Generating AI recommendations...</p>
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

    // Get all favorite buttons with modern class names
    const favoriteButtons = document.querySelectorAll('.modern-favorite-btn:not(.favorite-login-required)');
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
                const response = await fetch(`/favorites/toggle/${categoryId}`, {
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
                    const heartIcon = this.querySelector('.modern-heart-icon');
                    
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
                    const card = this.closest('.modern-category-card');
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
        const badge = document.querySelector('.modern-favorites-badge .badge-count');
        if (badge) {
            const currentCount = parseInt(badge.textContent || 0);
            const newCount = currentCount + delta;
            badge.textContent = newCount;
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
