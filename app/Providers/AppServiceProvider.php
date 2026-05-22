<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            if (config('database.default') === 'sqlite') {
                throw new RuntimeException(
                    'На Railway нужен PostgreSQL: DB_CONNECTION=pgsql и DB_URL (см. railway.env.example).'
                );
            }

            URL::forceScheme('https');
        }

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
