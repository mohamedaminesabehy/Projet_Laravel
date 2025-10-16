@extends('layouts.app')

@push('styles')
<style>
/* Hero Animation */
@keyframes floatAnimation {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes pulseGlow {
    0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.4); }
    50% { box-shadow: 0 0 40px rgba(102, 126, 234, 0.8), 0 0 60px rgba(118, 75, 162, 0.6); }
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.ai-hero {
    background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.ai-hero::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    top: -250px;
    right: -250px;
    animation: floatAnimation 8s ease-in-out infinite;
}

.ai-hero::after {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    bottom: -200px;
    left: -200px;
    animation: floatAnimation 10s ease-in-out infinite reverse;
}

.brain-icon {
    font-size: 80px;
    animation: pulseGlow 3s ease-in-out infinite, floatAnimation 6s ease-in-out infinite;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
}

.slide-in {
    animation: slideInUp 0.6s ease-out forwards;
}

.stats-card-modern {
    background: white;
    border-radius: 20px;
    padding: 30px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
}

.stats-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.stats-card-modern:hover::before {
    left: 100%;
}

.stats-card-modern:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.filter-bar {
    background: white;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.book-card-modern {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    height: 100%;
}

.book-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
    transform: scaleX(0);
    transition: transform 0.5s ease;
}

.book-card-modern:hover::before {
    transform: scaleX(1);
}

.book-card-modern:hover {
    transform: translateY(-15px) rotateX(5deg);
    box-shadow: 0 25px 60px rgba(102, 126, 234, 0.3);
}

.book-card-header-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px;
    position: relative;
    overflow: hidden;
}

.book-image-modern {
    width: 100px;
    height: 140px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    transition: transform 0.5s ease;
}

.book-card-modern:hover .book-image-modern {
    transform: scale(1.1) rotateY(10deg);
}

.sentiment-bar-3d {
    height: 40px;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    box-shadow: inset 0 4px 8px rgba(0,0,0,0.2);
}

.sentiment-segment {
    height: 100%;
    float: left;
    position: relative;
    transition: all 0.5s ease;
}

