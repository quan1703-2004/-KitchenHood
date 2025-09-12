<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Address;

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

        // Lấy danh sách địa chỉ của user
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        $defaultAddress = Auth::user()->getDefaultAddress();

        return view('customer.checkout.index', compact('cartItems', 'total', 'shippingFee', 'finalTotal', 'addresses', 'defaultAddress'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,bank_transfer,momo',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Kiểm tra quyền sở hữu địa chỉ
        $address = Address::where('id', $request->address_id)
                         ->where('user_id', Auth::id())
                         ->first();
        
        if (!$address) {
            return redirect()->back()->with('error', 'Địa chỉ không hợp lệ!');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        
        try {
            // Tính toán tổng tiền trước khi tạo đơn hàng
            $total = 0;
            foreach ($items as $ci) {
                $product = $ci->product;
                if ($product) {
                    $total += $product->price * $ci->quantity;
                }
            }
            
            // Tính phí vận chuyển
            $shippingFee = 0;
            if ($total < 5000000) {
                $shippingFee = 50000;
            }
            
            $finalAmount = $total + $shippingFee;
            
            // Tạo đơn hàng mới với tổng tiền đã tính
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'subtotal' => $total,
                'shipping_fee' => $shippingFee,
                'total_amount' => $finalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'shipping_address' => $address->full_address,
                'shipping_province_id' => $address->province_id,
                'shipping_province_name' => $address->province_name,
                'shipping_district_id' => $address->district_id,
                'shipping_district_name' => $address->district_name,
                'shipping_ward_id' => $address->ward_id,
                'shipping_ward_name' => $address->ward_name,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);
            
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
                }
            }
            
            // Xóa giỏ hàng DB
            CartItem::where('cart_id', $cart->id)->delete();
            
            // Xử lý chuyển hướng theo phương thức thanh toán
            if ($request->payment_method === 'cod') {
                return redirect()->route('checkout.success', $order->id)
                               ->with('success', 'Đặt hàng thành công!');
            } elseif ($request->payment_method === 'bank_transfer') {
                return redirect()->route('payment.qr-code', $order->id);
            } elseif ($request->payment_method === 'momo') {
                return redirect()->route('payment.momo', $order->id);
            }
                           
        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
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

