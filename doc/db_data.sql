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

/*Data for the table `tbl_bundle_option` */

/*Data for the table `tbl_bundle_permission` */

insert  into `tbl_bundle_permission`(`PERMISSION_ID`,`PERMISSION_NAME`,`DETAILS`,`GROUP_NAME`,`MENU_NAME`,`ROUTE_NAME`,`PARENT_ID`,`STATUS`) values (13,'create_user',NULL,'user','create_user','create_user',0,1),(14,'manage_user',NULL,'user','manage_user','manage_user',0,1),(15,'create_role',NULL,'user','create_role','create_role',0,1),(16,'manage_role',NULL,'user','manage_role','manage_role',0,1);

/*Data for the table `tbl_bundle_role` */

/*Data for the table `tbl_bundle_user` */

insert  into `tbl_bundle_user`(`USER_ID`,`ROLE_ID`,`USER_NAME`,`USER_EMAIL`,`USER_PHONE`,`USER_PASSWORD`,`USER_PASSWORD_HISTORY`,`USER_CREATED_DATE`,`USER_UPDATED_DATE`,`USER_STATUS`) values (1,0,'admin','golam.mohiuddin@nns-solution.net','','l0y7QkzEyLXkyLLL_BEuJVjUterSeR98qEDwMa1y0TI%2C',NULL,'2015-09-13 12:06:23',NULL,9);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
