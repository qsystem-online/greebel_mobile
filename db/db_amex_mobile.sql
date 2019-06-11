-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jun 2019 pada 05.46
-- Versi server: 10.1.35-MariaDB
-- Versi PHP: 7.1.24

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_amex_mobile`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_order` int(11) NOT NULL,
  `fst_menu_name` varchar(256) NOT NULL,
  `fst_caption` varchar(256) NOT NULL,
  `fst_icon` varchar(256) NOT NULL,
  `fst_type` enum('HEADER','TREEVIEW','','') NOT NULL DEFAULT 'HEADER',
  `fst_link` text,
  `fin_parent_id` int(11) NOT NULL,
  `fbl_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`fin_id`, `fin_order`, `fst_menu_name`, `fst_caption`, `fst_icon`, `fst_type`, `fst_link`, `fin_parent_id`, `fbl_active`) VALUES
(1, 1, 'master', 'Master', '', 'HEADER', NULL, 0, 1),
(2, 2, 'dashboard', 'Dashboard', '<i class=\"fa fa-dashboard\"></i>', 'TREEVIEW', 'dashboard', 0, 1),
(3, 3, 'department', 'Department', '<i class=\"fa fa-dashboard\"></i>', 'TREEVIEW', 'department', 0, 1),
(4, 4, 'group', 'Groups', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'welcome/general_element', 0, 1),
(5, 5, 'user', 'User', '<i class=\"fa fa-edit\"></i>', 'TREEVIEW', 'user', 0, 1),
(6, 1, 'user_user', 'Users', '<i class=\"fa fa-files-o\"></i>', 'TREEVIEW', 'user', 4, 1),
(7, 2, 'user_group', 'Groups', '<i class=\"fa fa-edit\"></i>', 'TREEVIEW', 'master_groups', 4, 1),
(8, 6, 'document', 'Documents', '', 'HEADER', NULL, 0, 1),
(9, 7, 'list_document', 'List Document', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'document', 0, 1),
(10, 8, 'approval_history', 'Approval History', '<i class=\"fa fa-calendar\"></i>', 'TREEVIEW', 'document/approval_history_list', 0, 1),
(11, 9, 'search_document', 'Search', '<i class=\"fa fa-search\"></i>', 'TREEVIEW', 'document/search_list', 0, 1),
(12, 10, 'refference_document', 'Reference Document', '<i class=\"fa fa-link\"></i>', 'TREEVIEW', 'reference_document/show_list', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbappid`
--

