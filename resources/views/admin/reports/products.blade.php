@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="reports-header">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="reports-title">
                <i class="fas fa-box me-3"></i>
                Báo cáo Sản phẩm
            </h1>
            <p class="reports-subtitle">Thống kê chi tiết về sản phẩm và danh mục</p>
        </div>
        <div class="header-actions">
            <form action="{{ route('admin.reports.export') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="type" value="products">
                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>Xuất Excel
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.reports.products') }}" class="filter-form">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sắp xếp theo</label>
                    <select name="sort_by" class="form-select">
                        <option value="sales" {{ $sortBy == 'sales' ? 'selected' : '' }}>Số lượng bán</option>
                        <option value="revenue" {{ $sortBy == 'revenue' ? 'selected' : '' }}>Doanh thu</option>
                        <option value="orders" {{ $sortBy == 'orders' ? 'selected' : '' }}>Số đơn hàng</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Lọc
                        </button>
                        <a href="{{ route('admin.reports.products') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Overview Cards -->
<div class="overview-cards mb-4">
    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($productOverview['total_products']) }}</h3>
            <p class="overview-label">Tổng sản phẩm</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-tags"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($productOverview['total_categories']) }}</h3>
            <p class="overview-label">Tổng danh mục</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($productOverview['products_with_sales']) }}</h3>
            <p class="overview-label">Sản phẩm có bán</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($productOverview['avg_price']) }}₫</h3>
            <p class="overview-label">Giá TB</p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section mb-4">
    <div class="row">
        <!-- Top Categories Chart -->
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-bar me-2"></i>
                        Top danh mục bán chạy
                    </h3>
                </div>
                <div class="chart-content">
                    <canvas id="topCategoriesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Product Performance Chart -->
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie me-2"></i>
                        Phân bố sản phẩm theo danh mục
                    </h3>
                </div>
                <div class="chart-content">
                    <canvas id="productDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="products-table-section">
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-list me-2"></i>
                Chi tiết sản phẩm
            </h3>
            <div class="table-actions">
                <button class="btn btn-sm btn-outline-primary" onclick="exportTable()">
                    <i class="fas fa-download me-1"></i>Xuất
                </button>
            </div>
        </div>
        <div class="table-content">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th class="text-end">Giá</th>
                            <th class="text-center">Đã bán</th>
                            <th class="text-end">Doanh thu</th>
                            <th class="text-center">Đơn hàng</th>
                            <th class="text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productStats as $index => $product)
                        <tr>
                            <td>
                                <span class="product-rank">{{ ($productStats->currentPage() - 1) * $productStats->perPage() + $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="product-info">
                                    <h4 class="product-name">{{ $product->name }}</h4>
                                    <p class="product-id">ID: {{ $product->id }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="category-badge">{{ $product->category_name }}</span>
                            </td>
                            <td class="text-end">
                                <span class="product-price">{{ number_format($product->price) }}₫</span>
                            </td>
                            <td class="text-center">
                                <span class="sales-count">{{ number_format($product->total_sold) }}</span>
                            </td>
                            <td class="text-end">
                                <span class="revenue-amount">{{ number_format($product->total_revenue) }}₫</span>
                            </td>
                            <td class="text-center">
                                <span class="orders-count">{{ number_format($product->order_count) }}</span>
                            </td>
                            <td class="text-center">
                                @if($product->total_sold > 0)
                                    <span class="status-badge status-success">
                                        <i class="fas fa-check-circle me-1"></i>Bán tốt
                                    </span>
                                @else
                                    <span class="status-badge status-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>Chưa bán
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Không có dữ liệu sản phẩm
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($productStats->hasPages())
            <div class="pagination-section">
                {{ $productStats->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ===== PRODUCT REPORT STYLES ===== */
:root {
    --primary-color: #2563eb;
    --primary-light: #3b82f6;
    --primary-dark: #1d4ed8;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #0ea5e9;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --text-muted: #94a3b8;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* Header Section */
.reports-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.reports-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.reports-title i {
    color: var(--info-color);
    font-size: 1.5rem;
}

.reports-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

/* Filter Section */
.filter-section {
    margin-bottom: 2rem;
}

.filter-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.filter-form .form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.filter-form .form-select {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
}

.filter-form .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

/* Overview Cards */
.overview-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.overview-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.overview-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--info-color), #38bdf8);
}

.overview-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.overview-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--info-color), #38bdf8);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.overview-content {
    flex: 1;
}

.overview-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1;
}

.overview-label {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
    font-weight: 500;
}

/* Charts Section */
.charts-section {
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
    margin-bottom: 2rem;
}

.chart-header {
    background: var(--bg-light);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.chart-title i {
    color: var(--info-color);
}

.chart-content {
    padding: 2rem;
}

/* Products Table Section */
.products-table-section {
    margin-bottom: 2rem;
}

.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.table-header {
    background: var(--bg-light);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.table-title i {
    color: var(--info-color);
}

.table-content {
    padding: 0;
}

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    background: var(--bg-light);
    border-bottom: 2px solid var(--border-color);
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.875rem;
    padding: 1rem 1.5rem;
}

.table td {
    border-bottom: 1px solid var(--border-color);
    padding: 1rem 1.5rem;
    vertical-align: middle;
}

.table tbody tr:hover {
    background: var(--bg-light);
}

/* Product Info */
.product-rank {
    display: inline-block;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--info-color);
    color: white;
    text-align: center;
    line-height: 32px;
    font-weight: 700;
    font-size: 0.875rem;
}

.product-info {
    min-width: 200px;
}

.product-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.product-id {
    font-size: 0.75rem;
    color: var(--text-light);
    margin: 0;
}

/* Category Badge */
.category-badge {
    background: var(--bg-light);
    color: var(--text-dark);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid var(--border-color);
}

/* Product Price */
.product-price {
    font-weight: 700;
    color: var(--text-dark);
    font-size: 0.875rem;
}

/* Sales Count */
.sales-count {
    font-weight: 600;
    color: var(--success-color);
    font-size: 0.875rem;
}

/* Revenue Amount */
.revenue-amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 0.875rem;
}

