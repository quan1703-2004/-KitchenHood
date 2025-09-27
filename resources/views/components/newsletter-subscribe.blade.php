<style>
    /* UI: nền trắng, chữ tối; phong cách tối giản, hiện đại */
    .newsletter-section { background: #ffffff; }
    .newsletter-card {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }
    .newsletter-title { color: #1f2937; }
    .newsletter-desc { color: #6b7280; }
    .newsletter-input {
        border: 1px solid #e5e7eb;
        border-right: 0;
        border-radius: 999px 0 0 999px;
        padding: 0.9rem 1.25rem;
        height: 52px;
        background: #ffffff;
    }
    .newsletter-input:focus { box-shadow: none; border-color: #60a5fa; }
    .newsletter-btn {
        border-radius: 0 999px 999px 0;
        height: 52px;
        padding: 0 1.25rem;
        font-weight: 600;
    }
    .newsletter-feature i {
        width: 28px; height: 28px; line-height: 28px; text-align: center;
        border-radius: 50%; background: #e9f5ff; color: #1e88e5; margin-right: 8px;
    }
    @media (max-width: 767.98px) {
        .newsletter-card { padding: 1rem; }
        .newsletter-input { height: 48px; }
        .newsletter-btn { height: 48px; }
    }
</style>

<section class="newsletter-section py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="newsletter-card">
                    <h3 class="fw-bold mb-1 newsletter-title">Đăng ký nhận tin tức mới nhất</h3>
                    <p class="mb-3 newsletter-desc">Cập nhật xu hướng, ưu đãi độc quyền và bài viết hay mỗi tuần.</p>
                    <div class="d-flex flex-wrap gap-3 newsletter-feature small">
                        <span class="d-inline-flex align-items-center"><i class="fas fa-shield-alt"></i>Bảo mật email</span>
                        <span class="d-inline-flex align-items-center"><i class="fas fa-bolt"></i>Nhận thông báo nhanh</span>
                        <span class="d-inline-flex align-items-center"><i class="fas fa-gift"></i>Ưu đãi dành riêng</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <!-- Chỉ là UI; backend xử lý đăng ký có thể bổ sung sau -->
                <form class="" method="post" action="#" onsubmit="return false;">
                    <div class="input-group shadow-sm">
                        <input type="email" class="form-control newsletter-input" placeholder="Email của bạn" aria-label="Email">
                        <button class="btn btn-warning newsletter-btn" type="submit">
                            <i class="fas fa-paper-plane me-2"></i> Đăng ký
                        </button>
                    </div>
                    <div class="form-text text-muted mt-2">
                        Bằng việc đăng ký, bạn đồng ý nhận email tin tức. Có thể hủy bất cứ lúc nào.
                    </div>
                </form>
            </div>
        </div>
    </div>
 </section>


