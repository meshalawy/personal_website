-- MySQL dump 10.13  Distrib 5.1.60, for apple-darwin11.2.0 (i386)
--
-- Host: localhost    Database: marques
-- ------------------------------------------------------
-- Server version	5.1.60

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id for an activity log record',
  `type` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT 'the type of activity being logged',
  `notes` varchar(512) CHARACTER SET latin1 NOT NULL COMMENT 'the notes related to the activity',
  `timestamp` datetime NOT NULL COMMENT 'the date and time when the activity occured',
  PRIMARY KEY (`id`),
  KEY `activity_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COMMENT='Store details of activities that need to be logged for the p';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `australian_states`
--

DROP TABLE IF EXISTS `australian_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `australian_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'the unique identifier for a state',
  `shortname` varchar(3) CHARACTER SET latin1 NOT NULL COMMENT 'the short name for the state',
  `longname` varchar(30) CHARACTER SET latin1 NOT NULL COMMENT 'the long name for the state',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='store details of australian states';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `film_weekly_archaeologies`
--

DROP TABLE IF EXISTS `film_weekly_archaeologies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_archaeologies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `film_weekly_cinemas_id` int(11) NOT NULL COMMENT 'the unique identifier of a film weekly cinema id',
  `film_weekly_categories_id` int(11) NOT NULL COMMENT 'the unique identifier for a film weekly category',
  `cinema_name` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the name of the cinema',
  `exhibitor_name` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the name of the exhibitor',
  `capacity` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'the capacity of the theatre',
  PRIMARY KEY (`id`),
  KEY `film_weekly_cinemas_id` (`film_weekly_cinemas_id`),
  KEY `film_weekly_categories_id` (`film_weekly_categories_id`),
  CONSTRAINT `fk_film_weekly_categories` FOREIGN KEY (`film_weekly_categories_id`) REFERENCES `film_weekly_categories` (`id`),
  CONSTRAINT `fk_film_weekly_cinemas_id` FOREIGN KEY (`film_weekly_cinemas_id`) REFERENCES `film_weekly_cinemas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7796 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`marques`@`%`*/ /*!50003 TRIGGER `insert_fwa_search` AFTER INSERT ON `film_weekly_archaeologies` FOR EACH ROW IF NEW.cinema_name IS NOT NULL OR NEW.exhibitor_name IS NOT NULL THEN

INSERT INTO film_weekly_searches (film_weekly_archaeologies_id, fwa_cinema_name, fwa_exhibitor_name) 
VALUES (NEW.id, NEW.cinema_name, NEW.exhibitor_name);

END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`marques`@`%`*/ /*!50003 TRIGGER `update_fwa_search` AFTER UPDATE ON `film_weekly_archaeologies` FOR EACH ROW IF NEW.cinema_name IS NOT NULL OR NEW.exhibitor_name IS NOT NULL THEN

UPDATE film_weekly_searches
SET fwa_cinema_name = NEW.cinema_name, fwa_exhibitor_name = NEW.exhibitor_name
WHERE film_weekly_archaeologies_id = OLD.id;

END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`marques`@`%`*/ /*!50003 TRIGGER `delete_fwa_search` AFTER DELETE ON `film_weekly_archaeologies` FOR EACH ROW IF OLD.cinema_name IS NOT NULL OR OLD.exhibitor_name IS NOT NULL THEN

DELETE FROM film_weekly_searches
WHERE film_weekly_archaeologies_id = OLD.id;

END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `film_weekly_categories`
--

DROP TABLE IF EXISTS `film_weekly_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_categories` (
  `id` int(11) NOT NULL COMMENT 'the unique identifier for the film weekly category',
  `description` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT 'the description of this category',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='store details of the film weekly categories';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `film_weekly_category_maps`
--

DROP TABLE IF EXISTS `film_weekly_category_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_category_maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for the category map',
  `film_weekly_cinemas_id` int(11) NOT NULL COMMENT 'unique identifier of a film weekly cinema',
  `film_weekly_categories_id` int(11) NOT NULL COMMENT 'unique identifier of a film weekly category',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_maps` (`film_weekly_cinemas_id`,`film_weekly_categories_id`),
  KEY `idx_film_weekly_cinemas_id` (`film_weekly_cinemas_id`),
  KEY `idx_film_weekly_categories_id` (`film_weekly_categories_id`),
  CONSTRAINT `fk_film_weekly_categories_id_map` FOREIGN KEY (`film_weekly_categories_id`) REFERENCES `film_weekly_categories` (`id`),
  CONSTRAINT `fk_film_weekly_cinemas_id_map` FOREIGN KEY (`film_weekly_cinemas_id`) REFERENCES `film_weekly_cinemas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33327 DEFAULT CHARSET=utf8 COMMENT='store details of the relationship between film weekly cinema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `film_weekly_cinema_types`
