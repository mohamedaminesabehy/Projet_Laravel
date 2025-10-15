<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Router;
use App\Http\Controllers\CartController;
use App\Http\Middleware\CheckRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register middleware alias for role-based access control
        /** @var Router $router */
        $router = $this->app['router'];
        $router->aliasMiddleware('role', CheckRole::class);

        // Share cart count with header
        View::composer('partials.header', function ($view) {
            $cartController = new CartController();
            $cartCount = $cartController->getCartCount();
            $view->with('cartCount', $cartCount);
        });
    }
}
