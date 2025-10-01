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
                @foreach($books as $book)
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="product-img">
                            <img src="{{ asset($book->cover_image) }}" alt="product image">
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
                                    <li><del>${{ $book->price * 1.3 }}</del></li>
                                    <li>${{ $book->price }}</li>
                                </ul>
                            </div>
                            <span class="product-author"><strong>By:</strong> {{ $book->author }}</span>
                            <h2 class="product-title"><a href="{{ route('shop-details', ['id' => $book->id]) }}">{{ $book->title }}</a></h2>
                        </div>
                    </div>
                </div>
                @endforeach
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