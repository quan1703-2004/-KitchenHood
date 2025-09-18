@extends('layouts.auth')

@section('title', 'Đăng nhập')
@section('header-text', 'Đăng nhập vào hệ thống')

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
/* Custom styles cho form đăng nhập */
.login-form {
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

.forgot-password {
    text-align: right;
    margin-bottom: 1.5rem;
}

.forgot-password a {
    color: #3498db;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s ease;
}

.forgot-password a:hover {
    color: #2ecc71;
    text-decoration: none;
}

.btn-login {
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

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(52, 152, 219, 0.3);
    color: white;
}

.btn-login:active {
    transform: translateY(0);
}

.btn-login:disabled {
    opacity: 0.7;
    transform: none;
    box-shadow: none;
}

.login-loader {
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

.social-login {
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
    .social-login {
        flex-direction: column;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
}
</style>

<div class="login-form">
    <form method="POST" action="{{ route('login') }}">
    @csrf
        
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
                    autocomplete="current-password"
                />
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="password-toggle-icon"></i>
                </button>
    </div>
    @error('password')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
        </div>

        <!-- Forgot Password -->
        <div class="forgot-password">
            <a href="#" onclick="alert('Tính năng quên mật khẩu đang được phát triển')">
                Quên mật khẩu?
            </a>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn-login" id="login-submit">
            <span id="login-text">Đăng nhập</span>
            <div class="login-loader" id="login-loader">
                <div class="spinner"></div>
      </div>
        </button>
    </form>

    <!-- Divider -->
    <div class="divider">
        <span>Hoặc đăng nhập bằng</span>
    </div>

    <!-- Social Login -->
    <div class="social-login">
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
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('password-toggle-icon');
    
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

// Handle form submission với loading state
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action$="/login"]');
    const submitBtn = document.getElementById('login-submit');
    const loginText = document.getElementById('login-text');
    const loginLoader = document.getElementById('login-loader');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            // Disable button và hiển thị loading
            submitBtn.disabled = true;
            loginText.style.display = 'none';
            loginLoader.style.display = 'flex';
            
            // Thêm hiệu ứng loading cho button
            submitBtn.style.opacity = '0.8';
        });
    }
});
</script>
@endsection

@section('footer')
<div class="text-center">
    Chưa có tài khoản? <a href="{{ route('register') }}" style="color: #1e40af; font-weight: 600;">Đăng ký ngay</a>
</div>
@endsection