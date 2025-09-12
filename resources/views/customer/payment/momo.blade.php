@extends('layouts.customer')

@section('content')
<style>
/* ===== PAYMENT STYLES ===== */
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

.payment-container {
    background: var(--bg-light);
    min-height: 100vh;
    padding: 2rem 0;
}

.payment-header {
    background: white;
    border-radius: 20px;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.payment-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.payment-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.payment-title i {
    color: var(--success-color);
    font-size: 2rem;
}

.payment-subtitle {
    color: var(--text-light);
    font-size: 1.1rem;
    margin: 0;
}

.momo-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: var(--success-color);
}

.momo-display {
    text-align: center;
    padding: 2rem;
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    border-radius: 16px;
    margin-bottom: 2rem;
    color: white;
}

.momo-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.momo-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.momo-subtitle {
    font-size: 1rem;
    opacity: 0.9;
}

.momo-info {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
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

.info-label {
    font-weight: 600;
    color: var(--text-dark);
}

.info-value {
    font-weight: 700;
    color: var(--success-color);
}

.order-info {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.total-amount {
    background: linear-gradient(135deg, var(--success-color), #059669);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    text-align: center;
    margin-bottom: 2rem;
}

.total-label {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    opacity: 0.9;
}

.total-value {
    font-size: 2rem;
    font-weight: 800;
}

.payment-steps {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.step-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.step-item:last-child {
    border-bottom: none;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--success-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.step-text {
    color: var(--text-dark);
    font-weight: 500;
}

.confirm-form {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.form-control {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 1rem;
}

.form-control:focus {
    border-color: var(--success-color);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    outline: none;
}

.btn-success {
    background: linear-gradient(135deg, var(--success-color), #059669);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.1rem;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669, var(--success-color));
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-danger {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    border: none;
    color: white;
    padding: 0.875rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, var(--danger-color));
    transform: translateY(-1px);
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .payment-container {
        padding: 1rem 0;
    }
    
    .payment-header {
        padding: 2rem 1rem;
    }
    
    .payment-title {
        font-size: 2rem;
    }
    
    .momo-section, .momo-info, .order-info, .payment-steps, .confirm-form {
        padding: 1.5rem;
    }
    
    .momo-icon {
        font-size: 3rem;
    }
    
    .total-value {
        font-size: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<div class="payment-container">
    <div class="container">
        <!-- Header -->
        <div class="payment-header">
            <h1 class="payment-title">
                <i class="fas fa-mobile-alt"></i>
                Thanh Toán Momo
            </h1>
            <p class="payment-subtitle">Chuyển khoản qua ví điện tử Momo</p>
        </div>

        <div class="row">
            <!-- Thông tin Momo -->
            <div class="col-lg-6">
                <div class="momo-section">
                    <h3 class="section-title">
                        <i class="fas fa-mobile-alt"></i>
                        Thông Tin Ví Momo
                    </h3>
                    
                    <div class="momo-display">
                        <div class="momo-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="momo-title">Ví Điện Tử Momo</div>
                        <div class="momo-subtitle">Chuyển khoản nhanh chóng và an toàn</div>
                    </div>
                </div>

                <div class="momo-info">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Thông Tin Chuyển Khoản
                    </h3>
                    
                    @if($momoPaymentMethod->momo_phone)
                        <div class="info-item">
                            <span class="info-label">Số điện thoại Momo:</span>
                            <span class="info-value">{{ $momoPaymentMethod->momo_phone }}</span>
                        </div>
                    @endif
                    
                    @if($momoPaymentMethod->momo_name)
                        <div class="info-item">
                            <span class="info-label">Tên chủ ví:</span>
                            <span class="info-value">{{ $momoPaymentMethod->momo_name }}</span>
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <span class="info-label">Nội dung chuyển khoản:</span>
                        <span class="info-value">{{ $order->order_number }}</span>
                    </div>
                </div>
            </div>

            <!-- Thông tin đơn hàng và xác nhận -->
            <div class="col-lg-6">
                <div class="order-info">
                    <h3 class="section-title">
                        <i class="fas fa-receipt"></i>
                        Thông Tin Đơn Hàng
                    </h3>
                    
                    <div class="info-item">
                        <span class="info-label">Mã đơn hàng:</span>
                        <span class="info-value">{{ $order->order_number }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Tổng tiền sản phẩm:</span>
                        <span class="info-value">{{ number_format($order->total_amount) }} VNĐ</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Phí vận chuyển:</span>
                        <span class="info-value">
                            @if($order->shipping_fee > 0)
                                {{ number_format($order->shipping_fee) }} VNĐ
                            @else
                                Miễn phí
                            @endif
                        </span>
                    </div>
                </div>

                <div class="total-amount">
                    <div class="total-label">Số tiền cần chuyển</div>
                    <div class="total-value">{{ number_format($order->final_amount) }} VNĐ</div>
                </div>

                <div class="payment-steps">
                    <h3 class="section-title">
                        <i class="fas fa-list-ol"></i>
                        Hướng Dẫn Chuyển Khoản
                    </h3>
                    
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-text">Mở ứng dụng Momo trên điện thoại</div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-text">Chọn "Chuyển tiền" → "Đến số điện thoại"</div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-text">Nhập số điện thoại: <strong>{{ $momoPaymentMethod->momo_phone }}</strong></div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-text">Nhập số tiền: <strong>{{ number_format($order->final_amount) }} VNĐ</strong></div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">5</div>
                        <div class="step-text">Nhập nội dung: <strong>{{ $order->order_number }}</strong></div>
                    </div>
                    
                    <div class="step-item">
                        <div class="step-number">6</div>
                        <div class="step-text">Xác nhận chuyển khoản và nhập mã giao dịch bên dưới</div>
                    </div>
                </div>

                <div class="confirm-form">
                    <h3 class="section-title">
                        <i class="fas fa-check-circle"></i>
                        Xác Nhận Thanh Toán
                    </h3>
                    
                    <form action="{{ route('payment.confirm-momo', $order->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="transaction_id" class="form-label">
                                Mã giao dịch Momo <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="transaction_id" 
                                   name="transaction_id" 
                                   placeholder="Nhập mã giao dịch từ Momo"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="amount" class="form-label">
                                Số tiền đã chuyển <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   id="amount" 
                                   name="amount" 
                                   value="{{ $order->final_amount }}"
                                   min="0"
                                   step="1000"
                                   required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Xác Nhận Thanh Toán
                        </button>
                    </form>
                    
                    <div class="action-buttons">
                        <form action="{{ route('payment.cancel', $order->id) }}" method="POST" class="flex-fill">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-danger w-100"
                                    onclick="return confirm('Bạn có chắc muốn hủy thanh toán?')">
                                <i class="fas fa-times me-2"></i>Hủy Thanh Toán
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus vào input mã giao dịch
    document.getElementById('transaction_id').focus();
    
    // Validate số tiền
    const amountInput = document.getElementById('amount');
    const expectedAmount = {{ $order->final_amount }};
    
    amountInput.addEventListener('input', function() {
        const enteredAmount = parseFloat(this.value);
        if (enteredAmount !== expectedAmount) {
            this.style.borderColor = 'var(--warning-color)';
        } else {
            this.style.borderColor = 'var(--success-color)';
        }
    });
});
</script>
@endsection
