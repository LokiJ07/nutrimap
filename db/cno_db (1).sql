-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 05:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cno_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bns_reports`
--

CREATE TABLE `bns_reports` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `year` year(4) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ind1` int(11) DEFAULT NULL,
  `ind2` int(11) DEFAULT NULL,
  `ind3` int(11) DEFAULT NULL,
  `ind4a` int(11) DEFAULT NULL,
  `ind4b` int(11) DEFAULT NULL,
  `ind5` int(11) DEFAULT NULL,
  `ind6` int(11) DEFAULT NULL,
  `ind7a` decimal(5,2) DEFAULT NULL,
  `ind7b1_no` int(11) DEFAULT NULL,
  `ind7b1_pct` decimal(5,2) DEFAULT NULL,
  `ind7b2_no` int(11) DEFAULT NULL,
  `ind7b2_pct` decimal(5,2) DEFAULT NULL,
  `ind7b3_no` int(11) DEFAULT NULL,
  `ind7b3_pct` decimal(5,2) DEFAULT NULL,
  `ind7b4_no` int(11) DEFAULT NULL,
  `ind7b4_pct` decimal(5,2) DEFAULT NULL,
  `ind7b5_no` int(11) DEFAULT NULL,
  `ind7b5_pct` decimal(5,2) DEFAULT NULL,
  `ind7b6_no` int(11) DEFAULT NULL,
  `ind7b6_pct` decimal(5,2) DEFAULT NULL,
  `ind7b7_no` int(11) DEFAULT NULL,
  `ind7b7_pct` decimal(5,2) DEFAULT NULL,
  `ind7b8_no` int(11) DEFAULT NULL,
  `ind7b8_pct` decimal(5,2) DEFAULT NULL,
  `ind7b9_no` int(11) DEFAULT NULL,
  `ind7b9_pct` decimal(5,2) DEFAULT NULL,
  `ind8` int(11) DEFAULT NULL,
  `ind9` int(11) DEFAULT NULL,
  `ind10` int(11) DEFAULT NULL,
  `ind11` int(11) DEFAULT NULL,
  `ind12` int(11) DEFAULT NULL,
  `ind13` int(11) DEFAULT NULL,
  `ind14` int(11) DEFAULT NULL,
  `ind15a_public` int(11) DEFAULT NULL,
  `ind15a_private` int(11) DEFAULT NULL,
  `ind15b_public` int(11) DEFAULT NULL,
  `ind15b_private` int(11) DEFAULT NULL,
  `ind16` int(11) DEFAULT NULL,
  `ind17` int(11) DEFAULT NULL,
  `ind18` int(11) DEFAULT NULL,
  `ind19` decimal(5,2) DEFAULT NULL,
  `ind20a_no` int(11) DEFAULT NULL,
  `ind20a_pct` decimal(5,2) DEFAULT NULL,
  `ind20b_no` int(11) DEFAULT NULL,
  `ind20b_pct` decimal(5,2) DEFAULT NULL,
  `ind20c_no` int(11) DEFAULT NULL,
  `ind20c_pct` decimal(5,2) DEFAULT NULL,
  `ind20d_no` int(11) DEFAULT NULL,
  `ind20d_pct` decimal(5,2) DEFAULT NULL,
  `ind20e_no` int(11) DEFAULT NULL,
  `ind20e_pct` decimal(5,2) DEFAULT NULL,
  `ind21` int(11) DEFAULT NULL,
  `ind22` int(11) DEFAULT NULL,
  `ind23` int(11) DEFAULT NULL,
  `ind24` int(11) DEFAULT NULL,
  `ind25` int(11) DEFAULT NULL,
  `ind26a_no` int(11) DEFAULT NULL,
  `ind26a_pct` decimal(5,2) DEFAULT NULL,
  `ind26b_no` int(11) DEFAULT NULL,
  `ind26b_pct` decimal(5,2) DEFAULT NULL,
  `ind26c_no` int(11) DEFAULT NULL,
  `ind26c_pct` decimal(5,2) DEFAULT NULL,
  `ind26d_no` int(11) DEFAULT NULL,
  `ind26d_pct` decimal(5,2) DEFAULT NULL,
  `ind27a_no` int(11) DEFAULT NULL,
  `ind27a_pct` decimal(5,2) DEFAULT NULL,
  `ind27b_no` int(11) DEFAULT NULL,
  `ind27b_pct` decimal(5,2) DEFAULT NULL,
  `ind27c_no` int(11) DEFAULT NULL,
  `ind27c_pct` decimal(5,2) DEFAULT NULL,
  `ind27d_no` int(11) DEFAULT NULL,
  `ind27d_pct` decimal(5,2) DEFAULT NULL,
  `ind28a_no` int(11) DEFAULT NULL,
  `ind28a_pct` decimal(5,2) DEFAULT NULL,
  `ind28b_no` int(11) DEFAULT NULL,
  `ind28b_pct` decimal(5,2) DEFAULT NULL,
  `ind28c_no` int(11) DEFAULT NULL,
  `ind28c_pct` decimal(5,2) DEFAULT NULL,
  `ind28d_no` int(11) DEFAULT NULL,
  `ind28d_pct` decimal(5,2) DEFAULT NULL,
  `ind28e_no` int(11) DEFAULT NULL,
  `ind28e_pct` decimal(5,2) DEFAULT NULL,
  `ind29a_no` int(11) DEFAULT NULL,
  `ind29a_pct` decimal(5,2) DEFAULT NULL,
  `ind29b_no` int(11) DEFAULT NULL,
  `ind29b_pct` decimal(5,2) DEFAULT NULL,
  `ind29c_no` int(11) DEFAULT NULL,
  `ind29c_pct` decimal(5,2) DEFAULT NULL,
  `ind29d_no` int(11) DEFAULT NULL,
  `ind29d_pct` decimal(5,2) DEFAULT NULL,
  `ind29e_no` int(11) DEFAULT NULL,
  `ind29e_pct` decimal(5,2) DEFAULT NULL,
  `ind30a_no` int(11) DEFAULT NULL,
  `ind30a_pct` decimal(5,2) DEFAULT NULL,
  `ind30b_no` int(11) DEFAULT NULL,
  `ind30b_pct` decimal(5,2) DEFAULT NULL,
  `ind30c_no` int(11) DEFAULT NULL,
  `ind30c_pct` decimal(5,2) DEFAULT NULL,
  `ind30d_no` int(11) DEFAULT NULL,
  `ind30d_pct` decimal(5,2) DEFAULT NULL,
  `ind30e_no` int(11) DEFAULT NULL,
  `ind30e_pct` decimal(5,2) DEFAULT NULL,
  `ind31` int(11) DEFAULT NULL,
  `ind32` int(11) DEFAULT NULL,
  `ind33` int(11) DEFAULT NULL,
  `ind34` int(11) DEFAULT NULL,
  `ind35a` int(11) DEFAULT NULL,
  `ind35b` int(11) DEFAULT NULL,
  `ind36` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bns_reports`
--

INSERT INTO `bns_reports` (`id`, `report_id`, `barangay`, `year`, `title`, `ind1`, `ind2`, `ind3`, `ind4a`, `ind4b`, `ind5`, `ind6`, `ind7a`, `ind7b1_no`, `ind7b1_pct`, `ind7b2_no`, `ind7b2_pct`, `ind7b3_no`, `ind7b3_pct`, `ind7b4_no`, `ind7b4_pct`, `ind7b5_no`, `ind7b5_pct`, `ind7b6_no`, `ind7b6_pct`, `ind7b7_no`, `ind7b7_pct`, `ind7b8_no`, `ind7b8_pct`, `ind7b9_no`, `ind7b9_pct`, `ind8`, `ind9`, `ind10`, `ind11`, `ind12`, `ind13`, `ind14`, `ind15a_public`, `ind15a_private`, `ind15b_public`, `ind15b_private`, `ind16`, `ind17`, `ind18`, `ind19`, `ind20a_no`, `ind20a_pct`, `ind20b_no`, `ind20b_pct`, `ind20c_no`, `ind20c_pct`, `ind20d_no`, `ind20d_pct`, `ind20e_no`, `ind20e_pct`, `ind21`, `ind22`, `ind23`, `ind24`, `ind25`, `ind26a_no`, `ind26a_pct`, `ind26b_no`, `ind26b_pct`, `ind26c_no`, `ind26c_pct`, `ind26d_no`, `ind26d_pct`, `ind27a_no`, `ind27a_pct`, `ind27b_no`, `ind27b_pct`, `ind27c_no`, `ind27c_pct`, `ind27d_no`, `ind27d_pct`, `ind28a_no`, `ind28a_pct`, `ind28b_no`, `ind28b_pct`, `ind28c_no`, `ind28c_pct`, `ind28d_no`, `ind28d_pct`, `ind28e_no`, `ind28e_pct`, `ind29a_no`, `ind29a_pct`, `ind29b_no`, `ind29b_pct`, `ind29c_no`, `ind29c_pct`, `ind29d_no`, `ind29d_pct`, `ind29e_no`, `ind29e_pct`, `ind30a_no`, `ind30a_pct`, `ind30b_no`, `ind30b_pct`, `ind30c_no`, `ind30c_pct`, `ind30d_no`, `ind30d_pct`, `ind30e_no`, `ind30e_pct`, `ind31`, `ind32`, `ind33`, `ind34`, `ind35a`, `ind35b`, `ind36`) VALUES
(1, 3, 'Amoros', '2025', '', 1, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 1, 0, 0),
(2, 4, 'Amoros', '2025', '', 1, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 1, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 1, 0, 0),
(3, 5, 'Amoros', '2025', '', 1, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0),
(4, 6, 'Amoros', '2025', '', 1, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0),
(5, 7, 'Amoros', '2025', '', 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0),
(6, 8, 'Amoros', '2025', '', 112, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 123, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0),
(7, 9, 'Amoros', '2025', '', 1, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_codes`
--

