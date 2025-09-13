@extends('layouts.admin')

@section('title', 'Quản Lý Tồn Kho - KitchenHood Pro')

@section('content')
<style>
/* ===== INVENTORY STYLES ===== */
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
.inventory-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.inventory-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.inventory-title i {
    color: var(--info-color);
    font-size: 1.5rem;
}

.inventory-subtitle {
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

.stat-icon.success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
}

.stat-icon.warning {
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
}

.stat-icon.danger {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
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
    color: var(--info-color);
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

/* Badge Styles */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
}

.badge-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
}

.badge-warning {
    background: linear-gradient(135deg, var(--warning-color), #fbbf24);
    color: white;
}

.badge-danger {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    color: white;
}

.badge-info {
    background: linear-gradient(135deg, var(--info-color), #38bdf8);
    color: white;
}

.badge-secondary {
    background: linear-gradient(135deg, var(--text-muted), #94a3b8);
    color: white;
}

/* Action Buttons */
.action-btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    margin-bottom: 0.25rem;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.action-btn:last-child {
    margin-bottom: 0;
}

.btn-view {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    border: none;
}

.btn-view:hover {
    color: white;
}

.btn-edit {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
    border: none;
}

.btn-edit:hover {
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .inventory-header {
        padding: 1.5rem;
    }
    
    .inventory-title {
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
<div class="inventory-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="inventory-title">
                <i class="fas fa-warehouse me-3"></i>
                Quản Lý Tồn Kho
            </h1>
            <p class="inventory-subtitle">Theo dõi tồn kho, sắp hết hàng và lịch sử giao dịch</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.inventory.history') }}" class="btn btn-outline-primary">
                <i class="fas fa-history me-2"></i>Lịch Sử Giao Dịch
            </a>
            <a href="{{ route('admin.inventory.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Xuất Excel
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['total_products'] }}</div>
            <div class="stat-label">Tổng Sản Phẩm</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['in_stock'] }}</div>
            <div class="stat-label">Còn Hàng</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['low_stock'] }}</div>
            <div class="stat-label">Sắp Hết Hàng</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['out_of_stock'] }}</div>
            <div class="stat-label">Hết Hàng</div>
        </div>
    </div>
</div>

<!-- Inventory Table -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title">
            <i class="fas fa-list me-2"></i>
            Danh Sách Sản Phẩm
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table mb-0" id="dataTable">
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
                                     class="product-image me-3">
                            @else
                                <div class="product-image-placeholder me-3">
                                    <i class="fas fa-image"></i>
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
                        <span class="badge badge-info">{{ $product->category->name ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center">
                        <span class="fw-bold fs-6">{{ $product->quantity }}</span>
                    </td>
                    <td class="text-center">
                        @if($product->quantity <= 0)
                            <span class="badge badge-secondary">Hết Hàng</span>
                        @elseif($product->quantity <= 10)
                            <span class="badge badge-warning">Sắp Hết Hàng</span>
                        @else
                            <span class="badge badge-success">Còn Hàng</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <span class="fw-bold text-primary">{{ number_format($product->price) }}₫</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group-vertical btn-group-sm" role="group">
                            <a href="{{ route('admin.inventory.show', $product) }}" class="action-btn btn-view" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($product->quantity <= 10)
                                <a href="{{ route('admin.inventory.show', $product) }}" class="action-btn btn-edit" title="Nhập hàng">
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
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center py-3">
        {{ $products->links() }}
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
