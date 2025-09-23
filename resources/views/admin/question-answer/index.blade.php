@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="content-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="content-title">
                    <i class="fas fa-question-circle me-3"></i>
                    Quản lý Hỏi Đáp
                </h1>
                <p class="content-subtitle">Quản lý và trả lời các câu hỏi từ khách hàng</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" onclick="refreshQuestions()">
                    <i class="fas fa-sync-alt me-2"></i>Làm mới
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Về Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-question"></i>
                </div>
                <div class="card-count" id="totalQuestions">0</div>
                <div class="card-title">Tổng câu hỏi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-count" id="unansweredQuestions">0</div>
                <div class="card-title">Chưa trả lời</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-icon" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-count" id="answeredQuestions">0</div>
                <div class="card-title">Đã trả lời</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="card-count" id="answerRate">0%</div>
                <div class="card-title">Tỷ lệ trả lời</div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc và tìm kiếm -->
    <div class="admin-search">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Lọc theo trạng thái</label>
                    <select class="form-select" id="statusFilter" onchange="filterQuestions()">
                        <option value="all">Tất cả</option>
                        <option value="unanswered">Chưa trả lời</option>
                        <option value="answered">Đã trả lời</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Lọc theo danh mục</label>
                    <select class="form-select" id="categoryFilter" onchange="filterQuestions()">
                        <option value="all">Tất cả danh mục</option>
                        @foreach($categories as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Tìm kiếm</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm câu hỏi...">
                        <button class="btn btn-primary" onclick="searchQuestions()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách câu hỏi -->
    <div class="admin-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="questionsTableBody">
                    <!-- Dữ liệu sẽ được load bằng AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination" id="paginationContainer">
        <!-- Pagination sẽ được load bằng AJAX -->
    </div>
</div>

<!-- Modal trả lời câu hỏi -->
<div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="answerModalLabel">
                    <i class="fas fa-reply me-2"></i>Trả lời câu hỏi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Thông tin câu hỏi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-question-circle me-2"></i>Câu hỏi từ khách hàng
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="questionInfo">
                            <!-- Thông tin câu hỏi sẽ được load ở đây -->
                        </div>
                    </div>
                </div>

                <!-- Form trả lời -->
                <form id="answerForm">
                    <div class="form-group mb-3">
                        <label class="form-label">Câu trả lời <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="answerContent" rows="6" 
                                  placeholder="Nhập câu trả lời chi tiết cho khách hàng..." required></textarea>
                        <div class="form-text">Tối thiểu 5 ký tự, tối đa 2000 ký tự</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Hủy
                </button>
                <button type="button" class="btn btn-primary" onclick="submitAnswer()">
                    <i class="fas fa-paper-plane me-2"></i>Gửi trả lời
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xem chi tiết câu hỏi -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-eye me-2"></i>Chi tiết câu hỏi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="questionDetail">
                <!-- Chi tiết câu hỏi sẽ được load ở đây -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let currentQuestionId = null;
let currentPage = 1;
let currentFilter = 'all';
let currentCategory = 'all';
let currentSearch = '';

// Load dữ liệu khi trang được tải
document.addEventListener('DOMContentLoaded', function() {
    loadQuestions();
    loadStatistics();
    
    // Tự động refresh mỗi 30 giây
    setInterval(function() {
        loadQuestions();
        loadStatistics();
    }, 30000);
});

// Load thống kê
function loadStatistics() {
    $.ajax({
        url: '{{ route("admin.question-answer.unanswered") }}',
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.success) {
                const unanswered = data.count;
                
                // Load tổng số câu hỏi và đã trả lời
                $.ajax({
                    url: '{{ route("admin.question-answer.index") }}',
                    method: 'GET',
                    success: function(response) {
                        const total = {{ $unansweredQuestions->count() + $answeredQuestions->count() }};
                        const answered = total - unanswered;
                        const rate = total > 0 ? Math.round((answered / total) * 100) : 0;
                        
                        $('#totalQuestions').text(total);
                        $('#unansweredQuestions').text(unanswered);
                        $('#answeredQuestions').text(answered);
                        $('#answerRate').text(rate + '%');
                    }
                });
            }
        }
    });
}

// Load danh sách câu hỏi
function loadQuestions(page = 1) {
    currentPage = page;
    
    $.ajax({
        url: '{{ route("admin.question-answer.index") }}',
        method: 'GET',
        data: {
            page: page,
            status: currentFilter,
            category: currentCategory,
            search: currentSearch
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            updateQuestionsTable(data);
        },
        error: function(xhr) {
            console.error('Lỗi khi tải câu hỏi:', xhr);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Không thể tải danh sách câu hỏi',
                confirmButtonText: 'Thử lại'
            });
        }
    });
}

