<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Trang xử lý QR Code thanh toán
    public function qrCode(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Lấy thông tin QR Code từ database
        $qrPaymentMethod = PaymentMethod::where('type', 'qr_code')
            ->where('is_active', true)
            ->first();

        if (!$qrPaymentMethod) {
            return redirect()->back()->with('error', 'Phương thức thanh toán QR Code không khả dụng');
        }

        return view('customer.payment.qr-code', compact('order', 'qrPaymentMethod'));
    }

    // Trang xử lý Momo thanh toán
    public function momo(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Lấy thông tin Momo từ database
        $momoPaymentMethod = PaymentMethod::where('type', 'momo')
            ->where('is_active', true)
            ->first();

        if (!$momoPaymentMethod) {
            return redirect()->back()->with('error', 'Phương thức thanh toán Momo không khả dụng');
        }

        return view('customer.payment.momo', compact('order', 'momoPaymentMethod'));
    }

    // Xác nhận thanh toán QR Code
    public function confirmQrCode(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $request->validate([
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        // Cập nhật trạng thái đơn hàng
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'notes' => $order->notes . "\n[QR Code] Mã giao dịch: " . $request->transaction_id,
        ]);

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Xác nhận thanh toán thành công!');
    }

    // Xác nhận thanh toán Momo
    public function confirmMomo(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $request->validate([
            'transaction_id' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        // Cập nhật trạng thái đơn hàng
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'notes' => $order->notes . "\n[Momo] Mã giao dịch: " . $request->transaction_id,
        ]);

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Xác nhận thanh toán Momo thành công!');
    }

    // Hủy thanh toán
    public function cancel(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Cập nhật trạng thái đơn hàng
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed', // Sử dụng 'failed' thay vì 'cancelled'
        ]);

        return redirect()->route('cart.index')
            ->with('error', 'Đã hủy thanh toán. Vui lòng thử lại.');
    }
}
