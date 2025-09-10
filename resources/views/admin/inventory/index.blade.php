@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark mb-2"><i class="fas fa-warehouse me-2 text-primary"></i>Quản Lý Tồn Kho</h1>
            <p class="text-muted mb-0">Theo dõi tồn kho, sắp hết hàng và lịch sử giao dịch</p>
        </div>
        <div>
            <a href="{{ route('admin.inventory.history') }}" class="btn btn-view btn-sm me-2" style="padding: 0.75rem 1rem;">
                <i class="fas fa-history me-2"></i>Lịch Sử Giao Dịch
            </a>
            <a href="{{ route('admin.inventory.export') }}" class="btn btn-success" style="padding: 0.75rem 1rem;">
                <i class="fas fa-file-excel me-2"></i>Xuất Excel
            </a>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-icon"><i class="fas fa-box"></i></div>
                <div class="card-count">{{ $stats['total_products'] }}</div>
                <div class="card-title">Tổng Sản Phẩm</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-icon" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%);"><i class="fas fa-check-circle"></i></div>
                <div class="card-count">{{ $stats['in_stock'] }}</div>
                <div class="card-title">Còn Hàng</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="card-count">{{ $stats['low_stock'] }}</div>
                <div class="card-title">Sắp Hết Hàng</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card h-100">
                <div class="card-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);"><i class="fas fa-times-circle"></i></div>
                <div class="card-count">{{ $stats['out_of_stock'] }}</div>
                <div class="card-title">Hết Hàng</div>
            </div>
        </div>
    </div>

    <!-- Bảng sản phẩm -->
    <div class="card admin-table mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
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
                                <span class="badge badge-info text-wrap">{{ $product->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold fs-6">{{ $product->quantity }}</span>
                            </td>
                            <td class="text-center">
                                @if($product->quantity <= 0)
                                    <span class="badge badge-secondary">Hết hàng</span>
                                @elseif($product->quantity <= 10)
                                    <span class="badge badge-success" style="background: #f59e0b;">Sắp hết hàng</span>
                                @else
                                    <span class="badge badge-success">Còn hàng</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <span class="fw-bold text-primary">{{ number_format($product->price) }} ₫</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group-vertical btn-group-sm" role="group">
                                    <a href="{{ route('admin.inventory.show', $product) }}" class="btn btn-view mb-1" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($product->quantity <= 10)
                                        <a href="{{ route('admin.inventory.show', $product) }}" class="btn btn-edit" title="Nhập hàng">
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
