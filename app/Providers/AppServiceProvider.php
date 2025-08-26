<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

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
        // View composer: hiển thị số lượng sản phẩm trong giỏ theo user
        View::composer('layouts.customer', function ($view) {
            $count = 0;
            if (Auth::check()) {
                $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
                $count = CartItem::where('cart_id', $cart->id)->sum('quantity');
            }
            $view->with('cartCount', $count);
        });
    }
}