/* Orders Count */
.orders-count {
    font-weight: 600;
    color: var(--info-color);
    font-size: 0.875rem;
}

/* Status Badge */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
}

.status-success {
    background: var(--success-color);
    color: white;
}

.status-warning {
    background: var(--warning-color);
    color: white;
}

/* Pagination */
.pagination-section {
    padding: 1.5rem 2rem;
    background: var(--bg-light);
    border-top: 1px solid var(--border-color);
}

.pagination {
    margin: 0;
    justify-content: center;
}

.pagination .page-link {
    border: 1px solid var(--border-color);
    color: var(--text-dark);
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 6px;
}

.pagination .page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination .page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .reports-header {
        padding: 1.5rem;
    }
    
    .reports-title {
        font-size: 1.5rem;
    }
    
    .filter-card {
        padding: 1.5rem;
    }
    
    .overview-cards {
        grid-template-columns: 1fr;
    }
    
    .overview-card {
        padding: 1.5rem;
    }
    
    .chart-content {
        padding: 1rem;
    }
    
    .table-header {
        padding: 1rem 1.5rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem 1rem;
    }
}

@media (max-width: 576px) {
    .reports-header {
        padding: 1rem;
    }
    
    .filter-card {
        padding: 1rem;
    }
    
    .overview-card {
        flex-direction: column;
        text-align: center;
    }
    
    .chart-content {
        padding: 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .product-info {
        min-width: 150px;
    }
}
</style>

<script>
// Top Categories Chart
const topCategoriesCtx = document.getElementById('topCategoriesChart').getContext('2d');
const topCategoriesChart = new Chart(topCategoriesCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($topCategories->pluck('name')) !!},
        datasets: [{
            label: 'Số lượng bán',
            data: {!! json_encode($topCategories->pluck('total_sold')) !!},
            backgroundColor: '#0ea5e9',
            borderColor: '#0284c7',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Product Distribution Chart
const productDistributionCtx = document.getElementById('productDistributionChart').getContext('2d');
const productDistributionChart = new Chart(productDistributionCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($topCategories->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($topCategories->pluck('total_revenue')) !!},
            backgroundColor: [
                '#0ea5e9',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6',
                '#06b6d4',
                '#84cc16',
                '#f97316'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    }
});

// Functions
function exportTable() {
    // Export table functionality - sử dụng form xuất chính
    console.log('Exporting products table');
}
</script>
@endsection
