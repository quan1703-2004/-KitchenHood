<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đăng nhập/Đăng ký') - KitchenHood Pro</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body{
            background-image: url('{{ asset('images/image.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;           /* phủ kín màn hình, không méo ảnh */
            
            min-height: 100vh;                /* hoặc 100dvh cho mobile mới */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        
        .auth-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.08);
            overflow: hidden;
            max-width: 550px;
            width: 100%;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }
        
        .auth-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            text-align: center;
            padding: 2rem 2.5rem;
        }
        
        .auth-header h2 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .auth-header p {
            opacity: 0.95;
            font-weight: 400;
            font-size: 1.1rem;
        }
        
        .auth-body {
            padding: 2rem 2.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 16px 20px;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
            background: white;
        }
        
        .form-control.is-invalid {
            border-color: #e74c3c;
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.15);
        }
        
        .form-control.is-invalid:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.25);
        }
        
        .invalid-feedback {
            color: #e74c3c;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2ecc71 100%);
            border: none;
            border-radius: 12px;
            padding: 16px 32px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .auth-footer {
            text-align: center;
            padding: 1.5rem 2.5rem;
            border-top: 1px solid #f1f3f4;
            background: #fafbfc;
        }
        
        .auth-footer a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .auth-footer a:hover {
            color: #2ecc71;
            text-decoration: none;
        }
        
        .back-to-home {
            position: absolute;
            top: 30px;
            left: 30px;
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
            z-index: 1000;
            background: rgba(255,255,255,0.9);
            padding: 12px 20px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .back-to-home:hover {
            color: #3498db;
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border-left: 4px solid #ffc107;
        }
        
        .btn-close {
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .btn-close:hover {
            opacity: 1;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .auth-container {
                margin: 20px;
                border-radius: 20px;
                max-width: 100%;
            }
            
            .auth-header, .auth-body, .auth-footer {
                padding: 2rem 1.5rem;
            }
            
            .back-to-home {
                top: 20px;
                left: 20px;
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <a href="/" class="back-to-home">
        <i class="fas fa-arrow-left me-2"></i>Về trang chủ
    </a>
    
    <div class="auth-container">
        <div class="auth-header">
            <h2 class="mb-2">
                <i class="fas fa-wind me-2"></i>KitchenHood Pro
            </h2>
            <p class="mb-0 opacity-90">@yield('header-text', 'Đăng nhập vào hệ thống')</p>
        </div>
        
        <div class="auth-body">
            @yield('content')
        </div>
        
        <div class="auth-footer">
            @yield('footer')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Hiển thị loader khi submit form đăng nhập/đăng ký
    document.addEventListener('DOMContentLoaded', function() {
        const handleFormWithLoader = (formSelector, btnSelector, loaderSelector) => {
            const form = document.querySelector(formSelector);
            if (!form) return;
            const btn = form.querySelector(btnSelector);
            const loader = form.querySelector(loaderSelector);
            form.addEventListener('submit', function() {
                if (btn) btn.setAttribute('disabled', 'disabled');
                if (loader) loader.classList.remove('d-none');
            });
        };
        handleFormWithLoader('form[action$="/login"]', '#login-submit', '#login-loader');
        handleFormWithLoader('form[action$="/register"]', '#register-submit', '#register-loader');
    });
    </script>
</body>
</html>
