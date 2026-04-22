-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: ikhtiar_berkah
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_id` bigint unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_type_id_foreign` (`type_id`),
  CONSTRAINT `categories_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,1,'Tumbler','2025-04-08 00:43:12','2025-04-08 00:43:12');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2025_03_11_034530_create_types_table',1),(3,'2025_03_11_034640_create_categories_table',1),(4,'2025_03_12_065521_create_products_table',1),(5,'2025_03_13_032350_create_users_table',1),(6,'2025_03_21_043433_create_partnerships_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partnerships`
--

DROP TABLE IF EXISTS `partnerships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partnerships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partnerships`
--

LOCK TABLES `partnerships` WRITE;
/*!40000 ALTER TABLE `partnerships` DISABLE KEYS */;
INSERT INTO `partnerships` VALUES (1,'/images/company-logo/company-logo-1.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(2,'/images/company-logo/company-logo-2.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(3,'/images/company-logo/company-logo-3.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(4,'/images/company-logo/company-logo-4.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(5,'/images/company-logo/company-logo-5.png','2025-04-08 00:43:12','2025-04-08 00:43:12');
/*!40000 ALTER TABLE `partnerships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` bigint unsigned NOT NULL DEFAULT '0',
  `category_type` bigint unsigned NOT NULL DEFAULT '0',
  `discount` int NOT NULL DEFAULT '0',
  `price` int NOT NULL DEFAULT '0',
  `image_url` json DEFAULT NULL,
  `detail` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `click_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `products_product_type_foreign` (`product_type`),
  KEY `products_category_type_foreign` (`category_type`),
  CONSTRAINT `products_category_type_foreign` FOREIGN KEY (`category_type`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_product_type_foreign` FOREIGN KEY (`product_type`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('0c13de26-5839-4eae-9647-f98082ecbe2a','Example',1,1,80,1250000,'[\"/images/product-image/goodie-bag.jpg\", \"/images/product-image/tumbler.jpg\"]','{\"size\": \"L\", \"weight\": \"20kg\"}','This Tumbler made with your mythical heavenly Freshly rod below your abdomen',0,'2025-04-08 00:43:12','2025-04-08 00:43:12'),('21d8832d-a92e-4bff-a5c9-a74d5b6f725d','Example Tumbler2',1,1,10,1200000,'[\"/images/product-image/tumbler.jpg\", \"/images/product-image/tumbler.jpg\"]','[]','This is just an example',0,'2025-04-08 00:43:12','2025-04-08 00:43:12'),('6771b9fc-5a8f-4c7a-a421-90445d582b56','Example Tumbler6',1,1,10,1200000,'[\"/images/product-image/tumbler.jpg\"]','[]','This is just an example',0,'2025-04-08 00:43:12','2025-04-08 00:43:12'),('737ffa42-5755-4291-ad53-239c57872ddf','Example Tumbler3',1,1,10,1200000,'[\"/images/product-image/tumbler.jpg\"]','[]','This is just an example',0,'2025-04-08 00:43:12','2025-04-08 00:43:12'),('d5978fc5-137d-40f0-9ccb-20d6eae4674d','MUG',1,1,10,1200000,'[\"/images/product-image/mug-mockup.jpg\", \"/images/product-image/tumbler.jpg\"]','[]','This is just an example',0,'2025-04-08 00:43:12','2025-04-08 00:43:12'),('da367311-52f6-47d3-b97e-c1b46c0d75d9','Example Tumbler4',1,1,10,1200000,'[\"/images/product-image/tumbler.jpg\"]','[]','This is just an example',0,'2025-04-08 00:43:12','2025-04-08 00:43:12');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Souvenir','1.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(2,'Plakat','2.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(3,'Stempel','3.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(4,'Booth','4.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(5,'Printing','5.png','2025-04-08 00:43:12','2025-04-08 00:43:12'),(6,'Others','6.png','2025-04-08 00:43:12','2025-04-08 00:43:12');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin1','Admin Tokabe 1','$2y$12$W8wtHIPlscByiFrZgHa8N.o8L2yEYm9T1g.XKXyV2EXW7pO7wxYXG','2025-04-08 01:18:34','2025-04-08 01:20:20');
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

-- Dump completed on 2025-04-09  9:10:15
