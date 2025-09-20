@extends('layouts.admin')

@section('title', 'Chat với Khách hàng')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-comments me-2"></i>Chat với Khách hàng
                        </h3>
                        <button class="btn btn-light btn-sm" id="refreshAdminChat" title="Làm mới">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0" style="height: 80vh;">
                        <!-- Danh sách khách hàng -->
                        <div class="col-md-4 border-end bg-light">
                            <!-- Header với tìm kiếm -->
                            <div class="p-3 border-bottom bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-primary fw-bold">
                                        <i class="fas fa-users me-2"></i>Danh sách khách hàng
                                    </h6>
                                    <span class="badge bg-primary rounded-pill" id="customerCount">0</span>
                                </div>
                                <!-- Thanh tìm kiếm -->
                                <div class="position-relative">
                                    <input type="text" id="customerSearch" class="form-control form-control-sm" 
                                           placeholder="Tìm kiếm khách hàng..." autocomplete="off">
                                    <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>
                            </div>
                            
                            <!-- Danh sách khách hàng -->
                            <div id="adminCustomersList" class="p-3" style="height: calc(100% - 120px); overflow-y: auto;">
                                <div class="empty-state loading-pulse">
                                    <i class="fas fa-spinner fa-spin text-primary"></i>
                                    <p>Đang tải danh sách khách hàng...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Khung chat -->
                        <div class="col-md-8">
                            <div id="adminChatWindow" class="d-flex flex-column h-100">
                                <!-- Header chat -->
                                <div class="p-3 border-bottom bg-gradient-light">
                                    <div class="d-flex align-items-center">
                                        <div class="chat-avatar me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1" id="selectedCustomerName">Chọn khách hàng để bắt đầu chat</h6>
                                            <small class="text-muted" id="selectedCustomerInfo">Nhấn vào tên khách hàng bên trái</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Khung tin nhắn -->
                                <div id="adminChatMessages" class="flex-grow-1 p-3 chat-messages-container">
                                    <div class="text-center text-muted py-5">
                                        <i class="fas fa-comments fa-3x mb-3 opacity-50 text-primary"></i>
                                        <p>Chọn khách hàng để xem lịch sử chat</p>
                                        <small>Tin nhắn sẽ hiển thị ở đây</small>
                                    </div>
                                </div>

                                <!-- Form gửi tin nhắn -->
                                <div class="p-3 border-top bg-white">
                                    <div class="input-group">
                                        <input type="text" id="adminMessageInput" class="form-control form-control-lg" placeholder="Nhập tin nhắn..." maxlength="500" disabled>
                                        <button class="btn btn-primary btn-lg" id="adminSendButton" disabled>
                                            <i class="fas fa-paper-plane me-2"></i>Gửi
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Tin nhắn sẽ được gửi tới khách hàng đã chọn
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
</div>

<style>
/* Gradient backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* Chat avatar */
.chat-avatar {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    box-shadow: 0 2px 8px rgba(0,123,255,0.3);
}

/* Customer list styling */
.customer-item {
    padding: 16px;
    border-radius: 16px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
}

.customer-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #00d4ff);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.customer-item:hover {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-color: #007bff;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.15);
}

.customer-item:hover::before {
    transform: scaleX(1);
}

.customer-item.active {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-color: #2196f3;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(33,150,243,0.25);
}

.customer-item.active::before {
    transform: scaleX(1);
    background: linear-gradient(90deg, #2196f3, #00bcd4);
}

/* Customer avatar */
.customer-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff 0%, #00d4ff 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
    margin-right: 12px;
    flex-shrink: 0;
}

.customer-item.active .customer-avatar {
    background: linear-gradient(135deg, #2196f3 0%, #00bcd4 100%);
    box-shadow: 0 4px 12px rgba(33,150,243,0.4);
}

/* Customer content */
.customer-content {
    flex: 1;
    min-width: 0;
}

.customer-name {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 4px;
    font-size: 16px;
    line-height: 1.3;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.customer-item.active .customer-name {
    color: #1976d2;
}

.customer-info {
    font-size: 0.9em;
    color: #6c757d;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.customer-info i {
    font-size: 0.8em;
    color: #007bff;
}

.customer-meta {
    font-size: 0.8em;
    color: #8e9aaf;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.customer-meta i {
    font-size: 0.7em;
}

/* Status indicators */
.status-verified {
    color: #28a745;
    font-size: 0.8em;
    display: flex;
    align-items: center;
    gap: 4px;
}

.status-unverified {
    color: #dc3545;
    font-size: 0.8em;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Search styling */
#customerSearch {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 8px 16px 8px 40px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

#customerSearch:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
    background: white;
}

#customerSearch::placeholder {
    color: #adb5bd;
    font-style: italic;
}

.unread-badge {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-radius: 12px;
    padding: 4px 8px;
    font-size: 0.75em;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(220,53,69,0.3);
}

/* Chat messages container */
.chat-messages-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    overflow-y: auto;
    max-height: calc(70vh - 200px);
    scroll-behavior: smooth;
}

