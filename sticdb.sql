-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2021 at 10:45 PM
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
  `TransactionID` text NOT NULL DEFAULT '[]',
  `TransactionOpenDate` datetime NOT NULL DEFAULT current_timestamp(),
  `TransactionCloseDate` datetime NOT NULL,
  `ContractID` varchar(30) NOT NULL,
  `BuyerUserID` varchar(20) NOT NULL,
  `SellerUserID` varchar(20) NOT NULL,
  `ProductID` varchar(20) NOT NULL,
  `DateRequired` date NOT NULL,
  `InitialOffer` int(11) NOT NULL,
  `NewOffer` int(11) NOT NULL,
  `Status` text NOT NULL DEFAULT 'Pending Seller Reply',
  `Payment Mode` text NOT NULL DEFAULT 'Half-STICoins',
  `TotalAccepted` int(11) NOT NULL DEFAULT 0,
  `Transaction` text NOT NULL DEFAULT 'Negotiating',
  `Message` text NOT NULL DEFAULT '[]',
  `RatingToken` text NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `negotiation`
--

CREATE TABLE `negotiation` (
  `UserID` varchar(20) NOT NULL,
  `Message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `UserID2` varchar(20) NOT NULL
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
  `Image` text NOT NULL DEFAULT '/images/default.jpg',
  `Review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductCategory`, `ProductDescription`, `ProductCaption`, `ProductInitialPrice`, `DateOfListing`, `DateOfExpiry`, `SellerUserID`, `Status`, `Image`, `Review`) VALUES
('ajy466961', 'Product36', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser2', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('awq984529', 'Product18', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser2', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('awu610781', 'Product20', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('bgm371258', 'Product13', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser9', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('bjo961187', 'Product25', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser9', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('brp906940', 'Product39', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser36', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('faw629282', 'Product4', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser26', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('fba99287', 'Product27', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser36', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ftu83814', 'Product11', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('gan361250', 'Product19', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser28', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('gsx206686', 'Product28', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('gxl439323', 'Product3', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser16', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('hhr38974', 'Product34', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser6', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('hnx704591', 'Product45', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser13', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('hwm781345', 'Product30', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser44', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('irt951699', 'Product35', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser5', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('iyh566961', 'Product24', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('jei928403', 'Product44', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('mph701253', 'Product32', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser10', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ngn499680', 'Product9', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser46', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ocj706659', 'Product29', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser34', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('oug589996', 'Product37', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser8', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ovo979683', 'Product12', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser48', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('phu871795', 'Product10', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('qiy4456', 'Product42', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser9', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('qpy645795', 'Product2', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser39', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('quj844050', 'Product1', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser23', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('qyg937962', 'Product48', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('rhj239050', 'Product22', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser43', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('rjz32683', 'Product15', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser29', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('rpr29790', 'Product17', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser21', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('rwj221421', 'Product40', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser7', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('snd804616', 'Product8', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser14', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('stj701324', 'Product21', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser27', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('swd225097', 'Product49', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser27', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('tbf699236', 'Product31', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('tgs969702', 'Product43', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser41', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('tmx832910', 'Product6', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser41', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('txp205418', 'Product23', 'Music', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser1', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ugo562616', 'Product5', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser19', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('uik540740', 'Product16', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser7', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ukg639501', 'Product38', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser49', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('uyx055120', 'Product47', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser10', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('vth730596', 'Product41', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser29', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('wbb995946', 'Product33', 'Clothing', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser11', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ydy653404', 'Product14', 'Sports', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser18', 'Available', 'images/608a7ebcb42924.31420860.png', '[]'),
('ymo277469', 'Product46', 'Electronics', 'Sample Description', 'Sample caption', 1000, '2021-04-29', '0000-00-00', 'DemoUser24', 'Available', 'images/608a7ebcb42924.31420860.png', '[]');

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
  `Rating` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{"Rating":5,"NumOfReviewers":0}' CHECK (json_valid(`Rating`)),
  `Review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`Review`)),
  `Status` text NOT NULL DEFAULT '["Normal",""]',
  `AccountBalance` int(11) NOT NULL,
  `LoginCount` int(11) NOT NULL DEFAULT 0,
  `ProfilePicture` text NOT NULL DEFAULT 'profilepictures/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `DisplayName`, `PublicKey`, `Password`, `Email`, `FirstName`, `LastName`, `DateOfBirth`, `ContactNumber`, `Address`, `AccountType`, `PrivateKey`, `Rating`, `Review`, `Status`, `AccountBalance`, `LoginCount`, `ProfilePicture`) VALUES
