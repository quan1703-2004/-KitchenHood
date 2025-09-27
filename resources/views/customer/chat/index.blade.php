@extends('layouts.customer')

@section('title', 'Hỗ trợ khách hàng')

@section('content')
<div class="customer-chat-container">
    <!-- Chat Header -->
    <div class="chat-header">
        <div class="header-content">
            <div class="support-avatar">
                <div class="avatar-circle">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="online-indicator"></div>
            </div>
            <div class="header-info">
                <h3 class="support-title">Hỗ trợ khách hàng</h3>
                <p class="support-subtitle">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
                <div class="status-badge">
                    <span class="status-dot"></span>
                    <span class="status-text">Trực tuyến</span>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <button class="action-btn" title="Tối thiểu hóa">
                <i class="fas fa-minus"></i>
            </button>
            <button class="action-btn" title="Đóng">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Chat Messages Area -->
    <div class="chat-messages-area">
        <div id="customerChatMessages" class="messages-container">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Chào mừng bạn đến với hệ thống hỗ trợ!</h3>
                <p>Nhân viên hỗ trợ sẽ phản hồi trong thời gian sớm nhất</p>
                <div class="quick-actions">
                    <button class="quick-btn">
                        <i class="fas fa-question-circle"></i>
                        Câu hỏi thường gặp
                    </button>
                    <button class="quick-btn">
                        <i class="fas fa-phone"></i>
                        Gọi hỗ trợ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Input Area -->
    <div class="message-input-area">
        <div class="input-container">
            <button class="input-btn emoji-btn" type="button" title="Emoji">
                <i class="fas fa-smile"></i>
            </button>
            <div class="message-input-wrapper">
                <input type="text" id="customerMessageInput" class="message-input" 
                       placeholder="Nhập tin nhắn của bạn..." maxlength="500">
                <div class="input-actions">
                    <button class="input-btn attach-btn" type="button" title="Đính kèm hình ảnh">
                        <i class="fas fa-image"></i>
                    </button>
                    <button class="input-btn attach-btn" type="button" title="Đính kèm file">
                        <i class="fas fa-paperclip"></i>
                    </button>
                </div>
            </div>
            <button class="send-btn" id="customerSendButton">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
        <div class="input-footer">
            <small class="input-hint">
                <i class="fas fa-info-circle"></i>
                Tin nhắn sẽ được gửi tới nhân viên hỗ trợ
            </small>
            <div class="typing-indicator" id="typingIndicator" style="display: none;">
                <div class="typing-dots">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
                <span class="typing-text">Đang nhập...</span>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== CSS Variables & Reset ===== */
:root {
    /* Color Palette */
    --primary-color: #3498db;
    --primary-light: #81c784;
    --primary-dark: #388e3c;
    --secondary-color: #26a69a;
    --accent-color: #ffc107;
    
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
    --online-color: #4caf50;
    
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
.customer-chat-container {
    max-width: 800px;
    margin: var(--space-6) auto;
    background: var(--white);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 80vh;
    min-height: 600px;
}

/* ===== Chat Header ===== */
.chat-header {
    background: #79929d;
    color: var(--white);
    padding: var(--space-6);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.chat-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-full);
    transform: rotate(45deg);
}

.header-content {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    position: relative;
    z-index: 2;
}

.support-avatar {
    position: relative;
}

.avatar-circle {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-2xl);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: var(--shadow-lg);
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 16px;
    height: 16px;
    background: var(--online-color);
    border: 3px solid var(--white);
    border-radius: var(--radius-full);
    box-shadow: var(--shadow-sm);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.1); }
}

.header-info {
    flex: 1;
}

.support-title {
    font-size: var(--font-size-xl);
    font-weight: 700;
    margin-bottom: var(--space-1);
    color: var(--white);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.support-subtitle {
    font-size: var(--font-size-sm);
    opacity: 0.9;
    color: var(--white);
    margin-bottom: var(--space-2);
    font-weight: 500;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: rgba(255, 255, 255, 0.15);
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #00ff0a;
    border-radius: var(--radius-full);
    animation: pulse 2s infinite;
}

.status-text {
    font-size: var(--font-size-xs);
    font-weight: 600;
    color: var(--white);
}

.header-actions {
    display: flex;
    gap: var(--space-2);
    position: relative;
    z-index: 2;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: rgba(255, 255, 255, 0.15);
    border-radius: var(--radius-md);
    color: var(--white);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-sm);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.05);
}

.action-btn:active {
    transform: scale(0.95);
}

/* ===== Chat Messages Area ===== */
.chat-messages-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: var(--gray-50);
}

.messages-container {
    flex: 1;
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

/* ===== Empty State ===== */
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
    margin-bottom: var(--space-6);
}

.quick-actions {
    display: flex;
    gap: var(--space-3);
    flex-wrap: wrap;
    justify-content: center;
}

