@extends('layouts.customer')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 70vh;">
    <div class="container h-100">
        <div class="row align-items-center h-100 py-5">
            <div class="col-lg-6 text-white">
                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
                    <i class="fas fa-star me-1"></i>SẢN PHẨM MỚI
                </div>
                <h1 class="display-3 fw-bold mb-4" style="line-height: 1.1;">
                    Máy Hút Mùi<br>
                    <span class="text-warning">Chất Lượng Cao</span>
                </h1>
                <p class="lead mb-4 opacity-90">
                    Khám phá bộ sưu tập máy hút mùi cao cấp với thiết kế hiện đại, công nghệ tiên tiến và hiệu suất vượt trội cho căn bếp của bạn.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg px-4 py-3 fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i>Xem Sản Phẩm
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-info-circle me-2"></i>Tìm Hiểu Thêm
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image position-relative">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Máy Hút Mùi Cao Cấp" 
                         class="img-fluid rounded-3 shadow-lg">
                    <div class="position-absolute top-0 end-0 m-3">
                        <div class="badge bg-success fs-6 px-3 py-2">
                            <i class="fas fa-check me-1"></i>Chất lượng 5 sao
                            <div class="text-warning mt-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Decorative elements -->
    <div class="position-absolute bottom-0 start-0 w-100" style="height: 100px; background: linear-gradient(to top, rgba(255,255,255,0.1), transparent);"></div>
</section>

<!-- Features Section -->
<section id="features" class="features-section py-5 bg-light">
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
                    <div class="product-card card shadow-sm h-100">
                        <div class="position-relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="product-image card-img-top w-100" 
                                     alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/300x280/cccccc/666666?text=Không+có+ảnh" 
                                     class="product-image card-img-top w-100" 
                                     alt="{{ $product->name }}">
                            @endif
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger fw-bold">BÁN CHẠY</span>
                            </div>
                            <div class="position-absolute top-0 end-0 m-3">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <small class="text-white bg-dark px-2 py-1 rounded ms-1">(97 đánh giá)</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <div class="mb-3">
                                <span class="badge bg-info me-2">
                                    <i class="fas fa-tag me-1"></i>{{ $product->category->name ?? 'N/A' }}
                                </span>
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Còn hàng
                                </span>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="price-tag badge px-3 py-2 fs-6">
                                        {{ number_format($product->price) }} VNĐ
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-custom text-white">
                                        <i class="fas fa-shopping-cart me-2"></i>Thêm Vào Giỏ Hàng
                                    </a>
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

<!-- Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">15,000+</h3>
                    <p class="text-muted mb-0">Khách hàng hài lòng</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">{{ $latestProducts->count() ?? 0 }}+</h3>
                    <p class="text-muted mb-0">Sản phẩm chất lượng</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-award fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">5</h3>
                    <p class="text-muted mb-0">Năm bảo hành</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">4.9/5</h3>
                    <p class="text-muted mb-0">Đánh giá trung bình</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection