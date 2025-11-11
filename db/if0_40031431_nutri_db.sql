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

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(21, 8, 'Logged out', 'Trusted Device', '2025-10-01 16:59:01'),
(22, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 16:59:05'),
(23, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 17:36:25'),
(24, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 17:36:33'),
(25, 8, 'Logged out', 'Trusted Device', '2025-10-01 17:36:51'),
(26, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 17:36:57'),
(27, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 17:37:32'),
(28, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 17:37:53'),
(29, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 17:38:01'),
(30, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:05:24'),
(31, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:05:52'),
(32, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:06:07'),
(33, 8, 'Logged out', 'Trusted Device', '2025-10-01 18:06:11'),
(34, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:06:17'),
(35, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:10:10'),
(36, 12, 'Logged out', 'Trusted Device', '2025-10-01 18:10:12'),
(37, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:17:51'),
(38, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:18:15'),
(39, 10, 'Report Added', 'Report ID 21 created for Barangay Calongonan, Year 2025 with title \'new report\'', '2025-10-01 18:19:18'),
(40, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-01 18:19:26'),
(41, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-04 16:52:39'),
(42, 8, 'User logged in', 'Trusted device login from IP ::1', '2025-10-04 17:57:24'),
(43, 10, 'Report Added', 'Report ID: 22, Created for Barangay: Calongonan, Year: 2025, Title: \'new\'', '2025-10-04 18:14:52'),
(44, 10, 'Report Added', 'Report ID: 23, Created for Barangay: Calongonan, Year: 2025, Title: \'new2\'', '2025-10-04 18:21:22'),
(45, 10, 'Report Added', 'Report ID: 24, Created for Barangay: Calongonan, Year: 2025, Title: \'try\'', '2025-10-04 18:24:20'),
(46, 10, 'Logged out', 'Trusted Device', '2025-10-04 18:57:47'),
(47, 12, 'User logged in', 'Trusted device login from IP ::1', '2025-10-04 18:57:55'),
(48, 12, 'Report Added', 'Report ID: 25, Created for Barangay: Sambulawan, Year: 2025, Title: \'asd\'', '2025-10-04 18:58:15'),
(49, 12, 'Report Added', 'Report ID: 26, Created for Barangay: Sambulawan, Year: 2025, Title: \'asd\'', '2025-10-04 19:10:52'),
(50, 12, 'Report Added', 'Report ID: 27, Created for Barangay: Sambulawan, Year: 2025, Title: \'s\'', '2025-10-04 19:16:55'),
(51, 12, 'Logged out', 'Trusted Device', '2025-10-04 20:04:17'),
(52, 10, 'User logged in', 'Trusted device login from IP ::1', '2025-10-04 20:04:22'),
(53, 8, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.52', '2025-10-06 10:39:25'),
(54, 10, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.52', '2025-10-06 10:41:51'),
(55, 10, 'Logged out', 'Trusted Device', '2025-10-06 10:44:09'),
(56, 8, 'User logged in', 'Trusted device login from IP 143.44.193.52', '2025-10-06 10:44:15'),
(57, 8, 'Logged out', 'Trusted Device', '2025-10-06 10:58:11'),
(58, 8, 'User logged in', 'Trusted device login from IP 143.44.193.52', '2025-10-06 11:06:23'),
(59, 8, 'Logged out', 'Trusted Device', '2025-10-06 11:06:44'),
(60, 10, 'User logged in', 'Trusted device login from IP 143.44.193.52', '2025-10-06 11:06:49'),
(61, 10, 'Logged out', 'Trusted Device', '2025-10-06 11:11:11'),
(62, 8, 'User logged in', 'Trusted device login from IP 143.44.193.52', '2025-10-06 11:11:17'),
(63, 8, 'Created new account: DanMark Javier (Dan) - Role: BNS, Barangay: Poblacion', NULL, '2025-10-06 11:12:40'),
(64, 13, 'OTP sent for new device login', 'Device token: 458b74ae386623c14173803612085b12, IP: 143.44.193.52', '2025-10-06 11:13:30'),
(65, 8, 'Created new account: James Serenio (Lowkey) - Role: BNS, Barangay: Ulaliman', NULL, '2025-10-06 11:20:42'),
(66, 8, 'Created new account: Chucks Glee (Chucks07) - Role: BNS, Barangay: Sinaloc', NULL, '2025-10-06 11:27:13'),
(67, 15, 'OTP sent for new device login', 'Device token: 4292f9f3eecccfedf7a20a818c9df708, IP: 143.44.193.52', '2025-10-06 11:27:34'),
(68, 13, 'Logged out', 'Trusted Device', '2025-10-06 11:49:24'),
(69, 15, 'OTP sent for new device login', 'Device token: 458b74ae386623c14173803612085b12, IP: 143.44.193.52', '2025-10-06 11:50:23'),
(70, 15, 'Logged out', 'Trusted Device', '2025-10-06 11:55:20'),
(71, 8, 'OTP sent for new device login', 'Device token: 4292f9f3eecccfedf7a20a818c9df708, IP: 143.44.193.52', '2025-10-06 11:55:29'),
(72, 15, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-07 12:43:45'),
(73, 15, 'Logged out', 'Trusted Device', '2025-10-07 12:44:03'),
(74, 10, 'OTP sent for new device login', 'Device token: 4292f9f3eecccfedf7a20a818c9df708, IP: 143.44.193.195', '2025-10-07 12:44:13'),
(75, 10, 'Logged out', 'Trusted Device', '2025-10-08 03:55:51'),
(76, 8, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 03:56:02'),
(77, 8, 'Logged out', 'Trusted Device', '2025-10-08 03:56:24'),
(78, 15, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 03:56:34'),
(79, 15, 'Report Added', 'Report ID: 28, Created for Barangay: Sinaloc, Year: 2025, Title: \'Sinaloc Report\'', '2025-10-08 03:57:24'),
(80, 8, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 03:57:49'),
(81, 15, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 03:58:31'),
(82, 15, 'Report Added', 'Report ID: 29, Created for Barangay: Sinaloc, Year: 2025, Title: \'New Report\'', '2025-10-08 03:59:33'),
(83, 15, 'Logged out', 'Trusted Device', '2025-10-08 03:59:42'),
(84, 8, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 03:59:52'),
(85, 8, 'Logged out', 'Trusted Device', '2025-10-08 04:00:25'),
(86, 15, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 04:00:36'),
(87, 15, 'Logged out', 'Trusted Device', '2025-10-08 04:02:11'),
(88, 8, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 04:04:01'),
(89, 14, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:11:11'),
(90, 14, 'Report Added', 'Report ID: 30, Created for Barangay: Ulaliman, Year: 2025, Title: \'Ulaliman Report\'', '2025-10-08 04:12:14'),
(91, 8, 'OTP sent for new device login', 'Device token: 458b74ae386623c14173803612085b12, IP: 143.44.193.195', '2025-10-08 04:12:46'),
(92, 14, 'Logged out', 'Trusted Device', '2025-10-08 04:15:38'),
(93, 13, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:15:45'),
(94, 13, 'Report Added', 'Report ID: 31, Created for Barangay: Poblacion, Year: 2025, Title: \'Poblacion Report\'', '2025-10-08 04:16:55'),
(95, 8, 'Created new account: Floyd Botandes (Floyd) - Role: BNS, Barangay: Kibonbon', NULL, '2025-10-08 04:19:37'),
(96, 13, 'Logged out', 'Trusted Device', '2025-10-08 04:19:51'),
(97, 16, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:20:06'),
(98, 16, 'Report Added', 'Report ID: 32, Created for Barangay: Kibonbon, Year: 2025, Title: \'Kibonbon Report\'', '2025-10-08 04:20:53'),
(99, 8, 'Created new account: Amor Sat (Amoros) - Role: BNS, Barangay: Amoros', NULL, '2025-10-08 04:22:12'),
(100, 16, 'Logged out', 'Trusted Device', '2025-10-08 04:22:20'),
(101, 17, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:22:34'),
(102, 17, 'Report Added', 'Report ID: 33, Created for Barangay: Amoros, Year: 2025, Title: \'Amoros Report\'', '2025-10-08 04:23:36'),
(103, 8, 'Created new account: Bolo Bolo (Bolobolo) - Role: BNS, Barangay: Bolobolo', NULL, '2025-10-08 04:24:40'),
(104, 17, 'Logged out', 'Trusted Device', '2025-10-08 04:24:48'),
(105, 18, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:25:04'),
(106, 18, 'Report Added', 'Report ID: 34, Created for Barangay: Bolobolo, Year: 2025, Title: \'BoloBolo Report\'', '2025-10-08 04:26:02'),
(107, 8, 'Created new account: Jus Tine (Bolisong) - Role: BNS, Barangay: Bolisong', NULL, '2025-10-08 04:27:07'),
(108, 18, 'Logged out', 'Trusted Device', '2025-10-08 04:27:11'),
(109, 19, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:27:27'),
(110, 19, 'Report Added', 'Report ID: 35, Created for Barangay: Bolisong, Year: 2025, Title: \'Bolisong Report\'', '2025-10-08 04:28:20'),
(111, 8, 'Created new account: Hes Des (Cogon) - Role: BNS, Barangay: Cogon', NULL, '2025-10-08 04:29:18'),
(112, 19, 'Logged out', 'Trusted Device', '2025-10-08 04:29:28'),
(113, 20, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:29:42'),
(114, 20, 'Report Added', 'Report ID: 36, Created for Barangay: Cogon, Year: 2025, Title: \'Cogon Report\'', '2025-10-08 04:31:30'),
(115, 8, 'Created new account: Gog Das (Himaya) - Role: BNS, Barangay: Himaya', NULL, '2025-10-08 04:32:15'),
(116, 20, 'Logged out', 'Trusted Device', '2025-10-08 04:32:21'),
(117, 21, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:32:35'),
(118, 21, 'Report Added', 'Report ID: 37, Created for Barangay: Himaya, Year: 2025, Title: \'Himaya Report\'', '2025-10-08 04:33:29'),
(119, 8, 'Created new account: Hinig Daan (Hinigdaan) - Role: BNS, Barangay: Hinigdaan', NULL, '2025-10-08 04:34:23'),
(120, 21, 'Logged out', 'Trusted Device', '2025-10-08 04:34:29'),
(121, 22, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:34:56'),
(122, 22, 'Report Added', 'Report ID: 38, Created for Barangay: Hinigdaan, Year: 2025, Title: \'Hinigdaan Report\'', '2025-10-08 04:35:48'),
(123, 8, 'Created new account: Kalabay Labay (Kalabaylabay) - Role: BNS, Barangay: Kalabaylabay', NULL, '2025-10-08 04:37:51'),
(124, 22, 'Logged out', 'Trusted Device', '2025-10-08 04:38:09'),
(125, 23, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:38:26'),
(126, 23, 'Report Added', 'Report ID: 39, Created for Barangay: Kalabaylabay, Year: 2025, Title: \'Kalabaylabay\'', '2025-10-08 04:39:50'),
(127, 8, 'Created new account: Molu Gan (Molugan) - Role: BNS, Barangay: Molugan', NULL, '2025-10-08 04:40:33'),
(128, 23, 'Logged out', 'Trusted Device', '2025-10-08 04:40:39'),
(129, 24, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:40:53'),
(130, 24, 'Report Added', 'Report ID: 40, Created for Barangay: Molugan, Year: 2025, Title: \'Molugan Report\'', '2025-10-08 04:41:51'),
(131, 8, 'Created new account: Tay Tay (Taytay) - Role: BNS, Barangay: Taytay', NULL, '2025-10-08 04:42:34'),
(132, 24, 'Logged out', 'Trusted Device', '2025-10-08 04:42:41'),
(133, 25, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.195', '2025-10-08 04:42:54'),
(134, 25, 'Report Added', 'Report ID: 41, Created for Barangay: Taytay, Year: 2025, Title: \'Taytay Report\'', '2025-10-08 04:43:43'),
(135, 25, 'Logged out', 'Trusted Device', '2025-10-08 04:44:40'),
(136, 10, 'User logged in', 'Trusted device login from IP 143.44.193.195', '2025-10-08 04:46:22'),
(137, 10, 'Report Added', 'Report ID: 42, Created for Barangay: Calongonan, Year: 2025, Title: \'Calongonan Report\'', '2025-10-08 04:49:37'),
(138, 10, 'Logged out', 'Trusted Device', '2025-10-08 04:56:00'),
(139, 19, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-11 14:41:21'),
(140, 19, 'Report Added', 'Report ID: 43, Created for Barangay: Bolisong, Year: 2025, Title: \'Bolisong New Report\'', '2025-10-11 15:25:17'),
(141, 19, 'Logged out', 'Trusted Device', '2025-10-11 15:25:28'),
(142, 8, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-11 15:25:34'),
(143, 8, 'Logged out', 'Trusted Device', '2025-10-11 15:34:51'),
(144, 19, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-11 15:35:01'),
(145, 19, 'Logged out', 'Trusted Device', '2025-10-11 15:35:49'),
(146, 8, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-12 05:52:06'),
(147, 10, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-12 05:52:33'),
(148, 10, 'Logged out', 'Trusted Device', '2025-10-12 05:52:39'),
(149, 12, 'OTP sent for new device login', 'Device token: 96adada48aefa8716229947a061b6ae8, IP: 143.44.193.155', '2025-10-12 05:52:46'),
(150, 12, 'Report Added', 'Report ID: 44, Created for Barangay: Sambulawan, Year: 2025, Title: \'Sambulawan Report\'', '2025-10-12 05:54:02'),
(151, 10, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-12 05:55:09'),
(152, 10, 'User logged in', 'Trusted device login from IP 143.44.193.155', '2025-10-12 09:45:57'),
(153, 8, 'User logged in', 'Trusted device login from IP 143.44.193.75', '2025-10-14 10:43:50'),
(154, 8, 'User logged in', 'Trusted device login from IP 27.110.167.246', '2025-10-15 05:45:51'),
(155, 8, 'Logged out', 'Trusted Device', '2025-10-15 05:47:43'),
(156, 10, 'User logged in', 'Trusted device login from IP 27.110.167.246', '2025-10-15 05:47:51'),
(157, 10, 'Logged out', 'Trusted Device', '2025-10-15 05:48:03'),
(158, 8, 'User logged in', 'Trusted device login from IP 27.110.167.246', '2025-10-15 05:48:11'),
(159, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-15 07:22:35'),
(160, 8, 'Created new account: Antonio Parane (Antonio) - Role: BNS, Barangay: Calongonan', NULL, '2025-10-15 07:24:32'),
(161, 26, 'OTP sent for new device login', 'Device token: 053f99c9de3c5976f37bdd69b83cab9f, IP: 126.209.18.230', '2025-10-15 07:27:06'),
(162, 8, 'User logged in', 'Trusted device login from IP 143.44.193.75', '2025-10-15 11:06:18'),
(163, 10, 'User logged in', 'Trusted device login from IP 143.44.193.75', '2025-10-15 14:19:11'),
(164, 8, 'User logged in', 'Trusted device login from IP 143.44.193.75', '2025-10-15 14:37:27'),
(165, 10, 'Report Added', 'Report ID: 45, Created for Barangay: Calongonan, Year: 2025, Title: \'asd\'', '2025-10-15 14:37:49'),
(166, 10, 'Viewed report (ID: 42, Title: Calongonan Report)', NULL, '2025-10-15 15:05:56'),
(167, 10, 'Viewed report (ID: 45, Title: asd)', NULL, '2025-10-15 15:06:13'),
(168, 10, 'Viewed report (ID: 45, Title: asd)', NULL, '2025-10-15 15:10:59'),
(169, 10, 'Updated report (cloned as Pending)', 'Old Report ID: 45 → New Report ID: 46', '2025-10-15 15:11:03'),
(170, 10, 'Report Added', 'Report ID: 47, Created for Barangay: Calongonan, Year: 2025, Title: \'ads\'', '2025-10-15 15:35:15'),
(171, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 06:04:41'),
(172, 8, 'Logged out', 'Trusted Device', '2025-10-16 06:28:05'),
(173, 10, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 06:28:25'),
(174, 10, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 08:00:40'),
(175, 10, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 08:00:48'),
(176, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 08:34:02'),
(177, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 08:35:01'),
(178, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 08:35:13'),
(179, 8, 'Logged out', 'Trusted Device', '2025-10-16 08:41:42'),
(180, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 09:00:11'),
(181, 8, 'Logged out', 'Trusted Device', '2025-10-16 09:00:15'),
(182, 10, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-16 09:00:22'),
(183, 10, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-17 06:32:20'),
(184, 10, 'Viewed report (ID: 42, Title: Calongonan Report)', NULL, '2025-10-17 06:34:16'),
(185, 10, 'Viewed report (ID: 42, Title: Calongonan Report)', NULL, '2025-10-17 07:00:37'),
(186, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-17 08:31:13'),
(187, 10, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-17 08:31:35'),
(188, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-17 08:35:24'),
(189, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-17 09:25:23'),
(190, 12, 'OTP sent for new device login', 'Device token: 4292f9f3eecccfedf7a20a818c9df708, IP: 126.209.18.230', '2025-10-17 09:35:00'),
(191, 8, 'User logged in', 'Trusted device login from IP 126.209.18.230', '2025-10-19 03:47:48'),
(192, 8, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-09 16:39:57'),
(193, 8, 'Logged out', 'Trusted Device', '2025-11-09 16:40:06'),
(194, 10, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-09 16:40:38'),
(195, 10, 'Report Added', 'Report ID: 268, Created for Barangay: Calongonan, Year: 2025, Title: \'new\'', '2025-11-09 16:42:40'),
(196, 8, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-09 16:44:57'),
(197, 10, 'Viewed report (ID: 268, Title: new)', NULL, '2025-11-09 16:51:45'),
(198, 10, 'Logged out', 'Trusted Device', '2025-11-09 16:54:59'),
(199, 19, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-09 16:55:08'),
(200, 19, 'Logged out', 'Trusted Device', '2025-11-09 17:04:39'),
(201, 10, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-09 17:04:47'),
(202, 8, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-10 01:09:06'),
(203, 10, 'OTP sent for new device login', 'Device token: 458b74ae386623c14173803612085b12, IP: 143.44.193.54', '2025-11-10 02:30:30'),
(204, 8, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-10 02:30:42'),
(205, 8, 'Logged out', 'Trusted Device', '2025-11-10 02:30:47'),
(206, 10, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-10 02:30:52'),
(207, 10, 'Report Added', 'Report ID: 270, Created for Barangay: Calongonan, Year: 2026, Title: \'fer\'', '2025-11-10 02:31:22'),
(208, 8, 'User logged in', 'Trusted device login from IP 143.44.193.54', '2025-11-10 10:52:23'),
(209, 8, 'Created new account: Karen Jay Langala (Admin) - Role: CNO, Barangay: CNO', NULL, '2025-11-10 10:57:09'),
(210, 8, 'User logged in', 'Trusted device login from IP 143.44.193.171', '2025-11-10 23:41:48');

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

INSERT INTO `login_history` (`id`, `user_id`, `session_id`, `browser`, `ip_address`, `login_time`, `logout_time`, `device_token`) VALUES
(1, 10, '04hk3r65n68a8bi0qb382p2fsp', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-10-04 20:04:22', NULL, 'eb917e6f5f80b52a73e8e69c1a03a18e'),
(2, 10, '2hauhvi1j0u8lcgslp2m8ovncv', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-09-22 03:56:44', NULL, NULL),
(3, 8, 'ph8g5jk94suiavfbon58b31hf4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-10-01 18:19:26', NULL, 'eb917e6f5f80b52a73e8e69c1a03a18e'),
(4, 8, '2hauhvi1j0u8lcgslp2m8ovncv', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-09-22 04:12:29', NULL, NULL),
(5, 12, 'o86fu9nin7o5i9rt5hsrvf09q9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-10-01 18:10:10', NULL, 'a067af488dacc36b3d01fdb803f029e3'),
(6, 12, '89jbjpmh218tvv08dbf3v77i0p', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-09-22 11:22:48', NULL, NULL),
(7, 10, 'o86fu9nin7o5i9rt5hsrvf09q9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-10-01 18:18:15', NULL, 'a067af488dacc36b3d01fdb803f029e3'),
(8, 10, '89jbjpmh218tvv08dbf3v77i0p', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-09-22 11:26:57', NULL, NULL),
(9, 12, '04hk3r65n68a8bi0qb382p2fsp', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-10-04 18:57:55', NULL, 'eb917e6f5f80b52a73e8e69c1a03a18e'),
(10, 12, '8vsueecltnic705kk3f66fgdh4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-09-26 03:18:56', NULL, NULL),
(11, 8, 'cl7adhhvu5q8h9am918d5qv2fn', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-10-04 17:57:24', NULL, 'a067af488dacc36b3d01fdb803f029e3'),
(12, 8, 'rr16nfgqk577b4jnm0qam3lkv0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '::1', '2025-09-29 11:35:51', NULL, NULL),
(13, 8, '57770297efb4aa4f288b8768a1637796', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-11-10 23:41:48', NULL, '96adada48aefa8716229947a061b6ae8'),
(14, 8, 'b728e49255299800bac8c08bbb07ea3a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-10-06 10:39:52', NULL, NULL),
(15, 10, '4e7a8cb269d4c89600b855a9dee11317', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-11-10 02:30:52', NULL, '96adada48aefa8716229947a061b6ae8'),
(16, 10, 'b728e49255299800bac8c08bbb07ea3a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-10-06 10:42:18', NULL, NULL),
(17, 13, '2953a8de89a8328082d7a716859cfc00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-10-06 11:13:30', NULL, '458b74ae386623c14173803612085b12'),
(18, 13, '2953a8de89a8328082d7a716859cfc00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-10-06 11:14:45', NULL, NULL),
(19, 15, 'd8c24c38e5f86474e011e70fc35da113', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.3', '143.44.193.52', '2025-10-08 04:00:36', NULL, '4292f9f3eecccfedf7a20a818c9df708'),
(20, 15, 'f7be1395c1e7081805d01e88729ff8bf', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.3', '143.44.193.52', '2025-10-06 11:28:01', NULL, NULL),
(21, 15, '2953a8de89a8328082d7a716859cfc00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-10-06 11:50:23', NULL, '458b74ae386623c14173803612085b12'),
(22, 15, '2953a8de89a8328082d7a716859cfc00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.52', '2025-10-06 11:51:04', NULL, NULL),
(23, 8, 'ab82097a1d89ed975476a7ddaf55c299', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.3', '143.44.193.52', '2025-10-16 09:00:11', NULL, '4292f9f3eecccfedf7a20a818c9df708'),
(24, 10, '9319353005a7e2b677a5ca8064141887', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.3', '143.44.193.195', '2025-10-17 06:32:20', NULL, '4292f9f3eecccfedf7a20a818c9df708'),
(25, 10, 'd8c24c38e5f86474e011e70fc35da113', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.3', '143.44.193.195', '2025-10-07 12:44:40', NULL, NULL),
(26, 14, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:11:11', NULL, '96adada48aefa8716229947a061b6ae8'),
(27, 14, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:11:40', NULL, NULL),
(28, 8, '5dd450a971bdfa8ab66515fb92bd1feb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-11-10 02:30:42', NULL, '458b74ae386623c14173803612085b12'),
(29, 8, 'a41ce151a895bd6a05775086bd93b29e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:13:09', NULL, NULL),
(30, 13, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:15:45', NULL, '96adada48aefa8716229947a061b6ae8'),
(31, 13, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:16:04', NULL, NULL),
(32, 16, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:20:06', NULL, '96adada48aefa8716229947a061b6ae8'),
(33, 16, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:20:24', NULL, NULL),
(34, 17, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:22:34', NULL, '96adada48aefa8716229947a061b6ae8'),
(35, 17, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:22:50', NULL, NULL),
(36, 18, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:25:04', NULL, '96adada48aefa8716229947a061b6ae8'),
(37, 18, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:25:20', NULL, NULL),
(38, 19, '4e7a8cb269d4c89600b855a9dee11317', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-11-09 16:55:08', NULL, '96adada48aefa8716229947a061b6ae8'),
(39, 19, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:27:43', NULL, NULL),
(40, 20, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:29:42', NULL, '96adada48aefa8716229947a061b6ae8'),
(41, 20, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:30:46', NULL, NULL),
(42, 21, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:32:35', NULL, '96adada48aefa8716229947a061b6ae8'),
(43, 21, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:32:52', NULL, NULL),
(44, 22, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:34:56', NULL, '96adada48aefa8716229947a061b6ae8'),
(45, 22, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:35:13', NULL, NULL),
(46, 23, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:38:26', NULL, '96adada48aefa8716229947a061b6ae8'),
(47, 23, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:39:08', NULL, NULL),
(48, 24, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:40:53', NULL, '96adada48aefa8716229947a061b6ae8'),
(49, 24, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:41:11', NULL, NULL),
(50, 25, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:42:54', NULL, '96adada48aefa8716229947a061b6ae8'),
(51, 25, '889a45928807feecf347b8357231f97c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.195', '2025-10-08 04:43:08', NULL, NULL),
(52, 12, 'ef71b2c6a6a77aeea6602402f68107cc', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.155', '2025-10-12 05:52:46', NULL, '96adada48aefa8716229947a061b6ae8'),
(53, 12, 'ef71b2c6a6a77aeea6602402f68107cc', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa', '143.44.193.155', '2025-10-12 05:53:27', NULL, NULL),
(54, 26, '9b0b271e081366a950a952d7f879bf07', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.3', '126.209.18.230', '2025-10-15 07:27:06', NULL, '053f99c9de3c5976f37bdd69b83cab9f'),
(55, 26, '9b0b271e081366a950a952d7f879bf07', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.3', '126.209.18.230', '2025-10-15 07:28:00', NULL, NULL),
(56, 12, '9319353005a7e2b677a5ca8064141887', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.3', '126.209.18.230', '2025-10-17 09:35:00', NULL, '4292f9f3eecccfedf7a20a818c9df708'),
(57, 12, '9319353005a7e2b677a5ca8064141887', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.3', '126.209.18.230', '2025-10-17 09:35:44', NULL, NULL),
(58, 10, '5dd450a971bdfa8ab66515fb92bd1feb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Sa', '143.44.193.54', '2025-11-10 02:30:30', NULL, '458b74ae386623c14173803612085b12');

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
(1, 10, 0, 'Your report has been approved!', '2025-10-05 02:15:18', 1),
(2, 10, 0, 'Your report has been approved!', '2025-10-05 02:21:36', 1),
(3, 10, 0, 'Your report has been approved!', '2025-10-05 02:22:35', 1),
(4, 10, 0, 'Your report has been approved!', '2025-10-05 02:24:27', 1),
(5, 12, 0, 'Your report has been approved!', '2025-10-05 02:58:23', 1),
(6, 12, 0, 'Your report has been approved!', '2025-10-05 03:10:57', 1),
(7, 12, 0, 'Your report has been approved!', '2025-10-05 03:17:02', 1),
(8, 15, 0, 'Your report has been approved!', '2025-10-07 20:58:01', 1),
(9, 15, 0, 'Your report has been approved!', '2025-10-07 21:00:03', 1),
(10, 14, 0, 'Your report has been approved!', '2025-10-07 21:13:19', 1),
(11, 13, 0, 'Your report has been approved!', '2025-10-07 21:17:42', 1),
(12, 22, 0, 'Your report has been approved!', '2025-10-07 21:36:02', 1),
(13, 21, 0, 'Your report has been approved!', '2025-10-07 21:36:03', 0),
(14, 20, 0, 'Your report has been approved!', '2025-10-07 21:36:04', 0),
(15, 19, 0, 'Your report has been approved!', '2025-10-07 21:36:04', 1),
(16, 18, 0, 'Your report has been approved!', '2025-10-07 21:36:06', 0),
(17, 17, 0, 'Your report has been approved!', '2025-10-07 21:36:07', 0),
(18, 16, 0, 'Your report has been approved!', '2025-10-07 21:36:08', 0),
(19, 25, 0, 'Your report has been approved!', '2025-10-07 21:44:00', 1),
(20, 24, 0, 'Your report has been approved!', '2025-10-07 21:44:03', 0),
(21, 23, 0, 'Your report has been approved!', '2025-10-07 21:44:10', 0),
(22, 10, 0, 'Your report has been approved!', '2025-10-07 21:49:46', 1),
(23, 19, 0, 'Your report has been approved!', '2025-10-11 08:26:00', 1),
(24, 12, 0, 'Your report has been approved!', '2025-10-11 22:54:21', 0),
(25, 10, 0, 'Your report has been rejected.', '2025-10-11 22:55:17', 1),
(26, 10, 0, 'Your report has been rejected.', '2025-10-11 22:55:48', 1),
(27, 10, 0, 'Your report has been rejected.', '2025-10-15 07:38:01', 1),
(28, 10, NULL, 'Your report has been rejected.', '2025-10-15 08:11:25', 1),
(29, 10, NULL, 'Your report has been rejected.', '2025-10-17 01:36:08', 1),
(30, 8, 10, 'A new report has been submitted by Calongonan.', '2025-11-09 08:42:40', 0),
(31, 10, NULL, 'Your report has been approved!', '2025-11-09 08:45:05', 1),
(32, 8, 10, 'A new report has been submitted by Calongonan.', '2025-11-09 18:31:22', 0),
(33, 10, NULL, 'Your report has been approved!', '2025-11-09 18:31:32', 1);

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
(55, 23, '605920', '2025-10-08 04:38:52', '2025-10-08 00:43:52'),
(56, 24, '596703', '2025-10-08 04:40:53', '2025-10-08 00:45:53'),
(57, 25, '964670', '2025-10-08 04:42:54', '2025-10-08 00:47:54'),
(58, 12, '152535', '2025-10-12 05:52:46', '2025-10-12 01:57:46'),
(59, 26, '267905', '2025-10-15 07:27:06', '2025-10-15 03:32:06'),
(60, 12, '192384', '2025-10-17 09:35:00', '2025-10-17 05:40:00'),
(61, 10, '828935', '2025-11-10 02:30:30', '2025-11-09 21:35:30');

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
