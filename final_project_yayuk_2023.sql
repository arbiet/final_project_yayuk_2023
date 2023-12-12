-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 01:42 PM
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
(4, 'Sambal', 42000.00, 1.00, 300, 1, 2000.00, 90, 'Supplier D', 'Saus pedas spesial', 3, 'Cool Storage', 'kg', NULL, NULL, NULL, NULL),
(5, 'Nasi Putih', 10000.00, 1.00, 25, 1, 3000.00, 1, 'Supplier E', 'Nasi putih matang', 10, 'Warm Storage', 'kg', NULL, NULL, NULL, NULL),
(6, 'Kantong Plastik Kecil', 200.00, 1.00, 100, 1, 20.00, 0, 'Supplier F', 'Kantong plastik kecil berkualitas', 500, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(7, 'Kresek Plastik Kecil', 7500.00, 1.00, 100, 1, 500.00, 0, 'Supplier G', 'Kresek plastik kecil berkualitas', 2, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(8, 'Foam Kecil (Wadah)', 18000.00, 1.00, 100, 1, 100.00, NULL, 'Supplier H', 'Wadah foam kecil berkualitas', 100, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(9, 'Foam Besar (Wadah)', 28000.00, 1.00, 100, 1, 150.00, NULL, 'Supplier I', 'Wadah foam besar berkualitas', 50, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(10, 'Cup Minuman Kecil', 17000.00, 1.00, 100, 1, 30.00, NULL, 'Supplier J', 'Cup minuman kecil berkualitas', 200, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(11, 'Cup Minuman Besar', 22000.00, 1.00, 100, 1, 50.00, NULL, 'Supplier K', 'Cup minuman besar berkualitas', 150, 'Dry Storage', 'piece', NULL, NULL, NULL, NULL),
(12, 'Ayam', 53000.00, 1.00, 30, 1, 2000.00, 365, 'Supplier A', 'Ayam Potong', 3, 'Cool Storage', 'kg', NULL, NULL, NULL, NULL),
(13, 'Kresek Plastik Besar', 25000.00, 1.00, 50, 1, 500.00, 0, 'Suplier X', 'Kresek Plastik Besar Yahud', 1, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(14, 'Kresek Plastik Sedang', 8000.00, 1.00, 100, 1, 500.00, 0, 'Suplier X', 'Kresek Plastik Sedang dang dang dang', 1, 'Dry Storage', 'pack', NULL, NULL, NULL, NULL),
(15, 'Minyak Goreng', 75000.00, 1.00, 210, 1, 2000.00, 730, 'Suplier M', 'Minyak Kelapa Sawit Murni', 10, 'Dry Storage', 'kg', NULL, NULL, NULL, NULL),
(16, 'Gas Elpigi 15Kg', 275000.00, 1.00, 2700, 1, 2000.00, 30, 'Suplier G', 'Gas Elpigi 15Kg Gas Negoro', 2, 'Dry Storage', 'kg', NULL, NULL, NULL, NULL),
(17, 'Teh Minang', 5000.00, 1.00, 30, 1, 500.00, 365, 'Supplier T', 'Teh Minang Kabau Asli', 6, 'Dry Storage', 'piece', NULL, NULL, NULL, NULL),
(18, 'Gula Pasir', 16500.00, 1.00, 80, 1, 1000.00, 365, 'Suplier G', 'Gula Pasir Pabrik Gula Mrican', 4, 'Dry Storage', 'kg', NULL, NULL, NULL, NULL),
(19, 'Air Galon ', 4000.00, 1.00, 54, 1, 500.00, 7, 'Suplier G', 'Banyu Sri Sejahtera Sedudo', 2, 'Dry Storage', 'liter', NULL, NULL, NULL, NULL);

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
(5, 137648118, 'Ingredient with Name: Marinasi Spesial has been updated.', '2023-12-12 12:41:52');

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
(137648118, 'admin', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'admin@ikimukti.com', 'Administrator', NULL, NULL, NULL, NULL, 1, '2023-12-12 11:32:45', '2023-12-12 18:32:45', NULL, '6562102a33af3.png', NULL);

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
  MODIFY `StockID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `IngredientTransactions`
--
ALTER TABLE `IngredientTransactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LogActivities`
--
ALTER TABLE `LogActivities`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
