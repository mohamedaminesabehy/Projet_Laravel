@extends('layouts.app')

@section('content')
    {{-- @push('styles')
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
    @endpush --}}
    <!--==============================
    Breadcumb
    ============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Error Page</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Error Page</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Error -->
    <div class="space error-style1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="error-img wow animate__fadeInUp" data-wow-delay="0.35s">
                        <img src="{{ asset('assets/img/404/404.png') }}" alt="404">
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <div class="text-center  wow animate__fadeInUp" data-wow-delay="0.55s">
                        <div class="title-area animation-style1 title-anime">
                            <h2 class="sec-title text-title title-anime__title">Oops! That Page Can't Be Found.</h2>
                        </div>
                        <p class="error-text wow animate__fadeInUp" data-wow-delay="0.75s">Unfortunately, something went wrong and this page does not exist. Try using the search or return to the previous page.</p>
                        <a href="{{ route('home') }}" class="vs-btn wow animate__bounceInUp" data-wow-delay="0.85s">Go Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Error End -->
    {{-- @push('scripts')
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
    @endpush --}}
@endsection 