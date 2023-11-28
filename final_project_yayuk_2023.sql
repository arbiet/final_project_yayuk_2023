-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 03:43 PM
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
  `PurchaseUnit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Ingredients`
--

INSERT INTO `Ingredients` (`IngredientID`, `IngredientName`, `PurchasePrice`, `QuantityPerPurchase`, `ServingsPerIngredient`, `HoldingCost`, `HoldingCostPrice`, `ShelfLife`, `SupplierName`, `Description`, `MinimumStock`, `StorageLocation`, `PurchaseUnit`) VALUES
(1, 'Timun Segar', 7000.00, 5.00, 20, 0, 1000.00, 7, 'Supplier A', 'Timun segar berkualitas', 3, 'Cool Storage', 'kg'),
(2, 'Tepung Ayam', 19000.00, 1.00, 30, 1, 1000.00, 182, 'Supplier B', 'Tepung ayam khusus untuk pencelupan', 3, 'Dry Storage', 'kg'),
(3, 'Marinasi Spesial', 2000.00, 1.00, 30, 1, 500.00, 730, 'Supplier C', 'Bumbu ayam spesial', 3, 'Dry Storage', 'piece'),
(4, 'Sambal', 42000.00, 1.00, 300, 1, 2000.00, 90, 'Supplier D', 'Saus pedas spesial', 3, 'Cool Storage', 'kg'),
(5, 'Nasi Putih', 10000.00, 1.00, 25, 1, 3000.00, 1, 'Supplier E', 'Nasi putih matang', 10, 'Warm Storage', 'kg'),
(6, 'Kantong Plastik Kecil', 200.00, 1.00, 100, 1, 20.00, 0, 'Supplier F', 'Kantong plastik kecil berkualitas', 500, 'Dry Storage', 'pack'),
(7, 'Kresek Plastik Kecil', 7500.00, 1.00, 100, 1, 500.00, 0, 'Supplier G', 'Kresek plastik kecil berkualitas', 2, 'Dry Storage', 'pack'),
(8, 'Foam Kecil (Wadah)', 18000.00, 1.00, 100, 1, 100.00, NULL, 'Supplier H', 'Wadah foam kecil berkualitas', 100, 'Dry Storage', 'pack'),
(9, 'Foam Besar (Wadah)', 28000.00, 1.00, 100, 1, 150.00, NULL, 'Supplier I', 'Wadah foam besar berkualitas', 50, 'Dry Storage', 'pack'),
(10, 'Cup Minuman Kecil', 17000.00, 1.00, 100, 1, 30.00, NULL, 'Supplier J', 'Cup minuman kecil berkualitas', 200, 'Dry Storage', 'pack'),
(11, 'Cup Minuman Besar', 22000.00, 1.00, 100, 1, 50.00, NULL, 'Supplier K', 'Cup minuman besar berkualitas', 150, 'Dry Storage', 'piece'),
(12, 'Ayam', 53000.00, 1.00, 30, 1, 2000.00, 365, 'Supplier A', 'Ayam Potong', 3, 'Cool Storage', 'kg'),
(13, 'Kresek Plastik Besar', 25000.00, 1.00, 50, 1, 500.00, 0, 'Suplier X', 'Kresek Plastik Besar Yahud', 1, 'Dry Storage', 'pack'),
(14, 'Kresek Plastik Sedang', 8000.00, 1.00, 100, 1, 500.00, 0, 'Suplier X', 'Kresek Plastik Sedang dang dang dang', 1, 'Dry Storage', 'pack'),
(15, 'Minyak Goreng', 75000.00, 1.00, 210, 1, 2000.00, 730, 'Suplier M', 'Minyak Kelapa Sawit Murni', 10, 'Dry Storage', 'kg'),
(16, 'Gas Elpigi 15Kg', 275000.00, 1.00, 2700, 1, 2000.00, 30, 'Suplier G', 'Gas Elpigi 15Kg Gas Negoro', 2, 'Dry Storage', 'kg'),
(17, 'Teh Minang', 5000.00, 1.00, 30, 1, 500.00, 365, 'Supplier T', 'Teh Minang Kabau Asli', 6, 'Dry Storage', 'piece'),
(18, 'Gula Pasir', 16500.00, 1.00, 80, 1, 1000.00, 365, 'Suplier G', 'Gula Pasir Pabrik Gula Mrican', 4, 'Dry Storage', 'kg'),
(19, 'Air Galon ', 4000.00, 1.00, 54, 1, 500.00, 7, 'Suplier G', 'Banyu Sri Sejahtera Sedudo', 2, 'Dry Storage', 'liter');

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
(6, 1, 1.00, 100.00, '2023-11-28 11:57:03');

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
(6, 1, 'In', 1.00, 100.00, '2023-11-28 11:57:03');

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
(1, 0, 'User logged in', '2023-10-29 12:35:16'),
(2, 0, 'User logged out', '2023-10-29 12:38:21'),
(3, 0, 'User logged in', '2023-10-29 12:38:44'),
(4, 0, 'User logged out', '2023-10-29 12:47:05'),
(5, 0, 'User logged in', '2023-10-29 12:47:14'),
(6, 0, 'User logged out', '2023-10-29 12:48:24'),
(7, 0, 'User logged in', '2023-10-29 12:48:36'),
(8, 0, 'User logged out', '2023-10-29 13:04:46'),
(9, 0, 'User logged in', '2023-10-29 13:04:55'),
(10, 0, 'Changed profile picture from 653e58a6edc33.png to 653e5a409b4fb.jpeg', '2023-10-29 13:12:32'),
(11, 0, 'User updated profile. Changes: Full Name, Email, Username, Date of Birth, Gender, Address, Phone Number', '2023-10-29 13:17:59'),
(12, 0, 'User updated profile. Changes: ', '2023-10-29 13:18:51'),
(13, 0, 'User updated profile. Changes: Address', '2023-10-29 13:19:00'),
(14, 0, 'User updated profile. Changes: Address', '2023-10-29 13:19:10'),
(15, 0, 'User logged out', '2023-10-29 13:26:42'),
(16, 137648118, 'User logged in', '2023-10-29 13:36:58'),
(17, 137648118, 'Bahan dengan Nama: Ayam telah dibuat dengan detail berikut - Harga Beli: 53000, Jumlah per Beli: 1, Porsi per Bahan: 30.', '2023-11-25 12:54:51'),
(18, 137648118, 'Ingredient with Name: Timun Segar has been updated.', '2023-11-25 13:11:01'),
(19, 137648118, 'Bahan dengan Nama: Kresek Plastik Besar telah dibuat dengan detail berikut - Harga Beli: 25000, Jumlah per Beli: 50, Porsi per Bahan: 50.', '2023-11-25 13:17:00'),
(20, 137648118, 'Ingredient with Name: Kresek Plastik Besar has been updated.', '2023-11-25 13:19:38'),
(21, 137648118, 'Bahan dengan Nama: Kresek Plastik Sedang telah dibuat dengan detail berikut - Harga Beli: 8000, Jumlah per Beli: 100, Porsi per Bahan: 100.', '2023-11-25 13:20:43'),
(22, 137648118, 'Ingredient with Name: Kantong Plastik Kecil has been updated.', '2023-11-25 13:20:55'),
(23, 137648118, 'Ingredient with Name: Marinasi Spesial has been updated.', '2023-11-25 13:23:10'),
(24, 137648118, 'Ingredient with Name: Tepung Ayam has been updated.', '2023-11-25 13:24:29'),
(25, 137648118, 'Ingredient with Name: Sambal has been updated.', '2023-11-25 13:26:03'),
(26, 137648118, 'Ingredient with Name: Nasi Putih has been updated.', '2023-11-25 13:28:05'),
(27, 137648118, 'Ingredient with Name: Kresek Plastik Kecil has been updated.', '2023-11-25 13:28:44'),
(28, 137648118, 'Bahan dengan Nama: Minyak Goreng telah dibuat dengan detail berikut - Harga Beli: 75000, Jumlah per Beli: 210, Porsi per Bahan: 210.', '2023-11-25 13:44:56'),
(29, 137648118, 'Bahan dengan Nama: Gas Elpigi 15Kg telah dibuat dengan detail berikut - Harga Beli: 275000, Jumlah per Beli: 2, Porsi per Bahan: 2700.', '2023-11-25 13:48:55'),
(30, 137648118, 'Bahan dengan Nama: Teh Minang telah dibuat dengan detail berikut - Harga Beli: 5000, Jumlah per Beli: 30, Porsi per Bahan: 30.', '2023-11-25 13:51:37'),
(31, 137648118, 'Bahan dengan Nama: Gula Pasir telah dibuat dengan detail berikut - Harga Beli: 16500, Jumlah per Beli: 4, Porsi per Bahan: 80.', '2023-11-25 13:53:30'),
(32, 137648118, 'Bahan dengan Nama: Air Galon  telah dibuat dengan detail berikut - Harga Beli: 4000, Jumlah per Beli: 2, Porsi per Bahan: 54.', '2023-11-25 13:56:14'),
(33, 137648118, 'User logged out', '2023-11-25 14:20:57'),
(34, 137648118, 'User logged in', '2023-11-25 14:21:16'),
(35, 137648118, 'Product with Name: O ayam Geprek ( Paket 1)  has been created with the following details - Selling Price: 15000, Manufacturer: O Ayam Geprek, Weight: 400.', '2023-11-25 14:39:35'),
(36, 137648118, 'Product with ID: 9 has been updated with the following details - Product Name: O ayam Geprek ( Paket 1) , Selling Price: 15000.00, Manufacturer: O Ayam Geprek, Weight: 400.00.', '2023-11-25 14:50:39'),
(37, 137648118, 'Product with ID: 9 has been updated with the following details - Product Name: O ayam Geprek ( Paket 1) , Selling Price: 15000.00, Manufacturer: O Ayam Geprek, Weight: 400.00.', '2023-11-25 14:53:14'),
(38, 137648118, 'Product with ID: 1, Product Name: O Ayam has been deleted.', '2023-11-25 14:56:37'),
(39, 137648118, 'Changed profile picture from default.png to 6562102a33af3.png', '2023-11-25 15:18:02'),
(40, 137648118, 'User logged in', '2023-11-25 19:15:36'),
(41, 137648118, 'User logged out', '2023-11-25 19:17:12'),
(42, 137648118, 'User logged in', '2023-11-25 19:17:18'),
(43, 137648118, 'User logged out', '2023-11-25 19:19:35'),
(44, 137648118, 'User logged in', '2023-11-25 19:19:40'),
(45, 137648118, 'User logged in', '2023-11-28 11:17:01'),
(46, 0, 'User logged out', '2023-11-28 12:31:46'),
(47, 137648118, 'User logged in', '2023-11-28 12:31:58');

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

