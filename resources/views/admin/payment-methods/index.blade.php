@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-credit-card me-2"></i>
                Quản Lý Phương Thức Thanh Toán
            </h1>
            <p class="text-muted mb-0">Quản lý các phương thức thanh toán của hệ thống</p>
        </div>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm Phương Thức
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Danh sách phương thức thanh toán -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list me-2"></i>
                Danh Sách Phương Thức Thanh Toán
            </h5>
        </div>
        <div class="card-body p-0">
            @if($paymentMethods->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">#</th>
                                <th class="border-0">Loại</th>
                                <th class="border-0">Tên</th>
                                <th class="border-0">Thông Tin</th>
                                <th class="border-0">Trạng Thái</th>
                                <th class="border-0">Thứ Tự</th>
                                <th class="border-0 text-center">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentMethods as $index => $method)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">
                                    @if($method->type === 'qr_code')
                                        <span class="badge bg-info">
                                            <i class="fas fa-qrcode me-1"></i>QR Code
                                        </span>
                                    @elseif($method->type === 'momo')
                                        <span class="badge bg-success">
                                            <i class="fas fa-mobile-alt me-1"></i>Momo
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="fw-bold text-dark">{{ $method->name }}</div>
                                    @if($method->description)
                                        <small class="text-muted">{{ Str::limit($method->description, 50) }}</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($method->type === 'qr_code')
                                        <div class="small">
                                            @if($method->bank_name)
                                                <div><strong>Ngân hàng:</strong> {{ $method->bank_name }}</div>
                                            @endif
                                            @if($method->account_number)
                                                <div><strong>STK:</strong> {{ $method->account_number }}</div>
                                            @endif
                                            @if($method->account_name)
                                                <div><strong>Chủ TK:</strong> {{ $method->account_name }}</div>
                                            @endif
                                        </div>
                                    @elseif($method->type === 'momo')
                                        <div class="small">
                                            @if($method->momo_phone)
                                                <div><strong>SĐT:</strong> {{ $method->momo_phone }}</div>
                                            @endif
                                            @if($method->momo_name)
                                                <div><strong>Tên:</strong> {{ $method->momo_name }}</div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($method->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>Tạm dừng
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-light text-dark">{{ $method->sort_order }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.payment-methods.show', $method) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.payment-methods.edit', $method) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.payment-methods.destroy', $method) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa phương thức thanh toán này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có phương thức thanh toán nào</h5>
                    <p class="text-muted mb-4">Hãy thêm phương thức thanh toán đầu tiên để bắt đầu</p>
                    <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm Phương Thức Đầu Tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.table-responsive {
    border-radius: 0.35rem;
}
</style>
@endsection
