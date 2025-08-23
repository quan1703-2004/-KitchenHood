@extends('layouts.customer')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h2 fw-bold">{{ $product->name }}</h1>
                        <div>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Quay Lại
                            </a>
                            @if($product->category)
                            <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="btn btn-primary">
                                <i class="fas fa-tag me-1"></i>Xem Sản Phẩm Cùng Danh Mục
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Hình ảnh sản phẩm -->
                    <div class="text-center mb-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="img-fluid rounded shadow" 
                                 alt="{{ $product->name }}"
                                 style="max-height: 400px; max-width: 100%;">
                        @else
                            <img src="https://via.placeholder.com/400x400/cccccc/666666?text=Không+có+ảnh" 
                                 class="img-fluid rounded shadow" 
                                 alt="{{ $product->name }}"
                                 style="max-height: 400px; max-width: 100%;">
                        @endif
                    </div>

                    <!-- Mô tả sản phẩm -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Mô Tả Sản Phẩm</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    <!-- Đặc điểm sản phẩm -->
                    @if($product->features && count($product->features) > 0)
                    <div class="mb-4">
                        <h5 class="fw-bold">Đặc Điểm Sản Phẩm</h5>
                        <div class="row g-3">
                            @foreach($product->features as $feature)
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <strong class="text-primary">{{ $feature['key'] }}:</strong>
                                    <span class="ms-2">{{ $feature['value'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Thông tin bổ sung -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Thông Tin Bổ Sung</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <strong class="text-muted">Ngày tạo:</strong>
                                    <span class="ms-2">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <strong class="text-muted">Cập nhật lần cuối:</strong>
                                    <span class="ms-2">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar thông tin -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Thông Tin Sản Phẩm</h5>
                    
                    <!-- Giá sản phẩm -->
                    <div class="mb-4">
                        <h3 class="text-primary fw-bold mb-2">
                            {{ number_format($product->price) }} VNĐ
                        </h3>
                        <small class="text-muted">Giá đã bao gồm thuế</small>
                    </div>

                    <!-- Danh mục -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Danh Mục</h6>
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-tag me-1"></i>
                            {{ $product->category->name ?? 'N/A' }}
                        </span>
                    </div>

                    <!-- Số lượng -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Tình Trạng Kho</h6>
                        @if($product->quantity > 0)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-1"></i>
                                Còn {{ $product->quantity }} sản phẩm
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times me-1"></i>
                                Hết hàng
                            </span>
                        @endif
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Trạng Thái</h6>
                        @if($product->is_active)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>
                                Hoạt động
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="fas fa-pause-circle me-1"></i>
                                Không hoạt động
                            </span>
                        @endif
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-grid gap-2">
                        @if($product->quantity > 0 && $product->is_active)
                            <button class="btn btn-success btn-lg">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm Vào Giỏ Hàng
                            </button>
                        @else
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="fas fa-ban me-2"></i>Không Khả Dụng
                            </button>
                        @endif
                        
                        @if($product->category)
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-tags me-2"></i>Xem Sản Phẩm Cùng Danh Mục
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 