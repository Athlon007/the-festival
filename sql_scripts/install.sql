-- MySQL dump 10.13  Distrib 8.0.32, for macos13.0 (arm64)
--
-- Host: haarlemfestival.mysql.database.azure.com    Database: development
-- ------------------------------------------------------
-- Server version	5.7.40-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `addressId` int(11) NOT NULL AUTO_INCREMENT,
  `streetName` varchar(100) NOT NULL,
  `houseNumber` varchar(10) NOT NULL,
  `postalCode` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  PRIMARY KEY (`addressId`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (5,'Spelderholt','213 ','1025BM','Amsterdam','Netherlands'),(11,'Poelenburg','254','1504NL','Zaandam','Netherlands'),(13,'Zijlsingel','2','2013DN','Haarlem','Netherlands'),(14,'Nieuwe Kerksplein','22','2011ZT','Haarlem','Netherlands'),(16,'Grote Markt','16','2011RD','Haarlem','Netherlands'),(17,'Grote Markt','16','2011RD','Haarlem','Netherlands'),(18,'Grote Houtstraat','142','2011SV','Haarlem','Netherlands'),(19,'Gedempte Voldersgracht','2','2011 WD','Haarlem','Netherlands'),(20,'Begijnhof','28','2011HE','Haarlem','Netherlands'),(21,'Papentorenvest','1','2011AV','Haarlem','Netherlands'),(22,'','','2011BZ','Haarlem','Netherlands'),(23,'','','2011BZ','Haarlem','Netherlands'),(24,'','','2011BZ','Haarlem','Netherlands'),(25,'Gedempte Herensingel','58','2032NT','Haarlem','Netherlands'),(26,'Wijde Appelaarsteeg','11','2011HB','Haarlem','Netherlands'),(27,'Spelderholt','213','1025BM','Amsterdam','Netherlands'),(28,'Zijlsingel','2','2013DN','Haarlem','Netherlands'),(29,'Grote Markt','17','2011RC','Haarlem','Netherlands'),(30,'Zijlsingel','2','2013DN','Haarlem','Netherlands'),(31,'de Blankenstraat','3','2377VB','Oude Wetering','Netherlands'),(32,'Street','1 ','1234AB','City','Netherlands'),(33,'Bijdorplaan','15','2015CE','Haarlem','Netherlands');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artistkinds`
--

DROP TABLE IF EXISTS `artistkinds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artistkinds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artistkinds`
--

LOCK TABLES `artistkinds` WRITE;
/*!40000 ALTER TABLE `artistkinds` DISABLE KEYS */;
INSERT INTO `artistkinds` VALUES (1,'Jazz'),(2,'DANCE!');
/*!40000 ALTER TABLE `artistkinds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bannerimages`
--

DROP TABLE IF EXISTS `bannerimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bannerimages` (
  `imageId` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  PRIMARY KEY (`imageId`,`pageId`),
  UNIQUE KEY `imageId` (`imageId`,`pageId`),
  KEY `FK_Page_Id_Banner` (`pageId`),
  CONSTRAINT `FK_ImageId` FOREIGN KEY (`imageId`) REFERENCES `images` (`imageId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Page_Id_Banner` FOREIGN KEY (`pageId`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bannerimages`
--

LOCK TABLES `bannerimages` WRITE;
/*!40000 ALTER TABLE `bannerimages` DISABLE KEYS */;
INSERT INTO `bannerimages` VALUES (1,1),(2,1),(4,4),(27,5),(6,11),(7,15);
/*!40000 ALTER TABLE `bannerimages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `userId` int(11) NOT NULL,
  `dateOfBirth` datetime NOT NULL,
  `phoneNumber` varchar(32) NOT NULL,
  `addressId` int(11) NOT NULL,
  PRIMARY KEY (`userId`),
  KEY `userId` (`userId`),
  KEY `customers_FK` (`addressId`),
  CONSTRAINT `customers_FK` FOREIGN KEY (`addressId`) REFERENCES `addresses` (`addressId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (33,'1998-04-16 00:00:00','0612312312',11),(40,'2000-03-12 00:00:00','12346789675',32);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `eventId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `festivalEventType` int(11) DEFAULT NULL,
  `availableTickets` int(11) DEFAULT NULL,
  PRIMARY KEY (`eventId`),
  KEY `events_FK` (`festivalEventType`),
  CONSTRAINT `events_FK` FOREIGN KEY (`festivalEventType`) REFERENCES `festivaleventtypes` (`eventTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Gumbo Kings','2023-07-27 18:00:00','2023-07-27 19:00:00',1,300),(2,'A Stroll Through History','2023-07-27 10:00:00','2023-07-27 12:30:00',3,12),(4,'A Stroll Through History','2023-07-27 13:00:00','2023-07-27 15:30:00',3,12),(7,'Ntjam Rosie','2023-07-27 21:00:00','2023-07-27 22:00:00',1,300),(8,'Gumbo Kings','2023-07-30 19:00:00','2023-07-30 20:00:00',1,2000),(14,'Jazz Pass Thursday','2023-07-27 02:00:00','2023-07-27 02:00:00',1,0),(15,'Jazz Pass Friday','2023-07-28 02:00:00','2023-07-28 02:00:00',1,0),(16,'Jazz Pass Saturday','2023-07-29 02:00:00','2023-07-29 02:00:00',1,0),(17,'Jazz Pass Sunday','2023-07-30 02:00:00','2023-07-30 02:00:00',1,0),(18,'Jazz Pass All Days','2023-07-27 02:00:00','2023-07-27 02:00:00',1,0),(19,'Gare du Nord','2023-07-29 18:00:00','2023-07-29 19:00:00',1,300),(20,'Gare du Nord','2023-07-30 20:00:00','2023-07-30 21:00:00',1,2000),(21,'The Nordanians','2023-07-29 19:30:00','2023-07-29 20:30:00',1,150),(22,'The Nordanians','2023-07-30 18:00:00','2023-07-30 19:00:00',1,2000),(23,'Evolve','2023-07-27 19:30:00','2023-07-27 20:30:00',1,300),(24,'Evolve','2023-07-30 17:00:00','2023-07-30 18:00:00',1,2000),(26,'Wicked Jazz Sounds','2023-07-30 16:00:00','2023-07-30 17:00:00',1,2000),(27,'Tom Thomson Assemble','2023-07-27 19:30:00','2023-07-27 20:30:00',1,200),(28,'Jonna Fraser','2023-07-27 21:00:00','2023-07-27 22:00:00',1,200),(29,'Fox &amp; The Mayors','2023-07-28 18:00:00','2023-07-28 19:00:00',1,300),(30,'Uncle Sue','2023-07-28 19:30:00','2023-07-28 20:30:00',1,300),(31,'Kris Allen','2023-07-28 21:00:00','2023-07-28 22:00:00',1,300),(32,'Myles Sanko','2023-07-28 18:00:00','2023-07-28 19:00:00',1,200),(33,'Ruis Soundsystem','2023-07-28 19:30:00','2023-07-28 20:30:00',1,200),(34,'Ruis Soundsystem','2023-07-30 15:00:00','2023-07-30 16:00:00',1,2000),(35,'The Family XL','2023-07-28 21:00:00','2023-07-28 22:00:00',1,200),(36,'Rilan &amp; The Bombardiers','2023-07-29 19:30:00','2023-07-29 20:30:00',1,300),(37,'Soul Six','2023-07-29 21:00:00','2023-07-29 22:00:00',1,300),(38,'Han Bennink','2023-07-29 18:00:00','2023-07-29 19:00:00',1,150),(39,'Lilth Merlot','2023-07-29 21:00:00','2023-07-29 22:00:00',1,150),(42,'Wicked Jazz Sounds','2023-07-27 18:00:00','2023-07-27 19:00:00',1,200);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `festivaleventtypes`
--

DROP TABLE IF EXISTS `festivaleventtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `festivaleventtypes` (
  `eventTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `VAT` decimal(3,2) NOT NULL,
  PRIMARY KEY (`eventTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `festivaleventtypes`
--

LOCK TABLES `festivaleventtypes` WRITE;
/*!40000 ALTER TABLE `festivaleventtypes` DISABLE KEYS */;
INSERT INTO `festivaleventtypes` VALUES (1,'Haarlem Jazz',0.09),(2,'Yummy',0.21),(3,'Stroll Through History',0.21),(4,'DANCE!',0.09);
/*!40000 ALTER TABLE `festivaleventtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foodtype`
--

DROP TABLE IF EXISTS `foodtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foodtype` (
  `typeId` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`typeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foodtype`
--

LOCK TABLES `foodtype` WRITE;
/*!40000 ALTER TABLE `foodtype` DISABLE KEYS */;
INSERT INTO `foodtype` VALUES (1,'French'),(2,'Fish and Seefood');
/*!40000 ALTER TABLE `foodtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guides` (
  `guideId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`guideId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guides`
--

LOCK TABLES `guides` WRITE;
/*!40000 ALTER TABLE `guides` DISABLE KEYS */;
INSERT INTO `guides` VALUES (1,'Susan','Can','English',NULL),(2,'Annet','Marry','Dutch',NULL),(3,'Kim','Huang','Chinese',NULL);
/*!40000 ALTER TABLE `guides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historyevents`
--

DROP TABLE IF EXISTS `historyevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historyevents` (
  `eventId` int(11) NOT NULL AUTO_INCREMENT,
  `guideId` int(11) DEFAULT NULL,
  `locationId` int(11) DEFAULT NULL,
  PRIMARY KEY (`eventId`),
  KEY `guideId` (`guideId`),
  KEY `locationId` (`locationId`),
  CONSTRAINT `historyevents_ibfk_1` FOREIGN KEY (`guideId`) REFERENCES `guides` (`guideId`),
  CONSTRAINT `historyevents_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historyevents`
--

LOCK TABLES `historyevents` WRITE;
/*!40000 ALTER TABLE `historyevents` DISABLE KEYS */;
INSERT INTO `historyevents` VALUES (2,1,2),(4,2,2);
/*!40000 ALTER TABLE `historyevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(128) NOT NULL,
  `alt` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`imageId`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'/img/jpg/BACKGROUND.jpg','Visit Haarlem'),(2,'/img/jpg/background2.jpg','Visit Haarlem'),(3,'/img/jpg/food-home.jpg','Food'),(4,'/img/png/image_5.png','The Festival'),(5,'/img/jpg/EDM_1.jpg','Dance!'),(6,'/img/jpg/Jazz.jpg','Haarlem Jazz'),(7,'/img/jpg/History.jpg','A Stroll Through Haarlem'),(8,'/img/jpg/Erva-Cafe-Restaurant-Haarlem_1.jpg','Yummy!'),(9,'/img/jpg/teylers.jpg','The Teyler Mystery'),(10,'/img/jpg/bg.jpg','Ntjam Rosie'),(11,'/img/jpg/763.jpg','Ntjam Rosie'),(12,'/img/jpg/52958_Ntjam_Rosie_21293.jpg','Ntjam Rosie'),(13,'/img/jpg/52958_Ntjam_Rosie_20954.jpg','Ntjam Rosie'),(14,'/img/jpg/xxx830_650_0b3c7bb625295828f620e41c3c11858d.jpg','Gumbo Kings'),(15,'/img/jpg/Gumbo-Kings.jpg','Gumbo Kings'),(16,'/img/jpg/Nordanians-1.jpg','The Nordanians'),(17,'/img/jpg/HaarlemGroteMarkt1.JPG','St. Bavo Church'),(18,'/img/jpg/brouwerij-restaurant-jopenkerk-haarlem-jopenbier_4082379069.jpg','Jopenkerk Beer'),(19,'/img/jpg/Frame_21.jpg','Grote Markt'),(20,'/img/jpg/Frame_212.jpg','De Hallen'),(21,'/img/jpg/Frame_307.jpg','Jopenkerk'),(22,'/img/jpg/Frame_21(1).jpg','Proveniershof'),(23,'/img/jpg/Frame_21(2).jpg','Waalse Kerk'),(24,'/img/jpg/Frame_21(3).jpg','Molen de Adriaan'),(25,'/img/jpg/Frame_21(4).jpg','Amsterdamse Poort'),(26,'/img/jpg/Frame_21(5).jpg','Hof van Bakenes'),(27,'/img/jpg/image_6.jpg','Music &amp; Dance'),(28,'/img/jpg/Image.jpg','Haarlem Jazz'),(29,'/img/jpg/Image(1).jpg','Stadsschouwburg &amp; Philharmonie Haarlem'),(30,'/img/jpg/Image(2).jpg','Patronaat'),(31,'/img/jpg/bottom.jpg','Bottom Music &amp; Dance'),(32,'/img/jpg/history(1).jpg','History'),(34,'/img/jpg/history(2).jpg','Art'),(35,'/img/jpg/kids.jpg','Kids'),(36,'/img/jpg/imgcounter.jpg','Image Counter'),(37,'/img/jpg/Gare_du_Nord_1082.jpg','Gare du Nord'),(38,'/img/jpg/GdN_presspic_Staand-scaled-e1649839659934.jpg','Gare du Nord'),(39,'/img/jpg/Gare_Du_Nord.jpg','Gare du Nord'),(40,'/img/jpg/gare.jpg','Gare du Nord'),(41,'/img/jpg/Nordanians-1(1).jpg','The Nordanians'),(42,'/img/jpg/33036422_2199605456721417_3092494307022602240_n.jpg','The Nordanians'),(43,'/img/jpg/Nordanians-2.jpg','The Nordanians'),(44,'/img/jpg/images0.persgroep.jpg','Wicked Jazz Sounds'),(45,'/img/jpg/Jonna-Fraser-Photo-Credit-Orrin-Jaarsveld-1.jpg','Jonna Fraser'),(46,'/img/jpg/maxresdefault-1.jpg','Jonna Fraser'),(47,'/img/jpg/Wicked-jazz-sounds-podium-1024x675.jpg','Wicked Jazz Sounds'),(49,'/img/webp/Uncle-Sue-bandfoto-10.webp','Uncle Sue'),(50,'/img/webp/Uncle-Sue-podium-22.webp','Uncle Sue'),(51,'/img/webp/Uncle-Sue-podium-16.webp','Uncle Sue'),(52,'/img/png/BCF8428E-5A1E-4B5F-AC44-F085A629C731.png','Kris Allen'),(53,'/img/jpg/myles-sanko-1140x642.jpg','Myles Sanko'),(54,'/img/jpg/cb65da9a8be1899ff923b166c9ad9dd4.jpg','Myles Sanko'),(55,'/img/jpg/15_Myles-Sanko.jpg','Myles Sanko'),(56,'/img/jpg/22254979_2030325053855095_5034947054993221983_o.jpg','The Family XL'),(57,'/img/jpg/22221507_2030324933855107_2469730967042660850_n.jpg','The Family Xl'),(58,'/img/jpg/b33fc364-46df-47f9-88fe-9986b11c54d0_thumb1440.jpg','Rilan &amp; The Bombardiers'),(59,'/img/jpg/data36752617-547464.jpg','Rilan &amp; The Bombardiers'),(60,'/img/jpg/69650218_3211291552244922_6963147898221494272_n.jpg','Soul Six'),(61,'/img/jpg/72074381_3326183484089061_6188742728994521088_n.jpg','Soul Six'),(62,'/img/jpg/72421516_3326183677422375_6121295065089310720_n.jpg','Soul Six'),(63,'/img/jpg/1280px-Anderson,_Bennink,_Glerum,_van_Kemenade_02.jpg','Han Bennink'),(64,'/img/jpg/Han_Bennink,_Canada_2015_DSC_1125.jpg','Han Bennink'),(65,'/img/jpg/cf31f2_1209ac9c542e4d81938e380d2a0e2273~mv2.jpg','Lilth Merlot'),(66,'/img/jpg/copyrights-RONA-LANE-50.jpg','Lilth Merlot');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `invoiceId` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `paymentDeadline` datetime DEFAULT NULL,
  `isPaid` tinyint(1) DEFAULT NULL,
  `invoiceDate` datetime DEFAULT NULL,
  PRIMARY KEY (`invoiceId`),
  KEY `invoices_FK` (`orderId`),
  CONSTRAINT `invoices_FK` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jazzartistimage`
--

DROP TABLE IF EXISTS `jazzartistimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jazzartistimage` (
  `imageId` int(11) NOT NULL,
  `artistId` int(11) NOT NULL,
  KEY `FK_ArtistImageIdToImageId` (`imageId`),
  KEY `FK_ArtistToArtistId` (`artistId`),
  CONSTRAINT `FK_ArtistImageIdToImageId` FOREIGN KEY (`imageId`) REFERENCES `images` (`imageId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ArtistToArtistId` FOREIGN KEY (`artistId`) REFERENCES `jazzartists` (`artistId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jazzartistimage`
--

LOCK TABLES `jazzartistimage` WRITE;
/*!40000 ALTER TABLE `jazzartistimage` DISABLE KEYS */;
INSERT INTO `jazzartistimage` VALUES (37,8),(38,8),(39,8),(40,8),(41,9),(42,9),(43,9),(45,15),(46,15),(44,13),(49,17),(50,17),(51,17),(52,18),(53,19),(54,19),(55,19),(56,21),(57,21),(58,22),(59,22),(61,23),(62,23),(60,23),(63,24),(64,24),(65,25),(66,25),(10,7),(11,7),(12,7),(13,7),(14,1),(15,1);
/*!40000 ALTER TABLE `jazzartistimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jazzartists`
--

DROP TABLE IF EXISTS `jazzartists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jazzartists` (
  `artistId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `recentAlbums` varchar(255) DEFAULT NULL,
  `genres` varchar(255) DEFAULT NULL,
  `country` varchar(127) DEFAULT NULL,
  `homepageUrl` varchar(2048) DEFAULT NULL,
  `facebookUrl` varchar(2048) DEFAULT NULL,
  `twitterUrl` varchar(2048) DEFAULT NULL,
  `instagramUrl` varchar(2048) DEFAULT NULL,
  `spotifyUrl` varchar(2048) DEFAULT NULL,
  `artistKindId` int(11) NOT NULL,
  PRIMARY KEY (`artistId`),
  KEY `FK_ArtistToArtistKindId` (`artistKindId`),
  CONSTRAINT `FK_ArtistToArtistKindId` FOREIGN KEY (`artistKindId`) REFERENCES `artistkinds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jazzartists`
--

LOCK TABLES `jazzartists` WRITE;
/*!40000 ALTER TABLE `jazzartists` DISABLE KEYS */;
INSERT INTO `jazzartists` VALUES (1,'Gumbo Kings','The Gumbo Kings are a five-member band from the Netherlands known for their blend of soul, rhythm and blues, and swamp rock. &lt;br&gt;&lt;br&gt;They have released a self-titled debut album and are known for incorporating elements of 70s soul-funk, 80s drum computers, and synth soundscapes into their music. The band tours frequently and has gained a loyal fanbase and critical acclaim.','I wonder, Gumbo Kings, Changes Somehow','Soul, Rhythm &amp; Blues','The Netherlands','','https://www.facebook.com/thegumbokings','','https://www.instagram.com/gumbokings','https://open.spotify.com/artist/1j0vpirnPJTpjYHRAInw3n',1),(7,'Ntjam Rosie','Ntjam Rosie is a Cameroonian-Dutch singer and songwriter known for blending jazz, funk, and Afrobeat in her music.&lt;br&gt;&lt;br&gt;She has released multiple critically acclaimed albums and tours internationally, performing at various venues and festivals. Rosie promotes social justice and equality through her music and message.','Home Cooking, Family &amp; Friends, Breaking Cycles','Jazz, Soul','The Netherlands','','https://www.facebook.com/ntjamrosiemusic/','https://twitter.com/NtjamRosie','https://www.instagram.com/ntjamrosie/','https://open.spotify.com/artist/44XhJ4fcKrMzrVr6WpF69R',1),(8,'Gare du Nord','Gare du Nord is a Dutch band that was formed in 1998 and plays a mix of jazz, funk, soul, and pop. &lt;br&gt;&lt;br&gt;â€¨â€¨The band&#039;s lineup consists of vocalist Martijn ten Velden, saxophonist Ben Hazleton, keyboardist Jan van Duikeren, bassist Bart Wirtz, drummer Paul Willemen, and percussionist Tijs Klaverstijn. Gare du Nord has released several successful albums and toured extensively, performing at venues and festivals worldwide.','Play, Sex &#039;N&#039; Jazz, Rende Vous','Jazz, Funk, Soul, Pop','The Netherlands, Belgium','','https://www.facebook.com/garedunord','','','https://open.spotify.com/artist/0fvpn2k7FymYHxEx5U5FpP?autoplay=true',1),(9,'The Nordanians','When Oene van Geel viola, Mark Tuinstra guitar and Niti Ranjan Biswas tabla virtuoso played together for the first time there where immediately fireworks, roaring u-turns and cinematic tearjerkers. Then they started writing songs together based on traditional ragas, smashing funk and delicate chamber music.&lt;br&gt;&lt;br&gt;This gave them a great new impulse on stage for even more interaction and improvisation and made them build a rocking live reputation. They love to play with the three of them but they also play with special guests from around the globe such as Fraser Fifield whistle / pipes, Jorg Brinkmann cello, Maarten Ornstein bass clarinet, Theo Loevendie sop sax, Druba Ghosh sarangi, Bruno Ferro Xavier da Silva bass guitar, Barbara Schilstra (vocals), Bao Sisoko (kora) and Benedicte Maurseth hardanger fiddle.','Tabla Rasa','Jazz','The Netherlands','','https://www.facebook.com/Nordanians/','','','https://open.spotify.com/artist/2euGZQXIbIpW8OlRrdVZhf',1),(12,'Evolve','','','','','','','','','',1),(13,'Wicked Jazz Sounds','Wicked Jazz Sounds is an Amsterdam-based event organisation that has become a platform for music lovers. The two founders Phil Horneman and Manne van der Zee started a club night in 2002 where DJs and live musicians improvised together on a dancefloor-focused mix of funk, soul, hip-hop, house, jazz and more.','','Funk, Soul, Hip Hop, House, Jazz','The Netherlands','','https://www.facebook.com/wickedjazzsounds/','','https://www.instagram.com/wickedjazz/','https://open.spotify.com/artist/0JhIXbP3aPERorDqoKu3BF',1),(14,'Tom Thomson Assemble','','','','','','','','','',1),(15,'Jonna Fraser','Jonna Fraser, in full Jonathan Jeffrey Grando, is a Dutch rapper and singer of Surinamese descent. He has a broad nederhop style that ranges from gangsta rap to sultry soul. He released several albums, including Goed teken which managed to reach the eleventh position of the album chart. The single Do or die, which he recorded with rap formation Broederliefde, reached number 10 in 2016. He is also part of the rap collective New Wave, which won the 2015 Pop Award. ','Championships, Champagne Rain, Calma','Pop, Nederhop, Rap','The Netherlands','','https://www.facebook.com/jonnafraser','https://twitter.com/jonnafraser','https://www.instagram.com/jonnafraser','https://open.spotify.com/artist/5adKMaYrGOMyOfnbiLPuHg',1),(16,'Fox &amp; The Mayors','','','','','','','','','',1),(17,'Uncle Sue','Uncle Sue is a seven-piece Haarlem Funk and Soul Band with its own story, soul diva and swinging horn section. &lt;br&gt;Quirky repertoire, from their own studio and slightly less obvious gems by our musical heroes. A sound that harks back to the 60s and 70s. That&#039;s where Uncle Sue feels at home. This is reflected in their own retro look. Tight in suits with classy energetic singer. Think Sharon Jones &amp; the Dap Kings, Bamboos, Slim Moore, James Brown, Amy Winehouse, Beck, Trombone Shorty, Otis Redding et al.','New Dimension Of Life','Funk, Soul','The Netherlands','','https://www.facebook.com/unclesue/','','','https://open.spotify.com/artist/61Oa2dakzgX5019WmmsRg8',1),(18,'Kris Allen','Kris Allen is a singer-songwriter and musician known for his soulful voice and heartfelt lyrics. Born in Jacksonville, Arkansas, Kris rose to national fame as the winner of the eighth season of American Idol in 2009. Since then, he has released several successful albums, including his self-titled debut album, &quot;Kris Allen,&quot; and his latest release, &quot;Letting You In.&quot;&lt;br&gt;&lt;br&gt;Kris has toured extensively throughout the United States and internationally, performing at festivals, theaters, and arenas. His live shows are a dynamic mix of acoustic guitar-driven pop-rock, bluesy ballads, and soulful R&amp;B. Kris is known for his ability to connect with his audience, delivering powerful and emotional performances that leave a lasting impression.','10, Letting You In, Horizons','Pop rock, Alternative rock, Soul','United States of America','','https://www.facebook.com/KrisAllen','','','https://open.spotify.com/artist/2zwHaEmXxX6DTv4i8ajNCM',1),(19,'Myles Sanko','Myles Sanko is a British soul singer and songwriter known for his smooth and soulful voice, captivating lyrics, and dynamic live performances. Born in Ghana and raised in the UK, Myles draws inspiration from a wide range of musical genres, including jazz, funk, and soul.&lt;br&gt;&lt;br&gt;With his distinctive sound and engaging stage presence, Myles has gained a loyal following around the world, touring extensively across Europe, Asia, and the Americas. His live shows are a mesmerizing fusion of soulful melodies, powerful vocals, and tight rhythms, leaving audiences spellbound and craving more.','Forever Dreaming, Born in Black &amp; White','Jazz, Funk, Soul','British','','https://www.facebook.com/mylessankofanpage','','https://www.instagram.com/mylessanko/','https://open.spotify.com/artist/0EeY17gAdOJIBjNrpi6q1G?autoplay=true',1),(20,'Ruis Soundsystem','','','','','','','','','',1),(21,'The Family XL','','','','','','','','','',1),(22,'Rilan &amp; The Bombardiers','Rilan &amp; the Bombardiers is characterised by its eclectic style of pop, funk, rap, rythm-and-blues. The energetic live show and frontman Rilan&#039;s charismatic and unique performance make sure you won&#039;t forget a gig any time soon.','Walking On Fire, Drowning','Soul, Rock, Funk','The Netherlands','','https://www.facebook.com/RilanandtheBombardiers/?locale=nl_NL','','','https://open.spotify.com/artist/1yawxcvEJTTtsz2aX3yruE',1),(23,'Soul Six','','','','','','','','','',1),(24,'Han Bennink','Han Bennink is a Dutch jazz drummer and percussionist known for his dynamic and innovative style, fearless improvisation, and irreverent humor. Born in Zaandam, Netherlands, Han began his music career in the 1960s, performing with jazz legends like Eric Dolphy and Dexter Gordon.&lt;br&gt;&lt;br&gt;With his unique approach to drumming and percussion, Han has pushed the boundaries of jazz, experimenting with a wide range of sounds and techniques, from traditional swing to free jazz and avant-garde. He is known for his ability to blend different rhythms and styles, creating a dynamic and unpredictable musical experience.','Home Safely, Icarus, Welcome Back','Jazz','The Netherlands','','','https://twitter.com/han_bennink','https://www.instagram.com/hanbennink/','https://open.spotify.com/artist/0tmLlnSIrAb8NZajutucCC',1),(25,'Lilth Merlot','Lilith Merlot is known for her warm and deep voice with a timeless feel. Growing up in a family of classically trained professional musicians, Lilith was enchanted by the beauty of harmony and melody from a very young age.','Easier to Fight, Speak Your Heart','R&amp;B, Soul, Jazz, Pop','The Netherlands','','https://www.facebook.com/lilithmerlot/','','https://www.instagram.com/lilithmerlot/','https://open.spotify.com/artist/1aj2btWZXYFQP5KhTKGO0s',1);
/*!40000 ALTER TABLE `jazzartists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jazzevents`
--

DROP TABLE IF EXISTS `jazzevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jazzevents` (
  `eventId` int(11) NOT NULL,
  `artistId` int(11) NOT NULL,
  `locationId` int(11) NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `FK_JazzEventArtistId` (`artistId`),
  KEY `FK_JazzEventLocationId` (`locationId`),
  CONSTRAINT `FK_JazzEventArtistId` FOREIGN KEY (`artistId`) REFERENCES `jazzartists` (`artistId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JazzEventEventId` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JazzEventLocationId` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jazzevents`
--

LOCK TABLES `jazzevents` WRITE;
/*!40000 ALTER TABLE `jazzevents` DISABLE KEYS */;
INSERT INTO `jazzevents` VALUES (1,1,1),(7,7,1),(8,1,13),(19,8,1),(20,8,13),(21,9,14),(22,9,13),(23,12,1),(24,12,13),(26,13,13),(27,14,12),(28,15,12),(29,16,1),(30,17,1),(31,18,1),(32,19,12),(33,20,12),(34,20,13),(35,21,12),(36,22,1),(37,23,1),(38,24,14),(39,25,14),(42,13,12);
/*!40000 ALTER TABLE `jazzevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `locationId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `addressId` int(11) NOT NULL,
  `locationType` int(11) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `lon` decimal(8,5) NOT NULL,
  `lat` decimal(7,5) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`locationId`),
  KEY `FK_LocationToAddressId` (`addressId`),
  CONSTRAINT `FK_LocationToAddressId` FOREIGN KEY (`addressId`) REFERENCES `addresses` (`addressId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Partonaat (Main Hall)',13,1,300,4.62871,52.38300,NULL),(2,'St. Bavo Church',14,3,0,4.62919,52.37719,'The Sint Bavokerk is the largest church in Haarlem. The St Bavo Church is also called the Grote Kerk and is popularly referred to as the old baaf.  The St Bavo church is already mentioned in documents from 1245. \nSince 1245, the church has expanded to its current size with seven bells and a beautiful tower. To this day, the St Bavo Church is the highest building in Haarlem.'),(3,'Grote Markt',16,3,0,4.63603,52.38113,'The market square features several works of art, including a statue honoring Laurenz Janszoon Coster, who is widely credited with inventing printing in the Netherlands.'),(4,'De Hallen',17,3,0,4.63603,52.38113,'De Hallen is a contemporary art museum hosting exhibitions featuring national and international artists. Exhibitions are held three times a year and focus on current developments in the visual arts.'),(7,'Waalse Kerk',20,3,0,4.63915,52.38254,'The Waalse Kerk is a Walloon church that was built in the 14th century. It has an upper gallery that was originally built for the Beguines who lived on the courtyard that still bears their name. '),(8,'Molen de Adriaan',21,3,0,4.64264,52.38377,'In 1778, a businessman from Amsterdam purchased an old defense tower in Haarlem and received permission to build a windmill on top of it. The tower was subsequently transformed into a windmill.'),(9,'Amsterdamse Poort',25,3,0,4.64733,52.38053,'The Amsterdamse Poort is a gate located in Haarlem. It is one of the original gates of the city\'s old defensive wall and has been well-preserved over the years. It is a significant part of Haarlem\'s history.'),(10,'Hof van Bakenes',26,3,0,4.63989,52.38146,'The Hofje van Bakenes is located on the Bakenessergracht and has two entrances. The main entrance is located on the Wijde Appelaarsteeg. The courtyard at this location is the oldest one in Haarlem.'),(12,'Patronaat (Second Hall)',28,1,200,4.62871,52.38300,NULL),(13,'Grote Markt',29,1,2000,4.63647,52.38170,NULL),(14,'Patronaat (Third Hall)',30,1,150,4.62871,52.38300,NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `navigationbaritems`
--

DROP TABLE IF EXISTS `navigationbaritems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `navigationbaritems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageId` int(11) NOT NULL,
  `parentNavId` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PageId` (`pageId`),
  KEY `PK_ParentId` (`parentNavId`),
  CONSTRAINT `FK_PageId` FOREIGN KEY (`pageId`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PK_ParentId` FOREIGN KEY (`parentNavId`) REFERENCES `navigationbaritems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `navigationbaritems`
--

LOCK TABLES `navigationbaritems` WRITE;
/*!40000 ALTER TABLE `navigationbaritems` DISABLE KEYS */;
INSERT INTO `navigationbaritems` VALUES (1,1,NULL,1),(2,4,NULL,2),(3,10,2,201),(4,11,2,202),(5,15,2,203),(6,18,2,204),(7,14,2,205),(8,5,NULL,3),(9,6,NULL,4),(10,7,NULL,5),(11,8,NULL,6),(12,9,NULL,7);
/*!40000 ALTER TABLE `navigationbaritems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `orderDate` datetime NOT NULL,
  `customerId` int(11) NOT NULL,
  `totalFullPrice` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`orderId`),
  KEY `orders_FK` (`customerId`),
  CONSTRAINT `orders_FK` FOREIGN KEY (`customerId`) REFERENCES `customers` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `href` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `href` (`href`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Home','/','/views/home/index.php'),(2,'Page Not Found','/404','/views/404.php'),(4,'Festival','/festival','/views/festival/index.php'),(5,'Music &amp; Dance','/music-and-dance','/views/home/music-and-dance.php'),(6,'Food','/food','/views/home/food.php'),(7,'History','/history','/views/home/history.php'),(8,'Art','/art','/views/home/art.php'),(9,'Kids','/kids','/views/home/kids.php'),(10,'Dance!','/festival/dance','/views/festival/dance.php'),(11,'Haarlem Jazz','/festival/jazz','/views/festival/jazz-and-more.php'),(13,'Yummy!','/editor/festival/yummy','/views/festival/yummy.php'),(14,'The Teyler Mystery','/festival/teyler-mystery','/views/festival/teyler-mystery.php'),(15,'A Stroll Through History','/festival/history-stroll-2',''),(18,'Yummy','/festival/yummy','/views/festival/food_Festival.php');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resettokens`
--

DROP TABLE IF EXISTS `resettokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resettokens` (
  `tokenId` int(11) NOT NULL AUTO_INCREMENT,
  `reset_token` varchar(100) NOT NULL,
  `sendTime` datetime NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`tokenId`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resettokens`
--

LOCK TABLES `resettokens` WRITE;
/*!40000 ALTER TABLE `resettokens` DISABLE KEYS */;
INSERT INTO `resettokens` VALUES (44,'96d7bb828f97746d5c0488022f298fad','2023-02-19 14:29:56','turkvedat0911@gmail.com'),(45,'023d916bbef32000c779dc5d2bad7edb','2023-02-19 14:40:07','turkvedat0911@gmail.com'),(46,'2dc802a3c2b8add9a8f1a47c21cd411a','2023-02-21 17:50:19','turkvedat0911@gmail.com'),(47,'406a81b3d8257209d7f01004bf5992a1','2023-02-21 18:27:21','turkvedat0911@gmail.com'),(48,'07773448b5e40c84355a63586961b565','2023-02-21 18:53:53','turkvedat0911@gmail.com'),(49,'b5d5d80b4fdf3ac2eced9497e854d512','2023-02-21 18:55:47','turkvedat0911@gmail.com'),(50,'182eca604d1c5fe88abbb1b34e0f4db9','2023-02-21 19:05:15','turkvedat0911@gmail.com'),(51,'346dc137a628f04f2903e2eb2af36367','2023-02-21 19:20:00','turkvedat0911@gmail.com'),(52,'ea87bd69b1c11081cae68ed79ed2128c','2023-02-21 19:35:41','turkvedat0911@gmail.com'),(53,'e239d1243385ec8ecb11a94dc97c40d4','2023-02-22 09:04:46','turkvedat0911@gmail.com'),(54,'c75448f68b215c33957401601703a765','2023-02-22 09:12:45','turkvedat0911@gmail.com'),(55,'95a429ef6a297979a39e89ad8dcb5a2a','2023-02-22 09:13:40','turkvedat0911@gmail.com'),(56,'e636ed2402cd9c270e571f38c7e29aff','2023-02-22 09:14:50','turkvedat0911@gmail.com'),(57,'6763b1249e427ca920fdf1e339f1e9f8','2023-02-22 10:28:46','turkvedat0911@gmail.com'),(58,'12b7d409c093fc712e449dc47ce788b6','2023-02-22 10:32:45','turkvedat0911@gmail.com'),(59,'c28c60469a9d3cb2179f192d8c7593ba','2023-02-22 10:41:49','joshua.andrea@hotmail.com'),(60,'ce74a70a956a46bdc017e5b5e15ee533','2023-02-22 10:45:55','joshua.andrea@hotmail.com'),(61,'6c8a8ba4dca93dac525b575ff26dc7ed','2023-02-22 10:50:01','turkvedat0911@gmail.com'),(62,'c43c4c97a23a4dcce3727824f00b51c8','2023-02-22 10:51:37','turkvedat0911@gmail.com'),(63,'ad3f799b15d3edc886e878274baa0152','2023-02-22 10:54:06','turkvedat0911@gmail.com'),(64,'a953c47b88a28f184066f4f3bc7044de','2023-02-22 10:54:35','turkvedat0911@gmail.com'),(65,'0682b74e490da50fb050cc66230c9c17','2023-02-22 10:55:34','joshua.andrea@hotmail.com'),(66,'8184d9d454bf3bc5f75ad2fe6d8b63b3','2023-02-22 10:57:21','turkvedat0911@gmail.com'),(67,'9dfbcde1ac3932cb008fb136c1df22e6','2023-02-22 10:59:48','turkvedat0911@gmail.com'),(68,'20e25595e21007236691bb719c1f6f9a','2023-02-22 11:39:36','turkvedat0911@gmail.com'),(69,'4c2d42e944bb6d770097958b62ce3afb','2023-02-25 09:58:59','turkvedat0911@gmail.com'),(70,'924ffb20d00976c85b9e992ae3d07a6e','2023-02-25 10:09:36','turkvedat0911@gmail.com'),(71,'ebfda86d16758901353f1a4f4014215e','2023-02-25 11:21:59','turkvedat0911@gmail.com'),(72,'9d273457b43f004b51c2effe8c2ad2f4','2023-02-25 13:35:56','turkvedat0911@gmail.com'),(73,'a882450e164f9ec7dad93d1a948ad1ad','2023-02-27 13:48:22','turkvedat0911@gmail.com'),(74,'dd466d728ee6ce546833abfb75ee4554','2023-02-27 13:48:28','turkvedat0911@gmail.com'),(75,'a62780c44391428d71a68e5ea14c03a4','2023-02-27 13:48:36','turkvedat0911@gmail.com'),(76,'b4a4d8315dd6d947b05f5db51c309b9e','2023-02-27 14:13:34','turkvedat0911@gmail.com'),(77,'bbe90f5f9681506e7cf72304a8b764ec','2023-02-27 14:14:37','turkvedat0911@gmail.com'),(78,'2800e73729a5555005901a996e820150','2023-02-27 14:21:16','turkvedat0911@gmail.com'),(79,'23740ee90fa7ea1ecc51611a73eb1c09','2023-02-27 14:21:34','turkvedat0911@gmail.com'),(80,'4f3cc1a657293c228e48fc94324363cd','2023-02-27 14:23:01','turkvedat0911@gmail.com'),(81,'499ba8cedbcd457df720d3b77204be70','2023-02-27 14:24:18','turkvedat0911@gmail.com'),(82,'21926d05cb30fd44f0a911bd69d06eba','2023-02-27 14:24:49','turkvedat0911@gmail.com'),(83,'1ba1c37899c34daf8e853ae6f75083b0','2023-02-28 11:22:08','turkvedat0911@gmail.com'),(84,'a9707575e44ffc14998926390e308b71','2023-03-04 14:01:13','turkvedat0911@gmail.com'),(85,'ce0dd866d423ce596a69d4501be1661e','2023-03-04 14:27:32','turkvedat0911@gmail.com'),(86,'cfa3e69c544241e0d284627ea2259d14','2023-03-04 14:31:58','turkvedat0911@gmail.com'),(87,'54a22f34eeb1088afa319fe985b4d099','2023-03-04 14:33:02','turkvedat0911@gmail.com'),(88,'55fa151704fb4572cd80e8f8977aa30b','2023-03-04 14:33:40','turkvedat0911@gmail.com'),(89,'7bfad14e179ff5f402090457e2172ed1','2023-03-04 14:35:43','turkvedat0911@gmail.com'),(90,'215f74274e6e13c0bfae37d36f0f7b99','2023-03-04 14:36:42','turkvedat0911@gmail.com'),(91,'c9aa00de76840ac3e63ec74ad48b7535','2023-03-04 14:37:05','turkvedat0911@gmail.com'),(92,'1dc838cc7491ca9b8947682cc2d30cef','2023-03-04 14:38:32','turkvedat0911@gmail.com'),(93,'58d367b4286a26bd1ee0eb93b6d7c2a6','2023-03-04 14:40:38','turkvedat0911@gmail.com'),(94,'fc8b1716c602fae90f837e36ee83c1b2','2023-03-04 14:42:09','turkvedat0911@gmail.com'),(95,'a89b9394c6ae12aa139fa2069b38e2cc','2023-03-15 08:51:16','turkvedat0911@gmail.com'),(96,'a8da393e37f62d470fff65ab11945af7','2023-03-15 10:43:25','turkvedat0911@gmail.com'),(97,'b0a320af17104fbf438acc281e0c52c0','2023-03-21 09:33:22','682474@student.inholland.nl'),(98,'4b1427936959571a27e866cc7d0fe563','2023-03-23 10:19:54','turkvedat0911@gmail.com'),(99,'60559f962a9dd6f40d8840bfe1f0290e','2023-04-11 07:37:16','turkvedat0911@gmail.com');
/*!40000 ALTER TABLE `resettokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurants` (
  `restaurantId` int(11) NOT NULL AUTO_INCREMENT,
  `restaurantName` varchar(100) NOT NULL,
  `addressId` int(11) NOT NULL,
  `numOfSessions` int(11) DEFAULT NULL,
  `durationOfSessions` time DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `AvailableSeats` int(11) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL,
  `rating` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`restaurantId`),
  KEY `restaurants_restaurantId_IDX` (`restaurantId`,`restaurantName`,`description`,`addressId`,`numOfSessions`,`durationOfSessions`) USING BTREE,
  KEY `restaurants_FK` (`typeId`),
  CONSTRAINT `restaurants_FK` FOREIGN KEY (`typeId`) REFERENCES `foodtype` (`typeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,'testresto',28,4,'01:30:00','test',45,20,1,4),(2,'Ratatouille',28,3,'02:00:00','The successful Michelin restaurant in Haarlem of chef Jozua Jaring is - like Ratatouille a mix of French cuisuine today\'s reality with excellent value for money in an accessible environment in Haarlem. This is how we started our restaurant Haarlem in 2013 in the Lange Veerstraat and this is how we continue at our unique monumental location at Het Spaarne with our restaurant in Haarlem after the move in 2015.',45,20,2,4);
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `strollhistoryticket`
--

DROP TABLE IF EXISTS `strollhistoryticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `strollhistoryticket` (
  `ticketId` int(11) NOT NULL AUTO_INCREMENT,
  `guideId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticketId`),
  KEY `guideId` (`guideId`),
  CONSTRAINT `strollhistoryticket_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `tickets` (`ticketId`),
  CONSTRAINT `strollhistoryticket_ibfk_2` FOREIGN KEY (`guideId`) REFERENCES `guides` (`guideId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `strollhistoryticket`
--

LOCK TABLES `strollhistoryticket` WRITE;
/*!40000 ALTER TABLE `strollhistoryticket` DISABLE KEYS */;
INSERT INTO `strollhistoryticket` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `strollhistoryticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `textpages`
--

DROP TABLE IF EXISTS `textpages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `textpages` (
  `textPageId` int(11) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`textPageId`),
  CONSTRAINT `FK_PK_Pages` FOREIGN KEY (`textPageId`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `textpages`
--

LOCK TABLES `textpages` WRITE;
/*!40000 ALTER TABLE `textpages` DISABLE KEYS */;
INSERT INTO `textpages` VALUES (1,'&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;&lt;img src=&quot;../img/jpg/imgcounter.jpg&quot; width=&quot;690&quot; height=&quot;145&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;\n&lt;h2&gt;Festival is in...&lt;/h2&gt;\n&lt;p id=&quot;countdown&quot;&gt;00:00:00:00&lt;br&gt;days hours minutes seconds&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;table style=&quot;color: var(--bs-body-color); font-family: var(--bs-body-font-family); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); background-color: var(--bs-body-bg); width: 100%; height: 787px; border-width: 0px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 292px;&quot;&gt;\n&lt;td style=&quot;height: 292px; border-width: 0px; padding: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/food-home.jpg&quot; alt=&quot;Food&quot; width=&quot;auto&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 292px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;New Title&lt;/h2&gt;\n&lt;p&gt;While visiting Haarlem you can&amp;acute;t miss out on the incredible food experience of Haarlem. Haarlem has food for everyone&amp;rsquo;s taste. From Dutch to Italian, from Michelin Star restaurants to everything the kids will like. In Haarlem, you will find what you crave.&lt;/p&gt;\n&lt;p&gt;&lt;a href=&quot;../food&quot; aria-invalid=&quot;true&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 351px;&quot;&gt;\n&lt;td style=&quot;height: 351px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;Music &amp;amp; Dance&lt;/h2&gt;\n&lt;p&gt;With the annual world-famous &lt;strong&gt;Festival&lt;/strong&gt;, Haarlem is a perfect place to experience top-class Jazz music. Visit Haarlem during the July, to enjoy it!&lt;br&gt;If jazz isn&amp;rsquo;t your thing, and you prefer the night life, visit one of the numerous night clubs, including the &lt;strong&gt;Patronaat&lt;/strong&gt;.&lt;br&gt;Or if you&amp;rsquo;re feeling fancy, come and enjoy the &lt;strong&gt;Stadsschouwburg &amp;amp; Philharmonie Haarlem&lt;/strong&gt;, in order to taste the top-notch orchestral music.&lt;/p&gt;\n&lt;p&gt;&lt;a href=&quot;../music-and-dance&quot; aria-invalid=&quot;true&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 351px; border-width: 0px; padding-top: 12px; padding-right: 12px; padding-bottom: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/Image.jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 48px;&quot;&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding-top: 12px; padding-right: 12px; padding-bottom: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/history(1).jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;History&lt;/h2&gt;\n&lt;p&gt;Haarlem, with roots dating back to the 10th century, is a city with a rich and storied history. Located on the banks of the Spaarne river in the Zuid-Kennemerland region, it has served as the capital of Noord Holland province for centuries.&lt;br&gt;&lt;br&gt;Haarlem first appears in literary sources in the 10th century. In the source, the place is mentioned under the name of &amp;rsquo;Haarlem&amp;rsquo;. Archaeological research shows that there was already habitation in the area of Spaarne 1500 years before our era.&lt;/p&gt;\n&lt;p&gt;&lt;a href=&quot;../music-and-dance&quot; aria-invalid=&quot;true&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 48px;&quot;&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;Art&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Haarlem is a city of aesthetic architecture and collections of masterpieces of world-famous artists. &lt;br&gt;&lt;br&gt;&lt;strong&gt;Dolhuys Museum of the Mind&lt;/strong&gt; is one of the most characteristic museums in this city in that it deals with the theme &amp;rsquo;mind&amp;rsquo;. &lt;br&gt;&lt;br&gt;If you are fascinated by dramatic stories and performances, then , you would better visit &lt;strong&gt;Theatre de liefde&lt;/strong&gt;, which allows you to meet a touching story and a fantastic view.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../art&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/history(2).jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 48px;&quot;&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/kids.jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px; text-align: center;&quot;&gt;\n&lt;h2&gt;Kids&lt;/h2&gt;\n&lt;p style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Haarlem is one of the most kid-friendly towns in the Netherlands. Large car-free zones in the city centre allow your children to run around in relative safety.&lt;br&gt;Of course, safety isn&amp;rsquo;t everything, there are many activities to do and places to visit that will keep your little ones entertained as well!&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../kids&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;div&gt;&lt;a href=&quot;../festival&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;The Festival&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/Image.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;Visit Haarlem during The Festival!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/div&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;strong&gt;The Festival &lt;/strong&gt;is an annual event held in Haarlem. &lt;br&gt;&lt;br&gt;The festival features a diverse lineup of &lt;strong&gt;concerts&lt;/strong&gt;, but also represents the city&amp;rsquo;s &lt;strong&gt;history&lt;/strong&gt;, and the &lt;strong&gt;culinary&lt;/strong&gt; aspect of the town. The festival takes place over several days in &lt;strong&gt;July&lt;/strong&gt; and includes both indoor and outdoor concerts, as well as tours and other events. The Festival attracts &lt;strong&gt;music&lt;/strong&gt;, &lt;strong&gt;culinary&lt;/strong&gt;, and&lt;strong&gt; history lovers&lt;/strong&gt; from all over the world and has become an important cultural event in the city.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;iframe src=&quot;https://www.instagram.com/visithaarlem/embed/&quot; width=&quot;100%&quot; height=&quot;480&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;'),(4,'&lt;table style=&quot;border-collapse: collapse; width: 100%; height: 726.266px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50.0471%;&quot;&gt;&lt;col style=&quot;width: 49.9529%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 362.733px;&quot;&gt;\n&lt;td style=&quot;height: 362.733px;&quot;&gt;&lt;a href=&quot;../festival/dance&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;DANCE!&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/EDM_1.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;We welcome you to the parties with the most hottest artists in the world!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 362.733px;&quot;&gt;&lt;a href=&quot;../festival/jazz&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;Haarlem Jazz&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/Jazz.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;The annual festival, representing one of the best Jazz players!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 363.533px;&quot;&gt;\n&lt;td style=&quot;height: 363.533px;&quot;&gt;&lt;a href=&quot;../festival/history-stroll-2&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;A Stroll Through Haarlem&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/History.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;Welcome to a city that is filled with historical monuments, spectacular museums and world-famous art!&amp;nbsp;&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 363.533px;&quot;&gt;&lt;a href=&quot;../festival/yummy&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;Yummy!&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/Erva-Cafe-Restaurant-Haarlem_1.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;These are all the Restaurant which are participating in the Haarlem Festival.&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;div&gt;&lt;a href=&quot;../festival/tyler-mystery&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;The&amp;nbsp;Teyler Mystery&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/teylers.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;Visit the Teyler&amp;rsquo;s Museum and solve the secret of Dr. Teyler!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/div&gt;\n&lt;h2&gt;Event Area&lt;/h2&gt;\n&lt;div id=&quot;mapContainer&quot; class=&quot;row&quot; data-mapkind=&quot;general&quot;&gt;&lt;/div&gt;\n&lt;h2&gt;Schedule&lt;/h2&gt;\n&lt;div id=&quot;calendar&quot; class=&quot;row&quot; data-calendar-type=&quot;all-events&quot;&gt;&lt;/div&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;'),(5,'&lt;p style=&quot;text-align: center;&quot;&gt;Haarlem is a city in the Netherlands known for its rich history and culture, including its music scene. The city has a long tradition of producing and fostering talented musicians. Experience it yourself!&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50.0362%;&quot;&gt;&lt;col style=&quot;width: 49.9639%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto;&quot; src=&quot;../img/jpg/Image.jpg&quot; width=&quot;646&quot; height=&quot;362&quot;&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto;&quot; src=&quot;../img/jpg/Image(1).jpg&quot; width=&quot;646&quot; height=&quot;362&quot;&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;h2&gt;Haarlem Jazz Festival&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;One of the most famous musical events in Haarlem is the annual &lt;strong&gt;Haarlem Jazz &amp;amp; More festival&lt;/strong&gt;, which brings together jazz and world music artists from around the globe. The festival, which has been held every summer since 1986, attracts thousands of music fans to the city&#039;s historic Grote Markt square.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival/jazz&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;h2&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Stadsschouwburg &amp;amp; Philharmonie Haarlem&lt;/span&gt;&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Looking for an unforgettable night of entertainment? Look no further than &lt;strong&gt;Stadsschouwburg &amp;amp; Philharmonie Haarlem&lt;/strong&gt;! Located in the heart of the city, our state-of-the-art theatre and concert hall is the perfect venue for experiencing the best in music, dance, theatre, and more.&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;h2&gt;&lt;img src=&quot;../img/jpg/Image(2).jpg&quot; width=&quot;646&quot; height=&quot;auto&quot;&gt;&lt;/h2&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;h2&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Patronaat&lt;br&gt;&lt;/span&gt;&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;strong&gt;Patronaat Haarlem&lt;/strong&gt; is a premier venue for live music and entertainment. With a capacity of over 1,000 people, it has the space to host some of the biggest and best names in the industry.&lt;br&gt;Their state-of-the-art sound and lighting systems ensure that every performance is an unforgettable experience. Whether you&#039;re a fan of rock, pop, electronic, or any other genre, they have something for everyone.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Browse Events&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/bottom.jpg&quot; width=&quot;100%&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h2&gt;...and more&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Haarlem&#039;s music scene is diverse and vibrant, offering something for every taste. Whether you&#039;re a classical music aficionado or a fan of more contemporary sounds, there is always something exciting happening in Haarlem&#039;s music scene.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Browse Events&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;'),(6,'&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1 style=&quot;text-align: center;&quot;&gt;Food&lt;/h1&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;You favorite Restaurants all in one place. From Dutch to Italien to Michelin Star restaurants Haarlem has it all. Have trouble deciding have a look at our recommendations.&lt;/p&gt;\n&lt;div class=&quot;container text-center border&quot;&gt;\n&lt;div class=&quot;row&quot;&gt;\n&lt;div class=&quot;col-6 border&quot;&gt;\n&lt;h3&gt;Michelin Star Restaurants&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Haarlem has 3 Michelin Star Restaurants. One of them is Ratatouille which has a mix frensh cuisine.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-warning&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6 border&quot;&gt;\n&lt;h3&gt;Restaurant With the Best View&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Da Dakka is on top of a parking garage which has 5 floors, which means the restaurant overlooks a big part of Haarlem.&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-warning&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;Haarlem&amp;rsquo;s Brewery Special Experience&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;Jopenkerk is a brewery which is build inside a church founded in 1998. Which brews bier with a recipe from 1407.Which makes a unique experience. Which the Citizens of Haarlem are really proud of.&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;hr&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div style=&quot;text-align: center;&quot;&gt;\n&lt;div class=&quot;btn-group&quot; style=&quot;text-align: center;&quot;&gt;&lt;button class=&quot;btn btn-secondary dropdown-toggle&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; data-bs-display=&quot;static&quot; aria-expanded=&quot;false&quot;&gt; Food Type &lt;/button&gt;\n&lt;ul class=&quot;dropdown-menu dropdown-menu-lg-end&quot;&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;/ul&gt;\n&lt;/div&gt;\n&lt;div class=&quot;btn-group&quot; style=&quot;text-align: center;&quot;&gt;&lt;button class=&quot;btn btn-secondary dropdown-toggle ms-5&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; data-bs-display=&quot;static&quot; aria-expanded=&quot;false&quot;&gt; Food Type &lt;/button&gt;&lt;/div&gt;\n&lt;div class=&quot;btn-group&quot; style=&quot;text-align: center;&quot;&gt;\n&lt;ul class=&quot;dropdown-menu dropdown-menu-lg-end&quot;&gt;\n&lt;li&gt;&amp;nbsp;&lt;/li&gt;\n&lt;li&gt;&amp;nbsp;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;/ul&gt;\n&lt;/div&gt;\n&lt;div&gt;\n&lt;div class=&quot;card&quot;&gt;\n&lt;h5 class=&quot;card-header&quot; style=&quot;text-align: center;&quot;&gt;Featured&lt;/h5&gt;\n&lt;div class=&quot;card-body&quot;&gt;\n&lt;div class=&quot;container text-center&quot;&gt;\n&lt;div class=&quot;row&quot;&gt;\n&lt;div class=&quot;col-4&quot;&gt;\n&lt;h2&gt;Ratatouille&lt;/h2&gt;\n&lt;p&gt;Chef Joshua Jaring&#039;s successful Michelin restaurant in Haarlem is &amp;ndash; just like Ratatouille &amp;ndash; a mix of French cuisine in today&#039;s reality with an excellent price-quality ratio in an accessible environment in Haarlem.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-warning&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-4&quot;&gt;way point and image&lt;/div&gt;\n&lt;div class=&quot;col-4&quot;&gt;image&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;'),(7,'&lt;h1 style=&quot;text-align: center;&quot;&gt;History&lt;/h1&gt;\n&lt;p&gt;Haarlem is a city in the Netherlands and the capital of the province of Noord Holland. The city is located on the river Spaarne and in the Zuid-Kennemerland region. Haarlem first appears in literary sources in the 10th century. In the source, the place is mentioned under the name of &amp;rsquo;Haralem&amp;rsquo;. Archaeological research shows that there was already habitation in the are of Spaarne 1500 years before our era.&lt;/p&gt;\n&lt;div class=&quot;container&quot;&gt;\n&lt;div class=&quot;row&quot;&gt;\n&lt;div class=&quot;col-6&quot;&gt;image 1&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;image 2&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;p&gt;Haarlem is an actient city and the nice thing about that is that there are also very old cafes. These are some cafes and bars where you might be shared the same memory with your grandmother, grandfather.&lt;/p&gt;\n&lt;div class=&quot;container&quot;&gt;\n&lt;div class=&quot;row&quot;&gt;\n&lt;div class=&quot;col-4&quot;&gt;\n&lt;figure&gt;&lt;img src=&quot;tiquet.png&quot; width=&quot;90&quot; height=&quot;150&quot;&gt;\n&lt;figcaption&gt;Grote Markt 13&lt;/figcaption&gt;\n&lt;/figure&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-4&quot;&gt;\n&lt;figure&gt;&lt;img src=&quot;tiquet.png&quot; width=&quot;90&quot; height=&quot;150&quot;&gt;\n&lt;figcaption&gt;Botermarkt 19&lt;/figcaption&gt;\n&lt;/figure&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-4&quot;&gt;\n&lt;figure&gt;&lt;img src=&quot;tiquet.png&quot; width=&quot;90&quot; height=&quot;150&quot;&gt;\n&lt;figcaption&gt;Gierstraat 78&lt;/figcaption&gt;\n&lt;/figure&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;'),(8,'&lt;h1 style=&quot;text-align: center;&quot;&gt;Art or no art is the question?&lt;/h1&gt;'),(9,'&lt;h1 style=&quot;text-align: center;&quot;&gt;Kids&lt;/h1&gt;\n&lt;div class=&quot;container&quot;&gt;\n&lt;div class=&quot;row border mt-5&quot;&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;Climbing Wall Haarlem&lt;/h3&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;image&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p class=&quot;fs-8&quot; style=&quot;text-align: center;&quot;&gt;The Climbing Wall is a fun way for children to spend an afternoon indoors, exercising! &lt;br&gt;&lt;br&gt;Afraid of heights or not, the Climbing Wall in Haarlem is a fun, safe activity that requires you to think on your feet and climb to the top! Afterwards, have a break at the restaurant on location.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-success&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;row border mt-5&quot;&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;Mister Paprika&lt;/h3&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;image&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;If you&amp;rsquo;re in the city centre, take a pit stop at &amp;ldquo;Meneer Paprika&amp;rdquo;, a cafe and toy shop in one! Tables are arranged around a huge toddler-height train set so you can keep an eye on your little ones wherever you&amp;rsquo;re sat.&lt;br&gt;&lt;br&gt;The cafe offers breakfast, lunch and dinner, as well as cake, or just something to drink.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-success&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;row border mt-5&quot;&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;The Teylers Museum&lt;/h3&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;image&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;Interactive, informative, and most important of all, loads of fun! Kids will love the Teylers Museum of Wonder. Fantastic fossils, preserved beasts, sparkling minerals and impressive gadgets are just some of the weird and wonderful items on display at this beautiful museum. &lt;br&gt;&lt;br&gt;During the Haarlem Festival, there is even a very fun treasure hunt just for children, you can find it on our website by pressing the button below!&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-success&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;'),(10,''),(11,'&lt;h2 style=&quot;text-align: center;&quot;&gt;Experience a fine Jazz (and not only)&lt;/h2&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;The Jazz &amp;amp; More Festival is a yearly event held in Haarlem. It features a diverse lineup of jazz and other musical performers, offering attendees the opportunity to experience a wide range of genres and styles.&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;The festival&#039;s mission is to bring top-quality musical performances to everyone, making it a must-attend event for music lovers.&lt;/p&gt;\n&lt;div id=&quot;allday-pass&quot; data-kind=&quot;jazz&quot;&gt;&lt;/div&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div id=&quot;events&quot; data-type=&quot;jazz&quot;&gt;&lt;/div&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;'),(13,''),(14,''),(15,'&lt;h1 style=&quot;text-align: center;&quot;&gt;Welcome to The Festival Haarlem&lt;/h1&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;h2&gt;Let&#039;s tour around Haarlem&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Welcome to a city that is filled with historical monuments, spectacular museums and world-famous art! Cars are not allowed on many streets in Haarlem which makes it a great city for a tour! &lt;br&gt;&lt;br&gt;We organise tours every day during The Festival Haarlem. &lt;br&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;\n&lt;h2&gt;Starting Point&lt;/h2&gt;\n&lt;p&gt;Bavo Church&lt;/p&gt;\n&lt;p&gt;(Age 12+)&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;\n&lt;h2&gt;Time&lt;/h2&gt;\n&lt;p&gt;Every festival day:&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;10:00&lt;/li&gt;\n&lt;li&gt;13:00&lt;/li&gt;\n&lt;li&gt;16:00&lt;/li&gt;\n&lt;/ul&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;div id=&quot;events&quot; data-type=&quot;stroll&quot;&gt;&lt;/div&gt;\n&lt;div data-type=&quot;stroll&quot;&gt;&amp;nbsp;&lt;/div&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;--- During 2.5 hours, you will visit ---&lt;/h2&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 99.1336%; height: 334.4px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 23.17%;&quot;&gt;&lt;col style=&quot;width: 1.61136%;&quot;&gt;&lt;col style=&quot;width: 33.6735%;&quot;&gt;&lt;col style=&quot;width: 41.4723%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 334.4px;&quot;&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;&lt;img src=&quot;../img/jpg/HaarlemGroteMarkt1.JPG&quot; width=&quot;100%&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;\n&lt;h2&gt;St. Bavo Church&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Sint Bavokerk is the largest church in Haarlem. The St Bavo Church is also called the Grote Kerk and is popularly referred to as &amp;ldquo;the old baaf&amp;rdquo;. The St Bavo church is already mentioned in documents from 1245. &lt;br&gt;&lt;br&gt;Since 1245, the church has expanded to its current size with seven bells and a beautiful tower. To this day, the St Bavo Church is the highest building in Haarlem.&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;One drink per person&lt;/h2&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;../img/jpg/brouwerij-restaurant-jopenkerk-haarlem-jopenbier_4082379069.jpg&quot; width=&quot;264&quot; height=&quot;176&quot;&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;15 minute break at Jopenkerk&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%; height: 549.1px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 336.7px;&quot;&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21.jpg&quot; width=&quot;200px&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Grote Markt (B)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_212.jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;De Hallen (C)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(1).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Proveniershof (D)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_307.jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Jopenkerk (E)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 185.4px;&quot;&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;\n&lt;p&gt;The market square features several works of art, including a statue honoring Laurenz Janszoon Coster, who is widely credited with inventing printing in the Netherlands.&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;De Hallen is a contemporary art museum hosting exhibitions featuring national and international artists. Exhibitions are held three times a year and focus on current developments in the visual arts.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Proveniershof is a unique courtyard area in Haarlem, originally intended for the wealthy bourgeoisie. Its houses differ in appearance from other small courtyards in the area.&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The story Jopen begins in the 14th century when Haarlem was one of the most important brewing cities in the Netherlands. &lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 27px;&quot;&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(2).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h3&gt;Waalse Kerk (F)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(3).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Molen de Adriaan (G)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(4).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Amsterdamse Poort (H)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(5).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Hof van Bakenes&lt;/h3&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Waalse Kerk is a Walloon church that was built in the 14th century. It has an upper gallery that was originally built for the Beguines who lived on the courtyard that still bears their name. &lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;In 1778, a businessman from Amsterdam purchased an old defense tower in Haarlem and received permission to build a windmill on top of it. The tower was subsequently transformed into a windmill.&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Amsterdamse Poort is a gate located in Haarlem. It is one of the original gates of the city&#039;s old defensive wall and has been well-preserved over the years. It is a significant part of Haarlem&#039;s history.&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Hofje van Bakenes is located on the Bakenessergracht and has two entrances. The main entrance is located on the Wijde Appelaarsteeg. The courtyard at this location is the oldest one in Haarlem.&lt;/span&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/h2&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;--- Haarlem in Maps ---&lt;/h2&gt;\n&lt;p&gt;&lt;iframe src=&quot;https://www.google.com/maps/d/u/0/embed?mid=1R3EC9xY6xPNKRIk0CG3kO20wrgsPMHc&amp;amp;ehbc=2E312F&quot; width=&quot;100%&quot; height=&quot;480&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;\n&lt;div id=&quot;calendar&quot; class=&quot;row&quot; data-calendar-type=&quot;stroll&quot;&gt;&lt;/div&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;');
/*!40000 ALTER TABLE `textpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketlinks`
--

DROP TABLE IF EXISTS `ticketlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticketlinks` (
  `ticketLinkId` int(11) NOT NULL,
  `ticketTypeId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  PRIMARY KEY (`ticketLinkId`),
  KEY `ticketlinks_FK_1` (`eventId`),
  KEY `ticketlinks_FK` (`ticketTypeId`),
  CONSTRAINT `ticketlinks_FK` FOREIGN KEY (`ticketTypeId`) REFERENCES `tickettypes` (`ticketTypeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ticketlinks_FK_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that links types of tickets to events for which they can be bought';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketlinks`
--

LOCK TABLES `ticketlinks` WRITE;
/*!40000 ALTER TABLE `ticketlinks` DISABLE KEYS */;
INSERT INTO `ticketlinks` VALUES (1,1,2),(2,2,2),(3,1,4),(4,2,4),(5,4,1),(6,4,7),(7,6,8),(8,7,14),(9,7,15),(10,7,16),(11,7,17),(12,8,18),(13,4,19),(14,6,20),(15,9,21),(16,6,22),(17,4,23),(18,6,24),(20,6,26),(21,5,27),(22,5,28),(23,4,29),(24,4,30),(26,5,32),(27,5,33),(28,6,34),(29,5,35),(30,4,36),(31,4,37),(32,9,38),(33,9,39),(36,5,42);
/*!40000 ALTER TABLE `ticketlinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `ticketId` int(11) NOT NULL AUTO_INCREMENT,
  `qr_code` varchar(255) DEFAULT NULL,
  `eventId` int(11) DEFAULT NULL,
  `isScanned` tinyint(1) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `basePrice` decimal(6,2) NOT NULL,
  `vat` decimal(3,2) NOT NULL,
  `fullPrice` decimal(6,2) NOT NULL,
  `ticketTypeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticketId`),
  KEY `tickets_FK` (`orderId`),
  KEY `tickets_ibfk_1` (`eventId`),
  KEY `tickets_FK_1` (`ticketTypeId`),
  CONSTRAINT `tickets_FK` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON UPDATE CASCADE,
  CONSTRAINT `tickets_FK_1` FOREIGN KEY (`ticketTypeId`) REFERENCES `tickettypes` (`ticketTypeId`) ON UPDATE CASCADE,
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Table for sold, generated tickets, belonging to orders.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'ABC123',1,0,NULL,0.00,0.00,15.00,4),(2,'ABC123',1,0,NULL,0.00,0.00,15.00,4),(3,'ABC123',2,0,NULL,0.00,0.00,17.50,1);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickettypes`
--

DROP TABLE IF EXISTS `tickettypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickettypes` (
  `ticketTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `ticketTypeName` varchar(100) NOT NULL,
  `ticketTypePrice` decimal(6,2) NOT NULL,
  `nrOfPeople` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ticketTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Table for types of tickets that can be linked to events in cartitems table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettypes`
--

LOCK TABLES `tickettypes` WRITE;
/*!40000 ALTER TABLE `tickettypes` DISABLE KEYS */;
INSERT INTO `tickettypes` VALUES (1,'Single',17.50,1),(2,'Family',60.00,4),(3,'Yummy - Reservation',10.00,1),(4,'Jazz - Patronaat Main Hall',15.00,1),(5,'Jazz - Patronaat Second Hall',10.00,1),(6,'Jazz - Grote Markt',0.00,1),(7,'Jazz - One-Day Pass',35.00,1),(8,'Jazz - All-Day Pass',80.00,1),(9,'Jazz - Patronaat Third Hall',10.00,1);
/*!40000 ALTER TABLE `tickettypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `hashPassword` varchar(256) NOT NULL,
  `firstName` varchar(256) NOT NULL,
  `lastName` varchar(256) NOT NULL,
  `userType` int(1) NOT NULL,
  `registrationDate` date DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (23,'682474@student.inholland.nl','$2y$10$H80FBpRiTBsBHkxChIgw0e051d5XYa2Akxd1WQLOZunUIPd5cYR16','Roby','Trierweiler',1,'2023-03-01'),(27,'turkvedat0911@gmail.com','$2y$10$l0A92t2H/NKDoVZOSFWl6eyqXNTsS8I4BqoFsrOOvHQ6qDuVM1UAG','Vedat','TÃ¼rk',1,'2023-03-02'),(33,'joshua.andrea@hotmail.com','$2y$10$HfB7MwtaQoFwz0kSjC6lq.WUQQ.4Q1DZJHvF6r6aeLBc5o6vVWsle','Joshua','Andrea',3,'2023-03-03'),(37,'aathlon@outlook.com','$2y$10$AA5Kbo7kJeGq0NM9PdSe5.TCsLdDVPpqGqclkRWQAUNJp6wmfBIy6','Konrad','Figura',1,'2023-04-03'),(38,'mail@example.com','$2y$10$IAHPjz.E4G7nZEQhOwykvumCoLeAWzCQtUjQJJK5FiQFcScXOAlsu','Ben','Dover',2,'2023-04-04'),(40,'2mail@example.com','$2y$10$qUGFt7BwlSkx1sYDLruWHeG4wLSE5Y9GkPF6uqQFUeyiTTM6mOHI.','A','B',3,'2023-04-11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'development'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-14 14:05:52
