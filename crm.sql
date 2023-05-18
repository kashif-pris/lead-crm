-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 15, 2021 at 05:38 AM
-- Server version: 8.0.24
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int UNSIGNED NOT NULL,
  `block_id` int DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `date_of_birth` varchar(100) NOT NULL,
  `avatar` text NOT NULL,
  `commission` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` date NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `project_id`, `block_id`, `name`, `email`, `mobile`, `city`, `address`, `date_of_birth`, `avatar`, `commission`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, NULL, 'Kashif Ali', 'kashif@gmail.com', '0307881628', 'Lahore', '<p>71 C3 Gulberg III,Lahore</p>', '2021-08-05 00:00:00', 'agents\\August2021\\3ONlT9o8tCrwhrgWfPHD.jpg', 5, '2021-08-20 12:48:37', '2021-08-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `allotments`
--

DROP TABLE IF EXISTS `allotments`;
CREATE TABLE IF NOT EXISTS `allotments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT 'date',
  `updated_at` varchar(45) DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `allotments`
--

INSERT INTO `allotments` (`id`, `customer_id`, `booking_id`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`, `type`) VALUES
(22, 4, 8, 'Approved', '2021-09-14 17:52:00', '2021-09-14 17:56:53', 1, 1, NULL, NULL),
(23, 4, 8, 'Pending', '2021-09-14 17:59:00', '2021-09-14 17:59:00', 1, NULL, NULL, 'duplicate');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `branch_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `branch_code`) VALUES
(1, 'UBL', '45757');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `project_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Block-A', 'Block-A', '2021-08-13 13:15:52', '2021-08-13 13:15:52'),
(2, 1, 'Block-B', 'Block-B', '2021-08-13 13:16:40', '2021-08-13 13:16:40'),
(3, 2, 'Block-A', 'N/A', '2021-08-13 13:17:29', '2021-08-13 13:17:29'),
(4, 3, 'Block-A', 'A1-A30', '2021-09-08 14:15:44', '2021-09-08 14:16:42'),
(5, 3, 'Block-B', 'B1-B50', '2021-09-08 14:17:03', '2021-09-08 14:17:03'),
(6, 3, 'Block-C', 'C1-C30', '2021-09-08 14:17:21', '2021-09-08 14:17:21'),
(7, 3, 'Block-D', 'D1-D20', '2021-09-08 14:17:42', '2021-09-08 14:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plot_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `agent_id` int DEFAULT NULL,
  `agent_commission` int DEFAULT NULL,
  `agent_amount` int DEFAULT NULL,
  `ref_num` varchar(111) NOT NULL,
  `ser_num` varchar(111) NOT NULL,
  `amount` int NOT NULL,
  `status` int NOT NULL COMMENT '0 = "unapproved"\r\n1 = "approved"',
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `plot_size` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `plot_id`, `customer_id`, `agent_id`, `agent_commission`, `agent_amount`, `ref_num`, `ser_num`, `amount`, `status`, `created_by`, `created_at`, `updated_at`, `plot_size`) VALUES
(8, 6, 4, 1, 5, 10, '34563456', '8', 194, 1, 7, '2021-09-10 18:20:58', '2021-09-14 11:56:29', '5-marla'),
(11, 9, 7, 1, 5, 283, '235235353', '9', 5666, 2, 7, '2021-09-13 11:16:21', '2021-09-14 11:51:28', '7-marla');

-- --------------------------------------------------------

--
-- Table structure for table `cancelations`
--

DROP TABLE IF EXISTS `cancelations`;
CREATE TABLE IF NOT EXISTS `cancelations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `fee` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `reason` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cancelations`
--

INSERT INTO `cancelations` (`id`, `booking_id`, `fee`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `reason`) VALUES
(1, 8, 75000, '1', 7, 1, '2021-09-10 18:47:08', '2021-09-14 17:08:16', ''),
(3, 8, 250000, '0', 7, NULL, '2021-09-10 19:15:45', '2021-09-10 19:15:45', 'Development Status'),
(4, 11, 567, '2', 7, 1, '2021-09-13 11:47:33', '2021-09-14 17:16:25', 'Development Charges'),
(5, 8, 250000, '1', 7, 1, '2021-09-13 17:42:05', '2021-09-14 17:12:13', 'Unsatisfactory Customer services');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(8, NULL, 2, '5 Marla', '5-marla', '2021-07-29 09:44:17', '2021-08-23 01:36:28'),
(9, NULL, 1, '3 Marla', '3-marla', '2021-07-29 09:44:45', '2021-08-23 01:35:36'),
(10, NULL, 1, '7 marla', '7-marla', '2021-08-23 01:40:34', '2021-08-23 01:40:34'),
(11, NULL, 1, '10 marla', '10-marla', '2021-08-23 01:40:45', '2021-08-23 01:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `son_of` varchar(45) DEFAULT NULL,
  `cnic` varchar(45) DEFAULT NULL,
  `passport_num` varchar(45) DEFAULT NULL,
  `mail_address` varchar(45) DEFAULT NULL,
  `permanent_address` varchar(45) DEFAULT NULL,
  `phone_1` varchar(45) DEFAULT NULL,
  `phone_2` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `son_of`, `cnic`, `passport_num`, `mail_address`, `permanent_address`, `phone_1`, `phone_2`, `email`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Amy Miller', 'Quos dicta maiores i', '645647', 'Et enim quaerat culp', '<p>Enim et aliquid a sa.</p>', '<p>Alias facere beatae .</p>', '67', '37', 'deqijixo@mailinator.com', 1, '2021-08-25 10:59:15', '2021-08-25 10:59:15', NULL),
(5, 'Jaquelyn Mendoza', 'Autem officia corrup', '32465456', '4546', '<p>Voluptate dolore des.</p>', '<p>Aliquam et mollit qu.</p>', '39', '59', 'dumu@mailinator.com', 1, '2021-08-26 06:04:57', '2021-08-26 06:04:57', NULL),
(6, 'Danielle Wall', 'Laboris dolor enim f', '456456', '53465456', '<p>Asperiores amet, per.</p>', '<p>Labore necessitatibu.</p>', '62', '15', 'tufib@mailinator.com', 1, '2021-08-26 06:05:13', '2021-08-26 06:05:13', NULL),
(7, 'Zain Ali Waheed', 'Waheed', '3530156902203', '235353453', '<p>Zain Near Office</p>', '<p>Zain Near Office</p>', '3252352345', '2353535', 'zain@gmail.com', 7, '2021-09-13 11:09:39', '2021-09-13 11:09:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

DROP TABLE IF EXISTS `data_rows`;
CREATE TABLE IF NOT EXISTS `data_rows` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `data_type_id` int UNSIGNED NOT NULL,
  `field` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, '{}', 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, '{}', 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, '{}', 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, '{}', 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
(21, 1, 'role_id', 'text', 'Role', 0, 1, 1, 1, 1, 1, '{}', 9),
(22, 4, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(23, 4, 'parent_id', 'select_dropdown', 'Parent', 0, 0, 0, 0, 0, 0, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(24, 4, 'order', 'text', 'Order', 1, 0, 0, 0, 0, 0, '{\"default\":1}', 3),
(25, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 4),
(26, 4, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(27, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, '{}', 6),
(28, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
(29, 5, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(30, 5, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, NULL, 2),
(31, 5, 'category_id', 'text', 'Category', 1, 0, 1, 1, 1, 0, NULL, 3),
(32, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 4),
(33, 5, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 5),
(34, 5, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 6),
(35, 5, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(36, 5, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:posts,slug\"}}', 8),
(37, 5, 'meta_description', 'text_area', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 9),
(38, 5, 'meta_keywords', 'text_area', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 10),
(39, 5, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(40, 5, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 12),
(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 13),
(42, 5, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, NULL, 14),
(43, 5, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, NULL, 15),
(44, 6, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(45, 6, 'author_id', 'text', 'Author', 1, 0, 0, 0, 0, 0, NULL, 2),
(46, 6, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 3),
(47, 6, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 4),
(48, 6, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 5),
(49, 6, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"},\"validation\":{\"rule\":\"unique:pages,slug\"}}', 6),
(50, 6, 'meta_description', 'text', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 7),
(51, 6, 'meta_keywords', 'text', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 8),
(52, 6, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(53, 6, 'created_at', 'timestamp', 'Created At', 1, 1, 1, 0, 0, 0, NULL, 10),
(54, 6, 'updated_at', 'timestamp', 'Updated At', 1, 0, 0, 0, 0, 0, NULL, 11),
(55, 6, 'image', 'image', 'Page Image', 0, 1, 1, 1, 1, 1, NULL, 12),
(79, 16, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(80, 16, 'author_id', 'number', 'Author Id', 1, 0, 0, 0, 0, 0, '{}', 2),
(81, 16, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 3),
(82, 16, 'image_url', 'image', 'Image', 1, 0, 0, 1, 1, 1, '{}', 4),
(83, 16, 'isbn', 'text', 'ISBN', 1, 1, 1, 1, 1, 1, '{}', 5),
(84, 16, 'year_of_publication', 'date', 'Year', 1, 1, 1, 1, 1, 1, '{\"format\":\"Y\"}', 6),
(85, 16, 'category_id', 'select_dropdown', 'Category', 1, 1, 1, 1, 1, 1, 'null', 7),
(86, 16, 'subjects', 'text', 'Subjects', 1, 1, 1, 1, 1, 1, '{}', 8),
(87, 16, 'tags', 'text', 'Tags', 0, 1, 1, 1, 1, 1, '{}', 9),
(88, 16, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 10),
(89, 16, 'edition', 'text', 'Edition', 0, 1, 1, 1, 1, 1, '{}', 11),
(90, 16, 'numberOfPages', 'number', 'Pages', 1, 1, 1, 1, 1, 1, '{}', 12),
(91, 16, 'URL', 'text', 'URL', 0, 0, 0, 0, 0, 0, '{}', 13),
(92, 16, 'manufacturer', 'text', 'Manufacturer', 0, 0, 0, 0, 0, 0, '{}', 14),
(93, 16, 'publisher_link', 'text', 'Publisher Link', 0, 0, 0, 0, 0, 0, '{}', 15),
(94, 16, 'status', 'radio_btn', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"radio1\",\"options\":{\"0\":\"Draft\",\"1\":\"Active\"}}', 16),
(95, 16, 'similar_books', 'select_multiple', 'Similar Books', 0, 0, 0, 1, 1, 1, '{}', 17),
(96, 16, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 18),
(97, 16, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 19),
(98, 16, 'created_by', 'number', 'Created By', 0, 0, 0, 0, 0, 0, '{}', 20),
(99, 16, 'updated_by', 'number', 'Updated By', 0, 0, 0, 0, 0, 0, '{}', 21),
(100, 16, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 22),
(101, 16, 'deleted_by', 'number', 'Deleted By', 0, 0, 0, 0, 0, 0, '{}', 23),
(102, 17, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(103, 17, 'user_id', 'text', 'User Id', 0, 0, 0, 0, 0, 0, '{}', 2),
(104, 17, 'author_name', 'text', 'Author Name', 1, 1, 1, 1, 1, 1, '{}', 3),
(105, 17, 'image_url', 'image', 'Profile Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 4),
(106, 17, 'thumb_image_url', 'text', 'Thumb Image Url', 0, 0, 0, 0, 0, 0, '{}', 5),
(107, 17, 'profile_url', 'text', 'Profile Url', 0, 0, 0, 0, 0, 0, '{}', 6),
(108, 17, 'twitter_url', 'text', 'Twitter Url', 0, 0, 0, 1, 1, 0, '{}', 7),
(109, 17, 'facebook_url', 'text', 'Facebook Url', 0, 0, 0, 1, 1, 0, '{}', 8),
(110, 17, 'date_of_birth', 'date', 'Date Of Birth', 0, 0, 0, 1, 1, 0, '{}', 9),
(111, 17, 'city', 'text', 'City', 0, 1, 1, 1, 1, 1, '{}', 10),
(112, 17, 'state', 'text', 'State', 0, 1, 1, 1, 1, 1, '{}', 11),
(113, 17, 'country', 'text', 'Country', 0, 1, 1, 1, 1, 1, '{}', 12),
(114, 17, 'weekly_ranking', 'text', 'Weekly Ranking', 0, 0, 0, 0, 0, 0, '{}', 13),
(115, 17, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 14),
(116, 17, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 15),
(117, 17, 'created_by', 'hidden', 'Created By', 0, 0, 0, 0, 0, 0, '{}', 16),
(118, 17, 'updated_by', 'text', 'Updated By', 0, 0, 0, 0, 0, 0, '{}', 17),
(119, 17, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 18),
(120, 17, 'deleted_by', 'text', 'Deleted By', 0, 0, 0, 0, 0, 0, '{}', 19),
(121, 17, 'approval_status', 'radio_btn', 'Approval Status', 0, 1, 1, 1, 1, 1, '{\"default\":\"1\",\"options\":{\"0\":\"Pending\",\"1\":\"Approved\"}}', 20),
(122, 17, 'meta_keywords', 'text', 'Meta Keywords', 0, 0, 1, 1, 1, 1, '{}', 14),
(123, 17, 'meta_title', 'text', 'Meta Title', 0, 0, 1, 1, 1, 1, '{}', 15),
(124, 17, 'meta_description', 'text', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 16),
(125, 17, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"author_name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:authors,slug\"}}', 17),
(126, 17, 'bio', 'text_area', 'Bio', 0, 0, 1, 1, 1, 1, '{}', 13),
(132, 21, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(133, 21, 'project_name', 'text', 'Project Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(134, 21, 'description', 'rich_text_box', 'Description', 0, 1, 1, 1, 1, 1, '{}', 3),
(135, 21, 'created_at', 'date', 'Created At', 0, 0, 1, 1, 1, 1, '{}', 4),
(136, 21, 'updated_at', 'text', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(137, 22, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(138, 22, 'project_name', 'text', 'Project Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(139, 22, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 3),
(140, 22, 'created_at', 'text', 'Created At', 0, 1, 1, 1, 1, 1, '{}', 4),
(141, 22, 'updated_at', 'text', 'Updated At', 0, 1, 1, 1, 1, 1, '{}', 5),
(142, 23, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(143, 23, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(144, 23, 'description', 'text', 'Description', 1, 1, 1, 1, 1, 1, '{}', 5),
(145, 23, 'created_at', 'text', 'Created At', 1, 0, 0, 0, 0, 0, '{}', 6),
(146, 23, 'updated_at', 'text', 'Updated At', 1, 0, 0, 0, 0, 0, '{}', 7),
(147, 23, 'project_id', 'select_dropdown', 'Project Id', 1, 1, 1, 1, 1, 1, '{}', 3),
(148, 21, 'project_hasmany_block_relationship', 'relationship', 'blocks', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Block\",\"table\":\"blocks\",\"type\":\"hasMany\",\"column\":\"project_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"blocks\",\"pivot\":\"0\",\"taggable\":\"0\"}', 6),
(149, 23, 'block_belongsto_project_relationship', 'relationship', 'Project', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Project\",\"table\":\"projects\",\"type\":\"belongsTo\",\"column\":\"project_id\",\"key\":\"id\",\"label\":\"project_name\",\"pivot_table\":\"blocks\",\"pivot\":\"0\",\"taggable\":\"0\"}', 4),
(150, 25, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(151, 25, 'parent_id', 'text', 'Parent Id', 0, 0, 0, 0, 0, 0, '{}', 2),
(152, 25, 'order', 'text', 'Order', 1, 0, 1, 1, 1, 1, '{}', 3),
(153, 25, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 4),
(154, 25, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(155, 25, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 6),
(156, 25, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
(157, 26, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(158, 26, 'order', 'text', 'Order', 1, 0, 1, 1, 1, 1, '{}', 2),
(159, 26, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 3),
(160, 26, 'fee', 'text', 'Fee', 1, 1, 1, 1, 1, 1, '{}', 4),
(161, 26, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(162, 26, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 6),
(163, 26, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
(164, 28, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(165, 28, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(166, 28, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 3),
(167, 28, 'mobile', 'number', 'Mobile', 1, 1, 1, 1, 1, 1, '{}', 4),
(168, 28, 'city', 'text', 'City', 1, 1, 1, 1, 1, 1, '{}', 5),
(169, 28, 'address', 'rich_text_box', 'Address', 1, 1, 1, 1, 1, 1, '{}', 6),
(170, 28, 'date_of_birth', 'date', 'Date Of Birth', 1, 0, 1, 1, 1, 1, '{}', 7),
(171, 28, 'avatar', 'image', 'Profile Image', 1, 0, 1, 1, 1, 1, '{}', 8),
(173, 28, 'commission', 'number', 'Commission (%)', 1, 1, 1, 1, 1, 1, '{}', 10),
(174, 28, 'created_at', 'text', 'Created At', 1, 0, 0, 0, 0, 0, '{}', 11),
(175, 28, 'updated_at', 'text', 'Updated At', 1, 0, 0, 0, 0, 0, '{}', 12),
(176, 28, 'created_by', 'text', 'Created By', 0, 0, 0, 0, 0, 0, '{}', 13),
(177, 28, 'updated_by', 'text', 'Updated By', 0, 0, 0, 0, 0, 0, '{}', 14),
(178, 21, 'project_hasmany_agent_relationship', 'relationship', 'agents', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Agent\",\"table\":\"agents\",\"type\":\"hasMany\",\"column\":\"project_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":null}', 7),
(179, 28, 'agent_belongsto_project_relationship', 'relationship', 'Project', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Project\",\"table\":\"projects\",\"type\":\"belongsTo\",\"column\":\"project_id\",\"key\":\"id\",\"label\":\"project_name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 15),
(180, 28, 'project_id', 'text', 'Project Id', 1, 1, 1, 1, 1, 1, '{}', 2),
(181, 28, 'block_id', 'text', 'Block Id', 0, 0, 0, 0, 0, 0, '{}', 3),
(182, 30, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(183, 30, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{}', 2),
(184, 30, 'son_of', 'text', 'Son Of', 0, 1, 1, 1, 1, 1, '{}', 3),
(185, 30, 'cnic', 'text', 'Cnic', 0, 1, 1, 1, 1, 1, '{}', 4),
(186, 30, 'passport_num', 'text', 'Passport Num', 0, 1, 1, 1, 1, 1, '{}', 5),
(187, 30, 'mail_address', 'rich_text_box', 'Mail Address', 0, 1, 1, 1, 1, 1, '{}', 6),
(188, 30, 'permanent_address', 'rich_text_box', 'Permanent Address', 0, 1, 1, 1, 1, 1, '{}', 7),
(189, 30, 'phone_1', 'number', 'Phone 1', 0, 1, 1, 1, 1, 1, '{}', 8),
(190, 30, 'phone_2', 'number', 'Phone 2', 0, 1, 1, 1, 1, 1, '{}', 9),
(191, 30, 'email', 'text', 'Email', 0, 1, 1, 1, 1, 1, '{}', 10),
(192, 30, 'created_by', 'text', 'Created By', 0, 0, 0, 0, 0, 0, '{}', 11),
(193, 30, 'created_at', 'text', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 12),
(194, 30, 'updated_at', 'text', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 13),
(195, 30, 'deleted_at', 'text', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 14),
(197, 1, 'user_hasmany_customer_relationship', 'relationship', 'customers', 0, 1, 1, 1, 1, 1, '{\"scope\":\"getUser\",\"model\":\"App\\\\Models\\\\Customer\",\"table\":\"customers\",\"type\":\"hasMany\",\"column\":\"created_by\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 13),
(198, 1, 'email_verified_at', 'timestamp', 'Email Verified At', 0, 1, 1, 1, 1, 1, '{}', 6),
(199, 30, 'customer_belongsto_user_relationship', 'relationship', 'Created By', 0, 1, 1, 0, 0, 0, '{\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"created_by\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 15),
(200, 32, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(201, 32, 'key', 'text', 'Key', 1, 1, 1, 1, 1, 1, '{}', 2),
(202, 32, 'table_name', 'text', 'Table Name', 0, 1, 1, 1, 1, 1, '{}', 3),
(203, 32, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
(204, 32, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
CREATE TABLE IF NOT EXISTS `data_types` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2021-05-25 08:34:44', '2021-08-25 05:24:07'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2021-05-25 08:34:44', '2021-08-23 01:42:14'),
(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, NULL, '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, NULL, '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(16, 'books', 'books', 'Book', 'Books', 'voyager-logbook', 'App\\Book', NULL, 'TCG\\Voyager\\Http\\Controllers\\BookController', NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-07-29 09:32:36', '2021-08-03 08:57:43'),
(17, 'authors', 'authors', 'Author', 'Authors', 'voyager-people', 'App\\Author', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-04 10:59:40', '2021-08-10 09:18:52'),
(21, 'projects', 'projects', 'Projects', 'Projects', 'voyager-pie-chart', 'App\\Project', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-13 07:36:31', '2021-08-17 04:02:50'),
(22, 'projects', 'projects', 'Projects', 'Projects', 'voyager-pie-chart', 'App\\Project', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2021-08-13 07:36:42', '2021-08-13 07:36:42'),
(23, 'blocks', 'blocks', 'Block', 'Blocks', 'voyager-documentation', 'App\\Block', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-13 07:59:19', '2021-08-13 08:16:23'),
(25, 'features', 'features', 'Feature', 'Features', 'voyager-paw', 'App\\Feature', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-17 03:29:07', '2021-08-17 03:42:24'),
(26, 'fee_setup', 'fee-setup', 'Fee Setup', 'Fee Setups', 'voyager-double-right', 'App\\FeeSetup', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-17 03:49:47', '2021-08-17 03:58:28'),
(28, 'agents', 'agents', 'Agent', 'Agents', 'voyager-people', 'App\\Agent', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-20 07:44:35', '2021-08-20 07:59:11'),
(30, 'customers', 'customers', 'Customer', 'Customers', NULL, 'App\\Models\\Customer', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2021-08-25 05:06:52', '2021-08-25 06:00:08'),
(32, 'permissions', 'permissions', 'Permission', 'Permissions', NULL, 'TCG\\Voyager\\Models\\Permission', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2021-09-02 06:42:35', '2021-09-02 06:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `event_value` int NOT NULL,
  `file_id` int NOT NULL,
  `file` varchar(111) NOT NULL,
  `path` varchar(111) NOT NULL,
  `customer_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `event_id`, `event_value`, `file_id`, `file`, `path`, `customer_id`) VALUES
