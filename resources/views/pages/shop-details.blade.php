@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcrumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Shop Details</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Shop Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style/custom.css') }}">
    <style>
        /* Augmenter proportionnellement la taille de l'image du livre */
        .vs-product-wrapper .product-slide-row .img {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 12px;
        }
        .vs-product-wrapper .product-slide-row .img img {
            max-width: 100%;
            width: 100%;
            height: auto;
            max-height: 640px;
            object-fit: contain;
        }
        @media (max-width: 767px) {
            .vs-product-wrapper .product-slide-row .img img { max-height: 420px; }
        }

        /* Réorganisation harmonieuse des boutons et des champs de quantité */
        .vs-product-wrapper .product-about .actions form {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .vs-product-wrapper .product-about .quantity { margin: 0; }
        .vs-product-wrapper .product-about .qty-input { width: 88px; min-height: 44px; }
        .vs-product-wrapper .product-about .buttons-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .vs-product-wrapper .product-about .buttons-row .vs-btn { padding: 12px 20px; }

        /* Grille responsive pour les résultats IA dans le modal */
        .ai-modal-grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
        @media (min-width: 992px) { .ai-modal-grid { grid-template-columns: 1fr 1fr; } }
        .ai-section { min-height: 120px; }
    </style>
    @endpush
    <!-- Shop Details Area Start-->
    <div class="vs-product-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-60">
                <div class="col-lg-6">
                    <div class="product-slide-row wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="img"><img src="{{ asset($book->cover_image) }}" alt="Product Image"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-about wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-rating">
                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                <span></span>
                            </div>
                            <span class="product-rating__total">Review (03)</span>
                        </div>
                        <h2 class="product-title">{{ $book->title }}</h2>
                        <span class="product-author"><strong>By:</strong> <a href="#">{{ $book->author }}</a></span>
                        <p class="product-price">${{ $book->price }}</p>
                        <p class="text">{{ $book->description }}</p>
                        <span class="product-instock">
                            <p>Availability:</p><span><i class="fas fa-check-square"></i>In Stock</span>
                        </span>
                        <div class="actions">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="quantity">
                                    <div class="quantity__field quantity-container">
                                        <div class="quantity__buttons">
                                            <button type="button" class="quantity-plus qty-btn"><i class="fal fa-plus"></i></button>
                                            <input type="number" id="quantity" class="qty-input" step="1" min="1" max="100" name="quantity" value="1" title="Qty">
                                            <button type="button" class="quantity-minus qty-btn"><i class="fal fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttons-row">
                                    <button type="submit" class="vs-btn"><i class="fa-solid fa-basket-shopping"></i>Add to Cart</button>
                                    <button type="button" class="vs-btn vs-btn--outline ai-encouragement-btn" data-book-id="{{ $book->id }}">
                                        <i class="fas fa-magic"></i>Pourquoi acheter ce livre ? IA
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="product_meta">
                            <h4 class="h5">Information:</h4>
                            <span class="sku_wrapper">
                                <p>SKU:</p> <span class="sku">{{ $book->id }}</span>
                            </span>
                            <span class="posted_in">
                                <p>Category:</p> <a href="#" rel="tag">{{ $book->category->name }}</a>
                            </span>
                            <span>
                                <p>Tags:</p> <a href="#" rel="tag">Kids</a><a href="#" rel="tag">Popular</a><a href="#" rel="tag">Gost</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-description wow animate__fadeInUp" data-wow-delay="0.50s">
                <div class="product-description__tab">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Reviews (03)</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="description">
                            <p class="text">{{ $book->description }}</p>
                            <div class="product_meta">
                                <span class="sku_wrapper">
                                    <p>Categoris</p> <span class="sku">{{ $book->category->name }}</span>
                                </span>
                                <span class="posted_in">
                                    <p>Color</p> <span>Lilac Purple</span>
                                </span>
                                <span>
                                    <p>Item Weight</p> <span>10.4 Ounces</span>
                                </span>
                                <span>
                                    <p>Item Dimensions</p> <span>2.6 x 4.2 x 4.8 inches</span>
                                </span>
                                <span>
                                    <p>Paper</p> <span>White Paper</span>
                                </span>
                            </div>
                            <p class="text">{{ $book->description }}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="woocommerce-reviews">
                            <div class="vs-comments-wrap">
                                <ul class="comment-list">
                                    <li class="review vs-comment-item">
                                        <div class="vs-post-comment">
                                            <div class="comment-avater">
                                                <img src="{{ asset('assets/img/shop/r-1-1.jpg') }}" alt="Comment Author">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-content__header">
                                                    <div class="review-rating">
                                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <h4 class="name h4">Crish Thomas</h4>
                                                </div>
                                                <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit purus vel, of a
                                                    viveirra facilisi neque quisque. Phasellus aliquam ut a id rhogncus. In viverra sed vitae
                                                    vivamus amet, nuncg vivamus. </p>
                                                <span class="commented-on">Published 1 day ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="review vs-comment-item">
                                        <div class="vs-post-comment">
                                            <div class="comment-avater">
                                                <img src="{{ asset('assets/img/shop/r-1-2.jpg') }}" alt="Comment Author">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-content__header">
                                                    <div class="review-rating">
                                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <h4 class="name h4">Crish Thomas</h4>
                                                </div>
                                                <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit purus vel, of a
                                                    viveirra facilisi neque quisque. Phasellus aliquam ut a id rhogncus. In viverra sed vitae
                                                    vivamus amet, nuncg vivamus. </p>
                                                <span class="commented-on">Published 1 day ago</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="vs-comment-form review-form">
                                <div id="respond" class="comment-respond">
                                    @auth
                                        <form action="{{ route('reviews.store') }}" method="POST" id="review-form">
                                            @csrf
                                            <div class="form-title">
                                                <h3 class="blog-inner-title">Add A Review</h3>
                                                @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                @if(session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                <div class="rating-select">
                                                    <label>Your Rating</label>
                                                    <p class="stars">
                                                        <span id="star-rating" data-rating="0">
                                                            <a class="star-1" href="#" data-value="1">1</a>
                                                            <a class="star-2" href="#" data-value="2">2</a>
                                                            <a class="star-3" href="#" data-value="3">3</a>
                                                            <a class="star-4" href="#" data-value="4">4</a>
                                                            <a class="star-5" href="#" data-value="5">5</a>
                                                        </span>
                                                    </p>
                                                    <input type="hidden" name="rating" id="rating-input" value="" required>
                                                </div>
                                            </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label>Livre</label>
                                                <select name="book_id" class="form-control" required>
                                                    <option value="">Sélectionnez un livre</option>
                                                    @foreach(App\Models\Book::all() as $book)
                                                        <option value="{{ $book->id }}">{{ $book->title }} - {{ $book->author }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="user_name" class="form-control" placeholder="Votre nom" value="{{ auth()->user()->name ?? '' }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="email" name="user_email" class="form-control" placeholder="Email Address" value="{{ auth()->user()->email ?? '' }}">
                                            </div>
                                            <div class="col-12 form-group">
                                                <textarea name="comment" class="form-control" placeholder="Votre avis sur ce livre..." required minlength="10" maxlength="1000"></textarea>
                                                <small class="text-muted">Minimum 10 caractères, maximum 1000</small>
                                            </div>
                                            <div class="col-12 form-group mb-0">
                                                <div class="custom-checkbox notice">
                                                    <input id="wp-comment-cookies-consent" name="save_info" type="checkbox" value="yes">
                                                    <label for="wp-comment-cookies-consent">Sauvegarder mes informations pour la prochaine fois</label>
                                                </div>
                                                <button type="submit" class="vs-btn"> <span class="vs-btn__bar"></span>Soumettre l'avis</button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                        <div class="text-center p-4">
                                            <h3 class="blog-inner-title">Add A Review</h3>
                                            <div class="alert alert-info">
                                                <h5><i class="fas fa-info-circle"></i> Connexion requise</h5>
                                                <p>Vous devez être connecté pour laisser un avis sur ce livre.</p>
                                                <a href="{{ route('login') }}" class="vs-btn">
                                                    <span class="vs-btn__bar"></span>Se connecter
                                                </a>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Details Area End -->

    <!-- AI Purchase Encouragement Modal -->
    <div class="modal fade" id="aiEncouragementModal" tabindex="-1" aria-labelledby="aiEncouragementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content ai-modal">
                <div class="modal-header ai-modal-header">
                    <h5 class="modal-title ai-modal-title" id="aiEncouragementModalLabel">
                        <i class="fas fa-magic me-2"></i>Pourquoi acheter ce livre ?
                    </h5>
                    <button type="button" class="btn-close ai-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ai-modal-body">
                    <div class="ai-loading text-center" id="aiLoading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Génération en cours...</span>
                        </div>
                        <p class="mt-3">L'IA analyse ce livre pour vous...</p>
                    </div>
                    
                    <div class="ai-content" id="aiContent" style="display: none;">
                        <div class="ai-headline mb-4">
                            <h4 class="ai-title" id="aiHeadline"></h4>
                        </div>
                        
                        <div class="ai-persuasive-text mb-4">
                            <p class="ai-description" id="aiPersuasiveText"></p>
                        </div>
                        
                        <div class="ai-benefits mb-4">
                            <h6 class="ai-section-title">Pourquoi ce livre est fait pour vous :</h6>
                            <ul class="ai-benefits-list" id="aiBenefitsList"></ul>
                        </div>
                        
                        <div class="ai-social-proof mb-4">
                            <div class="social-proof-card">
                                <i class="fas fa-users text-success me-2"></i>
                                <span id="aiSocialProof"></span>
                            </div>
                        </div>
                        
                        <div class="ai-urgency mb-4">
                            <div class="urgency-card">
                                <i class="fas fa-clock text-warning me-2"></i>
                                <span id="aiUrgencyMessage"></span>
                            </div>
                        </div>
                        
                        <!-- Section des recommandations de livres similaires -->
                        <div class="ai-similar-books mb-4" id="aiSimilarBooksSection" style="display: none;">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-book-open me-2"></i>Livres similaires recommandés
                            </h6>
                            <div class="similar-books-container" id="aiSimilarBooks">
                                <!-- Les recommandations seront ajoutées ici par JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="ai-error text-center" id="aiError" style="display: none;">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Une erreur est survenue lors de la génération du contenu. Veuillez réessayer.
                        </div>
                    </div>
                </div>
                <div class="modal-footer ai-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary ai-cta-btn" id="aiCallToAction">
                        <i class="fas fa-shopping-cart me-2"></i>Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/ai-encouragement.js') }}"></script>
@endpush