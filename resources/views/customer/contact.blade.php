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
        background: linear-gradient(135deg, #2c5aa0, #1e40af);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        height: 100%;
    }
    
    .contact-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
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
        background: rgba(255,255,255,0.2);
        color: white;
        border-radius: 50%;
        margin: 0 10px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-links a:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-3px);
        color: white;
    }
</style>

<!-- Hero Section -->
<section class="hero-section text-white py-5">
    <div class="container">
        <div class="row align-items-center" style="position: relative; z-index: 2;">
            <div class="col-lg-8 mx-auto text-center">
                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-phone me-1"></i>LIÊN HỆ
                </div>
                <h1 class="display-3 fw-bold mb-4">
                    Liên Hệ Với<br>
                    <span class="text-warning">KitchenHood Pro</span>
                </h1>
                <p class="lead mb-4 opacity-90">
                    Chúng tôi luôn sẵn sàng hỗ trợ và tư vấn cho bạn 24/7
                </p>
            </div>
        </div>
    </div>
</section>

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
                    
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label fw-bold">Họ và tên *</label>
                                <input type="text" class="form-control" id="firstName" placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Số điện thoại *</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn">
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">Chủ đề *</label>
                            <select class="form-control" id="subject" required>
                                <option value="">Chọn chủ đề</option>
                                <option value="tư-vấn">Tư vấn sản phẩm</option>
                                <option value="báo-giá">Báo giá</option>
                                <option value="lắp-đặt">Lắp đặt</option>
                                <option value="bảo-hành">Bảo hành</option>
                                <option value="khác">Khác</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Nội dung tin nhắn *</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Mô tả chi tiết yêu cầu của bạn..." required></textarea>
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
                    <h4 class="fw-bold mb-4 text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông Tin Liên Hệ
                    </h4>
                    
                    <div class="mb-4">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Địa Chỉ</h6>
                        <p class="mb-0 opacity-90">
                            123 Đường ABC, Phường 1, Quận 1<br>
                            Thành phố Hồ Chí Minh, Việt Nam
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-phone fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Điện Thoại</h6>
                        <p class="mb-0 opacity-90">
                            <strong>Hotline:</strong> 0123 456 789<br>
                            <strong>Hỗ trợ:</strong> 0987 654 321
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Email</h6>
                        <p class="mb-0 opacity-90">
                            <strong>Chung:</strong> info@kitchenhoodpro.com<br>
                            <strong>Hỗ trợ:</strong> support@kitchenhoodpro.com
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="contact-icon mx-auto">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Giờ Làm Việc</h6>
                        <p class="mb-0 opacity-90">
                            <strong>Thứ 2 - Thứ 6:</strong> 8:00 - 18:00<br>
                            <strong>Thứ 7:</strong> 8:00 - 12:00<br>
                            <strong>Chủ nhật:</strong> Nghỉ
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <h6 class="fw-bold mb-3">Kết Nối Với Chúng Tôi</h6>
                        <div class="social-links">
                            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" title="Zalo"><i class="fas fa-comment"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bản đồ và thông tin bổ sung -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="map-container">
                    <div class="bg-light p-5 text-center">
                        <i class="fas fa-map fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Bản Đồ Google Maps</h4>
                        <p class="text-muted mb-0">
                            Bản đồ sẽ được tích hợp tại đây để hiển thị vị trí cửa hàng
                        </p>
                    </div>
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

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h3 class="fw-bold mb-4">Cần Tư Vấn Gấp?</h3>
        <p class="lead mb-4">Gọi ngay hotline để được tư vấn miễn phí</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="tel:0123456789" class="btn btn-warning btn-lg px-4 py-3 fw-bold">
                <i class="fas fa-phone me-2"></i>0123 456 789
            </a>
            <a href="https://zalo.me/0123456789" class="btn btn-outline-light btn-lg px-4 py-3">
                <i class="fab fa-facebook-messenger me-2"></i>Chat Zalo
            </a>
        </div>
    </div>
</section>

<script>
    // Form validation và submit
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Lấy dữ liệu form
        const formData = {
            firstName: document.getElementById('firstName').value,
            phone: document.getElementById('phone').value,
            email: document.getElementById('email').value,
            subject: document.getElementById('subject').value,
            message: document.getElementById('message').value
        };
        
        // Kiểm tra dữ liệu
        if (!formData.firstName || !formData.phone || !formData.subject || !formData.message) {
            alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            return;
        }
        
        // Hiển thị thông báo thành công
        alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
        
        // Reset form
        this.reset();
    });
</script>
@endsection
