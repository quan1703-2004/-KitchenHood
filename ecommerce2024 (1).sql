-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 06, 2025 at 04:35 PM
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
(2, 2, 'Đào Văn Tâm', '0969859400', 1, 'Thành phố Hà Nội', 21, 'Quận Bắc Từ Liêm', 619, 'Phường Phú Diễn', '10c', '00001', 1, 'ko', '2025-08-28 22:52:36', '2025-08-29 00:05:41'),
(3, 7, 'Đào Văn Tâm', '0969859400', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', '10c', NULL, 1, NULL, '2025-09-18 01:11:32', '2025-09-18 01:11:32'),
(4, 1, 'Đào Văn Tâm', '0969859400', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', '10c', NULL, 1, NULL, '2025-09-18 10:33:38', '2025-09-18 10:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(2, 3, 1, 'Máy hút mùi hoạt động ở mức độ ồn khoảng 45–65 dB (tương đương tiếng nói chuyện bình thường). Với model này, độ ồn tối đa là 55 dB nên khá êm, không ảnh hưởng nhiều khi nấu ăn.', '2025-09-23 23:25:11', '2025-09-23 23:25:11'),
(3, 4, 1, 'Model Teka này có công suất hút 700 m³/h, phù hợp cho gian bếp từ 15–25m². Với bếp 20m² của bạn thì hoàn toàn đáp ứng tốt.', '2025-09-23 23:25:42', '2025-09-23 23:25:42'),
(4, 5, 1, 'Bạn có thể tìm sản phẩm tại danh mục Máy hút mùi → Âm tủ trên website. Đây là dòng máy nhỏ gọn, lắp gọn trong tủ bếp.', '2025-09-23 23:25:57', '2025-09-23 23:25:57'),
(5, 5, 1, 'Tất cả máy hút mùi Sunhouse được bảo hành chính hãng 2 năm cho motor. Ngoài ra, shop hỗ trợ bảo hành điện tử, chỉ cần cung cấp số điện thoại khi cần.', '2025-09-23 23:26:08', '2025-09-23 23:26:08'),
(6, 7, 1, '“Chúng tôi hỗ trợ giao hàng và lắp đặt tận nhà tại Hà Nội và TP.HCM miễn phí. Các tỉnh khác sẽ tính thêm phí lắp đặt từ 150.000đ tùy khu vực.', '2025-09-23 23:26:20', '2025-09-23 23:26:20'),
(7, 6, 1, 'Tất cả máy hút mùi Sunhouse được bảo hành chính hãng 2 năm cho motor. Ngoài ra, shop hỗ trợ bảo hành điện tử, chỉ cần cung cấp số điện thoại khi cần', '2025-09-23 23:26:34', '2025-09-23 23:26:34'),
(8, 8, 1, 'Shop có hỗ trợ trả góp 0% qua thẻ tín dụng của các ngân hàng: Vietcombank, BIDV, VPBank, Techcombank… với đơn hàng từ 3 triệu trở lên', '2025-09-23 23:27:16', '2025-09-23 23:27:16'),
(9, 9, 1, 'Nếu sản phẩm bị lỗi hoặc hư hỏng do vận chuyển, bạn được đổi mới trong vòng 7 ngày kể từ khi nhận hàng. Vui lòng giữ nguyên hộp và phụ kiện để được hỗ trợ nhanh chóng.', '2025-09-23 23:27:56', '2025-09-23 23:27:56'),
(10, 10, 1, 'Máy hút mùi than hoạt tính không cần ống thoát khí ra ngoài. Bạn chỉ cần thay lõi than sau 6–12 tháng để đảm bảo hiệu quả khử mùi.', '2025-09-23 23:28:07', '2025-09-23 23:28:07'),
(11, 11, 1, 'Máy hút mùi có công suất 200W, nếu hoạt động 1 giờ sẽ tiêu thụ khoảng 0.2 kWh điện. Trung bình sử dụng 1–2 giờ/ngày thì chi phí điện không đáng kể (chưa tới 50.000đ/tháng).', '2025-09-23 23:28:18', '2025-09-23 23:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-forgot-password:tamblvp@gmail.com', 'b:1;', 1759770248);

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
(2, 1, '2025-08-29 00:00:02', '2025-08-29 00:00:02'),
(7, 7, '2025-09-18 01:10:15', '2025-09-18 01:10:15'),
(12, 12, '2025-09-23 22:56:02', '2025-09-23 22:56:02'),
(13, 13, '2025-09-23 23:20:29', '2025-09-23 23:20:29');

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

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 2, 1, 1, '2025-10-03 18:44:13', '2025-10-03 18:44:13');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_visible`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Chính sách vận chuyển như thế nào?', '<p>Chúng tôi <strong>miễn phí vận chuyển toàn quốc</strong> cho đơn hàng từ 5.000.000 VNĐ. Thời gian giao hàng dự kiến từ 2-5 ngày làm việc tùy khu vực.</p>', 1, 1, '2025-09-15 23:09:39', '2025-09-15 23:09:39'),
(2, 'Sản phẩm được bảo hành bao lâu?', '<p>Tất cả máy hút mùi đều được <strong>bảo hành 5 năm chính hãng</strong>. Vui lòng giữ hóa đơn/phiếu bảo hành để được hỗ trợ tốt nhất.</p>', 1, 2, '2025-09-15 23:09:39', '2025-09-15 23:09:39'),
(3, 'Làm sao để vệ sinh máy hút mùi đúng cách?', '<p>Vệ sinh lưới lọc 2 tuần/lần bằng nước ấm và xà phòng. Với máy dùng than hoạt tính, <strong>thay than lọc sau 6-12 tháng</strong> tùy mức sử dụng.</p>', 1, 3, '2025-09-15 23:09:39', '2025-09-15 23:09:39'),
(4, 'Có hỗ trợ lắp đặt tại nhà không?', '<p>Chúng tôi có <strong>dịch vụ lắp đặt tận nơi</strong> cho khách hàng tại các thành phố lớn. Phí lắp đặt được thông báo trước khi tiến hành.</p>', 1, 4, '2025-09-15 23:09:39', '2025-09-15 23:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(19, 1, 1, '2025-10-03 18:40:21', '2025-10-03 18:40:21'),
(23, 7, 1, '2025-10-06 05:10:37', '2025-10-06 05:10:37'),
(31, 7, 2, '2025-10-06 05:16:32', '2025-10-06 05:16:32'),
(32, 7, 6, '2025-10-06 05:16:36', '2025-10-06 05:16:36'),
(33, 7, 5, '2025-10-06 05:16:50', '2025-10-06 05:16:50'),
(35, 2, 3, '2025-10-06 06:18:59', '2025-10-06 06:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_before` int(11) NOT NULL,
  `quantity_after` int(11) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_transactions`
--

INSERT INTO `inventory_transactions` (`id`, `product_id`, `type`, `quantity`, `quantity_before`, `quantity_after`, `notes`, `user_id`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 3, 'out', 1, 18, 17, 'Đặt hàng #ORD-20250918-68CC42D730C81', 1, 9, '2025-09-18 10:35:19', '2025-09-18 10:35:19'),
(2, 2, 'out', 1, 12, 11, 'Đặt hàng #ORD-20250919-68CCC214A4549', 7, NULL, '2025-09-18 19:38:12', '2025-09-18 19:38:12'),
(3, 1, 'out', 2, 15, 13, 'Đặt hàng #ORD-20250919-68CCC87802977', 1, 11, '2025-09-18 20:05:28', '2025-09-18 20:05:28'),
(4, 2, 'out', 1, 11, 10, 'Đặt hàng #ORD-20250919-68CCC9217C02A', 1, 12, '2025-09-18 20:08:17', '2025-09-18 20:08:17'),
(5, 11, 'out', 1, 8, 7, 'Đặt hàng #ORD-20250919-68CCCA27BDD2C', 1, 13, '2025-09-18 20:12:39', '2025-09-18 20:12:39'),
(6, 17, 'out', 1, 80, 79, 'Đặt hàng #ORD-20250919-68CCCA27BDD2C', 1, 13, '2025-09-18 20:12:39', '2025-09-18 20:12:39'),
(7, 11, 'out', 1, 7, 6, 'Xuất hàng cho đơn hàng #ORD-20250919-68CCCA27BDD2C', 1, 13, '2025-09-18 20:13:00', '2025-09-18 20:13:00'),
(8, 17, 'out', 1, 79, 78, 'Xuất hàng cho đơn hàng #ORD-20250919-68CCCA27BDD2C', 1, 13, '2025-09-18 20:13:00', '2025-09-18 20:13:00'),
(9, 2, 'out', 2, 10, 8, 'Đặt hàng #ORD-20250920-68CE0ED7574EA', 7, NULL, '2025-09-19 19:17:59', '2025-09-19 19:17:59'),
(10, 3, 'out', 1, 17, 16, 'Đặt hàng #ORD-20250920-68CE0ED7574EA', 7, NULL, '2025-09-19 19:17:59', '2025-09-19 19:17:59'),
(11, 2, 'out', 2, 8, 6, 'Đặt hàng #ORD-20250920-68CE10CF2D7AD', 7, NULL, '2025-09-19 19:26:23', '2025-09-19 19:26:23'),
(12, 2, 'out', 1, 6, 5, 'Đặt hàng #ORD-20250920-68CE11DA59A23', 7, NULL, '2025-09-19 19:30:50', '2025-09-19 19:30:50'),
(13, 3, 'out', 1, 16, 15, 'Đặt hàng #ORD-20250920-68CE11DA59A23', 7, NULL, '2025-09-19 19:30:50', '2025-09-19 19:30:50'),
(14, 5, 'out', 1, 14, 13, 'Đặt hàng #ORD-20250920-68CE12DD22F7C', 7, NULL, '2025-09-19 19:35:09', '2025-09-19 19:35:09'),
(15, 5, 'out', 1, 13, 12, 'Đặt hàng #ORD-20250920-68CE139CC42D3', 7, 18, '2025-09-19 19:38:20', '2025-09-19 19:38:20'),
(16, 5, 'in', 1, 12, 13, 'Hoàn lại hàng do hủy đơn hàng #ORD-20250920-68CE139CC42D3', 7, NULL, '2025-09-19 19:45:23', '2025-09-19 19:45:23'),
(17, 5, 'out', 1, 13, 12, 'Đặt hàng #ORD-20250920-68CE155D179B4', 7, 19, '2025-09-19 19:45:49', '2025-09-19 19:45:49'),
(18, 7, 'out', 1, 8, 7, 'Đặt hàng #ORD-20250920-68CE155D179B4', 7, 19, '2025-09-19 19:45:49', '2025-09-19 19:45:49'),
(19, 1, 'out', 1, 13, 12, 'Đặt hàng #ORD-20250920-68CE15CA825CE', 7, 20, '2025-09-19 19:47:38', '2025-09-19 19:47:38'),
(20, 1, 'out', 1, 12, 11, 'Đặt hàng #ORD-20250920-68CE1A0643FD8', 7, 21, '2025-09-19 20:05:42', '2025-09-19 20:05:42'),
(21, 1, 'out', 1, 11, 10, 'Đặt hàng #ORD-20250920-68CE1AF2A7FEB', 7, 22, '2025-09-19 20:09:38', '2025-09-19 20:09:38'),
(22, 2, 'out', 1, 5, 4, 'Đặt hàng #ORD-20250920-68CE1AF2A7FEB', 7, 22, '2025-09-19 20:09:38', '2025-09-19 20:09:38'),
(23, 2, 'out', 1, 4, 3, 'Đặt hàng #ORD-20250920-68CE1BFD6C6E3', 7, 23, '2025-09-19 20:14:05', '2025-09-19 20:14:05'),
(24, 2, 'out', 1, 3, 2, 'Đặt hàng #ORD-20250920-68CE2009E604D', 7, 24, '2025-09-19 20:31:21', '2025-09-19 20:31:21'),
(25, 17, 'out', 1, 78, 77, 'Đặt hàng #ORD-20250920-68CE20B3074CA', 7, 25, '2025-09-19 20:34:11', '2025-09-19 20:34:11'),
(26, 17, 'out', 1, 77, 76, 'Xuất hàng cho đơn hàng #ORD-20250920-68CE20B3074CA', 1, 25, '2025-09-19 20:34:22', '2025-09-19 20:34:22'),
(27, 1, 'out', 1, 10, 9, 'Đặt hàng #ORD-20250920-68CE2363E929F', 1, 26, '2025-09-19 20:45:39', '2025-09-19 20:45:39'),
(28, 1, 'out', 1, 9, 8, 'Đặt hàng #ORD-20250920-68CE239F3BE27', 1, 27, '2025-09-19 20:46:39', '2025-09-19 20:46:39'),
(29, 2, 'out', 1, 2, 1, 'Đặt hàng #ORD-20250920-68CE239F3BE27', 1, 27, '2025-09-19 20:46:39', '2025-09-19 20:46:39'),
(30, 1, 'out', 1, 8, 7, 'Đặt hàng #ORD-20250920-68CE23B3492B4', 1, 28, '2025-09-19 20:46:59', '2025-09-19 20:46:59'),
(31, 2, 'out', 1, 1, 0, 'Đặt hàng #ORD-20250920-68CE23B3492B4', 1, 28, '2025-09-19 20:46:59', '2025-09-19 20:46:59'),
(32, 1, 'out', 1, 7, 6, 'Đặt hàng #ORD-20250924-68D386E37A524', 1, 29, '2025-09-23 22:51:31', '2025-09-23 22:51:31'),
(33, 1, 'out', 1, 6, 5, 'Xuất hàng cho đơn hàng #ORD-20250927-68D74F3855CCC', 1, NULL, '2025-09-26 19:43:04', '2025-09-26 19:43:04'),
(34, 3, 'out', 1, 15, 14, 'Xuất hàng cho đơn hàng #ORD-20250927-68D76071D6084', 1, NULL, '2025-09-26 20:56:33', '2025-09-26 20:56:33'),
(35, 3, 'out', 1, 14, 13, 'Xuất hàng cho đơn hàng #ORD-20250927-68D760782B35B', 1, NULL, '2025-09-26 20:56:40', '2025-09-26 20:56:40'),
(36, 3, 'out', 1, 13, 12, 'Xuất hàng cho đơn hàng #ORD-20250927-68D76081901AF', 1, NULL, '2025-09-26 20:56:49', '2025-09-26 20:56:49'),
(37, 5, 'out', 1, 12, 11, 'Xuất hàng cho đơn hàng #ORD-20250927-68D760C717B49', 1, 37, '2025-09-26 20:57:59', '2025-09-26 20:57:59'),
(38, 5, 'out', 1, 11, 10, 'Xuất hàng cho đơn hàng #ORD-20250927-68D761544F7A6', 1, 38, '2025-09-26 21:00:20', '2025-09-26 21:00:20'),
(39, 5, 'out', 1, 10, 9, 'Xuất hàng cho đơn hàng #ORD-20250927-68D76240BBD06', 1, 39, '2025-09-26 21:04:16', '2025-09-26 21:04:16'),
(40, 12, 'out', 1, 10, 9, 'Xuất hàng cho đơn hàng #ORD-20250927-68D76240BBD06', 1, 39, '2025-09-26 21:04:16', '2025-09-26 21:04:16'),
(41, 5, 'out', 1, 9, 8, 'Xuất hàng cho đơn hàng #ORD-20250927-68D7631874022', 1, 40, '2025-09-26 21:07:52', '2025-09-26 21:07:52'),
(42, 12, 'out', 1, 9, 8, 'Xuất hàng cho đơn hàng #ORD-20250927-68D7631874022', 1, 40, '2025-09-26 21:07:52', '2025-09-26 21:07:52'),
(43, 5, 'out', 1, 8, 7, 'Xuất hàng cho đơn hàng #ORD-20250927-68D765208B4B6', 1, 41, '2025-09-26 21:16:32', '2025-09-26 21:16:32'),
(44, 12, 'out', 1, 8, 7, 'Xuất hàng cho đơn hàng #ORD-20250927-68D765208B4B6', 1, 41, '2025-09-26 21:16:32', '2025-09-26 21:16:32'),
(45, 5, 'out', 1, 7, 6, 'Xuất hàng cho đơn hàng #ORD-20251004-68E07AB2274FF', 1, 42, '2025-10-03 18:38:58', '2025-10-03 18:38:58'),
(46, 12, 'out', 1, 7, 6, 'Xuất hàng cho đơn hàng #ORD-20251004-68E07AB2274FF', 1, 42, '2025-10-03 18:38:58', '2025-10-03 18:38:58'),
(47, 1, 'out', 1, 5, 4, 'Xuất hàng cho đơn hàng #ORD-20251004-68E07BF4C22AE', 1, 43, '2025-10-03 18:44:20', '2025-10-03 18:44:20'),
(48, 3, 'out', 1, 12, 11, 'Xuất hàng cho đơn hàng #ORD-20251006-68E3C49175A0B', 7, 44, '2025-10-06 06:30:57', '2025-10-06 06:30:57'),
(49, 3, 'out', 1, 11, 10, 'Xuất hàng cho đơn hàng #ORD-20251006-68E3C4A21DA49', 7, 45, '2025-10-06 06:31:14', '2025-10-06 06:31:14'),
(50, 3, 'out', 1, 10, 9, 'Xuất hàng cho đơn hàng #ORD-20251006-68E3C5206D2EB', 7, 46, '2025-10-06 06:33:20', '2025-10-06 06:33:20'),
(51, 4, 'out', 1, 10, 9, 'Xuất hàng cho đơn hàng #ORD-20251006-68E3C5378487B', 7, 47, '2025-10-06 06:33:43', '2025-10-06 06:33:43'),
(52, 7, 'out', 1, 7, 6, 'Xuất hàng cho đơn hàng #ORD-20251006-68E3C5493B02B', 2, 48, '2025-10-06 06:34:01', '2025-10-06 06:34:01'),
(53, 14, 'out', 1, 30, 29, 'Xuất hàng cho đơn hàng #ORD-20251006-68E3C5493B02B', 2, 48, '2025-10-06 06:34:01', '2025-10-06 06:34:01');

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_type` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `sender_type`, `receiver_type`, `message`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'user', 'admin', 'xin chào', 1, '2025-09-18 19:08:09', '2025-09-18 18:55:31', '2025-09-18 19:08:09'),
(2, 7, 1, 'user', 'admin', 'hello', 1, '2025-09-18 19:08:09', '2025-09-18 18:56:47', '2025-09-18 19:08:09'),
(6, 1, 7, 'admin', 'user', '1', 0, NULL, '2025-09-18 19:11:24', '2025-09-18 19:11:24'),
(7, 7, 1, 'user', 'admin', '2', 1, '2025-09-18 19:11:56', '2025-09-18 19:11:48', '2025-09-18 19:11:56'),
(8, 1, 7, 'admin', 'user', '3', 0, NULL, '2025-09-18 19:15:52', '2025-09-18 19:15:52'),
(9, 7, 1, 'user', 'admin', '4', 1, '2025-09-18 19:17:54', '2025-09-18 19:17:42', '2025-09-18 19:17:54'),
(10, 1, 7, 'admin', 'user', '5', 0, NULL, '2025-09-18 19:22:41', '2025-09-18 19:22:41'),
(11, 7, 1, 'user', 'admin', '6', 1, '2025-09-18 19:22:54', '2025-09-18 19:22:48', '2025-09-18 19:22:54'),
(12, 1, 7, 'admin', 'user', '7', 0, NULL, '2025-09-18 19:35:22', '2025-09-18 19:35:22'),
(13, 7, 1, 'user', 'admin', '8', 1, '2025-09-18 19:41:31', '2025-09-18 19:39:08', '2025-09-18 19:41:31'),
(14, 7, 1, 'user', 'admin', '9', 1, '2025-09-18 19:42:25', '2025-09-18 19:41:51', '2025-09-18 19:42:25'),
(15, 1, 7, 'admin', 'user', '10', 0, NULL, '2025-09-18 19:41:56', '2025-09-18 19:41:56'),
(16, 7, 1, 'user', 'admin', 'xin chào', 1, '2025-09-19 18:14:43', '2025-09-19 18:14:32', '2025-09-19 18:14:43'),
(17, 1, 7, 'admin', 'user', 'hello', 0, NULL, '2025-09-19 18:14:54', '2025-09-19 18:14:54'),
(18, 7, 1, 'user', 'admin', '1', 1, '2025-09-19 18:16:42', '2025-09-19 18:15:01', '2025-09-19 18:16:42'),
(19, 1, 7, 'admin', 'user', '2', 0, NULL, '2025-09-19 18:15:09', '2025-09-19 18:15:09'),
(20, 7, 1, 'user', 'admin', '1', 1, '2025-09-19 19:20:49', '2025-09-19 19:20:42', '2025-09-19 19:20:49'),
(21, 1, 7, 'admin', 'user', '2', 0, NULL, '2025-09-19 19:20:52', '2025-09-19 19:20:52'),
(22, 7, 1, 'user', 'admin', '55', 1, '2025-09-23 19:25:40', '2025-09-19 19:20:56', '2025-09-23 19:25:40'),
(23, 1, 7, 'admin', 'user', 'ok', 0, NULL, '2025-09-23 19:25:53', '2025-09-23 19:25:53'),
(24, 1, 1, 'user', 'admin', 'ok', 0, NULL, '2025-09-23 20:11:42', '2025-09-23 20:11:42'),
(25, 12, 1, 'user', 'admin', 'xin chào', 1, '2025-09-23 22:57:07', '2025-09-23 22:56:30', '2025-09-23 22:57:07'),
(26, 1, 12, 'admin', 'user', 'tôi có thể giúp gì cho bạn', 0, NULL, '2025-09-23 22:57:15', '2025-09-23 22:57:15');

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
(29, '2025_09_04_022441_create_reviews_table', 3),
(30, '2025_09_04_035759_create_inventory_transactions_table', 4),
(31, '2025_09_18_034921_add_social_ids_to_users_table', 5),
(32, '2025_09_18_043333_add_momo_fields_to_orders_table', 6),
(33, '2025_09_12_041700_update_orders_payment_method_enum', 7),
(34, '2025_09_18_173123_remove_qr_code_from_payment_method_enum', 8),
(35, '2025_09_18_173242_drop_payment_methods_table', 9),
(36, '2025_09_18_174235_create_favorites_table', 10),
(37, '2025_09_18_181242_create_messages_table', 11),
(38, '2025_09_20_023627_add_password_set_to_users_table', 12),
(39, '2025_09_20_024035_add_waiting_payment_status_to_orders_table', 13),
(40, '2025_09_20_025835_add_images_to_reviews_table', 14),
(41, '2025_01_15_000000_create_questions_answers_table', 15),
(42, '2025_01_15_000002_create_questions_and_answers_tables', 15),
(43, '2025_01_15_000003_add_category_to_questions_table', 15),
(44, '2025_01_15_000005_add_category_to_questions_table', 15),
(45, '2025_09_13_030954_add_profile_fields_to_users_table', 16),
(46, '2025_09_27_021300_update_order_history_table_structure', 17),
(47, '2025_09_27_021315_add_shipping_ward_code_to_orders_table', 18),
(48, '2025_09_27_021832_add_order_code_to_orders_table', 19),
(49, '2025_10_06_145832_create_question_likes_table', 20),
(50, '2025_09_10_074803_create_faqs_table', 21),
(51, '2025_09_12_040359_create_payment_methods_table', 21),
(52, '2025_10_06_000001_add_order_item_and_admin_reply_to_reviews_table', 21);

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
(1, 'Xu Hướng Máy Hút Mùi 2025', 'xu-huong-may-hut-mui-2025', 'Khám phá những xu hướng mới nhất trong thiết kế và công nghệ máy hút mùi cho căn bếp hiện đại năm 2025.', '<h2>Xu Hướng Thiết Kế 2025</h2>\r\n<p>Năm 2025 mang đến những xu hướng thiết kế m&aacute;y h&uacute;t m&ugrave;i ho&agrave;n to&agrave;n mới, tập trung v&agrave;o t&iacute;nh thẩm mỹ v&agrave; hiệu quả sử dụng.</p>\r\n<h3>1. Thiết Kế Tối Giản</h3>\r\n<p>Xu hướng thiết kế tối giản tiếp tục thống trị thị trường với những đường n&eacute;t sạch sẽ, m&agrave;u sắc trung t&iacute;nh v&agrave; kiểu d&aacute;ng hiện đại.</p>\r\n<h3>2. C&ocirc;ng Nghệ Th&ocirc;ng Minh</h3>\r\n<p>C&aacute;c d&ograve;ng m&aacute;y h&uacute;t m&ugrave;i mới được t&iacute;ch hợp c&ocirc;ng nghệ IoT, cho ph&eacute;p điều khiển từ xa qua smartphone v&agrave; tự động điều chỉnh tốc độ h&uacute;t.</p>\r\n<h3>3. Tiết Kiệm Năng Lượng</h3>\r\n<p>Với c&ocirc;ng nghệ inverter ti&ecirc;n tiến, m&aacute;y h&uacute;t m&ugrave;i 2025 tiết kiệm điện năng l&ecirc;n đến 40% so với c&aacute;c d&ograve;ng cũ.</p>\r\n<h3>4. Vật Liệu Cao Cấp</h3>\r\n<p>Sử dụng th&eacute;p kh&ocirc;ng gỉ 304, k&iacute;nh cường lực v&agrave; c&aacute;c vật liệu chống b&aacute;m d&iacute;nh gi&uacute;p dễ d&agrave;ng vệ sinh v&agrave; bảo tr&igrave;.</p>', 'news/news_20250918041817_vu2ohm.jpg', 'xu-hướng', 'Admin', 1, 1, 160, '2025-08-28 22:31:56', '2025-09-23 19:13:11'),
(2, 'Cách Bảo Trì Máy Hút Mùi', 'cach-bao-tri-may-hut-mui', 'Hướng dẫn chi tiết cách vệ sinh và bảo trì máy hút mùi để đảm bảo hiệu suất tối ưu và tuổi thọ lâu dài.', '<h2>Hướng Dẫn Bảo Tr&igrave; M&aacute;y H&uacute;t M&ugrave;i</h2>\r\n<p>Việc bảo tr&igrave; định kỳ m&aacute;y h&uacute;t m&ugrave;i kh&ocirc;ng chỉ gi&uacute;p tăng tuổi thọ sản phẩm m&agrave; c&ograve;n đảm bảo hiệu suất hoạt động tối ưu.</p>\r\n<h3>1. Vệ Sinh Bộ Lọc</h3>\r\n<p><strong>Tần suất:</strong> Mỗi th&aacute;ng 1 lần</p>\r\n<ul>\r\n<li>Th&aacute;o bộ lọc khỏi m&aacute;y</li>\r\n<li>Ng&acirc;m trong nước ấm với x&agrave; ph&ograve;ng</li>\r\n<li>Chải nhẹ bằng b&agrave;n chải mềm</li>\r\n<li>Rửa sạch v&agrave; để kh&ocirc; ho&agrave;n to&agrave;n</li>\r\n</ul>\r\n<h3>2. Vệ Sinh Th&acirc;n M&aacute;y</h3>\r\n<p><strong>Tần suất:</strong> Mỗi tuần 1 lần</p>\r\n<ul>\r\n<li>D&ugrave;ng khăn ẩm lau bề mặt ngo&agrave;i</li>\r\n<li>Tr&aacute;nh sử dụng h&oacute;a chất mạnh</li>\r\n<li>Lau kh&ocirc; bằng khăn mềm</li>\r\n</ul>\r\n<h3>3. Kiểm Tra Định Kỳ</h3>\r\n<p><strong>Tần suất:</strong> Mỗi 6 th&aacute;ng</p>\r\n<ul>\r\n<li>Kiểm tra d&acirc;y điện v&agrave; ổ cắm</li>\r\n<li>L&agrave;m sạch quạt gi&oacute;</li>\r\n<li>Kiểm tra độ rung v&agrave; tiếng ồn</li>\r\n</ul>', 'news/news_20250918041754_d3gnlq.jpg', 'hướng-dẫn', 'Admin', 1, 1, 93, '2025-08-28 22:31:56', '2025-10-06 07:25:01'),
(3, 'Khuyến Mãi Tết Nguyên Đán', 'khuyen-mai-tet-nguyen-dan', 'Chương trình khuyến mãi đặc biệt nhân dịp Tết Nguyên Đán với nhiều ưu đãi hấp dẫn cho khách hàng.', '<h2>Chương Tr&igrave;nh Khuyến M&atilde;i Tết 2025</h2>\r\n<p>Nh&acirc;n dịp Tết Nguy&ecirc;n Đ&aacute;n, KitchenHood Pro mang đến chương tr&igrave;nh khuyến m&atilde;i đặc biệt với nhiều ưu đ&atilde;i hấp dẫn.</p>\r\n<h3>🎉 Ưu Đ&atilde;i Đặc Biệt</h3>\r\n<ul>\r\n<li><strong>Giảm gi&aacute; 30%</strong> cho tất cả sản phẩm m&aacute;y h&uacute;t m&ugrave;i</li>\r\n<li><strong>Miễn ph&iacute; vận chuyển</strong> to&agrave;n quốc</li>\r\n<li><strong>Tặng k&egrave;m bộ lọc</strong> trị gi&aacute; 500.000 VNĐ</li>\r\n<li><strong>Bảo h&agrave;nh mở rộng</strong> l&ecirc;n 7 năm</li>\r\n</ul>\r\n<h3>📅 Thời Gian &Aacute;p Dụng</h3>\r\n<p><strong>Từ ng&agrave;y:</strong> 15/01/2025<br><strong>Đến ng&agrave;y:</strong> 15/02/2025</p>\r\n<h3>🎁 Qu&agrave; Tặng Đặc Biệt</h3>\r\n<p>Kh&aacute;ch h&agrave;ng mua từ 2 sản phẩm trở l&ecirc;n sẽ được tặng th&ecirc;m:</p>\r\n<ul>\r\n<li>Bộ dụng cụ vệ sinh chuy&ecirc;n dụng</li>\r\n<li>G&oacute;i bảo tr&igrave; miễn ph&iacute; 1 năm</li>\r\n<li>Hướng dẫn sử dụng chi tiết</li>\r\n</ul>\r\n<h3>📞 Li&ecirc;n Hệ Ngay</h3>\r\n<p>Để được tư vấn v&agrave; đặt h&agrave;ng, vui l&ograve;ng li&ecirc;n hệ:</p>\r\n<ul>\r\n<li><strong>Hotline:</strong> 1900 1234</li>\r\n<li><strong>Email:</strong> sales@kitchenhoodpro.com</li>\r\n<li><strong>Website:</strong> www.kitchenhoodpro.com</li>\r\n</ul>', 'news/wXcFS1SowXTYEHp6gP2AAycKDs8rePhkZPnkA2ol.png', 'khuyến-mãi', 'Admin', 1, 1, 239, '2025-08-28 22:31:56', '2025-09-23 22:47:02'),
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
  `order_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` bigint(20) NOT NULL,
  `payment_method` enum('cod','bank_transfer','momo') COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `shipping_ward_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `momo_request_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `momo_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_comment` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','waiting_payment','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `total_amount` bigint(20) NOT NULL,
  `shipping_fee` bigint(20) NOT NULL,
  `discount_amount` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `order_code`, `subtotal`, `payment_method`, `payment_status`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_province_id`, `shipping_province_name`, `shipping_district_id`, `shipping_district_name`, `shipping_ward_id`, `shipping_ward_name`, `shipping_ward_code`, `notes`, `momo_request_id`, `momo_order_id`, `rating`, `review_comment`, `reviewed_at`, `status`, `total_amount`, `shipping_fee`, `discount_amount`, `created_at`, `updated_at`) VALUES
(1, 2, 'ORD-20250904-68B9007ED2BA4', NULL, 8500000, 'cod', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Phú Diễn, Quận Bắc Từ Liêm, Thành phố Hà Nội', 1, 'Thành phố Hà Nội', 21, 'Quận Bắc Từ Liêm', 619, 'Phường Phú Diễn', NULL, 'ok', NULL, NULL, NULL, NULL, NULL, 'delivered', 8500000, 0, 0, '2025-09-03 19:59:10', '2025-09-03 20:04:10'),
(5, 7, 'ORD-20250918-68CC3A67DA3D5', NULL, 22900000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68cc3a6b3efb6', '1758214763_5', NULL, NULL, NULL, 'delivered', 22900000, 0, 0, '2025-09-18 09:59:19', '2025-09-18 10:07:59'),
(7, 7, 'ORD-20250918-68CC3D74D59E2', NULL, 15700000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68cc3d77b5f39', '1758215543_7', NULL, NULL, NULL, 'delivered', 15700000, 0, 0, '2025-09-18 10:12:20', '2025-09-18 10:16:43'),
(8, 7, 'ORD-20250918-68CC3E99D014E', NULL, 16300000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68cc3e9ca7277', '1758215836_8', NULL, NULL, NULL, 'processing', 16300000, 0, 0, '2025-09-18 10:17:13', '2025-09-18 10:18:13'),
(9, 1, 'ORD-20250918-68CC42D730C81', NULL, 6800000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68cc42d9afdf2', '1758216921_9', NULL, NULL, NULL, 'delivered', 6800000, 0, 0, '2025-09-18 10:35:19', '2025-09-18 10:37:31'),
(11, 1, 'ORD-20250919-68CCC87802977', NULL, 17000000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68ccc87ff194d', '1758251135_11', NULL, NULL, NULL, 'delivered', 17000000, 0, 0, '2025-09-18 20:05:28', '2025-09-18 20:07:08'),
(12, 1, 'ORD-20250919-68CCC9217C02A', NULL, 7200000, 'cod', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'delivered', 7200000, 0, 0, '2025-09-18 20:08:17', '2025-09-18 20:09:07'),
(13, 1, 'ORD-20250919-68CCCA27BDD2C', NULL, 11920000, 'cod', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'delivered', 11920000, 0, 0, '2025-09-18 20:12:39', '2025-09-18 20:13:05'),
(18, 7, 'ORD-20250920-68CE139CC42D3', NULL, 7800000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68ce13d90565e', '1758335961_18', NULL, NULL, NULL, 'cancelled', 7800000, 0, 0, '2025-09-19 19:38:20', '2025-09-19 19:45:24'),
(19, 7, 'ORD-20250920-68CE155D179B4', NULL, 19300000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68ce156280ea2', '1758336354_19', NULL, NULL, NULL, 'processing', 19300000, 0, 0, '2025-09-19 19:45:49', '2025-09-19 19:47:25'),
(20, 7, 'ORD-20250920-68CE15CA825CE', NULL, 8500000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68ce15cd47d6d', '1758336461_20', NULL, NULL, NULL, 'waiting_payment', 8500000, 0, 0, '2025-09-19 19:47:38', '2025-09-19 19:47:42'),
(21, 7, 'ORD-20250920-68CE1A0643FD8', NULL, 8500000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68ce1a095e9eb', '1758337545_21', NULL, NULL, NULL, 'waiting_payment', 8500000, 0, 0, '2025-09-19 20:05:42', '2025-09-19 20:05:46'),
(22, 7, 'ORD-20250920-68CE1AF2A7FEB', NULL, 15700000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68ce1b34d44fb', '1758337844_22', NULL, NULL, NULL, 'processing', 15700000, 0, 0, '2025-09-19 20:09:38', '2025-09-19 20:12:09'),
(23, 7, 'ORD-20250920-68CE1BFD6C6E3', NULL, 7200000, 'cod', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 7200000, 0, 0, '2025-09-19 20:14:05', '2025-09-19 20:14:05'),
(24, 7, 'ORD-20250920-68CE2009E604D', NULL, 7200000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68ce200e399d4', '1758339086_24', NULL, NULL, NULL, 'delivered', 7200000, 0, 0, '2025-09-19 20:31:21', '2025-09-19 20:32:58'),
(25, 7, 'ORD-20250920-68CE20B3074CA', NULL, 120000, 'cod', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'delivered', 170000, 50000, 0, '2025-09-19 20:34:11', '2025-09-19 20:34:27'),
(26, 1, 'ORD-20250920-68CE2363E929F', NULL, 8500000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68ce2366cb6e5', '1758339942_26', NULL, NULL, NULL, 'waiting_payment', 8500000, 0, 0, '2025-09-19 20:45:39', '2025-09-19 20:45:44'),
(27, 1, 'ORD-20250920-68CE239F3BE27', NULL, 15700000, 'cod', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 15700000, 0, 0, '2025-09-19 20:46:39', '2025-09-19 20:46:39'),
(28, 1, 'ORD-20250920-68CE23B3492B4', NULL, 15700000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68ce2417ba35b', '1758340119_28', NULL, NULL, NULL, 'processing', 15700000, 0, 0, '2025-09-19 20:46:59', '2025-09-19 20:49:32'),
(29, 1, 'ORD-20250924-68D386E37A524', NULL, 8500000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68d386ffc4a71', '1758693119_29', NULL, NULL, NULL, 'processing', 8500000, 0, 0, '2025-09-23 22:51:31', '2025-09-23 22:53:36'),
(37, 1, 'ORD-20250927-68D760C717B49', '', 7800000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 7800000, 0, 0, '2025-09-26 20:57:59', '2025-09-26 20:57:59'),
(38, 1, 'ORD-20250927-68D761544F7A6', '', 7800000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68d76159c7ccc', '1758945625_38', NULL, NULL, NULL, 'pending', 7800000, 0, 0, '2025-09-26 21:00:20', '2025-09-26 21:00:32'),
(39, 1, 'ORD-20250927-68D76240BBD06', '', 19000000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68d76242aabce', '1758945858_39', NULL, NULL, NULL, 'pending', 19000000, 0, 0, '2025-09-26 21:04:16', '2025-09-26 21:04:19'),
(40, 1, 'ORD-20250927-68D7631874022', '', 19000000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68d7645b29954', '1758946395_40', NULL, NULL, NULL, 'pending', 19000000, 0, 0, '2025-09-26 21:07:52', '2025-09-26 21:13:15'),
(41, 1, 'ORD-20250927-68D765208B4B6', '', 19000000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68d76524d6d49', '1758946596_41', NULL, NULL, NULL, 'pending', 19000000, 0, 0, '2025-09-26 21:16:32', '2025-09-26 21:16:37'),
(42, 1, 'ORD-20251004-68E07AB2274FF', 'L4LU9F', 19000000, 'cod', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 19000000, 0, 0, '2025-10-03 18:38:58', '2025-10-03 18:39:02'),
(43, 1, 'ORD-20251004-68E07BF4C22AE', '', 8500000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Xã Hiên Vân, Huyện Tiên Du, Tỉnh Bắc Ninh', 27, 'Tỉnh Bắc Ninh', 260, 'Huyện Tiên Du', 9337, 'Xã Hiên Vân', NULL, NULL, '68e07bf6a79b5', '1759542262_43', NULL, NULL, NULL, 'pending', 8500000, 0, 0, '2025-10-03 18:44:20', '2025-10-03 18:44:23'),
(44, 7, 'ORD-20251006-68E3C49175A0B', '', 6800000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 6800000, 0, 0, '2025-10-06 06:30:57', '2025-10-06 06:30:57'),
(45, 7, 'ORD-20251006-68E3C4A21DA49', '', 6800000, 'momo', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 6800000, 0, 0, '2025-10-06 06:31:14', '2025-10-06 06:31:14'),
(46, 7, 'ORD-20251006-68E3C5206D2EB', '', 6800000, 'cod', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 6800000, 0, 0, '2025-10-06 06:33:20', '2025-10-06 06:33:20'),
(47, 7, 'ORD-20251006-68E3C5378487B', '', 9200000, 'momo', 'paid', 'Đào Văn Tâm', '0969859400', '10c, Phường Hàng Kênh, Quận Lê Chân, Thành phố Hải Phòng', 31, 'Thành phố Hải Phòng', 305, 'Quận Lê Chân', 11392, 'Phường Hàng Kênh', NULL, NULL, '68e3c53ad7583', '1759757626_47', NULL, NULL, NULL, 'delivered', 9200000, 0, 0, '2025-10-06 06:33:43', '2025-10-06 06:36:06'),
(48, 2, 'ORD-20251006-68E3C5493B02B', '', 14000000, 'cod', 'pending', 'Đào Văn Tâm', '0969859400', '10c, Phường Phú Diễn, Quận Bắc Từ Liêm, Thành phố Hà Nội', 1, 'Thành phố Hà Nội', 21, 'Quận Bắc Từ Liêm', 619, 'Phường Phú Diễn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 14000000, 0, 0, '2025-10-06 06:34:01', '2025-10-06 06:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'system',
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
(1, 1, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-03 19:59:10', '2025-09-03 19:59:10'),
(6, 5, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 2, 14400000, '2025-09-18 09:59:19', '2025-09-18 09:59:19'),
(7, 5, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-18 09:59:19', '2025-09-18 09:59:19'),
(11, 7, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-18 10:12:20', '2025-09-18 10:12:20'),
(12, 7, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-18 10:12:20', '2025-09-18 10:12:20'),
(13, 8, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-18 10:17:13', '2025-09-18 10:17:13'),
(14, 8, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-18 10:17:13', '2025-09-18 10:17:13'),
(15, 9, 3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 6800000, 1, 6800000, '2025-09-18 10:35:19', '2025-09-18 10:35:19'),
(17, 11, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 2, 17000000, '2025-09-18 20:05:28', '2025-09-18 20:05:28'),
(18, 12, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-18 20:08:17', '2025-09-18 20:08:17'),
(19, 13, 11, 'Máy hút mùi ống khói Electrolux LFC97CR50', 11800000, 1, 11800000, '2025-09-18 20:12:39', '2025-09-18 20:12:39'),
(20, 13, 17, 'Bộ lọc dầu mỡ cho máy hút mùi', 120000, 1, 120000, '2025-09-18 20:12:39', '2025-09-18 20:12:39'),
(27, 18, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-19 19:38:20', '2025-09-19 19:38:20'),
(28, 19, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-19 19:45:49', '2025-09-19 19:45:49'),
(29, 19, 7, 'Máy hút mùi đảo bếp Bosch DWF97CR50', 11500000, 1, 11500000, '2025-09-19 19:45:49', '2025-09-19 19:45:49'),
(30, 20, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-19 19:47:38', '2025-09-19 19:47:38'),
(31, 21, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-19 20:05:42', '2025-09-19 20:05:42'),
(32, 22, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-19 20:09:38', '2025-09-19 20:09:38'),
(33, 22, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-19 20:09:38', '2025-09-19 20:09:38'),
(34, 23, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-19 20:14:05', '2025-09-19 20:14:05'),
(35, 24, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-19 20:31:21', '2025-09-19 20:31:21'),
(36, 25, 17, 'Bộ lọc dầu mỡ cho máy hút mùi', 120000, 1, 120000, '2025-09-19 20:34:11', '2025-09-19 20:34:11'),
(37, 26, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-19 20:45:39', '2025-09-19 20:45:39'),
(38, 27, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-19 20:46:39', '2025-09-19 20:46:39'),
(39, 27, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-19 20:46:39', '2025-09-19 20:46:39'),
(40, 28, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-19 20:46:59', '2025-09-19 20:46:59'),
(41, 28, 2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 7200000, 1, 7200000, '2025-09-19 20:46:59', '2025-09-19 20:46:59'),
(42, 29, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-09-23 22:51:31', '2025-09-23 22:51:31'),
(48, 37, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-26 20:57:59', '2025-09-26 20:57:59'),
(49, 38, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-26 21:00:20', '2025-09-26 21:00:20'),
(50, 39, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-26 21:04:16', '2025-09-26 21:04:16'),
(51, 39, 12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 11200000, 1, 11200000, '2025-09-26 21:04:16', '2025-09-26 21:04:16'),
(52, 40, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-26 21:07:52', '2025-09-26 21:07:52'),
(53, 40, 12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 11200000, 1, 11200000, '2025-09-26 21:07:52', '2025-09-26 21:07:52'),
(54, 41, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-09-26 21:16:32', '2025-09-26 21:16:32'),
(55, 41, 12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 11200000, 1, 11200000, '2025-09-26 21:16:32', '2025-09-26 21:16:32'),
(56, 42, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-10-03 18:38:58', '2025-10-03 18:38:58'),
(57, 42, 12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 11200000, 1, 11200000, '2025-10-03 18:38:58', '2025-10-03 18:38:58'),
(58, 43, 1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 8500000, 1, 8500000, '2025-10-03 18:44:20', '2025-10-03 18:44:20'),
(59, 44, 3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 6800000, 1, 6800000, '2025-10-06 06:30:57', '2025-10-06 06:30:57'),
(60, 45, 3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 6800000, 1, 6800000, '2025-10-06 06:31:14', '2025-10-06 06:31:14'),
(61, 46, 3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 6800000, 1, 6800000, '2025-10-06 06:33:20', '2025-10-06 06:33:20'),
(62, 47, 4, 'Máy hút mùi kính cong Bosch DWF97CR50', 9200000, 1, 9200000, '2025-10-06 06:33:43', '2025-10-06 06:33:43'),
(63, 48, 7, 'Máy hút mùi đảo bếp Bosch DWF97CR50', 11500000, 1, 11500000, '2025-10-06 06:34:01', '2025-10-06 06:34:01'),
(64, 48, 14, 'Máy hút mùi mini Electrolux LFC97CR50', 2500000, 1, 2500000, '2025-10-06 06:34:01', '2025-10-06 06:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `qr_code_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `momo_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `momo_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 'Máy hút mùi âm tủ cao cấp của Bosch với công suất 650m³/h, thiết kế hiện đại, tích hợp đèn LED, 3 tốc độ hút và bộ lọc than hoạt tính.', 'products/prd_20250918041852_cygqat.jpg', 'products/prd_20250919033010_yiaaru.jpg', 'products/prd_20250919033010_9z16nl.jpg', 4, 8500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"650m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}, {\"key\": \"quân ngu\", \"value\": \"ngu cặc\"}]', 1, 1, '2025-08-28 22:31:49', '2025-10-03 18:44:20'),
(2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 'Máy hút mùi âm tủ Electrolux với thiết kế tối giản, công suất 600m³/h, bộ lọc 3 lớp hiệu quả, điều khiển cảm ứng và đèn LED chiếu sáng.', 'products/APi0bC8uyN7UmTcXAtnwbbzFdyXzkWjK7xNnxlM9.jpg', NULL, NULL, 0, 7200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"600m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"62dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-28 22:31:49', '2025-09-19 20:46:59'),
(3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 'Máy hút mùi âm tủ Samsung với công nghệ Cyclone Force, công suất 550m³/h, bộ lọc thông minh và thiết kế phù hợp với mọi không gian bếp.', 'products/eBHrh91cP8KUioJQBmDtR4moLUxQMvkfvGrLzAhE.jpg', NULL, NULL, 9, 6800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"550m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"64dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-28 22:31:49', '2025-10-06 06:33:20'),
(4, 'Máy hút mùi kính cong Bosch DWF97CR50', 'Máy hút mùi kính cong Bosch với thiết kế kính cong hiện đại, công suất 700m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', 'products/prd_20250918042248_w7amlc.jpg', NULL, NULL, 9, 9200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"700m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"63dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-28 22:31:49', '2025-10-06 06:33:43'),
(5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 'Máy hút mùi kính cong Electrolux với thiết kế kính cong 90 độ, công suất 650m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', 'products/prd_20250918042256_jlffrh.jpg', NULL, NULL, 6, 7800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"650m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"61dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-28 22:31:49', '2025-10-03 18:38:58'),
(6, 'Máy hút mùi kính cong Samsung NK36M5070DS', 'Máy hút mùi kính cong Samsung với công nghệ Cyclone Force, công suất 600m³/h, bộ lọc thông minh và thiết kế kính cong hiện đại.', 'products/prd_20250918042310_fikvm0.jpg', NULL, NULL, 16, 7500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"600m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"62dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-28 22:31:49', '2025-09-17 21:23:10'),
(7, 'Máy hút mùi đảo bếp Bosch DWF97CR50', 'Máy hút mùi đảo bếp Bosch với thiết kế đảo bếp hiện đại, công suất 800m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', 'products/prd_20250919025646_fv0ghg.jpg', NULL, NULL, 6, 11500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"800m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-28 22:31:49', '2025-10-06 06:34:01'),
(8, 'Máy hút mùi đảo bếp Electrolux LFC97CR50', 'Máy hút mùi đảo bếp Electrolux với thiết kế đảo bếp sang trọng, công suất 750m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', 'products/prd_20250919031330_rzpi2l.jpg', NULL, NULL, 12, 9800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"750m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"63dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-28 22:31:49', '2025-09-18 20:13:30'),
(9, 'Máy hút mùi đảo bếp Samsung NK36M5070DS', 'Máy hút mùi đảo bếp Samsung với công nghệ Cyclone Force, công suất 700m³/h, bộ lọc thông minh và thiết kế đảo bếp hiện đại.', 'products/prd_20250919031348_nadhpd.jpg', NULL, NULL, 15, 9200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"700m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"64dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-28 22:31:49', '2025-09-18 20:13:48'),
(10, 'Máy hút mùi ống khói Bosch DWF97CR50', 'Máy hút mùi ống khói Bosch với thiết kế ống khói hiện đại, công suất 900m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', 'products/prd_20250919031358_pk1fja.jpg', NULL, NULL, 6, 13500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"900m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"5 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"67dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-28 22:31:49', '2025-09-18 20:13:58'),
(11, 'Máy hút mùi ống khói Electrolux LFC97CR50', 'Máy hút mùi ống khói Electrolux với thiết kế ống khói sang trọng, công suất 850m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', 'products/prd_20250919031409_unyouh.jpg', NULL, NULL, 6, 11800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"850m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"5 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-28 22:31:49', '2025-09-18 20:14:09'),
(12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 'Máy hút mùi ống khói Samsung với công nghệ Cyclone Force, công suất 800m³/h, bộ lọc thông minh và thiết kế ống khói hiện đại.', 'products/prd_20250919031421_pzuly4.jpg', NULL, NULL, 6, 11200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"800m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"66dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-28 22:31:49', '2025-10-03 18:38:58'),
(13, 'Máy hút mùi mini Bosch DWF97CR50', 'Máy hút mùi mini Bosch với thiết kế nhỏ gọn, công suất 300m³/h, bộ lọc than hoạt tính và điều khiển cơ đơn giản.', 'products/prd_20250919031521_olm4tk.jpg', NULL, NULL, 25, 2800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"300m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"58dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-28 22:31:49', '2025-09-18 20:15:21'),
(14, 'Máy hút mùi mini Electrolux LFC97CR50', 'Máy hút mùi mini Electrolux với thiết kế nhỏ gọn, công suất 280m³/h, bộ lọc 2 lớp và đèn LED chiếu sáng.', 'products/prd_20250919031534_kxzpjg.jpg', NULL, NULL, 29, 2500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"280m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"56dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-28 22:31:49', '2025-10-06 06:34:01'),
(15, 'Máy hút mùi mini Samsung NK36M5070DS', 'Máy hút mùi mini Samsung với công nghệ Cyclone Force, công suất 320m³/h, bộ lọc thông minh và thiết kế nhỏ gọn.', NULL, NULL, NULL, 28, 3200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"320m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"57dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(16, 'Bộ lọc than hoạt tính cho máy hút mùi', 'Bộ lọc than hoạt tính chất lượng cao, giúp loại bỏ mùi hôi và khói bếp hiệu quả. Phù hợp với hầu hết các loại máy hút mùi.', NULL, NULL, NULL, 100, 150000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Than hoạt tính cao cấp\"}, {\"key\": \"Kích thước\", \"value\": \"Phù hợp đa số máy hút mùi\"}, {\"key\": \"Tuổi thọ\", \"value\": \"6-12 tháng\"}, {\"key\": \"Hiệu quả\", \"value\": \"Loại bỏ 99% mùi hôi\"}, {\"key\": \"Bảo hành\", \"value\": \"3 tháng\"}]', 6, 1, '2025-08-28 22:31:49', '2025-08-28 22:31:49'),
(17, 'Bộ lọc dầu mỡ cho máy hút mùi', 'Bộ lọc dầu mỡ chuyên dụng, giúp bảo vệ động cơ máy hút mùi khỏi dầu mỡ và bụi bẩn. Dễ dàng thay thế và vệ sinh.', NULL, NULL, NULL, 76, 120000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Vải lọc chống dầu mỡ\"}, {\"key\": \"Kích thước\", \"value\": \"Phù hợp đa số máy hút mùi\"}, {\"key\": \"Tuổi thọ\", \"value\": \"3-6 tháng\"}, {\"key\": \"Hiệu quả\", \"value\": \"Lọc 95% dầu mỡ\"}, {\"key\": \"Bảo hành\", \"value\": \"3 tháng\"}]', 6, 1, '2025-08-28 22:31:49', '2025-09-19 20:34:22'),
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
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_answered` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `title`, `category`, `content`, `is_answered`, `created_at`, `updated_at`) VALUES
(3, 1, 'Máy hút mùi có gây ồn không?', 'general', 'Mình muốn lắp trong bếp gia đình, không biết khi hoạt động máy có ồn nhiều không, độ ồn khoảng bao nhiêu dB', 1, '2025-09-23 23:19:15', '2025-09-23 23:25:11'),
(4, 13, 'Máy hút mùi này có phù hợp bếp 20m² không?', 'product', 'Xin hỏi model máy hút mùi Teka này có công suất đủ để sử dụng cho căn bếp diện tích 20m² không?', 1, '2025-09-23 23:21:02', '2025-09-23 23:25:42'),
(5, 13, 'Máy hút mùi âm tủ nằm ở đâu?', 'category', 'Mình muốn tìm loại máy hút mùi âm tủ cho căn hộ chung cư, shop để ở danh mục nào?', 1, '2025-09-23 23:21:30', '2025-09-23 23:25:57'),
(6, 12, 'Bảo hành motor máy hút mùi bao lâu?', 'warranty', 'Xin hỏi sản phẩm máy hút mùi Sunhouse bảo hành động cơ trong bao lâu, có bảo hành điện tử không?', 1, '2025-09-23 23:21:59', '2025-09-23 23:26:34'),
(7, 12, 'Shop có hỗ trợ lắp đặt tận nơi không?', 'shipping', 'Nếu mình đặt mua máy hút mùi, shop có hỗ trợ kỹ thuật viên đến lắp đặt tận nhà không, có tính thêm phí không?', 1, '2025-09-23 23:22:19', '2025-09-23 23:26:20'),
(8, 7, 'Máy hút mùi có hỗ trợ trả góp 0% không?', 'payment', 'Mình muốn mua máy hút mùi Bosch, giá khoảng 8 triệu, shop có hỗ trợ trả góp qua thẻ tín dụng không?', 1, '2025-09-23 23:22:50', '2025-09-23 23:27:16'),
(9, 7, 'Máy hút mùi giao bị móp méo có được đổi không?', 'return', 'Trường hợp nhận hàng máy hút mùi bị móp do vận chuyển thì shop có đổi ngay không?', 1, '2025-09-23 23:23:11', '2025-09-23 23:27:56'),
(10, 13, 'Có cần ống thoát khí ra ngoài không?', 'technical', 'Máy hút mùi dạng than hoạt tính có cần nối ống thoát ra ngoài không, hay chỉ cần thay than định kỳ?', 1, '2025-09-23 23:23:31', '2025-09-23 23:28:07'),
(11, 13, 'Tiêu thụ điện của máy hút mùi?', 'other', 'Một chiếc máy hút mùi 200W chạy 1 giờ thì tốn bao nhiêu điện, có tốn nhiều không?', 1, '2025-09-23 23:23:53', '2025-09-23 23:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `question_likes`
--

CREATE TABLE `question_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_likes`
--

INSERT INTO `question_likes` (`id`, `user_id`, `question_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, '2025-10-06 08:04:42', '2025-10-06 08:04:42'),
(2, 1, 11, '2025-10-06 08:04:45', '2025-10-06 08:04:45'),
(3, 1, 10, '2025-10-06 08:04:46', '2025-10-06 08:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `admin_reply` text COLLATE utf8mb4_unicode_ci,
  `admin_replied_at` timestamp NULL DEFAULT NULL,
  `images` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_item_id`, `rating`, `comment`, `admin_reply`, `admin_replied_at`, `images`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, 5, 'tốt', NULL, NULL, NULL, '2025-09-03 20:04:57', '2025-09-03 20:04:57'),
(2, 1, 1, NULL, 5, 'Sản phẩm rất tốt, chất lượng cao! Máy hút mùi hoạt động hiệu quả, thiết kế đẹp và dễ sử dụng.', NULL, NULL, NULL, '2025-09-03 20:34:49', '2025-09-03 20:34:49'),
(3, 2, 1, NULL, 4, 'Sản phẩm tốt, giá cả hợp lý. Công suất hút mùi khá tốt, phù hợp với gia đình.', NULL, NULL, NULL, '2025-09-03 20:34:49', '2025-09-03 20:34:49'),
(4, 1, 1, NULL, 5, 'Tuyệt vời! Đã sử dụng được 6 tháng, không có vấn đề gì. Âm thanh hoạt động êm ái.', NULL, NULL, NULL, '2025-09-03 20:34:49', '2025-09-03 20:34:49'),
(5, 1, 3, NULL, 5, 'ok', NULL, NULL, NULL, '2025-09-18 11:08:40', '2025-09-18 11:08:40'),
(6, 7, 2, NULL, 5, 'tốt đó', NULL, NULL, '[\"reviews/dbAEvi8ocfIBS0D9yAapMLJrmvxTdH4hIlLAG7Bc.jpg\"]', '2025-09-19 20:03:05', '2025-09-19 20:03:05'),
(7, 7, 1, NULL, 4, 'bình thường', NULL, NULL, '[\"reviews/72a38jP4LaPVVaB8WzoUGCjYsq1ekRGQeaSd2udc.jpg\"]', '2025-09-19 20:04:21', '2025-09-19 20:04:21'),
(8, 7, 17, NULL, 5, 'ok', NULL, NULL, '[\"reviews/Wp98SDqIOqQsczRGOVTIo0KbfswjawS7mUk695S9.jpg\"]', '2025-09-19 20:34:55', '2025-09-19 20:34:55'),
(9, 7, 4, NULL, 5, 'tốt', 'cảm ơn', '2025-10-06 09:16:00', '[\"reviews/LgyOroRaHr3ncQHWXN1bMsdh2XRqggjNShQKVdv5.jpg\"]', '2025-10-06 06:36:39', '2025-10-06 09:16:00');

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
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_set` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `phone`, `birth_date`, `gender`, `address`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `email_verified_at`, `google_id`, `facebook_id`, `password_set`) VALUES
(1, 'Admin', 'admin@gmail.com', 'avatars/4NBl6jBm9SMcD6vgLRQobxMwNwyp3PJQ1gDqbc19.jpg', '0969859400', '2004-09-24', 'male', NULL, '$2y$12$pt9ptXoMZV0nov8Fo/DJted0uH5Abe0HpCo1w20rWqJv.JLgRedr6', 'admin', NULL, '2025-08-28 22:31:49', '2025-09-23 23:44:59', '2025-08-29 06:58:17', NULL, NULL, 0),
(2, 'Tâm', 'vantamst97@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$12$/5wZ2Z4eXH.Qi99fn.hjtux2ohCs/PbzSh3NDTZNASlEffaMWvrfe', 'customer', 'dvjvjnN8K7Emgc50o8EGqvx5rVH5SY1Hdj5rcmp02ZpOHNolyqBpTc9fMyCO', '2025-08-28 22:34:58', '2025-10-06 05:07:50', '2025-10-06 05:07:50', '109043306184622165097', NULL, 0),
(7, 'Tâm Đào Văn', 'daovantambachluu@gmail.com', 'avatars/yM3Wi04RU7fIBHGFnVO9excLALtv3n9GBlLd50m9.jpg', '0123455666', '2000-09-24', 'male', NULL, '$2y$12$l941ClD49QGwYCcRTk1U6.2YRQAJ2Uo8g6OUgR18QxDdWGNs/4WTa', 'customer', 'Yxz2hxQLY6ZhMMRKakkszuQMZrFTXUN7aLtDy5rKTATCI1MTHM7RecKvX3mz', '2025-09-18 01:10:13', '2025-10-06 05:08:24', '2025-10-06 05:08:24', '112756535496879198362', NULL, 0),
(12, 'Đào Văn Tâm', '22111062277@hunre.edu.vn', NULL, NULL, NULL, NULL, NULL, '$2y$12$B4Q8w1j82rwZZDZDiRmMTuHeG/XLyu/z.NCPSo0sFrwbd0reppozG', 'customer', '6EjqjlOI5cW9mLzvXtYRPyGuZmg6k6aeaKPhEzJnir42bNjx1SbgOakqIw3i', '2025-09-23 22:56:02', '2025-09-23 22:56:02', '2025-09-23 22:56:02', '111536420119906722068', NULL, 0),
(13, 'Tâm Đào', 'tamblvp@gmail.com', 'avatars/DG3H0Pvjv2rLibYO4BYrA4wvN1yso6vrMHt4NQqk.jpg', NULL, NULL, NULL, NULL, '$2y$12$o5ylxkO8.gJ54pJHg3wVdOdOT2nshXuEdePWSZnU7T8lsaG/4ZR.q', 'customer', 'WOzMRmbmIOGPcOUELxcODyI6fNKhNnIpKrdQMFu8IE0r0cr6Qv7NKdVYVzJc', '2025-09-23 23:20:29', '2025-10-06 09:35:22', '2025-09-23 23:20:29', '101609073548246118430', NULL, 0);

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
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_user_id_foreign` (`user_id`),
  ADD KEY `answers_question_id_foreign` (`question_id`);

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
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_user_id_index` (`user_id`),
  ADD KEY `favorites_product_id_index` (`product_id`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_transactions_user_id_foreign` (`user_id`),
  ADD KEY `inventory_transactions_order_id_foreign` (`order_id`),
  ADD KEY `inventory_transactions_product_id_type_index` (`product_id`,`type`),
  ADD KEY `inventory_transactions_created_at_index` (`created_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  ADD KEY `messages_receiver_id_sender_id_index` (`receiver_id`,`sender_id`),
  ADD KEY `messages_created_at_index` (`created_at`);

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
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_shipping_ward_code_index` (`shipping_ward_code`),
  ADD KEY `orders_order_code_index` (`order_code`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_history_order_id_created_at_index` (`order_id`,`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `question_likes`
--
ALTER TABLE `question_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question_likes_user_id_question_id_unique` (`user_id`,`question_id`),
  ADD KEY `question_likes_question_id_foreign` (`question_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_order_item_id_unique` (`order_item_id`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `question_likes`
--
ALTER TABLE `question_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_likes`
--
ALTER TABLE `question_likes`
  ADD CONSTRAINT `question_likes_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
