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
            @forelse($news as $article)
            <div class="col-lg-4 col-md-6">
                <div class="card news-card h-100">
                    <div class="position-relative">
                        <img src="{{ $article->image_url }}" 
                             class="card-img-top" 
                             alt="{{ $article->title }}"
                             style="height: 250px; object-fit: cover;">
                        @if($article->is_featured)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger">NỔI BẬT</span>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary">{{ strtoupper($article->category) }}</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-meta mb-2">
                            <i class="fas fa-calendar me-1"></i>{{ $article->formatted_date }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>{{ $article->author }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-eye me-1"></i>{{ $article->views }} lượt xem
                        </div>
                        <h5 class="card-title fw-bold mb-3">{{ $article->title }}</h5>
                        <p class="news-excerpt mb-3">
                            {{ $article->excerpt }}
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('news.show', $article->slug) }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-right me-2"></i>Đọc thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-newspaper fa-3x mb-3"></i>
                    <h4>Không có tin tức nào</h4>
                    <p>Vui lòng quay lại sau hoặc liên hệ với chúng tôi</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="News pagination">
                    {{ $news->appends(request()->query())->links() }}
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
