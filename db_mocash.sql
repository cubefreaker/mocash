-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_mocash
CREATE DATABASE IF NOT EXISTS `db_mocash` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_mocash`;

-- Dumping structure for table db_mocash.tb_cart
CREATE TABLE IF NOT EXISTS `tb_cart` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `user_email` varchar(191) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `total_produk` int NOT NULL DEFAULT '0',
  `total_harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pembayaran` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sisa_pembayaran` decimal(10,2) NOT NULL DEFAULT '0.00',
  `waktu_buat` datetime DEFAULT CURRENT_TIMESTAMP,
  `waktu_selesai` datetime DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `company` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cabang` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_cart_user_id_fk` (`user_id`),
  KEY `tb_cart_user_email_fk` (`user_email`),
  CONSTRAINT `tb_cart_user_email_fk` FOREIGN KEY (`user_email`) REFERENCES `tb_user` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `tb_cart_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_cart: ~9 rows (approximately)
INSERT INTO `tb_cart` (`id`, `user_id`, `user_email`, `total_produk`, `total_harga`, `pembayaran`, `sisa_pembayaran`, `waktu_buat`, `waktu_selesai`, `status`, `company`, `cabang`) VALUES
	(9, 8, 'kasir1@mail.com', 4, 94500.00, 100000.00, 5500.00, '2023-07-18 18:11:45', '2023-07-18 17:40:21', 'Done', 'McDonald\'s', 'DMALL'),
	(10, 8, 'kasir1@mail.com', 2, 94000.00, 0.00, 0.00, '2023-07-18 18:11:47', '2023-07-18 18:01:27', 'Cancel', 'McDonald\'s', 'DMALL'),
	(11, 8, 'kasir1@mail.com', 2, 94000.00, 0.00, 0.00, '2023-07-18 18:11:47', '2023-07-18 18:01:39', 'Cancel', 'McDonald\'s', 'DMALL'),
	(12, 8, 'kasir1@mail.com', 2, 94000.00, 0.00, 0.00, '2023-07-18 18:11:48', '2023-07-18 18:03:05', 'Cancel', 'McDonald\'s', 'DMALL'),
	(13, 8, 'kasir1@mail.com', 2, 94000.00, 0.00, 0.00, '2023-07-18 18:11:48', '2023-07-18 18:04:06', 'Cancel', 'McDonald\'s', 'DMALL'),
	(14, 8, 'kasir1@mail.com', 2, 82000.00, 100000.00, 18000.00, '2023-07-18 18:11:49', '2023-07-18 18:04:23', 'Done', 'McDonald\'s', 'DMALL'),
	(15, 8, 'kasir1@mail.com', 7, 111000.00, 0.00, 0.00, '2023-07-18 21:08:09', '2023-07-18 21:08:09', 'Cancel', 'McDonald\'s', 'DMALL'),
	(16, 8, 'kasir1@mail.com', 3, 85000.00, 100000.00, 15000.00, '2023-07-19 06:16:23', '2023-07-18 21:09:09', 'Done', 'McDonald\'s', 'DMALL'),
	(17, 8, 'kasir1@mail.com', 1, 46000.00, 50000.00, 4000.00, '2023-07-18 21:09:55', '2023-07-18 21:09:55', 'Done', 'McDonald\'s', 'DMALL');

-- Dumping structure for table db_mocash.tb_cart_detail
CREATE TABLE IF NOT EXISTS `tb_cart_detail` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int DEFAULT NULL,
  `id_cart` int unsigned NOT NULL,
  `jumlah` int DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cabang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`),
  KEY `tb_cart_detail_id_cart_fk` (`id_cart`),
  CONSTRAINT `tb_cart_detail_id_cart_fk` FOREIGN KEY (`id_cart`) REFERENCES `tb_cart` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `tb_cart_detail_id_product_fk` FOREIGN KEY (`id_product`) REFERENCES `tb_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_cart_detail: ~21 rows (approximately)
INSERT INTO `tb_cart_detail` (`id`, `id_product`, `id_cart`, `jumlah`, `harga`, `waktu`, `company`, `cabang`) VALUES
	(34, 60, 9, 1, 48000.00, '2023-07-18 17:40:09', 'McDonald\'s', 'DMALL'),
	(35, 21, 9, 1, 17500.00, '2023-07-18 17:40:12', 'McDonald\'s', 'DMALL'),
	(36, 24, 9, 2, 29000.00, '2023-07-18 17:40:16', 'McDonald\'s', 'DMALL'),
	(37, 59, 10, 1, 46000.00, '2023-07-18 18:01:15', 'McDonald\'s', 'DMALL'),
	(38, 60, 10, 1, 48000.00, '2023-07-18 18:01:17', 'McDonald\'s', 'DMALL'),
	(39, 59, 11, 1, 46000.00, '2023-07-18 18:01:33', 'McDonald\'s', 'DMALL'),
	(40, 60, 11, 1, 48000.00, '2023-07-18 18:01:34', 'McDonald\'s', 'DMALL'),
	(41, 59, 12, 1, 46000.00, '2023-07-18 18:01:44', 'McDonald\'s', 'DMALL'),
	(42, 60, 12, 1, 48000.00, '2023-07-18 18:01:46', 'McDonald\'s', 'DMALL'),
	(43, 59, 13, 1, 46000.00, '2023-07-18 18:04:02', 'McDonald\'s', 'DMALL'),
	(44, 60, 13, 1, 48000.00, '2023-07-18 18:04:03', 'McDonald\'s', 'DMALL'),
	(45, 67, 14, 1, 44000.00, '2023-07-18 18:04:15', 'McDonald\'s', 'DMALL'),
	(46, 61, 14, 1, 38000.00, '2023-07-18 18:04:16', 'McDonald\'s', 'DMALL'),
	(47, 21, 15, 2, 35000.00, '2023-07-18 18:04:31', 'McDonald\'s', 'DMALL'),
	(48, 22, 15, 1, 23000.00, '2023-07-18 18:04:31', 'McDonald\'s', 'DMALL'),
	(49, 30, 15, 1, 17000.00, '2023-07-18 18:04:34', 'McDonald\'s', 'DMALL'),
	(50, 29, 15, 1, 17000.00, '2023-07-18 18:04:35', 'McDonald\'s', 'DMALL'),
	(51, 33, 15, 1, 9500.00, '2023-07-18 18:04:36', 'McDonald\'s', 'DMALL'),
	(52, 40, 15, 1, 9500.00, '2023-07-18 18:04:39', 'McDonald\'s', 'DMALL'),
	(54, 21, 16, 2, 35000.00, '2023-07-18 21:08:27', 'McDonald\'s', 'DMALL'),
	(55, 62, 16, 1, 50000.00, '2023-07-18 21:08:53', 'McDonald\'s', 'DMALL'),
	(56, 59, 17, 1, 46000.00, '2023-07-18 21:09:49', 'McDonald\'s', 'DMALL');

-- Dumping structure for table db_mocash.tb_product
CREATE TABLE IF NOT EXISTS `tb_product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Makanan',
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stok` int NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_product_created_by_fk` (`created_by`),
  KEY `tb_product_updated_by_fk` (`updated_by`),
  CONSTRAINT `tb_product_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `tb_user` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `tb_product_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `tb_user` (`email`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_product: ~74 rows (approximately)
INSERT INTO `tb_product` (`id`, `kategori`, `nama`, `harga`, `stok`, `image`, `company`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'Makanan', 'Fish Fillet Yakiniku Burger', 39500.00, 10, 'FishFilletYakinikuBurger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(3, 'Makanan', 'McSpicy Yakiniku Burger', 48000.00, 10, 'McSpicyYakinikuBurger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(4, 'Makanan', 'Big Mac', 41000.00, 10, 'BigMac.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(5, 'Makanan', 'Triple Cheeseburger', 60000.00, 10, 'TripleCheeseburger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(6, 'Makanan', 'Duoble Cheeseburger', 39500.00, 10, 'DuobleCheeseburger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(7, 'Makanan', 'Cheeseburger deluxe', 33000.00, 10, 'CheeseburgerDeluxe.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(8, 'Makanan', 'Cheeseburger', 32000.00, 10, '8_1073-350x350.jpg', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(9, 'Makanan', 'Beef Burger deluxe', 25000.00, 10, 'BeefBurgerDeluxe.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(10, 'Makanan', 'McSpicy', 39500.00, 10, 'McSpicy.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(11, 'Makanan', 'McChicken', 32000.00, 10, 'McChicken.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(12, 'Makanan', 'Chicken Burger deluxe', 25000.00, 10, 'ChickenBurgerDeluxe.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(13, 'Makanan', 'Fish Fillet Burger', 32000.00, 10, 'FishFilletBurger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(14, 'Makanan', 'Nasi Uduk McD', 21500.00, 10, 'NasiUduk.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(15, 'Makanan', 'Honey Garlic Chicken Rice', 22000.00, 10, 'HoneyGarlicChickenRice.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(16, 'Makanan', 'Honey Garlic Fish Rice', 22000.00, 10, 'HoneyGarlicFishRice.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(17, 'Makanan', 'Rica Rica Fish Rice', 22000.00, 10, 'RicaRicaFishRice.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(18, 'Makanan', 'Rica Rica Chicken Rice', 22000.00, 10, 'RicaRicaChickenRice.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(19, 'Makanan', 'Korean Soy Garlic Wings', 34500.00, 10, 'KoreanSoyGarlicWings.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(20, 'Cemilan', 'Fish Snack Wrap', 17500.00, 10, 'FishSoyWrap.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(21, 'Cemilan', 'Chicken Snack Wrap', 17500.00, 7, 'ChickenSnackWrap.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(22, 'Cemilan', 'Spicy Nori McShaker Fries', 23000.00, 10, 'SpicyNoriMcShakerFries.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(23, 'Cemilan', 'Spicy Chicken Bites', 13000.00, 10, 'SpicyChickenBites.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(24, 'Cemilan', 'Chicken Fingers 5pcs', 14500.00, 8, 'ChickenFingers.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(25, 'Cemilan', 'French Freis', 19000.00, 10, 'FrenchFries.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(26, 'Cemilan', 'Apple pie', 22500.00, 10, 'ApplePie.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(27, 'Cemilan', 'Spicy McNuggets 6pcs', 40500.00, 10, 'SpicyChickenNuggets6pcs.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(28, 'Minuman', 'Sakura Fizz', 14500.00, 10, 'SakuraFizz.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(29, 'Minuman', 'Sprite X Manggo McFloat', 17000.00, 10, 'SpriteXManggoMcFloat.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(30, 'Minuman', 'Coca Cola X Strawbeery McFloat', 17000.00, 10, 'CocaColaXStrawberryMcFloat.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(31, 'Minuman', 'Iced Lychee Tea', 20000.00, 10, 'tv_led_32.jpg', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(32, 'Minuman', 'Iced Coffee', 19000.00, 10, 'IcedLycheeTea.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(33, 'Minuman', 'Coca Cola', 9500.00, 10, 'CocaCola.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(34, 'Minuman', 'Coke McFloat', 14000.00, 10, 'CokeMcFloat.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(35, 'Minuman', 'Fanta', 9500.00, 10, 'Fanta.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(36, 'Minuman', 'Fanta McFloat', 14000.00, 10, 'FantaMcFloat.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(37, 'Minuman', 'Sprite', 9500.00, 10, 'Sprite.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(38, 'Minuman', 'Fruit Tea Lemon', 9500.00, 10, 'FruitTeaLomen.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(39, 'Minuman', 'Friut Tea Blackcurrant 200ml', 9500.00, 10, 'tv_led_32.jpg', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(40, 'Minuman', 'Tehbotol Sosro Kotak 250ml', 9500.00, 10, 'FriutTeaBlackcurrant.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(41, 'Minuman', 'Milo', 13000.00, 10, 'Milo.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(42, 'Minuman', 'Premium Roast Coffe', 12000.00, 10, 'PremiumRoastCoffe.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(43, 'Minuman', 'Teh Panas', 12000.00, 10, 'HotTea.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(44, 'Minuman', 'Air Mineral 600ml', 12500.00, 10, 'AirMineral.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(45, 'Minuman', 'Hot Cappucino', 23500.00, 10, 'HotCappucino.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(46, 'Minuman', 'Iced Cappucino', 28500.00, 10, 'IcedCappucino.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(47, 'Minuman', 'Hot Cafe Latte', 23500.00, 10, 'HotCafeLatte.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(48, 'Minuman', 'Iced Cafe Latte', 28500.00, 10, 'IcedCafeLatte.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(49, 'Minuman', 'Hot Long Black', 23500.00, 10, 'HotLongBlack.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(50, 'Minuman', 'Hot Flat White', 23500.00, 10, 'HotFlatWhite.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(51, 'Dessert', 'Duoble Choco Pie', 17000.00, 10, 'DuobleChocoPie.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(52, 'Dessert', 'Matcha McFlurry With Matcha Cookies', 18000.00, 10, 'MatchaMcFlurryWithMatchaCookies.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(53, 'Dessert', 'Matcha McFlurry With Oreo', 18000.00, 10, 'tv_led_32.jpg', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(54, 'Dessert', 'McFlurry Featuring Oreo', 13500.00, 10, 'MatchaMcFlurryWithOreo.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(55, 'Dessert', 'McFlurry Oreo', 13500.00, 10, 'McFlurryOreo', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(56, 'Dessert', 'McFlurry', 13500.00, 10, 'McFlurryOreo', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(57, 'Dessert', 'Sundae Chocolate', 12000.00, 10, 'SundaeChocolate.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(58, 'Dessert', 'Sundae Strawberry', 12000.00, 10, 'SundaeStrawberry.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(59, 'Paket', 'PaNas Spesial', 46000.00, 6, 'PaNasSpesial.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(60, 'Paket', 'PaNas Wings Large', 48000.00, 6, 'PaNasWingsLarg.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(61, 'Paket', 'PaNas 1', 38000.00, 9, 'PaNas1.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(62, 'Paket', 'PaNas 2 With Rice', 50000.00, 9, 'PaNas2WithRice.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(63, 'Paket', 'PaNas 2 With Fries', 52000.00, 10, 'PaNas2WithFries.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(64, 'Paket', 'PaMer 5', 125000.00, 10, 'PaMer5.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(65, 'Paket', 'PaNas 7', 180000.00, 10, 'PaNas7.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(66, 'Paket', 'PaNas Wings Koran Soy Garlic', 180000.00, 10, 'PaNasWingsKoranSoyGarlic.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(67, 'Paket', 'Happy Meal Chicken Burger', 44000.00, 9, 'HappyMealChickenBurger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(68, 'Paket', 'Happy Meal McNuggets 4pcs', 44000.00, 10, 'HappyMealMcNuggets4pcs.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(69, 'Paket', 'Happy Meal Beef Burger', 44000.00, 10, 'HappyMealBeefBurger.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(70, 'Paket', 'Happy Meal Ayam', 44000.00, 10, 'HappyMealAyam.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(71, 'Paket', 'Paket Keluarga Seru Tanpa Mainan', 84000.00, 10, 'PaketKeluargaSeruTanpaMainan.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(72, 'Paket', 'Paket Keluarga Seru Happy Meal Beef dan Mainan', 110000.00, 10, 'PaketKeluargaSeruHappyMealBeefdanMainan.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(73, 'Paket', 'Paket Keluarga Seru Happy Meal Ayam McD dan Mainan', 110000.00, 10, 'PaketKeluargaSeruHappyMealAyamMcDdanMainan.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL),
	(74, 'Makanan', 'Happy Meal Ayam', 44000.00, 10, 'HappyMealAyam.png', 'McDonald\'s', '2023-07-19 10:58:31', NULL, '2023-07-19 10:59:29', NULL);

-- Dumping structure for table db_mocash.tb_user
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `masa_berlangganan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cabang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `foto` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `tb_user_created_by_fk` (`created_by`),
  KEY `tb_user_updated_by_fk` (`updated_by`),
  CONSTRAINT `tb_user_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `tb_user` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `tb_user_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `tb_user` (`email`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_user: ~6 rows (approximately)
INSERT INTO `tb_user` (`id`, `fullname`, `email`, `password`, `role`, `masa_berlangganan`, `cabang`, `company`, `alamat`, `foto`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'Sectio Fatkhul Amrulloh Haq', 'sectiofatkhul51@gmail.com', 'Fatkhul02', 'Owner', '12 Bulan', 'Pusat', 'Burger King', 'Indonesia', NULL, '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(2, 'Salsabila', 'chacasbl01@gmail.com', 'Cacasuga06', 'Owner', '12 Bulan', 'Pusat', 'McDonald\'s', 'Indonesia', 'MCD.jpg', '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(3, 'Nurjanah Dewi Sinta', 'nurjanahdewi51@gmail.com', 'Nurdesin76', 'User', '', 'DMALL', 'Burger King', 'Depok Mall, Jl. Margonda No.Kav 88, Kemiri Muka, Kecamatan Beji, Kota Depok, Jawa Barat 16423', '', '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(5, 'Super Admin', 'sadmin@gmail.com', 'admin123', 'Super Admin', NULL, 'Pusat', 'McDonald\'s', NULL, NULL, '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(7, 'Admin', 'admin@mail.com', '1234', 'Admin', NULL, 'DMALL', 'McDonald\'s', '-', NULL, '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(8, 'kasir1', 'kasir1@mail.com', '1234', 'User', NULL, 'DMALL', 'McDonald\'s', 'Depok', NULL, '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(11, 'Boss', 'boss@mail.com', '1234', 'Owner', NULL, '', NULL, NULL, NULL, '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL),
	(12, 'kasir3', 'kasir3@mail.com', '1234', 'User', NULL, 'DETOS', 'McDonald\'s', 'Depok', NULL, '2023-07-19 10:57:44', NULL, '2023-07-19 10:57:44', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
