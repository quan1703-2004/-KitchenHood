@extends('layouts.customer')

@section('title', 'Hỏi Đáp')

@section('content')
<div class="faq-container">
    <!-- Main Content -->
    <div class="faq-main">
        <!-- Ask Question Section -->
        <div class="ask-question-section">
            <div class="section-header">
                <div class="header-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h2 class="section-title">Câu hỏi & trả lời</h2>
                <div class="ms-auto">
                    <button type="button" id="toggleQuestionFormBtn" class="toggle-form-btn">
                        <i class="fas fa-pen"></i>
                        <span>Đặt câu hỏi mới</span>
                    </button>
                </div>
            </div>
            
            <div class="question-form-container is-hidden" id="questionFormWrapper">
                <form id="questionForm" class="question-form" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading"></i>
                            <span>Tiêu đề câu hỏi</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-input" 
                               id="title" 
                               name="title" 
                               placeholder="Nhập tiêu đề câu hỏi ngắn gọn..." 
                               required
                               minlength="5"
                               maxlength="255">
                        <div class="form-hint">Tối thiểu 5 ký tự, tối đa 255 ký tự</div>
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="category" class="form-label">
                            <i class="fas fa-tags"></i>
                            <span>Danh mục câu hỏi</span>
                            <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <select class="form-select" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down select-arrow"></i>
                        </div>
                        <div class="form-hint">Chọn danh mục phù hợp với câu hỏi của bạn</div>
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="content" class="form-label">
                            <i class="fas fa-align-left"></i>
                            <span>Nội dung câu hỏi</span>
                            <span class="required">*</span>
                        </label>
                        <textarea class="form-textarea" 
                                  id="content" 
                                  name="content" 
                                  rows="5" 
                                  placeholder="Mô tả chi tiết câu hỏi của bạn..." 
                                  required
                                  minlength="10"
                                  maxlength="2000"></textarea>
                        <div class="form-hint">Tối thiểu 10 ký tự, tối đa 2000 ký tự</div>
                        <div class="form-error"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i>
                            <span>Gửi Câu Hỏi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="questions-section">
            <div class="section-header">
                <div class="header-icon">
                    <i class="fas fa-list"></i>
                </div>
                <h2 class="section-title">Câu Hỏi & Trả Lời</h2>
            </div>
            
            <!-- Search and Filter -->
            <div class="search-filter-section">
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Tìm kiếm câu hỏi...">
                    </div>
                </div>
                <div class="filter-container">
                    <div class="filter-select-wrapper">
                        <select id="categoryFilter" class="filter-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down filter-arrow"></i>
                    </div>
                </div>
            </div>
            
            <!-- Questions List -->
            <div class="questions-list">
                @if($questions->count() > 0)
                    @foreach($questions as $question)
                        <div class="question-item" data-category="{{ $question->category }}">
                            <div class="question-header" onclick="toggleQuestion({{ $question->id }})">
                                <div class="question-icon">
                                    <i class="fas fa-question"></i>
                                </div>
                                <div class="question-content">
                                    <h3 class="question-title">{{ $question->title }}</h3>
                                    <div class="question-meta">
                                        <span class="category-badge">{{ $question->category_name }}</span>
                                        <span class="user-info">
                                            <span class="qa-avatar">
                                                @if($question->user?->avatar)
                                                    <img src="{{ $question->user->avatar_url }}" alt="{{ $question->user->name }}" class="qa-avatar-img">
                                                @else
                                                    <span class="qa-avatar-initial">{{ mb_strtoupper(mb_substr($question->user->name, 0, 1, 'UTF-8'), 'UTF-8') }}</span>
                                                @endif
                                            </span>
                                            {{ $question->user->name }}
                                        </span>
                                        <span class="date-info">
                                            <i class="fas fa-clock"></i>
                                            {{ $question->created_at->format('d/m/Y H:i') }}
                                        </span>
                                        @can('update', $question)
                                            <button type="button" class="edit-question-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-edit"></i> Sửa
                                            </button>
                                        @endcan
                                        @if($question->is_answered)
                                            <span class="status-badge answered">
                                                <i class="fas fa-check"></i>
                                                Đã trả lời
                                            </span>
                                        @else
                                            <span class="status-badge pending">
                                                <i class="fas fa-clock"></i>
                                                Chưa trả lời
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="question-toggle">
                                    <i class="fas fa-chevron-down toggle-icon"></i>
                                </div>
                            </div>
                            
                            <div class="question-body" id="question-{{ $question->id }}">
                                <div class="question-description">
                                    <p>{{ $question->content }}</p>
                                </div>
                                
                                @if($question->answers->count() > 0)
                                    <div class="answers-section">
                                        <div class="answers-header">
                                            <i class="fas fa-reply"></i>
                                            <span>Câu trả lời</span>
                                        </div>
                                        @foreach($question->answers as $answer)
                                            <div class="answer-item">
                                                <div class="d-flex align-items-start gap-3">
                                                    <span class="qa-avatar qa-avatar-admin">
                                                        @if($answer->user?->avatar)
                                                            <img src="{{ $answer->user->avatar_url }}" alt="{{ $answer->user->name }}" class="qa-avatar-img">
                                                        @else
                                                            <span class="qa-avatar-initial">{{ mb_strtoupper(mb_substr($answer->user->name, 0, 1, 'UTF-8'), 'UTF-8') }}</span>
                                                        @endif
                                                    </span>
                                                    <div class="answer-content flex-grow-1">
                                                        <p>{{ $answer->content }}</p>
                                                        <div class="answer-meta">
                                                            <span class="answer-author">
                                                                {{ $answer->user->name }} (Admin)
                                                            </span>
                                                            <span class="answer-date">
                                                                <i class="fas fa-clock"></i>
                                                                {{ $answer->created_at->format('d/m/Y H:i') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="no-answer">
                                        <i class="fas fa-hourglass-half"></i>
                                        <p>Chưa có câu trả lời</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Pagination -->
                    <div class="pagination-container">
                        {{ $questions->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Chưa có câu hỏi nào</h3>
                        <p>Hãy là người đầu tiên đặt câu hỏi!</p>
                    </div>
                @endif
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

@section('styles')
<style>
/* ===== SCOPED CSS CHỈ CHO FAQ CONTAINER ===== */
.faq-container {
    padding: 2rem 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    min-height: 80vh;
    font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
}

.faq-container .faq-main {
    max-width: 1000px;
    margin: 0 auto;
}

/* ===== Section Headers ===== */
.faq-container .section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

/* Nút toggle form hỏi đáp */
.faq-container .toggle-form-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: #3498db;
    color: #fff;
    border: none;
    border-radius: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 150ms ease-in-out, box-shadow 150ms ease-in-out;
    box-shadow: 0 6px 12px rgba(52,152,219,0.2);
}

.faq-container .toggle-form-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 16px rgba(52,152,219,0.25);
}

.faq-container .toggle-form-btn:active {
    transform: translateY(0);
}

/* Ẩn/hiện form mượt mà */
.faq-container .question-form-container {
    transition: all 250ms ease-in-out;
}
.faq-container .question-form-container.is-hidden {
    display: none;
}

.faq-container .header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.faq-container .section-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #2c3e50;
    letter-spacing: -0.025em;
}

/* ===== Ask Question Section ===== */
.faq-container .ask-question-section {
    margin-bottom: 4rem;
}

.faq-container .question-form-container {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid #e9ecef;
}

.faq-container .question-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.faq-container .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.faq-container .form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
}

