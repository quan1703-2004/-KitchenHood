@extends('layouts.customer')

@section('content')
<style>
    /* Hero section với gradient đẹp */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        padding: 80px 0;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    /* Form liên hệ chính - giống ảnh */
    .contact-form {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        margin-bottom: 0;
        height: 100%;
    }
    
    .contact-form h2 {
        color: #1e3a8a;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .contact-form p {
        color: #6b7280;
        text-align: center;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }
    
    /* Input fields đẹp */
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: #f9fafb;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        background: white;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    /* Button submit đẹp */
    .btn-submit {
        background: linear-gradient(45deg, #3b82f6, #1d4ed8);
        border: none;
        padding: 15px 40px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        width: 100%;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        background: linear-gradient(45deg, #2563eb, #1e40af);
    }
    
    /* Thông tin liên hệ */
    .contact-info {
        background: #ffffff;
        color: #0f172a;
        border-radius: 20px;
        padding: 2.5rem;
        border: 1px solid #eef2f7;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }
    
    .contact-info h4 {
        color: #1e3a8a;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    /* Item thông tin liên hệ */
    .info-item {
        display: flex;
        align-items: start;
        gap: 15px;
        padding: 20px;
        border-radius: 15px;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    
    .info-item:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .info-item .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 50px;
        font-size: 1.2rem;
    }
    
    .info-item .info-content h6 {
        margin: 0 0 5px 0;
        font-weight: 700;
        color: #1e3a8a;
        font-size: 1.1rem;
    }
    
    .info-item .info-content p {
        margin: 0;
        color: #6b7280;
        font-size: 1rem;
    }
    
    .info-actions {
        display: flex;
        gap: 10px;
        margin-top: 12px;
        flex-wrap: wrap;
    }
    
    .btn-soft-primary { 
        background: rgba(59, 130, 246, 0.1); 
        color: #3b82f6; 
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-soft-primary:hover { 
        background: rgba(59, 130, 246, 0.15); 
        color: #1d4ed8;
        transform: translateY(-1px);
    }
    
    /* Social links */
    .social-links {
        text-align: center;
        margin-top: 2rem;
    }
    
    .social-links h6 {
        color: #1e3a8a;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .wrapper {
        display: inline-flex;
        list-style: none;
        width: 100%;
        font-family: "Poppins", sans-serif;
        justify-content: center;
        gap: 15px;
    }
    
    .wrapper .icon {
        position: relative;
        background: #fff;
        border-radius: 50%;
        width: 55px;
        height: 55px;
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border: 2px solid #f1f5f9;
    }
    
    .wrapper .icon:hover {
        transform: translateY(-5px);
    }
    
    .wrapper .tooltip {
        position: absolute;
        top: -40px;
        font-size: 12px;
        background: #1e3a8a;
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    .wrapper .icon:hover .tooltip {
        opacity: 1;
        transform: translateY(-5px);
    }
    
    .wrapper .facebook:hover {
        background: #1877f2;
        color: #fff;
        border-color: #1877f2;
    }
    
    .wrapper .github:hover {
        background: #0f172a;
        color: #fff;
        border-color: #0f172a;
    }
    
    .wrapper .instagram:hover {
        background: #e4405f;
        color: #fff;
        border-color: #e4405f;
    }
    
    /* Cards dịch vụ */
    .service-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        height: 100%;
    }
    
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .service-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }
    
    /* Breadcrumb */
    .breadcrumb-wrapper {
        background: #f8fafc;
        border-bottom: 1px solid #eef2f7;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #9aa3af;
    }
    
    /* Map container */
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        margin-bottom: 3rem;
    }
    
    /* Alert thông báo */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .contact-form {
            padding: 2rem;
            margin: 1rem;
        }
        
        .contact-form h2 {
            font-size: 2rem;
        }
        
        .info-item {
            padding: 15px;
        }
    }
</style>


<!-- Breadcrumb -->
<div class="breadcrumb-wrapper py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <!-- Form gửi tin nhắn và thông tin liên hệ -->
        <div class="row mb-5">
            <div class="col-lg-8 mb-4">
                <div class="contact-form">
                    <h2>Liên Hệ Với Chúng Tôi</h2>
                    <p>Hãy để lại thông tin, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất</p>
                    
                    <!-- Thông báo kết quả gửi -->
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="contactForm" method="POST" action="{{ route('contact.send') }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Họ và tên *</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Chọn dịch vụ *</label>
                                <select class="form-control" id="service" name="service" required>
                                    <option value="">Chọn dịch vụ</option>
                                    <option value="tư-vấn">Tư vấn sản phẩm</option>
                                    <option value="báo-giá">Báo giá</option>
                                    <option value="lắp-đặt">Lắp đặt</option>
                                    <option value="bảo-hành">Bảo hành</option>
                                    <option value="khác">Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="budget" class="form-label">Chọn ngân sách</label>
                                <select class="form-control" id="budget" name="budget">
                                    <option value="">Chọn ngân sách</option>
                                    <option value="dưới-5tr">Dưới 5 triệu</option>
                                    <option value="5-10tr">5 - 10 triệu</option>
                                    <option value="10-20tr">10 - 20 triệu</option>
                                    <option value="20-50tr">20 - 50 triệu</option>
                                    <option value="trên-50tr">Trên 50 triệu</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">Tin nhắn *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Mô tả chi tiết yêu cầu của bạn..." required></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-submit text-white">
                                <i class="fas fa-paper-plane me-2"></i>Gửi Tin Nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="contact-info">
                    <h4>Thông Tin Liên Hệ</h4>
                    
                    <!-- Địa chỉ -->
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <h6>Địa chỉ</h6>
                            <p>{{ $settings->contact_address ?? 'Xuân La - Tây Hồ - Hà Nội' }}</p>
                            <div class="info-actions">
                                <a class="btn btn-sm btn-soft-primary" target="_blank" rel="noopener" href="https://www.google.com/maps/dir/?api=1&destination=Xu%C3%A2n%20La%2C%20T%C3%A2y%20H%E1%BB%93%2C%20H%C3%A0%20N%E1%BB%99i">
                                    <i class="fas fa-directions me-1"></i>Chỉ đường
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Điện thoại -->
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <h6>Điện thoại</h6>
                            <p>{{ $settings->contact_phone ?? '0987 654 321' }}</p>
                            <div class="info-actions">
                                <a class="btn btn-sm btn-soft-primary" href="tel:{{ $settings->contact_phone ?? '0987654321' }}">
                                    <i class="fas fa-phone-alt me-1"></i>Gọi ngay
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <h6>Email</h6>
                            <p>{{ $settings->contact_email ?? 'zzztamdzzz@gmail.com' }}</p>
                            <div class="info-actions"></div>
                                <a class="btn btn-sm btn-soft-primary" href="mailto:{{ $settings->contact_email ?? 'zzztamdzzz@gmail.com' }}">
                                    <i class="fas fa-paper-plane me-1"></i>Gửi email
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="social-links">
                        <h6>Kết Nối Với Chúng Tôi</h6>
                        <ul class="wrapper">
                          <li class="icon facebook" title="Facebook" onclick="window.open('https://www.facebook.com/tamxbl?locale=vi_VN', '_blank')">
                            <span class="tooltip">Facebook</span>
                            <svg viewBox="0 0 320 512" height="1.2em" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                            </svg>
                          </li>
                          <li class="icon github" title="GitHub" onclick="window.open('https://github.com/tambl2004', '_blank')">
                            <span class="tooltip">GitHub</span>
                            <svg height="1.5em" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                              <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.19 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
                            </svg>
                          </li>
                          <li class="icon instagram" title="Instagram">
                            <span class="tooltip">Instagram</span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                              <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                            </svg>
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Bản đồ Google Maps -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="map-container">
                        <!-- Nhúng Google Maps: có thể thay địa chỉ bằng toạ độ/Place ID của bạn -->
                        @if(!empty($settings->contact_map_embed))
                            {!! $settings->contact_map_embed !!}
                        @else
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29784.82077814449!2d105.8172884!3d21.0685641!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1756199478462!5m2!1svi!2s"
                                width="100%"
                                height="420"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cards dịch vụ -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="service-card card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-primary text-white">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-3">Hỗ Trợ 24/7</h5>
                            <p class="text-muted mb-3">
                                Đội ngũ tư vấn chuyên nghiệp luôn sẵn sàng hỗ trợ bạn mọi lúc
                            </p>
                            <a href="tel:0987654321" class="btn btn-outline-primary">
                                <i class="fas fa-phone me-2"></i>Gọi Ngay
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="service-card card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-success text-white">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-3">Lắp Đặt Miễn Phí</h5>
                            <p class="text-muted mb-3">
                                Dịch vụ lắp đặt chuyên nghiệp miễn phí cho mọi đơn hàng
                            </p>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-shopping-cart me-2"></i>Mua Ngay
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="service-card card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-warning text-white">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-3">Bảo Hành 5 Năm</h5>
                            <p class="text-muted mb-3">
                                Cam kết bảo hành chính hãng 5 năm với dịch vụ hậu mãi tốt nhất
                            </p>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-warning">
                                <i class="fas fa-shield-alt me-2"></i>Tìm Hiểu Thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Gợi ý nhỏ: đánh dấu input lỗi khi submit fail phía server
    document.addEventListener('DOMContentLoaded', function() {
        ['firstName','email','service','message'].forEach(function(id) {
            var el = document.getElementById(id);
            if (!el) return;
            if (@json($errors->has('firstName')) && id === 'firstName') el.classList.add('is-invalid');
            if (@json($errors->has('email')) && id === 'email') el.classList.add('is-invalid');
            if (@json($errors->has('service')) && id === 'service') el.classList.add('is-invalid');
            if (@json($errors->has('message')) && id === 'message') el.classList.add('is-invalid');
        });
    });
</script>
@endsection
