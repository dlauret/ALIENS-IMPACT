-- Progettazione Web 
DROP DATABASE if exists pweb_myproject; 
CREATE DATABASE pweb_myproject; 
USE pweb_myproject; 
-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: pweb_myproject
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `max_score`
--

DROP TABLE IF EXISTS `max_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `max_score` (
  `IDUser` int(11) NOT NULL,
  `Max_Score` int(11) DEFAULT '0',
  `Time` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`IDUser`),
  KEY `IDUser` (`IDUser`),
  CONSTRAINT `IDUser` FOREIGN KEY (`IDUser`) REFERENCES `user` (`IDUser`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `max_score`
--

LOCK TABLES `max_score` WRITE;
/*!40000 ALTER TABLE `max_score` DISABLE KEYS */;
INSERT INTO `max_score` VALUES (1,320,'0:36'),(2,180,'0:35'),(3,200,'0:23'),(4,0,'0'),(5,260,'0'),(6,0,'0');
/*!40000 ALTER TABLE `max_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `IDUser` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Country` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IDUser`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Dario314','dario@gmail.com','$2y$10$3Ltgh2erroiEoSBDAGfGt.NF8hv3.Y0QepQNFMLYPDLWHQMmPkhdG','Italy'),(2,'Mario123','mario1@gmail.com','$2y$10$X3xXIzuyiQhXjhJUtv2bhOL1YS0zOA1LZwuyRqjyGAmobsewBLZ4q','Italy'),(3,'Will123','will2@gmail.com','$2y$10$1z59GspEsiYPmX4VC1HM0OLpeV3hHQv7hqkKrVPzwl.PTwZMfuQhy','USA'),(4,'James99','james@outlook.com','$2y$10$D/D5GKFa7s91TRocBWAOmeitSDMaeQNw8tS9F8ZUjuP.W5W/wOQVG','UK'),(5,'Gio16','giogio@email.com','$2y$10$4Zw2xpIAUK0lzcDngNfTEO9iZFk/Ek8HUt0Y9yeAkh7gP57tEAkRS','France'),(6,'Victor_12','vicvic@email.com','$2y$10$yGeFl.hAjwrvZ4YdpTFROusQMSFnImTrzVSOxc4YZ0VzbaqQgl6V2','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-25 16:48:20
