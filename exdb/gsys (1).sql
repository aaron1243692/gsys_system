-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2026 at 02:38 AM
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
(4, '2023-2024', '2023', '2024', '2026-06-01 12:36:24', '2026-09-21 18:07:56'),
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

--
-- Dumping data for table `agreement_records`
--

INSERT INTO `agreement_records` (`id`, `account_type`, `account_id`, `document_type`, `document_version`, `accepted_at`) VALUES
(1, 'student', 62, 'terms', '2026-09-15.1', '2026-09-19 23:16:09'),
(2, 'student', 62, 'privacy', '2026-09-15.1', '2026-09-19 23:16:09'),
(3, 'student', 63, 'terms', '2026-09-15.1', '2026-09-21 16:33:09'),
(4, 'student', 63, 'privacy', '2026-09-15.1', '2026-09-21 16:33:09');

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

--
-- Dumping data for table `audit_events`
--

INSERT INTO `audit_events` (`id`, `actor_type`, `actor_id`, `action`, `target_type`, `target_id`, `details`, `created_at`) VALUES
(1, 'web', 1, 'schedule.saved', 'grade_encoding_schedules', 1, '{\"academic_year_id\":\"7\",\"quarter\":\"1\",\"opens_at\":\"2026-09-17T21:34\",\"closes_at\":\"2026-09-24T21:34\"}', '2026-09-17 13:34:45'),
(2, 'web', 1, 'schedule.saved', 'grade_encoding_schedules', 1, '{\"academic_year_id\":\"7\",\"quarter\":\"1\",\"opens_at\":\"2026-09-16T21:38\",\"closes_at\":\"2026-09-24T21:38\"}', '2026-09-17 13:38:43'),
(3, 'web', 1, 'schedule.saved', 'grade_encoding_schedules', 2, '{\"academic_year_id\":\"7\",\"quarter\":\"2\",\"opens_at\":\"2026-09-18T21:42\",\"closes_at\":\"2026-09-19T21:42\"}', '2026-09-17 13:42:36'),
(4, 'web', 1, 'schedule.saved', 'grade_encoding_schedules', 3, '{\"academic_year_id\":\"7\",\"quarter\":\"3\",\"opens_at\":\"2026-09-03T21:42\",\"closes_at\":\"2026-10-07T21:42\"}', '2026-09-17 13:43:00'),
(5, 'web', 1, 'schedule.saved', 'grade_encoding_schedules', 2, '{\"academic_year_id\":\"7\",\"quarter\":\"2\",\"opens_at\":\"2026-09-03T21:43\",\"closes_at\":\"2026-09-30T21:43\"}', '2026-09-17 13:43:21'),
(6, 'web', 1, 'schedule.saved', 'grade_encoding_schedules', 4, '{\"academic_year_id\":\"6\",\"quarter\":\"1\",\"opens_at\":\"2026-09-11T13:13\",\"closes_at\":\"2026-09-25T13:13\"}', '2026-09-18 13:14:04'),
(7, 'teacher', 1, 'sheet.draft_saved', 'grade_sheets', 2, '[]', '2026-09-18 13:14:47'),
(9, 'teacher', 1, 'sheet.draft_saved', 'grade_sheets', 2, '[]', '2026-09-18 14:03:46'),
(10, 'teacher', 1, 'sheet.submitted', 'grade_sheets', 2, '[]', '2026-09-18 14:03:46'),
(11, 'web', 1, 'sheet.approved', 'grade_sheets', 2, '{\"action\":\"approve\"}', '2026-09-18 14:43:26'),
(12, 'web', 1, 'child.linked', 'guardianchilds', 1, '{\"reused_existing_link\":true}', '2026-09-19 00:27:08'),
(13, 'web', 1, 'child.linked', 'guardianchilds', 63, '{\"reused_existing_link\":false}', '2026-09-19 08:17:01'),
(14, 'web', 1, 'child.linked', 'guardianchilds', 2, '{\"reused_existing_link\":true}', '2026-09-19 22:36:19'),
(15, 'teacher', 1, 'sheet.draft_saved', 'grade_sheets', 3, '[]', '2026-09-19 22:39:42'),
(16, 'teacher', 1, 'sheet.draft_saved', 'grade_sheets', 3, '[]', '2026-09-19 22:39:49'),
(17, 'teacher', 1, 'sheet.submitted', 'grade_sheets', 3, '[]', '2026-09-19 22:39:49'),
(18, 'student', 62, 'registration.created', 'student_accounts', 62, '[]', '2026-09-19 23:16:09'),
(19, 'student', 63, 'registration.created', 'student_accounts', 63, '[]', '2026-09-21 16:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `curriculum_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `year`, `curriculum_id`, `created_at`, `updated_at`) VALUES
(1, '2027', NULL, '2026-06-02 09:01:14', '2026-06-02 09:08:44'),
(2, '2028', NULL, '2026-06-02 09:08:37', '2026-06-02 09:08:37'),
(3, '2024', 2, '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(4, '2025', 2, '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(5, '2026', 2, '2026-07-01 07:48:17', '2026-07-01 07:48:17');

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
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:8:\"codename\";s:1:\"d\";s:9:\"parent_id\";s:1:\"e\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:121:{i:0;a:5:{s:1:\"a\";i:164;s:1:\"b\";s:9:\"Dashboard\";s:1:\"c\";s:15:\"group.dashboard\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:1;a:6:{s:1:\"a\";i:165;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:14:\"dashboard.view\";s:1:\"d\";i:164;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:5:{s:1:\"a\";i:166;s:1:\"b\";s:12:\"Grade Levels\";s:1:\"c\";s:18:\"group.grade_levels\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:3;a:6:{s:1:\"a\";i:167;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:17:\"grade_levels.view\";s:1:\"d\";i:166;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:6:{s:1:\"a\";i:168;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:19:\"grade_levels.create\";s:1:\"d\";i:166;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:6:{s:1:\"a\";i:169;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:19:\"grade_levels.update\";s:1:\"d\";i:166;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:6:{s:1:\"a\";i:170;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:19:\"grade_levels.delete\";s:1:\"d\";i:166;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:171;s:1:\"b\";s:14:\"Academic Years\";s:1:\"c\";s:20:\"group.academic_years\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:8;a:6:{s:1:\"a\";i:172;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:19:\"academic_years.view\";s:1:\"d\";i:171;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:6:{s:1:\"a\";i:173;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:21:\"academic_years.create\";s:1:\"d\";i:171;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:6:{s:1:\"a\";i:174;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:21:\"academic_years.update\";s:1:\"d\";i:171;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:6:{s:1:\"a\";i:175;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:21:\"academic_years.delete\";s:1:\"d\";i:171;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:176;s:1:\"b\";s:18:\"Subject Categories\";s:1:\"c\";s:24:\"group.subject_categories\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:13;a:6:{s:1:\"a\";i:177;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:23:\"subject_categories.view\";s:1:\"d\";i:176;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:6:{s:1:\"a\";i:178;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:25:\"subject_categories.create\";s:1:\"d\";i:176;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:6:{s:1:\"a\";i:179;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:25:\"subject_categories.update\";s:1:\"d\";i:176;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:6:{s:1:\"a\";i:180;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:25:\"subject_categories.delete\";s:1:\"d\";i:176;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:5:{s:1:\"a\";i:181;s:1:\"b\";s:8:\"Subjects\";s:1:\"c\";s:14:\"group.subjects\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:18;a:6:{s:1:\"a\";i:182;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:13:\"subjects.view\";s:1:\"d\";i:181;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:6:{s:1:\"a\";i:183;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:15:\"subjects.create\";s:1:\"d\";i:181;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:6:{s:1:\"a\";i:184;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:15:\"subjects.update\";s:1:\"d\";i:181;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:6:{s:1:\"a\";i:185;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:15:\"subjects.delete\";s:1:\"d\";i:181;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:5:{s:1:\"a\";i:191;s:1:\"b\";s:7:\"Batches\";s:1:\"c\";s:13:\"group.batches\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:23;a:6:{s:1:\"a\";i:192;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:12:\"batches.view\";s:1:\"d\";i:191;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:6:{s:1:\"a\";i:193;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:14:\"batches.create\";s:1:\"d\";i:191;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:6:{s:1:\"a\";i:194;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:14:\"batches.update\";s:1:\"d\";i:191;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:6:{s:1:\"a\";i:195;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:14:\"batches.delete\";s:1:\"d\";i:191;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:5:{s:1:\"a\";i:196;s:1:\"b\";s:9:\"Curricula\";s:1:\"c\";s:15:\"group.curricula\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:28;a:6:{s:1:\"a\";i:197;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:14:\"curricula.view\";s:1:\"d\";i:196;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:6:{s:1:\"a\";i:198;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:16:\"curricula.create\";s:1:\"d\";i:196;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:6:{s:1:\"a\";i:199;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:16:\"curricula.update\";s:1:\"d\";i:196;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:6:{s:1:\"a\";i:200;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:16:\"curricula.delete\";s:1:\"d\";i:196;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:5:{s:1:\"a\";i:201;s:1:\"b\";s:19:\"Curriculum Subjects\";s:1:\"c\";s:25:\"group.curriculum_subjects\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:33;a:6:{s:1:\"a\";i:202;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:24:\"curriculum_subjects.view\";s:1:\"d\";i:201;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:6:{s:1:\"a\";i:203;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:26:\"curriculum_subjects.create\";s:1:\"d\";i:201;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:6:{s:1:\"a\";i:204;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:26:\"curriculum_subjects.update\";s:1:\"d\";i:201;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:6:{s:1:\"a\";i:205;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:26:\"curriculum_subjects.delete\";s:1:\"d\";i:201;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:5:{s:1:\"a\";i:206;s:1:\"b\";s:7:\"Classes\";s:1:\"c\";s:13:\"group.classes\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:38;a:6:{s:1:\"a\";i:207;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:12:\"classes.view\";s:1:\"d\";i:206;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:6:{s:1:\"a\";i:208;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:14:\"classes.create\";s:1:\"d\";i:206;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:6:{s:1:\"a\";i:209;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:14:\"classes.update\";s:1:\"d\";i:206;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:6:{s:1:\"a\";i:210;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:14:\"classes.delete\";s:1:\"d\";i:206;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:5:{s:1:\"a\";i:211;s:1:\"b\";s:5:\"Rooms\";s:1:\"c\";s:11:\"group.rooms\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:43;a:6:{s:1:\"a\";i:212;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:10:\"rooms.view\";s:1:\"d\";i:211;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:6:{s:1:\"a\";i:213;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:12:\"rooms.create\";s:1:\"d\";i:211;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:6:{s:1:\"a\";i:214;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:12:\"rooms.update\";s:1:\"d\";i:211;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:6:{s:1:\"a\";i:215;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:12:\"rooms.delete\";s:1:\"d\";i:211;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:5:{s:1:\"a\";i:216;s:1:\"b\";s:15:\"Class Schedules\";s:1:\"c\";s:21:\"group.class_schedules\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:48;a:6:{s:1:\"a\";i:217;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:20:\"class_schedules.view\";s:1:\"d\";i:216;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:6:{s:1:\"a\";i:218;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:22:\"class_schedules.create\";s:1:\"d\";i:216;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:6:{s:1:\"a\";i:219;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:22:\"class_schedules.update\";s:1:\"d\";i:216;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:6:{s:1:\"a\";i:220;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:22:\"class_schedules.delete\";s:1:\"d\";i:216;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:5:{s:1:\"a\";i:221;s:1:\"b\";s:13:\"Teacher Loads\";s:1:\"c\";s:19:\"group.teacher_loads\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:53;a:6:{s:1:\"a\";i:222;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:18:\"teacher_loads.view\";s:1:\"d\";i:221;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:6:{s:1:\"a\";i:223;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:20:\"teacher_loads.create\";s:1:\"d\";i:221;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:6:{s:1:\"a\";i:224;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:20:\"teacher_loads.update\";s:1:\"d\";i:221;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:6:{s:1:\"a\";i:225;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:20:\"teacher_loads.delete\";s:1:\"d\";i:221;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:5:{s:1:\"a\";i:226;s:1:\"b\";s:16:\"Student Accounts\";s:1:\"c\";s:22:\"group.student_accounts\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:58;a:6:{s:1:\"a\";i:227;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:21:\"student_accounts.view\";s:1:\"d\";i:226;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:6:{s:1:\"a\";i:228;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:23:\"student_accounts.create\";s:1:\"d\";i:226;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:6:{s:1:\"a\";i:229;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:23:\"student_accounts.update\";s:1:\"d\";i:226;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:6:{s:1:\"a\";i:230;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:23:\"student_accounts.delete\";s:1:\"d\";i:226;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:6:{s:1:\"a\";i:231;s:1:\"b\";s:14:\"Reset Password\";s:1:\"c\";s:31:\"student_accounts.reset_password\";s:1:\"d\";i:226;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:5:{s:1:\"a\";i:232;s:1:\"b\";s:9:\"Guardians\";s:1:\"c\";s:15:\"group.guardians\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:64;a:6:{s:1:\"a\";i:233;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:14:\"guardians.view\";s:1:\"d\";i:232;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:6:{s:1:\"a\";i:234;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:16:\"guardians.create\";s:1:\"d\";i:232;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:6:{s:1:\"a\";i:235;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:16:\"guardians.update\";s:1:\"d\";i:232;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:6:{s:1:\"a\";i:236;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:16:\"guardians.delete\";s:1:\"d\";i:232;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:6:{s:1:\"a\";i:237;s:1:\"b\";s:14:\"Reset Password\";s:1:\"c\";s:24:\"guardians.reset_password\";s:1:\"d\";i:232;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:5:{s:1:\"a\";i:238;s:1:\"b\";s:17:\"Guardian Children\";s:1:\"c\";s:23:\"group.guardian_children\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:70;a:6:{s:1:\"a\";i:239;s:1:\"b\";s:3:\"Add\";s:1:\"c\";s:21:\"guardian_children.add\";s:1:\"d\";i:238;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:6:{s:1:\"a\";i:240;s:1:\"b\";s:6:\"Remove\";s:1:\"c\";s:24:\"guardian_children.remove\";s:1:\"d\";i:238;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:5:{s:1:\"a\";i:241;s:1:\"b\";s:7:\"Faculty\";s:1:\"c\";s:13:\"group.faculty\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:73;a:6:{s:1:\"a\";i:242;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:12:\"faculty.view\";s:1:\"d\";i:241;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:6:{s:1:\"a\";i:243;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:14:\"faculty.create\";s:1:\"d\";i:241;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:6:{s:1:\"a\";i:244;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:14:\"faculty.update\";s:1:\"d\";i:241;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:6:{s:1:\"a\";i:245;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:14:\"faculty.delete\";s:1:\"d\";i:241;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:6:{s:1:\"a\";i:246;s:1:\"b\";s:14:\"Reset Password\";s:1:\"c\";s:22:\"faculty.reset_password\";s:1:\"d\";i:241;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:5:{s:1:\"a\";i:247;s:1:\"b\";s:13:\"Registrations\";s:1:\"c\";s:19:\"group.registrations\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:79;a:6:{s:1:\"a\";i:248;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:18:\"registrations.view\";s:1:\"d\";i:247;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:6:{s:1:\"a\";i:249;s:1:\"b\";s:6:\"Review\";s:1:\"c\";s:20:\"registrations.review\";s:1:\"d\";i:247;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:6:{s:1:\"a\";i:250;s:1:\"b\";s:8:\"Activate\";s:1:\"c\";s:22:\"registrations.activate\";s:1:\"d\";i:247;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:6:{s:1:\"a\";i:251;s:1:\"b\";s:6:\"Reject\";s:1:\"c\";s:20:\"registrations.reject\";s:1:\"d\";i:247;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:6:{s:1:\"a\";i:252;s:1:\"b\";s:10:\"Deactivate\";s:1:\"c\";s:24:\"registrations.deactivate\";s:1:\"d\";i:247;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:6:{s:1:\"a\";i:253;s:1:\"b\";s:12:\"Link Student\";s:1:\"c\";s:26:\"registrations.link_student\";s:1:\"d\";i:247;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:5:{s:1:\"a\";i:254;s:1:\"b\";s:11:\"Enrollments\";s:1:\"c\";s:17:\"group.enrollments\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:86;a:6:{s:1:\"a\";i:255;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:16:\"enrollments.view\";s:1:\"d\";i:254;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:6:{s:1:\"a\";i:256;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:18:\"enrollments.update\";s:1:\"d\";i:254;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:6:{s:1:\"a\";i:257;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:18:\"enrollments.delete\";s:1:\"d\";i:254;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:6:{s:1:\"a\";i:258;s:1:\"b\";s:5:\"Admit\";s:1:\"c\";s:17:\"enrollments.admit\";s:1:\"d\";i:254;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:5:{s:1:\"a\";i:259;s:1:\"b\";s:5:\"Users\";s:1:\"c\";s:11:\"group.users\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:91;a:6:{s:1:\"a\";i:260;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:10:\"users.view\";s:1:\"d\";i:259;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:6:{s:1:\"a\";i:261;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:12:\"users.create\";s:1:\"d\";i:259;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:6:{s:1:\"a\";i:262;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:12:\"users.update\";s:1:\"d\";i:259;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:6:{s:1:\"a\";i:263;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:12:\"users.delete\";s:1:\"d\";i:259;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:6:{s:1:\"a\";i:264;s:1:\"b\";s:11:\"Assign Role\";s:1:\"c\";s:17:\"users.assign_role\";s:1:\"d\";i:259;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:6:{s:1:\"a\";i:265;s:1:\"b\";s:14:\"Reset Password\";s:1:\"c\";s:20:\"users.reset_password\";s:1:\"d\";i:259;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:5:{s:1:\"a\";i:266;s:1:\"b\";s:14:\"Class Subjects\";s:1:\"c\";s:20:\"group.class_subjects\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:98;a:6:{s:1:\"a\";i:267;s:1:\"b\";s:6:\"Assign\";s:1:\"c\";s:21:\"class_subjects.assign\";s:1:\"d\";i:266;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:6:{s:1:\"a\";i:268;s:1:\"b\";s:6:\"Remove\";s:1:\"c\";s:21:\"class_subjects.remove\";s:1:\"d\";i:266;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:5:{s:1:\"a\";i:272;s:1:\"b\";s:14:\"Class Advisers\";s:1:\"c\";s:20:\"group.class_advisers\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:101;a:6:{s:1:\"a\";i:273;s:1:\"b\";s:15:\"Assign / Change\";s:1:\"c\";s:21:\"class_advisers.assign\";s:1:\"d\";i:272;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:6:{s:1:\"a\";i:274;s:1:\"b\";s:6:\"Remove\";s:1:\"c\";s:21:\"class_advisers.remove\";s:1:\"d\";i:272;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:5:{s:1:\"a\";i:275;s:1:\"b\";s:5:\"Roles\";s:1:\"c\";s:11:\"group.roles\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:104;a:6:{s:1:\"a\";i:276;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:10:\"roles.view\";s:1:\"d\";i:275;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:6:{s:1:\"a\";i:277;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:12:\"roles.create\";s:1:\"d\";i:275;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:6:{s:1:\"a\";i:278;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:12:\"roles.update\";s:1:\"d\";i:275;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:6:{s:1:\"a\";i:279;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:12:\"roles.delete\";s:1:\"d\";i:275;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:6:{s:1:\"a\";i:280;s:1:\"b\";s:18:\"Assign Permissions\";s:1:\"c\";s:18:\"permissions.assign\";s:1:\"d\";i:275;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:5:{s:1:\"a\";i:281;s:1:\"b\";s:15:\"Grade Schedules\";s:1:\"c\";s:21:\"group.grade_schedules\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:110;a:6:{s:1:\"a\";i:282;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:20:\"grades.schedule.view\";s:1:\"d\";i:281;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:6:{s:1:\"a\";i:283;s:1:\"b\";s:6:\"Create\";s:1:\"c\";s:22:\"grades.schedule.create\";s:1:\"d\";i:281;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:6:{s:1:\"a\";i:284;s:1:\"b\";s:6:\"Update\";s:1:\"c\";s:22:\"grades.schedule.update\";s:1:\"d\";i:281;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:6:{s:1:\"a\";i:285;s:1:\"b\";s:6:\"Delete\";s:1:\"c\";s:22:\"grades.schedule.delete\";s:1:\"d\";i:281;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:5:{s:1:\"a\";i:286;s:1:\"b\";s:6:\"Grades\";s:1:\"c\";s:12:\"group.grades\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:115;a:6:{s:1:\"a\";i:287;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:11:\"grades.view\";s:1:\"d\";i:286;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:116;a:6:{s:1:\"a\";i:288;s:1:\"b\";s:19:\"View Approval Queue\";s:1:\"c\";s:20:\"grades.approval.view\";s:1:\"d\";i:286;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:6:{s:1:\"a\";i:289;s:1:\"b\";s:7:\"Approve\";s:1:\"c\";s:14:\"grades.approve\";s:1:\"d\";i:286;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:6:{s:1:\"a\";i:290;s:1:\"b\";s:21:\"Return for Correction\";s:1:\"c\";s:13:\"grades.return\";s:1:\"d\";i:286;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:119;a:5:{s:1:\"a\";i:291;s:1:\"b\";s:7:\"Reports\";s:1:\"c\";s:13:\"group.reports\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:120;a:6:{s:1:\"a\";i:292;s:1:\"b\";s:4:\"View\";s:1:\"c\";s:12:\"reports.view\";s:1:\"d\";i:291;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"e\";s:3:\"web\";}}}', 1790101118);

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
  `acady_id` int(11) DEFAULT NULL,
  `adviser_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `grlvl_id`, `acady_id`, `adviser_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 34, 4, NULL, 'grade 7a', '2026-06-01 22:37:53', '2026-09-21 18:09:36'),
(3, 34, 4, NULL, 'grade 7b', '2026-06-02 12:23:57', '2026-09-21 18:09:36'),
(5, 18, 6, NULL, 'Grade 11 - Maharlika', '2026-07-01 07:48:48', '2026-09-21 18:09:36'),
(6, 18, 6, NULL, 'Grade 11 - Magiting', '2026-07-01 07:48:48', '2026-09-21 18:09:36'),
(7, 18, 6, NULL, 'Grade 11 - Marangal', '2026-07-01 07:48:48', '2026-09-21 18:09:36'),
(8, 19, 6, NULL, 'Grade 12 - Mapagkalinga', '2026-07-01 07:48:48', '2026-09-21 18:09:36'),
(9, 19, 6, NULL, 'Grade 12 - Mapagpasya', '2026-07-01 07:48:48', '2026-09-21 18:09:36'),
(10, 19, 6, NULL, 'Grade 12 - Mapamaraan', '2026-07-01 07:48:48', '2026-09-21 18:09:36'),
(23, 32, 7, 1, 'Grade 7 - Narra', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(24, 32, 7, 2, 'Grade 7 - Molave', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(25, 33, 7, 3, 'Grade 8 - Sampaguita', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(26, 33, 7, 4, 'Grade 8 - Ilang-Ilang', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(27, 34, 7, 5, 'Grade 9 - Mabini', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(28, 34, 7, 6, 'Grade 9 - Bonifacio', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(29, 35, 7, 7, 'Grade 10 - Rizal', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(30, 35, 7, 8, 'Grade 10 - Luna', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(31, 18, 7, 9, 'Grade 11 - Masikap', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(32, 18, 7, 10, 'Grade 11 - Matatag', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(33, 19, 7, 11, 'Grade 12 - Mapanuri', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(34, 19, 7, 12, 'Grade 12 - Malikhain', '2026-09-21 18:07:56', '2026-09-21 18:07:56');

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
(1, 2, 1, 'MTW', 1, '07:30:00', '08:30:00', '2026-07-01 07:49:59', '2026-09-17 15:19:09'),
(2, 2, 2, 'TTH', 2, '08:30:00', '09:30:00', '2026-07-01 07:49:59', '2026-09-17 15:19:21'),
(3, 2, 3, 'TF', 3, '10:00:00', '11:00:00', '2026-07-01 07:49:59', '2026-09-17 15:19:33'),
(4, 2, 4, 'MWF', 4, '11:00:00', '12:00:00', '2026-07-01 07:49:59', '2026-09-17 15:19:44'),
(5, 2, 5, 'TF', 5, '13:00:00', '14:00:00', '2026-07-01 07:49:59', '2026-09-17 15:19:55'),
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `classsub`
--

INSERT INTO `classsub` (`id`, `class_id`, `sub_id`, `created_at`, `updated_at`, `teacher_id`) VALUES
(2, 2, 1, '2026-06-01 23:33:31', '2026-09-19 14:32:24', 1),
(3, 5, 4, '2026-07-01 07:48:48', '2026-09-19 14:32:35', 7),
(4, 5, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(5, 5, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(6, 5, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(7, 5, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(8, 5, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(9, 5, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(10, 5, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(11, 5, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(12, 5, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(13, 6, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(14, 6, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(15, 6, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(16, 6, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(17, 6, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(18, 6, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(19, 6, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(20, 6, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(21, 6, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(22, 6, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(23, 7, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(24, 7, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(25, 7, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(26, 7, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(27, 7, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(28, 7, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(29, 7, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(30, 7, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(31, 7, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(32, 7, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(33, 8, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(34, 8, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(35, 8, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(36, 8, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(37, 8, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(38, 8, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(39, 8, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(40, 8, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(41, 8, 12, '2026-07-01 07:48:48', '2026-09-18 03:32:42', 1),
(42, 8, 13, '2026-07-01 07:48:48', '2026-09-18 03:32:50', 1),
(43, 9, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(44, 9, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(45, 9, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(46, 9, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(47, 9, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(48, 9, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(49, 9, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(50, 9, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(51, 9, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(52, 9, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(53, 10, 4, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(54, 10, 5, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(55, 10, 6, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(56, 10, 7, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(57, 10, 8, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(58, 10, 9, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(59, 10, 10, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(60, 10, 11, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(61, 10, 12, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(62, 10, 13, '2026-07-01 07:48:48', '2026-07-01 07:48:48', NULL),
(63, 8, 1, '2026-09-18 03:30:45', '2026-09-18 03:32:23', NULL),
(64, 8, 16, '2026-09-18 03:31:07', '2026-09-18 03:32:57', 1),
(77, 23, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(78, 23, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(79, 23, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(80, 23, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(81, 23, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(82, 23, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(83, 23, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(84, 23, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(85, 24, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(86, 24, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(87, 24, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(88, 24, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(89, 24, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(90, 24, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(91, 24, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(92, 24, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(93, 25, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(94, 25, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(95, 25, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(96, 25, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(97, 25, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(98, 25, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(99, 25, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(100, 25, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(101, 26, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(102, 26, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(103, 26, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(104, 26, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(105, 26, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(106, 26, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(107, 26, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(108, 26, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(109, 27, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(110, 27, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(111, 27, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(112, 27, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(113, 27, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(114, 27, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(115, 27, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(116, 27, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(117, 28, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(118, 28, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(119, 28, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(120, 28, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(121, 28, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(122, 28, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(123, 28, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(124, 28, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(125, 29, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7),
(126, 29, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(127, 29, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(128, 29, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(129, 29, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(130, 29, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(131, 29, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(132, 29, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(133, 30, 31, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 8),
(134, 30, 32, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(135, 30, 33, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(136, 30, 34, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(137, 30, 35, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(138, 30, 36, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(139, 30, 37, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(140, 30, 38, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(141, 31, 4, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 9),
(142, 31, 5, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(143, 31, 6, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(144, 31, 7, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(145, 31, 8, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(146, 31, 10, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(147, 31, 12, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(148, 31, 13, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(149, 32, 4, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 10),
(150, 32, 5, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(151, 32, 6, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(152, 32, 7, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(153, 32, 8, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(154, 32, 10, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(155, 32, 12, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(156, 32, 13, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(157, 33, 4, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 11),
(158, 33, 5, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(159, 33, 6, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(160, 33, 7, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(161, 33, 8, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(162, 33, 10, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(163, 33, 12, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(164, 33, 13, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(165, 34, 4, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 12),
(166, 34, 5, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 1),
(167, 34, 6, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 2),
(168, 34, 7, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 3),
(169, 34, 8, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 4),
(170, 34, 10, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 5),
(171, 34, 12, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 6),
(172, 34, 13, '2026-09-21 18:07:56', '2026-09-21 18:07:56', 7);

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
  `batch_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`id`, `name`, `batch_id`, `created_at`, `updated_at`) VALUES
(1, 'Secondary Education Curriculum', NULL, '2026-06-02 08:34:38', '2026-09-21 18:07:56'),
(2, 'Senior High STEM Curriculum', NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(3, 'Senior High ABM Curriculum', NULL, '2026-07-01 07:48:17', '2026-07-01 07:48:17');

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
(10, NULL, 4, NULL, NULL, NULL, NULL, NULL, '2026-09-10 23:13:27', '2026-09-15 05:26:33', 40, 9, 6, 19, 1, 1, 1, 1, 99.00, 'Rafael Navarro', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', 'jaycee', 1),
(11, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 05:14:47', '2026-09-18 05:14:47', 47, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Angelica Dela Cruz', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(17, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 06:03:46', '2026-09-18 06:03:46', 7, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Angelica Lopez', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(18, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 06:03:46', '2026-09-18 06:03:46', 39, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Jasmine Aquino', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(19, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 06:03:46', '2026-09-18 06:03:46', 15, 8, 6, 19, 1, 1, 1, 1, 98.78, 'Katrina Bautista', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(20, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 06:03:46', '2026-09-18 06:03:46', 55, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Katrina Navarro', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(21, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 06:03:46', '2026-09-18 06:03:46', 23, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Maria Flores', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(22, NULL, 12, NULL, NULL, NULL, NULL, NULL, '2026-09-18 06:03:46', '2026-09-18 06:03:46', 31, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Nicole Cruz', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', 'jaycee', 2),
(23, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:42', 47, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Angelica Dela Cruz', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(24, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:42', 7, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Angelica Lopez', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(25, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:42', 39, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Jasmine Aquino', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(26, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:42', 15, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Katrina Bautista', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(27, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:42', 55, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Katrina Navarro', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(28, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:42', 23, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Maria Flores', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(29, NULL, 13, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:49', '2026-09-19 14:39:49', 31, 8, 6, 19, 1, 1, 1, 1, 99.00, 'Nicole Cruz', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', 'dexter', 3),
(30, NULL, 31, NULL, NULL, NULL, NULL, NULL, '2026-09-21 18:09:35', '2026-09-21 18:09:35', 2, 23, 7, 32, 1, 1, 1, 1, 86.00, 'Juan Dela Cruz', 'Grade 7 - Narra', 'English', '2026-2027', 'Grade 7', 'Amihan Mercado', 4),
(31, NULL, 31, NULL, NULL, NULL, NULL, NULL, '2026-09-21 18:09:35', '2026-09-21 18:09:35', 4, 23, 7, 32, 1, 1, 1, 1, 87.00, 'Jose Reyes', 'Grade 7 - Narra', 'English', '2026-2027', 'Grade 7', 'Amihan Mercado', 4),
(32, NULL, 31, NULL, NULL, NULL, NULL, NULL, '2026-09-21 18:09:35', '2026-09-21 18:09:35', 6, 23, 7, 32, 1, 1, 1, 1, 88.00, 'Carlo Mendoza', 'Grade 7 - Narra', 'English', '2026-2027', 'Grade 7', 'Amihan Mercado', 4),
(33, NULL, 31, NULL, NULL, NULL, NULL, NULL, '2026-09-21 18:09:35', '2026-09-21 18:09:35', 8, 23, 7, 32, 1, 1, 1, 1, 89.00, 'Miguel Flores', 'Grade 7 - Narra', 'English', '2026-2027', 'Grade 7', 'Amihan Mercado', 4),
(34, NULL, 31, NULL, NULL, NULL, NULL, NULL, '2026-09-21 18:09:35', '2026-09-21 18:09:35', 10, 23, 7, 32, 1, 1, 1, 1, 90.00, 'Gabriel Navarro', 'Grade 7 - Narra', 'English', '2026-2027', 'Grade 7', 'Amihan Mercado', 4);

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

--
-- Dumping data for table `grade_encoding_schedules`
--

INSERT INTO `grade_encoding_schedules` (`id`, `academic_year_id`, `quarter`, `opens_at`, `closes_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 7, 1, '2026-06-22 02:09:36', '2026-07-22 02:09:36', 1, 1, '2026-09-17 05:34:45', '2026-09-21 18:09:36'),
(2, 7, 2, '2026-09-15 02:09:36', '2026-09-29 02:09:36', 1, 1, '2026-09-17 05:42:36', '2026-09-21 18:09:36'),
(3, 7, 3, '2026-11-22 02:09:36', '2026-12-22 02:09:36', 1, 1, '2026-09-17 05:43:00', '2026-09-21 18:09:36'),
(4, 6, 1, '2026-09-11 13:13:00', '2026-09-25 13:13:00', 1, 1, '2026-09-18 05:14:04', '2026-09-18 05:14:04');

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
(1, 1, 9, 4, 6, 19, 1, 'DRAFT', 'jaycee', 'Grade 12 STEM B', 'Oral Communication', '2025-2026', 'Grade 12', '[32,24,16,56,8,48,40]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-14 21:26:33', '2026-09-14 21:26:33'),
(2, 1, 8, 12, 6, 19, 1, 'APPROVED', 'jaycee', 'Grade 12 STEM A', 'Empowerment Technologies', '2025-2026', 'Grade 12', '[7,15,23,31,39,47,55]', 1, '2026-09-18 14:03:46', NULL, NULL, 1, '2026-09-18 14:43:26', NULL, NULL, '2026-09-18 05:14:47', '2026-09-18 06:43:26'),
(3, 1, 8, 13, 6, 19, 1, 'SUBMITTED', 'dexter', 'Grade 12 STEM A', 'Entrepreneurship', '2025-2026', 'Grade 12', '[7,15,23,31,39,47,55]', 1, '2026-09-19 22:39:49', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-19 14:39:42', '2026-09-19 14:39:49'),
(4, 1, 23, 31, 7, 32, 1, 'RETURNED', 'Amihan Mercado', 'Grade 7 - Narra', 'English', '2026-2027', 'Grade 7', '[2,4,6,8,10]', 1, '2026-09-20 02:09:36', 1, '2026-09-21 02:09:36', NULL, NULL, 'Demo record: verify one encoded grade before resubmission.', '2026-09-27 02:09:36', '2026-09-21 18:09:35', '2026-09-21 18:09:36');

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
(18, 'Grade 11', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(19, 'Grade 12', '2026-07-01 07:48:17', '2026-07-01 07:48:17'),
(32, 'Grade 7', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(33, 'Grade 8', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(34, 'Grade 9', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(35, 'Grade 10', '2026-09-21 18:07:56', '2026-09-21 18:07:56');

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
(1, 1, 1, '2026-06-01 23:36:36', '2026-09-18 16:27:08', 'VERIFIED', 'Legal Guardian', NULL, NULL, 1, '2026-09-19 00:27:08', NULL),
(304, 2, 2, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(305, 2, 3, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(306, 3, 4, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(307, 3, 5, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(308, 4, 6, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(309, 4, 7, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(310, 5, 8, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(311, 5, 9, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(312, 6, 10, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(313, 6, 11, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(314, 7, 12, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(315, 7, 13, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(316, 8, 14, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(317, 8, 15, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(318, 9, 16, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(319, 9, 17, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(320, 10, 18, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(321, 10, 19, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(322, 11, 20, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(323, 11, 21, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(324, 12, 22, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(325, 12, 23, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(326, 13, 24, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(327, 13, 25, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(328, 14, 26, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(329, 14, 27, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(330, 15, 28, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(331, 15, 29, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(332, 16, 30, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(333, 16, 31, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(334, 17, 32, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(335, 17, 33, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(336, 18, 34, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(337, 18, 35, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(338, 19, 36, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(339, 19, 37, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(340, 20, 38, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(341, 20, 39, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(342, 21, 40, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(343, 21, 41, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(344, 22, 42, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(345, 22, 43, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(346, 23, 44, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(347, 23, 45, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(348, 24, 46, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(349, 24, 47, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(350, 25, 48, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(351, 25, 49, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(352, 26, 50, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(353, 26, 51, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(354, 27, 52, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(355, 27, 53, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(356, 28, 54, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(357, 28, 55, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(358, 29, 56, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(359, 29, 57, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(360, 30, 58, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(361, 30, 59, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL),
(362, 31, 60, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Legal Guardian', NULL, NULL, NULL, NULL, NULL),
(363, 31, 61, '2026-09-21 18:09:36', '2026-09-21 18:09:36', 'VERIFIED', 'Parent', NULL, NULL, NULL, NULL, NULL);

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
(1, 'guardian', 'guardian@example.com', '$2y$12$HdWEb1mipwCP3wV7HFkiH.Mi48iHZqBdwYV02eseCggpz5kFyzC7S', NULL, NULL, NULL, '2026-05-31 23:29:51', '2026-09-18 06:58:32', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'parent01', 'guardian01@example.com', '$2y$12$NgpZyMmK7SCZGIN/stCoC.yOAxQZgfE/cKGErDVnEKqkPGowYTOW6', 'Alma Alma Alma Alma Alma Dela Cruz', '09991000001', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:36', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'parent02', 'guardian02@example.com', '$2y$12$W4EsYU6EDwIi9Cipw6UIaecQA1H69gA4obyI7w3chYtmDSC7umDbW', 'Benito Benito Benito Benito Benito Santos', '09991000002', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:36', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'parent03', 'guardian03@example.com', '$2y$12$p0h1aNkeGitonlt8di/g1umXNpd.ensX0Apw3eaCTUpRrr7BAs4lG', 'Corazon Corazon Corazon Corazon Corazon Reyes', '09991000003', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:36', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'parent04', 'guardian04@example.com', '$2y$12$kZFN3ZcBjeHk1gm5k2lUH.lMTEBKDExMbnUsrbUw2zy2BgvJwC7uC', 'Dante Dante Dante Dante Dante Garcia', '09991000004', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'parent05', 'guardian05@example.com', '$2y$12$dgMjkVXwTa7Cd0cSCNoNrO1DWoft3HRyasVKc3MIR6VGPgjBYnQ4m', 'Estrella Estrella Estrella Estrella Estrella Mendoza', '09991000005', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'parent06', 'guardian06@example.com', '$2y$12$2OBvLu1yTZPVdS40gkLPce./pCzhsvDMCs4Gzeg4ecE/LGOAM91Gu', 'Felipe Felipe Felipe Felipe Felipe Lopez', '09991000006', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'parent07', 'guardian07@example.com', '$2y$12$RH.tn7KDO.dFO5ai2WB28ujf5bojyo5nRxcWAx2rL3mML7vjbfWaW', 'Gloria Gloria Gloria Gloria Gloria Flores', '09991000007', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:37', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'parent08', 'guardian08@example.com', '$2y$12$ksPlPNMO4xQd28hHCuQJhOhEld/VhFpwv51FCIsMUSXxE/biDc8A6', 'Honesto Honesto Honesto Honesto Honesto Aquino', '09991000008', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'parent09', 'guardian09@example.com', '$2y$12$gqL4pslnbrCNQuJb4ax4aeEzO27JXhqPi8E1TUKdB/4cJMFlntj2m', 'Imelda Imelda Imelda Imelda Imelda Navarro', '09991000009', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'parent10', 'guardian10@example.com', '$2y$12$KBNps0cpLawWqizjUI6SEOFvHiuPb1iJZUDLIcWvJGfR/oSaVQAo.', 'Jaime Jaime Jaime Jaime Jaime Ramos', '09991000010', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'parent11', 'guardian11@example.com', '$2y$12$H91m2lRCfoqJTd3dLfxhGOIZ2BnCfu3RE.R6u8YSkNUcVec.YNXVi', 'Alma Alma Alma Alma Alma Torres', '09991000011', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:38', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'parent12', 'guardian12@example.com', '$2y$12$l9Emzal1VEhObzF4mvZbReX28psI1vTjrXvhIkA9P/yMWvc1IFTXq', 'Benito Benito Benito Benito Benito Castro', '09991000012', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'parent13', 'guardian13@example.com', '$2y$12$yaa.vv.4h9knGBuhi/jOhe0YSwQ0CN1UV2VXeJ8qqjg3HfF53a/g2', 'Corazon Corazon Corazon Corazon Corazon Villanueva', '09991000013', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'parent14', 'guardian14@example.com', '$2y$12$DMjPHE7G68Y89MLlPXTM0OGNwNeE/utE3ZKkdfhCMHvtHeCQOzyBG', 'Dante Dante Dante Dante Dante Bautista', '09991000014', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'parent15', 'guardian15@example.com', '$2y$12$xxMKRMuL8v/kWoQvPajw0ek4cp5i8TgOHd.fA5OCvySXv/aUbZ6nW', 'Estrella Estrella Estrella Estrella Estrella Cruz', '09991000015', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:39', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'parent16', 'guardian16@example.com', '$2y$12$hhC8gij31OU3EJQ1ARo67.69J8tJ3G0HI.S8DNmL4mUXVuqYh5wcm', 'Felipe Felipe Felipe Felipe Felipe Diaz', '09991000016', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'parent17', 'guardian17@example.com', '$2y$12$bYeDE3HS3ISI8.2Q00eawuRPHQV9/mjhxTMI37cxd4uTttkxQXD0y', 'Gloria Gloria Gloria Gloria Gloria Morales', '09991000017', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'parent18', 'guardian18@example.com', '$2y$12$EEzrm8RfJswLCsXnbYSOW.gS.9j7A/DAGzQlTa1R4H2WYndtMoYEW', 'Honesto Honesto Honesto Honesto Honesto Rivera', '09991000018', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'parent19', 'guardian19@example.com', '$2y$12$1HlRmp1tBD6g3cniauUAxe0idtZOJ4hIxu6Q37e/U2d.Cp3sTiT2u', 'Imelda Imelda Imelda Imelda Imelda Gonzales', '09991000019', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:40', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'parent20', 'guardian20@example.com', '$2y$12$rlv5fBBSXZlYT5OIitKubuvuh9NZB6TeLUkDosoRjRnQvln.GQBSy', 'Jaime Jaime Jaime Jaime Jaime Padilla', '09991000020', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'parent21', 'guardian21@example.com', '$2y$12$YpPy3HwDGaoe1vrPsIc8GOQOTX2PF2zr9wKZCYeONdx1x89ZyVEla', 'Alma Alma Alma Alma Alma Salazar', '09991000021', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'parent22', 'guardian22@example.com', '$2y$12$dJA8C89ZG.6jtwsM49QUZOECivERilpfzXBrM8I4n31AS788AElK.', 'Benito Benito Benito Benito Benito Domingo', '09991000022', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'parent23', 'guardian23@example.com', '$2y$12$SAoFjPTri8xyK0JWqm.rYeNeCzwBN7t0bDoKLybNO6Mta1vg8yUz6', 'Corazon Corazon Corazon Corazon Corazon Mercado', '09991000023', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:41', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'parent24', 'guardian24@example.com', '$2y$12$pp1KSGxzkzAiGBTY2K0FI.CI5evJ0s0LF7RVyKrQuZgY5jIp68DJ6', 'Dante Dante Dante Dante Dante Pascual', '09991000024', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'parent25', 'guardian25@example.com', '$2y$12$qzDO77pARY2tNdwUUVceSu0JgjW9xx2EL3b5ECwSz9WgQ7R7WJohK', 'Estrella Estrella Estrella Estrella Estrella Valdez', '09991000025', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'parent26', 'guardian26@example.com', '$2y$12$fI16OIi8GabV9KBZuY7xoup6qZJsW4.GLv2IZJMO1mn1y/m6oC66i', 'Felipe Felipe Felipe Felipe Felipe Aguilar', '09991000026', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'parent27', 'guardian27@example.com', '$2y$12$40b2JZWf/SlXu5VZQM2NRuSTPleWw9Btr.2g1PmsrbSvOoddYJiyW', 'Gloria Gloria Gloria Gloria Gloria Rosales', '09991000027', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:42', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'parent28', 'guardian28@example.com', '$2y$12$Xzg2rCsmRrgutmNf0DHP..8LlhycO6Nl7z8qYVmUdF3BB1sKG73Vi', 'Honesto Honesto Honesto Honesto Honesto Fernandez', '09991000028', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:43', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'parent29', 'guardian29@example.com', '$2y$12$kdaa/ONeaeYb3KoWVHTOp.mb/ohFlhHGMNn26MGmyL8nDIEDYZMFe', 'Imelda Imelda Imelda Imelda Imelda Alvarez', '09991000029', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:43', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'parent30', 'guardian30@example.com', '$2y$12$SMwO6i1lUbe0BbTPuEVuze3.BXOKgIDuRfvXl122oYQA4Xz4Qk3sC', 'Jaime Jaime Jaime Jaime Jaime Gutierrez', '09991000030', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:43', '2026-09-21 18:09:36', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(19, '2026_09_15_000001_add_web_workflow', 10),
(20, '2026_09_18_000001_assign_teacher_to_class_subject', 11),
(21, '2026_09_18_000002_create_student_accounts', 12),
(22, '2026_09_19_000001_create_mobile_api_tokens_table', 13),
(23, '2026_09_21_000001_add_web_authorization_permissions', 14),
(24, '2026_09_21_000003_remove_senior_high_school_tracks', 15);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_api_tokens`
--

CREATE TABLE `mobile_api_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_type` varchar(20) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `token_hash` char(64) NOT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(164, 'Dashboard', 'group.dashboard', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(165, 'View', 'dashboard.view', 164, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(166, 'Grade Levels', 'group.grade_levels', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(167, 'View', 'grade_levels.view', 166, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(168, 'Create', 'grade_levels.create', 166, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(169, 'Update', 'grade_levels.update', 166, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(170, 'Delete', 'grade_levels.delete', 166, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(171, 'Academic Years', 'group.academic_years', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(172, 'View', 'academic_years.view', 171, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(173, 'Create', 'academic_years.create', 171, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(174, 'Update', 'academic_years.update', 171, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(175, 'Delete', 'academic_years.delete', 171, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(176, 'Subject Categories', 'group.subject_categories', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(177, 'View', 'subject_categories.view', 176, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(178, 'Create', 'subject_categories.create', 176, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(179, 'Update', 'subject_categories.update', 176, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(180, 'Delete', 'subject_categories.delete', 176, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(181, 'Subjects', 'group.subjects', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(182, 'View', 'subjects.view', 181, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(183, 'Create', 'subjects.create', 181, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(184, 'Update', 'subjects.update', 181, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(185, 'Delete', 'subjects.delete', 181, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(191, 'Batches', 'group.batches', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(192, 'View', 'batches.view', 191, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(193, 'Create', 'batches.create', 191, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(194, 'Update', 'batches.update', 191, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(195, 'Delete', 'batches.delete', 191, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(196, 'Curricula', 'group.curricula', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(197, 'View', 'curricula.view', 196, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(198, 'Create', 'curricula.create', 196, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(199, 'Update', 'curricula.update', 196, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(200, 'Delete', 'curricula.delete', 196, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(201, 'Curriculum Subjects', 'group.curriculum_subjects', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(202, 'View', 'curriculum_subjects.view', 201, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(203, 'Create', 'curriculum_subjects.create', 201, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(204, 'Update', 'curriculum_subjects.update', 201, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(205, 'Delete', 'curriculum_subjects.delete', 201, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(206, 'Classes', 'group.classes', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(207, 'View', 'classes.view', 206, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(208, 'Create', 'classes.create', 206, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(209, 'Update', 'classes.update', 206, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(210, 'Delete', 'classes.delete', 206, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(211, 'Rooms', 'group.rooms', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(212, 'View', 'rooms.view', 211, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(213, 'Create', 'rooms.create', 211, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(214, 'Update', 'rooms.update', 211, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(215, 'Delete', 'rooms.delete', 211, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(216, 'Class Schedules', 'group.class_schedules', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(217, 'View', 'class_schedules.view', 216, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(218, 'Create', 'class_schedules.create', 216, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(219, 'Update', 'class_schedules.update', 216, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(220, 'Delete', 'class_schedules.delete', 216, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(221, 'Teacher Loads', 'group.teacher_loads', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(222, 'View', 'teacher_loads.view', 221, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(223, 'Create', 'teacher_loads.create', 221, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(224, 'Update', 'teacher_loads.update', 221, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(225, 'Delete', 'teacher_loads.delete', 221, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(226, 'Student Accounts', 'group.student_accounts', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(227, 'View', 'student_accounts.view', 226, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(228, 'Create', 'student_accounts.create', 226, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(229, 'Update', 'student_accounts.update', 226, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(230, 'Delete', 'student_accounts.delete', 226, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(231, 'Reset Password', 'student_accounts.reset_password', 226, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(232, 'Guardians', 'group.guardians', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(233, 'View', 'guardians.view', 232, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(234, 'Create', 'guardians.create', 232, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(235, 'Update', 'guardians.update', 232, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(236, 'Delete', 'guardians.delete', 232, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(237, 'Reset Password', 'guardians.reset_password', 232, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(238, 'Guardian Children', 'group.guardian_children', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(239, 'Add', 'guardian_children.add', 238, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(240, 'Remove', 'guardian_children.remove', 238, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(241, 'Faculty', 'group.faculty', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(242, 'View', 'faculty.view', 241, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(243, 'Create', 'faculty.create', 241, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(244, 'Update', 'faculty.update', 241, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(245, 'Delete', 'faculty.delete', 241, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(246, 'Reset Password', 'faculty.reset_password', 241, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(247, 'Registrations', 'group.registrations', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(248, 'View', 'registrations.view', 247, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(249, 'Review', 'registrations.review', 247, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(250, 'Activate', 'registrations.activate', 247, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(251, 'Reject', 'registrations.reject', 247, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(252, 'Deactivate', 'registrations.deactivate', 247, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(253, 'Link Student', 'registrations.link_student', 247, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(254, 'Enrollments', 'group.enrollments', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(255, 'View', 'enrollments.view', 254, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(256, 'Update', 'enrollments.update', 254, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(257, 'Delete', 'enrollments.delete', 254, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(258, 'Admit', 'enrollments.admit', 254, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(259, 'Users', 'group.users', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(260, 'View', 'users.view', 259, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(261, 'Create', 'users.create', 259, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(262, 'Update', 'users.update', 259, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(263, 'Delete', 'users.delete', 259, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(264, 'Assign Role', 'users.assign_role', 259, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(265, 'Reset Password', 'users.reset_password', 259, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(266, 'Class Subjects', 'group.class_subjects', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(267, 'Assign', 'class_subjects.assign', 266, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(268, 'Remove', 'class_subjects.remove', 266, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(272, 'Class Advisers', 'group.class_advisers', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(273, 'Assign / Change', 'class_advisers.assign', 272, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(274, 'Remove', 'class_advisers.remove', 272, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(275, 'Roles', 'group.roles', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(276, 'View', 'roles.view', 275, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(277, 'Create', 'roles.create', 275, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(278, 'Update', 'roles.update', 275, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(279, 'Delete', 'roles.delete', 275, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(280, 'Assign Permissions', 'permissions.assign', 275, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(281, 'Grade Schedules', 'group.grade_schedules', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(282, 'View', 'grades.schedule.view', 281, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(283, 'Create', 'grades.schedule.create', 281, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(284, 'Update', 'grades.schedule.update', 281, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(285, 'Delete', 'grades.schedule.delete', 281, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(286, 'Grades', 'group.grades', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(287, 'View', 'grades.view', 286, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(288, 'View Approval Queue', 'grades.approval.view', 286, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(289, 'Approve', 'grades.approve', 286, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(290, 'Return for Correction', 'grades.return', 286, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(291, 'Reports', 'group.reports', NULL, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37'),
(292, 'View', 'reports.view', 291, 'web', '2026-09-21 10:23:37', '2026-09-21 10:23:37');

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
(165, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(217, 1),
(218, 1),
(219, 1),
(220, 1),
(222, 1),
(223, 1),
(224, 1),
(225, 1),
(227, 1),
(228, 1),
(229, 1),
(230, 1),
(231, 1),
(233, 1),
(234, 1),
(235, 1),
(236, 1),
(237, 1),
(239, 1),
(240, 1),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(246, 1),
(248, 1),
(249, 1),
(250, 1),
(251, 1),
(252, 1),
(253, 1),
(255, 1),
(256, 1),
(257, 1),
(258, 1),
(260, 1),
(261, 1),
(262, 1),
(263, 1),
(264, 1),
(265, 1),
(267, 1),
(268, 1),
(273, 1),
(274, 1),
(276, 1),
(277, 1),
(278, 1),
(279, 1),
(280, 1),
(282, 1),
(283, 1),
(284, 1),
(285, 1),
(287, 1),
(288, 1),
(289, 1),
(290, 1),
(292, 1);

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
(1, 'Learning Resource Room', '2026-06-03 11:17:41', '2026-09-21 18:07:56'),
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
('OhUgmf7WNg1BQA9T4qS5ONuDFCoTljPJMx91o6Vl', 1, '172.20.10.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQlBlUHI3NWVQdTU0NXVjN1dCQ2FMTW1oZXVJVjM0eTk0Z21MVW5EVSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTcyLjIwLjEwLjI6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1790012124),
('tpqLv1R0CdBFc1Y0jrtZ7oxXtuS6CyLrVQExfKWL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY1c4SUJmR1VNalQ1RXdWMUN1OEdCYXJRREhuTFJzeTdxYWdhNFZGcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1790014719);

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
(1, 1, 2323, 1, 'dff', 'Male', NULL, 19, 8, 7, '09123456789', 'mnbb', '2026-06-03 19:46:01', '2026-09-17 05:47:04'),
(2, 2, 910000000001, 1, 'Juan Dela Cruz', 'Male', '2010-07-01', 32, 23, 7, '09990000001', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-09-21 18:07:56'),
(3, 3, 910000000002, 1, 'Maria Santos', 'Female', '2009-06-18', 32, 24, 7, '09990000002', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-09-21 18:07:56'),
(4, 4, 910000000003, 1, 'Jose Reyes', 'Male', '2008-06-05', 32, 23, 7, '09990000003', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-09-21 18:07:56'),
(5, 5, 910000000004, 1, 'Ana Garcia', 'Female', '2010-05-23', 32, 24, 7, '09990000004', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:44', '2026-09-21 18:07:56'),
(6, 6, 910000000005, 1, 'Carlo Mendoza', 'Male', '2009-05-10', 32, 23, 7, '09990000005', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-09-21 18:07:56'),
(7, 7, 910000000006, 1, 'Angelica Lopez', 'Female', '2008-04-27', 32, 24, 7, '09990000006', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-09-21 18:07:56'),
(8, 8, 910000000007, 1, 'Miguel Flores', 'Male', '2010-04-14', 32, 23, 7, '09990000007', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-09-21 18:07:56'),
(9, 9, 910000000008, 1, 'Sofia Aquino', 'Female', '2009-04-01', 32, 24, 7, '09990000008', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:45', '2026-09-21 18:07:56'),
(10, 10, 910000000009, 1, 'Gabriel Navarro', 'Male', '2008-03-19', 32, 23, 7, '09990000009', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-09-21 18:07:56'),
(11, 11, 910000000010, 1, 'Nicole Ramos', 'Female', '2010-03-06', 32, 24, 7, '09990000010', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-09-21 18:07:56'),
(12, 12, 910000000011, 1, 'Daniel Torres', 'Male', '2009-02-21', 33, 25, 7, '09990000011', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-09-21 18:07:56'),
(13, 13, 910000000012, 1, 'Andrea Castro', 'Female', '2008-02-09', 33, 26, 7, '09990000012', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:46', '2026-09-21 18:07:56'),
(14, 14, 910000000013, 1, 'Joshua Villanueva', 'Male', '2010-01-26', 33, 25, 7, '09990000013', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-09-21 18:07:56'),
(15, 15, 910000000014, 1, 'Katrina Bautista', 'Female', '2009-01-13', 33, 26, 7, '09990000014', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-09-21 18:07:56'),
(16, 16, 910000000015, 1, 'Marco Cruz', 'Male', '2008-01-01', 33, 25, 7, '09990000015', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-09-21 18:07:56'),
(17, 17, 910000000016, 1, 'Christine Dela Cruz', 'Female', '2009-12-18', 33, 26, 7, '09990000016', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:47', '2026-09-21 18:07:56'),
(18, 18, 910000000017, 1, 'Paolo Santos', 'Male', '2008-12-05', 33, 25, 7, '09990000017', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-09-21 18:07:56'),
(19, 19, 910000000018, 1, 'Jasmine Reyes', 'Female', '2007-11-23', 33, 26, 7, '09990000018', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-09-21 18:07:56'),
(20, 20, 910000000019, 1, 'Rafael Garcia', 'Male', '2009-11-09', 33, 25, 7, '09990000019', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-09-21 18:07:56'),
(21, 21, 910000000020, 1, 'Bianca Mendoza', 'Female', '2008-10-27', 33, 26, 7, '09990000020', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:48', '2026-09-21 18:07:56'),
(22, 22, 910000000021, 1, 'Juan Lopez', 'Male', '2007-10-15', 34, 27, 7, '09990000021', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:49', '2026-09-21 18:07:56'),
(23, 23, 910000000022, 1, 'Maria Flores', 'Female', '2009-10-01', 34, 28, 7, '09990000022', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:49', '2026-09-21 18:07:56'),
(24, 24, 910000000023, 1, 'Jose Aquino', 'Male', '2008-09-18', 34, 27, 7, '09990000023', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:49', '2026-09-21 18:07:56'),
(25, 25, 910000000024, 1, 'Ana Navarro', 'Female', '2007-09-06', 34, 28, 7, '09990000024', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-09-21 18:07:56'),
(26, 26, 910000000025, 1, 'Carlo Ramos', 'Male', '2009-08-23', 34, 27, 7, '09990000025', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-09-21 18:07:56'),
(27, 27, 910000000026, 1, 'Angelica Torres', 'Female', '2008-08-10', 34, 28, 7, '09990000026', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-09-21 18:07:56'),
(28, 28, 910000000027, 1, 'Miguel Castro', 'Male', '2007-07-29', 34, 27, 7, '09990000027', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:50', '2026-09-21 18:07:56'),
(29, 29, 910000000028, 1, 'Sofia Villanueva', 'Female', '2009-07-15', 34, 28, 7, '09990000028', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-09-21 18:07:56'),
(30, 30, 910000000029, 1, 'Gabriel Bautista', 'Male', '2008-07-02', 34, 27, 7, '09990000029', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-09-21 18:07:56'),
(31, 31, 910000000030, 1, 'Nicole Cruz', 'Female', '2007-06-20', 34, 28, 7, '09990000030', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-09-21 18:07:56'),
(32, 32, 910000000031, 1, 'Daniel Dela Cruz', 'Male', '2009-06-06', 35, 29, 7, '09990000031', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:51', '2026-09-21 18:07:56'),
(33, 33, 910000000032, 1, 'Andrea Santos', 'Female', '2008-05-24', 35, 30, 7, '09990000032', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-09-21 18:07:56'),
(34, 34, 910000000033, 1, 'Joshua Reyes', 'Male', '2007-05-12', 35, 29, 7, '09990000033', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-09-21 18:07:56'),
(35, 35, 910000000034, 1, 'Katrina Garcia', 'Female', '2009-04-28', 35, 30, 7, '09990000034', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-09-21 18:07:56'),
(36, 36, 910000000035, 1, 'Marco Mendoza', 'Male', '2008-04-15', 35, 29, 7, '09990000035', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:52', '2026-09-21 18:07:56'),
(37, 37, 910000000036, 1, 'Christine Lopez', 'Female', '2007-04-03', 35, 30, 7, '09990000036', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-09-21 18:07:56'),
(38, 38, 910000000037, 1, 'Paolo Flores', 'Male', '2009-03-20', 35, 29, 7, '09990000037', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-09-21 18:07:56'),
(39, 39, 910000000038, 1, 'Jasmine Aquino', 'Female', '2008-03-07', 35, 30, 7, '09990000038', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-09-21 18:07:56'),
(40, 40, 910000000039, 1, 'Rafael Navarro', 'Male', '2007-02-23', 35, 29, 7, '09990000039', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:53', '2026-09-21 18:07:56'),
(41, 41, 910000000040, 1, 'Bianca Ramos', 'Female', '2009-02-09', 35, 30, 7, '09990000040', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-09-21 18:07:56'),
(42, 42, 910000000041, 1, 'Juan Torres', 'Male', '2008-01-28', 18, 31, 7, '09990000041', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-09-21 18:07:56'),
(43, 43, 910000000042, 1, 'Maria Castro', 'Female', '2007-01-15', 18, 32, 7, '09990000042', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-09-21 18:07:56'),
(44, 44, 910000000043, 1, 'Jose Villanueva', 'Male', '2009-01-01', 18, 31, 7, '09990000043', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:54', '2026-09-21 18:07:56'),
(45, 45, 910000000044, 1, 'Ana Bautista', 'Female', '2007-12-20', 18, 32, 7, '09990000044', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:55', '2026-09-21 18:07:56'),
(46, 46, 910000000045, 1, 'Carlo Cruz', 'Male', '2006-12-07', 18, 31, 7, '09990000045', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:55', '2026-09-21 18:07:56'),
(47, 47, 910000000046, 1, 'Angelica Dela Cruz', 'Female', '2008-11-23', 18, 32, 7, '09990000046', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:55', '2026-09-21 18:07:56'),
(48, 48, 910000000047, 1, 'Miguel Santos', 'Male', '2007-11-11', 18, 31, 7, '09990000047', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-09-21 18:07:56'),
(49, 49, 910000000048, 1, 'Sofia Reyes', 'Female', '2006-10-29', 18, 32, 7, '09990000048', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-09-21 18:07:56'),
(50, 50, 910000000049, 1, 'Gabriel Garcia', 'Male', '2008-10-15', 18, 31, 7, '09990000049', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-09-21 18:07:56'),
(51, 51, 910000000050, 1, 'Nicole Mendoza', 'Female', '2007-10-03', 18, 32, 7, '09990000050', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:56', '2026-09-21 18:07:56'),
(52, 52, 910000000051, 1, 'Daniel Lopez', 'Male', '2006-09-20', 19, 33, 7, '09990000051', 'Barangay District I, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-09-21 18:07:56'),
(53, 53, 910000000052, 1, 'Andrea Flores', 'Female', '2008-09-06', 19, 34, 7, '09990000052', 'Barangay District II, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-09-21 18:07:56'),
(54, 54, 910000000053, 1, 'Joshua Aquino', 'Male', '2007-08-25', 19, 33, 7, '09990000053', 'Barangay District III, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-09-21 18:07:56'),
(55, 55, 910000000054, 1, 'Katrina Navarro', 'Female', '2006-08-12', 19, 34, 7, '09990000054', 'Barangay San Fermin, Cauayan City, Isabela', '2026-07-01 07:49:57', '2026-09-21 18:07:56'),
(56, 56, 910000000055, 1, 'Marco Ramos', 'Male', '2008-07-29', 19, 33, 7, '09990000055', 'Barangay Tagaran, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-21 18:07:56'),
(57, 57, 910000000056, 1, 'Christine Torres', 'Female', '2007-07-17', 19, 34, 7, '09990000056', 'Barangay Cabugao, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-21 18:07:56'),
(58, 58, 910000000057, 1, 'Paolo Castro', 'Male', '2006-07-04', 19, 33, 7, '09990000057', 'Barangay Alicaocao, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-21 18:07:56'),
(59, 59, 910000000058, 1, 'Jasmine Villanueva', 'Female', '2008-06-20', 19, 34, 7, '09990000058', 'Barangay Minante I, Cauayan City, Isabela', '2026-07-01 07:49:58', '2026-09-21 18:07:56'),
(60, 60, 910000000059, 1, 'Rafael Bautista', 'Male', '2007-06-08', 19, 33, 7, '09990000059', 'Barangay Minante II, Cauayan City, Isabela', '2026-07-01 07:49:59', '2026-09-21 18:07:56'),
(61, 61, 910000000060, 1, 'Bianca Cruz', 'Female', '2006-05-26', 19, 34, 7, '09990000060', 'Barangay Naganacan, Cauayan City, Isabela', '2026-07-01 07:49:59', '2026-09-21 18:07:56'),
(62, 62, 920000000001, 0, 'Althea Mae Domingo', 'Female', '2011-05-15', 32, NULL, 7, NULL, 'Barangay San Fermin, Cauayan City, Isabela', '2026-09-19 15:16:08', '2026-09-21 18:09:36'),
(63, 63, 920000000002, 0, 'Nathaniel Luis Pascual', 'Male', '2011-05-15', 32, NULL, 7, NULL, 'Barangay Tagaran, Cauayan City, Isabela', '2026-09-21 08:33:09', '2026-09-21 18:09:36');

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
(61, 'student060', 'student060@student.gsys.edu.ph', '$2y$12$lFpgiKr98lfcIDXpb7C22uiPB1gj7bXTFdXGhZyVydNjUOfUys8im', '2026-07-01 07:49:59', '2026-07-01 07:52:35', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '47107217319'),
(62, 'pending.althea', 'althea.domingo@example.com', '$2y$12$cHwo4Bc6LCy2IKtLNvLIJuCPjx1vh0Wk2Tw0Qi1ZCMpkykblGnmh6', '2026-09-19 15:16:08', '2026-09-21 18:09:36', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '36654510764'),
(63, 'pending.nathaniel', 'nathaniel.pascual@example.com', '$2y$12$vlHghbPHu3Pkns4lFh54pOmGxar38kX2zZqgTQwoEevWwteL1mTnO', '2026-09-21 08:33:09', '2026-09-21 18:09:36', 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '48414178662');

-- --------------------------------------------------------

--
-- Table structure for table `student_accounts`
--

CREATE TABLE `student_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `requested_grlvl_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_acady_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'PENDING',
  `activated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `deactivated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deactivated_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_accounts`
--

INSERT INTO `student_accounts` (`id`, `student_id`, `username`, `email`, `password`, `name`, `birthdate`, `gender`, `contact`, `address`, `requested_grlvl_id`, `requested_acady_id`, `status`, `activated_by`, `activated_at`, `rejected_by`, `rejected_at`, `deactivated_by`, `deactivated_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'student', NULL, '$2y$12$eboeark9HuxfOJ1dJasWmuQY6qdYtNlz3eGtLGU5HikHg9SQtYel2', 'dff', NULL, 'Male', '09123456789', 'mnbb', 19, 7, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-31 23:29:51', '2026-09-10 23:14:39'),
(2, 2, 'student001', 'student001@student.gsys.edu.ph', '$2y$12$WBvIzpQ58ot3M2HhBPbRvuxZpuMQTY37fRJhhOjVMFGkZ8xMXeRGa', 'Juan Dela Cruz', '2010-07-01', 'Male', '09990000001', 'Barangay District I, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:44', '2026-07-01 07:52:15'),
(3, 3, 'student002', 'student002@student.gsys.edu.ph', '$2y$12$SmWxdHIV59bGPOtoCDDg5.7R..wGvyzrnqLXuQbjevl.3nYrhlU5m', 'Maria Santos', '2009-06-18', 'Female', '09990000002', 'Barangay District II, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:44', '2026-07-01 07:52:15'),
(4, 4, 'student003', 'student003@student.gsys.edu.ph', '$2y$12$56GC.Q/v5N612AEnN5oCp.c40oVt0BbjE/y2jalc5KFsB5zc/8pSW', 'Jose Reyes', '2008-06-05', 'Male', '09990000003', 'Barangay District III, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:44', '2026-07-01 07:52:16'),
(5, 5, 'student004', 'student004@student.gsys.edu.ph', '$2y$12$ud7ycdTqgTlPFW87JZG/B.DbBMG.cSek4uG/fAoJkEjEwHiEfkYX.', 'Ana Garcia', '2010-05-23', 'Female', '09990000004', 'Barangay San Fermin, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:44', '2026-07-01 07:52:16'),
(6, 6, 'student005', 'student005@student.gsys.edu.ph', '$2y$12$uS0hGNXp5zXmPDcfkW1qB.6pcELEemvJHASgqcBke.1sFrv0AJkJi', 'Carlo Mendoza', '2009-05-10', 'Male', '09990000005', 'Barangay Tagaran, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:45', '2026-07-01 07:52:16'),
(7, 7, 'student006', 'student006@student.gsys.edu.ph', '$2y$12$IjEOwwy/xpQ.A8k5qEpomunsbLtHTGZsQMgfXfqAWZMWwRTaDzclW', 'Angelica Lopez', '2008-04-27', 'Female', '09990000006', 'Barangay Cabugao, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:45', '2026-09-19 00:16:29'),
(8, 8, 'student007', 'student007@student.gsys.edu.ph', '$2y$12$VohkWZb71U6/UN/cfynVMO4KpKeuS9aqiCQMd9s0qVP4aBTiw/DOi', 'Miguel Flores', '2010-04-14', 'Male', '09990000007', 'Barangay Alicaocao, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:45', '2026-07-01 07:52:17'),
(9, 9, 'student008', 'student008@student.gsys.edu.ph', '$2y$12$51LLmlgAuFAj.TGh.pFQOuv5ukuR5jr0BC.g73tgks4v67DOI2mDW', 'Sofia Aquino', '2009-04-01', 'Female', '09990000008', 'Barangay Minante I, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:45', '2026-07-01 07:52:17'),
(10, 10, 'student009', 'student009@student.gsys.edu.ph', '$2y$12$fXf25iWfX9M3a6B61GVlyOryLw8Ul9n5Km1fnYVzp8Zx9ckEJ8i.K', 'Gabriel Navarro', '2008-03-19', 'Male', '09990000009', 'Barangay Minante II, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:46', '2026-07-01 07:52:17'),
(11, 11, 'student010', 'student010@student.gsys.edu.ph', '$2y$12$fadEoCJeW7XWv4X6OTZQHu/ykt.k8luiv9wmLqySn3H3c08BCBNA.', 'Nicole Ramos', '2010-03-06', 'Female', '09990000010', 'Barangay Naganacan, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:46', '2026-07-01 07:52:18'),
(12, 12, 'student011', 'student011@student.gsys.edu.ph', '$2y$12$YoXvhmX9044uMAGgTTaVkOv7Z4hgx.Zanlz.Ok7Vs3PPrERO9Unda', 'Daniel Torres', '2009-02-21', 'Male', '09990000011', 'Barangay District I, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:46', '2026-07-01 07:52:18'),
(13, 13, 'student012', 'student012@student.gsys.edu.ph', '$2y$12$lL9xE0OhGQtj/jzI0o/1KOMP0cZiUID8vEDqwTDWkFTBHs2Iaav5.', 'Andrea Castro', '2008-02-09', 'Female', '09990000012', 'Barangay District II, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:46', '2026-07-01 07:52:18'),
(14, 14, 'student013', 'student013@student.gsys.edu.ph', '$2y$12$cjxapg4FDNj3xo0jWvYJO.otNb29NvZ.IMhZyHWH9rK.XvwTT/HEK', 'Joshua Villanueva', '2010-01-26', 'Male', '09990000013', 'Barangay District III, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:47', '2026-07-01 07:52:18'),
(15, 15, 'student014', 'student014@student.gsys.edu.ph', '$2y$12$YGlsk95OTWxmqA8HFiPIwuJZl9EpjALyOGzzrZEBofoSAVwEI.mSm', 'Katrina Bautista', '2009-01-13', 'Female', '09990000014', 'Barangay San Fermin, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:47', '2026-07-01 07:52:19'),
(16, 16, 'student015', 'student015@student.gsys.edu.ph', '$2y$12$pBLhPYP8HK7IslDQp2CNweHx7.kX1s7eeCETHfNyTco9AwtGwEdB2', 'Marco Cruz', '2008-01-01', 'Male', '09990000015', 'Barangay Tagaran, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:47', '2026-07-01 07:52:19'),
(17, 17, 'student016', 'student016@student.gsys.edu.ph', '$2y$12$vklZuXZr0uqAy6eIhJsW9O.U1GzGULLdARM947h0Kkd/n3BQqPAXq', 'Christine Dela Cruz', '2009-12-18', 'Female', '09990000016', 'Barangay Cabugao, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:47', '2026-07-01 07:52:19'),
(18, 18, 'student017', 'student017@student.gsys.edu.ph', '$2y$12$9cuNJJvW50lkl0EP7vG5fuwmBF2AzdnImSg9r8h17bb8fwdfcgLPa', 'Paolo Santos', '2008-12-05', 'Male', '09990000017', 'Barangay Alicaocao, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:48', '2026-07-01 07:52:20'),
(19, 19, 'student018', 'student018@student.gsys.edu.ph', '$2y$12$GWe0mH21x5Sk4yQdaWBEZOxxyckGLv10hIzPACGXoiQSqKI7D/EIO', 'Jasmine Reyes', '2007-11-23', 'Female', '09990000018', 'Barangay Minante I, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:48', '2026-07-01 07:52:20'),
(20, 20, 'student019', 'student019@student.gsys.edu.ph', '$2y$12$iquULDMSckkApn5doGOTPOo5Ra2rEVxrpkmjerro07LKbgObX.AUW', 'Rafael Garcia', '2009-11-09', 'Male', '09990000019', 'Barangay Minante II, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:48', '2026-07-01 07:52:20'),
(21, 21, 'student020', 'student020@student.gsys.edu.ph', '$2y$12$x.lEle7dgNKP8ZR3Kd34AuCoBvgX9Mcp84CqivkHMnxWNwrvI9cUS', 'Bianca Mendoza', '2008-10-27', 'Female', '09990000020', 'Barangay Naganacan, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:48', '2026-07-01 07:52:20'),
(22, 22, 'student021', 'student021@student.gsys.edu.ph', '$2y$12$QDn8jsE.MAaBwZPn1tzOZOyTFGZi6jbmqW.G/79eJvCUX18OSw0Oq', 'Juan Lopez', '2007-10-15', 'Male', '09990000021', 'Barangay District I, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:49', '2026-07-01 07:52:21'),
(23, 23, 'student022', 'student022@student.gsys.edu.ph', '$2y$12$.n.gFr/5WbAasTwO/HHbteefz3MlClMU3ge0CK3ELdR5MJtj5YA2O', 'Maria Flores', '2009-10-01', 'Female', '09990000022', 'Barangay District II, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:49', '2026-07-01 07:52:21'),
(24, 24, 'student023', 'student023@student.gsys.edu.ph', '$2y$12$KNvG/bmsDLg7jjmS.Z61/u98yUh7VP/96JtvJBJ1n1jwRWWlUWF6y', 'Jose Aquino', '2008-09-18', 'Male', '09990000023', 'Barangay District III, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:49', '2026-07-01 07:52:22'),
(25, 25, 'student024', 'student024@student.gsys.edu.ph', '$2y$12$il2B9juOus7jV6Fbqp9HgOI90LGN95Xu/JuuF/F5XukW1/3w/vJCm', 'Ana Navarro', '2007-09-06', 'Female', '09990000024', 'Barangay San Fermin, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:50', '2026-07-01 07:52:22'),
(26, 26, 'student025', 'student025@student.gsys.edu.ph', '$2y$12$VPiAL5W7tXc7aGZbJLnevu72mXJ7VIVR6giphapIpIf6HPl7wM4oe', 'Carlo Ramos', '2009-08-23', 'Male', '09990000025', 'Barangay Tagaran, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:50', '2026-07-01 07:52:22'),
(27, 27, 'student026', 'student026@student.gsys.edu.ph', '$2y$12$6UozcnsyrDA3Q5gTVIHak.yRboDc66SOsr2KkU7OUdFCXK9m8Q6.e', 'Angelica Torres', '2008-08-10', 'Female', '09990000026', 'Barangay Cabugao, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:50', '2026-07-01 07:52:23'),
(28, 28, 'student027', 'student027@student.gsys.edu.ph', '$2y$12$UJReKd93MM5pKGDZfJZ4eeA8iUjoIGJaXrNiQ.iU7Akl38qHS.xT.', 'Miguel Castro', '2007-07-29', 'Male', '09990000027', 'Barangay Alicaocao, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:50', '2026-07-01 07:52:23'),
(29, 29, 'student028', 'student028@student.gsys.edu.ph', '$2y$12$H0aHCTJFfo78Iys4aFR2e.KIL5xFQMZx25tLJ2jDDsWcU9YG2h6pa', 'Sofia Villanueva', '2009-07-15', 'Female', '09990000028', 'Barangay Minante I, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:51', '2026-07-01 07:52:24'),
(30, 30, 'student029', 'student029@student.gsys.edu.ph', '$2y$12$/HGBPOLaE51GMTTXcf06Z.SX3dIjh89gTEiZP/uDWn4Qh5LbSjU7C', 'Gabriel Bautista', '2008-07-02', 'Male', '09990000029', 'Barangay Minante II, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:51', '2026-07-01 07:52:24'),
(31, 31, 'student030', 'student030@student.gsys.edu.ph', '$2y$12$qC4CRIUZUKBXaoM.vbMTiuqV6m7vrsQODCrxefC5aL52If9wGqOky', 'Nicole Cruz', '2007-06-20', 'Female', '09990000030', 'Barangay Naganacan, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:51', '2026-07-01 07:52:24'),
(32, 32, 'student031', 'student031@student.gsys.edu.ph', '$2y$12$hyeClzgJhJnvTrR/t4rx9OQGWhYbEaCxKwS2WdpqWhhs4mL2ocic.', 'Daniel Dela Cruz', '2009-06-06', 'Male', '09990000031', 'Barangay District I, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:51', '2026-07-01 07:52:24'),
(33, 33, 'student032', 'student032@student.gsys.edu.ph', '$2y$12$8s4BfA392QHfmN94Tpqxqeq0LQdnOPCXDEEykiOLICFeDJa/VFhWO', 'Andrea Santos', '2008-05-24', 'Female', '09990000032', 'Barangay District II, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:52', '2026-07-01 07:52:25'),
(34, 34, 'student033', 'student033@student.gsys.edu.ph', '$2y$12$Ub8TwZSBA0yubggaQOZsbO/HldroEhvr63hbYOGlVp6PKtJriEyBm', 'Joshua Reyes', '2007-05-12', 'Male', '09990000033', 'Barangay District III, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:52', '2026-07-01 07:52:25'),
(35, 35, 'student034', 'student034@student.gsys.edu.ph', '$2y$12$suzJ1pkXdRZ.1vhMVBvt0eZ5Csn0t7ngXCMbfne0CWCCxV.BMAbie', 'Katrina Garcia', '2009-04-28', 'Female', '09990000034', 'Barangay San Fermin, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:52', '2026-07-01 07:52:26'),
(36, 36, 'student035', 'student035@student.gsys.edu.ph', '$2y$12$2Vm0padoxfqmBDesBTb.8etniyC07GGs8dstcEmTTQhH8gOl7Q6ra', 'Marco Mendoza', '2008-04-15', 'Male', '09990000035', 'Barangay Tagaran, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:52', '2026-07-01 07:52:26'),
(37, 37, 'student036', 'student036@student.gsys.edu.ph', '$2y$12$8/ifqgLK/0UVBly02r0SwuZTPU1em9250diZlu0YRq4/wRm9xiO.m', 'Christine Lopez', '2007-04-03', 'Female', '09990000036', 'Barangay Cabugao, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:53', '2026-07-01 07:52:26'),
(38, 38, 'student037', 'student037@student.gsys.edu.ph', '$2y$12$wgWol98YJamvtX6zSliZSOJ9P3M.TDQuo1tWggJBCkeSJxSmxF9JW', 'Paolo Flores', '2009-03-20', 'Male', '09990000037', 'Barangay Alicaocao, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:53', '2026-07-01 07:52:27'),
(39, 39, 'student038', 'student038@student.gsys.edu.ph', '$2y$12$10GKr.wzKGiIdMkaJZqjSu8kbcUzqS3WS8ZDzcH/gSg8uyqSDsAR2', 'Jasmine Aquino', '2008-03-07', 'Female', '09990000038', 'Barangay Minante I, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:53', '2026-07-01 07:52:27'),
(40, 40, 'student039', 'student039@student.gsys.edu.ph', '$2y$12$7sSZ8VXJW5pkgpeS8YCaFe9XEM2pYyYcW8eIhGYE0DWcA.Kt5naA2', 'Rafael Navarro', '2007-02-23', 'Male', '09990000039', 'Barangay Minante II, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:53', '2026-07-01 07:52:27'),
(41, 41, 'student040', 'student040@student.gsys.edu.ph', '$2y$12$4kl8SYF/Ljahi3j7wmpH2uQT03Z9lvSoUl6uQO.iNE2JORXDIZeeO', 'Bianca Ramos', '2009-02-09', 'Female', '09990000040', 'Barangay Naganacan, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:54', '2026-07-01 07:52:28'),
(42, 42, 'student041', 'student041@student.gsys.edu.ph', '$2y$12$KY.0tVfNo8AUPK8ag9IRvu15PGsbyRK/htkFplEMU9IAYQvpsniQm', 'Juan Torres', '2008-01-28', 'Male', '09990000041', 'Barangay District I, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:54', '2026-07-01 07:52:28'),
(43, 43, 'student042', 'student042@student.gsys.edu.ph', '$2y$12$PJ2zRpwjoSbQHHu6dN1ipOx6JIYmAS2K1Tzcl76nS5C4/wHCjcpW2', 'Maria Castro', '2007-01-15', 'Female', '09990000042', 'Barangay District II, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:54', '2026-07-01 07:52:29'),
(44, 44, 'student043', 'student043@student.gsys.edu.ph', '$2y$12$7k2OzkxRnrm0.cyzN1A3qu61Ew8.rGPV8g3AYGW1P1lJneLxdgspK', 'Jose Villanueva', '2009-01-01', 'Male', '09990000043', 'Barangay District III, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:54', '2026-07-01 07:52:29'),
(45, 45, 'student044', 'student044@student.gsys.edu.ph', '$2y$12$7bQohOgMaP/PmlkJn93UNOIKlIcA5rafj6yXZWpfhw4dofaqHgUjm', 'Ana Bautista', '2007-12-20', 'Female', '09990000044', 'Barangay San Fermin, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:55', '2026-07-01 07:52:29'),
(46, 46, 'student045', 'student045@student.gsys.edu.ph', '$2y$12$Iob4AF6EYJ0p1sEkDrXDMeIeXkoU345HR7PJahZLpOYYqktfj09OK', 'Carlo Cruz', '2006-12-07', 'Male', '09990000045', 'Barangay Tagaran, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:55', '2026-07-01 07:52:30'),
(47, 47, 'student046', 'student046@student.gsys.edu.ph', '$2y$12$cTn8oF83ym1lzNfxygYQaegtY.VY1jjIVZXsTOGsYPqtLRsjmeEEm', 'Angelica Dela Cruz', '2008-11-23', 'Female', '09990000046', 'Barangay Cabugao, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:55', '2026-09-18 06:06:02'),
(48, 48, 'student047', 'student047@student.gsys.edu.ph', '$2y$12$Nkk8DUMUoRs05TRaVrN6k.bI/jbkWFm47eHgP7cWpMyY0/qI8rAdG', 'Miguel Santos', '2007-11-11', 'Male', '09990000047', 'Barangay Alicaocao, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:56', '2026-07-01 07:52:30'),
(49, 49, 'student048', 'student048@student.gsys.edu.ph', '$2y$12$gdf3lPwnVITRvlV.jYMSouHLAEDfpuuHbMQUviFTREPkQy3h4RHKO', 'Sofia Reyes', '2006-10-29', 'Female', '09990000048', 'Barangay Minante I, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:56', '2026-07-01 07:52:31'),
(50, 50, 'student049', 'student049@student.gsys.edu.ph', '$2y$12$/3FaZvZpGzt/M42kJynSSOMfNCuBAvRJYo2WX/7cugXYalGyGGrIS', 'Gabriel Garcia', '2008-10-15', 'Male', '09990000049', 'Barangay Minante II, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:56', '2026-07-01 07:52:31'),
(51, 51, 'student050', 'student050@student.gsys.edu.ph', '$2y$12$IMJALLbKbaqjc/nmYkApfeCwPx/GmTo0VpCm/w7wtWo/BJmg86cMu', 'Nicole Mendoza', '2007-10-03', 'Female', '09990000050', 'Barangay Naganacan, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:56', '2026-07-01 07:52:31'),
(52, 52, 'student051', 'student051@student.gsys.edu.ph', '$2y$12$ePlHWP7xnYNzHDArWcuUz.xQI3aGPZKaDmIx4pre1L6KxCl4PCwFe', 'Daniel Lopez', '2006-09-20', 'Male', '09990000051', 'Barangay District I, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:57', '2026-07-01 07:52:32'),
(53, 53, 'student052', 'student052@student.gsys.edu.ph', '$2y$12$hFpw6/cwcwEy.woRIsemDu5CWIYIMpVeHm6AQlXWuQwGSY2NHAWDG', 'Andrea Flores', '2008-09-06', 'Female', '09990000052', 'Barangay District II, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:57', '2026-07-01 07:52:32'),
(54, 54, 'student053', 'student053@student.gsys.edu.ph', '$2y$12$3alrwtdKejJiyWUOD7kjo.MkusVwwKCkJglzIpEsnWa/ZfJM/fhH6', 'Joshua Aquino', '2007-08-25', 'Male', '09990000053', 'Barangay District III, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:57', '2026-07-01 07:52:33'),
(55, 55, 'student054', 'student054@student.gsys.edu.ph', '$2y$12$Hfeg6L1FO8Y4EfkyKqvmjuLhKgcIzt2kCX1YXIjvlXtP2EvVgxU2G', 'Katrina Navarro', '2006-08-12', 'Female', '09990000054', 'Barangay San Fermin, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:57', '2026-07-01 07:52:33'),
(56, 56, 'student055', 'student055@student.gsys.edu.ph', '$2y$12$34JXM.Xf5jy/RK.LW4R6eOGhKHG6KE1aq9GRGszCOnLSBsNARDGOm', 'Marco Ramos', '2008-07-29', 'Male', '09990000055', 'Barangay Tagaran, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:58', '2026-07-01 07:52:33'),
(57, 57, 'student056', 'student056@student.gsys.edu.ph', '$2y$12$mitouYJI6SkV27hMcGiGP.2g.c/5wVS.5CkqUgfWYUUmhev8xFNRy', 'Christine Torres', '2007-07-17', 'Female', '09990000056', 'Barangay Cabugao, Cauayan City, Isabela', 19, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:58', '2026-07-01 07:52:34'),
(58, 58, 'student057', 'student057@student.gsys.edu.ph', '$2y$12$PiyN2URpoGtD3UP8yRhBZe.UtsU9abosf2zVJje8i/HDYjA5DVn/2', 'Paolo Castro', '2006-07-04', 'Male', '09990000057', 'Barangay Alicaocao, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:58', '2026-07-01 07:52:34'),
(59, 59, 'student058', 'student058@student.gsys.edu.ph', '$2y$12$s1E5AUzezeJNOLhkZiay0u84H9Y/1wTfoCa5L85jysaggIWgAkwn6', 'Jasmine Villanueva', '2008-06-20', 'Female', '09990000058', 'Barangay Minante I, Cauayan City, Isabela', 5, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:58', '2026-07-01 07:52:34'),
(60, 60, 'student059', 'student059@student.gsys.edu.ph', '$2y$12$cGwBcLe0tQ.l7N.3hXO7HOT7jeDtBZTLqHQJnB1puNi526TXactRq', 'Rafael Bautista', '2007-06-08', 'Male', '09990000059', 'Barangay Minante II, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(61, 61, 'student060', 'student060@student.gsys.edu.ph', '$2y$12$lFpgiKr98lfcIDXpb7C22uiPB1gj7bXTFdXGhZyVydNjUOfUys8im', 'Bianca Cruz', '2006-05-26', 'Female', '09990000060', 'Barangay Naganacan, Cauayan City, Isabela', 18, 6, 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 07:49:59', '2026-07-01 07:52:35'),
(62, 62, 'pending.althea', 'althea.domingo@example.com', '$2y$12$3I9f3LWiVPighrZAbutou.IaqVo0.WXlSK5dTVy75e05cHbXTdUEW', 'Althea Mae Domingo', '2010-01-02', 'Female', NULL, 'Barangay San Fermin, Cauayan City, Isabela', 18, 7, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-19 15:16:09', '2026-09-21 18:09:36'),
(63, 63, 'pending.nathaniel', 'nathaniel.pascual@example.com', '$2y$12$zWMkZ4rdJNk0q4.0WvrZZ.8ELWScrw3a7df.bvA408rv6YcjOjcuu', 'Nathaniel Luis Pascual', '2012-12-12', 'Female', NULL, 'Barangay Tagaran, Cauayan City, Isabela', 8, 5, 'PENDING', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-21 08:33:09', '2026-09-21 18:09:36');

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
(1, 'Laboratory', '2026-06-01 22:37:16', '2026-09-21 18:07:56'),
(2, 'Lecture', '2026-06-01 22:37:21', '2026-09-21 18:07:56'),
(6, 'Core Learning Area', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(7, 'Applied Learning Area', '2026-09-21 18:07:56', '2026-09-21 18:07:56'),
(8, 'Specialized Learning Area', '2026-09-21 18:07:56', '2026-09-21 18:07:56');

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
(1, NULL, 1, 'Contemporary Philippine Arts', 'CPAR', '2026-06-01 22:28:56', '2026-09-21 18:09:09', NULL),
(2, NULL, 1, 'Media and Information Literacy', 'MIL', '2026-06-01 22:56:34', '2026-09-21 18:09:09', NULL),
(3, 1, 2, 'Chemistry 1', 'CHEM1', '2026-06-02 12:15:13', '2026-09-21 18:09:09', NULL),
(4, 6, 9, 'Oral Communication', 'OCOM', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(5, 6, 10, 'Reading and Writing', 'RW', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(6, 6, 11, 'General Mathematics', 'GMATH', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(7, 6, 12, 'Statistics and Probability', 'STAT', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(8, 6, 1, 'Earth and Life Science', 'ELS', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(9, 6, 2, 'Physical Science', 'PSCI', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(10, 7, 3, 'Practical Research 1', 'PR1', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(11, 7, 4, 'Practical Research 2', 'PR2', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(12, 7, 5, 'Empowerment Technologies', 'ETECH', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(13, 7, 6, 'Entrepreneurship', 'ENTREP', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(14, 7, 7, 'Work Immersion', 'WI', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(15, 8, 8, 'Pre-Calculus', 'PRECAL', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(16, 8, 9, 'Basic Calculus', 'BCAL', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(17, 8, 10, 'General Biology 1', 'BIO1', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(18, 8, 11, 'General Biology 2', 'BIO2', '2026-07-01 07:48:17', '2026-09-21 18:07:56', NULL),
(31, 6, 1, 'English', 'ENG', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(32, 6, 2, 'Filipino', 'FIL', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(33, 6, 3, 'Mathematics', 'MATH', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(34, 6, 4, 'Science', 'SCI', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(35, 6, 5, 'Araling Panlipunan', 'AP', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(36, 6, 6, 'MAPEH', 'MAPEH', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(37, 7, 7, 'Technology and Livelihood Education', 'TLE', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL),
(38, 6, 8, 'Edukasyon sa Pagpapakatao', 'ESP', '2026-09-21 18:07:56', '2026-09-21 18:07:56', NULL);

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
(1, 'Amihan Mercado', 'teacher', 'amihan.mercado@example.com', '$2y$12$Eu.rP4E0cSojOFAirPDU8e5povUeGY7ZnqIrOhPoKS2jovvlmGdnC', '2026-06-02 01:20:29', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Benedicto Ramos', 'asdsd', 'benedicto.ramos@example.com', '$2y$12$9Lojq549cyAbAlf5F89aSOky.sadMBekMJAOCW/1BTPNJxDYEIQJK', '2026-06-02 12:13:46', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Clarissa Santos', 'maria.santos', 'clarissa.santos@example.com', '$2y$12$yMCJtg2DGoUqxfsSV3fCl.PCZpI/7Q.Cgj9ldxkBmyUFi5hU7kOvm', '2026-07-01 07:48:14', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Danilo Reyes', 'jose.reyes', 'danilo.reyes@example.com', '$2y$12$izvqrYSNy.SKmh1/XyeWPO/NyEdt7AvCY/2YV7QICJ1d.2bXYbJdS', '2026-07-01 07:48:15', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Elena Cruz', 'ana.cruz', 'elena.cruz@example.com', '$2y$12$MFByA2ZYRIbX2n76oDd39Ojm2p/X3kBvTO5VmBxSfwdoBAi4/7iQi', '2026-07-01 07:48:15', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Francisco Dela Cruz', 'mark.delacruz', 'francisco.delacruz@example.com', '$2y$12$eFib2mE4fvRuhKvY5Fqc3eD1oO.Ij59UnO.sxogGjGc2uNLxsnIiS', '2026-07-01 07:48:15', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Gemma Garcia', 'liza.garcia', 'gemma.garcia@example.com', '$2y$12$lU7UZfh.VjuFxnlfecBBze/3NyzpOXzCn4M2hLfZNkIa.5Ku2t3BK', '2026-07-01 07:48:15', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Hector Mendoza', 'ramon.mendoza', 'hector.mendoza@example.com', '$2y$12$Wz33aoOxKmal2Kp3iAx4l.4o1USv5MchnwPJt4f8lzRBEdDU.1l6.', '2026-07-01 07:48:16', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Isabel Lopez', 'patricia.lopez', 'isabel.lopez@example.com', '$2y$12$HnudlyaeLw790BUJEASk7ej2tJeKTc/hSeaBjuOVKb8U5bIgi9KIm', '2026-07-01 07:48:16', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Jericho Aquino', 'carlo.aquino', 'jericho.aquino@example.com', '$2y$12$ewgK8YjqG3NE6EyEQwq9k.sHhtE5aKpjEMedfqETCJEi3rkWiz07G', '2026-07-01 07:48:16', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Katrina Flores', 'jenny.flores', 'katrina.flores@example.com', '$2y$12$Rn//MkJhaULzM.a5uBsQYe9gnm2na7.T1IGTLbzQabQOPtF4AMdjG', '2026-07-01 07:48:17', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Leandro Navarro', 'edwin.navarro', 'leandro.navarro@example.com', '$2y$12$MZnAwL2AUKgYPodAXoJuCO9uFO8Oa/1In3UCrgkuqy9WaHKe8lru6', '2026-07-01 07:48:17', '2026-09-21 18:07:56', 'ACTIVE', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `classsub_teacher_id_index` (`teacher_id`);

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
-- Indexes for table `mobile_api_tokens`
--
ALTER TABLE `mobile_api_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile_api_tokens_token_hash_unique` (`token_hash`),
  ADD KEY `mobile_api_tokens_account_type_account_id_index` (`account_type`,`account_id`),
  ADD KEY `mobile_api_tokens_expires_at_index` (`expires_at`);

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
-- Indexes for table `student_accounts`
--
ALTER TABLE `student_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `student_accounts_student_id_unique` (`student_id`),
  ADD UNIQUE KEY `student_accounts_email_unique` (`email`),
  ADD KEY `student_accounts_status_index` (`status`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `agreement_records`
--
ALTER TABLE `agreement_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_events`
--
ALTER TABLE `audit_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `classsched`
--
ALTER TABLE `classsched`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `classsub`
--
ALTER TABLE `classsub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `grade_encoding_schedules`
--
ALTER TABLE `grade_encoding_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grade_sheets`
--
ALTER TABLE `grade_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grlvl`
--
ALTER TABLE `grlvl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `guardianchilds`
--
ALTER TABLE `guardianchilds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `mobile_api_tokens`
--
ALTER TABLE `mobile_api_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pending_grades`
--
ALTER TABLE `pending_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stinfo`
--
ALTER TABLE `stinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `student_accounts`
--
ALTER TABLE `student_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `subcat`
--
ALTER TABLE `subcat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `teacherclass`
--
ALTER TABLE `teacherclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `teachersub`
--
ALTER TABLE `teachersub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

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

--
-- Constraints for table `student_accounts`
--
ALTER TABLE `student_accounts`
  ADD CONSTRAINT `student_accounts_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
