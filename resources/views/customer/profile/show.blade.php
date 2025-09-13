@extends('layouts.customer')

@section('title', 'Thông tin tài khoản')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-5">
        <h1 class="display-5 fw-bold text-dark mb-2">Thông tin tài khoản</h1>
        <p class="text-muted">Quản lý thông tin cá nhân và cài đặt tài khoản</p>
    </div>

    <div class="row g-4">
        <!-- Thông tin cá nhân -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 fw-bold text-dark mb-0">Thông tin cá nhân</h2>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa
                        </a>
                    </div>

                    <div class="row g-4">
                        <!-- Avatar -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ảnh đại diện</label>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-user fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-muted mb-0">Ảnh đại diện của bạn</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tên -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên</label>
                            <p class="form-control-plaintext fw-bold text-dark">{{ $user->name }}</p>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="form-control-plaintext text-dark">{{ $user->email }}</p>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Đã xác thực
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Chưa xác thực
                                </span>
                            @endif
                        </div>

                        <!-- Số điện thoại -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số điện thoại</label>
                            <p class="form-control-plaintext text-dark">{{ $user->phone ?: 'Chưa cập nhật' }}</p>
                        </div>

                        <!-- Ngày sinh -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày sinh</label>
                            <p class="form-control-plaintext text-dark">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'Chưa cập nhật' }}</p>
                        </div>

                        <!-- Giới tính -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giới tính</label>
                            <p class="form-control-plaintext text-dark">
                                @switch($user->gender)
                                    @case('male')
                                        Nam
                                        @break
                                    @case('female')
                                        Nữ
                                        @break
                                    @case('other')
                                        Khác
                                        @break
                                    @default
                                        Chưa cập nhật
                                @endswitch
                            </p>
                        </div>

                        <!-- Địa chỉ -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Địa chỉ</label>
                            <p class="form-control-plaintext text-dark">{{ $user->address ?: 'Chưa cập nhật' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                <!-- Thống kê đơn hàng -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-dark mb-4">Thống kê đơn hàng</h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Tổng đơn hàng</span>
                                <span class="fw-bold text-dark">{{ $orderStats['total_orders'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Tổng chi tiêu</span>
                                <span class="fw-bold text-dark">{{ number_format($orderStats['total_spent']) }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Đơn chờ xử lý</span>
                                <span class="fw-bold text-warning">{{ $orderStats['pending_orders'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu nhanh -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-dark mb-4">Menu nhanh</h3>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-light text-start p-3 rounded-3 border-0 bg-light text-dark">
                                <i class="fas fa-shopping-bag me-3 text-primary"></i>Đơn hàng của tôi
                            </a>
                            <a href="{{ route('addresses.index') }}" class="btn btn-outline-light text-start p-3 rounded-3 border-0 bg-light text-dark">
                                <i class="fas fa-map-marker-alt me-3 text-primary"></i>Quản lý địa chỉ
                            </a>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-light text-start p-3 rounded-3 border-0 bg-light text-dark">
                                <i class="fas fa-shopping-cart me-3 text-primary"></i>Giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Đơn hàng gần đây -->
                @if($orderStats['recent_orders']->count() > 0)
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-dark mb-4">Đơn hàng gần đây</h3>
                        <div class="d-flex flex-column gap-3">
                            @foreach($orderStats['recent_orders'] as $order)
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                                <div>
                                    <p class="fw-bold text-dark mb-1">#{{ $order->id }}</p>
                                    <p class="text-muted small mb-0">{{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="text-end">
                                    <p class="fw-bold text-dark mb-1">{{ number_format($order->total_amount) }}đ</p>
                                    <span class="badge 
                                        @switch($order->status)
                                            @case('pending')
                                                bg-warning
                                                @break
                                            @case('processing')
                                                bg-info
                                                @break
                                            @case('shipped')
                                                bg-primary
                                                @break
                                            @case('delivered')
                                                bg-success
                                                @break
                                            @case('cancelled')
                                                bg-danger
                                                @break
                                            @default
                                                bg-secondary
                                        @endswitch
                                    ">
                                        @switch($order->status)
                                            @case('pending')
                                                Chờ xử lý
                                                @break
                                            @case('processing')
                                                Đang xử lý
                                                @break
                                            @case('shipped')
                                                Đang giao
                                                @break
                                            @case('delivered')
                                                Đã giao
                                                @break
                                            @case('cancelled')
                                                Đã hủy
                                                @break
                                            @default
                                                {{ $order->status }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('orders.index') }}" class="text-primary text-decoration-none fw-semibold">Xem tất cả đơn hàng →</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
