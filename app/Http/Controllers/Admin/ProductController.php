<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Tạo tên file ảnh ngắn gọn và duy nhất
     * - Định dạng: prd_{YmdHis}_{rand6}.{ext}
     * - Dùng cho tất cả ảnh sản phẩm để tránh tên quá dài
     */
    private function makeShortImageName(string $extension): string
    {
        // tạo chuỗi ngắn tránh trùng lặp (timestamp + random)
        $timestamp = now()->format('YmdHis');
        $random = Str::lower(Str::random(6));
        return "prd_{$timestamp}_{$random}.{$extension}";
    }
    // Hiển thị danh sách sản phẩm (cho admin)
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'specs' => 'nullable|array',
            'specs.*.key' => 'required_with:specs|string|max:255',
            'specs.*.value' => 'required_with:specs|string|max:255',
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh chính (đặt tên file ngắn)
        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $this->makeShortImageName($ext);
            // lưu vào disk public/products với tên ngắn
            $path = $request->file('image')->storeAs('products', $filename, 'public');
            $data['image'] = $path;
        }
        
        // Xử lý upload hình ảnh phụ 1 (đặt tên file ngắn)
        if ($request->hasFile('image2')) {
            $ext = $request->file('image2')->getClientOriginalExtension();
            $filename = $this->makeShortImageName($ext);
            $path = $request->file('image2')->storeAs('products', $filename, 'public');
            $data['image2'] = $path;
        }
        
        // Xử lý upload hình ảnh phụ 2 (đặt tên file ngắn)
        if ($request->hasFile('image3')) {
            $ext = $request->file('image3')->getClientOriginalExtension();
            $filename = $this->makeShortImageName($ext);
            $path = $request->file('image3')->storeAs('products', $filename, 'public');
            $data['image3'] = $path;
        }
        
        // Đặt giá trị mặc định cho quantity nếu không có
        if (!isset($data['quantity'])) {
            $data['quantity'] = 0;
        }

        // Tạo sản phẩm
        $product = Product::create($data);
        
        // Lưu chi tiết sản phẩm nếu có
        if ($request->has('specs') && !empty($request->specs)) {
            $specs = collect($request->specs)->filter(function($spec) {
                return !empty($spec['key']) && !empty($spec['value']);
            })->values()->toArray();
            
            if (!empty($specs)) {
                ProductDetail::create([
                    'product_id' => $product->id,
                    'specs' => $specs
                ]);
            }
        }
        
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail'); // Load chi tiết sản phẩm
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'specs' => 'nullable|array',
            'specs.*.key' => 'required_with:specs|string|max:255',
            'specs.*.value' => 'required_with:specs|string|max:255',
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh chính mới (đặt tên file ngắn)
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $ext = $request->file('image')->getClientOriginalExtension();
            $filename = $this->makeShortImageName($ext);
            $path = $request->file('image')->storeAs('products', $filename, 'public');
            $data['image'] = $path;
        }
        
        // Xử lý upload hình ảnh phụ 1 mới (đặt tên file ngắn)
        if ($request->hasFile('image2')) {
            // Xóa hình ảnh cũ nếu có
            if ($product->image2) {
                Storage::disk('public')->delete($product->image2);
            }

            $ext = $request->file('image2')->getClientOriginalExtension();
            $filename = $this->makeShortImageName($ext);
            $path = $request->file('image2')->storeAs('products', $filename, 'public');
            $data['image2'] = $path;
        }
        
        // Xử lý upload hình ảnh phụ 2 mới (đặt tên file ngắn)
        if ($request->hasFile('image3')) {
            // Xóa hình ảnh cũ nếu có
            if ($product->image3) {
                Storage::disk('public')->delete($product->image3);
            }

            $ext = $request->file('image3')->getClientOriginalExtension();
            $filename = $this->makeShortImageName($ext);
            $path = $request->file('image3')->storeAs('products', $filename, 'public');
            $data['image3'] = $path;
        }
        
        // Đặt giá trị mặc định cho quantity nếu không có
        if (!isset($data['quantity'])) {
            $data['quantity'] = 0;
        }

        // Cập nhật sản phẩm
        $product->update($data);
        
        // Cập nhật chi tiết sản phẩm
        if ($request->has('specs') && !empty($request->specs)) {
            $specs = collect($request->specs)->filter(function($spec) {
                return !empty($spec['key']) && !empty($spec['value']);
            })->values()->toArray();
            
            if (!empty($specs)) {
                // Cập nhật hoặc tạo mới chi tiết
                $product->detail()->updateOrCreate(
                    ['product_id' => $product->id],
                    ['specs' => $specs]
                );
            } else {
                // Xóa chi tiết nếu không có specs
                $product->detail()->delete();
            }
        } else {
            // Xóa chi tiết nếu không có specs
            $product->detail()->delete();
        }
        
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    // Xóa sản phẩm
    public function destroy(Product $product)
    {
        // Xóa tất cả hình ảnh nếu có
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->image2) {
            Storage::disk('public')->delete($product->image2);
        }
        if ($product->image3) {
            Storage::disk('public')->delete($product->image3);
        }
        
        // Xóa chi tiết sản phẩm (cascade sẽ tự động xóa)
        $product->detail()->delete();
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa!');
    }
}
