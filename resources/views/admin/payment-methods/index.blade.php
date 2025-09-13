@extends('layouts.admin')

@section('title', 'Quản Lý Phương Thức Thanh Toán - KitchenHood Pro')

@section('content')
<style>
/* ===== PAYMENT METHODS STYLES ===== */
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
.payment-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.payment-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.payment-title i {
    color: var(--success-color);
    font-size: 1.5rem;
}

.payment-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
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
    color: var(--success-color);
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

.badge-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
}

.badge-info {
    background: linear-gradient(135deg, var(--info-color), #38bdf8);
    color: white;
}

.badge-secondary {
    background: linear-gradient(135deg, var(--text-muted), #94a3b8);
    color: white;
}

.badge-light {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

/* Action Buttons */
.action-btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.25rem;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.action-btn:last-child {
    margin-right: 0;
}

.btn-outline-info {
    border: 2px solid var(--info-color);
    color: var(--info-color);
}

.btn-outline-info:hover {
    background: var(--info-color);
    color: white;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
}

.btn-outline-danger {
    border: 2px solid var(--danger-color);
    color: var(--danger-color);
}

.btn-outline-danger:hover {
    background: var(--danger-color);
    color: white;
}

/* Alert */
.alert {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
}

.alert-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h5 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.empty-state p {
    margin-bottom: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .payment-header {
        padding: 1.5rem;
    }
    
    .payment-title {
        font-size: 1.5rem;
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
<div class="payment-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="payment-title">
                <i class="fas fa-credit-card me-3"></i>
                Quản Lý Phương Thức Thanh Toán
            </h1>
            <p class="payment-subtitle">Quản lý các phương thức thanh toán của hệ thống</p>
        </div>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm Phương Thức
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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Payment Methods Table -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title">
            <i class="fas fa-list me-2"></i>
            Danh Sách Phương Thức Thanh Toán
        </h3>
    </div>
    <div class="table-responsive">
        @if($paymentMethods->count() > 0)
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Loại</th>
                        <th>Tên</th>
                        <th>Thông Tin</th>
                        <th>Trạng Thái</th>
                        <th>Thứ Tự</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentMethods as $index => $method)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($method->type === 'qr_code')
                                <span class="badge badge-info">
                                    <i class="fas fa-qrcode me-1"></i>QR Code
                                </span>
                            @elseif($method->type === 'momo')
                                <span class="badge badge-success">
                                    <i class="fas fa-mobile-alt me-1"></i>Momo
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $method->name }}</div>
                            @if($method->description)
                                <small class="text-muted">{{ Str::limit($method->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($method->type === 'qr_code')
                                <div class="small">
                                    @if($method->bank_name)
                                        <div><strong>Ngân hàng:</strong> {{ $method->bank_name }}</div>
                                    @endif
                                    @if($method->account_number)
                                        <div><strong>STK:</strong> {{ $method->account_number }}</div>
                                    @endif
                                    @if($method->account_name)
                                        <div><strong>Chủ TK:</strong> {{ $method->account_name }}</div>
                                    @endif
                                </div>
                            @elseif($method->type === 'momo')
                                <div class="small">
                                    @if($method->momo_phone)
                                        <div><strong>SĐT:</strong> {{ $method->momo_phone }}</div>
                                    @endif
                                    @if($method->momo_name)
                                        <div><strong>Tên:</strong> {{ $method->momo_name }}</div>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($method->is_active)
                                <span class="badge badge-success">
                                    <i class="fas fa-check me-1"></i>Hoạt Động
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times me-1"></i>Tạm Dừng
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-light">{{ $method->sort_order }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.payment-methods.show', $method) }}" 
                                   class="action-btn btn-outline-info" 
                                   title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" 
                                   class="action-btn btn-outline-primary" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa phương thức thanh toán này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="action-btn btn-outline-danger" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-credit-card"></i>
                <h5>Chưa có phương thức thanh toán nào</h5>
                <p>Hãy thêm phương thức thanh toán đầu tiên để bắt đầu</p>
                <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm Phương Thức Đầu Tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
