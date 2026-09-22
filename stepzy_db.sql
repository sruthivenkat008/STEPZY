-- =========================================================================
-- STEPZY E-COMMERCE PHP & MYSQL DATABASE SCHEMA
-- =========================================================================

CREATE DATABASE IF NOT EXISTS `stepzy_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `stepzy_db`;

CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(80) NOT NULL,
    `slug` VARCHAR(80) NOT NULL UNIQUE,
    `tag_label` VARCHAR(120) NOT NULL,
    `image_url` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `category_id` INT NULL,
    `category_slug` VARCHAR(80) NOT NULL,
    `division` VARCHAR(120) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `original_price` DECIMAL(10, 2) NULL,
    `rating` DECIMAL(2, 1) DEFAULT 4.8,
    `review_count` INT DEFAULT 0,
    `badge_text` VARCHAR(50) NULL,
    `badge_class` VARCHAR(50) NULL,
    `image_url` TEXT NOT NULL,
    `sizes` VARCHAR(120) NOT NULL DEFAULT 'US 8, US 9, US 10, US 11',
    `is_new` TINYINT(1) DEFAULT 0,
    `is_sale` TINYINT(1) DEFAULT 0,
    `stock_quantity` INT DEFAULT 50,
    `description` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category_slug`),
    INDEX `idx_is_new` (`is_new`),
    INDEX `idx_is_sale` (`is_sale`),
    CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` VARCHAR(20) DEFAULT 'customer',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(60) NOT NULL UNIQUE,
    `user_id` INT NULL,
    `customer_name` VARCHAR(150) NOT NULL,
    `customer_email` VARCHAR(150) NOT NULL,
    `delivery_address` TEXT NOT NULL,
    `payment_method` VARCHAR(50) DEFAULT 'Card',
    `card_last4` VARCHAR(4) NULL,
    `subtotal` DECIMAL(10, 2) NOT NULL,
    `shipping_fee` DECIMAL(10, 2) DEFAULT 0.00,
    `total_amount` DECIMAL(10, 2) NOT NULL,
    `status` VARCHAR(50) DEFAULT 'IN_TRANSIT',
    `status_step` INT DEFAULT 3,
    `carrier` VARCHAR(80) DEFAULT 'DHL Express Air Priority',
    `tracking_number` VARCHAR(80) NULL,
    `estimated_delivery` VARCHAR(100) DEFAULT 'In 2 Business Days',
    `items_json` JSON NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_order_num` (`order_number`),
    INDEX `idx_cust_email` (`customer_email`),
    CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `subscribers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `discount_code` VARCHAR(50) DEFAULT 'STEPZY15',
    `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(150) DEFAULT 'General Inquiry',
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `tag_label`, `image_url`) VALUES
(1, 'Men', 'men', 'High Propulsion', 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=800&q=80'),
(2, 'Women', 'women', 'Agile & Ultra-Light', 'https://images.unsplash.com/photo-1508609349937-5ec4ae374ebf?auto=format&fit=crop&w=800&q=80'),
(3, 'Kids', 'kids', 'Durability & Cushion', 'https://images.unsplash.com/photo-1514989940723-e8e51635b782?auto=format&fit=crop&w=800&q=80'),
(4, 'Sports', 'sports', 'Marathon, Court & Track', 'https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=800&q=80')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `tag_label`=VALUES(`tag_label`), `image_url`=VALUES(`image_url`);

INSERT INTO `products` (`id`, `name`, `category_id`, `category_slug`, `division`, `price`, `original_price`, `rating`, `review_count`, `badge_text`, `badge_class`, `image_url`, `sizes`, `is_new`, `is_sale`, `stock_quantity`, `description`) VALUES
(1, 'Stepzy Pulse Runner', 1, 'men', 'Men • Running & Training', 129.99, 159.99, 4.9, 1420, 'POPULAR', 'badge-purple', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80', 'US 8, US 9, US 10, US 11', 0, 1, 45, 'Ultra-responsive cushioning with adaptive knit upper.'),
(2, 'Stepzy Horizon Lilac', 2, 'women', 'Women • Sprint & Studio', 139.99, 160.00, 4.8, 840, 'NEW DROP', 'badge-purple', 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&w=600&q=80', 'US 6, US 7, US 8, US 9', 1, 0, 40, 'Signature pastel lilac hue with high rebound cloudfoam.'),
(3, 'Stepzy Apex Carbon', 4, 'sports', 'Sports • Carbon Speed', 179.99, 210.00, 5.0, 2350, 'PRO MARATHON', 'badge-green', 'https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=600&q=80', 'US 8.5, US 9.5, US 10.5, US 11.5', 1, 0, 30, 'Full-length spoon shaped carbon plate engineered for snappy stride.'),
(4, 'Stepzy Junior Dynamo', 3, 'kids', 'Kids • Playground Active', 69.99, 85.00, 4.7, 410, 'YOUTH BEST', 'badge-purple', 'https://images.unsplash.com/photo-1514989940723-e8e51635b782?auto=format&fit=crop&w=600&q=80', '1Y, 2Y, 3Y, 4Y, 5Y', 0, 1, 60, 'Reinforced rubber toe bumper and quick-lock bungee toggle.'),
(5, 'Stepzy Phantom Knit', 1, 'men', 'Men • Street & Track', 119.99, 169.99, 4.8, 920, '30% OFF', 'badge-red', 'https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?auto=format&fit=crop&w=600&q=80', 'US 8, US 9, US 10, US 11, US 12', 0, 1, 35, 'Chunky modern silhouette with shock-absorbing hexagonal outsole.'),
(6, 'Stepzy Aero Strike', 4, 'sports', 'Sports • Pro Track', 164.99, 190.00, 4.9, 1180, 'HIGH PROPULSION', 'badge-green', 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?auto=format&fit=crop&w=600&q=80', 'US 8, US 9, US 10, US 11', 0, 1, 28, 'Competition level lateral stability with featherweight mono-mesh.'),
(7, 'Stepzy TrailBlaze GTX', 4, 'sports', 'Sports • Rugged Outdoor', 189.99, NULL, 4.9, 830, 'WATERPROOF', 'badge-dark', 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80', 'US 8.5, US 9.5, US 10.5, US 11.5', 1, 0, 22, 'GORE-TEX weatherproofing with Vibram mega-grip chevron lugs.'),
(8, 'Stepzy Street Rebel', 1, 'men', 'Men • Urban Streetwear', 109.99, 135.00, 4.6, 780, 'SAVE $25', 'badge-red', 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=600&q=80', 'US 8, US 9, US 10, US 11', 0, 1, 55, 'Bold chunky silhouette with abrasion-resistant vulcanized rubber.'),
(9, 'Stepzy Hyper Dash', 3, 'kids', 'Kids • Playground All-Star', 59.99, 75.00, 4.8, 430, 'SPECIAL', 'badge-purple', 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?auto=format&fit=crop&w=600&q=80', '2Y, 3Y, 4Y, 5Y', 0, 1, 70, 'Reinforced heel stability cage for high active playgrounds.'),
(10, 'Stepzy Pure Horizon', 2, 'women', 'Women • Daily Cushioning', 124.99, NULL, 4.7, 860, 'JUST IN', 'badge-purple', 'https://images.unsplash.com/photo-1575537302964-96cd47c06b1b?auto=format&fit=crop&w=600&q=80', 'US 6, US 7, US 8, US 9', 1, 0, 50, 'Feather-soft step in feel for all-day recovery and walks.'),
(11, 'Stepzy Swift Orbit', 1, 'men', 'Men • Sprint & Gym', 134.99, NULL, 4.8, 640, 'LIMITED', 'badge-purple', 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=600&q=80', 'US 8, US 9, US 10, US 11', 1, 0, 22, 'Lateral containment walls for heavy lifting and explosive sprint drills.'),
(12, 'Stepzy Breeze Flow', 2, 'women', 'Women • Aerobic Slip', 119.99, 145.00, 4.6, 490, 'CLEARANCE', 'badge-red', 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=600&q=80', 'US 6, US 7, US 8, US 9', 0, 1, 45, 'Easy slip-on collar with dynamic arch band support.'),
(13, 'Stepzy Junior Skate', 3, 'kids', 'Kids • Skate & Active', 64.99, 80.00, 4.8, 710, 'FLEX SOLE', 'badge-dark', 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=600&q=80', '2Y, 3Y, 4Y, 5Y', 1, 1, 65, 'Cupsole board feel and double-stitched leather panels.')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `price`=VALUES(`price`);
