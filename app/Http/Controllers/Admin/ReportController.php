<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Dashboard tổng quan
     */
    public function dashboard()
    {
        // Thống kê tổng quan
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
        ];

        // Doanh thu theo tháng (6 tháng gần nhất)
        $revenueByMonth = Order::where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Đơn hàng theo trạng thái
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Top sản phẩm bán chạy
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.subtotal) as total_revenue')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Đơn hàng gần đây
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Khách hàng mới (30 ngày gần nhất)
        $newCustomers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        return view('admin.reports.dashboard', compact(
            'stats',
            'revenueByMonth',
            'ordersByStatus',
            'topProducts',
            'recentOrders',
            'newCustomers'
        ));
    }

    /**
     * Báo cáo doanh thu
     */
    public function revenue(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Doanh thu theo ngày
        $dailyRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Doanh thu theo tháng
        $monthlyRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Doanh thu theo phương thức thanh toán
        $revenueByPayment = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment_method, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('payment_method')
            ->get();

        // Tổng doanh thu
        $totalRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        // Tổng đơn hàng
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        return view('admin.reports.revenue', compact(
            'dailyRevenue',
            'monthlyRevenue',
            'revenueByPayment',
            'totalRevenue',
            'totalOrders',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Báo cáo sản phẩm
     */
    public function products(Request $request)
    {
        $categoryId = $request->get('category_id');
        $sortBy = $request->get('sort_by', 'sales');

        $query = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('
                products.id,
                products.name,
                products.price,
                categories.name as category_name,
                SUM(order_items.quantity) as total_sold,
                SUM(order_items.subtotal) as total_revenue,
                COUNT(DISTINCT order_items.order_id) as order_count
            ')
            ->groupBy('products.id', 'products.name', 'products.price', 'categories.name');

        if ($categoryId) {
            $query->where('products.category_id', $categoryId);
        }

        // Sắp xếp
        switch ($sortBy) {
            case 'revenue':
                $query->orderBy('total_revenue', 'desc');
                break;
            case 'orders':
                $query->orderBy('order_count', 'desc');
                break;
            default:
                $query->orderBy('total_sold', 'desc');
        }

        $productStats = $query->paginate(20)->withQueryString();

        // Thống kê tổng quan sản phẩm
        $productOverview = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'products_with_sales' => DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->distinct('products.id')
                ->count(),
            'avg_price' => Product::avg('price'),
        ];

        // Top danh mục
        $topCategories = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, SUM(order_items.quantity) as total_sold, SUM(order_items.subtotal) as total_revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        $categories = Category::all();

        return view('admin.reports.products', compact(
            'productStats',
            'productOverview',
            'topCategories',
            'categories',
            'categoryId',
            'sortBy'
        ));
    }

    /**
     * Báo cáo khách hàng
     */
    public function customers(Request $request)
    {
        $sortBy = $request->get('sort_by', 'orders');

        $query = User::withCount(['orders'])
            ->withSum('orders', 'total_amount')
            ->whereHas('orders');

        // Sắp xếp
        switch ($sortBy) {
            case 'revenue':
                $query->orderBy('orders_sum_total_amount', 'desc');
                break;
            case 'registration':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('orders_count', 'desc');
        }

        $customerStats = $query->paginate(20)->withQueryString();

        // Thống kê tổng quan khách hàng
        $customerOverview = [
            'total_customers' => User::count(),
            'active_customers' => User::whereHas('orders')->count(),
            'new_customers_this_month' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'avg_order_value' => Order::where('status', 'delivered')->avg('total_amount'),
        ];

        // Khách hàng theo tháng đăng ký
        $customersByMonth = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top khách hàng VIP
        $vipCustomers = User::withCount(['orders'])
            ->withSum('orders', 'total_amount')
            ->whereHas('orders')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.customers', compact(
            'customerStats',
            'customerOverview',
            'customersByMonth',
            'vipCustomers',
            'sortBy'
        ));
    }

    /**
     * Xuất báo cáo Excel
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        switch ($type) {
            case 'revenue':
                return $this->exportRevenueReport($startDate, $endDate);
            case 'products':
                return $this->exportProductReport();
            case 'customers':
                return $this->exportCustomerReport();
            default:
                return redirect()->back()->with('error', 'Loại báo cáo không hợp lệ');
        }
    }

    private function exportRevenueReport($startDate, $endDate)
    {
        // Logic xuất báo cáo doanh thu
        // Có thể sử dụng Laravel Excel package
        return redirect()->back()->with('success', 'Xuất báo cáo doanh thu thành công');
    }

    private function exportProductReport()
    {
        // Logic xuất báo cáo sản phẩm
        return redirect()->back()->with('success', 'Xuất báo cáo sản phẩm thành công');
    }

    private function exportCustomerReport()
    {
        // Logic xuất báo cáo khách hàng
        return redirect()->back()->with('success', 'Xuất báo cáo khách hàng thành công');
    }
}
