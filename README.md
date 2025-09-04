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

## 📋 Mô tả dự án

**KitchenHood Pro** là một website thương mại điện tử chuyên về máy hút mùi và thiết bị nhà bếp cao cấp. Dự án được xây dựng bằng Laravel 10 với giao diện hiện đại, responsive và đầy đủ tính năng quản lý.

### ✨ Tính năng chính

- 🛍️ **Quản lý sản phẩm**: Thêm, sửa, xóa sản phẩm với hình ảnh và thông tin chi tiết
- 🛒 **Giỏ hàng thông minh**: Quản lý giỏ hàng với tính năng thêm, sửa, xóa sản phẩm
- 💳 **Hệ thống thanh toán**: Hỗ trợ nhiều phương thức thanh toán
- 📦 **Quản lý đơn hàng**: Theo dõi trạng thái đơn hàng từ đặt hàng đến giao hàng
- ⭐ **Hệ thống đánh giá**: Rating động từ khách hàng với thống kê chi tiết
- 👥 **Quản lý người dùng**: Đăng ký, đăng nhập, xác thực email
- 📰 **Tin tức & Blog**: Hệ thống tin tức với phân loại và tìm kiếm
- 🎨 **Giao diện admin**: Dashboard quản lý với thống kê trực quan
- 📱 **Responsive Design**: Tương thích với mọi thiết bị

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
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### Bước 3: Cấu hình môi trường

```bash
# Copy file môi trường
cp .env.example .env

# Tạo application key
php artisan key:generate
```

### Bước 4: Cấu hình database

1. **Tạo database mới** trong MySQL/MariaDB
2. **Cập nhật thông tin database** trong file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kecommerce2024.sql
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 5: Kết nối csdl
Lấy file sql rồi import vào xampp



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

## 🤝 Đóng góp

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📄 License

Dự án này được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

## 📞 Liên hệ

- **Email**: support@kitchenhood.com
- **Website**: https://kitchenhood.com
- **GitHub**: https://github.com/your-username/kitchenhood-pro

---

<p align="center">
  <strong>Made with ❤️ by KitchenHood Team</strong>
</p>
