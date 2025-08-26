@extends('layouts.customer')

@section('content')
<style>
    .product-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .product-image {
        height: 280px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .price-tag {
        background: linear-gradient(45deg, #ffc107, #ffca28);
        color: #000;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .btn-add-cart {
        background: linear-gradient(45deg, #2c5aa0, #1e40af);
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(44, 90, 160, 0.3);
    }
    
    .category-filter {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .rating-stars {
        color: #ffc107;
    }
    
    /* Style cho số lượng sản phẩm - làm nổi bật với màu nền xanh */
    .stock-badge {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }
    
    .stock-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
    }
    
    /* Đảm bảo icon hiển thị đúng */
    .fas, .far, .fab {
        display: inline-block !important;
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
    }
    
    /* Fallback cho icon nếu Font Awesome không load được */
    .icon-fallback {
        font-family: Arial, sans-serif;
        font-weight: bold;
        color: inherit;
    }
</style>

<div class="bg-light py-5">
    <div class="container">
        <!-- Breadcrumb -->
        @if(request('category'))
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Tất cả sản phẩm</a></li>
                <li class="breadcrumb-item active">{{ $categories->firstWhere('id', request('category'))->name ?? '' }}</li>
            </ol>
        </nav>
        @endif
        
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-wind me-1" title="Sản phẩm"></i>SẢN PHẨM
                </div>
                <h1 class="display-4 fw-bold text-dark mb-3">
                    @if(request('category'))
                        {{ $categories->firstWhere('id', request('category'))->name ?? 'Máy Hút Mùi' }}
                    @else
                        Máy Hút Mùi Chất Lượng Cao
                    @endif
                </h1>
                <p class="lead text-muted">
                    @if(request('category'))
                        Khám phá sản phẩm trong danh mục {{ $categories->firstWhere('id', request('category'))->name ?? '' }}
                        <span class="badge bg-primary ms-2">{{ $products->total() }} sản phẩm</span>
                    @else
                        Khám phá bộ sưu tập máy hút mùi hiện đại với công nghệ tiên tiến
                        <span class="badge bg-primary ms-2">{{ $products->total() }} sản phẩm</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="category-filter">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3 mb-md-0">
                                <i class="fas fa-filter me-2 text-primary" title="Lọc"></i>Lọc Sản Phẩm
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 flex-wrap justify-content-md-end">
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-tags me-1" title="Danh mục"></i>Lọc theo danh mục
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item {{ !request('category') ? 'active' : '' }}" href="{{ route('products.index') }}">Tất cả danh mục</a></li>
                                        @foreach($categories as $category)
                                        <li><a class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}" href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-sort me-1" title="Sắp xếp"></i>Sắp xếp
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Giá thấp đến cao</a></li>
                                        <li><a class="dropdown-item" href="#">Giá cao đến thấp</a></li>
                                        <li><a class="dropdown-item" href="#">Mới nhất</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top product-image">
                        @else
                            <img src="https://via.placeholder.com/300x280/cccccc/666666?text=Không+có+ảnh" alt="{{ $product->name }}" class="card-img-top product-image">
                        @endif
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">Mới</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'Không phân loại' }}</span>
                        </div>
                        <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="rating-stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-muted ms-2">(4.5)</span>
                        </div>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="price-tag px-3 py-2 rounded-pill">{{ number_format($product->price) }} VNĐ</span>
                                <span class="stock-badge">Còn: {{ $product->quantity ?? 0 }}</span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                                </a>
                                                                 @if($product->quantity > 0 && $product->is_active)
                                     <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                         @csrf
                                         <button type="submit" class="btn btn-add-cart text-white w-100">
                                             <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                                         </button>
                                     </form>
                                 @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>Hết hàng
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <h4>Không có sản phẩm nào</h4>
                    <p>Vui lòng quay lại sau hoặc liên hệ với chúng tôi</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Product pagination">
                    {{ $products->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Newsletter Section -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Đăng ký nhận thông tin mới nhất</h3>
                <p class="mb-0">Nhận thông báo về sản phẩm mới và khuyến mãi đặc biệt</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email của bạn">
                    <button class="btn btn-warning" type="button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
// Kiểm tra Font Awesome có load được không
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra xem Font Awesome có hoạt động không
    const testIcon = document.createElement('i');
    testIcon.className = 'fas fa-check';
    testIcon.style.display = 'none';
    document.body.appendChild(testIcon);
    
    // Nếu icon không hiển thị, thêm fallback
    if (getComputedStyle(testIcon, ':before').content === 'none') {
        console.log('Font Awesome không load được, sử dụng fallback');
        // Thêm class fallback cho tất cả icon
        document.querySelectorAll('.fas, .far, .fab').forEach(icon => {
            icon.classList.add('icon-fallback');
        });
    }
    
    document.body.removeChild(testIcon);
    
    // Xử lý thêm vào giỏ hàng với SweetAlert2
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const productName = this.closest('.card').querySelector('.card-title').textContent;
            
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
