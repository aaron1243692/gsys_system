/*
 Navicat Premium Dump SQL

 Source Server         : newlocal
 Source Server Type    : MySQL
 Source Server Version : 90700 (9.7.0)
 Source Host           : localhost:3306
 Source Schema         : logbook

 Target Server Type    : MySQL
 Target Server Version : 90700 (9.7.0)
 File Encoding         : 65001

 Date: 05/06/2026 09:04:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for egate_logs
-- ----------------------------
DROP TABLE IF EXISTS `egate_logs`;
CREATE TABLE `egate_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `egate_data_id` bigint UNSIGNED NULL DEFAULT NULL,
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT 2,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `egate_logs_egate_data_id_foreign`(`egate_data_id` ASC) USING BTREE,
  CONSTRAINT `egate_logs_egate_data_id_foreign` FOREIGN KEY (`egate_data_id`) REFERENCES `egate_data` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 603 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