--
-- Dumping data for table `ProductIngredients`
--

INSERT INTO `ProductIngredients` (`ProductIngredientID`, `ProductID`, `IngredientID`, `Quantity`) VALUES
(6, 2, 12, 1.00),
(7, 2, 4, 0.20),
(8, 2, 1, 0.10),
(9, 2, 5, 0.50),
(10, 2, 6, 1.00),
(11, 2, 8, 1.00),
(12, 3, 12, 2.00),
(13, 3, 4, 0.20),
(14, 3, 1, 0.10),
(15, 3, 5, 0.50),
(16, 3, 17, 1.00),
(17, 3, 6, 1.00),
(18, 3, 8, 1.00),
(19, 4, 12, 2.00),
(20, 4, 4, 0.20),
(21, 4, 1, 0.10),
(22, 4, 5, 0.50),
(23, 4, 17, 1.00),
(24, 4, 6, 1.00),
(25, 4, 8, 1.00),
(26, 5, 12, 1.00),
(27, 5, 4, 0.20),
(28, 5, 1, 0.10),
(29, 5, 6, 1.00),
(30, 5, 8, 1.00),
(31, 6, 12, 1.00),
(32, 6, 4, 0.20),
(33, 6, 1, 0.10),
(34, 6, 5, 0.50),
(35, 6, 6, 1.00),
(36, 6, 8, 1.00),
(37, 7, 12, 2.00),
(38, 7, 4, 0.20),
(39, 7, 1, 0.10),
(40, 7, 5, 0.50),
(41, 7, 17, 1.00),
(42, 7, 6, 1.00),
(43, 7, 8, 1.00),
(44, 8, 12, 2.00),
(45, 8, 4, 0.20),
(46, 8, 1, 0.10),
(47, 8, 5, 0.50),
(48, 8, 17, 1.00),
(49, 8, 6, 1.00),
(50, 8, 8, 1.00),
(60, 9, 12, 1.00),
(61, 9, 1, 1.00),
(62, 9, 4, 1.00),
(63, 9, 5, 1.00),
(64, 9, 14, 1.00),
(65, 9, 9, 1.00),
(66, 9, 15, 1.00),
(67, 9, 16, 1.00);

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

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`ProductID`, `ProductName`, `PhotoURL`, `SellingPrice`, `Manufacturer`, `Weight`) VALUES
(2, 'O Ayam 1 (Satu)', '2_o_ayam_1.jpg', 55000.00, 'O Ayam Geprek', 2.00),
(3, 'O Ayam 2 (Dua)', '3_o_ayam_2.jpg', 60000.00, 'O Ayam Geprek', 2.50),
(4, 'O Ayam 3 (Tiga)', '4_o_ayam_3.jpg', 70000.00, 'O Ayam Geprek', 3.00),
(5, 'O Ayam (Take Away)', '5_o_ayam_take_away.jpg', 52000.00, 'O Ayam Geprek', 1.70),
(6, 'O Ayam 1 (Satu) (Take Away)', '6_o_ayam_1_take_away.jpg', 57000.00, 'O Ayam Geprek', 2.20),
(7, 'O Ayam 2 (Dua) (Take Away)', '7_o_ayam_2_take_away.jpg', 62000.00, 'O Ayam Geprek', 2.70),
(8, 'O Ayam 3 (Tiga) (Take Away)', '8_o_ayam_3_take_away.jpg', 72000.00, 'O Ayam Geprek', 3.20),
(9, 'O ayam Geprek ( Paket 1) ', 'foto.jpg', 15000.00, 'O Ayam Geprek', 400.00);

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
(137648118, 'admin', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'admin@ikimukti.com', 'Administrator', NULL, NULL, NULL, NULL, 1, '2023-11-28 12:31:58', '2023-11-28 19:31:58', NULL, '6562102a33af3.png', NULL);

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
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `IngredientStocks`
--
ALTER TABLE `IngredientStocks`
  MODIFY `StockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `IngredientTransactions`
--
ALTER TABLE `IngredientTransactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `LogActivities`
--
ALTER TABLE `LogActivities`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `ProductIngredients`
--
ALTER TABLE `ProductIngredients`
  MODIFY `ProductIngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `ingredientstocks_ibfk_1` FOREIGN KEY (`IngredientID`) REFERENCES `Ingredients` (`IngredientID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `IngredientTransactions`
--
ALTER TABLE `IngredientTransactions`
  ADD CONSTRAINT `ingredienttransactions_ibfk_1` FOREIGN KEY (`IngredientID`) REFERENCES `Ingredients` (`IngredientID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `LogActivities`
--
ALTER TABLE `LogActivities`
  ADD CONSTRAINT `logactivities_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Constraints for table `ProductIngredients`
--
ALTER TABLE `ProductIngredients`
  ADD CONSTRAINT `productingredients_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ProductID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `productingredients_ibfk_2` FOREIGN KEY (`IngredientID`) REFERENCES `Ingredients` (`IngredientID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ProductTransactions`
--
ALTER TABLE `ProductTransactions`
  ADD CONSTRAINT `producttransactions_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ProductID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
