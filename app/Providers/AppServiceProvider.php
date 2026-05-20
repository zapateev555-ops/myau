<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
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
        View::composer('shop.layouts.app', function ($view) {
            $cartItemsCount = 0;

            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->with('items')->first();
                $cartItemsCount = $cart?->items->sum('quantity') ?? 0;
            }

            $view->with('cartItemsCount', $cartItemsCount);
        });
    }
}
