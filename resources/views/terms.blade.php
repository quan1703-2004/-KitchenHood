<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Điều khoản dịch vụ</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 0; background: #f6f7f9; color:#111; }
        .wrap { max-width: 900px; margin: 40px auto; padding: 24px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; }
        h1 { margin: 0 0 12px; font-size: 28px; }
        h2 { margin: 22px 0 10px; font-size: 18px; }
        p, li { line-height: 1.6; }
        code { background: #f3f4f6; padding: 2px 6px; border-radius: 6px; }
        .muted { color:#6b7280; font-size: 14px; margin-top: 6px; }
    </style>
</head>
<body>
<main class="wrap">
    <h1>Điều khoản dịch vụ</h1>
    <div class="muted">Cập nhật lần cuối: {{ now()->format('d/m/Y') }}</div>

    <p>
        Bằng việc truy cập và sử dụng website/ứng dụng này, bạn đồng ý với các điều khoản dưới đây.
        Nếu bạn không đồng ý, vui lòng ngừng sử dụng dịch vụ.
    </p>

    <h2>1) Tài khoản & đăng nhập</h2>
    <ul>
        <li>Bạn chịu trách nhiệm bảo mật thông tin tài khoản của mình.</li>
        <li>Nếu dùng đăng nhập Facebook, hệ thống chỉ nhận thông tin cần thiết để xác thực và tạo/ghép tài khoản.</li>
    </ul>

    <h2>2) Quyền riêng tư</h2>
    <p>
        Vui lòng xem <a href="{{ url('/privacy') }}">Chính sách quyền riêng tư</a> để biết cách chúng tôi thu thập và sử dụng dữ liệu.
    </p>

    <h2>3) Xóa dữ liệu</h2>
    <p>
        Hướng dẫn xóa dữ liệu: <a href="{{ url('/privacy/data-deletion-page') }}">Trang yêu cầu xóa dữ liệu</a>
        (hoặc API: <code>{{ url('/delete-data') }}</code>).
    </p>

    <h2>4) Giới hạn trách nhiệm</h2>
    <p>
        Dịch vụ được cung cấp theo hiện trạng. Chúng tôi không chịu trách nhiệm cho các thiệt hại gián tiếp phát sinh từ việc sử dụng dịch vụ.
    </p>

    <h2>5) Liên hệ</h2>
    <p>
        Nếu bạn cần hỗ trợ, vui lòng liên hệ qua email hỗ trợ/ email quản trị được công bố trên website.
    </p>
</main>
</body>
</html>

