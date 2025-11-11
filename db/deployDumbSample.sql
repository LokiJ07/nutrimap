-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql309.byetcluster.com
-- Generation Time: Nov 10, 2025 at 09:19 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40031431_nutri_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
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
  `ind_male` int(11) DEFAULT NULL,
  `ind_female` int(11) DEFAULT NULL,
  `ind2` int(11) DEFAULT NULL,
  `ind3` int(11) DEFAULT NULL,
  `ind4` int(11) DEFAULT NULL,
  `ind5` int(11) DEFAULT NULL,
  `ind6a` int(11) DEFAULT NULL,
  `ind6b` int(11) DEFAULT NULL,
  `ind7` int(11) DEFAULT NULL,
  `ind8` int(11) DEFAULT NULL,
  `ind9` int(11) DEFAULT NULL,
  `ind9a` decimal(5,2) DEFAULT NULL,
  `ind9b1_no` int(11) DEFAULT NULL,
  `ind9b1_pct` decimal(5,2) DEFAULT NULL,
  `ind9b2_no` int(11) DEFAULT NULL,
  `ind9b2_pct` decimal(5,2) DEFAULT NULL,
  `ind9b3_no` int(11) DEFAULT NULL,
  `ind9b3_pct` decimal(5,2) DEFAULT NULL,
  `ind9b4_no` int(11) DEFAULT NULL,
  `ind9b4_pct` decimal(5,2) DEFAULT NULL,
  `ind9b5_no` int(11) DEFAULT NULL,
  `ind9b5_pct` decimal(5,2) DEFAULT NULL,
  `ind9b6_no` int(11) DEFAULT NULL,
  `ind9b6_pct` decimal(5,2) DEFAULT NULL,
  `ind9b7_no` int(11) DEFAULT NULL,
  `ind9b7_pct` decimal(5,2) DEFAULT NULL,
  `ind9b8_no` int(11) DEFAULT NULL,
  `ind9b8_pct` decimal(5,2) DEFAULT NULL,
  `ind9b9_no` int(11) DEFAULT NULL,
  `ind9b9_pct` decimal(5,2) DEFAULT NULL,
  `ind10` int(11) DEFAULT NULL,
  `ind11` int(11) DEFAULT NULL,
  `ind12` int(11) DEFAULT NULL,
  `ind13` int(11) DEFAULT NULL,
  `ind14` int(11) DEFAULT NULL,
  `ind15` int(11) DEFAULT NULL,
  `ind16` int(11) DEFAULT NULL,
  `ind17a_public` int(11) DEFAULT NULL,
  `ind17a_private` int(11) DEFAULT NULL,
  `ind17b_public` int(11) DEFAULT NULL,
  `ind17b_private` int(11) DEFAULT NULL,
  `ind18` int(11) DEFAULT NULL,
  `ind19` int(11) DEFAULT NULL,
  `ind20` int(11) DEFAULT NULL,
  `ind21` decimal(5,2) DEFAULT NULL,
  `ind22a_no` int(11) DEFAULT NULL,
  `ind22a_pct` decimal(5,2) DEFAULT NULL,
  `ind22b_no` int(11) DEFAULT NULL,
  `ind22b_pct` decimal(5,2) DEFAULT NULL,
  `ind22c_no` int(11) DEFAULT NULL,
  `ind22c_pct` decimal(5,2) DEFAULT NULL,
  `ind22d_no` int(11) DEFAULT NULL,
  `ind22d_pct` decimal(5,2) DEFAULT NULL,
  `ind22e_no` int(11) DEFAULT NULL,
  `ind22e_pct` decimal(5,2) DEFAULT NULL,
  `ind22f_no` int(11) DEFAULT NULL,
  `ind22f_pct` decimal(5,2) DEFAULT NULL,
  `ind22g_no` int(11) DEFAULT NULL,
  `ind22g_pct` decimal(5,2) DEFAULT NULL,
  `ind23` int(11) DEFAULT NULL,
  `ind24` int(11) DEFAULT NULL,
  `ind25` int(11) DEFAULT NULL,
  `ind26` int(11) DEFAULT NULL,
  `ind27a_no` int(11) DEFAULT NULL,
  `ind27a_pct` decimal(5,2) DEFAULT NULL,
  `ind27b_no` int(11) DEFAULT NULL,
  `ind27b_pct` decimal(5,2) DEFAULT NULL,
  `ind27c_no` int(11) DEFAULT NULL,
  `ind27c_pct` decimal(5,2) DEFAULT NULL,
  `ind27d_no` int(11) DEFAULT NULL,
  `ind27d_pct` decimal(5,2) DEFAULT NULL,
  `ind27e_no` int(11) DEFAULT NULL,
  `ind27e_pct` decimal(5,2) DEFAULT NULL,
  `ind28a_no` int(11) DEFAULT NULL,
  `ind28a_pct` decimal(5,2) DEFAULT NULL,
  `ind28b_no` int(11) DEFAULT NULL,
  `ind28b_pct` decimal(5,2) DEFAULT NULL,
  `ind28c_no` int(11) DEFAULT NULL,
  `ind28c_pct` decimal(5,2) DEFAULT NULL,
  `ind28d_no` int(11) DEFAULT NULL,
  `ind28d_pct` decimal(5,2) DEFAULT NULL,
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
  `ind29f_no` int(11) DEFAULT NULL,
  `ind29f_pct` decimal(5,2) DEFAULT NULL,
  `ind29g_no` int(11) DEFAULT NULL,
  `ind29g_pct` decimal(5,2) DEFAULT NULL,
  `ind30a_no` int(11) DEFAULT NULL,
  `ind30a_pct` decimal(5,2) DEFAULT NULL,
  `ind30b_no` int(11) DEFAULT NULL,
  `ind30b_pct` decimal(5,2) DEFAULT NULL,
  `ind30c_no` int(11) DEFAULT NULL,
  `ind30c_pct` decimal(5,2) DEFAULT NULL,
  `ind30d_no` int(11) DEFAULT NULL,
  `ind30d_pct` decimal(5,2) DEFAULT NULL,
  `ind31a_no` int(11) DEFAULT NULL,
  `ind31a_pct` decimal(5,2) DEFAULT NULL,
  `ind31b_no` int(11) DEFAULT NULL,
  `ind31b_pct` decimal(5,2) DEFAULT NULL,
  `ind31c_no` int(11) DEFAULT NULL,
  `ind31c_pct` decimal(5,2) DEFAULT NULL,
  `ind31d_no` int(11) DEFAULT NULL,
  `ind31d_pct` decimal(5,2) DEFAULT NULL,
  `ind31e_no` int(11) DEFAULT NULL,
  `ind31e_pct` decimal(5,2) DEFAULT NULL,
  `ind31f_no` int(11) DEFAULT NULL,
  `ind31f_pct` decimal(5,2) DEFAULT NULL,
  `ind32_no` int(11) DEFAULT NULL,
  `ind32_pct` decimal(5,2) DEFAULT NULL,
  `ind33_no` int(11) DEFAULT NULL,
  `ind33_pct` decimal(5,2) DEFAULT NULL,
  `ind34_no` int(11) DEFAULT NULL,
  `ind34_pct` decimal(5,2) DEFAULT NULL,
  `ind35_no` int(11) DEFAULT NULL,
  `ind35_pct` decimal(5,2) DEFAULT NULL,
  `ind36_no` int(11) DEFAULT NULL,
  `ind36_pct` decimal(5,2) DEFAULT NULL,
  `ind37a` int(11) DEFAULT NULL,
  `ind37b` int(11) DEFAULT NULL,
  `ind38` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bns_reports`
--

INSERT INTO `bns_reports` (`id`, `report_id`, `barangay`, `year`, `title`, `ind1`, `ind_male`, `ind_female`, `ind2`, `ind3`, `ind4`, `ind5`, `ind6a`, `ind6b`, `ind7`, `ind8`, `ind9`, `ind9a`, `ind9b1_no`, `ind9b1_pct`, `ind9b2_no`, `ind9b2_pct`, `ind9b3_no`, `ind9b3_pct`, `ind9b4_no`, `ind9b4_pct`, `ind9b5_no`, `ind9b5_pct`, `ind9b6_no`, `ind9b6_pct`, `ind9b7_no`, `ind9b7_pct`, `ind9b8_no`, `ind9b8_pct`, `ind9b9_no`, `ind9b9_pct`, `ind10`, `ind11`, `ind12`, `ind13`, `ind14`, `ind15`, `ind16`, `ind17a_public`, `ind17a_private`, `ind17b_public`, `ind17b_private`, `ind18`, `ind19`, `ind20`, `ind21`, `ind22a_no`, `ind22a_pct`, `ind22b_no`, `ind22b_pct`, `ind22c_no`, `ind22c_pct`, `ind22d_no`, `ind22d_pct`, `ind22e_no`, `ind22e_pct`, `ind22f_no`, `ind22f_pct`, `ind22g_no`, `ind22g_pct`, `ind23`, `ind24`, `ind25`, `ind26`, `ind27a_no`, `ind27a_pct`, `ind27b_no`, `ind27b_pct`, `ind27c_no`, `ind27c_pct`, `ind27d_no`, `ind27d_pct`, `ind27e_no`, `ind27e_pct`, `ind28a_no`, `ind28a_pct`, `ind28b_no`, `ind28b_pct`, `ind28c_no`, `ind28c_pct`, `ind28d_no`, `ind28d_pct`, `ind29a_no`, `ind29a_pct`, `ind29b_no`, `ind29b_pct`, `ind29c_no`, `ind29c_pct`, `ind29d_no`, `ind29d_pct`, `ind29e_no`, `ind29e_pct`, `ind29f_no`, `ind29f_pct`, `ind29g_no`, `ind29g_pct`, `ind30a_no`, `ind30a_pct`, `ind30b_no`, `ind30b_pct`, `ind30c_no`, `ind30c_pct`, `ind30d_no`, `ind30d_pct`, `ind31a_no`, `ind31a_pct`, `ind31b_no`, `ind31b_pct`, `ind31c_no`, `ind31c_pct`, `ind31d_no`, `ind31d_pct`, `ind31e_no`, `ind31e_pct`, `ind31f_no`, `ind31f_pct`, `ind32_no`, `ind32_pct`, `ind33_no`, `ind33_pct`, `ind34_no`, `ind34_pct`, `ind35_no`, `ind35_pct`, `ind36_no`, `ind36_pct`, `ind37a`, `ind37b`, `ind38`) VALUES
(1, 268, 'Calongonan', 2025, 'new', 111, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 44, '44.00', 88, '88.00', 88, '77.00', 1, '1.00', 1, '1.00', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, 1, 1, 1, 1, '1.00', 1, '11.00', 111, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '1.00', 1, '11.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, 0, 0),
(2, 270, 'Calongonan', 2026, 'fer', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', 0, '1.00', 0, '22.00', 0, '33.00', 0, '44.00', 0, '55.00', 0, '66.00', 0, '77.00', 0, '88.00', 0, '99.00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, 0, 0, 0, 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `browser` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL,
  `device_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `read_status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_time` time NOT NULL,
  `report_date` date NOT NULL,
  `status` enum('Pending','Approved','Rejected','Archived') DEFAULT 'Pending',
  `prev_status` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_submitted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `report_time`, `report_date`, `status`, `prev_status`, `created_at`, `is_submitted`) VALUES
