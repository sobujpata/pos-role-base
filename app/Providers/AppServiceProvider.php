<?php
namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();
        // View::composer('*', function ($view) {
        //     $cart = json_decode(Cookie::get('cart'), true) ?? [];
        //     $totalCartCount = collect($cart)->sum('quantity'); // total quantity
        //     $subtotal = collect($cart)->sum(function ($item) {
        //         return $item['price'] * $item['quantity'];
        //     }); // total price
        //     $view->with('totalCartCount', $totalCartCount)->with('cart', $cart)->with('subtotal', $subtotal);
        // });
        View::composer('*', function ($view) {
            $cart = json_decode(Cookie::get('cart'), true) ?? [];

            $totalCartCount = collect($cart)->sum(function ($item) {
                return (int) $item['quantity'];
            });

            $subtotal = collect($cart)->sum(function ($item) {
                return (float) $item['price'] * (int) $item['quantity'];
            });

            $view->with('totalCartCount', $totalCartCount)
                ->with('cart', $cart)
                ->with('subtotal', $subtotal);
        });

    }
}