.quick-btn {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-4);
    background: var(--white);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-xl);
    color: var(--gray-700);
    font-size: var(--font-size-sm);
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-normal);
    box-shadow: var(--shadow-sm);
}

.quick-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.quick-btn i {
    font-size: var(--font-size-base);
}

/* ===== Message Items ===== */
.message-item {
    margin-bottom: var(--space-4);
    animation: messageSlideIn 0.3s ease-out;
}

.message-item.customer {
    text-align: right;
}

.message-item.admin {
    text-align: left;
}

.message-bubble {
    display: inline-block;
    max-width: 75%;
    padding: var(--space-4) var(--space-5);
    border-radius: var(--radius-2xl);
    word-wrap: break-word;
    position: relative;
    box-shadow: var(--shadow-sm);
    line-height: 1.5;
    transition: all var(--transition-normal);
}

.message-bubble:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.message-item.customer .message-bubble {
    background: #79929d;
    color: var(--white);
    border-bottom-right-radius: var(--radius-md);
}

.message-item.admin .message-bubble {
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

.message-item.customer .message-meta {
    text-align: right;
    color: rgba(255, 255, 255, 0.8);
}

.message-item.admin .message-meta {
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

/* ===== Message Input Area ===== */
.message-input-area {
    padding: var(--space-6);
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
    border-color: #79929d;
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.message-input-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.message-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: var(--space-3) var(--space-4);
    font-size: var(--font-size-base);
    color: var(--gray-900);
    outline: none;
    resize: none;
    font-weight: 500;
}

.message-input:disabled {
    color: var(--gray-500);
    cursor: not-allowed;
}

.message-input::placeholder {
    color: var(--gray-500);
    font-weight: 400;
}

.input-actions {
    display: flex;
    gap: var(--space-1);
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
    width: 44px;
    height: 44px;
    border: none;
    background: #79929d;
    border-radius: var(--radius-full);
    color: var(--white);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-base);
    box-shadow: var(--shadow-sm);
}

.send-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #2e7d32 100%);
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

/* Input Footer */
.input-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: var(--space-3);
    min-height: 20px;
}

.input-hint {
    display: flex;
    align-items: center;
    gap: var(--space-1);
    color: var(--gray-500);
    font-size: var(--font-size-xs);
    font-weight: 500;
}

.input-hint i {
    font-size: var(--font-size-xs);
}

/* ===== Typing Indicator ===== */
.typing-indicator {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    background: var(--white);
    border-radius: var(--radius-xl);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    animation: slideInUp 0.3s ease-out;
}

.typing-dots {
    display: flex;
    gap: var(--space-1);
}