.sentiment-segment::before {
    content: attr(data-value);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-weight: bold;
    font-size: 14px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.badge-3d {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.badge-3d:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
}

.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.neon-text {
    text-shadow: 
        0 0 10px rgba(255,255,255,0.8),
        0 0 20px rgba(102, 126, 234, 0.6),
        0 0 30px rgba(118, 75, 162, 0.4);
}

@media (max-width: 768px) {
    .brain-icon { font-size: 50px; }
    .ai-hero { padding: 50px 0; }
}
</style>
@endpush

@section('content')
<!-- AI Hero Section -->
<section class="ai-hero">
    <div class="container position-relative" style="z-index: 10;">
        <div class="text-center text-white mb-5">
            <div class="brain-icon mb-4">
                <i class="fas fa-brain" style="color: #FFD700;"></i>
            </div>
            <h1 class="neon-text" style="font-size: 48px; font-weight: bold; margin-bottom: 20px;">
                🚀 AI Book Insights
            </h1>
            <p style="font-size: 20px; opacity: 0.95; max-width: 800px; margin: 0 auto 30px;">
                Découvrez ce que l'intelligence artificielle révèle sur vos livres préférés grâce à l'analyse de milliers d'avis de lecteurs
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <div class="glass-effect" style="padding: 15px 30px; border-radius: 15px;">
                    <i class="fas fa-robot"></i> Powered by Google Gemini AI
                </div>
                <div class="glass-effect" style="padding: 15px 30px; border-radius: 15px;">
                    <i class="fas fa-chart-line"></i> Analyses en Temps Réel
                </div>
                <div class="glass-effect" style="padding: 15px 30px; border-radius: 15px;">
                    <i class="fas fa-shield-alt"></i> 100% Objectif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="space-top">
    <div class="container">
        <div class="row g-4 mb-50">
            <div class="col-xl-3 col-md-6 slide-in" style="animation-delay: 0.1s;">
                <div class="stats-card-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex align-items-center" style="color: white;">
                        <div style="font-size: 60px; opacity: 0.3; position: absolute; right: 20px; top: 20px;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="position-relative" style="z-index: 2;">
                            <div style="font-size: 42px; font-weight: bold; margin-bottom: 5px;">
                                {{ $stats['total_books'] }}
                            </div>
                            <div style="font-size: 14px; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;">
                                Livres Analysés
                            </div>
                            <div style="margin-top: 10px; font-size: 12px; opacity: 0.8;">
                                <i class="fas fa-check-circle"></i> Avec AI Insights
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 slide-in" style="animation-delay: 0.2s;">
                <div class="stats-card-modern" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="d-flex align-items-center" style="color: white;">
                        <div style="font-size: 60px; opacity: 0.3; position: absolute; right: 20px; top: 20px;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="position-relative" style="z-index: 2;">
                            <div style="font-size: 42px; font-weight: bold; margin-bottom: 5px;">
                                {{ number_format($stats['total_reviews']) }}
                            </div>
                            <div style="font-size: 14px; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;">
                                Avis Traités
                            </div>
                            <div style="margin-top: 10px; font-size: 12px; opacity: 0.8;">
                                <i class="fas fa-brain"></i> Par notre IA
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 slide-in" style="animation-delay: 0.3s;">
                <div class="stats-card-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="d-flex align-items-center" style="color: white;">
                        <div style="font-size: 60px; opacity: 0.3; position: absolute; right: 20px; top: 20px;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="position-relative" style="z-index: 2;">
                            <div style="font-size: 42px; font-weight: bold; margin-bottom: 5px;">
                                {{ number_format($stats['avg_positive'] ?? 0, 1) }}
                            </div>
                            <div style="font-size: 14px; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;">
                                Note Moyenne
                            </div>
                            <div style="margin-top: 10px; font-size: 12px; opacity: 0.8;">
                                <i class="fas fa-trophy"></i> Sur 5 étoiles
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 slide-in" style="animation-delay: 0.4s;">
                <div class="stats-card-modern" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <div class="d-flex align-items-center" style="color: white;">
                        <div style="font-size: 60px; opacity: 0.3; position: absolute; right: 20px; top: 20px;">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <div class="position-relative" style="z-index: 2;">
                            <div style="font-size: 42px; font-weight: bold; margin-bottom: 5px;">
                                {{ $stats['recent_updates'] }}
                            </div>
                            <div style="font-size: 14px; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;">
                                Récemment Mis à Jour
                            </div>
                            <div style="margin-top: 10px; font-size: 12px; opacity: 0.8;">
                                <i class="fas fa-clock"></i> Ces 7 derniers jours
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Generate AI Insights Button -->
        @auth
        <div class="row mb-4">
            <div class="col-12">
                <div class="text-center slide-in" style="animation-delay: 0.45s;">
                    <button id="generateInsightsBtn" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 18px 50px; border-radius: 15px; border: none; font-size: 18px; font-weight: 600; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); transition: all 0.3s ease; position: relative; overflow: hidden;">
                        <span class="btn-text">
                            <i class="fas fa-magic"></i> Générer les AI Insights
                        </span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                    <p class="text-muted mt-3 mb-0" style="font-size: 14px;">
                        <i class="fas fa-info-circle"></i> Analyser tous les livres éligibles avec l'IA (minimum 3 avis par livre)
                    </p>
                    <div id="generateMessage" class="alert mt-3 d-none" role="alert"></div>
                </div>
            </div>
        </div>
        @endauth
    </div>
</section>

