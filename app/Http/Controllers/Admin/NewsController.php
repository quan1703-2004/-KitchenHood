<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Hiển thị danh sách tin tức
     */
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Hiển thị form tạo tin tức mới
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Lưu tin tức mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $data['image'] = $imagePath;
        }

        // Tạo slug từ title
        $data['slug'] = Str::slug($request->title);

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa tin tức
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Cập nhật tin tức
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh mới
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            
            $imagePath = $request->file('image')->store('news', 'public');
            $data['image'] = $imagePath;
        }

        // Cập nhật slug nếu title thay đổi
        if ($news->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được cập nhật thành công!');
    }

    /**
     * Xóa tin tức
     */
    public function destroy(News $news)
    {
        // Xóa hình ảnh nếu có
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được xóa thành công!');
    }
}
