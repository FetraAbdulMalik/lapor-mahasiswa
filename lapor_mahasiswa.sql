-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2025 at 03:43 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lapor_mahasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` bigint UNSIGNED DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor_count` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `name`, `code`, `faculty_id`, `address`, `floor_count`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Gedung Teknik A', 'GTA', 1, 'Kampus Utama, Jalan Raya Kampus No. 1', 5, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(2, 'Gedung Teknik B', 'GTB', 1, 'Kampus Utama, Jalan Raya Kampus No. 2', 4, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(3, 'Gedung Teknik C', 'GTC', 1, 'Kampus Utama, Jalan Raya Kampus No. 3', 4, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(4, 'Perpustakaan Pusat', 'LIB', NULL, 'Kampus Utama, Area Tengah', 4, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(5, 'Gedung Rektorat', 'REK', NULL, 'Kampus Utama, Area Depan', 3, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(6, 'Gedung Olahraga', 'GOR', NULL, 'Kampus Utama, Area Belakang', 2, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(7, 'Gedung Student Center', 'SC', NULL, 'Kampus Utama, Area Tengah', 3, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(8, 'Masjid Kampus', 'MSJ', NULL, 'Kampus Utama, Area Timur', 2, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_official` tinyint(1) NOT NULL DEFAULT '0',
  `is_internal` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `report_id`, `user_id`, `comment`, `is_official`, `is_internal`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'bvhxcvashgc', 0, 0, '2025-12-17 19:12:20', '2025-12-17 19:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `faculty_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_of_department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `faculty_id`, `name`, `code`, `head_of_department`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Teknik Informatika', 'TI', 'Dr. Agus Supriyanto, M. Kom', 'ti@university. ac.id', 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(2, 1, 'Teknik Industri', 'TIN', 'Dr.  Ir. Dwi Susanto, M.T', 'tin@university.ac.id', 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(3, 1, 'Sistem Informasi', 'SI', 'Dr. Rina Handayani, M.Kom', 'si@university.ac.id', 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(4, 1, 'Teknik Sipil', 'TS', 'Dr.  Ir. Slamet Riyadi, M.T', 'ts@university.ac.id', 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(5, 1, 'Arsitektur', 'ARS', 'Dr.  Ir. Maya Kusuma, M. Ars', 'ars@university.ac.id', 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `building_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('classroom','lab','library','canteen','mosque','toilet','parking','sport_facility','office','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int NOT NULL DEFAULT '1',
  `capacity` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `building_id`, `name`, `code`, `type`, `floor`, `capacity`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ruang Kelas A101', 'A101', 'classroom', 1, 40, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(2, 1, 'Ruang Kelas A102', 'A102', 'classroom', 1, 40, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(3, 1, 'Lab Komputer 1', 'LAB-A201', 'lab', 2, 35, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(4, 1, 'Lab Komputer 2', 'LAB-A202', 'lab', 2, 35, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(5, 1, 'Lab Jaringan Komputer', 'LAB-A301', 'lab', 3, 30, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(6, 1, 'Lab Multimedia', 'LAB-A302', 'lab', 3, 25, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(7, 1, 'Lab Pemrograman', 'LAB-A401', 'lab', 4, 30, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(8, 1, 'Toilet Lantai 1 Pria', 'WC-A1-M', 'toilet', 1, NULL, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(9, 1, 'Toilet Lantai 1 Wanita', 'WC-A1-F', 'toilet', 1, NULL, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(10, 1, 'Kantin Gedung A', 'KANT-A', 'canteen', 1, 60, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(11, 2, 'Ruang Kelas B101', 'B101', 'classroom', 1, 45, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(12, 2, 'Ruang Kelas B102', 'B102', 'classroom', 1, 45, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(13, 2, 'Studio Arsitektur 1', 'STD-B201', 'lab', 2, 30, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(14, 2, 'Studio Arsitektur 2', 'STD-B202', 'lab', 2, 30, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(15, 2, 'Lab Struktur & Material', 'LAB-B301', 'lab', 3, 25, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(16, 2, 'Toilet Lantai 1', 'WC-B1', 'toilet', 1, NULL, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(17, 3, 'Ruang Kelas C101', 'C101', 'classroom', 1, 40, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(18, 3, 'Lab Sistem Produksi', 'LAB-C201', 'lab', 2, 30, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(19, 3, 'Lab Ergonomi', 'LAB-C202', 'lab', 2, 25, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(20, 3, 'Toilet Lantai 1', 'WC-C1', 'toilet', 1, NULL, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(21, 4, 'Ruang Baca Utama', 'LIB-READ1', 'library', 2, 150, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(22, 4, 'Ruang Diskusi 1', 'LIB-DISC1', 'library', 3, 10, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(23, 4, 'Ruang Diskusi 2', 'LIB-DISC2', 'library', 3, 10, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(24, 4, 'Ruang Komputer Perpustakaan', 'LIB-COMP', 'library', 2, 20, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(25, 6, 'Lapangan Indoor', 'GOR-INDOOR', 'sport_facility', 2, 200, 1, '2025-12-17 06:21:58', '2025-12-17 19:51:50'),
(26, 6, 'Fitness Center', 'GOR-FIT', 'sport_facility', 2, 30, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(27, 7, 'Ruang BEM', 'SC-BEM', 'office', 2, 20, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(28, 7, 'Kantin Student Center', 'SC-KANT', 'canteen', 1, 100, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(29, 7, 'Ruang Serbaguna', 'SC-MULTI', 'other', 3, 300, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(30, 6, 'Lapangan Indoor', 'gor-basket', 'sport_facility', 1, 50, 1, '2025-12-17 19:52:47', '2025-12-17 19:52:47'),
(31, 5, 'ruang rektorat 1', 'RK-01', 'other', 1, 30, 1, '2025-12-17 19:55:03', '2025-12-17 19:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dean_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `code`, `dean_name`, `email`, `phone`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fakultas Teknik', 'FT', 'Dr. Ir. Budi Hartono, M.T', 'ft@university.ac.id', '021-12345678', 'Fakultas Teknik dengan berbagai program studi teknik dan rekayasa', 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_17_125444_create_faculties_table', 1),
(5, '2025_12_17_125458_create_departments_table', 1),
(6, '2025_12_17_125517_create_student_profiles_table', 1),
(7, '2025_12_17_125539_create_buildings_table', 1),
(8, '2025_12_17_125551_create_facilities_table', 1),
(9, '2025_12_17_125603_create_report_categories_table', 1),
(10, '2025_12_17_125616_create_reports_table', 1),
(11, '2025_12_17_125652_create_report_attachments_table', 1),
(12, '2025_12_17_125708_create_report_statuses_table', 1),
(13, '2025_12_17_125720_create_comments_table', 1),
(14, '2025_12_17_125731_create_notifications_table', 1),
(15, '2025_12_17_125740_create_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json DEFAULT NULL,
  `report_id` bigint UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `data`, `report_id`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'report_assigned', 'Laporan Ditugaskan', 'Anda ditugaskan untuk menangani laporan #REF25120001', NULL, 1, 0, NULL, '2025-12-17 19:21:59', '2025-12-17 19:21:59'),
(2, 7, 'report_assigned', 'Laporan Sedang Ditinjau', 'Laporan #REF25120001 sedang ditinjau oleh admin terkait', NULL, 1, 0, NULL, '2025-12-17 19:21:59', '2025-12-17 19:21:59'),
(3, 7, 'report_status_changed', 'Status Laporan Berubah', 'Laporan #REF25120001 telah diubah statusnya menjadi:  Selesai', NULL, 1, 0, NULL, '2025-12-17 19:23:59', '2025-12-17 19:23:59'),
(4, 1, 'report_assigned', 'Laporan Ditugaskan', 'Anda ditugaskan untuk menangani laporan #REF25120001', NULL, 1, 0, NULL, '2025-12-17 19:25:21', '2025-12-17 19:25:21'),
(5, 7, 'report_assigned', 'Laporan Sedang Ditinjau', 'Laporan #REF25120001 sedang ditinjau oleh admin terkait', NULL, 1, 0, NULL, '2025-12-17 19:25:21', '2025-12-17 19:25:21'),
(6, 7, 'report_status_changed', 'Status Laporan Berubah', 'Laporan #REF25120001 telah diubah statusnya menjadi:  Ditolak', NULL, 1, 0, NULL, '2025-12-17 19:25:52', '2025-12-17 19:25:52'),
(7, 16, 'report_status_changed', 'Status Laporan Berubah', 'Laporan #REF25120002 telah diubah statusnya menjadi:  Sedang Ditinjau', NULL, 2, 1, '2025-12-17 20:00:48', '2025-12-17 20:00:30', '2025-12-17 20:00:48');

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
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `reference_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_id` bigint UNSIGNED DEFAULT NULL,
  `facility_id` bigint UNSIGNED DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `status` enum('pending','in_review','in_progress','resolved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `visibility` enum('public','anonymous','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolution_notes` text COLLATE utf8mb4_unicode_ci,
  `views_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reference_number`, `user_id`, `category_id`, `title`, `description`, `location`, `building_id`, `facility_id`, `incident_date`, `status`, `priority`, `visibility`, `is_anonymous`, `assigned_to`, `assigned_at`, `resolved_at`, `resolution_notes`, `views_count`, `created_at`, `updated_at`) VALUES
(1, 'REF25120001', 7, 1, 'gugdvdfh', 'hdsvcjdhvcdhvjfvegjvcdsjvcsdvcuddgvfchdbcjdsncbvudvdvchjsdbdcjhsdvcugvcusdbccjhsdcvcgsdhvcuydvcjhds cjsdvcdsgsvcgdshvcjsjbvcuvchdsvcsjdccvsdvhbsdhvbeuyfvbjdshbcjsddbcvhdsgvcsdhcvbjsd', 'bs cbds ch', 2, NULL, NULL, 'rejected', 'medium', 'public', 0, 1, '2025-12-17 19:25:21', '2025-12-17 19:23:59', 'hvdhgwevdywgedvf', 11, '2025-12-17 19:03:56', '2025-12-17 19:25:52'),
(2, 'REF25120002', 16, 2, 'hbsdjhcvsdgvcsd', 'hdsvbcvjhdsgfvuyegfyergfhsdbfckojsjdbveyugfv8ewrsgdvcugavcyugetvcdhgsvcgavdctyqweduhsbdcjhegr7futycegrr7ygcvbdaxs7yc', 'hsvdcuhsadgvcyue', 6, NULL, '2025-12-18', 'in_review', 'medium', 'anonymous', 1, NULL, NULL, NULL, NULL, 1, '2025-12-17 20:00:00', '2025-12-17 20:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `report_attachments`
--

CREATE TABLE `report_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint UNSIGNED NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_attachments`
--

INSERT INTO `report_attachments` (`id`, `report_id`, `file_name`, `file_path`, `file_type`, `file_size`, `mime_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'WhatsApp Image 2025-12-09 at 05.10.18_e3e9eac3.jpg', 'report-attachments/Z6fh8RVjAbtv005gOjhJemsepsn752ufCXsxQTvT.jpg', 'jpg', 30439, 'image/jpeg', NULL, '2025-12-17 20:00:01', '2025-12-17 20:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `report_categories`
--

CREATE TABLE `report_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '?',
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `department_handle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_categories`
--

INSERT INTO `report_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `department_handle`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Akademik', 'akademik', 'Masalah terkait perkuliahan, dosen, KRS/KHS, jadwal, nilai, ujian, dan tugas', '📚', '#3B82F6', 'Unit Akademik', 1, 1, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(2, 'Fasilitas Kampus', 'fasilitas-kampus', 'Kerusakan atau masalah pada fasilitas seperti ruang kelas, lab, perpustakaan, toilet, wifi, parkir, dll', '🏢', '#10B981', 'Unit Sarana & Prasarana', 1, 2, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(3, 'Administrasi', 'administrasi', 'masalah pembayaran', '📋', '#f59e0b', 'Unit Administrasi Akademik', 1, 3, '2025-12-17 06:21:58', '2025-12-17 19:45:07'),
(4, 'Kemahasiswaan', 'kemahasiswaan', 'Organisasi mahasiswa, beasiswa, kegiatan kampus, UKM (Unit Kegiatan Mahasiswa)', '👥', '#8B5CF6', 'Unit Kemahasiswaan', 1, 4, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(5, 'Layanan Kampus', 'layanan-kampus', 'Keamanan, kebersihan, kesehatan (klinik kampus), konseling mahasiswa', '🛎️', '#06B6D4', 'Unit Layanan Umum', 1, 5, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(6, 'Infrastruktur', 'infrastruktur', 'Jalan/akses kampus, lampu penerangan, drainase, kondisi bangunan', '🏗️', '#EF4444', 'Unit Infrastruktur', 1, 6, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(7, 'Bullying & Harassment', 'bullying-harassment', 'Laporan terkait bullying, pelecehan, diskriminasi (dijamin kerahasiaan dan ditangani profesional)', '🚨', '#DC2626', 'Unit Konseling & Hukum', 1, 7, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(8, 'Teknologi Informasi', 'teknologi-informasi', 'Masalah portal akademik, email kampus, wifi, sistem informasi, website kampus', '💻', '#6366F1', 'Unit IT', 1, 8, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(9, 'Saran & Kritik', 'saran-kritik', 'Saran, kritik, dan masukan konstruktif untuk peningkatan kualitas kampus', '💡', '#14B8A6', 'Rektorat', 1, 9, '2025-12-17 06:21:58', '2025-12-17 06:21:58'),
(10, 'Lainnya', 'lainnya', 'Masalah lain yang tidak termasuk kategori di atas', '📌', '#64748B', 'Unit Umum', 1, 10, '2025-12-17 06:21:58', '2025-12-17 06:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `report_statuses`
--

CREATE TABLE `report_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `previous_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_statuses`
--

INSERT INTO `report_statuses` (`id`, `report_id`, `previous_status`, `new_status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'pending', 'Laporan dibuat oleh mahasiswa', 7, '2025-12-17 19:03:56', '2025-12-17 19:03:56'),
(2, 1, 'in_review', 'in_review', 'vxcvhcvsdhgcvsdgc', 1, '2025-12-17 19:21:59', '2025-12-17 19:21:59'),
(3, 1, 'in_review', 'resolved', 'gfywgscqwyd', 1, '2025-12-17 19:23:59', '2025-12-17 19:23:59'),
(4, 1, 'in_review', 'in_review', 'bsdvchgdsvcygdw', 1, '2025-12-17 19:25:21', '2025-12-17 19:25:21'),
(5, 1, 'in_review', 'rejected', 'sdbvffhdgvf', 1, '2025-12-17 19:25:52', '2025-12-17 19:25:52'),
(6, 2, NULL, 'pending', 'Laporan dibuat oleh mahasiswa', 16, '2025-12-17 20:00:01', '2025-12-17 20:00:01'),
(7, 2, 'pending', 'in_review', 'hsdvcgsdvchsadgvchgdsa', 1, '2025-12-17 20:00:30', '2025-12-17 20:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aQ4U0EpOmkg6rKiykXg07cdarv8OS6EZ3Tch9m1h', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkhMRG5ZejZ6S2k2elg0NUJWYVYxNVFWU1VscnY1WHU1WW5qMnVEMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1766027562),
('DXuRoe8sax7X047rqafLvcLANsddAyljh3AdHxC9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieEU4a0g2QURyOUdYNXR1cnlRYlU1NFdWV3lpWERHUXZ1RDlybXdJUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9zZXR0aW5ncyI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4uc2V0dGluZ3MuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1766027938),
('S2wJ8aiQIGLE6rLDdDFFU6e98TPLZUtL7OZuMJM2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekJjTEtkbVkyZDdMb2lGeFRHQm02OXJCVzcwM3FaRGxSaUxhc01LRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766022603),
('ssjLHSpUptZ2YpWKflP9vzZDUbo99gxUhCKoXAZP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjlrR1owM2hXMWNUWXUzY29HZDRGZWo3Y2dyeVJuYlhTZzBOZGRNYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766022603),
('xnzQp02gGj81eEtZMCI56UjCz6DtDA0MkmDx5jie', 16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR3RxMUFEQzkwWFM3NHR5WkJUbUNnOEV4RXB5b1E4VHYxcEVjZ3FEbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L3Byb2ZpbGUiO3M6NToicm91dGUiO3M6MjE6InN0dWRlbnQucHJvZmlsZS5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2O30=', 1766028233);

-- --------------------------------------------------------

--
-- Table structure for table `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `semester` int NOT NULL DEFAULT '1',
  `year_of_entry` year NOT NULL,
  `status` enum('active','inactive','graduated','leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `user_id`, `nim`, `faculty_id`, `department_id`, `semester`, `year_of_entry`, `status`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 6, '11220001', 1, 1, 5, 2023, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 19:35:13'),
(2, 7, '11230002', 1, 3, 3, 2023, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(3, 8, '11210003', 1, 1, 7, 2021, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(4, 9, '11220004', 1, 2, 5, 2022, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(5, 10, '11240005', 1, 4, 1, 2024, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(6, 11, '11220006', 1, 5, 5, 2022, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(7, 12, '11230007', 1, 3, 3, 2023, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(8, 13, '11220008', 1, 2, 5, 2022, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(9, 14, '11230009', 1, 1, 3, 2023, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(10, 15, '11220010', 1, 4, 5, 2022, 'active', NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(11, 16, '2306039', 1, 1, 5, 2023, 'active', 'avatars/uYaQLvf6N0jSSgATlqq2R5eYv5n9WQg1AH2063yn.jpg', '2025-12-17 19:39:07', '2025-12-17 20:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('student','admin','super_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@university.ac.id', '2025-12-17 06:21:59', '$2y$12$1jyH7aLIzHboy9rwa5iKf.9ohI6vLH/jX/kxXMfvr.h9bUEXMlv9G', '081234567890', 'super_admin', 1, NULL, '2025-12-17 06:21:59', '2025-12-17 06:21:59'),
(2, 'Admin Fasilitas', 'fasilitas@university.ac.id', '2025-12-17 06:21:59', '$2y$12$Ueyb2QulZWPl6eX8GoNqourVyyxnGvSPL2wAQR3tIJME7lV9xapCO', '081234567891', 'admin', 1, NULL, '2025-12-17 06:21:59', '2025-12-17 06:21:59'),
(3, 'Admin Akademik', 'akademik@university.ac. id', '2025-12-17 06:22:00', '$2y$12$0F/7lowqrNUTR.eAko1Q1ODcsOGAyVExInR9mAMq.PkrHwwfOiJbe', '081234567892', 'admin', 1, NULL, '2025-12-17 06:22:00', '2025-12-17 06:22:00'),
(4, 'Admin Kemahasiswaan', 'kemahasiswaan@university.ac.id', '2025-12-17 06:22:00', '$2y$12$8sNwoh5jR7/pysoXOjrKZ.VRWUfpVXFWxQ58RF/YIbZDpxEs83lru', '081234567893', 'admin', 1, NULL, '2025-12-17 06:22:00', '2025-12-17 06:22:00'),
(5, 'Admin IT', 'it@university.ac.id', '2025-12-17 06:22:00', '$2y$12$YC.HfErCOVKG2OjrP2WooOtGajCeFDG3FsPDpoKTqRBuAI2Vh7D.i', '081234567894', 'admin', 1, NULL, '2025-12-17 06:22:00', '2025-12-17 06:22:00'),
(6, 'Budi Santoso', 'budi@student.ac.id', '2025-12-17 06:22:00', '$2y$12$eqDcnGLUksuQ0cCmdHYzROsvE6V.PM5wUtqAmgOFLaQjrdVA1p9ru', '081298765432', 'student', 1, NULL, '2025-12-17 06:22:00', '2025-12-17 19:35:13'),
(7, 'Siti Nurhaliza', 'siti.nurhaliza@student.university.ac.id', '2025-12-17 06:22:01', '$2y$12$cNA8DR7pNrb7anfdPLvXOeQeupfkJwmzJ63RImP32nWJWalsvnxj6', '081298765433', 'student', 1, NULL, '2025-12-17 06:22:01', '2025-12-17 06:22:01'),
(8, 'Ahmad Fauzi', 'ahmad.fauzi@student. university.ac.id', '2025-12-17 06:22:01', '$2y$12$c.wYqSA4m1lp7jqraH20yue7cFKT4CN9K9JQ8Rt51Joosc87wK2B.', '081298765434', 'student', 1, NULL, '2025-12-17 06:22:01', '2025-12-17 06:22:01'),
(9, 'Dewi Lestari', 'dewi.lestari@student.university.ac.id', '2025-12-17 06:22:01', '$2y$12$h04CTPTJCwlb9qXFJXAMs.MJgdSNjf3n2zUKY7VPDfVbEcCCKmKdC', '081298765435', 'student', 1, NULL, '2025-12-17 06:22:01', '2025-12-17 06:22:01'),
(10, 'Rudi Hermawan', 'rudi.hermawan@student.university.ac.id', '2025-12-17 06:22:02', '$2y$12$IbrLJ8x6NC2OaWJu465w0.qEkU94OJG8ewHWhb5c2anwf2WNGDAqS', '081298765436', 'student', 1, NULL, '2025-12-17 06:22:02', '2025-12-17 06:22:02'),
(11, 'Rina Wijayanti', 'rina.wijayanti@student.university.ac.id', '2025-12-17 06:22:02', '$2y$12$ILu6B0XPZn9nwlJE37Az2.J5fwALjFB7WEyZGjuF4pzYLGHR3weG.', '081298765437', 'student', 1, NULL, '2025-12-17 06:22:02', '2025-12-17 06:22:02'),
(12, 'Andi Pratama', 'andi.pratama@student.university.ac.id', '2025-12-17 06:22:02', '$2y$12$E8M1zYKQAGIaUnyNkWxvluYPj53lSkP02dMmNLYagtTWhAtxoPvfS', '081298765438', 'student', 1, NULL, '2025-12-17 06:22:02', '2025-12-17 06:22:02'),
(13, 'Maya Sari', 'maya.sari@student. university.ac.id', '2025-12-17 06:22:02', '$2y$12$q4g67VhvjfqTlHB.qO3GBOhi/iYrWKmXCtG7i8YuIyBHEyJngsyyy', '081298765439', 'student', 1, NULL, '2025-12-17 06:22:02', '2025-12-17 06:22:02'),
(14, 'Doni Saputra', 'doni.saputra@student.university.ac.id', '2025-12-17 06:22:03', '$2y$12$bBR2d1wLFmx6gVHbXff./eEzYiD.75RpEm7CDaCDFu/cEV7iFYdPi', '081298765440', 'student', 1, NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(15, 'Lisa Anggraini', 'lisa.anggraini@student.university.ac.id', '2025-12-17 06:22:03', '$2y$12$10Hw5aXQPgbSCBxyfmTxBeZX3KK3td0BFYArnbLaE9rYQUrUJZrJy', '081298765441', 'student', 1, NULL, '2025-12-17 06:22:03', '2025-12-17 06:22:03'),
(16, 'fetra abdul malik', 'fetraabdulmalikbarkah@gmail.com', NULL, '$2y$12$q/DaLt1yXHUb1yyD90FDROpJ0Dn9ytvFgp7wfH5L00wdRJnDEmGFu', NULL, 'student', 1, NULL, '2025-12-17 19:39:07', '2025-12-17 20:06:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buildings_code_unique` (`code`),
  ADD KEY `buildings_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_report_id_foreign` (`report_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facilities_code_unique` (`code`),
  ADD KEY `facilities_building_id_foreign` (`building_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_report_id_foreign` (`report_id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_reference_number_unique` (`reference_number`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_category_id_foreign` (`category_id`),
  ADD KEY `reports_building_id_foreign` (`building_id`),
  ADD KEY `reports_facility_id_foreign` (`facility_id`),
  ADD KEY `reports_assigned_to_foreign` (`assigned_to`),
  ADD KEY `reports_status_created_at_index` (`status`,`created_at`),
  ADD KEY `reports_reference_number_index` (`reference_number`);

--
-- Indexes for table `report_attachments`
--
ALTER TABLE `report_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_attachments_report_id_foreign` (`report_id`);

--
-- Indexes for table `report_categories`
--
ALTER TABLE `report_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_categories_slug_unique` (`slug`);

--
-- Indexes for table `report_statuses`
--
ALTER TABLE `report_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_statuses_report_id_foreign` (`report_id`),
  ADD KEY `report_statuses_created_by_foreign` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_profiles_nim_unique` (`nim`),
  ADD KEY `student_profiles_user_id_foreign` (`user_id`),
  ADD KEY `student_profiles_faculty_id_foreign` (`faculty_id`),
  ADD KEY `student_profiles_department_id_foreign` (`department_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report_attachments`
--
ALTER TABLE `report_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_categories`
--
ALTER TABLE `report_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `report_statuses`
--
ALTER TABLE `report_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`),
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reports_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  ADD CONSTRAINT `reports_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `report_categories` (`id`),
  ADD CONSTRAINT `reports_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_attachments`
--
ALTER TABLE `report_attachments`
  ADD CONSTRAINT `report_attachments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_statuses`
--
ALTER TABLE `report_statuses`
  ADD CONSTRAINT `report_statuses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `report_statuses_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `student_profiles_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `student_profiles_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `student_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
