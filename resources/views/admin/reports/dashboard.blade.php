@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="reports-header">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="reports-title">
                <i class="fas fa-chart-line me-3"></i>
                Báo cáo & Thống kê
            </h1>
            <p class="reports-subtitle">Tổng quan hoạt động kinh doanh và phân tích dữ liệu</p>
        </div>
        <div class="header-actions">
            <div class="date-range-picker">
                <input type="date" id="start-date" class="form-control" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                <span class="mx-2">đến</span>
                <input type="date" id="end-date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                <button class="btn btn-primary ms-2" onclick="updateDateRange()">
                    <i class="fas fa-sync me-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="stats-grid mb-4">
    <div class="stat-card revenue-card">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-number">{{ number_format($stats['total_revenue']) }}₫</h3>
            <p class="stat-label">Tổng doanh thu</p>
            <div class="stat-trend positive">
                <i class="fas fa-arrow-up"></i>
                <span>+12.5%</span>
            </div>
        </div>
    </div>

    <div class="stat-card orders-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-number">{{ number_format($stats['total_orders']) }}</h3>
            <p class="stat-label">Tổng đơn hàng</p>
            <div class="stat-trend positive">
                <i class="fas fa-arrow-up"></i>
                <span>+8.2%</span>
            </div>
        </div>
    </div>

    <div class="stat-card customers-card">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-number">{{ number_format($stats['total_users']) }}</h3>
            <p class="stat-label">Tổng khách hàng</p>
            <div class="stat-trend positive">
                <i class="fas fa-arrow-up"></i>
                <span>+{{ $newCustomers }}</span>
            </div>
        </div>
    </div>

    <div class="stat-card products-card">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-number">{{ number_format($stats['total_products']) }}</h3>
            <p class="stat-label">Tổng sản phẩm</p>
            <div class="stat-trend neutral">
                <i class="fas fa-minus"></i>
                <span>0%</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="reports-grid">
    <!-- Left Column -->
    <div class="reports-left">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-chart-area me-2"></i>
                    Doanh thu theo tháng
                </h3>
                <div class="chart-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="exportChart('revenue')">
                        <i class="fas fa-download me-1"></i>Xuất
                    </button>
                </div>
            </div>
            <div class="chart-content">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>

        <!-- Orders Status Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-chart-pie me-2"></i>
                    Đơn hàng theo trạng thái
                </h3>
            </div>
            <div class="chart-content">
                <canvas id="ordersStatusChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="reports-right">
        <!-- Top Products -->
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-trophy me-2"></i>
                    Top sản phẩm bán chạy
                </h3>
                <a href="{{ route('admin.reports.products') }}" class="btn btn-sm btn-outline-primary">
                    Xem tất cả
                </a>
            </div>
            <div class="table-content">
                <div class="top-products-list">
                    @foreach($topProducts as $index => $product)
                    <div class="product-item">
                        <div class="product-rank">
                            <span class="rank-number">{{ $index + 1 }}</span>
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">{{ $product->name }}</h4>
                            <p class="product-stats">
                                <span class="sales-count">{{ number_format($product->total_sold) }} bán</span>
                                <span class="revenue">{{ number_format($product->total_revenue) }}₫</span>
                            </p>
                        </div>
                        <div class="product-trend">
                            <div class="trend-indicator positive">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-clock me-2"></i>
                    Đơn hàng gần đây
                </h3>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                    Xem tất cả
                </a>
            </div>
            <div class="table-content">
                <div class="recent-orders-list">
                    @foreach($recentOrders as $order)
                    <div class="order-item">
                        <div class="order-info">
                            <h4 class="order-number">{{ $order->order_number }}</h4>
                            <p class="order-customer">{{ $order->user->name ?? 'Khách vãng lai' }}</p>
                        </div>
                        <div class="order-details">
                            <span class="order-status status-{{ $order->status }}">
                                @if($order->status == 'pending')
                                    Chờ xử lý
                                @elseif($order->status == 'processing')
                                    Đang xử lý
                                @elseif($order->status == 'shipped')
                                    Đang giao hàng
                                @elseif($order->status == 'delivered')
                                    Đã giao hàng
                                @elseif($order->status == 'cancelled')
                                    Đã hủy
                                @endif
                            </span>
                            <span class="order-total">{{ number_format($order->total_amount) }}₫</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions-section">
    <div class="actions-header">
        <h3 class="actions-title">
            <i class="fas fa-bolt me-2"></i>
            Hành động nhanh
        </h3>
    </div>
    <div class="actions-grid">
        <a href="{{ route('admin.reports.revenue') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="action-content">
                <h4>Báo cáo doanh thu</h4>
                <p>Phân tích doanh thu chi tiết</p>
            </div>
        </a>

        <a href="{{ route('admin.reports.products') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="action-content">
                <h4>Báo cáo sản phẩm</h4>
                <p>Thống kê sản phẩm bán chạy</p>
            </div>
        </a>

        <a href="{{ route('admin.reports.customers') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="action-content">
                <h4>Báo cáo khách hàng</h4>
                <p>Phân tích hành vi khách hàng</p>
            </div>
        </a>

        <a href="#" class="action-card" onclick="exportAllReports()">
            <div class="action-icon">
                <i class="fas fa-download"></i>
            </div>
            <div class="action-content">
                <h4>Xuất tất cả báo cáo</h4>
                <p>Download báo cáo Excel</p>
            </div>
        </a>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ===== REPORTS STYLES ===== */
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
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
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
    color: var(--primary-color);
    font-size: 1.5rem;
}

