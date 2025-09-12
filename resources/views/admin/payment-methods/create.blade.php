@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus me-2"></i>
                Thêm Phương Thức Thanh Toán
            </h1>
            <p class="text-muted mb-0">Tạo phương thức thanh toán mới</p>
        </div>
        <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay Lại
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-credit-card me-2"></i>
                        Thông Tin Phương Thức Thanh Toán
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Loại phương thức -->
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold text-dark">
                                Loại phương thức <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">Chọn loại phương thức</option>
                                <option value="qr_code" {{ old('type') == 'qr_code' ? 'selected' : '' }}>
                                    QR Code Ngân hàng
                                </option>
                                <option value="momo" {{ old('type') == 'momo' ? 'selected' : '' }}>
                                    Momo
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tên phương thức -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-dark">
                                Tên phương thức <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="VD: QR Code Vietcombank, Momo..."
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold text-dark">
                                Mô tả
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Mô tả về phương thức thanh toán...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thông tin QR Code -->
                        <div id="qr-code-fields" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Thông tin cho phương thức QR Code
                            </div>
                            
                            <!-- Ảnh QR Code -->
                            <div class="mb-4">
                                <label for="qr_code_image" class="form-label fw-bold text-dark">
                                    Ảnh QR Code
                                </label>
                                <input type="file" 
                                       class="form-control @error('qr_code_image') is-invalid @enderror" 
                                       id="qr_code_image" 
                                       name="qr_code_image" 
                                       accept="image/*">
                                <div class="form-text">Chọn ảnh QR Code của ngân hàng (JPG, PNG, GIF - tối đa 2MB)</div>
                                @error('qr_code_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tên ngân hàng -->
                            <div class="mb-4">
                                <label for="bank_name" class="form-label fw-bold text-dark">
                                    Tên ngân hàng
                                </label>
                                <input type="text" 
                                       class="form-control @error('bank_name') is-invalid @enderror" 
                                       id="bank_name" 
                                       name="bank_name" 
                                       value="{{ old('bank_name') }}" 
                                       placeholder="VD: Vietcombank, Techcombank...">
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số tài khoản -->
                            <div class="mb-4">
                                <label for="account_number" class="form-label fw-bold text-dark">
                                    Số tài khoản
                                </label>
                                <input type="text" 
                                       class="form-control @error('account_number') is-invalid @enderror" 
                                       id="account_number" 
                                       name="account_number" 
                                       value="{{ old('account_number') }}" 
                                       placeholder="Nhập số tài khoản ngân hàng">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tên chủ tài khoản -->
                            <div class="mb-4">
                                <label for="account_name" class="form-label fw-bold text-dark">
                                    Tên chủ tài khoản
                                </label>
                                <input type="text" 
                                       class="form-control @error('account_name') is-invalid @enderror" 
                                       id="account_name" 
                                       name="account_name" 
                                       value="{{ old('account_name') }}" 
                                       placeholder="Tên chủ tài khoản">
                                @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Thông tin Momo -->
                        <div id="momo-fields" style="display: none;">
                            <div class="alert alert-success">
                                <i class="fas fa-mobile-alt me-2"></i>
                                Thông tin cho phương thức Momo
                            </div>
                            
                            <!-- Số điện thoại Momo -->
                            <div class="mb-4">
                                <label for="momo_phone" class="form-label fw-bold text-dark">
                                    Số điện thoại Momo
                                </label>
                                <input type="text" 
                                       class="form-control @error('momo_phone') is-invalid @enderror" 
                                       id="momo_phone" 
                                       name="momo_phone" 
                                       value="{{ old('momo_phone') }}" 
                                       placeholder="VD: 0901234567">
                                @error('momo_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tên chủ tài khoản Momo -->
                            <div class="mb-4">
                                <label for="momo_name" class="form-label fw-bold text-dark">
                                    Tên chủ tài khoản Momo
                                </label>
                                <input type="text" 
                                       class="form-control @error('momo_name') is-invalid @enderror" 
                                       id="momo_name" 
                                       name="momo_name" 
                                       value="{{ old('momo_name') }}" 
                                       placeholder="Tên chủ tài khoản Momo">
                                @error('momo_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Thứ tự sắp xếp -->
                        <div class="mb-4">
                            <label for="sort_order" class="form-label fw-bold text-dark">
                                Thứ tự sắp xếp
                            </label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}" 
                                   min="0"
                                   placeholder="0">
                            <div class="form-text">Số càng nhỏ càng hiển thị trước</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark" for="is_active">
                                    Kích hoạt phương thức thanh toán
                                </label>
                            </div>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu Phương Thức
                            </button>
                            <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hướng dẫn -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        Hướng Dẫn
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold text-dark">QR Code Ngân hàng:</h6>
                        <ul class="small text-muted mb-0">
                            <li>Upload ảnh QR Code của ngân hàng</li>
                            <li>Nhập thông tin ngân hàng và tài khoản</li>
                            <li>Khách hàng sẽ quét QR để thanh toán</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold text-dark">Momo:</h6>
                        <ul class="small text-muted mb-0">
                            <li>Nhập số điện thoại Momo</li>
                            <li>Nhập tên chủ tài khoản</li>
                            <li>Khách hàng sẽ chuyển tiền qua Momo</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Lưu ý:</strong> Chỉ có thể có 1 phương thức QR Code và 1 phương thức Momo hoạt động tại một thời điểm.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const qrCodeFields = document.getElementById('qr-code-fields');
    const momoFields = document.getElementById('momo-fields');
    
    function toggleFields() {
        const selectedType = typeSelect.value;
        
        // Ẩn tất cả fields
        qrCodeFields.style.display = 'none';
        momoFields.style.display = 'none';
        
        // Hiện fields tương ứng
        if (selectedType === 'qr_code') {
            qrCodeFields.style.display = 'block';
        } else if (selectedType === 'momo') {
            momoFields.style.display = 'block';
        }
    }
    
    typeSelect.addEventListener('change', toggleFields);
    
    // Khởi tạo khi load trang
    toggleFields();
});
</script>

<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.form-label {
    color: #495057;
}

.alert {
    border: none;
}

.btn {
    border-radius: 0.35rem;
}
</style>
@endsection
