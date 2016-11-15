-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: localhost    Database: strictly_shirts
-- ------------------------------------------------------
-- Server version	5.7.15-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `addrId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `addressLine1` varchar(50) NOT NULL,
  `apartmentNumber` varchar(50) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zipcode` char(5) DEFAULT NULL,
  `isPrimaryAddress` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`addrId`),
  KEY `AddressCustomer_idx` (`personId`),
  KEY `AddressPerson_idx` (`personId`),
  CONSTRAINT `AddressPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,1,'44 Spruce Street','Apartment 23','Poughkeepsie','NY','12601',0),(2,2,'77 SandDune Ave',NULL,'Beachtown','AK','12458',0);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `permissionId` int(11) NOT NULL,
  `personId` int(11) NOT NULL,
  PRIMARY KEY (`permissionId`,`personId`),
  KEY `AdminPerson_idx` (`personId`),
  CONSTRAINT `AdminPermission` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `AdminPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `cartId` int(11) NOT NULL AUTO_INCREMENT,
  `peresonId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cartId`),
  KEY `CartPerson_idx` (`peresonId`),
  CONSTRAINT `CartPerson` FOREIGN KEY (`peresonId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,1,1,2),(2,1,3,1),(3,2,2,1);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES ('Marvel'),('Sports'),('Video Games'),('Music'),('Custom Order');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `colorId` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`colorId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'red'),(2,'brown'),(3,'green'),(4,'black'),(5,'dark-blue');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designs`
--

DROP TABLE IF EXISTS `designs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designs` (
  `designId` int(11) NOT NULL AUTO_INCREMENT,
  `design` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`designId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designs`
--

LOCK TABLES `designs` WRITE;
/*!40000 ALTER TABLE `designs` DISABLE KEYS */;
INSERT INTO `designs` VALUES (1,'Jets'),(2,'Giants'),(3,'Iron Man'),(4,'Thor'),(5,'Fallout'),(6,'Call of Duty'),(7,'DeadPool'),(8,'Super Man'),(9,'Hulk'),(10,'Avengers');
/*!40000 ALTER TABLE `designs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distributors`
--

DROP TABLE IF EXISTS `distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distributors` (
  `distId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`distId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distributors`
--

