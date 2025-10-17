@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Blog Standard</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Blog Standard</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Blog Area
==============================-->
    <section class="vs-blog-wrapper blog-sidebar2 space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.25s">
                            <div class="vs-blog blog-style2">
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.35s">
                            <div class="vs-blog blog-style2">
                                <div class="blog-img">
                                    <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-2.jpg') }}" alt="Blog Image"></a>
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.45s">
                            <div class="vs-blog blog-style2">
                                <div class="blog-img">
                                    <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-3.jpg') }}" alt="Blog Image"></a>
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.55s">
                            <div class="vs-blog blog-style2">
                                <div class="blog-img">
                                    <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-5.jpg') }}" alt="Blog Image"></a>
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.65s">
                            <div class="vs-blog blog-style2">
                                <div class="blog-img">
                                    <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-6.jpg') }}" alt="Blog Image"></a>
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.75s">
                            <div class="vs-blog blog-style2">
                                <div class="blog-img">
                                    <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-7.jpg') }}" alt="Blog Image"></a>
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                        <div class="col-12 wow animate__fadeInUp" data-wow-delay="0.85s">
                            <div class="vs-blog blog-style2">
                                <div class="blog-img">
                                    <a href="{{ route('blog-details') }}"><img class="blog-img__img" src="{{ asset('assets/img/blog/blog-img-1-8.jpg') }}" alt="Blog Image"></a>
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
                                        <a href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet con sectetur.</a>
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
                <div class="col-xl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search wow animate__fadeInUp" data-wow-delay="0.25s">
                            <h3 class="wp-block-heading widget_title title-shep">Search</h3>
                            <form class="search-form">
                                <input type="text" placeholder="Search Here...">
                                <button class="vs-btn" type="submit">Search</button>
                            </form>
                        </div>
                        <div class="widget wow animate__fadeInUp" data-wow-delay="0.35s">
                            <div class="wp-block-group widget_categories is-layout-constrained wp-block-group-is-layout-constrained">
                                <div class="wp-block-group__inner-container">
                                    <h3 class="wp-block-heading widget_title title-shep">Categories</h3>
                                    <ul class="wp-block-categories-list wp-block-categories">
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Romance</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Thriller</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Fantasy</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Since Fiction</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Since</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Astronomy</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Kids</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Cartoon & Story</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="{{ route('blog') }}">Educational</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="widget wow animate__fadeInUp" data-wow-delay="0.45s">
                            <h3 class="widget_title title-shep">Latest News</h3>
                            <div class="recent-post-wrap">
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog-details') }}"><img src="{{ asset('assets/img/blog/recent-post-1-1.jpg') }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <div class="recent-post-meta">
                                            <i class="fas fa-calendar-alt"></i> 16 January, 2025
                                        </div>
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a></h4>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog-details') }}"><img src="{{ asset('assets/img/blog/recent-post-1-2.jpg') }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <div class="recent-post-meta">
                                            <i class="fas fa-calendar-alt"></i> 16 January, 2025
                                        </div>
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('blog-details') }}">How to Improve amet Your Riding Skills</a></h4>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog-details') }}"><img src="{{ asset('assets/img/blog/recent-post-1-3.jpg') }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <div class="recent-post-meta">
                                            <i class="fas fa-calendar-alt"></i> 16 January, 2025
                                        </div>
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('blog-details') }}">Lorem ipsum dolor sit amet consectetur.</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--==============================
    Blog Area End
    ==============================-->
    <!-- Cta Area -->
    <section class="cta-layout1 z-index-common blog-title">
        <div class="container">
            <div class="row gx-60 align-items-center">
                <div class="col-lg-3">
                    <div class="cta-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.svg') }}" alt="Ebukz" class="logo"></a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row justify-content-xl-between justify-content-center align-items-center">
                        <div class="col-xl-4 col-lg-5">
                            <div class="newsletter-inner">
                                <span class="newsletter-icon"><img src="{{ asset('assets/img/icons/mail-2.svg') }}" alt="icon"></span>
                                <div class="newsletter-content">
                                    <h4 class="newsletter_title">Get In Touch</h4>
                                    <p class="newsletter-text">Subscribe for more Update</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7">
                            <div class="newsletter-form">
                                <div class="search-btn">
                                    <input class="form-control" type="email" placeholder="Your Email Address">
                                    <button type="submit" class="vs-btn"><i class="fa-solid fa-paper-plane"></i> Subscribe</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cta Area End -->
@endsection 