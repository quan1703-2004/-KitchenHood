<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm (cho customer)
    public function index(Request $request)
    {
        $query = Product::with('category');
        
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
        return view('customer.products.show', compact('product'));
    }

    // === CÁC CHỨC NĂNG ADMIN ===
    
    // Hiển thị danh sách sản phẩm (cho admin)
    public function adminIndex()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }
    
    // Hiển thị form tạo sản phẩm
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        // Đặt giá trị mặc định cho quantity nếu không có
        if (!isset($data['quantity'])) {
            $data['quantity'] = 0;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh mới
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        // Đặt giá trị mặc định cho quantity nếu không có
        if (!isset($data['quantity'])) {
            $data['quantity'] = 0;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    // Xóa sản phẩm
    public function destroy(Product $product)
    {
        // Xóa hình ảnh nếu có
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa!');
    }
}