.faq-container .form-label i {
    color: #3498db;
    font-size: 0.875rem;
}

.faq-container .required {
    color: #dc3545;
    font-weight: 700;
}

.faq-container .form-input, 
.faq-container .form-textarea {
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 500;
    background: #f8f9fa;
    transition: all 250ms ease-in-out;
    outline: none;
}

.faq-container .form-input:focus, 
.faq-container .form-textarea:focus {
    border-color: #3498db;
    background: white;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
    transform: translateY(-1px);
}

.faq-container .form-input.valid, 
.faq-container .form-textarea.valid {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
}

.faq-container .form-input.error, 
.faq-container .form-textarea.error {
    border-color: #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.faq-container .select-wrapper {
    position: relative;
}

.faq-container .form-select {
    appearance: none;
    padding: 1rem 3rem 1rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 500;
    background: #f8f9fa;
    transition: all 250ms ease-in-out;
    outline: none;
    cursor: pointer;
    width: 100%;
}

.faq-container .form-select:focus {
    border-color: #3498db;
    background: white;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
}

.faq-container .select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
    transition: all 150ms ease-in-out;
}

.faq-container .select-wrapper:hover .select-arrow {
    color: #3498db;
}

.faq-container .form-hint {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.faq-container .form-error {
    font-size: 0.875rem;
    color: #dc3545;
    font-weight: 600;
    display: none;
}

.faq-container .form-error.show {
    display: block;
}

.faq-container .form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

.faq-container .submit-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    border: none;
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 250ms ease-in-out;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.faq-container .submit-btn:hover {
    background: linear-gradient(135deg, #2980b9 0%, #1f5f8b 100%);
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
}

/* ===== Questions Section ===== */
.faq-container .questions-section {
    margin-bottom: 4rem;
}

/* ===== Search and Filter ===== */
.faq-container .search-filter-section {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.faq-container .search-container, 
.faq-container .filter-container {
    flex: 1;
    min-width: 250px;
}

.faq-container .search-input-wrapper {
    position: relative;
}

.faq-container .search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 0.875rem;
    z-index: 2;
}

.faq-container .search-input {
    width: 100%;
    padding: 1rem 1rem 1rem 2.5rem;
    border: 2px solid #e9ecef;
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 500;
    background: white;
    transition: all 250ms ease-in-out;
    outline: none;
}

.faq-container .search-input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
    transform: translateY(-1px);
}

.faq-container .filter-select-wrapper {
    position: relative;
}

.faq-container .filter-select {
    appearance: none;
    width: 100%;
    padding: 1rem 3rem 1rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 1rem;
    font-size: 1rem;
    font-weight: 500;
    background: white;
    transition: all 250ms ease-in-out;
    outline: none;
    cursor: pointer;
}

.faq-container .filter-select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
}

