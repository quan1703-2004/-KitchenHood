@extends('layouts.admin')

@section('title', 'Dashboard - KitchenHood Pro')

@section('content')
<style>
/* ===== DASHBOARD STYLES ===== */
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

/* Header Section */
.dashboard-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.dashboard-title i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.dashboard-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}

.quick-action-btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
    font-weight: 500;
}

.stat-action {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.stat-action:hover {
    color: var(--primary-dark);
}

/* Detail Stats */
.detail-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.detail-stat-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.detail-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.detail-stat-header {
    background: var(--bg-light);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-stat-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.detail-stat-body {
    padding: 1.5rem;
    text-align: center;
}

.detail-stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.detail-stat-description {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin: 0;
}

/* Recent Items */
.recent-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.recent-item-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
}

.recent-item-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.recent-item-header {
    background: var(--bg-light);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.recent-item-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.recent-item-body {
    padding: 1.5rem;
}

.recent-item-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item-info {
    flex: 1;
}

.recent-item-name {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.recent-item-meta {
    font-size: 0.75rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.recent-item-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.recent-item-action {
    text-align: center;
    margin-top: 1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .dashboard-title {
        font-size: 1.5rem;
    }
    
    .quick-actions {
        flex-direction: column;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .detail-stats {
        grid-template-columns: 1fr;
    }
    
    .recent-items {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Header Section -->
<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt me-3"></i>
                Dashboard
            </h1>
            <p class="dashboard-subtitle">Tổng quan hệ thống quản lý KitchenHood Pro</p>
</div>
        <a href="{{ route('admin.reports.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-chart-line me-2"></i>Báo Cáo & Thống Kê
    </a>
</div>
</div>


<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalCategories }}</div>
            <div class="stat-label">Danh Mục</div>
            <a href="{{ route('admin.categories.index') }}" class="stat-action">
                <i class="fas fa-eye me-1"></i>Xem Chi Tiết
            </a>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalProducts }}</div>
            <div class="stat-label">Sản Phẩm</div>
            <a href="{{ route('admin.products.index') }}" class="stat-action">
                <i class="fas fa-eye me-1"></i>Xem Chi Tiết
            </a>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
                <i class="fas fa-newspaper"></i>
            </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalNews }}</div>
            <div class="stat-label">Tin Tức</div>
            <a href="{{ route('admin.news.index') }}" class="stat-action">
                <i class="fas fa-eye me-1"></i>Xem Chi Tiết
            </a>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        <div class="stat-content">
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-label">Người Dùng</div>
            <span class="stat-action" style="color: var(--text-muted); cursor: default;">
                <i class="fas fa-chart-line me-1"></i>Thống Kê
            </span>
        </div>
    </div>
</div>

<!-- Detail Stats -->
<div class="detail-stats">
    <div class="detail-stat-card">
        <div class="detail-stat-header">
            <i class="fas fa-check-circle text-success"></i>
            <h6 class="detail-stat-title">Tin Đã Xuất Bản</h6>
            </div>
        <div class="detail-stat-body">
            <div class="detail-stat-number text-success">{{ $publishedNews }}</div>
            <p class="detail-stat-description">Tin tức đã xuất bản</p>
            </div>
        </div>
    
    <div class="detail-stat-card">
        <div class="detail-stat-header">
            <i class="fas fa-star text-warning"></i>
            <h6 class="detail-stat-title">Tin Nổi Bật</h6>
    </div>
        <div class="detail-stat-body">
            <div class="detail-stat-number text-warning">{{ $featuredNews }}</div>
            <p class="detail-stat-description">Tin tức nổi bật</p>
            </div>
        </div>
    
    <div class="detail-stat-card">
        <div class="detail-stat-header">
            <i class="fas fa-eye text-info"></i>
            <h6 class="detail-stat-title">Tổng Lượt Xem</h6>
    </div>
        <div class="detail-stat-body">
            <div class="detail-stat-number text-info">{{ $recentNews->sum('views') }}</div>
            <p class="detail-stat-description">Lượt xem tin tức</p>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="recent-items">
    <!-- Recent Categories -->
    <div class="recent-item-card">
        <div class="recent-item-header">
            <i class="fas fa-tags text-primary"></i>
            <h5 class="recent-item-title">Danh Mục Gần Đây</h5>
            </div>
        <div class="recent-item-body">
                @if($recentCategories->count() > 0)
                <ul class="recent-item-list">
                        @foreach($recentCategories as $category)
                        <li class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ $category->name }}</div>
                                <div class="recent-item-meta">
                                    <i class="fas fa-calendar"></i>
                                    {{ $category->created_at->format('d/m/Y H:i') }}
                                </div>
                                </div>
                            <span class="recent-item-badge bg-primary text-white">
                                        {{ $category->products_count }} sản phẩm
                                    </span>
                        </li>
                        @endforeach
                </ul>
                <div class="recent-item-action">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Xem Tất Cả
                        </a>
                    </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-tags"></i>
                        <p>Chưa có danh mục nào</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm Danh Mục Đầu Tiên
                        </a>
                    </div>
                @endif
        </div>
    </div>
    
    <!-- Recent Products -->
    <div class="recent-item-card">
        <div class="recent-item-header">
            <i class="fas fa-box text-success"></i>
            <h5 class="recent-item-title">Sản Phẩm Gần Đây</h5>
            </div>
        <div class="recent-item-body">
                @if($recentProducts->count() > 0)
                <ul class="recent-item-list">
                        @foreach($recentProducts as $product)
                        <li class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ Str::limit($product->name, 20) }}</div>
                                <div class="recent-item-meta">
                                    <i class="fas fa-calendar"></i>
                                    {{ $product->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary">
                                    {{ number_format($product->price) }}₫
                                    </div>
                                <small class="text-muted">SL: {{ $product->quantity }}</small>
                                </div>
                        </li>
                        @endforeach
                </ul>
                <div class="recent-item-action">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-eye me-2"></i>Xem Tất Cả
                        </a>
                    </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-box"></i>
                        <p>Chưa có sản phẩm nào</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm Đầu Tiên
                        </a>
                    </div>
                @endif
        </div>
    </div>
    
    <!-- Recent News -->
    <div class="recent-item-card">
        <div class="recent-item-header">
            <i class="fas fa-newspaper text-info"></i>
            <h5 class="recent-item-title">Tin Tức Gần Đây</h5>
            </div>
        <div class="recent-item-body">
                @if($recentNews->count() > 0)
                <ul class="recent-item-list">
                        @foreach($recentNews as $news)
                        <li class="recent-item">
                            <div class="recent-item-info">
                                <div class="recent-item-name">{{ Str::limit($news->title, 25) }}</div>
                                <div class="recent-item-meta">
                                    <i class="fas fa-calendar"></i>
                                    {{ $news->created_at->format('d/m/Y H:i') }}
                                </div>
                                </div>
                                <div class="text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        @if($news->is_featured)
                                        <span class="recent-item-badge bg-warning text-white mb-1">Nổi bật</span>
                                        @endif
                                        @if($news->is_published)
                                        <span class="recent-item-badge bg-success text-white">Đã xuất bản</span>
                                        @else
                                        <span class="recent-item-badge bg-secondary text-white">Bản nháp</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ $news->views }} lượt xem
                                    </small>
                                </div>
                        </li>
                        @endforeach
                </ul>
                <div class="recent-item-action">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye me-2"></i>Xem Tất Cả
                        </a>
                    </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                        <p>Chưa có tin tức nào</p>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm Tin Tức Đầu Tiên
                        </a>
                    </div>
                @endif
        </div>
    </div>
</div>
@endsection