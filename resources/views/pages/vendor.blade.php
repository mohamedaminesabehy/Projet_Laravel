@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Vendor</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Vendor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
    Vendor Area Start
==============================-->
    <section class="vendor-layout1 space-top space-extra-bottom">
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
            <div class="row gy-30 mb-20">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.20s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-1.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Book Store</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-2.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">RR Publisher</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.40s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-3.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">King Of Books</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-1.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Pink & Blue</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.60s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-2.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Book Station</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.70s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-3.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Book Nest</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.80s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-7.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Pyramid Books</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.90s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-8.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Rainbow Books</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="vendor-style1 wow animate__fadeInUp" data-wow-delay="0.95s">
                        <div class="vendor-body">
                            <div class="vendor-inner">
                <span class="vendor-icon">
                <img src="{{ asset('assets/img/vendor/vendor-1-9.jpg') }}" alt="vendor image">
              </span>
                                <div>
                                    <h6 class="vendor-title"><a href="{{ route('vendor-details') }}">Fast Print</a></h6>
                                    <div class="star-rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="list-style1">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-marked-alt"></i>Willow Creek, # 32/65 Colorado United State Of America</li>
                                    <li><i class="fas fa-envelope"></i><a href="mailto:example@ebokz.com">example@ebokz.com</a></li>
                                    <li><i class="fa-solid fa-headset"></i> <a href="tel:+0061365000299">+(006) 1365 000 29</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('vendor-details') }}" class="icon-btn"><i class="fa-regular fa-arrow-right"></i></a>
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
    Vendor Area End
==============================-->
@endsection
