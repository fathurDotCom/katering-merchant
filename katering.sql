/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_uuid_unique` (`uuid`),
  KEY `categories_company_uuid_foreign` (`company_uuid`),
  CONSTRAINT `categories_company_uuid_foreign` FOREIGN KEY (`company_uuid`) REFERENCES `companies` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `logo_light` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_dark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `sum` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_details_uuid_unique` (`uuid`),
  KEY `order_details_order_uuid_foreign` (`order_uuid`),
  KEY `order_details_product_uuid_foreign` (`product_uuid`),
  CONSTRAINT `order_details_order_uuid_foreign` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `order_details_product_uuid_foreign` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` int NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `paid` decimal(8,2) DEFAULT NULL,
  `transaction_type` enum('transfer','cash','loan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_method` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_uuid_unique` (`uuid`),
  KEY `orders_company_uuid_foreign` (`company_uuid`),
  KEY `orders_created_by_foreign` (`created_by`),
  KEY `customer_uuid` (`customer_uuid`),
  CONSTRAINT `orders_company_uuid_foreign` FOREIGN KEY (`company_uuid`) REFERENCES `companies` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_uuid`) REFERENCES `users` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_images_uuid_unique` (`uuid`),
  KEY `product_images_product_uuid_foreign` (`product_uuid`),
  CONSTRAINT `product_images_product_uuid_foreign` FOREIGN KEY (`product_uuid`) REFERENCES `products` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_uuid_unique` (`uuid`),
  KEY `products_company_uuid_foreign` (`company_uuid`),
  KEY `products_category_uuid_foreign` (`category_uuid`),
  CONSTRAINT `products_category_uuid_foreign` FOREIGN KEY (`category_uuid`) REFERENCES `categories` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `products_company_uuid_foreign` FOREIGN KEY (`company_uuid`) REFERENCES `companies` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_uuid_unique` (`uuid`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_uuid_foreign` (`company_uuid`),
  CONSTRAINT `users_company_uuid_foreign` FOREIGN KEY (`company_uuid`) REFERENCES `companies` (`uuid`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;





INSERT INTO `categories` (`id`, `uuid`, `company_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '766540f0-2813-4f69-9809-19099e4bc8fa', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', 'category1', 1, '2024-05-22 05:19:26', '2024-05-22 05:19:26', NULL);
INSERT INTO `categories` (`id`, `uuid`, `company_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'fc281409-04c1-47ca-a36d-cdb30d8c4320', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', 'category2', 1, '2024-05-22 05:19:31', '2024-05-22 05:19:31', NULL);
INSERT INTO `categories` (`id`, `uuid`, `company_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'a5bfcf20-e241-4785-a188-a6e289921182', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', 'category3', 1, '2024-05-22 05:19:35', '2024-05-22 05:19:35', NULL);
INSERT INTO `categories` (`id`, `uuid`, `company_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '8ae507ab-b82a-4c2c-a78c-8d5087baebfd', 'aef84395-3016-40b7-b55b-7cad03c9ad36', 'category1', 1, '2024-05-22 05:19:44', '2024-05-22 05:19:44', NULL),
(5, '95b47bdb-b964-4e57-b09a-81d9be16a7ce', 'aef84395-3016-40b7-b55b-7cad03c9ad36', 'category2', 1, '2024-05-22 05:19:48', '2024-05-22 05:19:48', NULL),
(6, '5ae001d3-a450-4714-bd21-529cf46cd18f', 'aef84395-3016-40b7-b55b-7cad03c9ad36', 'category3', 1, '2024-05-22 05:19:51', '2024-05-22 05:19:51', NULL),
(7, '4bd51df6-83e6-44f3-8ac7-2b0b6881509e', '34a2977b-6cbc-4624-8869-3956b7722150', 'fast food', 1, '2024-05-22 09:13:54', '2024-05-22 09:13:54', NULL),
(8, '95d1fe81-462b-4585-82a1-3ee9e606ba97', '34a2977b-6cbc-4624-8869-3956b7722150', 'sea food', 1, '2024-05-22 09:14:00', '2024-05-22 09:14:00', NULL),
(9, '159561e8-bee0-4fe4-8171-2fd4342a64e5', '34a2977b-6cbc-4624-8869-3956b7722150', 'drinks', 1, '2024-05-22 09:14:09', '2024-05-22 09:15:33', NULL),
(10, '89b8a074-0ca5-46a3-bd20-163f9c202a44', '34a2977b-6cbc-4624-8869-3956b7722150', 'drunk', 0, '2024-05-22 09:15:44', '2024-05-22 09:15:48', '2024-05-22 09:15:48');

INSERT INTO `companies` (`id`, `uuid`, `name`, `address`, `logo_light`, `logo_dark`, `favicon`, `phone`, `email`, `url`, `facebook`, `instagram`, `youtube`, `twitter`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', 'company1', 'dki jakarta', 'gDsnn20240522051618Gemini_Generated_Image_ez4nh3ez4nh3ez4n.jpeg', '2NI6l20240522051618Gemini_Generated_Image_ez4nh3ez4nh3ez4n.jpeg', '1mh6p20240522051618Gemini_Generated_Image_ez4nh3ez4nh3ez4n.jpeg', '(808) 975-384-0390', 'company1@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, '2024-05-22 05:16:18', '2024-05-22 05:16:18', NULL);
INSERT INTO `companies` (`id`, `uuid`, `name`, `address`, `logo_light`, `logo_dark`, `favicon`, `phone`, `email`, `url`, `facebook`, `instagram`, `youtube`, `twitter`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'aef84395-3016-40b7-b55b-7cad03c9ad36', 'company2', 'bandung', '62ZCc20240522051728Gemini_Generated_Image_ez4nh3ez4nh3ez4n.jpeg', 'YULFE20240522051728Gemini_Generated_Image_ez4nh3ez4nh3ez4n.jpeg', 'xjfc520240522051728Gemini_Generated_Image_ez4nh3ez4nh3ez4n.jpeg', '(171) 193-880-4775', 'company2@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, '2024-05-22 05:17:28', '2024-05-22 05:17:28', NULL);
INSERT INTO `companies` (`id`, `uuid`, `name`, `address`, `logo_light`, `logo_dark`, `favicon`, `phone`, `email`, `url`, `facebook`, `instagram`, `youtube`, `twitter`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '34a2977b-6cbc-4624-8869-3956b7722150', 'company3', 'semarang', 'MVmw520240522091146Gemini_Generated_Image_jc5p4jc5p4jc5p4j.jpeg', 'Rj2mH20240522091146Gemini_Generated_Image_jc5p4jc5p4jc5p4j.jpeg', 'rXlDB20240522091146Gemini_Generated_Image_jc5p4jc5p4jc5p4j.jpeg', '(803) 294-374-8200', 'company3@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, '2024-05-22 09:11:46', '2024-05-22 09:11:46', NULL);







INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2024_04_29_162444_create_companies_table', 1),
(5, '2024_04_29_162621_create_users_table', 1),
(6, '2024_04_29_164642_create_categories_table', 1),
(7, '2024_04_29_164907_create_products_table', 1),
(8, '2024_04_29_165360_create_product_images_table', 1),
(9, '2024_04_29_165553_create_customers_table', 1),
(10, '2024_04_29_165740_create_orders_table', 1),
(11, '2024_04_29_170212_create_order_details_table', 1),
(12, '2024_04_30_160109_create_permission_tables', 1);



INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 3);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5);

INSERT INTO `order_details` (`id`, `uuid`, `order_uuid`, `product_uuid`, `price`, `sum`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'e7b8d97b-a6f4-49cc-887a-845fbb2be6f2', '1cce436b-6666-41f5-99b8-87d5513619b8', '69aff50b-162f-4699-8daa-7f493ed22f77', '17000.00', 3, '2024-05-22 08:03:31', '2024-05-22 08:03:31', NULL);
INSERT INTO `order_details` (`id`, `uuid`, `order_uuid`, `product_uuid`, `price`, `sum`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'ab985c63-a9fe-43a7-bed6-aeec58bf95c3', '1cce436b-6666-41f5-99b8-87d5513619b8', '1d75da6c-6f84-45c3-a16d-187525e78280', '10000.00', 2, '2024-05-22 08:03:31', '2024-05-22 08:03:31', NULL);
INSERT INTO `order_details` (`id`, `uuid`, `order_uuid`, `product_uuid`, `price`, `sum`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'a53e4bff-1cd1-43b7-91a6-b5f095e0ae4d', '47f4a7d4-77bd-4cb4-b807-27f14d1ac450', 'abd49394-8c8d-44bb-b937-9112269171f5', '1000.00', 10, '2024-05-22 08:08:00', '2024-05-22 08:26:02', '2024-05-22 08:26:02');
INSERT INTO `order_details` (`id`, `uuid`, `order_uuid`, `product_uuid`, `price`, `sum`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '70e75b91-6a69-4c7d-a6c4-b05f05ed921c', '47f4a7d4-77bd-4cb4-b807-27f14d1ac450', 'abd49394-8c8d-44bb-b937-9112269171f5', '1000.00', 1, '2024-05-22 08:25:39', '2024-05-22 08:25:42', '2024-05-22 08:25:42'),
(5, '54a6743f-f155-461a-b879-3a67e1e79808', '47f4a7d4-77bd-4cb4-b807-27f14d1ac450', 'abd49394-8c8d-44bb-b937-9112269171f5', '1000.00', 1, '2024-05-22 08:25:42', '2024-05-22 08:25:53', '2024-05-22 08:25:53'),
(6, '5860312f-14f0-48bd-9727-7cb94eff7c2d', 'f6c94a82-99ed-47c5-b561-5be1f3b66c31', '1d75da6c-6f84-45c3-a16d-187525e78280', '10000.00', 1, '2024-05-22 08:40:36', '2024-05-22 08:45:12', '2024-05-22 08:45:12'),
(7, 'b71ad85e-ee94-47e1-9f87-c3626b0a90e0', 'f6c94a82-99ed-47c5-b561-5be1f3b66c31', '1d75da6c-6f84-45c3-a16d-187525e78280', '10000.00', 1, '2024-05-22 08:40:36', '2024-05-22 08:45:12', '2024-05-22 08:45:12'),
(8, 'd6bd6085-a6c7-41f6-8e7c-5c8622fb54a4', '10dae8f8-34b7-4c0a-9848-e0663c35467f', 'abd49394-8c8d-44bb-b937-9112269171f5', '1000.00', 6, '2024-05-22 08:42:07', '2024-05-22 08:45:09', '2024-05-22 08:45:09'),
(9, '1ce9d57a-c6be-4dd5-939a-f718b08dd0b1', 'e22ffc18-0263-4acc-96b0-27df2c5b1cd9', '69aff50b-162f-4699-8daa-7f493ed22f77', '17000.00', 4, '2024-05-22 08:45:04', '2024-05-22 08:45:04', NULL),
(10, 'f3a6c209-6a5b-4b52-a295-3bb043d2a9e1', 'e22ffc18-0263-4acc-96b0-27df2c5b1cd9', '1d75da6c-6f84-45c3-a16d-187525e78280', '10000.00', 1, '2024-05-22 08:45:04', '2024-05-22 08:45:04', NULL),
(11, '826e3d43-6d50-45b0-8370-13e30725d649', 'bec11108-714c-4094-a8c3-bbace99044d3', '69aff50b-162f-4699-8daa-7f493ed22f77', '17000.00', 10, '2024-05-22 09:06:18', '2024-05-22 09:06:18', NULL),
(12, 'db40b468-f7ea-4282-bc71-b092497bd4a5', 'bec11108-714c-4094-a8c3-bbace99044d3', '1d75da6c-6f84-45c3-a16d-187525e78280', '10000.00', 8, '2024-05-22 09:06:18', '2024-05-22 09:06:18', NULL),
(13, '47bd6ae7-675f-4324-918b-6cad14584aa8', 'd88da3e8-3a46-4e6c-8cbc-8e56e1a24731', '245c4fcc-94a9-4949-86a3-6a93d1d3bbd1', '100000.00', 1, '2024-05-22 09:20:20', '2024-05-22 09:20:20', NULL),
(14, '39e668e6-43e3-4e5a-aa03-f3795fe0a209', 'd88da3e8-3a46-4e6c-8cbc-8e56e1a24731', 'f29ccda9-8ba8-40a7-a7ee-65a063fa1c82', '5000.00', 3, '2024-05-22 09:20:20', '2024-05-22 09:20:20', NULL),
(15, '2fd123cb-3b87-4dee-b169-9935b08acf10', 'd88da3e8-3a46-4e6c-8cbc-8e56e1a24731', '313fa3ab-9dce-42c8-b2d9-5527e28d073d', '1000.00', 2, '2024-05-22 09:20:20', '2024-05-22 09:20:20', NULL);

INSERT INTO `orders` (`id`, `uuid`, `company_uuid`, `customer_uuid`, `order_number`, `invoice`, `amount`, `paid`, `transaction_type`, `created_method`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '1cce436b-6666-41f5-99b8-87d5513619b8', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', '79722c36-cef6-47cf-9283-e340015326c3', 101777, 'inv-20240522080331-1584', '27000.00', '80000.00', 'transfer', 'admin', NULL, '25fc574f-e9e2-4a40-bfbb-7a141691fb98', '2024-05-22 08:03:31', '2024-05-22 08:03:31', NULL);
INSERT INTO `orders` (`id`, `uuid`, `company_uuid`, `customer_uuid`, `order_number`, `invoice`, `amount`, `paid`, `transaction_type`, `created_method`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '47f4a7d4-77bd-4cb4-b807-27f14d1ac450', 'aef84395-3016-40b7-b55b-7cad03c9ad36', '79722c36-cef6-47cf-9283-e340015326c3', 872046, 'inv-20240522082553-1124', '1000.00', '10000.00', 'transfer', 'admin', NULL, '25fc574f-e9e2-4a40-bfbb-7a141691fb98', '2024-05-22 08:08:00', '2024-05-22 08:26:02', '2024-05-22 08:26:02');
INSERT INTO `orders` (`id`, `uuid`, `company_uuid`, `customer_uuid`, `order_number`, `invoice`, `amount`, `paid`, `transaction_type`, `created_method`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'f6c94a82-99ed-47c5-b561-5be1f3b66c31', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', '79722c36-cef6-47cf-9283-e340015326c3', 250851, 'inv-20240522084130-6908', '10000.00', '54000.00', 'cash', 'admin', 'test', '79722c36-cef6-47cf-9283-e340015326c3', '2024-05-22 08:40:36', '2024-05-22 08:45:12', '2024-05-22 08:45:12');
INSERT INTO `orders` (`id`, `uuid`, `company_uuid`, `customer_uuid`, `order_number`, `invoice`, `amount`, `paid`, `transaction_type`, `created_method`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '10dae8f8-34b7-4c0a-9848-e0663c35467f', 'aef84395-3016-40b7-b55b-7cad03c9ad36', '79722c36-cef6-47cf-9283-e340015326c3', 729814, 'inv-20240522084207-5526', '1000.00', '10000.00', 'transfer', 'admin', 'Earum veritatis minu', '79722c36-cef6-47cf-9283-e340015326c3', '2024-05-22 08:42:07', '2024-05-22 08:45:09', '2024-05-22 08:45:09'),
(7, 'e22ffc18-0263-4acc-96b0-27df2c5b1cd9', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', '79722c36-cef6-47cf-9283-e340015326c3', 155224, 'inv-20240522084503-5264', '78000.00', '100000.00', 'transfer', 'admin', NULL, '79722c36-cef6-47cf-9283-e340015326c3', '2024-05-22 08:45:04', '2024-05-22 08:45:04', NULL),
(8, 'bec11108-714c-4094-a8c3-bbace99044d3', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', '79722c36-cef6-47cf-9283-e340015326c3', 258725, 'inv-20240522090618-8281', '250000.00', '300000.00', 'cash', 'admin', NULL, 'f6c27cd5-e747-4db1-84e1-35cd8c41f227', '2024-05-22 09:06:18', '2024-05-22 09:06:18', NULL),
(9, 'd88da3e8-3a46-4e6c-8cbc-8e56e1a24731', '34a2977b-6cbc-4624-8869-3956b7722150', '79722c36-cef6-47cf-9283-e340015326c3', 660620, 'inv-20240522092020-1722', '117000.00', '120000.00', 'cash', 'admin', NULL, '6247d4d1-a746-4f65-ab33-9a5d13fc7ec9', '2024-05-22 09:20:20', '2024-05-22 09:20:20', NULL);







INSERT INTO `product_images` (`id`, `uuid`, `product_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '4e8cad70-f097-408f-8391-bf405811044c', '1d75da6c-6f84-45c3-a16d-187525e78280', '8gXFV20240522052217download.jpg', 1, '2024-05-22 05:22:17', '2024-05-22 05:22:17', NULL);
INSERT INTO `product_images` (`id`, `uuid`, `product_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'bbb1e99a-ba62-470a-817b-d5785b5997ee', '69aff50b-162f-4699-8daa-7f493ed22f77', 'FKXn720240522052355download.jpg', 1, '2024-05-22 05:23:55', '2024-05-22 05:23:55', NULL);
INSERT INTO `product_images` (`id`, `uuid`, `product_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'e2f59578-da65-4faf-a10e-ec7f2e467b9b', '69aff50b-162f-4699-8daa-7f493ed22f77', 'Rc1qq20240522052355download.jpg', 1, '2024-05-22 05:23:55', '2024-05-22 05:23:55', NULL);
INSERT INTO `product_images` (`id`, `uuid`, `product_uuid`, `name`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'd8834292-2acf-459a-a8af-d7f9971b90c4', '69aff50b-162f-4699-8daa-7f493ed22f77', 'pFg5O20240522052355download.jpg', 1, '2024-05-22 05:23:55', '2024-05-22 05:23:55', NULL),
(5, '4477cb7b-5137-412c-89cc-fb608d159f59', 'abd49394-8c8d-44bb-b937-9112269171f5', 'ZSS6O20240522053644download.jpg', 1, '2024-05-22 05:36:44', '2024-05-22 05:36:44', NULL),
(6, 'd5151db4-86f8-421d-91c0-c7a28403ef3c', 'abd49394-8c8d-44bb-b937-9112269171f5', '5Zbp120240522053644download.jpg', 1, '2024-05-22 05:36:44', '2024-05-22 05:36:44', NULL),
(9, 'd11a6aa5-0047-4470-bff9-e9bad1dd1032', 'abd49394-8c8d-44bb-b937-9112269171f5', 'uw6eY20240522053659download.jpg', 1, '2024-05-22 05:36:59', '2024-05-22 05:36:59', NULL),
(10, '1ce22172-79a0-4d6a-b11c-4070be67d901', '245c4fcc-94a9-4949-86a3-6a93d1d3bbd1', 'o5uoh20240522091739download.jpg', 1, '2024-05-22 09:17:39', '2024-05-22 09:17:39', NULL),
(11, 'a1b11af2-1463-407f-926b-6d5a4af0832e', '245c4fcc-94a9-4949-86a3-6a93d1d3bbd1', 'u8F2b20240522091739download.jpg', 1, '2024-05-22 09:17:39', '2024-05-22 09:17:39', NULL),
(12, '60736af8-59b0-4f10-876e-3657e70cff8f', '245c4fcc-94a9-4949-86a3-6a93d1d3bbd1', 'CLkIH20240522091739download.jpg', 1, '2024-05-22 09:17:39', '2024-05-22 09:17:39', NULL),
(13, 'e866d6c7-2eb5-4fa9-b1f5-90fa60e4930f', '313fa3ab-9dce-42c8-b2d9-5527e28d073d', 'SHecj20240522091818download.jpg', 1, '2024-05-22 09:18:18', '2024-05-22 09:18:18', NULL),
(14, '43e653fe-c316-46a6-849f-8575b0f7638e', '313fa3ab-9dce-42c8-b2d9-5527e28d073d', 'H7DS020240522091818download.jpg', 1, '2024-05-22 09:18:18', '2024-05-22 09:18:18', NULL),
(15, 'e699ff66-9dfe-4fac-8ada-d2b7f9d50a5d', 'f29ccda9-8ba8-40a7-a7ee-65a063fa1c82', 'EhCNy20240522091855download.jpg', 1, '2024-05-22 09:18:55', '2024-05-22 09:18:55', NULL);

INSERT INTO `products` (`id`, `uuid`, `company_uuid`, `category_uuid`, `sku_code`, `name`, `price`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1d75da6c-6f84-45c3-a16d-187525e78280', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', '766540f0-2813-4f69-9809-19099e4bc8fa', '100000', 'grilled fish', '10000.00', 'sea food from hawai', 1, '2024-05-22 05:22:17', '2024-05-22 05:22:17', NULL);
INSERT INTO `products` (`id`, `uuid`, `company_uuid`, `category_uuid`, `sku_code`, `name`, `price`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '69aff50b-162f-4699-8daa-7f493ed22f77', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', 'fc281409-04c1-47ca-a36d-cdb30d8c4320', '100001', 'fried rice', '17000.00', 'yummi', 1, '2024-05-22 05:23:55', '2024-05-22 05:23:55', NULL);
INSERT INTO `products` (`id`, `uuid`, `company_uuid`, `category_uuid`, `sku_code`, `name`, `price`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'abd49394-8c8d-44bb-b937-9112269171f5', 'aef84395-3016-40b7-b55b-7cad03c9ad36', '8ae507ab-b82a-4c2c-a78c-8d5087baebfd', '100002', 'product1', '1000.00', 'makassar', 1, '2024-05-22 05:36:44', '2024-05-22 05:36:59', NULL);
INSERT INTO `products` (`id`, `uuid`, `company_uuid`, `category_uuid`, `sku_code`, `name`, `price`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '245c4fcc-94a9-4949-86a3-6a93d1d3bbd1', '34a2977b-6cbc-4624-8869-3956b7722150', '95d1fe81-462b-4585-82a1-3ee9e606ba97', '100003', 'crab', '100000.00', 'yummi', 1, '2024-05-22 09:17:39', '2024-05-22 09:17:39', NULL),
(5, '313fa3ab-9dce-42c8-b2d9-5527e28d073d', '34a2977b-6cbc-4624-8869-3956b7722150', '4bd51df6-83e6-44f3-8ac7-2b0b6881509e', '100004', 'junk', '1000.00', NULL, 1, '2024-05-22 09:18:18', '2024-05-22 09:18:18', NULL),
(6, 'f29ccda9-8ba8-40a7-a7ee-65a063fa1c82', '34a2977b-6cbc-4624-8869-3956b7722150', '159561e8-bee0-4fe4-8171-2fd4342a64e5', '100005', 'juice orange', '5000.00', 'fresh', 1, '2024-05-22 09:18:55', '2024-05-22 09:18:55', NULL),
(8, 'ff40d7ab-5d49-4733-94a5-9f788c815d87', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', '766540f0-2813-4f69-9809-19099e4bc8fa', '100006', 'category1', '120000.00', NULL, 1, '2024-05-22 09:33:35', '2024-05-22 09:33:48', '2024-05-22 09:33:48');



INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2024-05-22 10:33:47', '2024-05-22 10:33:47');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'merchant', 'web', '2024-05-22 10:33:47', '2024-05-22 10:33:47');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'user', 'web', '2024-05-22 10:33:47', '2024-05-22 10:33:47');

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6GrluWfvj6kBkYAspLTqNVu3guNbD2Kq28APTuut', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU3dNb1hzNlczOW5RaXFwWWJKVE5Ea2FWM3JkS2hOQ1ZSWnNoNkMxUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzE2MzY5OTAzO319', 1716370429);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6H6dpKuKuRk8gLHawckhbn7nfr4YVNCeqrtCOrua', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidDZxeW9NRGNZMk0xdTlLU2xzOFZ3ZTdkY2RRRHhTYzRKQ1U3cjhXcCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXJzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb21wYW5pZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTcxNjM3MDI4Nzt9fQ==', 1716370292);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('nbi0LHk0ckjOju1cfbtYcptgXg9Sp9gT7QRzwZK2', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiY2RPem5yYnlrS0pZS2VlTEpxMWxKZDg2WGFhRXVKa1dsbW1LdUlBUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAxIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1716369893);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ompr17BdSRLc4BiMoz1jMK9ux18o9NsReG5iwJLs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzN5ZGdta0tubDN5QllJZE1GZGw5cXE4bzNHaURabVdiUFdVUFQxTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1716369681),
('roZz8wX5f8RdQPt11nZMZzRqjzuEZU70LnlcEeaE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUNrUkpOaTRyNVc2a1BsWUJXUHNHc2llcTlvNzVkN0xveDlPMDdDbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1716369684);

INSERT INTO `users` (`id`, `uuid`, `company_uuid`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `phone`, `photo`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '25fc574f-e9e2-4a40-bfbb-7a141691fb98', 'bda07dc4-cab9-4148-ac9c-7a44c3c553f9', 'user1', 'merchant', 'merchant1@katering.com', NULL, '$2y$12$xUdBFhxwacZSUEPlpIxlY.38A3l.7sqATLPMxizJOlw0jSj8ItXgK', '(456) 780-897-8765', NULL, 1, NULL, '2024-05-22 03:32:28', '2024-05-22 05:54:09', NULL);
INSERT INTO `users` (`id`, `uuid`, `company_uuid`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `phone`, `photo`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '6247d4d1-a746-4f65-ab33-9a5d13fc7ec9', '34a2977b-6cbc-4624-8869-3956b7722150', 'user2', 'merchant', 'merchant2@katering.com', NULL, '$2y$12$1DBB2NWhNgNWccmMNjwbj.Mq245qQ4umWJ7CFq2YCe9Oxj6un33oq', NULL, NULL, 1, NULL, '2024-05-22 04:39:23', '2024-05-22 09:11:46', NULL);
INSERT INTO `users` (`id`, `uuid`, `company_uuid`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `phone`, `photo`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'f6c27cd5-e747-4db1-84e1-35cd8c41f227', NULL, 'super', 'admin', 'admin@katering.com', NULL, '$2y$12$BW7dO3SVSkb9Ct/HkON/POrLOKnFigCdH1kIR18SfNJjxEHiX4Xwi', NULL, '0IY6E20240522092714690eefe3ba1f553e0ea527f51ee407b604b681b4.jpg', 1, NULL, '2024-05-22 04:59:28', '2024-05-22 09:27:14', NULL);
INSERT INTO `users` (`id`, `uuid`, `company_uuid`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `phone`, `photo`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '79722c36-cef6-47cf-9283-e340015326c3', NULL, 'user1', 'customer', 'customer1@katering.com', NULL, '$2y$12$iNEW.3vBh5GQkd81zmBOieAwB.BlXdhFmdboFvQWufFKuSfdMva8q', NULL, NULL, 1, NULL, '2024-05-22 06:37:40', '2024-05-22 06:37:40', NULL),
(5, 'bc745e68-5c6b-45e0-a85a-658bc6467680', 'aef84395-3016-40b7-b55b-7cad03c9ad36', 'goat', 'antonio', 'goatantonio@katering.com', NULL, '$2y$12$7plZ3uBLUA1pD7a4NLCAEO8boYzmujIPI74wK72gMaBpeNcFM3Fne', '(957) 464-320-2023', 'tIoIN20240522093234Screenshot-2024-05-18-190704.png', 1, NULL, '2024-05-22 09:32:34', '2024-05-22 09:32:34', NULL);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;