@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-cart me-2 text-primary"></i>
            Chi tiết Đơn hàng #{{ $order->id }}
        </h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Sản phẩm trong đơn -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-box me-2 text-primary"></i>
                        Sản phẩm trong đơn hàng
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Sản phẩm</th>
                                    <th class="px-4 py-3 text-center">Giá</th>
                                    <th class="px-4 py-3 text-center">Số lượng</th>
                                    <th class="px-4 py-3 text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product_name }}" 
                                                     class="rounded me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ $item->product_name }}</h6>
                                                @if($item->product)
                                                    <small class="text-muted">{{ $item->product->category->name ?? 'N/A' }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="fw-bold text-primary">{{ number_format($item->product_price) }}₫</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <span class="fw-bold text-success">{{ number_format($item->subtotal) }}₫</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-muted">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Không có sản phẩm nào trong đơn hàng
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Tổng tiền -->
                    <div class="bg-light p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tổng tiền sản phẩm:</span>
                                    <span class="fw-bold">{{ number_format($order->subtotal) }}₫</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Phí vận chuyển:</span>
                                    @if($order->shipping_fee > 0)
                                        <span class="fw-bold">{{ number_format($order->shipping_fee) }}₫</span>
                                    @else
                                        <span class="text-success fw-bold">Miễn phí</span>
                                    @endif
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="h5 fw-bold text-dark">Tổng cộng:</span>
                                    <span class="h5 fw-bold text-primary">{{ number_format($order->total_amount) }}₫</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-end">
                                    <p class="mb-1"><small class="text-muted">Mã đơn hàng:</small></p>
                                    <p class="mb-1 fw-bold text-primary">{{ $order->order_number }}</p>
                                    <p class="mb-1"><small class="text-muted">Ngày đặt:</small></p>
                                    <p class="mb-0 fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Thông tin đơn hàng -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Thông tin đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Thông tin khách hàng -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fas fa-user me-2 text-primary"></i>
                            Thông tin khách hàng
                        </h6>
                        <div class="mb-2">
                            <small class="text-muted">Tên khách hàng:</small>
                            <p class="mb-0 fw-bold">{{ $order->shipping_name ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Email:</small>
                            <p class="mb-0">{{ $order->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Điện thoại:</small>
                            <p class="mb-0">{{ $order->shipping_phone ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Địa chỉ:</small>
                            <p class="mb-0">{{ $order->shipping_address ?? 'N/A' }}</p>
                            @if($order->shipping_ward_name || $order->shipping_district_name || $order->shipping_province_name)
                                <p class="mb-0 text-muted small">
                                    {{ $order->shipping_ward_name ?? '' }}, 
                                    {{ $order->shipping_district_name ?? '' }}, 
                                    {{ $order->shipping_province_name ?? '' }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Thông tin thanh toán -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fas fa-credit-card me-2 text-primary"></i>
                            Thông tin thanh toán
                        </h6>
                        <div class="mb-2">
                            <small class="text-muted">Phương thức thanh toán:</small>
                            <p class="mb-0">
                                <span class="badge bg-info">{{ $order->payment_method_text }}</span>
                            </p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Trạng thái thanh toán:</small>
                            <p class="mb-0">
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif($order->payment_status == 'pending')
                                    <span class="badge bg-warning">Chờ thanh toán</span>
                                @elseif($order->payment_status == 'failed')
                                    <span class="badge bg-danger">Thanh toán thất bại</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->payment_status }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Ghi chú -->
                    @if($order->notes)
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fas fa-sticky-note me-2 text-primary"></i>
                            Ghi chú
                        </h6>
                        <p class="mb-0 text-muted">{{ $order->notes }}</p>
                    </div>
                    @endif
                    
                    <!-- Cập nhật trạng thái -->
                    <div class="border-top pt-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fas fa-cog me-2 text-primary"></i>
                            Cập nhật trạng thái
                        </h6>
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Trạng thái hiện tại:</label>
                                <div class="mb-2">
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
                                </div>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save me-2"></i>Cập nhật trạng thái
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    transform: translateY(-1px);
}
</style>
@endsection