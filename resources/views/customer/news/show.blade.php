@extends('layouts.customer')

@section('content')
<style>
    .news-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .news-content h2 {
        color: #2c5aa0;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    
    .news-content h3 {
        color: #2c5aa0;
        margin-top: 1.5rem;
        margin-bottom: 0.8rem;
        font-weight: 600;
    }
    
    .news-content p {
        margin-bottom: 1rem;
        text-align: justify;
    }
    
    .news-content ul, .news-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .news-content li {
        margin-bottom: 0.5rem;
    }
    
    .news-meta {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .related-news-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .related-news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .related-news-card .card-img-top {
        transition: transform 0.3s ease;
        height: 200px;
        object-fit: cover;
    }
    
    .related-news-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .sidebar-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }
    
    .sidebar-title {
        color: #2c5aa0;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #2c5aa0;
    }
</style>

<div class="bg-light py-3">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Tin tức</a></li>
                <li class="breadcrumb-item active">{{ $news->title }}</li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="bg-white rounded-3 p-4 shadow-sm">
                    <!-- Article Header -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($news->is_featured)
                                <span class="badge bg-danger">NỔI BẬT</span>
                            @endif
                            <span class="badge bg-primary">{{ strtoupper($news->category) }}</span>
                        </div>
                        
                        <h1 class="display-5 fw-bold text-dark mb-3">{{ $news->title }}</h1>
                        
                        <div class="news-meta mb-3">
                            <i class="fas fa-calendar me-1"></i>{{ $news->formatted_date }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>{{ $news->author }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-eye me-1"></i>{{ $news->views }} lượt xem
                        </div>
                    </div>
                    
                    <!-- Article Image -->
                    <div class="mb-4">
                        <img src="{{ $news->image_url }}" 
                             alt="{{ $news->title }}" 
                             class="img-fluid rounded-3 w-100"
                             style="height: 400px; object-fit: cover;">
                    </div>
                    
                    <!-- Article Content -->
                    <div class="news-content">
                        {!! $news->content !!}
                    </div>
                    
                    <!-- Article Footer -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <span class="text-muted">Chia sẻ:</span>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-facebook me-1"></i>Facebook
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        <i class="fab fa-twitter me-1"></i>Twitter
                                    </a>
                                    <a href="#" class="btn btn-outline-success btn-sm">
                                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Tin nổi bật -->
                <div class="sidebar-card">
                    <h4 class="sidebar-title">
                        <i class="fas fa-star me-2"></i>Tin Nổi Bật
                    </h4>
                    @foreach($featuredNews as $featured)
                    <div class="d-flex mb-3">
                        <img src="{{ $featured->image_url }}" 
                             alt="{{ $featured->title }}"
                             class="rounded me-3"
                             style="width: 80px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('news.show', $featured->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($featured->title, 50) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $featured->formatted_date }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Tin liên quan -->
                @if($relatedNews->count() > 0)
                <div class="sidebar-card">
                    <h4 class="sidebar-title">
                        <i class="fas fa-link me-2"></i>Tin Liên Quan
                    </h4>
                    @foreach($relatedNews as $related)
                    <div class="d-flex mb-3">
                        <img src="{{ $related->image_url }}" 
                             alt="{{ $related->title }}"
                             class="rounded me-3"
                             style="width: 80px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('news.show', $related->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $related->formatted_date }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                
                <!-- Danh mục -->
                <div class="sidebar-card">
                    <h4 class="sidebar-title">
                        <i class="fas fa-tags me-2"></i>Danh Mục
                    </h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('news.index', ['category' => 'xu-hướng']) }}" 
                           class="badge bg-primary text-decoration-none">Xu hướng</a>
                        <a href="{{ route('news.index', ['category' => 'hướng-dẫn']) }}" 
                           class="badge bg-success text-decoration-none">Hướng dẫn</a>
                        <a href="{{ route('news.index', ['category' => 'khuyến-mãi']) }}" 
                           class="badge bg-warning text-dark text-decoration-none">Khuyến mãi</a>
                        <a href="{{ route('news.index', ['category' => 'công-nghệ']) }}" 
                           class="badge bg-info text-decoration-none">Công nghệ</a>
                        <a href="{{ route('news.index', ['category' => 'thiết-kế']) }}" 
                           class="badge bg-secondary text-decoration-none">Thiết kế</a>
                        <a href="{{ route('news.index', ['category' => 'tiết-kiệm']) }}" 
                           class="badge bg-success text-decoration-none">Tiết kiệm</a>
                    </div>
                </div>
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
