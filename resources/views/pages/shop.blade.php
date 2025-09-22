@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcrumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Shop</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Shop Area
==============================-->
    <section class="books-layout1 space-top space-extra-bottom">
        <div class="container">
            <div class="vs-sort-bar">
                <div class="row gap-4 align-items-center">
                    <div class="col-md-auto flex-grow-1">
                        <p class="woocommerce-result-count">Showing <span>1-9 of 40</span> results</p>
                    </div>
                    <div class="col-md-auto">
                        <form class="woocommerce-ordering" method="get">
                            <select name="orderby" class="orderby" aria-label="Shop order">
                                <option value="recent_product" selected="selected">Short By Latest</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="rating">Sort by average rating</option>
                                <option value="date">Sort by latest</option>
                                <option value="price">Sort by price: low to high</option>
                                <option value="price-desc">Sort by price: high to low</option>
                            </select>
                        </form>
                    </div>
                </div>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">The Muke Guy</a></h2>
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
                            <h2 class="product-title"> <a href="{{ route('shop-details') }}">Levtimeline</a></h2>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Mick Weive Mockchapu</a></h2>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Fuarcnusk Preentine</a></h2>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">L Art Du Subtiliste</a></h2>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Vqirk Teur Mocgkcup</a></h2>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Hd Pry Balir Ptonnrnle</a></h2>
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Beuto minimal Cork</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-9.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Aelon Nacedile</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-10.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Green Journey</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.90s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-11.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Mick Weive Mockchapu</a></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.95s">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/product/product-img-5-13.jpg') }}" alt="product image">
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
                            <h2 class="product-title"><a href="{{ route('shop-details') }}">Beuto minimal Cork</a></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center wow animate__fadeInUp" data-wow-delay="0.95s">
                <div class="col-auto">
                    <div class="vs-pagination mt-55"><a href="#" class="pagi-btn"><i class="fa-solid fa-arrow-left"></i></a>
                        <ul>
                            <li><a href="#" class="active">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#">16</a></li>
                        </ul><a href="#" class="pagi-btn active"><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Shop Area End
==============================-->
@endsection 