.typing-dot {
    width: 8px;
    height: 8px;
    background: var(--primary-color);
    border-radius: var(--radius-full);
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dot:nth-child(1) {
    animation-delay: -0.32s;
}

.typing-dot:nth-child(2) {
    animation-delay: -0.16s;
}

.typing-text {
    font-size: var(--font-size-xs);
    color: var(--gray-600);
    font-weight: 500;
}

@keyframes typing {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== Responsive Design ===== */
@media (max-width: 768px) {
    .customer-chat-container {
        margin: var(--space-2);
        height: 90vh;
        border-radius: var(--radius-xl);
    }
    
    .chat-header {
        padding: var(--space-4);
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: var(--font-size-xl);
    }
    
    .support-title {
        font-size: var(--font-size-lg);
    }
    
    .support-subtitle {
        font-size: var(--font-size-xs);
    }
    
    .messages-container {
        padding: var(--space-4);
    }
    
    .message-bubble {
        max-width: 85%;
        padding: var(--space-3) var(--space-4);
    }
    
    .message-input-area {
        padding: var(--space-4);
    }
    
    .quick-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .quick-btn {
        width: 100%;
        max-width: 200px;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .customer-chat-container {
        margin: var(--space-1);
        height: 95vh;
        border-radius: var(--radius-lg);
    }
    
    .chat-header {
        padding: var(--space-3);
    }
    
    .avatar-circle {
        width: 45px;
        height: 45px;
        font-size: var(--font-size-lg);
    }
    
    .support-title {
        font-size: var(--font-size-base);
    }
    
    .support-subtitle {
        font-size: var(--font-size-xs);
    }
    
    .status-badge {
        padding: var(--space-1) var(--space-2);
    }
    
    .messages-container {
        padding: var(--space-3);
    }
    
    .message-bubble {
        max-width: 90%;
        padding: var(--space-2) var(--space-3);
        font-size: var(--font-size-sm);
    }
    
    .message-input-area {
        padding: var(--space-3);
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
        width: 40px;
        height: 40px;
        font-size: var(--font-size-sm);
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        font-size: var(--font-size-2xl);
    }
    
    .empty-state h3 {
        font-size: var(--font-size-lg);
    }
    
    .empty-state p {
        font-size: var(--font-size-sm);
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
.action-btn:focus,
.input-btn:focus,
.send-btn:focus,
.quick-btn:focus {
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
// Khởi tạo hệ thống polling để tự động load tin nhắn mới
let customerPollingInterval = null;
let lastCustomerMessageId = null;

function initCustomerPolling() {
    console.log('Customer khởi tạo hệ thống polling...');
    
    // Kiểm tra tin nhắn mới mỗi 2 giây
    customerPollingInterval = setInterval(() => {
        checkForNewCustomerMessages();
    }, 2000);
    
    console.log('Customer polling đã được khởi tạo thành công');
}

// Kiểm tra tin nhắn mới từ admin
async function checkForNewCustomerMessages() {
    try {
        const response = await fetch('/customer/chatting/history', {
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
            
            // Nếu có tin nhắn mới từ admin
            if (latestMessage.sender_type === 'admin' && 
                (!lastCustomerMessageId || latestMessage.id > lastCustomerMessageId)) {
                
                console.log('Customer nhận tin nhắn mới:', latestMessage);
                
                addMessageToCustomerChat({
                    author: latestMessage.sender_name,
                    message: latestMessage.message,
                    time: latestMessage.created_at,
                    isAdmin: true
                });
                
                lastCustomerMessageId = latestMessage.id;
            }
        }
    } catch (err) {
        console.warn('Lỗi kiểm tra tin nhắn mới:', err);
    }
}

// Load lịch sử chat cho customer
async function loadCustomerChatHistory() {
    try {
        const response = await fetch('/customer/chatting/history', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (!response.ok) throw new Error(data?.error || 'Không thể tải lịch sử chat');
        
        const chatMessages = document.getElementById('customerChatMessages');
        chatMessages.innerHTML = '';
        
        if (data.data && data.data.length > 0) {
            data.data.forEach(message => {
                addMessageToCustomerChat({
                    author: message.sender_name,
                    message: message.message,
                    time: message.created_at,
                    isAdmin: message.sender_type === 'admin'
                });
            });
            
            // Lưu ID tin nhắn cuối cùng để theo dõi tin nhắn mới
            lastCustomerMessageId = data.data[data.data.length - 1].id;
        } else {
            chatMessages.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Chào mừng bạn đến với hệ thống hỗ trợ!</h3>
                    <p>Nhân viên hỗ trợ sẽ phản hồi trong thời gian sớm nhất</p>
                    <div class="quick-actions">
                        <button class="quick-btn">
                            <i class="fas fa-question-circle"></i>
                            Câu hỏi thường gặp
                        </button>
                        <button class="quick-btn">
                            <i class="fas fa-phone"></i>
                            Gọi hỗ trợ
                        </button>
                    </div>
                </div>
            `;
        }
        
    } catch (err) {
        console.error('Lỗi load lịch sử chat:', err);
        const chatMessages = document.getElementById('customerChatMessages');
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

// Thêm tin nhắn vào chat customer
function addMessageToCustomerChat(messageData) {
    const chatMessages = document.getElementById('customerChatMessages');
    
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

// Gửi tin nhắn từ customer
async function sendCustomerMessage() {
    const messageInput = document.getElementById('customerMessageInput');
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
        
    const sendButton = document.getElementById('customerSendButton');
    sendButton.disabled = true;
    
    try {
        // Lấy CSRF token mới
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            throw new Error('CSRF token không tồn tại');
        }

        console.log('Customer gửi tin nhắn:', { message });

        const response = await fetch("{{ route('chat.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                message: message
            })
        });
        
        console.log('Customer response status:', response.status);
        
        const data = await response.json();
        console.log('Customer response data:', data);
        
        if (!response.ok) {
            throw new Error(data?.message || `HTTP ${response.status}: ${response.statusText}`);
        }
        
        // Hiển thị tin nhắn của customer ngay lập tức với thời gian từ server
        addMessageToCustomerChat({
            author: '{{ Auth::user()->name }}',
            message: message,
            time: data.data.timestamp, // Sử dụng thời gian từ server
            isAdmin: false
        });
        
        // Cập nhật lastCustomerMessageId để không nhận lại tin nhắn này
        lastCustomerMessageId = data.data.id;
        
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

// Event listeners cho customer chat
document.addEventListener('DOMContentLoaded', function() {
    const sendButton = document.getElementById('customerSendButton');
    const messageInput = document.getElementById('customerMessageInput');

    if (sendButton) {
        sendButton.addEventListener('click', sendCustomerMessage);
    }
    
    if (messageInput) {
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendCustomerMessage();
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
    
    // Khởi tạo khi trang load
    initCustomerPolling();
    loadCustomerChatHistory();
    
    // Dừng polling khi rời khỏi trang
    window.addEventListener('beforeunload', function() {
        if (customerPollingInterval) {
            clearInterval(customerPollingInterval);
        }
    });
});
</script>
@endsection