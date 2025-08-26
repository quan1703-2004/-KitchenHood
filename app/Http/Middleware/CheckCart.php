<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use Symfony\Component\HttpFoundation\Response;

class CheckCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $empty = true;
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $count = CartItem::where('cart_id', $cart->id)->sum('quantity');
            $empty = $count <= 0;
        }

        if ($empty) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống! Vui lòng thêm sản phẩm trước khi thanh toán.');
        }
        
        return $next($request);
    }
}
