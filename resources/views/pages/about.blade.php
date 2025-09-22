@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcrumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">About Us</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>About Us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Area  -->
    <section class="about-layout1 space-top">
        <div class="container space-bottom">
            <div class="row g-5 justify-content-center align-items-center">
                <div class="col-lg-4">
                    <div class="about-img wow animate__fadeInUp" data-wow-delay="0.45s">
                        <img src="{{ asset('assets/img/about/about-img-1-1.jpg') }}" alt="about image">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="about-content">
                        <div class="wow animate__fadeInUp" data-wow-delay="0.35s">
                            <div class="title-area animation-style1 title-anime">
                                <h2 class="sec-title text-title title-anime__title">We Are The Best Online Book Selling Store In The World</h2>
                            </div>
                            <p class="about-text wow animate__fadeInUp" data-wow-delay="0.30s">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>
                        <div class="list-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-badge-check"></i>Lorem ipsum dolor sit amet, qua. </li>
                                <li><i class="fa-solid fa-badge-check"></i>Lorem ipsum dolor sit qua. </li>
                                <li><i class="fa-solid fa-badge-check"></i>Lorem ipsum dolor sit amet </li>
                                <li><i class="fa-solid fa-badge-check"></i>Lorem ipsum dolor sit.</li>
                            </ul>
                        </div>
                        <div class="about-content wow animate__fadeInUp" data-wow-delay="0.75s">
                            <div class="about-box">
                                <div class="about-img wow animate__fadeInUp" data-wow-delay="0.55s">
                                    <img src="{{ asset('assets/img/about/about-img-1-2.jpg') }}" alt="about image">
                                </div>
                                <div class="about-inner mb-0 wow animate__fadeInUp" data-wow-delay="0.95s">
                                    <p class="about-text mb-20">
                                        Lorem ipsum dolor sit amet, consecteturdvnd adipiscing elit, sed do jdvj eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    </p>
                                    <a class="vs-btn" href="{{ route('about') }}">Explore More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Area End -->
    <!-- Video Area Start -->
    <div class="video-style1" data-bg-src="{{ asset('assets/img/bg/video-bg1.jpg') }}">
        <div class="container">
            <div class="title-area text-center animation-style1 title-anime">
                <h2 class="sec-title text-white title-anime__title">We are providing Best Services</h2>
            </div>
            <div class="video-btn text-center">
                <a href="https://www.youtube.com/watch?v=moYayPRgaY0" class="play-btn popup-video">
                    <i class="fas fa-play"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Video Area End -->
    <!-- counter Area -->
    <section class="counter-layout1 bg-theme">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="counter-style1">
                    <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
                        <div class="media-counter text-center">
                            <div class="media-count">
                                <h2 class="media-title counter-number" data-count="2">00</h2>
                                <span class="count-icon">M+</span>
                            </div>
                            <p class="media-text">Book Collection</p>
                        </div>
                        <span class="counter-line">
                            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
                        </span>
                    </div>
                    <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
                        <div class="media-counter text-center">
                            <div class="media-count">
                                <h2 class="media-title counter-number" data-count="99">00</h2>
                                <span class="count-icon">+</span>
                            </div>
                            <p class="media-text">Award Wins</p>
                        </div>
                        <span class="counter-line">
                            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
                        </span>
                    </div>
                    <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
                        <div class="media-counter text-center">
                            <div class="media-count">
                                <h2 class="media-title counter-number" data-count="10">00</h2>
                                <span class="count-icon">k+</span>
                            </div>
                            <p class="media-text">Book Author</p>
                        </div>
                        <span class="counter-line">
                            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
                        </span>
                    </div>
                    <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
                        <div class="media-counter text-center">
                            <div class="media-count">
                                <h2 class="media-title counter-number" data-count="100">00</h2>
                                <span class="count-icon">+</span>
                            </div>
                            <p class="media-text">Team Members</p>
                        </div>
                        <span class="counter-line">
                            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
                        </span>
                    </div>
                    <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
                        <div class="media-counter text-center">
                            <div class="media-count">
                                <h2 class="media-title counter-number" data-count="12">00</h2>
                                <span class="count-icon">k+</span>
                            </div>
                            <p class="media-text">Trusted Clients</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Facts Area End -->
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
                                            “ When you work with Los Angeles House Cleaners Refal Agen cleaning room breathe easy because your
                                            home will soon When yowork with Angeles House Cleaners Referal Agency cleaning breathe ”
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
                                            “ When you work with Los Angeles House Cleaners Refal Agen cleaning room breathe easy because your
                                            home will soon When yowork with Angeles House Cleaners Referal Agency cleaning breathe ”
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
    <!-- Brand Area Start  -->
    <div class="brand-style1 space-bottom">
        <div class="container">
            <div class="row vs-carousel wow animate__fadeInUp" data-wow-delay="0.35s" data-slide-show="5" data-lg-slide-show="4" data-md-slide-show="3" data-sm-slide-show="2" data-xs-slide-show="2" data-autoplay="true">
                <div class="col-xl-2">
                    <div class="brand-item">
                        <img src="{{ asset('assets/img/brand/brand-1-1.png') }}" alt="brand image">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="brand-item">
                        <img src="{{ asset('assets/img/brand/brand-1-2.png') }}" alt="brand image">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="brand-item">
                        <img src="{{ asset('assets/img/brand/brand-1-3.png') }}" alt="brand image">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="brand-item">
                        <img src="{{ asset('assets/img/brand/brand-1-4.png') }}" alt="brand image">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="brand-item">
                        <img src="{{ asset('assets/img/brand/brand-1-5.png') }}" alt="brand image">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="brand-item">
                        <img src="{{ asset('assets/img/brand/brand-1-1.png') }}" alt="brand image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand Area End  -->
@endsection 