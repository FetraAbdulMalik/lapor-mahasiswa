-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: lapor_mahasiswa
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buildings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` bigint unsigned DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor_count` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `buildings_code_unique` (`code`),
  KEY `buildings_faculty_id_foreign` (`faculty_id`),
  CONSTRAINT `buildings_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'Gedung Teknik A','GTA',1,'Kampus Utama, Jalan Raya Kampus No. 1',5,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(2,'Gedung Teknik B','GTB',1,'Kampus Utama, Jalan Raya Kampus No. 2',4,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(3,'Gedung Teknik C','GTC',1,'Kampus Utama, Jalan Raya Kampus No. 3',4,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(4,'Perpustakaan Pusat','LIB',NULL,'Kampus Utama, Area Tengah',4,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(5,'Gedung Rektorat','REK',NULL,'Kampus Utama, Area Depan',3,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(6,'Gedung Olahraga','GOR',NULL,'Kampus Utama, Area Belakang',2,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(7,'Gedung Student Center','SC',NULL,'Kampus Utama, Area Tengah',3,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(8,'Masjid Kampus','MSJ',NULL,'Kampus Utama, Area Timur',2,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(11,'bsdi','sabdk',NULL,NULL,1,1,'2026-01-05 16:45:58','2026-01-05 16:45:58');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_official` tinyint(1) NOT NULL DEFAULT '0',
  `is_internal` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_report_id_foreign` (`report_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `faculty_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_of_department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_code_unique` (`code`),
  KEY `departments_faculty_id_foreign` (`faculty_id`),
  CONSTRAINT `departments_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,1,'Teknik Informatika','TI','Dr. Agus Supriyanto, M. Kom','ti@university. ac.id',1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(2,1,'Teknik Industri','TIN','Dr.  Ir. Dwi Susanto, M.T','tin@university.ac.id',1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(3,1,'Sistem Informasi','SI','Dr. Rina Handayani, M.Kom','si@university.ac.id',1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(4,1,'Teknik Sipil','TS','Dr.  Ir. Slamet Riyadi, M.T','ts@university.ac.id',1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(5,1,'Arsitektur','ARS','Dr.  Ir. Maya Kusuma, M. Ars','ars@university.ac.id',1,'2026-01-05 01:06:12','2026-01-05 01:06:12');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('classroom','lab','library','canteen','mosque','toilet','parking','sport_facility','office','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int NOT NULL DEFAULT '1',
  `capacity` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilities_code_unique` (`code`),
  KEY `facilities_building_id_foreign` (`building_id`),
  CONSTRAINT `facilities_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES (1,1,'Ruang Kelas A101','A101','classroom',1,40,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(2,1,'Ruang Kelas A102','A102','classroom',1,40,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(3,1,'Lab Komputer 1','LAB-A201','lab',2,35,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(4,1,'Lab Komputer 2','LAB-A202','lab',2,35,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(5,1,'Lab Jaringan Komputer','LAB-A301','lab',3,30,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(6,1,'Lab Multimedia','LAB-A302','lab',3,25,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(7,1,'Lab Pemrograman','LAB-A401','lab',4,30,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(8,1,'Toilet Lantai 1 Pria','WC-A1-M','toilet',1,NULL,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(9,1,'Toilet Lantai 1 Wanita','WC-A1-F','toilet',1,NULL,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(10,1,'Kantin Gedung A','KANT-A','canteen',1,60,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(11,2,'Ruang Kelas B101','B101','classroom',1,45,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(12,2,'Ruang Kelas B102','B102','classroom',1,45,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(13,2,'Studio Arsitektur 1','STD-B201','lab',2,30,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(14,2,'Studio Arsitektur 2','STD-B202','lab',2,30,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(15,2,'Lab Struktur & Material','LAB-B301','lab',3,25,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(16,2,'Toilet Lantai 1','WC-B1','toilet',1,NULL,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(17,3,'Ruang Kelas C101','C101','classroom',1,40,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(18,3,'Lab Sistem Produksi','LAB-C201','lab',2,30,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(19,3,'Lab Ergonomi','LAB-C202','lab',2,25,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(20,3,'Toilet Lantai 1','WC-C1','toilet',1,NULL,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(21,4,'Ruang Baca Utama','LIB-READ1','library',2,150,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(22,4,'Ruang Diskusi 1','LIB-DISC1','library',3,10,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(23,4,'Ruang Diskusi 2','LIB-DISC2','library',3,10,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(24,4,'Ruang Komputer Perpustakaan','LIB-COMP','library',2,20,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(25,6,'Lapangan Indoor','GOR-INDOOR','sport_facility',1,200,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(26,6,'Fitness Center','GOR-FIT','sport_facility',2,30,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(27,7,'Ruang BEM','SC-BEM','office',2,20,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(28,7,'Kantin Student Center','SC-KANT','canteen',1,100,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(29,7,'Ruang Serbaguna','SC-MULTI','other',3,300,1,'2026-01-05 01:06:12','2026-01-05 01:06:12');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faculties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dean_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faculties_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES (1,'Fakultas Teknik','FT','Dr. Ir. Budi Hartono, M.T','ft@university.ac.id','021-12345678','Fakultas Teknik dengan berbagai program studi teknik dan rekayasa',1,'2026-01-05 01:06:12','2026-01-05 01:06:12');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (16,'0001_01_01_000000_create_users_table',1),(17,'0001_01_01_000001_create_cache_table',1),(18,'0001_01_01_000002_create_jobs_table',1),(19,'2025_12_17_125444_create_faculties_table',1),(20,'2025_12_17_125458_create_departments_table',1),(21,'2025_12_17_125517_create_student_profiles_table',1),(22,'2025_12_17_125539_create_buildings_table',1),(23,'2025_12_17_125551_create_facilities_table',1),(24,'2025_12_17_125603_create_report_categories_table',1),(25,'2025_12_17_125616_create_reports_table',1),(26,'2025_12_17_125652_create_report_attachments_table',1),(27,'2025_12_17_125708_create_report_statuses_table',1),(28,'2025_12_17_125720_create_comments_table',1),(29,'2025_12_17_125731_create_notifications_table',1),(30,'2025_12_17_125740_create_activity_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` json DEFAULT NULL,
  `report_id` bigint unsigned DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_report_id_foreign` (`report_id`),
  KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  CONSTRAINT `notifications_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,16,'report_status_changed','Status Laporan Berubah','Laporan #REF26010033 telah diubah statusnya menjadi:  Sedang Ditinjau',NULL,33,1,'2026-01-05 03:34:59','2026-01-05 03:34:44','2026-01-05 03:34:59'),(2,16,'report_status_changed','Status Laporan Berubah','Laporan #REF26010033 telah diubah statusnya menjadi:  Sedang Ditinjau',NULL,33,1,'2026-01-05 03:34:59','2026-01-05 03:34:45','2026-01-05 03:34:59'),(3,16,'report_status_changed','Status Laporan Berubah','Laporan #REF26010033 telah diubah statusnya menjadi:  Sedang Diproses',NULL,33,1,'2026-01-05 12:18:44','2026-01-05 03:41:15','2026-01-05 12:18:44'),(4,17,'report_status_changed','Status Laporan Berubah','Laporan #REF26010034 telah diubah statusnya menjadi:  Sedang Diproses',NULL,34,1,'2026-01-05 08:23:24','2026-01-05 06:17:16','2026-01-05 08:23:24');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_attachments`
--

DROP TABLE IF EXISTS `report_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_attachments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint unsigned NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint unsigned NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_attachments_report_id_foreign` (`report_id`),
  CONSTRAINT `report_attachments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_attachments`
--

LOCK TABLES `report_attachments` WRITE;
/*!40000 ALTER TABLE `report_attachments` DISABLE KEYS */;
INSERT INTO `report_attachments` VALUES (1,33,'1.png','report-attachments/wovlEgIfVqVCcbwkgcD6mHOogztiWcrNSu4LEAEW.png','png',17578,'image/png',NULL,'2026-01-05 03:33:21','2026-01-05 03:33:21');
/*!40000 ALTER TABLE `report_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_categories`
--

DROP TABLE IF EXISTS `report_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '?',
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `department_handle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_categories`
--

