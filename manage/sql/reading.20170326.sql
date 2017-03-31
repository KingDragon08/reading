-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: reading
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Table structure for table `rd_admin`
--

DROP TABLE IF EXISTS `rd_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_admin` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_desc` varchar(255) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `login_ip` varchar(32) DEFAULT NULL,
  `user_group` int(11) NOT NULL,
  `template` varchar(32) NOT NULL DEFAULT 'default' COMMENT '主题模板',
  `shortcuts` text COMMENT '快捷菜单',
  `show_quicknote` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示quicknote',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='后台用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_admin`
--

LOCK TABLES `rd_admin` WRITE;
/*!40000 ALTER TABLE `rd_admin` DISABLE KEYS */;
INSERT INTO `rd_admin` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','SomewhereYu','13800138001','admin@osadmin.org','初始的超级管理员!',1490533552,1,'127.0.0.1',1,'default','2,7,10,11,13,18,21,24,101',0),(26,'demo','e10adc3949ba59abbe56e057f20f883e','SomewhereYu','15812345678','yuwenqi@osadmin.org','默认用户组成员',1371605873,1,'127.0.0.1',2,'schoolpainting','',1);
/*!40000 ALTER TABLE `rd_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_admin_group`
--

DROP TABLE IF EXISTS `rd_admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_admin_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初始权限为1,5,17,18,22,23,24,25',
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='账号组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_admin_group`
--

LOCK TABLES `rd_admin_group` WRITE;
/*!40000 ALTER TABLE `rd_admin_group` DISABLE KEYS */;
INSERT INTO `rd_admin_group` VALUES (1,'超级管理员组','1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117',1,'万能的不是神，是程序员'),(2,'默认账号组','1,5,17,18,20,22,23,24,25,101',1,'默认账号组');
/*!40000 ALTER TABLE `rd_admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book`
--

DROP TABLE IF EXISTS `rd_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `author` varchar(32) DEFAULT NULL,
  `press` varchar(32) DEFAULT NULL,
  `presstime` varchar(32) DEFAULT NULL,
  `bookdesc` text,
  `coverimg` varchar(255) DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  `score` int(10) unsigned DEFAULT '0',
  `addtime` varchar(32) DEFAULT NULL,
  `grade` int(32) NOT NULL,
  `level` int(10) NOT NULL DEFAULT '0',
  `wordcount` int(32) NOT NULL DEFAULT '0',
  `recommend_times` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book`
--

LOCK TABLES `rd_book` WRITE;
/*!40000 ALTER TABLE `rd_book` DISABLE KEYS */;
INSERT INTO `rd_book` VALUES (1,'红楼梦1','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',1,10,'1487223415',1,1,0,0),(2,'红楼梦2','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',2,10,'1487223415',2,2,0,0),(3,'红楼梦3','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',3,10,'1487223415',3,3,0,1),(4,'红楼梦4','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',4,10,'1487223415',4,4,0,0),(5,'红楼梦5','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',1,10,'1487223415',5,5,0,0),(6,'红楼梦6','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',1,10,'1487223415',6,6,0,0),(7,'红楼梦7','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',1,10,'1487223415',7,7,0,0),(8,'红楼梦8','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',5,10,'1487223415',8,8,0,2),(9,'红楼梦9','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',1,10,'1487223415',9,9,0,2),(10,'红楼梦10','曹雪芹','首都师范大学出版社','1487222415','《红楼梦》开篇以神话形式介绍作品的由来，说女娲炼三万六千五百零一块石补天，只用了三万六千五百块，剩余一块未用，弃在青埂峰下。剩一石自怨自愧，日夜悲哀。一僧一道见它形体可爱，便给它镌上数字，携带下凡。不知过了几世几劫，空空道人路过，见石上刻录了一段故事，便受石之托，抄写下来传世。辗转传到曹雪芹手中，经他批阅十载、增删五次而成书','/reading/img/book1.png',1,10,'1487223415',10,10,0,3);
/*!40000 ALTER TABLE `rd_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book_grade`
--

DROP TABLE IF EXISTS `rd_book_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book_grade` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book_grade`
--

LOCK TABLES `rd_book_grade` WRITE;
/*!40000 ALTER TABLE `rd_book_grade` DISABLE KEYS */;
/*!40000 ALTER TABLE `rd_book_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book_list`
--

DROP TABLE IF EXISTS `rd_book_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book_list` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(32) DEFAULT NULL,
  `list_id` int(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book_list`
--

LOCK TABLES `rd_book_list` WRITE;
/*!40000 ALTER TABLE `rd_book_list` DISABLE KEYS */;
INSERT INTO `rd_book_list` VALUES (1,1,1),(2,2,1),(3,3,1),(4,10,2),(5,8,2),(6,6,2),(7,10,3),(8,8,3),(9,6,3),(10,10,4),(11,8,4),(12,6,4),(13,10,5),(14,8,5),(15,6,5),(16,10,6),(17,9,6),(18,8,6),(19,7,6),(20,10,7),(21,10,8),(22,9,8),(23,8,8),(24,1,8),(25,10,9),(26,9,9),(27,3,10),(28,3,11),(29,8,11),(30,10,12),(31,9,12),(32,10,13),(33,9,13),(34,8,13),(35,10,14);
/*!40000 ALTER TABLE `rd_book_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book_question_obj`
--

DROP TABLE IF EXISTS `rd_book_question_obj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book_question_obj` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(32) DEFAULT NULL,
  `question` varchar(1000) DEFAULT NULL,
  `choice1` varchar(1000) DEFAULT NULL,
  `choice2` varchar(1000) DEFAULT NULL,
  `choice3` varchar(1000) DEFAULT NULL,
  `choice4` varchar(1000) DEFAULT NULL,
  `answer` tinyint(2) DEFAULT NULL,
  `score` int(2) DEFAULT NULL,
  `view` varchar(32) DEFAULT NULL,
  `addtime` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book_question_obj`
--

LOCK TABLES `rd_book_question_obj` WRITE;
/*!40000 ALTER TABLE `rd_book_question_obj` DISABLE KEYS */;
INSERT INTO `rd_book_question_obj` VALUES (1,1,'Question1','A:1','B:2','C:3','D:4',1,1,'1','0'),(2,1,'Question2','A:2','B:2','C:3','D:4',1,1,'2','0'),(3,1,'Question3','A:3','B:2','C:3','D:4',1,1,'3','0'),(4,1,'Question4','A:4','B:2','C:3','D:4',1,1,'4','0'),(5,1,'Question5','A:5','B:2','C:3','D:4',1,1,'5','0'),(6,1,'Question6','A:6','B:2','C:3','D:4',1,1,'1','0'),(7,1,'Question7','A:7','B:2','C:3','D:4',1,1,'2','0'),(8,1,'Question8','A:8','B:2','C:3','D:4',1,1,'3','0'),(9,1,'Question9','A:9','B:2','C:3','D:4',1,1,'4','0'),(10,1,'Question10','A:10','B:2','C:3','D:4',1,1,'5','0'),(11,1,'Question11','A:11','B:2','C:3','D:4',1,1,'1','0'),(12,1,'Question12','A:12','B:2','C:3','D:4',1,1,'2','0'),(13,1,'Question13','A:13','B:2','C:3','D:4',1,1,'3','0'),(14,1,'Question14','A:14','B:2','C:3','D:4',1,1,'4','0'),(15,1,'Question15','A:15','B:2','C:3','D:4',1,1,'5','0'),(16,1,'Question16','A:16','B:2','C:3','D:4',1,1,'1','0'),(17,1,'Question17','A:17','B:2','C:3','D:4',1,1,'2','0'),(18,1,'Question18','A:18','B:2','C:3','D:4',1,1,'3','0'),(19,1,'Question19','A:19','B:2','C:3','D:4',1,1,'4','0'),(20,1,'Question20','A:20','B:2','C:3','D:4',1,1,'5','0'),(21,1,'Question21','A:21','B:2','C:3','D:4',1,1,'1','0'),(22,1,'Question22','A:22','B:2','C:3','D:4',1,1,'2','0'),(23,1,'Question23','A:23','B:2','C:3','D:4',1,1,'3','0'),(24,1,'Question24','A:24','B:2','C:3','D:4',1,1,'4','0'),(25,1,'Question25','A:25','B:2','C:3','D:4',1,1,'5','0'),(26,1,'Question26','A:26','B:2','C:3','D:4',1,1,'1','0'),(27,1,'Question27','A:27','B:2','C:3','D:4',1,1,'2','0'),(28,1,'Question28','A:28','B:2','C:3','D:4',1,1,'3','0'),(29,1,'Question29','A:29','B:2','C:3','D:4',1,1,'4','0'),(30,1,'Question30','A:30','B:2','C:3','D:4',1,1,'5','0'),(31,8,'1','1','2','3','4',1,1,'1','0'),(32,8,'2','1','2','3','4',1,1,'2','0'),(33,8,'3','1','2','3','4',1,1,'3','0'),(34,8,'4','1','2','3','4',1,1,'4','0'),(35,8,'5','1','2','3','4',1,1,'5','0'),(36,8,'6','1','2','3','4',1,1,'1','0'),(37,8,'7','1','2','3','4',1,1,'2','0'),(38,8,'8','1','2','3','4',1,1,'3','0'),(39,8,'9','1','2','3','4',1,1,'4','0'),(40,8,'10','1','2','3','4',1,1,'5','0'),(41,8,'11','1','2','3','4',1,1,'1','0'),(42,8,'12','1','2','3','4',1,1,'2','0'),(43,8,'13','1','2','3','4',1,1,'3','0'),(44,8,'14','1','2','3','4',1,1,'4','0'),(45,8,'15','1','2','3','4',1,1,'5','0'),(46,8,'16','1','2','3','4',1,1,'1','0'),(47,8,'17','1','2','3','4',1,1,'2','0'),(48,8,'18','1','2','3','4',1,1,'3','0'),(49,8,'19','1','2','3','4',1,1,'4','0'),(50,8,'20','1','2','3','4',1,1,'5','0'),(51,8,'21','1','2','3','4',1,1,'1','0'),(52,8,'22','1','2','3','4',1,1,'2','0'),(53,8,'23','1','2','3','4',1,1,'3','0'),(54,8,'24','1','2','3','4',1,1,'4','0'),(55,8,'25','1','2','3','4',1,1,'5','0'),(56,8,'26','1','2','3','4',1,1,'1','0'),(57,8,'27','1','2','3','4',1,1,'2','0'),(58,8,'28','1','2','3','4',1,1,'3','0'),(59,8,'29','1','2','3','4',1,1,'4','0'),(60,8,'30','1','2','3','4',1,1,'5','0'),(61,8,'31','1','2','3','4',1,1,'1','0'),(62,8,'32','1','2','3','4',1,1,'2','0'),(63,8,'33','1','2','3','4',1,1,'3','0'),(64,8,'34','1','2','3','4',1,1,'4','0'),(65,8,'35','1','2','3','4',1,1,'5','0'),(66,8,'36','1','2','3','4',1,1,'1','0'),(67,8,'37','1','2','3','4',1,1,'2','0'),(68,8,'38','1','2','3','4',1,1,'3','0'),(69,8,'39','1','2','3','4',1,1,'4','0'),(70,8,'40','1','2','3','4',1,1,'5','0'),(71,8,'41','1','2','3','4',1,1,'1','0'),(72,8,'42','1','2','3','4',1,1,'2','0'),(73,8,'43','1','2','3','4',1,1,'3','0'),(74,8,'44','1','2','3','4',1,1,'4','0'),(75,8,'45','1','2','3','4',1,1,'5','0');
/*!40000 ALTER TABLE `rd_book_question_obj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book_question_sub`
--

DROP TABLE IF EXISTS `rd_book_question_sub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book_question_sub` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(32) DEFAULT NULL,
  `question` varchar(32) DEFAULT NULL,
  `addtime` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book_question_sub`
--

LOCK TABLES `rd_book_question_sub` WRITE;
/*!40000 ALTER TABLE `rd_book_question_sub` DISABLE KEYS */;
/*!40000 ALTER TABLE `rd_book_question_sub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book_review`
--

DROP TABLE IF EXISTS `rd_book_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book_review` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(32) DEFAULT NULL,
  `user_id` int(32) DEFAULT NULL,
  `content` text,
  `addtime` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book_review`
--

LOCK TABLES `rd_book_review` WRITE;
/*!40000 ALTER TABLE `rd_book_review` DISABLE KEYS */;
INSERT INTO `rd_book_review` VALUES (1,2,1,'我是红楼梦2的第一条书评我是红楼梦2的第一条书评我是红楼梦2的第一条书评我是红楼梦2的第一条书评','1487317369'),(2,2,1,'我是红楼梦2的第2条书评我是红楼梦2的第2条书评我是红楼梦2的第2条书评我是红楼梦2的第2条书评','1487317573'),(3,2,1,'我是红楼梦2的第3条书评我是红楼梦2的第3条书评我是红楼梦2的第3条书评我是红楼梦2的第3条书评','1487317578'),(4,2,1,'我是红楼梦2的第4条书评我是红楼梦2的第4条书评我是红楼梦2的第4条书评我是红楼梦2的第4条书评','1487317583'),(5,2,1,'我是红楼梦2的第5条书评我是红楼梦2的第5条书评我是红楼梦2的第5条书评我是红楼梦2的第5条书评','1487317587'),(6,2,1,'我是红楼梦2的第6条书评我是红楼梦2的第6条书评我是红楼梦2的第6条书评我是红楼梦2的第6条书评我是红楼梦2的第6条书评','1487317594'),(7,2,1,'我是红楼梦2的第7条书评我是红楼梦2的第7条书评我是红楼梦2的第7条书评我是红楼梦2的第7条书评','1487317599'),(8,2,1,'我是红楼梦2的第8条书评我是红楼梦2的第8条书评我是红楼梦2的第8条书评我是红楼梦2的第8条书评','1487317605'),(9,2,1,'我是红楼梦2的第9条书评我是红楼梦2的第9条书评我是红楼梦2的第9条书评','1487317610'),(10,2,1,'我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评我是红楼梦2的第10条书评','1487317615'),(11,2,1,'dtjvbknl','1487318627');
/*!40000 ALTER TABLE `rd_book_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_book_type`
--

DROP TABLE IF EXISTS `rd_book_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_book_type` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_book_type`
--

LOCK TABLES `rd_book_type` WRITE;
/*!40000 ALTER TABLE `rd_book_type` DISABLE KEYS */;
INSERT INTO `rd_book_type` VALUES (1,'测试用书'),(2,'寓言童话'),(3,'中外故事'),(4,'自然科普'),(5,'长篇小说'),(6,'传统文化'),(7,'科学故事'),(8,'成长教育'),(9,'儿童文学'),(10,'世界经典'),(11,'中外历史'),(12,'诗歌散文'),(13,'科学幻想');
/*!40000 ALTER TABLE `rd_book_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_class`
--

DROP TABLE IF EXISTS `rd_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_class` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(32) DEFAULT NULL,
  `school` int(32) NOT NULL DEFAULT '1',
  `teacher_id` int(32) NOT NULL,
  `grade` int(32) NOT NULL DEFAULT '0',
  `addtime` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_class`
--

LOCK TABLES `rd_class` WRITE;
/*!40000 ALTER TABLE `rd_class` DISABLE KEYS */;
INSERT INTO `rd_class` VALUES (1,'4年级1班',1,2,4,'0'),(2,'四年级二班',1,2,4,'0'),(3,'测试创建一',2,2,1,'1490158477'),(4,'测试创建2',2,2,1,'1490158531'),(6,'测试创建四',2,2,1,'1490158720');
/*!40000 ALTER TABLE `rd_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_grade`
--

DROP TABLE IF EXISTS `rd_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_grade` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_grade`
--

LOCK TABLES `rd_grade` WRITE;
/*!40000 ALTER TABLE `rd_grade` DISABLE KEYS */;
INSERT INTO `rd_grade` VALUES (1,'一年级'),(2,'二年级'),(3,'三年级'),(4,'四年级'),(5,'五年级'),(6,'六年级'),(7,'七年级'),(8,'八年级'),(9,'九年级'),(10,'高一'),(11,'高二'),(12,'高三'),(13,'成人');
/*!40000 ALTER TABLE `rd_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_list_type`
--

DROP TABLE IF EXISTS `rd_list_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_list_type` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_list_type`
--

LOCK TABLES `rd_list_type` WRITE;
/*!40000 ALTER TABLE `rd_list_type` DISABLE KEYS */;
INSERT INTO `rd_list_type` VALUES (1,'平台书单'),(2,'测试书单');
/*!40000 ALTER TABLE `rd_list_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_menu_url`
--

DROP TABLE IF EXISTS `rd_menu_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_menu_url` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_show` tinyint(4) NOT NULL COMMENT '是否在sidebar里出现',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '在线状态，还是下线状态，即可用，不可用。',
  `shortcut_allowed` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许快捷访问',
  `menu_desc` varchar(255) DEFAULT NULL,
  `father_menu` int(11) NOT NULL DEFAULT '0' COMMENT '上一级菜单',
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menu_url` (`menu_url`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_menu_url`
--

LOCK TABLES `rd_menu_url` WRITE;
/*!40000 ALTER TABLE `rd_menu_url` DISABLE KEYS */;
INSERT INTO `rd_menu_url` VALUES (1,'首页','/panel/index.php',1,0,1,1,'后台首页',0),(2,'账号列表','/panel/users.php',1,1,1,1,'账号列表',0),(3,'修改账号','/panel/user_modify.php',1,0,1,0,'修改账号',2),(4,'新建账号','/panel/user_add.php',1,0,1,1,'新建账号',2),(5,'个人信息','/panel/profile.php',1,0,1,1,'个人信息',0),(6,'账号组成员','/panel/group.php',1,0,1,0,'显示账号组详情及该组成员',7),(7,'账号组管理','/panel/groups.php',1,1,1,1,'增加管理员',0),(8,'修改账号组','/panel/group_modify.php',1,0,1,0,'修改账号组',7),(9,'新建账号组','/panel/group_add.php',1,0,1,1,'新建账号组',7),(10,'权限管理','/panel/group_role.php',1,1,1,1,'用户权限依赖于账号组的权限',0),(11,'菜单模块','/panel/modules.php',1,1,1,1,'菜单里的模块',0),(12,'编辑菜单模块','/panel/module_modify.php',1,0,1,0,'编辑模块',11),(13,'添加菜单模块','/panel/module_add.php',1,0,1,1,'添加菜单模块',11),(14,'功能列表','/panel/menus.php',1,1,1,1,'菜单功能及可访问的链接',0),(15,'增加功能','/panel/menu_add.php',1,0,1,1,'增加功能',14),(16,'功能修改','/panel/menu_modify.php',1,0,1,0,'修改功能',14),(17,'设置模板','/panel/set.php',1,0,1,1,'设置模板',0),(18,'便签管理','/panel/quicknotes.php',1,1,1,1,'quick note',0),(19,'菜单链接列表','/panel/module.php',1,0,1,0,'显示模块详情及该模块下的菜单',11),(20,'登入','/login.php',1,0,1,1,'登入页面',0),(21,'操作记录','/panel/syslog.php',1,1,1,1,'用户操作的历史行为',0),(22,'系统信息','/panel/system.php',1,1,1,1,'显示系统相关信息',0),(23,'ajax访问修改快捷菜单','/ajax/shortcut.php',1,0,1,0,'ajax请求',0),(24,'添加便签','/panel/quicknote_add.php',1,0,1,1,'添加quicknote的内容',18),(25,'修改便签','/panel/quicknote_modify.php',1,0,1,0,'修改quicknote的内容',18),(26,'系统设置','/panel/setting.php',1,0,1,0,'系统设置',0),(101,'样例','/user/sample.php',2,1,1,1,'',0),(103,'读取XLS文件','/user/read_excel.php',2,1,1,1,'',0),(104,'添加图书','/book/addbook.php',3,1,1,1,'',0),(105,'测试题管理','/book/question.php',3,1,1,1,'管理图书测试题',0),(106,'书单管理','/list/booklist.php',4,1,1,1,'管理书单',0),(107,'学生管理','/user/student.php',2,1,1,1,'学生管理模块',0),(108,'教师管理','/user/teacher.php',2,1,1,1,'教师管理模块',0),(109,'学校管理','/user/school.php',2,1,1,1,'学校管理模块',0),(110,'年级管理','/user/grade.php',2,1,1,1,'年级管理模块',0),(111,'班级管理','/user/banji.php',2,1,1,1,'班级管理模块',0),(112,'添加学校','/user/school_add.php',2,0,1,1,'',109),(113,'修改学校','/user/school_modify.php',2,0,1,1,'修改学校信息',109),(114,'添加年级','/user/grade_add.php',2,0,1,1,'添加年级信息',110),(115,'修改年级','/user/grade_modify.php',2,0,1,1,'修改年级信息',110),(116,'添加班级','/user/banji_add.php',2,0,1,1,'添加班级',111),(117,'修改班级','/user/banji_modify.php',2,0,1,1,'修改班级信息',111);
/*!40000 ALTER TABLE `rd_menu_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_module`
--

DROP TABLE IF EXISTS `rd_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_module` (
  `module_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_url` varchar(128) NOT NULL,
  `module_sort` int(11) unsigned NOT NULL DEFAULT '1',
  `module_desc` varchar(255) DEFAULT NULL,
  `module_icon` varchar(32) DEFAULT 'icon-th' COMMENT '菜单模块图标',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '模块是否在线',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='菜单模块';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_module`
--

LOCK TABLES `rd_module` WRITE;
/*!40000 ALTER TABLE `rd_module` DISABLE KEYS */;
INSERT INTO `rd_module` VALUES (1,'系统管理','/panel/index.php',10,'配置系统相关功能','icon-th',1),(2,'用户管理','/panel/index.php',0,'用户管理模块','icon-user',1),(3,'图书管理','/panel/index.php',1,'图书管理模块','icon-book',1),(4,'书单管理','/panel/index.php',2,'书单管理模块','icon-th-list',1);
/*!40000 ALTER TABLE `rd_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_msg`
--

DROP TABLE IF EXISTS `rd_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_msg` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `msg_from` int(32) NOT NULL,
  `msg_to` int(32) NOT NULL,
  `msg_content` varchar(2000) DEFAULT NULL,
  `sendtime` varchar(20) DEFAULT NULL,
  `msg_type` int(8) NOT NULL DEFAULT '1',
  `msg_status` int(1) NOT NULL DEFAULT '0',
  `msg_title` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_msg`
--

LOCK TABLES `rd_msg` WRITE;
/*!40000 ALTER TABLE `rd_msg` DISABLE KEYS */;
INSERT INTO `rd_msg` VALUES (1,2,1,'1','1484723074',2,0,'1'),(2,2,1,'2','1484817730',2,1,'2'),(3,2,1,'kingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicatkingdragon@kingdragon-Ubuntu:/var/www/navicat112_premium_en_x64$ ./start_navicat','1484817731',2,1,'3'),(4,1,2,'测试回复内容测试回复内容测试回复内容测试回复内容测试回复内容测试回复内容测试回复内容测试回复内容测试回复内容测试回复内容','1484802379',2,1,'[回复]:3'),(5,1,2,'nadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosinadofgadoisgaosi','1484802551',2,0,'[回复]:3'),(6,1,2,'fdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouioudsfdsbjkabsdouiouds','1484802588',2,1,'[回复]:3'),(7,2,1,'嗯呐 我收到了！','1484805650',2,0,'[回复]:[回复]:3'),(8,1,1,'自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩自己发给自己玩','1484817732',2,1,'自己发给自己玩'),(9,1,1,'自己回复给自己玩自己回复给自己玩自己回复给自己玩自己回复给自己玩自己回复给自己玩自己回复给自己玩','1484817836',2,0,'[回复]:自己发给自己玩'),(10,1,1,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310809',1,1,'新书单来啦'),(11,1,2,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310809',1,0,'新书单来啦'),(12,1,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310809',1,0,'新书单来啦'),(13,1,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310809',1,0,'新书单来啦'),(14,1,21,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310809',1,0,'新书单来啦'),(15,1,2,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310872',1,0,'新书单来啦'),(16,1,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310872',1,0,'新书单来啦'),(17,1,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310872',1,0,'新书单来啦'),(18,1,21,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487310872',1,0,'新书单来啦'),(19,1,2,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487333670',1,0,'新书单来啦'),(20,1,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487333670',1,0,'新书单来啦'),(21,1,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487333670',1,0,'新书单来啦'),(22,1,21,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1487333670',1,0,'新书单来啦'),(23,2,1,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490092498',1,0,'新书单来啦'),(24,2,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490092498',1,0,'新书单来啦'),(25,2,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490092498',1,0,'新书单来啦'),(26,2,1,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490099388',1,0,'新书单来啦'),(27,2,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490099388',1,0,'新书单来啦'),(28,2,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490099388',1,0,'新书单来啦'),(29,2,1,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490102801',1,0,'新书单来啦'),(30,2,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490102801',1,0,'新书单来啦'),(31,2,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490102801',1,0,'新书单来啦'),(32,2,1,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490107083',1,0,'新书单来啦'),(33,2,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490107083',1,0,'新书单来啦'),(34,2,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490107083',1,0,'新书单来啦'),(35,2,1,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490147218',1,1,'新书单来啦'),(36,2,19,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490147218',1,0,'新书单来啦'),(37,2,20,'老师给你推送书单啦,快去全本阅读－我的任务下边查看吧!','1490147218',1,0,'新书单来啦'),(38,1,2,'好的老师，收到了','1490149492',2,1,'[回复]:新书单来啦'),(39,2,1,' 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生 测试教师发给学生','1490156315',2,1,' 测试教师发给学生');
/*!40000 ALTER TABLE `rd_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_obj_log`
--

DROP TABLE IF EXISTS `rd_obj_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_obj_log` (
  `id` int(32) NOT NULL,
  `log_id` int(32) DEFAULT NULL,
  `ans_right` tinyint(2) DEFAULT NULL,
  `ans_stu` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_obj_log`
--

LOCK TABLES `rd_obj_log` WRITE;
/*!40000 ALTER TABLE `rd_obj_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `rd_obj_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_quick_note`
--

DROP TABLE IF EXISTS `rd_quick_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_quick_note` (
  `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'note_id',
  `note_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `owner_id` int(10) unsigned NOT NULL COMMENT '谁添加的',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用于显示的quick note';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_quick_note`
--

LOCK TABLES `rd_quick_note` WRITE;
/*!40000 ALTER TABLE `rd_quick_note` DISABLE KEYS */;
INSERT INTO `rd_quick_note` VALUES (6,'孔子说：万能的不是神，是程序员！',1),(7,'听说飞信被渗透了几百台服务器',1),(8,'（yamete）＝不要 ，一般音译为”亚美爹”，正确发音是：亚灭贴',1),(9,'（kimochiii）＝爽死了，一般音译为”可莫其”，正确发音是：克一莫其一一 ',1),(10,'（itai）＝疼 ，一般音译为以太',1),(11,'（iku）＝要出来了 ，一般音译为一库',1),(12,'（soko dame）＝那里……不可以 一般音译：锁扩，打灭',1),(13,'(hatsukashi)＝羞死人了 ，音译：哈次卡西',1),(14,'（atashinookuni）＝到人家的身体里了，音译：啊她西诺喔库你',1),(15,'（mottto mottto）＝还要，还要，再大力点的意思 音译：毛掏 毛掏',1),(20,'这是一条含HTML的便签 <a href=\"http://www.osadmin.org\">osadmin.org</a>',1),(23,'你造吗？quick note可以关掉的，在右上角的我的账号里可以设置的。',1),(24,'你造吗？“功能”其实就是“链接”啦啦，权限控制是根据用户访问的链接来验证的。',1),(25,'你造吗？权限是赋予给账号组的，账号组下的用户拥有相同的权限。',1),(26,'Hi，你注意到navibar上的+号和-号了吗？',1),(27,'假如世界上只剩下两坨屎，我一定会把热的留给你',1),(28,'你造吗？这页面设计用是bootstrap模板改的',1),(29,'你造吗？这全部都是我一个人开发的，可特么累了',1),(30,'客官有什么建议可以直接在weibo.com上<a target=_blank  href =\"http://weibo.com/osadmin\">@OSAdmin官网</a> 本店服务一定会让客官满意的！亚美爹！',1);
/*!40000 ALTER TABLE `rd_quick_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_read_list`
--

DROP TABLE IF EXISTS `rd_read_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_read_list` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(32) DEFAULT NULL,
  `type` int(32) DEFAULT NULL,
  `endtime` varchar(32) DEFAULT NULL,
  `addtime` varchar(32) DEFAULT NULL,
  `grade` int(32) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_read_list`
--

LOCK TABLES `rd_read_list` WRITE;
/*!40000 ALTER TABLE `rd_read_list` DISABLE KEYS */;
INSERT INTO `rd_read_list` VALUES (1,2,1,'1497223415','1486223415',1,'一年级书单'),(2,2,2,'1499705200','1487307040',2,'2年级书单'),(3,2,2,'1492380000','1487307131',3,'3年级书单'),(4,2,2,'1493330400','1487307249',4,'4年级书单'),(5,2,2,'1499890800','1487310239',5,'5年级书单'),(6,2,1,'1499804400','1487310809',6,'6年级书单'),(7,2,1,'1499631600','1487310872',7,'7年级书单'),(8,2,1,'1489631600','1487333670',8,'8年级书单'),(9,2,1,'1490911200','1490092498',NULL,NULL),(10,2,1,'1490911200','1490099372',NULL,NULL),(11,2,1,'1490911200','1490099388',NULL,NULL),(12,2,1,'','1490102801',NULL,NULL),(13,2,1,'','1490107083',NULL,NULL),(14,2,1,'1490911200','1490147218',NULL,NULL);
/*!40000 ALTER TABLE `rd_read_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_read_log`
--

DROP TABLE IF EXISTS `rd_read_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_read_log` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(32) DEFAULT NULL,
  `book_id` int(32) DEFAULT NULL,
  `list_id` int(32) DEFAULT NULL,
  `ques_num` int(2) DEFAULT NULL,
  `ques_deg` double(2,0) DEFAULT NULL,
  `usetime` int(2) DEFAULT NULL,
  `score_total` int(2) DEFAULT NULL,
  `score` int(2) DEFAULT NULL,
  `addtime` varchar(32) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_read_log`
--

LOCK TABLES `rd_read_log` WRITE;
/*!40000 ALTER TABLE `rd_read_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `rd_read_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_school`
--

DROP TABLE IF EXISTS `rd_school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_school` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `schoolname` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_school`
--

LOCK TABLES `rd_school` WRITE;
/*!40000 ALTER TABLE `rd_school` DISABLE KEYS */;
INSERT INTO `rd_school` VALUES (1,'海淀实验小学'),(2,'清华附属小学');
/*!40000 ALTER TABLE `rd_school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_sms`
--

DROP TABLE IF EXISTS `rd_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_sms` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_sms`
--

LOCK TABLES `rd_sms` WRITE;
/*!40000 ALTER TABLE `rd_sms` DISABLE KEYS */;
INSERT INTO `rd_sms` VALUES (1,'13810332931','363243',0,'1484397078'),(2,'13822222222','522837',0,'1484398051');
/*!40000 ALTER TABLE `rd_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_sys_log`
--

DROP TABLE IF EXISTS `rd_sys_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_sys_log` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `action` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL COMMENT '操作了哪个类的对象',
  `class_obj` varchar(32) NOT NULL COMMENT '操作的对象是谁，可能为对象的ID',
  `result` text NOT NULL COMMENT '操作的结果',
  `op_time` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_time` (`op_time`),
  KEY `class_name` (`class_name`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_sys_log`
--

LOCK TABLES `rd_sys_log` WRITE;
/*!40000 ALTER TABLE `rd_sys_log` DISABLE KEYS */;
INSERT INTO `rd_sys_log` VALUES (1,'admin','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1490447335),(2,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490447473),(3,'admin','LOGOUT','User','1','',1490447841),(4,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490449876),(5,'admin','MODIFY','Module','1','{\"module_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\",\"module_desc\":\"\\u914d\\u7f6e\\u7cfb\\u7edf\\u76f8\\u5173\\u529f\\u80fd\",\"module_icon\":\"icon-th\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"10\"}',1490450428),(6,'admin','MODIFY','Module','2','{\"module_name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"module_desc\":\"\\u7528\\u6237\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-align-justify\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"0\",\"online\":\"1\"}',1490450582),(7,'admin','ADD','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_url\":\"\\/index.php\",\"module_sort\":1,\"module_icon\":\"icon-book\"}',1490450782),(8,'admin','MODIFY','Module','2','{\"module_name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"module_desc\":\"\\u7528\\u6237\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-user\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"0\",\"online\":\"1\"}',1490450792),(9,'admin','MODIFY','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-book\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"1\",\"online\":\"1\"}',1490450853),(10,'admin','MODIFY','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-book\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"1\",\"online\":\"0\"}',1490451077),(11,'admin','MODIFY','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-book\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"1\",\"online\":\"1\"}',1490451088),(12,'admin','ADD','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/panel\\/addbook.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490451166),(13,'admin','MODIFY','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/panel\\/addbook.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"3\"}',1490451180),(14,'admin','MODIFY','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/book\\/addbook.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"104\",\"module_id\":\"3\"}',1490451763),(15,'admin','MODIFY','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/book\\/addbook.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"3\"}',1490451896),(16,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104\"}',1490452270),(17,'admin','ADD','Module','4','{\"module_name\":\"\\u4e66\\u5355\\u7ba1\\u7406\",\"module_desc\":\"\\u4e66\\u5355\\u7ba1\\u7406\\u6a21\\u5757\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":1,\"module_icon\":\"icon-th-list\"}',1490454526),(18,'admin','MODIFY','Module','4','{\"module_name\":\"\\u4e66\\u5355\\u7ba1\\u7406\",\"module_desc\":\"\\u4e66\\u5355\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-th-list\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"2\",\"online\":\"1\"}',1490454583),(19,'admin','ADD','MenuUrl','105','{\"menu_name\":\"\\u6d4b\\u8bd5\\u9898\\u7ba1\\u7406\",\"menu_url\":\"\\/book\\/question.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u7ba1\\u7406\\u56fe\\u4e66\\u6d4b\\u8bd5\\u9898\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490454770),(20,'admin','ADD','MenuUrl','106','{\"menu_name\":\"\\u4e66\\u5355\\u7ba1\\u7406\",\"menu_url\":\"\\/list\\/booklist.php\",\"module_id\":\"4\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u7ba1\\u7406\\u4e66\\u5355\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490454827),(21,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106\"}',1490454833),(22,'admin','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1490514789),(23,'admin','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1490514798),(24,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490515096),(25,'admin','ADD','MenuUrl','107','{\"menu_name\":\"\\u5b66\\u751f\\u7ba1\\u7406\",\"menu_url\":\"\\/user\\/student.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u5b66\\u751f\\u7ba1\\u7406\\u6a21\\u5757\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490515497),(26,'admin','ADD','MenuUrl','108','{\"menu_name\":\"\\u6559\\u5e08\\u7ba1\\u7406\",\"menu_url\":\"\\/user\\/teacher.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u6559\\u5e08\\u7ba1\\u7406\\u6a21\\u5757\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490515644),(27,'admin','LOGOUT','User','1','',1490516215),(28,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490516227),(29,'admin','ADD','MenuUrl','109','{\"menu_name\":\"\\u5b66\\u6821\\u7ba1\\u7406\",\"menu_url\":\"\\/user\\/school.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u5b66\\u6821\\u7ba1\\u7406\\u6a21\\u5757\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490516298),(30,'admin','ADD','MenuUrl','110','{\"menu_name\":\"\\u5e74\\u7ea7\\u7ba1\\u7406\",\"menu_url\":\"\\/user\\/grade.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u5e74\\u7ea7\\u7ba1\\u7406\\u6a21\\u5757\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490516333),(31,'admin','ADD','MenuUrl','111','{\"menu_name\":\"\\u73ed\\u7ea7\\u7ba1\\u7406\",\"menu_url\":\"\\/user\\/class.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u73ed\\u7ea7\\u7ba1\\u7406\\u6a21\\u5757\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490516360),(32,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111\"}',1490517267),(33,'admin','MODIFY','MenuUrl','101','{\"menu_name\":\"\\u6837\\u4f8b\",\"menu_url\":\"\\/user\\/sample.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"2\"}',1490518468),(34,'admin','MODIFY','MenuUrl','103','{\"menu_name\":\"\\u8bfb\\u53d6XLS\\u6587\\u4ef6\",\"menu_url\":\"\\/user\\/read_excel.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"2\"}',1490518485),(35,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490533510),(36,'admin','LOGOUT','User','1','',1490533526),(37,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490533552),(38,'admin','ADD','MenuUrl','112','{\"menu_name\":\"\\u6dfb\\u52a0\\u5b66\\u6821\",\"menu_url\":\"\\/user\\/school_add.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490535405),(39,'admin','MODIFY','MenuUrl','112','{\"menu_name\":\"\\u6dfb\\u52a0\\u5b66\\u6821\",\"menu_url\":\"\\/user\\/school_add.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"109\",\"module_id\":\"2\"}',1490535431),(40,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111,112\"}',1490535441),(41,'admin','ADD','School','3','{\"schoolname\":\"\\u6d4b\\u8bd5\"}',1490535648),(42,'admin','ADD','School','4','{\"schoolname\":\"\\u6d4b\\u8bd5\\u5b66\\u6821\"}',1490535712),(43,'admin','DELETE','School','3','',1490536065),(44,'admin','DELETE','School','4','',1490536070),(45,'admin','ADD','MenuUrl','113','{\"menu_name\":\"\\u4fee\\u6539\\u5b66\\u6821\",\"menu_url\":\"\\/user\\/school_modify.php\",\"module_id\":\"2\",\"is_show\":\"0\",\"online\":1,\"menu_desc\":\"\\u4fee\\u6539\\u5b66\\u6821\\u4fe1\\u606f\",\"shortcut_allowed\":\"1\",\"father_menu\":\"109\"}',1490536193),(46,'admin','MODIFY','MenuUrl','112','{\"menu_name\":\"\\u6dfb\\u52a0\\u5b66\\u6821\",\"menu_url\":\"\\/user\\/school_add.php\",\"is_show\":\"0\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"109\",\"module_id\":\"2\"}',1490536207),(47,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111,112,113\"}',1490536213),(48,'admin','MODIFY','School','1','{\"schoolname\":\"\\u6d77\\u6dc0\\u5b9e\\u9a8c\\u5c0f\",\"ip\":\"127.0.0.1\"}',1490536964),(49,'admin','MODIFY','School','1','{\"schoolname\":\"\\u6d77\\u6dc0\\u5b9e\\u9a8c\\u5c0f\\u5b66\",\"ip\":\"127.0.0.1\"}',1490536971),(50,'admin','ADD','MenuUrl','114','{\"menu_name\":\"\\u6dfb\\u52a0\\u5e74\\u7ea7\",\"menu_url\":\"\\/user\\/grade_add.php\",\"module_id\":\"2\",\"is_show\":\"0\",\"online\":1,\"menu_desc\":\"\\u6dfb\\u52a0\\u5e74\\u7ea7\\u4fe1\\u606f\",\"shortcut_allowed\":\"1\",\"father_menu\":\"110\"}',1490537061),(51,'admin','ADD','MenuUrl','115','{\"menu_name\":\"\\u4fee\\u6539\\u5e74\\u7ea7\",\"menu_url\":\"\\/user\\/grade_modify.php\",\"module_id\":\"2\",\"is_show\":\"0\",\"online\":1,\"menu_desc\":\"\\u4fee\\u6539\\u5e74\\u7ea7\\u4fe1\\u606f\",\"shortcut_allowed\":\"1\",\"father_menu\":\"110\"}',1490537099),(52,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111,112,113,114,115\"}',1490537105),(53,'admin','ADD','Grade','14','{\"grade_name\":\"\\u6d4b\\u8bd5\\u5e74\\u7ea7\"}',1490538133),(54,'admin','DELETE','Grade','14','',1490538141),(55,'admin','MODIFY','School','2','{\"schoolname\":\"\\u6e05\\u534e\\u9644\\u5c5e\\u5c0f\\u5b66\\u6d4b\",\"ip\":\"127.0.0.1\"}',1490538897),(56,'admin','MODIFY','School','2','{\"schoolname\":\"\\u6e05\\u534e\\u9644\\u5c5e\\u5c0f\\u5b66\",\"ip\":\"127.0.0.1\"}',1490538902),(57,'admin','ADD','Grade','15','{\"grade_name\":\"\\u6d4b\\u8bd5\"}',1490538973),(58,'admin','ADD','Grade','16','{\"grade_name\":\"\\u6d4b\\u8bd5\"}',1490540712),(59,'admin','DELETE','Grade','16','',1490540719),(60,'admin','ADD','MenuUrl','116','{\"menu_name\":\"\\u6dfb\\u52a0\\u73ed\\u7ea7\",\"menu_url\":\"\\/user\\/class_add.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u6dfb\\u52a0\\u73ed\\u7ea7\",\"shortcut_allowed\":\"1\",\"father_menu\":\"111\"}',1490540871),(61,'admin','ADD','MenuUrl','117','{\"menu_name\":\"\\u4fee\\u6539\\u73ed\\u7ea7\",\"menu_url\":\"\\/user\\/class_modify.php\",\"module_id\":\"2\",\"is_show\":\"0\",\"online\":1,\"menu_desc\":\"\\u4fee\\u6539\\u73ed\\u7ea7\\u4fe1\\u606f\",\"shortcut_allowed\":\"1\",\"father_menu\":\"111\"}',1490540904),(62,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117\"}',1490540913),(63,'admin','MODIFY','MenuUrl','116','{\"menu_name\":\"\\u6dfb\\u52a0\\u73ed\\u7ea7\",\"menu_url\":\"\\/user\\/class_add.php\",\"is_show\":\"0\",\"online\":\"1\",\"menu_desc\":\"\\u6dfb\\u52a0\\u73ed\\u7ea7\",\"shortcut_allowed\":\"1\",\"father_menu\":\"111\",\"module_id\":\"2\"}',1490540932),(64,'admin','MODIFY','MenuUrl','111','{\"menu_name\":\"\\u73ed\\u7ea7\\u7ba1\\u7406\",\"menu_url\":\"\\/user\\/banji.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\\u73ed\\u7ea7\\u7ba1\\u7406\\u6a21\\u5757\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"2\"}',1490541155),(65,'admin','MODIFY','MenuUrl','116','{\"menu_name\":\"\\u6dfb\\u52a0\\u73ed\\u7ea7\",\"menu_url\":\"\\/user\\/banji_add.php\",\"is_show\":\"0\",\"online\":\"1\",\"menu_desc\":\"\\u6dfb\\u52a0\\u73ed\\u7ea7\",\"shortcut_allowed\":\"1\",\"father_menu\":\"111\",\"module_id\":\"2\"}',1490541170),(66,'admin','MODIFY','MenuUrl','117','{\"menu_name\":\"\\u4fee\\u6539\\u73ed\\u7ea7\",\"menu_url\":\"\\/user\\/banji_modify.php\",\"is_show\":\"0\",\"online\":\"1\",\"menu_desc\":\"\\u4fee\\u6539\\u73ed\\u7ea7\\u4fe1\\u606f\",\"shortcut_allowed\":\"1\",\"father_menu\":\"111\",\"module_id\":\"2\"}',1490541183);
/*!40000 ALTER TABLE `rd_sys_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_system`
--

DROP TABLE IF EXISTS `rd_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_system` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_system`
--

LOCK TABLES `rd_system` WRITE;
/*!40000 ALTER TABLE `rd_system` DISABLE KEYS */;
INSERT INTO `rd_system` VALUES ('timezone','\"Asia/Shanghai\"');
/*!40000 ALTER TABLE `rd_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_user`
--

DROP TABLE IF EXISTS `rd_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_user` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `sex` tinyint(2) unsigned DEFAULT '0',
  `mobile` varchar(11) DEFAULT NULL,
  `grade` int(10) DEFAULT NULL,
  `class` int(10) DEFAULT NULL,
  `school` int(10) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT NULL,
  `score` int(32) DEFAULT '0',
  `role` tinyint(2) DEFAULT '1',
  `addtime` varchar(32) DEFAULT NULL,
  `item1_score` int(11) DEFAULT '0',
  `item2_score` int(11) DEFAULT '0',
  `item3_score` int(11) DEFAULT '0',
  `item4_score` int(11) DEFAULT '0',
  `item5_score` int(11) DEFAULT '0',
  `chinese_score` int(8) NOT NULL DEFAULT '0',
  `list_id` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_user`
--

LOCK TABLES `rd_user` WRITE;
/*!40000 ALTER TABLE `rd_user` DISABLE KEYS */;
INSERT INTO `rd_user` VALUES (1,'13810332931','e10adc3949ba59abbe56e057f20f883e','KingDragon',0,'13810332931',4,1,1,'http://img2.imgtn.bdimg.com/it/u=2608125868,2516638763&fm=214&gp=0.jpg',95,1,'1484723074',18,18,18,18,18,10,0),(2,'13800000000','e10adc3949ba59abbe56e057f20f883e','龙赤',0,'13800000000',4,6,1,'http://127.0.0.1/reading/upload/1490150597_158e1489a89d7676109d43bf577d4eb7',0,2,'1484723075',0,0,0,0,0,20,0),(19,'13811111111','96e79218965eb72c92a549dd5a330112','龙清',0,NULL,4,1,1,'http://127.0.0.1/reading/upload/1484717953_003b1310e614475bb36b275f347a349a',50,1,'1484723076',10,10,10,10,10,30,0),(20,'13822222222','96e79218965eb72c92a549dd5a330112','kd08',0,NULL,4,1,1,NULL,65,1,'1484723077',15,15,15,15,5,40,0),(21,'13833333333','96e79218965eb72c92a549dd5a330112','龙绿',0,NULL,4,2,1,NULL,0,1,'1484723078',0,0,0,0,0,50,0);
/*!40000 ALTER TABLE `rd_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_user_exam_scores`
--

DROP TABLE IF EXISTS `rd_user_exam_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_user_exam_scores` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `user_id` int(32) NOT NULL,
  `book_id` int(32) NOT NULL,
  `scores` varchar(30) NOT NULL,
  `hege` int(1) NOT NULL DEFAULT '0',
  `use_time` int(32) NOT NULL DEFAULT '0',
  `exam_time` varchar(50) NOT NULL,
  `answers` varchar(30) NOT NULL,
  `question_ids` varchar(255) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_user_exam_scores`
--

LOCK TABLES `rd_user_exam_scores` WRITE;
/*!40000 ALTER TABLE `rd_user_exam_scores` DISABLE KEYS */;
INSERT INTO `rd_user_exam_scores` VALUES (1,1,1,'1,1,1,1,1,1,1,1,1,1',1,579,'1489221875','1,1,1,1,1,1,1,1,1,1','6,21,7,22,8,23,9,24,10,25',10),(2,1,2,'1,0,0,0,0,0,0,1,0,0',1,493,'1489238077','1,2,3,3,4,2,2,1,2,2','6,21,7,22,8,23,9,24,10,25',2),(10,1,3,'0,0,0,0,0,0,0,0,0,0',1,-1,'1489306702','5,5,5,5,5,5,5,5,5,5','6,16,7,17,8,18,9,19,10,20',0),(11,1,5,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0',0,-1,'1489306702','5,5,5,5,5,5,5,5,5,5,5,5,5,5,5','6,16,7,17,8,18,9,19,10,20,20,20,20,20,20',0),(12,1,9,'1,1,1,1,1,1,1,1,1,1,1,1,1,1,1',1,479,'1489309216','1,1,1,1,1,1,1,1,1,1,1,1,1,1,1','61,56,41,62,57,42,63,58,43,64,59,44,65,60,45',15),(13,1,8,'0,0,0,0,0,0,0,1,0,0,0,0,0,1,1',0,548,'1490161212','4,4,4,4,3,3,2,1,3,4,3,2,2,1,1','66,41,51,67,42,52,68,43,53,69,44,54,70,45,55',3),(14,1,8,'0,0,0,0,0,0,0,0,0,0,0,0,0,0,0',0,475,'1490161374','2,2,2,2,2,2,2,2,2,2,2,2,2,2,5','31,51,71,32,52,72,33,53,73,34,54,74,35,55,75',0);
/*!40000 ALTER TABLE `rd_user_exam_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_user_read_book`
--

DROP TABLE IF EXISTS `rd_user_read_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_user_read_book` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `user_id` int(32) NOT NULL COMMENT '用户id',
  `book_id` int(32) NOT NULL COMMENT '书本idfrom rd_book',
  `removed` int(2) NOT NULL DEFAULT '0',
  `addtime` varchar(50) DEFAULT NULL,
  `endtime` varchar(50) DEFAULT NULL,
  `type` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_user_read_book`
--

LOCK TABLES `rd_user_read_book` WRITE;
/*!40000 ALTER TABLE `rd_user_read_book` DISABLE KEYS */;
INSERT INTO `rd_user_read_book` VALUES (1,1,5,0,NULL,'1497223415',1),(2,1,8,0,NULL,'1497223415',0),(3,1,9,0,NULL,'1497223415',0),(4,1,6,0,NULL,'1497223415',0),(5,1,10,0,'1490092498','1490911200',1),(6,1,9,0,'1490092498','1490911200',1),(7,2,10,0,'1490092498','1490911200',1),(8,2,9,0,'1490092498','1490911200',1),(9,19,10,0,'1490092498','1490911200',1),(10,19,9,0,'1490092498','1490911200',1),(11,20,10,0,'1490092498','1490911200',1),(12,20,9,0,'1490092498','1490911200',1),(13,1,3,0,'1490099388','1490911200',1),(14,1,8,0,'1490099388','1490911200',1),(15,19,3,0,'1490099388','1490911200',1),(16,19,8,0,'1490099388','1490911200',1),(17,20,3,0,'1490099388','1490911200',1),(18,20,8,0,'1490099388','1490911200',1),(19,1,2,1,NULL,NULL,0),(20,1,10,0,'1490102801','',1),(21,1,9,0,'1490102801','',1),(22,19,10,0,'1490102801','',1),(23,19,9,0,'1490102801','',1),(24,20,10,0,'1490102801','',1),(25,20,9,0,'1490102801','',1),(26,1,10,0,'1490107083','',1),(27,1,9,0,'1490107083','',1),(28,1,8,0,'1490107083','',1),(29,19,10,0,'1490107083','',1),(30,19,9,0,'1490107083','',1),(31,19,8,0,'1490107083','',1),(32,20,10,0,'1490107083','',1),(33,20,9,0,'1490107083','',1),(34,20,8,0,'1490107083','',1),(35,1,7,1,NULL,NULL,0),(36,1,10,0,'1490147218','1490911200',1),(37,19,10,0,'1490147218','1490911200',1),(38,20,10,0,'1490147218','1490911200',1);
/*!40000 ALTER TABLE `rd_user_read_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rd_user_read_list`
--

DROP TABLE IF EXISTS `rd_user_read_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rd_user_read_list` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `user_id` int(32) NOT NULL COMMENT '用户id',
  `book_list_id` int(32) NOT NULL COMMENT '书单id rd_read_list',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rd_user_read_list`
--

LOCK TABLES `rd_user_read_list` WRITE;
/*!40000 ALTER TABLE `rd_user_read_list` DISABLE KEYS */;
INSERT INTO `rd_user_read_list` VALUES (2,1,3),(4,19,3),(5,20,3),(6,21,3),(7,1,4),(8,2,4),(9,19,4),(10,20,4),(11,21,4),(12,1,5),(13,2,5),(14,19,5),(15,20,5),(16,21,5),(17,1,6),(18,2,6),(19,19,6),(20,20,6),(21,21,6),(22,1,7),(23,2,7),(24,19,7),(25,20,7),(26,21,7),(27,1,8),(28,2,8),(29,19,8),(30,20,8),(31,21,8),(33,1,2),(34,1,1),(35,1,9),(36,2,9),(37,19,9),(38,20,9),(39,1,11),(40,19,11),(41,20,11),(42,1,12),(43,19,12),(44,20,12),(45,1,13),(46,19,13),(47,20,13),(48,1,14),(49,19,14),(50,20,14);
/*!40000 ALTER TABLE `rd_user_read_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sample`
--

DROP TABLE IF EXISTS `sample`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sample` (
  `sample_id` int(11) NOT NULL,
  `sample_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sample`
--

LOCK TABLES `sample` WRITE;
/*!40000 ALTER TABLE `sample` DISABLE KEYS */;
INSERT INTO `sample` VALUES (1,'这是一个样例');
/*!40000 ALTER TABLE `sample` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-26 23:27:19
