/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.1.35-MariaDB : Database - db_amex_mobile
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_amex_mobile` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `tbitems` */

DROP TABLE IF EXISTS `tbitems`;

CREATE TABLE `tbitems` (
  `fst_item_code` varchar(20) DEFAULT NULL,
  `fst_item_name` varchar(50) DEFAULT NULL,
  `fst_satuan_1` varchar(10) DEFAULT NULL,
  `fst_satuan_2` varchar(10) DEFAULT NULL,
  `fst_satuan_3` varchar(10) DEFAULT NULL,
  `fin_convertion_2` float DEFAULT NULL,
  `fin_conversion_3` float DEFAULT NULL,
  `fin_selling_price1A` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2A` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3A` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1B` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2B` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3B` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1C` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2C` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3C` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1D` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2D` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3D` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1E` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2E` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3E` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1F` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2F` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3F` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1G` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2G` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3G` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1H` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2H` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3H` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1I` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2I` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3I` decimal(12,2) DEFAULT NULL,
  `fin_selling_price1J` decimal(12,2) DEFAULT NULL,
  `fin_selling_price2J` decimal(12,2) DEFAULT NULL,
  `fin_selling_price3J` decimal(12,2) DEFAULT NULL,
  `fst_memo` text,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
