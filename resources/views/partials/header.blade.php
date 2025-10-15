<!-- External CSS for Authentication Buttons -->
<link rel="stylesheet" href="{{ asset('css/auth-buttons.css') }}">

<div class="preloader">
    <button class="vs-btn pre                        <li><a href="#">Page List 1</a>
                            <ul>
                                <li><a href="{{ route('home') }}">Home 1</a></li>
                                <li><a href="#">Home 2</a></li>
                                <li><a href="#">Home 3</a></li>
                                <li><a href="{{ route('about') }}">About</a></li>
                                <li><a href="{{ route('reviews.index') }}">Reviews</a></li>
                                <li><a href="{{ route('ai-insights.index') }}"><i class="fas fa-brain"></i> AI Insights</a></li>
                                <li><a href="{{ route('favorites') }}"><i class="fas fa-heart"></i> Favorite Categories</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </li>Cancel Preloader </button>
    <div class="preloader-inner">
        <img src="{{ asset('assets/img/dark-logo.svg') }}" alt="logo">
        <span class="loader"></span>
    </div>
</div>
<button class="back-to-top" id="backToTop" aria-label="Back to Top">
    <span class="progress-circle">
        <svg viewBox="0 0 100 100">
            <circle class="bg" cx="50" cy="50" r="40"></circle>
            <circle class="progress" cx="50" cy="50" r="40"></circle>
        </svg>
        <span class="progress-percentage" id="progressPercentage">0%</span>
    </span>
</button>
<!--==============================
	Mobile Menu
	============================== -->
<div class="vs-menu-wrapper">
    <div class="vs-menu-area text-center">
        <div class="mobile-logo">
            <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.svg') }}" alt="ebukz" class="logo"></a>
            <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
        </div>
        <div class="vs-mobile-menu">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="menu-item-has-children">
                    <a href="{{ route('shop') }}">Shop</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('shop') }}">Shop</a></li>
                        <li><a href="{{ route('shop-sidebar') }}">Shop Sidebar</a></li>
                        <li><a href="{{ route('shop') }}">Shop Details</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Pages</a>
                    <ul class="mega-menu">
                        <li><a href="{{ route('shop') }}">Page List 1</a>
                            <ul>
                                <li><a href="{{ route('home') }}">Home 1</a></li>
                                <li><a href="#">Home 2</a></li>
                                <li><a href="#">Home 3</a></li>
                                <li><a href="{{ route('about') }}">About</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Page List 2</a>
                            <ul>
                                <li><a href="{{ route('blog') }}">Blog</a></li>
                                <li><a href="{{ route('blog-sidebar') }}">Blog Sidebar</a></li>
                                <li><a href="{{ route('blog-sidebar-2') }}">Blog Sidebar 2</a></li>
                                <li><a href="{{ route('blog-standard') }}">Blog Standard</a></li>
                                <li><a href="{{ route('blog-details') }}">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Page List 3</a>
                            <ul>
                                <li><a href="{{ route('cart') }}">Cart</a></li>
                                <li><a href="{{ route('shop') }}">Shop</a></li>
                                <li><a href="{{ route('shop-sidebar') }}">Shop Sidebar</a></li>
                                <li><a href="{{ route('shop') }}">Shop Details</a></li>
                                <li><a href="{{ route('404') }}">Error Page</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Page List 4</a>
                            <ul>
                                <li><a href="{{ route('wishlist') }}">wishlist</a></li>
                                <li><a href="{{ route('checkout') }}">checkout</a></li>
                                <li><a href="{{ route('author') }}">All Authors</a></li>
                                <li><a href="{{ route('author-details') }}">Author Details</a></li>
                                <li><a href="{{ route('vendor') }}">Vendor</a></li>
                                <li><a href="{{ route('vendor-details') }}">Vendor Details</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('reviews.index') }}">Reviews</a>
                </li>
                <li>
                    <a href="{{ route('ai-insights.index') }}">
                        <i class="fas fa-brain"></i> AI Insights
                    </a>
                </li>
                <li>
                    <a href="{{ route('favorites') }}" class="favorite-categories-link">
                        <i class="fas fa-heart"></i> Favorites
                        @auth
                            @php
                                $favCount = auth()->user()->categoryFavorites()->count();
                            @endphp
                            @if($favCount > 0)
                                <span class="favorite-count-badge">{{ $favCount }}</span>
                            @endif
                        @endauth
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--==============================
    Popup Search Box
    ============================== -->
<div class="popup-search-box d-none d-lg-block  ">
    <button class="searchClose"><i class="fal fa-times"></i></button>
    <form action="#">
        <input type="text" class="border-theme" placeholder="What are you looking for">
        <button type="submit"><i class="fal fa-search"></i></button>
    </form>
</div>
<!--==============================
    Header Area
    ==============================-->
