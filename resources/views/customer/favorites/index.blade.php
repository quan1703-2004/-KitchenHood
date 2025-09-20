@extends('layouts.customer')

@section('title', 'Sản Phẩm Yêu Thích - KitchenHood Pro')

@section('content')
<style>
/* ===== FAVORITES STYLES ===== */
:root {
    --primary-color: #2563eb;
    --primary-light: #3b82f6;
    --primary-dark: #1d4ed8;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #0ea5e9;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --text-muted: #94a3b8;
    --border-color: #e2e8f0;
    --bg-light: #f8fafc;
    --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
}

/* Header Section */
.favorites-header {
    margin-bottom: 3rem;
}



@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.favorites-subtitle {
    text-align: center;
    font-size: 1.2rem;
    opacity: 0.95;
    margin: 0;
    position: relative;
    z-index: 1;
    font-weight: 300;
}

/* Stats Section */
.stats-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 3rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--bg-gradient);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--bg-gradient);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.stat-label {
    color: var(--text-light);
    font-weight: 600;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Products Grid */
.products-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.products-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--bg-gradient);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    display: flex;
    align-items: center;
}

.section-title i {
    color: var(--danger-color);
    margin-right: 0.5rem;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-xl);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    height: 220px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.favorite-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    box-shadow: var(--shadow-lg);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
    50% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
}

.product-info {
    padding: 1.5rem;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-category {
    color: var(--text-light);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.product-price {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.product-rating {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.stars {
    color: #fbbf24;
    margin-right: 0.5rem;
}

.rating-text {
    color: var(--text-light);
    font-size: 0.9rem;
}

.product-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-primary {
    flex: 1;
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--primary-dark);
    color: white;
    text-decoration: none;
}

.btn-danger {
    background: var(--danger-color);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 44px;
}

.btn-danger:hover {
    background: #dc2626;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-light);
}

.empty-state i {
    font-size: 1.5rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.empty-state p {
    font-size: 1rem;
    margin-bottom: 2rem;
}

.btn-explore {
    background: var(--primary-color);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-explore:hover {
    background: var(--primary-dark);
    color: white;
    text-decoration: none;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 0.5rem;
}

.pagination .page-link {
    padding: 0.75rem 1rem;
    background: white;
    border: 1px solid var(--border-color);
    color: var(--text-dark);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination .page-item.active .page-link {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .favorites-title {
        font-size: 2rem;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>

<div class="favorites-header">
   
</div>

<div class="container">
   
    <!-- Products Section -->
    <div class="products-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-heart"></i>
                Danh sách sản phẩm yêu thích
            </h2>
        </div>

        @if($favoriteProducts->count() > 0)
            <div class="products-grid">
                @foreach($favoriteProducts as $product)
                    <div class="product-card" data-product-id="{{ $product->id }}">
                        <div class="product-image-container">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <img src="https://via.placeholder.com/300x200/cccccc/666666?text=Không+có+ảnh" alt="{{ $product->name }}" class="product-image">
                            @endif
                            <div class="favorite-badge">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <div class="product-category">{{ $product->category->name ?? 'Không phân loại' }}</div>
                            <div class="product-price">{{ number_format($product->price) }} VNĐ</div>
                            
                            <div class="product-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->average_rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $product->average_rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-text">({{ $product->reviews_count }} đánh giá)</span>
                            </div>
                            
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-primary">
                                    <i class="fas fa-eye me-1"></i>Xem chi tiết
                                </a>
                                <button class="btn-danger remove-favorite" data-product-id="{{ $product->id }}" title="Xóa khỏi yêu thích">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($favoriteProducts->hasPages())
                <div class="pagination-wrapper">
                    {{ $favoriteProducts->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-heart-broken"></i>
                <h3>Chưa có sản phẩm yêu thích</h3>
                <p>Hãy khám phá và thêm những sản phẩm bạn yêu thích vào danh sách!</p>
                <a href="{{ route('products.index') }}" class="btn-explore">
                    <i class="fas fa-shopping-bag me-1"></i>Khám phá sản phẩm
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý xóa sản phẩm khỏi yêu thích
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productCard = this.closest('.product-card');
            const productName = productCard.querySelector('.product-title').textContent;
            
            if (confirm(`Bạn có chắc muốn xóa "${productName}" khỏi danh sách yêu thích?`)) {
                // Gửi request xóa
                fetch(`/favorites/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Xóa card khỏi DOM
                        productCard.remove();
                        
                        // Hiển thị thông báo
                        showNotification(data.message, 'success');
                        
                        // Kiểm tra nếu không còn sản phẩm nào
                        if (document.querySelectorAll('.product-card').length === 0) {
                            location.reload();
                        }
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra!', 'error');
                });
            }
        });
    });
    
    // Hiển thị thông báo
    function showNotification(message, type) {
        // Tạo toast notification
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Thêm styles
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            z-index: 1000;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        // Tự động xóa sau 3 giây
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});

// CSS cho animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection
