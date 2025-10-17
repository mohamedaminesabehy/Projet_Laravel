@extends('layouts.app')

@section('content')
<div class="modern-category-details-page">
    <!-- Enhanced Category Header -->
    <div class="modern-category-header" style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }}22, {{ $category->color ?? '#764ba2' }}44);">
        <!-- Decorative Background Elements -->
        <div class="header-decoration">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="modern-category-info">
                        <div class="modern-category-icon-large">
                            @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                            @else
                            <i class="fas fa-book"></i>
                            @endif
                            <!-- Sparkle effects -->
                            <div class="icon-sparkles">
                                <div class="sparkle sparkle-1"></div>
                                <div class="sparkle sparkle-2"></div>
                                <div class="sparkle sparkle-3"></div>
                            </div>
                        </div>
                        <div class="modern-category-text">
                            <h1 class="modern-category-title">{{ $category->name }}</h1>
                            @if($category->description)
                            <p class="modern-category-description">{{ $category->description }}</p>
                            @endif
                            <div class="modern-category-meta">
                                <div class="meta-stat-card">
                                    <div class="stat-icon-wrapper">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-number">{{ $category->books_count }}</span>
                                        <span class="stat-label">{{ Str::plural('book', $category->books_count) }}</span>
                                    </div>
                                </div>
                                <div class="meta-stat-card">
                                    <div class="stat-icon-wrapper favorites-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-number favorites-count">{{ $category->favorites_count }}</span>
                                        <span class="stat-label">{{ Str::plural('favorite', $category->favorites_count) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @auth
                    <button class="modern-btn-favorite-large {{ $category->is_favorited ? 'is-favorited' : '' }}"
                            data-category-id="{{ $category->id }}"
                            data-favorited="{{ $category->is_favorited ? 'true' : 'false' }}">
                        <div class="btn-icon-container">
                            <i class="modern-heart-icon {{ $category->is_favorited ? 'fas' : 'far' }} fa-heart"></i>
                        </div>
                        <div class="btn-content">
                            <span class="btn-text">{{ $category->is_favorited ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                            <span class="btn-subtitle">{{ $category->is_favorited ? 'Click to unfavorite' : 'Save for later' }}</span>
                        </div>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="modern-btn-favorite-large login-required">
                        <div class="btn-icon-container">
                            <i class="far fa-heart"></i>
                        </div>
                        <div class="btn-content">
                            <span class="btn-text">Login to Favorite</span>
                            <span class="btn-subtitle">Sign in to save categories</span>
                        </div>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Books Section -->
    <div class="modern-category-books-section">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <h2 class="modern-section-title">Books in {{ $category->name }}</h2>
                    <div class="section-subtitle">Discover amazing books in this category</div>
                </div>
                <div class="section-stats">
                    <div class="books-count-badge">
                        <i class="fas fa-book"></i>
                        <span>{{ $category->books->count() }} {{ Str::plural('book', $category->books->count()) }}</span>
                    </div>
                </div>
            </div>
            
            @if($category->books->count() > 0)
            <div class="modern-books-grid">
                @foreach($category->books as $book)
                <div class="modern-book-card" data-book-id="{{ $book->id }}">
                    <div class="book-cover-container">
                        @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="modern-book-cover">
                        @else
                        <div class="modern-book-cover-placeholder">
                            <div class="placeholder-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="placeholder-pattern"></div>
                        </div>
                        @endif
                        <div class="book-overlay">
                            <div class="overlay-content">
                                <button class="quick-view-btn">
                                    <i class="fas fa-eye"></i>
                                    <span>Quick View</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modern-book-info">
                        <h3 class="modern-book-title" title="{{ $book->title }}">{{ Str::limit($book->title, 30) }}</h3>
                        <p class="modern-book-author">by {{ $book->user->name ?? 'Unknown Author' }}</p>
                        @if($book->price)
                        <div class="book-price-container">
                            <span class="modern-book-price">${{ number_format($book->price, 2) }}</span>
                            <span class="price-label">Price</span>
                        </div>
                        @endif
                        <div class="book-actions">
                            <button class="modern-book-btn primary">
                                <i class="fas fa-book-open"></i>
                                <span>Read Now</span>
                            </button>
                            <button class="modern-book-btn secondary">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="modern-empty-state">
                <div class="empty-state-container">
                    <div class="empty-state-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="empty-state-title">No Books Yet</h3>
                    <p class="empty-state-description">
                        This category doesn't have any books yet. Be the first to add a book to this category!
                    </p>
                    <a href="#" class="modern-cta-button">
                        <i class="fas fa-plus"></i>
                        <span>Add First Book</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Modern Category Details Page Styles */
    .modern-category-details-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        position: relative;
    }

    /* Enhanced Category Header */
    .modern-category-header {
        padding: 100px 0;
        position: relative;
        overflow: hidden;
        background-attachment: fixed;
    }

    .modern-category-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="modernGrain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.15)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.08)"/></pattern></defs><rect width="100" height="100" fill="url(%23modernGrain)"/></svg>');
        opacity: 0.4;
    }

    /* Decorative Background Elements */
    .header-decoration {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
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
        width: 120px;
        height: 120px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .element-3 {
        width: 60px;
        height: 60px;
        top: 40%;
        right: 40%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* Modern Category Info */
    .modern-category-info {
        display: flex;
        align-items: center;
        gap: 40px;
        position: relative;
        z-index: 2;
    }

    .modern-category-icon-large {
        width: 140px;
        height: 140px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
        color: #fff;
        backdrop-filter: blur(15px);
        border: 3px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        position: relative;
        animation: iconPulse 3s ease-in-out infinite;
    }

    @keyframes iconPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15); }
        50% { transform: scale(1.05); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2); }
    }

    /* Icon Sparkles */
    .icon-sparkles {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }

    .sparkle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        animation: sparkle 2s ease-in-out infinite;
    }

    .sparkle-1 {
        top: 20%;
        right: 25%;
        animation-delay: 0s;
    }

    .sparkle-2 {
        bottom: 30%;
        left: 20%;
        animation-delay: 0.7s;
    }

    .sparkle-3 {
        top: 60%;
        right: 15%;
        animation-delay: 1.4s;
    }

    @keyframes sparkle {
        0%, 100% { opacity: 0; transform: scale(0); }
        50% { opacity: 1; transform: scale(1); }
    }

    /* Modern Category Text */
    .modern-category-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 20px;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        line-height: 1.2;
        animation: slideInUp 0.8s ease-out;
    }

    .modern-category-description {
        font-size: 1.3rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 30px;
        line-height: 1.7;
        animation: slideInUp 0.8s ease-out 0.2s both;
    }

    /* Modern Category Meta */
    .modern-category-meta {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
        animation: slideInUp 0.8s ease-out 0.4s both;
    }

    .meta-stat-card {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }

    .meta-stat-card:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .stat-icon-wrapper {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
    }

    .favorites-icon {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    }

    .stat-content {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .stat-number {
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: capitalize;
    }

    /* Modern Favorite Button */
    .modern-btn-favorite-large {
        background: rgba(255, 255, 255, 0.25);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: #fff;
        padding: 0;
        border-radius: 20px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        backdrop-filter: blur(15px);
        transition: all 0.4s ease;
        cursor: pointer;
        overflow: hidden;
        position: relative;
        min-width: 280px;
        animation: slideInRight 0.8s ease-out 0.6s both;
    }

    .modern-btn-favorite-large::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .modern-btn-favorite-large:hover::before {
        left: 100%;
    }

    .modern-btn-favorite-large:hover {
        background: rgba(255, 255, 255, 0.35);
        border-color: rgba(255, 255, 255, 0.6);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        color: #fff;
    }

    .modern-btn-favorite-large.is-favorited {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border-color: #ff6b6b;
    }

    .modern-btn-favorite-large.is-favorited:hover {
        background: linear-gradient(135deg, #ff5252, #e53935);
        box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
    }

    .btn-icon-container {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-heart-icon {
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .modern-btn-favorite-large.is-favorited .modern-heart-icon {
        animation: heartBeat 1.5s ease-in-out infinite;
        color: #fff;
    }

    .btn-content {
        padding: 20px 25px 20px 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .btn-text {
        font-size: 1.1rem;
        font-weight: 600;
        line-height: 1;
    }

    .btn-subtitle {
        font-size: 0.85rem;
        opacity: 0.8;
        line-height: 1;
    }

    .login-required {
        opacity: 0.9;
    }

    .login-required:hover {
        opacity: 1;
    }

    /* Enhanced Books Section */
    .modern-category-books-section {
        background: #fff;
        padding: 80px 0;
        position: relative;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 50px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .section-title-wrapper {
        flex: 1;
    }

    .modern-section-title {
        font-size: 3rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 10px;
        position: relative;
        animation: fadeInUp 0.8s ease-out;
    }

    .modern-section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 100px;
        height: 5px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 3px;
    }

    .section-subtitle {
        font-size: 1.2rem;
        color: #64748b;
        font-weight: 500;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .section-stats {
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .books-count-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        padding: 12px 20px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Modern Books Grid */
    .modern-books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 35px;
        margin-top: 50px;
    }

    .modern-book-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        border: 1px solid rgba(0, 0, 0, 0.04);
        position: relative;
        animation: fadeInUp 0.6s ease-out;
    }

    .modern-book-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    /* Book Cover Container */
    .book-cover-container {
        position: relative;
        overflow: hidden;
        height: 350px;
    }

    .modern-book-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .modern-book-card:hover .modern-book-cover {
        transform: scale(1.08);
    }

    .modern-book-cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 4rem;
        position: relative;
    }

    .placeholder-icon {
        z-index: 2;
        position: relative;
    }

    .placeholder-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="bookPattern" width="20" height="20" patternUnits="userSpaceOnUse"><rect width="20" height="20" fill="none"/><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23bookPattern)"/></svg>');
        opacity: 0.3;
    }

    /* Book Overlay */
    .book-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modern-book-card:hover .book-overlay {
        opacity: 1;
    }

    .overlay-content {
        text-align: center;
    }

    .quick-view-btn {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        padding: 12px 24px;
        border-radius: 25px;
        color: #1a202c;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .quick-view-btn:hover {
        background: #fff;
        transform: translateY(-2px);
    }

    /* Modern Book Info */
    .modern-book-info {
        padding: 30px;
    }

    .modern-book-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 12px;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .modern-book-card:hover .modern-book-title {
        color: #667eea;
    }

    .modern-book-author {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 20px;
        font-style: italic;
        font-weight: 500;
    }

    .book-price-container {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 25px;
    }

    .modern-book-price {
        font-size: 1.6rem;
        font-weight: 800;
        color: #10b981;
    }

    .price-label {
        font-size: 0.9rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Book Actions */
    .book-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .modern-book-btn {
        border: none;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .modern-book-btn.primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        padding: 12px 20px;
        flex: 1;
    }

    .modern-book-btn.primary:hover {
        background: linear-gradient(135deg, #5a67d8, #6b46c1);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .modern-book-btn.secondary {
        background: #f1f5f9;
        color: #64748b;
        padding: 12px;
        width: 48px;
        height: 48px;
        justify-content: center;
    }

    .modern-book-btn.secondary:hover {
        background: #e2e8f0;
        color: #475569;
        transform: translateY(-2px);
    }

    /* Modern Empty State */
    .modern-empty-state {
        text-align: center;
        padding: 80px 20px;
        animation: fadeInUp 0.8s ease-out;
    }

    .empty-state-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 48px;
        color: #64748b;
        animation: float 3s ease-in-out infinite;
    }

    .empty-state-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 15px;
    }

    .empty-state-description {
        font-size: 1.1rem;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .modern-cta-button {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        padding: 16px 32px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .modern-cta-button:hover {
        background: linear-gradient(135deg, #5a67d8, #6b46c1);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        color: #fff;
    }

    /* Animations */
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

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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

    @keyframes heartBeat {
        0% { transform: scale(1); }
        14% { transform: scale(1.3); }
        28% { transform: scale(1); }
        42% { transform: scale(1.3); }
        70% { transform: scale(1); }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .modern-books-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
    }

    @media (max-width: 768px) {
        .modern-category-header {
            padding: 80px 0;
        }

        .modern-category-info {
            flex-direction: column;
            text-align: center;
            gap: 30px;
        }

        .modern-category-icon-large {
            width: 120px;
            height: 120px;
            font-size: 48px;
        }

        .modern-category-title {
            font-size: 2.5rem;
        }

        .modern-category-description {
            font-size: 1.1rem;
        }

        .modern-category-meta {
            justify-content: center;
            gap: 15px;
        }

        .modern-btn-favorite-large {
            min-width: 250px;
        }

        .modern-section-title {
            font-size: 2.2rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .modern-books-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .book-cover-container {
            height: 300px;
        }
    }

    @media (max-width: 480px) {
        .modern-category-header {
            padding: 60px 0;
        }

        .modern-category-title {
            font-size: 2rem;
        }

        .modern-section-title {
            font-size: 1.8rem;
        }

        .modern-books-grid {
            grid-template-columns: 1fr;
        }

        .modern-btn-favorite-large {
            min-width: 220px;
        }

        .btn-content {
            padding: 15px 20px 15px 0;
        }

        .btn-icon-container {
            padding: 15px;
        }
    }
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modern favorite button functionality
    const favoriteBtn = document.querySelector('.modern-btn-favorite-large');
    
    if (favoriteBtn && favoriteBtn.hasAttribute('data-category-id')) {
        favoriteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const categoryId = this.getAttribute('data-category-id');
            const isFavorited = this.getAttribute('data-favorited') === 'true';
            const heartIcon = this.querySelector('.modern-heart-icon');
            const btnText = this.querySelector('.btn-text');
            const btnSubtitle = this.querySelector('.btn-subtitle');
            const favoritesCountElement = document.querySelector('.favorites-count');
            
            // Add loading state
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
            
            // Create loading animation
            const originalIcon = heartIcon.className;
            heartIcon.className = 'fas fa-spinner fa-spin';
            
            // AJAX request to toggle favorite
             fetch(`/favorites/toggle/${categoryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button state with smooth animation
                    setTimeout(() => {
                        if (data.is_favorited) {
                            // Add to favorites
                            this.classList.add('is-favorited');
                            this.setAttribute('data-favorited', 'true');
                            heartIcon.className = 'modern-heart-icon fas fa-heart';
                            btnText.textContent = 'Remove from Favorites';
                            btnSubtitle.textContent = 'Click to unfavorite';
                            
                            // Trigger heart beat animation
                            heartIcon.style.animation = 'none';
                            setTimeout(() => {
                                heartIcon.style.animation = 'heartBeat 1.5s ease-in-out infinite';
                            }, 10);
                        } else {
                            // Remove from favorites
                            this.classList.remove('is-favorited');
                            this.setAttribute('data-favorited', 'false');
                            heartIcon.className = 'modern-heart-icon far fa-heart';
                            btnText.textContent = 'Add to Favorites';
                            btnSubtitle.textContent = 'Save for later';
                            heartIcon.style.animation = 'none';
                        }
                        
                        // Update favorites count with animation
                        if (favoritesCountElement) {
                            const currentCount = parseInt(favoritesCountElement.textContent);
                            const newCount = data.is_favorited ? currentCount + 1 : currentCount - 1;
                            
                            // Animate count change
                            favoritesCountElement.style.transform = 'scale(1.2)';
                            favoritesCountElement.style.transition = 'transform 0.2s ease';
                            
                            setTimeout(() => {
                                favoritesCountElement.textContent = newCount;
                                favoritesCountElement.style.transform = 'scale(1)';
                            }, 100);
                        }
                        
                        // Show success notification
                        showNotification(
                            data.is_favorited ? 'Added to favorites!' : 'Removed from favorites!',
                            'success'
                        );
                        
                        // Remove loading state
                        this.style.opacity = '1';
                        this.style.pointerEvents = 'auto';
                        
                    }, 300);
                } else {
                    throw new Error(data.message || 'Failed to update favorite status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Restore original state
                heartIcon.className = originalIcon;
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
                
                // Show error notification
                showNotification('Failed to update favorite status. Please try again.', 'error');
            });
        });
    }
    
    // Enhanced book card interactions
    const bookCards = document.querySelectorAll('.modern-book-card');
    bookCards.forEach(card => {
        // Add stagger animation on load
        const index = Array.from(bookCards).indexOf(card);
        card.style.animationDelay = `${index * 0.1}s`;
        
        // Enhanced hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Quick view functionality
    const quickViewBtns = document.querySelectorAll('.quick-view-btn');
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const bookCard = this.closest('.modern-book-card');
            const bookId = bookCard.getAttribute('data-book-id');
            
            // Add loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Loading...</span>';
            
            // Simulate quick view (replace with actual implementation)
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-eye"></i><span>Quick View</span>';
                showNotification('Quick view feature coming soon!', 'info');
            }, 1000);
        });
    });
    
    // Book action buttons
    const bookBtns = document.querySelectorAll('.modern-book-btn');
    bookBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (this.classList.contains('primary')) {
                // Read Now functionality
                const bookCard = this.closest('.modern-book-card');
                const bookTitle = bookCard.querySelector('.modern-book-title').textContent;
                
                // Add loading animation
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Opening...</span>';
                this.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.pointerEvents = 'auto';
                    showNotification(`Opening "${bookTitle}"...`, 'info');
                }, 1500);
                
            } else if (this.classList.contains('secondary')) {
                // Bookmark functionality
                const isBookmarked = this.classList.contains('bookmarked');
                
                if (isBookmarked) {
                    this.classList.remove('bookmarked');
                    this.innerHTML = '<i class="fas fa-bookmark"></i>';
                    this.style.background = '#f1f5f9';
                    this.style.color = '#64748b';
                    showNotification('Bookmark removed!', 'success');
                } else {
                    this.classList.add('bookmarked');
                    this.innerHTML = '<i class="fas fa-bookmark"></i>';
                    this.style.background = '#fbbf24';
                    this.style.color = '#fff';
                    showNotification('Bookmarked!', 'success');
                }
            }
        });
    });
    
    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.modern-notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `modern-notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="notification-icon ${getNotificationIcon(type)}"></i>
                <span class="notification-message">${message}</span>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add notification styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${getNotificationColor(type)};
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            animation: slideInRight 0.3s ease-out;
            backdrop-filter: blur(10px);
        `;
        
        // Add to document
        document.body.appendChild(notification);
        
        // Close button functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        });
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }
        }, 4000);
    }
    
    function getNotificationIcon(type) {
        switch (type) {
            case 'success': return 'fas fa-check-circle';
            case 'error': return 'fas fa-exclamation-circle';
            case 'warning': return 'fas fa-exclamation-triangle';
            default: return 'fas fa-info-circle';
        }
    }
    
    function getNotificationColor(type) {
        switch (type) {
            case 'success': return 'linear-gradient(135deg, #10b981, #059669)';
            case 'error': return 'linear-gradient(135deg, #ef4444, #dc2626)';
            case 'warning': return 'linear-gradient(135deg, #f59e0b, #d97706)';
            default: return 'linear-gradient(135deg, #3b82f6, #2563eb)';
        }
    }
    
    // Add notification animations to document
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100%);
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
                    transform: translateX(100%);
                }
            }
            
            .notification-content {
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 1;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: rgba(255, 255, 255, 0.8);
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                transition: all 0.2s ease;
            }
            
            .notification-close:hover {
                background: rgba(255, 255, 255, 0.2);
                color: white;
            }
        `;
        document.head.appendChild(style);
    }
});
</script>
@endpush
