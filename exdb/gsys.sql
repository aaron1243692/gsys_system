-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2026 at 09:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `acady`
--

CREATE TABLE `acady` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `year_from` year(4) DEFAULT NULL,
  `year_to` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `acady`
--

INSERT INTO `acady` (`id`, `name`, `year_from`, `year_to`, `created_at`, `updated_at`) VALUES
(4, 'asdas', '2026', '2027', '2026-06-01 12:36:24', '2026-06-01 12:36:24'),
(5, '2024-2025', '2024', '2025', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(6, '2025-2026', '2025', '2026', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(7, '2026-2027', '2026', '2027', '2026-07-01 07:48:17', '2026-07-01 07:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `agreement_records`
--

CREATE TABLE `agreement_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_version` varchar(255) NOT NULL,
  `accepted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_events`
--

CREATE TABLE `audit_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actor_type` varchar(255) NOT NULL,
  `actor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(255) NOT NULL,
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `curriculum_id` int(11) DEFAULT NULL,
  `track_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `year`, `curriculum_id`, `track_id`, `created_at`, `updated_at`) VALUES
(1, '2027', NULL, 4, '2026-06-02 09:01:14', '2026-06-02 09:08:44'),
(2, '2028', NULL, 2, '2026-06-02 09:08:37', '2026-06-02 09:08:37'),
(3, '2024', 2, NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(4, '2025', 2, NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(5, '2026', 2, NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1789437841),
('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1789437841;', 1789437841),
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:8:\"codename\";s:1:\"d\";s:9:\"parent_id\";s:1:\"e\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:3:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:6:\"sadasd\";s:1:\"c\";s:3:\"asd\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:1;a:6:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"view\";s:1:\"c\";s:8:\"asd.view\";s:1:\"d\";i:1;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:6:{s:1:\"a\";i:3;s:1:\"b\";s:6:\"delete\";s:1:\"c\";s:10:\"asd.delete\";s:1:\"d\";i:1;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"e\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:5:\"staff\";s:1:\"e\";s:3:\"web\";}}}', 1789196069);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `grlvl_id` int(11) DEFAULT NULL,
  `track_id` int(11) DEFAULT NULL,
  `acady_id` int(11) DEFAULT NULL,
  `adviser_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `grlvl_id`, `track_id`, `acady_id`, `adviser_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 5, 1, 4, 1, 'bsit 3ba', '2026-06-01 22:37:53', '2026-06-03 11:53:30'),
(3, 5, NULL, 4, NULL, 'sdsd', '2026-06-02 12:23:57', '2026-06-02 12:23:57'),
(5, 18, 1, 6, 2, 'Grade 11 STEM A', '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(6, 18, 1, 6, 3, 'Grade 11 STEM B', '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(7, 18, 2, 6, 4, 'Grade 11 ABM A', '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(8, 19, 1, 6, 5, 'Grade 12 STEM A', '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(9, 19, 1, 6, 6, 'Grade 12 STEM B', '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(10, 19, 2, 6, 7, 'Grade 12 ABM A', '2026-07-01 07:48:48', '2026-07-01 07:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `classsched`
--

CREATE TABLE `classsched` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `classsched`
--

INSERT INTO `classsched` (`id`, `class_id`, `subject_id`, `day`, `room_id`, `time_from`, `time_to`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Monday', 1, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(2, 2, 2, 'Tuesday', 2, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(3, 2, 3, 'Wednesday', 3, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(4, 2, 4, 'Thursday', 4, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(5, 2, 5, 'Friday', 5, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(6, 3, 6, 'Monday', 2, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(7, 3, 7, 'Tuesday', 3, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(8, 3, 8, 'Wednesday', 4, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(9, 3, 9, 'Thursday', 5, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(10, 3, 10, 'Friday', 6, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(11, 5, 11, 'Monday', 3, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(12, 5, 12, 'Tuesday', 4, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(13, 5, 13, 'Wednesday', 5, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(14, 5, 14, 'Thursday', 6, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(15, 5, 15, 'Friday', 1, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(16, 6, 16, 'Monday', 4, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(17, 6, 17, 'Tuesday', 5, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(18, 6, 18, 'Wednesday', 6, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(19, 6, 1, 'Thursday', 1, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(20, 6, 2, 'Friday', 2, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(21, 7, 3, 'Monday', 5, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(22, 7, 4, 'Tuesday', 6, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(23, 7, 5, 'Wednesday', 1, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(24, 7, 6, 'Thursday', 2, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(25, 7, 7, 'Friday', 3, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(26, 8, 8, 'Monday', 6, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(27, 8, 9, 'Tuesday', 1, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(28, 8, 10, 'Wednesday', 2, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(29, 8, 11, 'Thursday', 3, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(30, 8, 12, 'Friday', 4, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(31, 9, 13, 'Monday', 1, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(32, 9, 14, 'Tuesday', 2, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(33, 9, 15, 'Wednesday', 3, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(34, 9, 16, 'Thursday', 4, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(35, 9, 17, 'Friday', 5, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(36, 10, 18, 'Monday', 2, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(37, 10, 1, 'Tuesday', 3, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(38, 10, 2, 'Wednesday', 4, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(39, 10, 3, 'Thursday', 5, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(40, 10, 4, 'Friday', 6, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-07-01 07:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `classsub`
--

CREATE TABLE `classsub` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `classsub`
--

INSERT INTO `classsub` (`id`, `class_id`, `sub_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, '2026-06-01 23:33:31', '2026-06-01 23:33:31'),
(3, 5, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(4, 5, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(5, 5, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(6, 5, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(7, 5, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(8, 5, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(9, 5, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(10, 5, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(11, 5, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(12, 5, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(13, 6, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(14, 6, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(15, 6, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(16, 6, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(17, 6, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(18, 6, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(19, 6, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(20, 6, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(21, 6, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(22, 6, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(23, 7, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(24, 7, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(25, 7, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(26, 7, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(27, 7, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(28, 7, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(29, 7, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(30, 7, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(31, 7, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(32, 7, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(33, 8, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(34, 8, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(35, 8, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(36, 8, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(37, 8, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(38, 8, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(39, 8, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(40, 8, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(41, 8, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(42, 8, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(43, 9, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(44, 9, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(45, 9, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(46, 9, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(47, 9, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(48, 9, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(49, 9, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(50, 9, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(51, 9, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(52, 9, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(53, 10, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(54, 10, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(55, 10, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(56, 10, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(57, 10, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(58, 10, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(59, 10, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(60, 10, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(61, 10, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(62, 10, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE `curriculum` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `track_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`id`, `name`, `track_id`, `batch_id`, `created_at`, `updated_at`) VALUES
(1, 'ghgh', NULL, NULL, '2026-06-02 08:34:38', '2026-06-02 08:34:38'),
(2, 'Senior High STEM Curriculum', 1, NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(3, 'Senior High ABM Curriculum', 2, NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_subjects`
--

CREATE TABLE `curriculum_subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `curriculum_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_level` tinyint(3) UNSIGNED DEFAULT NULL,
  `year_level` tinyint(3) UNSIGNED NOT NULL,
  `semester` tinyint(3) UNSIGNED NOT NULL,
  `units` decimal(4,1) NOT NULL DEFAULT 0.0,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `prerequisites` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `curriculum_subjects`
--

INSERT INTO `curriculum_subjects` (`id`, `curriculum_id`, `subject_id`, `grade_level`, `year_level`, `semester`, `units`, `sort_order`, `prerequisites`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 11, 11, 1, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(2, 2, 6, 11, 11, 1, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(3, 2, 8, 11, 11, 1, 0.0, 3, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(4, 2, 10, 11, 11, 1, 0.0, 4, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(5, 2, 15, 11, 11, 1, 0.0, 5, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(6, 2, 5, 11, 11, 2, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(7, 2, 7, 11, 11, 2, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(8, 2, 9, 11, 11, 2, 0.0, 3, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(9, 2, 12, 11, 11, 2, 0.0, 4, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(10, 2, 17, 11, 11, 2, 0.0, 5, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(11, 2, 11, 12, 12, 1, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(12, 2, 13, 12, 12, 1, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(13, 2, 16, 12, 12, 1, 0.0, 3, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(14, 2, 18, 12, 12, 1, 0.0, 4, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(15, 2, 14, 12, 12, 2, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(16, 2, 7, 12, 12, 2, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(17, 2, 18, 12, 12, 2, 0.0, 3, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(18, 3, 4, 11, 11, 1, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(19, 3, 6, 11, 11, 1, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(20, 3, 8, 11, 11, 1, 0.0, 3, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(21, 3, 10, 11, 11, 1, 0.0, 4, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(22, 3, 15, 11, 11, 1, 0.0, 5, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(23, 3, 5, 11, 11, 2, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(24, 3, 7, 11, 11, 2, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(25, 3, 9, 11, 11, 2, 0.0, 3, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(26, 3, 12, 11, 11, 2, 0.0, 4, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(27, 3, 17, 11, 11, 2, 0.0, 5, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(28, 3, 11, 12, 12, 1, 0.0, 1, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(29, 3, 13, 12, 12, 1, 0.0, 2, NULL, '2026-07-01 07:49:35', '2026-07-01 07:52:06'),
(30, 3, 16, 12, 12, 1, 0.0, 3, NULL, '2026-07-01 07:49:36', '2026-07-01 07:52:06'),
(31, 3, 18, 12, 12, 1, 0.0, 4, NULL, '2026-07-01 07:49:36', '2026-07-01 07:52:06'),
(32, 3, 14, 12, 12, 2, 0.0, 1, NULL, '2026-07-01 07:49:36', '2026-07-01 07:52:06'),
(33, 3, 7, 12, 12, 2, 0.0, 2, NULL, '2026-07-01 07:49:36', '2026-07-01 07:52:06'),
(34, 3, 18, 12, 12, 2, 0.0, 3, NULL, '2026-07-01 07:49:36', '2026-07-01 07:52:06');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `class_list_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `first_quarter` decimal(5,2) DEFAULT NULL,
  `second_quarter` decimal(5,2) DEFAULT NULL,
  `third_quarter` decimal(5,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `grade_level_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `quarter` tinyint(3) UNSIGNED DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `academic_year_name` varchar(255) DEFAULT NULL,
  `grade_level_name` varchar(255) DEFAULT NULL,
  `teacher_name` varchar(255) DEFAULT NULL,
  `grade_sheet_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `class_list_id`, `subject_id`, `first_quarter`, `second_quarter`, `third_quarter`, `final_grade`, `remarks`, `created_at`, `updated_at`, `student_id`, `class_id`, `academic_year_id`, `grade_level_id`, `teacher_id`, `created_by`, `updated_by`, `quarter`, `grade`, `student_name`, `class_name`, `subject_name`, `academic_year_name`, `grade_level_name`, `teacher_name`, `grade_sheet_id`) VALUES
(4, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:26', '2026-09-15 05:26:33', 32, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Daniel Dela Cruz', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(5, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 24, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Jose Aquino', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(6, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 16, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Marco Cruz', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(7, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 56, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Marco Ramos', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(8, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 8, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Miguel Flores', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(9, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 48, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Miguel Santos', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(10, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 40, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Rafael Navarro', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grade_encoding_schedules`
--

CREATE TABLE `grade_encoding_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `quarter` tinyint(3) UNSIGNED NOT NULL,
  `opens_at` datetime NOT NULL,
  `closes_at` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_sheets`
--

CREATE TABLE `grade_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `grade_level_id` int(11) DEFAULT NULL,
  `quarter` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'DRAFT',
  `teacher_name` varchar(255) DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `academic_year_name` varchar(255) DEFAULT NULL,
  `grade_level_name` varchar(255) DEFAULT NULL,
  `roster` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roster`)),
  `submitted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `returned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `returned_at` datetime DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `return_reason` text DEFAULT NULL,
  `correction_until` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_sheets`
--

INSERT INTO `grade_sheets` (`id`, `teacher_id`, `class_id`, `subject_id`, `academic_year_id`, `grade_level_id`, `quarter`, `status`, `teacher_name`, `class_name`, `subject_name`, `academic_year_name`, `grade_level_name`, `roster`, `submitted_by`, `submitted_at`, `returned_by`, `returned_at`, `approved_by`, `approved_at`, `return_reason`, `correction_until`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 4, 6, 19, 1, 'DRAFT', 'jaycee', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', '[32,24,16,56,8,48,40]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-14 21:26:33', '2026-09-14 21:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `grlvl`
--

CREATE TABLE `grlvl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `grlvl`
--

INSERT INTO `grlvl` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'grade 2', '2026-06-01 11:43:45', '2026-06-01 12:09:16'),
(3, 'sadd', '2026-06-01 12:10:51', '2026-06-01 12:10:51'),
(5, 'asdas', '2026-06-01 12:10:58', '2026-06-01 12:10:58'),
(8, 'asdsad', '2026-06-01 12:11:11', '2026-06-01 12:11:11'),
(18, 'Grade 11', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(19, 'Grade 12', '2026-07-01 07:48:17', '2026-07-01 07:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `guardianchilds`
--

CREATE TABLE `guardianchilds` (
  `id` int(11) NOT NULL,
  `guardian_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'PENDING',
  `relationship` varchar(255) DEFAULT NULL,
  `claimed_student_name` varchar(255) DEFAULT NULL,
  `claimed_birthdate` date DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `verification_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `guardianchilds`
--

INSERT INTO `guardianchilds` (`id`, `guardian_id`, `student_id`, `created_at`, `updated_at`, `status`, `relationship`, `claimed_student_name`, `claimed_birthdate`, `verified_by`, `verified_at`, `verification_note`) VALUES
(1, 1, 1, '2026-06-01 23:36:36', '2026-06-01 23:36:36', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, '2026-07-01 07:49:44', '2026-07-01 07:49:44', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 3, '2026-07-01 07:49:44', '2026-07-01 07:49:44', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 4, '2026-07-01 07:49:44', '2026-07-01 07:49:44', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 5, '2026-07-01 07:49:44', '2026-07-01 07:49:44', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 3, 6, '2026-07-01 07:49:45', '2026-07-01 07:49:45', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 3, 7, '2026-07-01 07:49:45', '2026-07-01 07:49:45', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 4, 8, '2026-07-01 07:49:45', '2026-07-01 07:49:45', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 4, 9, '2026-07-01 07:49:45', '2026-07-01 07:49:45', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 5, 10, '2026-07-01 07:49:46', '2026-07-01 07:49:46', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 5, 11, '2026-07-01 07:49:46', '2026-07-01 07:49:46', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 6, 12, '2026-07-01 07:49:46', '2026-07-01 07:49:46', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 6, 13, '2026-07-01 07:49:46', '2026-07-01 07:49:46', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 7, 14, '2026-07-01 07:49:47', '2026-07-01 07:49:47', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 7, 15, '2026-07-01 07:49:47', '2026-07-01 07:49:47', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 8, 16, '2026-07-01 07:49:47', '2026-07-01 07:49:47', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 8, 17, '2026-07-01 07:49:47', '2026-07-01 07:49:47', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 9, 18, '2026-07-01 07:49:48', '2026-07-01 07:49:48', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 9, 19, '2026-07-01 07:49:48', '2026-07-01 07:49:48', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 10, 20, '2026-07-01 07:49:48', '2026-07-01 07:49:48', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 10, 21, '2026-07-01 07:49:48', '2026-07-01 07:49:48', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 11, 22, '2026-07-01 07:49:49', '2026-07-01 07:49:49', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 11, 23, '2026-07-01 07:49:49', '2026-07-01 07:49:49', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 12, 24, '2026-07-01 07:49:49', '2026-07-01 07:49:49', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 12, 25, '2026-07-01 07:49:50', '2026-07-01 07:49:50', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 13, 26, '2026-07-01 07:49:50', '2026-07-01 07:49:50', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(27, 13, 27, '2026-07-01 07:49:50', '2026-07-01 07:49:50', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(28, 14, 28, '2026-07-01 07:49:50', '2026-07-01 07:49:50', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 14, 29, '2026-07-01 07:49:51', '2026-07-01 07:49:51', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 15, 30, '2026-07-01 07:49:51', '2026-07-01 07:49:51', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 15, 31, '2026-07-01 07:49:51', '2026-07-01 07:49:51', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 16, 32, '2026-07-01 07:49:51', '2026-07-01 07:49:51', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 16, 33, '2026-07-01 07:49:52', '2026-07-01 07:49:52', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 17, 34, '2026-07-01 07:49:52', '2026-07-01 07:49:52', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(35, 17, 35, '2026-07-01 07:49:52', '2026-07-01 07:49:52', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 18, 36, '2026-07-01 07:49:52', '2026-07-01 07:49:52', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 18, 37, '2026-07-01 07:49:53', '2026-07-01 07:49:53', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 19, 38, '2026-07-01 07:49:53', '2026-07-01 07:49:53', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 19, 39, '2026-07-01 07:49:53', '2026-07-01 07:49:53', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(40, 20, 40, '2026-07-01 07:49:53', '2026-07-01 07:49:53', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(41, 20, 41, '2026-07-01 07:49:54', '2026-07-01 07:49:54', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(42, 21, 42, '2026-07-01 07:49:54', '2026-07-01 07:49:54', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(43, 21, 43, '2026-07-01 07:49:54', '2026-07-01 07:49:54', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 22, 44, '2026-07-01 07:49:54', '2026-07-01 07:49:54', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 22, 45, '2026-07-01 07:49:55', '2026-07-01 07:49:55', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(46, 23, 46, '2026-07-01 07:49:55', '2026-07-01 07:49:55', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(47, 23, 47, '2026-07-01 07:49:55', '2026-07-01 07:49:55', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 24, 48, '2026-07-01 07:49:56', '2026-07-01 07:49:56', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 24, 49, '2026-07-01 07:49:56', '2026-07-01 07:49:56', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 25, 50, '2026-07-01 07:49:56', '2026-07-01 07:49:56', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 25, 51, '2026-07-01 07:49:56', '2026-07-01 07:49:56', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 26, 52, '2026-07-01 07:49:57', '2026-07-01 07:49:57', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 26, 53, '2026-07-01 07:49:57', '2026-07-01 07:49:57', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(54, 27, 54, '2026-07-01 07:49:57', '2026-07-01 07:49:57', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 27, 55, '2026-07-01 07:49:57', '2026-07-01 07:49:57', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 28, 56, '2026-07-01 07:49:58', '2026-07-01 07:49:58', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 28, 57, '2026-07-01 07:49:58', '2026-07-01 07:49:58', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 29, 58, '2026-07-01 07:49:58', '2026-07-01 07:49:58', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(59, 29, 59, '2026-07-01 07:49:58', '2026-07-01 07:49:58', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 30, 60, '2026-07-01 07:49:59', '2026-07-01 07:49:59', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 30, 61, '2026-07-01 07:49:59', '2026-07-01 07:49:59', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  `activated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `deactivated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deactivated_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `username`, `email`, `password`, `name`, `contact`, `address`, `created_at`, `updated_at`, `status`, `activated_by`, `activated_at`, `rejected_by`, `rejected_at`, `deactivated_by`, `deactivated_at`, `rejection_reason`) VALUES
(1, 'guardian', 'guardian@example.com', '$2y$12$7sKVpB5nhJlUI/qjyopUten26aXUOCG0YQOVcE1rGs8oeWavWHife', NULL, NULL, NULL, '2026-05-31 23:29:51', '2026-09-10 23:14:25', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'parent01', 'parent01@example.com', '$2y$12$NgpZyMmK7SCZGIN/stCoC.yOAxQZgfE/cKGErDVnEKqkPGowYTOW6', 'Mr./Ms. Dela Cruz', '09170000000', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:36', '2026-07-01 07:52:06', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'parent02', 'parent02@example.com', '$2y$12$W4EsYU6EDwIi9Cipw6UIaecQA1H69gA4obyI7w3chYtmDSC7umDbW', 'Mr./Ms. Santos', '09170000001', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:36', '2026-07-01 07:52:07', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'parent03', 'parent03@example.com', '$2y$12$p0h1aNkeGitonlt8di/g1umXNpd.ensX0Apw3eaCTUpRrr7BAs4lG', 'Mr./Ms. Reyes', '09170000002', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:36', '2026-07-01 07:52:07', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'parent04', 'parent04@example.com', '$2y$12$kZFN3ZcBjeHk1gm5k2lUH.lMTEBKDExMbnUsrbUw2zy2BgvJwC7uC', 'Mr./Ms. Garcia', '09170000003', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-07-01 07:52:07', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'parent05', 'parent05@example.com', '$2y$12$dgMjkVXwTa7Cd0cSCNoNrO1DWoft3HRyasVKc3MIR6VGPgjBYnQ4m', 'Mr./Ms. Mendoza', '09170000004', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-07-01 07:52:07', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'parent06', 'parent06@example.com', '$2y$12$2OBvLu1yTZPVdS40gkLPce./pCzhsvDMCs4Gzeg4ecE/LGOAM91Gu', 'Mr./Ms. Lopez', '09170000005', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-07-01 07:52:08', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'parent07', 'parent07@example.com', '$2y$12$RH.tn7KDO.dFO5ai2WB28ujf5bojyo5nRxcWAx2rL3mML7vjbfWaW', 'Mr./Ms. Flores', '09170000006', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-07-01 07:52:08', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'parent08', 'parent08@example.com', '$2y$12$ksPlPNMO4xQd28hHCuQJhOhEld/VhFpwv51FCIsMUSXxE/biDc8A6', 'Mr./Ms. Aquino', '09170000007', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-07-01 07:52:08', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'parent09', 'parent09@example.com', '$2y$12$gqL4pslnbrCNQuJb4ax4aeEzO27JXhqPi8E1TUKdB/4cJMFlntj2m', 'Mr./Ms. Navarro', '09170000008', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-07-01 07:52:09', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'parent10', 'parent10@example.com', '$2y$12$KBNps0cpLawWqizjUI6SEOFvHiuPb1iJZUDLIcWvJGfR/oSaVQAo.', 'Mr./Ms. Ramos', '09170000009', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-07-01 07:52:09', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'parent11', 'parent11@example.com', '$2y$12$H91m2lRCfoqJTd3dLfxhGOIZ2BnCfu3RE.R6u8YSkNUcVec.YNXVi', 'Mr./Ms. Torres', '09170000010', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-07-01 07:52:09', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'parent12', 'parent12@example.com', '$2y$12$l9Emzal1VEhObzF4mvZbReX28psI1vTjrXvhIkA9P/yMWvc1IFTXq', 'Mr./Ms. Castro', '09170000011', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-07-01 07:52:09', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'parent13', 'parent13@example.com', '$2y$12$yaa.vv.4h9knGBuhi/jOhe0YSwQ0CN1UV2VXeJ8qqjg3HfF53a/g2', 'Mr./Ms. Villanueva', '09170000012', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-07-01 07:52:10', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'parent14', 'parent14@example.com', '$2y$12$DMjPHE7G68Y89MLlPXTM0OGNwNeE/utE3ZKkdfhCMHvtHeCQOzyBG', 'Mr./Ms. Bautista', '09170000013', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-07-01 07:52:10', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'parent15', 'parent15@example.com', '$2y$12$xxMKRMuL8v/kWoQvPajw0ek4cp5i8TgOHd.fA5OCvySXv/aUbZ6nW', 'Mr./Ms. Cruz', '09170000014', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-07-01 07:52:10', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'parent16', 'parent16@example.com', '$2y$12$hhC8gij31OU3EJQ1ARo67.69J8tJ3G0HI.S8DNmL4mUXVuqYh5wcm', 'Mr./Ms. Diaz', '09170000015', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-07-01 07:52:10', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'parent17', 'parent17@example.com', '$2y$12$bYeDE3HS3ISI8.2Q00eawuRPHQV9/mjhxTMI37cxd4uTttkxQXD0y', 'Mr./Ms. Morales', '09170000016', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-07-01 07:52:11', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'parent18', 'parent18@example.com', '$2y$12$EEzrm8RfJswLCsXnbYSOW.gS.9j7A/DAGzQlTa1R4H2WYndtMoYEW', 'Mr./Ms. Rivera', '09170000017', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-07-01 07:52:11', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'parent19', 'parent19@example.com', '$2y$12$1HlRmp1tBD6g3cniauUAxe0idtZOJ4hIxu6Q37e/U2d.Cp3sTiT2u', 'Mr./Ms. Gonzales', '09170000018', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-07-01 07:52:11', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'parent20', 'parent20@example.com', '$2y$12$rlv5fBBSXZlYT5OIitKubuvuh9NZB6TeLUkDosoRjRnQvln.GQBSy', 'Mr./Ms. Padilla', '09170000019', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-07-01 07:52:12', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'parent21', 'parent21@example.com', '$2y$12$YpPy3HwDGaoe1vrPsIc8GOQOTX2PF2zr9wKZCYeONdx1x89ZyVEla', 'Mr./Ms. Salazar', '09170000020', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-07-01 07:52:12', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'parent22', 'parent22@example.com', '$2y$12$dJA8C89ZG.6jtwsM49QUZOECivERilpfzXBrM8I4n31AS788AElK.', 'Mr./Ms. Domingo', '09170000021', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-07-01 07:52:12', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'parent23', 'parent23@example.com', '$2y$12$SAoFjPTri8xyK0JWqm.rYeNeCzwBN7t0bDoKLybNO6Mta1vg8yUz6', 'Mr./Ms. Mercado', '09170000022', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-07-01 07:52:13', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'parent24', 'parent24@example.com', '$2y$12$pp1KSGxzkzAiGBTY2K0FI.CI5evJ0s0LF7RVyKrQuZgY5jIp68DJ6', 'Mr./Ms. Pascual', '09170000023', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-07-01 07:52:13', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'parent25', 'parent25@example.com', '$2y$12$qzDO77pARY2tNdwUUVceSu0JgjW9xx2EL3b5ECwSz9WgQ7R7WJohK', 'Mr./Ms. Valdez', '09170000024', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-07-01 07:52:13', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'parent26', 'parent26@example.com', '$2y$12$fI16OIi8GabV9KBZuY7xoup6qZJsW4.GLv2IZJMO1mn1y/m6oC66i', 'Mr./Ms. Aguilar', '09170000025', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-07-01 07:52:14', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'parent27', 'parent27@example.com', '$2y$12$40b2JZWf/SlXu5VZQM2NRuSTPleWw9Btr.2g1PmsrbSvOoddYJiyW', 'Mr./Ms. Rosales', '09170000026', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-07-01 07:52:14', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'parent28', 'parent28@example.com', '$2y$12$Xzg2rCsmRrgutmNf0DHP..8LlhycO6Nl7z8qYVmUdF3BB1sKG73Vi', 'Mr./Ms. Fernandez', '09170000027', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:43', '2026-07-01 07:52:14', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'parent29', 'parent29@example.com', '$2y$12$kdaa/ONeaeYb3KoWVHTOp.mb/ohFlhHGMNn26MGmyL8nDIEDYZMFe', 'Mr./Ms. Alvarez', '09170000028', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:43', '2026-07-01 07:52:14', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'parent30', 'parent30@example.com', '$2y$12$SMwO6i1lUbe0BbTPuEVuze3.BXOKgIDuRfvXl122oYQA4Xz4Qk3sC', 'Mr./Ms. Gutierrez', '09170000029', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:43', '2026-07-01 07:52:15', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_30_135604_create_permission_tables', 1),
(5, '2026_05_30_140000_rename_name_to_username_on_users_table', 1),
(6, '2026_05_30_141000_add_hierarchy_to_permissions_table', 1),
(7, '2026_05_30_142000_drop_name_guard_unique_from_permissions_table', 1),
(8, '2026_06_01_000000_create_students_table', 1),
(9, '2026_06_01_000001_create_guardians_table', 1),
(10, '2026_06_02_000000_add_deleted_at_to_subject_table', 2),
(11, '2026_06_02_000001_add_teacher_id_to_subject_table', 3),
(12, '2026_06_02_000002_create_curriculum_subjects_table', 4),
(13, '2026_06_03_000001_add_track_id_to_class_table', 4),
(14, '2026_06_03_000002_add_flow_columns_to_batch_and_curriculum_tables', 5),
(15, '2026_06_03_000003_add_grlvl_id_to_tracksub_table', 6),
(16, '2026_06_03_000004_scope_curriculum_subjects_by_curriculum_grade_semester', 7),
(17, '2026_06_03_000005_add_adviser_id_to_class_table', 8),
(18, '2026_09_11_000001_extend_grades_for_quarter_recording', 9),
(19, '2026_09_15_000001_add_web_workflow', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pending_grades`
--

CREATE TABLE `pending_grades` (
  `id` int(11) NOT NULL,
  `class_list_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `first_quarter` decimal(5,2) DEFAULT NULL,
  `second_quarter` decimal(5,2) DEFAULT NULL,
  `third_quarter` decimal(5,2) DEFAULT NULL,
  `fourth_quarter` decimal(5,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `submitted_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `codename` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_id`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'sadasd', 'asd', NULL, 'web', NULL, NULL),
(2, 'view', 'asd.view', 1, 'web', NULL, NULL),
(3, 'delete', 'asd.delete', 1, 'web', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-05-31 23:29:50', '2026-05-31 23:29:50'),
(12, 'staff', 'web', '2026-06-02 00:53:21', '2026-06-02 00:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 1),
(3, 1),
(3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'lab121', '2026-06-03 11:17:41', '2026-06-03 11:17:41'),
(2, 'Room 101', '2026-07-01 07:49:59', '2026-07-01 07:49:59'),
(3, 'Room 102', '2026-07-01 07:49:59', '2026-07-01 07:49:59'),
(4, 'Room 201', '2026-07-01 07:49:59', '2026-07-01 07:49:59'),
(5, 'Science Lab', '2026-07-01 07:49:59', '2026-07-01 07:49:59'),
(6, 'Computer Lab', '2026-07-01 07:49:59', '2026-07-01 07:49:59');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0l1VCPMFmhQVIuoyi4cTYYtFAFRGr0EjJE49iX5x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3FxRVBzcTRVQWxaUFNIN1FtbTUzcVA2Tnh3MzdmcHFXMFlHbzAwQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS90ZXJtcy1vZi11c2UiO3M6NToicm91dGUiO3M6MTE6ImxlZ2FsLnRlcm1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789450017),
('5TdZdw1u8WBZI5HWc7qkwEO8TLCM1oH4rtlm8rYU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVVuNU1sdEJMRURObWlRbzVKN0V6a3ZhSlRFUWtKVnlrZ1VmWXo2WiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1OToiaHR0cDovLzEyNy4wLjAuMTo4MDE1L2NvbmZpZ3VyYXRpb24vZ3JhZGUtZW5jb2Rpbmctc2NoZWR1bGUiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo1OToiaHR0cDovLzEyNy4wLjAuMTo4MDE1L2NvbmZpZ3VyYXRpb24vZ3JhZGUtZW5jb2Rpbmctc2NoZWR1bGUiO3M6NToicm91dGUiO3M6Mzc6ImNvbmZpZ3VyYXRpb24uZ3JhZGUtZW5jb2Rpbmctc2NoZWR1bGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789450018),
('8PTA4oqdN6hQMa1MOofF3m49X4YsRG0Fj58bYaNP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWE5SSzNyQjBRbkEyQWVXV0NETVY4cTROS0E1SHQ3dHBQVFNVZXNtdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo2OiJzaWduaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789448816),
('9X5i04I1rRE03Wo14vxbZ9DxPHmxcZ2AKNLAXUmI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUVYM0hzMEF1ZDBYQU1qTE1VVEs3YmdOMzFZODJhQkUxVDF4eGhQaiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDE1L3JlcG9ydC9ncmFkZXMvYXBwcm92YWwiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDE1L3JlcG9ydC9ncmFkZXMvYXBwcm92YWwiO3M6NToicm91dGUiO3M6MjI6InJlcG9ydC5ncmFkZXMuYXBwcm92YWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789450018),
('CHwP0htWWjXfMJKgyEcDwDpQNLaQO0Rrydz6f9or', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0RKRGhCbGVndFdKMGpQZzNZOEs3MFBCSEd5bmt1TGwxcUFHYTE5aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wb3J0YWwvc3R1ZGVudC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czoxNToicG9ydGFsLnJlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789450017),
('gdMD5OSNt3qbOVueK7dlKuUWgJHrxz7NrFx8fMWU', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlcxWFBsY01HNjM3QmJsYldFdjlzRXUwRlJ3Y1JKT2hNVHUzWjhUNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wb3J0YWwvZ3VhcmRpYW4vcmVnaXN0ZXIiO3M6NToicm91dGUiO3M6MTU6InBvcnRhbC5yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789450034),
('hbBeSbiVLahTXxGSt7t04yjIp39Wr5a4zN7tr4Xg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia0NMQUdKNFNQc3FNM1dvcUtUeHVuMXo5QTNQM0VwdVkwWkQ4a25YcyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1ODoiaHR0cDovLzEyNy4wLjAuMTo4MDE1L2NvbmZpZ3VyYXRpb24vYWNjb3VudHMvcmVnaXN0cmF0aW9ucyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU4OiJodHRwOi8vMTI3LjAuMC4xOjgwMTUvY29uZmlndXJhdGlvbi9hY2NvdW50cy9yZWdpc3RyYXRpb25zIjtzOjU6InJvdXRlIjtzOjM2OiJjb25maWd1cmF0aW9uLmFjY291bnRzLnJlZ2lzdHJhdGlvbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789450018),
('HSErrd14PCvTRmg5mFwIkxqCel29NSGE8Zontvj9', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUhaUGpPTm00NDJSWkNSbFZBa2g2MDBCWnQzVlBDOVV3Y2tra1IzNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS90ZXJtcy1vZi11c2UiO3M6NToicm91dGUiO3M6MTE6ImxlZ2FsLnRlcm1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789450034),
('L13S4n2p36PbpMUhQ6TR51ZsGYe7uXradlrvRtMT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSm9malBGVG56U3dQMGdoVG9wZjdNS3EwaTRFT2xud3FaOEJpSFprMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wb3J0YWwvZ3VhcmRpYW4vcmVnaXN0ZXIiO3M6NToicm91dGUiO3M6MTU6InBvcnRhbC5yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789450017),
('lqmSBRHtHszV4NSkVpnyxWwMLX9qqftJlgIwrK8o', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaFc4NlRtQ01pOWpDUGZuaWFtT2tOOW05bmxXTVhKTjRBNTE5YlBKYyI7czo1NDoibG9naW5fc3R1ZGVudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L3N1YmplY3RzIjtzOjU6InJvdXRlIjtzOjE2OiJzdHVkZW50LnN1YmplY3RzIjt9fQ==', 1789114726),
('mI2b0pGJ2cXwYHn6w3NN0spmt7tD4wdnm1sHkimw', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTTJDRXE1cW5mVnplUmcxZnF3cE1tYk9penpkeEprak1ZSEtPNVdJRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wb3J0YWwvc3R1ZGVudC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czoxNToicG9ydGFsLnJlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789450034),
('pzALGTqsmTANrPX0P9bH5dcUNpfCpjqSdbqV0n6K', NULL, '127.0.0.1', 'curl/8.21.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTENvNHl4UGxjRFk0UGZWMk5RSDl6a3NReGdQT09YdmNzVHZDaWNFeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDE1L3JlcG9ydC9ncmFkZXMvYXBwcm92YWwiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDE1L3JlcG9ydC9ncmFkZXMvYXBwcm92YWwiO3M6NToicm91dGUiO3M6MjI6InJlcG9ydC5ncmFkZXMuYXBwcm92YWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789450034),
('qDkVghdkrcsWlbend43FDWcnTyHGQHyuYHvw3kqY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVQ4R3RKdzBHOHRNSG1hVDdBQkprd3VVcUtKdEFKcVFDdXFYUEl2OSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb25maWd1cmF0aW9uL2dyYWRlLWVuY29kaW5nLXNjaGVkdWxlIjtzOjU6InJvdXRlIjtzOjM3OiJjb25maWd1cmF0aW9uLmdyYWRlLWVuY29kaW5nLXNjaGVkdWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1789439524),
('tAVXU0wy8lzCXcVFEDJFPK8iBrWtGpmiWNsyiXOb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkJia2VQQUE3WTFJM1U1SVRweWFyU2EzRldzcVp1WHJUSHZuODBSZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wcml2YWN5LW5vdGljZSI7czo1OiJyb3V0ZSI7czoxMzoibGVnYWwucHJpdmFjeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789450017),
('u38VR2dxXdhnG0vyv1jDTkDEiczMoCbPw2mzJree', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEtKZ3Zna1kybXc0SUlVSEd4RVBkY01kT1ZNQU1CY2dIZ1g2WjdXcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wcml2YWN5LW5vdGljZSI7czo1OiJyb3V0ZSI7czoxMzoibGVnYWwucHJpdmFjeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1789450034),
('UDjIdlOQg16b3sgVAM5sVXhoKYx6Ieh64id7EdKr', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2ROUng3aW5tVU9ZMEg4VHNiS0kyZ0JOTERJNFlTd0VIQVFTYXBkTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo2OiJzaWduaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789109709),
('x4A04rXkzRBXSdNu60lQjTYlz90n8IMSpQnbZYpa', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkJpdjczZ09UY3BGYlpwUXJ0WWZ0MWx0enJmM24zcDVPREdlazBuOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wb3J0YWwvdGVhY2hlci9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMjoicG9ydGFsLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789450034),
('yaArryrL3IExbH6cD4l1cXPdIitO6CLLoqGzZiJd', NULL, '127.0.0.1', 'curl/8.21.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS0dDSWhaaTNHcVE5S05hRGRYUll1ZmRpcDV1OFhmMWdQenN0eUZsSSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1OToiaHR0cDovLzEyNy4wLjAuMTo4MDE1L2NvbmZpZ3VyYXRpb24vZ3JhZGUtZW5jb2Rpbmctc2NoZWR1bGUiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo1OToiaHR0cDovLzEyNy4wLjAuMTo4MDE1L2NvbmZpZ3VyYXRpb24vZ3JhZGUtZW5jb2Rpbmctc2NoZWR1bGUiO3M6NToicm91dGUiO3M6Mzc6ImNvbmZpZ3VyYXRpb24uZ3JhZGUtZW5jb2Rpbmctc2NoZWR1bGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789450034),
('Zb4YRr93tgNhpqqR4OlRh07K8Pp1lQpjxi6JI7NV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.9444', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlduN2UxMXFNUEFSc3BjRXJYSDBpWFRJZTY4YVhlUDdGZkt6akRydCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAxNS9wb3J0YWwvdGVhY2hlci9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMjoicG9ydGFsLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789450017),
('Zfw34oMrwkmomwwd3DOf6LWAXvoklDYnb0PoMlOz', NULL, '127.0.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlBtTWRYNFlvcE1OcEFxSFhKbnJ5bVJpc1U3VkhpU2xGSUN3eVl0byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wb3J0YWwvdGVhY2hlci9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMjoicG9ydGFsLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1789109709),
('zoCpDJodwsUhTrcNWLRD5qFAZLO74pfj6Gn9jBSt', NULL, '127.0.0.1', 'curl/8.21.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUDc4UlI4cWFmdUpyd3MzQTc2UGpoMWIydzVTd3gzRWlSMXp5eHRLQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1ODoiaHR0cDovLzEyNy4wLjAuMTo4MDE1L2NvbmZpZ3VyYXRpb24vYWNjb3VudHMvcmVnaXN0cmF0aW9ucyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU4OiJodHRwOi8vMTI3LjAuMC4xOjgwMTUvY29uZmlndXJhdGlvbi9hY2NvdW50cy9yZWdpc3RyYXRpb25zIjtzOjU6InJvdXRlIjtzOjM2OiJjb25maWd1cmF0aW9uLmFjY291bnRzLnJlZ2lzdHJhdGlvbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1789450034);

-- --------------------------------------------------------

--
-- Table structure for table `stinfo`
--

CREATE TABLE `stinfo` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `lrn` bigint(20) DEFAULT NULL,
  `admited` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(150) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `grlvl_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `acady_id` int(11) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `stinfo`
--

INSERT INTO `stinfo` (`id`, `student_id`, `lrn`, `admited`, `name`, `gender`, `birthdate`, `grlvl_id`, `class_id`, `acady_id`, `contact`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 2323, 1, 'dff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-03 19:46:01', '2026-06-10 05:36:26'),
(2, 2, 110000000000, 1, 'Juan Dela Cruz', 'Male', '2010-07-01', 5, 2, 6, '09180000000', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-07-01 07:49:44'),
(3, 3, 110000000001, 1, 'Maria Santos', 'Female', '2009-06-18', 5, 3, 6, '09180000001', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-07-01 07:49:44'),
(4, 4, 110000000002, 1, 'Jose Reyes', 'Male', '2008-06-05', 18, 5, 6, '09180000002', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-07-01 07:49:44'),
(5, 5, 110000000003, 1, 'Ana Garcia', 'Female', '2010-05-23', 18, 6, 6, '09180000003', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-07-01 07:49:44'),
(6, 6, 110000000004, 1, 'Carlo Mendoza', 'Male', '2009-05-10', 18, 7, 6, '09180000004', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-07-01 07:49:45'),
(7, 7, 110000000005, 1, 'Angelica Lopez', 'Female', '2008-04-27', 19, 8, 6, '09180000005', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-07-01 07:49:45'),
(8, 8, 110000000006, 1, 'Miguel Flores', 'Male', '2010-04-14', 19, 9, 6, '09180000006', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-07-01 07:49:45'),
(9, 9, 110000000007, 1, 'Sofia Aquino', 'Female', '2009-04-01', 19, 10, 6, '09180000007', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-07-01 07:49:45'),
(10, 10, 110000000008, 1, 'Gabriel Navarro', 'Male', '2008-03-19', 5, 2, 6, '09180000008', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-07-01 07:49:46'),
(11, 11, 110000000009, 1, 'Nicole Ramos', 'Female', '2010-03-06', 5, 3, 6, '09180000009', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-07-01 07:49:46'),
(12, 12, 110000000010, 1, 'Daniel Torres', 'Male', '2009-02-21', 18, 5, 6, '09180000010', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-07-01 07:49:46'),
(13, 13, 110000000011, 1, 'Andrea Castro', 'Female', '2008-02-09', 18, 6, 6, '09180000011', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-07-01 07:49:46'),
(14, 14, 110000000012, 1, 'Joshua Villanueva', 'Male', '2010-01-26', 18, 7, 6, '09180000012', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-07-01 07:49:47'),
(15, 15, 110000000013, 1, 'Katrina Bautista', 'Female', '2009-01-13', 19, 8, 6, '09180000013', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-07-01 07:49:47'),
(16, 16, 110000000014, 1, 'Marco Cruz', 'Male', '2008-01-01', 19, 9, 6, '09180000014', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-07-01 07:49:47'),
(17, 17, 110000000015, 1, 'Christine Dela Cruz', 'Female', '2009-12-18', 19, 10, 6, '09180000015', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-07-01 07:49:47'),
(18, 18, 110000000016, 1, 'Paolo Santos', 'Male', '2008-12-05', 5, 2, 6, '09180000016', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-07-01 07:49:48'),
(19, 19, 110000000017, 1, 'Jasmine Reyes', 'Female', '2007-11-23', 5, 3, 6, '09180000017', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-07-01 07:49:48'),
(20, 20, 110000000018, 1, 'Rafael Garcia', 'Male', '2009-11-09', 18, 5, 6, '09180000018', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-07-01 07:49:48'),
(21, 21, 110000000019, 1, 'Bianca Mendoza', 'Female', '2008-10-27', 18, 6, 6, '09180000019', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-07-01 07:49:48'),
(22, 22, 110000000020, 1, 'Juan Lopez', 'Male', '2007-10-15', 18, 7, 6, '09180000020', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:49', '2026-07-01 07:49:49'),
(23, 23, 110000000021, 1, 'Maria Flores', 'Female', '2009-10-01', 19, 8, 6, '09180000021', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:49', '2026-07-01 07:49:49'),
(24, 24, 110000000022, 1, 'Jose Aquino', 'Male', '2008-09-18', 19, 9, 6, '09180000022', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:49', '2026-07-01 07:49:49'),
(25, 25, 110000000023, 1, 'Ana Navarro', 'Female', '2007-09-06', 19, 10, 6, '09180000023', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-07-01 07:49:50'),
(26, 26, 110000000024, 1, 'Carlo Ramos', 'Male', '2009-08-23', 5, 2, 6, '09180000024', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-07-01 07:49:50'),
(27, 27, 110000000025, 1, 'Angelica Torres', 'Female', '2008-08-10', 5, 3, 6, '09180000025', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-07-01 07:49:50'),
(28, 28, 110000000026, 1, 'Miguel Castro', 'Male', '2007-07-29', 18, 5, 6, '09180000026', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-07-01 07:49:50'),
(29, 29, 110000000027, 1, 'Sofia Villanueva', 'Female', '2009-07-15', 18, 6, 6, '09180000027', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-07-01 07:49:51'),
(30, 30, 110000000028, 1, 'Gabriel Bautista', 'Male', '2008-07-02', 18, 7, 6, '09180000028', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-07-01 07:49:51'),
(31, 31, 110000000029, 1, 'Nicole Cruz', 'Female', '2007-06-20', 19, 8, 6, '09180000029', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-07-01 07:49:51'),
(32, 32, 110000000030, 1, 'Daniel Dela Cruz', 'Male', '2009-06-06', 19, 9, 6, '09180000030', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-07-01 07:49:51'),
(33, 33, 110000000031, 1, 'Andrea Santos', 'Female', '2008-05-24', 19, 10, 6, '09180000031', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-07-01 07:49:52'),
(34, 34, 110000000032, 1, 'Joshua Reyes', 'Male', '2007-05-12', 5, 2, 6, '09180000032', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-07-01 07:49:52'),
(35, 35, 110000000033, 1, 'Katrina Garcia', 'Female', '2009-04-28', 5, 3, 6, '09180000033', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-07-01 07:49:52'),
(36, 36, 110000000034, 1, 'Marco Mendoza', 'Male', '2008-04-15', 18, 5, 6, '09180000034', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-07-01 07:49:52'),
(37, 37, 110000000035, 1, 'Christine Lopez', 'Female', '2007-04-03', 18, 6, 6, '09180000035', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-07-01 07:49:53'),
(38, 38, 110000000036, 1, 'Paolo Flores', 'Male', '2009-03-20', 18, 7, 6, '09180000036', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-07-01 07:49:53'),
(39, 39, 110000000037, 1, 'Jasmine Aquino', 'Female', '2008-03-07', 19, 8, 6, '09180000037', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-07-01 07:49:53'),
(40, 40, 110000000038, 1, 'Rafael Navarro', 'Male', '2007-02-23', 19, 9, 6, '09180000038', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-07-01 07:49:53'),
(41, 41, 110000000039, 1, 'Bianca Ramos', 'Female', '2009-02-09', 19, 10, 6, '09180000039', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-07-01 07:49:54'),
(42, 42, 110000000040, 1, 'Juan Torres', 'Male', '2008-01-28', 5, 2, 6, '09180000040', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-07-01 07:49:54'),
(43, 43, 110000000041, 1, 'Maria Castro', 'Female', '2007-01-15', 5, 3, 6, '09180000041', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-07-01 07:49:54'),
(44, 44, 110000000042, 1, 'Jose Villanueva', 'Male', '2009-01-01', 18, 5, 6, '09180000042', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-07-01 07:49:54'),
(45, 45, 110000000043, 1, 'Ana Bautista', 'Female', '2007-12-20', 18, 6, 6, '09180000043', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:55', '2026-07-01 07:49:55'),
(46, 46, 110000000044, 1, 'Carlo Cruz', 'Male', '2006-12-07', 18, 7, 6, '09180000044', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:55', '2026-07-01 07:49:55'),
(47, 47, 110000000045, 1, 'Angelica Dela Cruz', 'Female', '2008-11-23', 19, 8, 6, '09180000045', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:55', '2026-07-01 07:49:55'),
(48, 48, 110000000046, 1, 'Miguel Santos', 'Male', '2007-11-11', 19, 9, 6, '09180000046', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-07-01 07:49:56'),
(49, 49, 110000000047, 1, 'Sofia Reyes', 'Female', '2006-10-29', 19, 10, 6, '09180000047', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-07-01 07:49:56'),
(50, 50, 110000000048, 1, 'Gabriel Garcia', 'Male', '2008-10-15', 5, 2, 6, '09180000048', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-07-01 07:49:56'),
(51, 51, 110000000049, 1, 'Nicole Mendoza', 'Female', '2007-10-03', 5, 3, 6, '09180000049', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-07-01 07:49:56'),
(52, 52, 110000000050, 1, 'Daniel Lopez', 'Male', '2006-09-20', 18, 5, 6, '09180000050', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-07-01 07:49:57'),
(53, 53, 110000000051, 1, 'Andrea Flores', 'Female', '2008-09-06', 18, 6, 6, '09180000051', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-07-01 07:49:57'),
(54, 54, 110000000052, 1, 'Joshua Aquino', 'Male', '2007-08-25', 18, 7, 6, '09180000052', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-07-01 07:49:57'),
(55, 55, 110000000053, 1, 'Katrina Navarro', 'Female', '2006-08-12', 19, 8, 6, '09180000053', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-07-01 07:49:57'),
(56, 56, 110000000054, 1, 'Marco Ramos', 'Male', '2008-07-29', 19, 9, 6, '09180000054', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-10 23:03:50'),
(57, 57, 110000000055, 1, 'Christine Torres', 'Female', '2007-07-17', 19, 10, 6, '09180000055', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-10 23:03:44'),
(58, 58, 110000000056, 1, 'Paolo Castro', 'Male', '2006-07-04', 5, 2, 6, '09180000056', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-10 23:03:53'),
(59, 59, 110000000057, 1, 'Jasmine Villanueva', 'Female', '2008-06-20', 5, 3, 6, '09180000057', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-10 23:03:47'),
(60, 60, 110000000058, 1, 'Rafael Bautista', 'Male', '2007-06-08', 18, 5, 6, '09180000058', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 07:49:59', '2026-09-10 23:03:56'),
(61, 61, 110000000059, 1, 'Bianca Cruz', 'Female', '2006-05-26', 18, 6, 6, '09180000059', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 07:49:59', '2026-09-10 23:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  `activated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `deactivated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deactivated_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `student_number` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`, `status`, `activated_by`, `activated_at`, `rejected_by`, `rejected_at`, `deactivated_by`, `deactivated_at`, `rejection_reason`, `student_number`) VALUES
(1, 'student', NULL, '$2y$12$eboeark9HuxfOJ1dJasWmuQY6qdYtNlz3eGtLGU5HikHg9SQtYel2', '2026-05-31 23:29:51', '2026-09-10 23:14:39', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '29878576314'),
(2, 'student001', 'student001@student.gsys.edu.ph', '$2y$12$WBvIzpQ58ot3M2HhBPbRvuxZpuMQTY37fRJhhOjVMFGkZ8xMXeRGa', '2026-07-01 07:49:44', '2026-07-01 07:52:15', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '91770721139'),
(3, 'student002', 'student002@student.gsys.edu.ph', '$2y$12$SmWxdHIV59bGPOtoCDDg5.7R..wGvyzrnqLXuQbjevl.3nYrhlU5m', '2026-07-01 07:49:44', '2026-07-01 07:52:15', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '90870090163'),
(4, 'student003', 'student003@student.gsys.edu.ph', '$2y$12$56GC.Q/v5N612AEnN5oCp.c40oVt0BbjE/y2jalc5KFsB5zc/8pSW', '2026-07-01 07:49:44', '2026-07-01 07:52:16', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '97996666193'),
(5, 'student004', 'student004@student.gsys.edu.ph', '$2y$12$ud7ycdTqgTlPFW87JZG/B.DbBMG.cSek4uG/fAoJkEjEwHiEfkYX.', '2026-07-01 07:49:44', '2026-07-01 07:52:16', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '80700417770'),
(6, 'student005', 'student005@student.gsys.edu.ph', '$2y$12$uS0hGNXp5zXmPDcfkW1qB.6pcELEemvJHASgqcBke.1sFrv0AJkJi', '2026-07-01 07:49:45', '2026-07-01 07:52:16', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '71648911157'),
(7, 'student006', 'student006@student.gsys.edu.ph', '$2y$12$U2Bcq12A/pN7ijKQAqp.TuRVHnd.2hzd0RBxni5XmUU9rNuZELcIa', '2026-07-01 07:49:45', '2026-07-01 07:52:17', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '37845911680'),
(8, 'student007', 'student007@student.gsys.edu.ph', '$2y$12$VohkWZb71U6/UN/cfynVMO4KpKeuS9aqiCQMd9s0qVP4aBTiw/DOi', '2026-07-01 07:49:45', '2026-07-01 07:52:17', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '65500286898'),
(9, 'student008', 'student008@student.gsys.edu.ph', '$2y$12$51LLmlgAuFAj.TGh.pFQOuv5ukuR5jr0BC.g73tgks4v67DOI2mDW', '2026-07-01 07:49:45', '2026-07-01 07:52:17', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '27905516173'),
(10, 'student009', 'student009@student.gsys.edu.ph', '$2y$12$fXf25iWfX9M3a6B61GVlyOryLw8Ul9n5Km1fnYVzp8Zx9ckEJ8i.K', '2026-07-01 07:49:46', '2026-07-01 07:52:17', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '23095267803'),
(11, 'student010', 'student010@student.gsys.edu.ph', '$2y$12$fadEoCJeW7XWv4X6OTZQHu/ykt.k8luiv9wmLqySn3H3c08BCBNA.', '2026-07-01 07:49:46', '2026-07-01 07:52:18', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '92749209466'),
(12, 'student011', 'student011@student.gsys.edu.ph', '$2y$12$YoXvhmX9044uMAGgTTaVkOv7Z4hgx.Zanlz.Ok7Vs3PPrERO9Unda', '2026-07-01 07:49:46', '2026-07-01 07:52:18', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '93064858632'),
(13, 'student012', 'student012@student.gsys.edu.ph', '$2y$12$lL9xE0OhGQtj/jzI0o/1KOMP0cZiUID8vEDqwTDWkFTBHs2Iaav5.', '2026-07-01 07:49:46', '2026-07-01 07:52:18', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '99909405329'),
(14, 'student013', 'student013@student.gsys.edu.ph', '$2y$12$cjxapg4FDNj3xo0jWvYJO.otNb29NvZ.IMhZyHWH9rK.XvwTT/HEK', '2026-07-01 07:49:47', '2026-07-01 07:52:18', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69515376716'),
(15, 'student014', 'student014@student.gsys.edu.ph', '$2y$12$YGlsk95OTWxmqA8HFiPIwuJZl9EpjALyOGzzrZEBofoSAVwEI.mSm', '2026-07-01 07:49:47', '2026-07-01 07:52:19', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '73889978268'),
(16, 'student015', 'student015@student.gsys.edu.ph', '$2y$12$pBLhPYP8HK7IslDQp2CNweHx7.kX1s7eeCETHfNyTco9AwtGwEdB2', '2026-07-01 07:49:47', '2026-07-01 07:52:19', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '15707729763'),
(17, 'student016', 'student016@student.gsys.edu.ph', '$2y$12$vklZuXZr0uqAy6eIhJsW9O.U1GzGULLdARM947h0Kkd/n3BQqPAXq', '2026-07-01 07:49:47', '2026-07-01 07:52:19', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '83947828426'),
(18, 'student017', 'student017@student.gsys.edu.ph', '$2y$12$9cuNJJvW50lkl0EP7vG5fuwmBF2AzdnImSg9r8h17bb8fwdfcgLPa', '2026-07-01 07:49:48', '2026-07-01 07:52:20', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32172240562'),
(19, 'student018', 'student018@student.gsys.edu.ph', '$2y$12$GWe0mH21x5Sk4yQdaWBEZOxxyckGLv10hIzPACGXoiQSqKI7D/EIO', '2026-07-01 07:49:48', '2026-07-01 07:52:20', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '41252262860'),
(20, 'student019', 'student019@student.gsys.edu.ph', '$2y$12$iquULDMSckkApn5doGOTPOo5Ra2rEVxrpkmjerro07LKbgObX.AUW', '2026-07-01 07:49:48', '2026-07-01 07:52:20', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '36390709306'),
(21, 'student020', 'student020@student.gsys.edu.ph', '$2y$12$x.lEle7dgNKP8ZR3Kd34AuCoBvgX9Mcp84CqivkHMnxWNwrvI9cUS', '2026-07-01 07:49:48', '2026-07-01 07:52:20', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16217723291'),
(22, 'student021', 'student021@student.gsys.edu.ph', '$2y$12$QDn8jsE.MAaBwZPn1tzOZOyTFGZi6jbmqW.G/79eJvCUX18OSw0Oq', '2026-07-01 07:49:49', '2026-07-01 07:52:21', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '71424558503'),
(23, 'student022', 'student022@student.gsys.edu.ph', '$2y$12$.n.gFr/5WbAasTwO/HHbteefz3MlClMU3ge0CK3ELdR5MJtj5YA2O', '2026-07-01 07:49:49', '2026-07-01 07:52:21', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '19939286208'),
(24, 'student023', 'student023@student.gsys.edu.ph', '$2y$12$KNvG/bmsDLg7jjmS.Z61/u98yUh7VP/96JtvJBJ1n1jwRWWlUWF6y', '2026-07-01 07:49:49', '2026-07-01 07:52:22', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30056369185'),
(25, 'student024', 'student024@student.gsys.edu.ph', '$2y$12$il2B9juOus7jV6Fbqp9HgOI90LGN95Xu/JuuF/F5XukW1/3w/vJCm', '2026-07-01 07:49:50', '2026-07-01 07:52:22', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '47530023867'),
(26, 'student025', 'student025@student.gsys.edu.ph', '$2y$12$VPiAL5W7tXc7aGZbJLnevu72mXJ7VIVR6giphapIpIf6HPl7wM4oe', '2026-07-01 07:49:50', '2026-07-01 07:52:22', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32887587710'),
(27, 'student026', 'student026@student.gsys.edu.ph', '$2y$12$6UozcnsyrDA3Q5gTVIHak.yRboDc66SOsr2KkU7OUdFCXK9m8Q6.e', '2026-07-01 07:49:50', '2026-07-01 07:52:23', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '58702701692'),
(28, 'student027', 'student027@student.gsys.edu.ph', '$2y$12$UJReKd93MM5pKGDZfJZ4eeA8iUjoIGJaXrNiQ.iU7Akl38qHS.xT.', '2026-07-01 07:49:50', '2026-07-01 07:52:23', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '51560499851'),
(29, 'student028', 'student028@student.gsys.edu.ph', '$2y$12$H0aHCTJFfo78Iys4aFR2e.KIL5xFQMZx25tLJ2jDDsWcU9YG2h6pa', '2026-07-01 07:49:51', '2026-07-01 07:52:24', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '38310772678'),
(30, 'student029', 'student029@student.gsys.edu.ph', '$2y$12$/HGBPOLaE51GMTTXcf06Z.SX3dIjh89gTEiZP/uDWn4Qh5LbSjU7C', '2026-07-01 07:49:51', '2026-07-01 07:52:24', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '14015478686'),
(31, 'student030', 'student030@student.gsys.edu.ph', '$2y$12$qC4CRIUZUKBXaoM.vbMTiuqV6m7vrsQODCrxefC5aL52If9wGqOky', '2026-07-01 07:49:51', '2026-07-01 07:52:24', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '92753930900'),
(32, 'student031', 'student031@student.gsys.edu.ph', '$2y$12$hyeClzgJhJnvTrR/t4rx9OQGWhYbEaCxKwS2WdpqWhhs4mL2ocic.', '2026-07-01 07:49:51', '2026-07-01 07:52:24', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '93224105643'),
(33, 'student032', 'student032@student.gsys.edu.ph', '$2y$12$8s4BfA392QHfmN94Tpqxqeq0LQdnOPCXDEEykiOLICFeDJa/VFhWO', '2026-07-01 07:49:52', '2026-07-01 07:52:25', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68349601311'),
(34, 'student033', 'student033@student.gsys.edu.ph', '$2y$12$Ub8TwZSBA0yubggaQOZsbO/HldroEhvr63hbYOGlVp6PKtJriEyBm', '2026-07-01 07:49:52', '2026-07-01 07:52:25', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16768931453'),
(35, 'student034', 'student034@student.gsys.edu.ph', '$2y$12$suzJ1pkXdRZ.1vhMVBvt0eZ5Csn0t7ngXCMbfne0CWCCxV.BMAbie', '2026-07-01 07:49:52', '2026-07-01 07:52:26', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '15688959273'),
(36, 'student035', 'student035@student.gsys.edu.ph', '$2y$12$2Vm0padoxfqmBDesBTb.8etniyC07GGs8dstcEmTTQhH8gOl7Q6ra', '2026-07-01 07:49:52', '2026-07-01 07:52:26', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '29730030435'),
(37, 'student036', 'student036@student.gsys.edu.ph', '$2y$12$8/ifqgLK/0UVBly02r0SwuZTPU1em9250diZlu0YRq4/wRm9xiO.m', '2026-07-01 07:49:53', '2026-07-01 07:52:26', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '18087519117'),
(38, 'student037', 'student037@student.gsys.edu.ph', '$2y$12$wgWol98YJamvtX6zSliZSOJ9P3M.TDQuo1tWggJBCkeSJxSmxF9JW', '2026-07-01 07:49:53', '2026-07-01 07:52:27', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '98316134278'),
(39, 'student038', 'student038@student.gsys.edu.ph', '$2y$12$10GKr.wzKGiIdMkaJZqjSu8kbcUzqS3WS8ZDzcH/gSg8uyqSDsAR2', '2026-07-01 07:49:53', '2026-07-01 07:52:27', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '17665694872'),
(40, 'student039', 'student039@student.gsys.edu.ph', '$2y$12$7sSZ8VXJW5pkgpeS8YCaFe9XEM2pYyYcW8eIhGYE0DWcA.Kt5naA2', '2026-07-01 07:49:53', '2026-07-01 07:52:27', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24749472895'),
(41, 'student040', 'student040@student.gsys.edu.ph', '$2y$12$4kl8SYF/Ljahi3j7wmpH2uQT03Z9lvSoUl6uQO.iNE2JORXDIZeeO', '2026-07-01 07:49:54', '2026-07-01 07:52:28', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '95719392448'),
(42, 'student041', 'student041@student.gsys.edu.ph', '$2y$12$KY.0tVfNo8AUPK8ag9IRvu15PGsbyRK/htkFplEMU9IAYQvpsniQm', '2026-07-01 07:49:54', '2026-07-01 07:52:28', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24756108095'),
(43, 'student042', 'student042@student.gsys.edu.ph', '$2y$12$PJ2zRpwjoSbQHHu6dN1ipOx6JIYmAS2K1Tzcl76nS5C4/wHCjcpW2', '2026-07-01 07:49:54', '2026-07-01 07:52:29', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '90544494254'),
(44, 'student043', 'student043@student.gsys.edu.ph', '$2y$12$7k2OzkxRnrm0.cyzN1A3qu61Ew8.rGPV8g3AYGW1P1lJneLxdgspK', '2026-07-01 07:49:54', '2026-07-01 07:52:29', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '36445012891'),
(45, 'student044', 'student044@student.gsys.edu.ph', '$2y$12$7bQohOgMaP/PmlkJn93UNOIKlIcA5rafj6yXZWpfhw4dofaqHgUjm', '2026-07-01 07:49:55', '2026-07-01 07:52:29', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '88159167981'),
(46, 'student045', 'student045@student.gsys.edu.ph', '$2y$12$Iob4AF6EYJ0p1sEkDrXDMeIeXkoU345HR7PJahZLpOYYqktfj09OK', '2026-07-01 07:49:55', '2026-07-01 07:52:30', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16144921683'),
(47, 'student046', 'student046@student.gsys.edu.ph', '$2y$12$AXrIgkdMAKl8VnADVpIfHOvszZAicrYkbvNL6OtLwXCaY/R6J3afi', '2026-07-01 07:49:55', '2026-07-01 07:52:30', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '52093878221'),
(48, 'student047', 'student047@student.gsys.edu.ph', '$2y$12$Nkk8DUMUoRs05TRaVrN6k.bI/jbkWFm47eHgP7cWpMyY0/qI8rAdG', '2026-07-01 07:49:56', '2026-07-01 07:52:30', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '42519900378'),
(49, 'student048', 'student048@student.gsys.edu.ph', '$2y$12$gdf3lPwnVITRvlV.jYMSouHLAEDfpuuHbMQUviFTREPkQy3h4RHKO', '2026-07-01 07:49:56', '2026-07-01 07:52:31', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16202057734'),
(50, 'student049', 'student049@student.gsys.edu.ph', '$2y$12$/3FaZvZpGzt/M42kJynSSOMfNCuBAvRJYo2WX/7cugXYalGyGGrIS', '2026-07-01 07:49:56', '2026-07-01 07:52:31', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '83063225457'),
(51, 'student050', 'student050@student.gsys.edu.ph', '$2y$12$IMJALLbKbaqjc/nmYkApfeCwPx/GmTo0VpCm/w7wtWo/BJmg86cMu', '2026-07-01 07:49:56', '2026-07-01 07:52:31', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '50133219177'),
(52, 'student051', 'student051@student.gsys.edu.ph', '$2y$12$ePlHWP7xnYNzHDArWcuUz.xQI3aGPZKaDmIx4pre1L6KxCl4PCwFe', '2026-07-01 07:49:57', '2026-07-01 07:52:32', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '43869137051'),
(53, 'student052', 'student052@student.gsys.edu.ph', '$2y$12$hFpw6/cwcwEy.woRIsemDu5CWIYIMpVeHm6AQlXWuQwGSY2NHAWDG', '2026-07-01 07:49:57', '2026-07-01 07:52:32', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '95229394316'),
(54, 'student053', 'student053@student.gsys.edu.ph', '$2y$12$3alrwtdKejJiyWUOD7kjo.MkusVwwKCkJglzIpEsnWa/ZfJM/fhH6', '2026-07-01 07:49:57', '2026-07-01 07:52:33', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33767696996'),
(55, 'student054', 'student054@student.gsys.edu.ph', '$2y$12$Hfeg6L1FO8Y4EfkyKqvmjuLhKgcIzt2kCX1YXIjvlXtP2EvVgxU2G', '2026-07-01 07:49:57', '2026-07-01 07:52:33', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11543995522'),
(56, 'student055', 'student055@student.gsys.edu.ph', '$2y$12$34JXM.Xf5jy/RK.LW4R6eOGhKHG6KE1aq9GRGszCOnLSBsNARDGOm', '2026-07-01 07:49:58', '2026-07-01 07:52:33', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '81720566454'),
(57, 'student056', 'student056@student.gsys.edu.ph', '$2y$12$mitouYJI6SkV27hMcGiGP.2g.c/5wVS.5CkqUgfWYUUmhev8xFNRy', '2026-07-01 07:49:58', '2026-07-01 07:52:34', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '43068262669'),
(58, 'student057', 'student057@student.gsys.edu.ph', '$2y$12$PiyN2URpoGtD3UP8yRhBZe.UtsU9abosf2zVJje8i/HDYjA5DVn/2', '2026-07-01 07:49:58', '2026-07-01 07:52:34', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '19458177835'),
(59, 'student058', 'student058@student.gsys.edu.ph', '$2y$12$s1E5AUzezeJNOLhkZiay0u84H9Y/1wTfoCa5L85jysaggIWgAkwn6', '2026-07-01 07:49:58', '2026-07-01 07:52:34', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11079282269'),
(60, 'student059', 'student059@student.gsys.edu.ph', '$2y$12$cGwBcLe0tQ.l7N.3hXO7HOT7jeDtBZTLqHQJnB1puNi526TXactRq', '2026-07-01 07:49:59', '2026-07-01 07:52:35', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '49951095522'),
(61, 'student060', 'student060@student.gsys.edu.ph', '$2y$12$lFpgiKr98lfcIDXpb7C22uiPB1gj7bXTFdXGhZyVydNjUOfUys8im', '2026-07-01 07:49:59', '2026-07-01 07:52:35', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '47107217319');

-- --------------------------------------------------------

--
-- Table structure for table `subcat`
--

CREATE TABLE `subcat` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `subcat`
--

INSERT INTO `subcat` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'subcatsugad', '2026-06-01 22:37:16', '2026-06-01 22:37:16'),
(2, 'fdgdfgfg', '2026-06-01 22:37:21', '2026-06-01 22:37:21'),
(3, 'Core Subject', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(4, 'Applied Subject', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(5, 'Specialized Subject', '2026-07-01 07:48:17', '2026-07-01 07:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subcat_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subcat_id`, `teacher_id`, `name`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 1, 'asdsd', 'asd', '2026-06-01 22:28:56', '2026-06-02 07:39:46', NULL),
(2, NULL, NULL, 'fdgdfg', NULL, '2026-06-01 22:56:34', '2026-06-01 22:56:34', NULL),
(3, 1, 2, 'g11 math', 'Biochems', '2026-06-02 12:15:13', '2026-06-02 12:15:13', NULL),
(4, 3, 1, 'Oral Communication', 'OCOM', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(5, 3, 2, 'Reading and Writing', 'RW', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(6, 3, 3, 'General Mathematics', 'GMATH', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(7, 3, 4, 'Statistics and Probability', 'STAT', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(8, 3, 5, 'Earth and Life Science', 'ELS', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(9, 3, 6, 'Physical Science', 'PSCI', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(10, 4, 7, 'Practical Research 1', 'PR1', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(11, 4, 8, 'Practical Research 2', 'PR2', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(12, 4, 9, 'Empowerment Technologies', 'ETECH', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(13, 4, 10, 'Entrepreneurship', 'ENTREP', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(14, 4, 11, 'Work Immersion', 'WI', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(15, 5, 12, 'Pre-Calculus', 'PRECAL', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(16, 5, 1, 'Basic Calculus', 'BCAL', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(17, 5, 2, 'General Biology 1', 'BIO1', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL),
(18, 5, 3, 'General Biology 2', 'BIO2', '2026-07-01 07:48:17', '2026-07-01 07:48:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacherclass`
--

CREATE TABLE `teacherclass` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `teacherclass`
--

INSERT INTO `teacherclass` (`id`, `teacher_id`, `class_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(2, 2, 6, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(3, 3, 7, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(4, 4, 8, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(5, 5, 9, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(6, 6, 10, '2026-07-01 07:52:06', '2026-07-01 07:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  `activated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `deactivated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deactivated_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `username`, `email`, `password`, `created_at`, `updated_at`, `status`, `activated_by`, `activated_at`, `rejected_by`, `rejected_at`, `deactivated_by`, `deactivated_at`, `rejection_reason`) VALUES
(1, 'jaycee', 'teacher', 'jaycee@gmail.com', '$2y$12$Eu.rP4E0cSojOFAirPDU8e5povUeGY7ZnqIrOhPoKS2jovvlmGdnC', '2026-06-02 01:20:29', '2026-09-10 23:14:14', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'roever', 'asdsd', 'rov@gmail.com', '$2y$12$9Lojq549cyAbAlf5F89aSOky.sadMBekMJAOCW/1BTPNJxDYEIQJK', '2026-06-02 12:13:46', '2026-06-02 12:13:46', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Maria Santos', 'maria.santos', 'maria.santos@gsys.edu.ph', '$2y$12$yMCJtg2DGoUqxfsSV3fCl.PCZpI/7Q.Cgj9ldxkBmyUFi5hU7kOvm', '2026-07-01 07:48:14', '2026-07-01 07:52:03', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Jose Reyes', 'jose.reyes', 'jose.reyes@gsys.edu.ph', '$2y$12$izvqrYSNy.SKmh1/XyeWPO/NyEdt7AvCY/2YV7QICJ1d.2bXYbJdS', '2026-07-01 07:48:15', '2026-07-01 07:52:04', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Ana Cruz', 'ana.cruz', 'ana.cruz@gsys.edu.ph', '$2y$12$MFByA2ZYRIbX2n76oDd39Ojm2p/X3kBvTO5VmBxSfwdoBAi4/7iQi', '2026-07-01 07:48:15', '2026-07-01 07:52:04', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Mark Dela Cruz', 'mark.delacruz', 'mark.delacruz@gsys.edu.ph', '$2y$12$eFib2mE4fvRuhKvY5Fqc3eD1oO.Ij59UnO.sxogGjGc2uNLxsnIiS', '2026-07-01 07:48:15', '2026-07-01 07:52:04', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Liza Garcia', 'liza.garcia', 'liza.garcia@gsys.edu.ph', '$2y$12$lU7UZfh.VjuFxnlfecBBze/3NyzpOXzCn4M2hLfZNkIa.5Ku2t3BK', '2026-07-01 07:48:15', '2026-07-01 07:52:04', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Ramon Mendoza', 'ramon.mendoza', 'ramon.mendoza@gsys.edu.ph', '$2y$12$Wz33aoOxKmal2Kp3iAx4l.4o1USv5MchnwPJt4f8lzRBEdDU.1l6.', '2026-07-01 07:48:16', '2026-07-01 07:52:05', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Patricia Lopez', 'patricia.lopez', 'patricia.lopez@gsys.edu.ph', '$2y$12$HnudlyaeLw790BUJEASk7ej2tJeKTc/hSeaBjuOVKb8U5bIgi9KIm', '2026-07-01 07:48:16', '2026-07-01 07:52:05', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Carlo Aquino', 'carlo.aquino', 'carlo.aquino@gsys.edu.ph', '$2y$12$ewgK8YjqG3NE6EyEQwq9k.sHhtE5aKpjEMedfqETCJEi3rkWiz07G', '2026-07-01 07:48:16', '2026-07-01 07:52:05', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Jenny Flores', 'jenny.flores', 'jenny.flores@gsys.edu.ph', '$2y$12$Rn//MkJhaULzM.a5uBsQYe9gnm2na7.T1IGTLbzQabQOPtF4AMdjG', '2026-07-01 07:48:17', '2026-07-01 07:52:06', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Edwin Navarro', 'edwin.navarro', 'edwin.navarro@gsys.edu.ph', '$2y$12$MZnAwL2AUKgYPodAXoJuCO9uFO8Oa/1In3UCrgkuqy9WaHKe8lru6', '2026-07-01 07:48:17', '2026-07-01 07:52:06', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachersub`
--

CREATE TABLE `teachersub` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `teachersub`
--

INSERT INTO `teachersub` (`id`, `teacher_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(2, 2, 5, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(3, 3, 6, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(4, 4, 7, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(5, 5, 8, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(6, 6, 9, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(7, 7, 10, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(8, 8, 11, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(9, 9, 12, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(10, 10, 13, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(11, 11, 14, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(12, 12, 15, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(13, 1, 16, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(14, 2, 17, '2026-07-01 07:52:06', '2026-07-01 07:52:06'),
(15, 3, 18, '2026-07-01 07:52:06', '2026-07-01 07:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'stem', '2026-06-02 08:51:30', '2026-06-02 08:51:30'),
(2, 'abm', '2026-06-02 08:51:35', '2026-06-02 08:51:41'),
(3, 'HUMSS', '2026-06-02 08:51:55', '2026-06-02 08:51:55'),
(4, 'gas', '2026-06-02 08:52:00', '2026-06-02 08:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `tracksub`
--

CREATE TABLE `tracksub` (
  `id` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `grlvl_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tracksub`
--

INSERT INTO `tracksub` (`id`, `track_id`, `grlvl_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(4, 1, NULL, 2, '2026-06-02 10:25:53', '2026-06-02 10:25:53'),
(5, 1, NULL, 1, '2026-06-02 10:25:53', '2026-06-02 10:25:53'),
(6, 1, 18, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(7, 1, 18, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(8, 1, 18, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(9, 1, 18, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(10, 1, 18, 15, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(11, 1, 18, 16, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(12, 1, 18, 17, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(13, 1, 18, 18, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(14, 2, 18, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(15, 2, 18, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(16, 2, 18, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(17, 2, 18, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(18, 2, 18, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48'),
(19, 2, 18, 14, '2026-07-01 07:48:48', '2026-07-01 07:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  `activated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `deactivated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deactivated_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`, `activated_by`, `activated_at`, `rejected_by`, `rejected_at`, `deactivated_by`, `deactivated_at`, `rejection_reason`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$UKtdiY3gmFAC9iLiIzFHPOav7Sub7qwF0DWTGpjaT56It8Eu3JJgy', NULL, '2026-05-31 23:29:50', '2026-07-01 07:52:03', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acady`
--
ALTER TABLE `acady`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `agreement_records`
--
ALTER TABLE `agreement_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_events`
--
ALTER TABLE `audit_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_events_target_type_target_id_index` (`target_type`,`target_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`) USING BTREE;

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`) USING BTREE;

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD UNIQUE KEY `adviser_id` (`adviser_id`) USING BTREE;

--
-- Indexes for table `classsched`
--
ALTER TABLE `classsched`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `classsub`
--
ALTER TABLE `classsub`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `curriculum_subject_unique` (`curriculum_id`,`subject_id`,`grade_level`,`semester`) USING BTREE,
  ADD KEY `curriculum_subjects_subject_id_index` (`subject_id`) USING BTREE,
  ADD KEY `curriculum_subjects_year_level_semester_sort_order_index` (`year_level`,`semester`,`sort_order`) USING BTREE,
  ADD KEY `curriculum_subjects_curriculum_id_index` (`curriculum_id`) USING BTREE,
  ADD KEY `curriculum_subject_lookup_index` (`curriculum_id`,`grade_level`,`semester`,`sort_order`) USING BTREE;

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`) USING BTREE;

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `grades_student_subject_class_year_quarter_unique` (`student_id`,`subject_id`,`class_id`,`academic_year_id`,`quarter`),
  ADD KEY `grades_class_subject_year_index` (`class_id`,`subject_id`,`academic_year_id`),
  ADD KEY `grades_year_level_index` (`academic_year_id`,`grade_level_id`),
  ADD KEY `grades_teacher_id_index` (`teacher_id`),
  ADD KEY `grades_grade_sheet_id_foreign` (`grade_sheet_id`);

--
-- Indexes for table `grade_encoding_schedules`
--
ALTER TABLE `grade_encoding_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schedule_year_quarter_unique` (`academic_year_id`,`quarter`);

--
-- Indexes for table `grade_sheets`
--
ALTER TABLE `grade_sheets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sheet_identity_unique` (`teacher_id`,`class_id`,`subject_id`,`academic_year_id`,`quarter`),
  ADD KEY `grade_sheets_status_index` (`status`);

--
-- Indexes for table `grlvl`
--
ALTER TABLE `grlvl`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD UNIQUE KEY `name_2` (`name`) USING BTREE;

--
-- Indexes for table `guardianchilds`
--
ALTER TABLE `guardianchilds`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `guardian_student_unique` (`guardian_id`,`student_id`),
  ADD KEY `guardianchilds_status_index` (`status`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `guardians_username_unique` (`username`) USING BTREE,
  ADD UNIQUE KEY `guardians_email_unique` (`email`) USING BTREE,
  ADD KEY `guardians_status_index` (`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `jobs_queue_index` (`queue`) USING BTREE;

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE;

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`) USING BTREE;

--
-- Indexes for table `pending_grades`
--
ALTER TABLE `pending_grades`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `unique_pending_grade` (`class_list_id`,`subject_id`,`status`) USING BTREE;

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `permissions_codename_unique` (`codename`) USING BTREE,
  ADD KEY `permissions_parent_id_index` (`parent_id`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`) USING BTREE;

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`) USING BTREE,
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`) USING BTREE;

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `sessions_user_id_index` (`user_id`) USING BTREE,
  ADD KEY `sessions_last_activity_index` (`last_activity`) USING BTREE;

--
-- Indexes for table `stinfo`
--
ALTER TABLE `stinfo`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `students_username_unique` (`username`) USING BTREE,
  ADD UNIQUE KEY `students_student_number_unique` (`student_number`),
  ADD KEY `students_status_index` (`status`);

--
-- Indexes for table `subcat`
--
ALTER TABLE `subcat`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `subject_teacher_id_index` (`teacher_id`) USING BTREE;

--
-- Indexes for table `teacherclass`
--
ALTER TABLE `teacherclass`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `teachers_status_index` (`status`);

--
-- Indexes for table `teachersub`
--
ALTER TABLE `teachersub`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tracksub`
--
ALTER TABLE `tracksub`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_email_unique` (`email`) USING BTREE,
  ADD KEY `users_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acady`
--
ALTER TABLE `acady`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `agreement_records`
--
ALTER TABLE `agreement_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_events`
--
ALTER TABLE `audit_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `classsched`
--
ALTER TABLE `classsched`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `classsub`
--
ALTER TABLE `classsub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `grade_encoding_schedules`
--
ALTER TABLE `grade_encoding_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_sheets`
--
ALTER TABLE `grade_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grlvl`
--
ALTER TABLE `grlvl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `guardianchilds`
--
ALTER TABLE `guardianchilds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pending_grades`
--
ALTER TABLE `pending_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stinfo`
--
ALTER TABLE `stinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `subcat`
--
ALTER TABLE `subcat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `teacherclass`
--
ALTER TABLE `teacherclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachersub`
--
ALTER TABLE `teachersub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tracksub`
--
ALTER TABLE `tracksub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_grade_sheet_id_foreign` FOREIGN KEY (`grade_sheet_id`) REFERENCES `grade_sheets` (`id`);

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
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
