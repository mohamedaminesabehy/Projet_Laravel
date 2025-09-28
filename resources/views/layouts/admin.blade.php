<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicons/favicon.svg') }}" type="image/svg+xml">
    
    <!-- Base CSS from app.blade.php -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style/custom.css') }}">
    
    <!-- Admin Specific CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    
    <!-- Page Specific CSS -->
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="Admin Logo" class="img-fluid">
            </div>
            <div class="sidebar-menu">
                <p class="menu-title">Menu Principal</p>
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
                
                <div class="menu-divider"></div>
                <p class="menu-title">Gestion Catalogue</p>
                
                <a href="{{ route('admin.books.index') }}" class="menu-item {{ request()->routeIs('admin.books.index') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Livres</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="menu-item {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Catégories</span>
                </a>
                
                <div class="menu-divider"></div>
                <p class="menu-title">Gestion Commerciale</p>
                
                <a href="{{ route('admin.orders') }}" class="menu-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Commandes</span>
                </a>
                
                <a href="{{ route('admin.events.index') }}" class="menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Événements</span>
                </a>

                <a href="{{ route('admin.exchanges') }}" class="menu-item {{ request()->routeIs('admin.exchanges') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Échanges</span>
                </a>
                <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                
                <div class="menu-divider"></div>
                <p class="menu-title">Configuration</p>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <button class="toggle-sidebar" id="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="topbar-title">@yield('title', 'Tableau de bord')</h4>
                
                <div class="topbar-right">
                    <div class="notification-bell">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="user-dropdown" id="user-dropdown-toggle">
                        <div class="user-avatar">
                            <span>{{ Auth::user()->first_name[0] ?? 'A' }}</span>
                        </div>
                        <div class="user-name">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Admin' }}
                        </div>
                        <div class="user-menu" id="user-menu-dropdown">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} BookStore. Tous droits réservés.</p>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Base Scripts from app.blade.php -->
    <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap-scroll-to-plugin.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/SplitText.js') }}"></script>
    <script src="{{ asset('assets/js/lenis.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!-- Admin Specific Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Inline Admin Scripts -->
    <script>
        // Toggle Sidebar
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('main-content').classList.toggle('expanded');
            document.getElementById('sidebar-overlay').classList.toggle('active');
        });
        
        // Close Sidebar on Overlay Click
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('collapsed');
            document.getElementById('sidebar-overlay').classList.remove('active');
        });
        
        // Initialize Toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };
        
        // Flash Messages
        var successMsg = "{{ session('success') }}";
        var errorMsg = "{{ session('error') }}";
        var infoMsg = "{{ session('info') }}";
        var warningMsg = "{{ session('warning') }}";
        
        // Afficher les messages s'ils existent
        if (successMsg) toastr.success(successMsg);
        if (errorMsg) toastr.error(errorMsg);
        if (infoMsg) toastr.info(infoMsg);
        if (warningMsg) toastr.warning(warningMsg);
    </script>
    
    <!-- Admin Scripts -->
    <script src="{{ asset('js/admin-scripts.js') }}"></script>
    
    <!-- CKEDITOR Script -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <!-- Page Specific Scripts -->
    @yield('scripts')
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userDropdownToggle = document.getElementById('user-dropdown-toggle');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');

            if (userDropdownToggle && userMenuDropdown) {
                userDropdownToggle.addEventListener('click', function() {
                    userMenuDropdown.classList.toggle('show');
                });

                // Close the dropdown if the user clicks outside of it
                window.addEventListener('click', function(event) {
                    if (!userDropdownToggle.contains(event.target) && !userMenuDropdown.contains(event.target)) {
                        userMenuDropdown.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>