.chat-messages-container::-webkit-scrollbar {
    width: 6px;
}

.chat-messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chat-messages-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.chat-messages-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Message styling */
.message-item {
    margin-bottom: 20px;
    animation: fadeInUp 0.3s ease;
}

.message-item.admin {
    text-align: right;
}

.message-item.customer {
    text-align: left;
}

.message-bubble {
    display: inline-block;
    max-width: 75%;
    padding: 15px 20px;
    border-radius: 20px;
    word-wrap: break-word;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.message-item.admin .message-bubble {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-bottom-right-radius: 6px;
}

.message-item.customer .message-bubble {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    color: #333;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 6px;
}

.message-meta {
    font-size: 0.75em;
    opacity: 0.8;
    margin-top: 8px;
    font-weight: 500;
}

.message-item.admin .message-meta {
    text-align: right;
    color: rgba(255,255,255,0.8);
}

.message-item.customer .message-meta {
    text-align: left;
    color: #666;
}

/* Typing indicator */
.typing-indicator {
    display: flex;
    align-items: center;
    padding: 12px 18px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    border-bottom-left-radius: 6px;
    max-width: 90px;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.typing-dots {
    display: flex;
    gap: 4px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
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
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form styling */
.form-control-lg {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 12px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.btn-lg {
    border-radius: 25px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}

/* Loading animation */
@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

.loading-pulse {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Empty state styling */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.empty-state small {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Scrollbar styling for customer list */
#adminCustomersList::-webkit-scrollbar {
    width: 6px;
}

#adminCustomersList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#adminCustomersList::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#adminCustomersList::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Hover effects for interactive elements */
.customer-item {
    position: relative;
}

.customer-item::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 16px;
    transform: translateY(-50%);
    width: 8px;
    height: 8px;
    background: #007bff;
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.customer-item:hover::after {
    opacity: 1;
}

.customer-item.active::after {
    background: #2196f3;
    opacity: 1;
}

/* Badge styling improvements */
.unread-badge {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-radius: 12px;
    padding: 4px 8px;
    font-size: 0.75em;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(220,53,69,0.3);
    animation: pulse 2s infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .row.g-0 {
        height: 80vh !important;
    }
    
    .message-bubble {
        max-width: 85%;
        padding: 12px 16px;
    }
    
    .chat-avatar {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .customer-avatar {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .customer-item {
        padding: 12px;
    }
    
    .customer-name {
        font-size: 15px;
    }
    
    .customer-info {
        font-size: 0.85em;
    }
    
    .customer-meta {
        font-size: 0.75em;
        gap: 8px;
    }
}

@media (max-width: 576px) {
    .customer-item {
        padding: 10px;
        margin-bottom: 8px;
    }
    
    .customer-avatar {
        width: 36px;
        height: 36px;
        font-size: 14px;
        margin-right: 8px;
    }
    
    .customer-name {
        font-size: 14px;
    }
    
    .customer-info {
        font-size: 0.8em;
    }
    
    .customer-meta {
        font-size: 0.7em;
        gap: 6px;
    }
    
    #customerSearch {
        font-size: 13px;
        padding: 6px 12px 6px 35px;
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
            
            // Tạo avatar từ tên
            const avatarText = customer.name.charAt(0).toUpperCase();
            
            // Tạo ngày đăng ký đẹp hơn
            const registerDate = formatDate(customer.created_at);
            
            // Trạng thái xác thực
            const isVerified = customer.email_verified_at === 'Đã xác thực';
            const statusClass = isVerified ? 'status-verified' : 'status-unverified';
            const statusIcon = isVerified ? 'fas fa-check-circle' : 'fas fa-times-circle';
            const statusText = isVerified ? 'Đã xác thực' : 'Chưa xác thực';
            
            customerDiv.innerHTML = `
                <div class="d-flex align-items-start">
                    <div class="customer-avatar">
                        ${avatarText}
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
                <div class="text-center text-muted py-5">
                    <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                    <p>Chưa có tin nhắn nào</p>
                    <small>Bắt đầu cuộc trò chuyện với khách hàng</small>
                </div>
            `;
        }
        
    } catch (err) {
        console.error('Lỗi load lịch sử chat:', err);
        const chatMessages = document.getElementById('adminChatMessages');
        chatMessages.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="fas fa-exclamation-triangle fa-3x mb-3 opacity-50"></i>
                <p>Không thể tải lịch sử chat</p>
                <small>Vui lòng thử lại sau</small>
            </div>
        `;
    }
}

// Thêm tin nhắn vào chat admin
function addMessageToAdminChat(messageData) {
    const chatMessages = document.getElementById('adminChatMessages');
    
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