<!-- Filters Section -->
<section class="space-bottom">
    <div class="container">
        <div class="filter-bar slide-in" style="animation-delay: 0.5s;">
            <form action="{{ route('ai-insights.index') }}" method="GET">
                <div class="row align-items-center g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none;">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="🔍 Rechercher un livre ou un auteur..." value="{{ $search ?? '' }}" style="border-left: none; padding: 12px;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="sentiment" class="form-select" style="padding: 12px; border-radius: 10px;" onchange="this.form.submit()">
                            <option value="">🎯 Tous les sentiments</option>
                            <option value="positive" {{ $sentiment == 'positive' ? 'selected' : '' }}>😊 Positifs uniquement</option>
                            <option value="neutral" {{ $sentiment == 'neutral' ? 'selected' : '' }}>😐 Neutres uniquement</option>
                            <option value="negative" {{ $sentiment == 'negative' ? 'selected' : '' }}>😞 Négatifs uniquement</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select" style="padding: 12px; border-radius: 10px;" onchange="this.form.submit()">
                            <option value="reviews_count" {{ $sortBy == 'reviews_count' ? 'selected' : '' }}>🔥 Plus populaires</option>
                            <option value="title" {{ $sortBy == 'title' ? 'selected' : '' }}>🔤 Par titre (A-Z)</option>
                            <option value="recent_insight" {{ $sortBy == 'recent_insight' ? 'selected' : '' }}>🆕 Récemment analysés</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        @if($search || $sentiment)
                        <a href="{{ route('ai-insights.index') }}" class="btn btn-outline-danger" style="padding: 12px 20px; border-radius: 10px;">
                            <i class="fas fa-times"></i> Réinitialiser
                        </a>
                        @else
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 12px 20px; border-radius: 10px; border: none;">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="text-center mb-4 slide-in" style="animation-delay: 0.6s;">
            <h2 style="font-size: 36px; font-weight: bold; background: linear-gradient(90deg, #667eea, #764ba2, #f093fb); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px;">
                {{ $books->total() }} Livres Disponibles
            </h2>
            <p style="color: #666; font-size: 16px;">Explorez les analyses AI de notre collection complète</p>
        </div>

        <!-- Books Grid -->
        @if($books->count() > 0)
        <div class="row gy-4">
            @foreach($books as $index => $book)
            <div class="col-xl-4 col-md-6 slide-in" style="animation-delay: {{ 0.7 + ($index * 0.1) }}s;">
                <div class="book-card-3d">
                    <!-- Book Cover with Hover Zoom -->
                    <div class="book-cover-wrapper">
                        @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" 
                             alt="{{ $book->title }}"
                             class="book-cover">
                        @else
                        <div class="book-cover book-cover-placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                        @endif
                        
                        <div class="book-overlay">
                            <div class="overlay-content">
                                <i class="fas fa-brain fa-3x mb-3" style="animation: pulseGlow 2s ease-in-out infinite;"></i>
                                <p style="margin: 0; font-size: 16px; font-weight: 600;">Voir l'analyse complète</p>
                            </div>
                        </div>
                        
                        <!-- Sentiment Badge -->
                        @if($book->insight)
                        @php
                            $dominant = $book->insight->getDominantSentiment();
                            // Vérifier que $dominant est bien un array
                            if (!is_array($dominant)) {
                                $dominant = ['sentiment' => 'neutral', 'percentage' => 0];
                            }
                            $sentimentColors = [
                                'positive' => 'linear-gradient(135deg, #11998e, #38ef7d)',
                                'neutral' => 'linear-gradient(135deg, #4facfe, #00f2fe)',
                                'negative' => 'linear-gradient(135deg, #fa709a, #fee140)'
                            ];
                            $sentimentIcons = ['positive' => '😊', 'neutral' => '😐', 'negative' => '😞'];
                            $sentiment = $dominant['sentiment'] ?? 'neutral';
                        @endphp
                        <div class="sentiment-badge" style="background: {{ $sentimentColors[$sentiment] ?? 'linear-gradient(135deg, #667eea, #764ba2)' }};">
                            {{ $sentimentIcons[$sentiment] ?? '🤖' }} {{ ucfirst($sentiment) }}
                        </div>
                        @endif
                    </div>

                    <!-- Book Info -->
                    <div class="book-info">
                        <h3 class="book-title">{{ Str::limit($book->title, 50) }}</h3>
                        <p class="book-author">
                            <i class="fas fa-user-edit" style="color: #667eea;"></i>
                            {{ $book->author }}
                        </p>
                        
                        @if($book->insight)
                        <!-- Résumé AI -->
                        <div class="ai-summary">
                            <div class="summary-header">
                                <i class="fas fa-magic"></i>
                                <span>Résumé AI</span>
                            </div>
                            <p class="summary-text">{{ Str::limit($book->insight->reviews_summary, 120) }}</p>
                        </div>
                        
                        <!-- Stats Row -->
                        <div class="book-stats">
                            <div class="stat-item">
                                <i class="fas fa-star" style="color: #ffd700;"></i>
                                <span>{{ number_format($book->insight->average_rating ?? 0, 1) }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-comments" style="color: #667eea;"></i>
                                <span>{{ $book->insight->total_reviews ?? 0 }} avis</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-chart-line" style="color: #11998e;"></i>
                                <span>{{ round($dominant['percentage'] ?? 0) }}%</span>
                            </div>
                        </div>

                        <!-- View Button -->
                        <a href="{{ route('ai-insights.show', $book->id) }}" class="view-insight-btn">
                            <i class="fas fa-brain"></i> Voir l'Analyse AI
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper" style="margin-top: 60px;">
            {{ $books->links() }}
        </div>
        @else
        <div class="empty-state slide-in" style="animation-delay: 0.7s;">
            <div class="empty-icon">🔍</div>
            <h3>Aucun résultat trouvé</h3>
            <p>Essayez de modifier vos filtres de recherche</p>
            <a href="{{ route('ai-insights.index') }}" class="btn" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 12px 30px; border-radius: 10px; border: none; margin-top: 20px;">
                <i class="fas fa-redo"></i> Réinitialiser les filtres
            </a>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
/* === 3D Book Cards === */
.book-card-3d {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.book-card-3d:hover {
    transform: translateY(-15px) rotateY(3deg);
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
}

.book-cover-wrapper {
    position: relative;
    height: 320px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.book-cover {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.book-cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
}

.book-cover-placeholder i {
    font-size: 80px;
    color: white;
    opacity: 0.5;
}

.book-card-3d:hover .book-cover {
    transform: scale(1.15) rotate(2deg);
}

.book-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.95), rgba(118, 75, 162, 0.95));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.book-card-3d:hover .book-overlay {
    opacity: 1;
}

.overlay-content {
    color: white;
    text-align: center;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.book-card-3d:hover .overlay-content {
    transform: translateY(0);
}

.sentiment-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 10;
    backdrop-filter: blur(10px);
}

.book-info {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.book-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
    line-height: 1.4;
    min-height: 56px;
}

.book-author {
    color: #666;
    font-size: 14px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ai-summary {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    color: #667eea;
    font-weight: 600;
    font-size: 14px;
}

.summary-header i {
    font-size: 16px;
}

.summary-text {
    color: #555;
    font-size: 13px;
    line-height: 1.6;
    margin: 0;
}

.book-stats {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 15px 0;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 20px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.stat-item i {
    font-size: 20px;
}

.view-insight-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 14px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    margin-top: auto;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.view-insight-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.view-insight-btn:hover::before {
    left: 100%;
}

.view-insight-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    color: white;
}

.view-insight-btn i.fa-arrow-right {
    transition: transform 0.3s ease;
}

.view-insight-btn:hover i.fa-arrow-right {
    transform: translateX(5px);
}

/* === Empty State === */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.empty-icon {
    font-size: 80px;
    margin-bottom: 20px;
    animation: floatAnimation 3s ease-in-out infinite;
}

.empty-state h3 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.empty-state p {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

/* === Pagination === */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

.pagination-wrapper .pagination {
    gap: 10px;
}

.pagination-wrapper .page-link {
    border-radius: 10px;
    padding: 10px 16px;
    border: 2px solid #e9ecef;
    color: #667eea;
    font-weight: 600;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-link:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* === Responsive === */
@media (max-width: 768px) {
    .book-card-3d:hover {
        transform: translateY(-10px);
    }
    
    .book-cover-wrapper {
        height: 280px;
    }
    
    .book-title {
        font-size: 18px;
        min-height: auto;
    }
    
    .ai-summary {
        padding: 12px;
    }
    
    .summary-text {
        font-size: 12px;
    }
}

/* === Filter Bar === */
.filter-bar {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    margin-bottom: 40px;
}

.filter-bar .form-control,
.filter-bar .form-select {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.filter-bar .form-control:focus,
.filter-bar .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.filter-bar .input-group-text {
    border: none;
}

/* Generate Button Hover Effect */
#generateInsightsBtn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6) !important;
}

#generateInsightsBtn:active {
    transform: translateY(-1px);
}

#generateInsightsBtn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

#generateInsightsBtn:hover::before {
    left: 100%;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateInsightsBtn');
    const messageDiv = document.getElementById('generateMessage');
    const btnText = generateBtn.querySelector('.btn-text');
    const spinner = generateBtn.querySelector('.spinner-border');
    
    if (generateBtn) {
        generateBtn.addEventListener('click', async function() {
            // Désactiver le bouton
            generateBtn.disabled = true;
            btnText.classList.add('d-none');
            spinner.classList.remove('d-none');
            messageDiv.classList.add('d-none');
            
            try {
                const response = await fetch('{{ route("ai-insights.generate-all") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                // Afficher le message
                messageDiv.classList.remove('d-none');
                messageDiv.textContent = data.message;
                
                if (data.success) {
                    messageDiv.classList.remove('alert-danger');
                    messageDiv.classList.add('alert-success');
                    
                    // Si des insights ont été générés, recharger après 3 secondes
                    if (data.generated > 0) {
                        messageDiv.innerHTML = data.message + '<br><small><i class="fas fa-sync fa-spin"></i> Rechargement de la page dans 3 secondes...</small>';
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    } else {
                        // Réactiver le bouton si aucun insight à générer
                        setTimeout(() => {
                            generateBtn.disabled = false;
                            btnText.classList.remove('d-none');
                            spinner.classList.add('d-none');
                        }, 2000);
                    }
                } else {
                    messageDiv.classList.remove('alert-success');
                    messageDiv.classList.add('alert-danger');
                    
                    // Réactiver le bouton en cas d'erreur
                    generateBtn.disabled = false;
                    btnText.classList.remove('d-none');
                    spinner.classList.add('d-none');
                }
                
            } catch (error) {
                console.error('Erreur:', error);
                messageDiv.classList.remove('d-none', 'alert-success');
                messageDiv.classList.add('alert-danger');
                messageDiv.textContent = '❌ Une erreur est survenue. Veuillez réessayer.';
                
                // Réactiver le bouton
                generateBtn.disabled = false;
                btnText.classList.remove('d-none');
                spinner.classList.add('d-none');
            }
        });
    }
});
</script>
@endpush

@endsection
