/*
SQLyog Community v11.12 Beta1 (32 bit)
MySQL - 5.5.37 : Database - bundle
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

/*Table structure for table `TBL_BUNDLE` */

DROP TABLE IF EXISTS `TBL_BUNDLE`;

CREATE TABLE `TBL_BUNDLE` (
  `BUNDLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BUNDLE_NAME` varchar(100) NOT NULL,
  `GL_CODE` varchar(50) DEFAULT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATEDBY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`BUNDLE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `TBL_BUNDLE` */

/*Table structure for table `TBL_BUNDLE_ITEM` */

DROP TABLE IF EXISTS `TBL_BUNDLE_ITEM`;

CREATE TABLE `TBL_BUNDLE_ITEM` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BUNDLE_ID` int(11) NOT NULL,
  `OPTION_ID` int(11) NOT NULL COMMENT 'bundle item id (from option)',
  `OPTION_VALUE` varchar(50) NOT NULL COMMENT 'bundle item name',
  `UNIT_ID` int(11) NOT NULL,
  `UNIT_NAME` varchar(50) NOT NULL,
  `TYPE` varchar(50) NOT NULL COMMENT 'once/loop - loop means it can be charged at multiple duration',
  `QUANTITY` int(11) NOT NULL,
  `UNIT_PRICE` float NOT NULL,
  `SUB_GL` varchar(50) DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `TBL_BUNDLE_ITEM` */

/*Table structure for table `TBL_BUNDLE_OPTION` */

DROP TABLE IF EXISTS `TBL_BUNDLE_OPTION`;

CREATE TABLE `TBL_BUNDLE_OPTION` (
  `OPTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `OPTION_VALUE` varchar(50) NOT NULL,
  `GROUP_NAME` varchar(50) NOT NULL,
  `PARENT_ID` int(11) DEFAULT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`OPTION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `TBL_BUNDLE_OPTION` */

insert  into `TBL_BUNDLE_OPTION`(`OPTION_ID`,`OPTION_VALUE`,`GROUP_NAME`,`PARENT_ID`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'device','bundle_item',NULL,1,'2015-09-15 11:07:19',NULL,NULL,7),(2,'internet data (off net)','bundle_item',NULL,1,'2015-09-15 11:08:56',NULL,NULL,7),(3,'internet data (on net)','bundle_item',NULL,1,'2015-09-15 11:09:31',1,'2015-09-15 11:12:09',7),(4,'pcs','unit_name',NULL,1,'2015-09-15 11:21:34',NULL,NULL,7),(5,'MB','unit_name',NULL,1,'2015-09-15 11:21:44',NULL,NULL,7);

/*Table structure for table `TBL_BUNDLE_PERMISSION` */

DROP TABLE IF EXISTS `TBL_BUNDLE_PERMISSION`;

CREATE TABLE `TBL_BUNDLE_PERMISSION` (
  `PERMISSION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERMISSION_NAME` varchar(100) NOT NULL COMMENT 'example: create order, edit PI, Create User etc',
  `DETAILS` varchar(250) DEFAULT NULL,
  `GROUP_NAME` varchar(200) DEFAULT NULL,
  `MENU_NAME` varchar(50) NOT NULL,
  `ROUTE_NAME` varchar(100) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | -5=Taking out | -6=Renewed/Replaced | -7=Inactive',
  PRIMARY KEY (`PERMISSION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `TBL_BUNDLE_PERMISSION` */

insert  into `TBL_BUNDLE_PERMISSION`(`PERMISSION_ID`,`PERMISSION_NAME`,`DETAILS`,`GROUP_NAME`,`MENU_NAME`,`ROUTE_NAME`,`PARENT_ID`,`STATUS`) values (13,'create_user',NULL,'user','create_user','create_user',0,1),(14,'manage_user',NULL,'user','manage_user','manage_user',0,1),(15,'create_role',NULL,'user','create_role','create_role',0,1),(16,'manage_role',NULL,'user','manage_role','manage_role',0,1),(18,'create_option',NULL,'configuration','create_option','create_option',0,1),(19,'manage_option',NULL,'configuration','manage_option','manage_option',0,1),(20,'create_bundle',NULL,'bundle','create_bundle','create_bundle',0,1),(21,'manage_bundle',NULL,'bundle','manage_bundle','manage_bundle',0,1),(22,'upload_sale_individual',NULL,'bundle','upload_sale_individual','upload_sale_individual',0,1),(23,'upload_sale_batch',NULL,'bundle','upload_sale_batch','upload_sale_batch',0,1),(24,'manage_sale',NULL,'bundle','manage_sale','manage_sale',0,1);

/*Table structure for table `TBL_BUNDLE_ROLE` */

DROP TABLE IF EXISTS `TBL_BUNDLE_ROLE`;

CREATE TABLE `TBL_BUNDLE_ROLE` (
  `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(100) NOT NULL,
  `DETAILS` varchar(255) DEFAULT NULL,
  `PERMISSION_NAME` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | -5=Taking out | -6=Renewed/Replaced | -7=Inactive',
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `TBL_BUNDLE_ROLE` */

insert  into `TBL_BUNDLE_ROLE`(`ROLE_ID`,`ROLE_NAME`,`DETAILS`,`PERMISSION_NAME`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'general',NULL,'create_role',9,'0000-00-00 00:00:00',9,'2015-09-14 06:25:51',7),(2,'user management',NULL,'create_role,manage_role',9,'2015-09-14 02:55:21',9,'2015-09-14 06:25:19',7);

/*Table structure for table `TBL_BUNDLE_USER` */

DROP TABLE IF EXISTS `TBL_BUNDLE_USER`;

CREATE TABLE `TBL_BUNDLE_USER` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_ID` int(11) DEFAULT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `USER_EMAIL` varchar(50) NOT NULL,
  `USER_PHONE` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(50) NOT NULL,
  `USER_PASSWORD_HISTORY` text,
  `CREATED_BY` int(11) DEFAULT NULL,
  `CREATED_DATE` datetime DEFAULT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=active | -1=inactive',
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `TBL_BUNDLE_USER` */

insert  into `TBL_BUNDLE_USER`(`USER_ID`,`ROLE_ID`,`USER_NAME`,`USER_EMAIL`,`USER_PHONE`,`USER_PASSWORD`,`USER_PASSWORD_HISTORY`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,0,'admin','golam.mohiuddin1@nns-solution.net','1234567890','l0y7QkzEyLXkyLLL_BEuJVjUterSeR98qEDwMa1y0TI%2C',NULL,NULL,'2015-09-13 12:06:23',NULL,NULL,9),(9,2,'Mohiuddin','golam.mohiuddin@nns-solution.net','01847 133060','xJBZIZflrZxyB1ZOSigSAF9IpB800Ojo7C7Qja5hCXs%2C','xJBZIZflrZxyB1ZOSigSAF9IpB800Ojo7C7Qja5hCXs%2C,Qj6Wu4y0eVKfDrncmVndYZKd5UO1dvIrTv1CrVjpyL8%2C',NULL,'2015-09-14 12:53:22',1,'2015-09-14 06:01:07',7);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
