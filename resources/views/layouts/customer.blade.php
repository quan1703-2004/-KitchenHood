<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KitchenHood Pro - Máy Hút Mùi Chất Lượng Cao</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Fallback cho Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
    <!-- CDN dự phòng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
    <style>
        :root {
            --primary-color: #3498db;
            --primary-dark: #2980b9;
            --primary-light: #5dade2;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --light-blue: #ecf0f1;
            --border-color: #e9ecef;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f2f4f7;
            color: var(--text-dark);
        }
        
        .navbar {
            background: var(--white) !important;
            box-shadow: 0 2px 20px rgba(52, 152, 219, 0.1);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        /* Navbar sticky thông minh: ẩn khi cuộn xuống, hiện khi cuộn lên */
        .navbar.smart-sticky {
            position: sticky; /* giữ ở top khi cuộn */
            top: 0;
            z-index: 1030; /* cao hơn nội dung khác */
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
            will-change: transform;
        }
        .navbar.smart-sticky.navbar-hidden {
            transform: translateY(-100%); /* ẩn đi khi cuộn xuống */
        }
        .navbar.smart-sticky.navbar-scrolled {
            box-shadow: 0 6px 20px rgba(44, 62, 80, 0.08);
            background-color: var(--white) !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            margin: 0 0.25rem;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: var(--light-blue);
        }
        
        .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: var(--white);
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
            color: var(--white);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.15);
            border-radius: 15px;
            min-width: 220px;
            border: 1px solid var(--border-color);
        }
        
        .dropdown-item {
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-blue);
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .dropdown-item.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-color);
            color: #000;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 7px;
            border-radius: 50%;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: var(--text-light);
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
        
        .breadcrumb-item.active {
            color: var(--text-light);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .pagination .page-link {
            color: var(--primary-color);
            border-color: var(--border-color);
        }
        
        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white);
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-color: var(--primary-color);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
        }
        
        .is-invalid {
            border-color: #dc3545;
        }
        
        .is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        
        .newsletter-section {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        }
        
        .newsletter-section .form-control {
            border: none;
            border-radius: 25px 0 0 25px;
        }
        
        .newsletter-section .btn {
            border-radius: 0 25px 25px 0;
            border: none;
        }
        
        .product-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.1);
            border: 1px solid var(--border-color);
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(52, 152, 219, 0.2);
            border-color: var(--primary-light);
        }
        
        .product-image {
            height: 280px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        
        .price-tag {
            background: linear-gradient(135deg, var(--accent-color), #ffca28);
            color: #000;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 20px;
            padding: 8px 16px;
        }
        
        .btn-add-cart {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
        }
        
        .rating-stars {
            display: inline-flex;
            align-items: center;
        }
        
        .rating-stars .fas.fa-star,
        .rating-stars .fas.fa-star-half-alt {
            color: #ffc107 !important;
        }
        
        .rating-stars .far.fa-star {
            color: #6c757d !important;
        }
        
        .product-rating {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
        
        .product-rating .progress {
            border-radius: 10px;
            background-color: #e9ecef;
        }
        
        .product-rating .progress-bar {
            border-radius: 10px;
            background: linear-gradient(90deg, #ffc107 0%, #ffb300 100%);
        }
        
        .product-rating .badge {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        .rating-stars .fa-lg {
            font-size: 1.25rem;
        }
        
        .rating-stars .fa-2x {
            font-size: 1.5rem;
        }
        
        /* Fallback cho Font Awesome icons */
        .fas, .far, .fab {
            display: inline-block !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }
        
        /* Fallback text cho các icon quan trọng */
        .icon-fallback {
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: inherit;
        }
        
        /* Đảm bảo icon hiển thị đúng */
        .navbar .fas,
        .navbar .far,
        .navbar .fab {
            font-size: 1em;
            line-height: 1;
            vertical-align: middle;
        }
        
        .category-filter {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.1);
            border: 1px solid var(--border-color);
        }
        
        .hero-section {
            min-height: 70vh;
            position: relative;
            overflow: hidden;
            background: var(--white);
        }
        
        .hero-slide {
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        /* Text styling cho banner để dễ đọc */
        .hero-slide .text-dark {
            color: #ffffff !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            font-weight: 700;
        }
        
        .hero-slide .text-muted {
            color: #ffffff !important;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.9);
            font-weight: 500;
        }
        
        .hero-slide .text-primary {
            color: #ffffff !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            font-weight: 800;
        }
        
        .hero-slide .badge {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
            font-weight: 600;
        }
        
        .hero-slide .btn {
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        .hero-slide .btn-outline-primary {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #ffffff;
            color: #2c3e50;
            backdrop-filter: blur(10px);
        }
        
        .hero-slide .btn-outline-primary:hover {
            background: #ffffff;
            border-color: #ffffff;
            color: #2c3e50;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }
        
        .hero-slide .btn-primary {
            background: rgba(52, 152, 219, 0.9);
            border: 2px solid #ffffff;
            backdrop-filter: blur(10px);
        }
        
        .hero-slide .btn-primary:hover {
            background: rgba(52, 152, 219, 1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }
        
        /* Overlay tối để tăng độ tương phản */
        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0.6) 100%);
            z-index: 1;
        }
        
        .hero-slide .container {
            position: relative;
            z-index: 2;
        }
        
        /* Responsive text sizing */
        @media (max-width: 768px) {
            .hero-slide .display-3 {
                font-size: 2.5rem;
            }
            
            .hero-slide .lead {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-slide .display-3 {
                font-size: 2rem;
            }
            
            .hero-slide .lead {
                font-size: 1rem;
            }
        }
        
        .carousel {
            height: 70vh;
        }
        
        .carousel-item {
            height: 70vh;
        }
        
        .carousel-item .hero-slide {
            height: 100%;
        }
        
        .carousel-indicators {
            bottom: 30px;
            z-index: 15;
        }
        
        .carousel-indicators button {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: rgba(52, 152, 219, 0.3);
            border: 2px solid rgba(52, 152, 219, 0.2);
            margin: 0 8px;
            transition: all 0.3s ease;
        }
        
        .carousel-indicators button.active {
            background-color: var(--primary-color);
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(52, 152, 219, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            border: 2px solid rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
        }
        
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(52, 152, 219, 0.4);
            border-color: var(--primary-color);
            transform: translateY(-50%) scale(1.1);
        }
        
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 24px;
            height: 24px;
        }
        
        .hero-image img {
            transition: transform 0.3s ease;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .carousel-item.active .hero-image img {
            transform: scale(1.05);
        }
        
        /* Animation cho carousel content */
        .carousel-item .text-white {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .carousel-item .hero-image {
            animation: fadeInRight 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Responsive cho carousel */
        @media (max-width: 768px) {
            .hero-section,
            .carousel,
            .carousel-item,
            .hero-slide {
                min-height: 60vh;
                height: 60vh;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                width: 50px;
                height: 50px;
            }
            
            .carousel-indicators {
                bottom: 20px;
            }
            
            .carousel-indicators button {
                width: 12px;
                height: 12px;
                margin: 0 6px;
            }
        }
        
        @media (max-width: 576px) {
            .hero-section,
            .carousel,
            .carousel-item,
            .hero-slide {
                min-height: 50vh;
                height: 50vh;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
            }
            
            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                width: 18px;
                height: 18px;
            }
        }
        
        .feature-card {
            text-align: center;
            padding: 2.5rem;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.1);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(52, 152, 219, 0.2);
            border-color: var(--primary-light);
        }
        
        .feature-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        }
        
        .stats-card {
            text-align: center;
            padding: 2.5rem;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.1);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(52, 152, 219, 0.2);
        }
        
        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }
        
        .stats-card p {
            color: var(--text-light);
            margin-bottom: 0;
            font-weight: 500;
        }
        
        .section-title {
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .product-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .product-description {
            color: var(--text-light);
            margin-bottom: 1rem;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--accent-color), #e0a800);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
            color: #000;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .hero-section {
                min-height: 50vh;
            }
            
            .display-4 {
                font-size: 2rem;
            }
            
            .display-5 {
                font-size: 1.5rem;
            }
            
            .stats-card h3 {
                font-size: 2rem;
            }
        }
        
        .admin-badge {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: var(--white);
            font-size: 0.7rem;
            padding: 3px 10px;
            border-radius: 15px;
            margin-left: 5px;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }
        
        footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: var(--white);
            margin-top: auto;
        }
        
        .footer-link {
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light smart-sticky">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-wind me-2"></i>KitchenHood Pro
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                            <i class="fas fa-home me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-box me-1"></i>Sản phẩm
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('news*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                            <i class="fas fa-newspaper me-1"></i>Tin tức
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-phone me-1"></i>Liên hệ
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#">
                            <i class="fas fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cart-count">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-login ms-2">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                                @if(Auth::user()->role === 'admin')
                                    <span class="admin-badge">ADMIN</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i>Thông tin tài khoản
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Quản lý địa chỉ
                                </a></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-heart me-2"></i>Sản phẩm yêu thích
                                </a></li>
                                
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Quản trị</h6></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">
                                        <i class="fas fa-tags me-2"></i>Quản lý danh mục
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">
                                        <i class="fas fa-box me-2"></i>Quản lý sản phẩm
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.news.index') }}">
                                        <i class="fas fa-newspaper me-2"></i>Quản lý tin tức
                                    </a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-wind me-2"></i>KitchenHood Pro
                    </h5>
                    <p class="text-light opacity-75 mb-3">
                        Chuyên cung cấp máy hút mùi cao cấp với chất lượng tốt nhất và dịch vụ chuyên nghiệp.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-link"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-youtube fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Sản phẩm</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Máy hút mùi âm tủ</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Máy hút mùi kính cong</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Máy hút mùi đảo bếp</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Phụ kiện</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Hỗ trợ</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Bảo hành</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Hướng dẫn sử dụng</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Chính sách</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Chính sách bảo mật</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Điều khoản sử dụng</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Chính sách đổi trả</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Liên hệ</h6>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <small>123 Đường ABC, Q.1, TP.HCM</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <small>0123 456 789</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope me-2"></i>
                        <small>info@kitchenhoodpro.com</small>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 opacity-75">
                        © 2025 KitchenHood Pro. Tất cả quyền được bảo lưu.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end gap-3">
                        <!-- VISA -->
                        <div class="payment-icon visa-icon d-flex align-items-center justify-content-center rounded" 
                             style="width: 40px; height: 25px; background: linear-gradient(135deg, #0052cc 0%, #1a75ff 100%);">
                            <span class="text-white fw-bold" style="font-size: 10px;">VISA</span>
                        </div>
                        <!-- MasterCard -->
                        <div class="payment-icon mastercard-icon d-flex align-items-center justify-content-center rounded" 
                             style="width: 40px; height: 25px; background: linear-gradient(135deg, #eb001b 0%, #ff6b6b 100%);">
                            <span class="text-white fw-bold" style="font-size: 10px;">MC</span>
                        </div>
                        <!-- MoMo -->
                        <div class="payment-icon momo-icon d-flex align-items-center justify-content-center rounded" 
                             style="width: 40px; height: 25px; background: linear-gradient(135deg, #003087 0%, #4a90e2 100%);">
                            <span class="text-white fw-bold" style="font-size: 10px;">MoMo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- CSS cho payment icons -->
    <style>
        .payment-icon {
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .payment-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .visa-icon {
            background: linear-gradient(135deg, #0052cc 0%, #1a75ff 100%) !important;
        }
        
        .mastercard-icon {
            background: linear-gradient(135deg, #eb001b 0%, #ff6b6b 100%) !important;
        }
        
        .momo-icon {
            background: linear-gradient(135deg, #003087 0%, #4a90e2 100%) !important;
        }
    </style>
    
    <style>
        /* Global page loader */
        #global-page-loader{position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:transparent;z-index:1050}
        #global-page-loader .wrapper{display:flex;justify-content:center;align-items:center;height:60px}
        #global-page-loader .ball{--size:16px;width:var(--size);height:var(--size);border-radius:11px;margin:0 10px;animation:2s bounce ease infinite}
        #global-page-loader .blue{background-color:#4285f5}
        #global-page-loader .red{background-color:#ea4436;animation-delay:.25s}
        #global-page-loader .yellow{background-color:#fbbd06;animation-delay:.5s}
        #global-page-loader .green{background-color:#34a952;animation-delay:.75s}
        @keyframes bounce{50%{transform:translateY(25px)}}
    </style>
    <div id="global-page-loader" aria-hidden="true">
        <div class="wrapper">
            <div class="blue ball"></div>
            <div class="red ball"></div>
            <div class="yellow ball"></div>
            <div class="green ball"></div>
        </div>
    </div>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add active class to current nav item
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            const navbar = document.querySelector('nav.navbar.smart-sticky');
            let lastScrollY = window.scrollY;
            let ticking = false;
            const delta = 8; // ngưỡng thay đổi nhỏ bỏ qua để tránh nhấp nháy
            const showAtTopThreshold = 80; // sau khi vượt mốc này mới cho phép ẩn khi kéo xuống
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                }
            });
            
            // Logic ẩn/hiện navbar theo hướng cuộn
            const handleScroll = () => {
                const currentY = window.scrollY;
                // thêm style khi đã cuộn xuống khỏi top một chút
                if (currentY > 5) {
                    navbar?.classList.add('navbar-scrolled');
                } else {
                    navbar?.classList.remove('navbar-scrolled');
                }
                // nếu chênh lệch nhỏ thì bỏ qua (tránh toggle liên tục)
                if (Math.abs(currentY - lastScrollY) < delta) {
                    ticking = false;
                    return;
                }
                // cuộn xuống và đã vượt qua ngưỡng -> ẩn
                if (currentY > lastScrollY && currentY > showAtTopThreshold) {
                    navbar?.classList.add('navbar-hidden');
                } else {
                    // cuộn lên -> hiện
                    navbar?.classList.remove('navbar-hidden');
                }
                lastScrollY = currentY;
                ticking = false;
            };

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(handleScroll);
                    ticking = true;
                }
            }, { passive: true });

            // Carousel functionality
            const heroCarousel = document.getElementById('heroCarousel');
            if (heroCarousel) {
                // Auto-play carousel
                const carousel = new bootstrap.Carousel(heroCarousel, {
                    interval: 5000,
                    wrap: true,
                    keyboard: true,
                    pause: 'hover'
                });
                
                // Pause carousel on hover
                heroCarousel.addEventListener('mouseenter', function() {
                    carousel.pause();
                });
                
                heroCarousel.addEventListener('mouseleave', function() {
                    carousel.cycle();
                });
                
                // Add smooth transitions
                heroCarousel.addEventListener('slide.bs.carousel', function(e) {
                    const activeItem = heroCarousel.querySelector('.carousel-item.active');
                    const nextItem = heroCarousel.querySelectorAll('.carousel-item')[e.to];
                    
                    if (activeItem) {
                        activeItem.style.transition = 'opacity 0.6s ease-in-out';
                    }
                    if (nextItem) {
                        nextItem.style.transition = 'opacity 0.6s ease-in-out';
                    }
                });
                
                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowLeft') {
                        carousel.prev();
                    } else if (e.key === 'ArrowRight') {
                        carousel.next();
                    }
                });
            }
            // Global loader for navigation clicks
            const pageLoader = document.getElementById('global-page-loader');
            const requestShow = () => { if(pageLoader) pageLoader.style.display = 'flex'; };
            const hideWhenReady = () => { if(pageLoader) pageLoader.style.display = 'none'; };

            // Show loader trên bất kỳ click điều hướng hợp lệ
            document.body.addEventListener('click', function(e){
                const a = e.target.closest('a');
                if(!a) return;
                // Bỏ qua mở tab mới / có modifier key
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                const href = a.getAttribute('href');
                if(!href || href.startsWith('#') || a.hasAttribute('target')) return;
                if(href.startsWith('javascript:')) return;
                requestShow();
            }, {capture:true});

            // Ẩn khi trang mới hiển thị
            window.addEventListener('pageshow', hideWhenReady);
        });
    </script>
</body>
</html>
