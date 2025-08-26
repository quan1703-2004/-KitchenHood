@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1 class="content-title">Dashboard</h1>
    <p class="content-subtitle">Tổng quan hệ thống quản lý KitchenHood Pro</p>
</div>

<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary me-2">
        <i class="fas fa-plus me-2"></i>Thêm Danh Mục
    </a>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success me-2">
        <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm
    </a>
    <a href="{{ route('admin.news.create') }}" class="btn btn-info">
        <i class="fas fa-plus me-2"></i>Thêm Tin Tức
    </a>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="card-count">{{ $totalCategories }}</div>
            <div class="card-title">Danh Mục</div>
            <a href="{{ route('admin.categories.index') }}" class="card-action">
                <i class="fas fa-eye me-2"></i>Xem Chi Tiết
            </a>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="card-count">{{ $totalProducts }}</div>
            <div class="card-title">Sản Phẩm</div>
            <a href="{{ route('admin.products.index') }}" class="card-action">
                <i class="fas fa-eye me-2"></i>Xem Chi Tiết
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="card-count">{{ $totalNews }}</div>
            <div class="card-title">Tin Tức</div>
            <a href="{{ route('admin.news.index') }}" class="card-action">
                <i class="fas fa-eye me-2"></i>Xem Chi Tiết
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-count">{{ $totalUsers }}</div>
            <div class="card-title">Người Dùng</div>
            <div class="card-action" style="background: #6c757d; cursor: default;">
                <i class="fas fa-chart-line me-2"></i>Thống Kê
            </div>
        </div>
    </div>
</div>

<!-- Thống kê tin tức chi tiết -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="admin-table">
            <div class="p-3 border-bottom">
                <h6 class="mb-0">
                    <i class="fas fa-check-circle me-2 text-success"></i>Tin Đã Xuất Bản
                </h6>
            </div>
            <div class="p-3 text-center">
                <div class="display-4 text-success fw-bold">{{ $publishedNews }}</div>
                <small class="text-muted">Tin tức đã xuất bản</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-table">
            <div class="p-3 border-bottom">
                <h6 class="mb-0">
                    <i class="fas fa-star me-2 text-warning"></i>Tin Nổi Bật
                </h6>
            </div>
            <div class="p-3 text-center">
                <div class="display-4 text-warning fw-bold">{{ $featuredNews }}</div>
                <small class="text-muted">Tin tức nổi bật</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-table">
            <div class="p-3 border-bottom">
                <h6 class="mb-0">
                    <i class="fas fa-eye me-2 text-info"></i>Tổng Lượt Xem
                </h6>
            </div>
            <div class="p-3 text-center">
                <div class="display-4 text-info fw-bold">{{ $recentNews->sum('views') }}</div>
                <small class="text-muted">Lượt xem tin tức</small>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách gần đây -->
<div class="row">
    <div class="col-md-4">
        <div class="admin-table">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2"></i>Danh Mục Gần Đây
                </h5>
            </div>
            <div class="p-3">
                @if($recentCategories->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentCategories as $category)
                            <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ $category->name }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $category->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div>
                                    <span class="badge badge-primary">
                                        {{ $category->products_count }} sản phẩm
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Xem Tất Cả
                        </a>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-tags fa-3x mb-3 opacity-50"></i>
                        <p>Chưa có danh mục nào</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm Danh Mục Đầu Tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="admin-table">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i>Sản Phẩm Gần Đây
                </h5>
            </div>
            <div class="p-3">
                @if($recentProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentProducts as $product)
                            <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded me-3" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px !important;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px; border-radius: 8px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ Str::limit($product->name, 20) }}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $product->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary">
                                        {{ number_format($product->price) }} VNĐ
                                    </div>
                                    <small class="text-muted">
                                        SL: {{ $product->quantity }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-eye me-2"></i>Xem Tất Cả
                        </a>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-box fa-3x mb-3 opacity-50"></i>
                        <p>Chưa có sản phẩm nào</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm Đầu Tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="admin-table">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-newspaper me-2"></i>Tin Tức Gần Đây
                </h5>
            </div>
            <div class="p-3">
                @if($recentNews->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentNews as $news)
                            <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ Str::limit($news->title, 25) }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $news->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        @if($news->is_featured)
                                            <span class="badge badge-warning mb-1">Nổi bật</span>
                                        @endif
                                        @if($news->is_published)
                                            <span class="badge badge-success">Đã xuất bản</span>
                                        @else
                                            <span class="badge badge-secondary">Bản nháp</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i>{{ $news->views }} lượt xem
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye me-2"></i>Xem Tất Cả
                        </a>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-newspaper fa-3x mb-3 opacity-50"></i>
                        <p>Chưa có tin tức nào</p>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm Tin Tức Đầu Tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection