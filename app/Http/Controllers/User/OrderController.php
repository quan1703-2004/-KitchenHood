<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của user
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['orderItems.product.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.product.category', 'orderItems.product']);
        
        return view('customer.orders.show', compact('order'));
    }

    /**
     * Hủy đơn hàng
     */
    public function cancel(Order $order)
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy đơn hàng này'
            ], 403);
        }

        // Chỉ cho phép hủy đơn hàng đang chờ xử lý
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể hủy đơn hàng đang chờ xử lý'
            ], 400);
        }

        try {
            $order->update(['status' => 'cancelled']);
            
            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng'
            ], 500);
        }
    }

    /**
     * Tải lại đơn hàng (reorder)
     */
    public function reorder(Order $order)
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này'
            ], 403);
        }

        try {
            // Thêm các sản phẩm từ đơn hàng cũ vào giỏ hàng
            $cart = Auth::user()->cart;
            
            if (!$cart) {
                $cart = Auth::user()->cart()->create();
            }

            foreach ($order->orderItems as $item) {
                // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
                $existingItem = $cart->items()->where('product_id', $item->product_id)->first();
                
                if ($existingItem) {
                    // Cập nhật số lượng
                    $existingItem->update([
                        'quantity' => $existingItem->quantity + $item->quantity
                    ]);
                } else {
                    // Thêm mới vào giỏ hàng
                    $cart->items()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->unit_price
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'redirect' => route('cart.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm vào giỏ hàng'
            ], 500);
        }
    }

    /**
     * Tải xuống hóa đơn PDF
     */
    public function downloadInvoice(Order $order)
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // TODO: Implement PDF generation
        return response()->json([
            'success' => false,
            'message' => 'Tính năng này đang được phát triển'
        ]);
    }

    /**
     * Đánh giá đơn hàng
     */
    public function review(Order $order)
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Chỉ cho phép đánh giá đơn hàng đã giao
        if ($order->status !== 'delivered') {
            return redirect()->route('orders.index')->with('error', 'Chỉ có thể đánh giá đơn hàng đã giao');
        }

        return view('customer.orders.review', compact('order'));
    }

    /**
     * Lưu đánh giá đơn hàng
     */
    public function storeReview(Request $request, Order $order)
    {
        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        try {
            $order->update([
                'rating' => $request->rating,
                'review_comment' => $request->comment,
                'reviewed_at' => now()
            ]);

            return redirect()->route('orders.index')->with('success', 'Đánh giá đã được lưu thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi lưu đánh giá');
        }
    }
}