INSERT INTO `otp_codes` (`id`, `user_id`, `otp_code`, `created_at`, `expires_at`) VALUES
(9, 2, '970074', '2025-09-15 05:23:48', '2025-09-15 07:28:48'),
(10, 2, '699247', '2025-09-15 11:57:40', '2025-09-15 14:02:40'),
(11, 5, '949655', '2025-09-15 14:36:52', '2025-09-15 16:41:52'),
(12, 5, '796328', '2025-09-15 14:37:01', '2025-09-15 16:42:01'),
(13, 2, '258143', '2025-09-16 03:31:44', '2025-09-16 05:36:44'),
(14, 2, '227212', '2025-09-17 13:22:29', '2025-09-17 15:27:29'),
(15, 2, '284633', '2025-09-18 01:00:43', '2025-09-18 03:05:43'),
(16, 2, '171406', '2025-09-18 01:00:49', '2025-09-18 03:05:49'),
(17, 2, '316970', '2025-09-18 03:05:36', '2025-09-18 05:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_time` time NOT NULL,
  `report_date` date NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `report_time`, `report_date`, `status`) VALUES
(3, 2, '04:15:32', '2025-09-18', 'Pending'),
(4, 2, '04:16:20', '2025-09-18', 'Pending'),
(5, 2, '04:23:42', '2025-09-18', 'Pending'),
(6, 2, '04:32:07', '2025-09-18', 'Pending'),
(7, 2, '04:41:52', '2025-09-18', 'Pending'),
(8, 2, '04:43:02', '2025-09-18', 'Pending'),
(9, 2, '05:06:26', '2025-09-18', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `barangay` enum('CNO','Amoros','Bolisong','Cogon','Himaya','Hinigdaan','Kalabaylabay','Molugan','Pedro S. Baculio','Poblacion','Quibonbon','Sambulawan','San Francisco de Asis','Sinaloc','Taytay','Ulaliman') NOT NULL,
  `user_type` enum('BNS','CNO') NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `phone_number`, `email`, `address`, `barangay`, `user_type`, `password_hash`, `created_at`) VALUES
(2, 'Dan', 'Javier', 'dan', '09781716517', 'danmarkpetalcurin@gmail.com', 'st, joseph', 'Amoros', 'BNS', '$2y$10$z3vwZl.fpBSJAlPXAz4HTe8rKCVJTRd1CuYUun1YW9Se3s31NTydS', '2025-09-13 13:18:11'),
(5, 'arl', 'ly', 'arly', '09476445486', 'audreyabigailhisanza.9@gmail.com', 'Tankulan', 'CNO', 'CNO', '$2y$10$hTi9BrY3K5Q0NOo35AA9oO5ahG3KG4ZTzssgWVturWIwI2rRJQi06', '2025-09-15 14:36:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bns_reports`
--
ALTER TABLE `bns_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bns_reports`
--
ALTER TABLE `bns_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bns_reports`
--
ALTER TABLE `bns_reports`
  ADD CONSTRAINT `bns_reports_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
