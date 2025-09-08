# 🏪 KitchenHood Pro - E-commerce Website

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-blue.svg)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

<p align="center">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-brightgreen" alt="Status">
  <img src="https://img.shields.io/badge/Version-1.0.0-blue" alt="Version">
  <img src="https://img.shields.io/badge/Last%20Update-September%202025-orange" alt="Last Update">
</p>

## 🛠️ Yêu cầu hệ thống

- **PHP**: >= 8.1
- **Composer**: >= 2.0
- **Node.js**: >= 16.0
- **NPM**: >= 8.0
- **MySQL**: >= 8.0 hoặc MariaDB >= 10.5
- **Web Server**: Apache/Nginx

## 🚀 Hướng dẫn cài đặt

### Bước 1: Clone dự án

```bash
# Clone repository về máy local
git https://github.com/tambl2004/laravel.git

### Bước 2: Cài đặt dependencies

```bash
# Cài đặt PHP dependencies (vendor)
composer update


# Lưu ý: nếu cài bị lỗi thì dùng cách sau:
1. Mở file cấu hình : 
notepad C:\xampp\php\php.ini
2. Tìm và bỏ dấu ; trước các dòng sau nếu có:
   extension=gd
   extension=zip
   extension=mbstring
3. Sau đó lưu lại rồi chạy:
composer clear-cache
composer update


#Cài đặt tailwind 
npm install -D @tailwindcss/vite

# Cài đặt Node.js dependencies
npm install
```

### Bước 3: Cấu hình môi trường

```bash
# Copy file môi trường
cp .env.example .env

# Xóa cache cấu hình cũ (rất quan trọng)
php artisan config:clear

# Sinh khóa và ghi vào .env
php artisan key:generate

# (Tuỳ chọn) Cache lại cấu hình cho sạch
php artisan config:cache

### Bước 4: Cấu hình database

2. **Cập nhật thông tin database** trong file `.env`:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce2024
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file 

### Bước 5: Kết nối csdl
Tạo bảng database mới trong xampp rồi import file sql vào, nhớ phải trùng tên ecommerce2024

### Bước 6: Tạo storage link

```bash
# Tạo symbolic link cho storage
php artisan storage:link
```

### Bước 7: Build assets

```bash
# Build CSS và JS cho production
npm run build

# Hoặc chạy development server
npm run dev
```

### Bước 8: Khởi chạy server

```bash
# Chạy development server
php artisan serve
```

Truy cập website tại: **http://localhost:8000**

## 👤 Tài khoản mặc định

### Admin Account
- **Email**: admin@admin.com
- **Password**: 12345678

Tài khoản người dùng pass cũng là 12345678

## 📁 Cấu trúc dự án

```
kitchenhood-pro/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Controllers quản lý admin
│   │   └── User/            # Controllers cho user
│   ├── Models/              # Eloquent models
│   └── Helpers/             # Helper classes
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/          # Views cho admin panel
│   │   ├── customer/       # Views cho customer
│   │   └── components/     # Blade components
│   ├── css/               # CSS files
│   └── js/                # JavaScript files
├── routes/
│   └── web.php            # Web routes
└── public/               # Public assets
```

## 🔧 Các lệnh hữu ích

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Tạo dữ liệu mẫu
php artisan db:seed

# Test rating system
php artisan test:rating

# Tạo storage link
php artisan storage:link

# Chạy migrations
php artisan migrate:fresh --seed
```

## 🎨 Tính năng nổi bật

### ⭐ Hệ thống Rating động
- Rating được tính toán tự động từ đánh giá thực tế của khách hàng
- Hiển thị thống kê chi tiết với progress bar
- Phần trăm khuyến nghị dựa trên đánh giá 4-5 sao

### 🛒 Giỏ hàng thông minh
- Thêm/sửa/xóa sản phẩm trong giỏ hàng
- Tính toán tổng tiền tự động
- Lưu trữ giỏ hàng theo session

### 📦 Quản lý đơn hàng
- Theo dõi trạng thái đơn hàng
- Quản lý địa chỉ giao hàng
- Lịch sử đơn hàng chi tiết

### 🎨 Giao diện hiện đại
- Bootstrap 5 với thiết kế responsive
- Font Awesome icons
- Gradient và animation đẹp mắt

## 🐛 Troubleshooting

### Lỗi thường gặp

1. **Lỗi "Class not found"**
   ```bash
   composer dump-autoload
   ```

2. **Lỗi permission storage**
   ```bash
   chmod -R 775 storage/
   chmod -R 775 bootstrap/cache/
   ```

3. **Lỗi database connection**
   - Kiểm tra thông tin database trong `.env`
   - Đảm bảo MySQL/MariaDB đang chạy

4. **Lỗi npm install**
   ```bash
   npm cache clean --force
   npm install
   ```
