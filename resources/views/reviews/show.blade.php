@extends('layouts.app')

@section('title', 'Review by ' . $review->user->name)

@push('styles')
<style>
    .review-detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .review-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-right: 1.5rem;
    }
    
    .star-rating {
        color: #ffc107;
        font-size: 1.5rem;
        margin: 0.5rem 0;
    }
    
    .book-section {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    
    .book-cover {
        width: 120px;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .comment-section {
        background: white;
        border-left: 4px solid #007bff;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 10px 10px 0;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    .dropdown-item {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin: 0.25rem 0.5rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: #F8EBE5;
        transform: translateX(5px);
    }
    
    .dropdown-header {
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.75rem 1rem 0.5rem;
    }
    
    .meta-info {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
    }
    
    .category-badge {
        display: inline-block;
        position: relative;
        z-index: 1;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: white !important;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        margin-bottom: 1rem;
    }
    
    .book-info-section {
        position: relative;
        z-index: 10;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back button -->
            <div class="mb-4">
                <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>

            <div class="review-detail-card">
                <!-- En-tête avec utilisateur -->
                <div class="review-header">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h1 class="mb-2">{{ $review->user->name }}</h1>
                            <div class="star-rating mb-2">
                                {!! $review->star_rating !!}
                                <span class="ms-2 fs-5">({{ $review->rating }}/5)</span>
                            </div>
                            <div class="meta-info">
                                <i class="fas fa-calendar-alt me-2"></i>{{ $review->formatted_date }}
                            </div>
                        </div>
                        <div class="text-end">
                            @if($review->is_approved)
                                <span class="status-badge bg-success text-white">
                                    <i class="fas fa-check-circle me-1"></i>Approuvé
                                </span>
                            @else
                                <span class="status-badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i>Pending
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="p-4">
                    <!-- Book Section -->
                    <div class="book-section">
                        <h4 class="mb-3 text-dark">
                            <i class="fas fa-book me-2 text-primary"></i>Book Reviewed
                        </h4>
                        
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                @if($review->book->cover_image)
                                    <img src="{{ $review->book->cover_image }}" 
                                         alt="{{ $review->book->title }}" 
                                         class="book-cover w-100">
                                @else
                                    <div class="book-cover w-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-9 book-info-section">
                                <h3 class="mb-2 text-dark">{{ $review->book->title }}</h3>
                                <p class="mb-2 text-muted fs-5">par {{ $review->book->author }}</p>
                                
                                @if($review->book->category)
                                    <div class="mb-3">
                                        <span class="category-badge" style="background-color: {{ $review->book->category->color }}">
                                            <i class="{{ $review->book->category->icon }} me-1"></i>
                                            {{ $review->book->category->name }}
                                        </span>
                                    </div>
                                @endif
                                
                                @if($review->book->description)
                                    <p class="text-muted mb-0">{{ Str::limit($review->book->description, 200) }}</p>
                                @endif
                                
                                <div class="mt-3">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="small text-muted">Note moyenne</div>
                                            <div class="h5 text-warning">
                                                {{ number_format($review->book->average_rating, 1) }}/5
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted">Number of Reviews</div>
                                            <div class="h5 text-info">{{ $review->book->total_reviews }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted">Prix</div>
                                            <div class="h5 text-success">{{ $review->book->formatted_price }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Commentaire -->
                    <div class="comment-section">
                        <h4 class="mb-3 text-dark">
                            <i class="fas fa-comment me-2 text-success"></i>Comment
                        </h4>
                        <div class="fs-5 text-dark lh-lg">
                            {{ $review->comment }}
                        </div>
                    </div>
                    
                    <!-- Actions (si c'est l'avis de l'utilisateur connecté) -->
                    @auth
                        @if(Auth::id() === $review->user_id)
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>This review belongs to you
                                    </small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: #D16655; color: #D16655;">
                                        <i class="fas fa-cog me-2"></i>Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="border: 2px solid #D16655;">
                                        <li>
                                            <h6 class="dropdown-header" style="color: #2E4A5B;">
                                                <i class="fas fa-tools me-1"></i>Actions disponibles
                                            </h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reviews.show', $review) }}">
                                                <i class="fas fa-eye me-2" style="color: #2E4A5B;"></i>View Full Review
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('reviews.edit', $review) }}">
                                                <i class="fas fa-edit me-2" style="color: #D16655;"></i>Edit My Review
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirmDelete()">
                                                    <i class="fas fa-trash-alt me-2" style="color: #BD7579;"></i>Delete Permanently
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                                
                                @if(!$review->is_approved)
                                    <div class="alert alert-info mt-3" role="alert">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Information:</strong> Your review is pending approval. It will be visible publicly once validated by our team.
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth
                    
                    <!-- Section pour les avis similaires -->
                    @if($review->book->approvedReviews->count() > 1)
                        <div class="mt-4 pt-4 border-top">
                            <h5 class="mb-3 text-dark">
                                <i class="fas fa-comments me-2 text-info"></i>Other Reviews on this Book
                            </h5>
                            
                            <div class="row">
                                @foreach($review->book->approvedReviews->where('id', '!=', $review->id)->take(3) as $otherReview)
                                    <div class="col-md-4 mb-3">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="me-2">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $otherReview->user->name }}</div>
                                                        <div class="text-warning small">
                                                            {!! $otherReview->star_rating !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="small text-muted mb-2">
                                                    {{ Str::limit($otherReview->comment, 100) }}
                                                </p>
                                                <a href="{{ route('reviews.show', $otherReview) }}" class="btn btn-sm btn-outline-primary">
                                                    Read Full Review
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('books.reviews', $review->book) }}" class="btn btn-outline-info">
                                    View All Reviews for this Book ({{ $review->book->total_reviews }})
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    return confirm('🗑️ Permanent Deletion\n\n⚠️ Are you absolutely sure you want to delete this review?\n\n• This action is irreversible\n• Your review and rating will be permanently lost\n• This action cannot be undone\n\nClick "OK" to confirm permanent deletion.');
}

// Animation du dropdown
document.addEventListener('DOMContentLoaded', function() {
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    
    dropdownItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endpush