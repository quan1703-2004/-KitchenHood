@extends('layouts.customer')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
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
    
    .contact-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        background: white;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .contact-form {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #2c5aa0;
        box-shadow: 0 0 0 0.2rem rgba(44, 90, 160, 0.25);
    }
    
    .btn-submit {
        background: linear-gradient(45deg, #2c5aa0, #1e40af);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(44, 90, 160, 0.3);
    }
    
    .contact-info {
        /* Nền trắng, bố cục rõ ràng cho khối thông tin liên hệ */
        background: #ffffff;
        color: #0f172a;
        border-radius: 15px;
        padding: 2rem;
        height: 97%;
        border: 1px solid #eef2f7;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    }
    
    /* Item thông tin liên hệ đẹp, rõ ràng */
    .info-item {
        display: flex;
        align-items: start;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 12px;
        transition: all .25s ease;
        position: relative;
    }
    .info-item .info-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: rgba(44,90,160,.1);
        color: #2c5aa0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 46px;
    }
    .info-item .info-content h6 {
        margin: 0 0 4px 0;
        font-weight: 700;
        color: #0f172a;
    }
    .info-item .info-content p {
        margin: 0;
        color: #475569;
    }
    .info-actions {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
    }
    .btn-soft-primary { background: rgba(44,90,160,.1); color: #1e40af; border: 0; }
    .btn-soft-primary:hover { background: rgba(44,90,160,.16); color: #1e3a8a; }
    .btn-soft-dark { background: #eef2f7; color: #0f172a; border: 0; }
    .btn-soft-dark:hover { background: #e5eaf2; }

    .contact-icon {
        width: 60px;
        height: 60px;
        background: rgba(44,90,160,0.1);
        color: #2c5aa0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: #f1f5f9;
        color: #1f2a44;
        border-radius: 50%;
        margin: 0 10px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-links a:hover {
        background: rgba(44,90,160,0.12);
        transform: translateY(-3px);
        color: #1e40af;
    }
    /* Breadcrumb đồng bộ layout */
    .breadcrumb-wrapper {
        background: #f8fafc;
        border-bottom: 1px solid #eef2f7;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #9aa3af;
    }
    
    /* From Uiverse.io by david-mohseni - Social icons hover đẹp */
    .wrapper {
      display: inline-flex;
      list-style: none;
      width: 100%;
      font-family: "Poppins", sans-serif;
      justify-content: center;
    }
    .wrapper .icon {
      position: relative;
      background: #fff;
      border-radius: 50%;
      margin: 10px;
      width: 50px;
      height: 50px;
      font-size: 18px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    .wrapper .tooltip {
      position: absolute;
      top: 0;
      font-size: 14px;
      background: #fff;
      color: #fff;
      padding: 5px 8px;
      border-radius: 5px;
      box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
      opacity: 0;
      pointer-events: none;
      transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    .wrapper .tooltip::before {
      position: absolute;
      content: "";
      height: 8px;
      width: 8px;
      background: #fff;
      bottom: -3px;
      left: 50%;
      transform: translate(-50%) rotate(45deg);
      transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    .wrapper .icon:hover .tooltip {
      top: -45px;
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }
    .wrapper .icon:hover span,
    .wrapper .icon:hover .tooltip {
      text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
    }
    .wrapper .facebook:hover,
    .wrapper .facebook:hover .tooltip,
    .wrapper .facebook:hover .tooltip::before {
      background: #1877f2;
      color: #fff;
    }
    .wrapper .twitter:hover,
    .wrapper .twitter:hover .tooltip,
    .wrapper .twitter:hover .tooltip::before {
      background: #1da1f2;
      color: #fff;
    }
    .wrapper .instagram:hover,
    .wrapper .instagram:hover .tooltip,
    .wrapper .instagram:hover .tooltip::before {
      background: #e4405f;
      color: #fff;
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
        <!-- Thông tin liên hệ và form -->
        <div class="row mb-5">
            <div class="col-lg-8 mb-4">
                <div class="contact-form">
                    <h3 class="fw-bold text-dark mb-4">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        Gửi Tin Nhắn Cho Chúng Tôi
                    </h3>
                    <p class="text-muted mb-4">
                        Hãy để lại thông tin, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất
                    </p>
                    
                    <!-- Thông báo kết quả gửi -->
                    <div id="contactAlert" class="alert alert-success d-none" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Gửi thành công! Chúng tôi sẽ phản hồi sớm nhất.
                    </div>

                    <form id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label fw-bold">Họ và tên *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="firstName" placeholder="Nhập họ và tên" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Số điện thoại *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="phone" placeholder="Nhập số điện thoại" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">Chủ đề *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                                <select class="form-control" id="subject" required>
                                    <option value="">Chọn chủ đề</option>
                                    <option value="tư-vấn">Tư vấn sản phẩm</option>
                                    <option value="báo-giá">Báo giá</option>
                                    <option value="lắp-đặt">Lắp đặt</option>
                                    <option value="bảo-hành">Bảo hành</option>
                                    <option value="khác">Khác</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Nội dung tin nhắn *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-comment-dots"></i></span>
                                <textarea class="form-control" id="message" rows="5" placeholder="Mô tả chi tiết yêu cầu của bạn..." required></textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-submit text-white btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi Tin Nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="text-center mb-3">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Thông Tin Liên Hệ</h4>
                        <small class="text-muted">Chúng tôi luôn sẵn sàng hỗ trợ bạn</small>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="info-item mb-3">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <h6>Địa chỉ</h6>
                            <p>Xuân La - Tây Hồ - Hà Nội</p>
                            <div class="info-actions">
                                <a class="btn btn-sm btn-soft-primary" target="_blank" rel="noopener" href="https://www.google.com/maps/dir/?api=1&destination=Xu%C3%A2n%20La%2C%20T%C3%A2y%20H%E1%BB%93%2C%20H%C3%A0%20N%E1%BB%99i">
                                    <i class="fas fa-directions me-1"></i>Chỉ đường
                                </a>
                              
                            </div>
                        </div>
                    </div>

                    <!-- Điện thoại -->
                    <div class="info-item mb-3">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <h6>Điện thoại</h6>
                            <p>0987 654 321</p>
                            <div class="info-actions">
                                <a class="btn btn-sm btn-soft-primary" href="tel:0987654321">
                                    <i class="fas fa-phone-alt me-1"></i>Gọi ngay
                                </a>
                    
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="info-item mb-4">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <h6>Email</h6>
                            <p>tam@kitchenhoodpro.com</p>
                            <div class="info-actions">
                                <a class="btn btn-sm btn-soft-primary" href="mailto:tam@kitchenhoodpro.com">
                                    <i class="fas fa-paper-plane me-1"></i>Gửi email
                                </a>
                              
                            </div>
                        </div>
                    </div>

                    <div class="text-center pt-2">
                        <h6 class="fw-bold mb-2">Kết Nối Với Chúng Tôi</h6>
                        <!-- From Uiverse.io by david-mohseni -->
                        <ul class="wrapper">
                          <li class="icon facebook" title="Facebook">
                            <span class="tooltip">Facebook</span>
                            <svg viewBox="0 0 320 512" height="1.2em" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                            </svg>
                          </li>
                          <li class="icon twitter" title="Twitter">
                            <span class="tooltip">Twitter</span>
                            <svg height="1.8em" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="twitter">
                              <path d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429"></path>
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

        <!-- Bản đồ Google Maps -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="map-container">
                    <!-- Nhúng Google Maps: có thể thay địa chỉ bằng toạ độ/Place ID của bạn -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29784.82077814449!2d105.8172884!3d21.0685641!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1756199478462!5m2!1svi!2s"
                        width="100%"
                        height="420"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <!-- Thông tin bổ sung -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="contact-card card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-headset fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Hỗ Trợ 24/7</h5>
                        <p class="text-muted mb-3">
                            Đội ngũ tư vấn chuyên nghiệp luôn sẵn sàng hỗ trợ bạn mọi lúc
                        </p>
                        <a href="tel:0123456789" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Gọi Ngay
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="contact-card card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-tools fa-2x"></i>
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
                <div class="contact-card card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Bảo Hành 5 Năm</h5>
                        <p class="text-muted mb-3">
                            Cam kết bảo hành chính hãng 5 năm với dịch vụ hậu mãi tốt nhất
                        </p>
            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Validate + hiển thị thông báo đẹp bằng Bootstrap
    const contactFormElement = document.getElementById('contactForm');
    const contactAlertElement = document.getElementById('contactAlert');

    contactFormElement.addEventListener('submit', function(e) {
        e.preventDefault();

        // Thu thập dữ liệu form
        const formData = {
            firstName: document.getElementById('firstName').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            email: document.getElementById('email').value.trim(),
            subject: document.getElementById('subject').value.trim(),
            message: document.getElementById('message').value.trim()
        };

        // Kiểm tra bắt buộc (logic đơn giản ở FE, BE nên kiểm tra lại)
        const isInvalid = !formData.firstName || !formData.phone || !formData.subject || !formData.message;
        if (isInvalid) {
            // Thêm class Bootstrap để báo lỗi trực quan
            [
                ['firstName', formData.firstName],
                ['phone', formData.phone],
                ['subject', formData.subject],
                ['message', formData.message]
            ].forEach(([id, value]) => {
                const el = document.getElementById(id);
                if (!el) return;
                el.classList.toggle('is-invalid', !value);
            });
            return;
        }

        // Hiển thị alert đẹp và cuộn tới
        contactAlertElement.classList.remove('d-none');
        contactAlertElement.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Reset form sau khi gửi
        contactFormElement.reset();

        // Xóa trạng thái lỗi nếu có
        ['firstName','phone','subject','message'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.remove('is-invalid');
        });
    });
</script>
@endsection
