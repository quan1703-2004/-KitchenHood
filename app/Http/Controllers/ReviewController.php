<?php

// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tối đa 2MB mỗi ảnh
        ], [
            'rating.required' => 'Vui lòng chọn điểm đánh giá',
            'rating.min' => 'Điểm đánh giá phải từ 1 đến 5 sao',
            'rating.max' => 'Điểm đánh giá phải từ 1 đến 5 sao',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ]);

        // Kiểm tra xem người dùng đã mua sản phẩm này chưa
        $hasPurchased = Auth::user()->orders()
            ->where('status', 'delivered') // Chỉ tính đơn hàng đã giao thành công
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua.');
        }

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
        $existingReview = $product->reviews()->where('user_id', Auth::id())->first();
        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Xử lý upload hình ảnh
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $imagePaths[] = $path;
            }
        }

        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá!');
    }
}
