<div class="preloader">
    <button class="vs-btn preloaderCls">Cancel Preloader </button>
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
                <li class="menu-item-has-children">
                    <a href="{{ route('home') }}">Home</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('home') }}">Home 1</a></li>
                        <li><a href="#">Home 2</a></li>
                        <li><a href="#">Home 3</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="{{ route('shop') }}">Shop</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('shop') }}">Shop</a></li>
                        <li><a href="{{ route('shop-sidebar') }}">Shop Sidebar</a></li>
                        <li><a href="{{ route('shop-details') }}">Shop Details</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="{{ route('vendor') }}">Vendor</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('vendor') }}">Vendor</a></li>
                        <li><a href="{{ route('vendor-details') }}">Vendor Details</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children mega-menu-wrap">
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
                                <li><a href="{{ route('shop-details') }}">Shop Details</a></li>
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
                <li class="menu-item-has-children">
                    <a href="{{ route('blog') }}">Blog</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('blog-sidebar') }}">Blog Sidebar</a></li>
                        <li><a href="{{ route('blog-sidebar-2') }}">Blog Sidebar 2</a></li>
                        <li><a href="{{ route('blog-standard') }}">Blog Standard</a></li>
                        <li><a href="{{ route('blog-details') }}">Blog Details</a></li>
                    </ul>
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
                            <div class="dropdown">
                                <a href="#" class="d-inline-flex align-items-center" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fa-regular fa-id-badge me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="fa-regular fa-heart me-2"></i>Favorites</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('signin') }}"><i class="fa-regular fa-right-to-bracket me-2"></i>Sign in</a></li>
                                </ul>
                            </div>
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
                                            <li class="menu-item-has-children">
                                                <a href="{{ route('home') }}">Home</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('home') }}">Home 1</a></li>
                                                    <li><a href="#">Home 2</a></li>
                                                    <li><a href="#">Home 3</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="{{ route('shop') }}">Shop</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('shop') }}">Shop</a></li>
                                                    <li><a href="{{ route('shop-sidebar') }}">Shop Sidebar</a></li>
                                                    <li><a href="{{ route('shop-details') }}">Shop Details</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="{{ route('vendor') }}">Vendor</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('vendor') }}">Vendor</a></li>
                                                    <li><a href="{{ route('vendor-details') }}">Vendor Details</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children mega-menu-wrap">
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
                                                            <li><a href="{{ route('shop-details') }}">Shop Details</a></li>
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
                                            <li class="menu-item-has-children">
                                                <a href="{{ route('blog') }}">Blog</a>
                                                <ul class="sub-menu">
                                                    <li><a href="{{ route('blog') }}">Blog</a></li>
                                                    <li><a href="{{ route('blog-sidebar') }}">Blog Sidebar</a></li>
                                                    <li><a href="{{ route('blog-sidebar-2') }}">Blog Sidebar 2</a></li>
                                                    <li><a href="{{ route('blog-standard') }}">Blog Standard</a></li>
                                                    <li><a href="{{ route('blog-details') }}">Blog Details</a></li>
                                                </ul>
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
                                <a href="{{ route('cart') }}" class="vs-icon has-badge"><i class="fa-solid fa-basket-shopping"></i><span class="badge">0</span></a>
                                <div class="woocommerce widget_shopping_cart">
                                    <div class="widget_shopping_cart_content">
                                        <ul class="cart_list">
                                            <li class="mini_cart_item">
                                                <a href="#" class="remove"><i class="far fa-times"></i></a>
                                                <a href="{{ route('shop-details') }}" class="img"><img src="{{ asset('assets/img/cart/cat-img-1.jpg') }}" alt="Cart Image"></a>
                                                <a href="{{ route('shop-details') }}" class="product-title">Smart Watch</a>
                                                <span class="amount">$99.00</span>
                                                <div class="quantity">
                                                    <button class="quantity-minus qut-btn"><i class="far fa-minus"></i></button>
                                                    <input type="number" class="qty-input" value="1" min="1" max="99">
                                                    <button class="quantity-plus qut-btn"><i class="far fa-plus"></i></button>
                                                </div>
                                                <div class="subtotal">
                                                    <span>Subtotal:</span>
                                                    <span class="amount">$99.00</span>
                                                </div>
                                            </li>
                                            <li class="mini_cart_item">
                                                <a href="#" class="remove"><i class="far fa-times"></i></a>
                                                <a href="{{ route('shop-details') }}" class="img"><img src="{{ asset('assets/img/cart/cat-img-2.jpg') }}" alt="Cart Image"></a>
                                                <a href="{{ route('shop-details') }}" class="product-title">Boss Chair</a>
                                                <span class="amount">$80.00</span>
                                                <div class="quantity">
                                                    <button class="quantity-minus qut-btn"><i class="far fa-minus"></i></button>
                                                    <input type="number" class="qty-input" value="2" min="1" max="99">
                                                    <button class="quantity-plus qut-btn"><i class="far fa-plus"></i></button>
                                                </div>
                                                <div class="subtotal">
                                                    <span>Subtotal:</span>
                                                    <span class="amount">$160.00</span>
                                                </div>
                                            </li>
                                        </ul>
                                        <p class="total">
                                            <strong>Subtotal:</strong>
                                            <span class="amount">$259.00</span>
                                        </p>
                                        <p class="buttons">
                                            <a href="{{ route('cart') }}" class="vs-btn">View cart</a>
                                            <a href="{{ route('checkout') }}" class="vs-btn checkout">Checkout</a>
                                        </p>
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