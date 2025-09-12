@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="user-detail-header">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="user-detail-title">
                <i class="fas fa-user me-3"></i>
                Chi tiết Người dùng
            </h1>
            <div class="user-meta">
                <span class="user-id">ID: {{ $user->id }}</span>
                <span class="user-role {{ $user->role === 'admin' ? 'role-admin' : 'role-user' }}">
                    {{ $user->role === 'admin' ? 'Admin' : 'Người dùng' }}
                </span>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-edit">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- Main Content Grid -->
<div class="user-detail-grid">
    <!-- Left Column - User Info -->
    <div class="user-info-section">
        <!-- Basic Information -->
        <div class="info-card">
            <div class="info-header">
                <h3 class="info-title">
                    <i class="fas fa-user-circle me-2"></i>
                    Thông tin cơ bản
                </h3>
            </div>
            <div class="info-content">
                <div class="user-avatar-section">
                    <div class="user-avatar-large">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <div class="avatar-placeholder-large">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="user-basic-info">
                        <h2 class="user-name">{{ $user->name }}</h2>
                        <p class="user-email">{{ $user->email }}</p>
                        <div class="user-status">
                            @if($user->email_verified_at)
                                <span class="status-badge status-active">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Đã kích hoạt
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="fas fa-clock me-1"></i>
                                    Chưa kích hoạt
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="info-items">
                    <div class="info-item">
                        <label>Vai trò</label>
                        <span>{{ $user->role === 'admin' ? 'Quản trị viên' : 'Người dùng' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Ngày tạo tài khoản</label>
                        <span>{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Lần đăng nhập cuối</label>
                        <span>{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="info-card">
            <div class="info-header">
                <h3 class="info-title">
                    <i class="fas fa-chart-bar me-2"></i>
                    Thống kê đơn hàng
                </h3>
            </div>
            <div class="info-content">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-info">
                            <h4 class="stat-number">{{ $orderStats['total_orders'] }}</h4>
                            <p class="stat-label">Tổng đơn hàng</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-info">
                            <h4 class="stat-number">{{ number_format($orderStats['total_spent']) }}₫</h4>
                            <p class="stat-label">Tổng chi tiêu</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h4 class="stat-number">{{ $orderStats['pending_orders'] }}</h4>
                            <p class="stat-label">Đơn chờ xử lý</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Recent Orders -->
    <div class="user-orders-section">
        <div class="info-card">
            <div class="info-header">
                <h3 class="info-title">
                    <i class="fas fa-receipt me-2"></i>
                    Đơn hàng gần đây
                </h3>
            </div>
            <div class="info-content">
                @if($orderStats['recent_orders']->count() > 0)
                    <div class="orders-list">
                        @foreach($orderStats['recent_orders'] as $order)
                        <div class="order-item">
                            <div class="order-info">
                                <h4 class="order-number">{{ $order->order_number }}</h4>
                                <p class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</p>
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
                    <div class="view-all-orders">
                        <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="btn btn-view-all">
                            <i class="fas fa-list me-2"></i>Xem tất cả đơn hàng
                        </a>
                    </div>
                @else
                    <div class="no-orders">
                        <div class="no-orders-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4>Chưa có đơn hàng</h4>
                        <p>Người dùng này chưa có đơn hàng nào.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="info-card">
            <div class="info-header">
                <h3 class="info-title">
                    <i class="fas fa-bolt me-2"></i>
                    Hành động nhanh
                </h3>
            </div>
            <div class="info-content">
                <div class="quick-actions">
                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="quick-action-form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="btn btn-quick-action {{ $user->email_verified_at ? 'btn-warning' : 'btn-success' }}"
                                onclick="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái người dùng này?')">
                            <i class="fas {{ $user->email_verified_at ? 'fa-ban' : 'fa-check' }} me-2"></i>
                            {{ $user->email_verified_at ? 'Vô hiệu hóa' : 'Kích hoạt' }} tài khoản
                        </button>
                    </form>
                    
                    @if($user->role !== 'admin')
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="quick-action-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-quick-action btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác!')">
                            <i class="fas fa-trash me-2"></i>
                            Xóa tài khoản
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== USER DETAIL STYLES ===== */
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
.user-detail-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.user-detail-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.user-detail-title i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.user-meta {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
}

.user-id {
    background: var(--bg-light);
    color: var(--text-light);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
}

.user-role {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
}

.role-admin {
    background: var(--primary-color);
    color: white;
}

.role-user {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.btn-edit {
    background: linear-gradient(135deg, var(--warning-color) 0%, #fbbf24 100%);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-edit:hover {
    background: linear-gradient(135deg, #d97706 0%, var(--warning-color) 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
    text-decoration: none;
}

.btn-back {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

/* Main Content Grid */
.user-detail-grid {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    align-items: flex-start;
}

.user-info-section {
    flex: 1;
    min-width: 0;
}

.user-orders-section {
    flex: 1;
    min-width: 0;
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
    margin-bottom: 2rem;
}

.info-header {
    background: var(--bg-light);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
}

.info-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.info-title i {
    color: var(--primary-color);
}

.info-content {
    padding: 2rem;
}

/* User Avatar Section */
.user-avatar-section {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-md);
}

.user-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-large {
    color: var(--text-muted);
    font-size: 2.5rem;
}

.user-basic-info {
    flex: 1;
}

.user-name {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.user-email {
    font-size: 1rem;
    color: var(--text-light);
    margin-bottom: 1rem;
}

.user-status {
    margin-top: 1rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
}

.status-active {
    background: var(--success-color);
    color: white;
}

.status-inactive {
    background: var(--warning-color);
    color: white;
}

/* Info Items */
.info-items {
    display: grid;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item label {
    font-weight: 600;
    color: var(--text-light);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-item span {
    font-weight: 500;
    color: var(--text-dark);
    text-align: right;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-info {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
    font-weight: 500;
}

/* Orders List */
.orders-list {
    margin-bottom: 2rem;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.order-item:last-child {
    border-bottom: none;
}

.order-info {
    flex: 1;
}

.order-number {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.order-date {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
}

.order-details {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.5rem;
}

.order-status {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.75rem;
}

.status-pending {
    background: var(--success-color);
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
    font-size: 1rem;
    font-weight: 700;
    color: var(--success-color);
}

.view-all-orders {
    text-align: center;
}

.btn-view-all {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    background: var(--primary-dark);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

/* No Orders */
.no-orders {
    text-align: center;
    padding: 3rem 0;
    color: var(--text-muted);
}

.no-orders-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-orders h4 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.no-orders p {
    font-size: 1rem;
    margin: 0;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.quick-action-form {
    margin: 0;
}

.btn-quick-action {
    width: 100%;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    text-align: center;
}

.btn-quick-action.btn-success {
    background: var(--success-color);
    color: white;
}

.btn-quick-action.btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-quick-action.btn-warning {
    background: var(--warning-color);
    color: white;
}

.btn-quick-action.btn-warning:hover {
    background: #d97706;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-quick-action.btn-danger {
    background: var(--danger-color);
    color: white;
}

.btn-quick-action.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .user-detail-grid {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .user-info-section {
        flex: none;
    }
    
    .user-orders-section {
        flex: none;
    }
}

@media (max-width: 768px) {
    .user-detail-header {
        padding: 1.5rem;
    }
    
    .user-detail-title {
        font-size: 1.5rem;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .user-avatar-section {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .order-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .order-details {
        align-items: flex-start;
        width: 100%;
    }
    
    .info-content {
        padding: 1.5rem;
    }
}

@media (max-width: 576px) {
    .user-detail-header {
        padding: 1rem;
    }
    
    .info-content {
        padding: 1rem;
    }
    
    .user-avatar-large {
        width: 80px;
        height: 80px;
    }
    
    .avatar-placeholder-large {
        font-size: 2rem;
    }
    
    .user-name {
        font-size: 1.5rem;
    }
}
</style>
@endsection
