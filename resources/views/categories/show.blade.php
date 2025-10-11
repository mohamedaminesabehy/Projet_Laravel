@extends('layouts.app')

@section('content')
<div class="category-details-page">
    <!-- Category Header -->
    <div class="category-header" style="background: linear-gradient(135deg, {{ $category->color ?? '#667eea' }}22, {{ $category->color ?? '#764ba2' }}44);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="category-info">
                        <div class="category-icon-large">
                            @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                            @else
                            <i class="fas fa-book"></i>
                            @endif
                        </div>
                        <div class="category-text">
                            <h1 class="category-title">{{ $category->name }}</h1>
                            @if($category->description)
                            <p class="category-description">{{ $category->description }}</p>
                            @endif
                            <div class="category-meta">
                                <span class="meta-item">
                                    <i class="fas fa-book"></i>
                                    {{ $category->books_count }} {{ Str::plural('book', $category->books_count) }}
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-heart"></i>
                                    <span class="favorites-count">{{ $category->favorites_count }}</span> {{ Str::plural('favorite', $category->favorites_count) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @auth
                    <button class="btn-favorite-large {{ $category->is_favorited ? 'is-favorited' : '' }}"
                            data-category-id="{{ $category->id }}"
                            data-favorited="{{ $category->is_favorited ? 'true' : 'false' }}">
                        <i class="heart-icon {{ $category->is_favorited ? 'fas' : 'far' }} fa-heart"></i>
                        <span class="btn-text">{{ $category->is_favorited ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn-favorite-large">
                        <i class="far fa-heart"></i>
                        <span class="btn-text">Login to Favorite</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Books Section -->
    <div class="category-books-section py-5">
        <div class="container">
            <h2 class="section-title">Books in {{ $category->name }}</h2>
            
            @if($category->books->count() > 0)
            <div class="books-grid">
                @foreach($category->books as $book)
                <div class="book-card">
                    @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="book-cover">
                    @else
                    <div class="book-cover-placeholder">
                        <i class="fas fa-book"></i>
                    </div>
                    @endif
                    <div class="book-info">
                        <h3 class="book-title">{{ Str::limit($book->title, 30) }}</h3>
                        <p class="book-author">by {{ $book->user->name ?? 'Unknown' }}</p>
                        @if($book->price)
                        <p class="book-price">${{ number_format($book->price, 2) }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                No books available in this category yet.
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.category-details-page {
    min-height: 100vh;
    background: #f8f9fa;
}

.category-header {
    padding: 4rem 0;
    margin-bottom: 3rem;
}

.category-info {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.category-icon-large {
    width: 100px;
    height: 100px;
    background: white;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.category-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

.category-description {
    color: #4a5568;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.category-meta {
    display: flex;
    gap: 2rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #718096;
    font-size: 1rem;
}

.meta-item i {
    color: #667eea;
}

.btn-favorite-large {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    border: 2px solid #e2e8f0;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #2d3748;
}

.btn-favorite-large:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.btn-favorite-large .heart-icon {
    font-size: 1.5rem;
    color: #ddd;
    transition: all 0.3s ease;
}

.btn-favorite-large.is-favorited {
    background: #fff5f5;
    border-color: #ff6b6b;
}

.btn-favorite-large.is-favorited .heart-icon {
    color: #ff6b6b;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: #2d3748;
}

.books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 2rem;
}

.book-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
}

.book-cover {
    width: 100%;
    height: 280px;
    object-fit: cover;
}

.book-cover-placeholder {
    width: 100%;
    height: 280px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: white;
}

.book-info {
    padding: 1rem;
}

.book-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

.book-author {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.book-price {
    color: #667eea;
    font-weight: 700;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .category-info {
        flex-direction: column;
        text-align: center;
    }
    
    .category-title {
        font-size: 1.8rem;
    }
    
    .books-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }
}
</style>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const favoriteButton = document.querySelector('.btn-favorite-large[data-category-id]');

    if (favoriteButton) {
        favoriteButton.addEventListener('click', async function(e) {
            e.preventDefault();

            const categoryId = this.getAttribute('data-category-id');
            const isFavorited = this.getAttribute('data-favorited') === 'true';

            try {
                const response = await fetch(`/category-favorites/toggle/${categoryId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const heartIcon = this.querySelector('.heart-icon');
                    const btnText = this.querySelector('.btn-text');
                    
                    if (data.favorited) {
                        this.classList.add('is-favorited');
                        this.setAttribute('data-favorited', 'true');
                        heartIcon.classList.remove('far');
                        heartIcon.classList.add('fas');
                        btnText.textContent = 'Remove from Favorites';
                    } else {
                        this.classList.remove('is-favorited');
                        this.setAttribute('data-favorited', 'false');
                        heartIcon.classList.remove('fas');
                        heartIcon.classList.add('far');
                        btnText.textContent = 'Add to Favorites';
                    }

                    // Update count
                    const favoritesCountElement = document.querySelector('.favorites-count');
                    if (favoritesCountElement) {
                        favoritesCountElement.textContent = data.favorites_count;
                    }
                }
            } catch (error) {
                console.error('Error toggling favorite:', error);
            }
        });
    }
});
</script>
@endpush
