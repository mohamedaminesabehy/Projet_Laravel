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
    <!-- Shop Details Area Start-->
    <div class="vs-product-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-60">
                <div class="col-lg-6">
                    <div class="product-slide-row wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="img"><img src="{{ asset('assets/img/shop/product-d-1.jpg') }}" alt="Product Image"></div>
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
                        <h2 class="product-title">Neglected Solitary Life</h2>
                        <span class="product-author"><strong>By:</strong> <a href="#">Fahim Al Bashar</a></span>
                        <p class="product-price">$155.00 <del>$23.85</del></p>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit purus vel, of a viveirra facilisi neque
                            quisque. Phasellus aliquam ut id rhoncus. In viverra sed vitae vivamus amet, nuncg vivamus. </p>
                        <span class="product-instock">
                            <p>Availability:</p><span><i class="fas fa-check-square"></i>In Stock</span>
                        </span>
                        <div class="actions">
                            <div class="quantity">
                                <div class="quantity__field quantity-container">
                                    <div class="quantity__buttons">
                                        <button class="quantity-plus qty-btn"><i class="fal fa-plus"></i></button>
                                        <input type="number" id="quantity" class="qty-input" step="1" min="1" max="100" name="quantity" value="01" title="Qty">
                                        <button class="quantity-minus qty-btn"><i class="fal fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('cart') }}" class="vs-btn"><i class="fa-solid fa-basket-shopping"></i>Add to Cart</a>
                            <a href="{{ route('wishlist') }}" class="icon-btn"><i class="far fa-heart"></i></a>
                        </div>
                        <div class="product_meta">
                            <h4 class="h5">Information:</h4>
                            <span class="sku_wrapper">
                                <p>SKU:</p> <span class="sku">03</span>
                            </span>
                            <span class="posted_in">
                                <p>Category:</p> <a href="#" rel="tag">Thriller</a>
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
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod
                                orci.
                                Cum
                                sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum ultricies
                                aliquam. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus sit am.</p>
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod
                                orci.
                                Cum
                                sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum ultricies
                                aliquam. Done ultricies nec, pellent, consectetur adipiscing elit. Ieuismod orci.</p>
                            <div class="product_meta">
                                <span class="sku_wrapper">
                                    <p>Categoris</p> <span class="sku">Thriller</span>
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
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod
                                orci.
                                Cum
                                sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum ultricies
                                aliquam. Done ultricies nec, pellent, consectetur adipiscing elit. Ieuismod orci. Cum sociis natoque
                                penatibus et magnis dis parturient montes
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci</p>
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
                                    <div class="form-title">
                                        <h3 class="blog-inner-title">Add A Review</h3>
                                        <div class="rating-select">
                                            <label>Your Rating</label>
                                            <p class="stars">
                                                <span>
                                                    <a class="star-1" href="#">1</a>
                                                    <a class="star-2" href="#">2</a>
                                                    <a class="star-3" href="#">3</a>
                                                    <a class="star-4" href="#">4</a>
                                                    <a class="star-5" href="#">5</a>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="text" class="form-control" placeholder="Complete Name">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input type="email" class="form-control" placeholder="Email Address">
                                        </div>
                                        <div class="col-12 form-group">
                                            <textarea class="form-control" placeholder="Review"></textarea>
                                        </div>
                                        <div class="col-12 form-group mb-0">
                                            <div class="custom-checkbox notice">
                                                <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                                                <label for="wp-comment-cookies-consent"> Save my name, email, and website in this browser for
                                                    the next time I comment.</label>
                                            </div>
                                            <button class="vs-btn"> <span class="vs-btn__bar"></span>Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Details Area End -->
    <!-- Book Of The Month End -->
    <section class="books-layout1 style2 space-bottom">
        <div class="container">
            <div class="title-area2 animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Book Of The Month</h2>
                <div class="arraw-area">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button class="icon-btn border-none" data-slick-prev=".book-carousel">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <button class="icon-btn" data-slick-next=".book-carousel">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row vs-carousel g-4 book-carousel wow animate__fadeInUp" data-wow-delay="0.30s" data-slide-show="4" data-autoplay="true">
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-1.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                        </div>
                            <span class="product-author"><strong>By:</strong> Fahim Al Bashar</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">The Muke Guy</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-2.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> H Abdul</span>
                            <h2 class="product-title"> <a href="{{ route('shop') }}">Levtimeline</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-3.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> D Bellingham</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Mick Weive Mockchapu</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-4.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> Alex Jhon</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Fuarcnusk Preentine</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-5.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> Nicola joi</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">L Art Du Subtiliste</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-6.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> Fahim Al Bashar</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Vqirk Teur Mocgkcup</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.90s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-7.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> Nicola joi</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Hd Pry Balir Ptonnrnle</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.95s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-8.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="icon-btn cart">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="product-rating">
                                <span class="star"><i class="fas fa-star"></i> (4.5)</span>
                                <ul class="price-list">
                                    <li><del>$39.99</del></li>
                                    <li>$30.00</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> Fahim Al Bashar</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Beuto minimal Cork</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Book Of The Month End -->
@endsection 