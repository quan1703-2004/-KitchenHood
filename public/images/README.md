# 📁 Thư Mục Lưu Trữ Hình Ảnh

Thư mục này chứa tất cả hình ảnh được sử dụng trong ứng dụng Laravel.

## 🗂️ Cấu Trúc Thư Mục

### 📦 `products/`
- **Mục đích**: Lưu trữ hình ảnh sản phẩm
- **Định dạng**: JPEG, PNG, JPG, GIF
- **Kích thước tối đa**: 2MB
- **Sử dụng**: Hiển thị trong danh sách sản phẩm, form tạo/sửa sản phẩm

### 🏷️ `categories/`
- **Mục đích**: Lưu trữ hình ảnh danh mục sản phẩm
- **Định dạng**: JPEG, PNG, JPG, GIF
- **Sử dụng**: Icon hoặc hình ảnh đại diện cho từng danh mục

### 👤 `avatars/`
- **Mục đích**: Lưu trữ hình ảnh đại diện người dùng
- **Định dạng**: JPEG, PNG, JPG, GIF
- **Sử dụng**: Hồ sơ người dùng, bình luận, đánh giá

### 🎨 `banners/`
- **Mục đích**: Lưu trữ hình ảnh banner, slider
- **Định dạng**: JPEG, PNG, JPG, GIF
- **Sử dụng**: Trang chủ, quảng cáo, khuyến mãi

## 📋 Quy Tắc Đặt Tên File

1. **Sử dụng tên có ý nghĩa**: `iphone-16-pro-max.jpg`
2. **Tránh ký tự đặc biệt**: Không sử dụng `@`, `#`, `$`, `%`, `^`, `&`, `*`, `(`, `)`, `+`, `=`, `[`, `]`, `{`, `}`, `|`, `\`, `:`, `;`, `"`, `'`, `<`, `>`, `,`, `.`, `?`, `/`
3. **Sử dụng dấu gạch ngang**: `-` thay vì dấu cách
4. **Thêm timestamp nếu cần**: `iphone-16-pro-max-20250822.jpg`

## 🔒 Bảo Mật

- Chỉ cho phép upload file hình ảnh
- Kiểm tra kích thước file
- Validate định dạng file
- Lưu trữ trong thư mục public để có thể truy cập từ web

## 🚀 Sử Dụng

### Trong Laravel Views:
```php
<img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
```

### Trong Laravel Controllers:
```php
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('products', 'public');
    // hoặc
    $imagePath = $request->file('image')->move('public/images/products', $filename);
}
```

## 📝 Lưu Ý

- Backup thường xuyên thư mục này
- Kiểm tra dung lượng ổ cứng định kỳ
- Xóa file không sử dụng để tiết kiệm không gian
- Sử dụng CDN cho production nếu cần thiết
