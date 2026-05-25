<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('shop.layouts.app', function ($view) {
            $cartItemsCount = 0;

            if (Auth::check()) {
                $cartItemsCount = (int) Cart::query()
                    ->where('user_id', Auth::id())
                    ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
                    ->sum('cart_items.quantity');
            }

            $view->with([
                'cartItemsCount' => $cartItemsCount,
            ]);
        });
    }
}
