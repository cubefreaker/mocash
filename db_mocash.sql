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
  `waktu_buat` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `waktu_selesai` datetime DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `company` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cabang` varchar(191) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_cart_user_id_fk` (`user_id`),
  KEY `tb_cart_user_email_fk` (`user_email`),
  CONSTRAINT `tb_cart_user_email_fk` FOREIGN KEY (`user_email`) REFERENCES `tb_user` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `tb_cart_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_cart: ~1 rows (approximately)
INSERT INTO `tb_cart` (`id`, `user_id`, `user_email`, `total_produk`, `total_harga`, `waktu_buat`, `waktu_selesai`, `status`, `company`, `cabang`) VALUES
	(2, 8, 'kasir1@mail.com', 18, 295500.00, '2023-07-18 09:52:12', NULL, 'Pending', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_cart_detail: ~3 rows (approximately)
INSERT INTO `tb_cart_detail` (`id`, `id_product`, `id_cart`, `jumlah`, `harga`, `waktu`, `company`, `cabang`) VALUES
	(1, 59, 2, 1, 46000.00, '2023-07-18 07:53:50', 'McDonald\'s', 'DMALL'),
	(2, 28, 2, 16, 232000.00, '2023-07-18 09:52:12', 'McDonald\'s', 'DMALL'),
	(3, 21, 2, 1, 17500.00, '2023-07-18 07:56:39', 'McDonald\'s', 'DMALL');

-- Dumping structure for table db_mocash.tb_product
CREATE TABLE IF NOT EXISTS `tb_product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Makanan',
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stok` int NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_product: ~73 rows (approximately)
INSERT INTO `tb_product` (`id`, `kategori`, `nama`, `harga`, `stok`, `image`, `company`) VALUES
	(1, 'Makanan', 'Fish Fillet Yakiniku Burger', 39500.00, 10, 'FishFilletYakinikuBurger.png', 'McDonald\'s'),
	(3, 'Makanan', 'McSpicy Yakiniku Burger', 48000.00, 10, 'McSpicyYakinikuBurger.png', 'McDonald\'s'),
	(4, 'Makanan', 'Big Mac', 41000.00, 10, 'BigMac.png', 'McDonald\'s'),
	(5, 'Makanan', 'Triple Cheeseburger', 60000.00, 10, 'TripleCheeseburger.png', 'McDonald\'s'),
	(6, 'Makanan', 'Duoble Cheeseburger', 39500.00, 10, 'DuobleCheeseburger.png', 'McDonald\'s'),
	(7, 'Makanan', 'Cheeseburger deluxe', 33000.00, 10, 'CheeseburgerDeluxe.png', 'McDonald\'s'),
	(8, 'Makanan', 'Cheeseburger', 32000.00, 10, 'Cheeseburger.png', 'McDonald\'s'),
	(9, 'Makanan', 'Beef Burger deluxe', 25000.00, 10, 'BeefBurgerDeluxe.png', 'McDonald\'s'),
	(10, 'Makanan', 'McSpicy', 39500.00, 10, 'McSpicy.png', 'McDonald\'s'),
	(11, 'Makanan', 'McChicken', 32000.00, 10, 'McChicken.png', 'McDonald\'s'),
	(12, 'Makanan', 'Chicken Burger deluxe', 25000.00, 10, 'ChickenBurgerDeluxe.png', 'McDonald\'s'),
	(13, 'Makanan', 'Fish Fillet Burger', 32000.00, 10, 'FishFilletBurger.png', 'McDonald\'s'),
	(14, 'Makanan', 'Nasi Uduk McD', 21500.00, 10, 'NasiUduk.png', 'McDonald\'s'),
	(15, 'Makanan', 'Honey Garlic Chicken Rice', 22000.00, 10, 'HoneyGarlicChickenRice.png', 'McDonald\'s'),
	(16, 'Makanan', 'Honey Garlic Fish Rice', 22000.00, 10, 'HoneyGarlicFishRice.png', 'McDonald\'s'),
	(17, 'Makanan', 'Rica Rica Fish Rice', 22000.00, 10, 'RicaRicaFishRice.png', 'McDonald\'s'),
	(18, 'Makanan', 'Rica Rica Chicken Rice', 22000.00, 10, 'RicaRicaChickenRice.png', 'McDonald\'s'),
	(19, 'Makanan', 'Korean Soy Garlic Wings', 34500.00, 10, 'KoreanSoyGarlicWings.png', 'McDonald\'s'),
	(20, 'Cemilan', 'Fish Snack Wrap', 17500.00, 10, 'FishSoyWrap.png', 'McDonald\'s'),
	(21, 'Cemilan', 'Chicken Snack Wrap', 17500.00, 10, 'ChickenSnackWrap.png', 'McDonald\'s'),
	(22, 'Cemilan', 'Spicy Nori McShaker Fries', 23000.00, 10, 'SpicyNoriMcShakerFries.png', 'McDonald\'s'),
	(23, 'Cemilan', 'Spicy Chicken Bites', 13000.00, 10, 'SpicyChickenBites.png', 'McDonald\'s'),
	(24, 'Cemilan', 'Chicken Fingers 5pcs', 14500.00, 10, 'ChickenFingers.png', 'McDonald\'s'),
	(25, 'Cemilan', 'French Freis', 19000.00, 10, 'FrenchFries.png', 'McDonald\'s'),
	(26, 'Cemilan', 'Apple pie', 22500.00, 10, 'ApplePie.png', 'McDonald\'s'),
	(27, 'Cemilan', 'Spicy McNuggets 6pcs', 40500.00, 10, 'SpicyChickenNuggets6pcs.png', 'McDonald\'s'),
	(28, 'Minuman', 'Sakura Fizz', 14500.00, 6, 'SakuraFizz.png', 'McDonald\'s'),
	(29, 'Minuman', 'Sprite X Manggo McFloat', 17000.00, 10, 'SpriteXManggoMcFloat.png', 'McDonald\'s'),
	(30, 'Minuman', 'Coca Cola X Strawbeery McFloat', 17000.00, 10, 'CocaColaXStrawberryMcFloat.png', 'McDonald\'s'),
	(31, 'Minuman', 'Iced Lychee Tea', 20000.00, 10, 'tv_led_32.jpg', 'McDonald\'s'),
	(32, 'Minuman', 'Iced Coffee', 19000.00, 10, 'IcedLycheeTea.png', 'McDonald\'s'),
	(33, 'Minuman', 'Coca Cola', 9500.00, 10, 'CocaCola.png', 'McDonald\'s'),
	(34, 'Minuman', 'Coke McFloat', 14000.00, 10, 'CokeMcFloat.png', 'McDonald\'s'),
	(35, 'Minuman', 'Fanta', 9500.00, 10, 'Fanta.png', 'McDonald\'s'),
	(36, 'Minuman', 'Fanta McFloat', 14000.00, 10, 'FantaMcFloat.png', 'McDonald\'s'),
	(37, 'Minuman', 'Sprite', 9500.00, 10, 'Sprite.png', 'McDonald\'s'),
	(38, 'Minuman', 'Fruit Tea Lemon', 9500.00, 10, 'FruitTeaLomen.png', 'McDonald\'s'),
	(39, 'Minuman', 'Friut Tea Blackcurrant 200ml', 9500.00, 10, 'tv_led_32.jpg', 'McDonald\'s'),
	(40, 'Minuman', 'Tehbotol Sosro Kotak 250ml', 9500.00, 10, 'FriutTeaBlackcurrant.png', 'McDonald\'s'),
	(41, 'Minuman', 'Milo', 13000.00, 10, 'Milo.png', 'McDonald\'s'),
	(42, 'Minuman', 'Premium Roast Coffe', 12000.00, 10, 'PremiumRoastCoffe.png', 'McDonald\'s'),
	(43, 'Minuman', 'Teh Panas', 12000.00, 10, 'HotTea.png', 'McDonald\'s'),
	(44, 'Minuman', 'Air Mineral 600ml', 12500.00, 10, 'AirMineral.png', 'McDonald\'s'),
	(45, 'Minuman', 'Hot Cappucino', 23500.00, 10, 'HotCappucino.png', 'McDonald\'s'),
	(46, 'Minuman', 'Iced Cappucino', 28500.00, 10, 'IcedCappucino.png', 'McDonald\'s'),
	(47, 'Minuman', 'Hot Cafe Latte', 23500.00, 10, 'HotCafeLatte.png', 'McDonald\'s'),
	(48, 'Minuman', 'Iced Cafe Latte', 28500.00, 10, 'IcedCafeLatte.png', 'McDonald\'s'),
	(49, 'Minuman', 'Hot Long Black', 23500.00, 10, 'HotLongBlack.png', 'McDonald\'s'),
	(50, 'Minuman', 'Hot Flat White', 23500.00, 10, 'HotFlatWhite.png', 'McDonald\'s'),
	(51, 'Dessert', 'Duoble Choco Pie', 17000.00, 10, 'DuobleChocoPie.png', 'McDonald\'s'),
	(52, 'Dessert', 'Matcha McFlurry With Matcha Cookies', 18000.00, 10, 'MatchaMcFlurryWithMatchaCookies.png', 'McDonald\'s'),
	(53, 'Dessert', 'Matcha McFlurry With Oreo', 18000.00, 10, 'tv_led_32.jpg', 'McDonald\'s'),
	(54, 'Dessert', 'McFlurry Featuring Oreo', 13500.00, 10, 'MatchaMcFlurryWithOreo.png', 'McDonald\'s'),
	(55, 'Dessert', 'McFlurry Oreo', 13500.00, 10, 'McFlurryOreo', 'McDonald\'s'),
	(56, 'Dessert', 'McFlurry', 13500.00, 10, 'McFlurryOreo', 'McDonald\'s'),
	(57, 'Dessert', 'Sundae Chocolate', 12000.00, 10, 'SundaeChocolate.png', 'McDonald\'s'),
	(58, 'Dessert', 'Sundae Strawberry', 12000.00, 10, 'SundaeStrawberry.png', 'McDonald\'s'),
	(59, 'Paket', 'PaNas Spesial', 46000.00, 10, 'PaNasSpesial.png', 'McDonald\'s'),
	(60, 'Paket', 'PaNas Wings Large', 48000.00, 10, 'PaNasWingsLarg.png', 'McDonald\'s'),
	(61, 'Paket', 'PaNas 1', 38000.00, 10, 'PaNas1.png', 'McDonald\'s'),
	(62, 'Paket', 'PaNas 2 With Rice', 50000.00, 10, 'PaNas2WithRice.png', 'McDonald\'s'),
	(63, 'Paket', 'PaNas 2 With Fries', 52000.00, 10, 'PaNas2WithFries.png', 'McDonald\'s'),
	(64, 'Paket', 'PaMer 5', 125000.00, 10, 'PaMer5.png', 'McDonald\'s'),
	(65, 'Paket', 'PaNas 7', 180000.00, 10, 'PaNas7.png', 'McDonald\'s'),
	(66, 'Paket', 'PaNas Wings Koran Soy Garlic', 180000.00, 10, 'PaNasWingsKoranSoyGarlic.png', 'McDonald\'s'),
	(67, 'Paket', 'Happy Meal Chicken Burger', 44000.00, 10, 'HappyMealChickenBurger.png', 'McDonald\'s'),
	(68, 'Paket', 'Happy Meal McNuggets 4pcs', 44000.00, 10, 'HappyMealMcNuggets4pcs.png', 'McDonald\'s'),
	(69, 'Paket', 'Happy Meal Beef Burger', 44000.00, 10, 'HappyMealBeefBurger.png', 'McDonald\'s'),
	(70, 'Paket', 'Happy Meal Ayam', 44000.00, 10, 'HappyMealAyam.png', 'McDonald\'s'),
	(71, 'Paket', 'Paket Keluarga Seru Tanpa Mainan', 84000.00, 10, 'PaketKeluargaSeruTanpaMainan.png', 'McDonald\'s'),
	(72, 'Paket', 'Paket Keluarga Seru Happy Meal Beef dan Mainan', 110000.00, 10, 'PaketKeluargaSeruHappyMealBeefdanMainan.png', 'McDonald\'s'),
	(73, 'Paket', 'Paket Keluarga Seru Happy Meal Ayam McD dan Mainan', 110000.00, 10, 'PaketKeluargaSeruHappyMealAyamMcDdanMainan.png', 'McDonald\'s'),
	(74, 'Makanan', 'Happy Meal Ayam', 44000.00, 10, 'HappyMealAyam.png', 'McDonald\'s');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_mocash.tb_user: ~7 rows (approximately)
INSERT INTO `tb_user` (`id`, `fullname`, `email`, `password`, `role`, `masa_berlangganan`, `cabang`, `company`, `alamat`, `foto`) VALUES
	(1, 'Sectio Fatkhul Amrulloh Haq', 'sectiofatkhul51@gmail.com', 'Fatkhul02', 'Owner', '12 Bulan', 'Pusat', 'Burger King', 'Indonesia', NULL),
	(2, 'Salsabila', 'chacasbl01@gmail.com', 'Cacasuga06', 'Owner', '12 Bulan', 'Pusat', 'McDonald\'s', 'Indonesia', 'MCD.jpg'),
	(3, 'Nurjanah Dewi Sinta', 'nurjanahdewi51@gmail.com', 'Nurdesin76', 'User', '', 'DMALL', 'Burger King', 'Depok Mall, Jl. Margonda No.Kav 88, Kemiri Muka, Kecamatan Beji, Kota Depok, Jawa Barat 16423', ''),
	(5, 'Super Admin', 'sadmin@gmail.com', 'admin123', 'Super Admin', NULL, 'Pusat', 'McDonald\'s', NULL, NULL),
	(7, 'Admin', 'admin@mail.com', '1234', 'Admin', NULL, 'DMALL', 'McDonald\'s', NULL, NULL),
	(8, 'kasir1', 'kasir1@mail.com', '1234', 'User', NULL, 'DMALL', 'McDonald\'s', 'Depok', NULL),
	(11, 'Boss', 'boss@mail.com', '1234', 'Owner', NULL, '', NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
