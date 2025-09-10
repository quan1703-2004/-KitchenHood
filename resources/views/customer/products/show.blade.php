@extends('layouts.customer')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                    
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Quay Lại
                        </a>
                        @if($product->category)
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-tag me-1"></i>Xem Sản Phẩm Cùng Danh Mục
                        </a>
                        @endif
                    </div>

                    <!-- Hình ảnh sản phẩm -->
                    <div class="text-center mb-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="img-fluid rounded shadow" 
                                 alt="{{ $product->name }}"
                                 style="max-height: 400px; max-width: 100%;">
                        @else
                            <img src="https://via.placeholder.com/400x400/cccccc/666666?text=Không+có+ảnh" 
                                 class="img-fluid rounded shadow" 
                                 alt="{{ $product->name }}"
                                 style="max-height: 400px; max-width: 100%;">
                        @endif
                    </div>

                    <!-- Mô tả sản phẩm -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Mô Tả Sản Phẩm</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    <!-- Đặc điểm sản phẩm -->
                    @if($product->features && count($product->features) > 0)
                    <div class="mb-4">
                        <h5 class="fw-bold">Đặc Điểm Sản Phẩm</h5>
                        <div class="row g-3">
                            @foreach($product->features as $feature)
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <strong class="text-primary">{{ $feature['key'] }}:</strong>
                                    <span class="ms-2">{{ $feature['value'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Thông tin bổ sung -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Thông Tin Bổ Sung</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <strong class="text-muted">Ngày tạo:</strong>
                                    <span class="ms-2">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <strong class="text-muted">Cập nhật lần cuối:</strong>
                                    <span class="ms-2">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                       <!-- Rating tổng quan -->
                    <div class="mb-4">
                        <x-product-rating :product="$product" />
                    </div>

                    <!-- Đánh giá sản phẩm -->
                    <hr class="my-5">

                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-4">Đánh giá sản phẩm ({{ $product->reviews->count() }})</h3>

                            @forelse ($product->reviews as $review)
                                <div class="media mb-4">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $review->user->name }}</h5>
                                        <div class="text-warning mb-2">
                                            <x-rating-stars :rating="$review->rating" :showHalfStar="false" />
                                            <span class="badge bg-primary ms-2">{{ $review->rating }}/5</span>
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                        <small class="text-muted">Đăng vào {{ $review->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            @empty
                                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Gửi form đánh Giá -->
                    <hr class="my-5">

                    <div class="row">
                        <div class="col-12">
                            @auth
                                @php
                                    // Kiểm tra xem người dùng đã mua sản phẩm chưa
                                    $hasPurchased = auth()->user()->orders()
                                        ->where('status', 'delivered')
                                        ->whereHas('items', function($query) use ($product) {
                                            $query->where('product_id', $product->id);
                                        })
                                        ->exists();

                                    // Kiểm tra xem người dùng đã đánh giá chưa
                                    $hasReviewed = $product->reviews()->where('user_id', auth()->id())->exists();
                                @endphp

                                @if ($hasPurchased && !$hasReviewed)
                                    <h4 class="mb-4">Viết đánh giá của bạn</h4>
                                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="rating">Đánh giá (số sao):</label>
                                            <select name="rating" id="rating" class="form-control" required>
                                                <option value="5">5 sao (Tuyệt vời)</option>
                                                <option value="4">4 sao (Tốt)</option>
                                                <option value="3">3 sao (Bình thường)</option>
                                                <option value="2">2 sao (Tệ)</option>
                                                <option value="1">1 sao (Rất tệ)</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="comment">Bình luận:</label>
                                            <textarea name="comment" id="comment" rows="4" class="form-control" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                    </form>
                                @elseif($hasPurchased && $hasReviewed)
                                    <p class="alert alert-info">Bạn đã đánh giá sản phẩm này.</p>
                                @endif
                            @else
                                <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.</p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar thông tin -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="top: 2rem;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Thông Tin Sản Phẩm</h5>
                    
                    <!-- Giá sản phẩm -->
                    <div class="mb-4">
                        <h3 class="text-primary fw-bold mb-2">
                            {{ number_format($product->price) }} VNĐ
                        </h3>
                        <small class="text-muted">Giá đã bao gồm thuế</small>
                    </div>

                    <!-- Danh mục -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Danh Mục</h6>
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-tag me-1"></i>
                            {{ $product->category->name ?? 'N/A' }}
                        </span>
                    </div>

                    <!-- Số lượng -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Tình Trạng Kho</h6>
                        @if($product->quantity > 10)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-1"></i>
                                Còn {{ $product->quantity }} sản phẩm
                            </span>
                        @elseif($product->quantity > 0)
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Chỉ còn {{ $product->quantity }} sản phẩm
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times me-1"></i>
                                Hết hàng
                            </span>
                        @endif
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Trạng Thái</h6>
                        @if($product->is_active)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>
                                Hoạt động
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-pause-circle me-1"></i>
                                Không hoạt động
                            </span>
                        @endif
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-grid gap-2">
                        @if($product->quantity > 0 && $product->is_active)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-grid add-to-cart-form">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-shopping-cart me-2"></i>Thêm Vào Giỏ Hàng
                                </button>
                            </form>
                        @elseif($product->quantity <= 0)
                            <button class="btn btn-danger btn-lg" disabled>
                                <i class="fas fa-ban me-2"></i>Hết Hàng
                            </button>
                        @else
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="fas fa-pause me-2"></i>Không Khả Dụng
                            </button>
                        @endif
                        
                        @if($product->category)
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-tags me-2"></i>Xem Sản Phẩm Cùng Danh Mục
                        </a>
                        @endif
                        
                        <!-- Nút xem giỏ hàng -->
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-shopping-bag me-2"></i>Xem Giỏ Hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý thêm vào giỏ hàng với SweetAlert2
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const productName = '{{ $product->name }}';
            
            // Hiển thị loading
            Swal.fire({
                title: 'Đang thêm vào giỏ hàng...',
                text: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Gửi request
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng giỏ hàng
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cartCount;
                    }
                    
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: `Đã thêm "${productName}" vào giỏ hàng`,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: error.message || 'Không thể thêm sản phẩm vào giỏ hàng',
                    confirmButtonText: 'Thử lại'
                });
            });
        });
    });
});
</script> 