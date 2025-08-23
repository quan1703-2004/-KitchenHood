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
    
    .about-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        background: white;
    }
    
    .about-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #2c5aa0, #1e40af);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: transform 0.3s ease;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        background: #2c5aa0;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0 0 4px #e5e7eb;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 10px;
        top: 20px;
        width: 2px;
        height: calc(100% + 1rem);
        background: #e5e7eb;
    }
    
    .timeline-item:last-child::after {
        display: none;
    }
</style>

<!-- Hero Section -->
<section class="hero-section text-white py-5">
    <div class="container">
        <div class="row align-items-center" style="position: relative; z-index: 2;">
            <div class="col-lg-8 mx-auto text-center">
                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-info-circle me-1"></i>VỀ CHÚNG TÔI
                </div>
                <h1 class="display-3 fw-bold mb-4">
                    KitchenHood Pro<br>
                    <span class="text-warning">Chuyên Gia Máy Hút Mùi</span>
                </h1>
                <p class="lead mb-4 opacity-90">
                    Hơn 10 năm kinh nghiệm trong lĩnh vực cung cấp và lắp đặt máy hút mùi cao cấp
                </p>
            </div>
        </div>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container">
        <!-- Giới thiệu công ty -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="about-card card shadow-sm h-100">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-dark mb-4">
                            <i class="fas fa-building text-primary me-2"></i>
                            Công Ty KitchenHood Pro
                        </h3>
                        <p class="text-muted mb-4">
                            Được thành lập vào năm 2015, KitchenHood Pro là đơn vị tiên phong trong việc cung cấp 
                            các giải pháp máy hút mùi cao cấp cho căn bếp Việt Nam.
                        </p>
                        <p class="text-muted mb-4">
                            Chúng tôi tự hào là đối tác tin cậy của nhiều thương hiệu uy tín như: Bosch, 
                            Electrolux, Panasonic, và nhiều thương hiệu khác.
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <h4 class="fw-bold text-primary mb-0">10+</h4>
                                <small class="text-muted">Năm kinh nghiệm</small>
                            </div>
                            <div class="me-4">
                                <h4 class="fw-bold text-success mb-0">15,000+</h4>
                                <small class="text-muted">Khách hàng</small>
                            </div>
                            <div>
                                <h4 class="fw-bold text-warning mb-0">50,000+</h4>
                                <small class="text-muted">Sản phẩm bán ra</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-card card shadow-sm h-100">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-dark mb-4">
                            <i class="fas fa-bullseye text-primary me-2"></i>
                            Sứ Mệnh & Tầm Nhìn
                        </h3>
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-rocket me-2"></i>Sứ Mệnh
                            </h5>
                            <p class="text-muted">
                                Mang đến những sản phẩm máy hút mùi chất lượng cao, giúp mọi gia đình 
                                Việt Nam có được không gian bếp sạch sẽ, thơm tho và hiện đại.
                            </p>
                        </div>
                        <div>
                            <h5 class="fw-bold text-success mb-3">
                                <i class="fas fa-eye me-2"></i>Tầm Nhìn
                            </h5>
                            <p class="text-muted">
                                Trở thành thương hiệu hàng đầu Việt Nam trong lĩnh vực cung cấp 
                                máy hút mùi và thiết bị nhà bếp cao cấp.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark mb-3">Thành Tựu Của Chúng Tôi</h2>
                    <p class="text-muted">Những con số ấn tượng phản ánh sự tin tưởng của khách hàng</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">15,000+</h3>
                    <p class="text-muted mb-0">Khách hàng hài lòng</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-success">50,000+</h3>
                    <p class="text-muted mb-0">Sản phẩm bán ra</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-award fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-warning">10+</h3>
                    <p class="text-muted mb-0">Năm kinh nghiệm</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stats-card">
                    <div class="feature-icon text-white mb-3">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-info">4.9/5</h3>
                    <p class="text-muted mb-0">Đánh giá trung bình</p>
                </div>
            </div>
        </div>

        <!-- Lịch sử phát triển -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="about-card card shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-dark mb-4 text-center">
                            <i class="fas fa-history text-primary me-2"></i>
                            Lịch Sử Phát Triển
                        </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="timeline-item">
                                    <h5 class="fw-bold text-primary">2015</h5>
                                    <p class="text-muted">Thành lập công ty với 5 nhân viên đầu tiên</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="fw-bold text-primary">2017</h5>
                                    <p class="text-muted">Mở rộng showroom đầu tiên tại TP.HCM</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="fw-bold text-primary">2019</h5>
                                    <p class="text-muted">Đạt mốc 5,000 khách hàng và mở chi nhánh Hà Nội</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="timeline-item">
                                    <h5 class="fw-bold text-primary">2021</h5>
                                    <p class="text-muted">Phát triển hệ thống bán hàng online</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="fw-bold text-primary">2023</h5>
                                    <p class="text-muted">Đạt mốc 15,000 khách hàng và mở rộng toàn quốc</p>
                                </div>
                                <div class="timeline-item">
                                    <h5 class="fw-bold text-primary">2025</h5>
                                    <p class="text-muted">Tiếp tục phát triển và mở rộng thị trường</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Giá trị cốt lõi -->
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark mb-3">Giá Trị Cốt Lõi</h2>
                    <p class="text-muted">Những nguyên tắc không thay đổi trong suốt hành trình phát triển</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="about-card card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-white mb-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Tận Tâm</h5>
                        <p class="text-muted">
                            Chúng tôi luôn đặt lợi ích của khách hàng lên hàng đầu, 
                            cung cấp dịch vụ tận tâm và chuyên nghiệp.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="about-card card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-white mb-3">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-success mb-3">Chất Lượng</h5>
                        <p class="text-muted">
                            Cam kết 100% sản phẩm chính hãng với chất lượng cao, 
                            bảo hành dài hạn và dịch vụ hậu mãi tốt nhất.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="about-card card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-white mb-3">
                            <i class="fas fa-lightbulb fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-warning mb-3">Sáng Tạo</h5>
                        <p class="text-muted">
                            Không ngừng đổi mới và cải tiến để mang đến những 
                            giải pháp tối ưu nhất cho khách hàng.
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
        <h3 class="fw-bold mb-4">Sẵn Sàng Tư Vấn Cho Bạn</h3>
        <p class="lead mb-4">Hãy để chúng tôi giúp bạn chọn máy hút mùi phù hợp nhất</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('contact') }}" class="btn btn-warning btn-lg px-4 py-3 fw-bold">
                <i class="fas fa-phone me-2"></i>Liên Hệ Ngay
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                <i class="fas fa-shopping-cart me-2"></i>Xem Sản Phẩm
            </a>
        </div>
    </div>
</section>
@endsection
