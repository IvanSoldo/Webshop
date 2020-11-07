-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2020 at 03:34 PM
-- Server version: 8.0.21-0ubuntu0.20.04.4
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` int NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `city`, `postal_code`, `address`) VALUES
(21, 'Vinkovci', 32100, 'Vrtna 29'),
(116, 'Vinkovci', 32100, 'Centar 6'),
(119, 'Osijek', 31000, 'Centar 6'),
(120, 'Vinkovci', 32100, 'Centar 1');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`) VALUES
(1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `id` int NOT NULL,
  `cart_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(9, 'Garden', '<div>Our&nbsp;<strong>Garden&nbsp;</strong>collection.</div>'),
(13, 'Living Room', '<div>Our <strong>Living Room</strong> collection.</div>'),
(15, 'Dining Room', '<div>Our&nbsp;<strong>Dining Room&nbsp;</strong>collection.</div>'),
(16, 'Storage', '<div>Our&nbsp;<strong>Storage</strong>&nbsp;collection</div>'),
(17, 'Bedroom', '<div>Our&nbsp;<strong>Bedroom&nbsp;</strong>collection.</div>');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201020110000', '2020-10-20 13:00:38', 159),
('DoctrineMigrations\\Version20201020130247', '2020-10-20 15:02:54', 125),
('DoctrineMigrations\\Version20201020132343', '2020-10-21 09:25:26', 212),
('DoctrineMigrations\\Version20201021080705', '2020-10-21 10:07:11', 398),
('DoctrineMigrations\\Version20201021080856', '2020-10-21 10:09:02', 669),
('DoctrineMigrations\\Version20201021081130', '2020-10-21 10:11:37', 305),
('DoctrineMigrations\\Version20201021081306', '2020-10-21 10:13:11', 218),
('DoctrineMigrations\\Version20201021085201', '2020-10-21 10:52:16', 550),
('DoctrineMigrations\\Version20201021085344', '2020-10-21 10:53:49', 133),
('DoctrineMigrations\\Version20201022123349', '2020-10-22 14:34:02', 239),
('DoctrineMigrations\\Version20201025122614', '2020-10-25 13:26:25', 147),
('DoctrineMigrations\\Version20201025123325', '2020-10-25 13:33:31', 132),
('DoctrineMigrations\\Version20201026135803', '2020-10-26 14:58:20', 324),
('DoctrineMigrations\\Version20201026142023', '2020-10-26 15:20:34', 510),
('DoctrineMigrations\\Version20201027084855', '2020-10-27 09:49:11', 136),
('DoctrineMigrations\\Version20201028073915', '2020-10-28 08:39:25', 168),
('DoctrineMigrations\\Version20201028075417', '2020-10-28 08:54:21', 122),
('DoctrineMigrations\\Version20201028134033', '2020-10-28 14:44:10', 522),
('DoctrineMigrations\\Version20201028134728', '2020-10-28 14:47:34', 297),
('DoctrineMigrations\\Version20201029121626', '2020-10-29 13:16:46', 478),
('DoctrineMigrations\\Version20201029142412', '2020-10-29 15:24:28', 322),
('DoctrineMigrations\\Version20201029155140', '2020-10-29 16:51:46', 159),
('DoctrineMigrations\\Version20201029155426', '2020-10-29 16:54:32', 396),
('DoctrineMigrations\\Version20201030094536', '2020-10-30 10:45:43', 322),
('DoctrineMigrations\\Version20201030094917', '2020-10-30 10:49:23', 155),
('DoctrineMigrations\\Version20201030100824', '2020-10-30 11:08:30', 297),
('DoctrineMigrations\\Version20201030101016', '2020-10-30 11:10:22', 147),
('DoctrineMigrations\\Version20201030101133', '2020-10-30 13:49:48', 410),
('DoctrineMigrations\\Version20201030123656', '2020-10-30 13:41:48', 364),
('DoctrineMigrations\\Version20201030125450', '2020-10-30 13:55:38', 292),
('DoctrineMigrations\\Version20201030135516', '2020-10-30 14:55:29', 149),
('DoctrineMigrations\\Version20201031101106', '2020-10-31 11:11:12', 243),
('DoctrineMigrations\\Version20201031101629', '2020-10-31 11:16:35', 140),
('DoctrineMigrations\\Version20201102092948', '2020-11-02 10:30:02', 151),
('DoctrineMigrations\\Version20201102102238', '2020-11-02 11:22:44', 225),
('DoctrineMigrations\\Version20201103093713', '2020-11-03 10:37:28', 212),
('DoctrineMigrations\\Version20201103102054', '2020-11-03 11:20:59', 152),
('DoctrineMigrations\\Version20201103111506', '2020-11-03 12:15:12', 538),
('DoctrineMigrations\\Version20201104101215', '2020-11-04 11:12:26', 315),
('DoctrineMigrations\\Version20201104102020', '2020-11-04 11:20:25', 144);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `address_id` int NOT NULL,
  `status_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int NOT NULL,
  `orders_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price_on_order_submit` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_predefined` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`, `is_predefined`) VALUES
