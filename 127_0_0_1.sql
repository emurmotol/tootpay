-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2016 at 06:32 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tootpay`
--
DROP DATABASE `tootpay`;
CREATE DATABASE IF NOT EXISTS `tootpay` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tootpay`;

-- --------------------------------------------------------

--
-- Table structure for table `cash_extension_transaction`
--

CREATE TABLE `cash_extension_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `cash_extension_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_extensions`
--

CREATE TABLE `cash_extensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `toot_card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manage_inventory` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `manage_inventory`, `created_at`, `updated_at`) VALUES
(1, 'Dish', 'Ulam', 0, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
(2, 'Others', 'Laman tyan', 0, '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(3, 'Beverages', 'Panulak', 0, '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(4, 'Snacks', 'Halo halong laman tyan', 0, '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(5, 'Sweets', 'Matamis', 0, '2016-10-05 06:04:18', '2016-10-05 06:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `load_share_transaction`
--

CREATE TABLE `load_share_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `load_share_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `load_shares`
--

CREATE TABLE `load_shares` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_toot_card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `to_toot_card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `load_amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchandise_operation_day`
--

CREATE TABLE `merchandise_operation_day` (
  `id` int(10) UNSIGNED NOT NULL,
  `merchandise_id` int(10) UNSIGNED NOT NULL,
  `operation_day_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `merchandise_operation_day`
--

INSERT INTO `merchandise_operation_day` (`id`, `merchandise_id`, `operation_day_id`, `created_at`, `updated_at`) VALUES
(1, 1, '1', '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(2, 1, '2', '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(3, 1, '3', '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(4, 1, '4', '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(5, 1, '5', '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(6, 1, '6', '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(7, 2, '1', '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(8, 2, '2', '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(9, 2, '3', '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(10, 2, '4', '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(11, 2, '5', '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(12, 2, '6', '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(13, 3, '1', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(14, 3, '2', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(15, 3, '3', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(16, 3, '4', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(17, 3, '5', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(18, 3, '6', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(19, 4, '1', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(20, 4, '2', '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(21, 4, '3', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(22, 4, '4', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(23, 4, '5', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(24, 4, '6', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(25, 5, '1', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(26, 5, '2', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(27, 5, '3', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(28, 5, '4', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(29, 5, '5', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(30, 5, '6', '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(31, 6, '1', '2016-10-05 06:04:22', '2016-10-05 06:04:22'),
(32, 6, '2', '2016-10-05 06:04:22', '2016-10-05 06:04:22'),
(33, 6, '3', '2016-10-05 06:04:22', '2016-10-05 06:04:22'),
(34, 6, '4', '2016-10-05 06:04:22', '2016-10-05 06:04:22'),
(35, 6, '5', '2016-10-05 06:04:22', '2016-10-05 06:04:22'),
(36, 6, '6', '2016-10-05 06:04:22', '2016-10-05 06:04:22'),
(37, 7, '1', '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(38, 7, '2', '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(39, 7, '3', '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(40, 7, '4', '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(41, 7, '5', '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(42, 7, '6', '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(43, 8, '1', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(44, 8, '2', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(45, 8, '3', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(46, 8, '4', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(47, 8, '5', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(48, 8, '6', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(49, 9, '1', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(50, 9, '2', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(51, 9, '3', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(52, 9, '4', '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(53, 9, '5', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(54, 9, '6', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(55, 10, '1', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(56, 10, '2', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(57, 10, '3', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(58, 10, '4', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(59, 10, '5', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(60, 10, '6', '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(61, 11, '1', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(62, 11, '2', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(63, 11, '3', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(64, 11, '4', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(65, 11, '5', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(66, 11, '6', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(67, 12, '1', '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(68, 12, '2', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(69, 12, '3', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(70, 12, '4', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(71, 12, '5', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(72, 12, '6', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(73, 13, '1', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(74, 13, '2', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(75, 13, '3', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(76, 13, '4', '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(77, 13, '5', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(78, 13, '6', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(79, 14, '1', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(80, 14, '2', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(81, 14, '3', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(82, 14, '4', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(83, 14, '5', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(84, 14, '6', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(85, 15, '1', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(86, 15, '2', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(87, 15, '3', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(88, 15, '4', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(89, 15, '5', '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(90, 15, '6', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(91, 16, '1', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(92, 16, '2', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(93, 16, '3', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(94, 16, '4', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(95, 16, '5', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(96, 16, '6', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(97, 17, '1', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(98, 17, '2', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(99, 17, '3', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(100, 17, '4', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(101, 17, '5', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(102, 17, '6', '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(103, 18, '1', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(104, 18, '2', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(105, 18, '3', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(106, 18, '4', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(107, 18, '5', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(108, 18, '6', '2016-10-05 06:04:30', '2016-10-05 06:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `merchandises`
--

CREATE TABLE `merchandises` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `has_image` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `merchandises`
--

INSERT INTO `merchandises` (`id`, `category_id`, `name`, `price`, `has_image`, `created_at`, `updated_at`) VALUES
(1, 2, 'Rice', 10.00, 1, '2016-10-05 06:04:18', '2016-10-05 06:04:18'),
(2, 1, 'Bicol Express', 40.00, 1, '2016-10-05 06:04:18', '2016-10-05 06:04:19'),
(3, 1, 'Caldereta', 40.00, 1, '2016-10-05 06:04:19', '2016-10-05 06:04:19'),
(4, 1, 'Monggo', 40.00, 1, '2016-10-05 06:04:20', '2016-10-05 06:04:20'),
(5, 1, 'Pancit', 40.00, 1, '2016-10-05 06:04:21', '2016-10-05 06:04:21'),
(6, 1, 'Pork Adobo', 40.00, 1, '2016-10-05 06:04:21', '2016-10-05 06:04:22'),
(7, 1, 'Bisugong Paksiw', 40.00, 1, '2016-10-05 06:04:22', '2016-10-05 06:04:23'),
(8, 1, 'Siomai', 40.00, 1, '2016-10-05 06:04:23', '2016-10-05 06:04:23'),
(9, 1, 'Sitaw Na Giniling', 40.00, 1, '2016-10-05 06:04:24', '2016-10-05 06:04:24'),
(10, 1, 'Sweet And Sour Meatballs', 40.00, 1, '2016-10-05 06:04:25', '2016-10-05 06:04:25'),
(11, 1, 'Tapa', 40.00, 1, '2016-10-05 06:04:25', '2016-10-05 06:04:26'),
(12, 3, 'Coke Mismo', 12.00, 1, '2016-10-05 06:04:26', '2016-10-05 06:04:26'),
(13, 3, 'Zesto', 12.00, 1, '2016-10-05 06:04:27', '2016-10-05 06:04:27'),
(14, 3, 'Wilkins', 15.00, 1, '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(15, 4, 'Piattos', 15.00, 1, '2016-10-05 06:04:28', '2016-10-05 06:04:28'),
(16, 4, 'V Cut', 15.00, 1, '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(17, 4, 'Oreo', 10.00, 1, '2016-10-05 06:04:29', '2016-10-05 06:04:29'),
(18, 5, 'Mentos', 1.00, 1, '2016-10-05 06:04:30', '2016-10-05 06:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_07_19_101256_create_users_table', 1),
('2016_07_19_101317_create_password_resets_table', 1),
('2016_07_19_101558_create_roles_table', 1),
('2016_07_19_101611_create_user_role_table', 1),
('2016_07_19_101648_create_toot_cards_table', 1),
('2016_07_19_101708_create_user_toot_card_table', 1),
('2016_07_19_101800_create_settings_table', 1),
('2016_07_20_175743_create_categories_table', 1),
('2016_07_20_181430_create_merchandises_table', 1),
('2016_07_26_123857_create_operation_days_table', 1),
('2016_07_26_124310_create_merchandise_operation_day_table', 1),
('2016_08_26_203404_create_payment_methods_table', 1),
('2016_08_26_203416_create_status_responses_table', 1),
('2016_08_27_191047_create_transactions_table', 1),
('2016_08_28_191033_create_orders_table', 1),
('2016_08_29_235037_create_order_transaction_table', 1),
('2016_09_02_040653_create_user_toot_card_transaction_table', 1),
('2016_09_02_042617_create_load_shares_table', 1),
('2016_09_03_041336_create_reloads_table', 1),
('2016_09_03_041718_create_sold_cards_table', 1),
('2016_09_03_042230_create_reload_transaction_table', 1),
('2016_09_03_042241_create_sold_card_transaction_table', 1),
('2016_09_07_041503_create_load_share_transaction_table', 1),
('2016_09_16_152246_create_serials_table', 1),
('2016_09_19_214450_create_expenses_table', 1),
('2016_09_20_153758_create_cash_extensions_table', 1),
('2016_09_20_153821_create_cash_extension_transaction_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operation_days`
--

CREATE TABLE `operation_days` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `has_operation` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `operation_days`
--

INSERT INTO `operation_days` (`id`, `day`, `has_operation`, `created_at`, `updated_at`) VALUES
('0', 'Sunday', 0, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('1', 'Monday', 1, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('2', 'Tuesday', 1, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('3', 'Wednesday', 1, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('4', 'Thursday', 1, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('5', 'Friday', 1, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('6', 'Saturday', 1, '2016-10-05 06:04:17', '2016-10-05 06:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_transaction`
--

CREATE TABLE `order_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `merchandise_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'CASH', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(2, 'TOOT_CARD_LOAD_POINTS', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(3, 'TOOT_CARD_LOAD', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(4, 'TOOT_CARD_POINTS', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(5, 'NOT_SPECIFIED', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(6, 'TOOT_CARD_LOAD_CASH', '2016-10-05 06:04:30', '2016-10-05 06:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `reload_transaction`
--

CREATE TABLE `reload_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `reload_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reloads`
--

CREATE TABLE `reloads` (
  `id` int(10) UNSIGNED NOT NULL,
  `load_amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(111111, 'Administrator', 'The administrator account is a blah blah blah.', '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
(222222, 'Cashier', 'The cashier account is a blah blah blah.', '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
(333333, 'Cardholder', 'The cardholder account is a blah blah blah.', '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
(444444, 'Guest', 'The guest account is a blah blah blah.', '2016-10-05 06:04:16', '2016-10-05 06:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `serials`
--

CREATE TABLE `serials` (
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`key`, `value`) VALUES
('per_page', '30'),
('per_point', '50'),
('ready', '0'),
('serial_count', '0'),
('toot_card_default_load', '80'),
('toot_card_expire_year_count', '5'),
('toot_card_max_load_limit', '10000'),
('toot_card_min_load_limit', '20'),
('toot_card_price', '100');

-- --------------------------------------------------------

--
-- Table structure for table `sold_card_transaction`
--

CREATE TABLE `sold_card_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `sold_card_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sold_cards`
--

CREATE TABLE `sold_cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `toot_card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_responses`
--

CREATE TABLE `status_responses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status_responses`
--

INSERT INTO `status_responses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'VALID_TOOT_CARD', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(2, 'INVALID_TOOT_CARD', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(3, 'CORRECT_PIN_CODE', '2016-10-05 06:04:30', '2016-10-05 06:04:30'),
(4, 'INCORRECT_PIN_CODE', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(5, 'PENDING', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(6, 'PAID', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(7, 'CANCELED', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(8, 'INSUFFICIENT_BALANCE', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(9, 'SUCCESS', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(10, 'QUEUED', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(11, 'DONE', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(12, 'LOAD_EXCEEDS_MIN_LIMIT', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(13, 'EMPTY_USER_ORDER', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(14, 'TO_MANY_CARD_TAP', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(15, 'VALID_USER_ID', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(16, 'INVALID_USER_ID', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(17, 'REQUEST_IS_NOT_AJAX', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(18, 'INSUFFICIENT_LOAD', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(19, 'LOAD_EXCEEDS_MAX_LIMIT', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(20, 'INSUFFICIENT_POINTS', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(21, 'INACTIVE_TOOT_CARD', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(22, 'EXPIRED_TOOT_CARD', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(23, 'CARDHOLDER_CREATED', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(24, 'ACTIVE_TOOT_CARD', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(25, 'ALREADY_ASSOCIATED_TOOT_CARD', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(26, 'EXIST_USER_ID', '2016-10-05 06:04:31', '2016-10-05 06:04:31'),
(27, 'EXIST_EMAIL', '2016-10-05 06:04:32', '2016-10-05 06:04:32'),
(28, 'SHARE_TO_SELF_NOT_PERMITTED', '2016-10-05 06:04:32', '2016-10-05 06:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `toot_cards`
--

CREATE TABLE `toot_cards` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pin_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `load` double(8,2) DEFAULT NULL,
  `points` double(8,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `toot_cards`
--

INSERT INTO `toot_cards` (`id`, `uid`, `pin_code`, `load`, `points`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
('0004249518', '000424951806455214', '1111', 80.00, 0.00, 1, '2021-10-05 06:04:16', '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
('0004250635', '000425063506456331', '1234', 80.00, 0.00, 1, '2021-10-05 06:04:17', '2016-10-05 06:04:17', '2016-10-05 06:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `status_response_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, '12312341234', 111111, '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
(2, '00000000000', 444444, '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
(3, '01987654321', 222222, '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
(4, '00420130015', 333333, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
(5, '00420130276', 333333, '2016-10-05 06:04:17', '2016-10-05 06:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_toot_card`
--

CREATE TABLE `user_toot_card` (
  `id` int(10) UNSIGNED NOT NULL,
  `toot_card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_toot_card`
--

INSERT INTO `user_toot_card` (`id`, `toot_card_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '0004249518', '00420130015', '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
(2, '0004250635', '00420130276', '2016-10-05 06:04:17', '2016-10-05 06:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_toot_card_transaction`
--

CREATE TABLE `user_toot_card_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `toot_card_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('00000000000', 'Cash Payer', NULL, NULL, NULL, NULL, '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
('00420130015', 'John Brian Alvior', 'johnbrianalvior@gmail.com', '09279167296', '$2y$10$Bo0yzPAB5w7IlNBc4CzGEuTuQW0V47h.bdp5.jpH2lzdwkPBcSKUG', NULL, '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
('00420130276', 'Farrah Zeus Resurreccion', 'f.zresurreccion@gmail.com', '09975117325', '$2y$10$hafCRqwJjgLmB8iZa17cI.8SByF0j.2ppYGClrWDV1RLGxuNn1Iyy', NULL, '2016-10-05 06:04:17', '2016-10-05 06:04:17'),
('01987654321', 'Juan Masipag', 'juanmasipag18@gmail.com', '09261231315', '$2y$10$orS2bI.VDT4x6QeGhVXezOhxzxcvdpWrw2.v.cJgmhwfjVxyah6X.', NULL, '2016-10-05 06:04:16', '2016-10-05 06:04:16'),
('12312341234', 'Kuya Franz', 'kuyafranz@toot.pay', '09261951315', '$2y$10$BfOd4lbnJrgq3Wp2FP/MOOIvkdZmgSW1zMNsxoA/aYNclVUMmF.xK', NULL, '2016-10-05 06:04:16', '2016-10-05 06:04:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_extension_transaction`
--
ALTER TABLE `cash_extension_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_extension_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `cash_extension_transaction_cash_extension_id_foreign` (`cash_extension_id`);

--
-- Indexes for table `cash_extensions`
--
ALTER TABLE `cash_extensions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_extensions_toot_card_id_index` (`toot_card_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `load_share_transaction`
--
ALTER TABLE `load_share_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `load_share_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `load_share_transaction_load_share_id_foreign` (`load_share_id`);

--
-- Indexes for table `load_shares`
--
ALTER TABLE `load_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `load_shares_from_toot_card_id_index` (`from_toot_card_id`),
  ADD KEY `load_shares_to_toot_card_id_index` (`to_toot_card_id`);

--
-- Indexes for table `merchandise_operation_day`
--
ALTER TABLE `merchandise_operation_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchandise_operation_day_merchandise_id_foreign` (`merchandise_id`),
  ADD KEY `merchandise_operation_day_operation_day_id_index` (`operation_day_id`);

--
-- Indexes for table `merchandises`
--
ALTER TABLE `merchandises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchandises_category_id_foreign` (`category_id`);

--
-- Indexes for table `operation_days`
--
ALTER TABLE `operation_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_transaction`
--
ALTER TABLE `order_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `order_transaction_order_id_foreign` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_merchandise_id_foreign` (`merchandise_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reload_transaction`
--
ALTER TABLE `reload_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reload_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `reload_transaction_reload_id_foreign` (`reload_id`);

--
-- Indexes for table `reloads`
--
ALTER TABLE `reloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `sold_card_transaction`
--
ALTER TABLE `sold_card_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sold_card_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `sold_card_transaction_sold_card_id_foreign` (`sold_card_id`);

--
-- Indexes for table `sold_cards`
--
ALTER TABLE `sold_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sold_cards_toot_card_id_index` (`toot_card_id`);

--
-- Indexes for table `status_responses`
--
ALTER TABLE `status_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toot_cards`
--
ALTER TABLE `toot_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `toot_cards_uid_unique` (`uid`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `transactions_status_response_id_foreign` (`status_response_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_user_id_index` (`user_id`),
  ADD KEY `user_role_role_id_index` (`role_id`);

--
-- Indexes for table `user_toot_card`
--
ALTER TABLE `user_toot_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_toot_card_toot_card_id_index` (`toot_card_id`),
  ADD KEY `user_toot_card_user_id_index` (`user_id`);

--
-- Indexes for table `user_toot_card_transaction`
--
ALTER TABLE `user_toot_card_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_toot_card_transaction_transaction_id_foreign` (`transaction_id`),
  ADD KEY `user_toot_card_transaction_user_id_index` (`user_id`),
  ADD KEY `user_toot_card_transaction_toot_card_id_index` (`toot_card_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_extension_transaction`
--
ALTER TABLE `cash_extension_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_extensions`
--
ALTER TABLE `cash_extensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `load_share_transaction`
--
ALTER TABLE `load_share_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `load_shares`
--
ALTER TABLE `load_shares`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `merchandise_operation_day`
--
ALTER TABLE `merchandise_operation_day`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `merchandises`
--
ALTER TABLE `merchandises`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `order_transaction`
--
ALTER TABLE `order_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `reload_transaction`
--
ALTER TABLE `reload_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reloads`
--
ALTER TABLE `reloads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sold_card_transaction`
--
ALTER TABLE `sold_card_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sold_cards`
--
ALTER TABLE `sold_cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status_responses`
--
ALTER TABLE `status_responses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_toot_card`
--
ALTER TABLE `user_toot_card`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_toot_card_transaction`
--
ALTER TABLE `user_toot_card_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_extension_transaction`
--
ALTER TABLE `cash_extension_transaction`
  ADD CONSTRAINT `cash_extension_transaction_cash_extension_id_foreign` FOREIGN KEY (`cash_extension_id`) REFERENCES `cash_extensions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_extension_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_extensions`
--
ALTER TABLE `cash_extensions`
  ADD CONSTRAINT `cash_extensions_toot_card_id_foreign` FOREIGN KEY (`toot_card_id`) REFERENCES `toot_cards` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `load_share_transaction`
--
ALTER TABLE `load_share_transaction`
  ADD CONSTRAINT `load_share_transaction_load_share_id_foreign` FOREIGN KEY (`load_share_id`) REFERENCES `load_shares` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `load_share_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `load_shares`
--
ALTER TABLE `load_shares`
  ADD CONSTRAINT `load_shares_from_toot_card_id_foreign` FOREIGN KEY (`from_toot_card_id`) REFERENCES `toot_cards` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `load_shares_to_toot_card_id_foreign` FOREIGN KEY (`to_toot_card_id`) REFERENCES `toot_cards` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `merchandise_operation_day`
--
ALTER TABLE `merchandise_operation_day`
  ADD CONSTRAINT `merchandise_operation_day_merchandise_id_foreign` FOREIGN KEY (`merchandise_id`) REFERENCES `merchandises` (`id`),
  ADD CONSTRAINT `merchandise_operation_day_operation_day_id_foreign` FOREIGN KEY (`operation_day_id`) REFERENCES `operation_days` (`id`);

--
-- Constraints for table `merchandises`
--
ALTER TABLE `merchandises`
  ADD CONSTRAINT `merchandises_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `order_transaction`
--
ALTER TABLE `order_transaction`
  ADD CONSTRAINT `order_transaction_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_merchandise_id_foreign` FOREIGN KEY (`merchandise_id`) REFERENCES `merchandises` (`id`);

--
-- Constraints for table `reload_transaction`
--
ALTER TABLE `reload_transaction`
  ADD CONSTRAINT `reload_transaction_reload_id_foreign` FOREIGN KEY (`reload_id`) REFERENCES `reloads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reload_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sold_card_transaction`
--
ALTER TABLE `sold_card_transaction`
  ADD CONSTRAINT `sold_card_transaction_sold_card_id_foreign` FOREIGN KEY (`sold_card_id`) REFERENCES `sold_cards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sold_card_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sold_cards`
--
ALTER TABLE `sold_cards`
  ADD CONSTRAINT `sold_cards_toot_card_id_foreign` FOREIGN KEY (`toot_card_id`) REFERENCES `toot_cards` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `transactions_status_response_id_foreign` FOREIGN KEY (`status_response_id`) REFERENCES `status_responses` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_toot_card`
--
ALTER TABLE `user_toot_card`
  ADD CONSTRAINT `user_toot_card_toot_card_id_foreign` FOREIGN KEY (`toot_card_id`) REFERENCES `toot_cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_toot_card_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_toot_card_transaction`
--
ALTER TABLE `user_toot_card_transaction`
  ADD CONSTRAINT `user_toot_card_transaction_toot_card_id_foreign` FOREIGN KEY (`toot_card_id`) REFERENCES `toot_cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_toot_card_transaction_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_toot_card_transaction_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
