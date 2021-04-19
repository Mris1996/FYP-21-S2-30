-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2021 at 02:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sticdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `TransactionID` int(11) NOT NULL,
  `TransactionOpenDate` datetime NOT NULL,
  `TransactionCloseDate` datetime NOT NULL,
  `ContractID` text NOT NULL,
  `BuyerUserID` varchar(20) NOT NULL,
  `SellerUserID` varchar(20) NOT NULL,
  `ProductID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `negotiation`
--

CREATE TABLE `negotiation` (
  `UserID` varchar(20) NOT NULL,
  `Message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Message`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(20) NOT NULL,
  `ProductName` text NOT NULL,
  `ProductCategory` text NOT NULL,
  `ProductDescription` text NOT NULL,
  `ProductInitialPrice` int(11) NOT NULL DEFAULT 0,
  `DateOfListing` date NOT NULL,
  `DateOfExpiry` date NOT NULL,
  `SellerUserID` varchar(20) NOT NULL,
  `Status` text NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` varchar(20) NOT NULL,
  `DisplayName` text NOT NULL,
  `GanachePublicKey` text NOT NULL,
  `Password` text NOT NULL,
  `Email` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `DateOfBirth` date NOT NULL,
  `ContactNumber` int(11) NOT NULL,
  `AccountBalance` int(11) NOT NULL DEFAULT 0,
  `Address` text NOT NULL,
  `AccountType` text NOT NULL DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`TransactionID`),
  ADD UNIQUE KEY `BuyerUserID` (`BuyerUserID`),
  ADD UNIQUE KEY `ProductID` (`ProductID`),
  ADD KEY `SellerUserID` (`SellerUserID`);

--
-- Indexes for table `negotiation`
--
ALTER TABLE `negotiation`
  ADD KEY `UID-negotiation` (`UserID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `SellerUserID` (`SellerUserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `negotiation`
--
ALTER TABLE `negotiation`
  ADD CONSTRAINT `UID-negotiation` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `PID-contract` FOREIGN KEY (`ProductID`) REFERENCES `contracts` (`ProductID`),
  ADD CONSTRAINT `UID-product` FOREIGN KEY (`SellerUserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `UID-Contract` FOREIGN KEY (`UserID`) REFERENCES `contracts` (`SellerUserID`),
  ADD CONSTRAINT `UID-Contract2` FOREIGN KEY (`UserID`) REFERENCES `contracts` (`BuyerUserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