(8, 'Submitted', 1),
(9, 'Completed', 1),
(10, 'Canceled', 1),
(14, 'Delayed', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_active` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `quantity` int NOT NULL,
  `on_discount` tinyint(1) NOT NULL,
  `discount_percentage` int DEFAULT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `picture`, `product_active`, `updated_at`, `quantity`, `on_discount`, `discount_percentage`, `created_at`) VALUES
(39, 'Brown Sofa', 100, 'Comfy brown sofa', '5fa3e729e6b9d430759976.jpg', 1, '2020-11-05 12:51:05', 4, 0, 1, '2020-11-05'),
(40, 'Gray Sofa', 100, 'Comfy gray sofa', '5fa3e7827e213104898382.jpeg', 1, '2020-11-05 12:52:34', 4, 1, 15, '2020-11-05'),
(41, 'Chair', 20, 'Sturdy wooden chair', '5fa3ec4e0fa20574410915.jpg', 1, '2020-11-05 13:13:02', 5, 0, 1, '2020-11-05'),
(42, 'Bed', 60, 'Sturdy single bed', '5fa3ee0494e47351320695.jpeg', 1, '2020-11-05 13:20:20', 5, 0, 1, '2020-11-05'),
(43, 'Table', 70, 'Sturdy oak table', '5fa3eefad8b13323750573.jpg', 1, '2020-11-05 13:24:26', 5, 0, 1, '2020-11-05'),
(44, 'Wardrobe', 100, 'Sturdy oak wardrobe', '5fa3ef6104d97364727938.jpeg', 1, '2020-11-05 13:26:09', 5, 0, 1, '2020-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(39, 13),
(40, 13),
(41, 9),
(41, 15),
(42, 17),
(43, 15),
(44, 16),
(44, 17);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int NOT NULL,
  `address_id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `address_id`, `email`) VALUES
(3, 119, 'webshopOs@webshop.com'),
(4, 120, 'webshopVk@webshop.com');

-- --------------------------------------------------------

--
-- Table structure for table `store_settings`
--

CREATE TABLE `store_settings` (
  `id` int NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_products_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_settings`
--

INSERT INTO `store_settings` (`id`, `store_name`, `address_id`, `email`, `new_products_date`) VALUES
(1, 'Webshop', 116, 'pero13@admin.com', '2020-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `address_id`) VALUES
(25, 'admin@admin.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$fKh8+mf1bg5iEiwv/cxbTA$GhU1mN3PpGtP9ZidlKagVJcjz5s2Awnb2VKRSIs29p0', 'Ivan', 'Soldo', 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BA388B7A76ED395` (`user_id`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2890CCAA1AD5CDBF` (`cart_id`),
  ADD KEY `IDX_2890CCAA4584665A` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F5299398F5B7AF75` (`address_id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`),
  ADD KEY `IDX_F52993986BF700BD` (`status_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2530ADE6CFFE9AD6` (`orders_id`),
  ADD KEY `IDX_2530ADE64584665A` (`product_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `IDX_CDFC73564584665A` (`product_id`),
  ADD KEY `IDX_CDFC735612469DE2` (`category_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_AC6A4CA2F5B7AF75` (`address_id`);

--
-- Indexes for table `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_DB32DF3FF5B7AF75` (`address_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D649F5B7AF75` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `FK_2890CCAA1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_2890CCAA4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993986BF700BD` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`id`),
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F5299398F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `FK_2530ADE64584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_2530ADE6CFFE9AD6` FOREIGN KEY (`orders_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `FK_CDFC735612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CDFC73564584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `FK_AC6A4CA2F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Constraints for table `store_settings`
--
ALTER TABLE `store_settings`
  ADD CONSTRAINT `FK_DB32DF3FF5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
