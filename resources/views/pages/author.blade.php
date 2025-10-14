@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcrumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">All Authors</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>All Authors</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Author Area start
==============================-->
    <section class="vs-blog-wrapper space-top space-extra-bottom">
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
                <div class="row g-4">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.20s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-1.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Jessica Kalvin</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-2.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Rodja Heartmann</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-3.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Ema Watson</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-4.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Rivanur R. Rafi</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-5.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Mrthina Kaiko</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-6.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Alison Baker</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.20s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-7.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Branden Mc Calam </a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-8.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Fahim Al Bashar</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-9.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Ema Watson</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-10.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Allaudin Alim</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-11.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Gonza Hatun</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-12.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Dua Lipa</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.20s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-13.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Eva Green</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-14.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Josher Martha</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-15.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Jenifer Lopez</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-16.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Snow White</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-17.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Kauppila Bevan</a></h2>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="feature-style2">
                            <span class="feature-img">
                                <img src="{{ asset('assets/img/feature/feature-author-1-8.jpg') }}" alt="feature image">
                            </span>
                            <h2 class="feature-title"><a href="{{ route('author-details') }}">Tony Stark</a></h2>
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
    Author Area End
==============================-->
@endsection 