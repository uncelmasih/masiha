-- BNG Shop Database Schema
-- Drop existing tables if they exist
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `cart`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `payment_logs`;

-- Users table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT 1,
  `email_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories table
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products table
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `gallery_images` text DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `digital_content` text DEFAULT NULL,
  `delivery_method` enum('instant','manual','email') DEFAULT 'instant',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cart table
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Orders table
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL UNIQUE,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','processing','completed','cancelled','refunded') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT 'zarinpal',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `payment_reference` varchar(100) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items table
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `digital_content` text DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Payment logs table
CREATE TABLE `payment_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `authority` varchar(100) DEFAULT NULL,
  `ref_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role`, `is_active`, `email_verified`) VALUES
('admin', 'bngshop@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدیر سایت', 'admin', 1, 1);

-- Insert categories
INSERT INTO `categories` (`name`, `slug`, `description`, `icon`, `sort_order`) VALUES
('گیفت کارت Steam', 'steam-gift-cards', 'گیفت کارت‌های Steam برای خرید بازی و محتوای اضافی', 'fab fa-steam', 1),
('گیفت کارت Google Play', 'google-play-gift-cards', 'گیفت کارت‌های Google Play برای فروشگاه گوگل', 'fab fa-google-play', 2),
('گیفت کارت Apple Store', 'apple-store-gift-cards', 'گیفت کارت‌های App Store و iTunes', 'fab fa-apple', 3),
('گیفت کارت PlayStation', 'playstation-gift-cards', 'گیفت کارت‌های PlayStation Network', 'fab fa-playstation', 4),
('گیفت کارت Xbox', 'xbox-gift-cards', 'گیفت کارت‌های Xbox Live', 'fab fa-xbox', 5),
('پرداخت درون برنامه‌ای', 'in-app-purchases', 'خرید الماس، جم و ارز بازی‌های موبایلی', 'fas fa-mobile-alt', 6),
('بازی‌های PC', 'pc-games', 'کلیدهای اورجینال بازی‌های کامپیوتر', 'fas fa-desktop', 7),
('اکانت‌های پریمیوم', 'premium-accounts', 'اکانت‌های Netflix، Spotify، YouTube Premium', 'fas fa-star', 8),
('خدمات آنلاین', 'online-services', 'VPN، آنتی ویروس و سایر خدمات', 'fas fa-cloud', 9),
('گیفت کارت‌های دیگر', 'other-gift-cards', 'Amazon، Netflix، Spotify و سایر گیفت کارت‌ها', 'fas fa-gift', 10);

-- Insert sample products
INSERT INTO `products` (`name`, `slug`, `description`, `short_description`, `price`, `discount_price`, `category_id`, `stock_quantity`, `digital_content`, `is_featured`, `tags`) VALUES
('Steam Wallet 10$', 'steam-wallet-10', 'گیفت کارت Steam به ارزش 10 دلار برای خرید بازی و محتوای اضافی در فروشگاه Steam', 'گیفت کارت Steam 10 دلاری', 500000, 450000, 1, 100, 'کد تحویل فوری پس از پرداخت', 1, 'steam,gift card,gaming'),
('Google Play Gift Card 50$', 'google-play-50', 'گیفت کارت Google Play 50 دلاری برای خرید اپلیکیشن، بازی و محتوای دیجیتال', 'گیفت کارت Google Play 50 دلار', 2300000, 2200000, 2, 50, 'کد تحویل فوری', 1, 'google play,android,gift card'),
('PUBG Mobile UC 8100', 'pubg-uc-8100', '8100 UC برای بازی PUBG Mobile - تحویل فوری و امن', '8100 UC پابجی موبایل', 1200000, 1100000, 6, 200, 'شارژ مستقیم در اکانت', 1, 'pubg,uc,mobile gaming'),
('PlayStation Plus 12 Month', 'ps-plus-12-month', 'اشتراک 12 ماهه PlayStation Plus - دسترسی به بازی‌های رایگان و تخفیف‌ها', 'PS Plus 12 ماهه', 3500000, 3200000, 4, 30, 'کد فعال‌سازی', 1, 'playstation,ps plus,subscription'),
('Netflix Premium 1 Month', 'netflix-premium-1month', 'اشتراک یک ماهه Netflix Premium - تماشای فیلم و سریال', 'Netflix پریمیوم 1 ماه', 250000, NULL, 8, 100, 'اطلاعات اکانت', 1, 'netflix,streaming,premium'),
('Free Fire Diamond 2200', 'free-fire-diamond-2200', '2200 الماس Free Fire - تحویل فوری و امن', '2200 الماس فری فایر', 800000, 750000, 6, 150, 'شارژ مستقیم', 1, 'free fire,diamond,mobile'),
('Steam Wallet 20$', 'steam-wallet-20', 'گیفت کارت Steam 20 دلاری', 'Steam 20 دلار', 950000, 900000, 1, 80, 'کد تحویل فوری', 1, 'steam,gaming'),
('Xbox Game Pass Ultimate 3 Month', 'xbox-gamepass-3month', 'اشتراک 3 ماهه Xbox Game Pass Ultimate', 'Xbox Game Pass 3 ماه', 1800000, 1650000, 5, 25, 'کد فعال‌سازی', 1, 'xbox,gamepass,subscription');

-- Update auto increment for better order numbers
ALTER TABLE `orders` AUTO_INCREMENT = 1000;