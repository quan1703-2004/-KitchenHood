-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 25, 2025 at 08:19 AM
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
(1, 1, '2025-08-25 01:09:11', '2025-08-25 01:09:11');

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
(1, 1, 8, 1, '2025-08-25 01:17:21', '2025-08-25 01:17:21');

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
(1, 'Máy hút mùi âm tủ', '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(2, 'Máy hút mùi kính cong', '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(3, 'Máy hút mùi đảo bếp', '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(4, 'Máy hút mùi ống khói', '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(5, 'Máy hút mùi mini', '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(6, 'Phụ kiện máy hút mùi', '2025-08-25 01:08:18', '2025-08-25 01:08:18');

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
(12, '2025_08_25_000510_create_cart_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('cod','bank_transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` bigint(20) NOT NULL,
  `shipping_fee` bigint(20) NOT NULL,
  `final_amount` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `payment_method`, `notes`, `status`, `total_amount`, `shipping_fee`, `final_amount`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20250120-001', 'Nguyễn Văn An', 'nguyenvanan@example.com', '0123456789', '123 Đường ABC, Phường 1, Quận 1, TP.HCM', 'cod', 'Giao hàng vào buổi sáng', 'pending', 2500000, 50000, 2550000, '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(2, 'ORD-20250120-002', 'Trần Thị Bình', 'tranthibinh@example.com', '0987654321', '456 Đường XYZ, Phường 2, Quận 3, TP.HCM', 'bank_transfer', 'Giao hàng vào buổi chiều', 'processing', 3500000, 0, 3500000, '2025-08-25 01:08:18', '2025-08-25 01:08:18');

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
(1, 1, 10, 'Máy hút mùi ống khói Bosch DWF97CR50', 13500000, 2, 27000000, '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(2, 1, 5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 7800000, 1, 7800000, '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(3, 1, 15, 'Máy hút mùi mini Samsung NK36M5070DS', 3200000, 2, 6400000, '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(4, 2, 4, 'Máy hút mùi kính cong Bosch DWF97CR50', 9200000, 2, 18400000, '2025-08-25 01:08:18', '2025-08-25 01:08:18'),
(5, 2, 15, 'Máy hút mùi mini Samsung NK36M5070DS', 3200000, 2, 6400000, '2025-08-25 01:08:18', '2025-08-25 01:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

INSERT INTO `products` (`id`, `name`, `description`, `image`, `quantity`, `price`, `features`, `category_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Máy hút mùi âm tủ Bosch DWF97CR50', 'Máy hút mùi âm tủ cao cấp của Bosch với công suất 650m³/h, thiết kế hiện đại, tích hợp đèn LED, 3 tốc độ hút và bộ lọc than hoạt tính.', 'products/KoDdcs7HF7zpZRmPHU9w7G5xmIHmWCHzGcBfOUXD.jpg', 15, 8500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"650m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-25 01:08:18', '2025-08-25 01:11:00'),
(2, 'Máy hút mùi âm tủ Electrolux LFC97CR50', 'Máy hút mùi âm tủ Electrolux với thiết kế tối giản, công suất 600m³/h, bộ lọc 3 lớp hiệu quả, điều khiển cảm ứng và đèn LED chiếu sáng.', 'products/pH6DF8QS8YuCQtAsqEDoCJFO9Zo6bjt2XGp677Vj.jpg', 12, 7200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"600m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"62dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-25 01:08:18', '2025-08-25 01:11:09'),
(3, 'Máy hút mùi âm tủ Samsung NK36M5070DS', 'Máy hút mùi âm tủ Samsung với công nghệ Cyclone Force, công suất 550m³/h, bộ lọc thông minh và thiết kế phù hợp với mọi không gian bếp.', 'products/2Wcr8KSJmNresouchZg5aFUhea1v2Gxc8mOuWBIy.jpg', 18, 6800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"550m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"64dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 1, 1, '2025-08-25 01:08:18', '2025-08-25 01:11:17'),
(4, 'Máy hút mùi kính cong Bosch DWF97CR50', 'Máy hút mùi kính cong Bosch với thiết kế kính cong hiện đại, công suất 700m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', 'products/u8qIACfPUD7lClyPmiRRztf8wNaiKGWeEXxAyELy.jpg', 10, 9200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"700m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"63dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-25 01:08:18', '2025-08-25 01:11:30'),
(5, 'Máy hút mùi kính cong Electrolux LFC97CR50', 'Máy hút mùi kính cong Electrolux với thiết kế kính cong 90 độ, công suất 650m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', 'products/RMwMHVoPP8CqJmL7RJaLc5rapkdODbaFRi702bXv.jpg', 14, 7800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"650m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"61dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-25 01:08:18', '2025-08-25 01:11:48'),
(6, 'Máy hút mùi kính cong Samsung NK36M5070DS', 'Máy hút mùi kính cong Samsung với công nghệ Cyclone Force, công suất 600m³/h, bộ lọc thông minh và thiết kế kính cong hiện đại.', 'products/Z1fYZcd5qIcAJG4yPRNAtumedEV9Sqo2cILFmTIK.jpg', 16, 7500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"600m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"62dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 2, 1, '2025-08-25 01:08:18', '2025-08-25 01:11:58'),
(7, 'Máy hút mùi đảo bếp Bosch DWF97CR50', 'Máy hút mùi đảo bếp Bosch với thiết kế đảo bếp hiện đại, công suất 800m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', 'products/3DNdIDyhdsvI7yf1xRu5ga5kYH1Rsvjfn46jZn2H.jpg', 8, 11500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"800m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-25 01:08:18', '2025-08-25 01:12:19'),
(8, 'Máy hút mùi đảo bếp Electrolux LFC97CR50', 'Máy hút mùi đảo bếp Electrolux với thiết kế đảo bếp sang trọng, công suất 750m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', 'products/QnD6PEe5IcIo0xfXk7G5MH4SmeV28U5RJ3ao6eLF.jpg', 12, 9800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"750m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"63dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-25 01:08:18', '2025-08-25 01:12:29'),
(9, 'Máy hút mùi đảo bếp Samsung NK36M5070DS', 'Máy hút mùi đảo bếp Samsung với công nghệ Cyclone Force, công suất 700m³/h, bộ lọc thông minh và thiết kế đảo bếp hiện đại.', 'products/OxCKfcvheWAqvCX6KN6JATijelfYngffm9Sa1YRu.jpg', 15, 9200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"700m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"3 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"64dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 3, 1, '2025-08-25 01:08:18', '2025-08-25 01:12:52'),
(10, 'Máy hút mùi ống khói Bosch DWF97CR50', 'Máy hút mùi ống khói Bosch với thiết kế ống khói hiện đại, công suất 900m³/h, bộ lọc than hoạt tính và điều khiển cảm ứng thông minh.', 'products/tMwI0yhre9TEsKGOhjJ8G6lAwV5WYyiHx2pQsHip.jpg', 6, 13500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"900m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"5 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"67dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-25 01:08:18', '2025-08-25 01:13:04'),
(11, 'Máy hút mùi ống khói Electrolux LFC97CR50', 'Máy hút mùi ống khói Electrolux với thiết kế ống khói sang trọng, công suất 850m³/h, bộ lọc 4 lớp và đèn LED chiếu sáng mạnh mẽ.', 'products/W4eJN7uMTRTZxtbXkCcvpm9q95KcApivGOr1vmOi.jpg', 8, 11800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"850m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"5 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"65dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-25 01:08:18', '2025-08-25 01:13:14'),
(12, 'Máy hút mùi ống khói Samsung NK36M5070DS', 'Máy hút mùi ống khói Samsung với công nghệ Cyclone Force, công suất 800m³/h, bộ lọc thông minh và thiết kế ống khói hiện đại.', 'products/pwoOkydzO5LN1NXe1M9m8d4u2cy2xkTRk0OZ0klw.jpg', 10, 11200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"800m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"4 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"66dB\"}, {\"key\": \"Kích thước\", \"value\": \"900 x 500 x 500mm\"}, {\"key\": \"Bảo hành\", \"value\": \"2 năm\"}]', 4, 1, '2025-08-25 01:08:18', '2025-08-25 01:14:41'),
(13, 'Máy hút mùi mini Bosch DWF97CR50', 'Máy hút mùi mini Bosch với thiết kế nhỏ gọn, công suất 300m³/h, bộ lọc than hoạt tính và điều khiển cơ đơn giản.', 'products/wM3QVRsSHhbYeB2rFgW3N2E4o2irFB7UyXaPLJEL.jpg', 25, 2800000.00, '[{\"key\": \"Công suất hút\", \"value\": \"300m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"58dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-25 01:08:18', '2025-08-25 01:14:55'),
(14, 'Máy hút mùi mini Electrolux LFC97CR50', 'Máy hút mùi mini Electrolux với thiết kế nhỏ gọn, công suất 280m³/h, bộ lọc 2 lớp và đèn LED chiếu sáng.', 'products/3EPyH1nREmne66q1HQNStNp0tAzYTDcVjKgTbNms.jpg', 30, 2500000.00, '[{\"key\": \"Công suất hút\", \"value\": \"280m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"56dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-25 01:08:18', '2025-08-25 01:15:14'),
(15, 'Máy hút mùi mini Samsung NK36M5070DS', 'Máy hút mùi mini Samsung với công nghệ Cyclone Force, công suất 320m³/h, bộ lọc thông minh và thiết kế nhỏ gọn.', 'products/foOzTqvKgVPk2XBUukmaNt20U8kj0SwoiOfhY06R.jpg', 28, 3200000.00, '[{\"key\": \"Công suất hút\", \"value\": \"320m³/h\"}, {\"key\": \"Số tốc độ\", \"value\": \"2 tốc độ\"}, {\"key\": \"Độ ồn\", \"value\": \"57dB\"}, {\"key\": \"Kích thước\", \"value\": \"600 x 300 x 300mm\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 5, 1, '2025-08-25 01:08:18', '2025-08-25 01:15:23'),
(16, 'Bộ lọc than hoạt tính cho máy hút mùi', 'Bộ lọc than hoạt tính chất lượng cao, giúp loại bỏ mùi hôi và khói bếp hiệu quả. Phù hợp với hầu hết các loại máy hút mùi.', 'products/BemEdCyZsGBrEB6dapF0scjOR9QLjJ1IBVAdcSOJ.jpg', 100, 150000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Than hoạt tính cao cấp\"}, {\"key\": \"Kích thước\", \"value\": \"Phù hợp đa số máy hút mùi\"}, {\"key\": \"Tuổi thọ\", \"value\": \"6-12 tháng\"}, {\"key\": \"Hiệu quả\", \"value\": \"Loại bỏ 99% mùi hôi\"}, {\"key\": \"Bảo hành\", \"value\": \"3 tháng\"}]', 6, 1, '2025-08-25 01:08:18', '2025-08-25 01:14:29'),
(17, 'Bộ lọc dầu mỡ cho máy hút mùi', 'Bộ lọc dầu mỡ chuyên dụng, giúp bảo vệ động cơ máy hút mùi khỏi dầu mỡ và bụi bẩn. Dễ dàng thay thế và vệ sinh.', 'products/vzHheYWy83w7b69weF7uphGKvaTpGMs0wCbNxl6m.jpg', 80, 120000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Vải lọc chống dầu mỡ\"}, {\"key\": \"Kích thước\", \"value\": \"Phù hợp đa số máy hút mùi\"}, {\"key\": \"Tuổi thọ\", \"value\": \"3-6 tháng\"}, {\"key\": \"Hiệu quả\", \"value\": \"Lọc 95% dầu mỡ\"}, {\"key\": \"Bảo hành\", \"value\": \"3 tháng\"}]', 6, 1, '2025-08-25 01:08:18', '2025-08-25 01:14:19'),
(18, 'Ống thông gió mềm cho máy hút mùi', 'Ống thông gió mềm chất lượng cao, dễ dàng uốn cong và lắp đặt. Giúp thông gió hiệu quả cho máy hút mùi.', 'products/Gc8Y9mIv92VtuqPp5exBFIGyNJMgVdBr5Fu50sgz.jpg', 60, 180000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Nhôm mềm cao cấp\"}, {\"key\": \"Đường kính\", \"value\": \"150mm\"}, {\"key\": \"Chiều dài\", \"value\": \"2m\"}, {\"key\": \"Độ bền\", \"value\": \"Chống ăn mòn\"}, {\"key\": \"Bảo hành\", \"value\": \"6 tháng\"}]', 6, 1, '2025-08-25 01:08:18', '2025-08-25 01:13:38'),
(19, 'Van một chiều cho máy hút mùi', 'Van một chiều chống ngược gió, giúp bảo vệ máy hút mùi khỏi gió ngược và côn trùng. Dễ dàng lắp đặt và bảo trì.', 'products/EeJLQx2Q3BzfjjqGLrxFOAbRoWJItPEgzbIyfsbH.jpg', 45, 220000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Nhựa ABS cao cấp\"}, {\"key\": \"Đường kính\", \"value\": \"150mm\"}, {\"key\": \"Chức năng\", \"value\": \"Chống ngược gió\"}, {\"key\": \"Độ bền\", \"value\": \"Chống ăn mòn\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 6, 1, '2025-08-25 01:08:18', '2025-08-25 01:13:56'),
(20, 'Bộ điều khiển cảm ứng cho máy hút mùi', 'Bộ điều khiển cảm ứng hiện đại, giúp điều khiển máy hút mùi một cách dễ dàng và chính xác. Tương thích với nhiều loại máy.', 'products/UTQZM3QQxYKQ6TcnycGOM7tafSczFkEOEvfZYoOr.jpg', 35, 350000.00, '[{\"key\": \"Chất liệu\", \"value\": \"Kính cường lực\"}, {\"key\": \"Chức năng\", \"value\": \"Điều khiển cảm ứng\"}, {\"key\": \"Tương thích\", \"value\": \"Đa dạng máy hút mùi\"}, {\"key\": \"Độ bền\", \"value\": \"Chống trầy xước\"}, {\"key\": \"Bảo hành\", \"value\": \"1 năm\"}]', 6, 1, '2025-08-25 01:08:18', '2025-08-25 01:14:11');

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
(1, 'Admin', 'admin@gmail.com', '$2y$12$Q1VCTgd4D5Nd3.q7iDEWsuZBugZ0pEhQ7WTZEGs8AsmETtUOgr1Km', 'admin', NULL, '2025-08-25 01:08:18', '2025-08-25 01:08:18', '2025-08-27 08:09:00');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
