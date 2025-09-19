// Favorite Button Handler - Debug Version
document.addEventListener('DOMContentLoaded', function() {
    console.log('Favorite button handler loaded');
    
    // Xử lý nút yêu thích
    document.querySelectorAll('.btn-favorite').forEach(button => {
        console.log('Found favorite button:', button);
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const isFavorited = this.classList.contains('favorited');
            const productCard = this.closest('.card');
            const productName = productCard ? productCard.querySelector('.card-title')?.textContent : 'Sản phẩm';
            
            console.log('Button clicked:', {
                productId: productId,
                isFavorited: isFavorited,
                productName: productName
            });
            
            // Hiển thị loading
            const originalIcon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
            // Gửi request
            const storeUrl = this.dataset.storeUrl;
            const destroyUrl = this.dataset.destroyUrl;
            const url = isFavorited ? destroyUrl : storeUrl;
            const method = isFavorited ? 'DELETE' : 'POST';
            
            console.log('Sending request to:', url, 'Method:', method, 'Product ID:', productId);
            
            // Kiểm tra CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            console.log('CSRF Token:', csrfToken ? csrfToken.getAttribute('content') : 'Not found');
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: method === 'POST' ? JSON.stringify({ product_id: productId }) : null
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Kiểm tra Content-Type header
                const contentType = response.headers.get('content-type');
                console.log('Content-Type:', contentType);
                
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // Nếu không phải JSON, đọc text để debug
                    return response.text().then(text => {
                        console.log('Non-JSON response:', text);
                        throw new Error('Server returned non-JSON response');
                    });
                }
            })
            .then(data => {
                console.log('Response data:', data);
                
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