('DemoUser0', 'Demo0', '0x5015c4CCb0a812C44bFFcB69e2D0d31422599A8D', '$2y$10$xYCXwoDh0exmIaOuaAT9IeJagRimDy1a6YO1x.Tk/X4pq3VqNUk3i', '0User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Administrator', '0xb9dba28737a50c5c08a7b37b344915c451ea2832c53e6e14ab76b6ce2ae279df', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 1999420, 0, 'profilepictures/default.jpg'),
('DemoUser1', 'Demo 1', '0x829cbE27525E5D60A3c4B9b09D9b3f27CEa2b582', '$2y$10$7LcALCP1fYorP55lGzBlP.qXe1Hmz4H83EJrtz.6JHHi0hrF9wQZ6', '1User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Administrator', '0xb84a33308ad07b1e19a2ce88e267525dfccfc097e0046d0b427fe97073af08d1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser10', 'Demo 10', '0x4946Ee1843dA9900cbD44f5735D02FF0Ca604455', '$2y$10$E0oXBVVPLf2rhXnZMB3UCervukZWwvH0cmUp9TDw4qJHWIChjMUF6', '10User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Administrator', '0xefaaf13d5c800d2babe60d0230a8040ba568d9b4521f017a08e8094ea36387e1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser11', 'Demo 11', '0xDe2DC35Fb0cFb83368f84321C180F6837ae05594', '$2y$10$.kRfnTwWhjFa6KMnnEqJre98YTdTF3WvXkkZ00pRraq8ktmZiEKZy', '11User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x870f07ec2a0a938d467b2d471dc650571013ebdc92cab2f04e96ec5828028eac', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser12', 'Demo 12', '0xA9Fc340d57e2fb968cF5F4c5dF47dbB0A0D57003', '$2y$10$G8mF0UBiw1gqBc.v0.oG0.3pFDcjQGkCrTzM.qrngO82JRBM4wdnC', '12User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x498df18349b0b32a1b8b2a48d393955bf529648f5a99bc4730875eafc1f5bf0f', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser13', 'Demo 13', '0x24EE50f9ff0EaB90792edb8cA9c39ec7f601f5aa', '$2y$10$rODhDdhu.k4v6ilpntLGv..jRo4xQpZJzwifkg3x6Xh04gJyyeUFC', '13User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xb7dd5ce50ba4091c5e39277da6a90d8a1e892e5c045f5943e3e0affc0352d134', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser14', 'Demo 14', '0x445eF169b49C82bb249AfBc3c35624052685B979', '$2y$10$IHsphheXwec9SjAUp4rbTO49DsvcijkamzLeWanmXrDx9/QwSQKHq', '14User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xf857ac805427da6db76fc340480f2c81a3d62c5107e68b267f2647a78c77d505', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 1000580, 0, 'profilepictures/default.jpg'),
('DemoUser15', 'Demo 15', '0x5a78414B579eB7E554a941c450eDCAD01bAc74B5', '$2y$10$sHxdp1RCwCofvPFQ.kWjJ.5RXQqLJ8eSpIAaWhvZEe.srTdVDtavi', '15User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x8839fc04577c6da12a973632828dde0bdb6244f93d15c81f050e36970e521e05', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser16', 'Demo 16', '0x76f71626C2b9Fa5D7784031798B25ea5405f34de', '$2y$10$oTf/JJf3ki7PSaI0vBv1q.WqOdAG8VHZJy9ZIUax0jnsWLLPbFQAO', '16User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x1f8060ce9b750e4783754427f922062a3fa88b4930cdd82c084c3d937d1f7f68', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser17', 'Demo 17', '0xF3C01e9902e7fEd8882C16126495e5210096170c', '$2y$10$N2rFTDtboQVKTW6kOW.Tp./uoDUoYBBt0oZYg7LamV0cYbViFYqBi', '17User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x58f7976b61653ed7ce2dddf667b6fa142035f5e96afa0f67c371188903fd75aa', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser18', 'Demo 18', '0xDDE441655619d0b1e49049B844E163D805707985', '$2y$10$RtvXJSosEosFOn4tPnxS5ezc7x83EvkAtyfDcSl3ynY3nZwOEozPq', '18User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xf9a9ca5378013f058617b3e11094446bea802a481dcfbf24002ff871b442bd3f', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser19', 'Demo 19', '0x4c39071260297D983B60fcDd958785b2F462dd67', '$2y$10$HlB7JqIGHF1lYFSAK6MBAuGcgv6g41/p62E6KYbzd9bRCA6rPQJV2', '19User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xc86603da194858fa8a1c1ff0ba700e67dca0620279a0cfff69450eaecf836614', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser2', 'Demo 2', '0xB8182F11a85F378EeB51Fd15C1E40B7f6BDe9F1F', '$2y$10$IvBi1bXQZJq4ejb7q9Oic.lN.tRFUOVcm8q7EyCArxYyPbjCiKMzC', '2User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x621717b68098b28d30754222f73a9ddbf713b261f1dd2f52bdb861623ba18dc4', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser20', 'Demo 20', '0x7F46753565Fe5D242D04e77417446ee39425367f', '$2y$10$Uk7zHYVr6Vf1fwHVvYwtAuJBt5LsdBH1Q42webBSUXJEGHYX3rC86', '20User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x87ae3aa4400f71dc6379f862ae7bebc9b2d59e5f0e498227bb6b1e3c705c3e61', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser21', 'Demo 21', '0x3f8305607C4b04c9ab789d91832F63A76A26112f', '$2y$10$ChEFJnC5o6UwrWTuSGHGZeCwyjZ7gWR4CRNzVIqTRop/Kfc4FG9ju', '21User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x43bcb5fab612cf482fcafd49d76d97ee46118443366bc3d0efc1652a2b0aa5eb', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser22', 'Demo 22', '0xF0FEDd980AABC8fba2D334C2f55De9541F7A773e', '$2y$10$16iD5Is7KlRBAn/RBq.ehOARptOb3p0szzA4YdVS34rg36qzeivzu', '22User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4cc975543cffacb44f9f300ff419c3a20ff501511585b74102cf0ee1056e5d77', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser23', 'Demo 23', '0xEB2Dd6508884f44d2Df9303A7a06D1847DB1305b', '$2y$10$1TbbZScnzN.NEcC93OWWk.9yznDn24GI3n6N94Ye8p4JolHumX26K', '23User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x0d3b3cad1179f94a8c57ad6138901a044629fc4fe6d6fc6d6184cf6188fdb0cf', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser24', 'Demo 24', '0x8e9749fe2A2428781c934768C5c44d19880C61BC', '$2y$10$MFsw5VYN9Ul8qvQQFu9sYeO8rI7Wci1M3De0jH3Do7GLgYQU2B0WG', '24User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xd0cb2876ec13c254d3a24d326648ab8f632d9d344f1a3b855d3d453323c83b31', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser25', 'Demo 25', '0xBA384a32Fc3fDC9d07876dE6050e708F5631BbAD', '$2y$10$i6eU/N8oqET5XHB/DN6F2.h5ygTBmVe.stKcgH6eVAS/fbvHoc5nm', '25User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xffa6f6d143d5bb29869af76256eb0d51e979313a52047e95e92d5c8243b8614d', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser26', 'Demo 26', '0x415EE159A02e4981868287d6bC0147548256477f', '$2y$10$vsYrVnlSN//Ac48dzdEVVeWhvSCHlu/uEJrdjkhhyYaIH6kKenQG2', '26User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x65fa782b4f7c999175a266d73d1486da1f9e42437a9a02fe3e63b6f054148fef', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser27', 'Demo 27', '0xeeA0f908F5140e06636741519361F4020Eb47194', '$2y$10$VyHHDxbAjgufII3xdL4k0OgYptA/DtgKzUGM7ZFsy89Tbh1AcHCTC', '27User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xab94f71391a2a10caf8f76e8a23a042c1e11a123e661932066ff8754704958a0', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser28', 'Demo 28', '0xf3d8b89e2aa0d26eD241A101436134dA31A15698', '$2y$10$nmCTnf8tIE99Jw.xo.YM0.6wJdlUfxrGjb4eamx7Hn5aMzi8za0ki', '28User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4608a3969a175760d46479bf6301a774b53ebda7e95501d903860fa46f324373', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser29', 'Demo 29', '0x157EbF951829fc4D1631Db9deF4af493A03BBCA2', '$2y$10$B/2E5YPzmV8u1Gy1L6s6EOD5.J97grErvGoi4wH1WU2iHvA8FM/Ju', '29User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4e004d0d42219f59ba614721b6c6f75cc48b4ba00601fdc6f3f79c62a2e20fe8', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser3', 'Demo 3', '0x5c51A4F1C770ad89244B4298DECCbe850bdF6b2E', '$2y$10$oOpdIOCNnaiHFddZ.n8CAucuhFb6t8LpxRDpRCe/XnaFMXPxwWP0e', '3User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xee0831479ebbb9247fef40c9d4a609ce4561a1c42d4d35da1b8eb5f99e6f0ddb', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser30', 'Demo 30', '0xf2976D51cC77538170b31f0b48fc6E1534Adc3c8', '$2y$10$NECJ1DZYBhsOI.OrZe.NVejFlqhn30NgBu9owy95NAaIuEuN2FPmu', '30User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x21e750379c64c4cdc5d7285bd5cfd63ec403b29a2268ec9e1b5001dee740e23e', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser31', 'Demo 31', '0x29Dac6F91439E8bF5cFf2022fC79092eDe3BD28D', '$2y$10$tt2BcEESwcVojOnwUd4xbeWupxYoQ/xgLHrNyDTVK.1OAd5gqGRAG', '31User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x574aede7ffcccfc7b90598b497904cc01c3f8a2166dedf949663b2c1db98af84', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser32', 'Demo 32', '0x5D8D50d00CB274c373D79D00Ce4E0e2B970A9353', '$2y$10$DVoL2Ved1VuXP9hOKpDsqOBwmcv.eo4ygSuuAJ0cliJbsxsE5hJQ6', '32User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x2e360f0d74a6ecedb2d8e06e95c998c37b49d5abea70f7cea84af51397f417b9', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser33', 'Demo 33', '0xB9351697a04dec1882A8F1c959567b6C6a694f0e', '$2y$10$yaTwrv8VJRmW8COX1mpfduJwP1U6f01cfZMyRtK2T0f9nJAFFdZ1O', '33User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x6e2be937d833b24866bfecb15e870ddf8f6093f6bd65575c2ab3c7bf5bd71211', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser34', 'Demo 34', '0x6A3450deA4d8Ba8B1DAB2536c7dcC2169B62aBf1', '$2y$10$EgOXdwBIhnclTkNx8zogHesJdws4M0/BLNMy4AcI56.6rwhxHW9F2', '34User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x3e080024d7f5bd28ccd8b436e305f899db1f046a7c416d2ccbb8f9c4781e61a9', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser35', 'Demo 35', '0xEb7d61a930897A14E497dF20693cA927E511e4cD', '$2y$10$6IoE72hBbAdKE1Y8cg4wuOTe3sKjgvB8sCCV6GmQExNowVFBIHJnS', '35User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x2e8e2847758a7c9f328df74e41884544b4442367abcdb54421e4b6715c9fef10', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser36', 'Demo 36', '0x9f99AF5423764A0C894Bf9f1986b102279f2f303', '$2y$10$5k/dlS99kG6I/LBQGtmhTOHbdCBBo/RHTbOpPdmgq.OIsa6evCOUu', '36User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x3851a3253e1e16f9bd538130c09ea31bf1217c803627d368086c5747cce8f0a1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser37', 'Demo 37', '0x3242C66A495806577d82f5ed3274e833666Bf945', '$2y$10$f8QoB793sZzhSSPPqAjAxubmTAHM5912470INk7eLg9jF9OxvLYuy', '37User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xf64ed8d513a408426b69bae40ec11a80e165f36dc2c1bfbde87f45d7d8cc42e2', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser38', 'Demo 38', '0x4FDb697870423b2989C2aeC2071C6F19dDCBC71A', '$2y$10$IHTepj69BI7ev8czkj7g4eWerxHN11ZCq3NSjbi7t5RkW/Qxru/4O', '38User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xd03f6933371760fe0214e90880dbeff9ab9f5bb010069b8e80c1ad87d902d788', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser39', 'Demo 39', '0xc431532C8C87b4292d4e71bdd1E436c468335cBE', '$2y$10$V5Qm5odibvuZf5adIilyhOKvYJdj7ZGC/eT0mXG0tV0JEW7A4QiT6', '39User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4ccb3c9d231ee0e22583e75837f1b94c8c4182ca7904f5aaae6d44a67e26c5bf', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser4', 'Demo 4', '0x7127394714b4727283868D6dD1106DA73B90844A', '$2y$10$/c1dz./wBTqJ8gV3TmTmo.Z/3sXUEvSwxkFVUwNifDUmMYbdzFzmm', '4User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xbaf46d03d03f326f617ddf90777126b8d3ae5fd75c6307f5ff4eeb7069c47890', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser40', 'Demo 40', '0xFb7881795F5f7D34331a1C464d71d94eFcBebE77', '$2y$10$AzEAbrMd2vTh19wds0efbeH1xfO5Oy1NPPdgJ9PYSftKO.BFd1L1i', '40User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4e1159408b06a69533b41d82f02421af532b4f10f41b4ce1ccdfbb43fe0d8168', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser41', 'Demo 41', '0xD47414be3Ff8f68BB2Aa3C4f21c796820B0D23d1', '$2y$10$DV7Z/oIayioMPaUzojniaOLc43rNydDqCSADPtZfQuvaOV4FCgDbq', '41User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x70b35e13981d22c6d284a90ac057bc5dd31b3e7055de933e0ca69d79223dbbee', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser42', 'Demo 42', '0x682979041687BD74eb925C24646Dc413EBc67403', '$2y$10$M6lzgaXSd6d81ndxISlEteyExwuDWTxOhIStN6G0BsIm8iGy6pUb2', '42User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x0e1f85e376b5c2c84acdf1e99459c1399c8b971cec5e9bfedc581af472002497', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser43', 'Demo 43', '0x07c13D2d39905CDD01c72b9A9559BA54CEAbaA5d', '$2y$10$u.FyEkRVprmxCp49pOfKPe0zXspemtoBs2DuzMVSVdcekSz8rCTdu', '43User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x7a2ea09b04f1996c68575abf4d42fe2db8ac36ff27f6496f6f800ce0b1f100b5', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser44', 'Demo 44', '0x799b8840fDb6c0cdE41320D84D0b5D56F4Bad610', '$2y$10$Oyxf0HHtUoZlTgqkJYg9lO5SmR8ATZpXphEtd5nhxnmdvuYDgbEYe', '44User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xa2d6b226b990be9cd5619b0a317eff121d30a4aaf47ca4e397c84dc43ee46108', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser45', 'Demo 45', '0x053dA6FF4130cb157A89624349BDcd7d32402a41', '$2y$10$qfi2A0ODRFFjYQd4qobztunnyRW9BfSPqIL1.y4tRV.vO9drQpREy', '45User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xa41cb3eefa12ab0c22d1d00222e0c1c3cdea89cf841422c6ef1ded8ad1667f54', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser46', 'Demo 46', '0x1993a8C485513C63923693E565638a2D65FF8f89', '$2y$10$K26rELs6qlYAdryeDGovcObPi2EuXBHYBIZ8uvhflpWP5Mte4oDhi', '46User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x86eec079fdc614125b562ba268c181c627007bca849252315323f288688b5b95', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser47', 'Demo 47', '0x922c6173Bb0e7056fC4339Ac660A845C28f427bB', '$2y$10$mufltiylcis/S/zOD6CzZeyRZ6rrhzMyhRbdRyd07Z3RJ462IxQha', '47User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x59fc080b7b2bb2556ede8f9ef640b386f4609b05e8daaae4e7393ec2d9c117d5', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser48', 'Demo 48', '0xE7a89e42D6cD5F23aF27f216bd77A09d07778E3d', '$2y$10$5lHhwizTwHVOfIjw4Y5cI.i165zVStQPNs2Nopl6N6aLHJMgkgqIO', '48User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xa6fc2423df0d8d138c2ea4925bef0b2e6211cfb77daabdb1dc5cf20740887618', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser49', 'Demo 49', '0xFA40Ac42809FC0A7D5130687F149F9ff760EE011', '$2y$10$y0DSFlZwTU6zSdfYXWPw/.plWs0WcM4YrnTsIcAAiHhnrxmnGuh4e', '49User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x993bd0e3816e235ec926fda773e233673ddeb67ee3788638159d11df449cafc3', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser5', 'Demo 5', '0xcAB98b6E8D24C962e7CC091ad194BAb563Acc502', '$2y$10$mi7.oo9CW1tLQw5I9ZhsQuo.De4hHkVofWJ1WvhHcooW7EfFU10iW', '5User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x3614953c113faed0b832fbb598ecf665ceff01d2722284b025aef280004832d8', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser6', 'Demo 6', '0x8686Ea677F29C7a6D8A8f714af3A7b3aE18b371b', '$2y$10$Ln9a4rAMTymQrFOgYU7RA.utf6IuSqvK50I8lDX.q1kWnbgGeKtEG', '6User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x319415870a13631b1b1a80cde359071a463bf518f5746d404f936f480e63b6ed', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser7', 'Demo 7', '0xd939Ea1757A2F38fa8351713905A47991B597A0A', '$2y$10$5.puqdmddkAdbnZMhd6es.vjalUyueb/ScHnAX8rAl4DxDYILg2FC', '7User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x43f2d30642502067b7445dfa6a21d9b2ef8bfb98d6db1912e21f0c9b4c1dc1b4', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser8', 'Demo 8', '0xFd7948b67dA97ec40D369ab3D3c086a317b370dd', '$2y$10$VZJ/xa/8.qf4RNMWcyJJseAd.gf1wyVTnxTmHaHScfzchRWr.wKaK', '8User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x9884b90bd6f3e6cc0be875b22fd80525481a77d032e23147ee2cb565ba5535d1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('DemoUser9', 'Demo 9', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '$2y$10$9iDj9herg.XtSSPo.cVN5OFu2Fir4D7cXDdHkXO1rhSjvcr87P4vi', '9User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x5bb7bed7ea41848af9a722b47bbd03463ec35a47faffc36dfe208da85b663be3', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('Escrow18', '', '0x73fA385076B6e9BEA157Ba6e507E922c2951Dc69', '', '', '', '', '', 0, '', 'Escrow', '9fadb3c63d66140740461f300f6f65ef0f5f0a3611e72303cecc44e88789e734', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg'),
('Escrow33', '', '0xc280F7B7DfC6427add5f42C9E1D02aC9F524aD00', '', '', '', '', '', 0, '', 'Escrow', '99fc8e13193cdd7c95d3791f863a918ff22c2646612191a57990054f7f139b43', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`ContractID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
