# Host: localhost  (Version: 5.5.53)
# Date: 2018-05-10 14:00:32
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "message"
#

CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(2) unsigned NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name` varchar(100) NOT NULL,
  `msgbody` text NOT NULL,
  `createdAt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;
