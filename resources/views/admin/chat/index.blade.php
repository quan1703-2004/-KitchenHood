@extends('layouts.admin')

@section('title', 'Chat với Khách hàng')

@section('content')
<div class="chat-container">
    <!-- Sidebar bên trái -->
    <div class="chat-sidebar">
        <!-- Profile Admin -->
        <div class="admin-profile">
            <div class="admin-avatar">
                <div class="avatar-circle">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="admin-avatar-img">
                    @else
                        <span class="admin-avatar-initial">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8'), 'UTF-8') }}</span>
                    @endif
                </div>
                <div class="admin-info">
                    <h4 class="admin-name">{{ Auth::user()->name }}</h4>
                    <span class="admin-role">Quản trị viên</span>
                </div>
            </div>
        </div>

        <!-- Thanh tìm kiếm -->
        <div class="search-section">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="customerSearch" class="search-input" 
                       placeholder="Tìm kiếm khách hàng..." autocomplete="off">
            </div>
        </div>

        <!-- Danh sách khách hàng -->
        <div class="customers-section">
            <div class="section-header">
                <h3 class="section-title">Tin nhắn gần đây</h3>
                <button class="refresh-btn" id="refreshAdminChat" title="Làm mới">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
            
            <div id="adminCustomersList" class="customers-list">
                <div class="loading-state">
                    <div class="loading-spinner"></div>
                    <p>Đang tải danh sách khách hàng...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Khung chat bên phải -->
    <div class="chat-main">
        <div id="adminChatWindow" class="chat-window">
            <!-- Header chat -->
            <div class="chat-header">
                <div class="chat-user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h4 class="user-name" id="selectedCustomerName">Chọn khách hàng để bắt đầu chat</h4>
                        <span class="user-status" id="selectedCustomerInfo">Nhấn vào tên khách hàng bên trái</span>
                    </div>
                </div>
                <div class="chat-actions">
                    <button class="action-btn" title="Gọi điện">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="action-btn" title="Video call">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="action-btn" title="Thêm người">
                        <i class="fas fa-user-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Khung tin nhắn -->
            <div id="adminChatMessages" class="messages-container">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Chọn khách hàng để xem lịch sử chat</h3>
                    <p>Tin nhắn sẽ hiển thị ở đây</p>
                </div>
            </div>

            <!-- Form gửi tin nhắn -->
            <div class="message-input-section">
                <div class="input-container">
                    <button class="input-btn emoji-btn" type="button" title="Emoji">
                        <i class="fas fa-smile"></i>
                    </button>
                    <div class="message-input-wrapper">
                        <input type="text" id="adminMessageInput" class="message-input" 
                               placeholder="Nhập tin nhắn..." maxlength="500" disabled>
                    </div>
                    <button class="input-btn attach-btn" type="button" title="Đính kèm hình ảnh">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="input-btn attach-btn" type="button" title="Đính kèm file">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <button class="send-btn" id="adminSendButton" disabled>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== CSS Variables & Reset ===== */
