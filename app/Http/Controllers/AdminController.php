<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\News;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Hiển thị dashboard admin với thống kê tổng quan
     */
    public function dashboard()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalNews = News::count();
        $publishedNews = News::where('is_published', true)->count();
        $featuredNews = News::where('is_featured', true)->count();
        
        // Load dữ liệu mới nhất để hiển thị
        $recentProducts = Product::with('category')->latest()->take(5)->get();
        $recentCategories = Category::withCount('products')->latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalCategories', 
            'totalProducts', 
            'totalUsers',
            'totalNews',
            'publishedNews',
            'featuredNews',
            'recentProducts',
            'recentCategories',
            'recentNews'
        ));
    }

    /**
     * Hiển thị danh sách danh mục cho admin
     */
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị danh sách sản phẩm cho admin
     */
    public function products()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Hiển thị danh sách người dùng cho admin
     */
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }
}