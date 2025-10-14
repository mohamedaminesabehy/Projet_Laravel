@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Blog Grid</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Blog Grid</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Blog Area
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.25s">
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.35s">
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.45s">
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.55s">
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.65s">
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.75s">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-6.jpg') }}" alt="Blog Image"></a>
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.85s">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-7.jpg') }}" alt="Blog Image"></a>
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.90s">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-8.jpg') }}" alt="Blog Image"></a>
                            <div class="blog-date">
                                <span class="day"><strong class="month">16</b>may</span>
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
                <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="0.95s">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-9.jpg') }}" alt="Blog Image"></a>
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
            <div class="row justify-content-center wow animate__fadeInUp" data-wow-delay="0.95s">
                <div class="col-auto">
                    <div class="vs-pagination"><a href="#" class="pagi-btn"><i class="fa-solid fa-arrow-left"></i></a>
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
    Blog Area End
    ==============================-->
    <!-- Cta Area End -->
@endsection 