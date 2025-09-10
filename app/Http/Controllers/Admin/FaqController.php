<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Hiển thị danh sách FAQ với phân trang và sắp xếp theo sort_order
     */
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->paginate(15);
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Form tạo mới FAQ
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Lưu FAQ mới vào CSDL
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'required|integer',
            'is_visible' => 'nullable|boolean',
        ]);

        // Chuẩn hoá is_visible theo checkbox (có -> true, không -> false)
        $validated['is_visible'] = $request->has('is_visible');

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'Tạo FAQ thành công!');
    }

    /**
     * Form chỉnh sửa FAQ
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Cập nhật FAQ
     */
    public function update(Request $request, Faq $faq)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'required|integer',
            'is_visible' => 'nullable|boolean',
        ]);

        // Chuẩn hoá is_visible theo checkbox
        $validated['is_visible'] = $request->has('is_visible');

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'Cập nhật FAQ thành công!');
    }

    /**
     * Xoá FAQ
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'Xóa FAQ thành công!');
    }
}


