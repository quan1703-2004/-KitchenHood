@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản Lý Tồn Kho</h1>
        <div>
            <a href="{{ route('admin.inventory.history') }}" class="btn btn-info">
                <i class="fas fa-history me-2"></i>Lịch Sử Giao Dịch
            </a>
            <a href="{{ route('admin.inventory.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Xuất Excel
            </a>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng Sản Phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Còn Hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['in_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Sắp Hết Hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['low_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Hết Hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['out_of_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng sản phẩm -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Sản Phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="35%">Sản Phẩm</th>
                            <th width="12%">Danh Mục</th>
                            <th width="10%">Tồn Kho</th>
                            <th width="12%">Trạng Thái</th>
                            <th width="15%">Giá</th>
                            <th width="11%">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="me-2 rounded" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="me-2 rounded bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-bold text-truncate" title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </div>
                                        <small class="text-muted text-truncate d-block" title="{{ $product->description }}">
                                            {{ Str::limit($product->description, 40) }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info text-wrap">{{ $product->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold fs-6">{{ $product->quantity }}</span>
                            </td>
                            <td class="text-center">
                                @if($product->quantity <= 0)
                                    <span class="badge bg-danger">Hết hàng</span>
                                @elseif($product->quantity <= 10)
                                    <span class="badge bg-warning">Sắp hết hàng</span>
                                @else
                                    <span class="badge bg-success">Còn hàng</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <span class="fw-bold text-primary">{{ number_format($product->price) }} ₫</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    <a href="{{ route('admin.inventory.show', $product) }}" 
                                       class="btn btn-primary btn-sm mb-1" 
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($product->quantity <= 10)
                                        <a href="{{ route('admin.inventory.show', $product) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Nhập hàng">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        },
        "pageLength": 15,
        "order": [[3, "asc"]], // Sắp xếp theo cột tồn kho
        "columnDefs": [
            {
                "targets": [0, 2, 3, 4, 6], // Các cột ID, Danh mục, Tồn kho, Trạng thái, Thao tác
                "orderable": true
            },
            {
                "targets": [1, 5], // Cột Sản phẩm và Giá
                "orderable": true
            }
        ],
        "responsive": true,
        "autoWidth": false
    });
});
</script>
@endpush

@push('styles')
<style>
.table-responsive {
    overflow-x: auto;
}

.table th {
    white-space: nowrap;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.text-truncate {
    max-width: 200px;
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
}

.btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

.badge {
    font-size: 0.75rem;
}

.fs-6 {
    font-size: 1rem !important;
}

.min-w-0 {
    min-width: 0;
}

.flex-grow-1 {
    flex-grow: 1;
}
</style>
@endpush
