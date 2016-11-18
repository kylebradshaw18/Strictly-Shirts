-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--

-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2016 at 03:35 AM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `strictly_shirts`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `addrId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `addressLine1` varchar(50) NOT NULL,
  `apartmentNumber` varchar(50) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zipcode` char(5) DEFAULT NULL,
  `isPrimaryAddress` tinyint(1) DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`addrId`),
  KEY `AddressPerson_idx` (`personId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`addrId`, `personId`, `addressLine1`, `apartmentNumber`, `city`, `state`, `zipcode`, `isPrimaryAddress`, `status`) VALUES
(7, 17, 's', 's', 's', 'AK', '53454', 0, 'ACTIVE'),
(8, 17, 's', 's', 's', 'AK', '34334', 0, 'ACTIVE'),
(9, 17, 's', 's', 'a', 'AK', '45354', 0, 'ACTIVE'),
(12, 17, 'df', 'dfg', 'fdg', 'AK', '64564', 0, 'ACTIVE'),
(13, 17, 'vjhvj', 'jhvjhv', 'jhvjhvjh', 'AK', '97797', 0, 'ACTIVE'),
(14, 17, 'dgdf', 'gdgdf', '5345435', 'AK', '34534', 0, 'ACTIVE'),
(15, 17, '5465', '', '5345435', 'AK', '34534', 0, 'ACTIVE'),
(16, 17, 'gdfgdd', 'dhghfg', '767567', 'AK', '98908', 0, 'ACTIVE'),
(17, 17, 'dfgf', 'dfggfd', 'gdfgdfg', 'AK', '64564', 0, 'ACTIVE'),
(18, 17, 'fgdfg', 'fdgdfg', 'dfgdfgdf', 'AK', '45645', 0, 'ACTIVE'),
(19, 17, 'fdgdf434343434', 'dfgdf', '34543', 'AK', '43534', 0, 'ACTIVE'),
(20, 17, 'hgfh', 'fghfghfg', 'fghfghfghfhgffffffff', 'AK', '56456', 0, 'ACTIVE'),
(23, 17, 'qerewr', 'ewqewer', 'ddewrwe', 'AK', '53453', 0, 'ACTIVE'),
(24, 17, 'qerewr', 'ewqewer', 'ddewrwe', 'AK', '54535', 0, 'ACTIVE'),
(25, 17, 'r43', '3r4', '543', 'AK', '34535', 0, 'ACTIVE'),
(26, 17, '345', '35', '453', 'AK', '53453', 0, 'ACTIVE'),
(28, 17, '454', 'bkbb', 'bkbkjb', 'NY', '46545', 0, 'ACTIVE'),
(29, 17, 'fdgdf', 'gdg', 'fgdg', 'AK', '64564', 0, 'ACTIVE'),
(30, 22, '22 Baker St', 'Apt 221B', 'New York', 'NY', '11111', 0, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `permissionId` int(11) NOT NULL,
  `personId` int(11) NOT NULL,
  PRIMARY KEY (`permissionId`,`personId`),
  KEY `AdminPerson_idx` (`personId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`permissionId`, `personId`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE IF NOT EXISTS `carts` (
  `cartId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `inventoryId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cartId`),
  KEY `CartPerson_idx` (`personId`),
  KEY `CartInventory_idx` (`inventoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `carts`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `category`) VALUES
(1, 'Marvel'),
(2, 'Sports'),
(3, 'Video Games'),
(4, 'Music'),
(5, 'Custom Order'),
(6, 'Meme');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `colorId` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`colorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`colorId`, `color`) VALUES
(1, 'Red'),
(2, 'Orange'),
(3, 'Green'),
(4, 'Black'),
(5, 'Dark Blue'),
(6, 'White'),
(7, 'Yellow'),
(8, 'Grey'),
(9, 'Blue'),
(10, 'Brown');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE IF NOT EXISTS `designs` (
  `designId` int(11) NOT NULL AUTO_INCREMENT,
  `design` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`designId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`designId`, `design`) VALUES