<header class="vs-header header-layout1 style2">
    <div class="header-top">
        <div class="container">
            <div class="row justify-content-md-between justify-content-center align-items-center">
                <div class="col-auto">
                    <div class="header-links d-md-inline d-none">
                        <ul>
                            <li><i class="fa-solid fa-truck-fast"></i>Fastest Delivery In Your City</li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="header-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><span class="globe-icon"><i class="fal fa-globe"></i></span>English</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Arabic</a></li>
                                <li><a class="dropdown-item" href="#">German</a></li>
                                <li><a class="dropdown-item" href="#">French</a></li>
                                <li><a class="dropdown-item" href="#">Italian</a></li>
                                <li><a class="dropdown-item" href="#">Slobac</a></li>
                                <li><a class="dropdown-item" href="#">Russian</a></li>
                                <li><a class="dropdown-item" href="#">Spanish</a></li>
                            </ul>
                        </div>
                        <div class="header-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                        <div class="user-login">
                            @auth
                                <!-- User is logged in - Show dropdown with username -->
                                <div class="dropdown">
                                    <a href="#" class="d-inline-flex align-items-center user-menu-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                                        <i class="fa-solid fa-user me-2"></i>
                                        <span class="username-display">{{ auth()->user()->name }}</span>
                                        <i class="fa-solid fa-chevron-down ms-2"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userMenu">
                                        <li class="dropdown-header">
                                            <div class="user-info">
                                                <strong>{{ auth()->user()->name }}</strong>
                                                <small class="text-muted d-block">{{ auth()->user()->email }}</small>
                                            </div>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="fa-regular fa-id-badge me-2"></i>Profile
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('wishlist') }}">
                                            <i class="fa-regular fa-heart me-2"></i>Wishlist
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('favorites') }}">
                                            <i class="fas fa-heart me-2" style="color: #ff6b6b;"></i>My Favorite Categories
                                            @php
                                                $favCount = auth()->user()->categoryFavorites()->count();
                                            @endphp
                                            @if($favCount > 0)
                                                <span class="badge bg-danger ms-2">{{ $favCount }}</span>
                                            @endif
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa-regular fa-right-from-bracket me-2"></i>Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <!-- User is not logged in - Show Sign In and Sign Up buttons -->
                                <div class="auth-buttons d-flex align-items-center gap-2">
                                    <a href="{{ route('signin') }}" class="btn btn-outline-primary btn-sm auth-btn signin-btn">
                                        <i class="fa-regular fa-right-to-bracket me-1"></i>Sign In
                                    </a>
                                    <a href="{{ route('signup') }}" class="btn btn-primary btn-sm auth-btn signup-btn">
                                        <i class="fa-regular fa-user-plus me-1"></i>Sign Up
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="row justify-content-sm-between justify-content-center align-items-center gx-sm-0">
                <div class="col-auto">
                    <div class="header-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/img/dark-logo.svg') }}" alt="Ebukz" class="logo"></a>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="header-inner">
                        <form class="header-search">
                            <button class="searchBoxTggler" aria-label="search-button">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <div class="d-flex align-items-center">
                                <div class="dropdown">
                                    <div class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                        Categories
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                                <input type="text" placeholder="Search yourProduct's.....">
                            </div>
                        </form>
                        <div class="header-buttons">
                            <a href="{{ route('wishlist') }}" class="vs-icon wishlist"><i class="fal fa-heart"></i></a>
                            <div class="header-info">
                                <div class="header-info_icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="media-body">
                                    <span class="header-info_label">Call Us 24/7</span>
                                    <div class="header-info_link"><a href="tel:+1234567890">(+216) 72 727 272 </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-wrapper header-bottom">
        <div class="sticky-active">
            <div class="container">
                <div class="menu-top">
                    <div class="row justify-content-between align-items-center gx-sm-0">
                        <div class="col-xl-auto">
                            <div class="menu-inner">
                                <div class="header-category">
                                    <button class="category-toggler"><i class="fa-solid fa-bars-sort"></i>Categories</button>
                                    <div class="vs-box-nav">
                                        <ul>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-1.svg') }}" alt="icon">Romance</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-2.svg') }}" alt="icon">Thriller</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-3.svg') }}" alt="icon">Fantasy</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-4.svg') }}" alt="icon">Since Fiction</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-5.svg') }}" alt="icon">Since</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-6.svg') }}" alt="icon">Adventure</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-7.svg') }}" alt="icon">Kids</a></li>
                                            <li><a href="{{ route('shop') }}"><img src="{{ asset('assets/img/icons/categori-i-8.svg') }}" alt="icon">cartoon & Story</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="header-logo">
                                    <a href="{{ route('home') }}"><img src="{{ asset('assets/img/dark-logo.svg') }}" alt="Ebukz" class="logo"></a>
                                </div>
                                <div class="menu-area">
                                    <nav class="main-menu menu-style1 d-none d-lg-block">
                                        <ul>
                                            <li>
                                                <a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="{{ route('shop') }}">Shop</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('shop') }}">Shop</a></li>
                                                    <li><a href="{{ route('shop-sidebar') }}">Shop Sidebar</a></li>

                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">Pages</a>
                                                <ul class="mega-menu">
                                                    <li><a href="{{ route('shop') }}">Page List 1</a>
                                                        <ul>
                                                            <li><a href="{{ route('home') }}">Home 1</a></li>
                                                            <li><a href="#">Home 2</a></li>
                                                            <li><a href="#">Home 3</a></li>
                                                            <li><a href="{{ route('about') }}">About</a></li>
                                                            <li><a href="{{ route('contact') }}">Contact</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Page List 2</a>
                                                        <ul>
                                                            <li><a href="{{ route('blog') }}">Blog</a></li>
                                                            <li><a href="{{ route('blog-sidebar') }}">Blog Sidebar</a></li>
                                                            <li><a href="{{ route('blog-sidebar-2') }}">Blog Sidebar 2</a></li>
                                                            <li><a href="{{ route('blog-standard') }}">Blog Standard</a></li>
                                                            <li><a href="{{ route('blog-details') }}">Blog Details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Page List 3</a>
                                                        <ul>
                                                            <li><a href="{{ route('cart') }}">Cart</a></li>
                                                            <li><a href="{{ route('shop') }}">Shop</a></li>
                                                            <li><a href="{{ route('shop-sidebar') }}">Shop Sidebar</a></li>
                                                            <li><a href="{{ route('shop') }}">Shop Details</a></li>
                                                            <li><a href="{{ route('404') }}">Error Page</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Page List 4</a>
                                                        <ul>
                                                            <li><a href="{{ route('wishlist') }}">wishlist</a></li>
                                                            <li><a href="{{ route('checkout') }}">checkout</a></li>
                                                            <li><a href="{{ route('author') }}">All Authors</a></li>
                                                            <li><a href="{{ route('author-details') }}">Author Details</a></li>
                                                            <li><a href="{{ route('vendor') }}">Vendor</a></li>
                                                            <li><a href="{{ route('vendor-details') }}">Vendor Details</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="{{ route('reviews.index') }}">Reviews</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('ai-insights.index') }}">
                                                    <span style="display: inline-flex; align-items: center; gap: 5px;">
                                                        <i class="fas fa-brain"></i> AI Insights
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('favorites') }}" class="favorite-categories-link">
                                                    <span style="display: inline-flex; align-items: center; gap: 5px;">
                                                        <i class="fas fa-heart"></i> Favorites
                                                    </span>
                                                    @auth
                                                        @php
                                                            $favCount = auth()->user()->categoryFavorites()->count();
                                                        @endphp
                                                        @if($favCount > 0)
                                                            <span class="favorite-count-badge">{{ $favCount }}</span>
                                                        @endif
                                                    @endauth
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('contact') }}">Contact</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto d-xl-block d-none">
                            <div class="header-cart">
                                <a href="{{ route('cart') }}" class="vs-icon cart"><i class="fal fa-shopping-bag"></i><span class="badge">{{ $cartCount }}</span></a>
                                        
                                        
                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* Simplified User Menu Styles */
