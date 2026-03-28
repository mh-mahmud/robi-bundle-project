/*
SQLyog Community v11.12 Beta1 (32 bit)
MySQL - 5.5.27 : Database - bundle
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bundle` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bundle`;

/*Table structure for table `tbl_bundle_option` */

DROP TABLE IF EXISTS `tbl_bundle_option`;

CREATE TABLE `tbl_bundle_option` (
  `OPTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `OPTION_VALUE` varchar(50) NOT NULL,
  `GROUP_NAME` varchar(50) NOT NULL,
  `PARENT_ID` int(11) DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`OPTION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_permission` */

DROP TABLE IF EXISTS `tbl_bundle_permission`;

CREATE TABLE `tbl_bundle_permission` (
  `PERMISSION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERMISSION_NAME` varchar(100) NOT NULL COMMENT 'example: create order, edit PI, Create User etc',
  `DETAILS` varchar(250) DEFAULT NULL,
  `GROUP_NAME` varchar(200) DEFAULT NULL,
  `MENU_NAME` varchar(50) NOT NULL,
  `ROUTE_NAME` varchar(100) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | -5=Taking out | -6=Renewed/Replaced | -7=Inactive',
  PRIMARY KEY (`PERMISSION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_role` */

DROP TABLE IF EXISTS `tbl_bundle_role`;

CREATE TABLE `tbl_bundle_role` (
  `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(100) NOT NULL,
  `DETAILS` varchar(255) DEFAULT NULL,
  `PERMISSION_NAME` text NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | -5=Taking out | -6=Renewed/Replaced | -7=Inactive',
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_user` */

DROP TABLE IF EXISTS `tbl_bundle_user`;

CREATE TABLE `tbl_bundle_user` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_ID` int(11) DEFAULT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `USER_EMAIL` varchar(50) NOT NULL,
  `USER_PHONE` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(50) NOT NULL,
  `USER_PASSWORD_HISTORY` varchar(250) DEFAULT NULL,
  `USER_CREATED_DATE` datetime DEFAULT NULL,
  `USER_UPDATED_DATE` datetime DEFAULT NULL,
  `USER_STATUS` tinyint(4) NOT NULL COMMENT '1=active | -1=inactive',
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