// Cập nhật bảng câu hỏi
function updateQuestionsTable(data) {
    const tbody = $('#questionsTableBody');
    tbody.empty();
    
    if (data.unansweredQuestions && data.unansweredQuestions.length > 0) {
        data.unansweredQuestions.forEach(function(question) {
            const row = createQuestionRow(question, false);
            tbody.append(row);
        });
    }
    
    if (data.answeredQuestions && data.answeredQuestions.length > 0) {
        data.answeredQuestions.forEach(function(question) {
            const row = createQuestionRow(question, true);
            tbody.append(row);
        });
    }
    
    if (tbody.children().length === 0) {
        tbody.append(`
            <tr>
                <td colspan="8" class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Không có câu hỏi nào</p>
                </td>
            </tr>
        `);
    }
}

// Tạo hàng câu hỏi với hiển thị câu trả lời
function createQuestionRow(question, isAnswered) {
    const statusBadge = isAnswered ? 
        '<span class="badge badge-success"><i class="fas fa-check me-1"></i>Đã trả lời</span>' :
        '<span class="badge badge-warning"><i class="fas fa-clock me-1"></i>Chưa trả lời</span>';
    
    const categoryBadge = `<span class="badge badge-info">${question.category_name}</span>`;
    
    const actions = isAnswered ? 
        `<button class="btn btn-sm btn-view" onclick="viewQuestion(${question.id})">
            <i class="fas fa-eye me-1"></i>Xem
        </button>` :
        `<button class="btn btn-sm btn-primary" onclick="answerQuestion(${question.id})">
            <i class="fas fa-reply me-1"></i>Trả lời
        </button>
        <button class="btn btn-sm btn-view" onclick="viewQuestion(${question.id})">
            <i class="fas fa-eye me-1"></i>Xem
        </button>`;
    
    // Tạo HTML cho câu trả lời nếu có
    let answersHtml = '';
    if (isAnswered && question.answers && question.answers.length > 0) {
        answersHtml = `
            <tr class="answer-row">
                <td colspan="8">
                    <div class="answer-section">
                        <div class="answer-header">
                            <i class="fas fa-reply me-2"></i>Câu trả lời:
                        </div>
                        ${question.answers.map(answer => `
                            <div class="answer-item">
                                <div class="answer-content">
                                    <p class="mb-2">${answer.content}</p>
                                    <div class="answer-meta">
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-1"></i>
                                            ${answer.user.name} (Admin) - 
                                            <i class="fas fa-clock me-1"></i>
                                            ${new Date(answer.created_at).toLocaleDateString('vi-VN')}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </td>
            </tr>
        `;
    }
    
    return `
        <tr>
            <td>#${question.id}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                        ${question.user.name.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <div class="fw-semibold">${question.user.name}</div>
                        <small class="text-muted">${question.user.email}</small>
                    </div>
                </div>
            </td>
            <td>
                <div class="fw-semibold">${question.title}</div>
            </td>
            <td>${categoryBadge}</td>
            <td>
                <div class="text-truncate" style="max-width: 200px;" title="${question.content}">
                    ${question.content}
                </div>
            </td>
            <td>${statusBadge}</td>
            <td>
                <div class="small text-muted">
                    ${new Date(question.created_at).toLocaleDateString('vi-VN')}
                </div>
                <div class="small text-muted">
                    ${new Date(question.created_at).toLocaleTimeString('vi-VN')}
                </div>
            </td>
            <td>
                <div class="d-flex gap-1">
                    ${actions}
                </div>
            </td>
        </tr>
        ${answersHtml}
    `;
}

// Lọc câu hỏi
function filterQuestions() {
    currentFilter = $('#statusFilter').val();
    currentCategory = $('#categoryFilter').val();
    loadQuestions(1);
}

// Tìm kiếm câu hỏi
function searchQuestions() {
    currentSearch = $('#searchInput').val();
    loadQuestions(1);
}

// Enter để tìm kiếm
$('#searchInput').on('keypress', function(e) {
    if (e.which === 13) {
        searchQuestions();
    }
});

// Trả lời câu hỏi
function answerQuestion(questionId) {
    currentQuestionId = questionId;
    
    // Load thông tin câu hỏi
    $.ajax({
        url: '{{ route("admin.question-answer.index") }}',
        method: 'GET',
        success: function(data) {
            let question = null;
            
            // Tìm câu hỏi trong danh sách
            if (data.unansweredQuestions) {
                question = data.unansweredQuestions.find(q => q.id === questionId);
            }
            
            if (question) {
                $('#questionInfo').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Khách hàng:</strong> ${question.user.name}
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong> ${question.user.email}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Danh mục:</strong> ${question.category_name}
                        </div>
                        <div class="col-md-6">
                            <strong>Ngày hỏi:</strong> ${new Date(question.created_at).toLocaleDateString('vi-VN')}
                        </div>
                    </div>
                    <div class="mt-3">
                        <strong>Tiêu đề:</strong>
                        <p class="mt-1">${question.title}</p>
                    </div>
                    <div class="mt-3">
                        <strong>Nội dung:</strong>
                        <p class="mt-1">${question.content}</p>
                    </div>
                `);
                
                $('#answerContent').val('');
                $('#answerModal').modal('show');
            }
        }
    });
}

