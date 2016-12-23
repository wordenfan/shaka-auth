# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.49-0ubuntu0.14.04.1)
# Database: shaka
# Generation Time: 2016-12-21 04:20:15 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table permission_func
# ------------------------------------------------------------

CREATE TABLE `permission_func` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '功能函数id',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(10) unsigned NOT NULL COMMENT '父菜单id',
  `m` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '模块',
  `c` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类文件',
  `a` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '函数',
  `intro` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '说明',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示1显示0不显示',
  `is_js` int(11) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table permission_menu
# ------------------------------------------------------------

CREATE TABLE `permission_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单文字内容',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '链接地址',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `pid` int(10) unsigned NOT NULL COMMENT '父菜单id',
  `level` int(10) unsigned NOT NULL COMMENT '显示级别',
  `sort` int(10) unsigned NOT NULL COMMENT '同级中显示的排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table permission_role
# ------------------------------------------------------------

CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table permissions
# ------------------------------------------------------------

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(10) unsigned NOT NULL,
  `ref_id` int(10) unsigned NOT NULL,
  `intro` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table role_user
# ------------------------------------------------------------

CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table roles
# ------------------------------------------------------------

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
  `leader_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该员工领导的ID',
  `mobile` varchar(15) NOT NULL COMMENT '座机或者手机',
  `sms_code` char(6) NOT NULL DEFAULT '',
  `sms_time` double NOT NULL DEFAULT '0',
  `identity` char(20) NOT NULL DEFAULT '' COMMENT '身份证件号',
  `identity_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '身份证件类型, 身份证/护照等',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `icon_url` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(20) NOT NULL DEFAULT '' COMMENT '绑定邮箱',
  `password` varchar(255) NOT NULL DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  `role` int(10) unsigned NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL COMMENT '存储session',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '微信OPENID',
  `wechat_info` text NOT NULL COMMENT '微信用户信息',
  `api_token` varchar(100) NOT NULL DEFAULT '' COMMENT '存储token, 将来要用jwt',
  `relation` varchar(10) NOT NULL DEFAULT '' COMMENT '手机号所有人与该用户的关系,比如本人/父子',
  `remark_name` varchar(20) NOT NULL DEFAULT '' COMMENT '备注姓名',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_api_token_unique` (`api_token`),
  KEY `users_name_index` (`name`(191)),
  KEY `users_username_index` (`username`(191)),
  KEY `users_mobile_index` (`mobile`),
  KEY `users_mobile_status_index` (`mobile`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