:root {
    /* Color Palette */
    --primary-color: #1976d2;
    --primary-light: #42a5f5;
    --primary-dark: #1565c0;
    --secondary-color: #26a69a;
    --accent-color: #ff7043;
    
    /* Neutral Colors */
    --white: #ffffff;
    --gray-50: #fafafa;
    --gray-100: #f5f5f5;
    --gray-200: #eeeeee;
    --gray-300: #e0e0e0;
    --gray-400: #bdbdbd;
    --gray-500: #9e9e9e;
    --gray-600: #757575;
    --gray-700: #616161;
    --gray-800: #424242;
    --gray-900: #212121;
    
    /* Status Colors */
    --success-color: #4caf50;
    --warning-color: #ff9800;
    --error-color: #f44336;
    --info-color: #2196f3;
    
    /* Typography */
    --font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
    --font-size-xs: 0.75rem;
    --font-size-sm: 0.875rem;
    --font-size-base: 1rem;
    --font-size-lg: 1.125rem;
    --font-size-xl: 1.25rem;
    --font-size-2xl: 1.5rem;
    --font-size-3xl: 1.875rem;
    
    /* Spacing */
    --space-1: 0.25rem;
    --space-2: 0.5rem;
    --space-3: 0.75rem;
    --space-4: 1rem;
    --space-5: 1.25rem;
    --space-6: 1.5rem;
    --space-8: 2rem;
    --space-10: 2.5rem;
    --space-12: 3rem;
    --space-16: 4rem;
    
    /* Border Radius */
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
    --radius-2xl: 1.5rem;
    --radius-full: 9999px;
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    
    /* Transitions */
    --transition-fast: 150ms ease-in-out;
    --transition-normal: 250ms ease-in-out;
    --transition-slow: 350ms ease-in-out;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: var(--font-family);
    background-color: var(--gray-50);
    color: var(--gray-900);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* ===== Main Container ===== */
.chat-container {
    display: flex;
    height: 100vh;
    background: var(--white);
    overflow: hidden;
}

/* ===== Sidebar ===== */
.chat-sidebar {
    width: 360px;
    background: var(--white);
    border-right: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 10;
    box-shadow: var(--shadow-lg);
}

/* Admin Profile */
.admin-profile {
    padding: 1rem;
    background: linear-gradient(135deg, #78a3c5 0%, #5e7b93 100%);
    color: var(--white);
    position: relative;
    overflow: hidden;
    border-radius: 10px 10px 0 0; 
}

.admin-profile::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-full);
    transform: rotate(45deg);
}

.admin-avatar {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    position: relative;
    z-index: 2;
}

.avatar-circle {
    width: 52px;
    height: 52px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-xl);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    position: relative;
}

/* Ảnh avatar admin hiển thị tròn, cover đầy đủ */
.admin-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--radius-full);
    display: block;
}

/* Chữ cái đầu khi không có ảnh */
.admin-avatar-initial {
    color: var(--white);
    font-weight: 700;
}

.avatar-circle::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), transparent);
    border-radius: var(--radius-full);
    z-index: -1;
}

.admin-info {
    flex: 1;
}

.admin-name {
    font-size: var(--font-size-lg);
    font-weight: 700;
    margin-bottom: var(--space-1);
    color: var(--white);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.admin-role {
    font-size: var(--font-size-sm);
    opacity: 0.9;
    color: var(--white);
    font-weight: 500;
}

/* Search Section */
.search-section {
    padding: 1rem;
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
}

.search-container {
    position: relative;
}

.search-icon {
    position: absolute;
    left: var(--space-4);
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-500);
    font-size: var(--font-size-sm);
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: var(--space-4) var(--space-4) var(--space-4) var(--space-10);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-xl);
    font-size: var(--font-size-sm);
    background: var(--gray-50);
    transition: all var(--transition-normal);
    outline: none;
    font-weight: 500;
}

.search-input:focus {
    border-color: var(--primary-color);
    background: var(--white);
    box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.1);
    transform: translateY(-1px);
}

.search-input::placeholder {
    color: var(--gray-500);
    font-weight: 400;
}

/* Customers Section */
.customers-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: var(--gray-50);
}

.section-header {
    padding: 1rem 1rem 0.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    border-radius: 0 0 10px 10px;
}

.section-title {
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: var(--gray-900);
    letter-spacing: -0.025em;
}

.refresh-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: var(--gray-100);
    border-radius: var(--radius-lg);
    color: var(--gray-600);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-sm);
    box-shadow: var(--shadow-sm);
}

.refresh-btn:hover {
    background: var(--primary-color);
    color: var(--white);
    transform: rotate(180deg) scale(1.05);
    box-shadow: var(--shadow-md);
}

.refresh-btn:active {
    transform: rotate(180deg) scale(0.95);
}

/* Customers List */
.customers-list {
    flex: 1;
    overflow-y: auto;
    padding: var(--space-4);
    background: var(--gray-50);
}