(1, 'Giants'),  
(2, 'Manchester United'),
(3, 'Real Madrid'),
(4, 'Barcelona'),
(5, 'Yankees'),
(6, 'Lakers'),
(7, 'Rangers'),
(8, 'Patriots'),
(9, 'Cowboys'),
(10, 'Iron Man'),
(11, 'Thor'),
(12, 'Marvel'),
(13, 'Super Man'),
(14, 'DeadPool'),
(15, 'Avengers'),
(16, 'Wolverine'),
(17, 'Hulk'),
(18, 'Drake'),
(19, 'Kayne West'),
(20, 'AC/DC'),
(21, 'Symphony'),
(22, 'Cold Play'),
(23, 'Green Day'),
(24, 'Maroon 5'),
(25, 'Rolling Stones'),
(26, 'Beatles'),
(27, 'No Time'), 
(28, 'Er Mah Gerd'),
(29, 'Grumpy Christmas Cat'),
(30, 'Hungry Frog'),
(31, 'Impossibru'),
(32, 'Troll'),
(33, 'Face Palm'),
(34, 'Take My Money'),
(35, 'True Story'),
(36, 'Watchout'),
(37, 'Nike'), 
(38, 'Bob Marley'), 
(39, 'Hello'),
(40, 'Austin 3:16'),
(41, 'Yolo'),
(42, 'Kiss Irish'),
(43, 'Reggae Love'),
(44, 'With Stupid'),
(45, 'Tuxedo'),
(46, 'Call Of Duty'), 
(47, 'Dragon Ball Z'),
(48, 'Final Fantasy'),
(49, 'God Of War'),
(50, 'Grand Theft Auto 5'),
(51, 'Guitar Hero'),
(52, 'Kingdom Heart'),
(53, 'Mario'),
(54, 'Pokemon');

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE IF NOT EXISTS `distributors` (
  `distId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`distId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`distId`, `name`) VALUES
