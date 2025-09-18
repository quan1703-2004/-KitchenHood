<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - KitchenHood Pro')</title>
    @if(View::hasSection('meta_description'))
    <meta name="description" content="@yield('meta_description')">
    @endif
    <!-- Preload critical CSS -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></noscript>
    
    <!-- Preload FontAwesome -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"></noscript>
    
    <!-- Preload Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"></noscript>
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary-color: #f8fafc;
            --accent-color: #10b981;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            background: #f8fafc;
            color: var(--text-dark);
            font-size: 14px;
        }
        
        /* Admin Sidebar - modernized */
        .admin-sidebar {
            background: #ffffff;
            min-height: 100vh;
            padding: 0;
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            z-index: 1000;
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }
        
        .admin-sidebar .sidebar-header {
            padding: 1.25rem 1.25rem 0.75rem 1.25rem;
            text-align: left;
            color: var(--text-dark);
            position: relative;
        }
        

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .admin-sidebar .sidebar-header h4 {
            font-weight: 800;
            font-size: 1.15rem;
            margin: 0 0 0.25rem 0;
        }
        
        .admin-sidebar .sidebar-header .subtitle {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 0.25rem;
            position: relative;
            z-index: 1;
        }
        
        .admin-sidebar .nav { padding: 0.75rem 0 1.25rem 0; }
        
        .admin-sidebar .nav-link {
            color: var(--text-dark) !important;
            padding: 0.65rem 0.9rem;
            margin: 0.2rem 0.75rem;
            border: none;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 10px;
        }
        
        .admin-sidebar .nav-link:hover {
            background: #f1f5f9;
            color: var(--text-dark) !important;
            transform: translateX(4px);
        }
        
        .admin-sidebar .nav-link.active {
            background: #eef2ff;
            color: var(--primary-color) !important;
            box-shadow: none;
        }
        
        .admin-sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: var(--primary-color);
            border-radius: 50%;
        }
        
        .admin-sidebar .nav-link i {
            font-size: 1rem;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        .admin-sidebar .nav-divider {
            margin: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            opacity: 0.5;
        }

        /* Sidebar search */
        .sidebar-search { padding: 0 1.25rem 0.5rem 1.25rem; }
        .sidebar-search .form-control {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            height: 38px;
            font-size: 0.9rem;
        }
        
        /* Admin Content */
        .admin-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
            background: #f8fafc;
        }
        
        .admin-content .content-header {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }
        
        .admin-content .content-title {
            color: var(--text-dark);
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .admin-content .content-subtitle {
            color: var(--text-light);
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-color);
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-color);
        }
        
        .dashboard-card .card-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .dashboard-card .card-count {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .dashboard-card .card-title {
            color: var(--text-light);
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .dashboard-card .card-action {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .dashboard-card .card-action:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
            text-decoration: none;
        }
        
        /* Admin Tables */
        .admin-table {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        .admin-table .table {
            margin-bottom: 0;
        }
        
        .admin-table .table th {
            background: #f8fafc;
            border: none;
            font-weight: 600;
            color: var(--text-dark);
            padding: 1.25rem 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
        }
        
        .admin-table .table td {
            border: none;
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
        }
        
        .admin-table .table tbody tr:hover {
            background: #f8fafc;
        }
        
        .admin-table .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--accent-color) 0%, #34d399 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, var(--accent-color) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 8px;
            margin: 0 0.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-edit {
            background: #fbbf24;
            color: #92400e;
        }
        
        .btn-edit:hover {
            background: #f59e0b;
            color: #92400e;
            transform: translateY(-1px);
        }
        
        .btn-delete {
            background: #ef4444;
            color: white;
        }
        
        .btn-delete:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-view {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-view:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }
        
        /* Admin Forms */
        .admin-form {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }
        
        .admin-form .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }
        
        .admin-form .form-control {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }
        
        .admin-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        
        .admin-form .form-select {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
        }
        
        .admin-form .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        
        /* Admin Alerts */
        .admin-alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }
        
        .admin-alert.alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-left: 4px solid var(--accent-color);
        }
        
        .admin-alert.alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .admin-alert.alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        
        .admin-alert.alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border-left: 4px solid var(--primary-color);
        }
        
        /* Pagination */
        .admin-pagination {
            margin-top: 2rem;
        }
        
        .admin-pagination .page-link {
            color: var(--primary-color);
            border-color: var(--border-color);
            border-radius: 8px;
            margin: 0 0.25rem;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .admin-pagination .page-link:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }
        
        .admin-pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: var(--shadow-md);
        }
        
        /* Search */
        .admin-search {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }
        
        .admin-search .form-control {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
        }
        
        .admin-search .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .admin-search .btn {
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            margin-left: 0.75rem;
            font-weight: 600;
        }
        
        /* Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }
        
        .badge-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
        }
        
        .badge-success {
            background: linear-gradient(135deg, var(--accent-color) 0%, #34d399 100%);
            color: white;
        }
        
        /* Responsive */
        .sidebar-toggle {
            display: none;
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        @media (max-width: 1024px) {
            .admin-sidebar {
                width: 250px;
            }
            .admin-content {
                margin-left: 250px;
            }
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px;
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1001;
            }
            
            .dashboard-card {
                padding: 1.5rem;
            }
            
            .dashboard-card .card-count {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .admin-content {
                padding: 0.75rem;
            }
            
            .admin-content .content-header {
                padding: 1.5rem;
            }
            
            .dashboard-card {
                padding: 1rem;
            }
            
            .dashboard-card .card-count {
                font-size: 1.75rem;
            }
            
            .admin-table {
                font-size: 0.875rem;
            }
            
            .admin-table .table th,
            .admin-table .table td {
                padding: 1rem 0.75rem;
            }
        }
        
        /* ====== Global Admin Enhancements (đồng bộ phong cách như trang FAQ) ====== */
        .admin-content .card {
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }

        .admin-content .card:hover {
            box-shadow: var(--shadow-md);
        }

        /* Bảng mặc định */
        .admin-content .table {
            margin-bottom: 0;
        }

        .admin-content .table thead th,
        .admin-content thead.table-dark th {
            background: #f8fafc !important;
            color: var(--text-dark) !important;
            border-bottom: 1px solid var(--border-color) !important;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .admin-content .table tbody td {
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .admin-content .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Nút hành động nhỏ đồng bộ */
        .admin-content .btn.btn-sm {
            border-radius: 8px;
            padding: 0.4rem 0.65rem;
            font-weight: 600;
        }

        .btn-warning { background: #fbbf24; color: #92400e; border: none; }
        .btn-warning:hover { background: #f59e0b; color: #92400e; transform: translateY(-1px); }
        .btn-danger { background: #ef4444; border: none; }
        .btn-danger:hover { background: #dc2626; transform: translateY(-1px); }
        .btn-success { color: #0f5132; }

        /* Badge mở rộng để dùng chung */
        .badge-info { background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); color: #fff; }
        .badge-secondary { background: #e2e8f0; color: #334155; }

        /* Tiêu đề trang và khu vực header */
        .admin-content h1, .admin-content .h1, .admin-content .content-title {
            color: var(--text-dark);
            font-weight: 800;
        }

        /* Khoảng cách container cũ */
        .admin-content .container, .admin-content .container-fluid { padding-left: 0; padding-right: 0; }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Admin Sidebar -->
    <div class="admin-sidebar">
        <button class="sidebar-toggle" type="button" onclick="toggleSidebar()">
            <i class="fas fa-bars me-2"></i>Menu
        </button>
        
        <div class="sidebar-header">
            <h4><i class="fas fa-shield-alt me-2"></i>Admin Panel</h4>
            <div class="subtitle">KitchenHood Pro</div>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags"></i>
                <span>Quản lý danh mục</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="fas fa-box"></i>
                <span>Quản lý sản phẩm</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                <i class="fas fa-newspaper"></i>
                <span>Quản lý tin tức</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}">
                <i class="fas fa-question-circle"></i>
                <span>Quản lý FAQ</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Quản lý Đơn hàng</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                <i class="fas fa-star"></i>
                <span>Quản lý Đánh giá</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" href="{{ route('admin.inventory.index') }}">
                <i class="fas fa-warehouse"></i>
                <span>Quản lý Tồn kho</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users"></i>
                <span>Quản lý Người dùng</span>
            </a>
            
            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.dashboard') }}">
                <i class="fas fa-chart-line"></i>
                <span>Báo cáo & Thống kê</span>
            </a>
            
                
            <div class="nav-divider"></div>
            <a class="nav-link" href="/">
                <i class="fas fa-home"></i>
                <span>Về trang chủ</span>
            </a>
        </nav>
    </div>
    
    <!-- Admin Content -->
    <div class="admin-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Toggle sidebar function
        function toggleSidebar() {
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.admin-sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                    document.querySelector('.sidebar-overlay').classList.remove('show');
                }
            }
        });
        
        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate dashboard cards on load
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>
