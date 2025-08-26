@extends('layouts.auth')

@section('title', 'Xác thực Email')
@section('header-text', 'Xác thực địa chỉ email của bạn')

@section('content')
<div class="text-center">
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-4">
        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
        <h4>Cảm ơn bạn đã đăng ký!</h4>
        <p class="text-muted">
            Chúng tôi đã gửi một email xác thực đến địa chỉ email của bạn. 
            Vui lòng kiểm tra hộp thư và nhấp vào liên kết xác thực để kích hoạt tài khoản.
        </p>
    </div>

    <div class="alert alert-info">
        <strong>Lưu ý:</strong> Email có thể mất vài phút để đến. 
        Hãy kiểm tra cả thư mục spam nếu bạn không thấy email.
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary me-2">
                <i class="fas fa-paper-plane me-2"></i>Gửi lại email xác thực
            </button>
        </form>
        
        <div class="mt-3">
            <a href="{{ route('login') }}" class="btn btn-link">
                <i class="fas fa-arrow-left me-2"></i>Quay lại trang đăng nhập
            </a>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="text-center">
    <p class="text-muted small">
        Nếu bạn gặp vấn đề, vui lòng liên hệ với chúng tôi để được hỗ trợ.
    </p>
</div>
@endsection
