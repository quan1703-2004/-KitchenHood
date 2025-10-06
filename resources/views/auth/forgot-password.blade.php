@extends('layouts.auth')

@section('title', 'Quên mật khẩu')
@section('header-text', 'Lấy lại mật khẩu của bạn')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
/* Đồng bộ phong cách với trang đăng nhập/đăng ký - không dùng màu tím */
.forgot-form { max-width: 100%; }
.form-group { margin-bottom: 1.5rem; position: relative; }
.floating { position: relative; }
.floating input { border: 2px solid #e9ecef; border-radius: 12px; padding: 20px 44px 12px 44px; font-size: 1rem; background: #fbfbfd; transition: all .25s ease; }
.floating input:focus { border-color: #3498db; box-shadow: 0 0 0 4px rgba(52,152,219,.15); background: #fff; }
.floating label { position: absolute; left: 44px; top: 14px; color: #6b7280; pointer-events: none; transition: all .2s ease; }
.floating input:not(:placeholder-shown)+label, .floating input:focus+label { transform: translateY(-12px); font-size: 12px; color: #3498db; }
.input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 1rem; }
.btn-forgot { background: linear-gradient(135deg, #3498db, #2ecc71); border: none; border-radius: 12px; padding: 14px 28px; font-weight: 700; color: #fff; width: 100%; transition: all .3s ease; }
.btn-forgot:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(52,152,219,.3); color: #fff; }
.btn-forgot:disabled { opacity: .7; }
@media (max-width: 576px) { .form-group { margin-bottom: 1rem; } }
</style>

<div class="forgot-form">
    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf
        <div class="form-group floating">
            <i class="fas fa-envelope input-icon"></i>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                placeholder=" "
                required 
                autocomplete="email"
            />
            <label for="email">Email đã đăng ký</label>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-forgot" id="forgot-submit">
            <span id="forgot-text">Gửi mật khẩu mới</span>
            <div class="login-loader" id="forgot-loader" style="display:none;">
                <div class="spinner" style="width:24px;height:24px;border:3px solid rgba(255,255,255,.3);border-top:3px solid #fff;border-radius:50%;animation:spin 1s linear infinite;"></div>
            </div>
        </button>
    </form>
</div>

<script>
// Trạng thái loading khi submit để tăng UX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action$="/forgot-password"]');
    const btn = document.getElementById('forgot-submit');
    const text = document.getElementById('forgot-text');
    const loader = document.getElementById('forgot-loader');
    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.disabled = true;
            text.style.display = 'none';
            loader.style.display = 'inline-flex';
            btn.style.opacity = '0.9';
        });
    }
});
</script>
@endsection

@section('footer')
<div class="text-center">
    Nhớ mật khẩu rồi? <a href="{{ route('login') }}">Đăng nhập</a> · Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
</div>
@endsection


