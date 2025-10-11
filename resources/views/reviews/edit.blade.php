@extends('layouts.app')

@section('title', 'Edit My Review')

@push('styles')
<style>
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
    
    .rating                <p>Are you absolutely sure you want to delete this review?</p>
                <p class="text-muted small">
                    This action is <strong>irreversible</strong>. Your review and rating will be permanently deleted.
                </p>ut input[type="radio"] {
        display: none;
    }
    
    .rating-input label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .rating-input input[type="radio"]:checked ~ label {
        color: #ffc107;
    }
    
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107;
    }
    
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .book-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .char-counter {
        font-size: 0.875rem;
        color: #6c757d;
        text-align: right;
        margin-top: 0.25rem;
    }
    
    .char-counter.warning {
        color: #fd7e14;
    }
    
    .char-counter.danger {
        color: #dc3545;
    }
    
    .current-rating {
        background: rgba(255, 193, 7, 0.1);
        border: 2px solid #ffc107;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Navigation -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Review
                </a>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reviews.show', $review) }}">My Review</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>

            <div class="form-card">
                <!-- En-tête -->
                <div class="form-header">
                    <h1 class="mb-2">
                        <i class="fas fa-edit me-3"></i>Edit My Review
                    </h1>
                    <p class="mb-0 opacity-90">Update your rating and comment</p>
                </div>
                
                <!-- Contenu -->
                <div class="p-4">
                    <!-- Book Information (non-editable) -->
                    <div class="book-info">
                        @if($review->book->cover_image)
                            <img src="{{ $review->book->cover_image }}" 
                                 alt="{{ $review->book->title }}" 
                                 style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-dark">{{ $review->book->title }}</h5>
                            <p class="mb-1 text-muted">par {{ $review->book->author }}</p>
                            @if($review->book->category)
                                <div class="mb-2">
                                    <span class="badge rounded-pill" style="background-color: {{ $review->book->category->color }}; color: white;">
                                        <i class="{{ $review->book->category->icon }} me-1"></i>
                                        {{ $review->book->category->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Review created on</div>
                            <div class="fw-bold">{{ $review->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <!-- Avertissement de modération -->
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> After modification, your review will need to be approved again before being publicly visible.
                    </div>

                    <form action="{{ route('reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Note actuelle et nouvelle note -->
                        <div class="mb-4">
                            <div class="current-rating">
                                <div class="small text-muted mb-1">Current Rating</div>
                                <div class="text-warning fs-4 mb-0">
                                    {!! $review->star_rating !!}
                                    <span class="text-dark ms-2">({{ $review->rating }}/5)</span>
                                </div>
                            </div>
                            
                            <label class="form-label fw-bold">
                                <i class="fas fa-star me-2 text-warning"></i>New Rating
                            </label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" 
                                           id="star{{ $i }}" 
                                           name="rating" 
                                           value="{{ $i }}"
                                           {{ (old('rating') ?? $review->rating) == $i ? 'checked' : '' }}
                                           required>
                                    <label for="star{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="text-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-center mt-2">
                                Click on the stars to modify your rating
                            </div>
                        </div>
                        
                        <!-- Commentaire -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">
                                <i class="fas fa-comment me-2 text-success"></i>Your Comment
                            </label>
                            
                            <!-- Preview of old comment -->
                            <div class="mb-3">
                                <div class="card bg-light">
                                    <div class="card-header bg-transparent">
                                        <small class="text-muted">
                                            <i class="fas fa-history me-1"></i>Current Comment:
                                        </small>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0 text-muted fst-italic">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="6" 
                                      maxlength="1000"
                                      placeholder="Update your comment..."
                                      required>{{ old('comment') ?? $review->comment }}</textarea>
                            
                            <div class="char-counter" id="charCounter">
                                <span id="charCount">0</span>/1000 caractères
                            </div>
                            
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="form-text">
                                <i class="fas fa-lightbulb me-1"></i>
                                Have you changed your mind since your first reading? Feel free to add new details.
                            </div>
                        </div>
                        
                        <!-- Modification history (if applicable) -->
                        @if($review->updated_at->ne($review->created_at))
                            <div class="mb-4">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-clock me-2"></i>
                                    <strong>Last modified:</strong> {{ $review->updated_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Boutons d'action -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="fas fa-times me-2"></i>Cancel Changes
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                        
                        <!-- Advanced Options -->
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="text-muted mb-3">Advanced Options</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Delete this Review</strong>
                                    <div class="small text-muted">Cette action est irréversible</div>
                                </div>
                                <button type="button" 
                                        class="btn btn-outline-danger"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you absolutely sure you want to delete this review?</p>
                <p class="text-muted mb-0">
                    This action is <strong>irreversible</strong>. Your review and rating will be permanently deleted.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Compteur de caractères
        const commentTextarea = document.getElementById('comment');
        const charCount = document.getElementById('charCount');
        const charCounter = document.getElementById('charCounter');
        
        function updateCharCount() {
            const length = commentTextarea.value.length;
            charCount.textContent = length;
            
            // Changer la couleur selon le nombre de caractères
            charCounter.classList.remove('warning', 'danger');
            if (length > 800) {
                charCounter.classList.add('danger');
            } else if (length > 600) {
                charCounter.classList.add('warning');
            }
        }
        
        commentTextarea.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial call
        
        // Détection des changements
        let initialRating = document.querySelector('input[name="rating"]:checked')?.value;
        let initialComment = commentTextarea.value;
        
        function checkForChanges() {
            const currentRating = document.querySelector('input[name="rating"]:checked')?.value;
            const currentComment = commentTextarea.value;
            
            const hasChanges = (currentRating !== initialRating) || (currentComment !== initialComment);
            
            // Optionnel : désactiver le bouton de soumission s'il n'y a pas de changements
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                if (!hasChanges) {
                    submitBtn.classList.add('disabled');
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>No Changes';
                } else {
                    submitBtn.classList.remove('disabled');
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Changes';
                }
            }
        }
        
        // Listen for changes
        document.querySelectorAll('input[name="rating"]').forEach(input => {
            input.addEventListener('change', checkForChanges);
        });
        commentTextarea.addEventListener('input', checkForChanges);
        
        // Vérification initiale
        checkForChanges();
        
        // Validation avant soumission
        document.querySelector('form').addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const comment = commentTextarea.value.trim();
            
            if (!rating) {
                e.preventDefault();
                alert('Veuillez donner une note en cliquant sur les étoiles.');
                return;
            }
            
            if (comment.length < 10) {
                e.preventDefault();
                alert('Your comment must contain at least 10 characters.');
                commentTextarea.focus();
                return;
            }
            
            // Confirm if important changes have been made
            const currentRating = rating.value;
            const ratingChanged = currentRating !== initialRating;
            
            if (ratingChanged) {
                const ratingMessages = {
                    '1': 'très négative (1 étoile)',
                    '2': 'négative (2 étoiles)',
                    '3': 'mitigée (3 étoiles)',
                    '4': 'positive (4 étoiles)',
                    '5': 'très positive (5 étoiles)'
                };
                
                if (!confirm(`You are going to change your rating to ${ratingMessages[currentRating]}. Do you confirm this modification?`)) {
                    e.preventDefault();
                    return;
                }
            }
        });
    });
</script>
@endpush