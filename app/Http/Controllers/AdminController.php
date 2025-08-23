<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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
        
        // Load dữ liệu mới nhất để hiển thị
        $latestProducts = Product::with('category')->latest()->take(5)->get();
        $latestCategories = Category::withCount('products')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalCategories', 
            'totalProducts', 
            'totalUsers',
            'latestProducts',
            'latestCategories'
        ));
    }
}