(267, 10, '11:42:40', '2025-11-09', 'Pending', NULL, '2025-11-09 08:42:40', 1),
(268, 10, '11:42:40', '2025-11-09', 'Approved', NULL, '2025-11-09 08:42:40', 1),
(269, 10, '21:31:22', '2025-11-09', 'Pending', NULL, '2025-11-09 18:31:22', 1),
(270, 10, '21:31:22', '2025-11-09', 'Approved', NULL, '2025-11-09 18:31:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `report_archives`
--

CREATE TABLE `report_archives` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('BNS','CNO') NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `archived_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `barangay` enum('CNO','Amoros','Bolisong','Cogon','Himaya','Hinigdaan','Kalabaylabay','Molugan','Bolobolo','Poblacion','Kibonbon','Sambulawan','Calongonan','Sinaloc','Taytay','Ulaliman') NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_type` enum('BNS','CNO') NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `current_session` varchar(128) DEFAULT NULL,
  `password_changed` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `phone_number`, `email`, `address`, `barangay`, `profile_pic`, `user_type`, `password_hash`, `created_at`, `current_session`, `password_changed`, `status`) VALUES
(8, 'CNO', 'ADMIN', 'CNO', '09264686830', 'louizkylaspona@gmail.com', 'Mangima Tankulan', 'CNO', '1758540105_CCS_Logo_2.png', 'CNO', '$2y$10$Xm/8kdPuxuROCeJfzlcU6.rrR0CizxiD3R7CCAy/lKlwIaZCGFJJq', '2025-09-21 13:06:17', '57770297efb4aa4f288b8768a1637796', 0, 'Active'),
(10, 'BNS', 'Brgy', 'bns', '09264686830', 'loki072002@gmail.com', 'Mangima Tankulan', 'Calongonan', '1758514208_2.png', 'BNS', '$2y$10$zO97F06lMGhmM.Cap0dhu.P4bn/7GyR4zMNMFnd3YS/zOK0WDjEoa', '2025-09-21 13:16:32', '4e7a8cb269d4c89600b855a9dee11317', 0, 'Active'),
(12, 'we', 'we', 'we', '21', 'goodies34512@gmail.com', 'Mangima Tankulan', 'Sambulawan', '1758540182_image_1.jpg', 'BNS', '$2y$10$XKrEFbJZtEkhhDpDq9vOsOQoQZ1H2ubMfaN2oEPSE8crsIW2OYoMW', '2025-09-21 13:18:02', '9319353005a7e2b677a5ca8064141887', 0, 'Active'),
(13, 'DanMark', 'Javier', 'Dan', '1112', 'danmarkpetalcurin@gmail.com', 'tankulan', 'Poblacion', '1759897044_4.png', 'BNS', '$2y$10$PLmDMPp197hXc2ykxyA9XuaGKCCy47YQXDP4XgSDvNZ3K8yQYEw2q', '2025-10-06 11:12:40', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(14, 'James', 'Serenio', 'Lowkey', '2121', 'sereniojames363@gmail.com', 'Mangima Tankulan', 'Ulaliman', '1759896854_image_1.jpg', 'BNS', '$2y$10$GeC6UNg6Iy9dW9q3ZO9S7.Fa/xksv4S9niLPpJzTYOYmpmmTxknKK', '2025-10-06 11:20:42', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(15, 'Chucks', 'Glee', 'Chucks07', '2121', 'cleezypanda1@gmail.com', 'Mangima Tankulan', 'Sinaloc', '1759896087_1000711103.png', 'BNS', '$2y$10$0s4QzVmNAF4qnhxDB6ak2OvTAcdYuzHwzZYKSucGUDIuLtL1sH4a.', '2025-10-06 11:27:13', 'd8c24c38e5f86474e011e70fc35da113', 0, 'Active'),
(16, 'Floyd', 'Botandes', 'Floyd', '21', 'kibonbon@gmail.com', 'El Salvador', 'Kibonbon', NULL, 'BNS', '$2y$10$MOymOOv6PxvXD7Q9XzDAdObjGWP.V3JF/g.5tf7MN4XN5U.LrCTgW', '2025-10-08 04:19:37', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(17, 'Amor', 'Sat', 'Amoros', '212', 'amoros@gmail.com', 'El Salvador', 'Amoros', '1759897386_4.png', 'BNS', '$2y$10$Iw99Cp1j5gp7icPqGvxwI.uE6RLUFT42w5/vyFi9Sar5HHp7JD5AS', '2025-10-08 04:22:12', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(18, 'Bolo', 'Bolo', 'Bolobolo', '212121', 'bolobolo@gmail.com', 'El Salvador', 'Bolobolo', '1759897530_4.png', 'BNS', '$2y$10$3pFvY2Dve2EQYgV75HbMg.hM7enVbp2Bmc4PisuofwihvlhJuT2hK', '2025-10-08 04:24:40', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(19, 'Jus', 'Tine', 'Bolisong', '12123', 'bolisong@gmail.com', 'El Salvador', 'Bolisong', '1759897672_2.png', 'BNS', '$2y$10$wLeTAmws0javLtCeuQ2mwOg3xO/gGRkcxdBhBoWusPgl2SpYB/l2G', '2025-10-08 04:27:07', '4e7a8cb269d4c89600b855a9dee11317', 0, 'Active'),
(20, 'Hes', 'Des', 'Cogon', '12121', 'cogon@gmail.com', 'El Salvador', 'Cogon', '1759897859_2.png', 'BNS', '$2y$10$WoT8Z/FyQSQqUHIk0hlo2uLMPT6jMuqW4Pwg.tl8LWi1vHGkKEP2m', '2025-10-08 04:29:18', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(21, 'Gog', 'Das', 'Himaya', '1231', 'himaya@gmail.com', 'El Salvador', 'Himaya', '1759897984_4.png', 'BNS', '$2y$10$QPJMf0YoLJERsLpqpMjETOK9IdMf61Uen8441xq1QZlJciFkEifN6', '2025-10-08 04:32:15', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(22, 'Hinig', 'Daan', 'Hinigdaan', '122', 'hinigdaan@gmail.com', 'El Salvador', 'Hinigdaan', '1759898122_4.png', 'BNS', '$2y$10$o9ITZy8WYSgmynOFjbhgy.q.txa4.BUYdBbI..rpN0Z8JBzekkAXC', '2025-10-08 04:34:23', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(23, 'Kalabay', 'Labay', 'Kalabaylabay', '21', 'kalabaylabay@gmail.com', 'El Salvador', 'Kalabaylabay', '1759898363_image_1.jpg', 'BNS', '$2y$10$9Lj3RL5o260AXLv8OSgxPeMVtYGTHPvFt/Sx2BRMROgIGIPxGXkMS', '2025-10-08 04:37:51', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(24, 'Molu', 'Gan', 'Molugan', '21', 'molugan@gmail.com', 'El Salvador', 'Molugan', '1759898482_2.png', 'BNS', '$2y$10$9bIufpiowtibsueJewYntu5csGk.3qMKaehJhMjdvK/L2YVVGI2tK', '2025-10-08 04:40:33', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(25, 'Tay', 'Tay', 'Taytay', '22', 'taytay@gmail.com', 'El Salvador', 'Taytay', '1759898598_4.png', 'BNS', '$2y$10$1vQVabql7YkR6pLlOiFggOIlI0tgqovflXTlc54qsoN74hu9iCq3m', '2025-10-08 04:42:34', '889a45928807feecf347b8357231f97c', 0, 'Active'),
(26, 'Antonio', 'Parane', 'Antonio', '09xxxxxx', 'anthon2712@gmail.com', 'Tankulan', 'Calongonan', NULL, 'BNS', '$2y$10$.SS4E2dgWwhGGT.Ing6ls.lYN12IUHAibgqfTudRObDnQsqjZF8q6', '2025-10-15 07:24:32', '9b0b271e081366a950a952d7f879bf07', 0, 'Active'),
(27, 'Karen Jay', 'Langala', 'Admin', '099999999', 'citynutritionoffice@elsalvadorcity.gov.ph', 'El Salvador', 'CNO', NULL, 'CNO', '$2y$10$fNr76vClgbI0eti/iDgdOO2XCgmC9xMvt95yisqY07wXBW8sh0FgK', '2025-11-10 10:57:09', NULL, 0, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bns_reports`
--
ALTER TABLE `bns_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bns_reports_report_fk` (`report_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_history_ibfk_1` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_sender` (`sender_id`);

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
  ADD KEY `reports_ibfk_1` (`user_id`);

--
-- Indexes for table `report_archives`
--
ALTER TABLE `report_archives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_report` (`report_id`,`user_id`,`user_type`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `bns_reports`
--
ALTER TABLE `bns_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `report_archives`
--
ALTER TABLE `report_archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bns_reports`
--
ALTER TABLE `bns_reports`
  ADD CONSTRAINT `bns_reports_report_fk` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
