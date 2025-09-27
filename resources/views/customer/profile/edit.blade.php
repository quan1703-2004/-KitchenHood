@extends('layouts.customer')

@section('title', 'Chỉnh sửa thông tin cá nhân')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
        <h1 class="display-5 fw-bold text-dark mb-2">Chỉnh sửa thông tin cá nhân</h1>
        <p class="text-muted">Cập nhật thông tin cá nhân và cài đặt tài khoản</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Avatar Section -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold text-dark mb-4">Ảnh đại diện</h2>
                        
                        <div class="row align-items-center">
                            <!-- Avatar Preview -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <div class="position-relative d-inline-block">
                                    <div id="avatar-preview-container" class="rounded-circle overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                        @if($user->avatar)
                                            <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <i id="avatar-placeholder" class="fas fa-user fa-3x text-muted"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Area -->
                            <div class="col-md-8">
                                <div id="drop-area" class="border border-2 border-dashed border-secondary rounded-4 p-4 text-center position-relative" style="cursor: pointer;">
                                    <div class="mb-3">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">Kéo thả ảnh vào đây</h5>
                                    <p class="text-muted mb-3">hoặc</p>
                                    <label for="avatar" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-plus me-2"></i>Chọn ảnh
                                    </label>
                                    <input type="file" id="avatar" name="avatar" accept="image/*" class="d-none" onchange="previewAvatar(this)">
                                    <p class="text-muted small mt-2 mb-0">PNG, JPG, GIF tối đa 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold text-dark mb-4">Thông tin cơ bản</h2>
                        
                        <div class="row g-4">
                            <!-- Tên -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">Họ và tên *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <label for="email" class="form-label fw-semibold">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       class="form-control form-control-lg @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ngày sinh -->
                            <div class="col-md-6">
                                <label for="birth_date" class="form-label fw-semibold">Ngày sinh</label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}" 
                                       class="form-control form-control-lg @error('birth_date') is-invalid @enderror">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giới tính -->
                            <div class="col-md-6">
                                <label for="gender" class="form-label fw-semibold">Giới tính</label>
                                <select id="gender" name="gender" 
                                        class="form-select form-select-lg @error('gender') is-invalid @enderror">
                                    <option value="">Chọn giới tính</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bỏ trường Địa chỉ vì đã có trang quản lý địa chỉ riêng -->
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold text-dark mb-4">Thay đổi mật khẩu</h2>
                        <p class="text-muted mb-4">Để thay đổi mật khẩu, hãy điền thông tin bên dưới. Để trống nếu không muốn thay đổi.</p>
                        
                        <div class="row g-4">
                            <!-- Mật khẩu mới -->
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Mật khẩu mới</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Xác nhận mật khẩu -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                           class="form-control form-control-lg">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-lg px-4">
                        Hủy
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-check me-2"></i>Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #drop-area.dragover {
        border-color: var(--primary-color) !important;
        background-color: rgba(52, 152, 219, 0.1) !important;
    }
</style>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            } else {
                // Tạo img element mới nếu chưa có
                const img = document.createElement('img');
                img.id = 'avatar-preview';
                img.src = e.target.result;
                img.alt = 'Avatar preview';
                img.className = 'w-100 h-100';
                img.style.objectFit = 'cover';
                
                const container = document.getElementById('avatar-preview-container');
                container.innerHTML = '';
                container.appendChild(img);
            }
            
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Drag and drop functionality
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('avatar');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropArea.classList.add('dragover');
}

function unhighlight(e) {
    dropArea.classList.remove('dragover');
}

dropArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        previewAvatar(fileInput);
    }
}

// Click to upload: chỉ mở dialog khi click trực tiếp lên vùng drop, không phải các phần tử con
dropArea.addEventListener('click', (e) => {
    // Nếu click vào chính vùng drop (không phải label hoặc icon bên trong) thì mới mở file dialog
    if (e.target === dropArea) {
        fileInput.click();
    }
});

// Ngăn sự kiện click ở nút/label "Chọn ảnh" nổi bọt lên dropArea gây mở dialog lần 2
const chooseLabel = document.querySelector('label[for="avatar"]');
if (chooseLabel) {
    chooseLabel.addEventListener('click', (e) => {
        e.stopPropagation();
    });
}
</script>
@endsection