--

DROP TABLE IF EXISTS `film_weekly_cinema_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_cinema_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'the unique identifier for this cinema type',
  `description` varchar(256) CHARACTER SET latin1 NOT NULL COMMENT 'the description of this cinema type',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='store details of the cinema types in the film weekly databas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `film_weekly_cinemas`
--

DROP TABLE IF EXISTS `film_weekly_cinemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_cinemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for each film weekly cinema',
  `latitude` double NOT NULL COMMENT 'the latitude geographic coordinate in decimal degrees',
  `longitude` double NOT NULL COMMENT 'the longitude geographic coordinate in decimal degrees',
  `australian_states_id` int(11) NOT NULL COMMENT 'the id of an australian_states record',
  `locality_types_id` int(11) NOT NULL COMMENT 'the id of a locality_types record',
  `film_weekly_cinema_types_id` int(11) NOT NULL COMMENT 'the id of a film_weekly_cinema_types record',
  `street` varchar(512) DEFAULT NULL COMMENT 'the street address for the cinema',
  `suburb` varchar(512) NOT NULL COMMENT 'suburb or town name',
  `postcode` varchar(4) NOT NULL COMMENT 'the australian post code for the suburb',
  `cinema_name` varchar(512) NOT NULL COMMENT 'the name of the theatre / cinema',
  `exhibitor_name` varchar(512) DEFAULT NULL COMMENT 'the name of the exhibitor',
  `capacity` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'the capacity of the cinema / theatre',
  PRIMARY KEY (`id`),
  KEY `idx_australian_states_id` (`australian_states_id`) USING BTREE,
  KEY `idx_locality_type_id` (`locality_types_id`) USING BTREE,
  KEY `idx_film_weekly_cinema_type_id` (`film_weekly_cinema_types_id`) USING BTREE,
  CONSTRAINT `fk_australian_states` FOREIGN KEY (`australian_states_id`) REFERENCES `australian_states` (`id`),
  CONSTRAINT `fk_film_weekly_cinema_types` FOREIGN KEY (`film_weekly_cinema_types_id`) REFERENCES `film_weekly_cinema_types` (`id`),
  CONSTRAINT `fk_locality_types` FOREIGN KEY (`locality_types_id`) REFERENCES `locality_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3230 DEFAULT CHARSET=utf8 COMMENT='store details of cinemas referenced in the film weekly datas';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`marques`@`%`*/ /*!50003 TRIGGER `insert_fwc_search` AFTER INSERT ON `film_weekly_cinemas` FOR EACH ROW INSERT INTO film_weekly_searches (film_weekly_cinemas_id, fwc_street, fwc_suburb, fwc_cinema_name, fwc_exhibitor_name) 
VALUES (NEW.id, NEW.street, NEW.suburb, NEW.cinema_name, NEW.exhibitor_name) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`marques`@`%`*/ /*!50003 TRIGGER `update_fwc_search` AFTER UPDATE ON `film_weekly_cinemas` FOR EACH ROW UPDATE film_weekly_searches
SET fwc_street = NEW.street, fwc_suburb = NEW.suburb, fwc_cinema_name = NEW.cinema_name, fwc_exhibitor_name = NEW.exhibitor_name
WHERE film_weekly_cinemas_id = OLD.id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`marques`@`%`*/ /*!50003 TRIGGER `delete_fwc_search` AFTER DELETE ON `film_weekly_cinemas` FOR EACH ROW DELETE FROM film_weekly_searches
WHERE film_weekly_cinemas_id = OLD.id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `film_weekly_markers`
--

DROP TABLE IF EXISTS `film_weekly_markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_markers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for each record',
  `film_weekly_cinema_types_id` int(11) NOT NULL COMMENT 'the unique identifier for a film weekly cinema type record',
  `locality_types_id` int(11) NOT NULL COMMENT 'the unique identifier for a locality type record',
  `marker_url` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'the complete URL for a marker image',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fw_cinema_type_and_locality` (`film_weekly_cinema_types_id`,`locality_types_id`),
  KEY `fw_cinema_type` (`film_weekly_cinema_types_id`),
  KEY `locality_type` (`locality_types_id`),
  CONSTRAINT `fw_cinema_type_marker` FOREIGN KEY (`film_weekly_cinema_types_id`) REFERENCES `film_weekly_cinema_types` (`id`),
  CONSTRAINT `locality_type_marker` FOREIGN KEY (`locality_types_id`) REFERENCES `locality_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='store details of film weekly markers';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `film_weekly_resource_maps`
