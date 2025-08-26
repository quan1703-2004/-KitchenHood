<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Hiển thị danh sách tin tức
     */
    public function index(Request $request)
    {
        $query = News::published()->latest();
        
        // Lọc theo danh mục
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }
        
        // Sắp xếp
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'featured':
                    $query->featured();
                    break;
                default:
                    $query->latest();
            }
        }
        
        $news = $query->paginate(6);
        
        // Lấy tin nổi bật cho sidebar
        $featuredNews = News::published()->featured()->take(3)->get();
        
        return view('customer.news.index', compact('news', 'featuredNews'));
    }
    
    /**
     * Hiển thị chi tiết tin tức
     */
    public function show($slug)
    {
        $news = News::published()->where('slug', $slug)->firstOrFail();
        
        // Tăng lượt xem
        $news->incrementViews();
        
        // Lấy tin liên quan
        $relatedNews = News::published()
            ->where('category', $news->category)
            ->where('id', '!=', $news->id)
            ->take(3)
            ->get();
        
        // Lấy tin nổi bật
        $featuredNews = News::published()->featured()->take(3)->get();
        
        return view('customer.news.show', compact('news', 'relatedNews', 'featuredNews'));
    }
}
