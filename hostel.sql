-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2025 at 12:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

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
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive 1=Active',
  `delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `username`, `image`, `email_verified_at`, `password`, `status`, `delete`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', '01724698393', 'admin', NULL, NULL, '$2y$12$h.2UiRNAEoaEGrOYND6Zsedhbr5FJayf9q9kGtR38NvHDnO0aSibK', 1, 0, NULL, '2025-07-24 04:26:45', '2025-07-24 04:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key` varchar(255) NOT NULL,
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
  `floor` varchar(20) NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `booking_person` bigint(20) UNSIGNED NOT NULL,
  `booking_start_date` date NOT NULL,
  `booking_end_date` date NOT NULL,
  `seat_price` double DEFAULT NULL,
  `seat_service_charge` double DEFAULT 0,
  `discount` double DEFAULT 0,
  `discount_price` double DEFAULT 0,
  `total_payable` double DEFAULT NULL,
  `total_paid` double DEFAULT NULL,
  `total_due` double DEFAULT NULL,
  `payment_status` int(11) DEFAULT 0 COMMENT '0=unpaid 1=paid 2=partially paid',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_invoices`
--

CREATE TABLE `booking_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_person` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
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
  `status` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_payments`
--

CREATE TABLE `booking_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payable_amount` double NOT NULL,
  `pay_amount` double NOT NULL,
  `due_amount` double NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `note` text DEFAULT NULL,
  `invoice_status` tinyint(1) NOT NULL COMMENT '0=Unpaid,1=Paid,2=Partially Paid',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_persons`
--

CREATE TABLE `booking_persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_phone_number` varchar(20) DEFAULT NULL,
  `booking_person_email` varchar(40) DEFAULT NULL,
  `booking_person_name` varchar(40) DEFAULT NULL,
  `booking_person_gender` varchar(20) DEFAULT NULL,
  `booking_person_dob` date DEFAULT NULL,
  `booking_nid_number` varchar(30) DEFAULT NULL,
  `booking_person_address` varchar(200) DEFAULT NULL,
  `booking_service_id` varchar(50) DEFAULT NULL,
  `booking_person_workplace_address` varchar(100) DEFAULT NULL,
  `booking_person_image` varchar(100) DEFAULT NULL,
  `booking_person_nid` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_name` varchar(100) NOT NULL,
  `hostel_type` varchar(50) NOT NULL,
  `hostel_phone` varchar(16) NOT NULL,
  `hostel_email` varchar(40) DEFAULT NULL,
  `hostel_images` varchar(255) DEFAULT NULL,
  `hostel_address` varchar(200) DEFAULT NULL,
  `hostel_map_location` text DEFAULT NULL,
  `concern_person_name` varchar(100) DEFAULT NULL,
  `concern_person_phone` varchar(16) DEFAULT NULL,
  `concern_person_email` varchar(40) DEFAULT NULL,
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
(1, 'Buddhijibi Hostel', 'Boys', '01724698392', 'mutasimstore@gmail.com', NULL, 'Noyanogor Mohila Madrasa , Noyanagar , Khilkhet', NULL, 'Masroom', '01724698392', 'bipebddomain@gmail.com', 1, 1, 0, '2025-07-24 04:28:51', '2025-07-24 04:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `hostel_buildings`
--

CREATE TABLE `hostel_buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `building_number` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostel_buildings`
--

INSERT INTO `hostel_buildings` (`id`, `hostel_id`, `building_number`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, 1, 'BUILDING-1', 1, 0, '2025-07-24 04:28:51', '2025-07-24 04:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
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
(1, 'English', 'en', 'en', 1, 1, 0, '2025-07-24 04:27:20', '2025-07-24 04:27:48'),
(2, 'Bangla', 'bn', 'bn', 0, 1, 0, '2025-07-24 04:27:31', '2025-07-24 04:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `secret_code` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `mail_option` varchar(255) NOT NULL,
  `mail_subject` varchar(255) NOT NULL,
  `mail_body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
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
(11, '2025_06_22_122656_create_hostels_table', 1),
(12, '2025_06_22_150445_add_hostel_images_hosteles_table', 1),
(13, '2025_06_23_131349_create_rooms_table', 1),
(14, '2025_06_24_093734_add_is_smoking_allowed_rooms', 1),
(15, '2025_06_25_161355_create_hostel_buildings_table', 1),
(16, '2025_06_26_095859_add_has_multiple_building_hostels', 1),
(17, '2025_06_26_113404_add_building_id_rooms', 1),
(18, '2025_06_28_000306_create_seats_table', 1),
(19, '2025_06_28_151400_add_last_booking_date_start_seats_table', 1),
(20, '2025_06_29_125320_create_booking_people_table', 1),
(21, '2025_06_29_130750_create_bookings_table', 1),
(22, '2025_06_29_132645_create_booking_invoices_table', 1),
(23, '2025_06_29_133015_add_invoice_id_bookings_table', 1),
(24, '2025_06_29_133440_add_created_by_booking_invoices_table', 1),
(25, '2025_07_18_122705_create_booking_payments_table', 1),
(26, '2025_07_20_163930_create_service_types_table', 1),
(27, '2025_07_20_171643_create_seat_service_types_table', 1),
(28, '2025_07_20_235843_add_service_id_to_booking_invoices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
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
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'user-index', 'admin', 'User Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(2, 'user-create', 'admin', 'User Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(3, 'user-update', 'admin', 'User Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(4, 'user-delete', 'admin', 'User Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(5, 'role-permission-index', 'admin', 'Roles And Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(6, 'role-permission-create', 'admin', 'Roles And Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(7, 'role-permission-update', 'admin', 'Roles And Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(8, 'role-permission-delete', 'admin', 'Roles And Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(9, 'specific-permission-create', 'admin', 'Roles And Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(10, 'language-index', 'admin', 'Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(11, 'language-create', 'admin', 'Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(12, 'language-update', 'admin', 'Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(13, 'language-delete', 'admin', 'Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(14, 'backend-string-generate', 'admin', 'Backend Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(15, 'backend-string-translate', 'admin', 'Backend Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(16, 'backend-string-update', 'admin', 'Backend Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(17, 'backend-string-index', 'admin', 'Backend Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(18, 'backend-api-accesskey', 'admin', 'Backend Language Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(19, 'maintenance-mode-index', 'admin', 'Settings Permissions', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(20, 'room-index', 'admin', 'Rooms', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(21, 'room-create', 'admin', 'Rooms', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(22, 'room-update', 'admin', 'Rooms', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(23, 'room-delete', 'admin', 'Rooms', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(24, 'hostel-index', 'admin', 'Hosteles', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(25, 'hostel-create', 'admin', 'Hosteles', '2025-07-24 04:26:44', '2025-07-24 04:26:44'),
(26, 'hostel-update', 'admin', 'Hosteles', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(27, 'hostel-delete', 'admin', 'Hosteles', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(28, 'seat-index', 'admin', 'Seats', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(29, 'seat-create', 'admin', 'Seats', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(30, 'seat-update', 'admin', 'Seats', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(31, 'seat-delete', 'admin', 'Seats', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(32, 'booking-index', 'admin', 'Booking', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(33, 'booking-create', 'admin', 'Booking', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(34, 'booking-update', 'admin', 'Booking', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(35, 'booking-delete', 'admin', 'Booking', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(36, 'booking-payment', 'admin', 'Booking', '2025-07-24 04:26:45', '2025-07-24 04:26:45'),
(37, 'booking-invoice', 'admin', 'Booking', '2025-07-24 04:26:45', '2025-07-24 04:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', '2025-07-24 04:26:43', '2025-07-24 04:26:43'),
(2, 'Admin', 'admin', '2025-07-24 04:26:43', '2025-07-24 04:26:43');

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
  `room_type` varchar(20) NOT NULL,
  `building_id` bigint(20) UNSIGNED DEFAULT NULL,
  `floor` varchar(20) NOT NULL,
  `block` varchar(20) DEFAULT NULL,
  `room_number` varchar(40) NOT NULL,
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
(1, 1, 'NON-AC', 1, '2nd', 'A', '201', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(2, 1, 'NON-AC', 1, '2nd', 'A', '202', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(3, 1, 'NON-AC', 1, '2nd', 'A', '203', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(4, 1, 'NON-AC', 1, '2nd', 'A', '204', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(5, 1, 'NON-AC', 1, '2nd', 'A', '205', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(6, 1, 'NON-AC', 1, '2nd', 'A', '206', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(7, 1, 'NON-AC', 1, '2nd', 'A', '207', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(8, 1, 'NON-AC', 1, '2nd', 'A', '208', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(9, 1, 'NON-AC', 1, '2nd', 'A', '209', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(10, 1, 'NON-AC', 1, '2nd', 'A', '210', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(11, 1, 'NON-AC', 1, '2nd', 'A', '211', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(12, 1, 'NON-AC', 1, '2nd', 'A', '212', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(13, 1, 'NON-AC', 1, '3rd', 'A', '301', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(14, 1, 'NON-AC', 1, '3rd', 'A', '302', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(15, 1, 'NON-AC', 1, '3rd', 'A', '303', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(16, 1, 'NON-AC', 1, '3rd', 'A', '304', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(17, 1, 'NON-AC', 1, '3rd', 'A', '305', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(18, 1, 'NON-AC', 1, '3rd', 'A', '306', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(19, 1, 'NON-AC', 1, '3rd', 'A', '307', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(20, 1, 'NON-AC', 1, '3rd', 'A', '308', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(21, 1, 'NON-AC', 1, '3rd', 'A', '309', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(22, 1, 'NON-AC', 1, '3rd', 'A', '310', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(23, 1, 'NON-AC', 1, '3rd', 'A', '311', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(24, 1, 'NON-AC', 1, '3rd', 'A', '312', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(25, 1, 'NON-AC', 1, '3rd', 'A', '313', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(26, 1, 'NON-AC', 1, '3rd', 'A', '314', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(27, 1, 'NON-AC', 1, '4th', 'A', '401', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(28, 1, 'NON-AC', 1, '4th', 'A', '402', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(29, 1, 'NON-AC', 1, '4th', 'A', '403', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(30, 1, 'NON-AC', 1, '4th', 'A', '404', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(31, 1, 'NON-AC', 1, '4th', 'A', '405', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(32, 1, 'NON-AC', 1, '4th', 'A', '406', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(33, 1, 'NON-AC', 1, '4th', 'A', '407', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(34, 1, 'NON-AC', 1, '4th', 'A', '408', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(35, 1, 'NON-AC', 1, '4th', 'A', '409', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(36, 1, 'NON-AC', 1, '4th', 'A', '410', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(37, 1, 'NON-AC', 1, '4th', 'A', '411', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(38, 1, 'NON-AC', 1, '4th', 'A', '412', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(39, 1, 'NON-AC', 1, '4th', 'A', '413', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(40, 1, 'NON-AC', 1, '4th', 'A', '414', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(41, 1, 'NON-AC', 1, '5th', 'A', '501', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(42, 1, 'NON-AC', 1, '5th', 'A', '502', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(43, 1, 'NON-AC', 1, '5th', 'A', '503', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(44, 1, 'NON-AC', 1, '5th', 'A', '504', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(45, 1, 'NON-AC', 1, '5th', 'A', '505', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(46, 1, 'NON-AC', 1, '5th', 'A', '506', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(47, 1, 'NON-AC', 1, '5th', 'A', '507', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(48, 1, 'NON-AC', 1, '5th', 'A', '508', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(49, 1, 'NON-AC', 1, '5th', 'A', '509', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(50, 1, 'NON-AC', 1, '5th', 'A', '510', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(51, 1, 'NON-AC', 1, '5th', 'A', '511', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(52, 1, 'NON-AC', 1, '5th', 'A', '512', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(53, 1, 'NON-AC', 1, '5th', 'A', '513', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(54, 1, 'NON-AC', 1, '5th', 'A', '514', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(55, 1, 'NON-AC', 1, '6th', 'A', '601', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(56, 1, 'NON-AC', 1, '6th', 'A', '602', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(57, 1, 'NON-AC', 1, '6th', 'A', '603', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(58, 1, 'NON-AC', 1, '6th', 'A', '604', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(59, 1, 'NON-AC', 1, '6th', 'A', '605', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(60, 1, 'NON-AC', 1, '6th', 'A', '606', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(61, 1, 'NON-AC', 1, '6th', 'A', '607', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(62, 1, 'NON-AC', 1, '6th', 'A', '608', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(63, 1, 'NON-AC', 1, '6th', 'A', '609', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(64, 1, 'NON-AC', 1, '6th', 'A', '610', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(65, 1, 'NON-AC', 1, '6th', 'A', '611', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(66, 1, 'NON-AC', 1, '6th', 'A', '612', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(67, 1, 'NON-AC', 1, '6th', 'A', '613', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(68, 1, 'NON-AC', 1, '6th', 'A', '614', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(69, 1, 'NON-AC', 1, '7th', 'A', '701', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(70, 1, 'NON-AC', 1, '7th', 'A', '702', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(71, 1, 'NON-AC', 1, '7th', 'A', '703', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(72, 1, 'NON-AC', 1, '7th', 'A', '704', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(73, 1, 'NON-AC', 1, '7th', 'A', '705', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(74, 1, 'NON-AC', 1, '7th', 'A', '706', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(75, 1, 'NON-AC', 1, '7th', 'A', '707', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(76, 1, 'NON-AC', 1, '7th', 'A', '708', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(77, 1, 'NON-AC', 1, '7th', 'A', '709', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(78, 1, 'NON-AC', 1, '7th', 'A', '710', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(79, 1, 'NON-AC', 1, '7th', 'A', '711', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(80, 1, 'NON-AC', 1, '7th', 'A', '712', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(81, 1, 'NON-AC', 1, '7th', 'A', '713', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(82, 1, 'NON-AC', 1, '7th', 'A', '714', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(83, 1, 'NON-AC', 1, '8th', 'A', '801', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(84, 1, 'NON-AC', 1, '8th', 'A', '802', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(85, 1, 'NON-AC', 1, '8th', 'A', '803', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(86, 1, 'NON-AC', 1, '8th', 'A', '804', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(87, 1, 'NON-AC', 1, '8th', 'A', '805', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(88, 1, 'NON-AC', 1, '8th', 'A', '806', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(89, 1, 'NON-AC', 1, '8th', 'A', '807', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(90, 1, 'NON-AC', 1, '8th', 'A', '808', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(91, 1, 'NON-AC', 1, '8th', 'A', '809', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(92, 1, 'NON-AC', 1, '8th', 'A', '810', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(93, 1, 'NON-AC', 1, '8th', 'A', '811', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(94, 1, 'NON-AC', 1, '8th', 'A', '812', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(95, 1, 'NON-AC', 1, '8th', 'A', '813', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(96, 1, 'NON-AC', 1, '8th', 'A', '814', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(97, 1, 'NON-AC', 1, '9th', 'A', '901', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(98, 1, 'NON-AC', 1, '9th', 'A', '902', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(99, 1, 'NON-AC', 1, '9th', 'A', '903', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(100, 1, 'NON-AC', 1, '9th', 'A', '904', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(101, 1, 'NON-AC', 1, '9th', 'A', '905', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(102, 1, 'NON-AC', 1, '9th', 'A', '906', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(103, 1, 'NON-AC', 1, '9th', 'A', '907', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(104, 1, 'NON-AC', 1, '9th', 'A', '908', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(105, 1, 'NON-AC', 1, '9th', 'A', '909', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(106, 1, 'NON-AC', 1, '9th', 'A', '910', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(107, 1, 'NON-AC', 1, '9th', 'A', '911', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(108, 1, 'NON-AC', 1, '9th', 'A', '912', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(109, 1, 'NON-AC', 1, '9th', 'A', '913', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(110, 1, 'NON-AC', 1, '9th', 'A', '914', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(111, 1, 'NON-AC', 1, '10th', 'A', '1001', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(112, 1, 'NON-AC', 1, '10th', 'A', '1002', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(113, 1, 'NON-AC', 1, '10th', 'A', '1003', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(114, 1, 'NON-AC', 1, '10th', 'A', '1004', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(115, 1, 'NON-AC', 1, '10th', 'A', '1005', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(116, 1, 'NON-AC', 1, '10th', 'A', '1006', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(117, 1, 'NON-AC', 1, '10th', 'A', '1007', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(118, 1, 'NON-AC', 1, '10th', 'A', '1008', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(119, 1, 'NON-AC', 1, '10th', 'A', '1009', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(120, 1, 'NON-AC', 1, '10th', 'A', '1010', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(121, 1, 'NON-AC', 1, '10th', 'A', '1011', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(122, 1, 'NON-AC', 1, '10th', 'A', '1012', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(123, 1, 'NON-AC', 1, '10th', 'A', '1013', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(124, 1, 'NON-AC', 1, '10th', 'A', '1014', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(125, 1, 'NON-AC', 1, '11th', 'A', '1101', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(126, 1, 'NON-AC', 1, '11th', 'A', '1102', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(127, 1, 'NON-AC', 1, '11th', 'A', '1103', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(128, 1, 'NON-AC', 1, '11th', 'A', '1104', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(129, 1, 'NON-AC', 1, '11th', 'A', '1105', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(130, 1, 'NON-AC', 1, '11th', 'A', '1106', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(131, 1, 'NON-AC', 1, '11th', 'A', '1107', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(132, 1, 'NON-AC', 1, '11th', 'A', '1108', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(133, 1, 'NON-AC', 1, '11th', 'A', '1109', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(134, 1, 'NON-AC', 1, '11th', 'A', '1110', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(135, 1, 'NON-AC', 1, '11th', 'A', '1111', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(136, 1, 'NON-AC', 1, '11th', 'A', '1112', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(137, 1, 'NON-AC', 1, '11th', 'A', '1113', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(138, 1, 'NON-AC', 1, '11th', 'A', '1114', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(139, 1, 'NON-AC', 1, '12th', 'A', '1201', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(140, 1, 'NON-AC', 1, '12th', 'A', '1202', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(141, 1, 'NON-AC', 1, '12th', 'A', '1203', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(142, 1, 'NON-AC', 1, '12th', 'A', '1204', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(143, 1, 'NON-AC', 1, '12th', 'A', '1205', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(144, 1, 'NON-AC', 1, '12th', 'A', '1206', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(145, 1, 'NON-AC', 1, '12th', 'A', '1207', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(146, 1, 'NON-AC', 1, '12th', 'A', '1208', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(147, 1, 'NON-AC', 1, '12th', 'A', '1209', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(148, 1, 'NON-AC', 1, '12th', 'A', '1210', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(149, 1, 'NON-AC', 1, '12th', 'A', '1211', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(150, 1, 'NON-AC', 1, '12th', 'A', '1212', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(151, 1, 'NON-AC', 1, '12th', 'A', '1213', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL),
(152, 1, 'NON-AC', 1, '12th', 'A', '1214', 1000, 0, 300, 100, 0, 0, 0, 1, 1, 1, 1, 2, 1, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hostel_id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED DEFAULT NULL,
  `floor` varchar(20) DEFAULT NULL,
  `block` varchar(20) DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `room_type` varchar(20) NOT NULL,
  `seat_number` varchar(20) NOT NULL,
  `seat_maximum_price` double NOT NULL,
  `seat_minimum_price` double NOT NULL,
  `price_for` varchar(20) NOT NULL,
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
(1, 1, 1, '2nd', 'A', 1, '201', 'NON-AC', '201-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(2, 1, 1, '2nd', 'A', 2, '202', 'NON-AC', '202-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(3, 1, 1, '2nd', 'A', 3, '203', 'NON-AC', '203-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(4, 1, 1, '2nd', 'A', 4, '204', 'NON-AC', '204-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(5, 1, 1, '2nd', 'A', 5, '205', 'NON-AC', '205-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(6, 1, 1, '2nd', 'A', 6, '206', 'NON-AC', '206-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(7, 1, 1, '2nd', 'A', 7, '207', 'NON-AC', '207-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(8, 1, 1, '2nd', 'A', 8, '208', 'NON-AC', '208-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(9, 1, 1, '2nd', 'A', 9, '209', 'NON-AC', '209-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(10, 1, 1, '2nd', 'A', 10, '210', 'NON-AC', '210-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(11, 1, 1, '2nd', 'A', 11, '211', 'NON-AC', '211-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(12, 1, 1, '2nd', 'A', 12, '212', 'NON-AC', '212-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(13, 1, 1, '3rd', 'A', 13, '301', 'NON-AC', '301-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(14, 1, 1, '3rd', 'A', 14, '302', 'NON-AC', '302-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(15, 1, 1, '3rd', 'A', 15, '303', 'NON-AC', '303-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(16, 1, 1, '3rd', 'A', 16, '304', 'NON-AC', '304-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(17, 1, 1, '3rd', 'A', 17, '305', 'NON-AC', '305-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(18, 1, 1, '3rd', 'A', 18, '306', 'NON-AC', '306-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(19, 1, 1, '3rd', 'A', 19, '307', 'NON-AC', '307-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(20, 1, 1, '3rd', 'A', 20, '308', 'NON-AC', '308-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(21, 1, 1, '3rd', 'A', 21, '309', 'NON-AC', '309-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(22, 1, 1, '3rd', 'A', 22, '310', 'NON-AC', '310-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(23, 1, 1, '3rd', 'A', 23, '311', 'NON-AC', '311-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(24, 1, 1, '3rd', 'A', 24, '312', 'NON-AC', '312-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(25, 1, 1, '3rd', 'A', 25, '313', 'NON-AC', '313-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(26, 1, 1, '3rd', 'A', 26, '314', 'NON-AC', '314-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(27, 1, 1, '4th', 'A', 27, '401', 'NON-AC', '401-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(28, 1, 1, '4th', 'A', 28, '402', 'NON-AC', '402-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(29, 1, 1, '4th', 'A', 29, '403', 'NON-AC', '403-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(30, 1, 1, '4th', 'A', 30, '404', 'NON-AC', '404-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(31, 1, 1, '4th', 'A', 31, '405', 'NON-AC', '405-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(32, 1, 1, '4th', 'A', 32, '406', 'NON-AC', '406-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(33, 1, 1, '4th', 'A', 33, '407', 'NON-AC', '407-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(34, 1, 1, '4th', 'A', 34, '408', 'NON-AC', '408-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(35, 1, 1, '4th', 'A', 35, '409', 'NON-AC', '409-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(36, 1, 1, '4th', 'A', 36, '410', 'NON-AC', '410-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(37, 1, 1, '4th', 'A', 37, '411', 'NON-AC', '411-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(38, 1, 1, '4th', 'A', 38, '412', 'NON-AC', '412-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(39, 1, 1, '4th', 'A', 39, '413', 'NON-AC', '413-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(40, 1, 1, '4th', 'A', 40, '414', 'NON-AC', '414-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(41, 1, 1, '5th', 'A', 41, '501', 'NON-AC', '501-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(42, 1, 1, '5th', 'A', 42, '502', 'NON-AC', '502-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(43, 1, 1, '5th', 'A', 43, '503', 'NON-AC', '503-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(44, 1, 1, '5th', 'A', 44, '504', 'NON-AC', '504-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(45, 1, 1, '5th', 'A', 45, '505', 'NON-AC', '505-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(46, 1, 1, '5th', 'A', 46, '506', 'NON-AC', '506-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(47, 1, 1, '5th', 'A', 47, '507', 'NON-AC', '507-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(48, 1, 1, '5th', 'A', 48, '508', 'NON-AC', '508-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(49, 1, 1, '5th', 'A', 49, '509', 'NON-AC', '509-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(50, 1, 1, '5th', 'A', 50, '510', 'NON-AC', '510-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(51, 1, 1, '5th', 'A', 51, '511', 'NON-AC', '511-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(52, 1, 1, '5th', 'A', 52, '512', 'NON-AC', '512-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(53, 1, 1, '5th', 'A', 53, '513', 'NON-AC', '513-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(54, 1, 1, '5th', 'A', 54, '514', 'NON-AC', '514-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(55, 1, 1, '6th', 'A', 55, '601', 'NON-AC', '601-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(56, 1, 1, '6th', 'A', 56, '602', 'NON-AC', '602-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(57, 1, 1, '6th', 'A', 57, '603', 'NON-AC', '603-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(58, 1, 1, '6th', 'A', 58, '604', 'NON-AC', '604-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(59, 1, 1, '6th', 'A', 59, '605', 'NON-AC', '605-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(60, 1, 1, '6th', 'A', 60, '606', 'NON-AC', '606-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(61, 1, 1, '6th', 'A', 61, '607', 'NON-AC', '607-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(62, 1, 1, '6th', 'A', 62, '608', 'NON-AC', '608-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(63, 1, 1, '6th', 'A', 63, '609', 'NON-AC', '609-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(64, 1, 1, '6th', 'A', 64, '610', 'NON-AC', '610-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(65, 1, 1, '6th', 'A', 65, '611', 'NON-AC', '611-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(66, 1, 1, '6th', 'A', 66, '612', 'NON-AC', '612-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(67, 1, 1, '6th', 'A', 67, '613', 'NON-AC', '613-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(68, 1, 1, '6th', 'A', 68, '614', 'NON-AC', '614-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(69, 1, 1, '7th', 'A', 69, '701', 'NON-AC', '701-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(70, 1, 1, '7th', 'A', 70, '702', 'NON-AC', '702-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(71, 1, 1, '7th', 'A', 71, '703', 'NON-AC', '703-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(72, 1, 1, '7th', 'A', 72, '704', 'NON-AC', '704-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(73, 1, 1, '7th', 'A', 73, '705', 'NON-AC', '705-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(74, 1, 1, '7th', 'A', 74, '706', 'NON-AC', '706-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(75, 1, 1, '7th', 'A', 75, '707', 'NON-AC', '707-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(76, 1, 1, '7th', 'A', 76, '708', 'NON-AC', '708-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(77, 1, 1, '7th', 'A', 77, '709', 'NON-AC', '709-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(78, 1, 1, '7th', 'A', 78, '710', 'NON-AC', '710-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(79, 1, 1, '7th', 'A', 79, '711', 'NON-AC', '711-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(80, 1, 1, '7th', 'A', 80, '712', 'NON-AC', '712-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(81, 1, 1, '7th', 'A', 81, '713', 'NON-AC', '713-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(82, 1, 1, '7th', 'A', 82, '714', 'NON-AC', '714-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(83, 1, 1, '8th', 'A', 83, '801', 'NON-AC', '801-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(84, 1, 1, '8th', 'A', 84, '802', 'NON-AC', '802-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(85, 1, 1, '8th', 'A', 85, '803', 'NON-AC', '803-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(86, 1, 1, '8th', 'A', 86, '804', 'NON-AC', '804-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(87, 1, 1, '8th', 'A', 87, '805', 'NON-AC', '805-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(88, 1, 1, '8th', 'A', 88, '806', 'NON-AC', '806-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(89, 1, 1, '8th', 'A', 89, '807', 'NON-AC', '807-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(90, 1, 1, '8th', 'A', 90, '808', 'NON-AC', '808-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(91, 1, 1, '8th', 'A', 91, '809', 'NON-AC', '809-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(92, 1, 1, '8th', 'A', 92, '810', 'NON-AC', '810-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(93, 1, 1, '8th', 'A', 93, '811', 'NON-AC', '811-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(94, 1, 1, '8th', 'A', 94, '812', 'NON-AC', '812-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(95, 1, 1, '8th', 'A', 95, '813', 'NON-AC', '813-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(96, 1, 1, '8th', 'A', 96, '814', 'NON-AC', '814-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(97, 1, 1, '9th', 'A', 97, '901', 'NON-AC', '901-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(98, 1, 1, '9th', 'A', 98, '902', 'NON-AC', '902-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(99, 1, 1, '9th', 'A', 99, '903', 'NON-AC', '903-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(100, 1, 1, '9th', 'A', 100, '904', 'NON-AC', '904-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(101, 1, 1, '9th', 'A', 101, '905', 'NON-AC', '905-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(102, 1, 1, '9th', 'A', 102, '906', 'NON-AC', '906-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(103, 1, 1, '9th', 'A', 103, '907', 'NON-AC', '907-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(104, 1, 1, '9th', 'A', 104, '908', 'NON-AC', '908-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(105, 1, 1, '9th', 'A', 105, '909', 'NON-AC', '909-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(106, 1, 1, '9th', 'A', 106, '910', 'NON-AC', '910-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(107, 1, 1, '9th', 'A', 107, '911', 'NON-AC', '911-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(108, 1, 1, '9th', 'A', 108, '912', 'NON-AC', '912-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(109, 1, 1, '9th', 'A', 109, '913', 'NON-AC', '913-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(110, 1, 1, '9th', 'A', 110, '914', 'NON-AC', '914-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(111, 1, 1, '10th', 'A', 111, '1001', 'NON-AC', '1001-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(112, 1, 1, '10th', 'A', 112, '1002', 'NON-AC', '1002-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(113, 1, 1, '10th', 'A', 113, '1003', 'NON-AC', '1003-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(114, 1, 1, '10th', 'A', 114, '1004', 'NON-AC', '1004-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(115, 1, 1, '10th', 'A', 115, '1005', 'NON-AC', '1005-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(116, 1, 1, '10th', 'A', 116, '1006', 'NON-AC', '1006-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(117, 1, 1, '10th', 'A', 117, '1007', 'NON-AC', '1007-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(118, 1, 1, '10th', 'A', 118, '1008', 'NON-AC', '1008-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(119, 1, 1, '10th', 'A', 119, '1009', 'NON-AC', '1009-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(120, 1, 1, '10th', 'A', 120, '1010', 'NON-AC', '1010-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(121, 1, 1, '10th', 'A', 121, '1011', 'NON-AC', '1011-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(122, 1, 1, '10th', 'A', 122, '1012', 'NON-AC', '1012-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(123, 1, 1, '10th', 'A', 123, '1013', 'NON-AC', '1013-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(124, 1, 1, '10th', 'A', 124, '1014', 'NON-AC', '1014-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(125, 1, 1, '11th', 'A', 125, '1101', 'NON-AC', '1101-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(126, 1, 1, '11th', 'A', 126, '1102', 'NON-AC', '1102-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(127, 1, 1, '11th', 'A', 127, '1103', 'NON-AC', '1103-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(128, 1, 1, '11th', 'A', 128, '1104', 'NON-AC', '1104-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(129, 1, 1, '11th', 'A', 129, '1105', 'NON-AC', '1105-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(130, 1, 1, '11th', 'A', 130, '1106', 'NON-AC', '1106-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(131, 1, 1, '11th', 'A', 131, '1107', 'NON-AC', '1107-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(132, 1, 1, '11th', 'A', 132, '1108', 'NON-AC', '1108-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(133, 1, 1, '11th', 'A', 133, '1109', 'NON-AC', '1109-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(134, 1, 1, '11th', 'A', 134, '1110', 'NON-AC', '1110-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(135, 1, 1, '11th', 'A', 135, '1111', 'NON-AC', '1111-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(136, 1, 1, '11th', 'A', 136, '1112', 'NON-AC', '1112-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(137, 1, 1, '11th', 'A', 137, '1113', 'NON-AC', '1113-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(138, 1, 1, '11th', 'A', 138, '1114', 'NON-AC', '1114-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(139, 1, 1, '12th', 'A', 139, '1201', 'NON-AC', '1201-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(140, 1, 1, '12th', 'A', 140, '1202', 'NON-AC', '1202-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(141, 1, 1, '12th', 'A', 141, '1203', 'NON-AC', '1203-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(142, 1, 1, '12th', 'A', 142, '1204', 'NON-AC', '1204-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(143, 1, 1, '12th', 'A', 143, '1205', 'NON-AC', '1205-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(144, 1, 1, '12th', 'A', 144, '1206', 'NON-AC', '1206-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(145, 1, 1, '12th', 'A', 145, '1207', 'NON-AC', '1207-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(146, 1, 1, '12th', 'A', 146, '1208', 'NON-AC', '1208-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(147, 1, 1, '12th', 'A', 147, '1209', 'NON-AC', '1209-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(148, 1, 1, '12th', 'A', 148, '1210', 'NON-AC', '1210-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(149, 1, 1, '12th', 'A', 149, '1211', 'NON-AC', '1211-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(150, 1, 1, '12th', 'A', 150, '1212', 'NON-AC', '1212-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(151, 1, 1, '12th', 'A', 151, '1213', 'NON-AC', '1213-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(152, 1, 1, '12th', 'A', 152, '1214', 'NON-AC', '1214-A', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(153, 1, 1, '2nd', 'A', 1, '201', 'NON-AC', '201-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(154, 1, 1, '2nd', 'A', 2, '202', 'NON-AC', '202-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(155, 1, 1, '2nd', 'A', 3, '203', 'NON-AC', '203-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(156, 1, 1, '2nd', 'A', 4, '204', 'NON-AC', '204-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(157, 1, 1, '2nd', 'A', 5, '205', 'NON-AC', '205-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(158, 1, 1, '2nd', 'A', 6, '206', 'NON-AC', '206-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(159, 1, 1, '2nd', 'A', 7, '207', 'NON-AC', '207-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(160, 1, 1, '2nd', 'A', 8, '208', 'NON-AC', '208-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(161, 1, 1, '2nd', 'A', 9, '209', 'NON-AC', '209-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(162, 1, 1, '2nd', 'A', 10, '210', 'NON-AC', '210-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(163, 1, 1, '2nd', 'A', 11, '211', 'NON-AC', '211-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(164, 1, 1, '2nd', 'A', 12, '212', 'NON-AC', '212-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(165, 1, 1, '3rd', 'A', 13, '301', 'NON-AC', '301-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(166, 1, 1, '3rd', 'A', 14, '302', 'NON-AC', '302-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(167, 1, 1, '3rd', 'A', 15, '303', 'NON-AC', '303-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(168, 1, 1, '3rd', 'A', 16, '304', 'NON-AC', '304-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(169, 1, 1, '3rd', 'A', 17, '305', 'NON-AC', '305-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(170, 1, 1, '3rd', 'A', 18, '306', 'NON-AC', '306-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(171, 1, 1, '3rd', 'A', 19, '307', 'NON-AC', '307-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(172, 1, 1, '3rd', 'A', 20, '308', 'NON-AC', '308-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(173, 1, 1, '3rd', 'A', 21, '309', 'NON-AC', '309-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(174, 1, 1, '3rd', 'A', 22, '310', 'NON-AC', '310-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(175, 1, 1, '3rd', 'A', 23, '311', 'NON-AC', '311-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(176, 1, 1, '3rd', 'A', 24, '312', 'NON-AC', '312-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(177, 1, 1, '3rd', 'A', 25, '313', 'NON-AC', '313-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(178, 1, 1, '3rd', 'A', 26, '314', 'NON-AC', '314-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(179, 1, 1, '4th', 'A', 27, '401', 'NON-AC', '401-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(180, 1, 1, '4th', 'A', 28, '402', 'NON-AC', '402-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(181, 1, 1, '4th', 'A', 29, '403', 'NON-AC', '403-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(182, 1, 1, '4th', 'A', 30, '404', 'NON-AC', '404-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(183, 1, 1, '4th', 'A', 31, '405', 'NON-AC', '405-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(184, 1, 1, '4th', 'A', 32, '406', 'NON-AC', '406-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(185, 1, 1, '4th', 'A', 33, '407', 'NON-AC', '407-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(186, 1, 1, '4th', 'A', 34, '408', 'NON-AC', '408-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(187, 1, 1, '4th', 'A', 35, '409', 'NON-AC', '409-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(188, 1, 1, '4th', 'A', 36, '410', 'NON-AC', '410-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(189, 1, 1, '4th', 'A', 37, '411', 'NON-AC', '411-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(190, 1, 1, '4th', 'A', 38, '412', 'NON-AC', '412-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(191, 1, 1, '4th', 'A', 39, '413', 'NON-AC', '413-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(192, 1, 1, '4th', 'A', 40, '414', 'NON-AC', '414-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(193, 1, 1, '5th', 'A', 41, '501', 'NON-AC', '501-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(194, 1, 1, '5th', 'A', 42, '502', 'NON-AC', '502-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(195, 1, 1, '5th', 'A', 43, '503', 'NON-AC', '503-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(196, 1, 1, '5th', 'A', 44, '504', 'NON-AC', '504-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(197, 1, 1, '5th', 'A', 45, '505', 'NON-AC', '505-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(198, 1, 1, '5th', 'A', 46, '506', 'NON-AC', '506-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(199, 1, 1, '5th', 'A', 47, '507', 'NON-AC', '507-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(200, 1, 1, '5th', 'A', 48, '508', 'NON-AC', '508-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(201, 1, 1, '5th', 'A', 49, '509', 'NON-AC', '509-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(202, 1, 1, '5th', 'A', 50, '510', 'NON-AC', '510-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(203, 1, 1, '5th', 'A', 51, '511', 'NON-AC', '511-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(204, 1, 1, '5th', 'A', 52, '512', 'NON-AC', '512-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(205, 1, 1, '5th', 'A', 53, '513', 'NON-AC', '513-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(206, 1, 1, '5th', 'A', 54, '514', 'NON-AC', '514-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(207, 1, 1, '6th', 'A', 55, '601', 'NON-AC', '601-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(208, 1, 1, '6th', 'A', 56, '602', 'NON-AC', '602-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(209, 1, 1, '6th', 'A', 57, '603', 'NON-AC', '603-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(210, 1, 1, '6th', 'A', 58, '604', 'NON-AC', '604-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(211, 1, 1, '6th', 'A', 59, '605', 'NON-AC', '605-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(212, 1, 1, '6th', 'A', 60, '606', 'NON-AC', '606-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(213, 1, 1, '6th', 'A', 61, '607', 'NON-AC', '607-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(214, 1, 1, '6th', 'A', 62, '608', 'NON-AC', '608-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(215, 1, 1, '6th', 'A', 63, '609', 'NON-AC', '609-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(216, 1, 1, '6th', 'A', 64, '610', 'NON-AC', '610-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(217, 1, 1, '6th', 'A', 65, '611', 'NON-AC', '611-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(218, 1, 1, '6th', 'A', 66, '612', 'NON-AC', '612-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(219, 1, 1, '6th', 'A', 67, '613', 'NON-AC', '613-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(220, 1, 1, '6th', 'A', 68, '614', 'NON-AC', '614-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(221, 1, 1, '7th', 'A', 69, '701', 'NON-AC', '701-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(222, 1, 1, '7th', 'A', 70, '702', 'NON-AC', '702-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(223, 1, 1, '7th', 'A', 71, '703', 'NON-AC', '703-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(224, 1, 1, '7th', 'A', 72, '704', 'NON-AC', '704-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(225, 1, 1, '7th', 'A', 73, '705', 'NON-AC', '705-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(226, 1, 1, '7th', 'A', 74, '706', 'NON-AC', '706-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(227, 1, 1, '7th', 'A', 75, '707', 'NON-AC', '707-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(228, 1, 1, '7th', 'A', 76, '708', 'NON-AC', '708-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(229, 1, 1, '7th', 'A', 77, '709', 'NON-AC', '709-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(230, 1, 1, '7th', 'A', 78, '710', 'NON-AC', '710-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(231, 1, 1, '7th', 'A', 79, '711', 'NON-AC', '711-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(232, 1, 1, '7th', 'A', 80, '712', 'NON-AC', '712-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(233, 1, 1, '7th', 'A', 81, '713', 'NON-AC', '713-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(234, 1, 1, '7th', 'A', 82, '714', 'NON-AC', '714-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(235, 1, 1, '8th', 'A', 83, '801', 'NON-AC', '801-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(236, 1, 1, '8th', 'A', 84, '802', 'NON-AC', '802-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(237, 1, 1, '8th', 'A', 85, '803', 'NON-AC', '803-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(238, 1, 1, '8th', 'A', 86, '804', 'NON-AC', '804-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(239, 1, 1, '8th', 'A', 87, '805', 'NON-AC', '805-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(240, 1, 1, '8th', 'A', 88, '806', 'NON-AC', '806-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(241, 1, 1, '8th', 'A', 89, '807', 'NON-AC', '807-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(242, 1, 1, '8th', 'A', 90, '808', 'NON-AC', '808-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(243, 1, 1, '8th', 'A', 91, '809', 'NON-AC', '809-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(244, 1, 1, '8th', 'A', 92, '810', 'NON-AC', '810-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(245, 1, 1, '8th', 'A', 93, '811', 'NON-AC', '811-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(246, 1, 1, '8th', 'A', 94, '812', 'NON-AC', '812-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(247, 1, 1, '8th', 'A', 95, '813', 'NON-AC', '813-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(248, 1, 1, '8th', 'A', 96, '814', 'NON-AC', '814-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(249, 1, 1, '9th', 'A', 97, '901', 'NON-AC', '901-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(250, 1, 1, '9th', 'A', 98, '902', 'NON-AC', '902-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(251, 1, 1, '9th', 'A', 99, '903', 'NON-AC', '903-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(252, 1, 1, '9th', 'A', 100, '904', 'NON-AC', '904-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(253, 1, 1, '9th', 'A', 101, '905', 'NON-AC', '905-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(254, 1, 1, '9th', 'A', 102, '906', 'NON-AC', '906-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(255, 1, 1, '9th', 'A', 103, '907', 'NON-AC', '907-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(256, 1, 1, '9th', 'A', 104, '908', 'NON-AC', '908-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(257, 1, 1, '9th', 'A', 105, '909', 'NON-AC', '909-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(258, 1, 1, '9th', 'A', 106, '910', 'NON-AC', '910-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(259, 1, 1, '9th', 'A', 107, '911', 'NON-AC', '911-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(260, 1, 1, '9th', 'A', 108, '912', 'NON-AC', '912-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(261, 1, 1, '9th', 'A', 109, '913', 'NON-AC', '913-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(262, 1, 1, '9th', 'A', 110, '914', 'NON-AC', '914-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(263, 1, 1, '10th', 'A', 111, '1001', 'NON-AC', '1001-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(264, 1, 1, '10th', 'A', 112, '1002', 'NON-AC', '1002-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(265, 1, 1, '10th', 'A', 113, '1003', 'NON-AC', '1003-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(266, 1, 1, '10th', 'A', 114, '1004', 'NON-AC', '1004-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(267, 1, 1, '10th', 'A', 115, '1005', 'NON-AC', '1005-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(268, 1, 1, '10th', 'A', 116, '1006', 'NON-AC', '1006-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(269, 1, 1, '10th', 'A', 117, '1007', 'NON-AC', '1007-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(270, 1, 1, '10th', 'A', 118, '1008', 'NON-AC', '1008-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(271, 1, 1, '10th', 'A', 119, '1009', 'NON-AC', '1009-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(272, 1, 1, '10th', 'A', 120, '1010', 'NON-AC', '1010-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(273, 1, 1, '10th', 'A', 121, '1011', 'NON-AC', '1011-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(274, 1, 1, '10th', 'A', 122, '1012', 'NON-AC', '1012-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(275, 1, 1, '10th', 'A', 123, '1013', 'NON-AC', '1013-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(276, 1, 1, '10th', 'A', 124, '1014', 'NON-AC', '1014-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(277, 1, 1, '11th', 'A', 125, '1101', 'NON-AC', '1101-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(278, 1, 1, '11th', 'A', 126, '1102', 'NON-AC', '1102-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(279, 1, 1, '11th', 'A', 127, '1103', 'NON-AC', '1103-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(280, 1, 1, '11th', 'A', 128, '1104', 'NON-AC', '1104-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(281, 1, 1, '11th', 'A', 129, '1105', 'NON-AC', '1105-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(282, 1, 1, '11th', 'A', 130, '1106', 'NON-AC', '1106-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(283, 1, 1, '11th', 'A', 131, '1107', 'NON-AC', '1107-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(284, 1, 1, '11th', 'A', 132, '1108', 'NON-AC', '1108-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(285, 1, 1, '11th', 'A', 133, '1109', 'NON-AC', '1109-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(286, 1, 1, '11th', 'A', 134, '1110', 'NON-AC', '1110-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(287, 1, 1, '11th', 'A', 135, '1111', 'NON-AC', '1111-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(288, 1, 1, '11th', 'A', 136, '1112', 'NON-AC', '1112-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(289, 1, 1, '11th', 'A', 137, '1113', 'NON-AC', '1113-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(290, 1, 1, '11th', 'A', 138, '1114', 'NON-AC', '1114-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(291, 1, 1, '12th', 'A', 139, '1201', 'NON-AC', '1201-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(292, 1, 1, '12th', 'A', 140, '1202', 'NON-AC', '1202-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(293, 1, 1, '12th', 'A', 141, '1203', 'NON-AC', '1203-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(294, 1, 1, '12th', 'A', 142, '1204', 'NON-AC', '1204-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(295, 1, 1, '12th', 'A', 143, '1205', 'NON-AC', '1205-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(296, 1, 1, '12th', 'A', 144, '1206', 'NON-AC', '1206-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(297, 1, 1, '12th', 'A', 145, '1207', 'NON-AC', '1207-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(298, 1, 1, '12th', 'A', 146, '1208', 'NON-AC', '1208-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(299, 1, 1, '12th', 'A', 147, '1209', 'NON-AC', '1209-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(300, 1, 1, '12th', 'A', 148, '1210', 'NON-AC', '1210-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(301, 1, 1, '12th', 'A', 149, '1211', 'NON-AC', '1211-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(302, 1, 1, '12th', 'A', 150, '1212', 'NON-AC', '1212-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(303, 1, 1, '12th', 'A', 151, '1213', 'NON-AC', '1213-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL),
(304, 1, 1, '12th', 'A', 152, '1214', 'NON-AC', '1214-B', 300, 100, 'day', 0, 0, NULL, NULL, 0, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seat_service_types`
--

CREATE TABLE `seat_service_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `service_type_id` bigint(20) UNSIGNED NOT NULL,
  `charge` double NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_code` varchar(30) NOT NULL,
  `service_type` varchar(30) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `charge` double NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translationable_type` varchar(255) NOT NULL,
  `translationable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `translationable_type`, `translationable_id`, `locale`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Admin\\Language', 1, 'en', 'name', 'English', '2025-07-24 04:27:20', '2025-07-24 04:27:48'),
(2, 'App\\Models\\Admin\\Language', 2, 'en', 'name', 'Bangla', '2025-07-24 04:27:31', NULL),
(3, 'App\\Models\\Admin\\Language', 1, 'bn', 'name', 'ইংরেজি', NULL, '2025-07-24 04:27:48'),
(4, 'App\\Models\\Admin\\Hostel', 1, 'en', 'hostel_name', 'Buddhijibi Hostel', '2025-07-24 04:28:51', NULL),
(5, 'App\\Models\\Admin\\Hostel', 1, 'bn', 'hostel_name', 'বুদ্ধিজিবি হোস্টেল', '2025-07-24 04:28:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive 1=Active',
  `delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `remember_token` varchar(100) DEFAULT NULL,
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
  ADD KEY `booking_invoices_created_by_foreign` (`created_by`),
  ADD KEY `booking_invoices_updated_by_foreign` (`updated_by`),
  ADD KEY `booking_invoices_service_id_foreign` (`service_id`);

--
-- Indexes for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `booking_payments_created_by_foreign` (`created_by`),
  ADD KEY `booking_payments_updated_by_foreign` (`updated_by`);

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
-- Indexes for table `seat_service_types`
--
ALTER TABLE `seat_service_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seat_service_types_room_id_foreign` (`room_id`),
  ADD KEY `seat_service_types_seat_id_foreign` (`seat_id`),
  ADD KEY `seat_service_types_service_type_id_foreign` (`service_type_id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_invoices`
--
ALTER TABLE `booking_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_payments`
--
ALTER TABLE `booking_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_persons`
--
ALTER TABLE `booking_persons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hostel_buildings`
--
ALTER TABLE `hostel_buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=719;

--
-- AUTO_INCREMENT for table `seat_service_types`
--
ALTER TABLE `seat_service_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `booking_invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `booking_invoices_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `service_types` (`id`),
  ADD CONSTRAINT `booking_invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD CONSTRAINT `booking_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `booking_payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `booking_invoices` (`id`),
  ADD CONSTRAINT `booking_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`);

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

--
-- Constraints for table `seat_service_types`
--
ALTER TABLE `seat_service_types`
  ADD CONSTRAINT `seat_service_types_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `seat_service_types_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`),
  ADD CONSTRAINT `seat_service_types_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
