/*
SQLyog Professional v12.09 (64 bit)
MySQL - 10.4.8-MariaDB : Database - ggg_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ggg_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ggg_test`;

/*Table structure for table `tbl_fee_config` */

DROP TABLE IF EXISTS `tbl_fee_config`;

CREATE TABLE `tbl_fee_config` (
  `fee_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fee_name` varchar(255) DEFAULT NULL,
  `fee_config` text DEFAULT NULL,
  `fee_config_condition` text DEFAULT NULL,
  `fee_status` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_fee_config` */

insert  into `tbl_fee_config`(`fee_id`,`fee_name`,`fee_config`,`fee_config_condition`,`fee_status`,`created_at`,`updated_at`) values (2,'fee_by_dimension','((|product_width| * 0.0254) * (|product_height| * 0.0254) * (|product_depth| * 0.0254)) * 11','{\"attribute_select\":\"0\",\"attribute_condition\":\"0\",\"attribute_condition_value\":null,\"config\":null}',1,'2023-04-21 07:47:52','2023-04-21 17:33:26'),(3,'fee_by_weight','(|product_weight| * 0.45359237) * 11','{\"attribute_select\":\"0\",\"attribute_condition\":\"0\",\"attribute_condition_value\":null,\"config\":null}',1,'2023-04-21 08:10:48','2023-04-21 17:34:31'),(4,'example_config_conditional','1','{\"attribute_select\":\"1\",\"attribute_condition\":\"4\",\"attribute_condition_value\":\"0.1\",\"config\":\"2\"}',1,'2023-04-21 17:25:11','2023-04-21 17:25:11');

/*Table structure for table `tbl_product_attribute_value` */

DROP TABLE IF EXISTS `tbl_product_attribute_value`;

CREATE TABLE `tbl_product_attribute_value` (
  `pav_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pa_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `pav_type_value` enum('number','string') DEFAULT NULL,
  `pav_status` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`pav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_product_attribute_value` */

/*Table structure for table `tbl_product_attributes` */

DROP TABLE IF EXISTS `tbl_product_attributes`;

CREATE TABLE `tbl_product_attributes` (
  `pa_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pa_text_show` varchar(255) DEFAULT NULL,
  `pa_name` varchar(255) DEFAULT NULL,
  `pa_status` int(1) DEFAULT 1,
  `pa_lock` int(1) DEFAULT 0,
  `regular_exp` text DEFAULT NULL,
  `regular_exp_index` int(11) DEFAULT 0,
  `pa_type` enum('text','number') DEFAULT 'text',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`pa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_product_attributes` */

insert  into `tbl_product_attributes`(`pa_id`,`pa_text_show`,`pa_name`,`pa_status`,`pa_lock`,`regular_exp`,`regular_exp_index`,`pa_type`,`created_at`,`updated_at`) values (1,'Weight item','product_weight',1,1,'/(?<=Item Weight).*?(?<=a-size-base prodDetAttrValue\">\\s)(.*?)\\s.*?(?=<\\/td>).*?(?=<\\/tr>)/',1,'number','2023-04-20 06:31:15','2023-04-20 22:15:29'),(2,'Width item','product_width',1,1,'/(?<=Product Dimensions).*?(?<=a-size-base prodDetAttrValue\">\\s).*?\\sx\\s(.*)?(?=\\sx).*?(?=<\\/td>)/',1,'number','2023-04-20 06:31:26','2023-04-20 22:15:37'),(3,'Height item','product_height',1,1,'/(?<=Product Dimensions).*?(?<=a-size-base prodDetAttrValue\">\\s).*?\\sx\\s.*?x\\s(.*?)\\s(.*?)\\s*?(?=<\\/td>)/',1,'number','2023-04-20 06:31:35','2023-04-20 22:15:46'),(4,'Depth item','product_depth',1,1,'/(?<=Product Dimensions).*?(?<=a-size-base prodDetAttrValue\">\\s)(.*?)\\s(?=x).*?(?=x).*?(?=<\\/td>)/',1,'number','2023-04-20 06:31:42','2023-04-20 22:15:53');

/*Table structure for table `tbl_products` */

DROP TABLE IF EXISTS `tbl_products`;

CREATE TABLE `tbl_products` (
  `p_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_url` text DEFAULT NULL,
  `product_name` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_content` text DEFAULT NULL,
  `product_price` double DEFAULT 0,
  `product_status` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_products` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
