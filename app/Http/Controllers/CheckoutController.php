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
            'payment_method' => 'required|in:cod,bank_transfer',
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
            // Tạo đơn hàng mới sử dụng thông tin từ địa chỉ đã lưu
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'customer_name' => $address->full_name,
                'customer_email' => Auth::user()->email,
                'customer_phone' => $address->phone,
                'customer_address' => $address->full_address,
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
