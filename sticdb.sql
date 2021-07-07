-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2021 at 02:25 PM
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
  `InitialOffer` float NOT NULL,
  `NewOffer` float NOT NULL,
  `Status` text NOT NULL DEFAULT 'Pending Seller Reply',
  `Payment Mode` text NOT NULL DEFAULT 'Half-STICoins',
  `TotalAccepted` int(11) NOT NULL DEFAULT 0,
  `Transaction` text NOT NULL DEFAULT 'Negotiating',
  `Message` text NOT NULL DEFAULT '[]',
  `RatingToken` text NOT NULL DEFAULT '[]',
  `Reported` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`TransactionID`, `TransactionOpenDate`, `TransactionCloseDate`, `ContractID`, `BuyerUserID`, `SellerUserID`, `ProductID`, `DateRequired`, `InitialOffer`, `NewOffer`, `Status`, `Payment Mode`, `TotalAccepted`, `Transaction`, `Message`, `RatingToken`, `Reported`) VALUES
('[[\"0x3fde08ee73641c0eb5c00dd1f50037bbdee20cbf8e8ae8dc9516796034b61f17\",\"25-05-2021\",50,\"DemoUser9\",\"DemoUser36\"],[\"0xa50d846d1568a072cb43390ab7ee7b8d577be829f943b3e5f50083eb6a9efc00\",\"25-05-2021\",50,\"DemoUser9\",\"DemoUser36\"]]', '2021-05-25 17:33:46', '2021-05-25 00:00:00', '085965108783sta602117', 'DemoUser9', 'DemoUser36', 'fba99287', '2021-05-29', 1000, 100, 'Transaction Complete', 'Half-STICoins', 2, 'Complete', '[]', '[\"DemoUser9\",\"DemoUser36\"]', 0),
('[[\"0x67821a74a461b0eb4f90f5c5c4d36a3da9f8e302532edb39d72195f6da7c5909\",\"22-05-2021\",0.0003057748640830729,\"DemoUser9\",\"DemoUser36\"],[\"0x100bb5ab7b55db7f1a5dbb5313ddc4dd529d0bcb29ebef53120243f212f3e083\",\"22-05-2021\",0.00015467282058262159,\"DemoUser9\",\"DemoUser36\"],[\"0xb3c6cdd38eda51e73e3d79d3a88fb77e6880a4ed75b71fe3662c4fffdd1b0787\",\"22-05-2021\",0.00015494219106851234,\"DemoUser9\",\"DemoUser36\"],[\"0xd5f56c7217cf85939bc968de9d400c98e749182f7ac1732464e84e53d5259ee5\",\"22-05-2021\",0.00015494219106851234,\"DemoUser9\",\"DemoUser36\"],[\"0x1a55236221bdd786be1908a99a580b73e1224ac8b217b61df38f42c74b290491\",\"22-05-2021\",0.0001558404318650048,\"DemoUser9\",\"DemoUser36\"],[\"0x444459aaa923e6d11fb878564f6c0e8d5950f713392767bac43c5a486aa7a61d\",\"22-05-2021\",0.0001558404318650048,\"DemoUser9\",\"DemoUser36\"],[\"0x3199e802c9e5ca384e6bdd6e3c3d5455ee8ed184cd0c8e534db46d67632e438b\",\"22-05-2021\",0.0001558404318650048,\"DemoUser9\",\"DemoUser36\"],[\"0x9ec82d6706121174cf90123deaaa61e6161974b0f2c7fc375baed3e78301caf4\",\"22-05-2021\",0.0001558404318650048,\"DemoUser9\",\"DemoUser36\"],[\"0x4de4abfc98994cdf6ebbacaa2066dca33eb0b765aca993f63cde3eb22d9d2535\",\"22-05-2021\",0.0001558404318650048,\"DemoUser9\",\"DemoUser36\"],[\"0x59e3c9bafbfcaa9d9de7c80fb6d14833920a56ad5b15b520678197f4c7af1776\",\"22-05-2021\",0.00015757113548911655,\"DemoUser9\",\"DemoUser36\"],[\"0x4851118b6d73580bd4b81105a63ee848bb7e9af64bc3a871ed44210b76e45e8d\",\"22-05-2021\",0.00015757113548911655,\"DemoUser9\",\"DemoUser36\"],[\"0x67ad13f9aacdfbd7a44a8fe7ac6c3804bcce4bef1fbd44192d384dee436707fa\",\"22-05-2021\",0.00015757113548911655,\"DemoUser9\",\"DemoUser36\"],[\"0x03cec7b630d3261518540dbd4f3f7c9834136b787b3ea22919ff5e4b58370de8\",\"22-05-2021\",0.0003151422709782331,\"DemoUser36\",\"DemoUser9\"]]', '2021-05-19 23:36:30', '2021-05-22 00:00:00', '141313656016qpb197114', 'DemoUser9', 'DemoUser36', 'fba99287', '2021-06-05', 1000, 1, 'Refunded Transaction', 'Half-STICoins', 0, 'Complete', '[{\"Message\":\"as\",\"User\":\"DemoUser9\",\"Time\":1621653713,\"Type\":\"Buyer\"},{\"Message\":\"asd\",\"User\":\"DemoUser9\",\"Time\":1621653730,\"Type\":\"Buyer\"},{\"Message\":\"ds\",\"User\":\"DemoUser36\",\"Time\":1621653737,\"Type\":\"Seller\"},{\"Message\":\"has refunded for buyer.\",\"User\":\"DemoUser0\",\"Time\":1621654226,\"Type\":\"Admin\"},{\"Message\":\"ad\",\"User\":\"DemoUser9\",\"Time\":1621845495,\"Type\":\"Buyer\"}]', '[\"DemoUser9\",\"DemoUser36\"]', 0),
('[[\"0x8cd0019e5007a627652feb6cd887680f9c88e4295dedcca629b2b6e130fbd8b2\",\"25-05-2021\",3,\"DemoUser9\",\"DemoUser0\"],[\"0x4b5dba803bdc5a1aac94e2e581e6ab25c83384252084c64cd9c16b045f5e28cc\",\"25-05-2021\",3,\"DemoUser9\",\"DemoUser0\"],[\"0xc96495bfb11ea737e832d1d39194076df980939f6c43bcdb14e57a0ae80bac61\",\"25-05-2021\",3,\"DemoUser9\",\"DemoUser0\"]]', '2021-05-24 16:09:58', '2021-05-25 00:00:00', '227966430763jwi691020', 'DemoUser9', 'DemoUser0', 'xhz774290', '2021-05-28', 123, 6, 'Seller has accepted service', 'Half-STICoins', 1, 'On-Going', '[{\"Message\":\"hm\",\"User\":\"DemoUser9\",\"Time\":1621845458,\"Type\":\"Buyer\"}]', '[]', 0),
('[[\"0xcb63dbaa1d4c2315f93f2ef0a31cb680ba60e473f3ed9068ec8200d5b8c6bf2e\",\"25-05-2021\",25,\"DemoUser9\",\"DemoUser36\"],[\"0xa938861caeb35e56b0cf7de0e1072b07757a4e5340d3556f91731960f52ccdad\",\"25-05-2021\",25,\"DemoUser36\",\"DemoUser9\"]]', '2021-05-25 11:49:42', '2021-05-25 00:00:00', '245623535669jod73289', 'DemoUser9', 'DemoUser36', 'fba99287', '2021-05-28', 1000, 50, 'Refunded Transaction', 'Half-STICoins', 0, 'Complete', '[{\"Message\":\"has requested refund\",\"User\":\"DemoUser9\",\"Time\":1621914854,\"Type\":\"Buyer\"}]', '[]', 0),
('[[\"0x9f2fccc4a78bc72f64b8881995c3ffa502439c81751064dd281c7ab79db7f214\",\"25-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[\"0x0a12c7382c6a32ac3cb9a3f2001cb457b0030b936ce7625ba7b221f83860d63b\",\"25-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[\"0xe50bba712ac59d1f4382b6dd2cad4c790d7eb6ecb2f65d4069fa7536278eb2a2\",\"25-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[\"0x9ffc84576f8138e03df288f42adedcba700263e6505241a39e7964b3425d57c5\",\"25-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[\"0xb0591609bbedad5b5a3f943f5549a9e51ddad755094f3b36e1548bc7e34b3567\",\"26-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[\"0xa2203c1aa551f4cba66d2af3312501155c2d13a1837eb084387b73ce6d3f9534\",\"26-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[\"0x3f55d835f52bff6c0c8dc42be7dfd368a61f56255a38119c80e970c42545d278\",\"26-05-2021\",2500,\"DemoUser36\",\"DemoUser9\"],[null,\"26-05-2021\",2500,\"DemoUser9\",\"DemoUser36\"],[null,\"26-05-2021\",2500,\"DemoUser9\",\"DemoUser36\"],[\"0xa4f2690ad2d3c2bfdb3dc55b1ccd1ad5d888142297b8a015155c66f16520d1f4\",\"26-05-2021\",2500,\"DemoUser9\",\"DemoUser36\"]]', '2021-05-25 17:55:23', '2021-05-26 00:00:00', '615142112162cft899657', 'DemoUser36', 'DemoUser9', 'qiy4456', '2021-05-29', 1000, 5000, 'Order Cancelled', 'Half-STICoins', 0, 'Transaction Declined', '[{\"Message\":\"hi\",\"User\":\"DemoUser36\",\"Time\":1621936797,\"Type\":\"Buyer\"},{\"Message\":\"hi\",\"User\":\"DemoUser36\",\"Time\":1621936800,\"Type\":\"Buyer\"},{\"Message\":\"asd\",\"User\":\"DemoUser36\",\"Time\":1621936801,\"Type\":\"Buyer\"},{\"Message\":\"hi\",\"User\":\"DemoUser36\",\"Time\":1621936804,\"Type\":\"Buyer\"},{\"Message\":\"hi\",\"User\":\"DemoUser9\",\"Time\":1621936813,\"Type\":\"Seller\"},{\"Message\":\"has rejected the offer,Transaction declined\",\"User\":\"DemoUser9\",\"Time\":1621937065,\"Type\":\"Seller\"},{\"Message\":\"hi\",\"User\":\"DemoUser9\",\"Time\":1621999629,\"Type\":\"Seller\"},{\"Message\":\"has cancelled order.Sorry for the inconvenience,your amount will return to you shortly.\",\"User\":\"DemoUser9\",\"Time\":1622008044,\"Type\":\"Seller\"},{\"Message\":\"has cancelled order.Sorry for the inconvenience,your amount will return to you shortly.\",\"User\":\"DemoUser9\",\"Time\":1622008404,\"Type\":\"Seller\"},{\"Message\":\"has cancelled order.Sorry for the inconvenience,your amount will return to you shortly.\",\"User\":\"DemoUser9\",\"Time\":1622008597,\"Type\":\"Seller\"},{\"Message\":\"has cancelled order.Sorry for the inconvenience,your amount will return to you shortly.\",\"User\":\"DemoUser9\",\"Time\":1622008680,\"Type\":\"Seller\"}]', '[]', 0),
('[]', '2021-05-24 16:32:01', '0000-00-00 00:00:00', '741735409976wiq26156', 'DemoUser9', 'DemoUser0', 'xhz774290', '2021-05-27', 123, 5.6, 'Pending Seller Reply', 'Half-STICoins', 0, 'Negotiating', '[]', '[]', 0),
('[]', '2021-05-24 16:10:59', '0000-00-00 00:00:00', '805524999496iaw227239', 'DemoUser9', 'DemoUser0', 'xhz774290', '2021-05-28', 123, 6, 'Pending Seller Reply', 'Half-STICoins', 0, 'Negotiating', '[]', '[]', 0),
('[[\"0xc8e9a6e620e26bc34dafaa29076fb9a00cc6cc7d09c875434f863c36cc3a32e4\",\"25-05-2021\",4000,\"DemoUser9\",\"DemoUser36\"],[\"0x4c95a7c0913ea4b57c57ee0505d3f811b95f6073a191ba4bba9216f47fd01714\",\"25-05-2021\",4000,\"DemoUser9\",\"DemoUser36\"],[\"0xb381d67328de03ec800a45039aa1724f2bf9422f3274ef9224e17b30dd5e86f8\",\"25-05-2021\",4000,\"DemoUser9\",\"DemoUser36\"],[\"0xff0d4c96937e8bd934fcd3c446974408007f99c27e7cdd6018e5999c1049024b\",\"25-05-2021\",75.1,\"DemoUser9\",\"DemoUser36\"],[\"0xf6bfc35ed9aabaab4aef226dce75634331f34c1c27a4cec73000dec9187d54b9\",\"25-05-2021\",75.1,\"DemoUser9\",\"DemoUser36\"],[\"0x102ce8f81c30509e33867e438322cff2862fcdbc690c10a5dd35aad2c06f3683\",\"25-05-2021\",45,\"DemoUser9\",\"DemoUser36\"],[\"0x83439e308fb66e002f952b723af7a023ada60a811742690d0cf42a93a035b503\",\"25-05-2021\",45,\"DemoUser9\",\"DemoUser36\"],[\"0x32128a1abb17fc6e632fccdaf95f23f50a2bd56fb0072f7ff251676641e4a56a\",\"25-05-2021\",45,\"DemoUser9\",\"DemoUser36\"],[\"0xee12bdc27dd2a079bd04687e7485c3fbb16cf856ee8d18421dae338f666215b4\",\"25-05-2021\",45,\"DemoUser9\",\"DemoUser36\"]]', '2021-05-25 13:51:50', '2021-05-25 00:00:00', '839465748438ffh172318', 'DemoUser9', 'DemoUser36', 'fba99287', '2021-05-29', 1000, 90, 'Transaction Complete', 'Half-STICoins', 2, 'Complete', '[{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923702,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923702,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923703,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923704,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923704,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923705,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923716,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923716,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923716,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923799,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923802,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923802,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923873,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621923910,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser36\",\"Time\":1621923940,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser36\",\"Time\":1621923941,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser36\",\"Time\":1621924118,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser36\",\"Time\":1621924120,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621924153,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621924231,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621924240,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621925065,\"Type\":null},{\"Message\":\"has updated the offer\",\"User\":\"DemoUser9\",\"Time\":1621925065,\"Type\":null}]', '[\"DemoUser9\",\"DemoUser36\"]', 0);

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
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `UserID` varchar(30) NOT NULL,
  `Password` text NOT NULL,
  `Attempt` int(11) NOT NULL DEFAULT 0
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
  `DateOfListing` text NOT NULL DEFAULT current_timestamp(),
  `DateOfExpiry` text NOT NULL,
  `SellerUserID` varchar(20) NOT NULL,
  `Status` text NOT NULL DEFAULT 'Available',
  `Image` text NOT NULL DEFAULT '/images/default.jpg',
  `Review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[]',
  `Reported` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductCategory`, `ProductDescription`, `ProductCaption`, `ProductInitialPrice`, `DateOfListing`, `DateOfExpiry`, `SellerUserID`, `Status`, `Image`, `Review`, `Reported`) VALUES
