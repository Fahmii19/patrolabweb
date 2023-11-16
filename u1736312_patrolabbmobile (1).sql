-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2023 at 10:22 AM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1736312_patrolabbmobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `img_location` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `project_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `created_at`, `updated_at`, `code`, `img_location`, `name`, `status`, `project_id`) VALUES
(1, '2023-06-08 15:39:31', NULL, 'AREAPAL51', NULL, 'Area 51 Palembang', 'ACTIVED', 1),
(2, '2023-06-08 15:39:31', NULL, 'AREAPAL70', NULL, 'Area 70 Palembang', 'ACTIVED', 1),
(3, '2023-06-08 15:39:31', NULL, 'AREAPAL251', NULL, 'Area 251 Palembang', 'ACTIVED', 2);

-- --------------------------------------------------------

--
-- Table structure for table `asset_client_checkpoint`
--

CREATE TABLE `asset_client_checkpoint` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `checkpoint_note` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `asset_master_id` bigint(20) NOT NULL,
  `checkpoint_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `asset_client_checkpoint`
--

INSERT INTO `asset_client_checkpoint` (`id`, `created_at`, `updated_at`, `checkpoint_note`, `status`, `asset_master_id`, `checkpoint_id`) VALUES
(1, '2023-07-22 11:00:10', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 1),
(2, '2023-07-22 11:00:10', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 1),
(3, '2023-07-22 11:00:10', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 1),
(4, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 2),
(5, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 2),
(6, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 9, 2),
(7, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 10, 2),
(8, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 3),
(9, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 3),
(10, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 3),
(11, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 3),
(12, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 4),
(13, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 4),
(14, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 4),
(15, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 5),
(16, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 5),
(17, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 9, 5),
(18, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 10, 5),
(19, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 6),
(20, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 6),
(21, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 6),
(22, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 6),
(23, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 7),
(24, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 7),
(25, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 7),
(26, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 8),
(27, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 9, 8),
(28, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 10, 8),
(29, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 8),
(30, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 9),
(31, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 9),
(32, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 9),
(33, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 10),
(34, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 10),
(35, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 10),
(36, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 11),
(37, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 11),
(38, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 11),
(39, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 11),
(40, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 12),
(41, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 12),
(42, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 12),
(43, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 13),
(44, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 9, 13),
(45, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 10, 13),
(46, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 13),
(47, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 14),
(48, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 14),
(49, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 14),
(50, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 15),
(51, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 15),
(52, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 15),
(53, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 16),
(54, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 16),
(55, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 16),
(56, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 16),
(57, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 17),
(58, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 17),
(59, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 17),
(60, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 18),
(61, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 9, 18),
(62, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 10, 18),
(63, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 18),
(64, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 19),
(65, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 19),
(66, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 19),
(67, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 20),
(68, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 20),
(69, '2023-07-22 12:17:14', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 20),
(70, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 20),
(71, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 20),
(72, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 20),
(73, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 20),
(74, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 21),
(75, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 21),
(76, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 21),
(77, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 22),
(78, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 9, 22),
(79, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 10, 22),
(80, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 22),
(81, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 23),
(82, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 23),
(83, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 23),
(84, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 24),
(85, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 24),
(86, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 24),
(87, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 25),
(88, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 25),
(89, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 25),
(90, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 8, 25),
(91, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 5, 26),
(92, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 6, 26),
(93, '2023-07-22 12:19:06', NULL, 'Check Keberadaan dan Kondisi', 'ACTIVED', 7, 26);

-- --------------------------------------------------------

--
-- Table structure for table `asset_patrol_checkpoint`
--

CREATE TABLE `asset_patrol_checkpoint` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `checkpoint_note` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `asset_master_id` bigint(20) NOT NULL,
  `checkpoint_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `asset_patrol_checkpoint`
--

INSERT INTO `asset_patrol_checkpoint` (`id`, `created_at`, `updated_at`, `checkpoint_note`, `status`, `asset_master_id`, `checkpoint_id`) VALUES
(1, '2023-06-13 13:35:15', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 1),
(2, '2023-06-13 13:35:15', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 1),
(3, '2023-06-13 13:35:15', NULL, 'Pastikan Solar Cell Aman', 'ACTIVED', 3, 1),
(4, '2023-06-13 13:35:15', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 1),
(5, '2023-06-13 13:35:19', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 2),
(6, '2023-06-13 13:35:19', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 2),
(7, '2023-06-13 13:35:19', NULL, 'Pastikan Solar Cell Aman', 'ACTIVED', 3, 2),
(8, '2023-06-13 13:35:19', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 2),
(9, '2023-06-13 13:35:22', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 3),
(10, '2023-06-13 13:35:22', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 3),
(11, '2023-06-13 13:35:22', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 3),
(12, '2023-06-13 13:35:25', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 4),
(13, '2023-06-13 13:35:25', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 4),
(14, '2023-06-13 13:35:25', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 4),
(15, '2023-06-13 13:35:28', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 5),
(16, '2023-06-13 13:35:28', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 5),
(17, '2023-06-13 13:35:28', NULL, 'Pastikan Solar Cell Aman', 'ACTIVED', 3, 5),
(18, '2023-06-13 13:35:28', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 5),
(19, '2023-06-13 13:35:32', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 6),
(20, '2023-06-13 13:35:32', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 6),
(21, '2023-06-13 13:35:32', NULL, 'Pastikan Solar Cell Aman', 'ACTIVED', 3, 6),
(22, '2023-06-13 13:35:32', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 6),
(23, '2023-06-13 13:35:35', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 7),
(24, '2023-06-13 13:35:35', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 7),
(25, '2023-06-13 13:35:35', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 7),
(26, '2023-06-13 13:35:38', NULL, 'Pastikan Gembok dalam Kondisi Terkunci', 'ACTIVED', 1, 8),
(27, '2023-06-13 13:35:38', NULL, 'Pastikan Keadaan Pintu Aman', 'ACTIVED', 2, 8),
(28, '2023-06-13 13:35:38', NULL, 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'ACTIVED', 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `asset_patrol_checkpoint_log`
--

CREATE TABLE `asset_patrol_checkpoint_log` (
  `id` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `asset_code_log` varchar(255) DEFAULT NULL,
  `asset_name_log` varchar(255) DEFAULT NULL,
  `checkpoint_note_log` text DEFAULT NULL,
  `status` enum('SAFE','UNSAFE') NOT NULL,
  `unsafe_description` varchar(255) DEFAULT NULL,
  `unsafe_images` text DEFAULT NULL,
  `asset_patrol_checkpoint_id` bigint(20) DEFAULT NULL,
  `asset_unsafe_option_id` int(11) DEFAULT NULL,
  `patrol_checkpoint_log_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `asset_patrol_checkpoint_log`
--