.faq-container .filter-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
    transition: all 150ms ease-in-out;
}

.faq-container .filter-select-wrapper:hover .filter-arrow {
    color: #3498db;
}

/* ===== Questions List ===== */
.faq-container .questions-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.faq-container .question-item {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: all 250ms ease-in-out;
}

.faq-container .question-item:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.faq-container .question-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 250ms ease-in-out;
    background: white;
}

.faq-container .question-header:hover {
    background: #f8f9fa;
}

.faq-container .question-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.125rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.faq-container .question-content {
    flex: 1;
    min-width: 0;
}

.faq-container .question-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    letter-spacing: -0.025em;
}

.faq-container .question-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.faq-container .category-badge {
    background: linear-gradient(135deg, #ffc107 0%, #e6a800 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.faq-container .user-info, 
.faq-container .date-info {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* Avatar nhỏ cho Q&A */
.qa-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #9e9e9e;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    overflow: hidden;
    margin-right: 6px;
}

.qa-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.qa-avatar-initial { font-size: 0.85rem; }

.qa-avatar-admin { background: #86a4bc; }

.faq-container .user-info i, 
.faq-container .date-info i {
    color: #3498db;
    font-size: 0.75rem;
}

.faq-container .status-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.faq-container .status-badge.answered {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.faq-container .status-badge.pending {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.faq-container .question-toggle {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 50%;
    transition: all 150ms ease-in-out;
}

.faq-container .question-toggle:hover {
    background: #3498db;
    color: white;
}

.faq-container .toggle-icon {
    transition: transform 250ms ease-in-out;
}

/* Nút sửa câu hỏi */
.faq-container .edit-question-btn {
    border: 1px solid #e9ecef;
    background: #ffffff;
    color: #2c3e50;
    border-radius: 8px;
    padding: 0.35rem 0.6rem;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    transition: all 150ms ease-in-out;
}

.faq-container .edit-question-btn:hover {
    background: #3498db;
    color: #fff;
    border-color: #3498db;
}

.faq-container .question-item.expanded .toggle-icon {
    transform: rotate(180deg);
}

.faq-container .question-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 350ms ease-in-out;
    background: #f8f9fa;
}

.faq-container .question-item.expanded .question-body {
    max-height: 1000px;
}

.faq-container .question-description {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.faq-container .question-description p {
    font-size: 1rem;
    color: #495057;
    line-height: 1.7;
    font-weight: 500;
}

/* ===== Answers Section ===== */
.faq-container .answers-section {
    padding: 1.5rem;
}

.faq-container .answers-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1rem;
    font-weight: 600;
    color: #3498db;
}

.faq-container .answer-item {
    background: white;
    border-radius: 1rem;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    border: 1px solid #e9ecef;
}

.faq-container .answer-item:last-child {
    margin-bottom: 0;
}

.faq-container .answer-content p {
    font-size: 1rem;
    color: #343a40;
    line-height: 1.7;
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.faq-container .answer-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.faq-container .answer-author, 
.faq-container .answer-date {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.faq-container .answer-author i, 
.faq-container .answer-date i {
    color: #28a745;
    font-size: 0.75rem;
}

.faq-container .no-answer {
    padding: 1.5rem;
    text-align: center;
    color: #6c757d;
}

.faq-container .no-answer i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: #ffc107;
}

.faq-container .no-answer p {
    font-size: 1rem;
    font-weight: 500;
}

/* ===== Empty State ===== */
.faq-container .empty-state {
    text-align: center;
    padding: 5rem;
    color: #6c757d;
}

.faq-container .empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #adb5bd;
    font-size: 2.25rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.faq-container .empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #495057;
    margin-bottom: 0.75rem;
}

.faq-container .empty-state p {
    font-size: 1rem;
    color: #6c757d;
    font-weight: 500;
}

/* ===== Pagination ===== */
.faq-container .pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* ===== Responsive Design ===== */
@media (max-width: 768px) {
    .faq-container {
        padding: 1rem 0.5rem;
    }
    
    .faq-container .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .faq-container .section-title {
        font-size: 1.5rem;
    }
    
    .faq-container .question-form-container {
        padding: 1.5rem;
    }
    
    .faq-container .search-filter-section {
        flex-direction: column;
    }
    
    .faq-container .question-header {
        padding: 1rem;
    }
    
    .faq-container .question-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .faq-container .question-description,
    .faq-container .answers-section {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .faq-container .question-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .faq-container .question-title {
        font-size: 1rem;
    }
    
    .faq-container .form-actions {
        justify-content: stretch;
    }
    
    .faq-container .submit-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Accordion functionality
function toggleQuestion(questionId) {
    const questionItem = document.querySelector(`[onclick="toggleQuestion(${questionId})"]`).closest('.question-item');
    const questionBody = document.getElementById(`question-${questionId}`);
    
    if (questionItem.classList.contains('expanded')) {
        // Collapse
        questionItem.classList.remove('expanded');
        questionBody.style.maxHeight = '0';
    } else {
        // Expand
        questionItem.classList.add('expanded');
        questionBody.style.maxHeight = questionBody.scrollHeight + 'px';
    }
}

// Search functionality
function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterQuestions, 300));
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterQuestions);
    }
}

function filterQuestions() {
    const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const selectedCategory = document.getElementById('categoryFilter')?.value || '';
    const questionItems = document.querySelectorAll('.question-item');
    
    questionItems.forEach(item => {
        const title = item.querySelector('.question-title')?.textContent.toLowerCase() || '';
        const category = item.dataset.category || '';
        
        const matchesSearch = title.includes(searchTerm);
        const matchesCategory = !selectedCategory || category === selectedCategory;
        
        if (matchesSearch && matchesCategory) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

$(document).ready(function() {
    // Mở modal sửa câu hỏi (inline replace form)
    $(document).on('click', '.edit-question-btn', function() {
        const id = $(this).data('id');
        const $item = $(this).closest('.question-item');
        const currentTitle = $item.find('.question-title').text().trim();
        const currentCategory = $item.data('category');
        const currentContent = $item.find('.question-description p').text().trim();

        // Hiển thị form inline thay cho form tạo mới
        $('#toggleQuestionFormBtn').trigger('click');
        $('#title').val(currentTitle);
        $('#category').val(currentCategory).trigger('change');
        $('#content').val(currentContent);

        // Gắn cờ đang edit
        $('#questionForm').attr('data-edit-id', id);
        $('.submit-btn span').text('Cập nhật Câu Hỏi');
    });

    // Khi submit: nếu có data-edit-id thì gọi API update
    $('#questionForm').on('submit', function(e) {
        const editId = $(this).attr('data-edit-id');
        if (!editId) return; // không can thiệp khi tạo mới

        e.preventDefault();
        if (!validateForm()) return;

        const token = $('meta[name="csrf-token"]').attr('content');
        const payload = {
            title: $('#title').val().trim(),
            category: $('#category').val(),
            content: $('#content').val().trim(),
            _token: token,
            _method: 'PATCH'
        };

        $.ajax({
            url: '/hoi-dap/' + editId,
            method: 'POST',
            data: payload,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    // Cập nhật UI nhanh
                    const $item = $('.question-item').filter(function(){ return $(this).find('.edit-question-btn').data('id') == editId; });
                    $item.find('.question-title').text(res.question.title);
                    $item.find('.question-description p').text(res.question.content);
                    // Đặt lại form về trạng thái tạo mới
                    $('#questionForm').removeAttr('data-edit-id')[0].reset();
                    $('.submit-btn span').text('Gửi Câu Hỏi');
                    $('#toggleQuestionFormBtn').trigger('click');
                }
            },
            error: function(xhr) {
                if (xhr.status === 403) {
                    showErrorModal('Bạn không được phép sửa câu hỏi này.');
                } else if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors);
                } else {
                    showErrorModal('Không thể cập nhật câu hỏi. Vui lòng thử lại.');
                }
            }
        });
    });
    // Initialize search functionality
    initSearch();
    
    // Toggle form hỏi đáp
    const $formWrapper = $('#questionFormWrapper');
    const $toggleBtn = $('#toggleQuestionFormBtn');
    if ($toggleBtn.length && $formWrapper.length) {
        $toggleBtn.on('click', function() {
            const isHidden = $formWrapper.hasClass('is-hidden');
            if (isHidden) {
                $formWrapper.removeClass('is-hidden');
                $toggleBtn.find('span').text('Ẩn form đặt câu hỏi');
                $toggleBtn.find('i').removeClass('fa-pen').addClass('fa-times');
                // Focus vào tiêu đề khi mở form để UX tốt
                setTimeout(() => { $('#title').trigger('focus'); }, 50);
            } else {
                $formWrapper.addClass('is-hidden');
                $toggleBtn.find('span').text('Đặt câu hỏi mới');
                $toggleBtn.find('i').removeClass('fa-times').addClass('fa-pen');
            }
        });
    }
    
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
        
        // Tạo object để gửi
        const formData = {
            title: title,
            category: category,
            content: content,
            _token: token
        };
        
        // Gửi request
        $.ajax({
            url: '{{ route("question-answer.store") }}',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#loadingModal').modal('hide');
                
                if (response.success) {
                    // Hiển thị modal thành công
                    $('#successModal').modal('show');
                    
                    // Reset form
                    $('#questionForm')[0].reset();
                    $('.form-input, .form-textarea, .form-select').removeClass('valid error');
                    $('.form-error').removeClass('show').text('');
                    
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
                
                if (xhr.status === 422) {
                    // Lỗi validation
                    const errors = xhr.responseJSON.errors;
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
        const feedback = input.siblings('.form-error');
        
        input.removeClass('valid').addClass('error');
        feedback.addClass('show').text(message);
    }
    
    // Hàm hiển thị thành công cho field
    function showFieldSuccess(fieldName) {
        const input = $(`#${fieldName}`);
        const feedback = input.siblings('.form-error');
        
        input.removeClass('error').addClass('valid');
        feedback.removeClass('show').text('');
    }
    
    // Hàm hiển thị modal lỗi
    function showErrorModal(message) {
        $('#errorMessage').text(message);
        $('#errorModal').modal('show');
    }
    
    // Hàm hiển thị lỗi validation
    function showValidationErrors(errors) {
        // Xóa class invalid cũ
        $('.form-input, .form-textarea, .form-select').removeClass('error valid');
        $('.form-error').removeClass('show').text('');
        
        // Hiển thị lỗi mới
        Object.keys(errors).forEach(function(field) {
            const input = $(`#${field}`);
            const feedback = input.siblings('.form-error');
            
            input.addClass('error');
            feedback.addClass('show').text(errors[field][0]);
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
            $(this).removeClass('valid error');
            $(this).siblings('.form-error').removeClass('show').text('');
        }
    });
    
    $('#category').on('change', function() {
        const value = $(this).val();
        if (value) {
            showFieldSuccess('category');
        } else {
            $(this).removeClass('valid error');
            $(this).siblings('.form-error').removeClass('show').text('');
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
            $(this).removeClass('valid error');
            $(this).siblings('.form-error').removeClass('show').text('');
        }
    });
});
</script>
@endsection
