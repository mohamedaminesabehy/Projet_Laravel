@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/favorite-categories.css') }}">
@endpush

@section('content')
<!-- Modern Favorites Page Container -->
<div class="modern-favorites-page">
    <!-- Enhanced Hero Header with Gradient Background -->
    <div class="favorites-hero-section">
        <div class="container">
            <!-- Centered Hero Content with Modern Typography -->
            <div class="hero-content-wrapper">
                <div class="hero-icon-container">
                    <i class="fas fa-heart hero-heart-icon"></i>
                </div>
                <h1 class="modern-page-title">
                    My Favorite Categories
                </h1>
                <p class="modern-page-subtitle">
                    Discover and manage the categories that inspire you most
                </p>
            </div>
        </div>
    </div>

    <!-- Modern Statistics Dashboard -->
    <div class="stats-dashboard-section">
        <div class="container">
            <!-- Responsive Stats Grid with Enhanced Cards -->
            <div class="stats-grid-container">
                <div class="modern-stat-card favorites-stat">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-heart stat-icon"></i>
                    </div>
                    <div class="stat-content-area">
                        <h3 class="stat-number">{{ $stats['total_favorites'] }}</h3>
                        <p class="stat-description">Total Favorites</p>
                    </div>
                    <div class="stat-accent-line"></div>
                </div>
                
                <div class="modern-stat-card categories-stat">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-check-circle stat-icon"></i>
                    </div>
                    <div class="stat-content-area">
                        <h3 class="stat-number">{{ $stats['active_categories'] }}</h3>
                        <p class="stat-description">Active Categories</p>
                    </div>
                    <div class="stat-accent-line"></div>
                </div>
                
                <div class="modern-stat-card books-stat">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-book stat-icon"></i>
                    </div>
                    <div class="stat-content-area">
                        <h3 class="stat-number">{{ $stats['total_books'] }}</h3>
                        <p class="stat-description">Books Available</p>
                    </div>
                    <div class="stat-accent-line"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Favorites Content Section -->
    <div class="favorites-content-section">
        <div class="container">
            <!-- Success/Error Messages with Modern Styling -->
            @if(session('success'))
            <div class="modern-alert success-alert">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <span class="alert-message">{{ session('success') }}</span>
                </div>
                <button type="button" class="alert-close-btn" data-bs-dismiss="alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if($favoriteCategories->count() > 0)
            <!-- Modern Favorites Grid Layout -->
            <div class="modern-favorites-grid">
                @foreach($favoriteCategories as $category)
                <div class="modern-favorite-card">
                    <!-- Enhanced Card Header with Gradient and Icons -->
                    <div class="modern-card-header" style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }}15, {{ $category->color ?? '#764ba2' }}25);">
                        <div class="category-icon-modern">
                            <i class="{{ $category->icon ?? 'fas fa-book' }}"></i>
                        </div>
                        <button class="modern-remove-btn" 
                                data-category-id="{{ $category->id }}"
                                title="Remove from favorites"
                                aria-label="Remove {{ $category->name }} from favorites">
                            <i class="fas fa-heart-broken"></i>
                        </button>
                    </div>

                    <!-- Enhanced Card Body with Better Typography -->
                    <div class="modern-card-body">
                        <h3 class="modern-category-title">{{ $category->name }}</h3>
                        
                        @if($category->description)
                        <p class="modern-category-description">{{ Str::limit($category->description, 100) }}</p>
                        @endif

                        <!-- Modern Info Grid -->
                        <div class="modern-category-info">
                            <div class="modern-info-item">
                                <div class="info-icon-wrapper">
                                    <i class="fas fa-book"></i>
                                </div>
                                <span class="info-text">{{ $category->books_count }} books</span>
                            </div>
                            <div class="modern-info-item">
                                <div class="info-icon-wrapper">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <span class="info-text">Added {{ $category->pivot->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Modern Explore Button -->
                        <a href="{{ route('categories.show', $category) }}" class="modern-explore-btn">
                            <span class="btn-text">Explore Books</span>
                            <div class="btn-icon">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Modern Pagination Wrapper -->
            <div class="modern-pagination-wrapper">
                {{ $favoriteCategories->links() }}
            </div>
            @else
            <!-- Enhanced Empty State Design -->
            <div class="modern-empty-state">
                <div class="empty-state-container">
                    <div class="empty-state-icon">
                        <i class="far fa-heart"></i>
                    </div>
                    <h3 class="empty-state-title">No Favorite Categories Yet</h3>
                    <p class="empty-state-description">
                        Start your journey by exploring our diverse collection of categories and discover what inspires you most.
                    </p>
                    <a href="{{ route('categories.index') }}" class="modern-cta-button">
                        <div class="cta-icon">
                            <i class="fas fa-compass"></i>
                        </div>
                        <span class="cta-text">Explore Categories</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modern CSS Styles with Professional Design -->
<style>
/* ===============================================
   MODERN FAVORITES PAGE STYLES
   Enhanced design with professional aesthetics
   =============================================== */

/* Main Page Container */
.modern-favorites-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Enhanced Hero Section */
.favorites-hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 5rem 0 4rem;
    position: relative;
    overflow: hidden;
}

.favorites-hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content-wrapper {
    text-align: center;
    position: relative;
    z-index: 2;
}

.hero-icon-container {
    margin-bottom: 1.5rem;
    animation: heartPulse 2s ease-in-out infinite;
}

.hero-heart-icon {
    font-size: 4rem;
    color: #ff6b6b;
    filter: drop-shadow(0 4px 20px rgba(255, 107, 107, 0.4));
}

.modern-page-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    animation: fadeInUp 0.8s ease-out;
}

