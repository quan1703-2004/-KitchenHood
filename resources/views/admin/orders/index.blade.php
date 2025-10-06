@extends('layouts.admin')

@section('title', 'Quản Lý Đơn Hàng - KitchenHood Pro')

@section('content')
<style>
/* ===== ORDERS STYLES ===== */
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
.orders-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.orders-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.orders-title i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.orders-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
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

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
    font-weight: 500;
}

/* Table Card */
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
    color: var(--primary-color);
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

/* Badge Styles */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
}

/* Button Styles */
.btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    transform: translateY(-1px);
}

.btn-outline-success {
    border: 2px solid var(--success-color);
    color: var(--success-color);
}

.btn-outline-success:hover {
    background: var(--success-color);
    transform: translateY(-1px);
}

.btn-outline-info {
    border: 2px solid var(--info-color);
    color: var(--info-color);
}

.btn-outline-info:hover {
    background: var(--info-color);
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .orders-header {
        padding: 1.5rem;
    }
    
    .orders-title {
        font-size: 1.5rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .table-header {
        padding: 1rem 1.5rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem 1rem;
    }
}
</style>

<!-- Header Section -->
<div class="orders-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="orders-title">
                <i class="fas fa-shopping-cart me-3"></i>
                Quản Lý Đơn Hàng
            </h1>
            <p class="orders-subtitle">Theo dõi và quản lý tất cả đơn hàng trong hệ thống</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.orders.export') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    <i class="fas fa-download me-2"></i>Xuất Excel
                </button>
            </form>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>In Báo Cáo
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $orders->total() }}</div>
            <div class="stat-label">Tổng Đơn Hàng</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $orders->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Chờ Xử Lý</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-truck"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $orders->where('status', 'shipped')->count() }}</div>
            <div class="stat-label">Đang Giao Hàng</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $orders->where('status', 'delivered')->count() }}</div>
            <div class="stat-label">Đã Giao Hàng</div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title">
            <i class="fas fa-list me-2"></i>
            Danh Sách Đơn Hàng
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Khách Hàng</th>
                    <th>Ngày Đặt</th>
                    <th class="text-center">Tổng Tiền</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Thanh Toán</th>
                    <th class="text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <div>
                            <span class="fw-bold text-primary">#{{ $order->id }}</span>
                            <br>
                            <small class="text-muted">{{ $order->order_number }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="fw-bold">{{ $order->shipping_name ?? 'N/A' }}</span>
                            <br>
                            <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="fw-bold">{{ $order->created_at->format('d/m/Y') }}</span>
                            <br>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="fw-bold text-success">{{ number_format($order->total_amount) }}₫</span>
                    </td>
                    <td class="text-center">
                        @if($order->status == 'pending')
                            <span class="badge bg-warning">Chờ Xử Lý</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">Đang Xử Lý</span>
                        @elseif($order->status == 'shipped')
                            <span class="badge bg-primary">Đang Giao Hàng</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">Đã Giao Hàng</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">Đã Hủy</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($order->payment_status == 'paid')
                            <span class="badge bg-success">Đã Thanh Toán</span>
                        @elseif($order->payment_status == 'pending')
                            <span class="badge bg-warning">Chờ Thanh Toán</span>
                        @elseif($order->payment_status == 'failed')
                            <span class="badge bg-danger">Thất Bại</span>
                        @else
                            <span class="badge bg-secondary">{{ $order->payment_status }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($order->status == 'pending')
                                <button type="button" 
                                        class="btn btn-sm btn-outline-success" 
                                        title="Xử lý đơn hàng"
                                        onclick="updateStatus({{ $order->id }}, 'processing')">
                                    <i class="fas fa-play"></i>
                                </button>
                            @elseif($order->status == 'processing')
                                <button type="button" 
                                        class="btn btn-sm btn-outline-info" 
                                        title="Giao hàng"
                                        onclick="updateStatus({{ $order->id }}, 'shipped')">
                                    <i class="fas fa-truck"></i>
                                </button>
                            @elseif($order->status == 'shipped')
                                <button type="button" 
                                        class="btn btn-sm btn-outline-success" 
                                        title="Hoàn thành"
                                        onclick="updateStatus({{ $order->id }}, 'delivered')">
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-inbox fa-4x mb-3"></i>
                            <h5>Chưa có đơn hàng nào</h5>
                            <p>Hệ thống chưa có đơn hàng nào được tạo!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="d-flex justify-content-center py-3">
        {{ $orders->links() }}
    </div>
    @endif
</div>

<!-- Form ẩn để cập nhật trạng thái -->
<form id="updateStatusForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="statusInput">
</form>

<script>
function updateStatus(orderId, status) {
    if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
        const form = document.getElementById('updateStatusForm');
        const statusInput = document.getElementById('statusInput');
        
        form.action = `/admin/orders/${orderId}`;
        statusInput.value = status;
        
        form.submit();
    }
}
</script>
@endsection