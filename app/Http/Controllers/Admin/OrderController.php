<?php

// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Hiển thị danh sách tất cả đơn hàng
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết một đơn hàng
    public function show(Order $order)
    {
        // Tải thêm thông tin về các mục hàng và sản phẩm tương ứng
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Nếu chuyển từ pending sang processing và thanh toán thành công
        if ($oldStatus === 'pending' && $newStatus === 'processing' && $order->payment_status === 'paid') {
            // Trừ tồn kho cho tất cả sản phẩm trong đơn hàng
            foreach ($order->items as $item) {
                try {
                    $item->product->reduceStock(
                        $item->quantity,
                        "Xuất hàng cho đơn hàng #{$order->order_number}",
                        $order->id,
                        auth()->id()
                    );
                } catch (\Exception $e) {
                    // Nếu không đủ hàng, rollback trạng thái đơn hàng
                    return redirect()->back()->with('error', "Không đủ hàng cho sản phẩm: {$item->product->name}. Chỉ còn {$item->product->quantity} sản phẩm.");
                }
            }
        }

        // Nếu hủy đơn hàng và đã trừ tồn kho trước đó
        if ($newStatus === 'cancelled' && in_array($oldStatus, ['processing', 'shipped', 'delivered'])) {
            // Hoàn lại tồn kho cho tất cả sản phẩm trong đơn hàng
            foreach ($order->items as $item) {
                $item->product->addStock(
                    $item->quantity,
                    "Hoàn lại hàng do hủy đơn hàng #{$order->order_number}",
                    auth()->id()
                );
            }
        }

        $order->status = $newStatus;
        $order->save();

        $statusMessage = $newStatus === 'cancelled' ? 'Đã hủy đơn hàng' : 'Cập nhật trạng thái đơn hàng';
        return redirect()->route('admin.orders.show', $order)->with('success', $statusMessage . ' thành công!');
    }
}