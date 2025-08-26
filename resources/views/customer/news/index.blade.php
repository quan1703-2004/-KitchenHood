@extends('layouts.customer')

@section('content')
<style>
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
    
    .news-meta {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .news-excerpt {
        color: #6c757d;
        line-height: 1.6;
    }
    
    .category-filter {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
</style>

<div class="bg-light py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active">Tin tức</li>
            </ol>
        </nav>
        
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="badge bg-info text-white px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-newspaper me-1"></i>TIN TỨC
                </div>
                <h1 class="display-4 fw-bold text-dark mb-3">Tin Tức & Cập Nhật</h1>
                <p class="lead text-muted">
                    Cập nhật những thông tin mới nhất về máy hút mùi, xu hướng nhà bếp và khuyến mãi đặc biệt
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
                                <i class="fas fa-filter me-2 text-primary"></i>Lọc Tin Tức
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 flex-wrap justify-content-md-end">
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-tags me-1"></i>Danh mục
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Tất cả</a></li>
                                        <li><a class="dropdown-item" href="#">Xu hướng</a></li>
                                        <li><a class="dropdown-item" href="#">Hướng dẫn</a></li>
                                        <li><a class="dropdown-item" href="#">Khuyến mãi</a></li>
                                        <li><a class="dropdown-item" href="#">Công nghệ</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-sort me-1"></i>Sắp xếp
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Mới nhất</a></li>
                                        <li><a class="dropdown-item" href="#">Cũ nhất</a></li>
                                        <li><a class="dropdown-item" href="#">Nổi bật</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Grid -->
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
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary">XU HƯỚNG</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>15/01/2025
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>Admin
                        </div>
                        <h5 class="card-title fw-bold mb-3">Xu Hướng Máy Hút Mùi 2025</h5>
                        <p class="news-excerpt mb-3">
                            Khám phá những xu hướng mới nhất trong thiết kế và công nghệ máy hút mùi 
                            cho căn bếp hiện đại năm 2025. Từ thiết kế tối giản đến công nghệ thông minh...
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
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>12/01/2025
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>Admin
                        </div>
                        <h5 class="card-title fw-bold mb-3">Cách Bảo Trì Máy Hút Mùi</h5>
                        <p class="news-excerpt mb-3">
                            Hướng dẫn chi tiết cách vệ sinh và bảo trì máy hút mùi để đảm bảo 
                            hiệu suất tối ưu và tuổi thọ lâu dài. Những mẹo nhỏ nhưng rất hữu ích...
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
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>10/01/2025
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>Admin
                        </div>
                        <h5 class="card-title fw-bold mb-3">Khuyến Mãi Tết Nguyên Đán</h5>
                        <p class="news-excerpt mb-3">
                            Chương trình khuyến mãi đặc biệt nhân dịp Tết Nguyên Đán với nhiều 
                            ưu đãi hấp dẫn cho khách hàng. Giảm giá lên đến 30%...
                        </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tin tức 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/dc3545/ffffff?text=Công+Nghệ+Mới" 
                             class="card-img-top" 
                             alt="Công nghệ mới"
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-info">CÔNG NGHỆ</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>08/01/2025
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>Admin
                        </div>
                        <h5 class="card-title fw-bold mb-3">Công Nghệ Lọc Không Khí Mới</h5>
                        <p class="news-excerpt mb-3">
                            Khám phá công nghệ lọc không khí tiên tiến mới nhất được tích hợp 
                            trong các dòng máy hút mùi cao cấp hiện nay...
                        </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tin tức 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/6f42c1/ffffff?text=Thiết+Kế+Hiện+Đại" 
                             class="card-img-top" 
                             alt="Thiết kế hiện đại"
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-secondary">THIẾT KẾ</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>05/01/2025
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>Admin
                        </div>
                        <h5 class="card-title fw-bold mb-3">Thiết Kế Nhà Bếp Hiện Đại</h5>
                        <p class="news-excerpt mb-3">
                            Những xu hướng thiết kế nhà bếp hiện đại kết hợp với máy hút mùi 
                            để tạo nên không gian bếp hoàn hảo và tiện nghi...
                        </p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tin tức 6 -->
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/400x250/20c997/ffffff?text=Tiết+Kiệm+Năng+Lượng" 
                             class="card-img-top" 
                             alt="Tiết kiệm năng lượng"
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success">TIẾT KIỆM</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>03/01/2025
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>Admin
                        </div>
                        <h5 class="card-title fw-bold mb-3">Máy Hút Mùi Tiết Kiệm Điện</h5>
                        <p class="news-excerpt mb-3">
                            Cách chọn và sử dụng máy hút mùi để tiết kiệm điện năng hiệu quả 
                            mà vẫn đảm bảo hiệu suất hoạt động tối ưu...
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

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="News pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Trước</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Đăng ký nhận tin tức mới nhất</h3>
                <p class="mb-0">Nhận thông báo về tin tức mới và khuyến mãi đặc biệt</p>
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
