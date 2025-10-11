@extends('layouts.app')

@section('content')
<div class="user-favorites-page">
    <!-- Header -->
    <div class="favorites-header">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="page-title">
                    <i class="fas fa-heart"></i>
                    My Favorite Categories
                </h1>
                <p class="page-subtitle">Categories you love the most</p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="favorites-stats py-4 bg-light">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['total_favorites'] }}</h3>
                            <p class="stat-label">Total Favorites</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['active_categories'] }}</h3>
                            <p class="stat-label">Active Categories</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">{{ $stats['total_books'] }}</h3>
                            <p class="stat-label">Books Available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorites List -->
    <div class="favorites-section py-5">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($favoriteCategories->count() > 0)
            <div class="favorites-grid">
                @foreach($favoriteCategories as $category)
                <div class="favorite-card">
                    <div class="card-header" style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }}22, {{ $category->color ?? '#764ba2' }}44);">
                        <div class="category-icon">
                            <i class="{{ $category->icon ?? 'fas fa-book' }}"></i>
                        </div>
                        <button class="btn-remove-favorite" 
                                data-category-id="{{ $category->id }}"
                                title="Remove from favorites">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <h3 class="category-name">{{ $category->name }}</h3>
                        
                        @if($category->description)
                        <p class="category-description">{{ Str::limit($category->description, 100) }}</p>
                        @endif

                        <div class="category-info">
                            <div class="info-item">
                                <i class="fas fa-book"></i>
                                <span>{{ $category->books_count }} books</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <span>Added {{ $category->pivot->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <a href="{{ route('categories.show', $category) }}" class="btn-explore">
                            Explore Books <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper mt-5">
                {{ $favoriteCategories->links() }}
            </div>
            @else
            <div class="empty-state text-center py-5">
                <div class="empty-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h3 class="empty-title">No Favorite Categories Yet</h3>
                <p class="empty-text">Start exploring and add your favorite categories!</p>
                <a href="{{ route('categories.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-compass me-2"></i>Explore Categories
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.user-favorites-page {
    min-height: 100vh;
    background: #f8f9fa;
}

.favorites-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 4rem 0 3rem;
    color: white;
}

.page-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    animation: fadeInDown 0.6s ease;
}

.page-title i {
    color: #ff6b6b;
}

.page-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    animation: fadeInUp 0.6s ease;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.stat-label {
    color: #718096;
    margin: 0;
    font-size: 0.9rem;
}

.favorites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.favorite-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease;
}

.favorite-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.favorite-card .card-header {
    padding: 2rem;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-icon {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-remove-favorite {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 35px;
    height: 35px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-remove-favorite:hover {
    background: #ff6b6b;
    color: white;
    transform: scale(1.1);
}

.favorite-card .card-body {
    padding: 1.5rem;
}

.category-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.75rem;
}

.category-description {
    color: #718096;
    font-size: 0.95rem;
    margin-bottom: 1rem;
    line-height: 1.6;
}

.category-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1rem 0;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.9rem;
}

.info-item i {
    color: #667eea;
    width: 20px;
}

.btn-explore {
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

.btn-explore:hover {
    transform: translateX(3px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.empty-state {
    background: white;
    border-radius: 16px;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 5rem;
    color: #e2e8f0;
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: #718096;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

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

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .favorites-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const removeButtons = document.querySelectorAll('.btn-remove-favorite');

    removeButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to remove this category from your favorites?')) {
                return;
            }

            const categoryId = this.getAttribute('data-category-id');
            const card = this.closest('.favorite-card');

            try {
                const response = await fetch(`/category-favorites/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Animate removal
                    card.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if grid is empty
                        const grid = document.querySelector('.favorites-grid');
                        if (grid && grid.children.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            } catch (error) {
                console.error('Error removing favorite:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

// Add fadeOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.8);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
