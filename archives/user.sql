# Host: localhost  (Version: 5.5.53)
# Date: 2018-05-10 14:00:08
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "user"
#

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` text NOT NULL,
  `password` varchar(60) NOT NULL,
  `eiv` tinyint(1) NOT NULL DEFAULT '0',
  `role` int(10) unsigned NOT NULL DEFAULT '99',
  `authKey` varchar(200) NOT NULL,
  `accessToken` varchar(200) DEFAULT NULL,
  `createdAt` bigint(13) NOT NULL COMMENT '13 digital timestamp',
  `updatedAt` bigint(13) NOT NULL COMMENT '13 digital timestamp',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='user';
