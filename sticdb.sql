-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2021 at 11:37 AM
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
  `PublicKey` text NOT NULL,
  `Password` text NOT NULL,
  `Email` text NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `DateOfBirth` text NOT NULL,
  `ContactNumber` int(11) NOT NULL,
  `Address` text NOT NULL,
  `AccountType` text NOT NULL DEFAULT 'Standard',
  `PrivateKey` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `DisplayName`, `PublicKey`, `Password`, `Email`, `FirstName`, `LastName`, `DateOfBirth`, `ContactNumber`, `Address`, `AccountType`, `PrivateKey`) VALUES
('TestUser1', 'TestUser1', '0x33963Ce1286F603579713E7e25e155f7a70085A0', '$2y$10$S9/RRT2aqOepNOYL3KGWouq6jPteamDgWrwm/uuMDvIf8JFvxHWRW', 'bob3@gmail.com', 'Bob', 'Alice', '13/04/2021', 96969696, '1 sim', 'Standard', '0x57a3514924454e34842ad22341003c057a5696a07fe401b2f1a465bc78bfae1f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`TransactionID`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
