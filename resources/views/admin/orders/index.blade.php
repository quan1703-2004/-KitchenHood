@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-cart me-2 text-primary"></i>
            Quản lý Đơn hàng
        </h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>In báo cáo
            </button>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng đơn hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chờ xử lý
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $orders->where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Đang giao
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $orders->where('status', 'shipped')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đã giao
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $orders->where('status', 'delivered')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list me-2 text-primary"></i>
                Danh sách Đơn hàng
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Mã đơn hàng</th>
                            <th class="px-4 py-3">Khách hàng</th>
                            <th class="px-4 py-3">Ngày đặt</th>
                            <th class="px-4 py-3 text-center">Tổng tiền</th>
                            <th class="px-4 py-3 text-center">Trạng thái</th>
                            <th class="px-4 py-3 text-center">Thanh toán</th>
                            <th class="px-4 py-3 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3">
                                <div>
                                    <span class="fw-bold text-primary">#{{ $order->id }}</span>
                                    <br>
                                    <small class="text-muted">{{ $order->order_number }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <span class="fw-bold">{{ $order->shipping_name ?? 'N/A' }}</span>
                                    <br>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <span class="fw-bold">{{ $order->created_at->format('d/m/Y') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="fw-bold text-success">{{ number_format($order->total_amount) }}₫</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-info">Đang xử lý</span>
                                @elseif($order->status == 'shipped')
                                    <span class="badge bg-primary">Đang giao hàng</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-success">Đã giao hàng</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif($order->payment_status == 'pending')
                                    <span class="badge bg-warning">Chờ thanh toán</span>
                                @elseif($order->payment_status == 'failed')
                                    <span class="badge bg-danger">Thất bại</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->payment_status }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
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
                            <td colspan="7" class="px-4 py-4 text-center text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">Chưa có đơn hàng nào</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang -->
            @if($orders->hasPages())
            <div class="d-flex justify-content-center py-3">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Form ẩn để cập nhật trạng thái -->
<form id="updateStatusForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="statusInput">
</form>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem !important;
    border-bottom-left-radius: 0.375rem !important;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem !important;
    border-bottom-right-radius: 0.375rem !important;
}

.border-left-primary {
    border-left: 0.25rem solid #007bff !important;
}

.border-left-warning {
    border-left: 0.25rem solid #ffc107 !important;
}

.border-left-info {
    border-left: 0.25rem solid #17a2b8 !important;
}

.border-left-success {
    border-left: 0.25rem solid #28a745 !important;
}
</style>

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