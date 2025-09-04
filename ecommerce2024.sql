-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2025 at 03:52 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce2024`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` int(11) NOT NULL,
  `province_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(11) NOT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ward_id` int(11) NOT NULL,
  `ward_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `phone`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `street_address`, `postal_code`, `is_default`, `note`, `created_at`, `updated_at`) VALUES
(2, 2, 'Đào Văn Tâm', '0969859400', 1, 'Thành phố Hà Nội', 21, 'Quận Bắc Từ Liêm', 619, 'Phường Phú Diễn', '10c', '00001', 1, 'ko', '2025-08-28 22:52:36', '2025-08-29 00:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-08-28 22:35:43', '2025-08-28 22:35:43'),
(2, 1, '2025-08-29 00:00:02', '2025-08-29 00:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Máy hút mùi âm tủ', '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(2, 'Máy hút mùi kính cong', '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(3, 'Máy hút mùi đảo bếp', '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(4, 'Máy hút mùi ống khói', '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(5, 'Máy hút mùi mini', '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(6, 'Phụ kiện máy hút mùi', '2025-08-28 22:31:49', '2025-08-28 22:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_01_20_000000_create_orders_table', 1),
(2, '2025_01_20_000001_create_order_items_table', 1),
(3, '2025_08_16_025848_create_categories_table', 1),
(4, '2025_08_16_025850_create_products_table', 1),
(5, '2025_08_16_030206_create_sessions_table', 1),
(6, '2025_08_16_030208_create_cache_table', 1),
(7, '2025_08_16_030210_create_jobs_table', 1),
(8, '2025_08_22_020240_create_users_table', 1),
(9, '2025_08_22_023639_add_image_to_products_table', 1),
(10, '2025_08_23_023253_add_email_verification_to_users_table', 1),
(11, '2025_08_25_000500_create_carts_table', 1),
(12, '2025_08_25_000510_create_cart_items_table', 1),
(13, '2025_08_26_033610_create_news_table', 1),
(14, '2025_08_26_100000_create_product_details_table', 1),
(15, '2025_08_29_020318_create_addresses_table', 1),
(16, '2025_08_29_023433_update_orders_table_structure', 1),
(17, '2025_08_29_023457_update_order_items_table_structure', 1),
(18, '2025_08_29_023648_add_payment_fields_to_orders_table', 1),
(19, '2025_08_29_023721_restructure_orders_table_for_new_schema', 1),
(20, '2025_08_29_024105_update_order_items_table_structure', 1),
(21, '2025_08_29_025529_add_notes_to_orders_table', 1),
(22, '2025_08_29_051950_update_addresses_table_for_api_provinces', 1),
(23, '2025_08_29_052155_update_orders_table_for_user_tracking', 1),
(24, '2025_08_29_052220_create_order_history_table', 1),
(27, '2025_08_29_053959_update_addresses_table_for_api_provinces_new', 2),
(28, '2025_08_29_054031_update_orders_table_for_new_structure', 2),
(29, '2025_09_04_022441_create_reviews_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `category`, `author`, `is_featured`, `is_published`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Xu Hướng Máy Hút Mùi 2025', 'xu-huong-may-hut-mui-2025', 'Khám phá những xu hướng mới nhất trong thiết kế và công nghệ máy hút mùi cho căn bếp hiện đại năm 2025.', '<h2>Xu Hướng Thiết Kế 2025</h2>\r\n<p>Năm 2025 mang đến những xu hướng thiết kế m&aacute;y h&uacute;t m&ugrave;i ho&agrave;n to&agrave;n mới, tập trung v&agrave;o t&iacute;nh thẩm mỹ v&agrave; hiệu quả sử dụng.</p>\r\n<h3>1. Thiết Kế Tối Giản</h3>\r\n<p>Xu hướng thiết kế tối giản tiếp tục thống trị thị trường với những đường n&eacute;t sạch sẽ, m&agrave;u sắc trung t&iacute;nh v&agrave; kiểu d&aacute;ng hiện đại.</p>\r\n<h3>2. C&ocirc;ng Nghệ Th&ocirc;ng Minh</h3>\r\n<p>C&aacute;c d&ograve;ng m&aacute;y h&uacute;t m&ugrave;i mới được t&iacute;ch hợp c&ocirc;ng nghệ IoT, cho ph&eacute;p điều khiển từ xa qua smartphone v&agrave; tự động điều chỉnh tốc độ h&uacute;t.</p>\r\n<h3>3. Tiết Kiệm Năng Lượng</h3>\r\n<p>Với c&ocirc;ng nghệ inverter ti&ecirc;n tiến, m&aacute;y h&uacute;t m&ugrave;i 2025 tiết kiệm điện năng l&ecirc;n đến 40% so với c&aacute;c d&ograve;ng cũ.</p>\r\n<h3>4. Vật Liệu Cao Cấp</h3>\r\n<p>Sử dụng th&eacute;p kh&ocirc;ng gỉ 304, k&iacute;nh cường lực v&agrave; c&aacute;c vật liệu chống b&aacute;m d&iacute;nh gi&uacute;p dễ d&agrave;ng vệ sinh v&agrave; bảo tr&igrave;.</p>', 'news/WkQu7U1dPTc77E45lWFxzIsL0EsQCqUu5bcdX6U4.jpg', 'xu-hướng', 'Admin', 1, 1, 158, '2025-08-28 22:31:56', '2025-08-29 00:10:25'),
(2, 'Cách Bảo Trì Máy Hút Mùi', 'cach-bao-tri-may-hut-mui', 'Hướng dẫn chi tiết cách vệ sinh và bảo trì máy hút mùi để đảm bảo hiệu suất tối ưu và tuổi thọ lâu dài.', '<h2>Hướng Dẫn Bảo Tr&igrave; M&aacute;y H&uacute;t M&ugrave;i</h2>\r\n<p>Việc bảo tr&igrave; định kỳ m&aacute;y h&uacute;t m&ugrave;i kh&ocirc;ng chỉ gi&uacute;p tăng tuổi thọ sản phẩm m&agrave; c&ograve;n đảm bảo hiệu suất hoạt động tối ưu.</p>\r\n<h3>1. Vệ Sinh Bộ Lọc</h3>\r\n<p><strong>Tần suất:</strong> Mỗi th&aacute;ng 1 lần</p>\r\n<ul>\r\n<li>Th&aacute;o bộ lọc khỏi m&aacute;y</li>\r\n<li>Ng&acirc;m trong nước ấm với x&agrave; ph&ograve;ng</li>\r\n<li>Chải nhẹ bằng b&agrave;n chải mềm</li>\r\n<li>Rửa sạch v&agrave; để kh&ocirc; ho&agrave;n to&agrave;n</li>\r\n</ul>\r\n<h3>2. Vệ Sinh Th&acirc;n M&aacute;y</h3>\r\n<p><strong>Tần suất:</strong> Mỗi tuần 1 lần</p>\r\n<ul>\r\n<li>D&ugrave;ng khăn ẩm lau bề mặt ngo&agrave;i</li>\r\n<li>Tr&aacute;nh sử dụng h&oacute;a chất mạnh</li>\r\n<li>Lau kh&ocirc; bằng khăn mềm</li>\r\n</ul>\r\n<h3>3. Kiểm Tra Định Kỳ</h3>\r\n<p><strong>Tần suất:</strong> Mỗi 6 th&aacute;ng</p>\r\n<ul>\r\n<li>Kiểm tra d&acirc;y điện v&agrave; ổ cắm</li>\r\n<li>L&agrave;m sạch quạt gi&oacute;</li>\r\n<li>Kiểm tra độ rung v&agrave; tiếng ồn</li>\r\n</ul>', 'news/nYcelZdFgtf8UjGPbyCfyZ5ZPNfg9vos2kjiiN43.jpg', 'hướng-dẫn', 'Admin', 1, 1, 91, '2025-08-28 22:31:56', '2025-09-03 20:24:56'),
(3, 'Khuyến Mãi Tết Nguyên Đán', 'khuyen-mai-tet-nguyen-dan', 'Chương trình khuyến mãi đặc biệt nhân dịp Tết Nguyên Đán với nhiều ưu đãi hấp dẫn cho khách hàng.', '<h2>Chương Tr&igrave;nh Khuyến M&atilde;i Tết 2025</h2>\r\n<p>Nh&acirc;n dịp Tết Nguy&ecirc;n Đ&aacute;n, KitchenHood Pro mang đến chương tr&igrave;nh khuyến m&atilde;i đặc biệt với nhiều ưu đ&atilde;i hấp dẫn.</p>\r\n<h3>🎉 Ưu Đ&atilde;i Đặc Biệt</h3>\r\n<ul>\r\n<li><strong>Giảm gi&aacute; 30%</strong> cho tất cả sản phẩm m&aacute;y h&uacute;t m&ugrave;i</li>\r\n<li><strong>Miễn ph&iacute; vận chuyển</strong> to&agrave;n quốc</li>\r\n<li><strong>Tặng k&egrave;m bộ lọc</strong> trị gi&aacute; 500.000 VNĐ</li>\r\n<li><strong>Bảo h&agrave;nh mở rộng</strong> l&ecirc;n 7 năm</li>\r\n</ul>\r\n<h3>📅 Thời Gian &Aacute;p Dụng</h3>\r\n<p><strong>Từ ng&agrave;y:</strong> 15/01/2025<br><strong>Đến ng&agrave;y:</strong> 15/02/2025</p>\r\n<h3>🎁 Qu&agrave; Tặng Đặc Biệt</h3>\r\n<p>Kh&aacute;ch h&agrave;ng mua từ 2 sản phẩm trở l&ecirc;n sẽ được tặng th&ecirc;m:</p>\r\n<ul>\r\n<li>Bộ dụng cụ vệ sinh chuy&ecirc;n dụng</li>\r\n<li>G&oacute;i bảo tr&igrave; miễn ph&iacute; 1 năm</li>\r\n<li>Hướng dẫn sử dụng chi tiết</li>\r\n</ul>\r\n<h3>📞 Li&ecirc;n Hệ Ngay</h3>\r\n<p>Để được tư vấn v&agrave; đặt h&agrave;ng, vui l&ograve;ng li&ecirc;n hệ:</p>\r\n<ul>\r\n<li><strong>Hotline:</strong> 1900 1234</li>\r\n<li><strong>Email:</strong> sales@kitchenhoodpro.com</li>\r\n<li><strong>Website:</strong> www.kitchenhoodpro.com</li>\r\n</ul>', 'news/wXcFS1SowXTYEHp6gP2AAycKDs8rePhkZPnkA2ol.png', 'khuyến-mãi', 'Admin', 1, 1, 236, '2025-08-28 22:31:56', '2025-09-03 20:31:52'),
(4, 'Công Nghệ Lọc Không Khí Mới', 'cong-nghe-loc-khong-khi-moi', 'Khám phá công nghệ lọc không khí tiên tiến mới nhất được tích hợp trong các dòng máy hút mùi cao cấp hiện nay.', '<h2>C&ocirc;ng Nghệ Lọc Kh&ocirc;ng Kh&iacute; Ti&ecirc;n Tiến</h2>\r\n<p>C&ocirc;ng nghệ lọc kh&ocirc;ng kh&iacute; trong m&aacute;y h&uacute;t m&ugrave;i đ&atilde; c&oacute; những bước tiến vượt bậc, mang lại hiệu quả lọc sạch tối ưu.</p>\r\n<h3>1. Bộ Lọc HEPA</h3>\r\n<p>Bộ lọc HEPA (High Efficiency Particulate Air) c&oacute; khả năng lọc 99.97% c&aacute;c hạt bụi c&oacute; k&iacute;ch thước từ 0.3 micron trở l&ecirc;n.</p>\r\n<h3>2. C&ocirc;ng Nghệ Ion &Acirc;m</h3>\r\n<p>Ion &acirc;m gi&uacute;p trung h&ograve;a c&aacute;c chất độc hại trong kh&ocirc;ng kh&iacute;, tạo ra m&ocirc;i trường trong l&agrave;nh v&agrave; an to&agrave;n cho sức khỏe.</p>\r\n<h3>3. Bộ Lọc Than Hoạt T&iacute;nh</h3>\r\n<p>Than hoạt t&iacute;nh c&oacute; khả năng hấp thụ m&ugrave;i h&ocirc;i v&agrave; c&aacute;c chất hữu cơ bay hơi (VOC) hiệu quả.</p>\r\n<h3>4. C&ocirc;ng Nghệ UV-C</h3>\r\n<p>Tia UV-C c&oacute; khả năng ti&ecirc;u diệt vi khuẩn, virus v&agrave; nấm mốc, đảm bảo kh&ocirc;ng kh&iacute; sạch khuẩn.</p>\r\n<h3>5. Bộ Lọc Nano Silver</h3>\r\n<p>Nano Silver c&oacute; t&iacute;nh kh&aacute;ng khuẩn tự nhi&ecirc;n, gi&uacute;p ngăn chặn sự ph&aacute;t triển của vi khuẩn tr&ecirc;n bề mặt lọc.</p>', 'news/7Qdq6vOO1tM0aklLSXWSqFc9E0MPVIu0iESdkQJx.jpg', 'công-nghệ', 'Admin', 0, 1, 67, '2025-08-28 22:31:56', '2025-08-29 00:10:02'),
(5, 'Thiết Kế Nhà Bếp Hiện Đại', 'thiet-ke-nha-bep-hien-dai', 'Những xu hướng thiết kế nhà bếp hiện đại kết hợp với máy hút mùi để tạo nên không gian bếp hoàn hảo và tiện nghi.', '<h2>Xu Hướng Thiết Kế Nh&agrave; Bếp 2025</h2>\r\n<p>Thiết kế nh&agrave; bếp hiện đại kh&ocirc;ng chỉ đẹp mắt m&agrave; c&ograve;n phải thực dụng v&agrave; tiện nghi cho cuộc sống h&agrave;ng ng&agrave;y.</p>\r\n<h3>1. Phong C&aacute;ch Tối Giản</h3>\r\n<p>Thiết kế tối giản với đường n&eacute;t sạch sẽ, m&agrave;u sắc trung t&iacute;nh v&agrave; kh&ocirc;ng gian mở tạo cảm gi&aacute;c thoải m&aacute;i.</p>\r\n<h3>2. T&iacute;ch Hợp C&ocirc;ng Nghệ Th&ocirc;ng Minh</h3>\r\n<p>M&aacute;y h&uacute;t m&ugrave;i th&ocirc;ng minh được t&iacute;ch hợp v&agrave;o thiết kế tổng thể, c&oacute; thể điều khiển qua app hoặc giọng n&oacute;i.</p>\r\n<h3>3. Vật Liệu Cao Cấp</h3>\r\n<p>Sử dụng đ&aacute; granite, th&eacute;p kh&ocirc;ng gỉ v&agrave; gỗ tự nhi&ecirc;n tạo n&ecirc;n vẻ sang trọng v&agrave; bền bỉ.</p>\r\n<h3>4. &Aacute;nh S&aacute;ng Tự Nhi&ecirc;n</h3>\r\n<p>Thiết kế cửa sổ lớn v&agrave; &aacute;nh s&aacute;ng LED gi&uacute;p kh&ocirc;ng gian bếp s&aacute;ng sủa v&agrave; tiết kiệm năng lượng.</p>\r\n<h3>5. Khu Vực Lưu Trữ Th&ocirc;ng Minh</h3>\r\n<p>Hệ thống tủ k&eacute;o hiện đại với ngăn k&eacute;o s&acirc;u v&agrave; kệ xoay gi&uacute;p tối ưu kh&ocirc;ng gian lưu trữ.</p>', 'news/aDYsfgfMIla9pyEqkJLuOx6exShqCaAHvhCj9PHe.jpg', 'thiết-kế', 'Admin', 0, 1, 45, '2025-08-28 22:31:56', '2025-08-29 00:10:10'),
(6, 'Máy Hút Mùi Tiết Kiệm Điện', 'may-hut-mui-tiet-kiem-dien', 'Cách chọn và sử dụng máy hút mùi để tiết kiệm điện năng hiệu quả mà vẫn đảm bảo hiệu suất hoạt động tối ưu.', '<h2>Tiết Kiệm Điện Với M&aacute;y H&uacute;t M&ugrave;i</h2>\r\n<p>Việc sử dụng m&aacute;y h&uacute;t m&ugrave;i hiệu quả kh&ocirc;ng chỉ gi&uacute;p tiết kiệm điện m&agrave; c&ograve;n bảo vệ m&ocirc;i trường.</p>\r\n<h3>1. Chọn C&ocirc;ng Suất Ph&ugrave; Hợp</h3>\r\n<p>Kh&ocirc;ng phải c&ocirc;ng suất cao lu&ocirc;n tốt. Chọn c&ocirc;ng suất ph&ugrave; hợp với k&iacute;ch thước bếp để tiết kiệm điện.</p>\r\n<h3>2. Sử Dụng C&ocirc;ng Nghệ Inverter</h3>\r\n<p>M&aacute;y h&uacute;t m&ugrave;i với c&ocirc;ng nghệ Inverter tiết kiệm điện l&ecirc;n đến 40% so với m&aacute;y th&ocirc;ng thường.</p>\r\n<h3>3. Điều Chỉnh Tốc Độ Hợp L&yacute;</h3>\r\n<p>Chỉ sử dụng tốc độ cao khi cần thiết, thường xuy&ecirc;n sử dụng tốc độ thấp v&agrave; trung b&igrave;nh.</p>\r\n<h3>4. Vệ Sinh Định Kỳ</h3>\r\n<p>Bộ lọc bẩn l&agrave;m tăng ti&ecirc;u thụ điện. Vệ sinh định kỳ gi&uacute;p m&aacute;y hoạt động hiệu quả hơn.</p>\r\n<h3>5. Tắt M&aacute;y Khi Kh&ocirc;ng Sử Dụng</h3>\r\n<p>Lu&ocirc;n tắt m&aacute;y h&uacute;t m&ugrave;i khi kh&ocirc;ng nấu ăn để tiết kiệm điện năng.</p>\r\n<h3>6. Sử Dụng Đ&egrave;n LED</h3>\r\n<p>Chọn m&aacute;y h&uacute;t m&ugrave;i c&oacute; đ&egrave;n LED thay v&igrave; đ&egrave;n halogen để tiết kiệm điện.</p>', 'news/jOnAp8iSw4XxwWCLxRkktwlevq9NJXbZ2ZMygGVX.png', 'tiết-kiệm', 'Admin', 0, 1, 78, '2025-08-28 22:31:56', '2025-08-29 00:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `payment_method` enum('cod','bank_transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_province_id` int(11) NOT NULL,
  `shipping_province_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_district_id` int(11) NOT NULL,
  `shipping_district_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_ward_id` int(11) NOT NULL,
  `shipping_ward_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `rating` int(11) DEFAULT NULL,
  `review_comment` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` bigint(20) NOT NULL,
  `shipping_fee` bigint(20) NOT NULL,
  `discount_amount` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `subtotal`, `payment_method`, `payment_status`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_province_id`, `shipping_province_name`, `shipping_district_id`, `shipping_district_name`, `shipping_ward_id`, `shipping_ward_name`, `notes`, `rating`, `review_comment`, `reviewed_at`, `status`, `total_amount`, `shipping_fee`, `discount_amount`, `created_at`, `updated_at`) VALUES
(1, 2, 'ORD-20250904-68B9007ED2BA4', 8500000, 'cod', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Phú Diễn, Quận Bắc Từ Liêm, Thành phố Hà Nội', 1, 'Thành phố Hà Nội', 21, 'Quận Bắc Từ Liêm', 619, 'Phường Phú Diễn', 'ok', NULL, NULL, NULL, 'delivered', 8500000, 0, 0, '2025-09-03 19:59:10', '2025-09-03 20:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-03 19:59:10', '2025-09-03 19:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `features` json DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `image2`, `image3`, `quantity`, `price`, `features`, `category_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 'Máy hút mùi âm tủ cao cấp của Bosch với công suất 650m³/h, thiết kế hiện đại, tích hợp đèn LED, 3 tốc độ hút và bộ lọc than hoạt tính.', 'products/ifePMkhH7LcoPXjPY4gMYZKkmZiUpOPCLzh03UTv.jpg', NULL, NULL, 15, 8500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"650m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-28 22:31:49', '2025-08-28 23:59:34'),
(2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 'Máy hút mùi âm tủ Electrolux với thiết kế tối giản, công suất 600m³/h, bộ lọc 3 lớp hiệu quả, điều khiển cảm ứng và đèn LED chiếu sáng.', 'products/APi0bC8uyN7UmTcXAtnwbbzFdyXzkWjK7xNnxlM9.jpg', NULL, NULL, 12, 7200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"600m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"62dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-28 22:31:49', '2025-08-28 23:59:46'),
(3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 'Máy hút mùi âm tủ Samsung với công nghệ Cyclone Force, công suất 550m³/h, bộ lọc thông minh và thiết kế phù hợp với mọi không gian bếp.', 'products/eBHrh91cP8KUioJQBmDtR4moLUxQMvkfvGrLzAhE.jpg', NULL, NULL, 18, 6800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"550m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"64dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-28 22:31:49', '2025-08-28 23:59:56'),
(4, 'Máy hút mùi kính cong Bosch DWF97CR50', 'Máy hút mùi kính cong Bosch với thiết kế kính cong hiện đại, công suất 700m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', NULL, NULL, NULL, 10, 9200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"700m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"63dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 'Máy hút mùi kính cong Electrolux với thiết kế kính cong 90 độ, công suất 650m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', NULL, NULL, NULL, 14, 7800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"650m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"61dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(6, 'Máy hút mùi kính cong Samsung NK36M5070DS', 'Máy hút mùi kính cong Samsung với công nghệ Cyclone Force, công suất 600m³/h, bộ lọc thông minh và thiết kế kính cong hiện đại.', NULL, NULL, NULL, 16, 7500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"600m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"62dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(7, 'Máy hút mùi đảo bếp Bosch DWF97CR50', 'Máy hút mùi đảo bếp Bosch với thiết kế đảo bếp hiện đại, công suất 800m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', NULL, NULL, NULL, 8, 11500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"800m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(8, 'Máy hút mùi đảo bếp Electrolux LFC97CR50', 'Máy hút mùi đảo bếp Electrolux với thiết kế đảo bếp sang trọng, công suất 750m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', NULL, NULL, NULL, 12, 9800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"750m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"63dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(9, 'Máy hút mùi đảo bếp Samsung NK36M5070DS', 'Máy hút mùi đảo bếp Samsung với công nghệ Cyclone Force, công suất 700m³/h, bộ lọc thông minh và thiết kế đảo bếp hiện đại.', NULL, NULL, NULL, 15, 9200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"700m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"64dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(10, 'Máy hút mùi ống khói Bosch DWF97CR50', 'Máy hút mùi ống khói Bosch với thiết kế ống khói hiện đại, công suất 900m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', NULL, NULL, NULL, 6, 13500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"900m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"5 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"67dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(11, 'Máy hút mùi ống khói Electrolux LFC97CR50', 'Máy hút mùi ống khói Electrolux với thiết kế ống khói sang trọng, công suất 850m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', NULL, NULL, NULL, 8, 11800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"850m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"5 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 'Máy hút mùi ống khói Samsung với công nghệ Cyclone Force, công suất 800m³/h, bộ lọc thông minh và thiết kế ống khói hiện đại.', NULL, NULL, NULL, 10, 11200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"800m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"66dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(13, 'Máy hút mùi mini Bosch DWF97CR50', 'Máy hút mùi mini Bosch với thiết kế nhỏ gọn, công suất 300m³/h, bộ lọc than hoạt tính và điều khiển cơ đơn giản.', NULL, NULL, NULL, 25, 2800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"300m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"58dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(14, 'Máy hút mùi mini Electrolux LFC97CR50', 'Máy hút mùi mini Electrolux với thiết kế nhỏ gọn, công suất 280m³/h, bộ lọc 2 lớp và đèn LED chiếu sáng.', NULL, NULL, NULL, 30, 2500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"280m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"56dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(15, 'Máy hút mùi mini Samsung NK36M5070DS', 'Máy hút mùi mini Samsung với công nghệ Cyclone Force, công suất 320m³/h, bộ lọc thông minh và thiết kế nhỏ gọn.', NULL, NULL, NULL, 28, 3200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"320m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"57dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(16, 'Bộ lọc than hoạt tính cho máy hút mùi', 'Bộ lọc than hoạt tính chất lượng cao, giúp loại bỏ mùi hôi và khói bếp hiệu quả. Phù hợp với hầu hết các loại máy hút mùi.', NULL, NULL, NULL, 100, 150000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Than hoạt tính cao cấp\"}, {\"key\": \"Kích thước\", \"value\": \"Phù hợp đa số máy hút mùi\"}, {\"key\": \"Tuổi thọ\", \"value\": \"6-12 tháng\"}, {\"key\": \"Hiệu quả\", \"value\": \"Loại bỏ 99% mùi hôi\"}, {\"key\": \"Bảo hành\", \"value\": \"3 tháng\"}]', 6, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(17, 'Bộ lọc dầu mỡ cho máy hút mùi', 'Bộ lọc dầu mỡ chuyên dụng, giúp bảo vệ động cơ máy hút mùi khỏi dầu mỡ và bụi bẩn. Dễ dàng thay thế và vệ sinh.', NULL, NULL, NULL, 80, 120000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Vải lọc chống dầu mỡ\"}, {\"key\": \"Kích thước\", \"value\": \"Phù hợp đa số máy hút mùi\"}, {\"key\": \"Tuổi thọ\", \"value\": \"3-6 tháng\"}, {\"key\": \"Hiệu quả\", \"value\": \"Lọc 95% dầu mỡ\"}, {\"key\": \"Bảo hành\", \"value\": \"3 tháng\"}]', 6, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(18, 'Ống thông gió mềm cho máy hút mùi', 'Ống thông gió mềm chất lượng cao, dễ dàng uốn cong và lắp đặt. Giúp thông gió hiệu quả cho máy hút mùi.', NULL, NULL, NULL, 60, 180000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Nhôm mềm cao cấp\"}, {\"key\": \"Đường kính\", \"value\": \"150mm\"}, {\"key\": \"Chiều dài\", \"value\": \"2m\"}, {\"key\": \"Độ bền\", \"value\": \"Chống ăn mòn\"}, {\"key\": \"Bảo hành\", \"value\": \"6 tháng\"}]', 6, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(19, 'Van một chiều cho máy hút mùi', 'Van một chiều chống ngược gió, giúp bảo vệ máy hút mùi khỏi gió ngược và côn trùng. Dễ dàng lắp đặt và bảo trì.', NULL, NULL, NULL, 45, 220000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Nhựa ABS cao cấp\"}, {\"key\": \"Đường kính\", \"value\": \"150mm\"}, {\"key\": \"Chức năng\", \"value\": \"Chống ngược gió\"}, {\"key\": \"Độ bền\", \"value\": \"Chống ăn mòn\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 6, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(20, 'Bộ điều khiển cảm ứng cho máy hút mùi', 'Bộ điều khiển cảm ứng hiện đại, giúp điều khiển máy hút mùi một cách dễ dàng và chính xác. Tương thích với nhiều loại máy.', NULL, NULL, NULL, 35, 350000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Kính cường lực\"}, {\"key\": \"Chức năng\", \"value\": \"Điều khiển cảm ứng\"}, {\"key\": \"Tương thích\", \"value\": \"Đa dạng máy hút mùi\"}, {\"key\": \"Độ bền\", \"value\": \"Chống trầy xước\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 6, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `specs` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 5, 'máy như cặc', '2025-09-03 20:04:57', '2025-09-03 20:04:57'),
(2, 1, 1, 5, 'Sản phẩm rất tốt, chất lượng cao! Máy hút mùi hoạt động hiệu quả, thiết kế đẹp và dễ sử dụng.', '2025-09-03 20:34:49', '2025-09-03 20:34:49'),
(3, 2, 1, 4, 'Sản phẩm tốt, giá cả hợp lý. Công suất hút mùi khá tốt, phù hợp với gia đình.', '2025-09-03 20:34:49', '2025-09-03 20:34:49'),
(4, 1, 1, 5, 'Tuyệt vời! Đã sử dụng được 6 tháng, không có vấn đề gì. Âm thanh hoạt động êm ái.', '2025-09-03 20:34:49', '2025-09-03 20:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `email_verified_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$6UgtI5Q3X6jdfF87IJw92OZ6cfPntZ9En6LJI/ZlSj2VGPh8upwHu', 'admin', NULL, '2025-08-28 22:31:49', '2025-08-28 22:31:49', '2025-08-29 06:58:17'),
(2, 'Tâm', 'vantamst97@gmail.com', '$2y$12$/5wZ2Z4eXH.Qi99fn.hjtux2ohCs/PbzSh3NDTZNASlEffaMWvrfe', 'customer', NULL, '2025-08-28 22:34:58', '2025-08-28 22:34:58', '2025-08-29 06:58:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_is_default_index` (`user_id`,`is_default`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
