-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2021 at 05:38 PM
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
-- Table structure for table `escrow`
--

CREATE TABLE `escrow` (
  `PublicKey` varchar(320) NOT NULL,
  `PrivateKey` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `escrow`
--

INSERT INTO `escrow` (`PublicKey`, `PrivateKey`) VALUES
('0x1403Bc7902e5E3796b053dCFa017609c7C99F85F ', ' 0x050f81c214c558617da8ad5f5cd39af5ad87ab1987260866833cc9854f6de655');

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
  `ProductCaption` text NOT NULL,
  `ProductInitialPrice` int(11) NOT NULL DEFAULT 0,
  `DateOfListing` date NOT NULL DEFAULT current_timestamp(),
  `DateOfExpiry` date NOT NULL,
  `SellerUserID` varchar(20) NOT NULL,
  `Status` text NOT NULL DEFAULT 'Available',
  `Image` text NOT NULL,
  `Review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Review`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductCategory`, `ProductDescription`, `ProductCaption`, `ProductInitialPrice`, `DateOfListing`, `DateOfExpiry`, `SellerUserID`, `Status`, `Image`, `Review`) VALUES
('lpn57409', 'gg', 'CatC', 'gg', 'gg', 500, '2021-04-23', '0000-00-00', 'TestUser1', 'Available', 'images/608283449f7524.77177455 - Copy.jpg', '[]'),
('ykb566008', 'gg', 'CatB', 'gg', 'gg', 555, '2021-04-23', '0000-00-00', 'TestUser1', 'Available', 'images/60828304028fc2.76598577.jpg', '[]'),
('zek286895', 'gg', 'CatC', 'gg', 'gg', 20, '2021-04-23', '0000-00-00', 'TestUser1', 'Available', 'images/608283449f7524.77177455.jpg', '[{\"Review\":\"hi\",\"ProductID\":\"zek286895\",\"User\":\"TestUser1\",\"Date\":\"23/04/2021\"},{\"Review\":\"hi\",\"ProductID\":\"zek286895\",\"User\":\"TestUser1\",\"Date\":\"23/04/2021\"},{\"Review\":\"hi\",\"ProductID\":\"zek286895\",\"User\":\"TestUser1\",\"Date\":\"23/04/2021\"},{\"Review\":\"hi\",\"ProductID\":\"zek286895\",\"User\":\"TestUser1\",\"Date\":\"23/04/2021\"}]');

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
  `PrivateKey` text NOT NULL,
  `Rating` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{"Rating":5,"NumOfReviewers":0}' CHECK (json_valid(`Rating`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `DisplayName`, `PublicKey`, `Password`, `Email`, `FirstName`, `LastName`, `DateOfBirth`, `ContactNumber`, `Address`, `AccountType`, `PrivateKey`, `Rating`) VALUES
('TestUser1', 'TestUser1', '0x33963Ce1286F603579713E7e25e155f7a70085A0', '$2y$10$S9/RRT2aqOepNOYL3KGWouq6jPteamDgWrwm/uuMDvIf8JFvxHWRW', 'bob3@gmail.com', 'Bob', 'Alice', '13/04/2021', 96969696, '1 sim', 'Standard', '0x57a3514924454e34842ad22341003c057a5696a07fe401b2f1a465bc78bfae1f', '{\"Rating\":5,\"NumOfReviewers\":0}'),
('TestUser6', 'Bobbbbbb', '0x2436e48CB544FF78FB29f93f01878DE7a9688DEa', '$2y$10$S9/RRT2aqOepNOYL3KGWouq6jPteamDgWrwm/uuMDvIf8JFvxHWRW', 'bob5@gmail.com', 'bob', 'bob', '01/04/2021', 66666666, 'asdasdas', 'Standard', '0xcd91d2eefde0fa3757b24a8fa80dc445264753d270b49c66c013430c0ee204c0', '{\"Rating\":5,\"NumOfReviewers\":0}'),
('TestUser7', 'Bobbbbbbb', '0x87a45E8b751c8E2CFe63F909c204F8b32b81BEdF', '$2y$10$S9/RRT2aqOepNOYL3KGWouq6jPteamDgWrwm/uuMDvIf8JFvxHWRW', 'bob7@gmail.com', 'bob', 'bob', '01/04/2021', 66666666, 'asdasdas', 'Standard', '0xb2eaddd8afc0a10c42914e57a3b4c4fea3a9d5041d3423dad681d35ef33f9525', '{\"Rating\":5,\"NumOfReviewers\":0}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `escrow`
--
ALTER TABLE `escrow`
  ADD PRIMARY KEY (`PublicKey`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
