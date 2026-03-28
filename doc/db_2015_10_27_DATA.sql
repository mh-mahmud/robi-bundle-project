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

/*Data for the table `tbl_bundle` */

insert  into `tbl_bundle`(`BUNDLE_ID`,`SUBSCRIBERS_BASE`,`MATERIAL_CODE`,`MATERIAL_NAME`,`MRP`,`TYPE`,`EMI_MONTH`,`EMI_INTEREST`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (4,'pre_paid','20000036','Samsung ACE Next Campaign',8900,'in_cash',0,0,1,'2015-09-30 11:30:29',1,'2015-09-30 11:30:57',2),(5,'pre_paid','20000051','iPhone 6 &amp; iPhone 6 plus campaign',3999,'emi',24,14,1,'2015-10-08 03:34:24',1,'2015-10-08 03:43:57',2);

/*Data for the table `tbl_bundle_forecast` */

insert  into `tbl_bundle_forecast`(`BUNDLE_ID`,`SUBSCRIBERS_BASE`,`MATERIAL_CODE`,`MATERIAL_NAME`,`MRP`,`TYPE`,`EMI_MONTH`,`EMI_INTEREST`,`SALE_DATE`,`SALE_QUANTITY`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'pre_paid','20000051','iPhone 6 &amp; iPhone 6 plus campaign',3999,'emi',24,14,'2015-10-20 00:00:00',1,1,'2015-10-20 03:08:52',NULL,NULL,7);

/*Data for the table `tbl_bundle_item` */

insert  into `tbl_bundle_item`(`ID`,`BUNDLE_ID`,`SERVICE_ID`,`TYPE`,`LOOP_DAYS`,`QUANTITY`,`UNIT_PRICE`,`STATUS`) values (8,4,1,'once',0,1,7500,7),(9,4,2,'loop',90,3300,0.11,7),(10,4,3,'loop',90,675,0.14,7),(11,4,4,'loop',90,15360,0.22,7),(12,5,7,'once',0,1,70377,7),(13,5,2,'loop',0,750,0.12,7),(14,5,3,'loop',0,750,0.14,7),(15,5,4,'loop',0,2048,0.24,7);

/*Data for the table `tbl_bundle_item_forecast` */

insert  into `tbl_bundle_item_forecast`(`ID`,`BUNDLE_ID`,`SERVICE_ID`,`TYPE`,`LOOP_DAYS`,`QUANTITY`,`UNIT_PRICE`,`STATUS`) values (1,1,7,'once',0,1,70377,7),(2,1,2,'loop',0,750,0.12,7),(3,1,3,'loop',0,750,0.14,7),(4,1,4,'loop',0,2048,0.24,7);

/*Data for the table `tbl_bundle_option` */

insert  into `tbl_bundle_option`(`OPTION_ID`,`OPTION_VALUE`,`GROUP_NAME`,`PARENT_ID`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (4,'pcs','unit_name',NULL,1,'2015-09-15 11:21:34',NULL,NULL,7),(5,'MB','unit_name',NULL,1,'2015-09-15 11:21:44',NULL,NULL,7),(6,'minutes','unit_name',NULL,1,'2015-09-20 11:16:23',1,'2015-09-21 10:51:20',7),(8,'Count','unit_name',NULL,1,'2015-10-02 12:46:03',1,'2015-10-21 06:53:23',7),(10,'3','SD (%)',NULL,0,'0000-00-00 00:00:00',NULL,NULL,7),(11,'15','VAT (%)',NULL,0,'0000-00-00 00:00:00',NULL,NULL,7);

/*Data for the table `tbl_bundle_permission` */

insert  into `tbl_bundle_permission`(`PERMISSION_ID`,`PERMISSION_NAME`,`DETAILS`,`GROUP_NAME`,`MENU_NAME`,`ROUTE_NAME`,`PARENT_ID`,`STATUS`) values (13,'create_user',NULL,'user','create_user','create_user',0,1),(14,'manage_user',NULL,'user','manage_user','manage_user',0,1),(15,'create_role',NULL,'user','create_role','create_role',0,1),(16,'manage_role',NULL,'user','manage_role','manage_role',0,1),(18,'create_option',NULL,'configuration','create_option','create_option',0,1),(19,'manage_option',NULL,'configuration','manage_option','manage_option',0,1),(20,'create_bundle',NULL,'bundle','create_bundle','create_bundle',0,1),(21,'manage_bundle',NULL,'bundle','manage_bundle','manage_bundle',0,1),(22,'upload_sale_individual',NULL,'bundle','upload_sale_individual','upload_sale_individual',0,1),(23,'upload_sale_batch',NULL,'bundle','upload_sale_batch','upload_sale_batch',0,1),(24,'manage_sale',NULL,'bundle','manage_sale','manage_sale',0,1),(25,'approve_bundle',NULL,'bundle','manage_bundle','manage_bundle',0,1),(26,'fv_allocation',NULL,'report','fv_allocation','fv_allocation',0,1),(28,'create_service',NULL,'configuration','create_service','create_service',0,1),(29,'manage_service',NULL,'configuration','manage_service','manage_service',0,1),(30,'recognition_jv',NULL,'report','summary_jv_for_deferred_revenue_recognition','recognition_jv',0,1),(31,'fv_deferment',NULL,'report','revenue_deferment','fv_deferment',0,1),(32,'fv_summary',NULL,'report','fv_allocation_summary','fv_summary',0,1),(33,'individual_jv',NULL,'report','individual_jv_for_fv_allocation_and_revenue_deferment','individual_jv',0,1),(34,'fv_deferment_summary',NULL,'report','revenue_deferment_summary','fv_deferment_summary',0,1),(35,'create_bundle_forecast',NULL,'forecast','create_bundle_forecast','create_bundle_forecast',0,1),(36,'manage_bundle_forecast',NULL,'forecast','print_forecast','print_bundle_forecast',0,1),(37,'manage_bundle_forecast',NULL,'forecast','export_forecast','bundle_forecast/export',0,1),(38,'summary_jv',NULL,'report','summary_jv_for_fv_allocation_and_revenue_deferment','summary_jv',0,1);

/*Data for the table `tbl_bundle_role` */

insert  into `tbl_bundle_role`(`ROLE_ID`,`ROLE_NAME`,`DETAILS`,`PERMISSION_NAME`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'general',NULL,'create_role',9,'0000-00-00 00:00:00',9,'2015-09-14 06:25:51',7),(2,'user management',NULL,'create_bundle,create_role,manage_role',9,'2015-09-14 02:55:21',1,'2015-09-20 11:48:26',7);

/*Data for the table `tbl_bundle_sale` */

insert  into `tbl_bundle_sale`(`SALE_ID`,`BUNDLE_ID`,`INVOICE_DATE`,`SOLD_TO_PARTY`,`CHANNEL`,`CUST_NAME`,`MATERIAL_CODE`,`INVOICE_NO`,`DESCRIPTION`,`QUANTITY`,`GROSS_VALUE`,`CREATED_BY`,`CREATED_DATE`,`STATUS`) values (4,4,'2015-10-05 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',1,500000,2,'2015-10-04 06:22:02',7),(5,5,'2015-10-16 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',1,120000,2,'2015-10-04 06:22:02',7),(6,4,'2015-10-24 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',2,250000,2,'2015-10-04 06:22:02',7),(7,5,'2015-10-12 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',1,80000,2,'2015-10-04 06:22:02',7),(8,4,'2015-10-27 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',2,345000,2,'2015-10-04 06:22:02',7),(9,5,'2015-10-20 00:00:00','50046','WIC/CCC',NULL,'20000051','92629584','Cox Bazaar WIC',1,1200000,2,'2015-10-04 06:22:02',7);

/*Data for the table `tbl_bundle_sale_file` */

insert  into `tbl_bundle_sale_file`(`ID`,`FILE_NAME`,`UPLOAD_BY`,`UPLOAD_DATE`) values (1,'Book1.xls',1,'2015-10-04 06:22:02'),(2,'Book2.xls',1,'2015-10-07 05:08:10');

/*Data for the table `tbl_bundle_service` */

insert  into `tbl_bundle_service`(`SERVICE_ID`,`SERVICE_NAME`,`UNIT`,`UNIT_PRICE`,`PRICE_TYPE`,`GL_CODE`,`VAT_APPLICABLE`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,'Prepaid Hand Set','pcs',7500,'market_value','60100155','no',1,'2015-09-21 12:23:24',1,'2015-09-21 12:31:27',7),(2,'On-net voice','minutes',0.12,'NC','60400010','yes',1,'2015-09-21 12:34:19',NULL,NULL,7),(3,'Off-net voice','minutes',0.14,'NC','60401000','yes',1,'2015-09-21 12:35:08',NULL,NULL,7),(4,'Data-Per MB','MB',0.24,'NC','60403501','yes',1,'2015-09-21 12:36:02',NULL,NULL,7),(5,'voice call','minutes',1,'NC','60403502','yes',1,'2015-09-29 04:54:00',NULL,NULL,7),(6,'SMS on-net','count',0.05,'NC','34567867','yes',1,'2015-10-02 12:47:48',NULL,NULL,7),(7,'iphone6 device','count',70377,'market_value','20000051','no',1,'2015-10-08 03:00:07',NULL,NULL,7),(8,'Postpaid Revenue Voice ONNET Usage','minutes',0.12,'NC','60300010','yes',1,'2015-10-25 02:41:13',NULL,NULL,7);

/*Data for the table `tbl_bundle_user` */

insert  into `tbl_bundle_user`(`USER_ID`,`ROLE_ID`,`USER_NAME`,`USER_EMAIL`,`USER_PHONE`,`USER_PASSWORD`,`USER_PASSWORD_HISTORY`,`CREATED_BY`,`CREATED_DATE`,`UPDATED_BY`,`UPDATED_DATE`,`STATUS`) values (1,0,'MEHEDI3247','golam.mohiuddin@nns-solution.net','1234567890','l0y7QkzEyLXkyLLL_BEuJVjUterSeR98qEDwMa1y0TI%2C',NULL,NULL,'2015-09-13 12:06:23',NULL,NULL,9);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