LOCK TABLES `report_categories` WRITE;
/*!40000 ALTER TABLE `report_categories` DISABLE KEYS */;
INSERT INTO `report_categories` VALUES (1,'Akademik','akademik','Masalah terkait perkuliahan, dosen, KRS/KHS, jadwal, nilai, ujian, dan tugas','📚','#3B82F6','Unit Akademik',1,1,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(2,'Fasilitas Kampus','fasilitas-kampus','Kerusakan atau masalah pada fasilitas seperti ruang kelas, lab, perpustakaan, toilet, wifi, parkir, dll','🏢','#10B981','Unit Sarana & Prasarana',1,2,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(3,'Administrasi','administrasi','Masalah pembayaran UKT, surat keterangan, transkrip, legalisir, ijazah, kartu mahasiswa','📋','#F59E0B','Unit Administrasi Akademik',1,3,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(4,'Kemahasiswaan','kemahasiswaan','Organisasi mahasiswa, beasiswa, kegiatan kampus, UKM (Unit Kegiatan Mahasiswa)','👥','#8B5CF6','Unit Kemahasiswaan',1,4,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(5,'Layanan Kampus','layanan-kampus','Keamanan, kebersihan, kesehatan (klinik kampus), konseling mahasiswa','🛎️','#06B6D4','Unit Layanan Umum',1,5,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(6,'Infrastruktur','infrastruktur','Jalan/akses kampus, lampu penerangan, drainase, kondisi bangunan','🏗️','#EF4444','Unit Infrastruktur',1,6,'2026-01-05 01:06:12','2026-01-05 01:06:12'),(7,'Bullying & Harassment','bullying-harassment','Laporan terkait bullying, pelecehan, diskriminasi (dijamin kerahasiaan dan ditangani profesional)','🚨','#DC2626','Unit Konseling & Hukum',1,7,'2026-01-05 01:06:13','2026-01-05 01:06:13'),(8,'Teknologi Informasi','teknologi-informasi','Masalah portal akademik, email kampus, wifi, sistem informasi, website kampus','💻','#6366F1','Unit IT',1,8,'2026-01-05 01:06:13','2026-01-05 01:06:13'),(9,'Saran & Kritik','saran-kritik','Saran, kritik, dan masukan konstruktif untuk peningkatan kualitas kampus','💡','#14B8A6','Rektorat',1,9,'2026-01-05 01:06:13','2026-01-05 01:06:13'),(10,'Lainnya','lainnya','Masalah lain yang tidak termasuk kategori di atas','📌','#64748B','Unit Umum',1,10,'2026-01-05 01:06:13','2026-01-05 01:06:13');
/*!40000 ALTER TABLE `report_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_statuses`
--

DROP TABLE IF EXISTS `report_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `report_id` bigint unsigned NOT NULL,
  `previous_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_statuses_report_id_foreign` (`report_id`),
  KEY `report_statuses_created_by_foreign` (`created_by`),
  CONSTRAINT `report_statuses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `report_statuses_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_statuses`
--

LOCK TABLES `report_statuses` WRITE;
/*!40000 ALTER TABLE `report_statuses` DISABLE KEYS */;
INSERT INTO `report_statuses` VALUES (1,33,NULL,'pending','Laporan dibuat oleh mahasiswa',16,'2026-01-05 03:33:21','2026-01-05 03:33:21'),(2,33,'pending','in_review','nyantai lagi atuhhh',1,'2026-01-05 03:34:44','2026-01-05 03:34:44'),(3,33,'in_review','in_review','nyantai lagi atuhhh',1,'2026-01-05 03:34:45','2026-01-05 03:34:45'),(4,33,'in_review','in_progress','ns ddawawjs',1,'2026-01-05 03:41:15','2026-01-05 03:41:15'),(5,34,NULL,'pending','Laporan dibuat oleh mahasiswa',17,'2026-01-05 06:14:25','2026-01-05 06:14:25'),(6,34,'pending','in_progress','fegdvwehjdvquw',1,'2026-01-05 06:17:16','2026-01-05 06:17:16');
/*!40000 ALTER TABLE `report_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_id` bigint unsigned DEFAULT NULL,
  `facility_id` bigint unsigned DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `status` enum('pending','in_review','in_progress','resolved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `visibility` enum('public','anonymous','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `assigned_to` bigint unsigned DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolution_notes` text COLLATE utf8mb4_unicode_ci,
  `views_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reports_reference_number_unique` (`reference_number`),
  KEY `reports_user_id_foreign` (`user_id`),
  KEY `reports_category_id_foreign` (`category_id`),
  KEY `reports_building_id_foreign` (`building_id`),
  KEY `reports_facility_id_foreign` (`facility_id`),
  KEY `reports_assigned_to_foreign` (`assigned_to`),
  KEY `reports_status_created_at_index` (`status`,`created_at`),
  KEY `reports_reference_number_index` (`reference_number`),
  CONSTRAINT `reports_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  CONSTRAINT `reports_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  CONSTRAINT `reports_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `report_categories` (`id`),
  CONSTRAINT `reports_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,'REF260100001',6,2,'Toilet Buntu (6 hari lalu)','Perlu perbaikan segera','Lokasi A',1,3,'2025-12-30','pending','high','public',1,NULL,NULL,NULL,NULL,0,'2025-12-30 07:52:00','2025-12-30 07:52:00'),(2,'REF260100002',7,2,'Lampu Mati (6 hari lalu)','Perlu perbaikan segera','Lokasi B',1,3,'2025-12-30','resolved','medium','public',1,NULL,NULL,NULL,NULL,0,'2025-12-30 02:56:00','2025-12-30 02:56:00'),(3,'REF260100003',8,2,'Toilet Buntu (5 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi C',1,3,'2025-12-31','in_progress','urgent','public',0,NULL,NULL,NULL,NULL,0,'2025-12-31 07:42:00','2025-12-31 07:42:00'),(4,'REF260100004',9,2,'Jendela Pecah (5 hari lalu)','Perlu perbaikan segera','Lokasi D',1,3,'2025-12-31','resolved','medium','public',1,NULL,NULL,NULL,NULL,0,'2025-12-31 02:59:00','2025-12-31 02:59:00'),(5,'REF260100005',10,2,'Internet Lambat (5 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi E',1,3,'2025-12-31','in_review','high','public',1,NULL,NULL,NULL,NULL,0,'2025-12-31 07:44:00','2025-12-31 07:44:00'),(6,'REF260100006',11,2,'Internet Lambat (5 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi A',1,3,'2025-12-31','in_review','low','public',0,NULL,NULL,NULL,NULL,0,'2025-12-31 07:27:00','2025-12-31 07:27:00'),(7,'REF260100007',12,2,'AC Tidak Dingin (5 hari lalu)','Fasilitas tidak berfungsi dengan baik','Lokasi B',1,3,'2025-12-31','in_review','low','public',1,NULL,NULL,NULL,NULL,0,'2025-12-31 04:11:00','2025-12-31 04:11:00'),(8,'REF260100008',13,2,'Toilet Buntu (4 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi C',1,3,'2026-01-01','resolved','urgent','public',1,NULL,NULL,NULL,NULL,0,'2026-01-01 05:25:00','2026-01-01 05:25:00'),(9,'REF260100009',14,2,'Meja Jebol (4 hari lalu)','Perlu perbaikan segera','Lokasi D',1,3,'2026-01-01','in_progress','low','public',1,NULL,NULL,NULL,NULL,0,'2026-01-01 05:32:00','2026-01-01 05:32:00'),(10,'REF260100010',15,2,'Proyektor Rusak (4 hari lalu)','Kondisi sangat mengkhawatirkan','Lokasi E',1,3,'2026-01-01','rejected','high','public',0,NULL,NULL,NULL,NULL,0,'2026-01-01 04:29:00','2026-01-01 04:29:00'),(11,'REF260100011',6,2,'Meja Jebol (3 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi A',1,3,'2026-01-02','in_review','urgent','public',1,NULL,NULL,NULL,NULL,0,'2026-01-02 01:53:00','2026-01-02 01:53:00'),(12,'REF260100012',7,2,'Proyektor Rusak (3 hari lalu)','Perlu perbaikan segera','Lokasi B',1,3,'2026-01-02','in_progress','low','public',0,NULL,NULL,NULL,NULL,0,'2026-01-02 01:38:00','2026-01-02 01:38:00'),(13,'REF260100013',8,2,'Lampu Mati (3 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi C',1,3,'2026-01-02','in_progress','low','public',0,NULL,NULL,NULL,NULL,0,'2026-01-02 05:22:00','2026-01-02 05:22:00'),(14,'REF260100014',9,2,'AC Tidak Dingin (3 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi D',1,3,'2026-01-02','rejected','urgent','public',1,NULL,NULL,NULL,NULL,0,'2026-01-02 07:36:00','2026-01-02 07:36:00'),(15,'REF260100015',10,2,'Dinding Kotor (3 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi E',1,3,'2026-01-02','resolved','low','public',1,NULL,NULL,NULL,NULL,0,'2026-01-02 07:47:00','2026-01-02 07:47:00'),(16,'REF260100016',11,2,'Atap Bocor (3 hari lalu)','Perlu perbaikan segera','Lokasi A',1,3,'2026-01-02','resolved','high','public',1,NULL,NULL,NULL,NULL,0,'2026-01-02 06:50:00','2026-01-02 06:50:00'),(17,'REF260100017',12,2,'Kursi Rusak (3 hari lalu)','Fasilitas tidak berfungsi dengan baik','Lokasi B',1,3,'2026-01-02','pending','low','public',0,NULL,NULL,NULL,NULL,0,'2026-01-02 04:46:00','2026-01-02 04:46:00'),(18,'REF260100018',13,2,'Tangga Rusak (2 hari lalu)','Kondisi sangat mengkhawatirkan','Lokasi C',1,3,'2026-01-03','resolved','urgent','public',0,NULL,NULL,NULL,NULL,0,'2026-01-03 02:43:00','2026-01-03 02:43:00'),(19,'REF260100019',14,2,'Atap Bocor (2 hari lalu)','Perlu perbaikan segera','Lokasi D',1,3,'2026-01-03','pending','urgent','public',1,NULL,NULL,NULL,NULL,0,'2026-01-03 03:02:00','2026-01-03 03:02:00'),(20,'REF260100020',15,2,'Pagar Rusak (2 hari lalu)','Kondisi sangat mengkhawatirkan','Lokasi E',1,3,'2026-01-03','in_progress','low','public',0,NULL,NULL,NULL,NULL,0,'2026-01-03 03:12:00','2026-01-03 03:12:00'),(21,'REF260100021',6,2,'Meja Jebol (2 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi A',1,3,'2026-01-03','pending','low','public',1,NULL,NULL,NULL,NULL,0,'2026-01-03 08:18:00','2026-01-03 08:18:00'),(22,'REF260100022',7,2,'AC Tidak Dingin (1 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi B',1,3,'2026-01-04','pending','low','public',1,NULL,NULL,NULL,NULL,0,'2026-01-04 06:54:00','2026-01-04 06:54:00'),(23,'REF260100023',8,2,'Tangga Rusak (1 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi C',1,3,'2026-01-04','pending','medium','public',1,NULL,NULL,NULL,NULL,0,'2026-01-04 04:44:00','2026-01-04 04:44:00'),(24,'REF260100024',9,2,'Tempat Sampah Penuh (1 hari lalu)','Kondisi sangat mengkhawatirkan','Lokasi D',1,3,'2026-01-04','pending','urgent','public',0,NULL,NULL,NULL,NULL,0,'2026-01-04 08:41:00','2026-01-04 08:41:00'),(25,'REF260100025',10,2,'Proyektor Rusak (1 hari lalu)','Fasilitas tidak berfungsi dengan baik','Lokasi E',1,3,'2026-01-04','resolved','medium','public',0,NULL,NULL,NULL,NULL,0,'2026-01-04 03:40:00','2026-01-04 03:40:00'),(26,'REF260100026',11,2,'Proyektor Rusak (1 hari lalu)','Perlu perbaikan segera','Lokasi A',1,3,'2026-01-04','pending','medium','public',1,NULL,NULL,NULL,NULL,0,'2026-01-04 06:38:00','2026-01-04 06:38:00'),(27,'REF260100027',12,2,'Lampu Mati (1 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi B',1,3,'2026-01-04','resolved','urgent','public',1,NULL,NULL,NULL,NULL,0,'2026-01-04 04:11:00','2026-01-04 04:11:00'),(28,'REF260100028',13,2,'Atap Bocor (0 hari lalu)','Mengganggu aktivitas pembelajaran','Lokasi C',1,3,'2026-01-05','in_review','medium','public',1,NULL,NULL,NULL,NULL,0,'2026-01-05 10:09:00','2026-01-05 10:09:00'),(29,'REF260100029',14,2,'Dinding Kotor (0 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi D',1,3,'2026-01-05','rejected','urgent','public',0,NULL,NULL,NULL,NULL,0,'2026-01-05 08:53:00','2026-01-05 08:53:00'),(30,'REF260100030',15,2,'Tangga Rusak (0 hari lalu)','Sudah berapa hari belum diperbaiki','Lokasi E',1,3,'2026-01-05','resolved','medium','public',0,NULL,NULL,NULL,NULL,0,'2026-01-05 01:13:00','2026-01-05 01:13:00'),(31,'REF260100031',6,2,'Lampu Mati (0 hari lalu)','Mohon ditangani sesegera mungkin','Lokasi A',1,3,'2026-01-05','pending','medium','public',1,NULL,NULL,NULL,NULL,0,'2026-01-05 03:10:00','2026-01-05 03:10:00'),(32,'REF260100032',7,2,'Atap Bocor (0 hari lalu)','Mengganggu aktivitas pembelajaran','Lokasi B',1,3,'2026-01-05','pending','medium','public',0,NULL,NULL,NULL,NULL,0,'2026-01-05 10:00:00','2026-01-05 10:00:00'),(33,'REF26010033',16,8,'PC RUSAK','tibatiba rusak aneh bapuk  banget baru juga satu semester pc nya dah mau meledak dasar pc kentang konyol konyol','dimana mana hatiku senang',1,7,'2026-01-05','in_progress','high','anonymous',1,NULL,NULL,NULL,NULL,3,'2026-01-05 03:33:21','2026-01-05 03:41:15'),(34,'REF26010034',17,1,'SKS kurang','basdjhwvcbs cmbn aeefgdnbsc bhjbjhsdd bfuerryfben cojsowdhbfq3n dscuwe','jbhsjvfweuafvwef',NULL,NULL,NULL,'in_progress','medium','private',0,NULL,NULL,NULL,NULL,3,'2026-01-05 06:14:25','2026-01-05 08:31:48');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('gCeNlhAOEqLpbdMxbHSHbOussCnz3D4yMSJBFEy8',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSmtZRWM1WlhjSUNTMDI1QmZBWmx2ZXhiUEl2cHcwN3JsOTVmSnEyQSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vc2V0dGluZ3MiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLnNldHRpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1767657573);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_profiles`
--

DROP TABLE IF EXISTS `student_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` bigint unsigned NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `semester` int NOT NULL DEFAULT '1',
  `year_of_entry` year NOT NULL,
  `status` enum('active','inactive','graduated','leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_profiles_nim_unique` (`nim`),
  KEY `student_profiles_user_id_foreign` (`user_id`),
  KEY `student_profiles_faculty_id_foreign` (`faculty_id`),
  KEY `student_profiles_department_id_foreign` (`department_id`),
  CONSTRAINT `student_profiles_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `student_profiles_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  CONSTRAINT `student_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_profiles`
--

LOCK TABLES `student_profiles` WRITE;
/*!40000 ALTER TABLE `student_profiles` DISABLE KEYS */;
INSERT INTO `student_profiles` VALUES (1,6,'11220001',1,1,5,2022,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(2,7,'11230002',1,3,3,2023,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(3,8,'11210003',1,1,7,2021,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(4,9,'11220004',1,2,5,2022,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(5,10,'11240005',1,4,1,2024,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(6,11,'11220006',1,5,5,2022,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(7,12,'11230007',1,3,3,2023,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(8,13,'11220008',1,2,5,2022,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(9,14,'11230009',1,1,3,2023,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(10,15,'11220010',1,4,5,2022,'active',NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(11,16,'243678',1,2,1,2026,'active','avatars/kqav1d2lXWQlNklbmPsNu93xpsMlM6OaV8EbRvXc.png','2026-01-05 01:10:39','2026-01-05 12:20:53'),(12,17,'112345',1,1,1,2026,'active',NULL,'2026-01-05 06:11:12','2026-01-05 06:11:12');
/*!40000 ALTER TABLE `student_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('student','admin','super_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@university.ac.id','2026-01-05 01:06:13','$2y$12$w5A5zEQ.LtecB6fSaMOHc.A.zEwhGMT01aaxJP8rSHWKe6uDu9tme','081234567890','super_admin',1,NULL,'2026-01-05 01:06:13','2026-01-05 01:06:13'),(2,'Admin Fasilitas','fasilitas@university.ac.id','2026-01-05 01:06:13','$2y$12$SdrJrWXRpln0OBGR4f0t7equFf5r/HT5Xm14PFG2.0bfFAlj379sG','081234567891','admin',1,NULL,'2026-01-05 01:06:13','2026-01-05 01:06:13'),(3,'Admin Akademik','akademik@university.ac.id','2026-01-05 01:06:14','$2y$12$xJrEOoK2HOSb30chMKao1ebQyE1G5YImtn39Dy/UHP5ZJoEIi8C56','081234567892','admin',1,NULL,'2026-01-05 01:06:14','2026-01-05 01:06:14'),(4,'Admin Kemahasiswaan','kemahasiswaan@university.ac.id','2026-01-05 01:06:14','$2y$12$Jdo6.DV//e3DSs3Hfdcv5uxN6dZb2ldmKw0uYPwIJwDatC7OFuNeK','081234567893','admin',1,NULL,'2026-01-05 01:06:14','2026-01-05 01:06:14'),(5,'Admin IT','it@university.ac.id','2026-01-05 01:06:14','$2y$12$Iwc0HUEaLo5RHYE6KXl0ielElCJd5.Qp1.YKkaKY88xiAsHTH2GVq','081234567894','admin',1,NULL,'2026-01-05 01:06:14','2026-01-05 01:06:14'),(6,'Budi Santoso','budi.santoso@student.university.ac.id','2026-01-05 01:06:14','$2y$12$..WmdE87UhtvmohJ7C9mue3KNYV/llSfwZsHnLMyrVKqsR2f5FAIe','081298765432','student',1,NULL,'2026-01-05 01:06:14','2026-01-05 01:06:14'),(7,'Siti Nurhaliza','siti.nurhaliza@student.university.ac.id','2026-01-05 01:06:15','$2y$12$LjJMY7mc9zMo5l3Vki4XmeMWVfHlVXsohfI7HoxJwU0wp1.3YOpaG','081298765433','student',1,NULL,'2026-01-05 01:06:15','2026-01-05 01:06:15'),(8,'Ahmad Fauzi','ahmad.fauzi@student.university.ac.id','2026-01-05 01:06:15','$2y$12$voHEnNAJIPnNtXCQm1if6ux8RUUgi1kZaabsY.ybeB66EU7xEnmL2','081298765434','student',1,NULL,'2026-01-05 01:06:15','2026-01-05 01:06:15'),(9,'Dewi Lestari','dewi.lestari@student.university.ac.id','2026-01-05 01:06:16','$2y$12$w8MJJDuoQ0MHwivzrm0//.mc/.rkM/QWlg5GVzEWAKCQpTXQ32wLS','081298765435','student',1,NULL,'2026-01-05 01:06:16','2026-01-05 01:06:16'),(10,'Rudi Hermawan','rudi.hermawan@student.university.ac.id','2026-01-05 01:06:16','$2y$12$ohVZ7h.eSeURhmh31fXxf.KbcOadTzzXDJz6w.9VBbFLAl8KOiy3S','081298765436','student',1,NULL,'2026-01-05 01:06:16','2026-01-05 01:06:16'),(11,'Rina Wijayanti','rina.wijayanti@student.university.ac.id','2026-01-05 01:06:16','$2y$12$rnIXOZMfn/xBGntWJzvTzumXmV2SGY6934KZblKKVdbRJRzwX4r1G','081298765437','student',1,NULL,'2026-01-05 01:06:16','2026-01-05 01:06:16'),(12,'Andi Pratama','andi.pratama@student.university.ac.id','2026-01-05 01:06:16','$2y$12$Iw8184ch2J8d3Oa5fp9oV.J8qzOWRNtoHiReQ1.EiLF2Zabiedmna','081298765438','student',1,NULL,'2026-01-05 01:06:16','2026-01-05 01:06:16'),(13,'Maya Sari','maya.sari@student.university.ac.id','2026-01-05 01:06:17','$2y$12$4tDaIdkLTvy.2P6NuWYmquV0xiZg74uQOJbG0XrfrNNfb/N1BVY9.','081298765439','student',1,NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(14,'Doni Saputra','doni.saputra@student.university.ac.id','2026-01-05 01:06:17','$2y$12$9dr0LByKueb09rSZfdgdquIFuKcfKnOy.vTPE9vFXQotv6fCDFhvm','081298765440','student',1,NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(15,'Lisa Anggraini','lisa.anggraini@student.university.ac.id','2026-01-05 01:06:17','$2y$12$oGUHZZz.gYNA9aib1Qhg.eL64NlTEFR2vGrt41vP8VkxvzQ9JWwRy','081298765441','student',1,NULL,'2026-01-05 01:06:17','2026-01-05 01:06:17'),(16,'fetra abdul malik','fetraabdulmalikbarkah@gmail.com',NULL,'$2y$12$Ob7VohWY6Nv/ntyaagGxVOcUQRXFl08kAjSLTomxgbHIscy41ADp2',NULL,'student',1,NULL,'2026-01-05 01:10:39','2026-01-05 12:20:52'),(17,'udin','udin@gmail.com',NULL,'$2y$12$m/ICGGV2C7mw6W.FqNOcOu1Ck0upgdXZCEdmc6RWI7jwO4bW1V.B.','085678910','student',1,NULL,'2026-01-05 06:11:12','2026-01-05 06:11:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-06  6:59:41
