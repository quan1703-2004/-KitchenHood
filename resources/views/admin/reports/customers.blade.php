@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="reports-header">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="reports-title">
                <i class="fas fa-users me-3"></i>
                Báo cáo Khách hàng
            </h1>
            <p class="reports-subtitle">Phân tích hành vi và thống kê khách hàng</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-success" onclick="exportReport()">
                <i class="fas fa-download me-2"></i>Xuất Excel
            </button>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.reports.customers') }}" class="filter-form">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Sắp xếp theo</label>
                    <select name="sort_by" class="form-select">
                        <option value="orders" {{ $sortBy == 'orders' ? 'selected' : '' }}>Số đơn hàng</option>
                        <option value="revenue" {{ $sortBy == 'revenue' ? 'selected' : '' }}>Tổng chi tiêu</option>
                        <option value="registration" {{ $sortBy == 'registration' ? 'selected' : '' }}>Ngày đăng ký</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Lọc
                        </button>
                        <a href="{{ route('admin.reports.customers') }}" class="btn btn-outline-secondary">
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
            <i class="fas fa-users"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($customerOverview['total_customers']) }}</h3>
            <p class="overview-label">Tổng khách hàng</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($customerOverview['active_customers']) }}</h3>
            <p class="overview-label">Khách hàng hoạt động</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($customerOverview['new_customers_this_month']) }}</h3>
            <p class="overview-label">Khách hàng mới tháng này</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="overview-content">
            <h3 class="overview-number">{{ number_format($customerOverview['avg_order_value']) }}₫</h3>
            <p class="overview-label">Giá trị đơn hàng TB</p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section mb-4">
    <div class="row">
        <!-- Customer Registration Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-line me-2"></i>
                        Khách hàng đăng ký theo tháng
                    </h3>
                </div>
                <div class="chart-content">
                    <canvas id="customerRegistrationChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Customer Activity Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie me-2"></i>
                        Phân bố khách hàng
                    </h3>
                </div>
                <div class="chart-content">
                    <canvas id="customerActivityChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- VIP Customers Section -->
