-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2025 at 03:53 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive 1=Active',
  `delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `username`, `image`, `email_verified_at`, `password`, `status`, `delete`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', '01724698393', 'admin', NULL, NULL, '$2y$12$XP6b6Dk1aSuCNMcuUB1jLu1weIKK82cs2Nb.9ZOLC5QmhR33bkAaq', 1, 0, NULL, '2025-06-22 15:08:43', '2025-06-22 15:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `floor` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `booking_person` bigint(20) UNSIGNED NOT NULL,
  `booking_start_date` date NOT NULL,
  `booking_end_date` date NOT NULL,
  `seat_price` double DEFAULT NULL,
  `seat_service_charge` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `discount_price` double DEFAULT NULL,
  `total_payable` double DEFAULT NULL,
  `total_paid` double DEFAULT NULL,
  `total_due` double DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL COMMENT '0=unpaid 1=paid 2=partially paid',
  `status` tinyint(4) NOT NULL,
  `delete` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `invoice_id`, `hostel_id`, `building_id`, `floor`, `room_id`, `seat_id`, `booking_person`, `booking_start_date`, `booking_end_date`, `seat_price`, `seat_service_charge`, `discount`, `discount_price`, `total_payable`, `total_paid`, `total_due`, `payment_status`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 3, '1st', 3, 2, 1, '2025-06-30', '2025-07-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-29 10:14:31', '2025-06-29 10:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `booking_invoices`
--

CREATE TABLE `booking_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_person` bigint(20) UNSIGNED NOT NULL,
  `booking_start_date` date NOT NULL,
  `booking_end_date` date NOT NULL,
  `seat_price` double NOT NULL,
  `seat_service_charge` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `discount_price` double NOT NULL DEFAULT 0,
  `total_payable` double NOT NULL,
  `total_paid` double NOT NULL,
  `total_due` double NOT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=unpaid 1=paid 2=partially paid',
  `status` tinyint(4) NOT NULL,
  `delete` tinyint(4) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_invoices`
--

