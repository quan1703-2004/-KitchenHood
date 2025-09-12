<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::ordered()->get();
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:qr_code,momo',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'momo_phone' => 'nullable|string|max:20',
            'momo_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        
        // Xử lý upload ảnh QR Code
        if ($request->hasFile('qr_code_image')) {
            $data['qr_code_image'] = $request->file('qr_code_image')->store('payment-methods', 'public');
        }

        // Xử lý checkbox
        $data['is_active'] = $request->has('is_active');

        PaymentMethod::create($data);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Tạo phương thức thanh toán thành công!');
    }

    public function show(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.show', compact('paymentMethod'));
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'type' => 'required|in:qr_code,momo',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'momo_phone' => 'nullable|string|max:20',
            'momo_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        
        // Xử lý upload ảnh QR Code
        if ($request->hasFile('qr_code_image')) {
            // Xóa ảnh cũ nếu có
            if ($paymentMethod->qr_code_image) {
                Storage::disk('public')->delete($paymentMethod->qr_code_image);
            }
            $data['qr_code_image'] = $request->file('qr_code_image')->store('payment-methods', 'public');
        }

        // Xử lý checkbox
        $data['is_active'] = $request->has('is_active');

        $paymentMethod->update($data);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Cập nhật phương thức thanh toán thành công!');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        // Xóa ảnh nếu có
        if ($paymentMethod->qr_code_image) {
            Storage::disk('public')->delete($paymentMethod->qr_code_image);
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Xóa phương thức thanh toán thành công!');
    }
}
