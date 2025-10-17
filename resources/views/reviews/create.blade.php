@extends('layouts.app')

@section('title', 'Leave a Review')

@push('styles')
<style>
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
    
    .rating-input input[type="radio"] {
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .book-selection {
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
    }
    
    .book-selection:hover {
        border-color: #007bff;
        background-color: #f8f9ff;
    }
    
    .book-preview {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
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
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <!-- En-tête -->
                <div class="form-header">
                    <h1 class="mb-2">
                        <i class="fas fa-star me-3"></i>Leave a Review
                    </h1>
                    <p class="mb-0 opacity-90">Share your reading experience</p>
                </div>
                
                <!-- Formulaire -->
                <div class="p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        
                        <!-- Book Selection -->
                        <div class="mb-4">
                            <label for="book_id" class="form-label fw-bold">
                                <i class="fas fa-book me-2 text-primary"></i>📚 Book to Review
                            </label>
                            
                            @if($book)
                                <!-- Pre-selected Book -->
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="book-preview">
                                    @if($book->cover_image)
                                        <img src="{{ $book->cover_image }}" 
                                             alt="{{ $book->title }}" 
                                             style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                    <div>
                                        <h5 class="mb-1 text-dark">{{ $book->title }}</h5>
                                        <p class="mb-1 text-muted">par {{ $book->author }}</p>
                                        @if($book->category)
                                            <div class="mb-2">
                                                <span class="badge rounded-pill" style="background-color: {{ $book->category->color }}; color: white;">
                                                    <i class="{{ $book->category->icon }} me-1"></i>
                                                    {{ $book->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- Sélection libre -->
                                <select class="form-select @error('book_id') is-invalid @enderror" 
                                        id="book_id" 
                                        name="book_id" 
                                        required>
                                    <option value="">Choose a book...</option>
                                    @foreach($books as $bookOption)
                                        <option value="{{ $bookOption->id }}" {{ old('book_id') == $bookOption->id ? 'selected' : '' }}>
                                            {{ $bookOption->title }} - {{ $bookOption->author }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('book_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Can't find your book? Contact us to add it.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Note -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-star me-2 text-warning"></i>Your Rating
                            </label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" 
                                           id="star{{ $i }}" 
                                           name="rating" 
                                           value="{{ $i }}"
                                           {{ old('rating') == $i ? 'checked' : '' }}
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
                                Click on the stars to give your rating (1 = disappointing, 5 = excellent)
                            </div>
                        </div>
                        
                        <!-- Commentaire -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">
                                <i class="fas fa-comment me-2 text-success"></i>Your Comment
                            </label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="5" 
                                      maxlength="1000"
                                      placeholder="Share your opinion about this book: what you liked, strengths, weaknesses, who you would recommend it to..."
                                      required>{{ old('comment') }}</textarea>
                            
                            <div class="char-counter" id="charCounter">
                                <span id="charCount">0</span>/1000 characters
                            </div>
                            
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="form-text">
                                <i class="fas fa-lightbulb me-1"></i>
                                <strong>Tips:</strong> Talk about the plot without spoilers, writing style, originality, emotions felt...
                            </div>
                        </div>
                        
                        <!-- Info modération -->
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Please note:</strong> Your review will be submitted for moderation before publication to ensure quality exchanges.
                        </div>
                        
                        <!-- Boutons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Publish Review
                            </button>
                        </div>
                    </form>
                </div>
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
        
        // Amélioration de l'interface des étoiles
        const ratingInputs = document.querySelectorAll('.rating-input input[type="radio"]');
        const ratingLabels = document.querySelectorAll('.rating-input label');
        
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Optionnel : afficher un message basé sur la note
                const rating = this.value;
                const messages = {
                    '1': 'Très décevant',
                    '2': 'Décevant',
                    '3': 'Moyen',
                    '4': 'Bon',
                    '5': 'Excellent'
                };
                
                // Vous pouvez afficher le message quelque part si souhaité
                console.log(messages[rating]);
            });
        });
        
        // Validation côté client
        document.querySelector('form').addEventListener('submit', function(e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const comment = commentTextarea.value.trim();
            
            if (!rating) {
                e.preventDefault();
                alert('Please give a rating by clicking on the stars.');
                return;
            }
            
            if (comment.length < 10) {
                e.preventDefault();
                alert('Your comment must contain at least 10 characters.');
                commentTextarea.focus();
                return;
            }
        });
    });
</script>
@endpush