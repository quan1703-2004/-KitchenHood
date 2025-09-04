<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm (cho customer)
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews']);
        
        // Lọc theo danh mục nếu có
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->paginate(12);
        $categories = \App\Models\Category::all();
        
        return view('customer.products.index', compact('products', 'categories'));
    }

    // Hiển thị chi tiết sản phẩm (cho customer)
    public function show(Product $product)
    {
        // Load reviews với user để hiển thị đánh giá
        $product->load(['reviews.user', 'category']);
        
        return view('customer.products.show', compact('product'));
    }
}