.customers-list::-webkit-scrollbar {
    width: 6px;
}

.customers-list::-webkit-scrollbar-track {
    background: transparent;
}

.customers-list::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: var(--radius-full);
}

.customers-list::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

/* Loading State */
.loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: var(--space-12);
    color: var(--gray-500);
}

.loading-spinner {
    width: 32px;
    height: 32px;
    border: 3px solid var(--gray-200);
    border-top: 3px solid var(--primary-color);
    border-radius: var(--radius-full);
    animation: spin 1s linear infinite;
    margin-bottom: var(--space-4);
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-state p {
    font-size: var(--font-size-sm);
    color: var(--gray-600);
}

/* ===== Customer Items ===== */
.customer-item {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: 1rem;
    margin-bottom: var(--space-3);
    border-radius: var(--radius-xl);
    cursor: pointer;
    transition: all var(--transition-normal);
    background: var(--white);
    border: 2px solid transparent;
    position: relative;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.customer-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.05) 0%, rgba(25, 118, 210, 0.02) 100%);
    opacity: 0;
    transition: opacity var(--transition-normal);
}

.customer-item:hover {
    background: var(--white);
    border-color: var(--gray-300);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.customer-item:hover::before {
    opacity: 1;
}

.customer-item.active {
    background: var(--white);
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px rgba(25, 118, 210, 0.2), var(--shadow-lg);
    transform: translateY(-2px);
}

.customer-item.active::before {
    opacity: 1;
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.1) 0%, rgba(25, 118, 210, 0.05) 100%);
}

.customer-item.active::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-light) 100%);
    border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    box-shadow: var(--shadow-sm);
}

/* Customer Avatar */
.customer-avatar {
    width: 52px;
    height: 52px;
    border-radius: var(--radius-full);
    background: #9E9E9E;
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-lg);
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: var(--shadow-md);
    position: relative;
    z-index: 2;
}

/* Ảnh avatar khách hàng */
.customer-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--radius-full);
    display: block;
}

.customer-avatar::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    border-radius: var(--radius-full);
    z-index: -1;
    opacity: 0.3;
}

.customer-item.active .customer-avatar {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
    box-shadow: var(--shadow-lg);
    transform: scale(1.05);
}

/* Customer Content */
.customer-content {
    flex: 1;
    min-width: 0;
    position: relative;
    z-index: 2;
}

.customer-name {
    font-size: var(--font-size-base);
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: var(--space-2);
    display: flex;
    align-items: center;
    justify-content: space-between;
    line-height: 1.4;
    letter-spacing: -0.025em;
}

.customer-item.active .customer-name {
    color: var(--primary-dark);
}

.customer-info {
    font-size: var(--font-size-sm);
    color: var(--gray-600);
    margin-bottom: var(--space-2);
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-weight: 500;
}

.customer-info i {
    font-size: var(--font-size-xs);
    color: var(--primary-color);
    width: 14px;
    text-align: center;
}

.customer-meta {
    font-size: var(--font-size-xs);
    color: var(--gray-500);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    flex-wrap: wrap;
    font-weight: 500;
}

.customer-meta i {
    font-size: var(--font-size-xs);
    width: 12px;
    text-align: center;
}

/* Status Indicators */
.status-verified {
    color: var(--success-color);
    font-size: var(--font-size-xs);
    display: flex;
    align-items: center;
    gap: var(--space-1);
    font-weight: 600;
}

.status-unverified {
    color: var(--error-color);
    font-size: var(--font-size-xs);
    display: flex;
    align-items: center;
    gap: var(--space-1);
    font-weight: 600;
}

