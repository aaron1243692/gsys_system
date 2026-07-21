/*
 Navicat Premium Dump SQL

 Source Server         : newlocal
 Source Server Type    : MySQL
 Source Server Version : 90700 (9.7.0)
 Source Host           : localhost:3306
 Source Schema         : gsys

 Target Server Type    : MySQL
 Target Server Version : 90700 (9.7.0)
 File Encoding         : 65001

 Date: 21/07/2026 21:52:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acady
-- ----------------------------
DROP TABLE IF EXISTS `acady`;
CREATE TABLE `acady`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `year_from` year NULL DEFAULT NULL,
  `year_to` year NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of acady
-- ----------------------------
INSERT INTO `acady` VALUES (4, 'asdas', 2026, 2027, '2026-06-01 20:36:24', '2026-06-01 20:36:24');
INSERT INTO `acady` VALUES (5, '2024-2025', 2024, 2025, '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `acady` VALUES (6, '2025-2026', 2025, 2026, '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `acady` VALUES (7, '2026-2027', 2026, 2027, '2026-07-01 15:48:17', '2026-07-01 15:48:17');

-- ----------------------------
-- Table structure for batch
-- ----------------------------
DROP TABLE IF EXISTS `batch`;
CREATE TABLE `batch`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` year NOT NULL,
  `curriculum_id` int NULL DEFAULT NULL,
  `track_id` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of batch
-- ----------------------------
INSERT INTO `batch` VALUES (1, 2027, NULL, 4, '2026-06-02 17:01:14', '2026-06-02 17:08:44');
INSERT INTO `batch` VALUES (2, 2028, NULL, 2, '2026-06-02 17:08:37', '2026-06-02 17:08:37');
INSERT INTO `batch` VALUES (3, 2024, 2, NULL, '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `batch` VALUES (4, 2025, 2, NULL, '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `batch` VALUES (5, 2026, 2, NULL, '2026-07-01 15:48:17', '2026-07-01 15:48:17');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:8:\"codename\";s:1:\"d\";s:9:\"parent_id\";s:1:\"e\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:3:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:6:\"sadasd\";s:1:\"c\";s:3:\"asd\";s:1:\"d\";N;s:1:\"e\";s:3:\"web\";}i:1;a:6:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"view\";s:1:\"c\";s:8:\"asd.view\";s:1:\"d\";i:1;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:6:{s:1:\"a\";i:3;s:1:\"b\";s:6:\"delete\";s:1:\"c\";s:10:\"asd.delete\";s:1:\"d\";i:1;s:1:\"e\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:12;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"e\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:12;s:1:\"b\";s:5:\"staff\";s:1:\"e\";s:3:\"web\";}}}', 1783008052);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `grlvl_id` int NULL DEFAULT NULL,
  `track_id` int NULL DEFAULT NULL,
  `acady_id` int NULL DEFAULT NULL,
  `adviser_id` int NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name` ASC) USING BTREE,
  UNIQUE INDEX `adviser_id`(`adviser_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES (2, 5, 1, 4, 1, 'bsit 3ba', '2026-06-02 06:37:53', '2026-06-03 19:53:30');
INSERT INTO `class` VALUES (3, 5, NULL, 4, NULL, 'sdsd', '2026-06-02 20:23:57', '2026-06-02 20:23:57');
INSERT INTO `class` VALUES (5, 18, 1, 6, 2, 'Grade 11 STEM A', '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `class` VALUES (6, 18, 1, 6, 3, 'Grade 11 STEM B', '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `class` VALUES (7, 18, 2, 6, 4, 'Grade 11 ABM A', '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `class` VALUES (8, 19, 1, 6, 5, 'Grade 12 STEM A', '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `class` VALUES (9, 19, 1, 6, 6, 'Grade 12 STEM B', '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `class` VALUES (10, 19, 2, 6, 7, 'Grade 12 ABM A', '2026-07-01 15:48:48', '2026-07-01 15:48:48');

-- ----------------------------
-- Table structure for class_list
-- ----------------------------
DROP TABLE IF EXISTS `class_list`;
CREATE TABLE `class_list`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `class_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of class_list
-- ----------------------------

-- ----------------------------
-- Table structure for classsched
-- ----------------------------
DROP TABLE IF EXISTS `classsched`;
CREATE TABLE `classsched`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `day` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` int NULL DEFAULT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of classsched
-- ----------------------------
INSERT INTO `classsched` VALUES (1, 2, 1, 'Monday', 1, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (2, 2, 2, 'Tuesday', 2, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (3, 2, 3, 'Wednesday', 3, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (4, 2, 4, 'Thursday', 4, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (5, 2, 5, 'Friday', 5, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (6, 3, 6, 'Monday', 2, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (7, 3, 7, 'Tuesday', 3, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (8, 3, 8, 'Wednesday', 4, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (9, 3, 9, 'Thursday', 5, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (10, 3, 10, 'Friday', 6, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (11, 5, 11, 'Monday', 3, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (12, 5, 12, 'Tuesday', 4, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (13, 5, 13, 'Wednesday', 5, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (14, 5, 14, 'Thursday', 6, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (15, 5, 15, 'Friday', 1, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (16, 6, 16, 'Monday', 4, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (17, 6, 17, 'Tuesday', 5, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (18, 6, 18, 'Wednesday', 6, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (19, 6, 1, 'Thursday', 1, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (20, 6, 2, 'Friday', 2, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (21, 7, 3, 'Monday', 5, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (22, 7, 4, 'Tuesday', 6, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (23, 7, 5, 'Wednesday', 1, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (24, 7, 6, 'Thursday', 2, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (25, 7, 7, 'Friday', 3, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (26, 8, 8, 'Monday', 6, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (27, 8, 9, 'Tuesday', 1, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (28, 8, 10, 'Wednesday', 2, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (29, 8, 11, 'Thursday', 3, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (30, 8, 12, 'Friday', 4, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (31, 9, 13, 'Monday', 1, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (32, 9, 14, 'Tuesday', 2, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (33, 9, 15, 'Wednesday', 3, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (34, 9, 16, 'Thursday', 4, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (35, 9, 17, 'Friday', 5, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (36, 10, 18, 'Monday', 2, '07:30:00', '08:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (37, 10, 1, 'Tuesday', 3, '08:30:00', '09:30:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (38, 10, 2, 'Wednesday', 4, '10:00:00', '11:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (39, 10, 3, 'Thursday', 5, '11:00:00', '12:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `classsched` VALUES (40, 10, 4, 'Friday', 6, '13:00:00', '14:00:00', '2026-07-01 15:49:59', '2026-07-01 15:52:35');

-- ----------------------------
-- Table structure for classsub
-- ----------------------------
DROP TABLE IF EXISTS `classsub`;
CREATE TABLE `classsub`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `sub_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 63 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of classsub
-- ----------------------------
INSERT INTO `classsub` VALUES (2, 2, 1, '2026-06-02 07:33:31', '2026-06-02 07:33:31');
INSERT INTO `classsub` VALUES (3, 5, 4, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (4, 5, 5, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (5, 5, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (6, 5, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (7, 5, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (8, 5, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (9, 5, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (10, 5, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (11, 5, 12, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (12, 5, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (13, 6, 4, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (14, 6, 5, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (15, 6, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (16, 6, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (17, 6, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (18, 6, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (19, 6, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (20, 6, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (21, 6, 12, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (22, 6, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (23, 7, 4, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (24, 7, 5, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (25, 7, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (26, 7, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (27, 7, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (28, 7, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (29, 7, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (30, 7, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (31, 7, 12, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (32, 7, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (33, 8, 4, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (34, 8, 5, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (35, 8, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (36, 8, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (37, 8, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (38, 8, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (39, 8, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (40, 8, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (41, 8, 12, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (42, 8, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (43, 9, 4, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (44, 9, 5, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (45, 9, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (46, 9, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (47, 9, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (48, 9, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (49, 9, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (50, 9, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (51, 9, 12, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (52, 9, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (53, 10, 4, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (54, 10, 5, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (55, 10, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (56, 10, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (57, 10, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (58, 10, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (59, 10, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (60, 10, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (61, 10, 12, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `classsub` VALUES (62, 10, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');

-- ----------------------------
-- Table structure for curriculum
-- ----------------------------
DROP TABLE IF EXISTS `curriculum`;
CREATE TABLE `curriculum`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `track_id` int NULL DEFAULT NULL,
  `batch_id` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of curriculum
-- ----------------------------
INSERT INTO `curriculum` VALUES (1, 'ghgh', NULL, NULL, '2026-06-02 16:34:38', '2026-06-02 16:34:38');
INSERT INTO `curriculum` VALUES (2, 'Senior High STEM Curriculum', 1, NULL, '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `curriculum` VALUES (3, 'Senior High ABM Curriculum', 2, NULL, '2026-07-01 15:48:17', '2026-07-01 15:48:17');

-- ----------------------------
-- Table structure for curriculum_subjects
-- ----------------------------
DROP TABLE IF EXISTS `curriculum_subjects`;
CREATE TABLE `curriculum_subjects`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `curriculum_id` int NULL DEFAULT NULL,
  `subject_id` int NOT NULL,
  `grade_level` tinyint UNSIGNED NULL DEFAULT NULL,
  `year_level` tinyint UNSIGNED NOT NULL,
  `semester` tinyint UNSIGNED NOT NULL,
  `units` decimal(4, 1) NOT NULL DEFAULT 0.0,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT 1,
  `prerequisites` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `curriculum_subject_unique`(`curriculum_id` ASC, `subject_id` ASC, `grade_level` ASC, `semester` ASC) USING BTREE,
  INDEX `curriculum_subjects_subject_id_index`(`subject_id` ASC) USING BTREE,
  INDEX `curriculum_subjects_year_level_semester_sort_order_index`(`year_level` ASC, `semester` ASC, `sort_order` ASC) USING BTREE,
  INDEX `curriculum_subjects_curriculum_id_index`(`curriculum_id` ASC) USING BTREE,
  INDEX `curriculum_subject_lookup_index`(`curriculum_id` ASC, `grade_level` ASC, `semester` ASC, `sort_order` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of curriculum_subjects
-- ----------------------------
INSERT INTO `curriculum_subjects` VALUES (1, 2, 4, 11, 11, 1, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (2, 2, 6, 11, 11, 1, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (3, 2, 8, 11, 11, 1, 0.0, 3, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (4, 2, 10, 11, 11, 1, 0.0, 4, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (5, 2, 15, 11, 11, 1, 0.0, 5, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (6, 2, 5, 11, 11, 2, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (7, 2, 7, 11, 11, 2, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (8, 2, 9, 11, 11, 2, 0.0, 3, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (9, 2, 12, 11, 11, 2, 0.0, 4, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (10, 2, 17, 11, 11, 2, 0.0, 5, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (11, 2, 11, 12, 12, 1, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (12, 2, 13, 12, 12, 1, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (13, 2, 16, 12, 12, 1, 0.0, 3, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (14, 2, 18, 12, 12, 1, 0.0, 4, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (15, 2, 14, 12, 12, 2, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (16, 2, 7, 12, 12, 2, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (17, 2, 18, 12, 12, 2, 0.0, 3, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (18, 3, 4, 11, 11, 1, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (19, 3, 6, 11, 11, 1, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (20, 3, 8, 11, 11, 1, 0.0, 3, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (21, 3, 10, 11, 11, 1, 0.0, 4, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (22, 3, 15, 11, 11, 1, 0.0, 5, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (23, 3, 5, 11, 11, 2, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (24, 3, 7, 11, 11, 2, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (25, 3, 9, 11, 11, 2, 0.0, 3, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (26, 3, 12, 11, 11, 2, 0.0, 4, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (27, 3, 17, 11, 11, 2, 0.0, 5, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (28, 3, 11, 12, 12, 1, 0.0, 1, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (29, 3, 13, 12, 12, 1, 0.0, 2, NULL, '2026-07-01 15:49:35', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (30, 3, 16, 12, 12, 1, 0.0, 3, NULL, '2026-07-01 15:49:36', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (31, 3, 18, 12, 12, 1, 0.0, 4, NULL, '2026-07-01 15:49:36', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (32, 3, 14, 12, 12, 2, 0.0, 1, NULL, '2026-07-01 15:49:36', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (33, 3, 7, 12, 12, 2, 0.0, 2, NULL, '2026-07-01 15:49:36', '2026-07-01 15:52:06');
INSERT INTO `curriculum_subjects` VALUES (34, 3, 18, 12, 12, 2, 0.0, 3, NULL, '2026-07-01 15:49:36', '2026-07-01 15:52:06');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for grades
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_list_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `first_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `second_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `third_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `final_grade` decimal(5, 2) NULL DEFAULT NULL,
  `remarks` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grades
-- ----------------------------

-- ----------------------------
-- Table structure for grlvl
-- ----------------------------
DROP TABLE IF EXISTS `grlvl`;
CREATE TABLE `grlvl`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name` ASC) USING BTREE,
  UNIQUE INDEX `name_2`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grlvl
-- ----------------------------
INSERT INTO `grlvl` VALUES (2, 'grade 2', '2026-06-01 19:43:45', '2026-06-01 20:09:16');
INSERT INTO `grlvl` VALUES (3, 'sadd', '2026-06-01 20:10:51', '2026-06-01 20:10:51');
INSERT INTO `grlvl` VALUES (5, 'asdas', '2026-06-01 20:10:58', '2026-06-01 20:10:58');
INSERT INTO `grlvl` VALUES (8, 'asdsad', '2026-06-01 20:11:11', '2026-06-01 20:11:11');
INSERT INTO `grlvl` VALUES (18, 'Grade 11', '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `grlvl` VALUES (19, 'Grade 12', '2026-07-01 15:48:17', '2026-07-01 15:48:17');

-- ----------------------------
-- Table structure for guardianchilds
-- ----------------------------
DROP TABLE IF EXISTS `guardianchilds`;
CREATE TABLE `guardianchilds`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `guardian_id` int NOT NULL,
  `student_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of guardianchilds
-- ----------------------------
INSERT INTO `guardianchilds` VALUES (1, 1, 1, '2026-06-02 07:36:36', '2026-06-02 07:36:36');
INSERT INTO `guardianchilds` VALUES (2, 1, 2, '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `guardianchilds` VALUES (3, 1, 3, '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `guardianchilds` VALUES (4, 2, 4, '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `guardianchilds` VALUES (5, 2, 5, '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `guardianchilds` VALUES (6, 3, 6, '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `guardianchilds` VALUES (7, 3, 7, '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `guardianchilds` VALUES (8, 4, 8, '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `guardianchilds` VALUES (9, 4, 9, '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `guardianchilds` VALUES (10, 5, 10, '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `guardianchilds` VALUES (11, 5, 11, '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `guardianchilds` VALUES (12, 6, 12, '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `guardianchilds` VALUES (13, 6, 13, '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `guardianchilds` VALUES (14, 7, 14, '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `guardianchilds` VALUES (15, 7, 15, '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `guardianchilds` VALUES (16, 8, 16, '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `guardianchilds` VALUES (17, 8, 17, '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `guardianchilds` VALUES (18, 9, 18, '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `guardianchilds` VALUES (19, 9, 19, '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `guardianchilds` VALUES (20, 10, 20, '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `guardianchilds` VALUES (21, 10, 21, '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `guardianchilds` VALUES (22, 11, 22, '2026-07-01 15:49:49', '2026-07-01 15:49:49');
INSERT INTO `guardianchilds` VALUES (23, 11, 23, '2026-07-01 15:49:49', '2026-07-01 15:49:49');
INSERT INTO `guardianchilds` VALUES (24, 12, 24, '2026-07-01 15:49:49', '2026-07-01 15:49:49');
INSERT INTO `guardianchilds` VALUES (25, 12, 25, '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `guardianchilds` VALUES (26, 13, 26, '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `guardianchilds` VALUES (27, 13, 27, '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `guardianchilds` VALUES (28, 14, 28, '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `guardianchilds` VALUES (29, 14, 29, '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `guardianchilds` VALUES (30, 15, 30, '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `guardianchilds` VALUES (31, 15, 31, '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `guardianchilds` VALUES (32, 16, 32, '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `guardianchilds` VALUES (33, 16, 33, '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `guardianchilds` VALUES (34, 17, 34, '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `guardianchilds` VALUES (35, 17, 35, '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `guardianchilds` VALUES (36, 18, 36, '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `guardianchilds` VALUES (37, 18, 37, '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `guardianchilds` VALUES (38, 19, 38, '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `guardianchilds` VALUES (39, 19, 39, '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `guardianchilds` VALUES (40, 20, 40, '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `guardianchilds` VALUES (41, 20, 41, '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `guardianchilds` VALUES (42, 21, 42, '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `guardianchilds` VALUES (43, 21, 43, '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `guardianchilds` VALUES (44, 22, 44, '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `guardianchilds` VALUES (45, 22, 45, '2026-07-01 15:49:55', '2026-07-01 15:49:55');
INSERT INTO `guardianchilds` VALUES (46, 23, 46, '2026-07-01 15:49:55', '2026-07-01 15:49:55');
INSERT INTO `guardianchilds` VALUES (47, 23, 47, '2026-07-01 15:49:55', '2026-07-01 15:49:55');
INSERT INTO `guardianchilds` VALUES (48, 24, 48, '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `guardianchilds` VALUES (49, 24, 49, '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `guardianchilds` VALUES (50, 25, 50, '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `guardianchilds` VALUES (51, 25, 51, '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `guardianchilds` VALUES (52, 26, 52, '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `guardianchilds` VALUES (53, 26, 53, '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `guardianchilds` VALUES (54, 27, 54, '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `guardianchilds` VALUES (55, 27, 55, '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `guardianchilds` VALUES (56, 28, 56, '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `guardianchilds` VALUES (57, 28, 57, '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `guardianchilds` VALUES (58, 29, 58, '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `guardianchilds` VALUES (59, 29, 59, '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `guardianchilds` VALUES (60, 30, 60, '2026-07-01 15:49:59', '2026-07-01 15:49:59');
INSERT INTO `guardianchilds` VALUES (61, 30, 61, '2026-07-01 15:49:59', '2026-07-01 15:49:59');

-- ----------------------------
-- Table structure for guardians
-- ----------------------------
DROP TABLE IF EXISTS `guardians`;
CREATE TABLE `guardians`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `guardians_username_unique`(`username` ASC) USING BTREE,
  UNIQUE INDEX `guardians_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of guardians
-- ----------------------------
INSERT INTO `guardians` VALUES (1, 'guardian', 'guardian@example.com', '$2y$12$S88gxvq3CmEyr8zyeDGWkuNM29C4kq05FY3gGImpGCqWY.ATF6dIy', NULL, NULL, NULL, '2026-06-01 07:29:51', '2026-06-01 19:01:11');
INSERT INTO `guardians` VALUES (2, 'parent01', 'parent01@example.com', '$2y$12$NgpZyMmK7SCZGIN/stCoC.yOAxQZgfE/cKGErDVnEKqkPGowYTOW6', 'Mr./Ms. Dela Cruz', '09170000000', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:36', '2026-07-01 15:52:06');
INSERT INTO `guardians` VALUES (3, 'parent02', 'parent02@example.com', '$2y$12$W4EsYU6EDwIi9Cipw6UIaecQA1H69gA4obyI7w3chYtmDSC7umDbW', 'Mr./Ms. Santos', '09170000001', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:36', '2026-07-01 15:52:07');
INSERT INTO `guardians` VALUES (4, 'parent03', 'parent03@example.com', '$2y$12$p0h1aNkeGitonlt8di/g1umXNpd.ensX0Apw3eaCTUpRrr7BAs4lG', 'Mr./Ms. Reyes', '09170000002', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:36', '2026-07-01 15:52:07');
INSERT INTO `guardians` VALUES (5, 'parent04', 'parent04@example.com', '$2y$12$kZFN3ZcBjeHk1gm5k2lUH.lMTEBKDExMbnUsrbUw2zy2BgvJwC7uC', 'Mr./Ms. Garcia', '09170000003', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:37', '2026-07-01 15:52:07');
INSERT INTO `guardians` VALUES (6, 'parent05', 'parent05@example.com', '$2y$12$dgMjkVXwTa7Cd0cSCNoNrO1DWoft3HRyasVKc3MIR6VGPgjBYnQ4m', 'Mr./Ms. Mendoza', '09170000004', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:37', '2026-07-01 15:52:07');
INSERT INTO `guardians` VALUES (7, 'parent06', 'parent06@example.com', '$2y$12$2OBvLu1yTZPVdS40gkLPce./pCzhsvDMCs4Gzeg4ecE/LGOAM91Gu', 'Mr./Ms. Lopez', '09170000005', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:37', '2026-07-01 15:52:08');
INSERT INTO `guardians` VALUES (8, 'parent07', 'parent07@example.com', '$2y$12$RH.tn7KDO.dFO5ai2WB28ujf5bojyo5nRxcWAx2rL3mML7vjbfWaW', 'Mr./Ms. Flores', '09170000006', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:37', '2026-07-01 15:52:08');
INSERT INTO `guardians` VALUES (9, 'parent08', 'parent08@example.com', '$2y$12$ksPlPNMO4xQd28hHCuQJhOhEld/VhFpwv51FCIsMUSXxE/biDc8A6', 'Mr./Ms. Aquino', '09170000007', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:38', '2026-07-01 15:52:08');
INSERT INTO `guardians` VALUES (10, 'parent09', 'parent09@example.com', '$2y$12$gqL4pslnbrCNQuJb4ax4aeEzO27JXhqPi8E1TUKdB/4cJMFlntj2m', 'Mr./Ms. Navarro', '09170000008', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:38', '2026-07-01 15:52:09');
INSERT INTO `guardians` VALUES (11, 'parent10', 'parent10@example.com', '$2y$12$KBNps0cpLawWqizjUI6SEOFvHiuPb1iJZUDLIcWvJGfR/oSaVQAo.', 'Mr./Ms. Ramos', '09170000009', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:38', '2026-07-01 15:52:09');
INSERT INTO `guardians` VALUES (12, 'parent11', 'parent11@example.com', '$2y$12$H91m2lRCfoqJTd3dLfxhGOIZ2BnCfu3RE.R6u8YSkNUcVec.YNXVi', 'Mr./Ms. Torres', '09170000010', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:38', '2026-07-01 15:52:09');
INSERT INTO `guardians` VALUES (13, 'parent12', 'parent12@example.com', '$2y$12$l9Emzal1VEhObzF4mvZbReX28psI1vTjrXvhIkA9P/yMWvc1IFTXq', 'Mr./Ms. Castro', '09170000011', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:39', '2026-07-01 15:52:09');
INSERT INTO `guardians` VALUES (14, 'parent13', 'parent13@example.com', '$2y$12$yaa.vv.4h9knGBuhi/jOhe0YSwQ0CN1UV2VXeJ8qqjg3HfF53a/g2', 'Mr./Ms. Villanueva', '09170000012', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:39', '2026-07-01 15:52:10');
INSERT INTO `guardians` VALUES (15, 'parent14', 'parent14@example.com', '$2y$12$DMjPHE7G68Y89MLlPXTM0OGNwNeE/utE3ZKkdfhCMHvtHeCQOzyBG', 'Mr./Ms. Bautista', '09170000013', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:39', '2026-07-01 15:52:10');
INSERT INTO `guardians` VALUES (16, 'parent15', 'parent15@example.com', '$2y$12$xxMKRMuL8v/kWoQvPajw0ek4cp5i8TgOHd.fA5OCvySXv/aUbZ6nW', 'Mr./Ms. Cruz', '09170000014', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:39', '2026-07-01 15:52:10');
INSERT INTO `guardians` VALUES (17, 'parent16', 'parent16@example.com', '$2y$12$hhC8gij31OU3EJQ1ARo67.69J8tJ3G0HI.S8DNmL4mUXVuqYh5wcm', 'Mr./Ms. Diaz', '09170000015', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:40', '2026-07-01 15:52:10');
INSERT INTO `guardians` VALUES (18, 'parent17', 'parent17@example.com', '$2y$12$bYeDE3HS3ISI8.2Q00eawuRPHQV9/mjhxTMI37cxd4uTttkxQXD0y', 'Mr./Ms. Morales', '09170000016', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:40', '2026-07-01 15:52:11');
INSERT INTO `guardians` VALUES (19, 'parent18', 'parent18@example.com', '$2y$12$EEzrm8RfJswLCsXnbYSOW.gS.9j7A/DAGzQlTa1R4H2WYndtMoYEW', 'Mr./Ms. Rivera', '09170000017', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:40', '2026-07-01 15:52:11');
INSERT INTO `guardians` VALUES (20, 'parent19', 'parent19@example.com', '$2y$12$1HlRmp1tBD6g3cniauUAxe0idtZOJ4hIxu6Q37e/U2d.Cp3sTiT2u', 'Mr./Ms. Gonzales', '09170000018', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:40', '2026-07-01 15:52:11');
INSERT INTO `guardians` VALUES (21, 'parent20', 'parent20@example.com', '$2y$12$rlv5fBBSXZlYT5OIitKubuvuh9NZB6TeLUkDosoRjRnQvln.GQBSy', 'Mr./Ms. Padilla', '09170000019', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:41', '2026-07-01 15:52:12');
INSERT INTO `guardians` VALUES (22, 'parent21', 'parent21@example.com', '$2y$12$YpPy3HwDGaoe1vrPsIc8GOQOTX2PF2zr9wKZCYeONdx1x89ZyVEla', 'Mr./Ms. Salazar', '09170000020', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:41', '2026-07-01 15:52:12');
INSERT INTO `guardians` VALUES (23, 'parent22', 'parent22@example.com', '$2y$12$dJA8C89ZG.6jtwsM49QUZOECivERilpfzXBrM8I4n31AS788AElK.', 'Mr./Ms. Domingo', '09170000021', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:41', '2026-07-01 15:52:12');
INSERT INTO `guardians` VALUES (24, 'parent23', 'parent23@example.com', '$2y$12$SAoFjPTri8xyK0JWqm.rYeNeCzwBN7t0bDoKLybNO6Mta1vg8yUz6', 'Mr./Ms. Mercado', '09170000022', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:41', '2026-07-01 15:52:13');
INSERT INTO `guardians` VALUES (25, 'parent24', 'parent24@example.com', '$2y$12$pp1KSGxzkzAiGBTY2K0FI.CI5evJ0s0LF7RVyKrQuZgY5jIp68DJ6', 'Mr./Ms. Pascual', '09170000023', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:42', '2026-07-01 15:52:13');
INSERT INTO `guardians` VALUES (26, 'parent25', 'parent25@example.com', '$2y$12$qzDO77pARY2tNdwUUVceSu0JgjW9xx2EL3b5ECwSz9WgQ7R7WJohK', 'Mr./Ms. Valdez', '09170000024', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:42', '2026-07-01 15:52:13');
INSERT INTO `guardians` VALUES (27, 'parent26', 'parent26@example.com', '$2y$12$fI16OIi8GabV9KBZuY7xoup6qZJsW4.GLv2IZJMO1mn1y/m6oC66i', 'Mr./Ms. Aguilar', '09170000025', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:42', '2026-07-01 15:52:14');
INSERT INTO `guardians` VALUES (28, 'parent27', 'parent27@example.com', '$2y$12$40b2JZWf/SlXu5VZQM2NRuSTPleWw9Btr.2g1PmsrbSvOoddYJiyW', 'Mr./Ms. Rosales', '09170000026', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:42', '2026-07-01 15:52:14');
INSERT INTO `guardians` VALUES (29, 'parent28', 'parent28@example.com', '$2y$12$Xzg2rCsmRrgutmNf0DHP..8LlhycO6Nl7z8qYVmUdF3BB1sKG73Vi', 'Mr./Ms. Fernandez', '09170000027', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:43', '2026-07-01 15:52:14');
INSERT INTO `guardians` VALUES (30, 'parent29', 'parent29@example.com', '$2y$12$kdaa/ONeaeYb3KoWVHTOp.mb/ohFlhHGMNn26MGmyL8nDIEDYZMFe', 'Mr./Ms. Alvarez', '09170000028', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:43', '2026-07-01 15:52:14');
INSERT INTO `guardians` VALUES (31, 'parent30', 'parent30@example.com', '$2y$12$SMwO6i1lUbe0BbTPuEVuze3.BXOKgIDuRfvXl122oYQA4Xz4Qk3sC', 'Mr./Ms. Gutierrez', '09170000029', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:43', '2026-07-01 15:52:15');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2026_05_30_135604_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (5, '2026_05_30_140000_rename_name_to_username_on_users_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_05_30_141000_add_hierarchy_to_permissions_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_05_30_142000_drop_name_guard_unique_from_permissions_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_06_01_000000_create_students_table', 1);
INSERT INTO `migrations` VALUES (9, '2026_06_01_000001_create_guardians_table', 1);
INSERT INTO `migrations` VALUES (10, '2026_06_02_000000_add_deleted_at_to_subject_table', 2);
INSERT INTO `migrations` VALUES (11, '2026_06_02_000001_add_teacher_id_to_subject_table', 3);
INSERT INTO `migrations` VALUES (12, '2026_06_02_000002_create_curriculum_subjects_table', 4);
INSERT INTO `migrations` VALUES (13, '2026_06_03_000001_add_track_id_to_class_table', 4);
INSERT INTO `migrations` VALUES (14, '2026_06_03_000002_add_flow_columns_to_batch_and_curriculum_tables', 5);
INSERT INTO `migrations` VALUES (15, '2026_06_03_000003_add_grlvl_id_to_tracksub_table', 6);
INSERT INTO `migrations` VALUES (16, '2026_06_03_000004_scope_curriculum_subjects_by_curriculum_grade_semester', 7);
INSERT INTO `migrations` VALUES (17, '2026_06_03_000005_add_adviser_id_to_class_table', 8);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pending_grades
-- ----------------------------
DROP TABLE IF EXISTS `pending_grades`;
CREATE TABLE `pending_grades`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_list_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `first_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `second_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `third_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `fourth_quarter` decimal(5, 2) NULL DEFAULT NULL,
  `final_grade` decimal(5, 2) NULL DEFAULT NULL,
  `remarks` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `submitted_by` int NULL DEFAULT NULL,
  `approved_by` int NULL DEFAULT NULL,
  `submitted_at` datetime NULL DEFAULT NULL,
  `approved_at` datetime NULL DEFAULT NULL,
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_pending_grade`(`class_list_id` ASC, `subject_id` ASC, `status` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pending_grades
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED NULL DEFAULT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_codename_unique`(`codename` ASC) USING BTREE,
  INDEX `permissions_parent_id_index`(`parent_id` ASC) USING BTREE,
  CONSTRAINT `permissions_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'sadasd', 'asd', NULL, 'web', NULL, NULL);
INSERT INTO `permissions` VALUES (2, 'view', 'asd.view', 1, 'web', NULL, NULL);
INSERT INTO `permissions` VALUES (3, 'delete', 'asd.delete', 1, 'web', NULL, NULL);

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (3, 12);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin', 'web', '2026-06-01 07:29:50', '2026-06-01 07:29:50');
INSERT INTO `roles` VALUES (12, 'staff', 'web', '2026-06-02 08:53:21', '2026-06-02 08:53:21');

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES (1, 'lab121', '2026-06-03 19:17:41', '2026-06-03 19:17:41');
INSERT INTO `rooms` VALUES (2, 'Room 101', '2026-07-01 15:49:59', '2026-07-01 15:49:59');
INSERT INTO `rooms` VALUES (3, 'Room 102', '2026-07-01 15:49:59', '2026-07-01 15:49:59');
INSERT INTO `rooms` VALUES (4, 'Room 201', '2026-07-01 15:49:59', '2026-07-01 15:49:59');
INSERT INTO `rooms` VALUES (5, 'Science Lab', '2026-07-01 15:49:59', '2026-07-01 15:49:59');
INSERT INTO `rooms` VALUES (6, 'Computer Lab', '2026-07-01 15:49:59', '2026-07-01 15:49:59');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('XsfjRnSU31CLC3ypkvoYGBQ27A7FmJswSCMxc0S0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEFHbEY0ZzZNTURxTGVuU1owZVpXc1Rja1ZoYzk3SDcwYmJlbGk2SiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo2OiJzaWduaW4iO319', 1782922471);

-- ----------------------------
-- Table structure for stinfo
-- ----------------------------
DROP TABLE IF EXISTS `stinfo`;
CREATE TABLE `stinfo`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `lrn` bigint NULL DEFAULT NULL,
  `admited` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `birthdate` date NULL DEFAULT NULL,
  `grlvl_id` int NULL DEFAULT NULL,
  `class_id` int NULL DEFAULT NULL,
  `acady_id` int NULL DEFAULT NULL,
  `contact` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of stinfo
-- ----------------------------
INSERT INTO `stinfo` VALUES (1, 1, 2323, 1, 'dff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-04 03:46:01', '2026-06-10 13:36:26');
INSERT INTO `stinfo` VALUES (2, 2, 110000000000, 1, 'Juan Dela Cruz', 'Male', '2010-07-01', 5, 2, 6, '09180000000', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `stinfo` VALUES (3, 3, 110000000001, 1, 'Maria Santos', 'Female', '2009-06-18', 5, 3, 6, '09180000001', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `stinfo` VALUES (4, 4, 110000000002, 1, 'Jose Reyes', 'Male', '2008-06-05', 18, 5, 6, '09180000002', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `stinfo` VALUES (5, 5, 110000000003, 1, 'Ana Garcia', 'Female', '2010-05-23', 18, 6, 6, '09180000003', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:44', '2026-07-01 15:49:44');
INSERT INTO `stinfo` VALUES (6, 6, 110000000004, 1, 'Carlo Mendoza', 'Male', '2009-05-10', 18, 7, 6, '09180000004', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `stinfo` VALUES (7, 7, 110000000005, 1, 'Angelica Lopez', 'Female', '2008-04-27', 19, 8, 6, '09180000005', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `stinfo` VALUES (8, 8, 110000000006, 1, 'Miguel Flores', 'Male', '2010-04-14', 19, 9, 6, '09180000006', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `stinfo` VALUES (9, 9, 110000000007, 1, 'Sofia Aquino', 'Female', '2009-04-01', 19, 10, 6, '09180000007', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:45', '2026-07-01 15:49:45');
INSERT INTO `stinfo` VALUES (10, 10, 110000000008, 1, 'Gabriel Navarro', 'Male', '2008-03-19', 5, 2, 6, '09180000008', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `stinfo` VALUES (11, 11, 110000000009, 1, 'Nicole Ramos', 'Female', '2010-03-06', 5, 3, 6, '09180000009', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `stinfo` VALUES (12, 12, 110000000010, 1, 'Daniel Torres', 'Male', '2009-02-21', 18, 5, 6, '09180000010', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `stinfo` VALUES (13, 13, 110000000011, 1, 'Andrea Castro', 'Female', '2008-02-09', 18, 6, 6, '09180000011', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:46', '2026-07-01 15:49:46');
INSERT INTO `stinfo` VALUES (14, 14, 110000000012, 1, 'Joshua Villanueva', 'Male', '2010-01-26', 18, 7, 6, '09180000012', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `stinfo` VALUES (15, 15, 110000000013, 1, 'Katrina Bautista', 'Female', '2009-01-13', 19, 8, 6, '09180000013', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `stinfo` VALUES (16, 16, 110000000014, 1, 'Marco Cruz', 'Male', '2008-01-01', 19, 9, 6, '09180000014', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `stinfo` VALUES (17, 17, 110000000015, 1, 'Christine Dela Cruz', 'Female', '2009-12-18', 19, 10, 6, '09180000015', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:47', '2026-07-01 15:49:47');
INSERT INTO `stinfo` VALUES (18, 18, 110000000016, 1, 'Paolo Santos', 'Male', '2008-12-05', 5, 2, 6, '09180000016', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `stinfo` VALUES (19, 19, 110000000017, 1, 'Jasmine Reyes', 'Female', '2007-11-23', 5, 3, 6, '09180000017', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `stinfo` VALUES (20, 20, 110000000018, 1, 'Rafael Garcia', 'Male', '2009-11-09', 18, 5, 6, '09180000018', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `stinfo` VALUES (21, 21, 110000000019, 1, 'Bianca Mendoza', 'Female', '2008-10-27', 18, 6, 6, '09180000019', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:48', '2026-07-01 15:49:48');
INSERT INTO `stinfo` VALUES (22, 22, 110000000020, 1, 'Juan Lopez', 'Male', '2007-10-15', 18, 7, 6, '09180000020', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:49', '2026-07-01 15:49:49');
INSERT INTO `stinfo` VALUES (23, 23, 110000000021, 1, 'Maria Flores', 'Female', '2009-10-01', 19, 8, 6, '09180000021', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:49', '2026-07-01 15:49:49');
INSERT INTO `stinfo` VALUES (24, 24, 110000000022, 1, 'Jose Aquino', 'Male', '2008-09-18', 19, 9, 6, '09180000022', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:49', '2026-07-01 15:49:49');
INSERT INTO `stinfo` VALUES (25, 25, 110000000023, 1, 'Ana Navarro', 'Female', '2007-09-06', 19, 10, 6, '09180000023', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `stinfo` VALUES (26, 26, 110000000024, 1, 'Carlo Ramos', 'Male', '2009-08-23', 5, 2, 6, '09180000024', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `stinfo` VALUES (27, 27, 110000000025, 1, 'Angelica Torres', 'Female', '2008-08-10', 5, 3, 6, '09180000025', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `stinfo` VALUES (28, 28, 110000000026, 1, 'Miguel Castro', 'Male', '2007-07-29', 18, 5, 6, '09180000026', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:50', '2026-07-01 15:49:50');
INSERT INTO `stinfo` VALUES (29, 29, 110000000027, 1, 'Sofia Villanueva', 'Female', '2009-07-15', 18, 6, 6, '09180000027', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `stinfo` VALUES (30, 30, 110000000028, 1, 'Gabriel Bautista', 'Male', '2008-07-02', 18, 7, 6, '09180000028', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `stinfo` VALUES (31, 31, 110000000029, 1, 'Nicole Cruz', 'Female', '2007-06-20', 19, 8, 6, '09180000029', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `stinfo` VALUES (32, 32, 110000000030, 1, 'Daniel Dela Cruz', 'Male', '2009-06-06', 19, 9, 6, '09180000030', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:51', '2026-07-01 15:49:51');
INSERT INTO `stinfo` VALUES (33, 33, 110000000031, 1, 'Andrea Santos', 'Female', '2008-05-24', 19, 10, 6, '09180000031', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `stinfo` VALUES (34, 34, 110000000032, 1, 'Joshua Reyes', 'Male', '2007-05-12', 5, 2, 6, '09180000032', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `stinfo` VALUES (35, 35, 110000000033, 1, 'Katrina Garcia', 'Female', '2009-04-28', 5, 3, 6, '09180000033', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `stinfo` VALUES (36, 36, 110000000034, 1, 'Marco Mendoza', 'Male', '2008-04-15', 18, 5, 6, '09180000034', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:52', '2026-07-01 15:49:52');
INSERT INTO `stinfo` VALUES (37, 37, 110000000035, 1, 'Christine Lopez', 'Female', '2007-04-03', 18, 6, 6, '09180000035', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `stinfo` VALUES (38, 38, 110000000036, 1, 'Paolo Flores', 'Male', '2009-03-20', 18, 7, 6, '09180000036', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `stinfo` VALUES (39, 39, 110000000037, 1, 'Jasmine Aquino', 'Female', '2008-03-07', 19, 8, 6, '09180000037', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `stinfo` VALUES (40, 40, 110000000038, 1, 'Rafael Navarro', 'Male', '2007-02-23', 19, 9, 6, '09180000038', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:53', '2026-07-01 15:49:53');
INSERT INTO `stinfo` VALUES (41, 41, 110000000039, 1, 'Bianca Ramos', 'Female', '2009-02-09', 19, 10, 6, '09180000039', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `stinfo` VALUES (42, 42, 110000000040, 1, 'Juan Torres', 'Male', '2008-01-28', 5, 2, 6, '09180000040', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `stinfo` VALUES (43, 43, 110000000041, 1, 'Maria Castro', 'Female', '2007-01-15', 5, 3, 6, '09180000041', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `stinfo` VALUES (44, 44, 110000000042, 1, 'Jose Villanueva', 'Male', '2009-01-01', 18, 5, 6, '09180000042', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:54', '2026-07-01 15:49:54');
INSERT INTO `stinfo` VALUES (45, 45, 110000000043, 1, 'Ana Bautista', 'Female', '2007-12-20', 18, 6, 6, '09180000043', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:55', '2026-07-01 15:49:55');
INSERT INTO `stinfo` VALUES (46, 46, 110000000044, 1, 'Carlo Cruz', 'Male', '2006-12-07', 18, 7, 6, '09180000044', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:55', '2026-07-01 15:49:55');
INSERT INTO `stinfo` VALUES (47, 47, 110000000045, 1, 'Angelica Dela Cruz', 'Female', '2008-11-23', 19, 8, 6, '09180000045', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:55', '2026-07-01 15:49:55');
INSERT INTO `stinfo` VALUES (48, 48, 110000000046, 1, 'Miguel Santos', 'Male', '2007-11-11', 19, 9, 6, '09180000046', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `stinfo` VALUES (49, 49, 110000000047, 1, 'Sofia Reyes', 'Female', '2006-10-29', 19, 10, 6, '09180000047', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `stinfo` VALUES (50, 50, 110000000048, 1, 'Gabriel Garcia', 'Male', '2008-10-15', 5, 2, 6, '09180000048', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `stinfo` VALUES (51, 51, 110000000049, 1, 'Nicole Mendoza', 'Female', '2007-10-03', 5, 3, 6, '09180000049', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:56', '2026-07-01 15:49:56');
INSERT INTO `stinfo` VALUES (52, 52, 110000000050, 1, 'Daniel Lopez', 'Male', '2006-09-20', 18, 5, 6, '09180000050', 'Barangay 1, Cauayan City, Isabela', '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `stinfo` VALUES (53, 53, 110000000051, 1, 'Andrea Flores', 'Female', '2008-09-06', 18, 6, 6, '09180000051', 'Barangay 2, Cauayan City, Isabela', '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `stinfo` VALUES (54, 54, 110000000052, 1, 'Joshua Aquino', 'Male', '2007-08-25', 18, 7, 6, '09180000052', 'Barangay 3, Cauayan City, Isabela', '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `stinfo` VALUES (55, 55, 110000000053, 1, 'Katrina Navarro', 'Female', '2006-08-12', 19, 8, 6, '09180000053', 'Barangay 4, Cauayan City, Isabela', '2026-07-01 15:49:57', '2026-07-01 15:49:57');
INSERT INTO `stinfo` VALUES (56, 56, 110000000054, 0, 'Marco Ramos', 'Male', '2008-07-29', 19, 9, 6, '09180000054', 'Barangay 5, Cauayan City, Isabela', '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `stinfo` VALUES (57, 57, 110000000055, 0, 'Christine Torres', 'Female', '2007-07-17', 19, 10, 6, '09180000055', 'Barangay 6, Cauayan City, Isabela', '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `stinfo` VALUES (58, 58, 110000000056, 0, 'Paolo Castro', 'Male', '2006-07-04', 5, 2, 6, '09180000056', 'Barangay 7, Cauayan City, Isabela', '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `stinfo` VALUES (59, 59, 110000000057, 0, 'Jasmine Villanueva', 'Female', '2008-06-20', 5, 3, 6, '09180000057', 'Barangay 8, Cauayan City, Isabela', '2026-07-01 15:49:58', '2026-07-01 15:49:58');
INSERT INTO `stinfo` VALUES (60, 60, 110000000058, 0, 'Rafael Bautista', 'Male', '2007-06-08', 18, 5, 6, '09180000058', 'Barangay 9, Cauayan City, Isabela', '2026-07-01 15:49:59', '2026-07-01 15:49:59');
INSERT INTO `stinfo` VALUES (61, 61, 110000000059, 0, 'Bianca Cruz', 'Female', '2006-05-26', 18, 6, 6, '09180000059', 'Barangay 10, Cauayan City, Isabela', '2026-07-01 15:49:59', '2026-07-01 15:49:59');

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `students_username_unique`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (1, 'student', NULL, '$2y$12$S88gxvq3CmEyr8zyeDGWkuNM29C4kq05FY3gGImpGCqWY.ATF6dIy', '2026-06-01 07:29:51', '2026-06-02 07:50:25');
INSERT INTO `students` VALUES (2, 'student001', 'student001@student.gsys.edu.ph', '$2y$12$WBvIzpQ58ot3M2HhBPbRvuxZpuMQTY37fRJhhOjVMFGkZ8xMXeRGa', '2026-07-01 15:49:44', '2026-07-01 15:52:15');
INSERT INTO `students` VALUES (3, 'student002', 'student002@student.gsys.edu.ph', '$2y$12$SmWxdHIV59bGPOtoCDDg5.7R..wGvyzrnqLXuQbjevl.3nYrhlU5m', '2026-07-01 15:49:44', '2026-07-01 15:52:15');
INSERT INTO `students` VALUES (4, 'student003', 'student003@student.gsys.edu.ph', '$2y$12$56GC.Q/v5N612AEnN5oCp.c40oVt0BbjE/y2jalc5KFsB5zc/8pSW', '2026-07-01 15:49:44', '2026-07-01 15:52:16');
INSERT INTO `students` VALUES (5, 'student004', 'student004@student.gsys.edu.ph', '$2y$12$ud7ycdTqgTlPFW87JZG/B.DbBMG.cSek4uG/fAoJkEjEwHiEfkYX.', '2026-07-01 15:49:44', '2026-07-01 15:52:16');
INSERT INTO `students` VALUES (6, 'student005', 'student005@student.gsys.edu.ph', '$2y$12$uS0hGNXp5zXmPDcfkW1qB.6pcELEemvJHASgqcBke.1sFrv0AJkJi', '2026-07-01 15:49:45', '2026-07-01 15:52:16');
INSERT INTO `students` VALUES (7, 'student006', 'student006@student.gsys.edu.ph', '$2y$12$U2Bcq12A/pN7ijKQAqp.TuRVHnd.2hzd0RBxni5XmUU9rNuZELcIa', '2026-07-01 15:49:45', '2026-07-01 15:52:17');
INSERT INTO `students` VALUES (8, 'student007', 'student007@student.gsys.edu.ph', '$2y$12$VohkWZb71U6/UN/cfynVMO4KpKeuS9aqiCQMd9s0qVP4aBTiw/DOi', '2026-07-01 15:49:45', '2026-07-01 15:52:17');
INSERT INTO `students` VALUES (9, 'student008', 'student008@student.gsys.edu.ph', '$2y$12$51LLmlgAuFAj.TGh.pFQOuv5ukuR5jr0BC.g73tgks4v67DOI2mDW', '2026-07-01 15:49:45', '2026-07-01 15:52:17');
INSERT INTO `students` VALUES (10, 'student009', 'student009@student.gsys.edu.ph', '$2y$12$fXf25iWfX9M3a6B61GVlyOryLw8Ul9n5Km1fnYVzp8Zx9ckEJ8i.K', '2026-07-01 15:49:46', '2026-07-01 15:52:17');
INSERT INTO `students` VALUES (11, 'student010', 'student010@student.gsys.edu.ph', '$2y$12$fadEoCJeW7XWv4X6OTZQHu/ykt.k8luiv9wmLqySn3H3c08BCBNA.', '2026-07-01 15:49:46', '2026-07-01 15:52:18');
INSERT INTO `students` VALUES (12, 'student011', 'student011@student.gsys.edu.ph', '$2y$12$YoXvhmX9044uMAGgTTaVkOv7Z4hgx.Zanlz.Ok7Vs3PPrERO9Unda', '2026-07-01 15:49:46', '2026-07-01 15:52:18');
INSERT INTO `students` VALUES (13, 'student012', 'student012@student.gsys.edu.ph', '$2y$12$lL9xE0OhGQtj/jzI0o/1KOMP0cZiUID8vEDqwTDWkFTBHs2Iaav5.', '2026-07-01 15:49:46', '2026-07-01 15:52:18');
INSERT INTO `students` VALUES (14, 'student013', 'student013@student.gsys.edu.ph', '$2y$12$cjxapg4FDNj3xo0jWvYJO.otNb29NvZ.IMhZyHWH9rK.XvwTT/HEK', '2026-07-01 15:49:47', '2026-07-01 15:52:18');
INSERT INTO `students` VALUES (15, 'student014', 'student014@student.gsys.edu.ph', '$2y$12$YGlsk95OTWxmqA8HFiPIwuJZl9EpjALyOGzzrZEBofoSAVwEI.mSm', '2026-07-01 15:49:47', '2026-07-01 15:52:19');
INSERT INTO `students` VALUES (16, 'student015', 'student015@student.gsys.edu.ph', '$2y$12$pBLhPYP8HK7IslDQp2CNweHx7.kX1s7eeCETHfNyTco9AwtGwEdB2', '2026-07-01 15:49:47', '2026-07-01 15:52:19');
INSERT INTO `students` VALUES (17, 'student016', 'student016@student.gsys.edu.ph', '$2y$12$vklZuXZr0uqAy6eIhJsW9O.U1GzGULLdARM947h0Kkd/n3BQqPAXq', '2026-07-01 15:49:47', '2026-07-01 15:52:19');
INSERT INTO `students` VALUES (18, 'student017', 'student017@student.gsys.edu.ph', '$2y$12$9cuNJJvW50lkl0EP7vG5fuwmBF2AzdnImSg9r8h17bb8fwdfcgLPa', '2026-07-01 15:49:48', '2026-07-01 15:52:20');
INSERT INTO `students` VALUES (19, 'student018', 'student018@student.gsys.edu.ph', '$2y$12$GWe0mH21x5Sk4yQdaWBEZOxxyckGLv10hIzPACGXoiQSqKI7D/EIO', '2026-07-01 15:49:48', '2026-07-01 15:52:20');
INSERT INTO `students` VALUES (20, 'student019', 'student019@student.gsys.edu.ph', '$2y$12$iquULDMSckkApn5doGOTPOo5Ra2rEVxrpkmjerro07LKbgObX.AUW', '2026-07-01 15:49:48', '2026-07-01 15:52:20');
INSERT INTO `students` VALUES (21, 'student020', 'student020@student.gsys.edu.ph', '$2y$12$x.lEle7dgNKP8ZR3Kd34AuCoBvgX9Mcp84CqivkHMnxWNwrvI9cUS', '2026-07-01 15:49:48', '2026-07-01 15:52:20');
INSERT INTO `students` VALUES (22, 'student021', 'student021@student.gsys.edu.ph', '$2y$12$QDn8jsE.MAaBwZPn1tzOZOyTFGZi6jbmqW.G/79eJvCUX18OSw0Oq', '2026-07-01 15:49:49', '2026-07-01 15:52:21');
INSERT INTO `students` VALUES (23, 'student022', 'student022@student.gsys.edu.ph', '$2y$12$.n.gFr/5WbAasTwO/HHbteefz3MlClMU3ge0CK3ELdR5MJtj5YA2O', '2026-07-01 15:49:49', '2026-07-01 15:52:21');
INSERT INTO `students` VALUES (24, 'student023', 'student023@student.gsys.edu.ph', '$2y$12$KNvG/bmsDLg7jjmS.Z61/u98yUh7VP/96JtvJBJ1n1jwRWWlUWF6y', '2026-07-01 15:49:49', '2026-07-01 15:52:22');
INSERT INTO `students` VALUES (25, 'student024', 'student024@student.gsys.edu.ph', '$2y$12$il2B9juOus7jV6Fbqp9HgOI90LGN95Xu/JuuF/F5XukW1/3w/vJCm', '2026-07-01 15:49:50', '2026-07-01 15:52:22');
INSERT INTO `students` VALUES (26, 'student025', 'student025@student.gsys.edu.ph', '$2y$12$VPiAL5W7tXc7aGZbJLnevu72mXJ7VIVR6giphapIpIf6HPl7wM4oe', '2026-07-01 15:49:50', '2026-07-01 15:52:22');
INSERT INTO `students` VALUES (27, 'student026', 'student026@student.gsys.edu.ph', '$2y$12$6UozcnsyrDA3Q5gTVIHak.yRboDc66SOsr2KkU7OUdFCXK9m8Q6.e', '2026-07-01 15:49:50', '2026-07-01 15:52:23');
INSERT INTO `students` VALUES (28, 'student027', 'student027@student.gsys.edu.ph', '$2y$12$UJReKd93MM5pKGDZfJZ4eeA8iUjoIGJaXrNiQ.iU7Akl38qHS.xT.', '2026-07-01 15:49:50', '2026-07-01 15:52:23');
INSERT INTO `students` VALUES (29, 'student028', 'student028@student.gsys.edu.ph', '$2y$12$H0aHCTJFfo78Iys4aFR2e.KIL5xFQMZx25tLJ2jDDsWcU9YG2h6pa', '2026-07-01 15:49:51', '2026-07-01 15:52:24');
INSERT INTO `students` VALUES (30, 'student029', 'student029@student.gsys.edu.ph', '$2y$12$/HGBPOLaE51GMTTXcf06Z.SX3dIjh89gTEiZP/uDWn4Qh5LbSjU7C', '2026-07-01 15:49:51', '2026-07-01 15:52:24');
INSERT INTO `students` VALUES (31, 'student030', 'student030@student.gsys.edu.ph', '$2y$12$qC4CRIUZUKBXaoM.vbMTiuqV6m7vrsQODCrxefC5aL52If9wGqOky', '2026-07-01 15:49:51', '2026-07-01 15:52:24');
INSERT INTO `students` VALUES (32, 'student031', 'student031@student.gsys.edu.ph', '$2y$12$hyeClzgJhJnvTrR/t4rx9OQGWhYbEaCxKwS2WdpqWhhs4mL2ocic.', '2026-07-01 15:49:51', '2026-07-01 15:52:24');
INSERT INTO `students` VALUES (33, 'student032', 'student032@student.gsys.edu.ph', '$2y$12$8s4BfA392QHfmN94Tpqxqeq0LQdnOPCXDEEykiOLICFeDJa/VFhWO', '2026-07-01 15:49:52', '2026-07-01 15:52:25');
INSERT INTO `students` VALUES (34, 'student033', 'student033@student.gsys.edu.ph', '$2y$12$Ub8TwZSBA0yubggaQOZsbO/HldroEhvr63hbYOGlVp6PKtJriEyBm', '2026-07-01 15:49:52', '2026-07-01 15:52:25');
INSERT INTO `students` VALUES (35, 'student034', 'student034@student.gsys.edu.ph', '$2y$12$suzJ1pkXdRZ.1vhMVBvt0eZ5Csn0t7ngXCMbfne0CWCCxV.BMAbie', '2026-07-01 15:49:52', '2026-07-01 15:52:26');
INSERT INTO `students` VALUES (36, 'student035', 'student035@student.gsys.edu.ph', '$2y$12$2Vm0padoxfqmBDesBTb.8etniyC07GGs8dstcEmTTQhH8gOl7Q6ra', '2026-07-01 15:49:52', '2026-07-01 15:52:26');
INSERT INTO `students` VALUES (37, 'student036', 'student036@student.gsys.edu.ph', '$2y$12$8/ifqgLK/0UVBly02r0SwuZTPU1em9250diZlu0YRq4/wRm9xiO.m', '2026-07-01 15:49:53', '2026-07-01 15:52:26');
INSERT INTO `students` VALUES (38, 'student037', 'student037@student.gsys.edu.ph', '$2y$12$wgWol98YJamvtX6zSliZSOJ9P3M.TDQuo1tWggJBCkeSJxSmxF9JW', '2026-07-01 15:49:53', '2026-07-01 15:52:27');
INSERT INTO `students` VALUES (39, 'student038', 'student038@student.gsys.edu.ph', '$2y$12$10GKr.wzKGiIdMkaJZqjSu8kbcUzqS3WS8ZDzcH/gSg8uyqSDsAR2', '2026-07-01 15:49:53', '2026-07-01 15:52:27');
INSERT INTO `students` VALUES (40, 'student039', 'student039@student.gsys.edu.ph', '$2y$12$7sSZ8VXJW5pkgpeS8YCaFe9XEM2pYyYcW8eIhGYE0DWcA.Kt5naA2', '2026-07-01 15:49:53', '2026-07-01 15:52:27');
INSERT INTO `students` VALUES (41, 'student040', 'student040@student.gsys.edu.ph', '$2y$12$4kl8SYF/Ljahi3j7wmpH2uQT03Z9lvSoUl6uQO.iNE2JORXDIZeeO', '2026-07-01 15:49:54', '2026-07-01 15:52:28');
INSERT INTO `students` VALUES (42, 'student041', 'student041@student.gsys.edu.ph', '$2y$12$KY.0tVfNo8AUPK8ag9IRvu15PGsbyRK/htkFplEMU9IAYQvpsniQm', '2026-07-01 15:49:54', '2026-07-01 15:52:28');
INSERT INTO `students` VALUES (43, 'student042', 'student042@student.gsys.edu.ph', '$2y$12$PJ2zRpwjoSbQHHu6dN1ipOx6JIYmAS2K1Tzcl76nS5C4/wHCjcpW2', '2026-07-01 15:49:54', '2026-07-01 15:52:29');
INSERT INTO `students` VALUES (44, 'student043', 'student043@student.gsys.edu.ph', '$2y$12$7k2OzkxRnrm0.cyzN1A3qu61Ew8.rGPV8g3AYGW1P1lJneLxdgspK', '2026-07-01 15:49:54', '2026-07-01 15:52:29');
INSERT INTO `students` VALUES (45, 'student044', 'student044@student.gsys.edu.ph', '$2y$12$7bQohOgMaP/PmlkJn93UNOIKlIcA5rafj6yXZWpfhw4dofaqHgUjm', '2026-07-01 15:49:55', '2026-07-01 15:52:29');
INSERT INTO `students` VALUES (46, 'student045', 'student045@student.gsys.edu.ph', '$2y$12$Iob4AF6EYJ0p1sEkDrXDMeIeXkoU345HR7PJahZLpOYYqktfj09OK', '2026-07-01 15:49:55', '2026-07-01 15:52:30');
INSERT INTO `students` VALUES (47, 'student046', 'student046@student.gsys.edu.ph', '$2y$12$AXrIgkdMAKl8VnADVpIfHOvszZAicrYkbvNL6OtLwXCaY/R6J3afi', '2026-07-01 15:49:55', '2026-07-01 15:52:30');
INSERT INTO `students` VALUES (48, 'student047', 'student047@student.gsys.edu.ph', '$2y$12$Nkk8DUMUoRs05TRaVrN6k.bI/jbkWFm47eHgP7cWpMyY0/qI8rAdG', '2026-07-01 15:49:56', '2026-07-01 15:52:30');
INSERT INTO `students` VALUES (49, 'student048', 'student048@student.gsys.edu.ph', '$2y$12$gdf3lPwnVITRvlV.jYMSouHLAEDfpuuHbMQUviFTREPkQy3h4RHKO', '2026-07-01 15:49:56', '2026-07-01 15:52:31');
INSERT INTO `students` VALUES (50, 'student049', 'student049@student.gsys.edu.ph', '$2y$12$/3FaZvZpGzt/M42kJynSSOMfNCuBAvRJYo2WX/7cugXYalGyGGrIS', '2026-07-01 15:49:56', '2026-07-01 15:52:31');
INSERT INTO `students` VALUES (51, 'student050', 'student050@student.gsys.edu.ph', '$2y$12$IMJALLbKbaqjc/nmYkApfeCwPx/GmTo0VpCm/w7wtWo/BJmg86cMu', '2026-07-01 15:49:56', '2026-07-01 15:52:31');
INSERT INTO `students` VALUES (52, 'student051', 'student051@student.gsys.edu.ph', '$2y$12$ePlHWP7xnYNzHDArWcuUz.xQI3aGPZKaDmIx4pre1L6KxCl4PCwFe', '2026-07-01 15:49:57', '2026-07-01 15:52:32');
INSERT INTO `students` VALUES (53, 'student052', 'student052@student.gsys.edu.ph', '$2y$12$hFpw6/cwcwEy.woRIsemDu5CWIYIMpVeHm6AQlXWuQwGSY2NHAWDG', '2026-07-01 15:49:57', '2026-07-01 15:52:32');
INSERT INTO `students` VALUES (54, 'student053', 'student053@student.gsys.edu.ph', '$2y$12$3alrwtdKejJiyWUOD7kjo.MkusVwwKCkJglzIpEsnWa/ZfJM/fhH6', '2026-07-01 15:49:57', '2026-07-01 15:52:33');
INSERT INTO `students` VALUES (55, 'student054', 'student054@student.gsys.edu.ph', '$2y$12$Hfeg6L1FO8Y4EfkyKqvmjuLhKgcIzt2kCX1YXIjvlXtP2EvVgxU2G', '2026-07-01 15:49:57', '2026-07-01 15:52:33');
INSERT INTO `students` VALUES (56, 'student055', 'student055@student.gsys.edu.ph', '$2y$12$34JXM.Xf5jy/RK.LW4R6eOGhKHG6KE1aq9GRGszCOnLSBsNARDGOm', '2026-07-01 15:49:58', '2026-07-01 15:52:33');
INSERT INTO `students` VALUES (57, 'student056', 'student056@student.gsys.edu.ph', '$2y$12$mitouYJI6SkV27hMcGiGP.2g.c/5wVS.5CkqUgfWYUUmhev8xFNRy', '2026-07-01 15:49:58', '2026-07-01 15:52:34');
INSERT INTO `students` VALUES (58, 'student057', 'student057@student.gsys.edu.ph', '$2y$12$PiyN2URpoGtD3UP8yRhBZe.UtsU9abosf2zVJje8i/HDYjA5DVn/2', '2026-07-01 15:49:58', '2026-07-01 15:52:34');
INSERT INTO `students` VALUES (59, 'student058', 'student058@student.gsys.edu.ph', '$2y$12$s1E5AUzezeJNOLhkZiay0u84H9Y/1wTfoCa5L85jysaggIWgAkwn6', '2026-07-01 15:49:58', '2026-07-01 15:52:34');
INSERT INTO `students` VALUES (60, 'student059', 'student059@student.gsys.edu.ph', '$2y$12$cGwBcLe0tQ.l7N.3hXO7HOT7jeDtBZTLqHQJnB1puNi526TXactRq', '2026-07-01 15:49:59', '2026-07-01 15:52:35');
INSERT INTO `students` VALUES (61, 'student060', 'student060@student.gsys.edu.ph', '$2y$12$lFpgiKr98lfcIDXpb7C22uiPB1gj7bXTFdXGhZyVydNjUOfUys8im', '2026-07-01 15:49:59', '2026-07-01 15:52:35');

-- ----------------------------
-- Table structure for subcat
-- ----------------------------
DROP TABLE IF EXISTS `subcat`;
CREATE TABLE `subcat`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcat
-- ----------------------------
INSERT INTO `subcat` VALUES (1, 'subcatsugad', '2026-06-02 06:37:16', '2026-06-02 06:37:16');
INSERT INTO `subcat` VALUES (2, 'fdgdfgfg', '2026-06-02 06:37:21', '2026-06-02 06:37:21');
INSERT INTO `subcat` VALUES (3, 'Core Subject', '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `subcat` VALUES (4, 'Applied Subject', '2026-07-01 15:48:17', '2026-07-01 15:48:17');
INSERT INTO `subcat` VALUES (5, 'Specialized Subject', '2026-07-01 15:48:17', '2026-07-01 15:48:17');

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `subcat_id` int NULL DEFAULT NULL,
  `teacher_id` int NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subject_teacher_id_index`(`teacher_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES (1, NULL, 1, 'asdsd', 'asd', '2026-06-02 06:28:56', '2026-06-02 15:39:46', NULL);
INSERT INTO `subject` VALUES (2, NULL, NULL, 'fdgdfg', NULL, '2026-06-02 06:56:34', '2026-06-02 06:56:34', NULL);
INSERT INTO `subject` VALUES (3, 1, 2, 'g11 math', 'Biochems', '2026-06-02 20:15:13', '2026-06-02 20:15:13', NULL);
INSERT INTO `subject` VALUES (4, 3, 1, 'Oral Communication', 'OCOM', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (5, 3, 2, 'Reading and Writing', 'RW', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (6, 3, 3, 'General Mathematics', 'GMATH', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (7, 3, 4, 'Statistics and Probability', 'STAT', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (8, 3, 5, 'Earth and Life Science', 'ELS', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (9, 3, 6, 'Physical Science', 'PSCI', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (10, 4, 7, 'Practical Research 1', 'PR1', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (11, 4, 8, 'Practical Research 2', 'PR2', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (12, 4, 9, 'Empowerment Technologies', 'ETECH', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (13, 4, 10, 'Entrepreneurship', 'ENTREP', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (14, 4, 11, 'Work Immersion', 'WI', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (15, 5, 12, 'Pre-Calculus', 'PRECAL', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (16, 5, 1, 'Basic Calculus', 'BCAL', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (17, 5, 2, 'General Biology 1', 'BIO1', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);
INSERT INTO `subject` VALUES (18, 5, 3, 'General Biology 2', 'BIO2', '2026-07-01 15:48:17', '2026-07-01 15:48:17', NULL);

-- ----------------------------
-- Table structure for teacherclass
-- ----------------------------
DROP TABLE IF EXISTS `teacherclass`;
CREATE TABLE `teacherclass`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL,
  `class_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teacherclass
-- ----------------------------
INSERT INTO `teacherclass` VALUES (1, 1, 5, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teacherclass` VALUES (2, 2, 6, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teacherclass` VALUES (3, 3, 7, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teacherclass` VALUES (4, 4, 8, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teacherclass` VALUES (5, 5, 9, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teacherclass` VALUES (6, 6, 10, '2026-07-01 15:52:06', '2026-07-01 15:52:06');

-- ----------------------------
-- Table structure for teachers
-- ----------------------------
DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teachers
-- ----------------------------
INSERT INTO `teachers` VALUES (1, 'jaycee', 'jaycee', 'jaycee@gmail.com', '$2y$12$oUu3PgjTim.HIItdnPqkPuVNW3sr2AU86gmMFDFt5krBkQsYoMBb6', '2026-06-02 09:20:29', '2026-06-02 09:20:29');
INSERT INTO `teachers` VALUES (2, 'roever', 'asdsd', 'rov@gmail.com', '$2y$12$9Lojq549cyAbAlf5F89aSOky.sadMBekMJAOCW/1BTPNJxDYEIQJK', '2026-06-02 20:13:46', '2026-06-02 20:13:46');
INSERT INTO `teachers` VALUES (3, 'Maria Santos', 'maria.santos', 'maria.santos@gsys.edu.ph', '$2y$12$yMCJtg2DGoUqxfsSV3fCl.PCZpI/7Q.Cgj9ldxkBmyUFi5hU7kOvm', '2026-07-01 15:48:14', '2026-07-01 15:52:03');
INSERT INTO `teachers` VALUES (4, 'Jose Reyes', 'jose.reyes', 'jose.reyes@gsys.edu.ph', '$2y$12$izvqrYSNy.SKmh1/XyeWPO/NyEdt7AvCY/2YV7QICJ1d.2bXYbJdS', '2026-07-01 15:48:15', '2026-07-01 15:52:04');
INSERT INTO `teachers` VALUES (5, 'Ana Cruz', 'ana.cruz', 'ana.cruz@gsys.edu.ph', '$2y$12$MFByA2ZYRIbX2n76oDd39Ojm2p/X3kBvTO5VmBxSfwdoBAi4/7iQi', '2026-07-01 15:48:15', '2026-07-01 15:52:04');
INSERT INTO `teachers` VALUES (6, 'Mark Dela Cruz', 'mark.delacruz', 'mark.delacruz@gsys.edu.ph', '$2y$12$eFib2mE4fvRuhKvY5Fqc3eD1oO.Ij59UnO.sxogGjGc2uNLxsnIiS', '2026-07-01 15:48:15', '2026-07-01 15:52:04');
INSERT INTO `teachers` VALUES (7, 'Liza Garcia', 'liza.garcia', 'liza.garcia@gsys.edu.ph', '$2y$12$lU7UZfh.VjuFxnlfecBBze/3NyzpOXzCn4M2hLfZNkIa.5Ku2t3BK', '2026-07-01 15:48:15', '2026-07-01 15:52:04');
INSERT INTO `teachers` VALUES (8, 'Ramon Mendoza', 'ramon.mendoza', 'ramon.mendoza@gsys.edu.ph', '$2y$12$Wz33aoOxKmal2Kp3iAx4l.4o1USv5MchnwPJt4f8lzRBEdDU.1l6.', '2026-07-01 15:48:16', '2026-07-01 15:52:05');
INSERT INTO `teachers` VALUES (9, 'Patricia Lopez', 'patricia.lopez', 'patricia.lopez@gsys.edu.ph', '$2y$12$HnudlyaeLw790BUJEASk7ej2tJeKTc/hSeaBjuOVKb8U5bIgi9KIm', '2026-07-01 15:48:16', '2026-07-01 15:52:05');
INSERT INTO `teachers` VALUES (10, 'Carlo Aquino', 'carlo.aquino', 'carlo.aquino@gsys.edu.ph', '$2y$12$ewgK8YjqG3NE6EyEQwq9k.sHhtE5aKpjEMedfqETCJEi3rkWiz07G', '2026-07-01 15:48:16', '2026-07-01 15:52:05');
INSERT INTO `teachers` VALUES (11, 'Jenny Flores', 'jenny.flores', 'jenny.flores@gsys.edu.ph', '$2y$12$Rn//MkJhaULzM.a5uBsQYe9gnm2na7.T1IGTLbzQabQOPtF4AMdjG', '2026-07-01 15:48:17', '2026-07-01 15:52:06');
INSERT INTO `teachers` VALUES (12, 'Edwin Navarro', 'edwin.navarro', 'edwin.navarro@gsys.edu.ph', '$2y$12$MZnAwL2AUKgYPodAXoJuCO9uFO8Oa/1In3UCrgkuqy9WaHKe8lru6', '2026-07-01 15:48:17', '2026-07-01 15:52:06');

-- ----------------------------
-- Table structure for teachersub
-- ----------------------------
DROP TABLE IF EXISTS `teachersub`;
CREATE TABLE `teachersub`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teachersub
-- ----------------------------
INSERT INTO `teachersub` VALUES (1, 1, 4, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (2, 2, 5, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (3, 3, 6, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (4, 4, 7, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (5, 5, 8, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (6, 6, 9, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (7, 7, 10, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (8, 8, 11, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (9, 9, 12, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (10, 10, 13, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (11, 11, 14, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (12, 12, 15, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (13, 1, 16, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (14, 2, 17, '2026-07-01 15:52:06', '2026-07-01 15:52:06');
INSERT INTO `teachersub` VALUES (15, 3, 18, '2026-07-01 15:52:06', '2026-07-01 15:52:06');

-- ----------------------------
-- Table structure for track
-- ----------------------------
DROP TABLE IF EXISTS `track`;
CREATE TABLE `track`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of track
-- ----------------------------
INSERT INTO `track` VALUES (1, 'stem', '2026-06-02 16:51:30', '2026-06-02 16:51:30');
INSERT INTO `track` VALUES (2, 'abm', '2026-06-02 16:51:35', '2026-06-02 16:51:41');
INSERT INTO `track` VALUES (3, 'HUMSS', '2026-06-02 16:51:55', '2026-06-02 16:51:55');
INSERT INTO `track` VALUES (4, 'gas', '2026-06-02 16:52:00', '2026-06-02 16:52:00');

-- ----------------------------
-- Table structure for tracksub
-- ----------------------------
DROP TABLE IF EXISTS `tracksub`;
CREATE TABLE `tracksub`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `track_id` int NOT NULL,
  `grlvl_id` int NULL DEFAULT NULL,
  `subject_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tracksub
-- ----------------------------
INSERT INTO `tracksub` VALUES (4, 1, NULL, 2, '2026-06-02 18:25:53', '2026-06-02 18:25:53');
INSERT INTO `tracksub` VALUES (5, 1, NULL, 1, '2026-06-02 18:25:53', '2026-06-02 18:25:53');
INSERT INTO `tracksub` VALUES (6, 1, 18, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (7, 1, 18, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (8, 1, 18, 8, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (9, 1, 18, 9, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (10, 1, 18, 15, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (11, 1, 18, 16, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (12, 1, 18, 17, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (13, 1, 18, 18, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (14, 2, 18, 6, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (15, 2, 18, 7, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (16, 2, 18, 13, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (17, 2, 18, 10, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (18, 2, 18, 11, '2026-07-01 15:48:48', '2026-07-01 15:48:48');
INSERT INTO `tracksub` VALUES (19, 2, 18, 14, '2026-07-01 15:48:48', '2026-07-01 15:48:48');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin@gmail.com', NULL, '$2y$12$UKtdiY3gmFAC9iLiIzFHPOav7Sub7qwF0DWTGpjaT56It8Eu3JJgy', NULL, '2026-06-01 07:29:50', '2026-07-01 15:52:03');

SET FOREIGN_KEY_CHECKS = 1;