INSERT INTO `booking_invoices` (`id`, `booking_person`, `booking_start_date`, `booking_end_date`, `seat_price`, `seat_service_charge`, `discount`, `discount_price`, `total_payable`, `total_paid`, `total_due`, `payment_status`, `status`, `delete`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-06-30', '2025-07-03', 1500, 100, 140, 1360, 1360, 1000, 360, 2, 1, 0, 1, NULL, '2025-06-29 10:14:31', '2025-06-29 10:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `booking_persons`
--

CREATE TABLE `booking_persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_dob` date DEFAULT NULL,
  `booking_nid_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_service_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_workplace_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_person_nid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_persons`
--

INSERT INTO `booking_persons` (`id`, `booking_phone_number`, `booking_person_email`, `booking_person_name`, `booking_person_gender`, `booking_person_dob`, `booking_nid_number`, `booking_person_address`, `booking_service_id`, `booking_person_workplace_address`, `booking_person_image`, `booking_person_nid`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, '01724698392', 'mutasimstore@gmail.com', 'dddddd', 'Male', '2025-06-01', '12345678', 'Noyanogor Mohila Madrasa , Noyanagar , Khilkhet', '123', 'Noyanogor Mohila Madrasa , Noyanagar , Khilkhet', 'public/admin/upload/person_image/1751192070bpimage.jpg', 'public/admin/upload/person_image/1751192070bpimage.jpg', 1, 0, '2025-06-29 08:24:15', '2025-06-29 10:14:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hostel_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hostel_phone` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hostel_email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostel_map_location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `concern_person_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `concern_person_phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `concern_person_email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_multiple_building` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostels`
--

INSERT INTO `hostels` (`id`, `hostel_name`, `hostel_type`, `hostel_phone`, `hostel_email`, `hostel_images`, `hostel_address`, `hostel_map_location`, `concern_person_name`, `concern_person_phone`, `concern_person_email`, `has_multiple_building`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(4, 'Hello world', 'Boys', '01724698392', 'mutasimstore@gmail.com', NULL, 'Noyanogor Mohila Madrasa , Noyanagar , Khilkhet', NULL, 'mmm', '123456789', 'bipebddomain@gmail.com', 0, 0, 0, '2025-06-22 15:37:25', '2025-06-23 15:47:28'),
(5, 'Budhdhijibi Hostel', 'Boys', '01724698392', 'mutasimstore@gmail.com', NULL, 'Noyanogor Mohila Madrasa , Noyanagar , Khilkhet', NULL, 'mmm', '01729067060', 'bipebddomain@gmail.com', 1, 1, 0, '2025-06-29 05:11:21', '2025-06-29 05:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `hostel_buildings`
--

CREATE TABLE `hostel_buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `building_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostel_buildings`
--

INSERT INTO `hostel_buildings` (`id`, `hostel_id`, `building_number`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, 4, 'BUILDING-1', 1, 0, '2025-06-29 05:10:03', '2025-06-29 05:10:03'),
(2, 4, 'BUILDING-2', 1, 0, '2025-06-29 05:10:03', '2025-06-29 05:10:03'),
(3, 5, 'BUILDING-1', 1, 0, '2025-06-29 05:11:21', '2025-06-29 05:11:21'),
(4, 5, 'BUILDING-2', 1, 0, '2025-06-29 05:11:21', '2025-06-29 05:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `lang`, `slug`, `default`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'en', 1, 1, 0, '2025-06-22 15:10:48', '2025-06-22 15:11:27'),
(2, 'Bangla', 'bn', 'bn', 0, 1, 0, '2025-06-22 15:11:08', '2025-06-22 15:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `secret_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_27_095019_create_permission_tables', 1),
(6, '2023_12_27_101553_create_admins_table', 1),
(7, '2024_01_01_094807_create_languages_table', 1),
(8, '2024_01_01_145421_create_api_keys_table', 1),
(9, '2024_01_10_122602_create_maintenances_table', 1),
(10, '2025_01_09_165906_create_translations_table', 1),
(11, '2025_06_22_113847_create_rooms_table', 1),
(12, '2025_06_22_122656_create_hostels_table', 1),
(13, '2025_06_22_150445_add_hostel_images_hosteles_table', 1),
(14, '2025_06_23_131349_create_rooms_table', 2),
(15, '2025_06_24_093734_add_is_smoking_allowed_rooms', 3),
(16, '2025_06_25_161355_create_hostel_buildings_table', 4),
(17, '2025_06_26_095859_add_has_multiple_building_hostels', 4),
(18, '2025_06_26_113404_add_building_id_rooms', 4),
(19, '2025_06_28_000306_create_seats_table', 4),
(20, '2025_06_28_111332_create_bookings_table', 4),
(21, '2025_06_28_151400_add_last_booking_date_start_seats_table', 4),
(22, '2025_06_29_125320_create_booking_people_table', 5),
(23, '2025_06_29_130750_create_bookings_table', 6),
(24, '2025_06_29_132645_create_booking_invoices_table', 7),
(25, '2025_06_29_133015_add_invoice_id_bookings_table', 8),
(26, '2025_06_29_133440_add_created_by_booking_invoices_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'user-index', 'admin', 'User Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(2, 'user-create', 'admin', 'User Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(3, 'user-update', 'admin', 'User Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(4, 'user-delete', 'admin', 'User Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(5, 'role-permission-index', 'admin', 'Roles And Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(6, 'role-permission-create', 'admin', 'Roles And Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(7, 'role-permission-update', 'admin', 'Roles And Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(8, 'role-permission-delete', 'admin', 'Roles And Permissions', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(9, 'specific-permission-create', 'admin', 'Roles And Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(10, 'language-index', 'admin', 'Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(11, 'language-create', 'admin', 'Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(12, 'language-update', 'admin', 'Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(13, 'language-delete', 'admin', 'Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(14, 'backend-string-generate', 'admin', 'Backend Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(15, 'backend-string-translate', 'admin', 'Backend Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(16, 'backend-string-update', 'admin', 'Backend Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(17, 'backend-string-index', 'admin', 'Backend Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(18, 'backend-api-accesskey', 'admin', 'Backend Language Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(19, 'maintenance-mode-index', 'admin', 'Settings Permissions', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(20, 'room-index', 'admin', 'Rooms', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(21, 'room-create', 'admin', 'Rooms', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(22, 'room-update', 'admin', 'Rooms', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(23, 'room-delete', 'admin', 'Rooms', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(24, 'hostel-index', 'admin', 'Hosteles', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(25, 'hostel-create', 'admin', 'Hosteles', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(26, 'hostel-update', 'admin', 'Hosteles', '2025-06-22 15:08:42', '2025-06-22 15:08:42'),
(27, 'hostel-delete', 'admin', 'Hosteles', '2025-06-22 15:08:42', '2025-06-22 15:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', '2025-06-22 15:08:41', '2025-06-22 15:08:41'),
(2, 'Admin', 'admin', '2025-06-22 15:08:41', '2025-06-22 15:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `room_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_id` bigint(20) UNSIGNED DEFAULT NULL,
  `floor` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_number` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_dimension` int(11) DEFAULT NULL,
  `is_full_bookable` tinyint(1) DEFAULT NULL,
  `full_room_max_price` double DEFAULT NULL,
  `full_room_min_price` double DEFAULT NULL,
  `has_attached_bath_room` tinyint(1) DEFAULT NULL,
  `has_attached_balcony` tinyint(1) DEFAULT NULL,
  `is_smoking_allowed` tinyint(1) DEFAULT NULL,
  `total_window` int(11) DEFAULT NULL,
  `total_fan` int(11) DEFAULT NULL,
  `total_light` int(11) DEFAULT NULL,
  `has_seats` tinyint(1) DEFAULT NULL,
  `total_seats` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hostel_id`, `room_type`, `building_id`, `floor`, `block`, `room_number`, `room_dimension`, `is_full_bookable`, `full_room_max_price`, `full_room_min_price`, `has_attached_bath_room`, `has_attached_balcony`, `is_smoking_allowed`, `total_window`, `total_fan`, `total_light`, `has_seats`, `total_seats`, `status`, `delete`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'NON-AC', NULL, '1st', 'A', '101', 1200, 1, 500, 400, 1, 1, 1, 1, 1, 1, 1, NULL, 0, 1, 1, '2025-06-24 14:41:33', '2025-06-24 16:27:58'),
(2, 5, 'NON-AC', 3, '1st', 'A', '101', 1200, 1, 1000, 800, 1, 1, 0, 1, 1, 1, 1, NULL, 1, 0, 1, '2025-06-29 05:11:55', '2025-06-29 05:11:55'),
(3, 5, 'NON-AC', 3, '1st', 'A', '102', 1200, 0, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 0, 1, '2025-06-29 05:12:20', '2025-06-29 05:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED DEFAULT NULL,
  `floor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat_maximum_price` double NOT NULL,
  `seat_minimum_price` double NOT NULL,
  `price_for` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_any_service_charge` tinyint(1) NOT NULL DEFAULT 0,
  `service_charge` double DEFAULT NULL,
  `last_booking_start_date` date DEFAULT NULL,
  `last_booking_end_date` date DEFAULT NULL,
  `last_booking_status` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `hostel_id`, `building_id`, `floor`, `block`, `room_id`, `room_number`, `room_type`, `seat_number`, `seat_maximum_price`, `seat_minimum_price`, `price_for`, `has_any_service_charge`, `service_charge`, `last_booking_start_date`, `last_booking_end_date`, `last_booking_status`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, 5, 3, '1st', 'A', 2, '101', 'NON-AC', '101-A-1', 500, 400, 'day', 1, 100, NULL, NULL, 1, 1, 0, '2025-06-29 05:12:46', '2025-06-29 09:10:53'),
(2, 5, 3, '1st', 'A', 3, '102', 'NON-AC', '102-A-1', 500, 400, 'day', 1, 100, '2025-06-30', '2025-07-03', 1, 1, 0, '2025-06-29 05:13:05', '2025-06-29 10:14:31'),
(3, 5, 3, '1st', 'A', 2, '101', 'NON-AC', '101-A-2', 500, 400, 'day', 1, 100, NULL, NULL, 1, 1, 0, '2025-06-29 05:13:50', '2025-06-29 08:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translationable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translationable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `translationable_type`, `translationable_id`, `locale`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Admin\\Language', 1, 'en', 'name', 'English', '2025-06-22 15:10:48', '2025-06-22 15:11:27'),
(2, 'App\\Models\\Admin\\Language', 2, 'en', 'name', 'Bangla', '2025-06-22 15:11:08', '2025-06-22 15:11:19'),
(3, 'App\\Models\\Admin\\Language', 2, 'bn', 'name', 'বাংলা', NULL, '2025-06-22 15:11:20'),
(4, 'App\\Models\\Admin\\Language', 1, 'bn', 'name', 'ইংরেজি', NULL, '2025-06-22 15:11:28'),
(5, 'App\\Models\\Admin\\Hostel', 4, 'en', 'hostel_name', 'Hello world', '2025-06-22 15:37:25', '2025-06-29 05:10:03'),
(6, 'App\\Models\\Admin\\Hostel', 4, 'bn', 'hostel_name', 'হ্যালো ওয়ার্ল্ড', '2025-06-22 15:37:25', '2025-06-29 05:10:03'),
(7, 'App\\Models\\Admin\\Hostel', 5, 'en', 'hostel_name', 'Budhdhijibi Hostel', '2025-06-29 05:11:21', NULL),
(8, 'App\\Models\\Admin\\Hostel', 5, 'bn', 'hostel_name', 'Budhdhijibi Hostel', '2025-06-29 05:11:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive 1=Active',
  `delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_phone_unique` (`phone`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_hostel_id_foreign` (`hostel_id`),
  ADD KEY `bookings_building_id_foreign` (`building_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`),
  ADD KEY `bookings_seat_id_foreign` (`seat_id`),
  ADD KEY `bookings_booking_person_foreign` (`booking_person`),
  ADD KEY `bookings_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `booking_invoices`
--
ALTER TABLE `booking_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_invoices_booking_person_foreign` (`booking_person`),
  ADD KEY `booking_invoices_crated_by_foreign` (`created_by`),
  ADD KEY `booking_invoices_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `booking_persons`
--
ALTER TABLE `booking_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostel_buildings`
--
ALTER TABLE `hostel_buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostel_buildings_hostel_id_foreign` (`hostel_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_hostel_id_foreign` (`hostel_id`),
  ADD KEY `rooms_created_by_foreign` (`created_by`),
  ADD KEY `rooms_building_id_foreign` (`building_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seats_hostel_id_foreign` (`hostel_id`),
  ADD KEY `seats_building_id_foreign` (`building_id`),
  ADD KEY `seats_room_id_foreign` (`room_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_invoices`
--
ALTER TABLE `booking_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_persons`
--
ALTER TABLE `booking_persons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hostel_buildings`
--
ALTER TABLE `hostel_buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_booking_person_foreign` FOREIGN KEY (`booking_person`) REFERENCES `booking_persons` (`id`),
  ADD CONSTRAINT `bookings_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `hostel_buildings` (`id`),
  ADD CONSTRAINT `bookings_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`),
  ADD CONSTRAINT `bookings_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `booking_invoices` (`id`),
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `bookings_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`);

--
-- Constraints for table `booking_invoices`
--
ALTER TABLE `booking_invoices`
  ADD CONSTRAINT `booking_invoices_booking_person_foreign` FOREIGN KEY (`booking_person`) REFERENCES `booking_persons` (`id`),
  ADD CONSTRAINT `booking_invoices_crated_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `booking_invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `hostel_buildings`
--
ALTER TABLE `hostel_buildings`
  ADD CONSTRAINT `hostel_buildings_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`);

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `hostel_buildings` (`id`),
  ADD CONSTRAINT `rooms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `rooms_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `hostel_buildings` (`id`),
  ADD CONSTRAINT `seats_hostel_id_foreign` FOREIGN KEY (`hostel_id`) REFERENCES `hostels` (`id`),
  ADD CONSTRAINT `seats_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
