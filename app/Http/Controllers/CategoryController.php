<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục (cho customer)
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('customer.categories.index', compact('categories'));
    }
}