--

DROP TABLE IF EXISTS `film_weekly_resource_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_resource_maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'a unique identifier for the record',
  `film_weekly_cinemas_id` int(11) NOT NULL COMMENT 'the unique identifier for a film weekly cinema',
  `resources_id` int(11) NOT NULL COMMENT 'the unique identifier for the resource',
  PRIMARY KEY (`id`),
  KEY `film_weekly_cinemas_id` (`film_weekly_cinemas_id`),
  KEY `resources_id` (`resources_id`),
  CONSTRAINT `film_weekly_cinemas` FOREIGN KEY (`film_weekly_cinemas_id`) REFERENCES `film_weekly_cinemas` (`id`),
  CONSTRAINT `resources` FOREIGN KEY (`resources_id`) REFERENCES `resources` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `film_weekly_searches`
--

DROP TABLE IF EXISTS `film_weekly_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film_weekly_searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for the row',
  `film_weekly_cinemas_id` int(11) NOT NULL COMMENT 'unique identifier for the film_weekly_cinemas record',
  `film_weekly_archaeologies_id` int(11) NOT NULL COMMENT 'unique id from the film_weekly_archaeologies table',
  `fwc_street` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the corresponding field from the film_weekly_cinemas table',
  `fwc_suburb` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the corresponding field from the film_weekly_cinemas table',
  `fwc_cinema_name` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the corresponding field from the film_weekly_cinemas table',
  `fwc_exhibitor_name` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the corresponding field from the film_weekly_cinemas table',
  `fwa_cinema_name` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the corresponding field from the film_weekly_archaeologies table',
  `fwa_exhibitor_name` varchar(512) CHARACTER SET latin1 DEFAULT NULL COMMENT 'the corresponding field from the film_weekly_archaeologies table',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `film_weekly_full_text_search_1` (`fwc_street`,`fwc_suburb`,`fwc_cinema_name`,`fwc_exhibitor_name`),
  FULLTEXT KEY `film_weekly_full_text_search_2` (`fwa_cinema_name`,`fwa_exhibitor_name`)
) ENGINE=MyISAM AUTO_INCREMENT=7236 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locality_types`
--

DROP TABLE IF EXISTS `locality_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locality_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for the locality type',
  `description` varchar(50) NOT NULL COMMENT 'description of the locality',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='store details of the different types of localities';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'the unique identifier for the record',
  `title` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'the title of the resource',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'a short description of the resource',
  `url` varchar(256) COLLATE utf8_bin NOT NULL COMMENT 'the url for the resource',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='a simple table to store details of remote resources';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique primary id for the user',
  `username` varchar(25) NOT NULL COMMENT 'username for the user',
  `password` varchar(255) NOT NULL COMMENT 'password for the user',
  `firstname` varchar(50) NOT NULL COMMENT 'first name of the user',
  `lastname` varchar(50) NOT NULL COMMENT 'last name of the user',
  `email` varchar(512) NOT NULL COMMENT 'email address of the user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='store details of users';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-12-12 14:41:32
