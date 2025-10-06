<?php

// app/Http/Controllers/Admin/ReviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Exports\ReviewsExport;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Xuất báo cáo đánh giá
     */
    public function export()
    {
        $export = new ReviewsExport();
        $result = $export->export();
        return response()->download($result['file'], $result['name'])->deleteFileAfterSend(true);
    }

    /**
     * Admin trả lời đánh giá
     */
    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:2000',
        ], [
            'reply.required' => 'Vui lòng nhập nội dung phản hồi',
        ]);

        // cập nhật phản hồi và thời gian
        $review->update([
            'admin_reply' => $validated['reply'],
            'admin_replied_at' => now(),
        ]);

        return back()->with('success', 'Đã gửi phản hồi cho đánh giá.');
    }
}