/* Unread Badge */
.unread-badge {
    background: linear-gradient(135deg, var(--error-color) 0%, #d32f2f 100%);
    color: var(--white);
    border-radius: var(--radius-full);
    padding: var(--space-1) var(--space-2);
    font-size: var(--font-size-xs);
    font-weight: 700;
    min-width: 22px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    animation: pulse 2s infinite;
    border: 2px solid var(--white);
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* ===== Chat Main Area ===== */
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: var(--gray-50);
    position: relative;
}

.chat-window {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: var(--white);
    border-radius: var(--radius-lg) 0 0 var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

/* Chat Header */
.chat-header {
    padding: var(--space-5);
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 5;
}

.chat-user-info {
    display: flex;
    align-items: center;
    gap: var(--space-4);
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-full);
    background: linear-gradient(135deg, var(--gray-600) 0%, var(--gray-700) 100%);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-lg);
    box-shadow: var(--shadow-sm);
}

.user-details {
    flex: 1;
}

.user-name {
    font-size: var(--font-size-lg);
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: var(--space-1);
}

.user-status {
    font-size: var(--font-size-sm);
    color: var(--gray-600);
}

/* Chat Actions */
.chat-actions {
    display: flex;
    gap: var(--space-2);
}

.action-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: var(--gray-100);
    border-radius: var(--radius-md);
    color: var(--gray-600);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-sm);
}

.action-btn:hover {
    background: var(--gray-200);
    color: var(--gray-800);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

/* ===== Messages Container ===== */
.messages-container {
    flex: 1;
    background: var(--gray-50);
    overflow-y: auto;
    padding: var(--space-6);
    scroll-behavior: smooth;
    position: relative;
}

.messages-container::-webkit-scrollbar {
    width: 8px;
}

.messages-container::-webkit-scrollbar-track {
    background: transparent;
}

.messages-container::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: var(--radius-full);
}

.messages-container::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

/* Empty State */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    color: var(--gray-500);
    padding: var(--space-8);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--space-6);
    color: var(--gray-400);
    font-size: var(--font-size-3xl);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.empty-icon::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.empty-state h3 {
    font-size: var(--font-size-xl);
    font-weight: 700;
    color: var(--gray-700);
    margin-bottom: var(--space-3);
    letter-spacing: -0.025em;
}

.empty-state p {
    font-size: var(--font-size-base);
    color: var(--gray-500);
    font-weight: 500;
    line-height: 1.6;
    max-width: 300px;
}

/* ===== Message Items ===== */
.message-item {
    margin-bottom: var(--space-4);
    animation: messageSlideIn 0.3s ease-out;
}

.message-item.admin {
    text-align: right;
}

.message-item.customer {
    text-align: left;
}

.message-bubble {
    display: inline-block;
    max-width: 70%;
    padding: var(--space-4) var(--space-5);
    border-radius: var(--radius-2xl);
    word-wrap: break-word;
    position: relative;
    box-shadow: var(--shadow-sm);
    line-height: 1.5;
}

.message-item.admin .message-bubble {
    background: #86a4bc;
    color: var(--white);
    border-bottom-right-radius: var(--radius-md);
}

.message-item.customer .message-bubble {
    background: var(--white);
    color: var(--gray-900);
    border: 1px solid var(--gray-200);
    border-bottom-left-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
}

.message-meta {
    font-size: var(--font-size-xs);
    opacity: 0.8;
    margin-top: var(--space-2);
    font-weight: 500;
}

.message-item.admin .message-meta {
    text-align: right;
    color: rgba(255, 255, 255, 0.8);
}

.message-item.customer .message-meta {
    text-align: left;
    color: var(--gray-500);
}

/* Message Animations */
@keyframes messageSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* ===== Message Input Section ===== */
.message-input-section {
    padding: var(--space-5);
    background: var(--white);
    border-top: 1px solid var(--gray-200);
    position: relative;
    z-index: 5;
}

.input-container {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    background: var(--gray-50);
    border-radius: var(--radius-2xl);
    padding: var(--space-2);
    border: 2px solid var(--gray-200);
    transition: all var(--transition-normal);
}

