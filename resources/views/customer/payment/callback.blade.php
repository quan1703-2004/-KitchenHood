@extends('layouts.customer')

@section('title', $success ? 'Thanh Toán Thành Công' : 'Thanh Toán Thất Bại')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    @if($success)
                        <!-- Thành công -->
                        <div class="mb-4">
                            <div class="payment-icon mx-auto mb-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h2 class="text-success mb-3">Thanh Toán Thành Công!</h2>
                            <p class="text-muted mb-4">{{ $message }}</p>
                        </div>
                        
                        <!-- Thông tin đơn hàng -->
                        <div class="bg-light rounded p-4 mb-4">
                            <h5 class="text-dark mb-3">
                                <i class="fas fa-receipt me-2"></i>
                                Thông Tin Đơn Hàng
                            </h5>
                            <div class="row text-start">
                                <div class="col-6">
                                    <strong>Mã đơn hàng:</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-primary fw-bold">#{{ $order->order_number }}</span>
                                </div>
                                <div class="col-6">
                                    <strong>Tổng tiền:</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-success fw-bold">{{ number_format($order->total_amount) }} VNĐ</span>
                                </div>
                                <div class="col-6">
                                    <strong>Trạng thái:</strong>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-success">Đã thanh toán</span>
                                </div>
                                <div class="col-6">
                                    <strong>Ngày đặt:</strong>
                                </div>
                                <div class="col-6">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nút hành động -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-eye me-2"></i>
                                Xem Chi Tiết Đơn Hàng
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>
                                Xem Tất Cả Đơn Hàng
                            </a>
                            <a href="{{ route('customer.welcome') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>
                                Về Trang Chủ
                            </a>
                        </div>
                        
                    @else
                        <!-- Thất bại -->
                        <div class="mb-4">
                            <div class="payment-icon-failed mx-auto mb-3">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <h2 class="text-danger mb-3">Thanh Toán Thất Bại</h2>
                            <p class="text-muted mb-4">{{ $message }}</p>
                        </div>
                        
                        <!-- Thông tin đơn hàng -->
                        <div class="bg-light rounded p-4 mb-4">
                            <h5 class="text-dark mb-3">
                                <i class="fas fa-receipt me-2"></i>
                                Thông Tin Đơn Hàng
                            </h5>
                            <div class="row text-start">
                                <div class="col-6">
                                    <strong>Mã đơn hàng:</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-primary fw-bold">#{{ $order->order_number }}</span>
                                </div>
                                <div class="col-6">
                                    <strong>Tổng tiền:</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-danger fw-bold">{{ number_format($order->total_amount) }} VNĐ</span>
                                </div>
                                <div class="col-6">
                                    <strong>Trạng thái:</strong>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-warning">Chờ thanh toán</span>
                                </div>
                                <div class="col-6">
                                    <strong>Ngày đặt:</strong>
                                </div>
                                <div class="col-6">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nút hành động -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('payment.momo', $order->id) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-redo me-2"></i>
                                Thử Lại Thanh Toán
                            </a>
                            <form action="{{ route('payment.switch-to-cod', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success" 
                                        onclick="return confirm('Bạn có chắc chắn muốn chuyển sang thanh toán khi nhận hàng (COD)?')">
                                    <i class="fas fa-truck me-2"></i>
                                    Chuyển Sang COD
                                </button>
                            </form>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>
                                Xem Chi Tiết Đơn Hàng
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i>
                                Xem Tất Cả Đơn Hàng
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
.payment-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
}

.payment-icon-failed {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.bg-light {
    background-color: #f8f9fa !important;
    border-radius: 12px;
    padding: 1.5rem;
}
</style>
@endsection
