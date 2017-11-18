-- MySQL dump 10.13  Distrib 5.7.11, for Win64 (x86_64)
--
-- Host: localhost    Database: lesson16db
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Мобильные телефоны','Широкий выбор мобильных телефонов (смартфонов) самых популярных брендов. Top модели, а так же бюджетные варианты.','/img/category/1.jpg',3,1),(2,'Ноутбуки','Самый широкий выбор моделей ноутбуков, нетбуков на любой вкус.','/img/category/2.jpg',2,1),(5,'Планшеты','Лучший выбор планшетов (tablets) среди всех Интернет магазинов','/img/category/5.png',1,1),(6,'Флеш накопители','У нас самые лучше и вместительные флешки во всем Интернете!!!','',4,1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_category_id` (`category_id`) USING BTREE,
  KEY `idx_active` (`active`),
  CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,1,'Samsung','Самый крутой телефон этого года','',123.45,1),(2,1,'Apple iPhone 5s','','',990.99,1),(3,1,'Apple iPhone 6','','',999.99,1),(4,2,'Air','','',999999.00,1),(5,2,'HP ProBook 6560b','','',5999.00,1),(6,2,'Asus Zen Book','','',9999.00,1),(7,2,'HP Compaq','','',3999.00,1),(8,2,'Aser','','',1999.00,1),(9,5,'iPad Air 2','','',26999.00,1),(10,5,'iPad Air','','',16999.00,1),(11,5,'Samsung Tab A 8','','',6777.00,1),(12,5,'Samsung Note A 10','','',9799.00,1),(13,5,'Aser','','',2999.00,1),(15,1,'Nokia','Не разбивается от ударов об стенку - проверено','',99.17,1);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `goods` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,4,1,999999.00),(2,4,2,999999.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` varchar(128) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'new','2017-10-25 17:55:08'),(2,1,'new','2017-10-25 17:56:18');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `registeredDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','taras@shkodenko.com','2017-10-25 16:46:07',1,0,'$2y$11$RVM3cFZOUXlLVDBhVHk1Vu4ed.iIFZmxbI7MMjc2E4SzqmzjgQ2Ne\n','ES7pVNQyKT0aTy5WnGzyXLA5kZf7ihSfnBmw4dv4zEo=',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-25 21:03:48