(1, 'USPS'),
(2, 'UPS'),
(3, 'FED EX');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE IF NOT EXISTS `orderdetails` (
  `orderId` int(11) NOT NULL,
  `inventoryId` int(11) NOT NULL,
  `priorityId` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`orderId`,`inventoryId`),
  KEY `OrderInventory_idx` (`inventoryId`),
  KEY `OrderPriority_idx` (`priorityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderdetails`
--
/*
INSERT INTO `orderdetails` (`orderId`, `inventoryId`, `priorityId`, `quantity`) VALUES
(1, 1, 2, 2),
(2, 2, 3, 1),
(2, 3, 1, 1);
*/
-- --------------------------------------------------------

--
-- Table structure for table `ordersmaster`
--

CREATE TABLE IF NOT EXISTS `ordersmaster` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `addrId` int(11) DEFAULT NULL,
  `payId` int(11) DEFAULT NULL,
  `date` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderId`),
  KEY `OrderPerson_idx` (`personId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ordersmaster`
--
/*
INSERT INTO `ordersmaster` (`orderId`, `personId`, `addrId`, `payId`, `date`) VALUES
(1, 1, 1, 1, '2016-10-08'),
(2, 2, 2, 2, '2016-09-30');
*/
-- --------------------------------------------------------

--
-- Table structure for table `paymentmethods`
--

CREATE TABLE IF NOT EXISTS `paymentmethods` (
  `payId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `cardNum` varchar(20) DEFAULT NULL,
  `csc` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `isPrimaryPayment` tinyint(1) DEFAULT '0',
  `expirationMonth` char(2) DEFAULT NULL,
  `expirationYear` year(4) DEFAULT NULL,
  `nameOnCard` varchar(45) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`payId`),
  KEY `PaymentPerson_idx` (`personId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `paymentmethods`
--

INSERT INTO `paymentmethods` (`payId`, `personId`, `cardNum`, `csc`, `type`, `isPrimaryPayment`, `expirationMonth`, `expirationYear`, `nameOnCard`, `status`) VALUES
(1, 1, '5546662', 202, 'VISA', 0, '03', 2014, 'testing', 'ACTIVE'),
(2, 1, '8876244', 5555, 'AMEX', 0, '03', 2014, '645645', 'ACTIVE'),
(3, 2, '5546633', 443, 'VISA', 0, '03', 2014, '645645', 'ACTIVE'),
(5, 17, '111111111111', 1111, 'Visa', 0, '03', 2014, '645645', 'ACTIVE'),
(7, 17, '686876876', 7987, 'American Express', 1, '10', 2016, 'fdfd', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `personId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(15) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`personId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`personId`, `firstName`, `lastName`, `password`, `email`, `date`, `phone`, `status`) VALUES
(1, 'Jesse', 'Person', 'papAq5PwY/QQM', 'admin@msn.com', '2016-10-28 20:48:28', '(654) 654-6546', 'ACTIVE'),
(2, 'Joe', 'BuysStuff', 'pa.XxUWTE7Pt2', 'shirtsRgr8@yahoo.com', '2016-10-28 20:48:28', '(654) 654-6546', 'ACTIVE'),
(3, 'Norman', 'Moonshoes', 'pa0r4XZFvu4/2', 'webCeleb98@gmail.com', '2016-10-28 20:48:28', '(654) 654-6546', 'ACTIVE'),
(5, 'Kyle', 'Bradshaw', 'paKGT7jOFzF.s', 'ss@gmail.com', '2016-11-01 20:00:10', '(845) 240-2066', 'ACTIVE'),
(11, 'kyle', 'br', 'pa04lb9.ShCe6', 'sdafsdf@sfadsf', '2016-11-01 22:05:35', '(654) 654-6546', 'ACTIVE'),
(12, 'asas', 'asas', 'paE9VF.hyvYg.', 'test@g', '2016-11-02 22:19:30', '(555) 555-5555', 'ACTIVE'),
(13, 'sda', 'sd', 'paCnv9ivNC20o', 's@s', '2016-11-03 02:45:54', '(434) 534-5345', 'ACTIVE'),
(14, 'as', 'as', 'paCnv9ivNC20o', 'a@s', '2016-11-03 02:55:31', '(232) 323-2323', 'ACTIVE'),
(16, 'Kyle', 'Bradshaw', 'paf/WUKjenbOk', 'kylebradshaw18@gmail.com', '2016-11-03 04:57:04', '(845) 240-2066', 'ACTIVE'),
(17, 'test', 'test', 'pa0nOH/Fzv9xE', '1@1', '2016-11-07 14:56:21', '(654) 654-6556', 'ACTIVE'),
(18, 'kibria', 'biswas', 'paltKSI9drjl.', 'biswas_kibria@yahoo.com', '2016-11-09 22:44:09', '(718) 998-9878', 'ACTIVE'),
(19, 'Greg', 'Dallari', 'paltKSI9drjl.', 'Greg.Dallari@marist.edu', '2016-11-09 23:57:02', '(845) 575-3000', 'ACTIVE'),
(20, 'Ronald', 'Dartey', 'paagWgB/nq8gk', 'tttt@gmail.com', '2016-11-14 22:43:10', '(556) 759-5955', 'ACTIVE'),
(21, 'Elf', 'Roff', 'pa4.HHSXL55NA', 'elf@gmail.com', '2016-11-15 06:42:02', '(748) 494-9404', 'ACTIVE'),
(22, 'kg', 'lk', 'paIogez5Bz25s', 'marist@marist.edu', '2016-11-15 18:08:10', '(845) 433-5000', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `permissionId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`permissionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissionId`, `name`) VALUES
(1, 'ADD'),
(2, 'UPDATE'),
(3, 'DELETE');

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE IF NOT EXISTS `priorities` (
  `priorityId` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(50) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `distId` int(11) DEFAULT NULL,
  PRIMARY KEY (`priorityId`),
  KEY `PriorityDistributor_idx` (`distId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`priorityId`, `priority`, `price`, `distId`) VALUES
(1, 'First Class', 5.00, 1),
(2, 'Standard', 6.10, 2),
(3, 'Two Day', 15.56, 2);


-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `inventoryId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `colorId` int(11) DEFAULT NULL,
  `sizeId` int(11) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `supplierId` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`inventoryId`),
  KEY `InventoryColor_idx` (`colorId`),
  KEY `InventorySize_idx` (`sizeId`),
  KEY `InventoryType_idx` (`typeId`),
  KEY `InventorySupplier_idx` (`supplierId`),
  KEY `InventoryProduct_idx` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=217 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventoryId`, `productId`, `colorId`, `sizeId`, `typeId`, `quantity`, `supplierId`, `price`) VALUES
(1,  1, 9, 1, 1, 37, 1, 23.34), 
(2,  1, 9, 2, 1, 22, 1, 23.34), 
(3,  1, 9, 3, 1, 46, 1, 23.34), 
(4,  1, 9, 4, 1, 15, 1, 23.34), 

(5,  2, 1, 1, 1, 23, 1, 17.98), 
(6,  2, 1, 2, 1, 12, 1, 17.98), 
(7,  2, 1, 3, 1, 10, 1, 17.98), 
(8,  2, 1, 4, 1, 0,  1, 17.98), 

(9,  3, 6, 1, 1, 23, 1, 16.98),
(10, 3, 6, 2, 1, 26, 1, 16.98),
(11, 3, 6, 3, 1, 12, 1, 16.98),
(12, 3, 6, 4, 1, 2,  1, 16.98),

(13, 4, 5, 1, 1, 16, 1, 14.98), 
(14, 4, 5, 2, 1, 14, 1, 14.98), 
(15, 4, 5, 3, 1, 40, 1, 12.98), 
(16, 4, 5, 4, 1, 2,  1, 15.98), 

(17, 5, 5, 1, 1, 17, 1, 14.98),
(18, 5, 5, 2, 1, 14, 1, 18.98),
(19, 5, 5, 3, 1, 54, 1, 12.98),
(20, 5, 5, 4, 1, 24, 1, 20.98),

(21, 6, 7, 1, 1, 8,  1, 20.00), 
(22, 6, 7, 2, 1, 24, 1, 21.00), 
(23, 6, 7, 3, 1, 31, 1, 20.00), 
(24, 6, 7, 4, 1, 6,  1, 22.00), 

(25, 7, 9, 1, 1, 15,  1, 26.00), 
(26, 7, 9, 2, 1, 13, 1, 26.00), 
(27, 7, 9, 3, 1, 56, 1, 27.00), 
(28, 7, 9, 4, 1, 50,  1, 28.00), 

(29, 8, 8, 1, 1, 10,  1, 19.10), 
(30, 8, 8, 2, 1, 24, 1, 23.00), 
(31, 8, 8, 3, 1, 46, 1, 24.23), 
(32, 8, 8, 4, 1, 80,  1, 22.00), 

(33, 9, 5, 1, 1, 13,  1, 27.10), 
(34, 9, 5, 2, 1, 24, 1, 26.00), 
(35, 9, 5, 3, 1, 20, 1, 27.23), 
(36, 9, 5, 4, 1, 9,  1, 29.00), 

(37, 10, 1, 1, 1, 15,  1, 19.10), 
(38, 10, 1, 2, 1, 24, 1, 18.00), 
(39, 10, 1, 3, 1, 25, 1, 19.23), 
(40, 10, 1, 4, 1, 9,  1, 20.00), 

(41, 11, 4, 1, 1, 19,  1, 19.10), 
(42, 11, 4, 2, 1, 24, 1, 18.00), 
(43, 11, 4, 3, 1, 26, 1, 19.23), 
(44, 11, 4, 4, 1, 19,  1, 20.00), 

(45, 12, 4, 1, 1, 19,  1, 20.10), 
(46, 12, 4, 2, 1, 24, 1, 21.00), 
(47, 12, 4, 3, 1, 26, 1, 28.23), 
(48, 12, 4, 4, 1, 19,  1, 29.00), 

(49, 13, 9, 1, 1, 19,  1, 20.10), 
(50, 13, 9, 2, 1, 24, 1, 20.10), 
(51, 13, 9, 3, 1, 26, 1, 20.10), 
(52, 13, 9, 4, 1, 19,  1, 20.10), 

(53, 14, 4, 1, 1, 25,  1, 20.10), 
(54, 14, 4, 2, 1, 26, 1, 20.10), 
(55, 14, 4, 3, 1, 34, 1, 20.10), 
(56, 14, 4, 4, 1, 54,  1, 20.10), 

(57, 15, 4, 1, 1, 23,  1, 20.10), 
(58, 15, 4, 2, 1, 35, 1, 16.10), 
(59, 15, 4, 3, 1, 45, 1, 20.10), 
(60, 15, 4, 4, 1, 75,  1, 19.10), 

(61, 16, 8, 1, 1, 15,  1, 23.10), 
(62, 16, 8, 2, 1, 89, 1, 22.10), 
(63, 16, 8, 3, 1, 48, 1, 25.10), 
(64, 16, 8, 4, 1, 56,  1, 16.10), 

(65, 17, 3, 1, 1, 35,  1, 15.10), 
(66, 17, 3, 2, 1, 88, 1, 16.10), 
(67, 17, 3, 3, 1, 79, 1, 18.10), 
(68, 17, 3, 4, 1, 56,  1, 18.10), 

(69, 18, 4, 1, 1, 17,  1, 26.10), 
(70, 18, 4, 2, 1, 47, 1, 26.10), 
(71, 18, 4, 3, 1, 27, 1, 26.10), 
(72, 18, 4, 4, 1, 30,  1, 28.10), 

(73, 19, 8, 1, 1, 24,  1, 28.10), 
(74, 19, 8, 2, 1, 53, 1, 28.10), 
(75, 19, 8, 3, 1, 49, 1, 28.10), 
(76, 19, 8, 4, 1, 46,  1, 28.10), 

(77, 20, 8, 1, 1, 19,  1, 16.10), 
(78, 20, 8, 2, 1, 13, 1, 17.10), 
(79, 20, 8, 3, 1, 19, 1, 17.10), 
(80, 20, 8, 4, 1, 25,  1, 17.10), 

(81, 21, 6, 1, 1, 7,  1, 12.10), 
(82, 21, 6, 2, 1, 6, 1, 13.10), 
(83, 21, 6, 3, 1, 0, 1, 16.10), 
(84, 21, 6, 4, 1, 8,  1, 15.10), 

(85, 22, 6, 1, 1, 7,  1, 9.10), 
(86, 22, 6, 2, 1, 6, 1, 10.10), 
(87, 22, 6, 3, 1, 0, 1, 11.10), 
(88, 22, 6, 4, 1, 8,  1, 9.10), 

(89, 23, 4, 1, 1, 30,  1, 22.10), 
(90, 23, 4, 2, 1, 38, 1, 22.10), 
(91, 23, 4, 3, 1, 12, 1, 22.10), 
(92, 23, 4, 4, 1, 45,  1, 22.10), 

(93, 24, 6, 1, 1, 35,  1, 25.10), 
(94, 24, 6, 2, 1, 36, 1, 25.10), 
(95, 24, 6, 3, 1, 32, 1, 25.10), 
(96, 24, 6, 4, 1, 0,  1, 26.10), 

(97,  25, 4, 1, 1, 30,  1, 14.10), 
(98,  25, 4, 2, 1, 38, 1, 14.10), 
(99,  25, 4, 3, 1, 12, 1, 14.10), 
(100, 25, 4, 4, 1, 45,  1, 14.10), 

(101,  26, 6, 1, 1, 17,  1, 16.10), 
(102,  26, 6, 2, 1, 16, 1, 17.10), 
(103,  26, 6, 3, 1, 20, 1, 16.10), 
(104,  26, 6, 4, 1, 34,  1, 16.10), 

(105,  27, 10, 1, 1, 24,  1, 12.10), 
(106,  27, 10, 2, 1, 16, 1, 12.10), 
(107,  27, 10, 3, 1, 28, 1, 12.10), 
(108,  27, 10, 4, 1, 34,  1, 12.10), 

(109,  28, 1, 1, 1, 46,  1, 14.10), 
(110,  28, 1, 2, 1, 28, 1, 14.10), 
(111,  28, 1, 3, 1, 32, 1, 14.10), 
(112,  28, 1, 4, 1, 34,  1, 14.10), 

(113,  29, 6, 1, 1, 36,  1, 11.14), 
(114,  29, 6, 2, 1, 100, 1, 11.14), 
(115,  29, 6, 3, 1, 95, 1, 11.14), 
(116,  29, 6, 4, 1, 89,  1, 11.14), 

(117,  30, 6, 1, 1, 42,  1, 15.14), 
(118,  30, 6, 2, 1, 13, 1, 15.14), 
(119,  30, 6, 3, 1, 16, 1, 15.14), 
(120,  30, 6, 4, 1, 18,  1, 15.14), 

(121,  31, 9, 1, 1, 15,  1, 18.18), 
(122,  31, 9, 2, 1, 16, 1, 18.18), 
(123,  31, 9, 3, 1, 18, 1, 18.18), 
(124,  31, 9, 4, 1, 19,  1, 19.34), 

(125,  32, 8, 1, 1, 31,  1, 20.18), 
(126,  32, 8, 2, 1, 28, 1, 20.18), 
(127,  32, 8, 3, 1, 26, 1, 20.18), 
(128,  32, 8, 4, 1, 15,  1, 20.18), 

(129,  33, 1, 1, 1, 88,  1, 23.99), 
(130,  33, 1, 2, 1, 95, 1, 23.99), 
(131,  33, 1, 3, 1, 102, 1, 23.99), 
(132,  33, 1, 4, 1, 26,  1, 23.99), 

(133,  34, 4, 1, 1, 100,  1, 20.99), 
(134,  34, 4, 2, 1, 95, 1, 20.99), 
(135,  34, 4, 3, 1, 102, 1, 20.99), 
(136,  34, 4, 4, 1, 46,  1, 20.99), 

(137,  35, 4, 1, 1, 105,  1, 20.99), 
(138,  35, 4, 2, 1, 95, 1, 20.99), 
(139,  35, 4, 3, 1, 15, 1, 20.99), 
(140,  35, 4, 4, 1, 55,  1, 20.99), 

(141,  36, 6, 1, 1, 120,  1, 22.99), 
(142,  36, 6, 2, 1, 95, 1, 22.99), 
(143,  36, 6, 3, 1, 150, 1, 23.99), 
(144,  36, 6, 4, 1, 68,  1, 23.99), 

(145,  37, 6, 1, 1, 220,  1, 24.99), 
(146,  37, 6, 2, 1, 195, 1, 24.99), 
(147,  37, 6, 3, 1, 150, 1, 24.99), 
(148,  37, 6, 4, 1, 168,  1, 24.99), 

(149,  38, 7, 1, 1, 120,  1, 19.99),
(150,  38, 7, 2, 1, 95, 1, 19.99),
(151,  38, 7, 3, 1, 150, 1, 19.99),
(152,  38, 7, 4, 1, 68,  1, 19.99),

(153,  39, 8, 1, 1, 120,  1, 19.99), 
(154,  39, 8, 2, 1, 95, 1, 19.99), 
(155,  39, 8, 3, 1, 150, 1, 19.99), 
(156,  39, 8, 4, 1, 68,  1, 19.99), 

(157,  40, 4, 1, 1, 120,  1, 19.99), 
(158,  40, 4, 2, 1, 95, 1, 19.99), 
(159,  40, 4, 3, 1, 150, 1, 19.99), 
(160,  40, 4, 4, 1, 68,  1, 19.99), 

(161,  41, 4, 1, 1, 120,  1, 19.99), 
(162,  41, 4, 2, 1, 95, 1, 19.99), 
(163,  41, 4, 3, 1, 150, 1, 19.99), 
(164,  41, 4, 4, 1, 68,  1, 19.99), 

(165,  42, 3, 1, 1, 120,  1, 19.99), 
(166,  42, 3, 2, 1, 95, 1, 19.99), 
(167,  42, 3, 3, 1, 150, 1, 19.99), 
(168,  42, 3, 4, 1, 68,  1, 19.99), 

(169,  43, 10, 1, 1, 120,  1, 19.99), 
(170,  43, 10, 2, 1, 95, 1, 19.99), 
(171,  43, 10, 3, 1, 150, 1, 19.99), 
(172,  43, 10, 4, 1, 68,  1, 19.99), 

(173,  44, 4, 1, 1, 120,  1, 19.99), 
(174,  44, 4, 2, 1, 95, 1, 19.99), 
(175,  44, 4, 3, 1, 150, 1, 19.99), 
(176,  44, 4, 4, 1, 68,  1, 19.99), 

(177,  45, 4, 1, 1, 120,  1, 19.99), 
(178,  45, 4, 2, 1, 95, 1, 19.99), 
(179,  45, 4, 3, 1, 150, 1, 19.99), 
(180,  45, 4, 4, 1, 68,  1, 19.99), 

(181,  46, 4, 1, 1, 120,  1, 23.99), 
(182,  46, 4, 2, 1, 95, 1, 23.99), 
(183,  46, 4, 3, 1, 150, 1, 23.99), 
(184,  46, 4, 4, 1, 68,  1, 23.99), 

(185,  47, 4, 1, 1, 120,  1, 21.99), 
(186,  47, 4, 2, 1, 95, 1, 21.99), 
(187,  47, 4, 3, 1, 150, 1, 21.99), 
(188,  47, 4, 4, 1, 68,  1, 21.99), 

(189,  48, 6, 1, 1, 120,  1, 21.99),  
(190,  48, 6, 2, 1, 95, 1, 21.99),  
(191,  48, 6, 3, 1, 150, 1, 21.99), 
(192,  48, 6, 4, 1, 68,  1, 21.99), 

(193,  49, 6, 1, 1, 120,  1, 21.99),  
(194,  49, 6, 2, 1, 95, 1, 21.99),  
(195,  49, 6, 3, 1, 150, 1, 21.99), 
(196,  49, 6, 4, 1, 68,  1, 21.99), 

(197,  50, 6, 1, 1, 120,  1, 23.99),  
(198,  50, 6, 2, 1, 95, 1, 23.99), 
(199,  50, 6, 3, 1, 150, 1, 23.99), 
(200,  50, 6, 4, 1, 68,  1, 23.99), 

(201,  51, 6, 1, 1, 120,  1, 22.99),  
(202,  51, 6, 2, 1, 95, 1, 22.99), 
(203,  51, 6, 3, 1, 150, 1, 22.99), 
(204,  51, 6, 4, 1, 68,  1, 22.99), 

(205,  52, 6, 1, 1, 120,  1, 18.99), 
(206,  52, 6, 2, 1, 95, 1, 18.99), 
(207,  52, 6, 3, 1, 150, 1, 18.99), 
(208,  52, 6, 4, 1, 68,  1, 18.99), 

(209,  53, 8, 1, 1, 120,  1, 21.99), 
(210,  53, 8, 2, 1, 95, 1, 20.99), 
(211,  53, 8, 3, 1, 150, 1, 23.99), 
(212,  53, 8, 4, 1, 68,  1, 20.99), 

(213,  54, 6, 1, 1, 120,  1, 17.99), 
(214,  54, 6, 2, 1, 95, 1, 17.99), 
(215,  54, 6, 3, 1, 150, 1, 17.99), 
(216,  54, 6, 4, 1, 68,  1, 17.99); 
-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) DEFAULT NULL,
  `designId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `ProductCategory_idx` (`categoryId`),
  KEY `ProductDesign_idx` (`designId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `categoryId`, `designId`) VALUES
(1, 2, 1), 
(2, 2, 2), 
(3, 2, 3),
(4, 2, 4), 
(5, 2, 5),
(6, 2, 6), 
(7, 2, 7), 
(8, 2, 8), 
(9, 2, 9), 

(10, 1, 10), 
(11, 1, 11), 
(12, 1, 12), 
(13, 1, 13), 
(14, 1, 14), 
(15, 1, 15), 
(16, 1, 16), 
(17, 1, 17), 

(18, 1, 18), 
(19, 1, 19), 
(20, 1, 20), 
(21, 1, 21), 
(22, 1, 22), 
(23, 1, 23), 
(24, 1, 24), 
(25, 1, 25), 
(26, 1, 26), 

(27, 6, 27), 
(28, 6, 28), 
(29, 6, 29), 
(30, 6, 30), 
(31, 6, 31), 
(32, 6, 32), 
(33, 6, 33), 
(34, 6, 34), 
(35, 6, 35), 
(36, 6, 36), 

(37, 2, 37), 

(38, 6, 38),
(39, 6, 39), 
(40, 6, 40), 
(41, 6, 41), 
(42, 6, 42), 
(43, 6, 43), 
(44, 6, 44), 
(45, 6, 45),     

(46, 3, 46), 
(47, 3, 47),     
(48, 3, 48), 
(49, 3, 49), 
(50, 3, 50), 
(51, 3, 51), 
(52, 3, 52), 
(53, 3, 53), 
(54, 3, 54); 
-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE IF NOT EXISTS `sizes` (
  `sizeId` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`sizeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`sizeId`, `size`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `subscriptionId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `addrId` int(11) DEFAULT NULL,
  `date` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subscriptionId`),
  KEY `SubscriptionPerson_idx` (`personId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`subscriptionId`, `personId`, `categoryId`, `addrId`, `date`) VALUES
(1, 17, 2, 1, CURRENT_TIMESTAMP),
(2, 17, 1, 2, CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplierId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`supplierId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplierId`, `name`, `contact`) VALUES
(1, 'Alibaba', 'Jack Ma');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `typeId` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`typeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`typeId`, `type`) VALUES
(1, 'O Neck'),
(2, 'V Neck');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `AddressPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `AdminPermission` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `AdminPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `CartPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `OrderMaster` FOREIGN KEY (`orderId`) REFERENCES `ordersmaster` (`orderId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `OrderPriority` FOREIGN KEY (`priorityId`) REFERENCES `priorities` (`priorityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `OrderInventory` FOREIGN KEY (`inventoryId`) REFERENCES `inventory` (`inventoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ordersmaster`
--
ALTER TABLE `ordersmaster`
  ADD CONSTRAINT `OrderPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  ADD CONSTRAINT `PaymentPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `priorities`
--
ALTER TABLE `priorities`
  ADD CONSTRAINT `PriorityDistributor` FOREIGN KEY (`distId`) REFERENCES `distributors` (`distId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `ProductCategory` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ProductDesign` FOREIGN KEY (`designId`) REFERENCES `designs` (`designId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/*
--REMOVED CONSTRAINTS IT DID NOT LIKE THIS FOR SOME REASON
--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `InventoryProduct` FOREIGN KEY (`productId`) REFERENCES `products` (`productsId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `InventoryColor` FOREIGN KEY (`colorId`) REFERENCES `colors` (`colorId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `InventorySize` FOREIGN KEY (`sizeId`) REFERENCES `sizes` (`sizeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `InventoryType` FOREIGN KEY (`typeId`) REFERENCES `sizes` (`typeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `InventorySupplier` FOREIGN KEY (`supplierId`) REFERENCES `suppliers` (`supplierId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

*/

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `SubscriptionPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
