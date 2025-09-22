@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcrumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Author Details</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Author Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Author Details Start
==============================-->
    <section class="author-details space">
        <div class="container space-bottom position-relative">
            <div class="row align-items-center gx-60 g-4">
                <div class="col-xl-5 col-lg-6">
                    <div class="author-img">
                        <img src="{{ asset('assets/img/about/author-img.jpg') }}" alt="author image">
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="author-content">
                        <h2 class="author-title">Rodja Heartmann</h2>
                        <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sit purus vel, of a viv eirra fasdcilisi neque quisque.
                            Phasellus aliquam ut id rhoncus. In viverra sed vitae vivamus amet, nuncg quisque. Phasellus aliquam vivamus. </p>
                        <p class="text">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vijktae pellentesque sem placerat.
                            In id cursus mi pretxedium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nioplec metus bibendum egestas.
                            Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent urna tempor taciti sociosqu. </p>
                        <div class="author-social">
                            <h3 class="social-title">Social Media</h3>
                            <ul class="social-links">
                                <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <span class="border-line"></span>
        </div>
    </section>
    <!--==============================
    Author Details End
    ==============================-->
    <!-- Kids Product Start -->
    <section class="romance-layout1">
        <div class="container space-bottom position-relative">
            <div class="title-area2 animation-style1 title-anime">
                <h2 class="sec-title title-anime__title">Books By Rodja heartmann</h2>
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
        </div>
    </section>
    <!-- Kids Product End -->
    @endsection 