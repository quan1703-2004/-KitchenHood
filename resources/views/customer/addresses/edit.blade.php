@extends('layouts.customer')

@section('title', 'Chỉnh sửa địa chỉ')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-edit text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-warning mb-2">Chỉnh sửa địa chỉ</h2>
                    <p class="text-muted mb-0 fs-5">Cập nhật thông tin địa chỉ giao hàng của bạn</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-map-marker-alt text-warning me-2"></i>
                        Thông tin địa chỉ
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('addresses.update', $address) }}" method="POST" id="addressForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                    <i class="fas fa-user text-warning me-2"></i>
                                    Thông tin người nhận
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label fw-bold">
                                    Họ tên người nhận <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-warning"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 @error('full_name') is-invalid @enderror" 
                                           id="full_name" name="full_name" value="{{ old('full_name', $address->full_name) }}" 
                                           placeholder="Nhập họ tên đầy đủ" required>
                                </div>
                                @error('full_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-phone text-warning"></i>
                                    </span>
                                    <input type="tel" class="form-control border-start-0 @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $address->phone) }}" 
                                           placeholder="Nhập số điện thoại" required>
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Selection Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                    <i class="fas fa-map text-warning me-2"></i>
                                    Chọn địa chỉ
                                </h6>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="province_id" class="form-label fw-bold">
                                    Tỉnh/Thành phố <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-building text-warning"></i>
                                    </span>
                                    <select class="form-select border-start-0 @error('province_id') is-invalid @enderror" 
                                            id="province_id" name="province_id" required>
                                        <option value="">Chọn tỉnh/thành phố</option>
                                    </select>
                                </div>
                                <input type="hidden" id="province_name" name="province_name" value="{{ old('province_name', $address->province_name) }}">
                                @error('province_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="district_id" class="form-label fw-bold">
                                    Quận/Huyện <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-map-marker text-warning"></i>
                                    </span>
                                    <select class="form-select border-start-0 @error('district_id') is-invalid @enderror" 
                                            id="district_id" name="district_id" required>
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                </div>
                                <input type="hidden" id="district_name" name="district_name" value="{{ old('district_name', $address->district_name) }}">
                                @error('district_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ward_id" class="form-label fw-bold">
                                    Phường/Xã <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-home text-warning"></i>
                                    </span>
                                    <select class="form-select border-start-0 @error('ward_id') is-invalid @enderror" 
                                            id="ward_id" name="ward_id" required>
                                        <option value="">Chọn phường/xã</option>
                                    </select>
                                </div>
                                <input type="hidden" id="ward_name" name="ward_name" value="{{ old('ward_name', $address->ward_name) }}">
                                @error('ward_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Street Address Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                    <i class="fas fa-map-pin text-warning me-2"></i>
                                    Địa chỉ chi tiết
                                </h6>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="street_address" class="form-label fw-bold">
                                    Địa chỉ chi tiết <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-map-marker-alt text-warning"></i>
                                    </span>
                                    <textarea class="form-control border-start-0 @error('street_address') is-invalid @enderror" 
                                              id="street_address" name="street_address" rows="3" 
                                              placeholder="Số nhà, tên đường, tên khu vực, tên chung cư..." required>{{ old('street_address', $address->street_address) }}</textarea>
                                </div>
                                @error('street_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                    <i class="fas fa-info-circle text-warning me-2"></i>
                                    Thông tin bổ sung
                                </h6>
                            </div>
                            


                            <div class="col-12 mb-3">
                                <label for="note" class="form-label fw-bold">
                                    Ghi chú
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-sticky-note text-warning"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 @error('note') is-invalid @enderror" 
                                           id="note" name="note" value="{{ old('note', $address->note) }}" 
                                           placeholder="Ghi chú thêm về địa chỉ...">
                                </div>
                                @error('note')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Default Address Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-check p-3 bg-light rounded-3">
                                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" 
                                           {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="is_default">
                                        <i class="fas fa-star text-warning me-2"></i>
                                        Đặt làm địa chỉ mặc định
                                    </label>
                                    <small class="form-text text-muted d-block mt-1">
                                        Địa chỉ mặc định sẽ được sử dụng khi đặt hàng nếu bạn không chọn địa chỉ khác
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Current Address Info -->
                        @if($address->hasCompleteAddress())
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="alert alert-info border-0 shadow-sm">
                                        <h6 class="fw-bold mb-2">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Địa chỉ hiện tại
                                        </h6>
                                        <p class="mb-0">{{ $address->full_address }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form Actions -->
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Quay lại
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg shadow-sm">
                                <i class="fas fa-save me-2"></i>
                                Cập nhật địa chỉ
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fas fa-question-circle text-warning me-2"></i>
                        Hướng dẫn chỉnh sửa
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Có thể thay đổi bất kỳ thông tin nào
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Hệ thống sẽ tự động cập nhật
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Kiểm tra kỹ trước khi lưu
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Có thể thay đổi địa chỉ mặc định
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script để xử lý API tỉnh thành -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Lấy danh sách tỉnh thành khi trang load
    loadProvinces();
    
    // Xử lý khi chọn tỉnh thành
    $('#province_id').change(function() {
        var provinceId = $(this).val();
        var provinceName = $(this).find('option:selected').text();
        
        console.log('Province selected:', { id: provinceId, name: provinceName });
        
        if (provinceId && provinceId !== '') {
            $('#province_name').val(provinceName);
            loadDistricts(provinceId);
            // Reset quận huyện và phường xã
            $('#district_id').html('<option value="">Chọn quận/huyện</option>').prop('disabled', true);
            $('#ward_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
            // Reset hidden fields
            $('#district_name').val('');
            $('#ward_name').val('');
        } else {
            $('#province_name').val('');
            $('#district_id').html('<option value="">Chọn quận/huyện</option>').prop('disabled', true);
            $('#ward_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
            // Reset hidden fields
            $('#district_name').val('');
            $('#ward_name').val('');
        }
    });
    
    // Xử lý khi chọn quận huyện
    $('#district_id').change(function() {
        var districtId = $(this).val();
        var districtName = $(this).find('option:selected').text();
        
        console.log('District selected:', { id: districtId, name: districtName });
        
        if (districtId && districtId !== '') {
            $('#district_name').val(districtName);
            loadWards(districtId);
            // Reset phường xã
            $('#ward_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
            // Reset hidden field
            $('#ward_name').val('');
        } else {
            $('#district_name').val('');
            $('#ward_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
            // Reset hidden field
            $('#ward_name').val('');
        }
    });
    
    // Xử lý khi chọn phường xã
    $('#ward_id').change(function() {
        var wardId = $(this).val();
        var wardName = $(this).find('option:selected').text();
        
        console.log('Ward selected:', { id: wardId, name: wardName });
        
        if (wardId && wardId !== '') {
            $('#ward_name').val(wardName);
        } else {
            $('#ward_name').val('');
        }
    });
    
    // Validation trước khi submit
    $('#addressForm').on('submit', function(e) {
        var provinceId = $('#province_id').val();
        var districtId = $('#district_id').val();
        var wardId = $('#ward_id').val();
        
        console.log('Form validation:', {
            provinceId: provinceId,
            districtId: districtId,
            wardId: wardId,
            provinceName: $('#province_name').val(),
            districtName: $('#district_name').val(),
            wardName: $('#ward_name').val()
        });
        
        if (!provinceId || provinceId === '') {
            e.preventDefault();
            showAlert('Vui lòng chọn tỉnh/thành phố', 'warning');
            $('#province_id').focus();
            return false;
        }
        
        if (!districtId || districtId === '') {
            e.preventDefault();
            showAlert('Vui lòng chọn quận/huyện', 'warning');
            $('#district_id').focus();
            return false;
        }
        
        if (!wardId || wardId === '') {
            e.preventDefault();
            showAlert('Vui lòng chọn phường/xã', 'warning');
            $('#ward_id').focus();
            return false;
        }
        
        // Kiểm tra xem các hidden field đã có giá trị chưa
        if (!$('#province_name').val() || !$('#district_name').val() || !$('#ward_name').val()) {
            e.preventDefault();
            showAlert('Vui lòng chọn đầy đủ thông tin địa chỉ', 'warning');
            return false;
        }
        
        // Kiểm tra xem các ID có phải là số không
        if (isNaN(parseInt(provinceId)) || isNaN(parseInt(districtId)) || isNaN(parseInt(wardId))) {
            e.preventDefault();
            showAlert('Dữ liệu địa chỉ không hợp lệ. Vui lòng chọn lại.', 'warning');
            return false;
        }
        
        // Nếu tất cả đều hợp lệ, hiển thị loading
        showAlert('Đang cập nhật...', 'info');
    });
    
    // Hàm hiển thị alert
    function showAlert(message, type) {
        // Xóa alert cũ nếu có
        $('.alert').remove();
        
        var alertClass = 'alert-' + type;
        var icon = type === 'warning' ? 'exclamation-triangle' : (type === 'info' ? 'info-circle' : 'check-circle');
        
        var alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-${icon} me-3 fs-4"></i>
                    <div>
                        <p class="mb-0 fw-semibold">${message}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('#addressForm').prepend(alertHtml);
        
        // Tự động ẩn sau 5 giây
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
    
    // Hàm lấy danh sách tỉnh thành
    function loadProvinces() {
        console.log('Loading provinces...');
        $.ajax({
            url: '{{ route("addresses.provinces") }}',
            type: 'GET',
            success: function(data) {
                console.log('Provinces data:', data);
                if (data && data.length > 0) {
                    $.each(data, function(key, province) {
                        if (province.id && province.full_name) {
                            var selected = '';
                            if (province.id == '{{ $address->province_id }}') {
                                selected = 'selected';
                            }
                            $('#province_id').append('<option value="' + province.id + '" ' + selected + '>' + province.full_name + '</option>');
                        }
                    });
                    console.log('Loaded ' + $('#province_id option').length + ' provinces');
                    
                    // Nếu có tỉnh được chọn, load quận huyện
                    if ('{{ $address->province_id }}') {
                        loadDistricts('{{ $address->province_id }}');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error loading provinces:', xhr.responseText);
                showAlert('Không thể tải danh sách tỉnh thành. Vui lòng thử lại.', 'danger');
            }
        });
    }
    
    // Hàm lấy danh sách quận huyện
    function loadDistricts(provinceId) {
        if (!provinceId || provinceId === '') return;
        
        console.log('Loading districts for province:', provinceId);
        $.ajax({
            url: '{{ route("addresses.districts", ":provinceId") }}'.replace(':provinceId', provinceId),
            type: 'GET',
            success: function(data) {
                console.log('Districts data:', data);
                if (data && data.length > 0) {
                    $('#district_id').prop('disabled', false);
                    $.each(data, function(key, district) {
                        if (district.id && district.full_name) {
                            var selected = '';
                            if (district.id == '{{ $address->district_id }}') {
                                selected = 'selected';
                            }
                            $('#district_id').append('<option value="' + district.id + '" ' + selected + '>' + district.full_name + '</option>');
                        }
                    });
                    console.log('Loaded ' + $('#district_id option').length + ' districts');
                    
                    // Nếu có quận huyện được chọn, load phường xã
                    if ('{{ $address->district_id }}') {
                        loadWards('{{ $address->district_id }}');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error loading districts:', xhr.responseText);
                showAlert('Không thể tải danh sách quận huyện. Vui lòng thử lại.', 'danger');
            }
        });
    }
    
    // Hàm lấy danh sách phường xã
    function loadWards(districtId) {
        if (!districtId || districtId === '') return;
        
        console.log('Loading wards for district:', districtId);
        $.ajax({
            url: '{{ route("addresses.wards", ":districtId") }}'.replace(':districtId', districtId),
            type: 'GET',
            success: function(data) {
                console.log('Wards data:', data);
                if (data && data.length > 0) {
                    $('#ward_id').prop('disabled', false);
                    $.each(data, function(key, ward) {
                        if (ward.id && ward.full_name) {
                            var selected = '';
                            if (ward.id == '{{ $address->ward_id }}') {
                                selected = 'selected';
                            }
                            $('#ward_id').append('<option value="' + ward.id + '" ' + selected + '>' + ward.full_name + '</option>');
                        }
                    });
                    console.log('Loaded ' + $('#ward_id option').length + ' wards');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error loading wards:', xhr.responseText);
                showAlert('Không thể tải danh sách phường xã. Vui lòng thử lại.', 'danger');
            }
        });
    }
});
</script>

<!-- Custom CSS -->
<style>
.card {
    border-radius: 1rem;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.input-group-text {
    border-color: #dee2e6;
    color: #6c757d;
}

.form-control, .form-select {
    border-color: #dee2e6;
    border-radius: 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.btn {
    border-radius: 0.75rem;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.alert {
    border-radius: 1rem;
    border: none;
}

.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.rounded-3 {
    border-radius: 1rem !important;
}

.alert-info {
    background-color: #d1ecf1 !important;
    color: #0c5460 !important;
    border-color: #bee5eb !important;
}

@media (max-width: 768px) {
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
}
</style>
@endsection
