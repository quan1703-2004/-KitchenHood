@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-eye me-2"></i>
                Chi Tiết Phương Thức Thanh Toán
            </h1>
            <p class="text-muted mb-0">Xem thông tin chi tiết phương thức thanh toán</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Chỉnh Sửa
            </a>
            <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay Lại
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Thông tin chính -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông Tin Cơ Bản
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-dark">Loại phương thức:</label>
                                <div>
                                    @if($paymentMethod->type === 'qr_code')
                                        <span class="badge bg-info fs-6">
                                            <i class="fas fa-qrcode me-1"></i>QR Code Ngân hàng
                                        </span>
                                    @elseif($paymentMethod->type === 'momo')
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-mobile-alt me-1"></i>Momo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-dark">Tên phương thức:</label>
                                <p class="mb-0 fs-5">{{ $paymentMethod->name }}</p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-dark">Trạng thái:</label>
                                <div>
                                    @if($paymentMethod->is_active)
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-check me-1"></i>Hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6">
                                            <i class="fas fa-times me-1"></i>Tạm dừng
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-dark">Thứ tự sắp xếp:</label>
                                <p class="mb-0 fs-5">
                                    <span class="badge bg-light text-dark fs-6">{{ $paymentMethod->sort_order }}</span>
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-dark">Ngày tạo:</label>
                                <p class="mb-0">{{ $paymentMethod->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-dark">Cập nhật lần cuối:</label>
                                <p class="mb-0">{{ $paymentMethod->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($paymentMethod->description)
                        <div class="info-item">
                            <label class="form-label fw-bold text-dark">Mô tả:</label>
                            <div class="alert alert-light">
                                <p class="mb-0">{{ $paymentMethod->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Thông tin chi tiết theo loại -->
            @if($paymentMethod->type === 'qr_code')
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-qrcode me-2"></i>
                            Thông Tin QR Code
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if($paymentMethod->qr_code_image)
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark">Ảnh QR Code:</label>
                                        <div class="qr-display text-center">
                                            <img src="{{ $paymentMethod->qr_code_image_url }}" 
                                                 alt="QR Code" 
                                                 class="img-fluid rounded shadow"
                                                 style="max-width: 300px; max-height: 300px;">
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Chưa có ảnh QR Code
                                    </div>
                                @endif
                            </div>
                            
                            <div class="col-md-6">
                                @if($paymentMethod->bank_name)
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-dark">Ngân hàng:</label>
                                        <p class="mb-0 fs-5">{{ $paymentMethod->bank_name }}</p>
                                    </div>
                                @endif
                                
                                @if($paymentMethod->account_number)
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-dark">Số tài khoản:</label>
                                        <p class="mb-0 fs-5 text-primary fw-bold">{{ $paymentMethod->account_number }}</p>
                                    </div>
                                @endif
                                
                                @if($paymentMethod->account_name)
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-dark">Chủ tài khoản:</label>
                                        <p class="mb-0 fs-5 text-primary fw-bold">{{ $paymentMethod->account_name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($paymentMethod->type === 'momo')
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-mobile-alt me-2"></i>
                            Thông Tin Momo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="momo-display text-center mb-4">
                                    <div class="momo-icon bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-mobile-alt fa-2x"></i>
                                    </div>
                                    <h4 class="text-success fw-bold">Ví Điện Tử Momo</h4>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                @if($paymentMethod->momo_phone)
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-dark">Số điện thoại Momo:</label>
                                        <p class="mb-0 fs-5 text-success fw-bold">{{ $paymentMethod->momo_phone }}</p>
                                    </div>
                                @endif
                                
                                @if($paymentMethod->momo_name)
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-dark">Tên chủ ví:</label>
                                        <p class="mb-0 fs-5 text-success fw-bold">{{ $paymentMethod->momo_name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Thao tác nhanh -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-tools me-2"></i>
                        Thao Tác Nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.payment-methods.edit', $paymentMethod) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Chỉnh Sửa
                        </a>
                        
                        <form action="{{ route('admin.payment-methods.destroy', $paymentMethod) }}" 
                              method="POST" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa phương thức thanh toán này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Xóa
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.payment-methods.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>Danh Sách
                        </a>
                    </div>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2"></i>
                        Thống Kê
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-calendar-alt fa-2x text-info mb-2"></i>
                            <h6 class="fw-bold text-dark">Ngày tạo</h6>
                            <p class="mb-0">{{ $paymentMethod->created_at->format('d/m/Y') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h6 class="fw-bold text-dark">Thời gian hoạt động</h6>
                            <p class="mb-0">{{ $paymentMethod->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <div class="mb-0">
                            <i class="fas fa-sort-numeric-up fa-2x text-success mb-2"></i>
                            <h6 class="fw-bold text-dark">Thứ tự hiển thị</h6>
                            <p class="mb-0 fs-4 fw-bold text-primary">{{ $paymentMethod->sort_order }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông Tin Bổ Sung
                    </h5>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <p class="mb-2">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Mẹo:</strong> Bạn có thể thay đổi thứ tự hiển thị bằng cách chỉnh sửa số trong trường "Thứ tự sắp xếp".
                        </p>
                        
                        <p class="mb-2">
                            <i class="fas fa-toggle-on me-2"></i>
                            <strong>Trạng thái:</strong> Chỉ các phương thức đang hoạt động mới hiển thị cho khách hàng.
                        </p>
                        
                        <p class="mb-0">
                            <i class="fas fa-image me-2"></i>
                            <strong>QR Code:</strong> Đảm bảo ảnh QR Code rõ nét và có kích thước phù hợp.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.info-item {
    padding: 0.5rem 0;
}

.form-label {
    color: #495057;
    margin-bottom: 0.25rem;
}

.badge {
    font-size: 0.875rem;
}

.qr-display img {
    border: 2px solid #e9ecef;
}

.momo-icon {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
}

.btn {
    border-radius: 0.35rem;
}

.alert {
    border: none;
}
</style>
@endsection
