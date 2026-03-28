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

/*Data for the table `tbl_bundle` */

insert  into `tbl_bundle`(`BUNDLE_ID`,`SUBSCRIBERS_BASE`,`MATERIAL_CODE`,`MATERIAL_NAME`,`MRP`,`TYPE`,`EMI_MONTH`,`EMI_INTEREST`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (4,'pre_paid','20000036','Samsung ACE Next Campaign',8900,'in_cash',0,0,1,'2015-09-30 11:30:29',1,'2015-09-30 11:30:57',2),(5,'pre_paid','20000051','iPhone 6 &amp; iPhone 6 plus campaign',3999,'emi',24,14,1,'2015-10-08 03:34:24',1,'2015-10-08 03:43:57',2);

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

/*Data for the table `tbl_bundle_forecast` */

insert  into `tbl_bundle_forecast`(`BUNDLE_ID`,`SUBSCRIBERS_BASE`,`MATERIAL_CODE`,`MATERIAL_NAME`,`MRP`,`TYPE`,`EMI_MONTH`,`EMI_INTEREST`,`SALE_DATE`,`SALE_QUANTITY`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'pre_paid','20000051','iPhone 6 &amp; iPhone 6 plus campaign',3999,'emi',24,14,'2015-10-20 00:00:00',1,1,'2015-10-20 03:08:52',NULL,NULL,7);

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

/*Data for the table `tbl_bundle_item` */

insert  into `tbl_bundle_item`(`ID`,`BUNDLE_ID`,`SERVICE_ID`,`TYPE`,`LOOP_DAYS`,`QUANTITY`,`UNIT_PRICE`,`STATUS`) values (8,4,1,'once',0,1,7500,7),(9,4,2,'loop',90,3300,0.11,7),(10,4,3,'loop',90,675,0.14,7),(11,4,4,'loop',90,15360,0.22,7),(12,5,7,'once',0,1,70377,7),(13,5,2,'loop',0,750,0.12,7),(14,5,3,'loop',0,750,0.14,7),(15,5,4,'loop',0,2048,0.24,7);

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

/*Data for the table `tbl_bundle_item_forecast` */

insert  into `tbl_bundle_item_forecast`(`ID`,`BUNDLE_ID`,`SERVICE_ID`,`TYPE`,`LOOP_DAYS`,`QUANTITY`,`UNIT_PRICE`,`STATUS`) values (1,1,7,'once',0,1,70377,7),(2,1,2,'loop',0,750,0.12,7),(3,1,3,'loop',0,750,0.14,7),(4,1,4,'loop',0,2048,0.24,7);

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

/*Data for the table `tbl_bundle_option` */

insert  into `tbl_bundle_option`(`OPTION_ID`,`OPTION_VALUE`,`GROUP_NAME`,`PARENT_ID`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (4,'pcs','unit_name',NULL,1,'2015-09-15 11:21:34',NULL,NULL,7),(5,'MB','unit_name',NULL,1,'2015-09-15 11:21:44',NULL,NULL,7),(6,'minutes','unit_name',NULL,1,'2015-09-20 11:16:23',1,'2015-09-21 10:51:20',7),(8,'Count','unit_name',NULL,1,'2015-10-02 12:46:03',1,'2015-10-21 06:53:23',7),(10,'3','SD',NULL,0,'0000-00-00 00:00:00',NULL,NULL,7),(11,'15','VAT',NULL,0,'0000-00-00 00:00:00',NULL,NULL,7);

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_bundle_permission` */

insert  into `tbl_bundle_permission`(`PERMISSION_ID`,`PERMISSION_NAME`,`DETAILS`,`GROUP_NAME`,`MENU_NAME`,`ROUTE_NAME`,`PARENT_ID`,`STATUS`) values (13,'create_user',NULL,'user','create_user','create_user',0,1),(14,'manage_user',NULL,'user','manage_user','manage_user',0,1),(15,'create_role',NULL,'user','create_role','create_role',0,1),(16,'manage_role',NULL,'user','manage_role','manage_role',0,1),(18,'create_option',NULL,'configuration','create_option','create_option',0,1),(19,'manage_option',NULL,'configuration','manage_option','manage_option',0,1),(20,'create_bundle',NULL,'bundle','create_bundle','create_bundle',0,1),(21,'manage_bundle',NULL,'bundle','manage_bundle','manage_bundle',0,1),(22,'upload_sale_individual',NULL,'bundle','upload_sale_individual','upload_sale_individual',0,1),(23,'upload_sale_batch',NULL,'bundle','upload_sale_batch','upload_sale_batch',0,1),(24,'manage_sale',NULL,'bundle','manage_sale','manage_sale',0,1),(25,'approve_bundle',NULL,'bundle','manage_bundle','manage_bundle',0,1),(26,'fv_allocation',NULL,'report','fv_allocation','fv_allocation',0,1),(28,'create_service',NULL,'configuration','create_service','create_service',0,1),(29,'manage_service',NULL,'configuration','manage_service','manage_service',0,1),(30,'summary_jv',NULL,'report','summary_jv','summary_jv',0,1),(31,'fv_deferment',NULL,'report','fv_deferment','fv_deferment',0,1),(32,'fv_summery',NULL,'report','fv_summery','fv_summery',0,1),(33,'individual_jv',NULL,'report','individual_jv','individual_jv',0,1),(34,'fv_deferment_summery',NULL,'report','fv_deferment_summery','fv_deferment_summery',0,1),(35,'create_bundle_forecast',NULL,'forecast','create_bundle_forecast','create_bundle_forecast',0,1),(36,'manage_bundle_forecast',NULL,'forecast','print_forecast','print_bundle_forecast',0,1),(37,'manage_bundle_forecast',NULL,'forecast','export_forecast','bundle_forecast/export',0,1);

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

/*Data for the table `tbl_bundle_role` */

insert  into `tbl_bundle_role`(`ROLE_ID`,`ROLE_NAME`,`DETAILS`,`PERMISSION_NAME`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'general',NULL,'create_role',9,'0000-00-00 00:00:00',9,'2015-09-14 06:25:51',7),(2,'user management',NULL,'create_bundle,create_role,manage_role',9,'2015-09-14 02:55:21',1,'2015-09-20 11:48:26',7);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_bundle_sale` */

insert  into `tbl_bundle_sale`(`SALE_ID`,`BUNDLE_ID`,`INVOICE_DATE`,`SOLD_TO_PARTY`,`CHANNEL`,`CUST_NAME`,`MATERIAL_CODE`,`INVOICE_NO`,`DESCRIPTION`,`QUANTITY`,`GROSS_VALUE`,`CREATED_BY`,`CREATED_DATE`,`STATUS`) values (4,5,'2015-10-21 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',1,80000,2,'2015-10-04 06:22:02',8),(5,5,'2015-10-20 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',1,80000,2,'2015-10-04 06:22:02',7),(6,4,'2015-10-20 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',2,80000,2,'2015-10-04 06:22:02',7);

/*Table structure for table `tbl_bundle_sale_copy` */

DROP TABLE IF EXISTS `tbl_bundle_sale_copy`;

CREATE TABLE `tbl_bundle_sale_copy` (
  `SALE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BUNDLE_ID` int(11) NOT NULL,
  `INVOICE_DATE` datetime NOT NULL,
  `SOLD_TO_PARTY` varchar(50) DEFAULT NULL,
  `CHANNEL` varchar(50) DEFAULT NULL,
  `MATERIAL_CODE` varchar(100) NOT NULL,
  `INVOICE_NO` varchar(50) DEFAULT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `QUANTITY` int(11) NOT NULL,
  `GROSS_VALUE` double NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `STATUS` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`SALE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_bundle_sale_copy` */

insert  into `tbl_bundle_sale_copy`(`SALE_ID`,`BUNDLE_ID`,`INVOICE_DATE`,`SOLD_TO_PARTY`,`CHANNEL`,`MATERIAL_CODE`,`INVOICE_NO`,`DESCRIPTION`,`QUANTITY`,`GROSS_VALUE`,`CREATED_BY`,`CREATED_DATE`,`STATUS`) values (1,3,'2015-09-17 00:00:00','50144','WIC/CCC','20000031','92628802','Tangil Hub',1,1500000,1,'2015-10-04 06:22:02',7),(2,3,'2015-09-17 00:00:00','100097','WIC/CCC','20000031','92629059','Faruk Chamber',2,709923,1,'2015-10-04 06:22:02',7),(3,3,'2015-09-17 00:00:00','50046','WIC/CCC','20000031','92628869','Rajshahi WIC',3,297018,1,'2015-10-04 06:22:02',7),(4,2,'2015-09-17 00:00:00','50046','WIC/CCC','20000323','92629584','Cox Bazaar WIC',1,80000,2,'2015-10-04 06:22:02',7),(114,2,'2015-10-17 00:00:00','50046','WIC/CCC','20000323','92629584','Cox Bazaar WIC',1,80000,2,'2015-10-04 06:22:02',7);

/*Table structure for table `tbl_bundle_sale_file` */

DROP TABLE IF EXISTS `tbl_bundle_sale_file`;

CREATE TABLE `tbl_bundle_sale_file` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FILE_NAME` varchar(200) NOT NULL,
  `UPLOAD_BY` int(11) NOT NULL,
  `UPLOAD_DATE` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_bundle_sale_file` */

insert  into `tbl_bundle_sale_file`(`ID`,`FILE_NAME`,`UPLOAD_BY`,`UPLOAD_DATE`) values (1,'Book1.xls',1,'2015-10-04 06:22:02'),(2,'Book2.xls',1,'2015-10-07 05:08:10');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_bundle_service` */

insert  into `tbl_bundle_service`(`SERVICE_ID`,`SERVICE_NAME`,`UNIT`,`UNIT_PRICE`,`PRICE_TYPE`,`GL_CODE`,`VAT_APPLICABLE`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'Prepaid Hand Set','pcs',7500,'market_value','60100155','no',1,'2015-09-21 12:23:24',1,'2015-09-21 12:31:27',7),(2,'On-net voice','minutes',0.12,'NC','60400010','yes',1,'2015-09-21 12:34:19',NULL,NULL,7),(3,'Off-net voice','minutes',0.14,'NC','60401000','yes',1,'2015-09-21 12:35:08',NULL,NULL,7),(4,'Data-Per MB','MB',0.24,'NC','60403501','yes',1,'2015-09-21 12:36:02',NULL,NULL,7),(5,'voice call','minutes',1,'NC','60403502','yes',1,'2015-09-29 04:54:00',NULL,NULL,7),(6,'SMS on-net','count',0.05,'NC','34567867','yes',1,'2015-10-02 12:47:48',NULL,NULL,7),(7,'iphone6 device','count',70377,'market_value','20000051','no',1,'2015-10-08 03:00:07',NULL,NULL,7);

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

/*Data for the table `tbl_bundle_user` */

insert  into `tbl_bundle_user`(`USER_ID`,`ROLE_ID`,`USER_NAME`,`USER_EMAIL`,`USER_PHONE`,`USER_PASSWORD`,`USER_PASSWORD_HISTORY`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,0,'MEHEDI3247','golam.mohiuddin@nns-solution.net','1234567890','l0y7QkzEyLXkyLLL_BEuJVjUterSeR98qEDwMa1y0TI%2C',NULL,NULL,'2015-09-13 12:06:23',NULL,NULL,9);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