('ajy466961', 'Product36', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser2', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('awq984529', 'Product18', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser2', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('awu610781', 'Product20', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('bgm371258', 'Product13', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser9', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('bjo961187', 'Product25', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser9', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('brp906940', 'Product39', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser36', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('faw629282', 'Product4', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser26', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('fba99287', 'Product27', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser36', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ftu83814', 'Product11', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('gan361250', 'Product19', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser28', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('gsx206686', 'Product28', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('gxl439323', 'Product3', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser16', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('hhr38974', 'Product34', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser6', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('hnx704591', 'Product45', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser13', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('hwm781345', 'Product30', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser44', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('idy466641', 'asdasd', 'Home and Lifestyle', 'asd', 'asd', 123, '1621421595', '2021-06-23', 'DemoUser0', 'Available', 'images/60a4eda4b95745.87835773.jpg', '[]', 0),
('irt951699', 'Product35', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser5', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('iyh566961', 'Product24', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('jei928403', 'Product44', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('mph701253', 'Product32', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser10', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('nfd344457', 'zxcz', 'Home and Lifestyle', 'asd', 'asd', 1234, '1621421595', '2021-06-23', 'DemoUser0', 'Available', 'images/60a4e69335e333.96018939.jpg', '[]', 0),
('ngn499680', 'Product9', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser46', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ocj706659', 'Product29', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser34', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('oug589996', 'Product37', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser8', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ovo979683', 'Product12', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser48', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('phu871795', 'Product10', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('qiy4456', 'Product42', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-04', 'DemoUser9', 'Unlisted', 'images/608a7ebcb42924.31420860.png', '[{\"Review\":\"good\",\"ProductID\":\"qiy4456\",\"User\":\"DemoUser14\",\"Date\":\"2021-05-17\"},{\"Review\":\"ok\",\"ProductID\":\"qiy4456\",\"User\":\"DemoUser14\",\"Date\":\"2021-05-17\"}]', 0),
('qpy645795', 'Product2', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser39', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('quj844050', 'Product1', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser23', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('qyg937962', 'Product48', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser30', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('rhj239050', 'Product22', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser43', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('rjz32683', 'Product15', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser29', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('rpr29790', 'Product17', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser21', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('rwj221421', 'Product40', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser7', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('snd804616', 'Product8', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser14', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('stj701324', 'Product21', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser27', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('swd225097', 'Product49', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser27', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('tbf699236', 'Product31', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser40', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('tgs969702', 'Product43', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser41', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('tmx832910', 'Product6', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser41', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('txp205418', 'Product23', 'Music', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser1', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ugo562616', 'Product5', 'Home and Lifestyle', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser19', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('uik540740', 'Product16', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser7', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ukg639501', 'Product38', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser49', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('uyx055120', 'Product47', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser10', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('vth730596', 'Product41', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser29', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('wbb995946', 'Product33', 'Clothing', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser11', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ydy653404', 'Product14', 'Sports', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser18', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0),
('ymo277469', 'Product46', 'Electronics', 'Sample Description', 'Sample caption', 1000, '1621421233', '2021-06-23', 'DemoUser24', 'Available', 'images/608a7ebcb42924.31420860.png', '[]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `temporarypassword`
--

CREATE TABLE `temporarypassword` (
  `UserID` varchar(20) NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temporarypassword`
--

INSERT INTO `temporarypassword` (`UserID`, `Password`) VALUES
('DemoUser0', '$2y$10$hPVovkAMk7nFgqlCVTm6le/Zj7aHz7HEEBR3xe9MdpoVi9z/GRrvO');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransactionID` varchar(100) NOT NULL,
  `Receiver` text NOT NULL,
  `Sender` text NOT NULL,
  `Title` text NOT NULL,
  `Amount` float NOT NULL,
  `Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`TransactionID`, `Receiver`, `Sender`, `Title`, `Amount`, `Date`) VALUES
('0x02a63aabdfe614b16bbb763897e32a5bb8db1df16fd95ae660a03fa6c6a190f1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '0x886EE39B4E7a981A84D5e58d413B8700851e3Fe7', 'Top-Up', 18335.2, '2021-05-27 13:58:05'),
('0x039c84b140be1a35a99b2078f6218774f85199489c2b2b652c07cb5171e007bd', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 12000, '2021-05-28 18:33:13'),
('0x065795df0978cb22be90fb0073e9d7f31b496e1750e9e14674f31e7f3c0c8623', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x06a35242ddfc3e1d51ccd0d30016fa4c943e52a7e585982b0047bba19213101b', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 15:39:13'),
('0x089528f585de83d59eb65549aad08cd45fa5216ebbe01dff772735c7c9076b84', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '0xc97Ffb44c51Fb8f0aF365D324B580B3575Ed73ef', 'Top-Up', 3438920, '2021-05-28 15:31:52'),
('0x08eccec319ee5d730605c4469f7d90c2524a3d239e6c646ffe2e46e168162905', '0x886EE39B4E7a981A84D5e58d413B8700851e3Fe7', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 1000, '2021-05-28 13:45:34'),
('0x0df5b415bcb5cf1d1cc6e81191f1efbf6567c6ed184f4109be94402da2309a8b', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x145384a9bc9da244dd55550c8a3604c541976ad9861d1dec0dc26308a0b8f574', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x1d29757e4542fb490e7984b180fd92623038af11b580437f3653221e44a4f431', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:03:56'),
('0x23018373a898de6c5ac55f41b0dc1143d60f6b27e00126292f00f9a6ed5e4fe9', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x2e9fd014f64096b02caf5bca0b1a4bf9d17b5b1462a1261f3f617397fdfaccdc', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x3da1bda3b7d427b56f52f73454bab556dec8be80d9a4914360dd7c5ea9756945', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 30, '2021-05-28 18:23:11'),
('0x4c3ea3cf91f9bb8f35333ea9f491b996d03067b399a2438e466b010ae56f37b3', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x4cac2276cd30028d738994934fdb52b09e1291ca8dc28a449f4e99e7db125a3f', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 0, '2021-05-28 18:19:27'),
('0x6c7f235c0c249078d95216ab5a721cbfeb0b48cc57e5138d7a4ee5adc3232a63', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:19:07'),
('0x6f326bc969ed9c0f3909623eb2e56da34ae4b314be7b02d105fa1a16b696e948', '0x886EE39B4E7a981A84D5e58d413B8700851e3Fe7', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 1000, '2021-05-28 13:40:17'),
('0x6f3c3028b42b33d7e679575677fe91a381508f1999d213975736b4e604c4045d', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 12000, '2021-05-28 18:27:41'),
('0x6f6244c1375401d0a6a4c0e34ed095934335fe1b9df24694822da971cef25e1e', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 15:37:57'),
('0x6f64bdcc05a792bb3ea9c9cee3ee1f219b4c20912b418ec2e53cf4a29c39a389', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x6fb3b6a836b55d195cbe2188ebbbe2d9ffd754315206180d27c72446975c322b', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x7428a2ba7c5ab9f7e8371836c2dd60b3c34534e1ff019605e0c8148213a2e3d3', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:07:14'),
('0x7a676c42644150fbcb68fc5b882cee41f6d18e0b338ed35a4b31c9b3b3517a7f', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '0x7DeC7f19a5Cc44A09f92fb38B3E91A0389ca0505', 'Top-Up', 11100, '2021-05-26 19:29:26'),
('0x7cc4443181619f605f7eecd97986cf5fe1371b80c5b6729e893986d2afa677c1', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 100, '2021-05-28 18:11:37'),
('0x7cda93ce8d008c5fc0b5ef884911f3671cdce2134b0698d2d496708f7d8b1aed', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '0xeBf8A5F394374B388C916957ce5B2426dC7BEADf', 'Top-Up', 3417200, '2021-05-28 16:20:46'),
('0x865393a5319086b63cb12dde04ee33f5a15e40a43619f99e81a2fa139ff4a2b6', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:07:36'),
('0x97110e1ba13fced0cc894c1fe5eadab33b8770566ed10410bdde2336269244b5', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0x978cff7f41a35d3e2969ceba0c81977e084bb3fe078770d5af75faf23175349d', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:00:22'),
('0xa24c347f815b604407f4a7a2f25e9099305dd71d679a1b944d27379e109597ab', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 100, '2021-05-28 18:12:07'),
('0xa3555cce5eb8652ad5da17a476969325ce2115ad7de9b6a7f3c7d30b9a71df57', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '0x6BA6D8b8381EEA5eAbB7c19e8B2dcfCD00b07fA9', 'Top-Up', 3568, '2021-05-27 16:28:14'),
('0xaa58e3223e72fc814803f04c6c3847f2b9f6820124306dffa4ac3994c0985e13', '0x6BA6D8b8381EEA5eAbB7c19e8B2dcfCD00b07fA9', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Redeem', 8335.18, '2021-05-27 16:17:22'),
('0xabefa7610e89226ff4c72e1e3bbe1368ddbf1e66dec6344db9a62166f3f83dad', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 17:40:52'),
('0xafa8fd012e9e0a5bd754b4cf84094ce56a1f5b256b9242c02d7c23f9847af2ec', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 15:49:55'),
('0xb47ff02d05e469f8019cc24468a36ee863e5a301be444833652cdf970d734483', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:08:05'),
('0xb8de7d53649231b5f7982b3ff6d5efe99731f9232ae84ab4087105291d6c0b7b', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 16:26:37'),
('0xbfc35ad4778cfbc7feeca42ae91afbdefd9062ca6856b66cfba367005c087e2d', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0xca29020131c7f6f9f7a466e1afb529df0e096f8e8d108f4ad2d708a94b5d569e', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 18:33:13'),
('0xd60763fd6ec7b8c85b7993867c18a793c277602607fdaedfc6eba5c75268f6b2', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 15:39:01'),
('0xed0a784e730f411e77e02f26280e06b19c5e5a0d01dea32a7fa78c51a05add14', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:07:01'),
('0xfa4f736a169482d4a292549fb631ef616e433f090b78b96055718ed4ef0872db', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 250, '2021-05-28 19:00:27'),
('0xfca924f0d11e3d9230f4cff130edfec8dec5c6e9d599180130f21a6db486db59', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 30, '2021-05-28 18:20:08'),
('asd', '0xadcb06ED28846f938537A6072CED0951385359Ab', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', 'Payment for product listing', 10000, '2021-05-28 18:02:22');

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
  `AccountBalance` double NOT NULL,
  `LoginCount` int(11) NOT NULL DEFAULT 0,
  `ProfilePicture` text NOT NULL DEFAULT 'profilepictures/default.jpg',
  `Reported` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `DisplayName`, `PublicKey`, `Password`, `Email`, `FirstName`, `LastName`, `DateOfBirth`, `ContactNumber`, `Address`, `AccountType`, `PrivateKey`, `Rating`, `Review`, `Status`, `AccountBalance`, `LoginCount`, `ProfilePicture`, `Reported`) VALUES
('DemoUser0', 'Demo0', '0x5015c4CCb0a812C44bFFcB69e2D0d31422599A8D', '$2y$10$xYCXwoDh0exmIaOuaAT9IeJagRimDy1a6YO1x.Tk/X4pq3VqNUk3i', 'risv96@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Administrator', '0xb9dba28737a50c5c08a7b37b344915c451ea2832c53e6e14ab76b6ce2ae279df', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 9, 6, 'profilepictures/default.jpg', 0),
('DemoUser1', 'Demo 1', '0x829cbE27525E5D60A3c4B9b09D9b3f27CEa2b582', '$2y$10$7LcALCP1fYorP55lGzBlP.qXe1Hmz4H83EJrtz.6JHHi0hrF9wQZ6', '1User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Administrator', '0xb84a33308ad07b1e19a2ce88e267525dfccfc097e0046d0b427fe97073af08d1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 1, 'profilepictures/default.jpg', 0),
('DemoUser10', 'Demo 10', '0x4946Ee1843dA9900cbD44f5735D02FF0Ca604455', '$2y$10$E0oXBVVPLf2rhXnZMB3UCervukZWwvH0cmUp9TDw4qJHWIChjMUF6', '10User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Administrator', '0xefaaf13d5c800d2babe60d0230a8040ba568d9b4521f017a08e8094ea36387e1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser11', 'Demo 11', '0xDe2DC35Fb0cFb83368f84321C180F6837ae05594', '$2y$10$.kRfnTwWhjFa6KMnnEqJre98YTdTF3WvXkkZ00pRraq8ktmZiEKZy', '11User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x870f07ec2a0a938d467b2d471dc650571013ebdc92cab2f04e96ec5828028eac', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser12', 'Demo 12', '0xA9Fc340d57e2fb968cF5F4c5dF47dbB0A0D57003', '$2y$10$G8mF0UBiw1gqBc.v0.oG0.3pFDcjQGkCrTzM.qrngO82JRBM4wdnC', '12User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x498df18349b0b32a1b8b2a48d393955bf529648f5a99bc4730875eafc1f5bf0f', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser13', 'Demo 13', '0x24EE50f9ff0EaB90792edb8cA9c39ec7f601f5aa', '$2y$10$rODhDdhu.k4v6ilpntLGv..jRo4xQpZJzwifkg3x6Xh04gJyyeUFC', '13User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xb7dd5ce50ba4091c5e39277da6a90d8a1e892e5c045f5943e3e0affc0352d134', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser14', 'Demo1235', '0x445eF169b49C82bb249AfBc3c35624052685B979', '$2y$10$IHsphheXwec9SjAUp4rbTO49DsvcijkamzLeWanmXrDx9/QwSQKHq', '14User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xf857ac805427da6db76fc340480f2c81a3d62c5107e68b267f2647a78c77d505', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 998580, 0, 'profilepictures/60a1ff6695c095.61733867.jpg', 0),
('DemoUser15', 'Demo 15', '0x5a78414B579eB7E554a941c450eDCAD01bAc74B5', '$2y$10$sHxdp1RCwCofvPFQ.kWjJ.5RXQqLJ8eSpIAaWhvZEe.srTdVDtavi', '15User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x8839fc04577c6da12a973632828dde0bdb6244f93d15c81f050e36970e521e05', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser16', 'Demo 16', '0x76f71626C2b9Fa5D7784031798B25ea5405f34de', '$2y$10$oTf/JJf3ki7PSaI0vBv1q.WqOdAG8VHZJy9ZIUax0jnsWLLPbFQAO', '16User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x1f8060ce9b750e4783754427f922062a3fa88b4930cdd82c084c3d937d1f7f68', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser17', 'Demo 17', '0xF3C01e9902e7fEd8882C16126495e5210096170c', '$2y$10$N2rFTDtboQVKTW6kOW.Tp./uoDUoYBBt0oZYg7LamV0cYbViFYqBi', '17User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x58f7976b61653ed7ce2dddf667b6fa142035f5e96afa0f67c371188903fd75aa', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser18', 'Demo 18', '0xDDE441655619d0b1e49049B844E163D805707985', '$2y$10$RtvXJSosEosFOn4tPnxS5ezc7x83EvkAtyfDcSl3ynY3nZwOEozPq', '18User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xf9a9ca5378013f058617b3e11094446bea802a481dcfbf24002ff871b442bd3f', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser19', 'Demo 19', '0x4c39071260297D983B60fcDd958785b2F462dd67', '$2y$10$HlB7JqIGHF1lYFSAK6MBAuGcgv6g41/p62E6KYbzd9bRCA6rPQJV2', '19User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xc86603da194858fa8a1c1ff0ba700e67dca0620279a0cfff69450eaecf836614', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser2', 'Demo 2', '0xB8182F11a85F378EeB51Fd15C1E40B7f6BDe9F1F', '$2y$10$IvBi1bXQZJq4ejb7q9Oic.lN.tRFUOVcm8q7EyCArxYyPbjCiKMzC', '2User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x621717b68098b28d30754222f73a9ddbf713b261f1dd2f52bdb861623ba18dc4', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser20', 'Demo 20', '0x7F46753565Fe5D242D04e77417446ee39425367f', '$2y$10$Uk7zHYVr6Vf1fwHVvYwtAuJBt5LsdBH1Q42webBSUXJEGHYX3rC86', '20User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x87ae3aa4400f71dc6379f862ae7bebc9b2d59e5f0e498227bb6b1e3c705c3e61', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser21', 'Demo 21', '0x3f8305607C4b04c9ab789d91832F63A76A26112f', '$2y$10$ChEFJnC5o6UwrWTuSGHGZeCwyjZ7gWR4CRNzVIqTRop/Kfc4FG9ju', '21User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x43bcb5fab612cf482fcafd49d76d97ee46118443366bc3d0efc1652a2b0aa5eb', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser22', 'Demo 22', '0xF0FEDd980AABC8fba2D334C2f55De9541F7A773e', '$2y$10$16iD5Is7KlRBAn/RBq.ehOARptOb3p0szzA4YdVS34rg36qzeivzu', '22User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4cc975543cffacb44f9f300ff419c3a20ff501511585b74102cf0ee1056e5d77', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser23', 'Demo 23', '0xEB2Dd6508884f44d2Df9303A7a06D1847DB1305b', '$2y$10$1TbbZScnzN.NEcC93OWWk.9yznDn24GI3n6N94Ye8p4JolHumX26K', '23User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x0d3b3cad1179f94a8c57ad6138901a044629fc4fe6d6fc6d6184cf6188fdb0cf', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser24', 'Demo 24', '0x8e9749fe2A2428781c934768C5c44d19880C61BC', '$2y$10$MFsw5VYN9Ul8qvQQFu9sYeO8rI7Wci1M3De0jH3Do7GLgYQU2B0WG', '24User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xd0cb2876ec13c254d3a24d326648ab8f632d9d344f1a3b855d3d453323c83b31', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser25', 'Demo 25', '0xBA384a32Fc3fDC9d07876dE6050e708F5631BbAD', '$2y$10$i6eU/N8oqET5XHB/DN6F2.h5ygTBmVe.stKcgH6eVAS/fbvHoc5nm', '25User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xffa6f6d143d5bb29869af76256eb0d51e979313a52047e95e92d5c8243b8614d', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser26', 'Demo 26', '0x415EE159A02e4981868287d6bC0147548256477f', '$2y$10$vsYrVnlSN//Ac48dzdEVVeWhvSCHlu/uEJrdjkhhyYaIH6kKenQG2', '26User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x65fa782b4f7c999175a266d73d1486da1f9e42437a9a02fe3e63b6f054148fef', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser27', 'Demo 27', '0xeeA0f908F5140e06636741519361F4020Eb47194', '$2y$10$VyHHDxbAjgufII3xdL4k0OgYptA/DtgKzUGM7ZFsy89Tbh1AcHCTC', '27User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xab94f71391a2a10caf8f76e8a23a042c1e11a123e661932066ff8754704958a0', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser28', 'Demo 28', '0xf3d8b89e2aa0d26eD241A101436134dA31A15698', '$2y$10$nmCTnf8tIE99Jw.xo.YM0.6wJdlUfxrGjb4eamx7Hn5aMzi8za0ki', '28User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4608a3969a175760d46479bf6301a774b53ebda7e95501d903860fa46f324373', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser29', 'Demo 29', '0x157EbF951829fc4D1631Db9deF4af493A03BBCA2', '$2y$10$B/2E5YPzmV8u1Gy1L6s6EOD5.J97grErvGoi4wH1WU2iHvA8FM/Ju', '29User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4e004d0d42219f59ba614721b6c6f75cc48b4ba00601fdc6f3f79c62a2e20fe8', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser3', 'Demo 3', '0x5c51A4F1C770ad89244B4298DECCbe850bdF6b2E', '$2y$10$oOpdIOCNnaiHFddZ.n8CAucuhFb6t8LpxRDpRCe/XnaFMXPxwWP0e', '3User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xee0831479ebbb9247fef40c9d4a609ce4561a1c42d4d35da1b8eb5f99e6f0ddb', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser30', 'Demo 30', '0xf2976D51cC77538170b31f0b48fc6E1534Adc3c8', '$2y$10$NECJ1DZYBhsOI.OrZe.NVejFlqhn30NgBu9owy95NAaIuEuN2FPmu', '30User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x21e750379c64c4cdc5d7285bd5cfd63ec403b29a2268ec9e1b5001dee740e23e', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser31', 'Demo 31', '0x29Dac6F91439E8bF5cFf2022fC79092eDe3BD28D', '$2y$10$tt2BcEESwcVojOnwUd4xbeWupxYoQ/xgLHrNyDTVK.1OAd5gqGRAG', '31User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x574aede7ffcccfc7b90598b497904cc01c3f8a2166dedf949663b2c1db98af84', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser32', 'Demo 32', '0x5D8D50d00CB274c373D79D00Ce4E0e2B970A9353', '$2y$10$DVoL2Ved1VuXP9hOKpDsqOBwmcv.eo4ygSuuAJ0cliJbsxsE5hJQ6', '32User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x2e360f0d74a6ecedb2d8e06e95c998c37b49d5abea70f7cea84af51397f417b9', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser33', 'Demo 33', '0xB9351697a04dec1882A8F1c959567b6C6a694f0e', '$2y$10$yaTwrv8VJRmW8COX1mpfduJwP1U6f01cfZMyRtK2T0f9nJAFFdZ1O', '33User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x6e2be937d833b24866bfecb15e870ddf8f6093f6bd65575c2ab3c7bf5bd71211', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser34', 'Demo 34', '0x6A3450deA4d8Ba8B1DAB2536c7dcC2169B62aBf1', '$2y$10$EgOXdwBIhnclTkNx8zogHesJdws4M0/BLNMy4AcI56.6rwhxHW9F2', '34User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x3e080024d7f5bd28ccd8b436e305f899db1f046a7c416d2ccbb8f9c4781e61a9', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser35', 'Demo 35', '0xEb7d61a930897A14E497dF20693cA927E511e4cD', '$2y$10$6IoE72hBbAdKE1Y8cg4wuOTe3sKjgvB8sCCV6GmQExNowVFBIHJnS', '35User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x2e8e2847758a7c9f328df74e41884544b4442367abcdb54421e4b6715c9fef10', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser36', 'Demo 36', '0x9f99AF5423764A0C894Bf9f1986b102279f2f303', '$2y$10$5k/dlS99kG6I/LBQGtmhTOHbdCBBo/RHTbOpPdmgq.OIsa6evCOUu', '36User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x3851a3253e1e16f9bd538130c09ea31bf1217c803627d368086c5747cce8f0a1', '{\"Rating\":4,\"NumOfReviewers\":1}', '[{\"Review\":\"123\",\"UserID\":\"DemoUser36\",\"User\":\"DemoUser36\",\"Date\":\"2021-05-21\"}]', '[\"Normal\",\"\"]', 35264.22, 4, 'profilepictures/default.jpg', 0),
('DemoUser37', 'Demo 37', '0x3242C66A495806577d82f5ed3274e833666Bf945', '$2y$10$f8QoB793sZzhSSPPqAjAxubmTAHM5912470INk7eLg9jF9OxvLYuy', '37User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xf64ed8d513a408426b69bae40ec11a80e165f36dc2c1bfbde87f45d7d8cc42e2', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser38', 'Demo 38', '0x4FDb697870423b2989C2aeC2071C6F19dDCBC71A', '$2y$10$IHTepj69BI7ev8czkj7g4eWerxHN11ZCq3NSjbi7t5RkW/Qxru/4O', '38User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xd03f6933371760fe0214e90880dbeff9ab9f5bb010069b8e80c1ad87d902d788', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser39', 'Demo 39', '0xc431532C8C87b4292d4e71bdd1E436c468335cBE', '$2y$10$V5Qm5odibvuZf5adIilyhOKvYJdj7ZGC/eT0mXG0tV0JEW7A4QiT6', '39User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4ccb3c9d231ee0e22583e75837f1b94c8c4182ca7904f5aaae6d44a67e26c5bf', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser4', 'Demo 4', '0x7127394714b4727283868D6dD1106DA73B90844A', '$2y$10$/c1dz./wBTqJ8gV3TmTmo.Z/3sXUEvSwxkFVUwNifDUmMYbdzFzmm', '4User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xbaf46d03d03f326f617ddf90777126b8d3ae5fd75c6307f5ff4eeb7069c47890', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser40', 'Demo 40', '0xFb7881795F5f7D34331a1C464d71d94eFcBebE77', '$2y$10$AzEAbrMd2vTh19wds0efbeH1xfO5Oy1NPPdgJ9PYSftKO.BFd1L1i', '40User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x4e1159408b06a69533b41d82f02421af532b4f10f41b4ce1ccdfbb43fe0d8168', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser41', 'Demo 41', '0xD47414be3Ff8f68BB2Aa3C4f21c796820B0D23d1', '$2y$10$DV7Z/oIayioMPaUzojniaOLc43rNydDqCSADPtZfQuvaOV4FCgDbq', '41User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x70b35e13981d22c6d284a90ac057bc5dd31b3e7055de933e0ca69d79223dbbee', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser42', 'Demo 42', '0x682979041687BD74eb925C24646Dc413EBc67403', '$2y$10$M6lzgaXSd6d81ndxISlEteyExwuDWTxOhIStN6G0BsIm8iGy6pUb2', '42User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x0e1f85e376b5c2c84acdf1e99459c1399c8b971cec5e9bfedc581af472002497', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser43', 'Demo 43', '0x07c13D2d39905CDD01c72b9A9559BA54CEAbaA5d', '$2y$10$u.FyEkRVprmxCp49pOfKPe0zXspemtoBs2DuzMVSVdcekSz8rCTdu', '43User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x7a2ea09b04f1996c68575abf4d42fe2db8ac36ff27f6496f6f800ce0b1f100b5', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser44', 'Demo 44', '0x799b8840fDb6c0cdE41320D84D0b5D56F4Bad610', '$2y$10$Oyxf0HHtUoZlTgqkJYg9lO5SmR8ATZpXphEtd5nhxnmdvuYDgbEYe', '44User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xa2d6b226b990be9cd5619b0a317eff121d30a4aaf47ca4e397c84dc43ee46108', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser45', 'Demo 45', '0x053dA6FF4130cb157A89624349BDcd7d32402a41', '$2y$10$qfi2A0ODRFFjYQd4qobztunnyRW9BfSPqIL1.y4tRV.vO9drQpREy', '45User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xa41cb3eefa12ab0c22d1d00222e0c1c3cdea89cf841422c6ef1ded8ad1667f54', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser46', 'Demo 46', '0x1993a8C485513C63923693E565638a2D65FF8f89', '$2y$10$K26rELs6qlYAdryeDGovcObPi2EuXBHYBIZ8uvhflpWP5Mte4oDhi', '46User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x86eec079fdc614125b562ba268c181c627007bca849252315323f288688b5b95', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser47', 'Demo 47', '0x922c6173Bb0e7056fC4339Ac660A845C28f427bB', '$2y$10$mufltiylcis/S/zOD6CzZeyRZ6rrhzMyhRbdRyd07Z3RJ462IxQha', '47User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x59fc080b7b2bb2556ede8f9ef640b386f4609b05e8daaae4e7393ec2d9c117d5', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser48', 'Demo 48', '0xE7a89e42D6cD5F23aF27f216bd77A09d07778E3d', '$2y$10$5lHhwizTwHVOfIjw4Y5cI.i165zVStQPNs2Nopl6N6aLHJMgkgqIO', '48User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0xa6fc2423df0d8d138c2ea4925bef0b2e6211cfb77daabdb1dc5cf20740887618', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser49', 'Demo 49', '0xFA40Ac42809FC0A7D5130687F149F9ff760EE011', '$2y$10$y0DSFlZwTU6zSdfYXWPw/.plWs0WcM4YrnTsIcAAiHhnrxmnGuh4e', '49User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x993bd0e3816e235ec926fda773e233673ddeb67ee3788638159d11df449cafc3', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser5', 'Demo 5', '0xcAB98b6E8D24C962e7CC091ad194BAb563Acc502', '$2y$10$mi7.oo9CW1tLQw5I9ZhsQuo.De4hHkVofWJ1WvhHcooW7EfFU10iW', '5User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x3614953c113faed0b832fbb598ecf665ceff01d2722284b025aef280004832d8', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser6', 'Demo 6', '0x8686Ea677F29C7a6D8A8f714af3A7b3aE18b371b', '$2y$10$Ln9a4rAMTymQrFOgYU7RA.utf6IuSqvK50I8lDX.q1kWnbgGeKtEG', '6User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x319415870a13631b1b1a80cde359071a463bf518f5746d404f936f480e63b6ed', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser7', 'Demo 7', '0xd939Ea1757A2F38fa8351713905A47991B597A0A', '$2y$10$5.puqdmddkAdbnZMhd6es.vjalUyueb/ScHnAX8rAl4DxDYILg2FC', '7User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x43f2d30642502067b7445dfa6a21d9b2ef8bfb98d6db1912e21f0c9b4c1dc1b4', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser8', 'Demo 8', '0xFd7948b67dA97ec40D369ab3D3c086a317b370dd', '$2y$10$VZJ/xa/8.qf4RNMWcyJJseAd.gf1wyVTnxTmHaHScfzchRWr.wKaK', '8User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x9884b90bd6f3e6cc0be875b22fd80525481a77d032e23147ee2cb565ba5535d1', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0),
('DemoUser9', 'Demo 9', '0x11170Fc76A75Df867ED06B1973A8f23E2cFfD317', '$2y$10$9iDj9herg.XtSSPo.cVN5OFu2Fir4D7cXDdHkXO1rhSjvcr87P4vi', '9User@gmail.com', 'Demo', 'User', '01/01/1991', 96969696, 'demo road', 'Standard', '0x5bb7bed7ea41848af9a722b47bbd03463ec35a47faffc36dfe208da85b663be3', '{\"Rating\":3.0009765625,\"NumOfReviewers\":11}', '[{\"Review\":\"good\",\"UserID\":\"DemoUser9\",\"User\":\"DemoUser14\",\"Date\":\"2021-05-17\"},{\"Review\":\"good\",\"UserID\":\"DemoUser9\",\"User\":\"DemoUser9\",\"Date\":\"2021-05-17\"},{\"Review\":\"ok\",\"UserID\":\"DemoUser9\",\"User\":\"DemoUser14\",\"Date\":\"2021-05-17\"}]', '[\"Normal\",\"\"]', 31497.4, 23, 'profilepictures/default.jpg', 0),
('Escrow18', '', '0xD94a5b0d776163Fc1228d666824C367Be8b0a6c1', '', '', '', '', '', 0, '', 'Escrow', 'a1c61f0871e06c22585cd4486dde228b08151cf8f72a4dfbac9065d22f80c279', '{\"Rating\":5,\"NumOfReviewers\":0}', '[]', '[\"Normal\",\"\"]', 0, 0, 'profilepictures/default.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`ContractID`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `temporarypassword`
--
ALTER TABLE `temporarypassword`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);
  
  
CREATE TABLE `advertising` (
  `UserID` varchar(20) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `adImage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertising`
--
ALTER TABLE `advertising`
  ADD PRIMARY KEY (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
