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
        
        // Tìm kiếm theo từ khóa
        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                      $categoryQuery->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }
        
        // Lọc theo danh mục nếu có
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Sắp xếp theo yêu cầu
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12)->appends($request->query());
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