.input-container:focus-within {
    border-color: var(--primary-color);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.message-input-wrapper {
    flex: 1;
}

.message-input {
    width: 100%;
    border: none;
    background: transparent;
    padding: var(--space-3) var(--space-4);
    font-size: var(--font-size-base);
    color: var(--gray-900);
    outline: none;
    resize: none;
}

.message-input:disabled {
    color: var(--gray-500);
    cursor: not-allowed;
}

.message-input::placeholder {
    color: var(--gray-500);
}

/* Input Buttons */
.input-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: transparent;
    border-radius: var(--radius-md);
    color: var(--gray-500);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-sm);
}

.input-btn:hover {
    background: var(--gray-200);
    color: var(--gray-700);
}

.input-btn:active {
    transform: scale(0.95);
}

.send-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: var(--primary-color);
    border-radius: var(--radius-full);
    color: var(--white);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-sm);
    box-shadow: var(--shadow-sm);
}

.send-btn:hover:not(:disabled) {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.send-btn:disabled {
    background: var(--gray-300);
    color: var(--gray-500);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.send-btn:active:not(:disabled) {
    transform: scale(0.95);
}

/* ===== Responsive Design ===== */
@media (max-width: 1024px) {
    .chat-sidebar {
        width: 320px;
    }
    
    .admin-profile {
        padding: var(--space-4);
    }
    
    .avatar-circle {
        width: 48px;
        height: 48px;
        font-size: var(--font-size-lg);
    }
    
    .admin-name {
        font-size: var(--font-size-base);
    }
}

@media (max-width: 768px) {
    .chat-container {
        flex-direction: column;
    }
    
    .chat-sidebar {
        width: 100%;
        height: 40vh;
        border-right: none;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .chat-main {
        height: 60vh;
    }
    
    .chat-window {
        border-radius: 0;
    }
    
    .message-bubble {
        max-width: 85%;
        padding: var(--space-3) var(--space-4);
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        font-size: var(--font-size-base);
    }
    
    .customer-avatar {
        width: 40px;
        height: 40px;
        font-size: var(--font-size-base);
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
    }
    
    .send-btn {
        width: 36px;
        height: 36px;
    }
}

@media (max-width: 576px) {
    .chat-sidebar {
        height: 35vh;
    }
    
    .chat-main {
        height: 65vh;
    }
    
    .admin-profile {
        padding: var(--space-3);
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: var(--font-size-base);
    }
    
    .admin-name {
        font-size: var(--font-size-sm);
    }
    
    .admin-role {
        font-size: var(--font-size-xs);
    }
    
    .search-section {
        padding: var(--space-3);
    }
    
    .search-input {
        padding: var(--space-2) var(--space-2) var(--space-2) var(--space-8);
        font-size: var(--font-size-sm);
    }
    
    .section-header {
        padding: var(--space-3) var(--space-3) var(--space-2);
    }
    
    .section-title {
        font-size: var(--font-size-base);
    }
    
    .customer-item {
        padding: var(--space-3);
        margin-bottom: var(--space-1);
    }
    
    .customer-avatar {
        width: 36px;
        height: 36px;
        font-size: var(--font-size-sm);
    }
    
    .customer-name {
        font-size: var(--font-size-sm);
    }
    
    .customer-info {
        font-size: var(--font-size-xs);
    }
    
    .customer-meta {
        font-size: var(--font-size-xs);
        gap: var(--space-2);
    }
    
    .chat-header {
        padding: var(--space-4);
    }
    
    .user-name {
        font-size: var(--font-size-base);
    }
    
    .user-status {
        font-size: var(--font-size-xs);
    }
    
    .messages-container {
        padding: var(--space-4);
    }
    
    .message-input-section {
        padding: var(--space-4);
    }
    
    .message-input {
        font-size: var(--font-size-sm);
        padding: var(--space-2) var(--space-3);
    }
    
    .input-btn {
        width: 32px;
        height: 32px;
        font-size: var(--font-size-xs);
    }
    
    .send-btn {
        width: 32px;
        height: 32px;
        font-size: var(--font-size-xs);
    }
}

/* ===== Accessibility ===== */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Focus styles for keyboard navigation */
.customer-item:focus,
.action-btn:focus,
.input-btn:focus,
.send-btn:focus,
.refresh-btn:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    :root {
        --gray-200: #000000;
        --gray-300: #000000;
        --gray-500: #000000;
        --gray-600: #000000;
    }
}


</style>

<script>
let selectedCustomerId = null;
let adminEcho = null;

// Khởi tạo hệ thống polling để tự động load tin nhắn mới
let adminPollingInterval = null;
let lastMessageId = null;

function initAdminPolling() {
    console.log('Admin khởi tạo hệ thống polling...');
    
    // Kiểm tra tin nhắn mới mỗi 2 giây
    adminPollingInterval = setInterval(() => {
        if (selectedCustomerId) {
            checkForNewMessages();
        }
    }, 2000);
    
    console.log('Admin polling đã được khởi tạo thành công');
}

// Kiểm tra tin nhắn mới từ customer
async function checkForNewMessages() {
    try {
        const response = await fetch(`/admin/chatting/history/${selectedCustomerId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) return;
        
        const data = await response.json();
        
        if (data.data && data.data.length > 0) {
            // Lấy tin nhắn mới nhất
            const latestMessage = data.data[data.data.length - 1];
            
            // Nếu có tin nhắn mới từ customer
            if (latestMessage.sender_type === 'user' && 
                (!lastMessageId || latestMessage.id > lastMessageId)) {
                
                console.log('Admin nhận tin nhắn mới:', latestMessage);
                
                addMessageToAdminChat({
                    author: latestMessage.sender_name,
                    message: latestMessage.message,
                    time: latestMessage.created_at,
                    isAdmin: false
                });
                
                lastMessageId = latestMessage.id;
            }
        }
    } catch (err) {
        console.warn('Lỗi kiểm tra tin nhắn mới:', err);
    }
}

// Biến lưu trữ danh sách khách hàng gốc
let allCustomers = [];

// Load danh sách khách hàng
async function loadCustomersList() {
    try {
        const response = await fetch('/admin/chatting/data', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (!response.ok) throw new Error(data?.error || 'Không thể tải danh sách khách hàng');
        
        // Lưu danh sách gốc
        allCustomers = data.customers || [];
        
        // Hiển thị danh sách
        displayCustomers(allCustomers);
        
        // Cập nhật số lượng khách hàng
        updateCustomerCount(allCustomers.length);
        
    } catch (err) {
        console.error('Lỗi load danh sách khách hàng:', err);
        const customersList = document.getElementById('adminCustomersList');
        customersList.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Không thể tải danh sách khách hàng</p>
                <small>Vui lòng thử lại sau</small>
            </div>
        `;
    }
}

// Hiển thị danh sách khách hàng
function displayCustomers(customers) {
    const customersList = document.getElementById('adminCustomersList');
    customersList.innerHTML = '';
    
    if (customers && customers.length > 0) {
        customers.forEach(customer => {
            const customerDiv = document.createElement('div');
            customerDiv.className = 'customer-item';
            customerDiv.onclick = () => selectCustomer(customer.id, customer.name, customer.email);
            
            // Tạo avatar từ tên (fallback nếu không có ảnh)
            const avatarText = customer.name.charAt(0).toUpperCase();
            
            // Tạo ngày đăng ký đẹp hơn
            const registerDate = formatDate(customer.created_at);
            
            // Trạng thái xác thực
            const isVerified = customer.email_verified_at === 'Đã xác thực';
            const statusClass = isVerified ? 'status-verified' : 'status-unverified';
            const statusIcon = isVerified ? 'fas fa-check-circle' : 'fas fa-times-circle';
            const statusText = isVerified ? 'Đã xác thực' : 'Chưa xác thực';
            
            const hasAvatar = Boolean(customer.avatar_url);
            customerDiv.innerHTML = `
                <div class="d-flex align-items-start">
                    <div class="customer-avatar">
                        ${hasAvatar ? `<img src="${customer.avatar_url}" alt="${customer.name}" class="customer-avatar-img">` : avatarText}
                    </div>
                    <div class="customer-content">
                        <div class="customer-name">
                            <span>${customer.name}</span>
                            ${customer.unread_count > 0 ? `<span class="unread-badge">${customer.unread_count}</span>` : ''}
                        </div>
                        <div class="customer-info">
                            <i class="fas fa-envelope"></i>
                            <span>${customer.email}</span>
                        </div>
                        <div class="customer-meta">
                            <span><i class="fas fa-calendar-alt"></i> ${registerDate}</span>
                            <span class="${statusClass}">
                                <i class="${statusIcon}"></i>
                                ${statusText}
                            </span>
                        </div>
                    </div>
                </div>
            `;
            
            customersList.appendChild(customerDiv);
        });
    } else {
        customersList.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <p>Chưa có khách hàng nào</p>
                <small>Tìm kiếm để lọc danh sách</small>
            </div>
        `;
    }
}

// Cập nhật số lượng khách hàng
function updateCustomerCount(count) {
    const countElement = document.getElementById('customerCount');
    if (countElement) {
        countElement.textContent = count;
    }
}

// Định dạng ngày tháng
function formatDate(dateString) {
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    } catch (err) {
        return dateString;
    }
}

// Tìm kiếm khách hàng
function searchCustomers(searchTerm) {
    if (!searchTerm.trim()) {
        displayCustomers(allCustomers);
        updateCustomerCount(allCustomers.length);
        return;
    }
    
    const filteredCustomers = allCustomers.filter(customer => {
        const name = customer.name.toLowerCase();
        const email = customer.email.toLowerCase();
        const search = searchTerm.toLowerCase();
        
        return name.includes(search) || email.includes(search);
    });
    
    displayCustomers(filteredCustomers);
    updateCustomerCount(filteredCustomers.length);
}

// Chọn khách hàng để chat
async function selectCustomer(customerId, customerName, customerEmail) {
    selectedCustomerId = customerId;
    
    // Reset lastMessageId khi chọn customer mới
    lastMessageId = null;
    
    // Cập nhật UI
    document.querySelectorAll('.customer-item').forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');
    
    document.getElementById('selectedCustomerName').textContent = customerName;
    document.getElementById('selectedCustomerInfo').textContent = customerEmail;
    
    // Enable form gửi tin nhắn
    document.getElementById('adminMessageInput').disabled = false;
    document.getElementById('adminSendButton').disabled = false;
    
    // Load lịch sử chat
    await loadChatHistory(customerId);
    
    // Mark as read
    try {
        await fetch(`/admin/chatting/mark-read/${customerId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
    } catch (err) {
        console.warn('Không thể đánh dấu đã đọc:', err);
    }
}

// Load lịch sử chat với khách hàng
async function loadChatHistory(customerId) {
    try {
        const response = await fetch(`/admin/chatting/history/${customerId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (!response.ok) throw new Error(data?.error || 'Không thể tải lịch sử chat');
        
        const chatMessages = document.getElementById('adminChatMessages');
        chatMessages.innerHTML = '';
        
        if (data.data && data.data.length > 0) {
            data.data.forEach(message => {
                addMessageToAdminChat({
                    author: message.sender_name,
                    message: message.message,
                    time: message.created_at,
                    isAdmin: message.sender_type === 'admin'
                });
            });
            
            // Lưu ID tin nhắn cuối cùng để theo dõi tin nhắn mới
            lastMessageId = data.data[data.data.length - 1].id;
        } else {
            chatMessages.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Chưa có tin nhắn nào</h3>
                    <p>Bắt đầu cuộc trò chuyện với khách hàng</p>
                </div>
            `;
        }
        
    } catch (err) {
        console.error('Lỗi load lịch sử chat:', err);
        const chatMessages = document.getElementById('adminChatMessages');
        chatMessages.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3>Không thể tải lịch sử chat</h3>
                <p>Vui lòng thử lại sau</p>
            </div>
        `;
    }
}

// Thêm tin nhắn vào chat admin
function addMessageToAdminChat(messageData) {
    const chatMessages = document.getElementById('adminChatMessages');
    
    // Xóa thông báo chào mừng nếu có
    const welcomeMessage = chatMessages.querySelector('.empty-state');
    if (welcomeMessage) welcomeMessage.remove();
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message-item ${messageData.isAdmin ? 'admin' : 'customer'}`;
    
    messageDiv.innerHTML = `
        <div class="message-bubble">
            <div>${messageData.message}</div>
            <div class="message-meta">${messageData.time}</div>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Gửi tin nhắn từ admin
async function sendAdminMessage() {
    const messageInput = document.getElementById('adminMessageInput');
    const message = messageInput.value.trim();
    
    if (!message) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa nhập tin nhắn',
            text: 'Vui lòng nhập nội dung tin nhắn',
            confirmButtonText: 'Đóng'
        });
        return;
    }
    
    if (!selectedCustomerId) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa chọn khách hàng',
            text: 'Vui lòng chọn khách hàng để gửi tin nhắn',
            confirmButtonText: 'Đóng'
        });
        return;
    }
    
    const sendButton = document.getElementById('adminSendButton');
    sendButton.disabled = true;
    
    try {
        // Lấy CSRF token mới
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            throw new Error('CSRF token không tồn tại');
        }

        console.log('Admin gửi tin nhắn:', { message, customer_id: selectedCustomerId });

        const response = await fetch("{{ route('admin.admin.chat.send-message') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                message: message,
                customer_id: selectedCustomerId
            })
        });
        
        console.log('Admin response status:', response.status);
        
        const data = await response.json();
        console.log('Admin response data:', data);
        
        if (!response.ok) {
            throw new Error(data?.message || `HTTP ${response.status}: ${response.statusText}`);
        }
        
        // Hiển thị tin nhắn của admin ngay lập tức với thời gian từ server
        addMessageToAdminChat({
            author: '{{ Auth::user()->name }}',
            message: message,
            time: data.data.timestamp, // Sử dụng thời gian từ server
            isAdmin: true
        });
        
        // Cập nhật lastMessageId để không nhận lại tin nhắn này
        lastMessageId = data.data.id;
        
        messageInput.value = '';
        messageInput.focus();
        
    } catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Gửi thất bại',
            text: err?.message || 'Vui lòng thử lại',
            confirmButtonText: 'Đóng'
        });
    } finally {
        sendButton.disabled = false;
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const sendButton = document.getElementById('adminSendButton');
    const messageInput = document.getElementById('adminMessageInput');
    const refreshButton = document.getElementById('refreshAdminChat');
    const searchInput = document.getElementById('customerSearch');

    if (sendButton) {
        sendButton.addEventListener('click', sendAdminMessage);
    }
    
    if (messageInput) {
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendAdminMessage();
            }
        });
        
        // Giới hạn độ dài tin nhắn
        messageInput.addEventListener('input', function(e) {
            const maxLength = 500;
            if (e.target.value.length > maxLength) {
                e.target.value = e.target.value.substring(0, maxLength);
            }
        });
    }
    
    if (refreshButton) {
        refreshButton.addEventListener('click', function() {
            loadCustomersList();
        });
    }
    
    // Chức năng tìm kiếm khách hàng
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchCustomers(e.target.value);
            }, 300); // Delay 300ms để tránh tìm kiếm quá nhiều lần
        });
        
        // Xóa tìm kiếm khi nhấn Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.target.value = '';
                searchCustomers('');
            }
        });
    }
    
    // Khởi tạo khi trang load
    initAdminPolling();
    loadCustomersList();
    
    // Dừng polling khi rời khỏi trang
    window.addEventListener('beforeunload', function() {
        if (adminPollingInterval) {
            clearInterval(adminPollingInterval);
        }
    });
});
</script>
@endsection