/*
SQLyog Community v11.11 (32 bit)
MySQL - 5.7.9 : Database - eletters
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`eletters` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `eletters`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL COMMENT 'Session Sistem',
  `status_online` varchar(255) NOT NULL DEFAULT 'OFFLINE' COMMENT 'Status Online',
  `account_status` varchar(255) NOT NULL DEFAULT 'AKTIF' COMMENT 'Akaun Status',
  `user_role` varchar(255) NOT NULL DEFAULT 'user',
  `nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`user_id`,`pwd`,`session_id`,`status_online`,`account_status`,`user_role`,`nama`) values (1,'admin','DB777E4E7DE0B102F961AC8642735AC5','','OFFLINE','AKTIF','admin','Administrator');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
