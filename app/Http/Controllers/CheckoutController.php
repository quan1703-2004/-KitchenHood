<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = CartItem::with('product.category')
            ->where('cart_id', $cart->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $cartItems = [];
        $total = 0;
        $shippingFee = 0;

        foreach ($items as $item) {
            if ($item->product) {
                $line = $item->product->price * $item->quantity;
                $cartItems[] = [
                    'product' => $item->product,
                    'quantity' => $item->quantity,
                    'subtotal' => $line,
                ];
                $total += $line;
            }
        }

        if ($total < 5000000) {
            $shippingFee = 50000; // 50,000 VNĐ
        }

        $finalTotal = $total + $shippingFee;

        return view('customer.checkout.index', compact('cartItems', 'total', 'shippingFee', 'finalTotal'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        
        try {
            // Tạo đơn hàng mới
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'status' => 'pending',
                'total_amount' => 0,
                'shipping_fee' => 0,
                'final_amount' => 0
            ]);
            
            $total = 0;
            $shippingFee = 0;
            
            // Tạo các mục đơn hàng
            foreach ($items as $ci) {
                $product = $ci->product;
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price,
                        'quantity' => $ci->quantity,
                        'subtotal' => $product->price * $ci->quantity
                    ]);
                    $total += $product->price * $ci->quantity;
                }
            }
            
            // Tính phí vận chuyển
            if ($total < 5000000) {
                $shippingFee = 50000;
            }
            
            $finalAmount = $total + $shippingFee;
            
            // Cập nhật tổng tiền đơn hàng
            $order->update([
                'total_amount' => $total,
                'shipping_fee' => $shippingFee,
                'final_amount' => $finalAmount
            ]);
            
            // Xóa giỏ hàng DB
            CartItem::where('cart_id', $cart->id)->delete();
            
            return redirect()->route('checkout.success', $order->id)
                           ->with('success', 'Đặt hàng thành công!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!')
                           ->withInput();
        }
    }

    /**
     * Trang thành công sau khi đặt hàng
     */
    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('customer.checkout.success', compact('order'));
    }
}
