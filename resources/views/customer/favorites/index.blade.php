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
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

/* Header Section */
.favorites-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
    border-radius: 0 0 24px 24px;
}

.favorites-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.favorites-title i {
    margin-right: 1rem;
    color: #fbbf24;
}

.favorites-subtitle {
    text-align: center;
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

/* Stats Section */
.stats-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1.5rem;
    background: var(--bg-light);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-light);
    font-weight: 500;
}

/* Products Grid */
.products-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
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
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.favorite-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--danger-color);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: var(--shadow-md);
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
    font-size: 4rem;
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
    <div class="container">
        <h1 class="favorites-title">
            <i class="fas fa-heart"></i>
            Sản Phẩm Yêu Thích
        </h1>
        <p class="favorites-subtitle">
            Danh sách những sản phẩm bạn đã yêu thích
        </p>
    </div>
</div>

<div class="container">
    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $favoriteProducts->total() }}</div>
                <div class="stat-label">Sản phẩm yêu thích</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $favoriteProducts->where('quantity', '>', 0)->count() }}</div>
                <div class="stat-label">Còn hàng</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $favoriteProducts->where('quantity', '<=', 0)->count() }}</div>
                <div class="stat-label">Hết hàng</div>
            </div>
        </div>
    </div>

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
                        
                        // Cập nhật số liệu thống kê
                        updateStats();
                        
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
    
    // Cập nhật thống kê
    function updateStats() {
        const totalProducts = document.querySelectorAll('.product-card').length;
        const inStockProducts = document.querySelectorAll('.product-card').length; // Simplified for now
        
        document.querySelector('.stat-item:nth-child(1) .stat-number').textContent = totalProducts;
        document.querySelector('.stat-item:nth-child(2) .stat-number').textContent = inStockProducts;
        document.querySelector('.stat-item:nth-child(3) .stat-number').textContent = 0;
    }
    
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
