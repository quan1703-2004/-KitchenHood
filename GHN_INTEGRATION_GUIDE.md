# Hướng dẫn cấu hình GHN API

## Cấu hình biến môi trường

Thêm các biến sau vào file `.env` của bạn:

```env
# GHN API Configuration
# URL API của GHN (sử dụng sandbox cho môi trường dev)
GHN_API_URL=https://dev-online-gateway.ghn.vn

# Token xác thực từ GHN (lấy từ tài khoản GHN của bạn)
GHN_TOKEN=your_ghn_token_here

# ID shop trên GHN (lấy từ tài khoản GHN của bạn)
GHN_SHOP_ID=your_shop_id_here

# Thông tin địa chỉ gửi hàng (từ shop của bạn)
GHN_FROM_DISTRICT_ID=your_district_id_here
GHN_FROM_WARD_CODE=your_ward_code_here
```

## Cách lấy thông tin cấu hình từ GHN

### 1. Token API
- Đăng nhập vào tài khoản GHN của bạn
- Vào phần "API Integration" hoặc "Tích hợp API"
- Copy token API được cung cấp

### 2. Shop ID
- Trong tài khoản GHN, vào phần "Shop Management"
- Copy Shop ID của shop bạn muốn sử dụng

### 3. Địa chỉ gửi hàng
- Vào phần "Địa chỉ gửi hàng" trong tài khoản GHN
- Lấy District ID và Ward Code của địa chỉ shop

## Lưu ý quan trọng

1. **Môi trường Development**: Sử dụng `https://dev-online-gateway.ghn.vn`
2. **Môi trường Production**: Sử dụng `https://online-gateway.ghn.vn`
3. **Token**: Cần có quyền truy cập API để tạo đơn hàng vận chuyển
4. **Địa chỉ**: Địa chỉ gửi hàng phải chính xác để tính phí vận chuyển

## Kiểm tra tích hợp

Sau khi cấu hình, bạn có thể kiểm tra tích hợp bằng cách:

### 1. Test kết nối API
```bash
php artisan ghn:test --connection
```

### 2. Test tạo đơn hàng (cần cấu hình đầy đủ)
```bash
php artisan ghn:test --order
```

### 3. Test toàn bộ
```bash
php artisan ghn:test
```

### 4. Kiểm tra trong ứng dụng
1. Tạo một đơn hàng mới từ frontend
2. Kiểm tra log file `storage/logs/laravel.log` để xem kết quả tích hợp GHN
3. Kiểm tra trường `order_code` trong bảng `orders` để xem mã đơn hàng GHN

## Xử lý lỗi

### Lỗi thường gặp:

#### 1. Lỗi "Phường/xã người gửi không tồn tại trong hệ thống"
- **Nguyên nhân**: `GHN_FROM_WARD_CODE` chưa được cấu hình hoặc không đúng
- **Giải pháp**: 
  - Đăng nhập vào tài khoản GHN
  - Vào phần "Địa chỉ gửi hàng" 
  - Copy chính xác Ward Code của địa chỉ shop
  - Cập nhật vào file `.env`

#### 2. Lỗi "Số điện thoại không hợp lệ"
- **Nguyên nhân**: Số điện thoại không đúng định dạng
- **Giải pháp**: Sử dụng số điện thoại Việt Nam hợp lệ (10-11 số, bắt đầu bằng 0)

#### 3. Lỗi kết nối API (404)
- **Nguyên nhân**: Token API không đúng hoặc không có quyền
- **Giải pháp**: Kiểm tra lại token API trong tài khoản GHN

#### 4. Lấy Ward Code chính xác
Để lấy ward code chính xác cho địa chỉ của bạn:

```bash
# Lấy danh sách phường/xã cho Quận 1, TP.HCM
php artisan ghn:wards 1442

# Lấy danh sách phường/xã cho district khác
php artisan ghn:wards <district_id>
```

**Lưu ý quan trọng**: Ward code phải chính xác và tồn tại trong hệ thống GHN. Ví dụ:
- ✅ Ward code hợp lệ: `20101` (Phường Bến Nghé)
- ❌ Ward code không hợp lệ: `20113` (không tồn tại trong Quận 1)

#### 4. Các lỗi khác
1. Kiểm tra token API có đúng không
2. Kiểm tra địa chỉ gửi hàng có tồn tại không
3. Kiểm tra kết nối internet
4. Xem log để biết chi tiết lỗi

### Kiểm tra log chi tiết:
```bash
tail -f storage/logs/laravel.log | grep "GHN"
```