// Gửi câu trả lời
function submitAnswer() {
    const content = $('#answerContent').val().trim();
    
    if (!content) {
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo!',
            text: 'Vui lòng nhập câu trả lời',
            confirmButtonText: 'Đồng ý'
        });
        return;
    }
    
    if (content.length < 5) {
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo!',
            text: 'Câu trả lời phải có ít nhất 5 ký tự',
            confirmButtonText: 'Đồng ý'
        });
        return;
    }
    
    if (content.length > 2000) {
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo!',
            text: 'Câu trả lời không được vượt quá 2000 ký tự',
            confirmButtonText: 'Đồng ý'
        });
        return;
    }
    
    // Hiển thị loading
    Swal.fire({
        title: 'Đang gửi trả lời...',
        text: 'Vui lòng chờ trong giây lát',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: `{{ route("admin.question-answer.answer", ":id") }}`.replace(':id', currentQuestionId),
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
            content: content
        }),
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: data.message,
                confirmButtonText: 'Đồng ý'
            });
            
            $('#answerModal').modal('hide');
            loadQuestions(currentPage);
            loadStatistics();
        },
        error: function(xhr) {
            let errorMessage = 'Có lỗi xảy ra khi gửi trả lời';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: errorMessage,
                confirmButtonText: 'Thử lại'
            });
        }
    });
}

// Xem chi tiết câu hỏi
function viewQuestion(questionId) {
    $.ajax({
        url: '{{ route("admin.question-answer.index") }}',
        method: 'GET',
        success: function(data) {
            let question = null;
            
            // Tìm câu hỏi trong danh sách
            if (data.unansweredQuestions) {
                question = data.unansweredQuestions.find(q => q.id === questionId);
            }
            if (!question && data.answeredQuestions) {
                question = data.answeredQuestions.find(q => q.id === questionId);
            }
            
            if (question) {
                let answersHtml = '';
                if (question.answers && question.answers.length > 0) {
                    answersHtml = `
                        <div class="mt-4">
                            <h6><i class="fas fa-reply me-2"></i>Câu trả lời:</h6>
                            ${question.answers.map(answer => `
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="fw-semibold">${answer.user.name}</div>
                                            <small class="text-muted">${new Date(answer.created_at).toLocaleDateString('vi-VN')}</small>
                                        </div>
                                        <p class="mb-0">${answer.content}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                }
                
                $('#questionDetail').html(`
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-question-circle me-2"></i>Thông tin câu hỏi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Khách hàng:</strong> ${question.user.name}
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong> ${question.user.email}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Danh mục:</strong> ${question.category_name}
                                </div>
                                <div class="col-md-6">
                                    <strong>Ngày hỏi:</strong> ${new Date(question.created_at).toLocaleDateString('vi-VN')}
                                </div>
                            </div>
                            <div class="mt-3">
                                <strong>Tiêu đề:</strong>
                                <p class="mt-1">${question.title}</p>
                            </div>
                            <div class="mt-3">
                                <strong>Nội dung:</strong>
                                <p class="mt-1">${question.content}</p>
                            </div>
                            ${answersHtml}
                        </div>
                    </div>
                `);
                
                $('#detailModal').modal('show');
            }
        }
    });
}

// Làm mới trang
function refreshQuestions() {
    loadQuestions(currentPage);
    loadStatistics();
    
    Swal.fire({
        icon: 'success',
        title: 'Đã làm mới!',
        text: 'Dữ liệu đã được cập nhật',
        timer: 1500,
        showConfirmButton: false
    });
}
</script>

<style>
/* CSS bổ sung cho trang hỏi đáp */
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.badge-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: #92400e;
}

.badge-info {
    background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
    color: #fff;
}

.badge-success {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: #fff;
}

/* CSS cho phần câu trả lời trong admin */
.answer-row {
    background-color: #f8f9fa;
}

.answer-section {
    padding: 1rem;
    margin: 0.5rem 0;
    background: white;
    border-radius: 8px;
    border-left: 4px solid #10b981;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.answer-header {
    font-weight: 600;
    color: #10b981;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.answer-item {
    margin-bottom: 1rem;
}

.answer-item:last-child {
    margin-bottom: 0;
}

.answer-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.answer-meta {
    margin-top: 0.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid #e9ecef;
}

/* Responsive cho bảng */
@media (max-width: 768px) {
    .admin-table .table {
        font-size: 0.875rem;
    }
    
    .admin-table .table th,
    .admin-table .table td {
        padding: 0.75rem 0.5rem;
    }
    
    .text-truncate {
        max-width: 150px !important;
    }
    
    .answer-section {
        padding: 0.75rem;
    }
    
    .answer-content {
        padding: 0.75rem;
    }
}
</style>
@endsection
