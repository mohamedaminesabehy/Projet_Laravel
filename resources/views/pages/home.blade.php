@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="icon" href="{{ asset('assets/img/favicons/favicon.svg') }}" type="image/svg+xml">
        <link rel="icon" href="{{ asset('assets/img/favicons/favicon.png') }}" type="image/png" sizes="32x32">
        <link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset('assets/img/favicons/favicon.png') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/nouislider.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/twentytwenty.css') }}">
    @endpush
    <section class="hero-layout1" data-wow-delay="0.25s" aria-hidden="true">
        <div class="hero-item" data-bg-src="{{ asset('assets/img/bg/hero-bg1.jpg') }}">
            <div class="container position-relative z-index">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 position-relative">
                        <div class="hero-content">
                            <h1 class="hero-title wow animate__fadeInUp" data-wow-delay="0.50s">The Most Biggest <span class="title-highlight">Bookstore</span> in the world</h1>
                            <p class="hero-text wow animate__fadeInUp" data-wow-delay="0.75s">We deliver books all over the world 10,000+ books in stock.</p>
                            <a class="vs-btn wow animate__flipInX" data-wow-delay="0.95s" href="{{ route('shop') }}">Explore More</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-img">
                            <img src="{{ asset('assets/img/hero/hero-img-1-1.png') }}" alt="hero image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="shape-mockup element1 z-index1  d-xxl-block d-none" data-wow-delay="0.80s" style="right: 0px; top: -10px;"><img src="{{ asset('assets/img/shapes/hero-shape2.svg') }}" alt="Hero shape"></span>
        <span class="shape-mockup element2 z-index1  d-xxl-block d-none" data-wow-delay="0.80s" style="left: 0px; bottom: -10px;"><img src="{{ asset('assets/img/shapes/hero-shape3.svg') }}" alt="Hero shape"></span>
        <span class="shape-mockup z-index1 wow animate__fadeInLeft d-xxl-block d-none" data-wow-delay="0.80s" style="left: 0px; top: 0px;"><img src="{{ asset('assets/img/shapes/hero-shape1.svg') }}" alt="Hero shape"></span>
    </section>
    <!-- Trending Product Start -->
    <section class="trending-layout1 space">
        <div class="container">
            <div class="title-area2 animation-style1 title-anime">
                <span class="border-line d-xxl-block d-none"></span>
                <h2 class="sec-title title-anime__title">Trending On Ebukz</h2>
                <a class="vs-btn wow animate__flipInX" data-wow-delay="0.30s" href="{{ route('shop') }}">View More</a>
            </div>
            <div class="row g-4">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-1-1.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Rat Phnory Mttke</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-1-2.jpg') }}" alt="product image">
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
                            <h2 class="product-title"> <a href="{{ route('shop') }}">Ali Tofail Tu</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-1-3.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Green Journy</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-1-4.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Fefcenting Pesentin</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-1-5.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Tevely Entiamile</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-1-6.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Gmerll Femed</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Trending Product End -->
    <!-- Offer section Start -->
    <div class="offer-layout1 space-bottom">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-6 col-lg-6">
                    <div class="offer-style1 wow animate__fadeInLeft" data-wow-delay="0.30s" data-bg-src="{{ asset('assets/img/bg/offer-bg1.jpg') }}">
                        <div class="offer-img">
                            <img src="{{ asset('assets/img/offer/offer-img1.png') }}" alt="offer image">
                        </div>
                        <div class="offer-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <h2 class="offer-title">E Emeher Mme</h2>
                            <p class="offer-price">Only From <span>$85.00</span></p>
                            <a class="vs-btn" href="{{ route('shop') }}">Shop Now</a>
                        </div>
                        <span class="shape-mockup element1 z-index1  d-xxl-block d-none" data-wow-delay="0.80s" style="right: 0px; bottom: -5px;"><img src="{{ asset('assets/img/shapes/offer-shape1.png') }}" alt="offer shape"></span>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="offer-style1 white-style wow animate__fadeInRight" data-wow-delay="0.30s" data-bg-src="{{ asset('assets/img/bg/offer-bg2.jpg') }}">
                        <div class="offer-img">
                            <img src="{{ asset('assets/img/offer/offer-img1.png') }}" alt="offer image">
                        </div>
                        <div class="offer-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <h2 class="offer-title">Viving Moneme</h2>
                            <p class="offer-price">Only From <span>$85.00</span></p>
                            <a class="vs-btn" href="{{ route('shop') }}">Shop Now</a>
                        </div>
                        <span class="shape-mockup element1 z-index1  d-xxl-block d-none" data-wow-delay="0.80s" style="right: 0px; bottom: -5px;"><img src="{{ asset('assets/img/shapes/offer-shape2.png') }}" alt="offer shape"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer section End -->
    <!-- Top Categories Start -->
    <section class="categories-layout1 space" data-bg-src="{{ asset('assets/img/bg/categorie-bg1.jpg') }}">
        <div class="container">
            <div class="title-area text-center animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Top Categories</h2>
            </div>
            <div class="row g-4 mb-40 filter-menu-active">
                <div class="col-xl-2 col-lg-3 col-md-4 col-6 ">
                    <div class="categorie-style1 active wow animate__fadeInUp" data-filter="*" data-wow-delay="0.30s">
                        <img src="{{ asset('assets/img/categoris/catigori-1-1.png') }}" alt="categorie image">
                        <h4 class="categorie-title">Romance</h4>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-filter=".thriller">
                    <div class="categorie-style1  wow animate__fadeInUp" data-wow-delay="0.40s">
                        <img src="{{ asset('assets/img/categoris/catigori-1-2.png') }}" alt="categorie image">
                        <h4 class="categorie-title">Thriller</h4>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-filter=".fantasy">
                    <div class="categorie-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <img src="{{ asset('assets/img/categoris/catigori-1-3.png') }}" alt="categorie image">
                        <h4 class="categorie-title">fantasy</h4>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-filter=".since-fiction">
                    <div class="categorie-style1 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <img src="{{ asset('assets/img/categoris/catigori-1-4.png') }}" alt="categorie image">
                        <h4 class="categorie-title">Since Fiction</h4>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-filter=".since">
                    <div class="categorie-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <img src="{{ asset('assets/img/categoris/catigori-1-5.png') }}" alt="categorie image">
                        <h4 class="categorie-title">Since</h4>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-filter=".adventure">
                    <div class="categorie-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <img src="{{ asset('assets/img/categoris/catigori-1-6.png') }}" alt="categorie image">
                        <h4 class="categorie-title">Adventure</h4>
                    </div>
                </div>
            </div>
            <div class="row gy-30 mb-40 filter-active">
                <div class="col-xl-4 col-lg-6 col-md-6 filter-item fantasy adventure">
                    <div class="product-style1 style2 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-2-1.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="product-author"><strong>By:</strong> Fahim Al Bashar</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Feel The Bloosme Session</a></h2>
                            <ul class="price-list">
                                <li><del>$124</del></li>
                                <li>$100</li>
                            </ul>
                            <div class="product-btn">
                                <a class="vs-btn" href="{{ route('cart') }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 filter-item thriller since-fiction adventure">
                    <div class="product-style1 style2 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-2-2.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="product-author"><strong>By:</strong> Fahim Al Bashar</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">World Adventure Trekking</a></h2>
                            <ul class="price-list">
                                <li><del>$124</del></li>
                                <li>$100</li>
                            </ul>
                            <div class="product-btn">
                                <a class="vs-btn" href="{{ route('cart') }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 filter-item since-fiction fantasy">
                    <div class="product-style1 style2 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-2-3.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="product-author"><strong>By:</strong>Keep Clam Mountain</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Feel The Bloosme Session</a></h2>
                            <ul class="price-list">
                                <li><del>$124</del></li>
                                <li>$100</li>
                            </ul>
                            <div class="product-btn">
                                <a class="vs-btn" href="{{ route('cart') }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 filter-item adventure since-fiction">
                    <div class="product-style1 style2 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-2-4.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="product-author"><strong>By:</strong>Learn From Nature</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Feel The Bloosme Session</a></h2>
                            <ul class="price-list">
                                <li><del>$124</del></li>
                                <li>$100</li>
                            </ul>
                            <div class="product-btn">
                                <a class="vs-btn" href="{{ route('cart') }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 filter-item thriller since-fiction since fantasy">
                    <div class="product-style1 style2 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-2-5.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="product-author"><strong>By:</strong>Rat Phnory Mttke Srial</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Feel The Bloosme Session</a></h2>
                            <ul class="price-list">
                                <li><del>$124</del></li>
                                <li>$100</li>
                            </ul>
                            <div class="product-btn">
                                <a class="vs-btn" href="{{ route('cart') }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 filter-item since since-fiction">
                    <div class="product-style1 style2 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-2-6.jpg') }}" alt="product image">
                            <div class="product-btns">
                                <a href="{{ route('wishlist') }}" class="icon-btn wishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                            <ul class="post-box">
                                <li>Hot</li>
                                <li>-30%</li>
                            </ul>
                        </div>
                        <div class="product-content">
                            <div class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="product-author"><strong>By:</strong>Negated Story Life</span>
                            <h2 class="product-title"><a href="{{ route('shop') }}">Feel The Bloosme Session</a></h2>
                            <ul class="price-list">
                                <li><del>$125</del></li>
                                <li>$100</li>
                            </ul>
                            <div class="product-btn">
                                <a class="vs-btn" href="{{ route('cart') }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a class="vs-btn wow animate__flipInX" data-wow-delay="0.40s" href="{{ route('shop') }}">View More</a>
            </div>
        </div>
    </section>
    <!-- Top Categories End -->
    <!-- Best selling start -->
    <section class="selling-layout1 space" data-bg-src="{{ asset('assets/img/bg/selling-bg.jpg') }}">
        <div class="container">
            <div class="row g-4 gx-40 align-items-center">
                <div class="col-xl-5">
                    <div class="selling-content">
                        <h2 class="selling-title wow animate__fadeInUp" data-wow-delay="0.20s">Best Seller Author Of The Month</h2>
                        <h4 class="author-name wow animate__fadeInUp" data-wow-delay="0.30s">Joseph Martin</h4>
                        <span class="published wow animate__fadeInUp" data-wow-delay="0.40s">30+ Published Book</span>
                        <p class="selling-text wow animate__fadeInUp" data-wow-delay="0.50s">Lorem ipsum dolor a amet, consectetur adipiscing elit, eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut eim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                        <a class="vs-btn wow animate__flipInX" data-wow-delay="0.60s" href="#">Read More</a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="selling-img-tag wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="wow animate__fadeInDownBig" data-wow-delay="0.30s">
                            <div class="tag" data-wow-delay="0.30s">
                                <img src="{{ asset('assets/img/selling/selling-icon.png') }}" alt="selling icon">
                                <h4 class="tag-title">no.1 Best Seller Of The Month</h4>
                            </div>
                        </div>
                        <img src="{{ asset('assets/img/selling/selling-img.jpg') }}" class="w-100" alt="selling images">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="selling-books">
                        <div class="book-item wow animate__fadeInDown" data-wow-delay="0.30s">
                            <img src="{{ asset('assets/img/selling/book-img1.jpg') }}" alt="book image">
                        </div>
                        <div class="book-item wow animate__fadeInDown" data-wow-delay="0.40s">
                            <img src="{{ asset('assets/img/selling/book-img2.jpg') }}" alt="book image">
                        </div>
                        <div class="book-item wow animate__fadeInUp" data-wow-delay="0.50s">
                            <img src="{{ asset('assets/img/selling/book-img3.jpg') }}" alt="book image">
                        </div>
                        <div class="book-item wow animate__fadeInUp" data-wow-delay="0.60s">
                            <img src="{{ asset('assets/img/selling/book-img4.jpg') }}" alt="book image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Best selling End -->
    <!-- Romance Product Start -->
    <section class="romance-layout1 space-top">
        <div class="container space-bottom position-relative">
            <div class="title-area2 animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Best Selling Romance Books</h2>
                <a class="vs-btn wow animate__flipInX" data-wow-delay="0.70s" href="{{ route('shop') }}">View More</a>
            </div>
            <div class="row g-4">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-3-1.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Rivetmane 10An</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-3-2.jpg') }}" alt="product image">
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
                            <h2 class="product-title"> <a href="{{ route('shop') }}">Love Nature</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-3-3.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Love Story</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-3-4.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Stotc Stoite Ust...</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-3-5.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Cook Design Psvter</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-3-6.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Cover Design</a></h2>
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-line"></span>
        </div>
    </section>
    <!-- Romance Product End -->
    <!-- Kids Product Start -->
    <section class="Kids-layout1 space">
        <div class="container">
            <div class="title-area2 animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Best Selling Kids Books</h2>
                <a class="vs-btn wow animate__flipInX" data-wow-delay="0.50s" href="{{ route('shop') }}">View More</a>
            </div>
            <div class="row g-4">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-4-1.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Aelon Nacedile</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-4-2.jpg') }}" alt="product image">
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
                            <h2 class="product-title"> <a href="{{ route('shop') }}">Parer Book</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-4-3.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Every Thought Sed</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-4-4.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">A Sunny Day</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-4-5.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Present Trop Ical</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-4-6.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop') }}">Whispers of Wild</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Kids Product End -->
    <!-- Book Of The Month End -->
    <section class="books-layout1 space" data-bg-src="{{ asset('assets/img/bg/section-bg1.jpg') }}">
        <div class="container">
            <div class="title-area text-center animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Book Of The Month</h2>
            </div>
            <div class="row g-4">
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
                <div class="text-center">
                    <a class="vs-btn mt-10 wow animate__flipInX" data-wow-delay="0.40s" href="{{ route('shop') }}">View More</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Book Of The Month End -->
    <!-- Testimonial Area  -->
    <section class="vs-testi__layout1 space">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-5">
                    <div class="banner-img">
                        <img src="{{ asset('assets/img/others/banner1.jpg') }}" alt="banner image">
                        <div class="banner-content">
                            <span class="sub-title">Best offer</span>
                            <h2 class="banner-title">Save Up to $15</h2>
                            <a class="vs-btn" href="{{ route('shop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="vs-testi__inner">
                        <div class="title-area text-left wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
                            <span class="sec-subtitle  left-shape justify-content-center title-anime__title">Testimonials</span>
                            <h2 class="sec-title title-anime__title">What Our Clint's Feedback And review</h2>
                            <p class="sec-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor inc ididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div class="vs-testi__items wow animate__fadeInUp" data-wow-delay="0.35s">
                            <div class="vs-carousel testi-slider" data-autoplay="true" data-fade="true">
                                <div class="vs-testi__style1">
                                    <span class="vs-testi__icon"><img src="{{ asset('assets/img/icons/quote-icon.svg') }}" alt="icon"></span>
                                    <div class="vs-testi__top">
                                        <div class="vs-testi__image">
                                            <img class="img1" src="{{ asset('assets/img/testimonial/testi-1-1.jpg') }}" alt="testimonials">
                                        </div>
                                        <div class="vs-testi__author">
                                            <div class="star-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                            </div>
                                            <h3 class="vs-testi__title">rodja hartmann</h3>
                                            <span class="vs-testi__desi">Designer, Vecurosoft</span>
                                        </div>
                                    </div>
                                    <div class="vs-testi__content">
                                        <p class="vs-testi__text">
                                            <span class="text-highlight"><img class="icon" src="{{ asset('assets/img/testimonial/testi-icon1.png') }}" alt="icon"> Lorem ipsum dolor sit a met!</span>
                                            " When you work with Los Angeles House Cleaners Refal Agen cleaning room breathe easy because your
                                            home will soon When yowork with Angeles House Cleaners Referal Agency cleaning breathe "
                                        </p>
                                    </div>
                                </div>
                                <div class="vs-testi__style1">
                                    <span class="vs-testi__icon"><img src="{{ asset('assets/img/icons/quote-icon.svg') }}" alt="icon"></span>
                                    <div class="vs-testi__top">
                                        <div class="vs-testi__image">
                                            <img class="img1" src="{{ asset('assets/img/testimonial/testi-1-1.jpg') }}" alt="testimonials">
                                        </div>
                                        <div class="vs-testi__author">
                                            <div class="star-rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <h3 class="vs-testi__title">alaxander pall</h3>
                                            <span class="vs-testi__desi">Designer, Vecurosoft</span>
                                        </div>
                                    </div>
                                    <div class="vs-testi__content">
                                        <p class="vs-testi__text">
                                            <span class="text-highlight"><img class="icon" src="{{ asset('assets/img/testimonial/testi-icon1.png') }}" alt="icon"> Lorem ipsum dolor sit a met!</span>
                                            " When you work with Los Angeles House Cleaners Refal Agen cleaning room breathe easy because your
                                            home will soon When yowork with Angeles House Cleaners Referal Agency cleaning breathe "
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-arraw wow animate__fadeInUp" data-wow-delay="0.45s">
                            <div class="icon-arraw slick-prev" data-slick-prev=".testi-slider">
                                <button class="icon-btn">
                                    <i class="fa-regular fa-arrow-right"></i>
                                </button>
                            </div>
                            <div class="icon-arraw slick-next" data-slick-next=".testi-slider">
                                <button class="icon-btn">
                                    <i class="fa-regular fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Area End  -->
    <!-- Blog Area Start  -->
    <section class="custom-space-bottom">
        <div class="container">
            <div class="title-area2 animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Blog And News</h2>
                <a class="vs-btn wow animate__flipInX" data-wow-delay="0.50s" href="{{ route('blog') }}">View More</a>
            </div>
            <div class="row vs-carousel blog-carousel wow animate__fadeInUp" data-wow-delay="0.25s" data-arrows="true" data-autoplay="true" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="2" data-center-mode="true">
                <div class="col-lg-4 col-md-6">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-1.jpg') }}" alt="Blog Image"></a>
                            <div class="blog-date">
                                <span class="day"><strong class="month">15</strong>may</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-user"></i>By Admin</a>
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-comments"></i>2 Comments</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a>
                            </h2>
                            <div class="btn-area">
                                <a class="vs-btn" href="{{ route('blog-details') }}">Read More<i class="fa-regular fa-arrow-right"></i></a>
                                <div class="social-media">
                                    <div class="member-links">
                                        <a href="#" tabindex="-1"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" tabindex="-1"><i class="fa-brands fa-x-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-instagram"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-behance"></i></a>
                                    </div>
                                    <span class="icon-btn"><i class="fas fa-share-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-2.jpg') }}" alt="Blog Image"></a>
                            <div class="blog-date">
                                <span class="day"><strong class="month">16</strong>may</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-user"></i>By Admin</a>
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-comments"></i>2 Comments</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a>
                            </h2>
                            <div class="btn-area">
                                <a class="vs-btn" href="{{ route('blog-details') }}">Read More<i class="fa-regular fa-arrow-right"></i></a>
                                <div class="social-media">
                                    <div class="member-links">
                                        <a href="#" tabindex="-1"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" tabindex="-1"><i class="fa-brands fa-x-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-instagram"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-behance"></i></a>
                                    </div>
                                    <span class="icon-btn"><i class="fas fa-share-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-3.jpg') }}" alt="Blog Image"></a>
                            <div class="blog-date">
                                <span class="day"><strong class="month">16</strong>may</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-user"></i>By Admin</a>
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-comments"></i>2 Comments</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a>
                            </h2>
                            <div class="btn-area">
                                <a class="vs-btn" href="{{ route('blog-details') }}">Read More<i class="fa-regular fa-arrow-right"></i></a>
                                <div class="social-media">
                                    <div class="member-links">
                                        <a href="#" tabindex="-1"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" tabindex="-1"><i class="fa-brands fa-x-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-instagram"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-behance"></i></a>
                                    </div>
                                    <span class="icon-btn"><i class="fas fa-share-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-4.jpg') }}" alt="Blog Image"></a>
                            <div class="blog-date">
                                <span class="day"><strong class="month">16</strong>may</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-user"></i>By Admin</a>
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-comments"></i>2 Comments</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a>
                            </h2>
                            <div class="btn-area">
                                <a class="vs-btn" href="{{ route('blog-details') }}">Read More<i class="fa-regular fa-arrow-right"></i></a>
                                <div class="social-media">
                                    <div class="member-links">
                                        <a href="#" tabindex="-1"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" tabindex="-1"><i class="fa-brands fa-x-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-instagram"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-behance"></i></a>
                                    </div>
                                    <span class="icon-btn"><i class="fas fa-share-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-5.jpg') }}" alt="Blog Image"></a>
                            <div class="blog-date">
                                <span class="day"><strong class="month">16</strong>may</span>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-user"></i>By Admin</a>
                                <a href="{{ route('blog') }}"><i class="fa-solid fa-comments"></i>2 Comments</a>
                            </div>
                            <h2 class="blog-title">
                                <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a>
                            </h2>
                            <div class="btn-area">
                                <a class="vs-btn" href="{{ route('blog-details') }}">Read More<i class="fa-regular fa-arrow-right"></i></a>
                                <div class="social-media">
                                    <div class="member-links">
                                        <a href="#" tabindex="-1"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" tabindex="-1"><i class="fa-brands fa-x-twitter"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-instagram"></i></a>
                                        <a href="#" tabindex="-1"><i class="fab fa-behance"></i></a>
                                    </div>
                                    <span class="icon-btn"><i class="fas fa-share-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Area End  -->

    @push('scripts')
        <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
        <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
        <script src="{{ asset('assets/js/gsap-scroll-to-plugin.js') }}"></script>
        <script src="{{ asset('assets/js/SplitText.js') }}"></script>
        <script src="{{ asset('assets/js/lenis.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/custom-cursor.js') }}"></script>
    @endpush
@endsection 