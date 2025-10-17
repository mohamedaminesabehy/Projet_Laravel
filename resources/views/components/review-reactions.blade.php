@props(['review', 'showCount' => true, 'size' => 'md'])

@php
    $user = auth()->user();
    $userReaction = $user && $review->reactions ? $review->reactions->where('user_id', $user->id)->first() : null;
    $likesCount = $review->reactions ? $review->reactions->where('reaction_type', 'like')->count() : 0;
    $dislikesCount = $review->reactions ? $review->reactions->where('reaction_type', 'dislike')->count() : 0;
    $isOwnReview = $user && $review->user_id === $user->id;
    
    // Size classes
    $btnClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => ''
    };
@endphp

<div class="review-reactions d-inline-flex align-items-center gap-2" data-review-id="{{ $review->id }}">
    @auth
        @if(!$isOwnReview)
            <!-- Like Button -->
            <button 
                type="button" 
                class="btn btn-outline-success reaction-btn {{ $btnClass }} {{ $userReaction && $userReaction->reaction_type === 'like' ? 'active' : '' }}"
                data-reaction-type="like"
                data-bs-toggle="tooltip"
                title="Utile"
            >
                <i class="fas fa-thumbs-up"></i>
                @if($showCount)
                    <span class="reaction-count ms-1">{{ $likesCount }}</span>
                @endif
            </button>

            <!-- Dislike Button -->
            <button 
                type="button" 
                class="btn btn-outline-danger reaction-btn {{ $btnClass }} {{ $userReaction && $userReaction->reaction_type === 'dislike' ? 'active' : '' }}"
                data-reaction-type="dislike"
                data-bs-toggle="tooltip"
                title="Pas utile"
            >
                <i class="fas fa-thumbs-down"></i>
                @if($showCount)
                    <span class="reaction-count ms-1">{{ $dislikesCount }}</span>
                @endif
            </button>
        @else
            <!-- Display only for own review -->
            <div class="text-muted small">
                <i class="fas fa-thumbs-up text-success"></i> {{ $likesCount }}
                <i class="fas fa-thumbs-down text-danger ms-2"></i> {{ $dislikesCount }}
            </div>
        @endif
    @else
        <!-- Not authenticated - show counts only -->
        <div class="text-muted small">
            <i class="fas fa-thumbs-up text-success"></i> {{ $likesCount }}
            <i class="fas fa-thumbs-down text-danger ms-2"></i> {{ $dislikesCount }}
            <span class="ms-2 fst-italic">Connectez-vous pour réagir</span>
        </div>
    @endauth
</div>

@once
@push('styles')
<style>
    .review-reactions .reaction-btn {
        transition: all 0.3s ease;
        border-radius: 20px;
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
    }
    
    .review-reactions .reaction-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .review-reactions .reaction-btn.active {
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    
    .review-reactions .btn-outline-success.active {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
        color: white;
    }
    
    .review-reactions .btn-outline-danger.active {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-color: #dc3545;
        color: white;
    }
    
    .review-reactions .reaction-count {
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .review-reactions .btn-sm {
        font-size: 0.8rem;
        padding: 0.25rem 0.6rem;
    }
    
    .review-reactions .btn-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Handle reaction button clicks
    document.querySelectorAll('.reaction-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const reviewId = this.closest('.review-reactions').dataset.reviewId;
            const reactionType = this.dataset.reactionType;
            const container = this.closest('.review-reactions');
            const isActive = this.classList.contains('active');
            
            try {
                const response = await fetch(`/reviews/${reviewId}/reactions`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ reaction_type: reactionType })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update UI based on response
                    updateReactionUI(container, data);
                    
                    // Show success message (optional)
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Une erreur est survenue', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Une erreur est survenue lors de l\'enregistrement de votre réaction', 'error');
            }
        });
    });
    
    function updateReactionUI(container, data) {
        const likeBtn = container.querySelector('[data-reaction-type="like"]');
        const dislikeBtn = container.querySelector('[data-reaction-type="dislike"]');
        
        // Remove active class from both buttons
        likeBtn.classList.remove('active');
        dislikeBtn.classList.remove('active');
        
        // Add active class based on current reaction
        if (data.reaction_type === 'like') {
            likeBtn.classList.add('active');
        } else if (data.reaction_type === 'dislike') {
            dislikeBtn.classList.add('active');
        }
        
        // Update counts
        if (data.counts) {
            const likeCount = likeBtn.querySelector('.reaction-count');
            const dislikeCount = dislikeBtn.querySelector('.reaction-count');
            
            if (likeCount) likeCount.textContent = data.counts.likes;
            if (dislikeCount) dislikeCount.textContent = data.counts.dislikes;
        }
    }
    
    function showToast(message, type = 'info') {
        // Simple toast notification (you can use a library like Toastify or create your own)
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endpush
@endonce