DROP TABLE IF EXISTS `tbappid`;
CREATE TABLE `tbappid` (
  `fst_sales_code` varchar(6) DEFAULT NULL,
  `fst_appid` varchar(64) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbappid`
--

INSERT INTO `tbappid` (`fst_sales_code`, `fst_appid`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
('SLS01', '1234567890', 'A', '2019-06-02 20:43:28', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbcustomers`
--

DROP TABLE IF EXISTS `tbcustomers`;
CREATE TABLE `tbcustomers` (
  `fin_cust_id` int(10) NOT NULL,
  `fst_cust_code` varchar(10) DEFAULT NULL,
  `fst_cust_name` varchar(40) DEFAULT NULL,
  `fst_cust_address` text,
  `fst_cust_phone` varchar(20) DEFAULT NULL,
  `fst_sales_code` varchar(6) DEFAULT NULL,
  `fst_cust_location` varchar(50) DEFAULT NULL,
  `fin_visit_day` int(1) DEFAULT NULL,
  `fin_price_group_id` int(1) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbcustomers`
--

INSERT INTO `tbcustomers` (`fin_cust_id`, `fst_cust_code`, `fst_cust_name`, `fst_cust_address`, `fst_cust_phone`, `fst_sales_code`, `fst_cust_location`, `fin_visit_day`, `fin_price_group_id`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'CODE-1', 'Customer Name 1', 'Customer address 1', 'Phone -1', 'SLS01', '-6.1825171,106.6749247', 2, 1, 'A', '2019-06-02 20:40:09', 1, '2019-06-03 00:00:57', 0),
(2, 'CODE-2', 'Customer Name 2', 'Customer address 2', 'Phone -2', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:09', 1, NULL, NULL),
(3, 'CODE-3', 'Customer Name 3', 'Customer address 3', 'Phone -3', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:09', 1, NULL, NULL),
(4, 'CODE-4', 'Customer Name 4', 'Customer address 4', 'Phone -4', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:09', 1, NULL, NULL),
(5, 'CODE-5', 'Customer Name 5', 'Customer address 5', 'Phone -5', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(6, 'CODE-6', 'Customer Name 6', 'Customer address 6', 'Phone -6', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(7, 'CODE-7', 'Customer Name 7', 'Customer address 7', 'Phone -7', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(8, 'CODE-8', 'Customer Name 8', 'Customer address 8', 'Phone -8', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(9, 'CODE-9', 'Customer Name 9', 'Customer address 9', 'Phone -9', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(10, 'CODE-10', 'Customer Name 10', 'Customer address 10', 'Phone -10', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(11, 'CODE-11', 'Customer Name 11', 'Customer address 11', 'Phone -11', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(12, 'CODE-12', 'Customer Name 12', 'Customer address 12', 'Phone -12', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(13, 'CODE-13', 'Customer Name 13', 'Customer address 13', 'Phone -13', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(14, 'CODE-14', 'Customer Name 14', 'Customer address 14', 'Phone -14', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(15, 'CODE-15', 'Customer Name 15', 'Customer address 15', 'Phone -15', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(16, 'CODE-16', 'Customer Name 16', 'Customer address 16', 'Phone -16', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(17, 'CODE-17', 'Customer Name 17', 'Customer address 17', 'Phone -17', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(18, 'CODE-18', 'Customer Name 18', 'Customer address 18', 'Phone -18', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(19, 'CODE-19', 'Customer Name 19', 'Customer address 19', 'Phone -19', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(20, 'CODE-20', 'Customer Name 20', 'Customer address 20', 'Phone -20', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(21, 'CODE-0', 'Customer Name 0', 'Customer address 0', 'Phone -0', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:09', 1, NULL, NULL),
(22, 'CODE-22', 'Customer Name 22', 'Customer address 22', 'Phone -22', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(23, 'CODE-23', 'Customer Name 23', 'Customer address 23', 'Phone -23', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(24, 'CODE-24', 'Customer Name 24', 'Customer address 24', 'Phone -24', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(25, 'CODE-25', 'Customer Name 25', 'Customer address 25', 'Phone -25', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(26, 'CODE-26', 'Customer Name 26', 'Customer address 26', 'Phone -26', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(27, 'CODE-27', 'Customer Name 27', 'Customer address 27', 'Phone -27', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(28, 'CODE-28', 'Customer Name 28', 'Customer address 28', 'Phone -28', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(29, 'CODE-29', 'Customer Name 29', 'Customer address 29', 'Phone -29', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(30, 'CODE-30', 'Customer Name 30', 'Customer address 30', 'Phone -30', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(31, 'CODE-31', 'Customer Name 31', 'Customer address 31', 'Phone -31', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(32, 'CODE-32', 'Customer Name 32', 'Customer address 32', 'Phone -32', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(33, 'CODE-33', 'Customer Name 33', 'Customer address 33', 'Phone -33', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(34, 'CODE-34', 'Customer Name 34', 'Customer address 34', 'Phone -34', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(35, 'CODE-35', 'Customer Name 35', 'Customer address 35', 'Phone -35', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(36, 'CODE-36', 'Customer Name 36', 'Customer address 36', 'Phone -36', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(37, 'CODE-37', 'Customer Name 37', 'Customer address 37', 'Phone -37', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(38, 'CODE-38', 'Customer Name 38', 'Customer address 38', 'Phone -38', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(39, 'CODE-39', 'Customer Name 39', 'Customer address 39', 'Phone -39', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(40, 'CODE-40', 'Customer Name 40', 'Customer address 40', 'Phone -40', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(41, 'CODE-41', 'Customer Name 41', 'Customer address 41', 'Phone -41', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(42, 'CODE-42', 'Customer Name 42', 'Customer address 42', 'Phone -42', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(43, 'CODE-43', 'Customer Name 43', 'Customer address 43', 'Phone -43', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(44, 'CODE-44', 'Customer Name 44', 'Customer address 44', 'Phone -44', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(45, 'CODE-45', 'Customer Name 45', 'Customer address 45', 'Phone -45', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(46, 'CODE-46', 'Customer Name 46', 'Customer address 46', 'Phone -46', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(47, 'CODE-47', 'Customer Name 47', 'Customer address 47', 'Phone -47', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(48, 'CODE-48', 'Customer Name 48', 'Customer address 48', 'Phone -48', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(49, 'CODE-49', 'Customer Name 49', 'Customer address 49', 'Phone -49', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(50, 'CODE-50', 'Customer Name 50', 'Customer address 50', 'Phone -50', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(51, 'CODE-51', 'Customer Name 51', 'Customer address 51', 'Phone -51', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(52, 'CODE-52', 'Customer Name 52', 'Customer address 52', 'Phone -52', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:10', 1, NULL, NULL),
(53, 'CODE-53', 'Customer Name 53', 'Customer address 53', 'Phone -53', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(54, 'CODE-54', 'Customer Name 54', 'Customer address 54', 'Phone -54', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(55, 'CODE-55', 'Customer Name 55', 'Customer address 55', 'Phone -55', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(56, 'CODE-56', 'Customer Name 56', 'Customer address 56', 'Phone -56', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(57, 'CODE-57', 'Customer Name 57', 'Customer address 57', 'Phone -57', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(58, 'CODE-58', 'Customer Name 58', 'Customer address 58', 'Phone -58', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(59, 'CODE-59', 'Customer Name 59', 'Customer address 59', 'Phone -59', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(60, 'CODE-60', 'Customer Name 60', 'Customer address 60', 'Phone -60', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(61, 'CODE-61', 'Customer Name 61', 'Customer address 61', 'Phone -61', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(62, 'CODE-62', 'Customer Name 62', 'Customer address 62', 'Phone -62', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(63, 'CODE-63', 'Customer Name 63', 'Customer address 63', 'Phone -63', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(64, 'CODE-64', 'Customer Name 64', 'Customer address 64', 'Phone -64', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(65, 'CODE-65', 'Customer Name 65', 'Customer address 65', 'Phone -65', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(66, 'CODE-66', 'Customer Name 66', 'Customer address 66', 'Phone -66', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(67, 'CODE-67', 'Customer Name 67', 'Customer address 67', 'Phone -67', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(68, 'CODE-68', 'Customer Name 68', 'Customer address 68', 'Phone -68', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(69, 'CODE-69', 'Customer Name 69', 'Customer address 69', 'Phone -69', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(70, 'CODE-70', 'Customer Name 70', 'Customer address 70', 'Phone -70', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(71, 'CODE-71', 'Customer Name 71', 'Customer address 71', 'Phone -71', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(72, 'CODE-72', 'Customer Name 72', 'Customer address 72', 'Phone -72', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(73, 'CODE-73', 'Customer Name 73', 'Customer address 73', 'Phone -73', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(74, 'CODE-74', 'Customer Name 74', 'Customer address 74', 'Phone -74', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(75, 'CODE-75', 'Customer Name 75', 'Customer address 75', 'Phone -75', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(76, 'CODE-76', 'Customer Name 76', 'Customer address 76', 'Phone -76', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(77, 'CODE-77', 'Customer Name 77', 'Customer address 77', 'Phone -77', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(78, 'CODE-78', 'Customer Name 78', 'Customer address 78', 'Phone -78', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(79, 'CODE-79', 'Customer Name 79', 'Customer address 79', 'Phone -79', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(80, 'CODE-80', 'Customer Name 80', 'Customer address 80', 'Phone -80', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(81, 'CODE-81', 'Customer Name 81', 'Customer address 81', 'Phone -81', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(82, 'CODE-82', 'Customer Name 82', 'Customer address 82', 'Phone -82', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(83, 'CODE-83', 'Customer Name 83', 'Customer address 83', 'Phone -83', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(84, 'CODE-84', 'Customer Name 84', 'Customer address 84', 'Phone -84', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(85, 'CODE-85', 'Customer Name 85', 'Customer address 85', 'Phone -85', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:11', 1, NULL, NULL),
(86, 'CODE-86', 'Customer Name 86', 'Customer address 86', 'Phone -86', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(87, 'CODE-87', 'Customer Name 87', 'Customer address 87', 'Phone -87', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(88, 'CODE-88', 'Customer Name 88', 'Customer address 88', 'Phone -88', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(89, 'CODE-89', 'Customer Name 89', 'Customer address 89', 'Phone -89', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(90, 'CODE-90', 'Customer Name 90', 'Customer address 90', 'Phone -90', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(91, 'CODE-91', 'Customer Name 91', 'Customer address 91', 'Phone -91', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(92, 'CODE-92', 'Customer Name 92', 'Customer address 92', 'Phone -92', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(93, 'CODE-93', 'Customer Name 93', 'Customer address 93', 'Phone -93', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(94, 'CODE-94', 'Customer Name 94', 'Customer address 94', 'Phone -94', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(95, 'CODE-95', 'Customer Name 95', 'Customer address 95', 'Phone -95', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(96, 'CODE-96', 'Customer Name 96', 'Customer address 96', 'Phone -96', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(97, 'CODE-97', 'Customer Name 97', 'Customer address 97', 'Phone -97', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(98, 'CODE-98', 'Customer Name 98', 'Customer address 98', 'Phone -98', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(99, 'CODE-99', 'Customer Name 99', 'Customer address 99', 'Phone -99', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(100, 'CODE-100', 'Customer Name 100', 'Customer address 100', 'Phone -100', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(101, 'CODE-101', 'Customer Name 101', 'Customer address 101', 'Phone -101', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(102, 'CODE-102', 'Customer Name 102', 'Customer address 102', 'Phone -102', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(103, 'CODE-103', 'Customer Name 103', 'Customer address 103', 'Phone -103', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(104, 'CODE-104', 'Customer Name 104', 'Customer address 104', 'Phone -104', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(105, 'CODE-105', 'Customer Name 105', 'Customer address 105', 'Phone -105', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(106, 'CODE-106', 'Customer Name 106', 'Customer address 106', 'Phone -106', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(107, 'CODE-107', 'Customer Name 107', 'Customer address 107', 'Phone -107', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(108, 'CODE-108', 'Customer Name 108', 'Customer address 108', 'Phone -108', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(109, 'CODE-109', 'Customer Name 109', 'Customer address 109', 'Phone -109', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(110, 'CODE-110', 'Customer Name 110', 'Customer address 110', 'Phone -110', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(111, 'CODE-111', 'Customer Name 111', 'Customer address 111', 'Phone -111', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(112, 'CODE-112', 'Customer Name 112', 'Customer address 112', 'Phone -112', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(113, 'CODE-113', 'Customer Name 113', 'Customer address 113', 'Phone -113', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(114, 'CODE-114', 'Customer Name 114', 'Customer address 114', 'Phone -114', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(115, 'CODE-115', 'Customer Name 115', 'Customer address 115', 'Phone -115', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(116, 'CODE-116', 'Customer Name 116', 'Customer address 116', 'Phone -116', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(117, 'CODE-117', 'Customer Name 117', 'Customer address 117', 'Phone -117', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(118, 'CODE-118', 'Customer Name 118', 'Customer address 118', 'Phone -118', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(119, 'CODE-119', 'Customer Name 119', 'Customer address 119', 'Phone -119', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(120, 'CODE-120', 'Customer Name 120', 'Customer address 120', 'Phone -120', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(121, 'CODE-121', 'Customer Name 121', 'Customer address 121', 'Phone -121', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(122, 'CODE-122', 'Customer Name 122', 'Customer address 122', 'Phone -122', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(123, 'CODE-123', 'Customer Name 123', 'Customer address 123', 'Phone -123', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(124, 'CODE-124', 'Customer Name 124', 'Customer address 124', 'Phone -124', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(125, 'CODE-125', 'Customer Name 125', 'Customer address 125', 'Phone -125', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(126, 'CODE-126', 'Customer Name 126', 'Customer address 126', 'Phone -126', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(127, 'CODE-127', 'Customer Name 127', 'Customer address 127', 'Phone -127', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:12', 1, NULL, NULL),
(128, 'CODE-128', 'Customer Name 128', 'Customer address 128', 'Phone -128', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(129, 'CODE-129', 'Customer Name 129', 'Customer address 129', 'Phone -129', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(130, 'CODE-130', 'Customer Name 130', 'Customer address 130', 'Phone -130', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(131, 'CODE-131', 'Customer Name 131', 'Customer address 131', 'Phone -131', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(132, 'CODE-132', 'Customer Name 132', 'Customer address 132', 'Phone -132', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(133, 'CODE-133', 'Customer Name 133', 'Customer address 133', 'Phone -133', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(134, 'CODE-134', 'Customer Name 134', 'Customer address 134', 'Phone -134', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(135, 'CODE-135', 'Customer Name 135', 'Customer address 135', 'Phone -135', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(136, 'CODE-136', 'Customer Name 136', 'Customer address 136', 'Phone -136', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(137, 'CODE-137', 'Customer Name 137', 'Customer address 137', 'Phone -137', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(138, 'CODE-138', 'Customer Name 138', 'Customer address 138', 'Phone -138', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(139, 'CODE-139', 'Customer Name 139', 'Customer address 139', 'Phone -139', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(140, 'CODE-140', 'Customer Name 140', 'Customer address 140', 'Phone -140', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(141, 'CODE-141', 'Customer Name 141', 'Customer address 141', 'Phone -141', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(142, 'CODE-142', 'Customer Name 142', 'Customer address 142', 'Phone -142', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(143, 'CODE-143', 'Customer Name 143', 'Customer address 143', 'Phone -143', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(144, 'CODE-144', 'Customer Name 144', 'Customer address 144', 'Phone -144', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(145, 'CODE-145', 'Customer Name 145', 'Customer address 145', 'Phone -145', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(146, 'CODE-146', 'Customer Name 146', 'Customer address 146', 'Phone -146', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(147, 'CODE-147', 'Customer Name 147', 'Customer address 147', 'Phone -147', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(148, 'CODE-148', 'Customer Name 148', 'Customer address 148', 'Phone -148', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(149, 'CODE-149', 'Customer Name 149', 'Customer address 149', 'Phone -149', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(150, 'CODE-150', 'Customer Name 150', 'Customer address 150', 'Phone -150', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(151, 'CODE-151', 'Customer Name 151', 'Customer address 151', 'Phone -151', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(152, 'CODE-152', 'Customer Name 152', 'Customer address 152', 'Phone -152', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(153, 'CODE-153', 'Customer Name 153', 'Customer address 153', 'Phone -153', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(154, 'CODE-154', 'Customer Name 154', 'Customer address 154', 'Phone -154', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(155, 'CODE-155', 'Customer Name 155', 'Customer address 155', 'Phone -155', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(156, 'CODE-156', 'Customer Name 156', 'Customer address 156', 'Phone -156', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(157, 'CODE-157', 'Customer Name 157', 'Customer address 157', 'Phone -157', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(158, 'CODE-158', 'Customer Name 158', 'Customer address 158', 'Phone -158', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(159, 'CODE-159', 'Customer Name 159', 'Customer address 159', 'Phone -159', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(160, 'CODE-160', 'Customer Name 160', 'Customer address 160', 'Phone -160', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(161, 'CODE-161', 'Customer Name 161', 'Customer address 161', 'Phone -161', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(162, 'CODE-162', 'Customer Name 162', 'Customer address 162', 'Phone -162', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(163, 'CODE-163', 'Customer Name 163', 'Customer address 163', 'Phone -163', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(164, 'CODE-164', 'Customer Name 164', 'Customer address 164', 'Phone -164', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(165, 'CODE-165', 'Customer Name 165', 'Customer address 165', 'Phone -165', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(166, 'CODE-166', 'Customer Name 166', 'Customer address 166', 'Phone -166', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(167, 'CODE-167', 'Customer Name 167', 'Customer address 167', 'Phone -167', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(168, 'CODE-168', 'Customer Name 168', 'Customer address 168', 'Phone -168', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:13', 1, NULL, NULL),
(169, 'CODE-169', 'Customer Name 169', 'Customer address 169', 'Phone -169', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(170, 'CODE-170', 'Customer Name 170', 'Customer address 170', 'Phone -170', 'SLS01', NULL, 4, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(171, 'CODE-171', 'Customer Name 171', 'Customer address 171', 'Phone -171', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(172, 'CODE-172', 'Customer Name 172', 'Customer address 172', 'Phone -172', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(173, 'CODE-173', 'Customer Name 173', 'Customer address 173', 'Phone -173', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(174, 'CODE-174', 'Customer Name 174', 'Customer address 174', 'Phone -174', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(175, 'CODE-175', 'Customer Name 175', 'Customer address 175', 'Phone -175', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(176, 'CODE-176', 'Customer Name 176', 'Customer address 176', 'Phone -176', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(177, 'CODE-177', 'Customer Name 177', 'Customer address 177', 'Phone -177', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(178, 'CODE-178', 'Customer Name 178', 'Customer address 178', 'Phone -178', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(179, 'CODE-179', 'Customer Name 179', 'Customer address 179', 'Phone -179', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(180, 'CODE-180', 'Customer Name 180', 'Customer address 180', 'Phone -180', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(181, 'CODE-181', 'Customer Name 181', 'Customer address 181', 'Phone -181', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(182, 'CODE-182', 'Customer Name 182', 'Customer address 182', 'Phone -182', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(183, 'CODE-183', 'Customer Name 183', 'Customer address 183', 'Phone -183', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(184, 'CODE-184', 'Customer Name 184', 'Customer address 184', 'Phone -184', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(185, 'CODE-185', 'Customer Name 185', 'Customer address 185', 'Phone -185', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(186, 'CODE-186', 'Customer Name 186', 'Customer address 186', 'Phone -186', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(187, 'CODE-187', 'Customer Name 187', 'Customer address 187', 'Phone -187', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(188, 'CODE-188', 'Customer Name 188', 'Customer address 188', 'Phone -188', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(189, 'CODE-189', 'Customer Name 189', 'Customer address 189', 'Phone -189', 'SLS01', NULL, 3, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(190, 'CODE-190', 'Customer Name 190', 'Customer address 190', 'Phone -190', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(191, 'CODE-191', 'Customer Name 191', 'Customer address 191', 'Phone -191', 'SLS01', NULL, 6, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(192, 'CODE-192', 'Customer Name 192', 'Customer address 192', 'Phone -192', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(193, 'CODE-193', 'Customer Name 193', 'Customer address 193', 'Phone -193', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(194, 'CODE-194', 'Customer Name 194', 'Customer address 194', 'Phone -194', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(195, 'CODE-195', 'Customer Name 195', 'Customer address 195', 'Phone -195', 'SLS01', NULL, 5, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(196, 'CODE-196', 'Customer Name 196', 'Customer address 196', 'Phone -196', 'SLS01', NULL, 7, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(197, 'CODE-197', 'Customer Name 197', 'Customer address 197', 'Phone -197', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(198, 'CODE-198', 'Customer Name 198', 'Customer address 198', 'Phone -198', 'SLS01', NULL, 1, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL),
(199, 'CODE-199', 'Customer Name 199', 'Customer address 199', 'Phone -199', 'SLS01', NULL, 2, 1, 'A', '2019-06-02 20:40:14', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbfreeitemperinvoice`
--

DROP TABLE IF EXISTS `tbfreeitemperinvoice`;
CREATE TABLE `tbfreeitemperinvoice` (
  `fin_promo_id` int(10) NOT NULL,
  `fst_item_code_awal` varchar(20) DEFAULT NULL,
  `fst_item_code_akhir` varchar(20) DEFAULT NULL,
  `fin_qty` int(10) DEFAULT NULL,
  `fst_satuan` varchar(10) DEFAULT NULL,
  `fst_free_item_code_awal` varchar(20) DEFAULT NULL,
  `fst_free_item_code_akhir` varchar(20) DEFAULT NULL,
  `fin_free_qty` int(10) DEFAULT NULL,
  `fst_free_satuan` varchar(10) DEFAULT NULL,
  `fdt_date_start` date DEFAULT NULL,
  `fdt_date_end` date DEFAULT NULL,
  `fin_price_group_id` int(2) DEFAULT NULL,
  `fbl_multiple_free` tinyint(1) DEFAULT NULL,
  `fin_max_free_qty` int(10) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbfreeitemperinvoice`
--

INSERT INTO `tbfreeitemperinvoice` (`fin_promo_id`, `fst_item_code_awal`, `fst_item_code_akhir`, `fin_qty`, `fst_satuan`, `fst_free_item_code_awal`, `fst_free_item_code_akhir`, `fin_free_qty`, `fst_free_satuan`, `fdt_date_start`, `fdt_date_end`, `fin_price_group_id`, `fbl_multiple_free`, `fin_max_free_qty`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'ITM-CODE-0', 'ITM-CODE-10', 10, 'KILO', 'ITM-CODE-12', 'ITM-CODE-15', 1, 'KILO', '2019-06-01', '2019-06-30', 1, 1, 5, 'A', '2019-06-04 14:23:46', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbitems`
--

DROP TABLE IF EXISTS `tbitems`;
CREATE TABLE `tbitems` (
  `fst_item_code` varchar(20) DEFAULT NULL,
  `fst_item_name` varchar(50) DEFAULT NULL,
  `fst_satuan_1` varchar(10) DEFAULT NULL,
  `fst_satuan_2` varchar(10) DEFAULT NULL,
  `fst_satuan_3` varchar(10) DEFAULT NULL,
  `fin_conversion_2` float DEFAULT NULL,
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

--
-- Dumping data untuk tabel `tbitems`
--

INSERT INTO `tbitems` (`fst_item_code`, `fst_item_name`, `fst_satuan_1`, `fst_satuan_2`, `fst_satuan_3`, `fin_conversion_2`, `fin_conversion_3`, `fin_selling_price1A`, `fin_selling_price2A`, `fin_selling_price3A`, `fin_selling_price1B`, `fin_selling_price2B`, `fin_selling_price3B`, `fin_selling_price1C`, `fin_selling_price2C`, `fin_selling_price3C`, `fin_selling_price1D`, `fin_selling_price2D`, `fin_selling_price3D`, `fin_selling_price1E`, `fin_selling_price2E`, `fin_selling_price3E`, `fin_selling_price1F`, `fin_selling_price2F`, `fin_selling_price3F`, `fin_selling_price1G`, `fin_selling_price2G`, `fin_selling_price3G`, `fin_selling_price1H`, `fin_selling_price2H`, `fin_selling_price3H`, `fin_selling_price1I`, `fin_selling_price2I`, `fin_selling_price3I`, `fin_selling_price1J`, `fin_selling_price2J`, `fin_selling_price3J`, `fst_memo`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
('ITM-CODE-0', 'ITEM NAME 0', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 0', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-1', 'ITEM NAME 1', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 1', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-2', 'ITEM NAME 2', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 2', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-3', 'ITEM NAME 3', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 3', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-4', 'ITEM NAME 4', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 4', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-5', 'ITEM NAME 5', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 5', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-6', 'ITEM NAME 6', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 6', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-7', 'ITEM NAME 7', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 7', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-8', 'ITEM NAME 8', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 8', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-9', 'ITEM NAME 9', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 9', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-10', 'ITEM NAME 10', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 10', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-11', 'ITEM NAME 11', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 11', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-12', 'ITEM NAME 12', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 12', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-13', 'ITEM NAME 13', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 13', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-14', 'ITEM NAME 14', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 14', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-15', 'ITEM NAME 15', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 15', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-16', 'ITEM NAME 16', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 16', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-17', 'ITEM NAME 17', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 17', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-18', 'ITEM NAME 18', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 18', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-19', 'ITEM NAME 19', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 19', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-20', 'ITEM NAME 20', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 20', 'A', '2019-06-03 15:26:33', 1, NULL, NULL),
('ITM-CODE-21', 'ITEM NAME 21', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 21', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-22', 'ITEM NAME 22', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 22', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-23', 'ITEM NAME 23', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 23', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-24', 'ITEM NAME 24', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 24', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-25', 'ITEM NAME 25', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 25', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-26', 'ITEM NAME 26', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 26', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-27', 'ITEM NAME 27', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 27', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-28', 'ITEM NAME 28', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 28', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-29', 'ITEM NAME 29', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 29', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-30', 'ITEM NAME 30', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 30', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-31', 'ITEM NAME 31', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 31', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-32', 'ITEM NAME 32', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 32', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-33', 'ITEM NAME 33', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 33', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-34', 'ITEM NAME 34', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 34', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-35', 'ITEM NAME 35', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 35', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-36', 'ITEM NAME 36', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 36', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-37', 'ITEM NAME 37', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 37', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-38', 'ITEM NAME 38', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 38', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-39', 'ITEM NAME 39', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 39', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-40', 'ITEM NAME 40', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 40', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-41', 'ITEM NAME 41', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 41', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-42', 'ITEM NAME 42', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 42', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-43', 'ITEM NAME 43', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 43', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-44', 'ITEM NAME 44', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 44', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-45', 'ITEM NAME 45', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 45', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-46', 'ITEM NAME 46', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 46', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-47', 'ITEM NAME 47', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 47', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-48', 'ITEM NAME 48', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 48', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-49', 'ITEM NAME 49', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 49', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-50', 'ITEM NAME 50', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 50', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-51', 'ITEM NAME 51', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 51', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-52', 'ITEM NAME 52', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 52', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-53', 'ITEM NAME 53', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 53', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-54', 'ITEM NAME 54', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 54', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-55', 'ITEM NAME 55', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 55', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-56', 'ITEM NAME 56', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 56', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-57', 'ITEM NAME 57', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 57', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-58', 'ITEM NAME 58', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 58', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-59', 'ITEM NAME 59', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 59', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-60', 'ITEM NAME 60', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 60', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-61', 'ITEM NAME 61', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 61', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-62', 'ITEM NAME 62', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 62', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-63', 'ITEM NAME 63', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 63', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-64', 'ITEM NAME 64', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 64', 'A', '2019-06-03 15:26:34', 1, NULL, NULL),
('ITM-CODE-65', 'ITEM NAME 65', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 65', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-66', 'ITEM NAME 66', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 66', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-67', 'ITEM NAME 67', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 67', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-68', 'ITEM NAME 68', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 68', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-69', 'ITEM NAME 69', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 69', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-70', 'ITEM NAME 70', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 70', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-71', 'ITEM NAME 71', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 71', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-72', 'ITEM NAME 72', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 72', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-73', 'ITEM NAME 73', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 73', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-74', 'ITEM NAME 74', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 74', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-75', 'ITEM NAME 75', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 75', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-76', 'ITEM NAME 76', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 76', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-77', 'ITEM NAME 77', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 77', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-78', 'ITEM NAME 78', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 78', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-79', 'ITEM NAME 79', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 79', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-80', 'ITEM NAME 80', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 80', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-81', 'ITEM NAME 81', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 81', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-82', 'ITEM NAME 82', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 82', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-83', 'ITEM NAME 83', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 83', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-84', 'ITEM NAME 84', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 84', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-85', 'ITEM NAME 85', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 85', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-86', 'ITEM NAME 86', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 86', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-87', 'ITEM NAME 87', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 87', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-88', 'ITEM NAME 88', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 88', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-89', 'ITEM NAME 89', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 89', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-90', 'ITEM NAME 90', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 90', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-91', 'ITEM NAME 91', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 91', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-92', 'ITEM NAME 92', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 92', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-93', 'ITEM NAME 93', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 93', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-94', 'ITEM NAME 94', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 94', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-95', 'ITEM NAME 95', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 95', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-96', 'ITEM NAME 96', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 96', 'A', '2019-06-03 15:26:35', 1, NULL, NULL),
('ITM-CODE-97', 'ITEM NAME 97', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 97', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-98', 'ITEM NAME 98', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 98', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-99', 'ITEM NAME 99', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 99', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-100', 'ITEM NAME 100', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 100', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-101', 'ITEM NAME 101', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 101', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-102', 'ITEM NAME 102', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 102', 'A', '2019-06-03 15:26:36', 1, NULL, NULL);
INSERT INTO `tbitems` (`fst_item_code`, `fst_item_name`, `fst_satuan_1`, `fst_satuan_2`, `fst_satuan_3`, `fin_conversion_2`, `fin_conversion_3`, `fin_selling_price1A`, `fin_selling_price2A`, `fin_selling_price3A`, `fin_selling_price1B`, `fin_selling_price2B`, `fin_selling_price3B`, `fin_selling_price1C`, `fin_selling_price2C`, `fin_selling_price3C`, `fin_selling_price1D`, `fin_selling_price2D`, `fin_selling_price3D`, `fin_selling_price1E`, `fin_selling_price2E`, `fin_selling_price3E`, `fin_selling_price1F`, `fin_selling_price2F`, `fin_selling_price3F`, `fin_selling_price1G`, `fin_selling_price2G`, `fin_selling_price3G`, `fin_selling_price1H`, `fin_selling_price2H`, `fin_selling_price3H`, `fin_selling_price1I`, `fin_selling_price2I`, `fin_selling_price3I`, `fin_selling_price1J`, `fin_selling_price2J`, `fin_selling_price3J`, `fst_memo`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
('ITM-CODE-103', 'ITEM NAME 103', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 103', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-104', 'ITEM NAME 104', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 104', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-105', 'ITEM NAME 105', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 105', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-106', 'ITEM NAME 106', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 106', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-107', 'ITEM NAME 107', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 107', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-108', 'ITEM NAME 108', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 108', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-109', 'ITEM NAME 109', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 109', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-110', 'ITEM NAME 110', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 110', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-111', 'ITEM NAME 111', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 111', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-112', 'ITEM NAME 112', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 112', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-113', 'ITEM NAME 113', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 113', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-114', 'ITEM NAME 114', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 114', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-115', 'ITEM NAME 115', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 115', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-116', 'ITEM NAME 116', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 116', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-117', 'ITEM NAME 117', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 117', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-118', 'ITEM NAME 118', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 118', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-119', 'ITEM NAME 119', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 119', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-120', 'ITEM NAME 120', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 120', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-121', 'ITEM NAME 121', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 121', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-122', 'ITEM NAME 122', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 122', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-123', 'ITEM NAME 123', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 123', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-124', 'ITEM NAME 124', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 124', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-125', 'ITEM NAME 125', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 125', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-126', 'ITEM NAME 126', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 126', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-127', 'ITEM NAME 127', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 127', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-128', 'ITEM NAME 128', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 128', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-129', 'ITEM NAME 129', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 129', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-130', 'ITEM NAME 130', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 130', 'A', '2019-06-03 15:26:36', 1, NULL, NULL),
('ITM-CODE-131', 'ITEM NAME 131', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 131', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-132', 'ITEM NAME 132', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 132', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-133', 'ITEM NAME 133', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 133', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-134', 'ITEM NAME 134', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 134', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-135', 'ITEM NAME 135', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 135', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-136', 'ITEM NAME 136', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 136', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-137', 'ITEM NAME 137', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 137', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-138', 'ITEM NAME 138', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 138', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-139', 'ITEM NAME 139', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 139', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-140', 'ITEM NAME 140', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 140', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-141', 'ITEM NAME 141', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 141', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-142', 'ITEM NAME 142', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 142', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-143', 'ITEM NAME 143', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 143', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-144', 'ITEM NAME 144', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 144', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-145', 'ITEM NAME 145', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 145', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-146', 'ITEM NAME 146', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 146', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-147', 'ITEM NAME 147', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 147', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-148', 'ITEM NAME 148', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 148', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-149', 'ITEM NAME 149', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 149', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-150', 'ITEM NAME 150', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 150', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-151', 'ITEM NAME 151', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 151', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-152', 'ITEM NAME 152', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 152', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-153', 'ITEM NAME 153', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 153', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-154', 'ITEM NAME 154', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 154', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-155', 'ITEM NAME 155', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 155', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-156', 'ITEM NAME 156', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 156', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-157', 'ITEM NAME 157', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 157', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-158', 'ITEM NAME 158', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 158', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-159', 'ITEM NAME 159', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 159', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-160', 'ITEM NAME 160', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 160', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-161', 'ITEM NAME 161', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 161', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-162', 'ITEM NAME 162', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 162', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-163', 'ITEM NAME 163', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 163', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-164', 'ITEM NAME 164', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 164', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-165', 'ITEM NAME 165', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 165', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-166', 'ITEM NAME 166', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 166', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-167', 'ITEM NAME 167', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 167', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-168', 'ITEM NAME 168', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 168', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-169', 'ITEM NAME 169', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 169', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-170', 'ITEM NAME 170', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 170', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-171', 'ITEM NAME 171', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 171', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-172', 'ITEM NAME 172', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 172', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-173', 'ITEM NAME 173', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 173', 'A', '2019-06-03 15:26:37', 1, NULL, NULL),
('ITM-CODE-174', 'ITEM NAME 174', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 174', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-175', 'ITEM NAME 175', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 175', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-176', 'ITEM NAME 176', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 176', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-177', 'ITEM NAME 177', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 177', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-178', 'ITEM NAME 178', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 178', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-179', 'ITEM NAME 179', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 179', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-180', 'ITEM NAME 180', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 180', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-181', 'ITEM NAME 181', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 181', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-182', 'ITEM NAME 182', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 182', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-183', 'ITEM NAME 183', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 183', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-184', 'ITEM NAME 184', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 184', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-185', 'ITEM NAME 185', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 185', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-186', 'ITEM NAME 186', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 186', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-187', 'ITEM NAME 187', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 187', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-188', 'ITEM NAME 188', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 188', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-189', 'ITEM NAME 189', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 189', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-190', 'ITEM NAME 190', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 190', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-191', 'ITEM NAME 191', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 191', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-192', 'ITEM NAME 192', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 192', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-193', 'ITEM NAME 193', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 193', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-194', 'ITEM NAME 194', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 194', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-195', 'ITEM NAME 195', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 195', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-196', 'ITEM NAME 196', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 196', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-197', 'ITEM NAME 197', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 197', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-198', 'ITEM NAME 198', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 198', 'A', '2019-06-03 15:26:38', 1, NULL, NULL),
('ITM-CODE-199', 'ITEM NAME 199', 'GRAM', 'KILO', 'BOX', 1000, 5525.54, '1000.01', '2000.01', '3000.01', '1000.02', '2000.02', '3000.02', '1000.03', '2000.03', '3000.03', '1000.04', '2000.04', '3000.04', '1000.05', '2000.05', '3000.05', '1000.06', '2000.06', '3000.06', '1000.07', '2000.07', '1000.07', '1000.08', '2000.08', '3000.08', '1000.09', '2000.09', '3000.09', '1000.10', '2000.10', '3000.10', 'Ini Test Demo untuk item 199', 'A', '2019-06-03 15:26:38', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbsales`
--

DROP TABLE IF EXISTS `tbsales`;
CREATE TABLE `tbsales` (
  `fst_sales_code` varchar(6) DEFAULT NULL,
  `fst_sales_name` varchar(40) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbsales`
--

INSERT INTO `tbsales` (`fst_sales_code`, `fst_sales_name`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
('SLS01', 'Sales Name 01', 'A', '2019-06-02 20:42:23', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trcheckinlog`
--

DROP TABLE IF EXISTS `trcheckinlog`;
CREATE TABLE `trcheckinlog` (
  `fin_id` int(10) NOT NULL,
  `fst_sales_code` varchar(6) DEFAULT NULL,
  `fin_cust_id` int(10) DEFAULT NULL,
  `fdt_checkin_datetime` datetime DEFAULT NULL,
  `fst_checkin_location` varchar(128) DEFAULT NULL,
  `fin_distance_meters` int(10) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trcheckinlog`
--

INSERT INTO `trcheckinlog` (`fin_id`, `fst_sales_code`, `fin_cust_id`, `fdt_checkin_datetime`, `fst_checkin_location`, `fin_distance_meters`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(2, 'SLS01', 1, '2019-06-02 22:03:49', '-6.1825171,106.6749247', NULL, 'A', '2019-06-02 23:20:34', 1, NULL, NULL),
(3, 'SLS01', 1, '2019-06-02 22:04:23', '-6.1825207,106.6749234', NULL, 'A', '2019-06-02 23:20:37', 1, NULL, NULL),
(7, 'SLS01', 1, '2019-06-02 23:51:31', '-6.1825167,106.6749215', 0, 'A', '2019-06-03 00:02:57', 1, NULL, NULL),
(8, 'SLS01', 1, '2019-06-03 00:04:54', '-6.1825145,106.674923', 0, 'A', '2019-06-03 00:04:55', 1, NULL, NULL),
(9, 'SLS01', 1, '2019-06-03 00:05:53', '-6.1825148,106.6749248', 0, 'A', '2019-06-03 00:05:54', 1, NULL, NULL),
(10, 'SLS01', 1, '2019-06-03 08:42:44', '-6.1316062,106.7367022', 8870, 'A', '2019-06-03 13:58:12', 1, NULL, NULL),
(11, 'SLS01', 1, '2019-06-03 17:36:02', '-6.3021292,106.6680011', 13322, 'A', '2019-06-04 09:52:08', 1, NULL, NULL),
(12, 'SLS01', 1, '2019-06-04 18:09:46', '-6.1825053,106.674901', 3, 'A', '2019-06-04 18:09:45', 1, NULL, NULL),
(13, 'SLS01', 1, '2019-06-04 18:09:47', '-6.1825053,106.6749009', 3, 'A', '2019-06-04 18:09:48', 1, NULL, NULL),
(14, 'SLS01', 1, '2019-06-04 18:09:48', '-6.1825053,106.6749009', 3, 'A', '2019-06-04 18:09:49', 1, NULL, NULL),
(15, 'SLS01', 1, '2019-06-04 18:09:50', '-6.1825053,106.674901', 3, 'A', '2019-06-04 18:09:50', 1, NULL, NULL),
(16, 'SLS01', 1, '2019-06-04 18:10:01', '-6.182506,106.6749016', 3, 'A', '2019-06-04 18:10:03', 1, NULL, NULL),
(17, 'SLS01', 1, '2019-06-05 19:35:13', '-6.1825159,106.6749003', 3, 'A', '2019-06-05 19:35:15', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trtargetpercustomer`
--

DROP TABLE IF EXISTS `trtargetpercustomer`;
CREATE TABLE `trtargetpercustomer` (
  `fin_target_id` int(10) NOT NULL,
  `fst_cust_code` varchar(10) DEFAULT NULL,
  `fst_item_code` varchar(20) DEFAULT NULL,
  `fin_target` int(10) DEFAULT NULL,
  `fst_satuan` varchar(10) DEFAULT NULL,
  `fdt_date_start` date DEFAULT NULL,
  `fdt_date_end` date DEFAULT NULL,
  `fst_program_code` varchar(20) DEFAULT NULL,
  `fin_current_qty` int(10) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(10) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trtargetpercustomer`
--

INSERT INTO `trtargetpercustomer` (`fin_target_id`, `fst_cust_code`, `fst_item_code`, `fin_target`, `fst_satuan`, `fdt_date_start`, `fdt_date_end`, `fst_program_code`, `fin_current_qty`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'CODE-1', 'ITM-CODE-1', 100, 'KILO', '2019-06-01', '2019-06-30', 'PROG-TEST-CODE-1', 2, 'A', '2019-06-05 17:54:38', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `fin_user_id` bigint(20) UNSIGNED NOT NULL,
  `fst_username` varchar(50) NOT NULL,
  `fst_password` varchar(256) NOT NULL,
  `fst_fullname` varchar(256) NOT NULL,
  `fst_gender` enum('M','F') NOT NULL,
  `fdt_birthdate` date NOT NULL,
  `fst_birthplace` varchar(256) NOT NULL,
  `fst_address` text,
  `fst_phone` varchar(100) DEFAULT NULL,
  `fst_email` varchar(100) DEFAULT NULL,
  `fin_branch_id` int(5) NOT NULL,
  `fin_department_id` bigint(20) NOT NULL,
  `fin_group_id` bigint(20) DEFAULT NULL,
  `fbl_admin` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`fin_user_id`, `fst_username`, `fst_password`, `fst_fullname`, `fst_gender`, `fdt_birthdate`, `fst_birthplace`, `fst_address`, `fst_phone`, `fst_email`, `fin_branch_id`, `fin_department_id`, `fin_group_id`, `fbl_admin`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'devibong@yahoo.com', '06a6077b0cfcb0f4890fb5f2543c43be', 'Devi Bastian', 'M', '0000-00-00', '', NULL, NULL, NULL, 1, 1, 2, 0, 'A', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0),
(3, 'Donna@yahoo.com', '06a6077b0cfcb0f4890fb5f2543c43be', 'Donna Natalisa', 'M', '0000-00-00', '', NULL, NULL, NULL, 2, 1, 3, 0, 'A', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `tbcustomers`
--
ALTER TABLE `tbcustomers`
  ADD PRIMARY KEY (`fin_cust_id`);

--
-- Indeks untuk tabel `tbfreeitemperinvoice`
--
ALTER TABLE `tbfreeitemperinvoice`
  ADD KEY `fin_promo_id` (`fin_promo_id`);

--
-- Indeks untuk tabel `trcheckinlog`
--
ALTER TABLE `trcheckinlog`
  ADD KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `trtargetpercustomer`
--
ALTER TABLE `trtargetpercustomer`
  ADD KEY `fin_target_id` (`fin_target_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `fin_id` (`fin_user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbcustomers`
--
ALTER TABLE `tbcustomers`
  MODIFY `fin_cust_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT untuk tabel `tbfreeitemperinvoice`
--
ALTER TABLE `tbfreeitemperinvoice`
  MODIFY `fin_promo_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `trcheckinlog`
--
ALTER TABLE `trcheckinlog`
  MODIFY `fin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `trtargetpercustomer`
--
ALTER TABLE `trtargetpercustomer`
  MODIFY `fin_target_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `fin_user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
