@extends('layouts.admin')

@section('content')
<style>
    .admin-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .admin-card:hover {
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.1);
        border-color: #007bff;
    }
    
    .status-badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .price-badge {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .category-badge {
        background: linear-gradient(45deg, #17a2b8, #6f42c1);
        color: white;
        padding: 6px 10px;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    
    .action-btn {
        border-radius: 8px;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .table-modern {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .table-modern thead th {
        background: linear-gradient(45deg, #2c3e50, #34495e);
        color: white;
        border: none;
        padding: 15px 12px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .table-modern tbody tr {
        transition: all 0.3s ease;
    }
    
    .table-modern tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .table-modern tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    .pagination-modern .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: none;
        color: #007bff;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .pagination-modern .page-item.active .page-link {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        box-shadow: 0 4px 12px rgba(0,123,255,0.3);
    }
    
    .pagination-modern .page-link:hover {
        background-color: #e9ecef;
        transform: translateY(-1px);
    }
</style>

<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-2">
                        <i class="fas fa-box me-2 text-primary"></i>Quản Lý Sản Phẩm
                    </h1>
                    <p class="text-muted mb-0">Quản lý danh sách sản phẩm trong hệ thống</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm Mới
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card admin-card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x mb-2"></i>
                    <h4 class="mb-1">{{ $products->total() }}</h4>
                    <small>Tổng Sản Phẩm</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4 class="mb-1">{{ $products->where('is_active', true)->count() }}</h4>
                    <small>Đang Hoạt Động</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h4 class="mb-1">{{ $products->where('quantity', 0)->count() }}</h4>
                    <small>Hết Hàng</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-tags fa-2x mb-2"></i>
                    <h4 class="mb-1">{{ $products->pluck('category_id')->unique()->count() }}</h4>
                    <small>Danh Mục</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card admin-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Mô Tả</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                            <th>Danh Mục</th>
                            <th>Ngày Tạo</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 60px; max-height: 60px;">
                                @else
                                    <div class="bg-light text-center text-muted rounded" 
                                         style="width: 60px; height: 60px; line-height: 60px; font-size: 10px; border: 1px solid #dee2e6;">
                                        <i class="fas fa-image text-muted"></i>
                                        <br><small>No Image</small>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>
                            <td>
                                {{ Str::limit($product->description, 100) }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    {{ number_format($product->price) }} VNĐ
                                </span>
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-warning action-btn" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger action-btn" 
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-4x mb-3"></i>
                                    <h5>Chưa có sản phẩm nào</h5>
                                    <p>Hãy thêm sản phẩm đầu tiên để bắt đầu!</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Product pagination" class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>
    @endif
</div>
@endsection