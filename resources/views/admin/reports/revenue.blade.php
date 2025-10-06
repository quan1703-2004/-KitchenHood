@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="reports-header">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="reports-title">
                <i class="fas fa-chart-line me-3"></i>
                Báo cáo Doanh thu
            </h1>
            <p class="reports-subtitle">Phân tích chi tiết doanh thu và xu hướng bán hàng</p>
        </div>
        <div class="header-actions">
            <form action="{{ route('admin.reports.export') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="type" value="revenue">
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
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
        <form method="GET" action="{{ route('admin.reports.revenue') }}" class="filter-form">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" 
                           name="start_date" 
                           class="form-control" 
                           value="{{ $startDate }}"
                           required>
                    <small class="text-muted">Bao gồm từ 00:00:00</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" 
                           name="end_date" 
                           class="form-control" 
                           value="{{ $endDate }}"
                           required>
                    <small class="text-muted">Bao gồm đến 23:59:59</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Lọc
                        </button>
                        <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Summary Cards -->
<div class="summary-cards mb-4">
    <div class="summary-card">
        <div class="summary-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="summary-content">
            <h3 class="summary-number">{{ number_format($totalRevenue) }}₫</h3>
            <p class="summary-label">Tổng doanh thu</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="summary-content">
            <h3 class="summary-number">{{ number_format($totalOrders) }}</h3>
            <p class="summary-label">Tổng đơn hàng</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i class="fas fa-calculator"></i>
        </div>
        <div class="summary-content">
            <h3 class="summary-number">{{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0) }}₫</h3>
            <p class="summary-label">Giá trị đơn hàng TB</p>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="summary-content">
            <h3 class="summary-number">+12.5%</h3>
            <p class="summary-label">Tăng trưởng</p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section">
    <div class="row">
        <!-- Daily Revenue Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-area me-2"></i>
                        Doanh thu theo ngày
                    </h3>
                    <div class="chart-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleChartType('daily')">
                            <i class="fas fa-exchange-alt me-1"></i>Chuyển đổi
                        </button>
                    </div>
                </div>
                <div class="chart-content">
                    <canvas id="dailyRevenueChart" height="400"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Method Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie me-2"></i>
                        Phương thức thanh toán
                    </h3>
                </div>
                <div class="chart-content">
                    <canvas id="paymentMethodChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Tables -->
