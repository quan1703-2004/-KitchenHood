@extends('layouts.customer')

@section('title', 'Diễn Đàn Hỏi Đáp')

@section('content')
<div class="forum-container">
    <div class="forum-layout">
        <!-- Main Content -->
        <div class="forum-wrapper">
            <!-- Header Section -->
            <div class="forum-header">
            <div class="header-content">
                <h1 class="forum-title">
                    <i class="fas fa-comments"></i>
                    Diễn Đàn Hỏi Đáp
                </h1>
                <button type="button" id="toggleQuestionFormBtn" class="btn-ask-question">
                    <i class="fas fa-plus-circle"></i>
                    <span>Đặt câu hỏi mới</span>
                </button>
            </div>
        </div>

        <!-- Question Form -->
        <div class="question-form-wrapper is-hidden" id="questionFormWrapper">
            <div class="post-card">
                <form id="questionForm" class="question-form" novalidate>
                    @csrf
                    <div class="form-row">
                        <label class="form-label">
                            <span>Tiêu đề câu hỏi</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               placeholder="Nhập tiêu đề câu hỏi..." 
                               required
                               minlength="5"
                               maxlength="255">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">
                            <span>Danh mục</span>
                            <span class="required">*</span>
                        </label>
                        <select class="form-control" 
                                id="category" 
                                name="category" 
                                required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="form-row">
                        <label class="form-label">
                            <span>Nội dung câu hỏi</span>
                            <span class="required">*</span>
                        </label>
                        <textarea class="form-control" 
                                  id="content" 
                                  name="content" 
                                  rows="5" 
                                  placeholder="Mô tả chi tiết câu hỏi của bạn..." 
                                  required
                                  minlength="10"
                                  maxlength="2000"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            <span>Gửi Câu Hỏi</span>
                        </button>
                        <button type="button" class="btn-cancel" id="cancelFormBtn">
                            <i class="fas fa-times"></i>
                            <span>Hủy</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="filter-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Tìm kiếm câu hỏi...">
            </div>
            <div class="filter-box">
                <select id="categoryFilter">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Questions List -->
        <div class="questions-feed">
            @if($questions->count() > 0)
                @foreach($questions as $question)
                    <div class="post-card" data-category="{{ $question->category }}" data-question-id="{{ $question->id }}">
                        <!-- Post Header -->
                        <div class="post-header">
                            <div class="author-info">
                                <div class="author-avatar">
                                    @if($question->user?->avatar)
                                        <img src="{{ $question->user->avatar_url }}" alt="{{ $question->user->name }}">
                                    @else
                                        <div class="avatar-placeholder">{{ mb_strtoupper(mb_substr($question->user->name, 0, 1, 'UTF-8'), 'UTF-8') }}</div>
                                    @endif
                                </div>
                                <div class="author-details">
                                    <div class="author-name-row">
                                        <span class="author-name">{{ $question->user->name }}</span>
                                        @if($question->user->role === 'admin')
                                            <span class="user-badge admin-badge">ADMIN</span>
                                        @else
                                            <span class="user-badge member-badge">Thành viên</span>
                                        @endif
                                        <span class="category-tag">{{ $question->category_name }}</span>
                                    </div>
                                    <div class="post-time">
                                        <i class="far fa-clock"></i>
                                        {{ $question->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            @can('update', $question)
                                <div class="post-actions">
                                    <button class="btn-edit-question" data-id="{{ $question->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            @endcan
                        </div>

                        <!-- Post Content -->
                        <div class="post-content">
                            <h3 class="post-title">{{ $question->title }}</h3>
                            <div class="post-body" id="body-{{ $question->id }}">
                                <p>{{ $question->content }}</p>
                            </div>
                        </div>

                        <!-- Post Stats -->
                        <div class="post-stats">
                            <!-- Nút Like -->
                            <button class="btn-like @if(Auth::check() && $question->isLikedBy(Auth::id())) liked @endif" 
                                    data-question-id="{{ $question->id }}"
                                    onclick="toggleLike({{ $question->id }})">
                                <i class="fas fa-heart"></i>
                                <span class="like-count">{{ $question->likes_count }}</span>
                            </button>
                            <span class="stat-divider">•</span>
                            @if($question->is_answered)
                                <span class="stat-item stat-answered">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Đã trả lời ({{ $question->answers->count() }})</span>
                                </span>
                            @else
                                <span class="stat-item stat-pending">
                                    <i class="far fa-clock"></i>
                                    <span>Chờ trả lời</span>
                                </span>
                            @endif
                            <span class="stat-divider">•</span>
                            <button class="btn-toggle-answers" onclick="toggleAnswers({{ $question->id }})">
                                <i class="fas fa-comment-dots"></i>
                                <span>{{ $question->answers->count() }} bình luận</span>
                            </button>
                        </div>

                        <!-- Answers Section -->
                        <div class="answers-wrapper is-collapsed" id="answers-{{ $question->id }}">
                            @if($question->answers->count() > 0)
                                <div class="answers-list">
                                    @foreach($question->answers as $answer)
                                        <div class="answer-card">
                                            <div class="answer-avatar">
                                                @if($answer->user?->avatar)
                                                    <img src="{{ $answer->user->avatar_url }}" alt="{{ $answer->user->name }}">
                                                @else
                                                    <div class="avatar-placeholder admin">{{ mb_strtoupper(mb_substr($answer->user->name, 0, 1, 'UTF-8'), 'UTF-8') }}</div>
                                                @endif
                                            </div>
                                            <div class="answer-content">
                                                <div class="answer-header">
                                                    <span class="answer-author">{{ $answer->user->name }}</span>
                                                    <span class="user-badge admin-badge">ADMIN</span>
                                                    <span class="answer-time">
                                                        <i class="far fa-clock"></i>
                                                        {{ $answer->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <div class="answer-text">
                                                    <p>{{ $answer->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-answers">
                                    <i class="far fa-comment-dots"></i>
                                    <p>Chưa có câu trả lời nào. Hãy chờ admin phản hồi!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $questions->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3>Chưa có câu hỏi nào</h3>
                    <p>Hãy là người đầu tiên đặt câu hỏi trong diễn đàn!</p>
                    <button type="button" class="btn-ask-question" onclick="$('#toggleQuestionFormBtn').click()">
                        <i class="fas fa-plus-circle"></i>
                        <span>Đặt câu hỏi ngay</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar Xếp Hạng -->
    <aside class="forum-sidebar">
        <div class="sidebar-card">
            <div class="sidebar-header">
                <i class="fas fa-trophy"></i>
                <h3>Top Bài Viết</h3>
            </div>
            <div class="sidebar-body">
                @if($topQuestions->count() > 0)
                    <div class="top-questions-list">
                        @foreach($topQuestions as $index => $topQuestion)
                            <div class="top-question-item">
                                <div class="rank-badge rank-{{ $index + 1 }}">
                                    @if($index == 0)
                                        <i class="fas fa-trophy"></i>
                                    @elseif($index == 1)
                                        <i class="fas fa-medal"></i>
                                    @elseif($index == 2)
                                        <i class="fas fa-award"></i>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <div class="top-question-info">
                                    <a href="#question-{{ $topQuestion->id }}" class="top-question-title">
                                        {{ Str::limit($topQuestion->title, 50) }}
                                    </a>
                                    <div class="top-question-meta">
                                        <span class="top-author">
                                            <i class="fas fa-user"></i>
                                            {{ $topQuestion->user->name }}
                                        </span>
                                        <span class="top-likes">
                                            <i class="fas fa-heart"></i>
                                            {{ $topQuestion->likes_count }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-top-questions">
                        <i class="fas fa-inbox"></i>
                        <p>Chưa có bài viết nào được like</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Thống kê -->
        <div class="sidebar-card">
            <div class="sidebar-header">
                <i class="fas fa-chart-bar"></i>
                <h3>Thống Kê</h3>
            </div>
            <div class="sidebar-body">
                <div class="stat-row">
                    <span class="stat-label">Tổng câu hỏi:</span>
                    <span class="stat-value">{{ $questions->total() }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Đã trả lời:</span>
                    <span class="stat-value text-success">{{ $questions->where('is_answered', true)->count() }}</span>
                </div>
                <div class="stat-row">
                    <span class="stat-label">Chờ trả lời:</span>
                    <span class="stat-value text-warning">{{ $questions->where('is_answered', false)->count() }}</span>
                </div>
            </div>
        </div>
    </aside>
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
/* ===== FORUM CONTAINER - GIAO DIỆN DIỄN ĐÀN CHUYÊN NGHIỆP ===== */
.forum-container {
    background: #f0f2f5;
    min-height: 100vh;
    padding: 20px 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

.forum-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.forum-wrapper {
    flex: 1;
    min-width: 0;
}

/* ===== HEADER ===== */
.forum-header {
    background: #fff;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 16px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.forum-title {
    font-size: 24px;
    font-weight: 700;
    color: #1c1e21;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.forum-title i {
    color: #1877f2;
    font-size: 28px;
}

.btn-ask-question {
    background: #1877f2;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s;
}

.btn-ask-question:hover {
    background: #166fe5;
}

/* ===== FORM ===== */
.question-form-wrapper {
    margin-bottom: 16px;
    transition: all 0.3s;
}

.question-form-wrapper.is-hidden {
    display: none;
}

.post-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.question-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-row {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #050505;
    display: flex;
    align-items: center;
    gap: 4px;
}

.form-label .required {
    color: #f02849;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #dddfe2;
    border-radius: 6px;
    font-size: 15px;
    background: #f0f2f5;
    transition: all 0.2s;
    outline: none;
}

.form-control:focus {
    background: #fff;
    border-color: #1877f2;
}

.form-control.is-invalid {
    border-color: #f02849;
    background: #fff5f5;
}

.invalid-feedback {
    color: #f02849;
    font-size: 13px;
    display: none;
}

.form-control.is-invalid + .invalid-feedback {
    display: block;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.btn-submit {
    background: #1877f2;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 10px 24px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s;
}

.btn-submit:hover {
    background: #166fe5;
}

.btn-cancel {
    background: #e4e6eb;
    color: #050505;
    border: none;
    border-radius: 6px;
    padding: 10px 24px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s;
}

.btn-cancel:hover {
    background: #d8dadf;
}

/* ===== FILTER BAR ===== */
.filter-bar {
    background: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #65676b;
}

.search-box input {
    width: 100%;
    padding: 10px 12px 10px 38px;
    border: 1px solid #dddfe2;
    border-radius: 20px;
    background: #f0f2f5;
    font-size: 15px;
    outline: none;
    transition: all 0.2s;
}

.search-box input:focus {
    background: #fff;
    border-color: #1877f2;
}

.filter-box {
    min-width: 200px;
}

.filter-box select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #dddfe2;
    border-radius: 6px;
    background: #f0f2f5;
    font-size: 15px;
    cursor: pointer;
    outline: none;
    transition: all 0.2s;
}

.filter-box select:focus {
    background: #fff;
    border-color: #1877f2;
}

/* ===== POST CARD - GIAO DIỆN GIỐNG FACEBOOK ===== */
.questions-feed .post-card {
    margin-bottom: 16px;
}

.post-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.author-info {
    display: flex;
    gap: 12px;
    flex: 1;
}

.author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 20px;
}

.avatar-placeholder.admin {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.author-details {
    flex: 1;
}

.author-name-row {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 4px;
}

.author-name {
    font-size: 15px;
    font-weight: 600;
    color: #050505;
}

.user-badge {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.admin-badge {
    color: #fff;
}

.member-badge {
    background: #e7f3ff;
    color: #1877f2;
}

.category-tag {
    background: #ffeaa7;
    color: #2d3436;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.post-time {
    font-size: 13px;
    color: #65676b;
    display: flex;
    align-items: center;
    gap: 4px;
}

.post-actions {
    display: flex;
    gap: 8px;
}

.btn-edit-question {
    background: #f0f2f5;
    border: none;
    border-radius: 6px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #65676b;
    transition: all 0.2s;
}

.btn-edit-question:hover {
    background: #e4e6eb;
    color: #050505;
}

/* ===== POST CONTENT ===== */
.post-content {
    margin-bottom: 16px;
}

.post-title {
    font-size: 18px;
    font-weight: 700;
    color: #050505;
    margin: 0 0 12px 0;
    line-height: 1.4;
}

.post-body {
    color: #050505;
    font-size: 15px;
    line-height: 1.6;
}

.post-body p {
    margin: 0;
}

/* ===== POST STATS ===== */
.post-stats {
    border-top: 1px solid #e4e6eb;
    padding-top: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 600;
}

.stat-answered {
    color: #31b545;
}

.stat-pending {
    color: #e67e22;
}

.stat-divider {
    color: #65676b;
    font-size: 12px;
}

.btn-toggle-answers {
    background: none;
    border: none;
    color: #65676b;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 0;
    transition: color 0.2s;
}

.btn-toggle-answers:hover {
    color: #050505;
}

.btn-like {
    background: none;
    border: none;
    color: #65676b;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s;
}

.btn-like:hover {
    background: #f0f2f5;
}

.btn-like.liked {
    color: #e91e63;
}

.btn-like.liked i {
    animation: likeAnimation 0.3s ease;
}

@keyframes likeAnimation {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.btn-like .like-count {
    font-weight: 700;
}

/* ===== SIDEBAR ===== */
.forum-sidebar {
    width: 320px;
    flex-shrink: 0;
}

.sidebar-card {
    background: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.sidebar-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f2f5;
}

.sidebar-header i {
    color: #1877f2;
    font-size: 18px;
}

.sidebar-header h3 {
    font-size: 16px;
    font-weight: 700;
    color: #1c1e21;
    margin: 0;
}

.sidebar-body {
    color: #65676b;
}

/* Top Questions */
.top-questions-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.top-question-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.rank-badge {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
}

.rank-badge.rank-1 {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(255, 215, 0, 0.4);
}

.rank-badge.rank-2 {
    background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(192, 192, 192, 0.4);
}

.rank-badge.rank-3 {
    background: linear-gradient(135deg, #cd7f32 0%, #e69a56 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(205, 127, 50, 0.4);
}

.rank-badge:not(.rank-1):not(.rank-2):not(.rank-3) {
    background: #f0f2f5;
    color: #65676b;
}

.top-question-info {
    flex: 1;
    min-width: 0;
}

.top-question-title {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #050505;
    margin-bottom: 4px;
    text-decoration: none;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.top-question-title:hover {
    color: #1877f2;
}

.top-question-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #65676b;
}

.top-author,
.top-likes {
    display: flex;
    align-items: center;
    gap: 4px;
}

.top-likes {
    color: #e91e63;
    font-weight: 600;
}

.no-top-questions {
    text-align: center;
    padding: 24px 12px;
    color: #65676b;
}

.no-top-questions i {
    font-size: 36px;
    margin-bottom: 8px;
    opacity: 0.5;
}

.no-top-questions p {
    margin: 0;
    font-size: 13px;
}

/* Stats */
.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 14px;
}

.stat-row:not(:last-child) {
    border-bottom: 1px solid #f0f2f5;
}

.stat-label {
    color: #65676b;
}

.stat-value {
    font-weight: 700;
    color: #050505;
}

.stat-value.text-success {
    color: #31b545;
}

.stat-value.text-warning {
    color: #e67e22;
}

/* ===== ANSWERS SECTION ===== */
.answers-wrapper {
    border-top: 1px solid #e4e6eb;
    margin-top: 16px;
    padding-top: 16px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.answers-wrapper.is-expanded {
    max-height: 2000px;
}

.answers-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.answer-card {
    display: flex;
    gap: 10px;
    padding: 12px;
    background: #f7f8fa;
    border-radius: 8px;
}

.answer-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.answer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.answer-content {
    flex: 1;
}

.answer-header {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 6px;
}

.answer-author {
    font-size: 14px;
    font-weight: 600;
    color: #050505;
}

.answer-time {
    font-size: 12px;
    color: #65676b;
    display: flex;
    align-items: center;
    gap: 4px;
}

.answer-text {
    color: #050505;
    font-size: 14px;
    line-height: 1.5;
}

.answer-text p {
    margin: 0;
}

.no-answers {
    text-align: center;
    padding: 24px;
    color: #65676b;
}

.no-answers i {
    font-size: 36px;
    margin-bottom: 8px;
    opacity: 0.5;
}

.no-answers p {
    margin: 0;
    font-size: 14px;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    background: #fff;
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: #f0f2f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 48px;
    color: #bcc0c4;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1c1e21;
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 15px;
    color: #65676b;
    margin: 0 0 20px 0;
}

/* ===== PAGINATION ===== */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    padding: 20px 0;
}

/* Pagination styles - Đẹp và hiện đại */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin: 0;
    padding: 0;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    border: 2px solid #e4e6eb;
    border-radius: 8px;
    color: #050505;
    padding: 10px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    background: white;
    min-width: 45px;
    text-align: center;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    text-decoration: none;
}

.pagination .page-link:hover {
    background: #1877f2;
    border-color: #1877f2;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(24,119,242,0.25);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #1877f2 0%, #166fe5 100%);
    border-color: #1877f2;
    color: white;
    box-shadow: 0 4px 12px rgba(24,119,242,0.3);
    transform: scale(1.1);
}

.pagination .page-item.disabled .page-link {
    background: #f0f2f5;
    border-color: #e4e6eb;
    color: #bcc0c4;
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination .page-item.disabled .page-link:hover {
    background: #f0f2f5;
    border-color: #e4e6eb;
    color: #bcc0c4;
    transform: none;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

/* Previous/Next buttons */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    border-radius: 8px;
    font-weight: 700;
    padding: 10px 20px;
}

.pagination .page-item:first-child .page-link {
    background: linear-gradient(90deg, #f0f2f5 0%, #ffffff 100%);
}

.pagination .page-item:last-child .page-link {
    background: linear-gradient(90deg, #ffffff 0%, #f0f2f5 100%);
}

.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background: linear-gradient(135deg, #1877f2 0%, #166fe5 100%);
}

/* Dots separator */
.pagination .page-item .page-link[aria-label*="..."] {
    border: none;
    background: transparent;
    box-shadow: none;
    cursor: default;
    padding: 10px 8px;
}

.pagination .page-item .page-link[aria-label*="..."]:hover {
    background: transparent;
    transform: none;
    box-shadow: none;
    color: #65676b;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .forum-layout {
        flex-direction: column;
    }
    
    .forum-sidebar {
        width: 100%;
        order: -1;
    }
    
    .sidebar-card {
        display: inline-block;
        width: calc(50% - 8px);
        margin-right: 16px;
        vertical-align: top;
    }
    
    .sidebar-card:last-child {
        margin-right: 0;
    }
}

@media (max-width: 768px) {
    .forum-container {
        padding: 12px 0;
    }
    
    .forum-layout {
        padding: 0 8px;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .forum-title {
        font-size: 20px;
    }
    
    .btn-ask-question {
        justify-content: center;
        width: 100%;
    }
    
    .filter-bar {
        flex-direction: column;
    }
    
    .search-box,
    .filter-box {
        width: 100%;
        min-width: 100%;
    }
    
    .post-card {
        padding: 16px;
    }
    
    .author-name-row {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-submit,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }
    
    .sidebar-card {
        width: 100%;
        margin-right: 0;
        display: block;
    }
    
    /* Pagination responsive - Tablet */
    .pagination .page-link {
        padding: 8px 12px;
        min-width: 38px;
        font-size: 14px;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 8px 14px;
    }
    
    .pagination {
        gap: 4px;
    }
}

@media (max-width: 576px) {
    .author-avatar {
        width: 40px;
        height: 40px;
    }
    
    .post-title {
        font-size: 16px;
    }
    
    .post-body {
        font-size: 14px;
    }
    
    /* Pagination responsive - Mobile */
    .pagination .page-link {
        padding: 6px 10px;
        min-width: 35px;
        font-size: 13px;
        border-radius: 6px;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 6px 12px;
    }
    
    /* Ẩn một số số trang trên mobile để gọn hơn */
    .pagination .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)) {
        display: none;
    }
}
</style>
@endsection

@section('scripts')
<script>
// Toggle like/unlike câu hỏi
function toggleLike(questionId) {
    // Kiểm tra đăng nhập
    @guest
        alert('Bạn cần đăng nhập để like câu hỏi!');
        window.location.href = '{{ route("login") }}';
        return;
    @endguest
    
    const token = $('meta[name="csrf-token"]').attr('content');
    const $btn = $(`.btn-like[data-question-id="${questionId}"]`);
    
    // Disable button khi đang xử lý
    $btn.prop('disabled', true);
    
    $.ajax({
        url: `/hoi-dap/${questionId}/like`,
        method: 'POST',
        data: {
            _token: token
        },
        success: function(response) {
            if (response.success) {
                // Cập nhật UI
                $btn.find('.like-count').text(response.likes_count);
                
                if (response.liked) {
                    $btn.addClass('liked');
                } else {
                    $btn.removeClass('liked');
                }
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                alert('Bạn cần đăng nhập để like câu hỏi!');
                window.location.href = '{{ route("login") }}';
            } else {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        },
        complete: function() {
            // Enable lại button
            $btn.prop('disabled', false);
        }
    });
}

// Toggle answers section
function toggleAnswers(questionId) {
    const answersWrapper = document.getElementById(`answers-${questionId}`);
    
    if (answersWrapper) {
        if (answersWrapper.classList.contains('is-collapsed')) {
            answersWrapper.classList.remove('is-collapsed');
            answersWrapper.classList.add('is-expanded');
        } else {
            answersWrapper.classList.add('is-collapsed');
            answersWrapper.classList.remove('is-expanded');
        }
    }
}

// Search và filter functionality
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
    const questionItems = document.querySelectorAll('.questions-feed .post-card[data-question-id]');
    
    questionItems.forEach(item => {
        const title = item.querySelector('.post-title')?.textContent.toLowerCase() || '';
        const body = item.querySelector('.post-body')?.textContent.toLowerCase() || '';
        const category = item.dataset.category || '';
        
        const matchesSearch = title.includes(searchTerm) || body.includes(searchTerm);
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
                setTimeout(() => { $('#title').trigger('focus'); }, 50);
            } else {
                $formWrapper.addClass('is-hidden');
                // Reset form khi đóng
                resetForm();
            }
        });
    }
    
    // Nút Cancel trong form
    $('#cancelFormBtn').on('click', function() {
        $formWrapper.addClass('is-hidden');
        resetForm();
    });
    
    // Xử lý nút sửa câu hỏi
    $(document).on('click', '.btn-edit-question', function() {
        const id = $(this).data('id');
        const $card = $(this).closest('.post-card');
        const currentTitle = $card.find('.post-title').text().trim();
        const currentCategory = $card.data('category');
        const currentContent = $card.find('.post-body p').text().trim();

        // Hiển thị form
        if ($formWrapper.hasClass('is-hidden')) {
            $toggleBtn.trigger('click');
        }
        
        // Điền dữ liệu vào form
        $('#title').val(currentTitle);
        $('#category').val(currentCategory);
        $('#content').val(currentContent);

        // Gắn cờ đang edit
        $('#questionForm').attr('data-edit-id', id);
        $('.btn-submit span').text('Cập nhật Câu Hỏi');
        
        // Scroll đến form
        $('html, body').animate({
            scrollTop: $formWrapper.offset().top - 100
        }, 500);
    });
    
    // Xử lý form gửi câu hỏi
    $('#questionForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form trước khi gửi
        if (!validateForm()) {
            return;
        }
        
        const editId = $(this).attr('data-edit-id');
        const isEdit = !!editId;
        
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
        
        // Thêm method PATCH nếu đang edit
        if (isEdit) {
            formData._method = 'PATCH';
        }
        
        // Xác định URL
        const url = isEdit ? '/hoi-dap/' + editId : '{{ route("question-answer.store") }}';
        
        // Gửi request
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#loadingModal').modal('hide');
                
                if (response.success) {
                    // Hiển thị modal thành công
                    $('#successModal').modal('show');
                    
                    // Reset form
                    resetForm();
                    
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
                } else if (xhr.status === 403) {
                    showErrorModal('Bạn không có quyền thực hiện thao tác này.');
                } else {
                    showErrorModal('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            }
        });
    });
    
    // Reset form về trạng thái ban đầu
    function resetForm() {
        $('#questionForm')[0].reset();
        $('#questionForm').removeAttr('data-edit-id');
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
        $('.btn-submit span').text('Gửi Câu Hỏi');
    }
    
    // Hàm validate form
    function validateForm() {
        let isValid = true;
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
        
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
        }
        
        // Validate category
        const category = $('#category').val();
        if (!category) {
            showFieldError('category', 'Vui lòng chọn danh mục câu hỏi.');
            isValid = false;
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
        }
        
        return isValid;
    }
    
    // Hàm hiển thị lỗi cho field
    function showFieldError(fieldName, message) {
        const $input = $(`#${fieldName}`);
        const $feedback = $input.siblings('.invalid-feedback');
        
        $input.addClass('is-invalid');
        $feedback.text(message).show();
    }
    
    // Hàm hiển thị modal lỗi
    function showErrorModal(message) {
        $('#errorMessage').text(message);
        $('#errorModal').modal('show');
    }
    
    // Hàm hiển thị lỗi validation từ server
    function showValidationErrors(errors) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
        
        Object.keys(errors).forEach(function(field) {
            showFieldError(field, errors[field][0]);
        });
        
        showErrorModal('Vui lòng kiểm tra lại thông tin đã nhập.');
    }
    
    // Real-time validation khi người dùng nhập
    $('#title, #category, #content').on('input change', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').text('').hide();
    });
});
</script>
@endsection
