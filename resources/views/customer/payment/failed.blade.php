@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <!-- Header thất bại -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="error-icon mb-4">
                <div class="error-circle bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-times fa-3x"></i>
                </div>
            </div>
            <h1 class="display-4 fw-bold text-danger mb-3">Thanh Toán Thất Bại!</h1>
            <p class="lead text-muted mb-4">
                Rất tiếc, giao dịch của bạn không thể hoàn thành. Vui lòng thử lại hoặc chọn phương thức thanh toán khác.
            </p>
            @if(isset($order))
            <div class="alert alert-warning d-inline-block">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Mã đơn hàng: <strong class="text-dark">{{ $order->order_number }}</strong>
            </div>
            @endif
        </div>
    </div>

    @if(session('error'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Thông tin đơn hàng -->
        @if(isset($order))
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Thông Tin Đơn Hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Thông tin khách hàng -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-user me-2 text-danger"></i>
                                Thông Tin Khách Hàng
                            </h6>
                            <div class="customer-info">
                                <p class="mb-2">
                                    <strong>Tên:</strong> {{ $order->customer_name }}
                                </p>
                                <p class="mb-2">
                                    <strong>Email:</strong> {{ $order->customer_email }}
                                </p>
                                <p class="mb-2">
                                    <strong>Số điện thoại:</strong> {{ $order->customer_phone }}
                                </p>
                                <p class="mb-0">
                                    <strong>Địa chỉ:</strong> {{ $order->customer_address }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-credit-card me-2 text-danger"></i>
                                Thông Tin Thanh Toán
                            </h6>
                            <div class="payment-info">
                                <p class="mb-2">
                                    <strong>Phương thức:</strong> {{ $order->payment_method_text }}
                                </p>
                                <p class="mb-2">
                                    <strong>Trạng thái:</strong> 
                                    <span class="badge bg-warning text-dark">{{ $order->status_text }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                                @if($order->notes)
                                <p class="mb-0">
                                    <strong>Ghi chú:</strong> {{ $order->notes }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách sản phẩm -->
                    <div class="order-products">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fas fa-shopping-bag me-2 text-danger"></i>
                            Sản Phẩm Trong Đơn Hàng
                        </h6>
                        @foreach($order->items as $item)
                        <div class="order-product-item d-flex align-items-center p-3 border rounded mb-3">
                            <div class="product-image me-3">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         class="rounded" 
                                         style="width: 60px; height: 60px; object-fit: cover;"
                                         alt="{{ $item->product_name }}">
                                @else
                                    <img src="https://via.placeholder.com/60x60/cccccc/666666?text=Không+có+ảnh" 
                                         class="rounded" 
                                         style="width: 60px; height: 60px;"
                                         alt="{{ $item->product_name }}">
                                @endif
                            </div>
                            <div class="product-details flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark">{{ $item->product_name }}</h6>
                                <p class="mb-0 text-muted small">
                                    {{ number_format($item->product_price) }} VNĐ × {{ $item->quantity }}
                                </p>
                            </div>
                            <div class="product-total">
                                <span class="fw-bold text-danger fs-5">{{ number_format($item->subtotal) }} VNĐ</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Tổng tiền -->
                    <div class="order-total mt-4">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="total-breakdown">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Tổng tiền sản phẩm:</span>
                                        <span class="fw-bold">{{ number_format($order->subtotal) }} VNĐ</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Phí vận chuyển:</span>
                                        @if($order->shipping_fee > 0)
                                            <span class="fw-bold">{{ number_format($order->shipping_fee) }} VNĐ</span>
                                        @else
                                            <span class="text-success fw-bold">Miễn phí</span>
                                        @endif
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 fw-bold text-dark">Tổng cộng:</span>
                                        <span class="h5 fw-bold text-danger">{{ number_format($order->total_amount) }} VNĐ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Hành động -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Hành Động Tiếp Theo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        @if(isset($order))
                        <div class="d-grid gap-3 mb-4">
                            <!-- Thanh toán lại -->
                            @if($order->payment_method === 'momo')
                            <form action="{{ route('payment.momo.pay-again', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-redo me-2"></i>
                                    Thanh Toán Lại Bằng MoMo
                                </button>
                            </form>
                            @endif
                            
                            <!-- Chuyển sang COD -->
                            <form action="{{ route('payment.switch-to-cod', $order->id) }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn chuyển sang thanh toán COD?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    Chuyển Sang Thanh Toán COD
                                </button>
                            </form>
                            
                            <!-- Hủy đơn hàng -->
                            <form action="{{ route('payment.cancel-order', $order->id) }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Giỏ hàng sẽ được khôi phục.')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-times me-2"></i>
                                    Hủy Đơn Hàng
                                </button>
                            </form>
                        </div>
                        @endif
                        
                        <!-- Các hành động khác -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i>
                                Tiếp Tục Mua Sắm
                            </a>
                            
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-info">
                                <i class="fas fa-list me-2"></i>
                                Xem Lịch Sử Đơn Hàng
                            </a>
                            
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>
                                Về Trang Chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thông tin hỗ trợ -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-headset me-2"></i>
                        Cần Hỗ Trợ?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="support-info">
                        <div class="support-item mb-3">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="fas fa-phone me-2 text-info"></i>
                                Hotline hỗ trợ
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>1900-xxxx</strong><br>
                                Thời gian: 8:00 - 22:00 hàng ngày
                            </p>
                        </div>
                        
                        <div class="support-item mb-3">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="fas fa-envelope me-2 text-info"></i>
                                Email hỗ trợ
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>support@kitchenhood.com</strong><br>
                                Phản hồi trong 24h
                            </p>
                        </div>
                        
                        <div class="support-item">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="fas fa-comments me-2 text-info"></i>
                                Chat trực tuyến
                            </h6>
                            <p class="text-muted small mb-0">
                                Hỗ trợ trực tiếp qua chat<br>
                                Thời gian: 9:00 - 21:00
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
.error-circle {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

.order-product-item {
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.order-product-item:hover {
    background-color: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.total-breakdown {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.support-item {
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.support-item:hover {
    background-color: #e9ecef;
    transform: translateX(5px);
}

.btn-primary {
    background: linear-gradient(135deg, #d82d8b 0%, #e91e63 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #c2185b 0%, #d81b60 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .error-circle {
        width: 80px !important;
        height: 80px !important;
    }
    
    .error-circle i {
        font-size: 2rem !important;
    }
    
    .order-product-item {
        flex-direction: column;
        text-align: center;
    }
    
    .product-image {
        margin-bottom: 1rem;
    }
    
    .product-total {
        margin-top: 1rem;
    }
}
</style>
@endsection
