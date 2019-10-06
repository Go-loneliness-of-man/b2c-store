-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: localhost    Database: ddtj
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dd`
--

DROP TABLE IF EXISTS `dd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `dd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `sid` varchar(100) DEFAULT NULL,
  `count` varchar(100) DEFAULT NULL,
  `ms` varchar(1000) DEFAULT NULL,
  `kd` char(40) DEFAULT NULL,
  `kddh` char(50) DEFAULT NULL,
  `phone` char(60) DEFAULT NULL,
  `price` char(50) DEFAULT NULL,
  `prices` int(11) DEFAULT NULL,
  `zf` char(10) DEFAULT NULL,
  `zfstate` int(11) DEFAULT NULL,
  `mailstate` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `mailto` varchar(300) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `bz` varchar(300) DEFAULT NULL,
  `pl` varchar(900) DEFAULT NULL,
  `pltime` datetime DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dd`
--

LOCK TABLES `dd` WRITE;
/*!40000 ALTER TABLE `dd` DISABLE KEYS */;
INSERT INTO `dd` VALUES (2,13,'39,63,92,130','2,2,2,1','样式：亮黑色；手机内存和磁盘空间大小：3GB 32GB；;;;;;;;;;;样式：黄色；;;;;;样式：蓝色；','werwr','sdfsfs','123456789','1998,13998,58,129',16183,'wx',1,1,1,'中国','2019-08-08 13:34:36','','很好，非常不错','2019-08-10 21:26:14',4),(6,13,'144','2','衣服尺码：XL；','qweqwe','asdasd','123456789','168',168,'wx',1,1,1,'中国','2019-08-10 21:27:40','','衣服很好','2019-08-10 21:44:54',5),(8,13,'113,72','2,1','样式：黑色；;;;;;pc 配置：i7 16G 1050MAX-Q 256G；','sadsa','sdf','123456789','33.8,7599',7633,'wx',1,1,1,'中国','2019-08-10 21:44:33','','太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好太好','2019-08-11 15:59:30',5),(9,13,'63','1','','asdf','szdvdsf','123456789','6999',6999,'wx',1,1,1,'中国','2019-08-11 15:38:56','','真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好真好','2019-08-11 15:59:16',5),(10,13,'130','2','样式：蓝色；','erwd','sdfdf','123456789','258',258,'wx',1,1,1,'中国','2019-08-11 15:39:48','','好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好好','2019-08-11 15:59:03',5),(11,13,'72','1','pc 配置： i5 8G 1050MAX-Q 256G；','sadfdf','sdf','123456789','6299',6299,'wx',1,1,1,'中国','2019-08-11 15:40:25','','很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好很好','2019-08-11 15:54:14',5),(12,13,'69','2','','erttz','sdfsdf','123456789','5398',5398,'wx',1,1,1,'中国','2019-08-12 21:01:20','','未评论',NULL,0),(13,13,'69','2','','wadsa','awsdasd','123456789','5398',5398,'wx',1,1,1,'中国','2019-08-12 21:04:12','','未评论',NULL,0),(14,13,'143,124,128','3,1,1','衣服尺码：XL；;;;;;眼镜框形状：方框；;;;;;','wd','asd','123456789','177,249,99',525,'wx',1,1,1,'中国','2019-08-12 21:17:39','','未评论',NULL,0),(15,13,'109','2','样式：白色；','124','ad','123456789','3998',3998,'wx',1,1,1,'中国','2019-08-14 23:03:49','','未评论',NULL,0),(16,13,'127','1','','asdas','asd','123456789','99',99,'wx',1,1,1,'中国','2019-08-14 23:09:56','','东西很好','2019-08-15 19:48:37',5),(17,13,'37','1','样式：暮光金；','asd	asd','asd','123456789','1599',1599,'wx',1,1,1,'中国','2019-08-15 23:57:59','','未评论',NULL,0);
/*!40000 ALTER TABLE `dd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tj`
--

DROP TABLE IF EXISTS `tj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tj` (
  `time` datetime NOT NULL,
  `money` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `csucs` int(11) DEFAULT NULL,
  `ucount` int(11) DEFAULT NULL,
  PRIMARY KEY (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tj`
--

LOCK TABLES `tj` WRITE;
/*!40000 ALTER TABLE `tj` DISABLE KEYS */;
INSERT INTO `tj` VALUES ('2019-08-14 00:00:00',5497,1,2,2),('2019-08-15 00:00:00',1599,1,1,0);
/*!40000 ALTER TABLE `tj` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-16  1:18:08
