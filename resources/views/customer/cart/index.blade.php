@extends('layouts.customer')

@section('content')
<style>
    .cart-container{background:linear-gradient(135deg,#f5f9ff 0%,#edf4ff 100%);min-height:100vh;padding:2rem 0}
    .cart-header{background:linear-gradient(135deg,var(--primary-color) 0%,var(--primary-dark) 100%);color:#fff;border-radius:18px;padding:1.75rem 2rem;margin-bottom:2rem;text-align:center}
    .cart-item{background:#fff;border:1px solid var(--border-color);border-radius:14px;padding:1rem 1.25rem;margin-bottom:1rem;box-shadow:var(--shadow-sm);transition:transform .2s ease, box-shadow .2s ease;display:grid;grid-template-columns:120px 1fr 170px 160px 48px;gap:16px;align-items:center}
    .cart-item:hover{transform:translateY(-2px);box-shadow:var(--shadow-md)}
    .product-image{width:120px;height:120px;object-fit:cover;border-radius:12px;border:1px solid var(--border-color)}
    .product-title{font-weight:700;color:#0f172a;margin-bottom:.25rem}
    .product-meta{color:#64748b;margin-bottom:.25rem}
    .price-display{font-weight:700;color:var(--primary-color)}
    .quantity-controls{display:flex;align-items:center;gap:.5rem}
    .quantity-btn{width:36px;height:36px;border:2px solid var(--primary-color);background:#fff;color:var(--primary-color);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;cursor:pointer;transition:all .2s}
    .quantity-btn:hover{background:var(--primary-color);color:#fff}
    .quantity-input{width:64px;text-align:center;border:2px solid var(--border-color);border-radius:10px;padding:.5rem;font-weight:700;color:var(--primary-color)}
    .subtotal-display{font-size:1.1rem;font-weight:700;color:#16a34a}
    .update-btn{background:linear-gradient(135deg,var(--primary-color),var(--primary-dark));border:none;color:#fff;padding:.55rem .9rem;border-radius:10px;font-weight:700}
    .remove-btn{background:#ef4444;border:none;color:#fff;padding:.55rem .75rem;border-radius:10px}
    .order-summary{background:#fff;border:1px solid var(--border-color);border-radius:16px;padding:1.5rem;box-shadow:var(--shadow-sm);position:sticky;top:2rem}
    .summary-item{display:flex;justify-content:space-between;align-items:center;padding:.85rem 0;border-bottom:1px solid #e9ecef}
    .summary-item:last-child{border-bottom:none}
    .total-display{font-size:1.45rem;font-weight:800;color:#1e3a8a}
    .checkout-btn{background:linear-gradient(135deg,var(--primary-color),var(--primary-dark));border:none;color:#fff;padding:1rem;border-radius:12px;font-weight:800;width:100%;margin-top:1rem}
    .clear-cart-btn{background:#475569;border:none;color:#fff;padding:.8rem 1.2rem;border-radius:10px;font-weight:700}
    .continue-shopping-btn{background:#0ea5e9;border:none;color:#fff;padding:.8rem 1.2rem;border-radius:10px;font-weight:700}
    .empty-cart{text-align:center;padding:4rem 2rem;background:#fff;border-radius:16px;box-shadow:var(--shadow-sm)}
    .empty-cart i{font-size:4rem;color:#6c757d;margin-bottom:1rem}
    @media (max-width: 992px){.cart-item{grid-template-columns:100px 1fr;grid-template-rows:auto auto auto;gap:12px}.cart-item .qty-col{grid-row:2}.cart-item .subtotal-col{grid-row:2}.cart-item .remove-col{grid-row:3;justify-self:end}}
</style>

<div class="cart-container">
    <div class="container">
        <!-- Header -->
        <div class="cart-header">
            <h1 class="display-5 fw-bold mb-3">
                <i class="fas fa-shopping-cart me-3"></i>Giỏ Hàng
            </h1>
            <p class="lead mb-0">Quản lý sản phẩm trong giỏ hàng của bạn</p>
        </div>

        @if(count($cartItems) > 0)
        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark">
                        <i class="fas fa-list me-2"></i>Sản phẩm trong giỏ hàng ({{ count($cartItems) }})
                    </h4>
                </div>

                @foreach($cartItems as $item)
                <div class="cart-item" data-product-id="{{ $item['product']->id }}" data-price="{{ $item['product']->price }}">
                    <div class="img-col">
                        @if($item['product']->image)
                            <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="product-image">
                        @else
                            <img src="https://via.placeholder.com/120x120/cccccc/666666?text=Không+có+ảnh" alt="{{ $item['product']->name }}" class="product-image">
                        @endif
                    </div>
                    <div class="info-col">
                        <div class="product-title">{{ $item['product']->name }}</div>
                        <div class="product-meta">{{ $item['product']->category->name ?? 'Không phân loại' }}</div>
                        <span class="price-display">{{ number_format($item['product']->price) }} VNĐ</span>
                    </div>
                    <div class="qty-col">
                        <div class="quantity-controls">
                            <button class="quantity-btn quantity-decrease" type="button"><i class="fas fa-minus"></i></button>
                            <input type="number" class="quantity-input" value="{{ $item['quantity'] }}" min="1" max="99">
                            <button class="quantity-btn quantity-increase" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="subtotal-col text-center">
                        <div class="subtotal-display mb-2" data-subtotal="{{ $item['subtotal'] }}">{{ number_format($item['subtotal']) }} VNĐ</div>
                        <button class="update-btn btn-sm update-quantity" type="button"><i class="fas fa-sync-alt me-1"></i>Cập nhật</button>
                    </div>
                    <div class="remove-col text-end">
                        <button class="remove-btn btn-sm remove-item" type="button" data-product-id="{{ $item['product']->id }}"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                @endforeach

                <!-- Các nút hành động -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="clear-cart-btn" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                <i class="fas fa-trash me-2"></i>Xóa toàn bộ giỏ hàng
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('products.index') }}" class="continue-shopping-btn">
                            <i class="fas fa-arrow-left me-2"></i>Tiếp Tục Mua Sắm
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h4 class="fw-bold text-dark mb-4">
                        <i class="fas fa-calculator me-2"></i>Tóm Tắt Đơn Hàng
                    </h4>
                    
                    <div class="summary-item">
                        <span>Tổng tiền sản phẩm:</span>
                        <span class="price-display" id="subtotal-display">{{ number_format($total) }} VNĐ</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="summary-item">
                        <span>Tổng cộng:</span>
                        <span class="total-display" id="total-display">{{ number_format($total) }} VNĐ</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="checkout-btn">
                        <i class="fas fa-credit-card me-2"></i>Tiến Hành Thanh Toán
                    </a>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>Thanh toán an toàn
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Giỏ hàng trống -->
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3 class="text-dark mb-3">Giỏ hàng của bạn đang trống</h3>
            <p class="text-muted mb-4">Hãy thêm một số sản phẩm vào giỏ hàng để bắt đầu mua sắm!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Mua Sắm Ngay
            </a>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các biến
    let cartItems = document.querySelectorAll('.cart-item');
    let subtotalDisplay = document.getElementById('subtotal-display');
    let totalDisplay = document.getElementById('total-display');
    
    // Hàm tính toán tổng tiền
    function calculateTotal() {
        let subtotal = 0;
        cartItems.forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            const price = parseFloat(item.dataset.price);
            const itemSubtotal = quantity * price;
            
            // Cập nhật subtotal của item
            const subtotalElement = item.querySelector('.subtotal-display');
            subtotalElement.textContent = numberFormat(itemSubtotal) + ' VNĐ';
            subtotalElement.dataset.subtotal = itemSubtotal;
            
            subtotal += itemSubtotal;
        });
        
        // Cập nhật hiển thị
        subtotalDisplay.textContent = numberFormat(subtotal) + ' VNĐ';
        totalDisplay.textContent = numberFormat(subtotal) + ' VNĐ';
        
        return subtotal;
    }
    
    // Hàm format số tiền
    function numberFormat(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }
    
    // Xử lý tăng/giảm số lượng
    cartItems.forEach(item => {
        const decreaseBtn = item.querySelector('.quantity-decrease');
        const increaseBtn = item.querySelector('.quantity-increase');
        const quantityInput = item.querySelector('.quantity-input');
        const subtotalElement = item.querySelector('.subtotal-display');
        
        // Giảm số lượng
        decreaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateItemSubtotal();
            }
        });
        
        // Tăng số lượng
        increaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < 99) {
                quantityInput.value = currentValue + 1;
                updateItemSubtotal();
            }
        });
        
        // Thay đổi số lượng bằng input
        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > 99) this.value = 99;
            updateItemSubtotal();
        });
        
        // Cập nhật subtotal của item
        function updateItemSubtotal() {
            const quantity = parseInt(quantityInput.value);
            const price = parseFloat(item.dataset.price);
            const subtotal = quantity * price;
            
            subtotalElement.textContent = numberFormat(subtotal) + ' VNĐ';
            subtotalElement.dataset.subtotal = subtotal;
        }
    });
    
    // Xử lý cập nhật số lượng
    document.querySelectorAll('.update-quantity').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.cart-item');
            const productId = item.dataset.productId;
            const quantity = item.querySelector('.quantity-input').value;
            
            // Hiển thị loading
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang cập nhật...';
            this.disabled = true;
            
            // Gửi request cập nhật
            fetch(`{{ url('/cart/update') }}/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(async response => {
                const text = await response.text();
                try { return JSON.parse(text); } catch (_) { return { success: response.ok, message: text }; }
            })
            .then(data => {
                if (data.success) {
                    // Cập nhật tổng tiền
                    calculateTotal();
                    
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Đã cập nhật số lượng sản phẩm',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: error.message || 'Không thể cập nhật số lượng',
                    confirmButtonText: 'Thử lại'
                });
            })
            .finally(() => {
                // Khôi phục nút
                this.innerHTML = '<i class="fas fa-sync-alt me-1"></i>Cập nhật';
                this.disabled = false;
            });
        });
    });
    
    // Xử lý xóa sản phẩm
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const item = this.closest('.cart-item');
            
            Swal.fire({
                title: 'Xác nhận xóa',
                text: 'Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Hiển thị loading
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;
                    
                    // Gửi request xóa
                    fetch(`{{ url('/cart/remove') }}/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(async response => {
                        const text = await response.text();
                        try { return JSON.parse(text); } catch (_) { return { success: response.ok, message: text }; }
                    })
                    .then(data => {
                        if (data.success) {
                            // Xóa item khỏi DOM
                            item.remove();
                            
                            // Cập nhật tổng tiền
                            calculateTotal();
                            
                            // Cập nhật số lượng giỏ hàng
                            const cartCount = document.getElementById('cart-count');
                            if (cartCount) {
                                cartCount.textContent = data.cartCount;
                            }
                            
                            // Kiểm tra nếu giỏ hàng trống
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Đã xóa sản phẩm khỏi giỏ hàng',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            throw new Error(data.message || 'Có lỗi xảy ra');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: error.message || 'Không thể xóa sản phẩm',
                            confirmButtonText: 'Thử lại'
                        });
                        
                        // Khôi phục nút
                        this.innerHTML = '<i class="fas fa-trash"></i>';
                        this.disabled = false;
                    });
                }
            });
        });
    });
    
    // Khởi tạo tổng tiền
    calculateTotal();
});
</script>
@endsection
