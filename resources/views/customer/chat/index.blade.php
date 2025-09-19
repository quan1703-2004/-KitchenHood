@extends('layouts.customer')

@section('title', 'Hỗ trợ khách hàng')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-success text-white">
                    <div class="d-flex align-items-center">
                        <div class="chat-avatar me-3">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Hỗ trợ khách hàng</h4>
                            <small>Chúng tôi luôn sẵn sàng hỗ trợ bạn</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0" style="height: 70vh;">
                        <!-- Khung tin nhắn -->
                        <div class="col-12">
                            <div id="customerChatMessages" class="p-4 chat-messages-container">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-comments fa-3x mb-3 opacity-50 text-success"></i>
                                    <p>Chào mừng bạn đến với hệ thống hỗ trợ!</p>
                                    <small>Nhân viên hỗ trợ sẽ phản hồi trong thời gian sớm nhất</small>
                                </div>
                            </div>
                            
                            <!-- Form gửi tin nhắn -->
                            <div class="p-4 border-top bg-white">
                                <div class="input-group">
                                    <input type="text" id="customerMessageInput" class="form-control form-control-lg" placeholder="Nhập tin nhắn của bạn..." maxlength="500">
                                    <button class="btn btn-success btn-lg" id="customerSendButton">
                                        <i class="fas fa-paper-plane me-2"></i>Gửi
                                    </button>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Tin nhắn sẽ được gửi tới nhân viên hỗ trợ
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Gradient backgrounds */
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

/* Chat avatar */
.chat-avatar {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}

/* Chat messages container */
.chat-messages-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    overflow-y: auto;
    max-height: calc(70vh - 150px);
    scroll-behavior: smooth;
}

.chat-messages-container::-webkit-scrollbar {
    width: 8px;
}

.chat-messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.chat-messages-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 4px;
}

.chat-messages-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
}

/* Message styling */
.message-item {
    margin-bottom: 25px;
    animation: fadeInUp 0.4s ease;
}

.message-item.customer {
    text-align: right;
}

.message-item.admin {
    text-align: left;
}

.message-bubble {
    display: inline-block;
    max-width: 80%;
    padding: 18px 24px;
    border-radius: 25px;
    word-wrap: break-word;
    position: relative;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.message-bubble:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.message-item.customer .message-bubble {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border-bottom-right-radius: 8px;
}

.message-item.admin .message-bubble {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    color: #333;
    border: 2px solid #e9ecef;
    border-bottom-left-radius: 8px;
}

.message-meta {
    font-size: 0.8em;
    opacity: 0.9;
    margin-top: 10px;
    font-weight: 600;
}

.message-item.customer .message-meta {
    text-align: right;
    color: rgba(255,255,255,0.9);
}

.message-item.admin .message-meta {
    text-align: left;
    color: #666;
}

/* Typing indicator */
.typing-indicator {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 25px;
    border-bottom-left-radius: 8px;
    max-width: 100px;
    border: 2px solid #e9ecef;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.typing-dots {
    display: flex;
    gap: 5px;
}

.typing-dot {
    width: 10px;
    height: 10px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dot:nth-child(1) {
    animation-delay: -0.32s;
}

.typing-dot:nth-child(2) {
    animation-delay: -0.16s;
}

/* Animations */
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

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form styling */
.form-control-lg {
    border-radius: 30px;
    border: 2px solid #e9ecef;
    padding: 15px 25px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.25);
}

.btn-lg {
    border-radius: 30px;
    padding: 15px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(40,167,69,0.4);
}

/* Card styling */
.card {
    border-radius: 20px;
    overflow: hidden;
}

.card-header {
    border-radius: 20px 20px 0 0 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .row.g-0 {
        height: 80vh !important;
    }
    
    .message-bubble {
        max-width: 90%;
        padding: 15px 20px;
    }
    
    .chat-avatar {
        width: 45px;
        height: 45px;
        font-size: 18px;
    }
    
    .form-control-lg {
        padding: 12px 20px;
        font-size: 14px;
    }
    
    .btn-lg {
        padding: 12px 24px;
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding: 10px;
    }
    
    .col-lg-10 {
        padding: 0;
    }
    
    .message-bubble {
        max-width: 95%;
        padding: 12px 16px;
        font-size: 14px;
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
                <div class="text-center text-muted py-5">
                    <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                    <p>Chào mừng bạn đến với hệ thống hỗ trợ!</p>
                    <small>Nhân viên hỗ trợ sẽ phản hồi trong thời gian sớm nhất</small>
                </div>
            `;
        }
        
    } catch (err) {
        console.error('Lỗi load lịch sử chat:', err);
        const chatMessages = document.getElementById('customerChatMessages');
        chatMessages.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="fas fa-exclamation-triangle fa-3x mb-3 opacity-50"></i>
                <p>Không thể tải lịch sử chat</p>
                <small>Vui lòng thử lại sau</small>
                </div>
            `;
    }
}

// Thêm tin nhắn vào chat customer
function addMessageToCustomerChat(messageData) {
    const chatMessages = document.getElementById('customerChatMessages');
    
    // Xóa thông báo chào mừng nếu có
    const welcomeMessage = chatMessages.querySelector('.text-center');
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