LOCK TABLES `distributors` WRITE;
/*!40000 ALTER TABLE `distributors` DISABLE KEYS */;
INSERT INTO `distributors` VALUES (1,'USPS'),(2,'UPS');
/*!40000 ALTER TABLE `distributors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderdetails` (
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `priorityId` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderId`,`productId`),
  KEY `OrderProduct_idx` (`productId`),
  KEY `OrderPriority_idx` (`priorityId`),
  CONSTRAINT `OrderMaster` FOREIGN KEY (`orderId`) REFERENCES `ordersmaster` (`orderId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `OrderPriority` FOREIGN KEY (`priorityId`) REFERENCES `priorities` (`priorityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `OrderProduct` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderdetails`
--

LOCK TABLES `orderdetails` WRITE;
/*!40000 ALTER TABLE `orderdetails` DISABLE KEYS */;
INSERT INTO `orderdetails` VALUES (1,1,2,2),(2,2,3,1),(2,3,1,1);
/*!40000 ALTER TABLE `orderdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordersmaster`
--

DROP TABLE IF EXISTS `ordersmaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordersmaster` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `addrId` int(11) DEFAULT NULL,
  `payId` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`orderId`),
  KEY `OrderPerson_idx` (`personId`),
  CONSTRAINT `OrderPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordersmaster`
--

LOCK TABLES `ordersmaster` WRITE;
/*!40000 ALTER TABLE `ordersmaster` DISABLE KEYS */;
INSERT INTO `ordersmaster` VALUES (1,1,1,1,'2016-10-08'),(2,2,2,2,'2016-09-30');
/*!40000 ALTER TABLE `ordersmaster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentmethods`
--

DROP TABLE IF EXISTS `paymentmethods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paymentmethods` (
  `payId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `cardNum` varchar(20) DEFAULT NULL,
  `csc` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `isPrimaryPayment` tinyint(1) DEFAULT '0',
  `expirationMonth` char(2) DEFAULT NULL,
  `expirationYear` year(4) DEFAULT NULL,
  `nameOnCard` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`payId`),
  KEY `PaymentPerson_idx` (`personId`),
  CONSTRAINT `PaymentPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentmethods`
--

LOCK TABLES `paymentmethods` WRITE;
/*!40000 ALTER TABLE `paymentmethods` DISABLE KEYS */;
INSERT INTO `paymentmethods` VALUES (1,1,'5546662',202,'VISA',0,NULL,NULL,NULL),(2,1,'8876244',5555,'AMEX',0,NULL,NULL,NULL),(3,2,'5546633',443,'VISA',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `paymentmethods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `personId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `date` timestamp DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`personId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Jesse','Person',ENCRYPT('password', 'password'),'admin@msn.com',null, null),(2,'Joe','BuysStuff',ENCRYPT('not-secure','password'),'shirtsRgr8@yahoo.com',null, null),(3,'Norman','Moonshoes',ENCRYPT('w1nn1ng','password'),'webCeleb98@gmail.com',null, null);
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `permissionId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`permissionId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'ADD'),(2,'UPDATE'),(3,'DELETE');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priorities`
--

DROP TABLE IF EXISTS `priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `priorities` (
  `priorityId` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(50) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `distId` int(11) DEFAULT NULL,
  PRIMARY KEY (`priorityId`),
  KEY `PriorityDistributor_idx` (`distId`),
  CONSTRAINT `PriorityDistributor` FOREIGN KEY (`distId`) REFERENCES `distributors` (`distId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priorities`
--

LOCK TABLES `priorities` WRITE;
/*!40000 ALTER TABLE `priorities` DISABLE KEYS */;
INSERT INTO `priorities` VALUES (1,'First Class',5,1),(2,'Standard',6,2),(3,'Two Day',15,2);
/*!40000 ALTER TABLE `priorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `typeId` int(11) DEFAULT NULL,
  `colorId` int(11) DEFAULT NULL,
  `sizeId` int(11) DEFAULT NULL,
  `designId` int(11) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `supplierId` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `ProductColor_idx` (`colorId`),
  KEY `ProductSize_idx` (`sizeId`),
  KEY `ProductDesign_idx` (`designId`),
  KEY `ProductCategory_idx` (`categoryId`),
  KEY `ProductSupplier_idx` (`supplierId`),
  CONSTRAINT `ProductCategory` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ProductColor` FOREIGN KEY (`colorId`) REFERENCES `colors` (`colorId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ProductDesign` FOREIGN KEY (`designId`) REFERENCES `designs` (`designId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ProductSize` FOREIGN KEY (`sizeId`) REFERENCES `sizes` (`sizeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ProductSupplier` FOREIGN KEY (`supplierId`) REFERENCES `suppliers` (`supplierId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,2,3,3,1,1,50,20),(2,2,3,1,3,1,1,25,20),(3,2,1,2,2,2,1,50,20);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sizes` (
  `sizeId` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`sizeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizes`
--

LOCK TABLES `sizes` WRITE;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` VALUES (1,'S'),(2,'M'),(3,'L'),(4,'XL');
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `subscriptionId` int(11) NOT NULL AUTO_INCREMENT,
  `personId` int(11) DEFAULT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `addrId` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`subscriptionId`),
  KEY `SubscriptionPerson_idx` (`personId`),
  CONSTRAINT `SubscriptionPerson` FOREIGN KEY (`personId`) REFERENCES `people` (`personId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,1,2,1,'2016-10-05'),(2,2,1,2,'2016-09-25');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `supplierId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`supplierId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Alibaba','Jack Ma');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `typeId` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`typeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'O Neck'),(2,'V Neck');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-28 14:57:43