.user-menu-toggle {
    background: var(--theme-color);
    color: var(--white-color);
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
    font-family: var(--body-font);
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 6px rgba(209, 102, 85, 0.25);
}

.user-menu-toggle:hover {
    background: var(--title-color);
    color: var(--white-color);
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(46, 74, 91, 0.3);
}

.username-display {
    font-weight: 500;
    font-family: var(--title-font);
    margin: 0 8px;
    font-size: 15px;
}

.user-dropdown-menu {
    background: var(--white-color);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    padding: 8px 0;
    min-width: 260px;
    margin-top: 8px;
}

.user-dropdown-menu .dropdown-header {
    background: var(--body-color);
    color: var(--title-color);
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    margin: 0 0 8px 0;
    border: none;
    font-weight: 600;
    font-size: 14px;
}

.user-dropdown-menu .dropdown-item {
    padding: 12px 20px;
    font-size: 14px;
    color: var(--title-color);
    font-family: var(--body-font);
    transition: all 0.3s ease;
    border: none;
    font-weight: 500;
}

.user-dropdown-menu .dropdown-item:hover {
    background: var(--body-color);
    color: var(--theme-color);
}

.user-dropdown-menu .dropdown-item i {
    width: 20px;
    text-align: center;
    color: var(--secondary-color);
    margin-right: 8px;
}

.user-dropdown-menu .dropdown-item:hover i {
    color: var(--theme-color);
}

.user-dropdown-menu .dropdown-divider {
    margin: 8px 0;
    border-color: var(--border-color);
}

.user-dropdown-menu .text-danger {
    color: var(--error-color) !important;
}

.user-dropdown-menu .text-danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: var(--error-color) !important;
}

/* Badge styling to match theme */
.user-dropdown-menu .badge {
    background-color: var(--theme-color) !important;
    color: var(--white-color);
    font-size: 11px;
    padding: 3px 6px;
    border-radius: 10px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .user-dropdown-menu {
        min-width: 240px;
    }
    
    .user-menu-toggle {
        padding: 8px 14px;
        font-size: 14px;
    }
    
    .username-display {
        font-size: 14px;
    }
}
</style>
