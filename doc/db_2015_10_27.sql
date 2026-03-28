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

/*Table structure for table `tbl_bundle` */

DROP TABLE IF EXISTS `tbl_bundle`;

CREATE TABLE `tbl_bundle` (
  `BUNDLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUBSCRIBERS_BASE` varchar(100) NOT NULL COMMENT 'postpaid/prepaid',
  `MATERIAL_CODE` varchar(50) NOT NULL,
  `MATERIAL_NAME` varchar(200) NOT NULL,
  `MRP` float NOT NULL,
  `TYPE` varchar(50) NOT NULL COMMENT 'emi/in_cash/credit card',
  `EMI_MONTH` int(11) DEFAULT '0' COMMENT 'only for emi',
  `EMI_INTEREST` float DEFAULT '0' COMMENT 'at percent',
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`BUNDLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_forecast` */

DROP TABLE IF EXISTS `tbl_bundle_forecast`;

CREATE TABLE `tbl_bundle_forecast` (
  `BUNDLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUBSCRIBERS_BASE` varchar(100) NOT NULL COMMENT 'postpaid/prepaid',
  `MATERIAL_CODE` varchar(50) NOT NULL,
  `MATERIAL_NAME` varchar(200) NOT NULL,
  `MRP` float NOT NULL,
  `TYPE` varchar(50) NOT NULL COMMENT 'emi/in_cash/credit card',
  `EMI_MONTH` int(11) DEFAULT '0' COMMENT 'only for emi',
  `EMI_INTEREST` float DEFAULT '0' COMMENT 'at percent',
  `SALE_DATE` datetime NOT NULL,
  `SALE_QUANTITY` int(11) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`BUNDLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_item` */

DROP TABLE IF EXISTS `tbl_bundle_item`;

CREATE TABLE `tbl_bundle_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BUNDLE_ID` int(11) NOT NULL,
  `SERVICE_ID` int(11) NOT NULL COMMENT 'bundle item id (from option)',
  `TYPE` varchar(50) NOT NULL COMMENT 'once/loop - loop means it can be charged at multiple duration',
  `LOOP_DAYS` int(11) DEFAULT NULL COMMENT 'value as month - only for type=loop',
  `QUANTITY` int(11) NOT NULL,
  `UNIT_PRICE` float DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_item_forecast` */

DROP TABLE IF EXISTS `tbl_bundle_item_forecast`;

CREATE TABLE `tbl_bundle_item_forecast` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BUNDLE_ID` int(11) NOT NULL,
  `SERVICE_ID` int(11) NOT NULL COMMENT 'bundle item id (from option)',
  `TYPE` varchar(50) NOT NULL COMMENT 'once/loop - loop means it can be charged at multiple duration',
  `LOOP_DAYS` int(11) DEFAULT NULL COMMENT 'value as month - only for type=loop',
  `QUANTITY` int(11) NOT NULL,
  `UNIT_PRICE` float DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_option` */

DROP TABLE IF EXISTS `tbl_bundle_option`;

CREATE TABLE `tbl_bundle_option` (
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_permission` */

DROP TABLE IF EXISTS `tbl_bundle_permission`;

CREATE TABLE `tbl_bundle_permission` (
  `PERMISSION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERMISSION_NAME` varchar(100) NOT NULL COMMENT 'example: create order, edit PI, Create User etc',
  `DETAILS` varchar(250) DEFAULT NULL,
  `GROUP_NAME` varchar(200) DEFAULT NULL,
  `MENU_NAME` varchar(200) NOT NULL,
  `ROUTE_NAME` varchar(100) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | -5=Taking out | -6=Renewed/Replaced | -7=Inactive',
  PRIMARY KEY (`PERMISSION_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_role` */

DROP TABLE IF EXISTS `tbl_bundle_role`;

CREATE TABLE `tbl_bundle_role` (
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

/*Table structure for table `tbl_bundle_sale` */

DROP TABLE IF EXISTS `tbl_bundle_sale`;

CREATE TABLE `tbl_bundle_sale` (
  `SALE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BUNDLE_ID` int(11) NOT NULL,
  `INVOICE_DATE` datetime NOT NULL,
  `SOLD_TO_PARTY` varchar(50) DEFAULT NULL,
  `CHANNEL` varchar(50) DEFAULT NULL,
  `CUST_NAME` varchar(200) DEFAULT NULL,
  `MATERIAL_CODE` varchar(100) NOT NULL,
  `INVOICE_NO` varchar(50) DEFAULT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `QUANTITY` int(11) NOT NULL,
  `GROSS_VALUE` double NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`SALE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_sale_file` */

DROP TABLE IF EXISTS `tbl_bundle_sale_file`;

CREATE TABLE `tbl_bundle_sale_file` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FILE_NAME` varchar(200) NOT NULL,
  `UPLOAD_BY` int(11) NOT NULL,
  `UPLOAD_DATE` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_service` */

DROP TABLE IF EXISTS `tbl_bundle_service`;

CREATE TABLE `tbl_bundle_service` (
  `SERVICE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SERVICE_NAME` varchar(100) NOT NULL,
  `UNIT` varchar(20) NOT NULL,
  `UNIT_PRICE` float NOT NULL,
  `PRICE_TYPE` varchar(50) DEFAULT NULL COMMENT 'NC (Network Cost)/Average',
  `GL_CODE` varchar(50) NOT NULL,
  `VAT_APPLICABLE` varchar(10) DEFAULT NULL COMMENT 'yes/no',
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`SERVICE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_user` */

DROP TABLE IF EXISTS `tbl_bundle_user`;

CREATE TABLE `tbl_bundle_user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
