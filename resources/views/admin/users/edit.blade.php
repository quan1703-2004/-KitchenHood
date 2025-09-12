@extends('layouts.admin')

@section('content')
<!-- Header Section -->
<div class="user-form-header">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header-info">
            <h1 class="user-form-title">
                <i class="fas fa-user-edit me-3"></i>
                Chỉnh sửa Người dùng
            </h1>
            <p class="user-form-subtitle">Cập nhật thông tin người dùng: {{ $user->name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-view">
                <i class="fas fa-eye me-2"></i>Xem chi tiết
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Có lỗi xảy ra:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- Form Section -->
<div class="user-form-section">
    <div class="form-card">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="user-form">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-user me-2"></i>
                        Thông tin cơ bản
                    </h3>
                </div>
                <div class="section-content">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label required">Họ và tên</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" 
                                       placeholder="Nhập họ và tên"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" 
                                       placeholder="Nhập địa chỉ email"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-lock me-2"></i>
                        Thông tin bảo mật
                    </h3>
                </div>
                <div class="section-content">
                    <div class="password-info">
                        <div class="info-alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>Để giữ nguyên mật khẩu hiện tại, hãy để trống các trường mật khẩu</span>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <div class="password-input-group">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Nhập mật khẩu mới">
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">Mật khẩu phải có ít nhất 8 ký tự</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <div class="password-input-group">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Nhập lại mật khẩu mới">
                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-shield-alt me-2"></i>
                        Quyền hạn
                    </h3>
                </div>
                <div class="section-content">
                    <div class="permission-group">
                        <div class="permission-item">
                            <div class="permission-info">
                                <h4 class="permission-title">Quyền quản trị</h4>
                                <p class="permission-description">Cấp quyền admin cho người dùng này</p>
                            </div>
                            <div class="permission-toggle">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_admin" 
                                           name="is_admin" 
                                           value="1"
                                           {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_admin">
                                        Admin
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-update">
                    <i class="fas fa-save me-2"></i>Cập nhật người dùng
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-cancel">
                    <i class="fas fa-times me-2"></i>Hủy
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* ===== USER FORM STYLES ===== */
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
.user-form-header {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.user-form-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.user-form-title i {
    color: var(--warning-color);
    font-size: 1.5rem;
}

.user-form-subtitle {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.btn-view {
    background: linear-gradient(135deg, var(--info-color) 0%, #38bdf8 100%);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-view:hover {
    background: linear-gradient(135deg, #0284c7 0%, var(--info-color) 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
    text-decoration: none;
}

.btn-back {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

/* Form Section */
.user-form-section {
    margin-bottom: 2rem;
}

.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.user-form {
    padding: 0;
}

.form-section {
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-child {
    border-bottom: none;
}

.section-header {
    background: var(--bg-light);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.section-title i {
    color: var(--primary-color);
}

.section-content {
    padding: 2rem;
}

/* Password Info */
.password-info {
    margin-bottom: 1.5rem;
}

.info-alert {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    border-left: 4px solid var(--info-color);
    font-size: 0.875rem;
    font-weight: 500;
}

.info-alert i {
    color: var(--info-color);
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
    display: block;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: ' *';
    color: var(--danger-color);
}

.form-control {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.form-control.is-invalid {
    border-color: var(--danger-color);
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--danger-color);
}

.form-text {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
}

/* Password Input Group */
.password-input-group {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    color: var(--primary-color);
    background: var(--bg-light);
}

/* Permission Group */
.permission-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.permission-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.permission-item:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow-sm);
}

.permission-info {
    flex: 1;
}

.permission-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.permission-description {
    font-size: 0.875rem;
    color: var(--text-light);
    margin: 0;
}

.permission-toggle {
    margin-left: 1rem;
}

.form-check-input {
    width: 3rem;
    height: 1.5rem;
    border-radius: 1rem;
    border: 2px solid var(--border-color);
    background-color: white;
    transition: all 0.3s ease;
}

.form-check-input:checked {
    background-color: var(--success-color);
    border-color: var(--success-color);
}

.form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-check-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-left: 0.5rem;
}

/* Form Actions */
.form-actions {
    padding: 2rem;
    background: var(--bg-light);
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-update {
    background: linear-gradient(135deg, var(--warning-color) 0%, #fbbf24 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-update:hover {
    background: linear-gradient(135deg, #d97706 0%, var(--warning-color) 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-cancel {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: var(--text-light);
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .user-form-header {
        padding: 1.5rem;
    }
    
    .user-form-title {
        font-size: 1.5rem;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .section-content {
        padding: 1.5rem;
    }
    
    .permission-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .permission-toggle {
        margin-left: 0;
        align-self: flex-end;
    }
    
    .form-actions {
        flex-direction: column;
        padding: 1.5rem;
    }
    
    .btn-update,
    .btn-cancel {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .user-form-header {
        padding: 1rem;
    }
    
    .section-content {
        padding: 1rem;
    }
    
    .form-actions {
        padding: 1rem;
    }
}
</style>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = field.nextElementSibling;
    const icon = toggle.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
