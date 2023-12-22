-- MariaDB dump 10.19-11.2.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: account_management_db
-- ------------------------------------------------------
-- Server version	11.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES
(2,'bare coding contest','we are bare, the more you bare the more you win','1702916456.png','2023-12-19 00:20:56','2023-12-19 00:28:00'),
(3,'missing rice cooker','to those you borrowed our rice cooker please return it before the cooking contest','1703009822.jpg','2023-12-20 02:17:02','2023-12-20 02:17:02'),
(4,'the killer ice picks','if you want to stab without bleeding then you need our ice pick, strong and bleeding free.','1703009930.jpg','2023-12-20 02:18:50','2023-12-20 02:18:50');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowed`
--

DROP TABLE IF EXISTS `borrowed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrowed` (
  `borrow_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `date_borrowed` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`borrow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowed`
--

LOCK TABLES `borrowed` WRITE;
/*!40000 ALTER TABLE `borrowed` DISABLE KEYS */;
INSERT INTO `borrowed` VALUES
(2,12,1,3,'inactive','2023-12-20 01:27:22','2023-12-20 01:30:28'),
(3,12,3,5,'active','2023-12-20 01:28:44','2023-12-20 01:28:44'),
(4,12,2,4,'active','2023-12-20 01:29:05','2023-12-20 01:29:05'),
(5,12,1,4,'active','2023-12-20 01:45:12','2023-12-20 01:45:12');
/*!40000 ALTER TABLE `borrowed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `borrowed_items`
--

DROP TABLE IF EXISTS `borrowed_items`;
/*!50001 DROP VIEW IF EXISTS `borrowed_items`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `borrowed_items` AS SELECT
 1 AS `borrowed_id`,
  1 AS `user_id`,
  1 AS `item_id`,
  1 AS `item_name`,
  1 AS `item_img`,
  1 AS `qty`,
  1 AS `fullname`,
  1 AS `department`,
  1 AS `status`,
  1 AS `date_borrowed`,
  1 AS `date_updated` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Ryan','Gosling','literally me','BSIT','mefr','Admin'),
(2,'Ice','Spice','ice@spice.e','BSIT','asdasd','Admin'),
(3,'Hev','Abi','hev@abi.com','BSHM','Admin','Admin'),
(4,'City','Girls','city@girls.com','BSHM','student','Student'),
(5,'Skibidi','Gyatt','skibidi gyatt rizz','BEED','123456','Admin'),
(6,'Chae ','young','young@chae.boang','BSIT','asdasd','Student'),
(7,'new','jeans','oma oma godd kasu kasu wa','BEED','gyatt','Admin'),
(8,'21','Savagee','21@savage.com','BSED','bruh','Admin'),
(9,'Ryan','Gosling','Ryan goslling unsint a message.','BSIT','asdasd','Admin'),
(10,'Perrell','Brown','dreamy@is.perrell','BSHM','GYATTTT','student'),
(11,'Joren','Sumagang','sumagangjoren@gmail.com','BSIT','asdasd','student'),
(12,'Admin','Admin','admin@email.com','BSIT','asdasd','Admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilities`
--

DROP TABLE IF EXISTS `utilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilities` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_img` varchar(255) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `item_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_name` (`item_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilities`
--

LOCK TABLES `utilities` WRITE;
/*!40000 ALTER TABLE `utilities` DISABLE KEYS */;
INSERT INTO `utilities` VALUES
(3,'washing machine','1702998324.jpg',4,'active','2023-12-19 23:05:24','2023-12-20 01:35:46'),
(4,'rice cooker','1702999167.jpg',0,'active','2023-12-19 23:19:27','2023-12-20 01:45:12'),
(5,'ice pick','1702999640.jpg',7,'active','2023-12-19 23:27:20','2023-12-20 01:28:44'),
(6,'vacuum cleaner','1702999724.jpg',3,'active','2023-12-19 23:28:44','2023-12-19 23:28:44');
/*!40000 ALTER TABLE `utilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `borrowed_items`
--

/*!50001 DROP VIEW IF EXISTS `borrowed_items`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `borrowed_items` AS select `b`.`borrow_id` AS `borrowed_id`,`u`.`id` AS `user_id`,`u2`.`item_id` AS `item_id`,`u2`.`item_name` AS `item_name`,`u2`.`item_img` AS `item_img`,`b`.`qty` AS `qty`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `fullname`,`u`.`department` AS `department`,`b`.`status` AS `status`,`b`.`date_borrowed` AS `date_borrowed`,`b`.`date_updated` AS `date_updated` from ((`borrowed` `b` left join `users` `u` on(`u`.`id` = `b`.`user_id`)) left join `utilities` `u2` on(`u2`.`item_id` = `b`.`item_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-20  9:12:15
