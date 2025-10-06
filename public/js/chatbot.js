// Widget Chatbot khách hàng (UI chuyên nghiệp, tránh màu tím)
(function() {
    const apiUrl = '/api/chatbot/message';

    // Container
    const container = document.createElement('div');
    container.id = 'chatbot-widget';
    container.style.position = 'fixed';
    container.style.right = '24px';
    container.style.bottom = '108px';
    container.style.zIndex = '1050';
    container.style.width = '440px';
    container.style.maxHeight = '74vh';
    container.style.display = 'none';
    container.style.overscrollBehavior = 'contain';

    // Card
    const card = document.createElement('div');
    card.style.display = 'flex';
    card.style.flexDirection = 'column';
    card.style.height = '100%';
    card.style.background = '#ffffff';
    card.style.borderRadius = '18px';
    card.style.border = '1px solid #e6e9ef';
    card.style.boxShadow = '0 28px 70px rgba(2,6,23,0.18)';
    card.style.maxHeight = '74vh';

    // Header
    const header = document.createElement('div');
    header.style.display = 'flex';
    header.style.alignItems = 'center';
    header.style.justifyContent = 'space-between';
    header.style.padding = '14px 16px';
    header.style.borderTopLeftRadius = '16px';
    header.style.borderTopRightRadius = '16px';
    header.style.borderBottom = '1px solid #e5e7eb';
    header.style.background = '#6487a2';
    header.style.color = '#fff';

    const left = document.createElement('div');
    left.style.display = 'flex';
    left.style.alignItems = 'center';
    left.style.gap = '10px';
    // Dùng ảnh chatbot.png (đã xóa nền) làm avatar hiển thị trực tiếp
    const botImageUrl = '/images/chatbot.png';
    left.innerHTML = '<img src="'+botImageUrl+'" alt="Chatbot" style="width:40px;height:40px;display:block;filter: drop-shadow(0 1px 2px rgba(0,0,0,.25));"/>\
    <div><div style="font-weight:800;letter-spacing:.2px">Trợ lý KitchenHood</div><small style="opacity:.9">Online</small></div>';

    const headerBtns = document.createElement('div');
    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.title = 'Đóng';
    closeBtn.style.background = 'transparent';
    closeBtn.style.border = 'none';
    closeBtn.style.color = '#fff';
    closeBtn.style.fontSize = '18px';
    closeBtn.textContent = '×';
    headerBtns.appendChild(closeBtn);

    header.appendChild(left);
    header.appendChild(headerBtns);

    // Messages
    const messages = document.createElement('div');
    messages.style.flex = '1';
    messages.style.overflowY = 'auto';
    messages.style.padding = '16px';
    messages.style.background = '#f7f9fc';
    messages.style.scrollBehavior = 'smooth';
    messages.style.overscrollBehavior = 'contain';
    messages.addEventListener('wheel', function(e){ e.stopPropagation(); }, { passive: true });

    // Welcome message
    let typingNode = null; // node hiển thị "đang soạn trả lời" để có thể xoá đi

    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }

    function sanitizeText(raw) {
        // Loại bỏ **, __, tiêu đề markdown đơn giản; rút gọn khoảng trắng thừa
        let t = String(raw || '');
        t = t.replace(/\*\*/g, '').replace(/__+/g, '');
        t = t.replace(/^#+\s*/gm, '');
        t = t.replace(/\s+$/g, '');
        return t;
    }

    function appendBubble(text, role) {
        const wrap = document.createElement('div');
        wrap.style.display = 'flex';
        wrap.style.marginBottom = '10px';
        wrap.style.justifyContent = role === 'user' ? 'flex-end' : 'flex-start';

        const bubble = document.createElement('div');
        bubble.style.maxWidth = '80%';
        bubble.style.padding = '10px 12px';
        bubble.style.borderRadius = '12px';
        bubble.style.whiteSpace = 'pre-wrap';
        bubble.style.lineHeight = '1.4';
        bubble.style.fontSize = '14px';
        if (role === 'user') {
            bubble.style.background = '#0d6efd';
            bubble.style.color = '#fff';
            bubble.style.borderTopRightRadius = '4px';
        } else {
            bubble.style.background = '#ffffff';
            bubble.style.color = '#111827';
            bubble.style.border = '1px solid #e5e7eb';
            bubble.style.borderTopLeftRadius = '4px';
        }
        bubble.textContent = sanitizeText(text);
        wrap.appendChild(bubble);
        messages.appendChild(wrap);
        scrollToBottom();
    }

    appendBubble('Xin chào! Mình là trợ lý AI. Bạn cần hỗ trợ gì về sản phẩm, đơn hàng hay chính sách?', 'bot');

    // Input area
    const inputWrap = document.createElement('div');
    inputWrap.style.display = 'flex';
    inputWrap.style.gap = '8px';
    inputWrap.style.padding = '12px';
    inputWrap.style.borderTop = '1px solid #e5e7eb';
    inputWrap.style.background = '#fff';

    const input = document.createElement('textarea');
    input.rows = 1;
    input.placeholder = 'Nhập câu hỏi của bạn...';
    input.style.flex = '1';
    input.style.border = '1px solid #d1d5db';
    input.style.borderRadius = '10px';
    input.style.padding = '10px 12px';
    input.style.resize = 'none';
    input.style.maxHeight = '160px';

    const sendBtn = document.createElement('button');
    sendBtn.type = 'button';
    sendBtn.textContent = 'Gửi';
    sendBtn.className = 'btn btn-primary';

    inputWrap.appendChild(input);
    inputWrap.appendChild(sendBtn);

    card.appendChild(header);
    card.appendChild(messages);
    card.appendChild(inputWrap);
    container.appendChild(card);
    document.body.appendChild(container);

    // Toggle button
    const toggleBtn = document.createElement('button');
    toggleBtn.id = 'chatbot-toggle';
    toggleBtn.setAttribute('aria-label', 'Mở Chatbot');
    toggleBtn.style.position = 'fixed';
    toggleBtn.style.right = '24px';
    toggleBtn.style.bottom = '24px';
    toggleBtn.style.width = '64px';
    toggleBtn.style.height = '64px';
    toggleBtn.style.borderRadius = '50%';
    toggleBtn.style.border = 'none';
    toggleBtn.style.background = 'linear-gradient(135deg, #0d6efd, #2b6cb0)';
    toggleBtn.style.color = '#fff';
    toggleBtn.style.boxShadow = '0 12px 28px rgba(13,110,253,0.4)';
    toggleBtn.style.zIndex = '1050';
    // Dùng ảnh chatbot trực tiếp cho nút toggle (không cần nền tròn)
    toggleBtn.style.background = 'transparent';
    toggleBtn.style.boxShadow = 'none';
    toggleBtn.innerHTML = '<img src="'+botImageUrl+'" alt="Chatbot" style="width:64px;height:64px;display:block;filter: drop-shadow(0 8px 20px rgba(0,0,0,.25));"/>';
    document.body.appendChild(toggleBtn);

    // Scroll-to-top button
    const toTop = document.createElement('button');
    toTop.id = 'scroll-to-top';
    toTop.setAttribute('aria-label', 'Lên đầu trang');
    toTop.style.position = 'fixed';
    toTop.style.right = '24px';
    toTop.style.bottom = '24px';
    toTop.style.transform = 'translateY(80px)';
    toTop.style.width = '48px';
    toTop.style.height = '48px';
    toTop.style.borderRadius = '50%';
    toTop.style.border = '1px solid #e5e7eb';
    toTop.style.background = '#ffffff';
    toTop.style.color = '#0d6efd';
    toTop.style.boxShadow = '0 10px 20px rgba(0,0,0,0.12)';
    toTop.style.zIndex = '1049';
    toTop.innerHTML = '↑';
    toTop.title = 'Cuộn lên đầu trang';
    document.body.appendChild(toTop);

    function setOpen(open) {
        container.style.display = open ? 'block' : 'none';
        if (open) {
            scrollToBottom();
        }
    }
    toggleBtn.addEventListener('click', () => setOpen(container.style.display === 'none'));
    closeBtn.addEventListener('click', () => setOpen(false));
    toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // Auto-expand textarea height
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    });

    // Helpers
    function showTyping() {
        // Tạo node riêng để có thể xoá khi có câu trả lời
        const wrap = document.createElement('div');
        wrap.style.display = 'flex';
        wrap.style.marginBottom = '10px';
        wrap.style.justifyContent = 'flex-start';
        const bubble = document.createElement('div');
        bubble.style.maxWidth = '80%';
        bubble.style.padding = '10px 12px';
        bubble.style.borderRadius = '12px';
        bubble.style.whiteSpace = 'pre-wrap';
        bubble.style.lineHeight = '1.4';
        bubble.style.fontSize = '14px';
        bubble.style.background = '#ffffff';
        bubble.style.color = '#6b7280';
        bubble.style.border = '1px solid #e5e7eb';
        bubble.style.borderTopLeftRadius = '4px';
        bubble.textContent = 'Đang soạn trả lời...';
        wrap.appendChild(bubble);
        messages.appendChild(wrap);
        typingNode = wrap;
        scrollToBottom();
    }

    async function sendMessage() {
        const text = (input.value || '').trim();
        if (!text) return;
        appendBubble(text, 'user');
        input.value = '';
        input.style.height = '38px';
        showTyping();
        try {
            const res = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: text })
            });
            const json = await res.json();
            // Xoá typing khi có phản hồi
            if (typingNode && typingNode.parentNode) typingNode.parentNode.removeChild(typingNode);
            typingNode = null;
            if (json && json.success) {
                appendBubble(json.answer, 'bot');
            } else {
                appendBubble(json.error || 'Xin lỗi, hệ thống bận. Vui lòng thử lại.', 'bot');
            }
        } catch (e) {
            if (typingNode && typingNode.parentNode) typingNode.parentNode.removeChild(typingNode);
            typingNode = null;
            appendBubble('Có lỗi kết nối. Vui lòng thử lại.', 'bot');
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
})();


