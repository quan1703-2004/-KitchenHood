@extends('layouts.auth')

@section('title', 'Đăng nhập')
@section('header-text', 'Đăng nhập vào hệ thống')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </div>
</form>
@endsection

@section('footer')
<div class="text-center">
    Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
</div>
@endsection