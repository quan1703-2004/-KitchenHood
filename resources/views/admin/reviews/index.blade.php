@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-star me-2 text-primary"></i>
            Quản lý Đánh giá
        </h1>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>In báo cáo
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Thống kê nhanh -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng đánh giá
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reviews->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                5 sao
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $reviews->where('rating', 5)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                4 sao
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $reviews->where('rating', 4)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Điểm TB
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($reviews->avg('rating'), 1) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list me-2 text-primary"></i>
                Danh sách Đánh giá
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Sản phẩm</th>
                            <th class="px-4 py-3">Người đánh giá</th>
                            <th class="px-4 py-3 text-center">Đánh giá</th>
                            <th class="px-4 py-3">Bình luận</th>
                            <th class="px-4 py-3">Ngày đăng</th>
                            <th class="px-4 py-3 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($review->product && $review->product->image)
                                        <img src="{{ asset('storage/' . $review->product->image) }}" 
                                             alt="{{ $review->product->name }}" 
                                             class="rounded me-3" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
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
                            <td class="px-4 py-3">
                                <div>
                                    <span class="fw-bold">{{ $review->user->name }}</span>
                                    <br>
                                    <small class="text-muted">{{ $review->user->email }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-warning me-1"></i>
                                        @else
                                            <i class="far fa-star text-muted me-1"></i>
                                        @endif
                                    @endfor
                                    <span class="badge bg-primary ms-2">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-muted">
                                    {{ Str::limit($review->comment, 100) }}
                                    @if(strlen($review->comment) > 100)
                                        <button type="button" 
                                                class="btn btn-sm btn-link p-0 ms-1" 
                                                data-bs-toggle="tooltip" 
                                                title="{{ $review->comment }}">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <span class="fw-bold">{{ $review->created_at->format('d/m/Y') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Xóa đánh giá"
                                        onclick="deleteReview({{ $review->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-muted">
                                <i class="fas fa-star fa-3x mb-3"></i>
                                <p class="mb-0">Chưa có đánh giá nào</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang -->
            @if($reviews->hasPages())
            <div class="d-flex justify-content-center py-3">
                {{ $reviews->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Form ẩn để xóa đánh giá -->
<form id="deleteReviewForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
}

.border-left-primary {
    border-left: 0.25rem solid #007bff !important;
}

.border-left-warning {
    border-left: 0.25rem solid #ffc107 !important;
}

.border-left-info {
    border-left: 0.25rem solid #17a2b8 !important;
}

.border-left-success {
    border-left: 0.25rem solid #28a745 !important;
}

.fa-star {
    font-size: 0.875rem;
}
</style>

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