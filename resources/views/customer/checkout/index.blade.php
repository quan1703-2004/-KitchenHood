@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <!-- Header thanh toán -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <div class="checkout-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-credit-card fa-lg"></i>
                </div>
                <div>
                    <h1 class="h2 mb-0 fw-bold text-dark">Thanh Toán</h1>
                    <p class="text-muted mb-0">Hoàn tất thông tin để đặt hàng</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form thông tin khách hàng -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-user me-2 text-primary"></i>
                        Thông Tin Khách Hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Họ và tên -->
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label fw-bold text-dark">
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       value="{{ old('customer_name') }}" 
                                       placeholder="Nhập họ và tên đầy đủ"
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label fw-bold text-dark">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       id="customer_email" 
                                       name="customer_email" 
                                       value="{{ old('customer_email') }}" 
                                       placeholder="example@email.com"
                                       required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Số điện thoại -->
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label fw-bold text-dark">
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="{{ old('customer_phone') }}" 
                                       placeholder="0123456789"
                                       required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Phương thức thanh toán -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label fw-bold text-dark">
                                    Phương thức thanh toán <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" 
                                        id="payment_method" 
                                        name="payment_method" 
                                        required>
                                    <option value="">Chọn phương thức thanh toán</option>
                                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>
                                        Thanh toán khi nhận hàng (COD)
                                    </option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>
                                        Chuyển khoản ngân hàng
                                    </option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Địa chỉ giao hàng -->
                        <div class="mb-3">
                            <label for="customer_address" class="form-label fw-bold text-dark">
                                Địa chỉ giao hàng <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                      id="customer_address" 
                                      name="customer_address" 
                                      rows="3" 
                                      placeholder="Nhập địa chỉ giao hàng chi tiết (số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố)"
                                      required>{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Ghi chú -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold text-dark">
                                Ghi chú (không bắt buộc)
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="2" 
                                      placeholder="Ghi chú thêm về đơn hàng hoặc yêu cầu đặc biệt">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Thông tin bổ sung -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle fa-lg text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-2">Thông tin bổ sung:</h6>
                                    <ul class="mb-0 small">
                                        <li>Đơn hàng sẽ được xử lý trong vòng 24-48 giờ</li>
                                        <li>Thời gian giao hàng: 2-5 ngày làm việc</li>
                                        <li>Miễn phí vận chuyển cho đơn hàng trên 5 triệu VNĐ</li>
                                        <li>Hỗ trợ đổi trả trong vòng 7 ngày</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nút đặt hàng -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold" id="submitOrder">
                                <i class="fas fa-check-circle me-2"></i>
                                Đặt Hàng Ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Tóm tắt đơn hàng -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Tóm Tắt Đơn Hàng
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Danh sách sản phẩm -->
                    <div class="order-items mb-3">
                        @foreach($cartItems as $item)
                        <div class="order-item d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="order-item-image me-3">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                         class="rounded" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         alt="{{ $item['product']->name }}">
                                @else
                                    <img src="https://via.placeholder.com/50x50/cccccc/666666?text=Không+có+ảnh" 
                                         class="rounded" 
                                         style="width: 50px; height: 50px;"
                                         alt="{{ $item['product']->name }}">
                                @endif
                            </div>
                            <div class="order-item-details flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark small">{{ $item['product']->name }}</h6>
                                <p class="mb-0 text-muted small">
                                    {{ number_format($item['product']->price) }} VNĐ × {{ $item['quantity'] }}
                                </p>
                            </div>
                            <div class="order-item-total">
                                <span class="fw-bold text-primary">{{ number_format($item['subtotal']) }} VNĐ</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Tổng tiền -->
                    <div class="order-summary">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Tổng tiền sản phẩm:</span>
                            <span class="fw-bold">{{ number_format($total) }} VNĐ</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Phí vận chuyển:</span>
                            @if($shippingFee > 0)
                                <span class="fw-bold">{{ number_format($shippingFee) }} VNĐ</span>
                            @else
                                <span class="text-success fw-bold">Miễn phí</span>
                            @endif
                        </div>
                        
                        @if($shippingFee > 0)
                            <div class="alert alert-info small mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                Mua thêm <strong>{{ number_format(5000000 - $total) }} VNĐ</strong> để được miễn phí vận chuyển!
                            </div>
                        @endif
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 fw-bold text-dark">Tổng cộng:</span>
                            <span class="h5 fw-bold text-primary">{{ number_format($finalTotal) }} VNĐ</span>
                        </div>
                    </div>
                    
                    <!-- Thông tin bảo mật -->
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i>
                            Thông tin của bạn được bảo mật
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quay lại giỏ hàng -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay Lại Giỏ Hàng
            </a>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
.checkout-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.order-item {
    transition: all 0.3s ease;
}

.order-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 8px;
    margin: -8px;
}

.sticky-top {
    z-index: 1020;
}

.form-control:focus,
.form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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
    .sticky-top {
        position: static !important;
        margin-top: 2rem;
    }
}
</style>

<!-- JavaScript cho form validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitOrder');
    
    // Xử lý submit form
    form.addEventListener('submit', function(e) {
        // Disable nút submit để tránh double submit
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
        
        // Form sẽ được submit bình thường
    });
    
    // Validation cho số điện thoại
    const phoneInput = document.getElementById('customer_phone');
    phoneInput.addEventListener('input', function() {
        // Chỉ cho phép nhập số
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Giới hạn độ dài
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });
    
    // Validation cho email
    const emailInput = document.getElementById('customer_email');
    emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            this.classList.add('is-invalid');
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'Email không hợp lệ';
                this.parentNode.appendChild(feedback);
            }
        } else {
            this.classList.remove('is-invalid');
            const feedback = this.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.remove();
            }
        }
    });
});
</script>
@endsection
