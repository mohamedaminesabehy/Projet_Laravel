<!-- Reviews for book: {{ $book->title }} -->
<div class="book-reviews-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark">
            <i class="fas fa-comments me-2 text-primary"></i>
            Reviews for this book ({{ $book->total_reviews }})
        </h3>
        
        @auth
            @if(!$book->reviews->where('user_id', Auth::id())->count())
                <a href="{{ route('reviews.create', ['book_id' => $book->id]) }}" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-plus me-2"></i>Laisser un avis
                </a>
            @else
                <a href="{{ route('reviews.show', $book->reviews->where('user_id', Auth::id())->first()) }}" 
                   class="btn btn-outline-success">
                    <i class="fas fa-eye me-2"></i>Voir mon avis
                </a>
            @endif
        @else
            <a href="{{ route('reviews.create', ['book_id' => $book->id]) }}" 
               class="btn btn-outline-primary">
                <i class="fas fa-plus me-2"></i>Laisser un avis
            </a>
        @endauth
    </div>

    @if($book->total_reviews > 0)
        <!-- Résumé des notes -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 bg-light text-center p-3">
                    <div class="h2 text-warning mb-2">
                        {{ number_format($book->average_rating, 1) }}/5
                    </div>
                    <div class="star-rating text-warning fs-4 mb-2">
                        {!! $book->star_rating !!}
                    </div>
                    <div class="text-muted">
                        Basé sur {{ $book->total_reviews }} avis
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="rating-distribution">
                    @for($star = 5; $star >= 1; $star--)
                        @php
                            $count = $book->approvedReviews->where('rating', $star)->count();
                            $percentage = $book->total_reviews > 0 ? ($count / $book->total_reviews) * 100 : 0;
                        @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2" style="width: 80px;">
                                <span class="text-warning">{{ $star }}</span>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <div class="flex-grow-1 me-2">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-warning" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <div style="width: 50px;" class="text-end text-muted">
                                {{ $count }}
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @endif

    <!-- Liste des avis -->
    @if($reviews->count() > 0)
        <div class="reviews-list">
            @foreach($reviews as $review)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 45px; height: 45px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-dark">{{ $review->user->name }}</h6>
                                    <div class="star-rating text-warning mb-1">
                                        {!! $review->star_rating !!}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $review->formatted_date }}
                                    </div>
                                </div>
                            </div>
                            
                            @auth
                                @if(Auth::id() === $review->user_id)
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" 
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('reviews.show', $review) }}">
                                                    <i class="fas fa-eye me-2"></i>Voir en détail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('reviews.edit', $review) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        
                        <div class="review-comment">
                            <p class="text-dark mb-0">{{ $review->comment }}</p>
                        </div>
                        
                        @if(strlen($review->comment) > 200)
                            <div class="mt-2">
                                <a href="{{ route('reviews.show', $review) }}" class="btn btn-sm btn-outline-primary">
                                    Lire l'avis complet
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-comment-slash fa-4x text-muted"></i>
            </div>
            <h5 class="text-muted">No reviews for this book</h5>
            <p class="text-muted mb-4">Soyez le premier à partager votre opinion !</p>
            
            @auth
                <a href="{{ route('reviews.create', ['book_id' => $book->id]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Laisser le premier avis
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                    Se connecter pour laisser un avis
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    S'inscrire
                </a>
            @endauth
        </div>
    @endif
</div>

<style>
    .star-rating {
        color: #ffc107;
    }
    
    .rating-distribution .progress {
        border-radius: 10px;
    }
    
    .rating-distribution .progress-bar {
        border-radius: 10px;
    }
    
    .reviews-list .card {
        border-radius: 15px;
        transition: transform 0.2s ease;
    }
    
    .reviews-list .card:hover {
        transform: translateY(-2px);
    }
    
    .review-comment {
        line-height: 1.6;
    }
</style>