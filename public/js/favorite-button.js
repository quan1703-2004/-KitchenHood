// Favorite Button Handler
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút yêu thích
    document.querySelectorAll('.btn-favorite').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const isFavorited = this.classList.contains('favorited');
            const productCard = this.closest('.card');
            const productName = productCard ? productCard.querySelector('.card-title')?.textContent : 'Sản phẩm';
            
            // Hiển thị loading
            const originalIcon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
        // Gửi request
        const url = `/favorites/${productId}`;
        const method = isFavorited ? 'DELETE' : 'POST';
        
        console.log('Sending request to:', url, 'Method:', method, 'Product ID:', productId);
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: method === 'POST' ? JSON.stringify({ product_id: productId }) : null
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Cập nhật trạng thái nút
                    if (isFavorited) {
                        this.classList.remove('favorited');
                        this.title = 'Thêm vào yêu thích';
                    } else {
                        this.classList.add('favorited');
                        this.title = 'Xóa khỏi yêu thích';
                    }
                    
                    // Hiển thị thông báo
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        // Fallback notification
                        alert(data.message);
                    }
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: error.message || 'Không thể cập nhật yêu thích',
                        confirmButtonText: 'Thử lại'
                    });
                } else {
                    alert('Lỗi: ' + (error.message || 'Không thể cập nhật yêu thích'));
                }
            })
            .finally(() => {
                this.innerHTML = originalIcon;
                this.disabled = false;
            });
        });
    });
});