(1, 13, 2, 41, '1631013221258.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(2, 13, 2, 37, '1631013221208.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(3, 13, 2, 40, '1631013221635.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(4, 13, 2, 39, '1631013221463.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(5, 13, 2, 38, '1631013221317.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(6, 13, 2, 36, '1631013221821.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(7, 13, 2, 42, '1631013221868.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(8, 13, 2, 43, '1631013221378.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(9, 13, 2, 44, '1631013221893.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(10, 13, 3, 41, '1631013337572.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(11, 13, 3, 37, '1631013337234.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(12, 13, 3, 40, '1631013337888.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(13, 13, 3, 39, '1631013337691.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(14, 13, 3, 38, '1631013337899.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(15, 13, 3, 36, '1631013337688.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(16, 13, 3, 42, '1631013337214.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(17, 13, 3, 43, '1631013337251.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(18, 13, 3, 44, '1631013337472.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Booking', '5'),
(19, 14, 2, 58, '1631013496438.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(20, 14, 2, 59, '1631013496879.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(21, 13, 4, 41, '1631014945234.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(22, 13, 4, 37, '1631014945925.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(23, 13, 4, 40, '1631014945616.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(24, 13, 4, 39, '1631014945259.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(25, 13, 4, 38, '1631014945122.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(26, 13, 4, 36, '1631014945864.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(27, 13, 4, 42, '1631014945465.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(28, 13, 4, 43, '1631014945380.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(29, 13, 4, 44, '1631014945553.jpeg', 'Storage/Files/2-1-2/Danielle Wall/Booking', '6'),
(30, 14, 3, 58, '1631015040474.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(31, 14, 3, 59, '1631015040906.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(32, 14, 4, 60, '1631016140491.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(33, 14, 4, 61, '1631016141335.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(34, 14, 5, 60, '1631016209459.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(35, 14, 5, 61, '1631016209327.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(36, 14, 6, 60, '1631016247756.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(37, 14, 6, 61, '1631016247664.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(38, 13, 5, 41, '1631017086155.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(39, 13, 5, 37, '1631017086187.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(40, 13, 5, 40, '1631017086735.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(41, 13, 5, 39, '1631017086851.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(42, 13, 5, 38, '1631017086126.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(43, 13, 5, 36, '1631017086241.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(44, 13, 5, 42, '1631017086935.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(45, 13, 5, 43, '1631017086711.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(46, 13, 5, 44, '1631017086667.jpeg', 'Storage/Files/1-1-6/Jaquelyn Mendoza/Booking', '5'),
(47, 14, 7, 60, '1631019175119.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(48, 14, 7, 61, '1631019175656.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(49, 13, 6, 41, '1631093419675.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(50, 13, 6, 37, '1631093419818.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(51, 13, 6, 40, '1631093419781.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(52, 13, 6, 39, '1631093419257.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(53, 13, 6, 38, '1631093419867.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(54, 13, 6, 36, '1631093419315.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(55, 13, 6, 42, '1631093419422.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(56, 13, 6, 43, '1631093419207.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(57, 13, 6, 44, '1631093419158.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Booking', '6'),
(58, 15, 20, 47, '1631094489154.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(59, 15, 20, 48, '1631094489422.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(60, 15, 20, 49, '1631094489653.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(61, 15, 20, 50, '1631094489338.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(62, 15, 20, 51, '1631094489372.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(63, 15, 20, 52, '1631094489211.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(64, 15, 20, 53, '1631094489545.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(65, 15, 20, 54, '1631094489438.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(66, 15, 20, 55, '1631094489682.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(67, 15, 20, 56, '1631094489297.jpeg', 'Storage/Files/3-5-12/Danielle Wall/Transfer', '6'),
(68, 15, 20, 47, '1631094489321.jpeg', 'Storage/Files/3-5-12/Jaquelyn Mendoza/Transfer', '5'),
(69, 15, 20, 48, '1631094489232.jpeg', 'Storage/Files/3-5-12/Jaquelyn Mendoza/Transfer', '5'),
(70, 15, 20, 49, '1631094489785.jpeg', 'Storage/Files/3-5-12/Jaquelyn Mendoza/Transfer', '5'),
(71, 14, 9, 58, '1631103307652.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(72, 14, 9, 59, '1631103307953.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(73, 14, 10, 60, '1631105355859.pdf', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(74, 14, 10, 61, '1631105355878.pdf', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(75, 14, 11, 60, '1631174031644.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(76, 14, 11, 61, '1631174031813.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(77, 14, 12, 58, '1631174301142.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(78, 14, 12, 59, '1631174301944.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(79, 14, 13, 60, '1631174336924.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(80, 14, 13, 61, '1631174336143.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(81, 14, 14, 58, '1631174388188.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(82, 14, 14, 59, '1631174388640.pptx', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(83, 14, 15, 60, '1631174430604.jpg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(84, 14, 15, 61, '1631174430138.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(85, 14, 16, 58, '1631174899521.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(86, 14, 16, 59, '1631174899602.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(87, 14, 17, 58, '1631179236492.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(88, 14, 17, 59, '1631179236899.png', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(89, 14, 18, 58, '1631180019611.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(90, 14, 18, 59, '1631180019606.jpeg', 'Storage/Files/1-3-1/Jaquelyn Mendoza/Allotment', '5'),
(91, 16, 5, 62, '1631186326653.jpeg', 'Storage/Files/1-1-5/Amy Miller/Merge', '4'),
(92, 13, 7, 41, '1631279622656.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(93, 13, 7, 37, '1631279622460.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(94, 13, 7, 40, '1631279622730.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(95, 13, 7, 39, '1631279622609.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(96, 13, 7, 38, '1631279622166.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(97, 13, 7, 36, '1631279622205.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(98, 13, 7, 42, '1631279623729.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(99, 13, 7, 43, '1631279623842.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(100, 13, 7, 44, '1631279623572.jpeg', 'Storage/Files/2-2-11/Jaquelyn Mendoza/Booking', '5'),
(101, 13, 8, 41, '1631280058504.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(102, 13, 8, 37, '1631280058130.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(103, 13, 8, 40, '1631280058403.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(104, 13, 8, 39, '1631280058826.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(105, 13, 8, 38, '1631280058951.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(106, 13, 8, 36, '1631280058263.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(107, 13, 8, 42, '1631280058118.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(108, 13, 8, 43, '1631280058638.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(109, 13, 8, 44, '1631280058608.jpeg', 'Storage/Files/1-1-5/Amy Miller/Booking', '4'),
(110, 19, 2, 63, '1631281659425.jpeg', 'Storage/Files/1-1-5/Amy Miller/Merge', '4'),
(111, 19, 2, 64, '1631281659102.jpeg', 'Storage/Files/1-1-5/Amy Miller/Merge', '4'),
(112, 19, 2, 65, '1631281659473.jpeg', 'Storage/Files/1-1-5/Amy Miller/Merge', '4'),
(113, 19, 3, 63, '1631283345662.jpeg', 'Storage/Files/1-1-5/Amy Miller/Cancelation', '4'),
(114, 19, 3, 64, '1631283345258.jpeg', 'Storage/Files/1-1-5/Amy Miller/Cancelation', '4'),
(115, 19, 3, 65, '1631283345982.jpeg', 'Storage/Files/1-1-5/Amy Miller/Cancelation', '4'),
(116, 14, 19, 58, '1631283924996.jpeg', 'Storage/Files/1-1-5/Amy Miller/Allotment', '4'),
(117, 14, 19, 59, '1631283924453.jpeg', 'Storage/Files/1-1-5/Amy Miller/Allotment', '4'),
(118, 13, 10, 41, '1631513698870.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(119, 13, 10, 37, '1631513698498.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(120, 13, 10, 40, '1631513698549.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(121, 13, 10, 39, '1631513698674.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(122, 13, 10, 38, '1631513698326.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(123, 13, 10, 36, '1631513698914.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(124, 13, 10, 42, '1631513698171.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(125, 13, 10, 43, '1631513698249.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(126, 13, 10, 44, '1631513698638.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(127, 13, 11, 41, '1631513781924.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(128, 13, 11, 37, '1631513781143.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(129, 13, 11, 40, '1631513781283.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(130, 13, 11, 39, '1631513781328.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(131, 13, 11, 38, '1631513781330.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(132, 13, 11, 36, '1631513781606.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(133, 13, 11, 42, '1631513781560.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(134, 13, 11, 43, '1631513781736.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(135, 13, 11, 44, '1631513781627.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Booking', '7'),
(136, 19, 4, 63, '1631515653651.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Cancelation', '7'),
(137, 19, 4, 64, '1631515653795.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Cancelation', '7'),
(138, 19, 4, 65, '1631515653292.jpeg', 'Storage/Files/1-2-9/Zain Ali Waheed/Cancelation', '7'),
(139, 19, 5, 63, '1631536925753.jpg', 'Storage/Files/1-1-5/Amy Miller/Cancelation', '4'),
(140, 19, 5, 64, '1631536926897.jpeg', 'Storage/Files/1-1-5/Amy Miller/Cancelation', '4'),
(141, 19, 5, 65, '1631536926743.jpeg', 'Storage/Files/1-1-5/Amy Miller/Cancelation', '4'),
(142, 14, 22, 58, '1631623975174.jpeg', 'Storage/Files/1-1-5/Amy Miller/Allotment', '4'),
(143, 14, 22, 59, '1631623975902.png', 'Storage/Files/1-1-5/Amy Miller/Allotment', '4'),
(144, 14, 23, 60, '1631624392696.gif', 'Storage/Files/1-1-5/Amy Miller/Allotment', '4'),
(145, 14, 23, 61, '1631624392978.gif', 'Storage/Files/1-1-5/Amy Miller/Allotment', '4');

-- --------------------------------------------------------

--
-- Table structure for table `down_payments`
--

DROP TABLE IF EXISTS `down_payments`;
CREATE TABLE IF NOT EXISTS `down_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `amount` float NOT NULL,
  `p_type` varchar(11) NOT NULL,
  `p_method` int NOT NULL,
  `bank_id` int DEFAULT NULL,
  `receipt` varchar(111) DEFAULT NULL,
  `cheque` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `p_order` varchar(111) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `down_payments`
--

INSERT INTO `down_payments` (`id`, `booking_id`, `amount`, `p_type`, `p_method`, `bank_id`, `receipt`, `cheque`, `p_order`, `date`) VALUES
(3, 3, 50000, 'full', 2, 1, '0000', 'dfgbdrgr', 'Kashif', '2021-09-23'),
(4, 4, 40000, 'full', 3, 1, 'etegrtet', '0000', '0000', '2021-10-01'),
(5, 5, 30000, 'full', 4, 1, '0000', '0000', '0000', '2021-09-29'),
(6, 6, 100000, 'partial', 2, 1, '0000', '0000', 'Kashif', '2021-09-09'),
(7, 7, 235345000, 'full', 2, 1, '0000', NULL, 'Kashif', '2021-09-23'),
(8, 8, 346346, 'full', 3, 1, '0000', '0000', '0000', '2021-09-17'),
(10, 11, 500000, 'full', 2, 1, '0000', '0000', '0000', '2021-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
CREATE TABLE IF NOT EXISTS `features` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(8, NULL, 2, 'Facing', 'facing', '2021-07-29 09:44:17', '2021-08-17 03:29:57'),
(9, NULL, 1, 'Corner', 'corner', '2021-07-29 09:44:45', '2021-08-17 03:29:42'),
(10, NULL, 3, 'Park', 'park', '2021-08-17 03:41:24', '2021-08-17 03:41:32'),
(11, NULL, 4, 'Bloulevard', 'bloulevard', '2021-08-17 03:41:54', '2021-08-17 03:41:54'),
(12, NULL, 5, 'General', 'general', '2021-08-17 03:42:07', '2021-08-17 03:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `fee_setup`
--

DROP TABLE IF EXISTS `fee_setup`;
CREATE TABLE IF NOT EXISTS `fee_setup` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` double NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_setup`
--

INSERT INTO `fee_setup` (`id`, `order`, `name`, `fee`, `slug`, `created_at`, `updated_at`) VALUES
(13, 1, 'Registration', 0, 'registration', '2021-08-17 03:53:17', '2021-08-17 03:53:17'),
(14, 2, 'Allotment Certificate', 2000, 'allotment-certificate', '2021-08-17 03:53:55', '2021-08-17 03:53:55'),
(15, 3, 'Transfer Of Plot', 3500, 'transfer-of-plot', '2021-08-17 03:54:15', '2021-08-17 03:54:15'),
(16, 4, 'Merger Of Plot', 4000, 'merger-of-plot', '2021-08-17 03:55:07', '2021-08-17 03:55:07'),
(17, 5, 'Upgradation', 3000, 'upgradation', '2021-08-17 03:55:26', '2021-08-17 03:55:26'),
(18, 6, 'Down Gradation', 2000, 'down-gradation', '2021-08-17 03:55:41', '2021-08-17 03:55:41'),
(19, 7, 'Cancelation Of Plot', 3500, 'cancelation-of-plot', '2021-08-17 03:56:02', '2021-08-17 03:56:02'),
(20, 8, 'Possession Fee', 2000, 'possession-fee', '2021-08-17 03:56:29', '2021-08-17 03:56:29'),
(21, 9, 'Development Charges', 3000, 'development-charges', '2021-08-17 03:56:49', '2021-08-17 03:56:49'),
(22, 13, 'Duplicate Allotment', 0, 'duplicate-allotment', '2021-09-07 11:49:10', '2021-09-07 11:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `form_documents`
--

DROP TABLE IF EXISTS `form_documents`;
CREATE TABLE IF NOT EXISTS `form_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `title` varchar(191) NOT NULL,
  `system_value` varchar(191) DEFAULT NULL,
  `is_required` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form_documents`
--

INSERT INTO `form_documents` (`id`, `form_id`, `title`, `system_value`, `is_required`, `created_at`, `updated_at`) VALUES
(41, 13, 'Nominee CNIC Copy / Passport', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(37, 13, 'CNIC Front', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(40, 13, 'CNIC Copies Of Joint Owners', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(39, 13, 'BForm', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(38, 13, 'CNIC Back', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(36, 13, 'Profile Image', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(42, 13, 'Terms & Conditions Signed By Customer', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(43, 13, 'Down Payment Receipt', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(44, 13, 'Client Introduction Letter', NULL, 'required', '2021-08-20 11:52:40', '2021-08-20 11:52:40'),
(47, 15, 'Application Form', 'application_form', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(48, 15, 'Booking Form (Orginal)', 'booking_form', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(49, 15, 'Seller / Buyer', 'seller_buyer', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(50, 15, 'Authority Holder Photo', 'authority_holder_photo', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(51, 15, 'Transfer Fee Copy', 'transfer_fee_copy', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(52, 15, 'Valid NDC', 'ndc', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(53, 15, 'Valid Payment Plan', 'payment_plan', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(54, 15, 'Ensure Surcharge Report Matches With Installment', 'surcharge', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(55, 15, 'Ensure There  Are No Wrong Entries In Surcharge Report', 'surcharge', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(56, 15, 'Ensure Seller Data Is Same In Affidavit As In Booking Form And System', 'seller_data', 'required', '2021-09-02 12:55:48', '2021-09-02 12:55:48'),
(58, 14, 'CNIC Copy', 'cnic', 'required', '2021-09-03 10:12:41', '2021-09-03 10:12:41'),
(59, 14, 'Installment Clearance Certificate', 'clearance_certificate', 'required', '2021-09-03 10:12:41', '2021-09-03 10:12:41'),
(60, 22, 'Original PAC Picture /  FIR (If Lost)', 'original_pac', 'required', '2021-09-07 16:50:24', '2021-09-07 16:50:24'),
(61, 22, 'CNIC Copy', 'cnic', 'required', '2021-09-07 16:50:24', '2021-09-07 16:50:24'),
(62, 16, 'CNIC Copy', 'cnic', 'required', '2021-09-09 16:17:58', '2021-09-09 16:17:58'),
(63, 19, 'CNIC Copy', 'cnic', 'required', '2021-09-09 17:26:38', '2021-09-09 17:26:38'),
(64, 19, 'Down Payment Receipt', 'down_payment_receipt', 'required', '2021-09-09 17:26:38', '2021-09-09 17:26:38'),
(65, 19, 'Allotment Certificate', 'allotment_certifacte', 'required', '2021-09-09 17:26:38', '2021-09-09 17:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2021-05-25 08:34:44', '2021-05-25 08:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 2, '2021-05-25 08:34:44', '2021-09-14 05:36:57', 'voyager.dashboard', NULL),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, NULL, 7, '2021-05-25 08:34:44', '2021-09-09 11:24:45', 'voyager.media.index', NULL),
(3, 1, 'Users', '', '_self', 'voyager-person', NULL, NULL, 3, '2021-05-25 08:34:44', '2021-05-25 08:34:44', 'voyager.users.index', NULL),
(4, 1, 'Roles', '', '_self', 'voyager-lock', NULL, NULL, 1, '2021-05-25 08:34:44', '2021-09-14 05:36:57', 'voyager.roles.index', NULL),
(5, 1, 'Tools', '', '_self', 'voyager-tools', NULL, NULL, 15, '2021-05-25 08:34:44', '2021-09-14 09:50:03', NULL, NULL),
(6, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 5, 1, '2021-05-25 08:34:44', '2021-07-26 09:09:34', 'voyager.menus.index', NULL),
(7, 1, 'Database', '', '_self', 'voyager-data', NULL, 5, 2, '2021-05-25 08:34:44', '2021-07-26 09:09:34', 'voyager.database.index', NULL),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 3, '2021-05-25 08:34:44', '2021-07-26 09:09:34', 'voyager.compass.index', NULL),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 4, '2021-05-25 08:34:44', '2021-07-26 09:09:34', 'voyager.bread.index', NULL),
(10, 1, 'Settings', '', '_self', 'voyager-settings', NULL, NULL, 16, '2021-05-25 08:34:44', '2021-09-14 09:50:03', 'voyager.settings.index', NULL),
(11, 1, 'Categories', '', '_self', 'voyager-categories', NULL, 18, 3, '2021-05-25 08:34:44', '2021-09-14 09:50:03', 'voyager.categories.index', NULL),
(12, 1, 'Posts', '', '_self', 'voyager-news', NULL, NULL, 8, '2021-05-25 08:34:45', '2021-09-09 11:24:45', 'voyager.posts.index', NULL),
(13, 1, 'Pages', '', '_self', 'voyager-file-text', NULL, NULL, 6, '2021-05-25 08:34:45', '2021-09-09 11:24:45', 'voyager.pages.index', NULL),
(14, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 5, 5, '2021-05-25 08:34:45', '2021-07-26 09:09:34', 'voyager.hooks', NULL),
(18, 1, 'System Setup', '', '_self', 'voyager-pie-chart', '#000000', NULL, 9, '2021-08-13 07:36:42', '2021-09-09 11:24:58', 'voyager.projects.index', 'null'),
(19, 1, 'Blocks', '', '_self', 'voyager-documentation', NULL, 18, 2, '2021-08-13 07:59:19', '2021-08-13 08:06:17', 'voyager.blocks.index', NULL),
(20, 1, 'Projects', 'admin/projects', '_self', 'voyager-file-text', '#000000', 18, 1, '2021-08-13 08:06:05', '2021-08-17 04:21:35', NULL, ''),
(21, 1, 'Features', '', '_self', 'voyager-paw', NULL, 18, 4, '2021-08-17 03:29:07', '2021-09-14 09:50:03', 'voyager.features.index', NULL),
(22, 1, 'Fee Setups', '', '_self', NULL, NULL, 18, 6, '2021-08-17 03:49:47', '2021-09-14 09:50:03', 'voyager.fee-setup.index', NULL),
(23, 1, 'Documents', 'admin/document', '_self', 'voyager-news', '#000000', 18, 7, '2021-08-17 06:37:33', '2021-09-14 09:50:03', NULL, ''),
(24, 1, 'Agents', '', '_self', 'voyager-people', NULL, NULL, 4, '2021-08-20 07:44:35', '2021-08-25 06:12:13', 'voyager.agents.index', NULL),
(25, 1, 'Plots', '/admin/plot/create', '_self', 'voyager-pie-chart', '#000000', 18, 5, '2021-08-23 02:47:45', '2021-09-14 09:50:03', NULL, ''),
(26, 1, 'Booking Form', '/admin/application-form', '_self', 'voyager-file-text', '#09b3b0', 34, 1, '2021-08-25 04:50:56', '2021-09-09 08:16:10', NULL, ''),
(27, 1, 'Customers', '', '_self', 'voyager-people', '#09b3b0', NULL, 5, '2021-08-25 05:06:52', '2021-08-25 06:12:13', 'voyager.customers.index', 'null'),
(28, 1, 'Allotments', '', '_self', 'voyager-news', '#000000', NULL, 11, '2021-08-30 04:05:48', '2021-09-14 09:50:11', NULL, ''),
(30, 1, 'Pending Requests', '/admin/pac/pending', '_self', 'voyager-forward', '#000000', 28, 1, '2021-08-30 04:11:04', '2021-09-09 08:08:03', NULL, ''),
(31, 1, 'Approved', '/admin/pac/approved', '_self', 'voyager-forward', '#000000', 28, 2, '2021-08-30 04:12:34', '2021-09-09 08:15:29', NULL, ''),
(32, 1, 'Delivered', '/admin/pac/delivered', '_self', 'voyager-check-circle', '#000000', 28, 3, '2021-08-30 04:13:16', '2021-09-09 08:15:29', NULL, ''),
(33, 1, 'Create Request', '/admin/pac/create', '_self', 'voyager-zoom-in', '#000000', 28, 4, '2021-08-30 04:23:12', '2021-09-09 08:15:29', NULL, ''),
(34, 1, 'Booking', '/', '_self', 'voyager-file-text', '#000000', NULL, 10, '2021-08-30 06:38:15', '2021-09-14 09:50:11', NULL, ''),
(35, 1, 'Booking List', '/admin/application-form/record', '_self', 'voyager-file-text', '#000000', 34, 2, '2021-08-30 06:39:15', '2021-09-09 08:16:10', NULL, ''),
(36, 1, 'Transfer Plot', '#', '_self', 'voyager-pie-chart', '#000000', NULL, 12, '2021-09-02 00:35:37', '2021-09-14 09:50:03', NULL, ''),
(37, 1, 'Transfer Create', '/admin/transfer/create', '_self', 'voyager-pie-chart', '#000000', 36, 1, '2021-09-02 00:36:31', '2021-09-02 00:37:24', NULL, ''),
(38, 1, 'Transfer Record', 'admin/transfer/record', '_self', 'voyager-pie-chart', '#000000', 36, 2, '2021-09-02 00:37:14', '2021-09-09 08:16:15', NULL, ''),
(39, 1, 'Permissions', '/admin/permissions', '_blank', 'voyager-group', '#000000', NULL, 17, '2021-09-02 07:29:54', '2021-09-14 09:50:03', NULL, ''),
(40, 1, 'Merger', '', '_self', 'voyager-resize-small', '#000000', NULL, 13, '2021-09-09 11:21:07', '2021-09-14 09:50:03', NULL, ''),
(41, 1, 'Create Request', '/admin/merge/create', '_self', 'voyager-forward', '#000000', 40, 1, '2021-09-09 11:22:03', '2021-09-09 11:22:50', NULL, ''),
(42, 1, 'Record', '/admin/merge/record', '_self', 'voyager-forward', '#000000', 40, 2, '2021-09-09 11:22:36', '2021-09-09 11:22:46', NULL, ''),
(43, 1, 'Cancelation', '', '_self', 'voyager-power', '#000000', NULL, 14, '2021-09-09 11:30:27', '2021-09-14 09:50:03', NULL, ''),
(44, 1, 'Create Request', '/admin/cancelation/create', '_self', 'voyager-forward', '#000000', 43, 1, '2021-09-09 11:30:57', '2021-09-09 11:31:23', NULL, ''),
(45, 1, 'Recrod', '/admin/cancelation/record', '_self', 'voyager-forward', '#000000', 43, 2, '2021-09-09 11:31:14', '2021-09-09 11:31:36', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `merges`
--

DROP TABLE IF EXISTS `merges`;
CREATE TABLE IF NOT EXISTS `merges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `plot_first` int NOT NULL,
  `plot_second` int NOT NULL,
  `fee` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `merges`
--

INSERT INTO `merges` (`id`, `customer_id`, `plot_first`, `plot_second`, `fee`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(3, 6, 10, 6, 4000, 2, '2021-09-08 10:43:18', '2021-09-15 10:12:57', 1, 1),
(4, 5, 5, 3, 4000, 0, '2021-09-09 16:17:15', '2021-09-09 16:17:15', 7, NULL),
(5, 4, 6, 3, 4000, 0, '2021-09-09 16:18:46', '2021-09-09 16:18:46', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `event_value` int NOT NULL,
  `msg_from` int NOT NULL,
  `msg_to` int NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `path` varchar(111) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `event_id`, `event_value`, `msg_from`, `msg_to`, `subject`, `message`, `path`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 8, 1, 7, 'Reason', 'i hate you', '', 1, '2021-09-14 11:42:23', '2021-09-14 14:18:11'),
(2, 13, 8, 1, 7, 'Dolor tenetur ipsam', 'cxzcxz', '', 1, '2021-09-14 11:50:42', '2021-09-14 14:16:21'),
(3, 13, 11, 1, 7, 'dfgdgfd', 'gfdgfdgfd', '', 1, '2021-09-14 11:51:28', '2021-09-14 14:16:32'),
(4, 13, 8, 1, 7, 'fdsfsd', 'dfsfds', '', 0, '2021-09-14 11:56:20', '2021-09-14 11:56:20'),
(5, 13, 11, 1, 7, 'gsdfgfdgfd', 'bs dil kr rha tha', '/admin/application-form/show/11', 1, '2021-09-14 13:02:48', '2021-09-14 14:44:59'),
(6, 15, 20, 1, 1, 'dsadsa', 'dsadsa', '/admin/transfer/show/20', 0, '2021-09-14 14:39:48', '2021-09-14 14:39:48'),
(7, 15, 20, 1, 1, 'dsadsa', 'dsadsa', '/admin/transfer/show/20', 0, '2021-09-14 14:40:05', '2021-09-14 14:40:05'),
(8, 15, 20, 1, 1, 'dsadsa', 'dsadsa', '/admin/transfer/show/20', 1, '2021-09-14 14:40:32', '2021-09-14 14:40:46'),
(9, 19, 4, 1, 7, 'test', 'cancelation', '/admin/cancelation/show/4', 0, '2021-09-14 17:16:25', '2021-09-14 17:16:25'),
(10, 16, 3, 1, 1, 'awi', 'ni btana', '/admin/merge/show/3', 0, '2021-09-15 10:12:57', '2021-09-15 10:12:57');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2016_01_01_000000_add_voyager_user_fields', 1),
(3, '2016_01_01_000000_create_data_types_table', 1),
(4, '2016_01_01_000000_create_pages_table', 1),
(5, '2016_01_01_000000_create_posts_table', 1),
(6, '2016_02_15_204651_create_categories_table', 1),
(7, '2016_05_19_173453_create_menu_table', 1),
(8, '2016_10_21_190000_create_roles_table', 1),
(9, '2016_10_21_190000_create_settings_table', 1),
(10, '2016_11_30_135954_create_permission_table', 1),
(11, '2016_11_30_141208_create_permission_role_table', 1),
(12, '2016_12_26_201236_data_types__add__server_side', 1),
(13, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(14, '2017_01_14_005015_create_translations_table', 1),
(15, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(16, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(17, '2017_04_11_000000_alter_post_nullable_fields_table', 1),
(18, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(19, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(20, '2017_08_05_000000_add_group_to_settings_table', 1),
(21, '2017_11_26_013050_add_user_role_relationship', 1),
(22, '2017_11_26_015000_create_user_roles_table', 1),
(23, '2018_03_11_000000_add_user_settings', 1),
(24, '2018_03_14_000000_add_details_to_data_types_table', 1),
(25, '2018_03_16_000000_make_settings_value_nullable', 1),
(26, '2019_08_19_000000_create_failed_jobs_table', 1),
(27, '2014_10_12_100000_create_password_resets_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nominees`
--

DROP TABLE IF EXISTS `nominees`;
CREATE TABLE IF NOT EXISTS `nominees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `name` varchar(111) NOT NULL,
  `son_of` varchar(111) NOT NULL,
  `relation` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cnic` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nominees`
--

INSERT INTO `nominees` (`id`, `booking_id`, `name`, `son_of`, `relation`, `phone`, `cnic`) VALUES
(10, 11, 'Kashif', 'Tufail', 'Father', '3252345', '3456345345');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int UNSIGNED NOT NULL,
  `author_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hello World', 'Hang the jib grog grog blossom grapple dance the hempen jig gangway pressgang bilge rat to go on account lugger. Nelsons folly gabion line draught scallywag fire ship gaff fluke fathom case shot. Sea Legs bilge rat sloop matey gabion long clothes run a shot across the bow Gold Road cog league.', '<p>Hello World. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', 'pages/page1.jpg', 'hello-world', 'Yar Meta Description', 'Keyword1, Keyword2', 'ACTIVE', '2021-05-25 08:34:45', '2021-05-25 08:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(2, 'browse_bread', NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(3, 'browse_database', NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(4, 'browse_media', NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(5, 'browse_compass', NULL, '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(6, 'browse_menus', 'menus', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(7, 'read_menus', 'menus', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(8, 'edit_menus', 'menus', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(9, 'add_menus', 'menus', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(10, 'delete_menus', 'menus', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(11, 'browse_roles', 'roles', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(12, 'read_roles', 'roles', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(13, 'edit_roles', 'roles', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(14, 'add_roles', 'roles', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(15, 'delete_roles', 'roles', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(16, 'browse_users', 'users', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(17, 'read_users', 'users', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(18, 'edit_users', 'users', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(19, 'add_users', 'users', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(20, 'delete_users', 'users', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(21, 'browse_settings', 'settings', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(22, 'read_settings', 'settings', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(23, 'edit_settings', 'settings', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(24, 'add_settings', 'settings', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(25, 'delete_settings', 'settings', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(26, 'browse_categories', 'categories', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(27, 'read_categories', 'categories', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(28, 'edit_categories', 'categories', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(29, 'add_categories', 'categories', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(30, 'delete_categories', 'categories', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(31, 'browse_posts', 'posts', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(32, 'read_posts', 'posts', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(33, 'edit_posts', 'posts', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(34, 'add_posts', 'posts', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(35, 'delete_posts', 'posts', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(36, 'browse_pages', 'pages', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(37, 'read_pages', 'pages', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(38, 'edit_pages', 'pages', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(39, 'add_pages', 'pages', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(40, 'delete_pages', 'pages', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(41, 'browse_hooks', NULL, '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(47, 'browse_books', 'books', '2021-07-29 09:32:36', '2021-07-29 09:32:36'),
(48, 'read_books', 'books', '2021-07-29 09:32:36', '2021-07-29 09:32:36'),
(49, 'edit_books', 'books', '2021-07-29 09:32:36', '2021-07-29 09:32:36'),
(50, 'add_books', 'books', '2021-07-29 09:32:36', '2021-07-29 09:32:36'),
(51, 'delete_books', 'books', '2021-07-29 09:32:36', '2021-07-29 09:32:36'),
(52, 'browse_allotments', 'allotments', '2021-08-04 10:59:41', '2021-08-04 10:59:41'),
(53, 'read_allotments', 'allotments', '2021-08-04 10:59:41', '2021-08-04 10:59:41'),
(54, 'edit_allotments', 'allotments', '2021-08-04 10:59:41', '2021-08-04 10:59:41'),
(55, 'add_allotments', 'allotments', '2021-08-04 10:59:41', '2021-08-04 10:59:41'),
(56, 'delete_allotments', 'allotments', '2021-08-04 10:59:41', '2021-08-04 10:59:41'),
(57, 'browse_projects', 'projects', '2021-08-13 07:36:31', '2021-08-13 07:36:31'),
(58, 'read_projects', 'projects', '2021-08-13 07:36:31', '2021-08-13 07:36:31'),
(59, 'edit_projects', 'projects', '2021-08-13 07:36:31', '2021-08-13 07:36:31'),
(60, 'add_projects', 'projects', '2021-08-13 07:36:31', '2021-08-13 07:36:31'),
(61, 'delete_projects', 'projects', '2021-08-13 07:36:31', '2021-08-13 07:36:31'),
(62, 'browse_blocks', 'blocks', '2021-08-13 07:59:19', '2021-08-13 07:59:19'),
(63, 'read_blocks', 'blocks', '2021-08-13 07:59:19', '2021-08-13 07:59:19'),
(64, 'edit_blocks', 'blocks', '2021-08-13 07:59:19', '2021-08-13 07:59:19'),
(65, 'add_blocks', 'blocks', '2021-08-13 07:59:19', '2021-08-13 07:59:19'),
(66, 'delete_blocks', 'blocks', '2021-08-13 07:59:19', '2021-08-13 07:59:19'),
(67, 'browse_features', 'features', '2021-08-17 03:29:07', '2021-08-17 03:29:07'),
(68, 'read_features', 'features', '2021-08-17 03:29:07', '2021-08-17 03:29:07'),
(69, 'edit_features', 'features', '2021-08-17 03:29:07', '2021-08-17 03:29:07'),
(70, 'add_features', 'features', '2021-08-17 03:29:07', '2021-08-17 03:29:07'),
(71, 'delete_features', 'features', '2021-08-17 03:29:07', '2021-08-17 03:29:07'),
(72, 'browse_fee_setup', 'fee_setup', '2021-08-17 03:49:47', '2021-08-17 03:49:47'),
(73, 'read_fee_setup', 'fee_setup', '2021-08-17 03:49:47', '2021-08-17 03:49:47'),
(74, 'edit_fee_setup', 'fee_setup', '2021-08-17 03:49:47', '2021-08-17 03:49:47'),
(75, 'add_fee_setup', 'fee_setup', '2021-08-17 03:49:47', '2021-08-17 03:49:47'),
(76, 'delete_fee_setup', 'fee_setup', '2021-08-17 03:49:47', '2021-08-17 03:49:47'),
(77, 'browse_agents', 'agents', '2021-08-20 07:44:35', '2021-08-20 07:44:35'),
(78, 'read_agents', 'agents', '2021-08-20 07:44:35', '2021-08-20 07:44:35'),
(79, 'edit_agents', 'agents', '2021-08-20 07:44:35', '2021-08-20 07:44:35'),
(80, 'add_agents', 'agents', '2021-08-20 07:44:35', '2021-08-20 07:44:35'),
(81, 'delete_agents', 'agents', '2021-08-20 07:44:35', '2021-08-20 07:44:35'),
(82, 'browse_customers', 'customers', '2021-08-25 05:06:52', '2021-08-25 05:06:52'),
(83, 'read_customers', 'customers', '2021-08-25 05:06:52', '2021-08-25 05:06:52'),
(84, 'edit_customers', 'customers', '2021-08-25 05:06:52', '2021-08-25 05:06:52'),
(85, 'add_customers', 'customers', '2021-08-25 05:06:52', '2021-08-25 05:06:52'),
(86, 'delete_customers', 'customers', '2021-08-25 05:06:52', '2021-08-25 05:06:52'),
(87, 'browse_permissions', 'permissions', '2021-09-02 06:42:35', '2021-09-02 06:42:35'),
(88, 'read_permissions', 'permissions', '2021-09-02 06:42:35', '2021-09-02 06:42:35'),
(89, 'edit_permissions', 'permissions', '2021-09-02 06:42:35', '2021-09-02 06:42:35'),
(90, 'add_permissions', 'permissions', '2021-09-02 06:42:35', '2021-09-02 06:42:35'),
(91, 'delete_permissions', 'permissions', '2021-09-02 06:42:35', '2021-09-02 06:42:35'),
(92, 'duplicate_allotments', 'allotments', '2021-09-02 06:58:43', '2021-09-02 06:58:43'),
(93, 'add_booking', 'bookings', '2021-09-02 07:30:00', '2021-09-02 07:30:46'),
(94, 'browse_booking', 'bookings', '2021-09-02 07:31:00', '2021-09-02 07:31:00'),
(95, 'edit_booking', 'bookings', '2021-09-02 07:31:14', '2021-09-02 07:31:14'),
(96, 'read_booking', 'bookings', '2021-09-02 07:31:29', '2021-09-02 07:31:29'),
(97, 'delete_booking', 'bookings', '2021-09-02 07:31:41', '2021-09-02 07:31:41'),
(98, 'add_transfer', 'transfers', '2021-09-02 07:36:01', '2021-09-02 07:36:01'),
(99, 'browse_transfer', 'transfers', '2021-09-02 07:36:20', '2021-09-02 07:36:20'),
(100, 'edit_transfer', 'transfers', '2021-09-02 07:37:15', '2021-09-02 07:37:15'),
(101, 'delete_transfer', 'transfers', '2021-09-02 07:37:31', '2021-09-02 07:37:31'),
(102, 'read_transfer', 'transfers', '2021-09-02 07:37:54', '2021-09-02 07:37:54'),
(103, 'edit_cancelation', 'cancelations', '2021-09-13 06:36:00', '2021-09-14 12:01:56'),
(104, 'delete_cancelation', 'Cancelations', '2021-09-13 06:37:57', '2021-09-13 06:37:57'),
(105, 'browse_cancelation', 'Cancelations', '2021-09-13 06:38:00', '2021-09-14 12:02:53'),
(106, 'read_cancelation', 'Cancelations', '2021-09-13 06:39:11', '2021-09-13 06:39:11'),
(107, 'read_merge', 'Merges', '2021-09-13 06:43:36', '2021-09-13 06:43:36'),
(108, 'edit_merge', 'Merges', '2021-09-13 06:43:47', '2021-09-13 06:43:47'),
(109, 'delete_merge', 'Merges', '2021-09-13 06:43:56', '2021-09-13 06:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 3),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 1),
(5, 3),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(26, 3),
(26, 4),
(27, 1),
(27, 3),
(27, 4),
(28, 1),
(28, 3),
(28, 4),
(29, 1),
(29, 3),
(29, 4),
(30, 1),
(30, 3),
(30, 4),
(31, 1),
(31, 3),
(31, 4),
(32, 1),
(32, 3),
(32, 4),
(33, 1),
(33, 3),
(33, 4),
(34, 1),
(34, 3),
(34, 4),
(35, 1),
(35, 3),
(35, 4),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(41, 3),
(47, 1),
(47, 3),
(48, 1),
(48, 3),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(86, 3),
(52, 4),
(53, 4),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(79, 3),
(80, 3),
(77, 3),
(52, 3),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(54, 3),
(92, 3),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(92, 1),
(107, 1),
(108, 1),
(109, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plots`
--

DROP TABLE IF EXISTS `plots`;
CREATE TABLE IF NOT EXISTS `plots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pr_id` int NOT NULL,
  `bl_id` int NOT NULL,
  `name` varchar(111) NOT NULL,
  `length` int NOT NULL,
  `width` int NOT NULL,
  `size` int NOT NULL,
  `price` int NOT NULL,
  `attach_plot` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '[]',
  `feature` varchar(45) DEFAULT NULL,
  `status` varchar(111) NOT NULL,
  `location_title` varchar(255) DEFAULT NULL,
  `lattitude` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `longitude` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_booked` varchar(45) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plots`
--

INSERT INTO `plots` (`id`, `pr_id`, `bl_id`, `name`, `length`, `width`, `size`, `price`, `attach_plot`, `feature`, `status`, `location_title`, `lattitude`, `longitude`, `created_at`, `updated_at`, `is_booked`) VALUES
(2, 1, 3, '1-3-1', 69, 24, 9, 842, '[]', NULL, 'commercial', 'kjhfkjdhgkfdh', '31.51992642333057', '74.2915965065423', '2021-08-24 07:35:36', '2021-09-07 16:15:37', '0'),
(3, 2, 1, '2-1-2', 59, 78, 9, 805, '[\"2\",\"3\"]', NULL, 'residential', 'kjhfkjdhgkfdh', '31.513247743260045', '74.33366093650179', '2021-08-24 07:35:58', '2021-09-07 16:42:25', '0'),
(4, 2, 2, '2-2-3', 84, 80, 8, 177, '[]', NULL, 'commercial', 'kjhfkjdhgkfdh', '31.502725462598967', '74.32333995228109', '2021-08-24 07:38:03', '2021-08-24 07:38:03', '0'),
(5, 1, 3, '1-3-4', 565, 1400, 11, 2500000, '[\"2\",\"3\"]', NULL, 'residential', 'kjhfkjdhgkfdh', '31.490761075503727', '74.34721728119312', '2021-08-24 07:38:21', '2021-08-24 07:41:12', '0'),
(6, 1, 1, '1-1-5', 57, 52, 8, 2500000, '[\"3\",\"4\",\"6\"]', NULL, 'commercial', 'kjhfkjdhgkfdh', '31.507210779438342', '74.3460216791296', '2021-08-24 11:03:59', '2021-09-14 11:55:42', '1'),
(7, 1, 1, '1-1-6', 565, 925, 9, 95000, '[\"3\",\"4\",\"5\"]', NULL, 'residential', 'khan arcade', '0', '0', '2021-08-25 05:14:45', '2021-09-07 17:18:06', '0'),
(9, 1, 2, '1-2-9', 65656, 565, 10, 5666, '[\"3\",\"7\"]', NULL, 'commercial', 'rajpot colony shujabad', '0', '0', '2021-08-25 05:57:25', '2021-09-14 11:51:28', '0'),
(10, 2, 2, '2-2-11', 3434, 434, 8, 3432432, '[\"2\",\"6\"]', '[\"10\",\"11\",\"12\"]', 'commercial', 'rajpot colony shujabad', '0', '0', '2021-08-25 11:37:43', '2021-09-10 18:13:42', '0'),
(11, 1, 2, '1-2-11', 3, 2, 9, 234523, '[\"3\"]', '[\"10\"]', 'commercial', 'edrgdfbv', '0', '0', '2021-09-07 16:11:15', '2021-09-07 16:11:15', '0'),
(12, 3, 5, '3-5-12', 200, 200, 8, 2000000, '[]', '[\"9\"]', 'residential', NULL, '0', '0', '2021-09-08 14:26:22', '2021-09-08 14:30:19', '1');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(7, 2, 1, 'kashif ali', 'er', 'ere', '<p>sdds</p>', 'posts\\August2021\\laBM2cVozPPSLIQTV7IV.jpg', 'kashif-ali', 'srvre', 'er', 'PUBLISHED', 1, '2021-08-03 10:30:19', '2021-08-03 10:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_project_name_unique` (`project_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Lahore', 'Lahore Project', NULL, NULL),
(2, 'Bahalpur', 'Bahalpur', '2021-08-13 00:00:00', '2021-08-13 13:17:04'),
(3, 'Multan City Development', '<p>Multan City Development</p>', '2021-09-08 00:00:00', '2021-09-08 14:15:11');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(2, 'user', 'Normal User', '2021-05-25 08:34:44', '2021-05-25 08:34:44'),
(3, 'CCR', 'CCR', '2021-05-25 08:45:00', '2021-08-31 07:41:13'),
(4, 'GM Sales', 'GM Sales', '2021-05-25 08:45:27', '2021-08-31 07:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'CRM', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'CRM', '', 'text', 4, 'Site'),
(3, 'admin.logo', 'Site Logo', '', '', 'image', 3, 'Admin'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 2, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'CRM', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to BookCentral.', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin'),
(12, 'admin.custome_css', 'Custome CSS', 'form{\r\nbackground: aliceblue;}\r\n\r\n.tab-content {\r\n    background: aliceblue;\r\n}\r\n\r\n.form-control {\r\n    border: 1px solid #4199e68f !important;\r\n}\r\n\r\nhr {\r\n    border-top: 1px solid #62a8ea40 !important;\r\n}\r\n\r\n.panel-body .select2-selection {\r\n    border: 1px solid #94c6f1 !important;\r\n}\r\n\r\n#plot_price_input{\r\nborder: 1px solid #4199e68f !important;\r\n}\r\n\r\n#commission_amount{\r\nborder: 1px solid #4199e68f !important;\r\n}\r\n\r\n.voyager .panel {\r\nbackground-color: #f0f8ff;\r\n}\r\n\r\n.table {\r\n    color: #383838;\r\n}\r\n\r\nthead th {\r\n    background: #39b0f278 !important;\r\n    color: black !important;\r\n}\r\n.voyager .side-menu.sidebar-inverse .navbar {\r\n    background: none;\r\n    font-weight: 400;\r\n    color: white !important;\r\n    background: black;\r\n}\r\nspan.title {\r\n    color: white;\r\n}\r\n.icon {\r\n    color: snow;\r\n}\r\n\r\na::after {\r\n    color: white;\r\n}\r\nnav.navbar.navbar-default.navbar-fixed-top.navbar-top {\r\n    background: black;\r\n}\r\n\r\na.navbar-brand {\r\n    background: black;\r\n}', NULL, 'code_editor', 6, 'Admin'),
(13, 'site.transfer_fee', 'Transfer Fee Note', 'The buyer must pay PKR 3000 per Marla transfer fee for Residential Plots and PKR 15000 per Marla for Commercial Plots.', NULL, 'text', 7, 'Site'),
(14, 'site.cancelation_fee_note', 'Cancelation Fee Note', 'Accounts department will make the cheque after deducting 10 % of total amount as per standard policy.', NULL, 'text', 8, 'Site'),
(15, 'site.cancelation_fee_percentage', 'Cancelation Fee Percentage', '10', NULL, 'text', 9, 'Site');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
CREATE TABLE IF NOT EXISTS `transfers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ref_num` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ser_num` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `plot_id` int NOT NULL,
  `from_customer` int NOT NULL,
  `to_customer` int NOT NULL,
  `fee` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_customer` (`from_customer`),
  KEY `to_customer` (`to_customer`),
  KEY `from_customer_2` (`from_customer`,`to_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `ref_num`, `ser_num`, `plot_id`, `from_customer`, `to_customer`, `fee`, `created_at`, `updated_at`, `status`, `created_by`) VALUES
(19, '54543', '4543543', 9, 6, 5, 100, '2021-09-03 06:41:24', '2021-09-03 06:41:24', NULL, '1'),
(20, '1231231', '12342131', 12, 6, 5, 3500, '2021-09-08 14:48:09', '2021-09-14 14:40:32', '2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_nominees`
--

DROP TABLE IF EXISTS `transfer_nominees`;
CREATE TABLE IF NOT EXISTS `transfer_nominees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transfer_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `relation` varchar(50) NOT NULL,
  `son_of` varchar(50) NOT NULL,
  `cnic` varchar(111) NOT NULL,
  `phone` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transfer_nominees`
--

INSERT INTO `transfer_nominees` (`id`, `transfer_id`, `name`, `relation`, `son_of`, `cnic`, `phone`) VALUES
(1, 1, 'Javed', 'father', 'akhtar', '24424234', 345643535),
(2, 2, 'Kashif', '3465345', '34563465', '353543', 3453);

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int UNSIGNED NOT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int UNSIGNED NOT NULL,
  `locale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 5, 'pt', 'Post', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(2, 'data_types', 'display_name_singular', 6, 'pt', 'Página', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(3, 'data_types', 'display_name_singular', 1, 'pt', 'Utilizador', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(5, 'data_types', 'display_name_singular', 2, 'pt', 'Menu', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(6, 'data_types', 'display_name_singular', 3, 'pt', 'Função', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(7, 'data_types', 'display_name_plural', 5, 'pt', 'Posts', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(8, 'data_types', 'display_name_plural', 6, 'pt', 'Páginas', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(9, 'data_types', 'display_name_plural', 1, 'pt', 'Utilizadores', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(11, 'data_types', 'display_name_plural', 2, 'pt', 'Menus', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(12, 'data_types', 'display_name_plural', 3, 'pt', 'Funções', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(22, 'menu_items', 'title', 12, 'pt', 'Publicações', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(23, 'menu_items', 'title', 3, 'pt', 'Utilizadores', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(24, 'menu_items', 'title', 11, 'pt', 'Categorias', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(25, 'menu_items', 'title', 13, 'pt', 'Páginas', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(26, 'menu_items', 'title', 4, 'pt', 'Funções', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(27, 'menu_items', 'title', 5, 'pt', 'Ferramentas', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(28, 'menu_items', 'title', 6, 'pt', 'Menus', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(29, 'menu_items', 'title', 7, 'pt', 'Base de dados', '2021-05-25 08:34:45', '2021-05-25 08:34:45'),
(30, 'menu_items', 'title', 10, 'pt', 'Configurações', '2021-05-25 08:34:45', '2021-05-25 08:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@admin.com', 'users\\September2021\\dyohnDOkHZGFu6ZUa5gV.png', NULL, '$2y$10$DSHq0NU06HiAm/1q6N.o2uuvGp1W06dXt4fvZs.TMUS1UZ0Jw3wvC', 'FIo9CHdtGyD7V1uks3Fxto2tnhAIRKztqfMd4yZUipHhms9pcoVmeVjS7RWv', '{\"locale\":\"en\"}', '2021-05-25 08:34:45', '2021-09-14 05:39:02'),
(2, 3, 'CCRA', 'ccra@it.com', 'users/default.png', NULL, '$2y$10$2jmazP0PPO.6gte62JoKnuo5rxPxPJjl/IXK1T7v5kCr.l6eWrUBO', NULL, '{\"locale\":\"en\"}', '2021-05-25 08:46:16', '2021-08-31 07:52:28'),
(3, 4, 'GM Sales', 'gm@it.com', 'users/default.png', NULL, '$2y$10$9T0gqa1/HDQS75TbW8nGCe/DaLMyliEiTOXfBPDuYImlIyFCVl1cq', 'D88xbc6mOPfnrxUdyPGvLjigKp6mp7gWp9vYyrS5BxbGdEVfXhVwwwmiVvEL', '{\"locale\":\"en\"}', '2021-05-25 08:46:52', '2021-08-31 07:50:43'),
(7, 1, 'Admin', 'admin@it.com', 'users\\September2021\\B85F55xbPunK5z8HvfBs.PNG', NULL, '$2y$10$E2is/5lMS5sbFOICWaDv2O5XVNCdXPikNqxlHO/9hGg30OgpildPu', NULL, '{\"locale\":\"en\"}', '2021-08-10 19:58:30', '2021-09-14 07:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(2, 3),
(3, 4),
(7, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
