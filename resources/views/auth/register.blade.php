@extends('layouts.auth')

@section('title', 'Đăng ký')
@section('header-text', 'Tạo tài khoản mới')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
/* Custom styles cho form đăng ký */
.register-form {
    max-width: 100%;
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-group label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
    font-size: 1rem;
    display: block;
}

.input-group {
    position: relative;
}

.input-group .form-control {
    padding-left: 3rem;
    border-radius: 12px;
    border: 2px solid #e9ecef;
    padding: 16px 20px 16px 3rem;
    font-size: 1.05rem;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.input-group .form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
    background: white;
}

.input-group .form-control.is-invalid {
    border-color: #e74c3c;
    box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.15);
}

.input-group .form-control.is-invalid:focus {
    border-color: #e74c3c;
    box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.25);
}

.input-group .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.1rem;
    z-index: 3;
}

.input-group .password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    font-size: 1.1rem;
    cursor: pointer;
    z-index: 3;
    transition: color 0.3s ease;
}

.input-group .password-toggle:hover {
    color: #3498db;
}

.btn-register {
    background: linear-gradient(135deg, #3498db 0%, #2ecc71 100%);
    border: none;
    border-radius: 12px;
    padding: 16px 32px;
    font-weight: 600;
    font-size: 1.1rem;
    color: white;
    width: 100%;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(52, 152, 219, 0.3);
    color: white;
}

.btn-register:active {
    transform: translateY(0);
}

.btn-register:disabled {
    opacity: 0.7;
    transform: none;
    box-shadow: none;
}

.register-loader {
    display: none;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
}

.spinner {
    width: 24px;
    height: 24px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top: 3px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.password-strength {
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.strength-bar {
    height: 4px;
    background: #e9ecef;
    border-radius: 2px;
    margin-top: 0.25rem;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-weak { background: #e74c3c; width: 25%; }
.strength-fair { background: #f39c12; width: 50%; }
.strength-good { background: #f1c40f; width: 75%; }
.strength-strong { background: #2ecc71; width: 100%; }

.terms-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.terms-checkbox input[type="checkbox"] {
    margin-top: 0.25rem;
    transform: scale(1.2);
}

.terms-checkbox label {
    font-size: 0.95rem;
    color: #6c757d;
    margin-bottom: 0;
    cursor: pointer;
}

.terms-checkbox a {
    color: #3498db;
    text-decoration: none;
    font-weight: 500;
}

.terms-checkbox a:hover {
    color: #2ecc71;
    text-decoration: underline;
}

.divider {
    text-align: center;
    margin: 2rem 0;
    position: relative;
    color: #6c757d;
    font-size: 0.9rem;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e9ecef;
    z-index: 1;
}

.divider span {
    background: white;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}

.social-register {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-btn {
    flex: 1;
    padding: 12px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    background: white;
    color: #6c757d;
    text-decoration: none;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.social-btn:hover {
    border-color: #3498db;
    color: #3498db;
    transform: translateY(-1px);
}

.social-btn.google:hover {
    border-color: #db4437;
    color: #db4437;
}

.social-btn.facebook:hover {
    border-color: #4267B2;
    color: #4267B2;
}

/* Responsive */
@media (max-width: 576px) {
    .social-register {
        flex-direction: column;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .terms-checkbox {
        margin-bottom: 1.25rem;
    }
}
</style>

<div class="register-form">
    <form method="POST" action="{{ route('register') }}">
    @csrf
        
        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Họ và tên</label>
            <div class="input-group">
                <i class="fas fa-user input-icon"></i>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Nhập họ và tên của bạn"
                    required 
                    autocomplete="name"
                />
            </div>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <input 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Nhập địa chỉ email của bạn"
                    required 
                    autocomplete="email"
                />
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    id="password" 
                    name="password" 
                    placeholder="Nhập mật khẩu của bạn"
                    required 
                    autocomplete="new-password"
                    oninput="checkPasswordStrength(this.value)"
                />
                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                    <i class="fas fa-eye" id="password-toggle-icon"></i>
                </button>
            </div>
            <div class="password-strength" id="password-strength" style="display: none;">
                <div id="strength-text"></div>
                <div class="strength-bar">
                    <div class="strength-fill" id="strength-fill"></div>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Nhập lại mật khẩu để xác nhận"
                    required 
                    autocomplete="new-password"
                />
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                    <i class="fas fa-eye" id="password_confirmation-toggle-icon"></i>
                </button>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="terms-checkbox">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">
                Tôi đồng ý với <a href="#" onclick="alert('Điều khoản sử dụng đang được cập nhật')">Điều khoản sử dụng</a> 
                và <a href="#" onclick="alert('Chính sách bảo mật đang được cập nhật')">Chính sách bảo mật</a>
            </label>
        </div>

        <!-- Register Button -->
        <button type="submit" class="btn-register" id="register-submit">
            <span id="register-text">Tạo tài khoản</span>
            <div class="register-loader" id="register-loader">
                <div class="spinner"></div>
            </div>
        </button>
    </form>

    <!-- Divider -->
    <div class="divider">
        <span>Hoặc đăng ký bằng</span>
      </div>

    <!-- Social Register -->
    <div class="social-register">
        <a href="{{ route('auth.google') }}" class="social-btn google">
            <i class="fab fa-google"></i>
            Google
        </a>
        <a href="{{ route('auth.facebook') }}" class="social-btn facebook">
            <i class="fab fa-facebook-f"></i>
            Facebook
        </a>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(fieldId + '-toggle-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Check password strength
function checkPasswordStrength(password) {
    const strengthDiv = document.getElementById('password-strength');
    const strengthText = document.getElementById('strength-text');
    const strengthFill = document.getElementById('strength-fill');
    
    if (password.length === 0) {
        strengthDiv.style.display = 'none';
        return;
    }
    
    strengthDiv.style.display = 'block';
    
    let strength = 0;
    let strengthLabel = '';
    
    // Length check
    if (password.length >= 8) strength++;
    else strengthLabel = 'Mật khẩu quá ngắn';
    
    // Character variety checks
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Determine strength level
    if (strength <= 2) {
        strengthLabel = 'Mật khẩu yếu';
        strengthFill.className = 'strength-fill strength-weak';
    } else if (strength === 3) {
        strengthLabel = 'Mật khẩu trung bình';
        strengthFill.className = 'strength-fill strength-fair';
    } else if (strength === 4) {
        strengthLabel = 'Mật khẩu tốt';
        strengthFill.className = 'strength-fill strength-good';
    } else {
        strengthLabel = 'Mật khẩu mạnh';
        strengthFill.className = 'strength-fill strength-strong';
    }
    
    strengthText.textContent = strengthLabel;
}

// Handle form submission với loading state
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action$="/register"]');
    const submitBtn = document.getElementById('register-submit');
    const registerText = document.getElementById('register-text');
    const registerLoader = document.getElementById('register-loader');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            // Disable button và hiển thị loading
            submitBtn.disabled = true;
            registerText.style.display = 'none';
            registerLoader.style.display = 'flex';
            
            // Thêm hiệu ứng loading cho button
            submitBtn.style.opacity = '0.8';
        });
    }
});
</script>
@endsection

@section('footer')
<div class="text-center">
    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
</div>
@endsection