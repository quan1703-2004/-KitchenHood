@extends('layouts.customer')

@section('title', 'Quản lý địa chỉ')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <h1 class="display-6 fw-bold text-primary mb-2">
                        <i class="fas fa-map-marker-alt me-3"></i>
                        Quản lý địa chỉ
                    </h1>
                </div>
                <a href="{{ route('addresses.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-plus me-2"></i>
                    Thêm địa chỉ mới
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">Thành công!</h6>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">Có lỗi xảy ra!</h6>
                    <p class="mb-0">{{ session('error') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Address Cards Section -->
    @if($addresses->count() > 0)
        <div class="row g-4">
            @foreach($addresses as $address)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-body p-4">
                            <!-- Header with Actions -->
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bold text-dark mb-2 d-flex align-items-center">
                                        <i class="fas fa-user-circle text-primary me-2 fs-4"></i>
                                        {{ $address->full_name }}
                                        @if($address->is_default)
                                            <span class="badge bg-success ms-2 fs-6 px-2 py-1">
                                                <i class="fas fa-star me-1"></i>
                                                Mặc định
                                            </span>
                                        @endif
                                    </h5>
                                    @if($address->is_default)
                                        <small class="text-success fw-semibold">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Địa chỉ giao hàng mặc định
                                        </small>
                                    @endif
                                </div>
                                
                                <!-- Action Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('addresses.edit', $address) }}">
                                                <i class="fas fa-edit me-2 text-primary"></i>
                                                Chỉnh sửa
                                            </a>
                                        </li>
                                        @if(!$address->is_default)
                                            <li>
                                                <form action="{{ route('addresses.set-default', $address) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-star me-2 text-warning"></i>
                                                        Đặt làm mặc định
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" 
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')">
                                                    <i class="fas fa-trash me-2"></i>
                                                    Xóa
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Số điện thoại</small>
                                        <span class="fw-semibold text-dark">{{ $address->phone }}</span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-light rounded-circle p-2 me-3 mt-1">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Địa chỉ chi tiết</small>
                                        <span class="fw-semibold text-dark">{{ $address->street_address }}</span>
                                    </div>
                                </div>

                                @if($address->hasCompleteAddress())
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="bg-light rounded-circle p-2 me-3 mt-1">
                                            <i class="fas fa-building text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Khu vực</small>
                                            <span class="fw-semibold text-dark">{{ $address->short_address }}</span>
                                        </div>
                                    </div>
                                @endif



                                @if($address->note)
                                    <div class="d-flex align-items-start">
                                        <div class="bg-light rounded-circle p-2 me-3 mt-1">
                                            <i class="fas fa-sticky-note text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Ghi chú</small>
                                            <span class="text-muted">{{ $address->note }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Cập nhật lần cuối: {{ $address->updated_at->diffForHumans() }}
                                    </small>
                                    @if($address->is_default)
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="fas fa-check me-1"></i>
                                            Đang sử dụng
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-map-marker-alt text-muted" style="font-size: 3rem;"></i>
                </div>
            </div>
            <h4 class="text-muted mb-3 fw-bold">Bạn chưa có địa chỉ nào</h4>
            <p class="text-muted mb-4 fs-5">Thêm địa chỉ để thuận tiện khi đặt hàng và giao hàng</p>
            <a href="{{ route('addresses.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus me-2"></i>
                Thêm địa chỉ đầu tiên
            </a>
        </div>
    @endif
</div>

<!-- Custom CSS -->
<style>
.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.transition-all {
    transition: all 0.3s ease;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.bg-success-subtle {
    background-color: #d1e7dd !important;
}

.text-success {
    color: #198754 !important;
}

.card {
    border-radius: 1rem;
    overflow: hidden;
}

.badge {
    border-radius: 0.75rem;
    font-weight: 600;
}

.btn {
    border-radius: 0.75rem;
    font-weight: 500;
}

.alert {
    border-radius: 1rem;
    border: none;
}

.dropdown-menu {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
}
</style>
@endsection
