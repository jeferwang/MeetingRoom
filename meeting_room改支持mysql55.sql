/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50714
Source Host           : 127.0.0.1:3306
Source Database       : meeting_room

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-05-21 16:29:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '$2y$10$vtuCiq7CoziX0o6HeLzCN.OWbye4F9Xm4N6jVYsEy.QG63nBUA1je', null, '2017-05-20 15:01:16');

-- ----------------------------
-- Table structure for applies
-- ----------------------------
DROP TABLE IF EXISTS `applies`;
CREATE TABLE `applies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` int(11) DEFAULT NULL,
  `weeknum` int(11) DEFAULT NULL,
  `week` int(11) DEFAULT NULL,
  `meeting_time` int(11) DEFAULT NULL,
  `room_id` int(11) NOT NULL COMMENT '申请的会议室ID',
  `people_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT '预约者姓名',
  `people_tel` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系方式',
  `meeting_title` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT '会议标题',
  `meeting_description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '会议概要',
  `pass` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否通过申请',
  `reason` text COLLATE utf8_unicode_ci COMMENT '不通过的原因',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of applies
-- ----------------------------
INSERT INTO `applies` VALUES ('43', '14', '14', '5', '3', '15', 'name2', '17638916666', 'title2', 'des2', '0', null, '2017-05-20 22:26:15', '2017-05-20 22:26:15');
INSERT INTO `applies` VALUES ('42', '14', '1', '1', '1', '20', 'name', '17638916666', 'title', 'des', '0', null, '2017-05-20 22:18:01', '2017-05-20 22:18:01');
INSERT INTO `applies` VALUES ('44', '14', '14', '1', '1', '15', '奶香萌男', '66666666666', '和程龙写代码', '写个卵', '0', null, '2017-05-20 22:58:00', '2017-05-20 22:58:00');
INSERT INTO `applies` VALUES ('45', '14', '13', '1', '1', '15', '奶香萌男', '66666666666', '和程龙写代码', '写个卵', '0', null, '2017-05-20 23:38:51', '2017-05-20 23:38:51');
INSERT INTO `applies` VALUES ('46', '14', '13', '2', '1', '20', '奶香萌男', '66666666666', '和程龙写代码', '写个卵', '2', 'no', '2017-05-20 23:42:08', '2017-05-21 14:00:35');
INSERT INTO `applies` VALUES ('47', '14', '13', '3', '5', '16', 'wxj', '17638916666', '写代码', '就是写代码', '1', null, '2017-05-20 23:42:52', '2017-05-21 13:59:57');
INSERT INTO `applies` VALUES ('48', '14', '13', '2', '1', '20', 'wxj', '17638916666', '开会', '开会开会', '1', null, '2017-05-21 14:05:55', '2017-05-21 14:11:13');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2017_04_05_102332_create_admins_table', '1');
INSERT INTO `migrations` VALUES ('4', '2017_04_06_140657_create_rooms_table', '2');
INSERT INTO `migrations` VALUES ('6', '2017_04_08_173508_create_applies_table', '3');
INSERT INTO `migrations` VALUES ('7', '2017_04_11_154330_create_notices_table', '4');
INSERT INTO `migrations` VALUES ('8', '2017_04_17_163722_create_terms_table', '5');
INSERT INTO `migrations` VALUES ('9', '2017_05_21_131030_create_tips_table', '6');

-- ----------------------------
-- Table structure for notices
-- ----------------------------
DROP TABLE IF EXISTS `notices`;
CREATE TABLE `notices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '公告标题',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '公告内容',
  `theme` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT '公告主题颜色',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of notices
-- ----------------------------
INSERT INTO `notices` VALUES ('3', '提示111', '<p>提示111</p>', 'warning', '2017-04-12 16:20:36', '2017-04-14 13:16:27');
INSERT INTO `notices` VALUES ('4', '提示222', '<p>提示222</p>', 'info', '2017-04-12 16:20:44', '2017-04-14 13:17:19');
INSERT INTO `notices` VALUES ('5', '最新的公告', '<p>来来来,发一篇最新的公告</p>', 'danger', '2017-04-12 16:20:47', '2017-04-14 16:03:29');
INSERT INTO `notices` VALUES ('7', 'HPU会议室预约系统开放使用啦', '<p>经过近一周的开发工作,会议室预约系统已经接近收尾工作,稍后即可正常使用<br/></p>', 'info', '2017-05-20 15:04:19', '2017-05-20 15:04:19');

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '会议室名称',
  `address` text COLLATE utf8_unicode_ci COMMENT '会议室地点',
  `description` text COLLATE utf8_unicode_ci COMMENT '会议室简介',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES ('20', '行政楼一楼会议室', '力行楼方形会议室呵呵', '呵呵呵呵666', '2017-04-06 15:23:08', '2017-05-19 16:08:28');
INSERT INTO `rooms` VALUES ('12', '行政楼二楼会议室', '力行楼方形会议室呵呵', '呵呵呵呵666', '2017-04-06 15:23:08', '2017-04-07 06:29:00');
INSERT INTO `rooms` VALUES ('13', '力行楼方形会议室', '力行楼方形会议室呵呵', '呵呵呵呵666', '2017-04-06 15:23:08', '2017-04-07 06:29:00');
INSERT INTO `rooms` VALUES ('14', '力行楼学术报告厅', '力行楼方形会议室呵呵', '呵呵呵呵666', '2017-04-06 15:23:08', '2017-04-07 06:29:00');
INSERT INTO `rooms` VALUES ('15', '明德楼一楼会议室', '学术报告厅', '学术报告', '2017-04-06 15:23:20', '2017-04-06 15:23:20');
INSERT INTO `rooms` VALUES ('16', '明德楼音乐厅', '力行楼方形会议室呵呵', '呵呵呵呵666', '2017-04-06 15:23:08', '2017-04-07 06:29:00');

-- ----------------------------
-- Table structure for terms
-- ----------------------------
DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `termName` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT '学期名称',
  `startTime` int(11) NOT NULL COMMENT '开始日期',
  `deleted_at` datetime DEFAULT NULL ,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of terms
-- ----------------------------
INSERT INTO `terms` VALUES ('14', '2017第一学期', '1487520000', null, '2017-04-18 22:36:53', '2017-04-18 22:36:53');
INSERT INTO `terms` VALUES ('16', '2017第二学期', '1505059200', null, '2017-05-20 16:50:10', '2017-05-20 16:51:52');

-- ----------------------------
-- Table structure for tips
-- ----------------------------
DROP TABLE IF EXISTS `tips`;
CREATE TABLE `tips` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '主要内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tips
-- ----------------------------
INSERT INTO `tips` VALUES ('1', '请合理使用会议室预约系统', '2017-05-21 13:50:08', '2017-05-21 13:57:21');
SET FOREIGN_KEY_CHECKS=1;
