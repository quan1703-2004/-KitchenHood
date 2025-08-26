@extends('layouts.customer')

@section('content')
<!-- Hero Section with Carousel -->
<section class="hero-section position-relative">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <!-- Slide 1: Máy Hút Mùi Cao Cấp -->
            <div class="carousel-item active">
                <div class="hero-slide" style="background: url({{ asset('images/banners/banner1.png') }}); background-repeat: no-repeat; background-position: center center; background-size: cover;">
                    <div class="container h-100">
                        <div class="row align-items-center h-100 py-5">
                            <div class="col-lg-6">
                                <div class="badge bg-primary px-3 py-2 rounded-pill mb-3">
                                    <i class="fas fa-star me-1"></i>SẢN PHẨM MỚI
                                </div>
                                <h1 class="display-3 fw-bold mb-4 text-dark" style="line-height: 1.1;">
                                    Máy Hút Mùi<br>
                                    <span class="text-primary">Chất Lượng Cao</span>
                                </h1>
                                <p class="lead mb-4 text-muted">
                                    Khám phá bộ sưu tập máy hút mùi cao cấp với thiết kế hiện đại, công nghệ tiên tiến và hiệu suất vượt trội cho căn bếp của bạn.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold">
                                        <i class="fas fa-shopping-cart me-2"></i>Xem Sản Phẩm
                                    </a>
                                    <a href="#features" class="btn btn-outline-primary btn-lg px-4 py-3">
                                        <i class="fas fa-info-circle me-2"></i>Tìm Hiểu Thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Khuyến Mãi Đặc Biệt -->
            <div class="carousel-item">
                <div class="hero-slide" style="background: url({{ asset('images/banners/banner2.png') }}); background-repeat: no-repeat; background-position: center center; background-size: cover;">
                    <div class="container h-100">
                        <div class="row align-items-center h-100 py-5">
                            <div class="col-lg-6">
                                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
                                    <i class="fas fa-fire me-1"></i>KHUYẾN MÃI ĐẶC BIỆT
                                </div>
                                <h1 class="display-3 fw-bold mb-4 text-dark" style="line-height: 1.1;">
                                    Giảm Giá<br>
                                    <span class="text-primary">Lên Đến 30%</span>
                                </h1>
                                <p class="lead mb-4 text-muted">
                                    Cơ hội duy nhất trong năm! Sở hữu máy hút mùi cao cấp với giá tốt nhất. Chương trình áp dụng cho tất cả sản phẩm trong bộ sưu tập.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold">
                                        <i class="fas fa-tags me-2"></i>Mua Ngay
                                    </a>
                                    <a href="#features" class="btn btn-outline-primary btn-lg px-4 py-3">
                                        <i class="fas fa-clock me-2"></i>Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Dịch Vụ Hậu Mãi -->
            <div class="carousel-item">
                <div class="hero-slide" style="background: url({{ asset('images/banners/banner3.png') }}); background-repeat: no-repeat; background-position: center center; background-size: cover;">
                    <div class="container h-100">
                        <div class="row align-items-center h-100 py-5">
                            <div class="col-lg-6">
                                <div class="badge bg-success px-3 py-2 rounded-pill mb-3">
                                    <i class="fas fa-shield-alt me-1"></i>DỊCH VỤ TỐT NHẤT
                                </div>
                                <h1 class="display-3 fw-bold mb-4 text-dark" style="line-height: 1.1;">
                                    Bảo Hành<br>
                                    <span class="text-primary">5 Năm</span>
                                </h1>
                                <p class="lead mb-4 text-muted">
                                    Đội ngũ kỹ thuật chuyên nghiệp 24/7, bảo hành chính hãng 5 năm, giao hàng miễn phí toàn quốc. Cam kết chất lượng và dịch vụ tốt nhất.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg px-4 py-3 fw-bold">
                                        <i class="fas fa-headset me-2"></i>Liên Hệ Ngay
                                    </a>
                                    <a href="#features" class="btn btn-outline-primary btn-lg px-4 py-3">
                                        <i class="fas fa-info-circle me-2"></i>Tìm Hiểu Thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-shipping-fast fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-primary">Giao Hàng Miễn Phí</h5>
                    <p class="text-muted mb-0">Miễn phí vận chuyển toàn quốc cho đơn hàng trên 5 triệu</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-success">Bảo Hành Chính Hãng</h5>
                    <p class="text-muted mb-0">Bảo hành 5 năm với đội ngũ kỹ thuật chuyên nghiệp 24/7</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-medal fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-warning">Chất Lượng Đảm Bảo</h5>
                    <p class="text-muted mb-0">Sản phẩm chính hãng với các tiêu chuẩn chất lượng quốc tế</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Best Selling Products -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold">
                <i class="fas fa-fire me-1"></i>BÁN CHẠY NHẤT
            </div>
            <h2 class="section-title display-5 fw-bold text-dark">Máy Hút Mùi Bán Chạy Nhất</h2>
            <p class="lead text-muted">Khám phá những mẫu máy hút mùi hot nhất được khách hàng lựa chọn nhiều nhất</p>
        </div>

        <div class="row g-4">
            @if(isset($latestProducts) && $latestProducts->count() > 0)
                @foreach($latestProducts->take(3) as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="card-img-top product-image">
                            @else
                                <img src="https://via.placeholder.com/300x280/cccccc/666666?text=Không+có+ảnh" 
                                     alt="{{ $product->name }}" 
                                     class="card-img-top product-image">
                            @endif
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">BÁN CHẠY</span>
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
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">Chưa có sản phẩm nào.</p>
                </div>
            @endif
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg px-5">
                Xem Tất Cả Sản Phẩm
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Tin Tức Nổi Bật -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <div class="badge bg-info text-white px-3 py-2 rounded-pill mb-3 fw-bold">
                <i class="fas fa-newspaper me-1"></i>TIN TỨC NỔI BẬT
            </div>
            <h2 class="section-title display-5 fw-bold text-dark">Cập Nhật Mới Nhất</h2>
            <p class="lead text-muted">Những thông tin hữu ích về máy hút mùi và xu hướng nhà bếp hiện đại</p>
        </div>

        <div class="row g-4">
            <!-- Tin tức 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/2c5aa0/ffffff?text=Xu+Hướng+2025" 
                             class="card-img-top" 
                             alt="Xu hướng máy hút mùi 2025"
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger">MỚI</span>
                        </div>
                        <div class="position-absolute bottom-0 end-0 m-3">
                            <small class="text-white bg-dark px-2 py-1 rounded">
                                <i class="fas fa-calendar me-1"></i>15/01/2025
                            </small>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">Xu Hướng Máy Hút Mùi 2025</h5>
                        <p class="card-text text-muted mb-3">
                            Khám phá những xu hướng mới nhất trong thiết kế và công nghệ máy hút mùi 
                            cho căn bếp hiện đại năm 2025...
                        </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tin tức 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/28a745/ffffff?text=Hướng+Dẫn+Sử+Dụng" 
                             class="card-img-top" 
                             alt="Hướng dẫn sử dụng máy hút mùi"
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success">HƯỚNG DẪN</span>
                        </div>
                        <div class="position-absolute bottom-0 end-0 m-3">
                            <small class="text-white bg-dark px-2 py-1 rounded">
                                <i class="fas fa-calendar me-1"></i>12/01/2025
                            </small>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">Cách Bảo Trì Máy Hút Mùi</h5>
                        <p class="card-text text-muted mb-3">
                            Hướng dẫn chi tiết cách vệ sinh và bảo trì máy hút mùi để đảm bảo 
                            hiệu suất tối ưu và tuổi thọ lâu dài...
                        </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tin tức 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/ffc107/000000?text=Khuyến+Mãi+Đặc+Biệt" 
                             class="card-img-top" 
                             alt="Khuyến mãi đặc biệt"
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-warning text-dark">KHUYẾN MÃI</span>
                        </div>
                        <div class="position-absolute bottom-0 end-0 m-3">
                            <small class="text-white bg-dark px-2 py-1 rounded">
                                <i class="fas fa-calendar me-1"></i>10/01/2025
                            </small>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">Khuyến Mãi Tết Nguyên Đán</h5>
                        <p class="card-text text-muted mb-3">
                            Chương trình khuyến mãi đặc biệt nhân dịp Tết Nguyên Đán với nhiều 
                            ưu đãi hấp dẫn cho khách hàng...
                        </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('news.index') }}" class="btn btn-outline-info btn-lg px-5">
                Xem Tất Cả Tin Tức
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="stats-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">15,000+</h3>
                    <p class="text-muted mb-0">Khách hàng hài lòng</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $latestProducts->count() ?? 0 }}+</h3>
                    <p class="text-muted mb-0">Sản phẩm chất lượng</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-award fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-warning">5</h3>
                    <p class="text-muted mb-0">Năm bảo hành</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center p-4 bg-white rounded-3 shadow-sm h-100 border-0">
                    <div class="feature-icon bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-info">4.9/5</h3>
                    <p class="text-muted mb-0">Đánh giá trung bình</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Thêm CSS cho giao diện sản phẩm -->
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
    
    /* Style cho tin tức */
    .news-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .news-card .card-img-top {
        transition: transform 0.3s ease;
    }
    
    .news-card:hover .card-img-top {
        transform: scale(1.05);
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
</style>

<!-- Thêm JavaScript để xử lý thêm vào giỏ hàng -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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
@endsection