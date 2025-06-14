-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 07:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `habnest`
--

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `landlord_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `bedrooms` varchar(10) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `property_image` varchar(255) NOT NULL,
  `status` enum('available','rented') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `landlord_id`, `title`, `description`, `price`, `bedrooms`, `latitude`, `longitude`, `property_image`, `status`, `created_at`) VALUES
(7, 1, 'luxurious villa', 'this is a demo description', 5000.00, '2', 10.3569787, 37.7078610, '../uploads/properties/img_684ac30507e6d5.52367635.jpg', 'rented', '2025-06-12 12:07:33'),
(8, 1, 'demo property', 'property description', 405000.00, '3', 10.3335667, 37.7237109, '../uploads/properties/img_684ac38c880190.38403073.jpg', 'available', '2025-06-12 12:09:48'),
(10, 3, 'Spacious House', 'This charming house offers a warm and peaceful atmosphere, perfect for small families or couples. Includes two bedrooms, a living room, kitchen.', 60000.00, '3', 10.3367085, 37.7330698, '../uploads/properties/img_684ad3da318213.79212645.jpg', 'available', '2025-06-12 13:19:22'),
(11, 3, 'Smart Home', 'This tech-enabled home offers a modern lifestyle with smart locks, a digital water heater, and built-in WiFi. Safe, stylish, and future-ready.', 50000.00, '3', 10.3320433, 37.7266302, '../uploads/properties/img_684add5a2c53a4.23479885.jpg', 'available', '2025-06-12 13:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `property_imgs`
--

CREATE TABLE `property_imgs` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_imgs`
--

INSERT INTO `property_imgs` (`id`, `property_id`, `img_name`) VALUES
(13, 7, '../uploads/properties/img_684ac3050857e3.14351735.jpg'),
(14, 7, '../uploads/properties/img_684ac30508d0b4.54466777.jpg'),
(15, 8, '../uploads/properties/img_684ac38c87aba0.26285138.jpg'),
(16, 8, '../uploads/properties/img_684ac38c8866c3.77524228.jpg'),
(19, 10, '../uploads/properties/img_684ad3da30fe67.52383250.jpg'),
(20, 10, '../uploads/properties/img_684ad3da31f723.26201981.jpg'),
(21, 11, '../uploads/properties/img_684add5a2cabf7.46151246.jpg'),
(22, 11, '../uploads/properties/img_684add5a2cfc06.14347988.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'uploads/profile_pic/default_pic.png',
  `last_active` datetime DEFAULT NULL,
  `joined_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `username`, `pwd`, `phone_number`, `profile_pic`, `last_active`, `joined_at`) VALUES
(1, 'landlord', 'Abebe', 'Kebede', 'abebe_k', '$2y$10$e1ZPGi64Lx.lqb2GunF/iu.twhGrk6QKpEKBsC4xmfVs99kYaf9Ci', '0912345678', 'uploads/profile_pic/default_pic.png', NULL, '2025-06-05 08:55:53'),
(2, 'admin', 'Biniyam', 'admin', 'admin_1', '$2y$10$fZP6qL0uykXjGN6MYBikdOkHLhGNtt2KfqFnsOu.l5rD/NjxmcGLq', '0912345678', 'uploads/profile_pic/default_pic.png', NULL, '2025-06-12 15:02:35'),
(3, 'landlord', 'Natnael', 'Alemu', 'nati_a', '$2y$10$SmKgtSq4ql.4Oh4.Nr/4J.v9WulkzHHDoRBVZaw/l8LEe0wXqW5Tu', '0934543243', 'uploads/profile_pic/default_pic.png', NULL, '2025-06-12 16:16:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- Indexes for table `property_imgs`
--
ALTER TABLE `property_imgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `property_imgs`
--
ALTER TABLE `property_imgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`landlord_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_imgs`
--
ALTER TABLE `property_imgs`
  ADD CONSTRAINT `property_imgs_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
