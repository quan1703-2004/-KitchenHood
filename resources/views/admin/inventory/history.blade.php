@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lịch Sử Giao Dịch Tồn Kho</h1>
        <div>
            <a href="{{ route('admin.inventory.export-history', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Xuất Excel
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại
            </a>
        </div>
    </div>

    <!-- Bộ lọc -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ Lọc</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.inventory.history') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="product_id">Sản phẩm</label>
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">Tất cả sản phẩm</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type">Loại giao dịch</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Tất cả</option>
                                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Nhập hàng</option>
                                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Xuất hàng</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from">Từ ngày</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to">Đến ngày</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Lọc
                                </button>
                                <a href="{{ route('admin.inventory.history') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo me-2"></i>Làm Mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng giao dịch -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh Sách Giao Dịch</h6>
        </div>
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="12%">Ngày</th>
                                <th width="25%">Sản phẩm</th>
                                <th width="8%">Loại</th>
                                <th width="8%">Số lượng</th>
                                <th width="10%">Tồn kho trước</th>
                                <th width="10%">Tồn kho sau</th>
                                <th width="12%">Người thực hiện</th>
                                <th width="10%">Đơn hàng</th>
                                <th width="15%">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="text-center">
                                    <div class="fw-bold">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($transaction->product->image)
                                            <img src="{{ asset('storage/' . $transaction->product->image) }}" 
                                                 alt="{{ $transaction->product->name }}" 
                                                 class="me-2 rounded" 
                                                 style="width: 35px; height: 35px; object-fit: cover;">
                                        @else
                                            <div class="me-2 rounded bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 35px; height: 35px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-bold text-truncate" title="{{ $transaction->product->name }}">
                                                {{ $transaction->product->name }}
                                            </div>
                                            <small class="text-muted">ID: {{ $transaction->product->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($transaction->type === 'in')
                                        <span class="badge bg-success">Nhập</span>
                                    @else
                                        <span class="badge bg-danger">Xuất</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold fs-6">{{ $transaction->quantity }}</span>
                                </td>
                                <td class="text-center">{{ $transaction->quantity_before }}</td>
                                <td class="text-center">{{ $transaction->quantity_after }}</td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $transaction->user_name }}</span>
                                </td>
                                <td class="text-center">
                                    @if($transaction->order)
                                        <a href="{{ route('admin.orders.show', $transaction->order) }}" 
                                           class="text-decoration-none fw-bold">
                                            #{{ $transaction->order->order_number }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->notes)
                                        <small class="text-muted text-truncate d-block" title="{{ $transaction->notes }}">
                                            {{ Str::limit($transaction->notes, 50) }}
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không có giao dịch nào</h5>
                    <p class="text-muted">Chưa có giao dịch tồn kho nào được thực hiện.</p>
                </div>
            @endif
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
        "pageLength": 20,
        "order": [[0, "desc"]], // Sắp xếp theo ngày giảm dần
        "columnDefs": [
            {
                "targets": [0, 2, 3, 4, 5, 6, 7], // Các cột ngày, loại, số lượng, tồn kho, người thực hiện, đơn hàng
                "orderable": true
            },
            {
                "targets": [1, 8], // Cột sản phẩm và ghi chú
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

.fw-bold {
    font-weight: 600 !important;
}
</style>
@endpush
