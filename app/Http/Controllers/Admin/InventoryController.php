<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryTransaction;
use App\Exports\InventoryExport;
use App\Exports\TransactionHistoryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Hiển thị trang quản lý tồn kho
     */
    public function index()
    {
        $products = Product::with('category')
            ->withCount(['inventoryTransactions as total_transactions'])
            ->orderBy('quantity', 'asc')
            ->paginate(15);

        // Thống kê tổng quan
        $stats = [
            'total_products' => Product::count(),
            'out_of_stock' => Product::where('quantity', 0)->count(),
            'low_stock' => Product::where('quantity', '>', 0)->where('quantity', '<=', 10)->count(),
            'in_stock' => Product::where('quantity', '>', 10)->count(),
        ];

        return view('admin.inventory.index', compact('products', 'stats'));
    }

    /**
     * Xuất báo cáo tồn kho
     */
    

    /**
     * Hiển thị trang nhập hàng cho sản phẩm
     */
    public function show(Product $product)
    {
        $product->load(['category', 'inventoryTransactions' => function($query) {
            $query->with(['user', 'order'])->latest()->limit(20);
        }]);

        return view('admin.inventory.show', compact('product'));
    }

    /**
     * Xử lý nhập hàng
     */
    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $product->addStock(
                $request->quantity,
                $request->notes,
                auth()->id()
            );

            DB::commit();

            return redirect()->route('admin.inventory.show', $product)
                ->with('success', "Đã nhập {$request->quantity} sản phẩm cho {$product->name}");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi nhập hàng: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị lịch sử giao dịch tồn kho
     */
    public function history(Request $request)
    {
        $query = InventoryTransaction::with(['product', 'user', 'order']);

        // Lọc theo sản phẩm
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Lọc theo loại giao dịch
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Lọc theo ngày
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(20);
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.history', compact('transactions', 'products'));
    }

    /**
     * Xuất báo cáo tồn kho
     */
    public function export(Request $request)
    {
        // Sử dụng lớp InventoryExport trả về mảng ['file','name'] để tải xuống
        try {
            $export = new InventoryExport();
            $result = $export->export();
            
            return response()
                ->download($result['file'], $result['name'])
                ->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xuất báo cáo: ' . $e->getMessage());
        }
    }

    /**
     * Xuất báo cáo lịch sử giao dịch
     */
    public function exportHistory(Request $request)
    {
        try {
            $filters = $request->only(['product_id', 'type', 'date_from', 'date_to']);
            
            $export = new TransactionHistoryExport();
            $filepath = $export->export($filters);
            
            $filename = basename($filepath);
            
            return response()->download($filepath, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ])->deleteFileAfterSend();
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xuất báo cáo: ' . $e->getMessage());
        }
    }
}