<div class="tables-section">
    <div class="row">
        <!-- Daily Revenue Table -->
        <div class="col-lg-8">
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-calendar-day me-2"></i>
                        Chi tiết doanh thu theo ngày
                    </h3>
                    <div class="table-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="exportTable('daily')">
                            <i class="fas fa-download me-1"></i>Xuất
                        </button>
                    </div>
                </div>
                <div class="table-content">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th class="text-end">Doanh thu</th>
                                    <th class="text-center">Số đơn</th>
                                    <th class="text-end">TB/Đơn</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dailyRevenue as $day)
                                <tr>
                                    <td>
                                        <div class="date-info">
                                            <span class="date-day">{{ \Carbon\Carbon::parse($day->date)->format('d/m') }}</span>
                                            <span class="date-weekday">{{ \Carbon\Carbon::parse($day->date)->format('l') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="revenue-amount">{{ number_format($day->revenue) }}₫</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="orders-count">{{ number_format($day->orders) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="avg-order">{{ number_format($day->orders > 0 ? $day->revenue / $day->orders : 0) }}₫</span>
                                    </td>
                                    <td class="text-center">
                                        @if($day->revenue > 0)
                                            <span class="status-badge status-success">
                                                <i class="fas fa-check-circle me-1"></i>Tốt
                                            </span>
                                        @else
                                            <span class="status-badge status-warning">
                                                <i class="fas fa-exclamation-circle me-1"></i>Không có
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Không có dữ liệu trong khoảng thời gian này
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method Table -->
        <div class="col-lg-4">
            <div class="table-card">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-credit-card me-2"></i>
                        Chi tiết thanh toán
                    </h3>
                </div>
                <div class="table-content">
                    <div class="payment-methods-list">
                        @forelse($revenueByPayment as $payment)
                        <div class="payment-method-item">
                            <div class="payment-info">
                                <div class="payment-icon">
                                    @if($payment->payment_method == 'cod')
                                        <i class="fas fa-money-bill-wave"></i>
                                    @elseif($payment->payment_method == 'bank_transfer')
                                        <i class="fas fa-university"></i>
                                    @else
                                        <i class="fas fa-credit-card"></i>
                                    @endif
                                </div>
                                <div class="payment-details">
                                    <h4 class="payment-name">
                                        @if($payment->payment_method == 'cod')
                                            Thanh toán khi nhận hàng
                                        @elseif($payment->payment_method == 'bank_transfer')
                                            Chuyển khoản ngân hàng
                                        @else
                                            {{ ucfirst($payment->payment_method) }}
                                        @endif
                                    </h4>
                                    <p class="payment-stats">{{ number_format($payment->orders) }} đơn hàng</p>
                                </div>
                            </div>
                            <div class="payment-amount">
                                <span class="amount">{{ number_format($payment->revenue) }}₫</span>
                                <span class="percentage">{{ $totalRevenue > 0 ? round(($payment->revenue / $totalRevenue) * 100, 1) : 0 }}%</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Không có dữ liệu
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ===== REVENUE REPORT STYLES ===== */
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
    color: var(--success-color);
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

.filter-form .form-control {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
}

.filter-form .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

/* Summary Cards */
.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.summary-card {
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

.summary-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.summary-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.summary-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.summary-content {
    flex: 1;
}

.summary-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1;
}

.summary-label {
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
    color: var(--success-color);
}

.chart-content {
    padding: 2rem;
}

/* Tables Section */
.tables-section {
    margin-bottom: 2rem;
}

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
    color: var(--success-color);
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

/* Date Info */
.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-day {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.875rem;
}

.date-weekday {
    font-size: 0.75rem;
    color: var(--text-light);
}

/* Revenue Amount */
.revenue-amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 0.875rem;
}

.orders-count {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.875rem;
}

.avg-order {
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

/* Payment Methods List */
.payment-methods-list {
    padding: 1rem 0;
}

.payment-method-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.payment-method-item:last-child {
    border-bottom: none;
}

.payment-method-item:hover {
    background: var(--bg-light);
}

.payment-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.payment-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.payment-details {
    flex: 1;
}

.payment-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.payment-stats {
    font-size: 0.75rem;
    color: var(--text-light);
    margin: 0;
}

.payment-amount {
    text-align: right;
    flex-shrink: 0;
}

.amount {
    display: block;
    font-weight: 700;
    color: var(--success-color);
    font-size: 0.875rem;
}

.percentage {
    display: block;
    font-size: 0.75rem;
    color: var(--text-light);
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
    
    .summary-cards {
        grid-template-columns: 1fr;
    }
    
    .summary-card {
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
    
    .payment-method-item {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .reports-header {
        padding: 1rem;
    }
    
    .filter-card {
        padding: 1rem;
    }
    
    .summary-card {
        flex-direction: column;
        text-align: center;
    }
    
    .chart-content {
        padding: 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .payment-method-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .payment-amount {
        text-align: left;
        width: 100%;
    }
}
</style>

<script>
// Daily Revenue Chart
const dailyRevenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
const dailyRevenueChart = new Chart(dailyRevenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyRevenue->pluck('date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('d/m'); })) !!},
        datasets: [{
            label: 'Doanh thu (₫)',
            data: {!! json_encode($dailyRevenue->pluck('revenue')) !!},
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

// Payment Method Chart
const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
const paymentMethodChart = new Chart(paymentMethodCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($revenueByPayment->map(function($payment) { 
            if($payment->payment_method == 'cod') return 'COD';
            if($payment->payment_method == 'bank_transfer') return 'Chuyển khoản';
            return ucfirst($payment->payment_method);
        })) !!},
        datasets: [{
            data: {!! json_encode($revenueByPayment->pluck('revenue')) !!},
            backgroundColor: [
                '#10b981',
                '#2563eb',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6'
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
function toggleChartType(type) {
    // Toggle chart type functionality
    console.log('Toggling chart type:', type);
}

function exportTable(type) {
    // Export table functionality - sử dụng form xuất chính
    console.log('Exporting table:', type);
}
</script>
@endsection
