@extends('layouts.admin')

@section('title', 'Quản Lý Đánh Giá - KitchenHood Pro')

@section('content')
<style>
/* ===== REVIEWS STYLES ===== */
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
.reviews-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.reviews-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.reviews-title i {
    color: var(--warning-color);
    font-size: 1.5rem;
}

.reviews-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
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

/* Table Card */
.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.table-header {
    background: var(--bg-light);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.table-title i {
    color: var(--warning-color);
}

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    background: var(--bg-light);
    border-bottom: 2px solid var(--border-color);
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.875rem;
    padding: 1rem 1.5rem;
}

.table td {
    border-bottom: 1px solid var(--border-color);
    padding: 1rem 1.5rem;
    vertical-align: middle;
}

.table tbody tr:hover {
    background: var(--bg-light);
}

/* Product Image */
.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid var(--border-color);
}

.product-image-placeholder {
    width: 50px;
    height: 50px;
    background: var(--bg-light);
    border-radius: 8px;
    border: 2px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

/* Rating Stars */
.rating-stars {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.rating-star {
    font-size: 1rem;
    color: var(--warning-color);
}

.rating-star.empty {
    color: var(--text-muted);
}

.rating-badge {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

/* Comment */
.comment-text {
    color: var(--text-light);
    line-height: 1.5;
}

.comment-toggle {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

.comment-toggle:hover {
    color: var(--primary-dark);
}

/* Action Button */
.action-btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

/* Alert */
.alert {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
}

.alert-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    font-size: 1.125rem;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .reviews-header {
        padding: 1.5rem;
    }
    
    .reviews-title {
        font-size: 1.5rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .table-header {
        padding: 1rem 1.5rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem 1rem;
    }
}
</style>

<!-- Header Section -->
<div class="reviews-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="reviews-title">
                <i class="fas fa-star me-3"></i>
                Quản Lý Đánh Giá
            </h1>
            <p class="reviews-subtitle">Theo dõi và quản lý tất cả đánh giá sản phẩm</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.reviews.export') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    <i class="fas fa-download me-2"></i>Xuất Excel
                </button>
            </form>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>In Báo Cáo
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $reviews->total() }}</div>
            <div class="stat-label">Tổng Đánh Giá</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $reviews->where('rating', 5)->count() }}</div>
            <div class="stat-label">5 Sao</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $reviews->where('rating', 4)->count() }}</div>
            <div class="stat-label">4 Sao</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ number_format($reviews->avg('rating'), 1) }}</div>
            <div class="stat-label">Điểm Trung Bình</div>
        </div>
    </div>
</div>

<!-- Reviews Table -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title">
            <i class="fas fa-list me-2"></i>
            Danh Sách Đánh Giá
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Người Đánh Giá</th>
                    <th class="text-center">Đánh Giá</th>
                    <th>Bình Luận</th>
                    <th class="text-center">Hình Ảnh</th>
                    <th>Ngày Đăng</th>
                    <th class="text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($review->product && $review->product->image)
                                <img src="{{ asset('storage/' . $review->product->image) }}" 
                                     alt="{{ $review->product->name }}" 
                                     class="product-image me-3">
                            @else
                                <div class="product-image-placeholder me-3">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('products.show', $review->product->id) }}" 
                                   target="_blank" 
                                   class="fw-bold text-decoration-none">
                                    {{ $review->product->name }}
                                </a>
                                @if($review->product)
                                    <br><small class="text-muted">{{ $review->product->category->name ?? 'N/A' }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="fw-bold">{{ $review->user->name }}</span>
                            <br>
                            <small class="text-muted">{{ $review->user->email }}</small>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star rating-star"></i>
                                @else
                                    <i class="far fa-star rating-star empty"></i>
                                @endif
                            @endfor
                            <span class="rating-badge">{{ $review->rating }}/5</span>
                        </div>
                    </td>
                    <td>
                        <div class="comment-text">
                            {{ Str::limit($review->comment, 100) }}
                            @if(strlen($review->comment) > 100)
                                <a href="#" 
                                   class="comment-toggle" 
                                   data-bs-toggle="tooltip" 
                                   title="{{ $review->comment }}">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                            @endif
                            @if($review->admin_reply)
                                <div class="mt-2 p-2 border rounded bg-light">
                                    <small class="text-muted d-block">Phản hồi admin {{ $review->admin_replied_at ? '(' . $review->admin_replied_at->format('d/m/Y H:i') . ')' : '' }}</small>
                                    <div>{{ $review->admin_reply }}</div>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        @if($review->images && count($review->images) > 0)
                            <div class="review-images-preview">
                                @foreach(array_slice($review->images, 0, 3) as $image)
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Hình ảnh đánh giá" 
                                         class="img-thumbnail me-1" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @endforeach
                                @if(count($review->images) > 3)
                                    <span class="badge bg-secondary">+{{ count($review->images) - 3 }}</span>
                                @endif
                            </div>
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td>
                        <div>
                            <span class="fw-bold">{{ $review->created_at->format('d/m/Y') }}</span>
                            <br>
                            <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('products.show', $review->product->id) }}" 
                               class="btn btn-sm btn-outline-primary action-btn" 
                               title="Xem sản phẩm"
                               target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-sm btn-outline-info action-btn"
                                    title="Trả lời đánh giá"
                                    data-bs-toggle="modal"
                                    data-bs-target="#replyModal-{{ $review->id }}">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger action-btn" 
                                    title="Xóa đánh giá"
                                    onclick="deleteReview({{ $review->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <!-- Reply Modal -->
                <div class="modal fade" id="replyModal-{{ $review->id }}" tabindex="-1" aria-labelledby="replyModalLabel-{{ $review->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel-{{ $review->id }}">Trả lời đánh giá của {{ $review->user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form method="POST" action="{{ route('admin.reviews.reply', $review) }}">
                        @csrf
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Nội dung phản hồi</label>
                            <textarea name="reply" class="form-control" rows="4" required>{{ old('reply', $review->admin_reply) }}</textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <p>Chưa có đánh giá nào</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($reviews->hasPages())
    <div class="d-flex justify-content-center py-3">
        {{ $reviews->links() }}
    </div>
    @endif
</div>

<!-- Form ẩn để xóa đánh giá -->
<form id="deleteReviewForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteReview(reviewId) {
    if (confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) {
        const form = document.getElementById('deleteReviewForm');
        form.action = `/admin/reviews/${reviewId}`;
        form.submit();
    }
}

// Khởi tạo tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection