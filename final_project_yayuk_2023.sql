-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2024 at 01:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_project_yayuk_2023`
--

-- --------------------------------------------------------

--
-- Table structure for table `Ingredients`
--

CREATE TABLE `Ingredients` (
  `IngredientID` int(11) NOT NULL,
  `IngredientName` varchar(255) NOT NULL,
  `PurchasePrice` decimal(10,2) NOT NULL,
  `QuantityPerPurchase` decimal(10,2) NOT NULL,
  `ServingsPerIngredient` int(11) NOT NULL,
  `HoldingCost` tinyint(1) NOT NULL,
  `HoldingCostPrice` decimal(10,2) DEFAULT NULL,
  `ShelfLife` int(11) DEFAULT NULL,
  `SupplierName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `MinimumStock` int(11) DEFAULT NULL,
  `StorageLocation` varchar(50) DEFAULT NULL,
  `PurchaseUnit` varchar(50) NOT NULL,
  `UsagePerDay` decimal(10,2) DEFAULT NULL,
  `UsagePerMonth` decimal(10,2) DEFAULT NULL,
  `OrderCost` decimal(10,2) DEFAULT NULL,
  `HoldingCostPercentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Ingredients`
--

INSERT INTO `Ingredients` (`IngredientID`, `IngredientName`, `PurchasePrice`, `QuantityPerPurchase`, `ServingsPerIngredient`, `HoldingCost`, `HoldingCostPrice`, `ShelfLife`, `SupplierName`, `Description`, `MinimumStock`, `StorageLocation`, `PurchaseUnit`, `UsagePerDay`, `UsagePerMonth`, `OrderCost`, `HoldingCostPercentage`) VALUES
(1, 'Timun Segar', 7000.00, 5.00, 20, 1, 3500.00, 7, 'Supplier A', 'Timun segar berkualitas', 2, 'Cool Storage', 'kg', 0.50, 15.00, 500.00, 50.00),
(2, 'Tepung Ayam', 19000.00, 1.00, 30, 1, 380.00, 182, 'Supplier B', 'Tepung ayam khusus untuk pencelupan', 3, 'Dry Storage', 'kg', 3.00, 90.00, 1000.00, 2.00),
(3, 'Marinasi Spesial', 2000.00, 1.00, 30, 1, 80.00, 730, 'Supplier C', 'Bumbu ayam spesial', 3, 'Dry Storage', 'piece', 6.00, 180.00, 2000.00, 4.00),
(4, 'Sambal', 42000.00, 1.00, 300, 1, 4200.00, 90, 'Supplier D', 'Saus pedas spesial', 4, 'Cool Storage', 'kg', 0.33, 10.00, 4000.00, 10.00),
(5, 'Nasi Putih', 10000.00, 1.00, 25, 1, 1000.00, 1, 'Supplier E', 'Nasi putih matang', 13, 'Warm Storage', 'kg', 3.00, 90.00, 1000.00, 10.00),
(6, 'Kantong Plastik Kecil', 10000.00, 1.00, 100, 1, 200.00, 0, 'Supplier F', 'Kantong plastik kecil berkualitas', 9, 'Dry Storage', 'pack', 0.50, 15.00, 500.00, 2.00),
(7, 'Kresek Plastik Kecil', 7500.00, 1.00, 100, 1, 150.00, 365, 'Supplier G', 'Kresek plastik kecil berkualitas', 10, 'Dry Storage', 'pack', 0.50, 15.00, 500.00, 2.00),
(8, 'Foam Kecil (Wadah)', 23000.00, 1.00, 100, 1, 460.00, 365, 'Supplier H', 'Wadah foam kecil berkualitas', 11, 'Dry Storage', 'pack', 1.00, 30.00, 1000.00, 2.00),
(9, 'Foam Besar (Wadah)', 25000.00, 1.00, 100, 1, 500.00, 365, 'Supplier I', 'Wadah foam besar berkualitas', 11, 'Dry Storage', 'pack', 1.00, 30.00, 1000.00, 2.00),
(10, 'Cup Minuman Kecil', 12000.00, 1.00, 100, 1, 240.00, 365, 'Supplier J', 'Cup minuman kecil berkualitas', 22, 'Dry Storage', 'pack', 2.00, 60.00, 1000.00, 2.00),
(11, 'Cup Minuman Besar', 13000.00, 1.00, 100, 1, 260.00, 365, 'Supplier K', 'Cup minuman besar berkualitas', 21, 'Dry Storage', 'piece', 2.00, 60.00, 1000.00, 2.00),
(12, 'Ayam', 53000.00, 1.00, 30, 1, 5300.00, 365, 'Supplier A', 'Ayam Potong', 13, 'Cool Storage', 'kg', 3.00, 90.00, 5000.00, 10.00),
(13, 'Kresek Plastik Besar', 25000.00, 1.00, 50, 1, 500.00, 365, 'Suplier X', 'Kresek Plastik Besar Yahud', 5, 'Dry Storage', 'pack', 0.20, 6.00, 1000.00, 2.00),
(14, 'Kresek Plastik Sedang', 8000.00, 1.00, 100, 1, 160.00, 365, 'Suplier X', 'Kresek Plastik Sedang dang dang dang', 11, 'Dry Storage', 'pack', 0.33, 10.00, 1000.00, 2.00),
(15, 'Minyak Goreng', 75000.00, 1.00, 210, 1, 1500.00, 730, 'Suplier M', 'Minyak Kelapa Sawit Murni', 5, 'Dry Storage', 'kg', 0.33, 10.00, 2000.00, 2.00),
(16, 'Gas Elpigi 15Kg', 275000.00, 1.00, 2700, 1, 5500.00, 750, 'Suplier G', 'Gas Elpigi 15Kg Gas Negoro', 1, 'Dry Storage', 'kg', 0.03, 1.00, 3000.00, 2.00),
(17, 'Teh Minang', 5000.00, 1.00, 30, 1, 5000.00, 365, 'Supplier T', 'Teh Minang Kabau Asli', 60, 'Dry Storage', 'piece', 3.00, 90.00, 2000.00, 100.00),
(18, 'Gula Pasir', 16500.00, 1.00, 80, 1, 660.00, 365, 'Suplier G', 'Gula Pasir Pabrik Gula Mrican', 12, 'Dry Storage', 'kg', 1.50, 45.00, 1000.00, 4.00),
(19, 'Air Galon ', 5000.00, 1.00, 54, 1, 2500.00, 7, 'Suplier G', 'Banyu Sri Sejahtera Sedudo', 2, 'Dry Storage', 'liter', 2.00, 60.00, 100.00, 50.00),
(20, 'Es Batu', 10000.00, 1.00, 50, 1, NULL, 2, '0', 'Pemasok K Es batu', 2, '0', 'pack', 1.00, 30.00, 200.00, 50.00),
(21, 'Saos Sachet', 10000.00, 2.00, 100, 1, NULL, 365, '0', 'Pemasok S', 24, '0', 'pack', 2.00, 60.00, 1000.00, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `IngredientStocks`
--

CREATE TABLE `IngredientStocks` (
  `StockID` int(11) NOT NULL,
  `IngredientID` int(11) NOT NULL,
  `Quantity` decimal(10,2) NOT NULL,
  `QuantityPerServings` decimal(10,2) NOT NULL,
  `LastUpdateStock` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `IngredientStocks`
--

INSERT INTO `IngredientStocks` (`StockID`, `IngredientID`, `Quantity`, `QuantityPerServings`, `LastUpdateStock`) VALUES
(1, 1, 1.00, 100.00, '2023-12-30 17:00:00'),
(2, 2, 20.00, 600.00, '2023-12-30 17:00:00'),
(3, 3, 96.00, 2880.00, '2023-12-30 17:00:00'),
(4, 4, 3.00, 900.00, '2023-12-30 17:00:00'),
(5, 5, 16.00, 400.00, '2023-12-30 17:00:00'),
(6, 6, 10.00, 1000.00, '2023-12-30 17:00:00'),
(7, 7, 9.00, 900.00, '2023-12-30 17:00:00'),
(8, 8, 12.00, 1200.00, '2023-12-30 17:00:00'),
(9, 9, 12.00, 1200.00, '2023-12-30 17:00:00'),
(10, 12, 12.00, 360.00, '2023-12-30 17:00:00'),
(11, 13, 4.00, 200.00, '2023-12-30 17:00:00'),
(12, 14, 10.00, 1000.00, '2023-12-30 17:00:00'),
(13, 15, 4.00, 840.00, '2023-12-30 17:00:00'),
(14, 16, 0.00, 0.00, '2023-12-30 17:00:00'),
(15, 17, 4.00, 120.00, '2023-12-30 17:00:00'),
(16, 18, 12.00, 960.00, '2023-12-30 17:00:00'),
(17, 19, 3.00, 162.00, '2023-12-30 17:00:00'),
(18, 20, 2.00, 100.00, '2023-12-30 17:00:00'),
(19, 21, 15.00, 3000.00, '2023-12-30 17:00:00'),
(20, 10, 28.00, 2800.00, '2023-12-30 17:00:00'),
(21, 11, 20.00, 2000.00, '2023-12-30 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `IngredientTransactions`
--

CREATE TABLE `IngredientTransactions` (
  `TransactionID` int(11) NOT NULL,
  `IngredientID` int(11) NOT NULL,
  `TransactionType` enum('In','Out') NOT NULL,
  `Quantity` decimal(10,2) NOT NULL,
  `QuantityPerServings` decimal(10,2) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `IngredientTransactions`
--

INSERT INTO `IngredientTransactions` (`TransactionID`, `IngredientID`, `TransactionType`, `Quantity`, `QuantityPerServings`, `Timestamp`) VALUES
(1, 1, 'In', 3.00, 300.00, '2023-12-18 01:42:01'),
(2, 1, 'In', 17.00, 1700.00, '2023-12-17 17:00:00'),
(3, 2, 'In', 95.00, 2850.00, '2023-12-18 01:43:56'),
(4, 3, 'In', 200.00, 6000.00, '2023-12-18 01:44:23'),
(5, 4, 'In', 12.00, 3600.00, '2023-12-18 01:44:34'),
(6, 5, 'In', 93.00, 2325.00, '2023-12-18 01:44:49'),
(7, 6, 'In', 15.00, 1500.00, '2023-12-18 01:45:01'),
(8, 7, 'In', 16.00, 1600.00, '2023-12-18 01:45:08'),
(9, 8, 'In', 33.00, 3300.00, '2023-12-18 01:45:17'),
(10, 1, 'In', 52.00, 5200.00, '2023-12-18 01:45:24'),
(12, 9, 'In', 32.00, 3200.00, '2023-12-18 01:47:07'),
(13, 12, 'In', 95.00, 2850.00, '2023-12-18 01:47:20'),
(14, 13, 'In', 7.00, 350.00, '2023-12-18 01:47:29'),
(15, 14, 'In', 12.00, 1200.00, '2023-12-18 01:47:43'),
(16, 15, 'In', 12.00, 2520.00, '2023-12-18 01:47:51'),
(17, 16, 'In', 1.00, 2700.00, '2023-12-18 01:48:02'),
(18, 17, 'In', 86.00, 2580.00, '2023-12-18 01:48:17'),
(19, 18, 'In', 40.00, 3200.00, '2023-12-18 01:48:36'),
(20, 19, 'In', 55.00, 2970.00, '2023-12-18 01:48:45'),
(21, 20, 'In', 55.00, 2750.00, '2023-12-18 02:52:41'),
(22, 21, 'In', 55.00, 11000.00, '2023-12-18 02:53:01'),
(23, 20, 'In', 5.00, 250.00, '2023-12-17 17:00:00'),
(24, 10, 'In', 75.00, 7500.00, '2023-12-18 02:55:02'),
(25, 11, 'In', 60.00, 6000.00, '2023-12-18 02:55:08'),
(26, 1, 'Out', 18.00, 1800.00, '2024-01-30 17:00:00'),
(27, 2, 'Out', 20.00, 600.00, '2023-12-30 17:00:00'),
(28, 2, 'Out', 55.00, 1650.00, '2023-12-30 17:00:00'),
(29, 3, 'Out', 104.00, 3120.00, '2023-12-30 17:00:00'),
(30, 6, 'Out', 5.00, 500.00, '2023-12-30 17:00:00'),
(31, 7, 'Out', 7.00, 700.00, '2023-12-30 17:00:00'),
(32, 8, 'Out', 21.00, 2100.00, '2023-12-30 17:00:00'),
(33, 9, 'Out', 22.00, 2200.00, '2023-12-30 17:00:00'),
(34, 12, 'Out', 83.00, 2490.00, '2023-12-30 17:00:00'),
(35, 13, 'Out', 3.00, 150.00, '2023-12-30 17:00:00'),
(36, 14, 'Out', 2.00, 200.00, '2023-12-30 17:00:00'),
(37, 15, 'Out', 8.00, 1680.00, '2023-12-30 17:00:00'),
(38, 16, 'Out', 1.00, 2700.00, '2023-12-30 17:00:00'),
(39, 17, 'Out', 82.00, 2460.00, '2023-12-30 17:00:00'),
(40, 18, 'Out', 28.00, 2240.00, '2023-12-30 17:00:00'),
(41, 19, 'Out', 52.00, 2808.00, '2023-12-30 17:00:00'),
(42, 20, 'Out', 58.00, 2900.00, '2023-12-30 17:00:00'),
(43, 21, 'Out', 40.00, 8000.00, '2023-12-30 17:00:00'),
(44, 10, 'Out', 47.00, 4700.00, '2023-12-30 17:00:00'),
(45, 11, 'Out', 40.00, 4000.00, '2023-12-30 17:00:00'),
(46, 4, 'Out', 9.00, 2700.00, '2023-12-30 17:00:00'),
(47, 5, 'Out', 77.00, 1925.00, '2023-12-30 17:00:00'),
(48, 1, 'Out', 1.00, 100.00, '2023-12-30 17:00:00'),
(49, 2, 'In', 95.00, 2850.00, '2023-05-31 17:00:00'),
(50, 2, 'In', 95.00, 2850.00, '2023-06-30 17:00:00'),
(51, 2, 'In', 95.00, 2850.00, '2023-07-31 17:00:00'),
(52, 2, 'In', 95.00, 2850.00, '2023-08-31 17:00:00'),
(53, 2, 'In', 95.00, 2850.00, '2023-09-30 17:00:00'),
(54, 2, 'In', 95.00, 2850.00, '2023-10-31 17:00:00'),
(55, 2, 'Out', 95.00, 2850.00, '2023-05-31 17:00:00'),
(56, 2, 'Out', 95.00, 2850.00, '2023-06-30 17:00:00'),
(57, 2, 'Out', 95.00, 2850.00, '2023-07-31 17:00:00'),
(58, 2, 'Out', 95.00, 2850.00, '2023-08-31 17:00:00'),
(59, 2, 'Out', 95.00, 2850.00, '2023-09-30 17:00:00'),
(60, 2, 'Out', 95.00, 2850.00, '2023-10-31 17:00:00'),
(61, 1, 'In', 20.00, 2000.00, '2023-05-31 17:00:00'),
(62, 1, 'In', 20.00, 2000.00, '2023-06-30 17:00:00'),
(63, 1, 'In', 20.00, 2000.00, '2023-07-31 17:00:00'),
(64, 1, 'In', 20.00, 2000.00, '2023-08-31 17:00:00'),
(65, 1, 'In', 20.00, 2000.00, '2023-09-30 17:00:00'),
(66, 1, 'In', 20.00, 2000.00, '2023-10-31 17:00:00'),
(67, 1, 'Out', 20.00, 2000.00, '2023-05-31 17:00:00'),
(68, 1, 'Out', 20.00, 2000.00, '2023-06-30 17:00:00'),
(69, 1, 'Out', 20.00, 2000.00, '2023-07-31 17:00:00'),
(70, 1, 'Out', 20.00, 2000.00, '2023-08-31 17:00:00'),
(71, 1, 'Out', 20.00, 2000.00, '2023-09-30 17:00:00'),
(72, 1, 'Out', 20.00, 2000.00, '2023-10-31 17:00:00'),
(73, 3, 'In', 200.00, 6000.00, '2023-05-31 17:00:00'),
(74, 3, 'In', 200.00, 6000.00, '2023-06-30 17:00:00'),
(75, 3, 'In', 200.00, 6000.00, '2023-07-31 17:00:00'),
(76, 3, 'In', 200.00, 6000.00, '2023-08-31 17:00:00'),
(77, 3, 'In', 200.00, 6000.00, '2023-09-30 17:00:00'),
(78, 3, 'In', 200.00, 6000.00, '2023-10-31 17:00:00'),
(79, 3, 'Out', 200.00, 6000.00, '2023-05-31 17:00:00'),
(80, 3, 'Out', 200.00, 6000.00, '2023-06-30 17:00:00'),
(81, 3, 'Out', 200.00, 6000.00, '2023-07-31 17:00:00'),
(82, 3, 'Out', 200.00, 6000.00, '2023-08-31 17:00:00'),
(83, 3, 'Out', 200.00, 6000.00, '2023-09-30 17:00:00'),
(84, 3, 'Out', 200.00, 6000.00, '2023-10-31 17:00:00'),
(85, 4, 'In', 12.00, 3600.00, '2023-05-31 17:00:00'),
(86, 4, 'In', 12.00, 3600.00, '2023-06-30 17:00:00'),
(87, 4, 'In', 12.00, 3600.00, '2023-07-31 17:00:00'),
(88, 4, 'In', 12.00, 3600.00, '2023-08-31 17:00:00'),
(89, 4, 'In', 12.00, 3600.00, '2023-09-30 17:00:00'),
(90, 4, 'In', 12.00, 3600.00, '2023-10-31 17:00:00'),
(91, 4, 'Out', 12.00, 3600.00, '2023-05-31 17:00:00'),
(92, 4, 'Out', 12.00, 3600.00, '2023-06-30 17:00:00'),
(93, 4, 'Out', 12.00, 3600.00, '2023-07-31 17:00:00'),
(94, 4, 'Out', 12.00, 3600.00, '2023-08-31 17:00:00'),
(95, 4, 'Out', 12.00, 3600.00, '2023-09-30 17:00:00'),
(96, 4, 'Out', 12.00, 3600.00, '2023-10-31 17:00:00'),
(97, 5, 'In', 93.00, 2325.00, '2023-05-31 17:00:00'),
(98, 5, 'In', 93.00, 2325.00, '2023-06-30 17:00:00'),
(99, 5, 'In', 93.00, 2325.00, '2023-07-31 17:00:00'),
(100, 5, 'In', 93.00, 2325.00, '2023-08-31 17:00:00'),
(101, 5, 'In', 93.00, 2325.00, '2023-09-30 17:00:00'),
(102, 5, 'In', 93.00, 2325.00, '2023-10-31 17:00:00'),
(103, 5, 'Out', 93.00, 2325.00, '2023-05-31 17:00:00'),
(104, 5, 'Out', 93.00, 2325.00, '2023-06-30 17:00:00'),
(105, 5, 'Out', 93.00, 2325.00, '2023-07-31 17:00:00'),
(106, 5, 'Out', 93.00, 2325.00, '2023-08-31 17:00:00'),
(107, 5, 'Out', 93.00, 2325.00, '2023-09-30 17:00:00'),
(108, 5, 'Out', 93.00, 2325.00, '2023-10-31 17:00:00'),
(109, 6, 'In', 15.00, 1500.00, '2023-05-31 17:00:00'),
(110, 6, 'In', 15.00, 1500.00, '2023-06-30 17:00:00'),
(111, 6, 'In', 15.00, 1500.00, '2023-07-31 17:00:00'),
(112, 6, 'In', 15.00, 1500.00, '2023-08-31 17:00:00'),
(113, 6, 'In', 15.00, 1500.00, '2023-09-30 17:00:00'),
(114, 6, 'In', 15.00, 1500.00, '2023-10-31 17:00:00'),
(115, 6, 'Out', 15.00, 1500.00, '2023-05-31 17:00:00'),
(116, 6, 'Out', 15.00, 1500.00, '2023-06-30 17:00:00'),
(117, 6, 'Out', 15.00, 1500.00, '2023-07-31 17:00:00'),
(118, 6, 'Out', 15.00, 1500.00, '2023-08-31 17:00:00'),
(119, 6, 'Out', 15.00, 1500.00, '2023-09-30 17:00:00'),
(120, 6, 'Out', 15.00, 1500.00, '2023-10-31 17:00:00'),
(121, 7, 'In', 16.00, 1600.00, '2023-05-31 17:00:00'),
(122, 7, 'In', 16.00, 1600.00, '2023-06-30 17:00:00'),
(123, 7, 'In', 16.00, 1600.00, '2023-07-31 17:00:00'),
(124, 7, 'In', 16.00, 1600.00, '2023-08-31 17:00:00'),
(125, 7, 'In', 16.00, 1600.00, '2023-09-30 17:00:00'),
(126, 7, 'In', 16.00, 1600.00, '2023-10-31 17:00:00'),
(127, 7, 'Out', 16.00, 1600.00, '2023-05-31 17:00:00'),
(128, 7, 'Out', 16.00, 1600.00, '2023-06-30 17:00:00'),
(129, 7, 'Out', 16.00, 1600.00, '2023-07-31 17:00:00'),
(130, 7, 'Out', 16.00, 1600.00, '2023-08-31 17:00:00'),
(131, 7, 'Out', 16.00, 1600.00, '2023-09-30 17:00:00'),
(132, 7, 'Out', 16.00, 1600.00, '2023-10-31 17:00:00'),
(133, 8, 'In', 30.00, 3000.00, '2023-05-31 17:00:00'),
(134, 8, 'In', 30.00, 3000.00, '2023-06-30 17:00:00'),
(135, 8, 'In', 30.00, 3000.00, '2023-07-31 17:00:00'),
(136, 8, 'In', 30.00, 3000.00, '2023-08-31 17:00:00'),
(137, 8, 'In', 30.00, 3000.00, '2023-09-30 17:00:00'),
(138, 8, 'In', 30.00, 3000.00, '2023-10-31 17:00:00'),
(139, 8, 'Out', 30.00, 3000.00, '2023-05-31 17:00:00'),
(140, 8, 'Out', 30.00, 3000.00, '2023-06-30 17:00:00'),
(141, 8, 'Out', 30.00, 3000.00, '2023-07-31 17:00:00'),
(142, 8, 'Out', 30.00, 3000.00, '2023-08-31 17:00:00'),
(143, 8, 'Out', 30.00, 3000.00, '2023-09-30 17:00:00'),
(144, 8, 'Out', 30.00, 3000.00, '2023-10-31 17:00:00'),
(145, 9, 'In', 30.00, 3000.00, '2023-05-31 17:00:00'),
(146, 9, 'In', 30.00, 3000.00, '2023-06-30 17:00:00'),
(147, 9, 'In', 30.00, 3000.00, '2023-07-31 17:00:00'),
(148, 9, 'In', 30.00, 3000.00, '2023-08-31 17:00:00'),
(149, 9, 'In', 30.00, 3000.00, '2023-09-30 17:00:00'),
(150, 9, 'In', 30.00, 3000.00, '2023-10-31 17:00:00'),
(151, 9, 'Out', 30.00, 3000.00, '2023-05-31 17:00:00'),
(152, 9, 'Out', 30.00, 3000.00, '2023-06-30 17:00:00'),
(153, 9, 'Out', 30.00, 3000.00, '2023-07-31 17:00:00'),
(154, 9, 'Out', 30.00, 3000.00, '2023-08-31 17:00:00'),
(155, 9, 'Out', 30.00, 3000.00, '2023-09-30 17:00:00'),
(156, 9, 'Out', 30.00, 3000.00, '2023-10-31 17:00:00'),
(157, 10, 'In', 60.00, 6000.00, '2023-05-31 17:00:00'),
(158, 10, 'In', 60.00, 6000.00, '2023-06-30 17:00:00'),
(159, 10, 'In', 60.00, 6000.00, '2023-07-31 17:00:00'),
(160, 10, 'In', 60.00, 6000.00, '2023-08-31 17:00:00'),
(161, 10, 'In', 60.00, 6000.00, '2023-09-30 17:00:00'),
(162, 10, 'In', 60.00, 6000.00, '2023-10-31 17:00:00'),
(163, 10, 'Out', 60.00, 6000.00, '2023-05-31 17:00:00'),
(164, 10, 'Out', 60.00, 6000.00, '2023-06-30 17:00:00'),
(165, 10, 'Out', 60.00, 6000.00, '2023-07-31 17:00:00'),
(166, 10, 'Out', 60.00, 6000.00, '2023-08-31 17:00:00'),
(167, 10, 'Out', 60.00, 6000.00, '2023-09-30 17:00:00'),
(168, 10, 'Out', 60.00, 6000.00, '2023-10-31 17:00:00'),
(169, 11, 'In', 60.00, 6000.00, '2023-05-31 17:00:00'),
(170, 11, 'In', 60.00, 6000.00, '2023-06-30 17:00:00'),
(171, 11, 'In', 60.00, 6000.00, '2023-07-31 17:00:00'),
(172, 11, 'In', 60.00, 6000.00, '2023-08-31 17:00:00'),
(173, 11, 'In', 60.00, 6000.00, '2023-09-30 17:00:00'),
(174, 11, 'In', 60.00, 6000.00, '2023-10-31 17:00:00'),
(175, 11, 'Out', 60.00, 6000.00, '2023-05-31 17:00:00'),
(176, 11, 'Out', 60.00, 6000.00, '2023-06-30 17:00:00'),
(177, 11, 'Out', 60.00, 6000.00, '2023-07-31 17:00:00'),
(178, 11, 'Out', 60.00, 6000.00, '2023-08-31 17:00:00'),
(179, 11, 'Out', 60.00, 6000.00, '2023-09-30 17:00:00'),
(180, 11, 'Out', 60.00, 6000.00, '2023-10-31 17:00:00'),
(181, 12, 'In', 90.00, 2700.00, '2023-05-31 17:00:00'),
(182, 12, 'In', 90.00, 2700.00, '2023-06-30 17:00:00'),
(183, 12, 'In', 90.00, 2700.00, '2023-07-31 17:00:00'),
(184, 12, 'In', 90.00, 2700.00, '2023-08-31 17:00:00'),
(185, 12, 'In', 90.00, 2700.00, '2023-09-30 17:00:00'),
(186, 12, 'In', 90.00, 2700.00, '2023-10-31 17:00:00'),
(187, 12, 'Out', 90.00, 2700.00, '2023-05-31 17:00:00'),
(188, 12, 'Out', 90.00, 2700.00, '2023-06-30 17:00:00'),
(189, 12, 'Out', 90.00, 2700.00, '2023-07-31 17:00:00'),
(190, 12, 'Out', 90.00, 2700.00, '2023-08-31 17:00:00'),
(191, 12, 'Out', 90.00, 2700.00, '2023-09-30 17:00:00'),
(192, 12, 'Out', 90.00, 2700.00, '2023-10-31 17:00:00'),
(193, 13, 'In', 6.00, 300.00, '2023-05-31 17:00:00'),
(194, 13, 'In', 6.00, 300.00, '2023-06-30 17:00:00'),
(195, 13, 'In', 6.00, 300.00, '2023-07-31 17:00:00'),
(196, 13, 'In', 6.00, 300.00, '2023-08-31 17:00:00'),
(197, 13, 'In', 6.00, 300.00, '2023-09-30 17:00:00'),
(198, 13, 'In', 6.00, 300.00, '2023-10-31 17:00:00'),
(199, 13, 'Out', 6.00, 300.00, '2023-05-31 17:00:00'),
(200, 13, 'Out', 6.00, 300.00, '2023-06-30 17:00:00'),
(201, 13, 'Out', 6.00, 300.00, '2023-07-31 17:00:00'),
(202, 13, 'Out', 6.00, 300.00, '2023-08-31 17:00:00'),
(203, 13, 'Out', 6.00, 300.00, '2023-09-30 17:00:00'),
(204, 13, 'Out', 6.00, 300.00, '2023-10-31 17:00:00'),
(205, 14, 'In', 10.00, 1000.00, '2023-05-31 17:00:00'),
(206, 14, 'In', 10.00, 1000.00, '2023-06-30 17:00:00'),
(207, 14, 'In', 10.00, 1000.00, '2023-07-31 17:00:00'),
(208, 14, 'In', 10.00, 1000.00, '2023-08-31 17:00:00'),
(209, 14, 'In', 10.00, 1000.00, '2023-09-30 17:00:00'),
(210, 14, 'In', 10.00, 1000.00, '2023-10-31 17:00:00'),
(211, 14, 'Out', 10.00, 1000.00, '2023-05-31 17:00:00'),
(212, 14, 'Out', 10.00, 1000.00, '2023-06-30 17:00:00'),
(213, 14, 'Out', 10.00, 1000.00, '2023-07-31 17:00:00'),
(214, 14, 'Out', 10.00, 1000.00, '2023-08-31 17:00:00'),
(215, 14, 'Out', 10.00, 1000.00, '2023-09-30 17:00:00'),
(216, 14, 'Out', 10.00, 1000.00, '2023-10-31 17:00:00'),
(217, 15, 'In', 10.00, 2100.00, '2023-05-31 17:00:00'),
(218, 15, 'In', 10.00, 2100.00, '2023-06-30 17:00:00'),
(219, 15, 'In', 10.00, 2100.00, '2023-07-31 17:00:00'),
(220, 15, 'In', 10.00, 2100.00, '2023-08-31 17:00:00'),
(221, 15, 'In', 10.00, 2100.00, '2023-09-30 17:00:00'),
(222, 15, 'In', 10.00, 2100.00, '2023-10-31 17:00:00'),
(223, 15, 'Out', 10.00, 2100.00, '2023-05-31 17:00:00'),
(224, 15, 'Out', 10.00, 2100.00, '2023-06-30 17:00:00'),
(225, 15, 'Out', 10.00, 2100.00, '2023-07-31 17:00:00'),
(226, 15, 'Out', 10.00, 2100.00, '2023-08-31 17:00:00'),
(227, 15, 'Out', 10.00, 2100.00, '2023-09-30 17:00:00'),
(228, 15, 'Out', 10.00, 2100.00, '2023-10-31 17:00:00'),
(229, 16, 'In', 1.00, 2700.00, '2023-05-31 17:00:00'),
(230, 16, 'In', 1.00, 2700.00, '2023-06-30 17:00:00'),
(231, 16, 'In', 1.00, 2700.00, '2023-07-31 17:00:00'),
(232, 16, 'In', 1.00, 2700.00, '2023-08-31 17:00:00'),
(233, 16, 'In', 1.00, 2700.00, '2023-09-30 17:00:00'),
(234, 16, 'In', 1.00, 2700.00, '2023-10-31 17:00:00'),
(235, 16, 'Out', 1.00, 2700.00, '2023-05-31 17:00:00'),
(236, 16, 'Out', 1.00, 2700.00, '2023-06-30 17:00:00'),
(237, 16, 'Out', 1.00, 2700.00, '2023-07-31 17:00:00'),
(238, 16, 'Out', 1.00, 2700.00, '2023-08-31 17:00:00'),
(239, 16, 'Out', 1.00, 2700.00, '2023-09-30 17:00:00'),
(240, 16, 'Out', 1.00, 2700.00, '2023-10-31 17:00:00'),
(241, 17, 'In', 90.00, 2700.00, '2023-05-31 17:00:00'),
(242, 17, 'In', 90.00, 2700.00, '2023-06-30 17:00:00'),
(243, 17, 'In', 90.00, 2700.00, '2023-07-31 17:00:00'),
(244, 17, 'In', 90.00, 2700.00, '2023-08-31 17:00:00'),
(245, 17, 'In', 90.00, 2700.00, '2023-09-30 17:00:00'),
(246, 17, 'In', 90.00, 2700.00, '2023-10-31 17:00:00'),
(247, 17, 'Out', 90.00, 2700.00, '2023-05-31 17:00:00'),
(248, 17, 'Out', 90.00, 2700.00, '2023-06-30 17:00:00'),
(249, 17, 'Out', 90.00, 2700.00, '2023-07-31 17:00:00'),
(250, 17, 'Out', 90.00, 2700.00, '2023-08-31 17:00:00'),
(251, 17, 'Out', 90.00, 2700.00, '2023-09-30 17:00:00'),
(252, 17, 'Out', 90.00, 2700.00, '2023-10-31 17:00:00'),
(253, 18, 'In', 45.00, 3600.00, '2023-05-31 17:00:00'),
(254, 18, 'In', 45.00, 3600.00, '2023-06-30 17:00:00'),
(255, 18, 'In', 45.00, 3600.00, '2023-07-31 17:00:00'),
(256, 18, 'In', 45.00, 3600.00, '2023-08-31 17:00:00'),
(257, 18, 'In', 45.00, 3600.00, '2023-09-30 17:00:00'),
(258, 18, 'In', 45.00, 3600.00, '2023-10-31 17:00:00'),
(259, 18, 'Out', 45.00, 3600.00, '2023-05-31 17:00:00'),
(260, 18, 'Out', 45.00, 3600.00, '2023-06-30 17:00:00'),
(261, 18, 'Out', 45.00, 3600.00, '2023-07-31 17:00:00'),
(262, 18, 'Out', 45.00, 3600.00, '2023-08-31 17:00:00'),
(263, 18, 'Out', 45.00, 3600.00, '2023-09-30 17:00:00'),
(264, 18, 'Out', 45.00, 3600.00, '2023-10-31 17:00:00'),
(265, 19, 'In', 60.00, 3240.00, '2023-05-31 17:00:00'),
(266, 19, 'In', 60.00, 3240.00, '2023-06-30 17:00:00'),
(267, 19, 'In', 60.00, 3240.00, '2023-07-31 17:00:00'),
(268, 19, 'In', 60.00, 3240.00, '2023-08-31 17:00:00'),
(269, 19, 'In', 60.00, 3240.00, '2023-09-30 17:00:00'),
(270, 19, 'In', 60.00, 3240.00, '2023-10-31 17:00:00'),
(271, 19, 'Out', 60.00, 3240.00, '2023-05-31 17:00:00'),
(272, 19, 'Out', 60.00, 3240.00, '2023-06-30 17:00:00'),
(273, 19, 'Out', 60.00, 3240.00, '2023-07-31 17:00:00'),
(274, 19, 'Out', 60.00, 3240.00, '2023-08-31 17:00:00'),
(275, 19, 'Out', 60.00, 3240.00, '2023-09-30 17:00:00'),
(276, 19, 'Out', 60.00, 3240.00, '2023-10-31 17:00:00'),
(277, 20, 'In', 60.00, 3000.00, '2023-05-31 17:00:00'),
(278, 20, 'In', 60.00, 3000.00, '2023-06-30 17:00:00'),
(279, 20, 'In', 60.00, 3000.00, '2023-07-31 17:00:00'),
(280, 20, 'In', 60.00, 3000.00, '2023-08-31 17:00:00'),
(281, 20, 'In', 60.00, 3000.00, '2023-09-30 17:00:00'),
(282, 20, 'In', 60.00, 3000.00, '2023-10-31 17:00:00'),
(283, 20, 'Out', 60.00, 3000.00, '2023-05-31 17:00:00'),
(284, 20, 'Out', 60.00, 3000.00, '2023-06-30 17:00:00'),
(285, 20, 'Out', 60.00, 3000.00, '2023-07-31 17:00:00'),
(286, 20, 'Out', 60.00, 3000.00, '2023-08-31 17:00:00'),
(287, 20, 'Out', 60.00, 3000.00, '2023-09-30 17:00:00'),
(288, 20, 'Out', 60.00, 3000.00, '2023-10-31 17:00:00'),
(289, 21, 'In', 30.00, 6000.00, '2023-05-31 17:00:00'),
(290, 21, 'In', 30.00, 6000.00, '2023-06-30 17:00:00'),
(291, 21, 'In', 30.00, 6000.00, '2023-07-31 17:00:00'),
(292, 21, 'In', 30.00, 6000.00, '2023-08-31 17:00:00'),
(293, 21, 'In', 30.00, 6000.00, '2023-09-30 17:00:00'),
(294, 21, 'In', 30.00, 6000.00, '2023-10-31 17:00:00'),
(295, 21, 'Out', 30.00, 6000.00, '2023-05-31 17:00:00'),
(296, 21, 'Out', 30.00, 6000.00, '2023-06-30 17:00:00'),
(297, 21, 'Out', 30.00, 6000.00, '2023-07-31 17:00:00'),
(298, 21, 'Out', 30.00, 6000.00, '2023-08-31 17:00:00'),
(299, 21, 'Out', 30.00, 6000.00, '2023-09-30 17:00:00'),
(300, 21, 'Out', 30.00, 6000.00, '2023-10-31 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `LogActivities`
--

CREATE TABLE `LogActivities` (
  `LogID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ActivityDescription` text DEFAULT NULL,
  `ActivityTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `LogActivities`
--

INSERT INTO `LogActivities` (`LogID`, `UserID`, `ActivityDescription`, `ActivityTimestamp`) VALUES
(1, 137648118, 'Ingredient with Name: Timun Segar has been updated.', '2023-12-12 11:56:36'),
(2, 137648118, 'Ingredient with Name: Tepung Ayam has been updated.', '2023-12-12 11:57:29'),
(3, 137648118, 'Ingredient with Name: Timun Segar has been updated.', '2023-12-12 12:37:59'),
(4, 137648118, 'Ingredient with Name: Tepung Ayam has been updated.', '2023-12-12 12:40:51'),
(5, 137648118, 'Ingredient with Name: Marinasi Spesial has been updated.', '2023-12-12 12:41:52'),
(6, 137648118, 'User logged in', '2023-12-18 01:41:32'),
(7, 137648118, 'Bahan dengan Nama: Es Batu telah dibuat dengan detail berikut - Harga Beli: 10000, Jumlah per Beli: 1, Porsi per Bahan: 50.', '2023-12-18 02:33:09'),
(8, 137648118, 'Ingredient with Name: Timun Segar has been updated.', '2023-12-18 02:34:16'),
(9, 137648118, 'Ingredient with Name: Tepung Ayam has been updated.', '2023-12-18 02:34:27'),
(10, 137648118, 'Ingredient with Name: Marinasi Spesial has been updated.', '2023-12-18 02:34:43'),
(11, 137648118, 'Ingredient with Name: Sambal has been updated.', '2023-12-18 02:35:26'),
(12, 137648118, 'Ingredient with Name: Nasi Putih has been updated.', '2023-12-18 02:36:50'),
(13, 137648118, 'Ingredient with Name: Kantong Plastik Kecil has been updated.', '2023-12-18 02:38:32'),
(14, 137648118, 'Ingredient with Name: Kresek Plastik Kecil has been updated.', '2023-12-18 02:39:57'),
(15, 137648118, 'Ingredient with Name: Foam Kecil (Wadah) has been updated.', '2023-12-18 02:40:59'),
(16, 137648118, 'Ingredient with Name: Foam Besar (Wadah) has been updated.', '2023-12-18 02:41:33'),
(17, 137648118, 'Ingredient with Name: Cup Minuman Kecil has been updated.', '2023-12-18 02:43:09'),
(18, 137648118, 'Ingredient with Name: Cup Minuman Besar has been updated.', '2023-12-18 02:43:43'),
(19, 137648118, 'Ingredient with Name: Ayam has been updated.', '2023-12-18 02:44:16'),
(20, 137648118, 'Ingredient with Name: Kresek Plastik Besar has been updated.', '2023-12-18 02:45:01'),
(21, 137648118, 'Ingredient with Name: Kresek Plastik Sedang has been updated.', '2023-12-18 02:45:50'),
(22, 137648118, 'Ingredient with Name: Minyak Goreng has been updated.', '2023-12-18 02:46:32'),
(23, 137648118, 'Ingredient with Name: Gas Elpigi 15Kg has been updated.', '2023-12-18 02:47:14'),
(24, 137648118, 'Ingredient with Name: Teh Minang has been updated.', '2023-12-18 02:47:54'),
(25, 137648118, 'Ingredient with Name: Gula Pasir has been updated.', '2023-12-18 02:48:51'),
(26, 137648118, 'Ingredient with Name: Air Galon  has been updated.', '2023-12-18 02:50:54'),
(27, 137648118, 'Bahan dengan Nama: Saos Sachet telah dibuat dengan detail berikut - Harga Beli: 10000, Jumlah per Beli: 2, Porsi per Bahan: 100.', '2023-12-18 02:52:11'),
(28, 137648118, 'Ingredient with Name: Nasi Putih has been updated.', '2023-12-18 03:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `ProductIngredients`
--

CREATE TABLE `ProductIngredients` (
  `ProductIngredientID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `IngredientID` int(11) DEFAULT NULL,
  `Quantity` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `PhotoURL` varchar(255) DEFAULT NULL,
  `SellingPrice` decimal(10,2) NOT NULL,
  `Manufacturer` varchar(255) DEFAULT NULL,
  `Weight` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProductTransactions`
--

CREATE TABLE `ProductTransactions` (
  `TransactionID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` decimal(10,2) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`RoleID`, `RoleName`) VALUES
(1, 'Admin'),
(2, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `RoleID` int(11) DEFAULT NULL,
  `AccountCreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastLogin` datetime DEFAULT NULL,
  `AccountStatus` varchar(20) DEFAULT NULL,
  `ProfilePictureURL` varchar(255) DEFAULT NULL,
  `ActivationStatus` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `DateOfBirth`, `Gender`, `Address`, `PhoneNumber`, `RoleID`, `AccountCreationDate`, `LastLogin`, `AccountStatus`, `ProfilePictureURL`, `ActivationStatus`) VALUES
(0, 'ikimukti', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '19103020046@unpkediri.ac.id', 'Firmansyah Mukti Wijaya', '2023-10-12', 'Male', 'Nglaban 1111', '081216318022', 2, '2023-11-25 12:09:14', '2023-10-29 20:04:55', NULL, '653e5a409b4fb.jpeg', NULL),
(137648118, 'admin', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'admin@ikimukti.com', 'Administrator', NULL, NULL, NULL, NULL, 1, '2023-12-18 01:41:32', '2023-12-18 08:41:32', NULL, '6562102a33af3.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Ingredients`
--
ALTER TABLE `Ingredients`
  ADD PRIMARY KEY (`IngredientID`);

--
-- Indexes for table `IngredientStocks`
--
ALTER TABLE `IngredientStocks`
  ADD PRIMARY KEY (`StockID`),
  ADD KEY `IngredientID` (`IngredientID`);

--
-- Indexes for table `IngredientTransactions`
--
ALTER TABLE `IngredientTransactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `IngredientID` (`IngredientID`);

--
-- Indexes for table `LogActivities`
--
ALTER TABLE `LogActivities`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `ProductIngredients`
--
ALTER TABLE `ProductIngredients`
  ADD PRIMARY KEY (`ProductIngredientID`),
  ADD KEY `product_id` (`ProductID`),
  ADD KEY `ingredient_id` (`IngredientID`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `ProductTransactions`
--
ALTER TABLE `ProductTransactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`RoleID`),
  ADD UNIQUE KEY `RoleName` (`RoleName`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `users_ibfk_1` (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Ingredients`
--
ALTER TABLE `Ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `IngredientStocks`
--
ALTER TABLE `IngredientStocks`
  MODIFY `StockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `IngredientTransactions`
--
ALTER TABLE `IngredientTransactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `LogActivities`
--
ALTER TABLE `LogActivities`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ProductIngredients`
--
ALTER TABLE `ProductIngredients`
  MODIFY `ProductIngredientID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductTransactions`
--
ALTER TABLE `ProductTransactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `IngredientStocks`
--
ALTER TABLE `IngredientStocks`
  ADD CONSTRAINT `ingredientstocks_ibfk_1` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`IngredientID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `IngredientTransactions`
--
ALTER TABLE `IngredientTransactions`
  ADD CONSTRAINT `ingredienttransactions_ibfk_1` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`IngredientID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `LogActivities`
--
ALTER TABLE `LogActivities`
  ADD CONSTRAINT `logactivities_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `ProductIngredients`
--
ALTER TABLE `ProductIngredients`
  ADD CONSTRAINT `productingredients_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `productingredients_ibfk_2` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`IngredientID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ProductTransactions`
--
ALTER TABLE `ProductTransactions`
  ADD CONSTRAINT `producttransactions_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
