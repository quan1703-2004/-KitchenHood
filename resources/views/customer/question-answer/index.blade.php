@extends('layouts.customer')

@section('title', 'Hỏi Đáp')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="badge bg-info text-white px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-question-circle me-1"></i>HỎI ĐÁP
                </div>
                <h1 class="display-5 fw-bold text-dark">Đặt Câu Hỏi</h1>
                <p class="lead text-muted">Bạn có thắc mắc gì về sản phẩm? Hãy đặt câu hỏi và chúng tôi sẽ trả lời sớm nhất!</p>
            </div>

            <!-- Form đặt câu hỏi -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Đặt Câu Hỏi Mới
                    </h5>
                </div>
                <div class="card-body">
                    <form id="questionForm" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading me-1"></i>Tiêu đề câu hỏi 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   placeholder="Nhập tiêu đề câu hỏi ngắn gọn..." 
                                   required
                                   minlength="5"
                                   maxlength="255">
                            <div class="form-text">Tối thiểu 5 ký tự, tối đa 255 ký tự</div>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label fw-bold">
                                <i class="fas fa-tags me-1"></i>Danh mục câu hỏi 
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Chọn danh mục phù hợp với câu hỏi của bạn</div>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">
                                <i class="fas fa-align-left me-1"></i>Nội dung câu hỏi 
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" 
                                      id="content" 
                                      name="content" 
                                      rows="5" 
                                      placeholder="Nhập nội dung câu hỏi chi tiết..." 
                                      required
                                      minlength="10"
                                      maxlength="2000"></textarea>
                            <div class="form-text">Tối thiểu 10 ký tự, tối đa 2000 ký tự</div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-paper-plane me-2"></i>Gửi Câu Hỏi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danh sách câu hỏi -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Câu Hỏi & Trả Lời
                    </h5>
                </div>
                <div class="card-body">
                    @if($questions->count() > 0)
                        <div class="row">
                            @foreach($questions as $question)
                                <div class="col-12 mb-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <!-- Câu hỏi -->
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                        <i class="fas fa-question"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <h6 class="fw-bold text-dark mb-0 me-3">{{ $question->title }}</h6>
                                                        <span class="badge bg-secondary">{{ $question->category_name }}</span>
                                                    </div>
                                                    <p class="text-muted mb-3">{{ $question->content }}</p>
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="fas fa-user me-1"></i>
                                                        <span class="me-3">{{ $question->user->name }}</span>
                                                        <i class="fas fa-clock me-1"></i>
                                                        <span class="me-3">{{ $question->created_at->format('d/m/Y H:i') }}</span>
                                                        @if($question->is_answered)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check me-1"></i>Đã trả lời
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-clock me-1"></i>Chưa trả lời
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Câu trả lời -->
                                            @if($question->answers->count() > 0)
                                                <div class="answer-section">
                                                    @foreach($question->answers as $answer)
                                                        <div class="answer-item">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                        <i class="fas fa-reply"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div class="answer-content">
                                                                        <p class="text-dark mb-2">{{ $answer->content }}</p>
                                                                        <div class="d-flex align-items-center text-muted small">
                                                                            <i class="fas fa-user-tie me-1"></i>
                                                                            <span class="me-3">{{ $answer->user->name }} (Admin)</span>
                                                                            <i class="fas fa-clock me-1"></i>
                                                                            <span>{{ $answer->created_at->format('d/m/Y H:i') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(!$loop->last)
                                                            <hr class="answer-divider">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $questions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-question-circle text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Chưa có câu hỏi nào</h5>
                            <p class="text-muted">Hãy là người đầu tiên đặt câu hỏi!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5>Đang gửi câu hỏi...</h5>
                <p class="text-muted mb-0">Vui lòng chờ trong giây lát</p>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="text-success mb-3" style="font-size: 4rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="text-success">Thành công!</h5>
                <p class="text-muted mb-0">Câu hỏi đã được gửi thành công!</p>
                <div class="mt-3">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="fas fa-check me-1"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="text-danger mb-3" style="font-size: 4rem;">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h5 class="text-danger">Lỗi!</h5>
                <p class="text-muted mb-0" id="errorMessage">Có lỗi xảy ra khi gửi câu hỏi.</p>
                <div class="mt-3">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Thử lại
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Xử lý form gửi câu hỏi
    $('#questionForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form trước khi gửi
        if (!validateForm()) {
            return;
        }
        
        // Hiển thị loading
        $('#loadingModal').modal('show');
        
        // Lấy dữ liệu form
        const title = $('#title').val().trim();
        const category = $('#category').val();
        const content = $('#content').val().trim();
        const token = $('meta[name="csrf-token"]').attr('content');
        
        // Debug: Log dữ liệu gửi đi
        console.log('Title:', title);
        console.log('Category:', category);
        console.log('Content:', content);
        console.log('Token:', token);
        
        // Tạo object để gửi
        const formData = {
            title: title,
            category: category,
            content: content,
            _token: token
        };
        
        console.log('Form data to send:', formData);
        
        // Gửi request
        $.ajax({
            url: '{{ route("question-answer.store") }}',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#loadingModal').modal('hide');
                console.log('Success response:', response);
                
                if (response.success) {
                    // Hiển thị modal thành công
                    $('#successModal').modal('show');
                    
                    // Reset form
                    $('#questionForm')[0].reset();
                    $('.form-control, .form-select').removeClass('is-valid is-invalid');
                    
                    // Reload trang sau khi đóng modal
                    $('#successModal').on('hidden.bs.modal', function() {
                        location.reload();
                    });
                } else {
                    showErrorModal(response.message || 'Có lỗi xảy ra khi gửi câu hỏi.');
                }
            },
            error: function(xhr) {
                $('#loadingModal').modal('hide');
                console.log('Error response:', xhr);
                console.log('Error response JSON:', xhr.responseJSON);
                
                if (xhr.status === 422) {
                    // Lỗi validation
                    const errors = xhr.responseJSON.errors;
                    console.log('Validation errors:', errors);
                    showValidationErrors(errors);
                } else if (xhr.status === 401) {
                    // Chưa đăng nhập
                    showErrorModal('Bạn cần đăng nhập để đặt câu hỏi.');
                } else {
                    showErrorModal('Có lỗi xảy ra khi gửi câu hỏi. Vui lòng thử lại.');
                }
            }
        });
    });
    
    // Hàm validate form
    function validateForm() {
        let isValid = true;
        
        // Validate title
        const title = $('#title').val().trim();
        if (!title) {
            showFieldError('title', 'Vui lòng nhập tiêu đề câu hỏi.');
            isValid = false;
        } else if (title.length < 5) {
            showFieldError('title', 'Tiêu đề phải có ít nhất 5 ký tự.');
            isValid = false;
        } else if (title.length > 255) {
            showFieldError('title', 'Tiêu đề không được vượt quá 255 ký tự.');
            isValid = false;
        } else {
            showFieldSuccess('title');
        }
        
        // Validate category
        const category = $('#category').val();
        if (!category) {
            showFieldError('category', 'Vui lòng chọn danh mục câu hỏi.');
            isValid = false;
        } else {
            showFieldSuccess('category');
        }
        
        // Validate content
        const content = $('#content').val().trim();
        if (!content) {
            showFieldError('content', 'Vui lòng nhập nội dung câu hỏi.');
            isValid = false;
        } else if (content.length < 10) {
            showFieldError('content', 'Nội dung phải có ít nhất 10 ký tự.');
            isValid = false;
        } else if (content.length > 2000) {
            showFieldError('content', 'Nội dung không được vượt quá 2000 ký tự.');
            isValid = false;
        } else {
            showFieldSuccess('content');
        }
        
        return isValid;
    }
    
    // Hàm hiển thị lỗi cho field
    function showFieldError(fieldName, message) {
        const input = $(`#${fieldName}`);
        const feedback = input.siblings('.invalid-feedback');
        
        input.removeClass('is-valid').addClass('is-invalid');
        feedback.text(message);
    }
    
    // Hàm hiển thị thành công cho field
    function showFieldSuccess(fieldName) {
        const input = $(`#${fieldName}`);
        const feedback = input.siblings('.invalid-feedback');
        
        input.removeClass('is-invalid').addClass('is-valid');
        feedback.text('');
    }
    
    // Hàm hiển thị modal lỗi
    function showErrorModal(message) {
        $('#errorMessage').text(message);
        $('#errorModal').modal('show');
    }
    
    // Hàm hiển thị lỗi validation
    function showValidationErrors(errors) {
        // Xóa class invalid cũ
        $('.form-control, .form-select').removeClass('is-invalid is-valid');
        $('.invalid-feedback').text('');
        
        // Hiển thị lỗi mới
        Object.keys(errors).forEach(function(field) {
            const input = $(`#${field}`);
            const feedback = input.siblings('.invalid-feedback');
            
            input.addClass('is-invalid');
            feedback.text(errors[field][0]);
        });
        
        // Hiển thị modal lỗi
        showErrorModal('Vui lòng kiểm tra lại thông tin đã nhập.');
    }
    
    // Real-time validation
    $('#title').on('input', function() {
        const value = $(this).val().trim();
        if (value.length >= 5 && value.length <= 255) {
            showFieldSuccess('title');
        } else if (value.length > 0) {
            if (value.length < 5) {
                showFieldError('title', 'Tiêu đề phải có ít nhất 5 ký tự.');
            } else if (value.length > 255) {
                showFieldError('title', 'Tiêu đề không được vượt quá 255 ký tự.');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });
    
    $('#category').on('change', function() {
        const value = $(this).val();
        if (value) {
            showFieldSuccess('category');
        } else {
            $(this).removeClass('is-valid is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });
    
    $('#content').on('input', function() {
        const value = $(this).val().trim();
        if (value.length >= 10 && value.length <= 2000) {
            showFieldSuccess('content');
        } else if (value.length > 0) {
            if (value.length < 10) {
                showFieldError('content', 'Nội dung phải có ít nhất 10 ký tự.');
            } else if (value.length > 2000) {
                showFieldError('content', 'Nội dung không được vượt quá 2000 ký tự.');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });
});
</script>

<style>
/* Custom CSS cho trang hỏi đáp */
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control.is-valid, .form-select.is-valid {
    border-color: #198754;
}

.form-control.is-valid:focus, .form-select.is-valid:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
}

.form-control.is-invalid:focus, .form-select.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.btn-primary {
    background: linear-gradient(45deg, #0d6efd, #0b5ed7);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0b5ed7, #0a58ca);
    transform: translateY(-1px);
}

.btn-success {
    background: linear-gradient(45deg, #198754, #157347);
    border: none;
}

.btn-danger {
    background: linear-gradient(45deg, #dc3545, #bb2d3b);
    border: none;
}

.spinner-border {
    animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
    to {
        transform: rotate(360deg);
    }
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}

.modal-body {
    padding: 2rem;
}

/* Animation cho các icon */
.fas {
    transition: all 0.3s ease;
}

.card:hover .fas {
    transform: scale(1.1);
}

/* CSS cho phần câu trả lời */
.answer-section {
    margin-top: 1.5rem;
    padding-left: 2rem;
    border-left: 3px solid #e9ecef;
    background: #f8f9fa;
    border-radius: 0 8px 8px 0;
    padding: 1.5rem;
}

.answer-item {
    margin-bottom: 1rem;
}

.answer-item:last-child {
    margin-bottom: 0;
}

.answer-content {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.answer-divider {
    margin: 1rem 0;
    border-color: #dee2e6;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .answer-section {
        padding-left: 1rem;
        margin-left: 0.5rem;
    }
    
    .answer-content {
        padding: 0.75rem;
    }
}
</style>
@endsection
