# 📋 Hướng dẫn cài đặt chi tiết - KitchenHood Pro

## 🎯 Mục tiêu
Hướng dẫn chi tiết từng bước để cài đặt và chạy dự án KitchenHood Pro trên máy local.

## ⚠️ Lưu ý quan trọng
- **Đảm bảo đã cài đặt đầy đủ các yêu cầu hệ thống trước khi bắt đầu**
- **Chạy các lệnh theo đúng thứ tự để tránh lỗi**
- **Nếu gặp lỗi, hãy kiểm tra phần Troubleshooting ở cuối**

---

## 🛠️ Bước 1: Kiểm tra yêu cầu hệ thống

### Kiểm tra PHP
```bash
php --version
# Kết quả mong đợi: PHP 8.1.x hoặc cao hơn
```

### Kiểm tra Composer
```bash
composer --version
# Kết quả mong đợi: Composer version 2.x.x
```

### Kiểm tra Node.js
```bash
node --version
# Kết quả mong đợi: v16.x.x hoặc cao hơn
```

### Kiểm tra NPM
```bash
npm --version
# Kết quả mong đợi: 8.x.x hoặc cao hơn
```

### Kiểm tra MySQL/MariaDB
```bash
mysql --version
# Kết quả mong đợi: MySQL 8.x.x hoặc MariaDB 10.5.x
```

---

## 🚀 Bước 2: Clone và cài đặt dự án

### 2.1 Clone repository
```bash
# Clone dự án về máy local
git clone https://github.com/your-username/kitchenhood-pro.git

# Di chuyển vào thư mục dự án
cd kitchenhood-pro

# Kiểm tra đã vào đúng thư mục
ls -la
# Nên thấy các file: composer.json, package.json, artisan, etc.
```

### 2.2 Cài đặt PHP dependencies
```bash
# Cài đặt các package PHP cần thiết
composer install

# Nếu gặp lỗi memory limit, chạy:
composer install --ignore-platform-reqs
```

### 2.3 Cài đặt Node.js dependencies
```bash
# Cài đặt các package Node.js
npm install

# Nếu gặp lỗi, thử:
npm cache clean --force
npm install
```

---

## ⚙️ Bước 3: Cấu hình môi trường

### 3.1 Tạo file môi trường
```bash
# Copy file môi trường mẫu
cp .env.example .env

# Tạo application key
php artisan key:generate
```

### 3.2 Cấu hình database
1. **Tạo database mới** trong MySQL/MariaDB:
```sql
CREATE DATABASE kitchenhood_pro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Cập nhật file `.env`** với thông tin database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kitchenhood_pro
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3.3 Cấu hình mail (tùy chọn)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🗄️ Bước 4: Thiết lập database

### 4.1 Chạy migrations
```bash
# Tạo các bảng trong database
php artisan migrate

# Nếu gặp lỗi, thử:
php artisan migrate:fresh
```

### 4.2 Tạo dữ liệu mẫu
```bash
# Tạo dữ liệu cơ bản (admin, categories, products)
php artisan db:seed

# Tạo dữ liệu đánh giá mẫu
php artisan db:seed --class=ReviewSeeder
```

### 4.3 Kiểm tra dữ liệu
```bash
# Test rating system
php artisan test:rating
```

---

## 📁 Bước 5: Thiết lập storage

### 5.1 Tạo storage link
```bash
# Tạo symbolic link cho storage
php artisan storage:link
```

### 5.2 Cấu hình permissions (Linux/Mac)
```bash
# Cấp quyền cho storage và cache
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 🎨 Bước 6: Build assets

### 6.1 Build cho development
```bash
# Chạy development server cho assets
npm run dev
```

### 6.2 Build cho production
```bash
# Build CSS và JS cho production
npm run build
```

---

## 🌐 Bước 7: Khởi chạy server

### 7.1 Chạy Laravel server
```bash
# Khởi chạy development server
php artisan serve
```

### 7.2 Truy cập website
Mở trình duyệt và truy cập: **http://localhost:8000**

---

## 👤 Bước 8: Đăng nhập và kiểm tra

### 8.1 Tài khoản Admin
- **URL**: http://localhost:8000/login
- **Email**: admin@kitchenhood.com
- **Password**: password

### 8.2 Tài khoản User
- **Email**: user@example.com
- **Password**: password

### 8.3 Kiểm tra các tính năng
- ✅ Trang chủ hiển thị sản phẩm
- ✅ Rating system hoạt động
- ✅ Admin panel có thể truy cập
- ✅ Giỏ hàng hoạt động
- ✅ Đăng ký/đăng nhập

---

## 🔧 Troubleshooting

### Lỗi thường gặp và cách khắc phục

#### 1. Lỗi "Class not found"
```bash
composer dump-autoload
```

#### 2. Lỗi "No application encryption key"
```bash
php artisan key:generate
```

#### 3. Lỗi database connection
- Kiểm tra MySQL/MariaDB đang chạy
- Kiểm tra thông tin trong `.env`
- Thử kết nối trực tiếp: `mysql -u root -p`

#### 4. Lỗi permission storage
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

#### 5. Lỗi npm install
```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

#### 6. Lỗi "Vite manifest not found"
```bash
npm run build
```

#### 7. Lỗi "Migration table not found"
```bash
php artisan migrate:fresh
```

#### 8. Lỗi "Storage link already exists"
```bash
rm public/storage
php artisan storage:link
```

---

## 📋 Checklist hoàn thành

- [ ] Clone repository thành công
- [ ] Cài đặt composer dependencies
- [ ] Cài đặt npm dependencies
- [ ] Tạo file .env và application key
- [ ] Cấu hình database
- [ ] Chạy migrations thành công
- [ ] Chạy seeders thành công
- [ ] Tạo storage link
- [ ] Build assets thành công
- [ ] Khởi chạy server
- [ ] Truy cập được trang chủ
- [ ] Đăng nhập được admin panel
- [ ] Rating system hoạt động

---

## 🆘 Hỗ trợ

Nếu gặp vấn đề không thể tự khắc phục:

1. **Kiểm tra logs**: `tail -f storage/logs/laravel.log`
2. **Tạo issue** trên GitHub với thông tin lỗi chi tiết
3. **Liên hệ**: support@kitchenhood.com

---

**🎉 Chúc mừng! Bạn đã cài đặt thành công KitchenHood Pro!**
