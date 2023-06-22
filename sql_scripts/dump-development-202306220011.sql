-- MySQL dump 10.13  Distrib 8.0.33, for macos13.3 (arm64)
--
-- Host: haarlemfestival.mysql.database.azure.com    Database: development
-- ------------------------------------------------------
-- Server version	5.7.42-log

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (5,'Spelderholt','213 ','1025BM','Amsterdam','Netherlands');
INSERT INTO `addresses` VALUES (11,'Poelenburg','254','1504NL','Zaandam','Netherlands');
INSERT INTO `addresses` VALUES (13,'Zijlsingel','2','2013DN','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (14,'Nieuwe Kerksplein','22','2011ZT','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (16,'Grote Markt','16','2011RD','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (17,'Grote Markt','16','2011RD','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (18,'Grote Houtstraat','142','2011SV','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (19,'Gedempte Voldersgracht','2','2011 WD','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (20,'Begijnhof','28','2011HE','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (21,'Papentorenvest','1','2011AV','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (22,'','','2011BZ','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (23,'','','2011BZ','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (24,'','','2011BZ','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (25,'Gedempte Herensingel','58','2032NT','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (26,'Wijde Appelaarsteeg','11','2011HB','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (27,'Spelderholt','213','1025BM','Amsterdam','Netherlands');
INSERT INTO `addresses` VALUES (28,'Zijlsingel','2','2013DN','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (29,'Grote Markt','17','2011RC','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (30,'Zijlsingel','2','2013DN','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (31,'de Blankenstraat','3','2377VB','Oude Wetering','Netherlands');
INSERT INTO `addresses` VALUES (32,'Street','1 ','1234AB','City','Netherlands');
INSERT INTO `addresses` VALUES (33,'Bijdorplaan','15','2015CE','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (34,'Kromme Elleboogsteeg','20','2011TS','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (35,'Hoge Duin en Daalseweg','2','2061 AG','Bloemendaal','Netherlands');
INSERT INTO `addresses` VALUES (36,'Gedempte Voldersgracht','2','2011WD','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (37,'Minckelersweg','2','2031EM','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (38,'Smedestraat','31','2011RE','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (39,'Grote Markt','8','2011RD','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (40,'Kusocinskiego','4 A','26-600','Radom','Poland');
INSERT INTO `addresses` VALUES (41,'de Blankenstraat','3','2377VB','Oude Wetering','Netherlands');
INSERT INTO `addresses` VALUES (42,'','','','','');
INSERT INTO `addresses` VALUES (43,'de Blankenstraat','3','2377VB','Oude Wetering','Netherlands');
INSERT INTO `addresses` VALUES (44,'De Blankenstraat','3 ','2377VB','Oude Wetering','Netherlands');
INSERT INTO `addresses` VALUES (45,'de Blankenstraat','3','2377VB','Oude Wetering','Netherlands');
INSERT INTO `addresses` VALUES (47,'Klokhuisplein','9','2011 HK','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (48,'Spaarne','96','2011 CL','Haarlem','Netherlands');
INSERT INTO `addresses` VALUES (49,'De Blankenstraat','3 ','2377VB','Oude Wetering','Netherlands');
INSERT INTO `addresses` VALUES (50,'de Blankenstraat','3 ','2377VB','Oude Wetering','Netherlands');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apikeys`
--

DROP TABLE IF EXISTS `apikeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apikeys` (
  `apiKeyId` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`apiKeyId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apikeys`
--

LOCK TABLES `apikeys` WRITE;
/*!40000 ALTER TABLE `apikeys` DISABLE KEYS */;
INSERT INTO `apikeys` VALUES (1,'af55cW1am9DlsOvofE4yXaBQtCTEXNDR','Api Key 1');
INSERT INTO `apikeys` VALUES (5,'DYBJ79OKHtx2ieJdEpH9zamT1SqNfnxC','API Key 2');
/*!40000 ALTER TABLE `apikeys` ENABLE KEYS */;
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
INSERT INTO `artistkinds` VALUES (1,'Jazz');
INSERT INTO `artistkinds` VALUES (2,'DANCE!');
/*!40000 ALTER TABLE `artistkinds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artists` (
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artists`
--

LOCK TABLES `artists` WRITE;
/*!40000 ALTER TABLE `artists` DISABLE KEYS */;
INSERT INTO `artists` VALUES (1,'Gumbo Kings','The Gumbo Kings are a five-member band from the Netherlands known for their blend of soul, rhythm and blues, and swamp rock. &lt;br&gt;&lt;br&gt;They have released a self-titled debut album and are known for incorporating elements of 70s soul-funk, 80s drum computers, and synth soundscapes into their music. The band tours frequently and has gained a loyal fanbase and critical acclaim.','I wonder, Gumbo Kings, Changes Somehow','Soul, Rhythm &amp; Blues','The Netherlands','','https://www.facebook.com/thegumbokings','','https://www.instagram.com/gumbokings','https://open.spotify.com/artist/1j0vpirnPJTpjYHRAInw3n',1);
INSERT INTO `artists` VALUES (7,'Ntjam Rosie','Ntjam Rosie is a Cameroonian-Dutch singer and songwriter known for blending jazz, funk, and Afrobeat in her music.&lt;br&gt;&lt;br&gt;She has released multiple critically acclaimed albums and tours internationally, performing at various venues and festivals. Rosie promotes social justice and equality through her music and message.','Home Cooking, Family &amp; Friends, Breaking Cycles','Jazz, Soul','The Netherlands','','https://www.facebook.com/ntjamrosiemusic/','https://twitter.com/NtjamRosie','https://www.instagram.com/ntjamrosie/','https://open.spotify.com/artist/44XhJ4fcKrMzrVr6WpF69R',1);
INSERT INTO `artists` VALUES (8,'Gare du Nord','Gare du Nord is a Dutch band that was formed in 1998 and plays a mix of jazz, funk, soul, and pop. &lt;br&gt;&lt;br&gt;â€¨â€¨The band&#039;s lineup consists of vocalist Martijn ten Velden, saxophonist Ben Hazleton, keyboardist Jan van Duikeren, bassist Bart Wirtz, drummer Paul Willemen, and percussionist Tijs Klaverstijn. Gare du Nord has released several successful albums and toured extensively, performing at venues and festivals worldwide.','Play, Sex &#039;N&#039; Jazz, Rende Vous','Jazz, Funk, Soul, Pop','The Netherlands, Belgium','','https://www.facebook.com/garedunord','','','https://open.spotify.com/artist/0fvpn2k7FymYHxEx5U5FpP?autoplay=true',1);
INSERT INTO `artists` VALUES (9,'The Nordanians','When Oene van Geel viola, Mark Tuinstra guitar and Niti Ranjan Biswas tabla virtuoso played together for the first time there where immediately fireworks, roaring u-turns and cinematic tearjerkers. Then they started writing songs together based on traditional ragas, smashing funk and delicate chamber music.&lt;br&gt;&lt;br&gt;This gave them a great new impulse on stage for even more interaction and improvisation and made them build a rocking live reputation. They love to play with the three of them but they also play with special guests from around the globe such as Fraser Fifield whistle / pipes, Jorg Brinkmann cello, Maarten Ornstein bass clarinet, Theo Loevendie sop sax, Druba Ghosh sarangi, Bruno Ferro Xavier da Silva bass guitar, Barbara Schilstra (vocals), Bao Sisoko (kora) and Benedicte Maurseth hardanger fiddle.','Tabla Rasa','Jazz','The Netherlands','','https://www.facebook.com/Nordanians/','','','https://open.spotify.com/artist/2euGZQXIbIpW8OlRrdVZhf',1);
INSERT INTO `artists` VALUES (12,'Evolve','','','','','','','','','',1);
INSERT INTO `artists` VALUES (13,'Wicked Jazz Sounds','Wicked Jazz Sounds is an Amsterdam-based event organisation that has become a platform for music lovers. The two founders Phil Horneman and Manne van der Zee started a club night in 2002 where DJs and live musicians improvised together on a dancefloor-focused mix of funk, soul, hip-hop, house, jazz and more.','','Funk, Soul, Hip Hop, House, Jazz','The Netherlands','','https://www.facebook.com/wickedjazzsounds/','','https://www.instagram.com/wickedjazz/','https://open.spotify.com/artist/0JhIXbP3aPERorDqoKu3BF',1);
INSERT INTO `artists` VALUES (14,'Tom Thomson Assemble','','','','','','','','','',1);
INSERT INTO `artists` VALUES (15,'Jonna Fraser','Jonna Fraser, in full Jonathan Jeffrey Grando, is a Dutch rapper and singer of Surinamese descent. He has a broad nederhop style that ranges from gangsta rap to sultry soul. He released several albums, including Goed teken which managed to reach the eleventh position of the album chart. The single Do or die, which he recorded with rap formation Broederliefde, reached number 10 in 2016. He is also part of the rap collective New Wave, which won the 2015 Pop Award. ','Championships, Champagne Rain, Calma','Pop, Nederhop, Rap','The Netherlands','','https://www.facebook.com/jonnafraser','https://twitter.com/jonnafraser','https://www.instagram.com/jonnafraser','https://open.spotify.com/artist/5adKMaYrGOMyOfnbiLPuHg',1);
INSERT INTO `artists` VALUES (16,'Fox &amp; The Mayors','','','','','','','','','',1);
INSERT INTO `artists` VALUES (17,'Uncle Sue','Uncle Sue is a seven-piece Haarlem Funk and Soul Band with its own story, soul diva and swinging horn section. &lt;br&gt;Quirky repertoire, from their own studio and slightly less obvious gems by our musical heroes. A sound that harks back to the 60s and 70s. That&#039;s where Uncle Sue feels at home. This is reflected in their own retro look. Tight in suits with classy energetic singer. Think Sharon Jones &amp; the Dap Kings, Bamboos, Slim Moore, James Brown, Amy Winehouse, Beck, Trombone Shorty, Otis Redding et al.','New Dimension Of Life','Funk, Soul','The Netherlands','','https://www.facebook.com/unclesue/','','','https://open.spotify.com/artist/61Oa2dakzgX5019WmmsRg8',1);
INSERT INTO `artists` VALUES (18,'Kris Allen','Kris Allen is a singer-songwriter and musician known for his soulful voice and heartfelt lyrics. Born in Jacksonville, Arkansas, Kris rose to national fame as the winner of the eighth season of American Idol in 2009. Since then, he has released several successful albums, including his self-titled debut album, &quot;Kris Allen,&quot; and his latest release, &quot;Letting You In.&quot;&lt;br&gt;&lt;br&gt;Kris has toured extensively throughout the United States and internationally, performing at festivals, theaters, and arenas. His live shows are a dynamic mix of acoustic guitar-driven pop-rock, bluesy ballads, and soulful R&amp;B. Kris is known for his ability to connect with his audience, delivering powerful and emotional performances that leave a lasting impression.','10, Letting You In, Horizons','Pop rock, Alternative rock, Soul','United States of America','','https://www.facebook.com/KrisAllen','','','https://open.spotify.com/artist/2zwHaEmXxX6DTv4i8ajNCM',1);
INSERT INTO `artists` VALUES (19,'Myles Sanko','Myles Sanko is a British soul singer and songwriter known for his smooth and soulful voice, captivating lyrics, and dynamic live performances. Born in Ghana and raised in the UK, Myles draws inspiration from a wide range of musical genres, including jazz, funk, and soul.&lt;br&gt;&lt;br&gt;With his distinctive sound and engaging stage presence, Myles has gained a loyal following around the world, touring extensively across Europe, Asia, and the Americas. His live shows are a mesmerizing fusion of soulful melodies, powerful vocals, and tight rhythms, leaving audiences spellbound and craving more.','Forever Dreaming, Born in Black &amp; White','Jazz, Funk, Soul','British','','https://www.facebook.com/mylessankofanpage','','https://www.instagram.com/mylessanko/','https://open.spotify.com/artist/0EeY17gAdOJIBjNrpi6q1G?autoplay=true',1);
INSERT INTO `artists` VALUES (20,'Ruis Soundsystem','','','','','','','','','',1);
INSERT INTO `artists` VALUES (21,'The Family XL','','','','','','','','','',1);
INSERT INTO `artists` VALUES (22,'Rilan &amp; The Bombardiers','Rilan &amp; the Bombardiers is characterised by its eclectic style of pop, funk, rap, rythm-and-blues. The energetic live show and frontman Rilan&#039;s charismatic and unique performance make sure you won&#039;t forget a gig any time soon.','Walking On Fire, Drowning','Soul, Rock, Funk','The Netherlands','','https://www.facebook.com/RilanandtheBombardiers/?locale=nl_NL','','','https://open.spotify.com/artist/1yawxcvEJTTtsz2aX3yruE',1);
INSERT INTO `artists` VALUES (23,'Soul Six','','','','','','','','','',1);
INSERT INTO `artists` VALUES (24,'Han Bennink','Han Bennink is a Dutch jazz drummer and percussionist known for his dynamic and innovative style, fearless improvisation, and irreverent humor. Born in Zaandam, Netherlands, Han began his music career in the 1960s, performing with jazz legends like Eric Dolphy and Dexter Gordon.&lt;br&gt;&lt;br&gt;With his unique approach to drumming and percussion, Han has pushed the boundaries of jazz, experimenting with a wide range of sounds and techniques, from traditional swing to free jazz and avant-garde. He is known for his ability to blend different rhythms and styles, creating a dynamic and unpredictable musical experience.','Home Safely, Icarus, Welcome Back','Jazz','The Netherlands','','','https://twitter.com/han_bennink','https://www.instagram.com/hanbennink/','https://open.spotify.com/artist/0tmLlnSIrAb8NZajutucCC',1);
INSERT INTO `artists` VALUES (25,'Lilth Merlot','Lilith Merlot is known for her warm and deep voice with a timeless feel. Growing up in a family of classically trained professional musicians, Lilith was enchanted by the beauty of harmony and melody from a very young age.','Easier to Fight, Speak Your Heart','R&amp;B, Soul, Jazz, Pop','The Netherlands','','https://www.facebook.com/lilithmerlot/','','https://www.instagram.com/lilithmerlot/','https://open.spotify.com/artist/1aj2btWZXYFQP5KhTKGO0s',1);
INSERT INTO `artists` VALUES (26,'Martin Garrix','Much Martin, Many Garrix','','Dance, Electronic','Netherlands','','','https://twitter.com/martingarrix','https://www.instagram.com/martingarrix/','https://open.spotify.com/artist/60d24wfXkVzDSfLS6hyCjZ',2);
INSERT INTO `artists` VALUES (27,'Armin van Buuren','','','Trance, Techno','Netherlands','','','','','',2);
INSERT INTO `artists` VALUES (28,'Hardwell','','','Dance, House','Netherlands','','','','','',2);
INSERT INTO `artists` VALUES (29,'TiÃ«sto','','','Trance, Techno, Minimal, House, Electronic','Netherlands','','','','','',2);
INSERT INTO `artists` VALUES (30,'Afrojack','','','House','Netherlands','','','','','',2);
INSERT INTO `artists` VALUES (31,'Nicky Romero','','','Electronic, House','Netherlands','','','','','',2);
/*!40000 ALTER TABLE `artists` ENABLE KEYS */;
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
INSERT INTO `bannerimages` VALUES (1,1);
INSERT INTO `bannerimages` VALUES (2,1);
INSERT INTO `bannerimages` VALUES (4,4);
INSERT INTO `bannerimages` VALUES (27,5);
INSERT INTO `bannerimages` VALUES (2,7);
INSERT INTO `bannerimages` VALUES (5,10);
INSERT INTO `bannerimages` VALUES (6,11);
INSERT INTO `bannerimages` VALUES (9,14);
INSERT INTO `bannerimages` VALUES (7,15);
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
INSERT INTO `customers` VALUES (33,'1998-04-16 00:00:00','0612312333',11);
INSERT INTO `customers` VALUES (43,'2004-10-13 00:00:00','+3167123456',40);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `danceevents`
--

DROP TABLE IF EXISTS `danceevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `danceevents` (
  `eventId` int(11) NOT NULL,
  `locationId` int(11) NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `danceevents_FK_1` (`locationId`),
  CONSTRAINT `danceevents_FK` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `danceevents_FK_1` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `danceevents`
--

LOCK TABLES `danceevents` WRITE;
/*!40000 ALTER TABLE `danceevents` DISABLE KEYS */;
INSERT INTO `danceevents` VALUES (132,17);
INSERT INTO `danceevents` VALUES (139,17);
INSERT INTO `danceevents` VALUES (143,17);
INSERT INTO `danceevents` VALUES (136,18);
INSERT INTO `danceevents` VALUES (140,18);
INSERT INTO `danceevents` VALUES (133,19);
INSERT INTO `danceevents` VALUES (137,19);
INSERT INTO `danceevents` VALUES (141,19);
INSERT INTO `danceevents` VALUES (113,20);
INSERT INTO `danceevents` VALUES (138,20);
INSERT INTO `danceevents` VALUES (135,21);
INSERT INTO `danceevents` VALUES (134,22);
INSERT INTO `danceevents` VALUES (142,22);
/*!40000 ALTER TABLE `danceevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dancelineups`
--

DROP TABLE IF EXISTS `dancelineups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dancelineups` (
  `eventId` int(11) NOT NULL,
  `artistId` int(11) NOT NULL,
  PRIMARY KEY (`eventId`,`artistId`),
  KEY `dancelineups_FK_1` (`artistId`),
  CONSTRAINT `dancelineups_FK` FOREIGN KEY (`eventId`) REFERENCES `danceevents` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dancelineups_FK_1` FOREIGN KEY (`artistId`) REFERENCES `artists` (`artistId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Links artists to dance events (many to many relationship)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dancelineups`
--

LOCK TABLES `dancelineups` WRITE;
/*!40000 ALTER TABLE `dancelineups` DISABLE KEYS */;
INSERT INTO `dancelineups` VALUES (135,26);
INSERT INTO `dancelineups` VALUES (136,26);
INSERT INTO `dancelineups` VALUES (143,26);
INSERT INTO `dancelineups` VALUES (134,27);
INSERT INTO `dancelineups` VALUES (136,27);
INSERT INTO `dancelineups` VALUES (141,27);
INSERT INTO `dancelineups` VALUES (133,28);
INSERT INTO `dancelineups` VALUES (136,28);
INSERT INTO `dancelineups` VALUES (142,28);
INSERT INTO `dancelineups` VALUES (132,29);
INSERT INTO `dancelineups` VALUES (138,29);
INSERT INTO `dancelineups` VALUES (140,29);
INSERT INTO `dancelineups` VALUES (113,30);
INSERT INTO `dancelineups` VALUES (137,30);
INSERT INTO `dancelineups` VALUES (140,30);
INSERT INTO `dancelineups` VALUES (113,31);
INSERT INTO `dancelineups` VALUES (139,31);
INSERT INTO `dancelineups` VALUES (140,31);
/*!40000 ALTER TABLE `dancelineups` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Gumbo Kings','2023-07-27 18:00:00','2023-07-27 19:00:00',1,300);
INSERT INTO `events` VALUES (2,'A Stroll Through History','2023-07-27 10:00:00','2023-07-27 12:30:00',3,12);
INSERT INTO `events` VALUES (4,'A Stroll Through History','2023-07-27 13:00:00','2023-07-27 15:30:00',3,12);
INSERT INTO `events` VALUES (7,'Ntjam Rosie','2023-07-27 21:00:00','2023-07-27 22:00:00',1,300);
INSERT INTO `events` VALUES (8,'Gumbo Kings','2023-07-30 19:00:00','2023-07-30 20:00:00',1,10000);
INSERT INTO `events` VALUES (14,'Jazz Pass Thursday','2023-07-27 02:00:00','2023-07-27 02:00:00',1,0);
INSERT INTO `events` VALUES (15,'Jazz Pass Friday','2023-07-28 02:00:00','2023-07-28 02:00:00',1,0);
INSERT INTO `events` VALUES (16,'Jazz Pass Saturday','2023-07-29 02:00:00','2023-07-29 02:00:00',1,0);
INSERT INTO `events` VALUES (17,'Jazz Pass Sunday','2023-07-30 02:00:00','2023-07-30 02:00:00',1,0);
INSERT INTO `events` VALUES (18,'Jazz Pass All Days','2023-07-27 02:00:00','2023-07-27 02:00:00',1,0);
INSERT INTO `events` VALUES (19,'Gare du Nord','2023-07-29 18:00:00','2023-07-29 19:00:00',1,300);
INSERT INTO `events` VALUES (20,'Gare du Nord','2023-07-30 20:00:00','2023-07-30 21:00:00',1,10000);
INSERT INTO `events` VALUES (21,'The Nordanians','2023-07-29 19:30:00','2023-07-29 20:30:00',1,150);
INSERT INTO `events` VALUES (22,'The Nordanians','2023-07-30 18:00:00','2023-07-30 19:00:00',1,10000);
INSERT INTO `events` VALUES (23,'Evolve','2023-07-27 19:30:00','2023-07-27 20:30:00',1,300);
INSERT INTO `events` VALUES (24,'Evolve','2023-07-30 17:00:00','2023-07-30 18:00:00',1,10000);
INSERT INTO `events` VALUES (26,'Wicked Jazz Sounds','2023-07-30 16:00:00','2023-07-30 17:00:00',1,10000);
INSERT INTO `events` VALUES (27,'Tom Thomson Assemble','2023-07-27 19:30:00','2023-07-27 20:30:00',1,200);
INSERT INTO `events` VALUES (28,'Jonna Fraser','2023-07-27 21:00:00','2023-07-27 22:00:00',1,200);
INSERT INTO `events` VALUES (29,'Fox &amp; The Mayors','2023-07-28 18:00:00','2023-07-28 19:00:00',1,300);
INSERT INTO `events` VALUES (30,'Uncle Sue','2023-07-28 19:30:00','2023-07-28 20:30:00',1,300);
INSERT INTO `events` VALUES (31,'Kris Allen','2023-07-28 21:00:00','2023-07-28 22:00:00',1,300);
INSERT INTO `events` VALUES (32,'Myles Sanko','2023-07-28 18:00:00','2023-07-28 19:00:00',1,200);
INSERT INTO `events` VALUES (33,'Ruis Soundsystem','2023-07-28 19:30:00','2023-07-28 20:30:00',1,200);
INSERT INTO `events` VALUES (34,'Ruis Soundsystem','2023-07-30 15:00:00','2023-07-30 16:00:00',1,10000);
INSERT INTO `events` VALUES (35,'The Family XL','2023-07-28 21:00:00','2023-07-28 22:00:00',1,200);
INSERT INTO `events` VALUES (36,'Rilan &amp; The Bombardiers','2023-07-29 19:30:00','2023-07-29 20:30:00',1,300);
INSERT INTO `events` VALUES (37,'Soul Six','2023-07-29 21:00:00','2023-07-29 22:00:00',1,300);
INSERT INTO `events` VALUES (38,'Han Bennink','2023-07-29 18:00:00','2023-07-29 19:00:00',1,150);
INSERT INTO `events` VALUES (39,'Lilth Merlot','2023-07-29 21:00:00','2023-07-29 22:00:00',1,150);
INSERT INTO `events` VALUES (42,'Wicked Jazz Sounds','2023-07-27 18:00:00','2023-07-27 19:00:00',1,200);
INSERT INTO `events` VALUES (44,'Dance Pass Friday','2023-07-28 02:00:00','2023-07-28 02:00:00',4,0);
INSERT INTO `events` VALUES (45,'Dance Pass Saturday','2023-07-29 02:00:00','2023-07-29 02:00:00',4,0);
INSERT INTO `events` VALUES (46,'Dance Pass Sunday','2023-07-30 02:00:00','2023-07-30 02:00:00',4,0);
INSERT INTO `events` VALUES (47,'Dance Pass All Days','2023-07-28 02:00:00','2023-07-28 02:00:00',4,0);
INSERT INTO `events` VALUES (66,'A Stroll Through History','2023-07-27 10:00:00','2023-07-27 12:30:00',3,12);
INSERT INTO `events` VALUES (68,'A Stroll Through History','2023-07-27 10:00:00','2023-07-27 12:30:00',3,12);
INSERT INTO `events` VALUES (69,'A Stroll Through History','2023-07-27 10:00:00','2023-07-27 12:30:00',3,12);
INSERT INTO `events` VALUES (71,'A Stroll Through History','2023-07-27 13:00:00','2023-07-27 15:30:00',3,12);
INSERT INTO `events` VALUES (72,'A Stroll Through History','2023-07-27 13:00:00','2023-07-27 15:30:00',3,12);
INSERT INTO `events` VALUES (74,'A Stroll Through History','2023-07-27 16:00:00','2023-07-27 18:30:00',3,12);
INSERT INTO `events` VALUES (75,'A Stroll Through History','2023-07-27 16:00:00','2023-07-27 18:30:00',3,12);
INSERT INTO `events` VALUES (76,'A Stroll Through History','2023-07-28 10:00:00','2023-07-28 12:30:00',3,12);
INSERT INTO `events` VALUES (77,'A Stroll Through History','2023-07-28 10:00:00','2023-07-28 12:30:00',3,12);
INSERT INTO `events` VALUES (78,'A Stroll Through History','2023-07-28 10:00:00','2023-07-28 12:30:00',3,12);
INSERT INTO `events` VALUES (79,'A Stroll Through History','2023-07-28 10:00:00','2023-07-28 12:30:00',3,12);
INSERT INTO `events` VALUES (80,'A Stroll Through History','2023-07-28 13:00:00','2023-07-28 15:30:00',3,12);
INSERT INTO `events` VALUES (81,'A Stroll Through History','2023-07-28 13:00:00','2023-07-28 15:30:00',3,12);
INSERT INTO `events` VALUES (82,'A Stroll Through History','2023-07-28 13:00:00','2023-07-28 15:30:00',3,12);
INSERT INTO `events` VALUES (83,'A Stroll Through History','2023-07-28 16:00:00','2023-07-28 18:30:00',3,12);
INSERT INTO `events` VALUES (84,'A Stroll Through History','2023-07-28 16:00:00','2023-07-28 18:30:00',3,12);
INSERT INTO `events` VALUES (85,'A Stroll Through History','2023-07-28 16:00:00','2023-07-28 18:30:00',3,12);
INSERT INTO `events` VALUES (86,'A Stroll Through History','2023-07-28 16:00:00','2023-07-28 18:30:00',3,12);
INSERT INTO `events` VALUES (87,'A Stroll Through History','2023-07-29 10:00:00','2023-07-29 12:30:00',3,12);
INSERT INTO `events` VALUES (88,'A Stroll Through History','2023-07-29 10:00:00','2023-07-29 12:30:00',3,12);
INSERT INTO `events` VALUES (89,'A Stroll Through History','2023-07-29 10:00:00','2023-07-29 12:30:00',3,12);
INSERT INTO `events` VALUES (91,'A Stroll Through History','2023-07-29 13:00:00','2023-07-29 15:30:00',3,12);
INSERT INTO `events` VALUES (92,'A Stroll Through History','2023-07-29 13:00:00','2023-07-29 15:30:00',3,12);
INSERT INTO `events` VALUES (94,'A Stroll Through History','2023-07-29 13:00:00','2023-07-29 15:30:00',3,12);
INSERT INTO `events` VALUES (95,'A Stroll Through History','2023-07-29 16:00:00','2023-07-29 18:30:00',3,12);
INSERT INTO `events` VALUES (96,'A Stroll Through History','2023-07-29 16:00:00','2023-07-29 18:30:00',3,12);
INSERT INTO `events` VALUES (97,'A Stroll Through History','2023-07-29 16:00:00','2023-07-29 18:30:00',3,12);
INSERT INTO `events` VALUES (98,'A Stroll Through History','2023-07-30 10:00:00','2023-07-30 12:30:00',3,12);
INSERT INTO `events` VALUES (99,'A Stroll Through History','2023-07-30 10:00:00','2023-07-30 12:30:00',3,12);
INSERT INTO `events` VALUES (101,'A Stroll Through History','2023-07-30 10:00:00','2023-07-30 12:30:00',3,12);
INSERT INTO `events` VALUES (102,'A Stroll Through History','2023-07-30 13:00:00','2023-07-30 15:30:00',3,12);
INSERT INTO `events` VALUES (103,'A Stroll Through History','2023-07-30 13:00:00','2023-07-30 15:30:00',3,12);
INSERT INTO `events` VALUES (104,'A Stroll Through History','2023-07-30 13:00:00','2023-07-30 15:30:00',3,12);
INSERT INTO `events` VALUES (105,'A Stroll Through History','2023-07-30 13:00:00','2023-07-30 15:30:00',3,12);
INSERT INTO `events` VALUES (106,'A Stroll Through History','2023-07-30 16:00:00','2023-07-30 18:30:00',3,12);
INSERT INTO `events` VALUES (107,'A Stroll Through History','2023-07-30 16:00:00','2023-07-30 18:30:00',3,12);
INSERT INTO `events` VALUES (108,'A Stroll Through History','2023-07-30 16:00:00','2023-07-30 18:30:00',3,12);
INSERT INTO `events` VALUES (109,'A Stroll Through History','2023-07-30 16:00:00','2023-07-30 18:30:00',3,12);
INSERT INTO `events` VALUES (112,'Mr&Mrs','2023-07-30 18:00:00','2023-07-30 20:00:00',2,18);
INSERT INTO `events` VALUES (113,'Back2Back - Nicky Romero &amp; Afrojack','2023-07-27 20:00:00','2023-07-28 02:00:00',4,1500);
INSERT INTO `events` VALUES (115,'Restaurant ML','2023-07-28 16:00:00','2023-07-28 18:30:00',2,30);
INSERT INTO `events` VALUES (131,'Mr & Mrs second Session','2023-07-29 20:10:00','2023-07-29 21:10:00',2,25);
INSERT INTO `events` VALUES (132,'TiÃ«sto','2023-07-27 22:00:00','2023-07-27 23:30:00',4,200);
INSERT INTO `events` VALUES (133,'Hardwell','2023-07-27 23:00:00','2023-07-28 00:30:00',4,300);
INSERT INTO `events` VALUES (134,'Armin Van Buuren','2023-07-27 22:00:00','2023-07-27 23:30:00',4,200);
INSERT INTO `events` VALUES (135,'Martin Garrix','2023-07-27 22:00:00','2023-07-27 23:30:00',4,200);
INSERT INTO `events` VALUES (136,'Back2Back - Hardwell &amp; Martin Garrix &amp; Armin van Buuren','2023-07-28 14:00:00','2023-07-28 23:00:00',4,2000);
INSERT INTO `events` VALUES (137,'Afrojack','2023-07-28 22:00:00','2023-07-28 23:30:00',4,300);
INSERT INTO `events` VALUES (138,'TiÃ«stoWorld','2023-07-28 21:00:00','2023-07-29 01:00:00',4,1500);
INSERT INTO `events` VALUES (139,'Nicky Romero','2023-07-28 23:00:00','2023-07-29 00:30:00',4,200);
INSERT INTO `events` VALUES (140,'Back2Back - Afrojack &amp; TiÃ«sto &amp; Nicky Romero','2023-07-29 14:00:00','2023-07-29 23:00:00',4,2000);
INSERT INTO `events` VALUES (141,'Armin van Buuren','2023-07-29 19:00:00','2023-07-29 20:30:00',4,300);
INSERT INTO `events` VALUES (142,'Hardwell','2023-07-29 21:00:00','2023-07-29 22:30:00',4,200);
INSERT INTO `events` VALUES (143,'Martin Garrix','2023-07-29 21:00:00','2023-07-29 22:30:00',4,200);
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
INSERT INTO `festivaleventtypes` VALUES (1,'Haarlem Jazz',0.09);
INSERT INTO `festivaleventtypes` VALUES (2,'Yummy',0.21);
INSERT INTO `festivaleventtypes` VALUES (3,'Stroll Through History',0.21);
INSERT INTO `festivaleventtypes` VALUES (4,'DANCE!',0.09);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foodtype`
--

LOCK TABLES `foodtype` WRITE;
/*!40000 ALTER TABLE `foodtype` DISABLE KEYS */;
INSERT INTO `foodtype` VALUES (1,'French');
INSERT INTO `foodtype` VALUES (2,'Fish and Seafood');
INSERT INTO `foodtype` VALUES (3,'Meat');
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
INSERT INTO `guides` VALUES (1,'Susan','Can','English',NULL);
INSERT INTO `guides` VALUES (2,'Annet','Marry','Dutch',NULL);
INSERT INTO `guides` VALUES (3,'Kim','Huang','Chinese',NULL);
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
  KEY `historyevents_ibfk_1` (`guideId`),
  KEY `historyevents_ibfk_2` (`locationId`),
  CONSTRAINT `historyevents_ibfk_1` FOREIGN KEY (`guideId`) REFERENCES `guides` (`guideId`) ON UPDATE CASCADE,
  CONSTRAINT `historyevents_ibfk_2` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historyevents`
--

LOCK TABLES `historyevents` WRITE;
/*!40000 ALTER TABLE `historyevents` DISABLE KEYS */;
INSERT INTO `historyevents` VALUES (48,3,2);
INSERT INTO `historyevents` VALUES (49,3,2);
INSERT INTO `historyevents` VALUES (50,3,2);
INSERT INTO `historyevents` VALUES (51,3,2);
INSERT INTO `historyevents` VALUES (52,3,2);
INSERT INTO `historyevents` VALUES (53,3,2);
INSERT INTO `historyevents` VALUES (54,3,2);
INSERT INTO `historyevents` VALUES (55,3,2);
INSERT INTO `historyevents` VALUES (56,3,2);
INSERT INTO `historyevents` VALUES (58,2,2);
INSERT INTO `historyevents` VALUES (60,3,2);
INSERT INTO `historyevents` VALUES (61,3,2);
INSERT INTO `historyevents` VALUES (62,3,2);
INSERT INTO `historyevents` VALUES (63,2,2);
INSERT INTO `historyevents` VALUES (64,3,2);
INSERT INTO `historyevents` VALUES (65,1,2);
INSERT INTO `historyevents` VALUES (66,1,2);
INSERT INTO `historyevents` VALUES (67,2,2);
INSERT INTO `historyevents` VALUES (68,2,2);
INSERT INTO `historyevents` VALUES (69,3,2);
INSERT INTO `historyevents` VALUES (70,3,2);
INSERT INTO `historyevents` VALUES (71,1,2);
INSERT INTO `historyevents` VALUES (72,2,2);
INSERT INTO `historyevents` VALUES (73,2,2);
INSERT INTO `historyevents` VALUES (74,1,2);
INSERT INTO `historyevents` VALUES (75,2,2);
INSERT INTO `historyevents` VALUES (76,1,2);
INSERT INTO `historyevents` VALUES (77,1,2);
INSERT INTO `historyevents` VALUES (78,2,2);
INSERT INTO `historyevents` VALUES (79,3,2);
INSERT INTO `historyevents` VALUES (80,1,2);
INSERT INTO `historyevents` VALUES (81,2,2);
INSERT INTO `historyevents` VALUES (82,3,2);
INSERT INTO `historyevents` VALUES (83,1,2);
INSERT INTO `historyevents` VALUES (84,2,2);
INSERT INTO `historyevents` VALUES (85,3,2);
INSERT INTO `historyevents` VALUES (86,2,2);
INSERT INTO `historyevents` VALUES (87,1,2);
INSERT INTO `historyevents` VALUES (88,2,2);
INSERT INTO `historyevents` VALUES (89,2,2);
INSERT INTO `historyevents` VALUES (90,3,2);
INSERT INTO `historyevents` VALUES (91,1,2);
INSERT INTO `historyevents` VALUES (92,2,2);
INSERT INTO `historyevents` VALUES (93,3,2);
INSERT INTO `historyevents` VALUES (94,3,2);
INSERT INTO `historyevents` VALUES (95,1,2);
INSERT INTO `historyevents` VALUES (96,2,2);
INSERT INTO `historyevents` VALUES (97,3,2);
INSERT INTO `historyevents` VALUES (98,1,2);
INSERT INTO `historyevents` VALUES (99,2,2);
INSERT INTO `historyevents` VALUES (100,3,2);
INSERT INTO `historyevents` VALUES (101,3,2);
INSERT INTO `historyevents` VALUES (102,3,2);
INSERT INTO `historyevents` VALUES (103,1,2);
INSERT INTO `historyevents` VALUES (104,2,2);
INSERT INTO `historyevents` VALUES (105,1,2);
INSERT INTO `historyevents` VALUES (106,1,2);
INSERT INTO `historyevents` VALUES (107,1,2);
INSERT INTO `historyevents` VALUES (108,2,2);
INSERT INTO `historyevents` VALUES (109,1,2);
INSERT INTO `historyevents` VALUES (110,3,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'/img/jpg/BACKGROUND.jpg','Visit Haarlem');
INSERT INTO `images` VALUES (2,'/img/jpg/background2.jpg','Visit Haarlem');
INSERT INTO `images` VALUES (3,'/img/jpg/food-home.jpg','Food');
INSERT INTO `images` VALUES (4,'/img/png/image_5.png','The Festival');
INSERT INTO `images` VALUES (5,'/img/jpg/EDM_1.jpg','Dance!');
INSERT INTO `images` VALUES (6,'/img/jpg/Jazz.jpg','Haarlem Jazz');
INSERT INTO `images` VALUES (7,'/img/jpg/History.jpg','A Stroll Through Haarlem');
INSERT INTO `images` VALUES (8,'/img/jpg/Erva-Cafe-Restaurant-Haarlem_1.jpg','Yummy!');
INSERT INTO `images` VALUES (9,'/img/jpg/teylers.jpg','The Teyler Mystery');
INSERT INTO `images` VALUES (10,'/img/jpg/bg.jpg','Ntjam Rosie');
INSERT INTO `images` VALUES (11,'/img/jpg/763.jpg','Ntjam Rosie');
INSERT INTO `images` VALUES (12,'/img/jpg/52958_Ntjam_Rosie_21293.jpg','Ntjam Rosie');
INSERT INTO `images` VALUES (13,'/img/jpg/52958_Ntjam_Rosie_20954.jpg','Ntjam Rosie');
INSERT INTO `images` VALUES (14,'/img/jpg/xxx830_650_0b3c7bb625295828f620e41c3c11858d.jpg','Gumbo Kings');
INSERT INTO `images` VALUES (15,'/img/jpg/Gumbo-Kings.jpg','Gumbo Kings');
INSERT INTO `images` VALUES (16,'/img/jpg/Nordanians-1.jpg','The Nordanians');
INSERT INTO `images` VALUES (17,'/img/jpg/HaarlemGroteMarkt1.JPG','St. Bavo Church');
INSERT INTO `images` VALUES (18,'/img/jpg/brouwerij-restaurant-jopenkerk-haarlem-jopenbier_4082379069.jpg','Jopenkerk Beer');
INSERT INTO `images` VALUES (19,'/img/jpg/Frame_21.jpg','Grote Markt');
INSERT INTO `images` VALUES (20,'/img/jpg/Frame_212.jpg','De Hallen');
INSERT INTO `images` VALUES (21,'/img/jpg/Frame_307.jpg','Jopenkerk');
INSERT INTO `images` VALUES (22,'/img/jpg/Frame_21(1).jpg','Proveniershof');
INSERT INTO `images` VALUES (23,'/img/jpg/Frame_21(2).jpg','Waalse Kerk');
INSERT INTO `images` VALUES (24,'/img/jpg/Frame_21(3).jpg','Molen de Adriaan');
INSERT INTO `images` VALUES (25,'/img/jpg/Frame_21(4).jpg','Amsterdamse Poort');
INSERT INTO `images` VALUES (26,'/img/jpg/Frame_21(5).jpg','Hof van Bakenes');
INSERT INTO `images` VALUES (27,'/img/jpg/image_6.jpg','Music &amp; Dance');
INSERT INTO `images` VALUES (28,'/img/jpg/Image.jpg','Haarlem Jazz');
INSERT INTO `images` VALUES (29,'/img/jpg/Image(1).jpg','Stadsschouwburg &amp; Philharmonie Haarlem');
INSERT INTO `images` VALUES (30,'/img/jpg/Image(2).jpg','Patronaat');
INSERT INTO `images` VALUES (31,'/img/jpg/bottom.jpg','Bottom Music &amp; Dance');
INSERT INTO `images` VALUES (32,'/img/jpg/history(1).jpg','History');
INSERT INTO `images` VALUES (34,'/img/jpg/history(2).jpg','Art');
INSERT INTO `images` VALUES (35,'/img/jpg/kids.jpg','Kids');
INSERT INTO `images` VALUES (36,'/img/jpg/imgcounter.jpg','Image Counter');
INSERT INTO `images` VALUES (37,'/img/jpg/Gare_du_Nord_1082.jpg','Gare du Nord');
INSERT INTO `images` VALUES (38,'/img/jpg/GdN_presspic_Staand-scaled-e1649839659934.jpg','Gare du Nord');
INSERT INTO `images` VALUES (39,'/img/jpg/Gare_Du_Nord.jpg','Gare du Nord');
INSERT INTO `images` VALUES (40,'/img/jpg/gare.jpg','Gare du Nord');
INSERT INTO `images` VALUES (41,'/img/jpg/Nordanians-1(1).jpg','The Nordanians');
INSERT INTO `images` VALUES (42,'/img/jpg/33036422_2199605456721417_3092494307022602240_n.jpg','The Nordanians');
INSERT INTO `images` VALUES (43,'/img/jpg/Nordanians-2.jpg','The Nordanians');
INSERT INTO `images` VALUES (44,'/img/jpg/images0.persgroep.jpg','Wicked Jazz Sounds');
INSERT INTO `images` VALUES (45,'/img/jpg/Jonna-Fraser-Photo-Credit-Orrin-Jaarsveld-1.jpg','Jonna Fraser');
INSERT INTO `images` VALUES (46,'/img/jpg/maxresdefault-1.jpg','Jonna Fraser');
INSERT INTO `images` VALUES (47,'/img/jpg/Wicked-jazz-sounds-podium-1024x675.jpg','Wicked Jazz Sounds');
INSERT INTO `images` VALUES (49,'/img/webp/Uncle-Sue-bandfoto-10.webp','Uncle Sue');
INSERT INTO `images` VALUES (50,'/img/webp/Uncle-Sue-podium-22.webp','Uncle Sue');
INSERT INTO `images` VALUES (51,'/img/webp/Uncle-Sue-podium-16.webp','Uncle Sue');
INSERT INTO `images` VALUES (52,'/img/png/BCF8428E-5A1E-4B5F-AC44-F085A629C731.png','Kris Allen');
INSERT INTO `images` VALUES (53,'/img/jpg/myles-sanko-1140x642.jpg','Myles Sanko');
INSERT INTO `images` VALUES (54,'/img/jpg/cb65da9a8be1899ff923b166c9ad9dd4.jpg','Myles Sanko');
INSERT INTO `images` VALUES (55,'/img/jpg/15_Myles-Sanko.jpg','Myles Sanko');
INSERT INTO `images` VALUES (56,'/img/jpg/22254979_2030325053855095_5034947054993221983_o.jpg','The Family XL');
INSERT INTO `images` VALUES (57,'/img/jpg/22221507_2030324933855107_2469730967042660850_n.jpg','The Family Xl');
INSERT INTO `images` VALUES (58,'/img/jpg/b33fc364-46df-47f9-88fe-9986b11c54d0_thumb1440.jpg','Rilan &amp; The Bombardiers');
INSERT INTO `images` VALUES (59,'/img/jpg/data36752617-547464.jpg','Rilan &amp; The Bombardiers');
INSERT INTO `images` VALUES (60,'/img/jpg/69650218_3211291552244922_6963147898221494272_n.jpg','Soul Six');
INSERT INTO `images` VALUES (61,'/img/jpg/72074381_3326183484089061_6188742728994521088_n.jpg','Soul Six');
INSERT INTO `images` VALUES (62,'/img/jpg/72421516_3326183677422375_6121295065089310720_n.jpg','Soul Six');
INSERT INTO `images` VALUES (63,'/img/jpg/1280px-Anderson,_Bennink,_Glerum,_van_Kemenade_02.jpg','Han Bennink');
INSERT INTO `images` VALUES (64,'/img/jpg/Han_Bennink,_Canada_2015_DSC_1125.jpg','Han Bennink');
INSERT INTO `images` VALUES (65,'/img/jpg/cf31f2_1209ac9c542e4d81938e380d2a0e2273~mv2.jpg','Lilth Merlot');
INSERT INTO `images` VALUES (66,'/img/jpg/copyrights-RONA-LANE-50.jpg','Lilth Merlot');
INSERT INTO `images` VALUES (67,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.22.57_(1).jpg','');
INSERT INTO `images` VALUES (68,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.22.57.jpg','');
INSERT INTO `images` VALUES (69,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.32.24.jpg','');
INSERT INTO `images` VALUES (70,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.32.24_(1).jpg','');
INSERT INTO `images` VALUES (71,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.32.24_(2).jpg','');
INSERT INTO `images` VALUES (72,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.45.15_(1).jpg','');
INSERT INTO `images` VALUES (73,'/img/jpg/WhatsApp_Image_2023-06-21_at_20.45.15.jpg','');
INSERT INTO `images` VALUES (74,'/img/jpg/nzhvervoermuseumbussentrams_vervoermuseumtramsbussenhaarlem_3_350_235.jpg','');
INSERT INTO `images` VALUES (75,'/img/jpg/Verwey-Museum-Haarlem-nieuw-logo-en-banieren-LR.jpg','');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
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
  CONSTRAINT `FK_ArtistToArtistId` FOREIGN KEY (`artistId`) REFERENCES `artists` (`artistId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jazzartistimage`
--

LOCK TABLES `jazzartistimage` WRITE;
/*!40000 ALTER TABLE `jazzartistimage` DISABLE KEYS */;
INSERT INTO `jazzartistimage` VALUES (37,8);
INSERT INTO `jazzartistimage` VALUES (38,8);
INSERT INTO `jazzartistimage` VALUES (39,8);
INSERT INTO `jazzartistimage` VALUES (40,8);
INSERT INTO `jazzartistimage` VALUES (41,9);
INSERT INTO `jazzartistimage` VALUES (42,9);
INSERT INTO `jazzartistimage` VALUES (43,9);
INSERT INTO `jazzartistimage` VALUES (45,15);
INSERT INTO `jazzartistimage` VALUES (46,15);
INSERT INTO `jazzartistimage` VALUES (44,13);
INSERT INTO `jazzartistimage` VALUES (49,17);
INSERT INTO `jazzartistimage` VALUES (50,17);
INSERT INTO `jazzartistimage` VALUES (51,17);
INSERT INTO `jazzartistimage` VALUES (53,19);
INSERT INTO `jazzartistimage` VALUES (54,19);
INSERT INTO `jazzartistimage` VALUES (55,19);
INSERT INTO `jazzartistimage` VALUES (56,21);
INSERT INTO `jazzartistimage` VALUES (57,21);
INSERT INTO `jazzartistimage` VALUES (58,22);
INSERT INTO `jazzartistimage` VALUES (59,22);
INSERT INTO `jazzartistimage` VALUES (61,23);
INSERT INTO `jazzartistimage` VALUES (62,23);
INSERT INTO `jazzartistimage` VALUES (60,23);
INSERT INTO `jazzartistimage` VALUES (63,24);
INSERT INTO `jazzartistimage` VALUES (64,24);
INSERT INTO `jazzartistimage` VALUES (65,25);
INSERT INTO `jazzartistimage` VALUES (66,25);
INSERT INTO `jazzartistimage` VALUES (10,7);
INSERT INTO `jazzartistimage` VALUES (11,7);
INSERT INTO `jazzartistimage` VALUES (12,7);
INSERT INTO `jazzartistimage` VALUES (13,7);
INSERT INTO `jazzartistimage` VALUES (14,1);
INSERT INTO `jazzartistimage` VALUES (15,1);
INSERT INTO `jazzartistimage` VALUES (52,18);
/*!40000 ALTER TABLE `jazzartistimage` ENABLE KEYS */;
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
  CONSTRAINT `FK_JazzEventArtistId` FOREIGN KEY (`artistId`) REFERENCES `artists` (`artistId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JazzEventEventId` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JazzEventLocationId` FOREIGN KEY (`locationId`) REFERENCES `locations` (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jazzevents`
--

LOCK TABLES `jazzevents` WRITE;
/*!40000 ALTER TABLE `jazzevents` DISABLE KEYS */;
INSERT INTO `jazzevents` VALUES (1,1,1);
INSERT INTO `jazzevents` VALUES (7,7,1);
INSERT INTO `jazzevents` VALUES (8,1,13);
INSERT INTO `jazzevents` VALUES (19,8,1);
INSERT INTO `jazzevents` VALUES (20,8,13);
INSERT INTO `jazzevents` VALUES (21,9,14);
INSERT INTO `jazzevents` VALUES (22,9,13);
INSERT INTO `jazzevents` VALUES (23,12,1);
INSERT INTO `jazzevents` VALUES (24,12,13);
INSERT INTO `jazzevents` VALUES (26,13,13);
INSERT INTO `jazzevents` VALUES (27,14,12);
INSERT INTO `jazzevents` VALUES (28,15,12);
INSERT INTO `jazzevents` VALUES (29,16,1);
INSERT INTO `jazzevents` VALUES (30,17,1);
INSERT INTO `jazzevents` VALUES (31,18,1);
INSERT INTO `jazzevents` VALUES (32,19,12);
INSERT INTO `jazzevents` VALUES (33,20,12);
INSERT INTO `jazzevents` VALUES (34,20,13);
INSERT INTO `jazzevents` VALUES (35,21,12);
INSERT INTO `jazzevents` VALUES (36,22,1);
INSERT INTO `jazzevents` VALUES (37,23,1);
INSERT INTO `jazzevents` VALUES (38,24,14);
INSERT INTO `jazzevents` VALUES (39,25,14);
INSERT INTO `jazzevents` VALUES (42,13,12);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Patronaat (Main Hall)',13,1,300,4.62871,52.38300,NULL);
INSERT INTO `locations` VALUES (2,'St. Bavo Church',14,3,0,4.62919,52.37719,'The Sint Bavokerk is the largest church in Haarlem. The St Bavo Church is also called the Grote Kerk and is popularly referred to as the old baaf.  The St Bavo church is already mentioned in documents from 1245. \nSince 1245, the church has expanded to its current size with seven bells and a beautiful tower. To this day, the St Bavo Church is the highest building in Haarlem.');
INSERT INTO `locations` VALUES (3,'Grote Markt',16,3,0,4.63603,52.38113,'The market square features several works of art, including a statue honoring Laurenz Janszoon Coster, who is widely credited with inventing printing in the Netherlands.');
INSERT INTO `locations` VALUES (4,'De Hallen',17,3,0,4.63603,52.38113,'De Hallen is a contemporary art museum hosting exhibitions featuring national and international artists. Exhibitions are held three times a year and focus on current developments in the visual arts.');
INSERT INTO `locations` VALUES (7,'Waalse Kerk',20,3,0,4.63915,52.38254,'The Waalse Kerk is a Walloon church that was built in the 14th century. It has an upper gallery that was originally built for the Beguines who lived on the courtyard that still bears their name. ');
INSERT INTO `locations` VALUES (8,'Molen de Adriaan',21,3,0,4.64264,52.38377,'In 1778, a businessman from Amsterdam purchased an old defense tower in Haarlem and received permission to build a windmill on top of it. The tower was subsequently transformed into a windmill.');
INSERT INTO `locations` VALUES (9,'Amsterdamse Poort',25,3,0,4.64733,52.38053,'The Amsterdamse Poort is a gate located in Haarlem. It is one of the original gates of the city\'s old defensive wall and has been well-preserved over the years. It is a significant part of Haarlem\'s history.');
INSERT INTO `locations` VALUES (10,'Hof van Bakenes',26,3,0,4.63989,52.38146,'The Hofje van Bakenes is located on the Bakenessergracht and has two entrances. The main entrance is located on the Wijde Appelaarsteeg. The courtyard at this location is the oldest one in Haarlem.');
INSERT INTO `locations` VALUES (12,'Patronaat (Second Hall)',28,1,200,4.62871,52.38300,NULL);
INSERT INTO `locations` VALUES (13,'Grote Markt',29,1,10000,4.63647,52.38170,NULL);
INSERT INTO `locations` VALUES (14,'Patronaat (Third Hall)',30,1,150,4.62871,52.38300,NULL);
INSERT INTO `locations` VALUES (17,'Club Stalker',34,4,200,4.63434,52.38223,NULL);
INSERT INTO `locations` VALUES (18,'Caprera Openluchttheater ',35,4,2000,4.60802,52.41121,NULL);
INSERT INTO `locations` VALUES (19,'Jopenkerk',36,4,300,4.62978,52.38104,NULL);
INSERT INTO `locations` VALUES (20,'Lichtfabriek',37,4,1500,4.65174,52.38635,NULL);
INSERT INTO `locations` VALUES (21,'Club Ruis',38,4,200,4.63636,52.38219,NULL);
INSERT INTO `locations` VALUES (22,'XO the Club',39,4,200,4.63521,52.38121,NULL);
INSERT INTO `locations` VALUES (27,'Restaurant ML',47,2,40,101.22828,16.81531,NULL);
INSERT INTO `locations` VALUES (28,'Mr & Mrs',48,2,50,4.63760,52.37868,NULL);
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
INSERT INTO `navigationbaritems` VALUES (1,1,NULL,1);
INSERT INTO `navigationbaritems` VALUES (2,4,NULL,2);
INSERT INTO `navigationbaritems` VALUES (3,10,2,201);
INSERT INTO `navigationbaritems` VALUES (4,11,2,202);
INSERT INTO `navigationbaritems` VALUES (5,15,2,203);
INSERT INTO `navigationbaritems` VALUES (6,18,2,204);
INSERT INTO `navigationbaritems` VALUES (7,14,2,205);
INSERT INTO `navigationbaritems` VALUES (8,5,NULL,3);
INSERT INTO `navigationbaritems` VALUES (9,6,NULL,4);
INSERT INTO `navigationbaritems` VALUES (10,7,NULL,5);
INSERT INTO `navigationbaritems` VALUES (11,8,NULL,6);
INSERT INTO `navigationbaritems` VALUES (12,9,NULL,7);
/*!40000 ALTER TABLE `navigationbaritems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orderitems` (
  `orderItemId` int(11) NOT NULL AUTO_INCREMENT,
  `ticketLinkId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  PRIMARY KEY (`orderItemId`),
  KEY `orderitems_FK` (`orderId`),
  KEY `orderitems_FK_1` (`ticketLinkId`),
  CONSTRAINT `orderitems_FK` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orderitems_FK_1` FOREIGN KEY (`ticketLinkId`) REFERENCES `ticketlinks` (`ticketLinkId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderitems`
--

LOCK TABLES `orderitems` WRITE;
/*!40000 ALTER TABLE `orderitems` DISABLE KEYS */;
INSERT INTO `orderitems` VALUES (1,4,2,1);
INSERT INTO `orderitems` VALUES (2,2,1,1);
INSERT INTO `orderitems` VALUES (100,36,1,29);
INSERT INTO `orderitems` VALUES (102,17,1,29);
INSERT INTO `orderitems` VALUES (103,21,1,29);
INSERT INTO `orderitems` VALUES (106,36,1,31);
INSERT INTO `orderitems` VALUES (114,36,1,38);
INSERT INTO `orderitems` VALUES (115,5,1,38);
INSERT INTO `orderitems` VALUES (116,17,1,38);
INSERT INTO `orderitems` VALUES (117,26,1,3);
INSERT INTO `orderitems` VALUES (118,6,1,3);
INSERT INTO `orderitems` VALUES (131,36,1,44);
INSERT INTO `orderitems` VALUES (132,36,1,45);
INSERT INTO `orderitems` VALUES (133,5,1,46);
INSERT INTO `orderitems` VALUES (134,36,3,47);
INSERT INTO `orderitems` VALUES (135,5,1,48);
INSERT INTO `orderitems` VALUES (136,36,1,48);
INSERT INTO `orderitems` VALUES (137,17,1,48);
INSERT INTO `orderitems` VALUES (138,36,1,49);
INSERT INTO `orderitems` VALUES (139,5,1,49);
INSERT INTO `orderitems` VALUES (140,5,1,4);
INSERT INTO `orderitems` VALUES (141,36,1,50);
INSERT INTO `orderitems` VALUES (142,36,1,51);
INSERT INTO `orderitems` VALUES (143,5,1,52);
INSERT INTO `orderitems` VALUES (144,36,1,53);
INSERT INTO `orderitems` VALUES (145,36,1,54);
INSERT INTO `orderitems` VALUES (146,5,1,55);
INSERT INTO `orderitems` VALUES (147,36,1,56);
INSERT INTO `orderitems` VALUES (148,36,1,57);
INSERT INTO `orderitems` VALUES (149,36,6,58);
INSERT INTO `orderitems` VALUES (150,5,3,59);
INSERT INTO `orderitems` VALUES (151,17,1,59);
INSERT INTO `orderitems` VALUES (152,21,1,59);
INSERT INTO `orderitems` VALUES (153,22,1,59);
INSERT INTO `orderitems` VALUES (154,6,1,59);
INSERT INTO `orderitems` VALUES (155,26,1,59);
INSERT INTO `orderitems` VALUES (156,53,1,59);
INSERT INTO `orderitems` VALUES (158,36,1,5);
INSERT INTO `orderitems` VALUES (159,5,1,61);
INSERT INTO `orderitems` VALUES (160,5,2,62);
INSERT INTO `orderitems` VALUES (161,5,1,63);
INSERT INTO `orderitems` VALUES (162,36,1,64);
INSERT INTO `orderitems` VALUES (163,5,1,65);
INSERT INTO `orderitems` VALUES (164,36,1,66);
INSERT INTO `orderitems` VALUES (165,5,1,67);
INSERT INTO `orderitems` VALUES (166,21,1,68);
INSERT INTO `orderitems` VALUES (167,5,1,69);
INSERT INTO `orderitems` VALUES (168,36,2,70);
INSERT INTO `orderitems` VALUES (169,36,1,71);
INSERT INTO `orderitems` VALUES (170,5,1,72);
INSERT INTO `orderitems` VALUES (171,6,1,73);
INSERT INTO `orderitems` VALUES (172,6,1,74);
INSERT INTO `orderitems` VALUES (173,22,1,75);
INSERT INTO `orderitems` VALUES (174,22,1,76);
INSERT INTO `orderitems` VALUES (175,36,3,60);
INSERT INTO `orderitems` VALUES (176,6,1,78);
INSERT INTO `orderitems` VALUES (177,5,1,60);
INSERT INTO `orderitems` VALUES (178,17,1,60);
INSERT INTO `orderitems` VALUES (179,22,1,80);
INSERT INTO `orderitems` VALUES (180,22,1,81);
INSERT INTO `orderitems` VALUES (181,6,1,82);
INSERT INTO `orderitems` VALUES (182,23,1,83);
INSERT INTO `orderitems` VALUES (183,24,1,84);
INSERT INTO `orderitems` VALUES (184,33,1,85);
INSERT INTO `orderitems` VALUES (185,5,1,86);
INSERT INTO `orderitems` VALUES (186,6,1,87);
INSERT INTO `orderitems` VALUES (187,6,1,88);
INSERT INTO `orderitems` VALUES (191,97,1,60);
INSERT INTO `orderitems` VALUES (192,97,1,90);
INSERT INTO `orderitems` VALUES (195,97,1,98);
INSERT INTO `orderitems` VALUES (196,97,1,99);
INSERT INTO `orderitems` VALUES (197,97,1,100);
INSERT INTO `orderitems` VALUES (198,97,1,101);
INSERT INTO `orderitems` VALUES (199,97,1,102);
INSERT INTO `orderitems` VALUES (200,97,1,103);
INSERT INTO `orderitems` VALUES (201,8,1,104);
INSERT INTO `orderitems` VALUES (202,9,1,105);
INSERT INTO `orderitems` VALUES (203,10,1,106);
INSERT INTO `orderitems` VALUES (204,12,1,107);
INSERT INTO `orderitems` VALUES (205,56,1,62);
INSERT INTO `orderitems` VALUES (206,5,1,108);
INSERT INTO `orderitems` VALUES (207,36,1,109);
INSERT INTO `orderitems` VALUES (208,97,1,110);
INSERT INTO `orderitems` VALUES (210,36,1,111);
INSERT INTO `orderitems` VALUES (214,98,1,115);
INSERT INTO `orderitems` VALUES (215,98,1,116);
INSERT INTO `orderitems` VALUES (216,98,1,117);
INSERT INTO `orderitems` VALUES (217,98,1,118);
INSERT INTO `orderitems` VALUES (218,97,1,119);
INSERT INTO `orderitems` VALUES (219,110,1,119);
INSERT INTO `orderitems` VALUES (220,111,1,119);
INSERT INTO `orderitems` VALUES (221,108,1,119);
INSERT INTO `orderitems` VALUES (222,109,1,119);
INSERT INTO `orderitems` VALUES (223,112,1,119);
INSERT INTO `orderitems` VALUES (224,114,1,119);
INSERT INTO `orderitems` VALUES (225,113,1,119);
INSERT INTO `orderitems` VALUES (226,115,1,119);
INSERT INTO `orderitems` VALUES (227,116,1,119);
INSERT INTO `orderitems` VALUES (228,117,1,119);
INSERT INTO `orderitems` VALUES (229,118,1,119);
INSERT INTO `orderitems` VALUES (230,119,1,119);
/*!40000 ALTER TABLE `orderitems` ENABLE KEYS */;
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
  `customerId` int(11) DEFAULT NULL,
  `isPaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`orderId`),
  KEY `orders_FK` (`customerId`),
  CONSTRAINT `orders_FK` FOREIGN KEY (`customerId`) REFERENCES `customers` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2023-04-18 07:51:54',33,1);
INSERT INTO `orders` VALUES (3,'2023-05-24 00:00:00',43,1);
INSERT INTO `orders` VALUES (4,'2023-05-24 00:00:00',43,1);
INSERT INTO `orders` VALUES (5,'2023-05-24 00:00:00',43,1);
INSERT INTO `orders` VALUES (29,'2023-06-18 00:00:00',33,1);
INSERT INTO `orders` VALUES (31,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (38,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (44,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (45,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (46,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (47,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (48,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (49,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (50,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (51,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (52,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (53,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (54,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (55,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (56,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (57,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (58,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (59,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (60,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (61,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (62,'2023-06-19 00:00:00',33,1);
INSERT INTO `orders` VALUES (63,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (64,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (65,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (66,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (67,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (68,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (69,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (70,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (71,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (72,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (73,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (74,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (75,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (76,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (78,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (80,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (81,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (82,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (83,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (84,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (85,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (86,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (87,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (88,'2023-06-19 00:00:00',43,1);
INSERT INTO `orders` VALUES (89,'2023-06-20 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (90,'2023-06-20 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (91,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (92,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (93,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (94,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (95,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (96,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (97,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (98,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (99,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (100,'2023-06-21 00:00:00',NULL,0);
INSERT INTO `orders` VALUES (101,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (102,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (103,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (104,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (105,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (106,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (107,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (108,'2023-06-21 00:00:00',33,1);
INSERT INTO `orders` VALUES (109,'2023-06-21 00:00:00',33,1);
INSERT INTO `orders` VALUES (110,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (111,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (112,'2023-06-21 00:00:00',43,0);
INSERT INTO `orders` VALUES (113,'2023-06-21 00:00:00',43,0);
INSERT INTO `orders` VALUES (114,'2023-06-21 00:00:00',43,0);
INSERT INTO `orders` VALUES (115,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (116,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (117,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (118,'2023-06-21 00:00:00',43,1);
INSERT INTO `orders` VALUES (119,'2023-06-21 00:00:00',33,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Visit Haarlem','/','/views/home/index.php');
INSERT INTO `pages` VALUES (2,'Page Not Found','/404','/views/404.php');
INSERT INTO `pages` VALUES (4,'The Festival','/festival','/views/festival/index.php');
INSERT INTO `pages` VALUES (5,'Music &amp; Dance','/music-and-dance','/views/home/music-and-dance.php');
INSERT INTO `pages` VALUES (6,'Food','/food','/views/home/food.php');
INSERT INTO `pages` VALUES (7,'History','/history','/views/home/history.php');
INSERT INTO `pages` VALUES (8,'Art','/art','/views/home/art.php');
INSERT INTO `pages` VALUES (9,'Kids','/kids','/views/home/kids.php');
INSERT INTO `pages` VALUES (10,'DANCE!','/festival/dance','/views/festival/dance.php');
INSERT INTO `pages` VALUES (11,'Haarlem Jazz','/festival/jazz','/views/festival/jazz-and-more.php');
INSERT INTO `pages` VALUES (13,'Yummy!','/editor/festival/yummy','/views/festival/yummy.php');
INSERT INTO `pages` VALUES (14,'The Teyler Mystery','/festival/teyler-mystery','/views/festival/teyler-mystery.php');
INSERT INTO `pages` VALUES (15,'A Stroll Through History','/festival/history-stroll-2','');
INSERT INTO `pages` VALUES (18,'Yummy','/festival/yummy','/views/festival/food_Festival.php');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `paymentId` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `paymentDate` datetime DEFAULT NULL,
  `paymentMethod` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`paymentId`),
  KEY `orderId` (`orderId`),
  KEY `userId` (`userId`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,33,180.00,'2023-05-17 10:04:07','ideal');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resettokens`
--

LOCK TABLES `resettokens` WRITE;
/*!40000 ALTER TABLE `resettokens` DISABLE KEYS */;
INSERT INTO `resettokens` VALUES (44,'96d7bb828f97746d5c0488022f298fad','2023-02-19 14:29:56','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (45,'023d916bbef32000c779dc5d2bad7edb','2023-02-19 14:40:07','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (46,'2dc802a3c2b8add9a8f1a47c21cd411a','2023-02-21 17:50:19','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (47,'406a81b3d8257209d7f01004bf5992a1','2023-02-21 18:27:21','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (48,'07773448b5e40c84355a63586961b565','2023-02-21 18:53:53','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (49,'b5d5d80b4fdf3ac2eced9497e854d512','2023-02-21 18:55:47','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (50,'182eca604d1c5fe88abbb1b34e0f4db9','2023-02-21 19:05:15','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (51,'346dc137a628f04f2903e2eb2af36367','2023-02-21 19:20:00','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (52,'ea87bd69b1c11081cae68ed79ed2128c','2023-02-21 19:35:41','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (53,'e239d1243385ec8ecb11a94dc97c40d4','2023-02-22 09:04:46','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (54,'c75448f68b215c33957401601703a765','2023-02-22 09:12:45','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (55,'95a429ef6a297979a39e89ad8dcb5a2a','2023-02-22 09:13:40','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (56,'e636ed2402cd9c270e571f38c7e29aff','2023-02-22 09:14:50','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (57,'6763b1249e427ca920fdf1e339f1e9f8','2023-02-22 10:28:46','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (58,'12b7d409c093fc712e449dc47ce788b6','2023-02-22 10:32:45','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (59,'c28c60469a9d3cb2179f192d8c7593ba','2023-02-22 10:41:49','joshua.andrea@hotmail.com');
INSERT INTO `resettokens` VALUES (60,'ce74a70a956a46bdc017e5b5e15ee533','2023-02-22 10:45:55','joshua.andrea@hotmail.com');
INSERT INTO `resettokens` VALUES (61,'6c8a8ba4dca93dac525b575ff26dc7ed','2023-02-22 10:50:01','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (62,'c43c4c97a23a4dcce3727824f00b51c8','2023-02-22 10:51:37','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (63,'ad3f799b15d3edc886e878274baa0152','2023-02-22 10:54:06','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (64,'a953c47b88a28f184066f4f3bc7044de','2023-02-22 10:54:35','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (65,'0682b74e490da50fb050cc66230c9c17','2023-02-22 10:55:34','joshua.andrea@hotmail.com');
INSERT INTO `resettokens` VALUES (66,'8184d9d454bf3bc5f75ad2fe6d8b63b3','2023-02-22 10:57:21','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (67,'9dfbcde1ac3932cb008fb136c1df22e6','2023-02-22 10:59:48','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (68,'20e25595e21007236691bb719c1f6f9a','2023-02-22 11:39:36','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (69,'4c2d42e944bb6d770097958b62ce3afb','2023-02-25 09:58:59','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (70,'924ffb20d00976c85b9e992ae3d07a6e','2023-02-25 10:09:36','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (71,'ebfda86d16758901353f1a4f4014215e','2023-02-25 11:21:59','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (72,'9d273457b43f004b51c2effe8c2ad2f4','2023-02-25 13:35:56','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (73,'a882450e164f9ec7dad93d1a948ad1ad','2023-02-27 13:48:22','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (74,'dd466d728ee6ce546833abfb75ee4554','2023-02-27 13:48:28','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (75,'a62780c44391428d71a68e5ea14c03a4','2023-02-27 13:48:36','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (76,'b4a4d8315dd6d947b05f5db51c309b9e','2023-02-27 14:13:34','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (77,'bbe90f5f9681506e7cf72304a8b764ec','2023-02-27 14:14:37','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (78,'2800e73729a5555005901a996e820150','2023-02-27 14:21:16','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (79,'23740ee90fa7ea1ecc51611a73eb1c09','2023-02-27 14:21:34','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (80,'4f3cc1a657293c228e48fc94324363cd','2023-02-27 14:23:01','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (81,'499ba8cedbcd457df720d3b77204be70','2023-02-27 14:24:18','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (82,'21926d05cb30fd44f0a911bd69d06eba','2023-02-27 14:24:49','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (83,'1ba1c37899c34daf8e853ae6f75083b0','2023-02-28 11:22:08','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (84,'a9707575e44ffc14998926390e308b71','2023-03-04 14:01:13','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (85,'ce0dd866d423ce596a69d4501be1661e','2023-03-04 14:27:32','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (86,'cfa3e69c544241e0d284627ea2259d14','2023-03-04 14:31:58','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (87,'54a22f34eeb1088afa319fe985b4d099','2023-03-04 14:33:02','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (88,'55fa151704fb4572cd80e8f8977aa30b','2023-03-04 14:33:40','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (89,'7bfad14e179ff5f402090457e2172ed1','2023-03-04 14:35:43','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (90,'215f74274e6e13c0bfae37d36f0f7b99','2023-03-04 14:36:42','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (91,'c9aa00de76840ac3e63ec74ad48b7535','2023-03-04 14:37:05','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (92,'1dc838cc7491ca9b8947682cc2d30cef','2023-03-04 14:38:32','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (93,'58d367b4286a26bd1ee0eb93b6d7c2a6','2023-03-04 14:40:38','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (94,'fc8b1716c602fae90f837e36ee83c1b2','2023-03-04 14:42:09','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (95,'a89b9394c6ae12aa139fa2069b38e2cc','2023-03-15 08:51:16','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (96,'a8da393e37f62d470fff65ab11945af7','2023-03-15 10:43:25','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (97,'b0a320af17104fbf438acc281e0c52c0','2023-03-21 09:33:22','682474@student.inholland.nl');
INSERT INTO `resettokens` VALUES (98,'4b1427936959571a27e866cc7d0fe563','2023-03-23 10:19:54','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (99,'60559f962a9dd6f40d8840bfe1f0290e','2023-04-11 07:37:16','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (100,'f7488ab3676b72b35eca676b79c9eced','2023-05-02 09:07:29','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (101,'e3eff77df9de989e7fce46982393d8aa','2023-06-16 10:31:52','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (102,'6e47dfd1430d6434f5bcd44ca9fcd645','2023-06-21 13:09:19','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (103,'89176d6a87921eb6cc5e87a2a93ff460','2023-06-21 13:16:12','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (104,'617d36214fae51f4d1d109d565ff061a','2023-06-21 13:17:41','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (105,'83cccb95bf9f3dc38c1b4e5cdae4d0cc','2023-06-21 13:19:52','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (106,'b33f3b0739dbdaf0e4fb652d6be25a4f','2023-06-21 13:22:53','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (107,'e6cbaaee4dbe3a8184f9369d05652942','2023-06-21 13:23:47','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (108,'69a15d7efa51fa8fa65227f773ecf543','2023-06-21 13:26:37','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (109,'2c27d53d6712bd7c212d1499ea721f58','2023-06-21 13:28:02','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (110,'bc1352b95574ecfb36db1615e63e9628','2023-06-21 13:29:37','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (111,'7baa6e669b76a29bf309ca655c11157f','2023-06-21 13:30:24','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (112,'9a93e9c81492a304cfaa293156d2c3a9','2023-06-21 13:31:21','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (113,'4917c93598ea7dc13fdcda263c28ba3e','2023-06-21 13:39:52','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (114,'cbc71dabc3d717c4a85f62d9f53e8408','2023-06-21 13:40:11','testclient@kfigura.nl');
INSERT INTO `resettokens` VALUES (115,'2b8e9c105d26bce0e96c6c916ed55b82','2023-06-21 13:42:26','testclient@kfigura.nl');
INSERT INTO `resettokens` VALUES (116,'dc0e154bece7fdea56cd13e42546954f','2023-06-21 13:44:08','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (117,'97fc9a66f7ea66a0f17e0c7b38a61fd4','2023-06-21 13:44:40','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (118,'fc3afdf5e62b8166fae03726ebb4999d','2023-06-21 13:47:55','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (119,'2e3acf745ba6cfefb29c55589feed8e6','2023-06-21 13:54:30','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (120,'eaa840e3a903b9d666784f9a34473e2b','2023-06-21 14:25:10','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (121,'0aa4f291aa20c47a4acd352f6b847f60','2023-06-21 14:25:39','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (122,'266c41aba5bd429bc81b7c5cbdfbc6ef','2023-06-21 14:26:28','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (123,'e891b2071fcc4954a746a80b77c0c514','2023-06-21 14:28:41','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (124,'ccd427d55f83d257914dc4660f474a6d','2023-06-21 14:29:26','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (125,'cf32a08993a679d939d892be22f0ad1d','2023-06-21 14:29:46','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (126,'522701662f45a7efb2fd20a95f7a2f66','2023-06-21 14:32:04','turkvedat0911@gmail.com');
INSERT INTO `resettokens` VALUES (127,'2735a510c1839dc0cacd6cff47f2a52d','2023-06-21 21:32:47','mail@kfigura.nl');
INSERT INTO `resettokens` VALUES (128,'c24f17cfbd56f30384861a91b4b3972b','2023-06-21 21:33:46','mail@kfigura.nl');
INSERT INTO `resettokens` VALUES (129,'3badf6c0db7924d0e6e51a1ff7b1569b','2023-06-21 21:35:17','mail@kfigura.nl');
INSERT INTO `resettokens` VALUES (130,'bff02caa4e8770b0ae507ba2ab677770','2023-06-21 21:36:19','aathlon@outlook.com');
INSERT INTO `resettokens` VALUES (131,'02a5b9584e69a5d6008d269f252818a6','2023-06-21 21:37:32','aathlon@outlook.com');
INSERT INTO `resettokens` VALUES (132,'52916a5fba7f94b70ec6d97b38150cf9','2023-06-21 21:38:14','aathlon@outlook.com');
INSERT INTO `resettokens` VALUES (133,'4c3c6b10e1b6697ae7c669e715969a01','2023-06-21 21:38:52','aathlon@outlook.com');
INSERT INTO `resettokens` VALUES (134,'04df2a112f875382eb3b3a29c2f47e6a','2023-06-21 21:39:15','aathlon@outlook.com');
INSERT INTO `resettokens` VALUES (135,'3cb200d07c2719a92b3198bec57e22a1','2023-06-21 21:40:37','aathlon@outlook.com');
INSERT INTO `resettokens` VALUES (136,'c709cecba7de1128c55b42218f89d125','2023-06-21 21:42:39','aathlon@outlook.com');
/*!40000 ALTER TABLE `resettokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurantevent`
--

DROP TABLE IF EXISTS `restaurantevent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurantevent` (
  `eventId` varchar(100) DEFAULT NULL,
  `restaurantId` varchar(100) DEFAULT NULL,
  UNIQUE KEY `restaurantevent_un` (`eventId`,`restaurantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurantevent`
--

LOCK TABLES `restaurantevent` WRITE;
/*!40000 ALTER TABLE `restaurantevent` DISABLE KEYS */;
INSERT INTO `restaurantevent` VALUES ('112','4');
INSERT INTO `restaurantevent` VALUES ('115','6');
INSERT INTO `restaurantevent` VALUES ('131','4');
/*!40000 ALTER TABLE `restaurantevent` ENABLE KEYS */;
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
  `description` varchar(500) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL,
  `rating` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`restaurantId`),
  KEY `restaurants_FK` (`typeId`),
  CONSTRAINT `restaurants_FK` FOREIGN KEY (`typeId`) REFERENCES `foodtype` (`typeId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (4,'Mr. & Mrs.',48,'Mr. & Mrs. offers an ambiance where you feel at ease. Mr. creates delicious taste explosions with honest products and Mrs. complements the dishes with the best matching wines.',45,2,4);
INSERT INTO `restaurants` VALUES (6,'Restaurant ML',47,'Restaurant ML is a restaurant in Haarlem, the Netherlands. It is a fine dining restaurant that has been awarded a Michelin star in the period 2011 to date. Gault Millau gave the restaurant 13 out of 20 points. Chef at ML Restaurant is Mark Gratama.',35,1,5);
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
INSERT INTO `strollhistoryticket` VALUES (3,1);
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
INSERT INTO `textpages` VALUES (1,'&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;&lt;img src=&quot;../img/jpg/imgcounter.jpg&quot; width=&quot;690&quot; height=&quot;145&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;\n&lt;h2&gt;Festival is in...&lt;/h2&gt;\n&lt;p id=&quot;countdown&quot;&gt;00:00:00:00&lt;br&gt;days hours minutes seconds&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;table style=&quot;color: var(--bs-body-color); font-family: var(--bs-body-font-family); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); background-color: var(--bs-body-bg); width: 100%; height: 787px; border-width: 0px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 292px;&quot;&gt;\n&lt;td style=&quot;height: 292px; border-width: 0px; padding: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/food-home.jpg&quot; alt=&quot;Food&quot; width=&quot;auto&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 292px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;Food&lt;/h2&gt;\n&lt;p&gt;While visiting Haarlem you can&amp;acute;t miss out on the incredible food experience of Haarlem. Haarlem has food for everyone&amp;rsquo;s taste. From Dutch to Italian, from Michelin Star restaurants to everything the kids will like. In Haarlem, you will find what you crave.&lt;/p&gt;\n&lt;p&gt;&lt;a href=&quot;../food&quot; aria-invalid=&quot;true&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 351px;&quot;&gt;\n&lt;td style=&quot;height: 351px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;Music &amp;amp; Dance&lt;/h2&gt;\n&lt;p&gt;With the annual world-famous &lt;strong&gt;Festival&lt;/strong&gt;, Haarlem is a perfect place to experience top-class Jazz music. Visit Haarlem during the July, to enjoy it!&lt;br&gt;If jazz isn&amp;rsquo;t your thing, and you prefer the night life, visit one of the numerous night clubs, including the &lt;strong&gt;Patronaat&lt;/strong&gt;.&lt;br&gt;Or if you&amp;rsquo;re feeling fancy, come and enjoy the &lt;strong&gt;Stadsschouwburg &amp;amp; Philharmonie Haarlem&lt;/strong&gt;, in order to taste the top-notch orchestral music.&lt;/p&gt;\n&lt;p&gt;&lt;a href=&quot;../music-and-dance&quot; aria-invalid=&quot;true&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 351px; border-width: 0px; padding-top: 12px; padding-right: 12px; padding-bottom: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/Image.jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 48px;&quot;&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding-top: 12px; padding-right: 12px; padding-bottom: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/history(1).jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;History&lt;/h2&gt;\n&lt;p&gt;Haarlem, with roots dating back to the 10th century, is a city with a rich and storied history. Located on the banks of the Spaarne river in the Zuid-Kennemerland region, it has served as the capital of Noord Holland province for centuries.&lt;br&gt;&lt;br&gt;Haarlem first appears in literary sources in the 10th century. In the source, the place is mentioned under the name of &amp;rsquo;Haarlem&amp;rsquo;. Archaeological research shows that there was already habitation in the area of Spaarne 1500 years before our era.&lt;/p&gt;\n&lt;p&gt;&lt;a href=&quot;../history&quot; aria-invalid=&quot;true&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 48px;&quot;&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;Art&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Haarlem is a city of aesthetic architecture and collections of masterpieces of world-famous artists. &lt;br&gt;&lt;br&gt;&lt;strong&gt;Dolhuys Museum of the Mind&lt;/strong&gt; is one of the most characteristic museums in this city in that it deals with the theme &amp;rsquo;mind&amp;rsquo;. &lt;br&gt;&lt;br&gt;If you are fascinated by dramatic stories and performances, then , you would better visit &lt;strong&gt;Theatre de liefde&lt;/strong&gt;, which allows you to meet a touching story and a fantastic view.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../art&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/history(2).jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 48px;&quot;&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px;&quot;&gt;&lt;img src=&quot;../img/jpg/kids.jpg&quot; width=&quot;600&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 48px; border-width: 0px; padding: 12px; text-align: center;&quot;&gt;\n&lt;h2&gt;Kids&lt;/h2&gt;\n&lt;p style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Haarlem is one of the most kid-friendly towns in the Netherlands. Large car-free zones in the city centre allow your children to run around in relative safety.&lt;br&gt;Of course, safety isn&amp;rsquo;t everything, there are many activities to do and places to visit that will keep your little ones entertained as well!&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../kids&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;div&gt;&lt;a href=&quot;../festival&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;The Festival&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/Image.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;Visit Haarlem during The Festival!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/div&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;strong&gt;The Festival &lt;/strong&gt;is an annual event held in Haarlem. &lt;br&gt;&lt;br&gt;The festival features a diverse lineup of &lt;strong&gt;concerts&lt;/strong&gt;, but also represents the city&amp;rsquo;s &lt;strong&gt;history&lt;/strong&gt;, and the &lt;strong&gt;culinary&lt;/strong&gt; aspect of the town. The festival takes place over several days in &lt;strong&gt;July&lt;/strong&gt; and includes both indoor and outdoor concerts, as well as tours and other events. The Festival attracts &lt;strong&gt;music&lt;/strong&gt;, &lt;strong&gt;culinary&lt;/strong&gt;, and&lt;strong&gt; history lovers&lt;/strong&gt; from all over the world and has become an important cultural event in the city.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;iframe src=&quot;https://www.instagram.com/visithaarlem/embed/&quot; width=&quot;100%&quot; height=&quot;480&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;');
INSERT INTO `textpages` VALUES (4,'&lt;table style=&quot;border-collapse: collapse; width: 100%; height: 726.266px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50.0471%;&quot;&gt;&lt;col style=&quot;width: 49.9529%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 362.733px;&quot;&gt;\n&lt;td style=&quot;height: 362.733px;&quot;&gt;&lt;a href=&quot;../festival/dance&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;DANCE!&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/EDM_1.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;We welcome you to the parties with the most hottest artists in the world!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 362.733px;&quot;&gt;&lt;a href=&quot;../festival/jazz&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;Haarlem Jazz&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/Jazz.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;The annual festival, representing one of the best Jazz players!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 363.533px;&quot;&gt;\n&lt;td style=&quot;height: 363.533px;&quot;&gt;&lt;a href=&quot;../festival/history-stroll-2&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;A Stroll Through Haarlem&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/History.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;Welcome to a city that is filled with historical monuments, spectacular museums and world-famous art!&amp;nbsp;&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 363.533px;&quot;&gt;&lt;a href=&quot;../festival/yummy&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;Yummy!&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/Erva-Cafe-Restaurant-Haarlem_1.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;These are all the Restaurant which are participating in the Haarlem Festival.&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;div&gt;&lt;a href=&quot;../festival/tyler-mystery&quot; aria-invalid=&quot;true&quot;&gt;\n&lt;div class=&quot;card img-fluid nav-tile&quot;&gt;\n&lt;div class=&quot;carousel-caption&quot;&gt;\n&lt;p&gt;The&amp;nbsp;Teyler Mystery&lt;/p&gt;\n&lt;/div&gt;\n&lt;img class=&quot;card-img-top&quot; src=&quot;../img/jpg/teylers.jpg&quot;&gt;\n&lt;div class=&quot;card-img-overlay&quot;&gt;\n&lt;p class=&quot;card-text w-65 inline-block&quot;&gt;Visit the Teyler&amp;rsquo;s Museum and solve the secret of Dr. Teyler!&lt;/p&gt;\n&lt;button class=&quot;btn btn-primary float-end&quot;&gt;Learn More&lt;/button&gt;&lt;/div&gt;\n&lt;/div&gt;\n&lt;/a&gt;&lt;/div&gt;\n&lt;h2&gt;Event Area&lt;/h2&gt;\n&lt;div id=&quot;mapContainer&quot; class=&quot;row&quot; data-mapkind=&quot;general&quot;&gt;&lt;/div&gt;\n&lt;h2&gt;Schedule&lt;/h2&gt;\n&lt;div id=&quot;calendar&quot; class=&quot;row&quot; data-calendar-type=&quot;all-events&quot;&gt;&lt;/div&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;');
INSERT INTO `textpages` VALUES (5,'&lt;p style=&quot;text-align: center;&quot;&gt;Haarlem is a city in the Netherlands known for its rich history and culture, including its music scene. The city has a long tradition of producing and fostering talented musicians. Experience it yourself!&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50.0362%;&quot;&gt;&lt;col style=&quot;width: 49.9639%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto;&quot; src=&quot;../img/jpg/Image.jpg&quot; width=&quot;646&quot; height=&quot;362&quot;&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto;&quot; src=&quot;../img/jpg/Image(1).jpg&quot; width=&quot;646&quot; height=&quot;362&quot;&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;h2&gt;Haarlem Jazz Festival&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;One of the most famous musical events in Haarlem is the annual &lt;strong&gt;Haarlem Jazz &amp;amp; More festival&lt;/strong&gt;, which brings together jazz and world music artists from around the globe. The festival, which has been held every summer since 1986, attracts thousands of music fans to the city&#039;s historic Grote Markt square.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival/jazz&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Learn more&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;h2&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Stadsschouwburg &amp;amp; Philharmonie Haarlem&lt;/span&gt;&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Looking for an unforgettable night of entertainment? Look no further than &lt;strong&gt;Stadsschouwburg &amp;amp; Philharmonie Haarlem&lt;/strong&gt;! Located in the heart of the city, our state-of-the-art theatre and concert hall is the perfect venue for experiencing the best in music, dance, theatre, and more.&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;h2&gt;&lt;img src=&quot;../img/jpg/Image(2).jpg&quot; width=&quot;646&quot; height=&quot;auto&quot;&gt;&lt;/h2&gt;\n&lt;/td&gt;\n&lt;td&gt;\n&lt;h2&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Patronaat&lt;br&gt;&lt;/span&gt;&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;strong&gt;Patronaat Haarlem&lt;/strong&gt; is a premier venue for live music and entertainment. With a capacity of over 1,000 people, it has the space to host some of the biggest and best names in the industry.&lt;br&gt;Their state-of-the-art sound and lighting systems ensure that every performance is an unforgettable experience. Whether you&#039;re a fan of rock, pop, electronic, or any other genre, they have something for everyone.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Browse Events&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/bottom.jpg&quot; width=&quot;100%&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h2&gt;...and more&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Haarlem&#039;s music scene is diverse and vibrant, offering something for every taste. Whether you&#039;re a classical music aficionado or a fan of more contemporary sounds, there is always something exciting happening in Haarlem&#039;s music scene.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;&lt;a href=&quot;../festival&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;Browse Events&lt;/button&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;');
INSERT INTO `textpages` VALUES (6,'&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h1 style=&quot;text-align: center;&quot;&gt;Food&lt;/h1&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;You favorite Restaurants all in one place. From Dutch to Italien to Michelin Star restaurants Haarlem has it all. Have trouble deciding have a look at our recommendations.&lt;/p&gt;\n&lt;div class=&quot;container text-center border&quot;&gt;\n&lt;div class=&quot;row&quot;&gt;\n&lt;div class=&quot;col-6 border&quot;&gt;\n&lt;h3&gt;Michelin Star Restaurants&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Haarlem has 3 Michelin Star Restaurants. One of them is Ratatouille which has a mix frensh cuisine.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-warning&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6 border&quot;&gt;\n&lt;h3&gt;Restaurant With the Best View&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Da Dakka is on top of a parking garage which has 5 floors, which means the restaurant overlooks a big part of Haarlem.&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-warning&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;Haarlem&amp;rsquo;s Brewery Special Experience&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;Jopenkerk is a brewery which is build inside a church founded in 1998. Which brews bier with a recipe from 1407.Which makes a unique experience. Which the Citizens of Haarlem are really proud of.&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;button class=&quot;btn btn-primary&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;hr&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div style=&quot;text-align: center;&quot;&gt;\n&lt;div class=&quot;btn-group&quot; style=&quot;text-align: center;&quot;&gt;&lt;button class=&quot;btn btn-secondary dropdown-toggle&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; data-bs-display=&quot;static&quot; aria-expanded=&quot;false&quot;&gt; Food Type &lt;/button&gt;\n&lt;ul class=&quot;dropdown-menu dropdown-menu-lg-end&quot;&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;/ul&gt;\n&lt;/div&gt;\n&lt;div class=&quot;btn-group&quot; style=&quot;text-align: center;&quot;&gt;&lt;button class=&quot;btn btn-secondary dropdown-toggle ms-5&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; data-bs-display=&quot;static&quot; aria-expanded=&quot;false&quot;&gt; Food Type &lt;/button&gt;&lt;/div&gt;\n&lt;div class=&quot;btn-group&quot; style=&quot;text-align: center;&quot;&gt;\n&lt;ul class=&quot;dropdown-menu dropdown-menu-lg-end&quot;&gt;\n&lt;li&gt;&amp;nbsp;&lt;/li&gt;\n&lt;li&gt;&amp;nbsp;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;li&gt;&lt;a class=&quot;dropdown-item&quot; href=&quot;#&quot;&gt;Menu item&lt;/a&gt;&lt;/li&gt;\n&lt;/ul&gt;\n&lt;/div&gt;\n&lt;div&gt;\n&lt;div class=&quot;card&quot;&gt;\n&lt;h5 class=&quot;card-header&quot; style=&quot;text-align: center;&quot;&gt;Featured&lt;/h5&gt;\n&lt;div class=&quot;card-body&quot;&gt;\n&lt;div class=&quot;container text-center&quot;&gt;\n&lt;div class=&quot;row&quot;&gt;\n&lt;div class=&quot;col-4&quot;&gt;\n&lt;h2&gt;Ratatouille&lt;/h2&gt;\n&lt;p&gt;Chef Joshua Jaring&#039;s successful Michelin restaurant in Haarlem is &amp;ndash; just like Ratatouille &amp;ndash; a mix of French cuisine in today&#039;s reality with an excellent price-quality ratio in an accessible environment in Haarlem.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-warning&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-4&quot;&gt;way point and image&lt;/div&gt;\n&lt;div class=&quot;col-4&quot;&gt;image&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;');
INSERT INTO `textpages` VALUES (7,'&lt;h1 style=&quot;text-align: center;&quot;&gt;History&lt;/h1&gt;\n&lt;p&gt;Haarlem is a city in the Netherlands and the capital of the province of Noord Holland. The city is located on the river Spaarne and in the Zuid-Kennemerland region. Haarlem first appears in literary sources in the 10th century. In the source, the place is mentioned under the name of &amp;rsquo;Haralem&amp;rsquo;. Archaeological research shows that there was already habitation in the are of Spaarne 1500 years before our era.&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 170.94%; height: 491px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 22.4054%;&quot;&gt;&lt;col style=&quot;width: 77.5951%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;&lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.22.57_(1).jpg&quot; alt=&quot;undefined&quot; width=&quot;447&quot; height=&quot;331&quot;&gt;&lt;/td&gt;\n&lt;td&gt;&lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.22.57.jpg&quot; alt=&quot;undefined&quot; width=&quot;654&quot; height=&quot;327&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%; height: 536.352px; border-width: 0px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 28.7995%;&quot;&gt;&lt;col style=&quot;width: 30.7307%;&quot;&gt;&lt;col style=&quot;width: 40.4705%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 69.125px;&quot;&gt;\n&lt;td style=&quot;height: 69.125px;&quot;&gt;\n&lt;h3&gt;Cafe Brinkman&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 69.125px;&quot;&gt;\n&lt;h3&gt;De Gooth&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 69.125px;&quot;&gt;\n&lt;h3&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Cafe Gierstraat / Cafe &amp;lsquo;t Kantoor&lt;/span&gt;&lt;/h3&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 440.227px;&quot;&gt;\n&lt;td style=&quot;height: 440.227px;&quot;&gt;&lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.32.24.jpg&quot; alt=&quot;undefined&quot; width=&quot;392&quot; height=&quot;261&quot;&gt; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;/td&gt;\n&lt;td style=&quot;height: 440.227px;&quot;&gt;&lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.32.24_(1).jpg&quot; alt=&quot;undefined&quot; width=&quot;421&quot; height=&quot;280&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 440.227px;&quot;&gt;&lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.32.24_(2).jpg&quot; alt=&quot;undefined&quot; width=&quot;556&quot; height=&quot;370&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 27px;&quot;&gt;\n&lt;td style=&quot;text-align: right; height: 27px;&quot;&gt;Grote Markt 13&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: right;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Botermarkt 19&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: right;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Gierstraat 78&lt;/span&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;color: var(--bs-body-color); font-family: var(--bs-body-font-family); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align); width: 100%; height: 1605.62px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 52.3041%;&quot;&gt;&lt;col style=&quot;width: 47.6959%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 563px;&quot;&gt;\n&lt;td style=&quot;height: 563px;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;img src=&quot;../img/jpg/Verwey-Museum-Haarlem-nieuw-logo-en-banieren-LR.jpg&quot; alt=&quot;undefined&quot; width=&quot;451&quot; height=&quot;300&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 563px;&quot;&gt;\n&lt;h3&gt;&lt;strong&gt;Verwey Museum Haarlem&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;Verwey Museum Haarlem is a museum in Haarlem about the history and cultural heritatge of Haarlem and Zuid-Kennemerland. The city museum is located in the historic center of Haarlem at Groot Heigland 47.&lt;strong&gt;&lt;br&gt;&lt;br&gt;&lt;/strong&gt;The Zuid-Kennemerland Historical Museum Foundation was established on August 25, 1975. Until 1990, the foundation was active as a historical information center. In 2005 the name of the museum was changed to Historical Museum Haarlem.&lt;strong&gt; &lt;br&gt;&lt;br&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 315.539px;&quot;&gt;\n&lt;td style=&quot;height: 315.539px;&quot;&gt;\n&lt;h3&gt;&lt;strong&gt;Archeology Museum Haarlem&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;The Archeology Museum Haarlem is a museum in the cellar of the Vleeshal on the Grote Markt in Haarlem, dedicated to promoting interesting and conserving the archeological heritage of Kennemerland. &lt;br&gt;&lt;br&gt;The museum is kept open by a large group of volunteers who gather on Wednesday evenings to discuss, document and clean finds. Discoveries are published monthly by the the volunteers.&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 315.539px;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.45.15.jpg&quot; alt=&quot;undefined&quot; width=&quot;411&quot; height=&quot;274&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 363.539px;&quot;&gt;\n&lt;td style=&quot;height: 363.539px;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &lt;img src=&quot;../img/jpg/WhatsApp_Image_2023-06-21_at_20.45.15_(1).jpg&quot; alt=&quot;undefined&quot; width=&quot;390&quot; height=&quot;260&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 363.539px;&quot;&gt;\n&lt;h3&gt;&lt;strong&gt;Frans Hals Museum&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;The Frans Hals Museum is a museum in the North Holland city of Haarlem, founded in 1862, known as &amp;ldquo;museum of the Golden Age&amp;rdquo;. The collection is based on the rich collection of the city itself, which has been built up since the 16th century.&lt;br&gt;&lt;br&gt;The collection is based on the rich collection of the city itself, which has been built up since the 16th century. The museum holds hunderds of paintinigs, including more than a dozen by Frans Haals, from whom the museum takes its name.&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 363.539px;&quot;&gt;\n&lt;td style=&quot;height: 363.539px;&quot;&gt;\n&lt;h3&gt;&lt;strong&gt;NZH Vervoer Museum&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;NZH Vervoer Maatschappij (NZH Public Transport Company) has an established name since 1881. From the very start a leading entrepreneur in the public transport sector. Unfortunately recent far reaching developments and many changes have put this to a halt. Fortunately some people realized that NHZ has become relevant of the city&amp;rsquo;s history. These people started to collect everything related to NZH&amp;rsquo;s history.&lt;br&gt;&lt;br&gt;The entrance of the museum, as well as the restrooms are easily accessible for people using wheelchairs.&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 363.539px;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &lt;img src=&quot;../img/jpg/nzhvervoermuseumbussentrams_vervoermuseumtramsbussenhaarlem_3_350_235.jpg&quot; alt=&quot;undefined&quot;&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;');
INSERT INTO `textpages` VALUES (8,'&lt;h1 style=&quot;text-align: center;&quot;&gt;Art or no art is the question?&lt;/h1&gt;');
INSERT INTO `textpages` VALUES (9,'&lt;h1 style=&quot;text-align: center;&quot;&gt;Kids&lt;/h1&gt;\n&lt;div class=&quot;container&quot;&gt;\n&lt;div class=&quot;row border mt-5&quot;&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;Climbing Wall Haarlem&lt;/h3&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;image&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p class=&quot;fs-8&quot; style=&quot;text-align: center;&quot;&gt;The Climbing Wall is a fun way for children to spend an afternoon indoors, exercising! &lt;br&gt;&lt;br&gt;Afraid of heights or not, the Climbing Wall in Haarlem is a fun, safe activity that requires you to think on your feet and climb to the top! Afterwards, have a break at the restaurant on location.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-success&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;row border mt-5&quot;&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;Mister Paprika&lt;/h3&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;image&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;If you&amp;rsquo;re in the city centre, take a pit stop at &amp;ldquo;Meneer Paprika&amp;rdquo;, a cafe and toy shop in one! Tables are arranged around a huge toddler-height train set so you can keep an eye on your little ones wherever you&amp;rsquo;re sat.&lt;br&gt;&lt;br&gt;The cafe offers breakfast, lunch and dinner, as well as cake, or just something to drink.&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-success&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;div class=&quot;row border mt-5&quot;&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;The Teylers Museum&lt;/h3&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;image&lt;/p&gt;\n&lt;/div&gt;\n&lt;div class=&quot;col-6&quot;&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;Interactive, informative, and most important of all, loads of fun! Kids will love the Teylers Museum of Wonder. Fantastic fossils, preserved beasts, sparkling minerals and impressive gadgets are just some of the weird and wonderful items on display at this beautiful museum. &lt;br&gt;&lt;br&gt;During the Haarlem Festival, there is even a very fun treasure hunt just for children, you can find it on our website by pressing the button below!&lt;/p&gt;\n&lt;p&gt;&lt;button class=&quot;btn btn-success&quot;&gt;More info&lt;/button&gt;&lt;/p&gt;\n&lt;/div&gt;\n&lt;/div&gt;\n&lt;/div&gt;');
INSERT INTO `textpages` VALUES (10,'&lt;h2 style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/h2&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;Experience DANCE! during the Haarlem Festival!&lt;/h2&gt;\n&lt;div id=&quot;allday-pass&quot; data-kind=&quot;dance&quot;&gt;&lt;/div&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;Browse the many available events to see who&#039;s playing&lt;/p&gt;\n&lt;div id=&quot;events&quot; data-type=&quot;dance&quot;&gt;&lt;/div&gt;\n&lt;h3 style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/h3&gt;');
INSERT INTO `textpages` VALUES (11,'&lt;h2 style=&quot;text-align: center;&quot;&gt;Experience a fine Jazz (and not only)&lt;/h2&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;The Jazz &amp;amp; More Festival is a yearly event held in Haarlem. It features a diverse lineup of jazz and other musical performers, offering attendees the opportunity to experience a wide range of genres and styles.&amp;nbsp;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;The festival&#039;s mission is to bring top-quality musical performances to everyone, making it a must-attend event for music lovers.&lt;/p&gt;\n&lt;div id=&quot;allday-pass&quot; data-kind=&quot;jazz&quot;&gt;&lt;/div&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div id=&quot;events&quot; data-type=&quot;jazz&quot;&gt;&lt;/div&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/p&gt;');
INSERT INTO `textpages` VALUES (13,'');
INSERT INTO `textpages` VALUES (14,'&lt;p&gt;Placeholder, The Teyler Mystery has not been implemented as part of the project.&lt;/p&gt;');
INSERT INTO `textpages` VALUES (15,'&lt;h1 style=&quot;text-align: center;&quot;&gt;Welcome to The Festival Haarlem&lt;/h1&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 50%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td&gt;\n&lt;h2&gt;Let&#039;s tour around Haarlem&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;Welcome to a city that is filled with historical monuments, spectacular museums and world-famous art! Cars are not allowed on many streets in Haarlem, which makes it a great city for a tour! &lt;br&gt;&lt;br&gt;We organise tours every day during The Festival Haarlem. &lt;br&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;\n&lt;h2&gt;Starting Point&lt;/h2&gt;\n&lt;p&gt;Bavo Church&lt;/p&gt;\n&lt;p&gt;(Age 12+)&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;\n&lt;h2&gt;Time&lt;/h2&gt;\n&lt;p&gt;Every festival day:&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;10:00&lt;/li&gt;\n&lt;li&gt;13:00&lt;/li&gt;\n&lt;li&gt;16:00&lt;/li&gt;\n&lt;/ul&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;div id=&quot;events&quot; data-type=&quot;stroll&quot;&gt;&lt;/div&gt;\n&lt;div data-type=&quot;stroll&quot;&gt;&amp;nbsp;&lt;/div&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;--- During 2.5 hours, you will visit ---&lt;/h2&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 99.1336%; height: 334.4px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 23.17%;&quot;&gt;&lt;col style=&quot;width: 1.61136%;&quot;&gt;&lt;col style=&quot;width: 33.6735%;&quot;&gt;&lt;col style=&quot;width: 41.4723%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 334.4px;&quot;&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;&lt;img src=&quot;../img/jpg/HaarlemGroteMarkt1.JPG&quot; width=&quot;100%&quot; height=&quot;auto&quot;&gt;&lt;/td&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;\n&lt;h2&gt;St. Bavo Church (A)&lt;/h2&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Sint Bavokerk is the largest church in Haarlem. The St Bavo Church is also called the Grote Kerk and is popularly referred to as &amp;ldquo;the old baaf&amp;rdquo;. The St Bavo church is already mentioned in documents from 1245. &lt;br&gt;&lt;br&gt;Since 1245, the church has expanded to its current size with seven bells and a beautiful tower. To this day, the St Bavo Church is the highest building in Haarlem.&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 334.4px;&quot;&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;One drink per person&lt;/h2&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;../img/jpg/brouwerij-restaurant-jopenkerk-haarlem-jopenbier_4082379069.jpg&quot; width=&quot;264&quot; height=&quot;176&quot;&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;15 minute break at Jopenkerk&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;table style=&quot;border-collapse: collapse; width: 100%; height: 549.1px;&quot; border=&quot;0&quot;&gt;&lt;colgroup&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;col style=&quot;width: 25%;&quot;&gt;&lt;/colgroup&gt;\n&lt;tbody&gt;\n&lt;tr style=&quot;height: 336.7px;&quot;&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21.jpg&quot; width=&quot;200px&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Grote Markt (B)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_212.jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;De Hallen (C)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(1).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Proveniershof (D)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 336.7px;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_307.jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Jopenkerk (E)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 185.4px;&quot;&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;\n&lt;p&gt;The market square features several works of art, including a statue honoring Laurenz Janszoon Coster, who is widely credited with inventing printing in the Netherlands.&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;De Hallen is a contemporary art museum hosting exhibitions featuring national and international artists. Exhibitions are held three times a year and focus on current developments in the visual arts.&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Proveniershof is a unique courtyard area in Haarlem, originally intended for the wealthy bourgeoisie. Its houses differ in appearance from other small courtyards in the area.&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center; height: 185.4px;&quot;&gt;\n&lt;p&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The story Jopen begins in the 14th century when Haarlem was one of the most important brewing cities in the Netherlands. &lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height: 27px;&quot;&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(2).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&amp;nbsp;&lt;/p&gt;\n&lt;h3&gt;Waalse Kerk (F)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(3).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Molen de Adriaan (G)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(4).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Amsterdamse Poort (H)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;td style=&quot;height: 27px; text-align: center;&quot;&gt;\n&lt;p&gt;&lt;img src=&quot;../img/jpg/Frame_21(5).jpg&quot; width=&quot;200&quot; height=&quot;auto&quot;&gt;&lt;/p&gt;\n&lt;h3&gt;Hof van Bakenes (F)&lt;/h3&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Waalse Kerk is a Walloon church that was built in the 14th century. It has an upper gallery that was originally built for the Beguines who lived on the courtyard that still bears their name. &lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;In 1778, a businessman from Amsterdam purchased an old defense tower in Haarlem and received permission to build a windmill on top of it. The tower was subsequently transformed into a windmill.&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Amsterdamse Poort is a gate located in Haarlem. It is one of the original gates of the city&#039;s old defensive wall and has been well-preserved over the years. It is a significant part of Haarlem&#039;s history.&lt;/span&gt;&lt;/td&gt;\n&lt;td style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;white-space: pre-wrap;&quot;&gt;The Hofje van Bakenes is located on the Bakenessergracht and has two entrances. The main entrance is located on the Wijde Appelaarsteeg. The courtyard at this location is the oldest one in Haarlem.&lt;/span&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;&amp;nbsp;&lt;/h2&gt;\n&lt;h2 style=&quot;text-align: center;&quot;&gt;--- Haarlem in Maps ---&lt;/h2&gt;\n&lt;p&gt;&lt;iframe src=&quot;https://www.google.com/maps/d/u/0/embed?mid=1R3EC9xY6xPNKRIk0CG3kO20wrgsPMHc&amp;amp;ehbc=2E312F&quot; width=&quot;100%&quot; height=&quot;480&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;\n&lt;div id=&quot;calendar&quot; class=&quot;row&quot; data-calendar-type=&quot;stroll&quot;&gt;&lt;/div&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;');
/*!40000 ALTER TABLE `textpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketlinks`
--

DROP TABLE IF EXISTS `ticketlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticketlinks` (
  `ticketLinkId` int(11) NOT NULL AUTO_INCREMENT,
  `ticketTypeId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  PRIMARY KEY (`ticketLinkId`),
  KEY `ticketlinks_FK_1` (`eventId`),
  KEY `ticketlinks_FK` (`ticketTypeId`),
  CONSTRAINT `ticketlinks_FK` FOREIGN KEY (`ticketTypeId`) REFERENCES `tickettypes` (`ticketTypeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ticketlinks_FK_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 COMMENT='Table that links types of tickets to events for which they can be bought';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketlinks`
--

LOCK TABLES `ticketlinks` WRITE;
/*!40000 ALTER TABLE `ticketlinks` DISABLE KEYS */;
INSERT INTO `ticketlinks` VALUES (1,1,2);
INSERT INTO `ticketlinks` VALUES (2,2,2);
INSERT INTO `ticketlinks` VALUES (3,1,4);
INSERT INTO `ticketlinks` VALUES (4,2,4);
INSERT INTO `ticketlinks` VALUES (5,4,1);
INSERT INTO `ticketlinks` VALUES (6,4,7);
INSERT INTO `ticketlinks` VALUES (7,6,8);
INSERT INTO `ticketlinks` VALUES (8,7,14);
INSERT INTO `ticketlinks` VALUES (9,7,15);
INSERT INTO `ticketlinks` VALUES (10,7,16);
INSERT INTO `ticketlinks` VALUES (11,7,17);
INSERT INTO `ticketlinks` VALUES (12,8,18);
INSERT INTO `ticketlinks` VALUES (13,4,19);
INSERT INTO `ticketlinks` VALUES (14,6,20);
INSERT INTO `ticketlinks` VALUES (15,9,21);
INSERT INTO `ticketlinks` VALUES (16,6,22);
INSERT INTO `ticketlinks` VALUES (17,4,23);
INSERT INTO `ticketlinks` VALUES (18,6,24);
INSERT INTO `ticketlinks` VALUES (20,6,26);
INSERT INTO `ticketlinks` VALUES (21,5,27);
INSERT INTO `ticketlinks` VALUES (22,5,28);
INSERT INTO `ticketlinks` VALUES (23,4,29);
INSERT INTO `ticketlinks` VALUES (24,4,30);
INSERT INTO `ticketlinks` VALUES (26,5,32);
INSERT INTO `ticketlinks` VALUES (27,5,33);
INSERT INTO `ticketlinks` VALUES (28,6,34);
INSERT INTO `ticketlinks` VALUES (29,5,35);
INSERT INTO `ticketlinks` VALUES (30,4,36);
INSERT INTO `ticketlinks` VALUES (31,4,37);
INSERT INTO `ticketlinks` VALUES (32,9,38);
INSERT INTO `ticketlinks` VALUES (33,9,39);
INSERT INTO `ticketlinks` VALUES (36,5,42);
INSERT INTO `ticketlinks` VALUES (37,10,44);
INSERT INTO `ticketlinks` VALUES (38,11,45);
INSERT INTO `ticketlinks` VALUES (39,11,46);
INSERT INTO `ticketlinks` VALUES (40,13,47);
INSERT INTO `ticketlinks` VALUES (53,1,66);
INSERT INTO `ticketlinks` VALUES (55,1,68);
INSERT INTO `ticketlinks` VALUES (56,1,69);
INSERT INTO `ticketlinks` VALUES (58,2,71);
INSERT INTO `ticketlinks` VALUES (59,2,72);
INSERT INTO `ticketlinks` VALUES (61,1,74);
INSERT INTO `ticketlinks` VALUES (62,2,75);
INSERT INTO `ticketlinks` VALUES (63,2,76);
INSERT INTO `ticketlinks` VALUES (64,1,77);
INSERT INTO `ticketlinks` VALUES (65,2,78);
INSERT INTO `ticketlinks` VALUES (66,1,79);
INSERT INTO `ticketlinks` VALUES (67,2,80);
INSERT INTO `ticketlinks` VALUES (68,1,81);
INSERT INTO `ticketlinks` VALUES (69,2,82);
INSERT INTO `ticketlinks` VALUES (70,2,83);
INSERT INTO `ticketlinks` VALUES (71,2,84);
INSERT INTO `ticketlinks` VALUES (72,2,85);
INSERT INTO `ticketlinks` VALUES (73,1,86);
INSERT INTO `ticketlinks` VALUES (74,1,87);
INSERT INTO `ticketlinks` VALUES (75,1,88);
INSERT INTO `ticketlinks` VALUES (76,2,89);
INSERT INTO `ticketlinks` VALUES (78,2,91);
INSERT INTO `ticketlinks` VALUES (79,1,92);
INSERT INTO `ticketlinks` VALUES (81,2,94);
INSERT INTO `ticketlinks` VALUES (82,1,95);
INSERT INTO `ticketlinks` VALUES (83,1,96);
INSERT INTO `ticketlinks` VALUES (84,1,97);
INSERT INTO `ticketlinks` VALUES (85,1,98);
INSERT INTO `ticketlinks` VALUES (86,1,99);
INSERT INTO `ticketlinks` VALUES (88,2,101);
INSERT INTO `ticketlinks` VALUES (89,2,102);
INSERT INTO `ticketlinks` VALUES (90,1,103);
INSERT INTO `ticketlinks` VALUES (91,1,104);
INSERT INTO `ticketlinks` VALUES (92,2,105);
INSERT INTO `ticketlinks` VALUES (93,1,106);
INSERT INTO `ticketlinks` VALUES (94,2,107);
INSERT INTO `ticketlinks` VALUES (95,1,108);
INSERT INTO `ticketlinks` VALUES (96,1,109);
INSERT INTO `ticketlinks` VALUES (97,14,113);
INSERT INTO `ticketlinks` VALUES (98,3,112);
INSERT INTO `ticketlinks` VALUES (99,3,115);
INSERT INTO `ticketlinks` VALUES (107,3,131);
INSERT INTO `ticketlinks` VALUES (108,18,132);
INSERT INTO `ticketlinks` VALUES (109,18,133);
INSERT INTO `ticketlinks` VALUES (110,18,134);
INSERT INTO `ticketlinks` VALUES (111,18,135);
INSERT INTO `ticketlinks` VALUES (112,15,136);
INSERT INTO `ticketlinks` VALUES (113,18,137);
INSERT INTO `ticketlinks` VALUES (114,16,138);
INSERT INTO `ticketlinks` VALUES (115,18,139);
INSERT INTO `ticketlinks` VALUES (116,15,140);
INSERT INTO `ticketlinks` VALUES (117,18,141);
INSERT INTO `ticketlinks` VALUES (118,17,142);
INSERT INTO `ticketlinks` VALUES (119,18,143);
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='Table for sold, generated tickets, belonging to orders.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (3,2,1,1,14.46,0.21,17.50,1);
INSERT INTO `tickets` VALUES (5,2,1,1,14.46,0.21,17.50,1);
INSERT INTO `tickets` VALUES (6,2,1,1,12.00,0.21,17.50,1);
INSERT INTO `tickets` VALUES (7,20,0,47,20.00,0.21,24.00,6);
INSERT INTO `tickets` VALUES (8,1,0,48,36.69,0.09,40.00,4);
INSERT INTO `tickets` VALUES (9,42,0,48,36.69,0.09,40.00,5);
INSERT INTO `tickets` VALUES (10,23,0,48,36.69,0.09,40.00,4);
INSERT INTO `tickets` VALUES (11,42,0,49,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (12,1,0,49,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (13,1,0,52,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (14,42,0,56,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (15,42,0,57,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (16,42,0,58,55.02,0.09,60.00,5);
INSERT INTO `tickets` VALUES (17,42,0,58,55.02,0.09,60.00,5);
INSERT INTO `tickets` VALUES (18,42,0,58,55.02,0.09,60.00,5);
INSERT INTO `tickets` VALUES (19,42,0,58,55.02,0.09,60.00,5);
INSERT INTO `tickets` VALUES (20,42,0,58,55.02,0.09,60.00,5);
INSERT INTO `tickets` VALUES (21,42,0,58,55.02,0.09,60.00,5);
INSERT INTO `tickets` VALUES (22,1,0,59,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (23,1,0,59,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (24,1,0,59,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (25,23,0,59,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (26,27,0,59,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (27,28,0,59,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (28,7,0,59,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (29,32,1,59,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (30,66,0,59,14.46,0.21,17.50,1);
INSERT INTO `tickets` VALUES (31,42,0,5,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (32,1,0,61,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (33,1,0,63,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (34,42,0,64,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (35,1,0,65,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (36,42,0,66,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (37,1,1,67,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (38,27,0,68,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (39,1,0,69,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (40,42,0,70,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (41,42,0,70,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (42,42,0,71,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (43,1,0,72,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (44,7,0,73,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (45,7,0,74,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (46,28,0,75,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (47,28,0,76,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (48,7,0,78,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (49,28,0,81,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (50,7,0,82,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (51,29,0,83,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (52,30,0,84,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (53,39,1,85,9.17,0.09,10.00,9);
INSERT INTO `tickets` VALUES (54,1,0,86,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (55,7,0,87,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (56,7,1,88,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (57,42,0,60,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (58,42,0,60,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (59,42,0,60,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (60,1,0,60,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (61,23,0,60,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (62,113,0,60,68.81,0.09,75.00,14);
INSERT INTO `tickets` VALUES (63,113,0,101,68.81,0.09,75.00,14);
INSERT INTO `tickets` VALUES (64,113,0,102,68.81,0.09,75.00,14);
INSERT INTO `tickets` VALUES (65,113,1,103,68.81,0.09,75.00,14);
INSERT INTO `tickets` VALUES (66,14,0,104,32.11,0.09,35.00,7);
INSERT INTO `tickets` VALUES (67,15,0,105,32.11,0.09,35.00,7);
INSERT INTO `tickets` VALUES (68,16,0,106,32.11,0.09,35.00,7);
INSERT INTO `tickets` VALUES (69,18,0,107,73.39,0.09,80.00,8);
INSERT INTO `tickets` VALUES (70,1,0,62,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (71,1,0,62,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (72,69,0,62,14.46,0.21,17.50,1);
INSERT INTO `tickets` VALUES (73,1,0,108,13.76,0.09,15.00,4);
INSERT INTO `tickets` VALUES (74,42,0,109,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (75,113,0,110,68.81,0.09,75.00,14);
INSERT INTO `tickets` VALUES (76,42,0,111,9.17,0.09,10.00,5);
INSERT INTO `tickets` VALUES (77,112,0,115,8.26,0.21,10.00,3);
INSERT INTO `tickets` VALUES (78,112,0,116,8.26,0.21,10.00,3);
INSERT INTO `tickets` VALUES (79,112,0,117,8.26,0.21,10.00,3);
INSERT INTO `tickets` VALUES (80,112,0,118,8.26,0.21,10.00,3);
INSERT INTO `tickets` VALUES (81,113,0,119,68.81,0.09,75.00,14);
INSERT INTO `tickets` VALUES (82,134,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (83,135,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (84,132,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (85,133,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (86,136,0,119,100.92,0.09,110.00,15);
INSERT INTO `tickets` VALUES (87,138,0,119,68.81,0.09,75.00,16);
INSERT INTO `tickets` VALUES (88,137,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (89,139,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (90,140,0,119,100.92,0.09,110.00,15);
INSERT INTO `tickets` VALUES (91,141,0,119,55.05,0.09,60.00,18);
INSERT INTO `tickets` VALUES (92,142,0,119,82.57,0.09,90.00,17);
INSERT INTO `tickets` VALUES (93,143,0,119,55.05,0.09,60.00,18);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Table for types of tickets that can be linked to events in cartitems table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickettypes`
--

LOCK TABLES `tickettypes` WRITE;
/*!40000 ALTER TABLE `tickettypes` DISABLE KEYS */;
INSERT INTO `tickettypes` VALUES (1,'Single',17.50,1);
INSERT INTO `tickettypes` VALUES (2,'Family',60.00,4);
INSERT INTO `tickettypes` VALUES (3,'Yummy - Reservation',10.00,1);
INSERT INTO `tickettypes` VALUES (4,'Jazz - Patronaat Main Hall',15.00,1);
INSERT INTO `tickettypes` VALUES (5,'Jazz - Patronaat Second Hall',10.00,1);
INSERT INTO `tickettypes` VALUES (6,'Jazz - Grote Markt',0.00,1);
INSERT INTO `tickettypes` VALUES (7,'Jazz - One-Day Pass',35.00,1);
INSERT INTO `tickettypes` VALUES (8,'Jazz - All-Day Pass',80.00,1);
INSERT INTO `tickettypes` VALUES (9,'Jazz - Patronaat Third Hall',10.00,1);
INSERT INTO `tickettypes` VALUES (10,'Dance - Friday Pass',125.00,1);
INSERT INTO `tickettypes` VALUES (11,'Dance - Weekend Pass',150.00,1);
INSERT INTO `tickettypes` VALUES (13,'Dance - All-Day Pass',250.00,1);
INSERT INTO `tickettypes` VALUES (14,'Dance - Back2Back',75.00,1);
INSERT INTO `tickettypes` VALUES (15,'Dance - Back2Back (3)',110.00,1);
INSERT INTO `tickettypes` VALUES (16,'Dance - TiÃ«stoWorld',75.00,1);
INSERT INTO `tickettypes` VALUES (17,'Dance - Hardwell',90.00,1);
INSERT INTO `tickettypes` VALUES (18,'Dance - Club ',60.00,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (27,'turkvedat0911@gmail.com','$2y$10$D46lhHtaWNCNku2JqffKM.ZKBfzZu9Yt.FLYyVjvHnL7Jd0rXT37i','Vedat','TÃ¼rk',1,'2023-03-02');
INSERT INTO `users` VALUES (33,'joshua.andrea@hotmail.com','$2y$10$5x3yFIIHyZTky94MDBhj.u23IJ4s5DDGKfWef04eoCmtGGif/cxeK','Joshua1','Andrea1',3,'2023-03-03');
INSERT INTO `users` VALUES (37,'aathlon@outlook.com','$2y$10$AA5Kbo7kJeGq0NM9PdSe5.TCsLdDVPpqGqclkRWQAUNJp6wmfBIy6','Konrad','Figura',1,'2023-04-03');
INSERT INTO `users` VALUES (41,'admin@example.com','$2y$10$qNY54rCbeHac28z7pG2d4uU88Ro6RpdziWuUTBF8XcRXChV2nLzuW','Admin','Account',1,'2023-04-14');
INSERT INTO `users` VALUES (42,'admin','$2y$10$lmySGRv7v1Y1B6nwr6DuuOS72577AyUNdh6nt9nWnEiJ2FjPsiJdi','admin','admin',1,'2023-05-03');
INSERT INTO `users` VALUES (43,'testclient@kfigura.nl','$2y$10$DCS4Nq4vnPHUeoXCPQ2MIu33Y9FV3CP.Mndci49F8thpNsQbRtMla','Ben','Dover',3,'2023-05-24');
INSERT INTO `users` VALUES (45,'demoemployee@example.com','$2y$10$zNdR8dKlJgWQXufUYi0FfOcTmpppC0pXuWuxlz6eJNOmI36cP9lem','Demo','Employee',2,'2023-06-15');
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

-- Dump completed on 2023-06-22  0:11:37