<div class="vip-customers-section mb-4">
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-crown me-2"></i>
                Top khách hàng VIP
            </h3>
        </div>
        <div class="table-content">
            <div class="vip-customers-list">
                @foreach($vipCustomers as $index => $customer)
                <div class="vip-customer-item">
                    <div class="customer-rank">
                        <span class="rank-number">{{ $index + 1 }}</span>
                    </div>
                    <div class="customer-info">
                        <div class="customer-avatar">
                            @if($customer->avatar)
                                <img src="{{ asset('storage/' . $customer->avatar) }}" alt="{{ $customer->name }}">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="customer-details">
                            <h4 class="customer-name">{{ $customer->name }}</h4>
                            <p class="customer-email">{{ $customer->email }}</p>
                            <div class="customer-stats">
                                <span class="orders-count">{{ number_format($customer->orders_count) }} đơn hàng</span>
                                <span class="join-date">{{ $customer->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="customer-revenue">
                        <span class="revenue-amount">{{ number_format($customer->orders_sum_total_amount) }}₫</span>
                        <span class="revenue-label">Tổng chi tiêu</span>
                    </div>
                    <div class="customer-actions">
                        <a href="{{ route('admin.users.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="customers-table-section">
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-list me-2"></i>
                Danh sách khách hàng
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
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th class="text-center">Đơn hàng</th>
                            <th class="text-end">Tổng chi tiêu</th>
                            <th class="text-center">Ngày đăng ký</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerStats as $index => $customer)
                        <tr>
                            <td>
                                <span class="customer-rank">{{ ($customerStats->currentPage() - 1) * $customerStats->perPage() + $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar-small">
                                        @if($customer->avatar)
                                            <img src="{{ asset('storage/' . $customer->avatar) }}" alt="{{ $customer->name }}">
                                        @else
                                            <div class="avatar-placeholder-small">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="customer-details">
                                        <h4 class="customer-name">{{ $customer->name }}</h4>
                                        <p class="customer-id">ID: {{ $customer->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="customer-email">{{ $customer->email }}</span>
                            </td>
                            <td class="text-center">
                                <span class="orders-count">{{ number_format($customer->orders_count) }}</span>
                            </td>
                            <td class="text-end">
                                <span class="revenue-amount">{{ number_format($customer->orders_sum_total_amount ?? 0) }}₫</span>
                            </td>
                            <td class="text-center">
                                <span class="join-date">{{ $customer->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="text-center">
                                @if($customer->email_verified_at)
                                    <span class="status-badge status-success">
                                        <i class="fas fa-check-circle me-1"></i>Hoạt động
                                    </span>
                                @else
                                    <span class="status-badge status-warning">
                                        <i class="fas fa-clock me-1"></i>Chưa kích hoạt
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $customer) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $customer) }}" class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Không có dữ liệu khách hàng
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($customerStats->hasPages())
            <div class="pagination-section">
                {{ $customerStats->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ===== CUSTOMER REPORT STYLES ===== */
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
    color: var(--warning-color);
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
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
}

.overview-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.overview-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
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
    color: var(--warning-color);
}

.chart-content {
    padding: 2rem;
}

/* VIP Customers Section */
.vip-customers-section {
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
    color: var(--warning-color);
}

.table-content {
    padding: 0;
}

/* VIP Customers List */
.vip-customers-list {
    padding: 1rem 0;
}

.vip-customer-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.vip-customer-item:last-child {
    border-bottom: none;
}

.vip-customer-item:hover {
    background: var(--bg-light);
}

.customer-rank {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.customer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.customer-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.customer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    color: var(--text-muted);
    font-size: 1.25rem;
}

.customer-details {
    flex: 1;
}

.customer-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.customer-email {
    font-size: 0.875rem;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.customer-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--text-light);
}

.customer-revenue {
    text-align: right;
    flex-shrink: 0;
}

.revenue-amount {
    display: block;
    font-weight: 700;
    color: var(--success-color);
    font-size: 1rem;
}

.revenue-label {
    display: block;
    font-size: 0.75rem;
    color: var(--text-light);
}

.customer-actions {
    flex-shrink: 0;
}

/* Customers Table Section */
.customers-table-section {
    margin-bottom: 2rem;
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

/* Customer Info in Table */
.customer-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.customer-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.customer-avatar-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-small {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.customer-details {
    flex: 1;
    min-width: 0;
}

.customer-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.customer-id {
    font-size: 0.75rem;
    color: var(--text-light);
    margin: 0;
}

.customer-email {
    font-size: 0.875rem;
    color: var(--text-dark);
}

/* Orders Count */
.orders-count {
    font-weight: 600;
    color: var(--info-color);
    font-size: 0.875rem;
}

/* Revenue Amount */
.revenue-amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 0.875rem;
}

/* Join Date */
.join-date {
    font-size: 0.875rem;
    color: var(--text-dark);
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

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.25rem;
}

.action-buttons .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
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
    
    .vip-customer-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .customer-revenue {
        text-align: left;
        width: 100%;
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
    
    .customer-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<script>
// Customer Registration Chart
const customerRegistrationCtx = document.getElementById('customerRegistrationChart').getContext('2d');
const customerRegistrationChart = new Chart(customerRegistrationCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($customersByMonth->pluck('month')->map(function($month) { return \Carbon\Carbon::parse($month)->format('m/Y'); })) !!},
        datasets: [{
            label: 'Khách hàng mới',
            data: {!! json_encode($customersByMonth->pluck('count')) !!},
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
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
                beginAtZero: true
            }
        }
    }
});

// Customer Activity Chart
const customerActivityCtx = document.getElementById('customerActivityChart').getContext('2d');
const customerActivityChart = new Chart(customerActivityCtx, {
    type: 'doughnut',
    data: {
        labels: ['Khách hàng hoạt động', 'Khách hàng không hoạt động'],
        datasets: [{
            data: [
                {{ $customerOverview['active_customers'] }},
                {{ $customerOverview['total_customers'] - $customerOverview['active_customers'] }}
            ],
            backgroundColor: [
                '#f59e0b',
                '#e5e7eb'
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
function exportReport() {
    // Export report functionality
    console.log('Exporting customer report');
}

function exportTable() {
    // Export table functionality
    console.log('Exporting customers table');
}
</script>
@endsection