.reports-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

.date-range-picker {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.date-range-picker .form-control {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.date-range-picker .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.stat-card {
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

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card.revenue-card::before {
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.stat-card.orders-card::before {
    background: linear-gradient(90deg, var(--info-color), #38bdf8);
}

.stat-card.customers-card::before {
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
}

.stat-card.products-card::before {
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.revenue-card .stat-icon {
    background: linear-gradient(135deg, var(--success-color), #34d399);
}

.orders-card .stat-icon {
    background: linear-gradient(135deg, var(--info-color), #38bdf8);
}

.customers-card .stat-icon {
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
}

.products-card .stat-icon {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-light);
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.stat-trend.positive {
    color: var(--success-color);
}

.stat-trend.negative {
    color: var(--danger-color);
}

.stat-trend.neutral {
    color: var(--text-muted);
}

/* Reports Grid */
.reports-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

/* Chart Cards */
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
    color: var(--primary-color);
}

.chart-content {
    padding: 2rem;
}

/* Table Cards */
.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
    margin-bottom: 2rem;
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
    color: var(--primary-color);
}

.table-content {
    padding: 0;
}

/* Top Products List */
.top-products-list {
    padding: 1rem 0;
}

.product-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 2rem;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.product-item:last-child {
    border-bottom: none;
}

.product-item:hover {
    background: var(--bg-light);
}

.product-rank {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.product-info {
    flex: 1;
    min-width: 0;
}

.product-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.product-stats {
    font-size: 0.75rem;
    color: var(--text-light);
    margin: 0;
    display: flex;
    gap: 1rem;
}

.product-trend {
    flex-shrink: 0;
}

.trend-indicator {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.trend-indicator.positive {
    background: var(--success-color);
    color: white;
}

.trend-indicator.negative {
    background: var(--danger-color);
    color: white;
}

/* Recent Orders List */
.recent-orders-list {
    padding: 1rem 0;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.order-item:last-child {
    border-bottom: none;
}

.order-item:hover {
    background: var(--bg-light);
}

.order-info {
    flex: 1;
}

.order-number {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.order-customer {
    font-size: 0.75rem;
    color: var(--text-light);
    margin: 0;
}

.order-details {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.25rem;
}

.order-status {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.75rem;
}

.status-pending {
    background: var(--warning-color);
    color: white;
}

.status-processing {
    background: var(--info-color);
    color: white;
}

.status-shipped {
    background: var(--primary-color);
    color: white;
}

.status-delivered {
    background: var(--success-color);
    color: white;
}

.status-cancelled {
    background: var(--danger-color);
    color: white;
}

.order-total {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--success-color);
}

/* Quick Actions */
.quick-actions-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.actions-header {
    margin-bottom: 2rem;
}

.actions-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.actions-title i {
    color: var(--primary-color);
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.action-card:hover {
    background: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.action-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.action-content p {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .reports-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .reports-header {
        padding: 1.5rem;
    }
    
    .reports-title {
        font-size: 1.5rem;
    }
    
    .date-range-picker {
        flex-direction: column;
        width: 100%;
        margin-top: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .chart-content {
        padding: 1rem;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .reports-header {
        padding: 1rem;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
    }
    
    .product-item {
        padding: 1rem;
    }
    
    .order-item {
        padding: 1rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .order-details {
        align-items: flex-start;
        width: 100%;
    }
}
</style>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueByMonth->pluck('month')) !!},
        datasets: [{
            label: 'Doanh thu (₫)',
            data: {!! json_encode($revenueByMonth->pluck('revenue')) !!},
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
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
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('vi-VN').format(value) + '₫';
                    }
                }
            }
        }
    }
});

// Orders Status Chart
const ordersStatusCtx = document.getElementById('ordersStatusChart').getContext('2d');
const ordersStatusChart = new Chart(ordersStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Chờ xử lý', 'Đang xử lý', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy'],
        datasets: [{
            data: [
                {{ $stats['pending_orders'] }},
                {{ $stats['processing_orders'] }},
                0,
                {{ $stats['delivered_orders'] }},
                0
            ],
            backgroundColor: [
                '#f59e0b',
                '#0ea5e9',
                '#2563eb',
                '#10b981',
                '#ef4444'
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
function updateDateRange() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    
    if (startDate && endDate) {
        // Reload page with new date range
        window.location.href = `{{ route('admin.reports.dashboard') }}?start_date=${startDate}&end_date=${endDate}`;
    }
}

function exportChart(type) {
    // Export chart functionality
    console.log('Exporting chart:', type);
}

function exportAllReports() {
    // Export all reports functionality
    console.log('Exporting all reports');
}
</script>
@endsection