INSERT INTO `asset_patrol_checkpoint_log` (`id`, `created_at`, `updated_at`, `asset_code_log`, `asset_name_log`, `checkpoint_note_log`, `status`, `unsafe_description`, `unsafe_images`, `asset_patrol_checkpoint_id`, `asset_unsafe_option_id`, `patrol_checkpoint_log_id`) VALUES
('168719320461414be1c7d6d8d429abf45041f3f6d7d0d', '2023-06-19 23:46:44', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', 'image11.png;image21.png;image31.png', 3, NULL, '20230619_2_3_2'),
('1687193204614a79de84e275b49629b72d6f27aa61f00', '2023-06-19 23:46:44', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'SAFE', NULL, NULL, 3, NULL, '20230619_2_3_2'),
('1687193204614e6e53f21e6ef40cbb967f0bab35daa15', '2023-06-19 23:46:44', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20230619_2_3_2'),
('1687704514619886de9a6ba29416d851ab371dda5fc78', '2023-06-25 21:48:34', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20230625_2_3_2'),
('1687704514621187e2174c65849be9053c8671a7f7ac5', '2023-06-25 21:48:34', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20230625_2_3_2'),
('1687704514621b8f5d47a6f7e4dc19a761f2eb0e444cd', '2023-06-25 21:48:34', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20230625_2_3_2'),
('1687801140742fed05172d82645838914a141691f17ec', '2023-06-27 00:39:00', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20230626_2_3_2'),
('168780114074308785ae5a7de4a55a9566ad69173fa4c', '2023-06-27 00:39:00', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20230626_2_3_2'),
('1687801140743cdfccd400dc04052919d57bdc5fbf115', '2023-06-27 00:39:00', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20230626_2_3_2'),
('1688095930028389fdcbd30a447cc851717bea79e2343', '2023-06-30 10:32:10', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 1, NULL, '20230630_1_1_1'),
('168809593002845bc6fe99c3649a49f01da8b6bd84f81', '2023-06-30 10:32:10', NULL, 'SOLARCELL', 'Solar Cell', 'Pastikan Solar Cell Aman', 'SAFE', NULL, NULL, 1, NULL, '20230630_1_1_1'),
('1688095930028610d2da0f0c34e5c966b6da208b53465', '2023-06-30 10:32:10', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 1, NULL, '20230630_1_1_1'),
('1688095930028f45ee6832b874179b1414adf74bd8804', '2023-06-30 10:32:10', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'SAFE', NULL, NULL, 1, NULL, '20230630_1_1_1'),
('1689125709747ae886e9d4d834dc29e30275865c70130', '2023-07-12 08:35:09', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'UNSAFE', 'hilang', '1689125708238fb049ebf9b5341fdb2e43337b1ec30bf.jpeg;1689125708556b39ddbc09ef44ee38c6b4d43d62f3c29.jpeg', 1, 1, '20230712_1_1_1'),
('1689125709748a1f9436de6594b90b66c94081d68e781', '2023-07-12 08:35:09', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'jebol', '1689125708795f43d749858a145e0af0d9626c1ee8288.jpeg;16891257090646819af97c2714f56a451c12c78762218.jpeg;1689125709411df03a14162834263a83b7ad185a939b5.jpeg', 1, 2, '20230712_1_1_1'),
('1689125709748a31febc27974407387c0db739babc9be', '2023-07-12 08:35:09', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'SAFE', NULL, NULL, 1, NULL, '20230712_1_1_1'),
('1689125709748ae08f4a7533a4930913c09634666aa98', '2023-07-12 08:35:09', NULL, 'SOLARCELL', 'Solar Cell', 'Pastikan Solar Cell Aman', 'SAFE', NULL, NULL, 1, NULL, '20230712_1_1_1'),
('1689475483510478bf585ea4b4c2e8a27396c63e9cc49', '2023-07-16 09:44:43', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20230716_2_3_2'),
('168947548351132ca0bb94b94412da52aa3df0b50df6a', '2023-07-16 09:44:43', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20230716_2_3_2'),
('1689475483512c15c768e33a345f994d80ed36ecc7f57', '2023-07-16 09:44:43', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20230716_2_3_2'),
('1690011817281771360d6045249288de426be6a1d8e69', '2023-07-22 14:43:37', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20230722_2_3_2'),
('169001181728406d5a2f101fa4ada9c227fb5a1542cda', '2023-07-22 14:43:37', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20230722_2_3_2'),
('169001181728496e71f44fde64b2fbb9efb9f7d486e83', '2023-07-22 14:43:37', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20230722_2_3_2'),
('169511199270555917a864d4a4bd383e4857a54b61621', '2023-09-19 15:26:32', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 1, NULL, '20230919_1_1_1'),
('16951119927061cd64a48bbc840849cf0ceced17dc10f', '2023-09-19 15:26:32', NULL, 'SOLARCELL', 'Solar Cell', 'Pastikan Solar Cell Aman', 'SAFE', NULL, NULL, 1, NULL, '20230919_1_1_1'),
('169511199270636cec5143a3f403dba0de2ccc4dc6867', '2023-09-19 15:26:32', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'ga aman', '1695111991497d29db70fede7467fb897d6f173aaefab.jpeg;1695111992065926810d3bfbf47d8bf9eb2d8bd72f6b6.jpeg', 1, NULL, '20230919_1_1_1'),
('1695111992706722fc112607b4b50ab15ca2c5da9b840', '2023-09-19 15:26:32', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'SAFE', NULL, NULL, 1, NULL, '20230919_1_1_1'),
('1699750067753812bf73856b4483a9b52b3d9639c9e46', '2023-11-12 07:47:47', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_3_f754ae59-51ba-4d4e-82c9-648389c919dc'),
('16997500677540134fea827fd4e2398e9461e9531e25a', '2023-11-12 07:47:47', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20231112_2_3_3_f754ae59-51ba-4d4e-82c9-648389c919dc'),
('1699750067755d63bd5d4c2ea4664afa8b1ce90581a28', '2023-11-12 07:47:47', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20231112_2_3_3_f754ae59-51ba-4d4e-82c9-648389c919dc'),
('169975157387432b4e2b890f348b0ba762fc59a017d0b', '2023-11-12 08:12:53', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_157a3b9b-7e5f-43a1-88a8-6885725c18aa'),
('169975157387478e10838298f45ee8b0db4a97fb1650b', '2023-11-12 08:12:53', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_157a3b9b-7e5f-43a1-88a8-6885725c18aa'),
('16997515738749033560f405c499f9ba348b35c2735c8', '2023-11-12 08:12:53', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_157a3b9b-7e5f-43a1-88a8-6885725c18aa'),
('169975160010597b4fd6ad4444bbc8e3e87c8cf906edc', '2023-11-12 08:13:20', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_c3477f96-61fb-46cf-bb0e-7c85b89b5704'),
('16997516001066898ec6cd8d14288b2211f0a20ca4a77', '2023-11-12 08:13:20', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20231112_2_3_1_c3477f96-61fb-46cf-bb0e-7c85b89b5704'),
('1699751600106e32d8712d9b74f4bb9a8508ee545d1de', '2023-11-12 08:13:20', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20231112_2_3_1_c3477f96-61fb-46cf-bb0e-7c85b89b5704'),
('16997516258812c31f7a471e54e838903350c8870c67f', '2023-11-12 08:13:45', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_84c27993-64f3-4a7d-bc77-faedd3bbc940'),
('16997516258819cbe3f92b0d74369856a9ab22e21ab46', '2023-11-12 08:13:45', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_84c27993-64f3-4a7d-bc77-faedd3bbc940'),
('1699751625881b3467d31a4cc478683c132fff562b579', '2023-11-12 08:13:45', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_84c27993-64f3-4a7d-bc77-faedd3bbc940'),
('16997523312606899b74d479b45d292bd56ade8ea7b31', '2023-11-12 08:25:31', NULL, 'PAGARBESI', 'Pagar Besi', 'Pastikan Pagar Besi dalam Kondisi Terkunci', 'UNSAFE', 'Test UnSafe', '1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg;16876606394877d4f9ea628a84c6285a4dba1c1ff7c8e.jpeg', 3, NULL, '20231112_2_3_1_868f8fe0-62ae-4f73-b848-a862f3daaf5c'),
('169975233126069fc625e35824350a1d40d5bf1c3e96c', '2023-11-12 08:25:31', NULL, 'PINTUBESI', 'Pintu Besi', 'Pastikan Keadaan Pintu Aman', 'UNSAFE', 'Kemungkinan karena karat', '1687660588220c060927a9fef4205a16f250d376cca3d.jpeg;1687660619355bdfccc107aa047c89c6827d0e14ff308.jpeg', 3, 2, '20231112_2_3_1_868f8fe0-62ae-4f73-b848-a862f3daaf5c'),
('1699752331260f25dba0b7b6342dabf8ca4695f60d947', '2023-11-12 08:25:31', NULL, 'GEMBOK', 'Gembok', 'Pastikan Gembok dalam Kondisi Terkunci', 'SAFE', NULL, NULL, 3, NULL, '20231112_2_3_1_868f8fe0-62ae-4f73-b848-a862f3daaf5c');

-- --------------------------------------------------------

--
-- Table structure for table `asset_patrol_master`
--

CREATE TABLE `asset_patrol_master` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_desc` text DEFAULT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `asset_master_type` enum('PATROL','CLIENT') NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `asset_patrol_master`
--

INSERT INTO `asset_patrol_master` (`id`, `created_at`, `updated_at`, `code`, `name`, `short_desc`, `status`, `asset_master_type`, `image`) VALUES
(1, '2023-06-13 13:35:10', NULL, 'GEMBOK', 'Gembok', 'Gembok Besi Tipe A', 'ACTIVED', 'PATROL', NULL),
(2, '2023-06-13 13:35:10', NULL, 'PINTUBESI', 'Pintu Besi', 'Pintu Besi Besi Tipe A', 'ACTIVED', 'PATROL', NULL),
(3, '2023-06-13 13:35:10', NULL, 'SOLARCELL', 'Solar Cell', 'Solar Cell Tipe A', 'ACTIVED', 'PATROL', NULL),
(4, '2023-06-13 13:35:10', NULL, 'PAGARBESI', 'Pagar Besi', 'Pagar Besi Dimensi Standard', 'ACTIVED', 'PATROL', NULL),
(5, '2023-07-22 11:00:10', NULL, 'GENSETBIGBLUE', 'Genset Besar Biru', 'Genset Ukuran Besar Warna Biru', 'ACTIVED', 'CLIENT', '1690001523175bc05859e1b4144a0913f5c804b70d954.png'),
(6, '2023-07-22 11:00:10', NULL, 'GENSETBIGGREEN', 'Genset Besar Hijau', 'Genset Ukuran Besar Warna Hijau', 'ACTIVED', 'CLIENT', '16900016234782c4c4bdd4c4e406aab17369a26ed514b.png'),
(7, '2023-07-22 11:00:10', NULL, 'GENSETBIGYELLOW', 'Genset Besar Kuning', 'Genset Ukuran Besar Warna Kuning', 'ACTIVED', 'CLIENT', '16900016767793a33d9fd9deb4ebbbaaed0f5d9098998.jpeg'),
(8, '2023-07-22 11:00:10', NULL, 'GENSETBIGWHITE', 'Genset Besar White', 'Genset Ukuran Besar Warna Putih', 'ACTIVED', 'CLIENT', '1690001711823aec263d611504dbcbca9bdd18330d2d9.jpeg'),
(9, '2023-07-22 11:00:10', NULL, 'GENSETSMALLTYPEA', 'Genset Kecil Type A', 'Genset Ukuran Kecil Tipe A', 'ACTIVED', 'CLIENT', '16900017987827ed2bdb75b6b4adcbdc2620392c9f62d.png'),
(10, '2023-07-22 11:00:10', NULL, 'GENSETSMALLTYPEB', 'Genset Kecil Type B', 'Genset Ukuran Kecil Tipe B', 'ACTIVED', 'CLIENT', '16900019545183a6054c2051c41b293e83588951c6eff.png');

-- --------------------------------------------------------

--
-- Table structure for table `asset_unsafe_option`
--

CREATE TABLE `asset_unsafe_option` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `option_condition` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `asset_unsafe_option`
--

INSERT INTO `asset_unsafe_option` (`id`, `created_at`, `updated_at`, `option_condition`, `status`) VALUES
(1, '2023-06-13 16:17:09', NULL, 'Hilang', 'ACTIVED'),
(2, '2023-06-13 16:17:09', NULL, 'Rusak', 'ACTIVED'),
(3, '2023-06-13 16:17:09', NULL, 'Pencurian', 'ACTIVED');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `created_at`, `updated_at`, `code`, `name`, `status`) VALUES
(1, '2023-06-08 15:11:11', NULL, 'PERTAGAS', 'Pertagas', 'ACTIVED'),
(2, '2023-06-08 15:11:50', NULL, 'KERUPUKGAS', 'Kerupuk Gas', 'ACTIVED');

-- --------------------------------------------------------

--
-- Table structure for table `checkpoint`
--

CREATE TABLE `checkpoint` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `danger_status` enum('LOW','MIDDLE','HIGH') NOT NULL,
  `location` text NOT NULL,
  `location_long_lat` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `round_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `checkpoint`
--

INSERT INTO `checkpoint` (`id`, `created_at`, `updated_at`, `danger_status`, `location`, `location_long_lat`, `name`, `qr_code`, `status`, `round_id`) VALUES
(1, NULL, NULL, 'LOW', 'Jl. Jend. Sudirman No.km 4', '104.735846710;-2.9588216', 'Checkpoint 1', 'PATPAL51ARSBYKR1', 'ACTIVED', 1),
(2, NULL, NULL, 'MIDDLE', 'Jl. Jend. Sudirman No.km 4', '104.735846720;-2.9588216', 'Checkpoint 2', 'PATPAL51ARSBYKR2', 'ACTIVED', 1),
(3, NULL, NULL, 'MIDDLE', 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', 'Checkpoint 3', 'PATPAL51ARSBYKR3', 'ACTIVED', 1),
(4, NULL, NULL, 'HIGH', 'Jl. Jend. Sudirman No.km 4', '104.735846750;-2.9588216', 'Checkpoint 4', 'PATPAL51ARSBYKR4', 'ACTIVED', 1),
(5, NULL, NULL, 'LOW', 'Ilir D. IV, Ilir Timur I', '104.735846850;-2.9588216', 'Checkpoint 1', 'PATPAL51BRFIALSTR1', 'ACTIVED', 4),
(6, NULL, NULL, 'LOW', 'Ilir D. IV, Ilir Timur I', '104.735846810;-2.9588216', 'Checkpoint 2', 'PATPAL51BRFIALSTR2', 'ACTIVED', 4),
(7, NULL, NULL, 'MIDDLE', 'Ilir D. IV, Ilir Timur I', '104.735846870;-2.9588216', 'Checkpoint 3', 'PATPAL51BRFIALSTR3', 'ACTIVED', 4),
(8, NULL, NULL, 'HIGH', 'Ilir D. IV, Ilir Timur I', '104.735846820;-2.9588216', 'Checkpoint 4', 'PATPAL51BRFIALSTR4', 'ACTIVED', 4),
(9, NULL, NULL, 'LOW', 'Jl. Jend. Sudirman No.km 4', '104.7358467;-2.958821610', 'Checkpoint 1', 'PATPAL51ARSBYKR21', 'ACTIVED', 2),
(10, NULL, NULL, 'LOW', 'Jl. Jend. Sudirman No.km 4', '104.7358467;-2.958821670', 'Checkpoint 2', 'PATPAL51ARSBYKR22', 'ACTIVED', 2),
(11, NULL, NULL, 'LOW', 'Jl. Jend. Sudirman No.km 4', '104.7358467;-2.958821680', 'Checkpoint 3', 'PATPAL51ARSBYKR23', 'ACTIVED', 2),
(12, NULL, NULL, 'MIDDLE', 'Jl. Jend. Sudirman No.km 4', '104.7358467;-2.958821630', 'Checkpoint 4', 'PATPAL51ARSBYKR24', 'ACTIVED', 2),
(13, NULL, NULL, 'MIDDLE', 'Jl. Jend. Sudirman No.km 4', '104.7358467;-2.958821790', 'Checkpoint 1', 'PATPAL51ARSBYKR31', 'ACTIVED', 3),
(14, NULL, NULL, 'LOW', 'Jl. Jend. Sudirman No.km 4', '104.7358467;-2.958821710', 'Checkpoint 2', 'PATPAL51ARSBYKR32', 'ACTIVED', 3),
(15, NULL, NULL, 'LOW', 'Ilir D. IV, Ilir Timur I', '104.735846980;-2.9588216', 'Checkpoint 1', 'PATPAL51ARFIALSTR51', 'ACTIVED', 5),
(16, NULL, NULL, 'LOW', 'Ilir D. IV, Ilir Timur I', '104.735846990;-2.9588216', 'Checkpoint 2', 'PATPAL51ARFIALSTR52', 'ACTIVED', 5),
(17, NULL, NULL, 'HIGH', 'Ilir D. IV, Ilir Timur I', '104.735846910;-2.9588216', 'Checkpoint 3', 'PATPAL51ARFIALSTR53', 'ACTIVED', 5),
(18, NULL, NULL, 'HIGH', 'Ilir D. IV, Ilir Timur I', '104.735846920;-2.9588216', 'Checkpoint 4', 'PATPAL51ARFIALSTR54', 'ACTIVED', 5),
(19, NULL, NULL, 'LOW', 'Ilir D. IV, Ilir Timur I', '104.7358468;-2.958821610', 'Checkpoint 1', 'PATPAL51ARFIALSTR61', 'ACTIVED', 6),
(20, NULL, NULL, 'MIDDLE', 'Ilir D. IV, Ilir Timur I', '104.7358468;-2.958821620', 'Checkpoint 2', 'PATPAL51ARFIALSTR62', 'ACTIVED', 6),
(21, NULL, NULL, 'LOW', 'Ilir D. IV, Ilir Timur I', '104.7358468;-2.958821650', 'Checkpoint 3', 'PATPAL51ARFIALSTR63', 'ACTIVED', 6),
(22, NULL, NULL, 'HIGH', 'Jl. Kol. H. Burlian, Ario Kemuning', '104.735493390;-2.9577704', 'Checkpoint 1', 'PATPAL51CSTLRT71', 'ACTIVED', 7),
(23, NULL, NULL, 'MIDDLE', 'Jl. Kol. H. Burlian, Ario Kemuning', '104.735493310;-2.9577704', 'Checkpoint 2', 'PATPAL51CSTLRT72', 'ACTIVED', 7),
(24, NULL, NULL, 'LOW', 'Jl. Kol. H. Burlian, Ario Kemuning', '104.735493320;-2.9577704', 'Checkpoint 3', 'PATPAL51CSTLRT71', 'ACTIVED', 7),
(25, NULL, NULL, 'HIGH', 'Jl. Kol. H. Burlian, Ario Kemuning', '104.735493410;-2.9577704', 'Checkpoint 1', 'PATPAL51CSTLRT81', 'ACTIVED', 8),
(26, NULL, NULL, 'LOW', 'Jl. Kol. H. Burlian, Ario Kemuning', '104.735493420;-2.9577704', 'Checkpoint 2', 'PATPAL51CSTLRT81', 'ACTIVED', 8);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `province_id`) VALUES
(1, 'PIDIE JAYA', 11),
(2, 'SIMEULUE', 11),
(3, 'BIREUEN', 11),
(4, 'ACEH TIMUR', 11),
(6, 'ACEH UTARA', 11),
(10, 'PIDIE', 11),
(12, 'ACEH BARAT DAYA', 11),
(15, 'GAYO LUES', 11),
(17, 'ACEH SELATAN', 11),
(19, 'ACEH TAMIANG', 11),
(25, 'ACEH BESAR', 11),
(30, 'ACEH TENGGARA', 11),
(34, 'BENER MERIAH', 11),
(42, 'ACEH JAYA', 11),
(48, 'LHOKSEUMAWE', 11),
(50, 'ACEH BARAT', 11),
(55, 'NAGAN RAYA', 11),
(61, 'LANGSA', 11),
(95, 'BANDA ACEH', 11),
(278, 'ACEH SINGKIL', 11),
(307, 'SABANG', 11),
(312, 'ACEH TENGAH', 11),
(448, 'SUBULUSSALAM', 11),
(6465, 'NIAS SELATAN', 12),
(6466, 'MANDAILING NATAL', 12),
(6467, 'DAIRI', 12),
(6468, 'LABUHAN BATU UTARA', 12),
(6469, 'TAPANULI UTARA', 12),
(6470, 'SIMALUNGUN', 12),
(6471, 'LANGKAT', 12),
(6472, 'SERDANG BEDAGAI', 12),
(6473, 'TAPANULI SELATAN', 12),
(6475, 'ASAHAN', 12),
(6478, 'PADANG LAWAS UTARA', 12),
(6479, 'PADANG LAWAS', 12),
(6481, 'LABUHAN BATU SELATAN', 12),
(6483, 'PADANG SIDEMPUAN', 12),
(6484, 'TOBA SAMOSIR', 12),
(6487, 'TAPANULI TENGAH', 12),
(6496, 'HUMBANG HASUNDUTAN', 12),
(6501, 'SIBOLGA', 12),
(6557, 'BATU BARA', 12),
(6558, 'SAMOSIR', 12),
(6559, 'PEMATANG SIANTAR', 12),
(6561, 'LABUHAN BATU', 12),
(6562, 'DELI SERDANG', 12),
(6606, 'GUNUNGSITOLI', 12),
(6607, 'NIAS UTARA', 12),
(6610, 'NIAS', 12),
(6624, 'KARO', 12),
(6653, 'NIAS BARAT', 12),
(6657, 'MEDAN', 12),
(6673, 'PAKPAK BHARAT', 12),
(6700, 'TEBING TINGGI', 12),
(6848, 'BINJAI', 12),
(7131, 'TANJUNG BALAI', 12),
(12404, 'DHARMASRAYA', 13),
(12405, 'SOLOK SELATAN', 13),
(12406, 'SIJUNJUNG (SAWAH LUNTO SIJUNJUNG)', 13),
(12407, 'PASAMAN BARAT', 13),
(12408, 'SOLOK', 13),
(12412, 'PASAMAN', 13),
(12413, 'PARIAMAN', 13),
(12414, 'TANAH DATAR', 13),
(12416, 'PADANG PARIAMAN', 13),
(12417, 'PESISIR SELATAN', 13),
(12422, 'PADANG', 13),
(12423, 'SAWAH LUNTO', 13),
(12437, 'LIMA PULUH KOTO / KOTA', 13),
(12439, 'AGAM', 13),
(12445, 'PAYAKUMBUH', 13),
(12466, 'BUKITTINGGI', 13),
(12491, 'PADANG PANJANG', 13),
(12548, 'KEPULAUAN MENTAWAI', 13),
(13549, 'INDRAGIRI HILIR', 14),
(13550, 'KUANTAN SINGINGI', 14),
(13551, 'PELALAWAN', 14),
(13552, 'PEKANBARU', 14),
(13553, 'ROKAN HILIR', 14),
(13555, 'BENGKALIS', 14),
(13556, 'INDRAGIRI HULU', 14),
(13561, 'ROKAN HULU', 14),
(13565, 'KAMPAR', 14),
(13569, 'KEPULAUAN MERANTI', 14),
(13594, 'DUMAI', 14),
(13638, 'SIAK', 14),
(15384, 'TEBO', 15),
(15385, 'TANJUNG JABUNG BARAT', 15),
(15387, 'MUARO JAMBI', 15),
(15388, 'KERINCI', 15),
(15389, 'MERANGIN', 15),
(15393, 'BUNGO', 15),
(15395, 'TANJUNG JABUNG TIMUR', 15),
(15402, 'SUNGAIPENUH', 15),
(15409, 'BATANG HARI', 15),
(15412, 'JAMBI', 15),
(15414, 'SAROLANGUN', 15),
(16937, 'PALEMBANG', 16),
(16981, 'LAHAT', 16),
(16982, 'OGAN KOMERING ULU TIMUR', 16),
(16984, 'MUSI BANYUASIN', 16),
(16985, 'PAGAR ALAM', 16),
(16986, 'OGAN KOMERING ULU SELATAN', 16),
(16990, 'BANYUASIN', 16),
(16991, 'MUSI RAWAS', 16),
(16993, 'MUARA ENIM', 16),
(16997, 'OGAN KOMERING ULU', 16),
(17001, 'OGAN KOMERING ILIR', 16),
(17003, 'EMPAT LAWANG', 16),
(17004, 'LUBUK LINGGAU', 16),
(17033, 'PRABUMULIH', 16),
(17045, 'OGAN ILIR', 16),
(20081, 'BENGKULU TENGAH', 17),
(20082, 'REJANG LEBONG', 17),
(20083, 'MUKO MUKO', 17),
(20085, 'KAUR', 17),
(20086, 'BENGKULU UTARA', 17),
(20097, 'LEBONG', 17),
(20101, 'KEPAHIANG', 17),
(20105, 'BENGKULU SELATAN', 17),
(20106, 'SELUMA', 17),
(20161, 'BENGKULU', 17),
(21605, 'LAMPUNG UTARA', 18),
(21606, 'WAY KANAN', 18),
(21607, 'LAMPUNG TENGAH', 18),
(21608, 'MESUJI', 18),
(21610, 'PRINGSEWU', 18),
(21612, 'LAMPUNG TIMUR', 18),
(21618, 'LAMPUNG SELATAN', 18),
(21620, 'TULANG BAWANG', 18),
(21622, 'TULANG BAWANG BARAT', 18),
(21624, 'TANGGAMUS', 18),
(21640, 'LAMPUNG BARAT', 18),
(21644, 'PESISIR BARAT', 18),
(21651, 'PESAWARAN', 18),
(21667, 'BANDAR LAMPUNG', 18),
(21768, 'METRO', 18),
(24185, 'BELITUNG', 19),
(24186, 'BELITUNG TIMUR', 19),
(24189, 'BANGKA', 19),
(24190, 'BANGKA SELATAN', 19),
(24192, 'BANGKA BARAT', 19),
(24199, 'PANGKAL PINANG', 19),
(24209, 'BANGKA TENGAH', 19),
(24565, 'KEPULAUAN ANAMBAS', 21),
(24568, 'BINTAN', 21),
(24569, 'NATUNA', 21),
(24575, 'BATAM', 21),
(24576, 'TANJUNG PINANG', 21),
(24579, 'KARIMUN', 21),
(24581, 'LINGGA', 21),
(24980, 'JAKARTA UTARA', 31),
(24981, 'JAKARTA BARAT', 31),
(24982, 'JAKARTA TIMUR', 31),
(24985, 'JAKARTA SELATAN', 31),
(24988, 'JAKARTA PUSAT', 31),
(25182, 'KEPULAUAN SERIBU', 31),
(25247, 'DEPOK', 32),
(25248, 'KARAWANG', 32),
(25250, 'CIREBON', 32),
(25251, 'BANDUNG', 32),
(25253, 'SUKABUMI', 32),
(25254, 'SUMEDANG', 32),
(25257, 'INDRAMAYU', 32),
(25258, 'MAJALENGKA', 32),
(25259, 'KUNINGAN', 32),
(25260, 'TASIKMALAYA', 32),
(25264, 'CIAMIS', 32),
(25268, 'SUBANG', 32),
(25273, 'PURWAKARTA', 32),
(25274, 'BOGOR', 32),
(25281, 'BEKASI', 32),
(25300, 'GARUT', 32),
(25337, 'PANGANDARAN', 32),
(25341, 'CIANJUR', 32),
(25384, 'BANJAR', 32),
(25480, 'BANDUNG BARAT', 32),
(25489, 'CIMAHI', 32),
(31181, 'PURBALINGGA', 33),
(31182, 'KEBUMEN', 33),
(31184, 'MAGELANG', 33),
(31186, 'CILACAP', 33),
(31188, 'BATANG', 33),
(31191, 'BANJARNEGARA', 33),
(31196, 'BLORA', 33),
(31197, 'BREBES', 33),
(31198, 'BANYUMAS', 33),
(31202, 'WONOSOBO', 33),
(31203, 'TEGAL', 33),
(31204, 'PURWOREJO', 33),
(31205, 'PATI', 33),
(31211, 'SUKOHARJO', 33),
(31212, 'KARANGANYAR', 33),
(31220, 'PEKALONGAN', 33),
(31221, 'PEMALANG', 33),
(31228, 'BOYOLALI', 33),
(31232, 'GROBOGAN', 33),
(31253, 'SEMARANG', 33),
(31259, 'DEMAK', 33),
(31260, 'REMBANG', 33),
(31261, 'KLATEN', 33),
(31281, 'KUDUS', 33),
(31287, 'TEMANGGUNG', 33),
(31293, 'SRAGEN', 33),
(31309, 'JEPARA', 33),
(31312, 'WONOGIRI', 33),
(31349, 'KENDAL', 33),
(31360, 'SURAKARTA (SOLO)', 33),
(31834, 'SALATIGA', 33),
(39759, 'SLEMAN', 34),
(39761, 'BANTUL', 34),
(39765, 'YOGYAKARTA', 34),
(39767, 'GUNUNG KIDUL', 34),
(39769, 'KULON PROGO', 34),
(40197, 'GRESIK', 35),
(40198, 'KEDIRI', 35),
(40199, 'SAMPANG', 35),
(40200, 'BANGKALAN', 35),
(40201, 'SUMENEP', 35),
(40208, 'SITUBONDO', 35),
(40209, 'SURABAYA', 35),
(40210, 'JEMBER', 35),
(40212, 'PAMEKASAN', 35),
(40213, 'JOMBANG', 35),
(40216, 'PROBOLINGGO', 35),
(40219, 'BANYUWANGI', 35),
(40226, 'PASURUAN', 35),
(40228, 'BOJONEGORO', 35),
(40235, 'BONDOWOSO', 35),
(40236, 'MAGETAN', 35),
(40239, 'LUMAJANG', 35),
(40240, 'MALANG', 35),
(40257, 'BLITAR', 35),
(40267, 'SIDOARJO', 35),
(40278, 'LAMONGAN', 35),
(40289, 'PACITAN', 35),
(40299, 'TULUNGAGUNG', 35),
(40313, 'MOJOKERTO', 35),
(40316, 'MADIUN', 35),
(40317, 'PONOROGO', 35),
(40321, 'NGAWI', 35),
(40322, 'NGANJUK', 35),
(40352, 'TUBAN', 35),
(40480, 'TRENGGALEK', 35),
(40847, 'BATU', 35),
(48702, 'TANGERANG', 36),
(48703, 'SERANG', 36),
(48704, 'PANDEGLANG', 36),
(48706, 'LEBAK', 36),
(48721, 'TANGERANG SELATAN', 36),
(48728, 'CILEGON', 36),
(50253, 'KLUNGKUNG', 51),
(50254, 'KARANGASEM', 51),
(50255, 'BANGLI', 51),
(50257, 'TABANAN', 51),
(50258, 'GIANYAR', 51),
(50259, 'BADUNG', 51),
(50263, 'JEMBRANA', 51),
(50265, 'BULELENG', 51),
(50423, 'DENPASAR', 51),
(50967, 'MATARAM', 52),
(50968, 'DOMPU', 52),
(50969, 'SUMBAWA BARAT', 52),
(50970, 'SUMBAWA', 52),
(50971, 'LOMBOK TENGAH', 52),
(50974, 'LOMBOK TIMUR', 52),
(50982, 'LOMBOK UTARA', 52),
(50992, 'LOMBOK BARAT', 52),
(51005, 'BIMA', 52),
(52047, 'TIMOR TENGAH SELATAN', 53),
(52048, 'FLORES TIMUR', 53),
(52049, 'ALOR', 53),
(52053, 'ENDE', 53),
(52059, 'NAGEKEO', 53),
(52062, 'KUPANG', 53),
(52063, 'SIKKA', 53),
(52064, 'NGADA', 53),
(52067, 'TIMOR TENGAH UTARA', 53),
(52073, 'BELU', 53),
(52080, 'LEMBATA', 53),
(52097, 'SUMBA BARAT DAYA', 53),
(52098, 'SUMBA BARAT', 53),
(52099, 'SUMBA TENGAH', 53),
(52102, 'SUMBA TIMUR', 53),
(52104, 'ROTE NDAO', 53),
(52113, 'MANGGARAI TIMUR', 53),
(52142, 'MANGGARAI', 53),
(52160, 'SABU RAIJUA', 53),
(52210, 'MANGGARAI BARAT', 53),
(55240, 'LANDAK', 61),
(55241, 'KETAPANG', 61),
(55246, 'SINTANG', 61),
(55247, 'KUBU RAYA', 61),
(55250, 'PONTIANAK', 61),
(55252, 'KAYONG UTARA', 61),
(55264, 'BENGKAYANG', 61),
(55281, 'KAPUAS HULU', 61),
(55282, 'SAMBAS', 61),
(55291, 'SINGKAWANG', 61),
(55293, 'SANGGAU', 61),
(55300, 'MELAWI', 61),
(55310, 'SEKADAU', 61),
(57226, 'KOTAWARINGIN TIMUR', 62),
(57227, 'SUKAMARA', 62),
(57229, 'KOTAWARINGIN BARAT', 62),
(57230, 'BARITO TIMUR', 62),
(57235, 'KAPUAS', 62),
(57240, 'PULANG PISAU', 62),
(57246, 'LAMANDAU', 62),
(57249, 'SERUYAN', 62),
(57250, 'KATINGAN', 62),
(57257, 'BARITO SELATAN', 62),
(57274, 'MURUNG RAYA', 62),
(57285, 'BARITO UTARA', 62),
(57301, 'GUNUNG MAS', 62),
(57304, 'PALANGKA RAYA', 62),
(58784, 'TAPIN', 63),
(58787, 'HULU SUNGAI TENGAH', 63),
(58789, 'TABALONG', 63),
(58791, 'HULU SUNGAI UTARA', 63),
(58792, 'BALANGAN', 63),
(58795, 'TANAH BUMBU', 63),
(58797, 'BANJARMASIN', 63),
(58802, 'KOTABARU', 63),
(58810, 'TANAH LAUT', 63),
(58811, 'HULU SUNGAI SELATAN', 63),
(58821, 'BARITO KUALA', 63),
(58938, 'BANJARBARU', 63),
(60793, 'KUTAI BARAT', 64),
(60794, 'SAMARINDA', 64),
(60795, 'PASER', 64),
(60797, 'KUTAI KARTANEGARA', 64),
(60799, 'BERAU', 64),
(60803, 'PENAJAM PASER UTARA', 64),
(60804, 'BONTANG', 64),
(60810, 'KUTAI TIMUR', 64),
(60829, 'BALIKPAPAN', 64),
(61810, 'MALINAU', 65),
(61811, 'NUNUKAN', 65),
(61812, 'BULUNGAN (BULONGAN)', 65),
(61822, 'TANA TIDUNG', 65),
(61866, 'TARAKAN', 65),
(62285, 'BOLAANG MONGONDOW (BOLMONG)', 71),
(62286, 'BOLAANG MONGONDOW SELATAN', 71),
(62288, 'MINAHASA SELATAN', 71),
(62289, 'BITUNG', 71),
(62291, 'MINAHASA', 71),
(62292, 'KEPULAUAN SANGIHE', 71),
(62293, 'MINAHASA UTARA', 71),
(62296, 'KEPULAUAN TALAUD', 71),
(62299, 'KEPULAUAN SIAU TAGULANDANG BIARO (SITARO)', 71),
(62303, 'MANADO', 71),
(62316, 'BOLAANG MONGONDOW UTARA', 71),
(62330, 'BOLAANG MONGONDOW TIMUR', 71),
(62355, 'MINAHASA TENGGARA', 71),
(62421, 'KOTAMOBAGU', 71),
(62691, 'TOMOHON', 71),
(64075, 'BANGGAI KEPULAUAN', 72),
(64076, 'TOLI-TOLI', 72),
(64078, 'PARIGI MOUTONG', 72),
(64080, 'BUOL', 72),
(64084, 'DONGGALA', 72),
(64085, 'POSO', 72),
(64094, 'MOROWALI', 72),
(64095, 'TOJO UNA-UNA', 72),
(64096, 'BANGGAI', 72),
(64097, 'SIGI', 72),
(64142, 'PALU', 72),
(66011, 'MAROS', 73),
(66012, 'WAJO', 73),
(66013, 'BONE', 73),
(66014, 'SOPPENG', 73),
(66018, 'SIDENRENG RAPPANG / RAPANG', 73),
(66022, 'TAKALAR', 73),
(66024, 'BARRU', 73),
(66035, 'LUWU TIMUR', 73),
(66038, 'SINJAI', 73),
(66040, 'PANGKAJENE KEPULAUAN', 73),
(66043, 'PINRANG', 73),
(66050, 'JENEPONTO', 73),
(66053, 'PALOPO', 73),
(66056, 'TORAJA UTARA', 73),
(66063, 'LUWU', 73),
(66066, 'BULUKUMBA', 73),
(66069, 'MAKASSAR', 73),
(66072, 'SELAYAR (KEPULAUAN SELAYAR)', 73),
(66081, 'TANA TORAJA', 73),
(66084, 'LUWU UTARA', 73),
(66116, 'BANTAENG', 73),
(66142, 'GOWA', 73),
(66150, 'ENREKANG', 73),
(66637, 'PAREPARE', 73),
(69035, 'KOLAKA', 74),
(69036, 'MUNA', 74),
(69037, 'KONAWE SELATAN', 74),
(69038, 'KENDARI', 74),
(69039, 'KONAWE', 74),
(69042, 'KONAWE UTARA', 74),
(69056, 'KOLAKA UTARA', 74),
(69057, 'BUTON', 74),
(69058, 'BOMBANA', 74),
(69084, 'WAKATOBI', 74),
(69197, 'BAU-BAU', 74),
(69230, 'BUTON UTARA', 74),
(71177, 'GORONTALO UTARA', 75),
(71178, 'BONE BOLANGO', 75),
(71180, 'GORONTALO', 75),
(71181, 'BOALEMO', 75),
(71188, 'POHUWATO', 75),
(71909, 'MAJENE', 76),
(71911, 'MAMUJU', 76),
(71912, 'MAMUJU UTARA', 76),
(71913, 'POLEWALI MANDAR', 76),
(71919, 'MAMASA', 76),
(72513, 'MALUKU TENGGARA BARAT', 81),
(72514, 'MALUKU TENGGARA', 81),
(72515, 'SERAM BAGIAN BARAT', 81),
(72516, 'MALUKU TENGAH', 81),
(72518, 'SERAM BAGIAN TIMUR', 81),
(72519, 'MALUKU BARAT DAYA', 81),
(72531, 'AMBON', 81),
(72533, 'BURU', 81),
(72535, 'BURU SELATAN', 81),
(72541, 'KEPULAUAN ARU', 81),
(72656, 'TUAL', 81),
(73682, 'HALMAHERA BARAT', 82),
(73684, 'TIDORE KEPULAUAN', 82),
(73685, 'TERNATE', 82),
(73686, 'PULAU MOROTAI', 82),
(73687, 'KEPULAUAN SULA', 82),
(73689, 'HALMAHERA SELATAN', 82),
(73691, 'HALMAHERA TENGAH', 82),
(73693, 'HALMAHERA TIMUR', 82),
(73706, 'HALMAHERA UTARA', 82),
(74833, 'YALIMO', 91),
(74834, 'DOGIYAI', 91),
(74835, 'ASMAT', 91),
(74836, 'JAYAPURA', 91),
(74837, 'PANIAI', 91),
(74838, 'MAPPI', 91),
(74839, 'TOLIKARA', 91),
(74843, 'PUNCAK JAYA', 91),
(74845, 'PEGUNUNGAN BINTANG', 91),
(74847, 'JAYAWIJAYA', 91),
(74850, 'LANNY JAYA', 91),
(74851, 'NDUGA', 91),
(74858, 'BIAK NUMFOR', 91),
(74860, 'KEPULAUAN YAPEN (YAPEN WAROPEN)', 91),
(74865, 'PUNCAK', 91),
(74869, 'INTAN JAYA', 91),
(74882, 'WAROPEN', 91),
(74884, 'NABIRE', 91),
(74885, 'MIMIKA', 91),
(74886, 'BOVEN DIGOEL', 91),
(74896, 'YAHUKIMO', 91),
(74898, 'SARMI', 91),
(74920, 'MERAUKE', 91),
(74945, 'DEIYAI (DELIYAI)', 91),
(74970, 'KEEROM', 91),
(74998, 'SUPIORI', 91),
(74999, 'MAMBERAMO RAYA', 91),
(75012, 'MAMBERAMO TENGAH', 91),
(79690, 'RAJA AMPAT', 92),
(79691, 'MANOKWARI SELATAN', 92),
(79692, 'MANOKWARI', 92),
(79693, 'KAIMANA', 92),
(79694, 'MAYBRAT', 92),
(79695, 'SORONG SELATAN', 92),
(79696, 'FAKFAK', 92),
(79697, 'PEGUNUNGAN ARFAK', 92),
(79700, 'TAMBRAUW', 92),
(79708, 'SORONG', 92),
(79716, 'TELUK WONDAMA', 92),
(79732, 'TELUK BINTUNI', 92);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guards`
--

CREATE TABLE `guards` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `badge_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL,
  `img_avatar` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `wa` varchar(255) NOT NULL,
  `pleton_id` bigint(20) NOT NULL,
  `dob` date NOT NULL,
  `shift_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `guards`
--

INSERT INTO `guards` (`id`, `created_at`, `updated_at`, `address`, `badge_number`, `email`, `gender`, `img_avatar`, `name`, `wa`, `pleton_id`, `dob`, `shift_id`) VALUES
(1, '2023-06-08 15:54:16', NULL, 'Jl. Raya', '123456', 'agus@gmail.com', 'MALE', NULL, 'AGUS', '08123456789', 1, '1990-01-01', 1),
(2, '2023-06-08 15:54:16', NULL, 'Jl. Rumah', '654321', 'yudi@gmail.com', 'MALE', NULL, 'YUDI', '0812431313', 1, '1990-01-01', 1),
(3, '2023-06-08 15:54:16', NULL, 'Taman Ubud', '765422', 'ogythoks@gmail.com', 'MALE', NULL, 'OGY', '08888888', 2, '1985-09-23', 1),
(4, '2023-06-08 15:54:16', NULL, 'Jel. Palembang Raya', '874362', 'edye.suwarnoe19@gmail.com', 'MALE', NULL, 'EDI', '089898989', 2, '1990-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2019_08_19_000000_create_failed_jobs_table', 2),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(4, '2023_03_14_033052_create_permission_tables', 4),
(5, '2023_03_16_030446_create_wilayahs_table', 5),
(6, '2014_10_12_000002_create_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `patrol_area`
--

CREATE TABLE `patrol_area` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `img_location` varchar(255) DEFAULT NULL,
  `location_long_lat` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `area_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patrol_area`
--

INSERT INTO `patrol_area` (`id`, `created_at`, `updated_at`, `code`, `img_location`, `location_long_lat`, `name`, `status`, `area_id`) VALUES
(1, '2023-06-10 10:13:53', NULL, 'PATPAL51A', '', '104.7358467;-2.9588216', 'Patroli Area RS Bhayangkara Mohamad Hasan', 'ACTIVED', 1),
(2, '2023-06-10 10:15:54', NULL, 'PATPAL51B', '', '104.7358468;-2.9588216', 'Patroli Area Apotik Rfia Lestari', 'ACTIVED', 1),
(3, '2023-06-10 10:15:54', NULL, 'PATPAL51C', '', '104.7354933;-2.9577704', 'Patroli Area Stasiun LRT Polda', 'ACTIVED', 1),
(4, '2023-06-10 10:15:54', NULL, 'PATPAL51D', '', '104.756554;-2.990934', 'Patroli Area 4', 'ACTIVED', 1),
(5, '2023-06-10 10:15:54', NULL, 'PATPAL51E', '', '104.756554;-2.990934', 'Patroli Area 5', 'ACTIVED', 1),
(6, '2023-06-10 10:15:54', NULL, 'PATPAL51F', '', '104.756554;-2.990934', 'Patroli Area 6', 'ACTIVED', 1),
(7, '2023-06-10 10:15:54', NULL, 'PATPAL51G', '', '104.756554;-2.990934', 'Patroli Area 7', 'ACTIVED', 1),
(8, '2023-06-10 10:15:54', NULL, 'PATPAL70A', '', '104.756554;-2.990934', 'Patroli Pal70 1', 'ACTIVED', 2),
(9, '2023-06-10 10:15:54', NULL, 'PATPAL70B', '', '104.756554;-2.990934', 'Patroli Pal70 2', 'ACTIVED', 2),
(10, '2023-06-10 10:15:54', NULL, 'PATPAL70C', '', '104.756554;-2.990934', 'Patroli Pal70 3', 'ACTIVED', 2);

-- --------------------------------------------------------

--
-- Table structure for table `patrol_checkpoint_log`
--

CREATE TABLE `patrol_checkpoint_log` (
  `id` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `checkpoint_location_log` varchar(255) DEFAULT NULL,
  `checkpoint_location_long_lat_log` varchar(255) DEFAULT NULL,
  `checkpoint_long_lat` varchar(255) DEFAULT NULL,
  `checkpoint_name_log` varchar(255) DEFAULT NULL,
  `shift_end_time_log` time DEFAULT NULL,
  `shift_start_time_log` time DEFAULT NULL,
  `checkpoint_id` bigint(20) NOT NULL,
  `pleton_id` bigint(20) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `business_date` date NOT NULL,
  `safe_asset_client_code_log` varchar(255) DEFAULT NULL,
  `safe_asset_client_images` varchar(255) DEFAULT NULL,
  `safe_asset_client_name_log` varchar(255) DEFAULT NULL,
  `safe_asset_client_checkpoint_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patrol_checkpoint_log`
--

INSERT INTO `patrol_checkpoint_log` (`id`, `created_at`, `updated_at`, `checkpoint_location_log`, `checkpoint_location_long_lat_log`, `checkpoint_long_lat`, `checkpoint_name_log`, `shift_end_time_log`, `shift_start_time_log`, `checkpoint_id`, `pleton_id`, `shift_id`, `business_date`, `safe_asset_client_code_log`, `safe_asset_client_images`, `safe_asset_client_name_log`, `safe_asset_client_checkpoint_id`) VALUES
('20230619_2_3_2', '2023-06-19 23:46:44', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '00:00:00', '16:01:00', 3, 2, 2, '2023-06-19', NULL, NULL, NULL, NULL),
('20230625_2_3_2', '2023-06-25 21:48:34', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '00:00:00', '08:31:00', 3, 2, 2, '2023-06-25', NULL, NULL, NULL, NULL),
('20230626_2_3_2', '2023-06-27 00:39:00', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '03:00:00', '16:01:00', 3, 2, 2, '2023-06-26', NULL, NULL, NULL, NULL),
('20230630_1_1_1', '2023-06-30 10:32:10', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846710;-2.9588216', '110.485261;-7.332665', 'Checkpoint 1', '16:00:00', '08:01:00', 1, 1, 1, '2023-06-30', NULL, NULL, NULL, NULL),
('20230712_1_1_1', '2023-07-12 08:35:09', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846710;-2.9588216', '110.485261;-7.332665', 'Checkpoint 1', '16:00:00', '08:01:00', 1, 1, 1, '2023-07-12', NULL, NULL, NULL, NULL),
('20230716_2_3_2', '2023-07-16 09:44:43', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '23:59:59', '09:01:00', 3, 2, 2, '2023-07-16', NULL, NULL, NULL, NULL),
('20230722_2_3_2', '2023-07-22 14:43:37', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '23:59:59', '09:01:00', 3, 2, 2, '2023-07-22', NULL, NULL, NULL, NULL),
('20230919_1_1_1', '2023-09-19 15:26:32', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846710;-2.9588216', '110.485261;-7.332665', 'Checkpoint 1', '16:00:00', '08:01:00', 1, 1, 1, '2023-09-19', NULL, NULL, NULL, NULL),
('20231112_2_3_1_157a3b9b-7e5f-43a1-88a8-6885725c18aa', '2023-11-12 08:12:53', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '16:00:00', '08:01:00', 3, 2, 1, '2023-11-12', 'GENSETBIGBLUE', '16900092829917283ea245e9843e884f947debcf9bd59.png,169000931321373614cd63d1447cabe65caafad323b38.png', 'Genset Besar Biru', 8),
('20231112_2_3_1_84c27993-64f3-4a7d-bc77-faedd3bbc940', '2023-11-12 08:13:45', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '16:00:00', '08:01:00', 3, 2, 1, '2023-11-12', 'GENSETBIGBLUE', '16900092829917283ea245e9843e884f947debcf9bd59.png,169000931321373614cd63d1447cabe65caafad323b38.png', 'Genset Besar Biru', 8),
('20231112_2_3_1_868f8fe0-62ae-4f73-b848-a862f3daaf5c', '2023-11-12 08:25:31', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '16:00:00', '08:01:00', 3, 2, 1, '2023-11-12', NULL, NULL, NULL, NULL),
('20231112_2_3_1_c3477f96-61fb-46cf-bb0e-7c85b89b5704', '2023-11-12 08:13:20', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '16:00:00', '08:01:00', 3, 2, 1, '2023-11-12', NULL, NULL, NULL, NULL),
('20231112_2_3_3_f754ae59-51ba-4d4e-82c9-648389c919dc', '2023-11-12 07:47:47', NULL, 'Jl. Jend. Sudirman No.km 4', '104.735846760;-2.9588216', '104.73584671;-2.9588216', 'Checkpoint 3', '08:00:00', '00:01:00', 3, 2, 3, '2023-11-12', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `fitur` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `fitur`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Menu Aset', 'web', 'menu', 'asset', '2023-09-27 04:50:32', '2023-09-27 04:50:32'),
(2, 'Melihat data Aset', 'web', 'index', 'asset', '2023-09-27 04:50:32', '2023-09-27 04:50:32'),
(3, 'Membuat data Aset', 'web', 'create', 'asset', '2023-09-27 04:50:32', '2023-09-27 04:50:32'),
(4, 'Mengedit data Aset', 'web', 'edit', 'asset', '2023-09-27 04:50:32', '2023-09-27 04:50:32'),
(5, 'Melihat detail data Aset', 'web', 'show', 'asset', '2023-09-27 04:50:32', '2023-09-27 04:50:32'),
(6, 'Menghapus data Aset', 'web', 'destroy', 'asset', '2023-09-27 04:50:32', '2023-09-27 04:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pivot_guard_projects`
--

CREATE TABLE `pivot_guard_projects` (
  `id_guard` bigint(20) UNSIGNED NOT NULL,
  `id_project` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pleton`
--

CREATE TABLE `pleton` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `area_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pleton`
--

INSERT INTO `pleton` (`id`, `created_at`, `updated_at`, `code`, `name`, `status`, `area_id`) VALUES
(1, '2023-06-08 15:45:18', NULL, 'ELANG51', 'Elang Area 51', 'ACTIVED', 1),
(2, '2023-06-08 15:45:18', NULL, 'JANGKRIK51', 'Jangkrik Area 51', 'ACTIVED', 1),
(3, '2023-06-08 15:45:18', NULL, 'KINJENG51', 'Kinjeng Area 51', 'ACTIVED', 1),
(4, '2023-06-08 15:45:18', NULL, 'DAHLIA70', 'Dahlia Area 70', 'ACTIVED', 2),
(5, '2023-06-08 15:45:18', NULL, 'ANGREK70', 'Anggrek Area 70', 'ACTIVED', 2),
(6, '2023-06-08 15:45:18', NULL, 'GATOTKACA251', 'GatotKaca Area 251', 'ACTIVED', 3),
(7, '2023-06-08 15:45:18', NULL, 'GARENG251', 'Gareng Area 251', 'ACTIVED', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pleton_patrol_area`
--

CREATE TABLE `pleton_patrol_area` (
  `id` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `patrol_area_id` bigint(20) NOT NULL,
  `pleton_id` bigint(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pleton_patrol_area`
--

INSERT INTO `pleton_patrol_area` (`id`, `created_at`, `patrol_area_id`, `pleton_id`, `updated_at`) VALUES
('1_1', '2023-06-10 10:59:18', 1, 1, NULL),
('1_2', '2023-06-10 10:59:18', 2, 1, NULL),
('2_1', '2023-06-10 10:59:18', 1, 2, NULL),
('2_2', '2023-06-10 10:59:18', 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `location_long_lat` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `created_at`, `updated_at`, `address`, `code`, `location_long_lat`, `name`, `status`, `branch_id`, `city_id`) VALUES
(1, '2023-06-08 15:34:02', NULL, 'Jl. Mancur 3', 'PROPERTAPALEMBANG', '104.756554;-2.990934', 'Pertagas Palembang', 'ACTIVED', 1, 16937),
(2, '2023-06-08 15:34:02', NULL, 'Jl. Telo 1', 'PROPERTAPALEMBANG2', '104.007235;-3.711416', 'Pertagas Muara Enim', 'ACTIVED', 1, 16937),
(3, '2023-06-08 15:37:32', NULL, 'Jl. Telo 21', 'KERUPUKGASPALEMBANG', '104.756554;-2.990934', 'Kerupuk Gas Palembang Dalam', 'ACTIVED', 2, 16937);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`) VALUES
(11, 'ACEH'),
(12, 'SUMATERA UTARA'),
(13, 'SUMATERA BARAT'),
(14, 'RIAU'),
(15, 'JAMBI'),
(16, 'SUMATERA SELATAN'),
(17, 'BENGKULU'),
(18, 'LAMPUNG'),
(19, 'KEPULAUAN BANGKA BELITUNG'),
(21, 'KEPULAUAN RIAU'),
(31, 'DAERAH KHUSUS IBUKOTA JAKARTA'),
(32, 'JAWA BARAT'),
(33, 'JAWA TENGAH'),
(34, 'DAERAH ISTIMEWA YOGYAKARTA'),
(35, 'JAWA TIMUR'),
(36, 'BANTEN'),
(51, 'BALI'),
(52, 'NUSA TENGGARA BARAT'),
(53, 'NUSA TENGGARA TIMUR'),
(61, 'KALIMANTAN BARAT'),
(62, 'KALIMANTAN TENGAH'),
(63, 'KALIMANTAN SELATAN'),
(64, 'KALIMANTAN TIMUR'),
(65, 'KALIMANTAN UTARA'),
(71, 'SULAWESI UTARA'),
(72, 'SULAWESI TENGAH'),
(73, 'SULAWESI SELATAN'),
(74, 'SULAWESI TENGGARA'),
(75, 'GORONTALO'),
(76, 'SULAWESI BARAT'),
(81, 'MALUKU'),
(82, 'MALUKU UTARA'),
(91, 'PAPUA'),
(92, 'PAPUA BARAT');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super-admin', 'web', '2023-09-27 04:50:31', '2023-09-27 04:50:31'),
(2, 'user', 'web', '2023-09-27 04:50:31', '2023-09-27 04:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rounds`
--

CREATE TABLE `rounds` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') NOT NULL,
  `patrol_area_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rounds`
--

INSERT INTO `rounds` (`id`, `created_at`, `updated_at`, `name`, `status`, `patrol_area_id`) VALUES
(1, '2023-06-11 12:44:50', NULL, 'PatPal51A Round 1', 'ACTIVED', 1),
(2, '2023-06-11 12:44:50', NULL, 'PatPal51A Round 2', 'ACTIVED', 1),
(3, '2023-06-11 12:44:50', NULL, 'PatPal51A Round 3', 'ACTIVED', 1),
(4, '2023-06-11 12:45:53', NULL, 'PatPal51B Round 1', 'ACTIVED', 2),
(5, '2023-06-11 12:45:53', NULL, 'PatPal51B Round 2', 'ACTIVED', 2),
(6, '2023-06-11 12:45:53', NULL, 'PatPal51B Round 3', 'ACTIVED', 2),
(7, '2023-06-11 13:28:48', NULL, 'PatPal51C Round 1', 'ACTIVED', 3),
(8, '2023-06-11 13:28:48', NULL, 'PatPal51C Round 2', 'ACTIVED', 3);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `end_time` time NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `created_at`, `updated_at`, `end_time`, `name`, `start_time`) VALUES
(1, '2023-06-09 08:54:03', NULL, '16:00:00', 'Shift Pagi', '08:01:00'),
(2, '2023-06-09 08:55:12', NULL, '23:59:59', 'Shift Siang', '09:01:00'),
(3, '2023-06-09 08:55:12', NULL, '08:00:00', 'Shift Malam', '00:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guard_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_badge` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('ACTIVED','INACTIVED') DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `guard_id`, `no_badge`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'super-admin', 'admin@gmail.com', NULL, '$2y$10$L/T8ku/7lb4iTIRf2YK45.fBepr4VZGXnCrZ1Ak8RrE3nQ0ixeqa.', 'ACTIVED', 'UCfOtBZTDAluSjeJWteJ1rsnnACXrYfMHtS0SeXgNNNLNhzpDxxGYwoNdkKg', '2023-09-27 07:32:40', '2023-09-27 07:32:40'),
(2, 1, '123456', 'agus', 'agus@gmail.com', NULL, '$2y$10$.YZEr7bYLqTjukP3mGI7b.aJCe6l52dooLOXElkoavGh/Ltn.pB3q', 'ACTIVED', NULL, '2023-09-27 07:32:40', '2023-09-27 07:32:40'),
(3, 3, '222222', 'Ogy', 'ogythoks@gmail.com', NULL, '$2y$10$.YZEr7bYLqTjukP3mGI7b.aJCe6l52dooLOXElkoavGh/Ltn.pB3q', 'ACTIVED', NULL, '2023-11-11 15:32:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wilayahs`
--

CREATE TABLE `wilayahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK2njj07ntvohwf4m5w07hwbifh` (`project_id`);

--
-- Indexes for table `asset_client_checkpoint`
--
ALTER TABLE `asset_client_checkpoint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKn68cba4my63b4yosribouosan` (`asset_master_id`),
  ADD KEY `FK62i9sqporvui19ssvq9cdj6kb` (`checkpoint_id`);

--
-- Indexes for table `asset_patrol_checkpoint`
--
ALTER TABLE `asset_patrol_checkpoint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK7hbkn1rl31dsee74i69tm4oks` (`asset_master_id`),
  ADD KEY `FKikyipmid6gbljqe6ovk1w0uxh` (`checkpoint_id`);

--
-- Indexes for table `asset_patrol_checkpoint_log`
--
ALTER TABLE `asset_patrol_checkpoint_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKmhesnctfh8c8iieckcjwfgru8` (`asset_patrol_checkpoint_id`),
  ADD KEY `FKjpm0qutc5h6lekvogjjhkcbnv` (`asset_unsafe_option_id`),
  ADD KEY `FK8yk5oq9ttshwsl6dmwl72fdby` (`patrol_checkpoint_log_id`);

--
-- Indexes for table `asset_patrol_master`
--
ALTER TABLE `asset_patrol_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_unsafe_option`
--
ALTER TABLE `asset_unsafe_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkpoint`
--
ALTER TABLE `checkpoint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKasslo22tmud5xfmfxecbhhv45` (`round_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKll21eddgtrjc9f40ueeouyr8f` (`province_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guards`
--
ALTER TABLE `guards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKd8sv14c28jj3h28340aby1nx` (`pleton_id`),
  ADD KEY `FK4hxhh3i6mta999y0a2tfr7hdn` (`shift_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `patrol_area`
--
ALTER TABLE `patrol_area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UK_iucraj0kw0gb8favn5ksasp7g` (`code`),
  ADD KEY `FKoel3drdrolltp0qy2ahtm0tlo` (`area_id`);

--
-- Indexes for table `patrol_checkpoint_log`
--
ALTER TABLE `patrol_checkpoint_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKsdd8f4410tncnfa2xwr3i9rqq` (`checkpoint_id`),
  ADD KEY `FK45h7wfvn19fj7vjll22oiuryv` (`pleton_id`),
  ADD KEY `FK2mmfu8dlcsvyq7375ii79ey56` (`shift_id`),
  ADD KEY `FKddf96q3ukmubnp1dscgsqkhxc` (`safe_asset_client_checkpoint_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pleton`
--
ALTER TABLE `pleton`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK7irp74yjaguy2m0r4jf9w3bxr` (`area_id`);

--
-- Indexes for table `pleton_patrol_area`
--
ALTER TABLE `pleton_patrol_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK1ffkstyio9grigk8sedcfb2pr` (`patrol_area_id`),
  ADD KEY `FKs0lf4oex3jvo3ce77qeuf5j2m` (`pleton_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKp612pfxkrtlesm9tu6cm0447v` (`branch_id`),
  ADD KEY `FKsvc6o016hobs95eyr69jol3ry` (`city_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rounds`
--
ALTER TABLE `rounds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKqcmnt2q4mjgetd2xnfyyrdl7a` (`patrol_area_id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wilayahs`
--
ALTER TABLE `wilayahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wilayahs_kode_unique` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `asset_client_checkpoint`
--
ALTER TABLE `asset_client_checkpoint`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `asset_patrol_checkpoint`
--
ALTER TABLE `asset_patrol_checkpoint`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `asset_patrol_master`
--
ALTER TABLE `asset_patrol_master`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `asset_unsafe_option`
--
ALTER TABLE `asset_unsafe_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checkpoint`
--
ALTER TABLE `checkpoint`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79733;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guards`
--
ALTER TABLE `guards`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patrol_area`
--
ALTER TABLE `patrol_area`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pleton`
--
ALTER TABLE `pleton`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rounds`
--
ALTER TABLE `rounds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wilayahs`
--
ALTER TABLE `wilayahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `FK2njj07ntvohwf4m5w07hwbifh` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `asset_client_checkpoint`
--
ALTER TABLE `asset_client_checkpoint`
  ADD CONSTRAINT `FK62i9sqporvui19ssvq9cdj6kb` FOREIGN KEY (`checkpoint_id`) REFERENCES `checkpoint` (`id`),
  ADD CONSTRAINT `FKn68cba4my63b4yosribouosan` FOREIGN KEY (`asset_master_id`) REFERENCES `asset_patrol_master` (`id`);

--
-- Constraints for table `asset_patrol_checkpoint`
--
ALTER TABLE `asset_patrol_checkpoint`
  ADD CONSTRAINT `FK7hbkn1rl31dsee74i69tm4oks` FOREIGN KEY (`asset_master_id`) REFERENCES `asset_patrol_master` (`id`),
  ADD CONSTRAINT `FKikyipmid6gbljqe6ovk1w0uxh` FOREIGN KEY (`checkpoint_id`) REFERENCES `checkpoint` (`id`);

--
-- Constraints for table `asset_patrol_checkpoint_log`
--
ALTER TABLE `asset_patrol_checkpoint_log`
  ADD CONSTRAINT `FK8yk5oq9ttshwsl6dmwl72fdby` FOREIGN KEY (`patrol_checkpoint_log_id`) REFERENCES `patrol_checkpoint_log` (`id`),
  ADD CONSTRAINT `FKjpm0qutc5h6lekvogjjhkcbnv` FOREIGN KEY (`asset_unsafe_option_id`) REFERENCES `asset_unsafe_option` (`id`),
  ADD CONSTRAINT `FKmhesnctfh8c8iieckcjwfgru8` FOREIGN KEY (`asset_patrol_checkpoint_id`) REFERENCES `asset_patrol_checkpoint` (`id`);

--
-- Constraints for table `checkpoint`
--
ALTER TABLE `checkpoint`
  ADD CONSTRAINT `FKasslo22tmud5xfmfxecbhhv45` FOREIGN KEY (`round_id`) REFERENCES `rounds` (`id`);

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `FKll21eddgtrjc9f40ueeouyr8f` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`);

--
-- Constraints for table `guards`
--
ALTER TABLE `guards`
  ADD CONSTRAINT `FK4hxhh3i6mta999y0a2tfr7hdn` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`),
  ADD CONSTRAINT `FKd8sv14c28jj3h28340aby1nx` FOREIGN KEY (`pleton_id`) REFERENCES `pleton` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patrol_area`
--
ALTER TABLE `patrol_area`
  ADD CONSTRAINT `FKoel3drdrolltp0qy2ahtm0tlo` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Constraints for table `patrol_checkpoint_log`
--
ALTER TABLE `patrol_checkpoint_log`
  ADD CONSTRAINT `FK2mmfu8dlcsvyq7375ii79ey56` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`),
  ADD CONSTRAINT `FK45h7wfvn19fj7vjll22oiuryv` FOREIGN KEY (`pleton_id`) REFERENCES `pleton` (`id`),
  ADD CONSTRAINT `FKddf96q3ukmubnp1dscgsqkhxc` FOREIGN KEY (`safe_asset_client_checkpoint_id`) REFERENCES `asset_client_checkpoint` (`id`),
  ADD CONSTRAINT `FKsdd8f4410tncnfa2xwr3i9rqq` FOREIGN KEY (`checkpoint_id`) REFERENCES `checkpoint` (`id`);

--
-- Constraints for table `pleton`
--
ALTER TABLE `pleton`
  ADD CONSTRAINT `FK7irp74yjaguy2m0r4jf9w3bxr` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Constraints for table `pleton_patrol_area`
--
ALTER TABLE `pleton_patrol_area`
  ADD CONSTRAINT `FK1ffkstyio9grigk8sedcfb2pr` FOREIGN KEY (`patrol_area_id`) REFERENCES `patrol_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKs0lf4oex3jvo3ce77qeuf5j2m` FOREIGN KEY (`pleton_id`) REFERENCES `pleton` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `FKp612pfxkrtlesm9tu6cm0447v` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `FKsvc6o016hobs95eyr69jol3ry` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rounds`
--
ALTER TABLE `rounds`
  ADD CONSTRAINT `FKqcmnt2q4mjgetd2xnfyyrdl7a` FOREIGN KEY (`patrol_area_id`) REFERENCES `patrol_area` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
