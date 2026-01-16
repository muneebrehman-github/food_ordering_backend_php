-- Food Ordering System Database Schema
-- Generated from Laravel Migrations
-- Compatible with MySQL/MariaDB

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Database: food_ordering
-- --------------------------------------------------------

-- Drop tables if they exist (in reverse order of dependencies)
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `cart_items`;
DROP TABLE IF EXISTS `carts`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `food_items`;
DROP TABLE IF EXISTS `user_roles`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

-- --------------------------------------------------------
-- Table structure for table `roles`
-- --------------------------------------------------------

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_phone_index` (`phone`),
  KEY `users_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `user_roles`
-- --------------------------------------------------------

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `food_items`
-- --------------------------------------------------------

CREATE TABLE `food_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `food_items_featured_index` (`featured`),
  KEY `food_items_active_index` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `reviews`
-- --------------------------------------------------------

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `food_item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_food_item_id_index` (`food_item_id`),
  KEY `reviews_user_id_index` (`user_id`),
  CONSTRAINT `reviews_food_item_id_foreign` FOREIGN KEY (`food_item_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `carts`
-- --------------------------------------------------------

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_unique` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `cart_items`
-- --------------------------------------------------------

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `food_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_index` (`cart_id`),
  KEY `cart_items_food_item_id_index` (`food_item_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_food_item_id_foreign` FOREIGN KEY (`food_item_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `delivery_address` varchar(500) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `notes` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_index` (`user_id`),
  KEY `orders_status_index` (`status`),
  KEY `orders_created_at_index` (`created_at`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `food_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_index` (`order_id`),
  KEY `order_items_food_item_id_index` (`food_item_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_food_item_id_foreign` FOREIGN KEY (`food_item_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Insert initial data
-- --------------------------------------------------------

-- Insert roles
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', NOW(), NOW()),
(2, 'CUSTOMER', NOW(), NOW());

-- Insert admin user (password: admin123)
-- WARNING: This is a default password hash. CHANGE IT IMMEDIATELY in production!
-- To generate a new password hash, run: php artisan tinker
-- Then: Hash::make('your_new_password')
-- Or use: php -r "echo password_hash('your_password', PASSWORD_BCRYPT);"
INSERT INTO `users` (`id`, `full_name`, `phone`, `email`, `password`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', '+1234567890', 'admin@foodordering.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), NOW());

-- Assign admin role to admin user
INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1);

-- Insert sample food items
INSERT INTO `food_items` (`id`, `name`, `description`, `price`, `image_url`, `active`, `featured`, `stock_quantity`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Margherita Pizza', 'Classic pizza with tomato sauce, mozzarella, and fresh basil', 12.99, 'https://example.com/pizza-margherita.jpg', 1, 1, 50, 'Pizza', NOW(), NOW()),
(2, 'Pepperoni Pizza', 'Traditional pizza with pepperoni and mozzarella cheese', 14.99, 'https://example.com/pizza-pepperoni.jpg', 1, 1, 45, 'Pizza', NOW(), NOW()),
(3, 'Chicken Burger', 'Juicy grilled chicken breast with lettuce, tomato, and special sauce', 9.99, 'https://example.com/burger-chicken.jpg', 1, 1, 60, 'Burgers', NOW(), NOW()),
(4, 'Beef Burger', 'Classic beef patty with cheese, pickles, and onions', 10.99, 'https://example.com/burger-beef.jpg', 1, 0, 55, 'Burgers', NOW(), NOW()),
(5, 'Caesar Salad', 'Fresh romaine lettuce with caesar dressing, croutons, and parmesan', 8.99, 'https://example.com/salad-caesar.jpg', 1, 0, 40, 'Salads', NOW(), NOW()),
(6, 'Greek Salad', 'Mixed greens with feta cheese, olives, and olive oil dressing', 9.49, 'https://example.com/salad-greek.jpg', 1, 0, 35, 'Salads', NOW(), NOW()),
(7, 'Chicken Wings', 'Crispy fried chicken wings with your choice of sauce', 11.99, 'https://example.com/wings.jpg', 1, 1, 70, 'Appetizers', NOW(), NOW()),
(8, 'French Fries', 'Golden crispy french fries served with ketchup', 4.99, 'https://example.com/fries.jpg', 1, 0, 100, 'Sides', NOW(), NOW()),
(9, 'Onion Rings', 'Battered and fried onion rings', 5.99, 'https://example.com/onion-rings.jpg', 1, 0, 80, 'Sides', NOW(), NOW()),
(10, 'Chocolate Cake', 'Rich chocolate layer cake with frosting', 6.99, 'https://example.com/cake-chocolate.jpg', 1, 1, 30, 'Desserts', NOW(), NOW()),
(11, 'Cheesecake', 'New York style cheesecake with berry topping', 7.99, 'https://example.com/cheesecake.jpg', 1, 0, 25, 'Desserts', NOW(), NOW()),
(12, 'Ice Cream Sundae', 'Vanilla ice cream with hot fudge and whipped cream', 5.99, 'https://example.com/sundae.jpg', 1, 0, 50, 'Desserts', NOW(), NOW()),
(13, 'Coca Cola', 'Refreshing cola drink', 2.99, 'https://example.com/coke.jpg', 1, 0, 200, 'Beverages', NOW(), NOW()),
(14, 'Orange Juice', 'Fresh squeezed orange juice', 3.49, 'https://example.com/oj.jpg', 1, 0, 150, 'Beverages', NOW(), NOW()),
(15, 'Coffee', 'Hot brewed coffee', 2.49, 'https://example.com/coffee.jpg', 1, 0, 180, 'Beverages', NOW(), NOW());

COMMIT;