.modern-page-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 400;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

/* Modern Statistics Dashboard */
.stats-dashboard-section {
    padding: 3rem 0;
    background: white;
    box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.05);
}

.stats-grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.modern-stat-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.modern-stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modern-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.modern-stat-card:hover::before {
    transform: scaleX(1);
}

.stat-icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    position: relative;
}

.favorites-stat .stat-icon-wrapper {
    background: linear-gradient(135deg, #ff6b6b20, #ff6b6b30);
}

.categories-stat .stat-icon-wrapper {
    background: linear-gradient(135deg, #48bb7820, #48bb7830);
}

.books-stat .stat-icon-wrapper {
    background: linear-gradient(135deg, #667eea20, #667eea30);
}

.stat-icon {
    font-size: 2rem;
    color: #667eea;
}

.favorites-stat .stat-icon {
    color: #ff6b6b;
}

.categories-stat .stat-icon {
    color: #48bb78;
}

.stat-content-area {
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d3748;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-description {
    font-size: 1rem;
    color: #718096;
    font-weight: 500;
    margin: 0;
}

.stat-accent-line {
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
    opacity: 0.3;
    transition: opacity 0.3s ease;
}

.modern-stat-card:hover .stat-accent-line {
    opacity: 1;
}

/* Modern Favorites Content Section */
.favorites-content-section {
    padding: 4rem 0;
}

/* Modern Alert Styling */
.modern-alert {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    animation: slideInDown 0.5s ease-out;
}

.success-alert {
    background: linear-gradient(135deg, #48bb7815, #48bb7825);
    border-left: 4px solid #48bb78;
}

.alert-icon {
    font-size: 1.5rem;
    color: #48bb78;
}

.alert-content {
    flex: 1;
}

.alert-message {
    font-weight: 600;
    color: #2d3748;
}

.alert-close-btn {
    background: none;
    border: none;
    color: #718096;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.alert-close-btn:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #2d3748;
}

/* Modern Favorites Grid */
.modern-favorites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.modern-favorite-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.modern-favorite-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.modern-card-header {
    padding: 2.5rem 2rem;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.category-icon-modern {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #667eea;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
}

.modern-remove-btn {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

.modern-remove-btn:hover {
    background: #fee;
    transform: scale(1.1);
    box-shadow: 0 6px 25px rgba(255, 107, 107, 0.3);
}

.modern-remove-btn i {
    font-size: 1.2rem;
    color: #ff6b6b;
}

.modern-card-body {
    padding: 2rem;
}

.modern-category-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.modern-category-description {
    color: #718096;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.modern-category-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.modern-info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-icon-wrapper {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.info-icon-wrapper i {
    font-size: 1.1rem;
    color: #667eea;
}

.info-text {
    font-size: 0.95rem;
    color: #4a5568;
    font-weight: 500;
}

.modern-explore-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.modern-explore-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.modern-explore-btn:hover::before {
    left: 100%;
}

.modern-explore-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-icon {
    transition: transform 0.3s ease;
}

.modern-explore-btn:hover .btn-icon {
    transform: translateX(5px);
}

/* Modern Pagination */
.modern-pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

/* Enhanced Empty State */
.modern-empty-state {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    padding: 3rem 0;
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
    font-size: 2rem;
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

.cta-icon {
    font-size: 1.3rem;
}

/* Animations */
@keyframes heartPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
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
    50% { transform: translateY(-10px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .modern-page-title {
        font-size: 2.5rem;
    }
    
    .modern-page-subtitle {
        font-size: 1.1rem;
    }
    
    .stats-grid-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .modern-favorites-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .modern-favorite-card {
        margin: 0 1rem;
    }
    
    .modern-category-info {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    .favorites-hero-section {
        padding: 3rem 0 2rem;
    }
    
    .modern-page-title {
        font-size: 2rem;
    }
    
    .hero-heart-icon {
        font-size: 3rem;
    }
    
    .modern-stat-card {
        padding: 1.5rem;
    }
    
    .modern-card-body {
        padding: 1.5rem;
    }
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const removeButtons = document.querySelectorAll('.modern-remove-btn');

    removeButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to remove this category from your favorites?')) {
                return;
            }

            const categoryId = this.getAttribute('data-category-id');
            const card = this.closest('.modern-favorite-card');

            try {
                const response = await fetch(`/favorites/toggle/${categoryId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Enhanced removal animation
                    card.style.animation = 'fadeOutScale 0.4s ease-in-out';
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if grid is empty and reload if necessary
                        const grid = document.querySelector('.modern-favorites-grid');
                        if (grid && grid.children.length === 0) {
                            location.reload();
                        }
                    }, 400);
                }
            } catch (error) {
                console.error('Error removing favorite:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

// Enhanced fade out animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOutScale {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        to {
            opacity: 0;
            transform: scale(0.8) translateY(-20px);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
