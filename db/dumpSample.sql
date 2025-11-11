-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2025 at 08:56 AM
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
-- Database: `nutri`
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
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1486, 1, 'OTP sent for new device login', 'Device token: eb917e6f5f80b52a73e8e69c1a03a18e, IP: ::1', '2025-11-08 22:03:09'),
(1487, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-08 22:50:44'),
(1488, 1, 'Logged out', 'Trusted Device', '2025-11-08 22:51:39'),
(1489, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-08 22:51:47'),
(1490, 1, 'Logged out', 'Trusted Device', '2025-11-08 22:51:49'),
(1491, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-08 22:51:53'),
(1492, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-08 22:57:51'),
(1493, 1, 'OTP sent for new device login', 'Device token: a067af488dacc36b3d01fdb803f029e3, IP: ::1', '2025-11-08 23:12:50'),
(1495, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-08 23:14:26'),
(1496, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-09 10:45:20'),
(1497, 12, 'Created new account: asd saasd (asd) - Role: BNS, Barangay: Himaya', NULL, '2025-11-09 11:07:59'),
(1498, 12, 'Logged out', 'Trusted Device', '2025-11-09 11:08:06'),
(1499, 12, 'OTP sent for new device login', 'Device token: eb917e6f5f80b52a73e8e69c1a03a18e, IP: ::1', '2025-11-09 11:08:17'),
(1501, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-11-09 11:36:23'),
(1502, 12, 'Report Added', 'Report ID: 265, Created for Barangay: Himaya, Year: 2025, Title: \'new report\'', '2025-11-09 11:37:07'),
(1503, 12, 'Accessed report (ID: 265, Title: new report, Status: Pending)', NULL, '2025-11-09 11:40:04'),
(1504, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:15'),
(1505, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:17'),
(1506, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:22'),
(1507, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:24'),
(1508, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:24'),
(1509, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:25'),
(1510, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:26'),
(1511, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:26'),
(1512, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:27'),
(1513, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:28'),
(1514, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:28'),
(1515, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:29'),
(1516, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:40:30'),
(1517, 12, 'Unsubmitted report ID 265', NULL, '2025-11-09 11:40:30'),
(1518, 12, 'Archived report (ID: 265) as BNS', NULL, '2025-11-09 11:42:24'),
(1519, 12, 'Restored report (ID: 265) from archive', NULL, '2025-11-09 11:42:33'),
(1520, 12, 'Archived report (ID: 265) as BNS', NULL, '2025-11-09 11:44:53'),
(1521, 12, 'Restored report (ID: 265) from archive', NULL, '2025-11-09 11:45:57'),
(1522, 12, 'Archived report (ID: 265) as BNS', NULL, '2025-11-09 11:46:03'),
(1523, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-09 11:56:42'),
(1524, 12, 'Restored report (ID: 265) from archive', NULL, '2025-11-09 11:57:26'),
(1525, 12, 'Submitted report ID 265', NULL, '2025-11-09 11:57:37'),
(1526, 1, 'Approved report ID: 265', NULL, '2025-11-09 12:04:29'),
(1527, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-11-09 12:06:09'),
(1528, 12, 'Report Added', 'Report ID: 266, Created for Barangay: Himaya, Year: 2025, Title: \'news\'', '2025-11-09 12:18:55'),
(1529, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-09 12:55:49'),
(1530, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-11-11 15:47:47'),
(1531, 12, 'Report Added', 'Report ID: 268, Created for Barangay: Himaya, Year: 2024, Title: \'dasd\'', '2025-11-11 15:48:30'),
(1532, 12, 'Report Added', 'Report ID: 270, Created for Barangay: Himaya, Year: 2026, Title: \'new report\'', '2025-11-11 15:51:53'),
(1533, 1, 'User logged in', 'Trusted device login from IP ::1', '2025-11-11 15:52:11'),
(1534, 12, 'Logged out', 'Trusted Device', '2025-11-11 15:52:30');

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
(0, 266, 'Himaya', '2025', 'news', 111, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 44.00, 44, 88.00, 88, 88.00, 77, 1.00, 1, 1.00, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1, 1, 1, 1, 1.00, 1, 1.00, 11, 111.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 1, 1.00, 11, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0),
(0, 268, 'Himaya', '2024', 'dasd', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 44.00, 0, 33.00, 0, 22.00, 0, 1.00, 0, 99.00, 0, 88.00, 0, 77.00, 0, 55.00, 0, 66.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0),
(0, 270, 'Himaya', '2026', 'new report', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 99.00, 0, 88.00, 0, 55.00, 0, 66.00, 0, 77.00, 0, 33.00, 0, 22.00, 0, 1.00, 0, 44.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0.00, 0, 0, 0);

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

INSERT INTO `login_history` (`id`, `user_id`, `session_id`, `browser`, `ip_address`, `login_time`, `logout_time`, `device_token`) VALUES
(30, 1, 'te8f04i1e9s1t8k5jdtvu99t6i', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa', '::1', '2025-11-09 02:45:20', NULL, 'eb917e6f5f80b52a73e8e69c1a03a18e'),
(31, 1, '4dm1lo9feadrkicodociqllcul', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa', '::1', '2025-11-08 14:03:30', NULL, NULL),
(32, 1, '1e1g3padj0alqvp15phe13su4m', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa', '::1', '2025-11-11 07:52:11', NULL, 'a067af488dacc36b3d01fdb803f029e3'),
(33, 1, 'jk630eu06ubt3qf3mmor9f6dgg', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa', '::1', '2025-11-08 15:13:16', NULL, NULL),
(34, 12, 'tmk72bsvie69c9kqpmrq9un4rb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa', '::1', '2025-11-11 07:47:47', NULL, 'eb917e6f5f80b52a73e8e69c1a03a18e'),
(35, 12, 'te8f04i1e9s1t8k5jdtvu99t6i', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa', '::1', '2025-11-09 03:08:40', NULL, NULL);

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

INSERT INTO `notifications` (`id`, `user_id`, `sender_id`, `message`, `date`, `read_status`) VALUES
(304, 1, 12, 'A new report has been submitted by Himaya.', '2025-11-09 11:37:07', 1),
(305, 1, 12, 'A new report has been submitted by Himaya.', '2025-11-09 12:18:55', 0),
(306, 12, NULL, 'Your report has been approved!', '2025-11-09 12:19:05', 1),
(307, 1, 12, 'A new report has been submitted by Himaya.', '2025-11-11 15:48:30', 0),
(308, 1, 12, 'A new report has been submitted by Himaya.', '2025-11-11 15:51:53', 0),
(309, 12, NULL, 'Your report has been approved!', '2025-11-11 15:52:16', 1),
(310, 12, NULL, 'Your report has been approved!', '2025-11-11 15:52:16', 1);

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
(38, 1, '655134', '2025-11-08 14:03:09', '2025-11-08 15:08:09'),
(39, 1, '158478', '2025-11-08 15:12:50', '2025-11-08 16:17:50'),
(40, 12, '992406', '2025-11-09 03:08:17', '2025-11-09 04:13:17');

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
(265, 12, '04:37:07', '2025-11-09', 'Approved', NULL, '2025-11-09 11:37:07', 1),
(266, 12, '05:18:55', '2025-11-09', 'Approved', NULL, '2025-11-09 12:18:55', 0),
(267, 12, '08:48:30', '2025-11-11', 'Pending', NULL, '2025-11-11 15:48:30', 1),
(268, 12, '08:48:30', '2025-11-11', 'Approved', NULL, '2025-11-11 15:48:30', 1),
(269, 12, '08:51:53', '2025-11-11', 'Pending', NULL, '2025-11-11 15:51:53', 1),
(270, 12, '08:51:53', '2025-11-11', 'Approved', NULL, '2025-11-11 15:51:53', 1);

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

--
-- Dumping data for table `report_archives`
--

INSERT INTO `report_archives` (`id`, `report_id`, `user_id`, `user_type`, `is_archived`, `is_deleted`, `archived_at`, `deleted_at`) VALUES
(148, 265, 12, 'BNS', 0, 0, NULL, NULL);

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
  `current_session` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password_changed` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `phone_number`, `email`, `address`, `barangay`, `profile_pic`, `user_type`, `password_hash`, `current_session`, `created_at`, `password_changed`, `status`) VALUES
(1, 'CNO', 'ADMIN', 'CNO', '09264686830', 'louizkylaspona@gmail.com', 'Mangima Tankulan', 'CNO', '1758540105_CCS_Logo_2.png', 'CNO', '$2y$10$Xm/8kdPuxuROCeJfzlcU6.rrR0CizxiD3R7CCAy/lKlwIaZCGFJJq', '1e1g3padj0alqvp15phe13su4m', '2025-09-21 05:06:17', 0, 'Active'),
(12, 'asd', 'saasd', 'asd', 'asd', 'user@gmail.com', 'El Sal', 'Himaya', '1762659655_4.png', 'BNS', '$2y$10$MKnAHAr/1iY9mGcFcNm3ne1fFVlTzmK0LPF5vVotQQfN8mzE2W3Fm', 'tmk72bsvie69c9kqpmrq9un4rb', '2025-11-09 03:07:59', 0, 'Active');

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
  ADD KEY `bns_reports_report_fk` (`report_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1535;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
