<?php

// app/Http/Controllers/Admin/ReviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các đánh giá.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Xóa một đánh giá khỏi cơ sở dữ liệu.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Đã xóa đánh giá thành công.');
    }
}