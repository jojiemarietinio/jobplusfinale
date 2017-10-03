-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: jobplusfinale
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `app_calendars`
--

DROP TABLE IF EXISTS `app_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_calendars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_calendars`
--

LOCK TABLES `app_calendars` WRITE;
/*!40000 ALTER TABLE `app_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_notifications`
--

DROP TABLE IF EXISTS `app_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_notifications`
--

LOCK TABLES `app_notifications` WRITE;
/*!40000 ALTER TABLE `app_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant` int(11) NOT NULL,
  `job` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `is_accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (6,1,15,'2017-02-27 22:47:59',1),(7,1,15,'2017-02-27 23:01:16',1),(8,1,15,'2017-02-28 01:23:02',1),(9,1,15,'2017-02-28 07:04:29',1),(10,1,15,'2017-02-28 06:11:26',1),(11,1,15,'2017-02-28 06:15:17',1),(12,1,15,'2017-02-28 07:21:28',1),(13,1,16,'2017-02-28 11:30:18',1);
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attainment`
--

DROP TABLE IF EXISTS `attainment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attainment` (
  `attainment_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`attainment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attainment`
--

LOCK TABLES `attainment` WRITE;
/*!40000 ALTER TABLE `attainment` DISABLE KEYS */;
INSERT INTO `attainment` VALUES (1,'Highschool'),(2,'College');
/*!40000 ALTER TABLE `attainment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Household'),(2,'Construction'),(3,'Personel'),(4,'Maintenance');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `degrees`
--

DROP TABLE IF EXISTS `degrees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `degrees` (
  `degree_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`degree_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `degrees`
--

LOCK TABLES `degrees` WRITE;
/*!40000 ALTER TABLE `degrees` DISABLE KEYS */;
INSERT INTO `degrees` VALUES (1,'Bachelor of Applied Science'),(2,'Bachelor of Architecture'),(3,'Bachelor of Arts'),(4,'Bachelor of Business Administration'),(5,'Bachelor of Commerce'),(6,'Bachelor of Science');
/*!40000 ALTER TABLE `degrees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edu_field`
--

DROP TABLE IF EXISTS `edu_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edu_field` (
  `edu_field_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`edu_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edu_field`
--

LOCK TABLES `edu_field` WRITE;
/*!40000 ALTER TABLE `edu_field` DISABLE KEYS */;
INSERT INTO `edu_field` VALUES (1,6,'Information Technology'),(2,6,'Computer Science');
/*!40000 ALTER TABLE `edu_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education` (
  `education_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attainment` int(1) NOT NULL,
  `school` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start` int(4) NOT NULL,
  `end` int(4) NOT NULL,
  `degree_id` int(11) DEFAULT NULL,
  `field_study` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`education_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (24,2,'University of San Jose-Recoletos',2013,2017,6,'1'),(26,2,'University of San Jose-Recoletos',2013,2016,6,'1'),(28,2,'University of San Carlos',2016,2025,6,'1'),(30,2,'University of San Carlos',2016,2025,6,'1'),(31,2,'University of San Carlos',2016,2025,6,'2'),(33,2,'University of San Carlos',2016,2025,6,'2'),(34,2,'San',2016,2025,6,'1'),(35,2,'San',2016,2024,6,'1'),(36,2,'San',2016,2024,6,'2'),(37,2,'San',2016,2024,0,NULL),(41,2,'hehe',2016,2025,6,'1'),(43,2,'hehe',2016,2025,6,'2'),(44,2,'awww',2016,2025,6,'2'),(46,2,'awwws',2016,2025,6,'1'),(47,2,'asdasd',2016,2025,6,'1'),(48,2,'asdasd',2016,2025,6,'1'),(51,2,'USC',2016,2025,6,'1'),(52,1,'UC',2016,2025,NULL,NULL);
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emp_calendars`
--

DROP TABLE IF EXISTS `emp_calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emp_calendars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emp_calendars`
--

LOCK TABLES `emp_calendars` WRITE;
/*!40000 ALTER TABLE `emp_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `emp_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emp_notifications`
--

DROP TABLE IF EXISTS `emp_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emp_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emp_notifications`
--

LOCK TABLES `emp_notifications` WRITE;
/*!40000 ALTER TABLE `emp_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `emp_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiences` (
  `experience_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `employer` varchar(255) CHARACTER SET utf8 NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`experience_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiences`
--

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (7,'Dish','Creative',2016),(8,'Dish','Creative',2016),(9,'asdasd','asdasdasd',2016),(12,'','',0),(13,'','',0),(14,'Programmer','Glocorp',2013),(15,'','',0),(16,'Tambay','Sa puso Mo',2014),(17,'Works at Krusty Krab','Mr. Crab',2015);
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_address`
--

DROP TABLE IF EXISTS `job_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `locality` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_address`
--

LOCK TABLES `job_address` WRITE;
/*!40000 ALTER TABLE `job_address` DISABLE KEYS */;
INSERT INTO `job_address` VALUES (14,10.31,123.892,'Cebu City'),(15,10.313,123.879,'Cebu City');
/*!40000 ALTER TABLE `job_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_skills`
--

DROP TABLE IF EXISTS `job_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_skills` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `skill_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_skills`
--

LOCK TABLES `job_skills` WRITE;
/*!40000 ALTER TABLE `job_skills` DISABLE KEYS */;
INSERT INTO `job_skills` VALUES (13,15,17),(14,16,17);
/*!40000 ALTER TABLE `job_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_type`
--

DROP TABLE IF EXISTS `job_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_type` (
  `jobtype_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`jobtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_type`
--

LOCK TABLES `job_type` WRITE;
/*!40000 ALTER TABLE `job_type` DISABLE KEYS */;
INSERT INTO `job_type` VALUES (1,'One time'),(2,'Daily'),(3,'Weekly');
/*!40000 ALTER TABLE `job_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `job_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `address_id` int(11) NOT NULL,
  `job_type_id` int(11) NOT NULL,
  `title` varchar(225) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `paytype` int(11) NOT NULL,
  `salary` double(8,2) NOT NULL,
  `is_all_day` tinyint(1) NOT NULL,
  `slot` int(11) NOT NULL,
  `date_posted` date NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (16,2,'3',15,1,'Looking for a driver','Must be 20 years old and above.\nwith drivers license and with pleasing personality.','2017-02-28 11:30:00','2017-02-28 13:30:31',1,500.00,1,0,'2017-02-28');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_09_12_031805_create_jobs_table',1),('2016_09_12_035543_create_categories_table',1),('2016_09_12_041852_create_works_table',1),('2016_09_13_095422_create_skills_table',1),('2016_09_13_095439_create_schedules_table',1),('2016_09_13_095517_create_paytypes_table',1),('2016_09_13_095558_create_experiences_table',1),('2016_09_13_095638_create_degrees_table',1),('2016_09_13_095652_create_education_table',1),('2016_09_13_095734_create_profiles_table',1),('2016_09_13_095755_create_reviews_table',1),('2016_09_13_100131_create_emp__notifications_table',1),('2016_09_13_100145_create_app__notifications_table',1),('2016_09_14_090116_create_prof_educations_table',1),('2016_09_14_125745_create_prof_experiences_table',1),('2016_09_14_125756_create_prof_skills_table',1),('2016_09_16_083427_create_app__calendars_table',1),('2016_09_16_083428_create_emp__calendars_table',1),('2016_10_02_222038_create_statuses_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paytypes`
--

DROP TABLE IF EXISTS `paytypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paytypes` (
  `paytype_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`paytype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paytypes`
--

LOCK TABLES `paytypes` WRITE;
/*!40000 ALTER TABLE `paytypes` DISABLE KEYS */;
INSERT INTO `paytypes` VALUES (1,'Hour'),(2,'Session'),(3,'Project');
/*!40000 ALTER TABLE `paytypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prof_educations`
--

DROP TABLE IF EXISTS `prof_educations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prof_educations` (
  `profedu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(10) NOT NULL,
  `education_id` int(11) NOT NULL,
  PRIMARY KEY (`profedu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prof_educations`
--

LOCK TABLES `prof_educations` WRITE;
/*!40000 ALTER TABLE `prof_educations` DISABLE KEYS */;
INSERT INTO `prof_educations` VALUES (25,1,51),(26,1,52);
/*!40000 ALTER TABLE `prof_educations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prof_experiences`
--

DROP TABLE IF EXISTS `prof_experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prof_experiences` (
  `profexp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `experience_id` int(11) NOT NULL,
  PRIMARY KEY (`profexp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prof_experiences`
--

LOCK TABLES `prof_experiences` WRITE;
/*!40000 ALTER TABLE `prof_experiences` DISABLE KEYS */;
INSERT INTO `prof_experiences` VALUES (1,1,16),(2,1,17);
/*!40000 ALTER TABLE `prof_experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prof_mobile`
--

DROP TABLE IF EXISTS `prof_mobile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prof_mobile` (
  `promob_id` int(10) NOT NULL,
  `code` varchar(45) NOT NULL,
  `is_verified` varchar(45) NOT NULL,
  `profile_id` int(10) NOT NULL,
  PRIMARY KEY (`promob_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prof_mobile`
--

LOCK TABLES `prof_mobile` WRITE;
/*!40000 ALTER TABLE `prof_mobile` DISABLE KEYS */;
INSERT INTO `prof_mobile` VALUES (0,'f1d2','1',1);
/*!40000 ALTER TABLE `prof_mobile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prof_skills`
--

DROP TABLE IF EXISTS `prof_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prof_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prof_skills`
--

LOCK TABLES `prof_skills` WRITE;
/*!40000 ALTER TABLE `prof_skills` DISABLE KEYS */;
INSERT INTO `prof_skills` VALUES (222,1,1),(223,1,2),(224,1,3),(225,1,13),(226,1,19),(227,1,20),(228,1,21),(232,84,1),(233,84,2),(234,84,3),(235,84,6),(236,84,7),(237,84,8),(238,84,9),(239,84,10),(240,84,11);
/*!40000 ALTER TABLE `prof_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `profile_id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `biography` longtext COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,1,'Baguion','Kent Michael','','Banawa Elementary School, Cebu City, Central Visayas, Philippines','A good review','/avatar/mw.jpg'),(84,2,'Baguion','Kim Vincent','09329520016','Banawa Elementary School, Cebu City, Central Visayas, Philippines','this is a good description about myself.','/avatar/kim.jpg'),(85,3,'Wenceslao','Marvin','','Banawa Elementary School, Cebu City, Central Visayas, Philippines','this is a good description about myself.','/avatar/mw.jpg');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `review_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `reviewed_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (42,'Thank you for the service. 5/5 for you buddy.',5,2,1,13),(43,'Thanks for your service sir! 5/5',5,1,2,13);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `schedule_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (11,15,'2017-02-28 06:00:00','2017-02-28 07:00:00'),(12,16,'2017-02-28 11:30:00','2017-02-28 13:30:31');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `skill_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'Dishwasher',1),(2,'Housekeeper',1),(3,'Child Care Worker',1),(4,'Laundry and Dry Cleaning',1),(5,'Carpenter',2),(6,'Painter',2),(7,'Masonry',2),(8,'Cutter',2),(9,'Tile and Marble Setter',2),(10,'Molding and Casting',2),(11,'Upholsterer',2),(12,'Sales Clerk',3),(13,'Promo Dicer',3),(14,'Waiter/Waitress',3),(16,'Retailer',3),(17,'Driver',3),(18,'Cook',3),(19,'Plumber',4),(20,'Automotive Technician',4),(21,'Appliance Technician',4),(22,'Electrician',4);
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Active'),(2,'Upcoming'),(3,'Ongoing'),(4,'Ended');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_review`
--

DROP TABLE IF EXISTS `user_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `number_votes` int(11) NOT NULL,
  `total_points` int(11) NOT NULL,
  `average` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_review`
--

LOCK TABLES `user_review` WRITE;
/*!40000 ALTER TABLE `user_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'applicant','moch@gmail.com','$2y$10$u7hcDAzeFgPFbYXWNxVdweyGU9XtLWeqHxdScyuW.aZsTaz4d27uu','qOMUnXiwK3KJsMycqAg2e3386IDXCQcuNTEPxpR6BlLsjsNE0Qv7c7Nfeasb'),(2,'employer','itnel13@gmail.com','$2y$10$E2PIeMbL68qZwELK3USQgO275CPJNjwJfAvoPHUVrLSa1kAryyws6','QPLGSGYFaVCGd0Kb01QOstx83yiTO7qAfSTJqPlalF1qdKURTldaGFzMtndC'),(3,'dummy1','dummy1@gmail.com','password',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_reviewed`
--

DROP TABLE IF EXISTS `work_reviewed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_reviewed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `applicant_reviewed` tinyint(1) NOT NULL,
  `employer_reviewed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_reviewed`
--

LOCK TABLES `work_reviewed` WRITE;
/*!40000 ALTER TABLE `work_reviewed` DISABLE KEYS */;
INSERT INTO `work_reviewed` VALUES (8,13,1,1);
/*!40000 ALTER TABLE `work_reviewed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_summary`
--

DROP TABLE IF EXISTS `work_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_summary` (
  `summary_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `total_salary` float NOT NULL,
  `fines` float NOT NULL,
  `hours_rendered` int(11) NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  PRIMARY KEY (`summary_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_summary`
--

LOCK TABLES `work_summary` WRITE;
/*!40000 ALTER TABLE `work_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works` (
  `work_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sched_id` int(10) NOT NULL,
  `applicant_id` int(10) NOT NULL,
  `employer_id` int(10) NOT NULL,
  `status` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `is_started` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`work_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES (13,12,1,2,4,'2017-02-28 11:31:15','2017-02-28 13:32:52',0,'2017-02-28 11:30:25');
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-28 11:37:18
