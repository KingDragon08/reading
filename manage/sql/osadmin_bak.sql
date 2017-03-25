-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: osadmin
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
-- Table structure for table `osa_menu_url`
--

DROP TABLE IF EXISTS `osa_menu_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_menu_url` (
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
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osa_menu_url`
--

LOCK TABLES `osa_menu_url` WRITE;
/*!40000 ALTER TABLE `osa_menu_url` DISABLE KEYS */;
INSERT INTO `osa_menu_url` VALUES (1,'首页','/panel/index.php',1,0,1,1,'后台首页',0),(2,'账号列表','/panel/users.php',1,1,1,1,'账号列表',0),(3,'修改账号','/panel/user_modify.php',1,0,1,0,'修改账号',2),(4,'新建账号','/panel/user_add.php',1,0,1,1,'新建账号',2),(5,'个人信息','/panel/profile.php',1,0,1,1,'个人信息',0),(6,'账号组成员','/panel/group.php',1,0,1,0,'显示账号组详情及该组成员',7),(7,'账号组管理','/panel/groups.php',1,1,1,1,'增加管理员',0),(8,'修改账号组','/panel/group_modify.php',1,0,1,0,'修改账号组',7),(9,'新建账号组','/panel/group_add.php',1,0,1,1,'新建账号组',7),(10,'权限管理','/panel/group_role.php',1,1,1,1,'用户权限依赖于账号组的权限',0),(11,'菜单模块','/panel/modules.php',1,1,1,1,'菜单里的模块',0),(12,'编辑菜单模块','/panel/module_modify.php',1,0,1,0,'编辑模块',11),(13,'添加菜单模块','/panel/module_add.php',1,0,1,1,'添加菜单模块',11),(14,'功能列表','/panel/menus.php',1,1,1,1,'菜单功能及可访问的链接',0),(15,'增加功能','/panel/menu_add.php',1,0,1,1,'增加功能',14),(16,'功能修改','/panel/menu_modify.php',1,0,1,0,'修改功能',14),(17,'设置模板','/panel/set.php',1,0,1,1,'设置模板',0),(18,'便签管理','/panel/quicknotes.php',1,1,1,1,'quick note',0),(19,'菜单链接列表','/panel/module.php',1,0,1,0,'显示模块详情及该模块下的菜单',11),(20,'登入','/login.php',1,0,1,1,'登入页面',0),(21,'操作记录','/panel/syslog.php',1,1,1,1,'用户操作的历史行为',0),(22,'系统信息','/panel/system.php',1,1,1,1,'显示系统相关信息',0),(23,'ajax访问修改快捷菜单','/ajax/shortcut.php',1,0,1,0,'ajax请求',0),(24,'添加便签','/panel/quicknote_add.php',1,0,1,1,'添加quicknote的内容',18),(25,'修改便签','/panel/quicknote_modify.php',1,0,1,0,'修改quicknote的内容',18),(26,'系统设置','/panel/setting.php',1,0,1,0,'系统设置',0),(101,'样例','/sample/sample.php',2,1,1,1,'',0),(103,'读取XLS文件','/sample/read_excel.php',2,1,1,1,'',0),(104,'添加图书','/book/addbook.php',3,1,1,1,'',0),(105,'测试题管理','/book/question.php',3,1,1,1,'管理图书测试题',0),(106,'书单管理','/list/booklist.php',4,1,1,1,'管理书单',0);
/*!40000 ALTER TABLE `osa_menu_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osa_module`
--

DROP TABLE IF EXISTS `osa_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_module` (
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
-- Dumping data for table `osa_module`
--

LOCK TABLES `osa_module` WRITE;
/*!40000 ALTER TABLE `osa_module` DISABLE KEYS */;
INSERT INTO `osa_module` VALUES (1,'系统管理','/panel/index.php',10,'配置系统相关功能','icon-th',1),(2,'用户管理','/panel/index.php',0,'用户管理模块','icon-user',1),(3,'图书管理','/panel/index.php',1,'图书管理模块','icon-book',1),(4,'书单管理','/panel/index.php',2,'书单管理模块','icon-th-list',1);
/*!40000 ALTER TABLE `osa_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osa_quick_note`
--

DROP TABLE IF EXISTS `osa_quick_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_quick_note` (
  `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'note_id',
  `note_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `owner_id` int(10) unsigned NOT NULL COMMENT '谁添加的',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用于显示的quick note';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osa_quick_note`
--

LOCK TABLES `osa_quick_note` WRITE;
/*!40000 ALTER TABLE `osa_quick_note` DISABLE KEYS */;
INSERT INTO `osa_quick_note` VALUES (6,'孔子说：万能的不是神，是程序员！',1),(7,'听说飞信被渗透了几百台服务器',1),(8,'（yamete）＝不要 ，一般音译为”亚美爹”，正确发音是：亚灭贴',1),(9,'（kimochiii）＝爽死了，一般音译为”可莫其”，正确发音是：克一莫其一一 ',1),(10,'（itai）＝疼 ，一般音译为以太',1),(11,'（iku）＝要出来了 ，一般音译为一库',1),(12,'（soko dame）＝那里……不可以 一般音译：锁扩，打灭',1),(13,'(hatsukashi)＝羞死人了 ，音译：哈次卡西',1),(14,'（atashinookuni）＝到人家的身体里了，音译：啊她西诺喔库你',1),(15,'（mottto mottto）＝还要，还要，再大力点的意思 音译：毛掏 毛掏',1),(20,'这是一条含HTML的便签 <a href=\"http://www.osadmin.org\">osadmin.org</a>',1),(23,'你造吗？quick note可以关掉的，在右上角的我的账号里可以设置的。',1),(24,'你造吗？“功能”其实就是“链接”啦啦，权限控制是根据用户访问的链接来验证的。',1),(25,'你造吗？权限是赋予给账号组的，账号组下的用户拥有相同的权限。',1),(26,'Hi，你注意到navibar上的+号和-号了吗？',1),(27,'假如世界上只剩下两坨屎，我一定会把热的留给你',1),(28,'你造吗？这页面设计用是bootstrap模板改的',1),(29,'你造吗？这全部都是我一个人开发的，可特么累了',1),(30,'客官有什么建议可以直接在weibo.com上<a target=_blank  href =\"http://weibo.com/osadmin\">@OSAdmin官网</a> 本店服务一定会让客官满意的！亚美爹！',1);
/*!40000 ALTER TABLE `osa_quick_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osa_sys_log`
--

DROP TABLE IF EXISTS `osa_sys_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_sys_log` (
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osa_sys_log`
--

LOCK TABLES `osa_sys_log` WRITE;
/*!40000 ALTER TABLE `osa_sys_log` DISABLE KEYS */;
INSERT INTO `osa_sys_log` VALUES (1,'admin','LOGIN','User','','\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"',1490447335),(2,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490447473),(3,'admin','LOGOUT','User','1','',1490447841),(4,'admin','LOGIN','User','1','{\"IP\":\"127.0.0.1\"}',1490449876),(5,'admin','MODIFY','Module','1','{\"module_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\",\"module_desc\":\"\\u914d\\u7f6e\\u7cfb\\u7edf\\u76f8\\u5173\\u529f\\u80fd\",\"module_icon\":\"icon-th\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"10\"}',1490450428),(6,'admin','MODIFY','Module','2','{\"module_name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"module_desc\":\"\\u7528\\u6237\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-align-justify\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"0\",\"online\":\"1\"}',1490450582),(7,'admin','ADD','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_url\":\"\\/index.php\",\"module_sort\":1,\"module_icon\":\"icon-book\"}',1490450782),(8,'admin','MODIFY','Module','2','{\"module_name\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"module_desc\":\"\\u7528\\u6237\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-user\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"0\",\"online\":\"1\"}',1490450792),(9,'admin','MODIFY','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-book\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"1\",\"online\":\"1\"}',1490450853),(10,'admin','MODIFY','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-book\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"1\",\"online\":\"0\"}',1490451077),(11,'admin','MODIFY','Module','3','{\"module_name\":\"\\u56fe\\u4e66\\u7ba1\\u7406\",\"module_desc\":\"\\u56fe\\u4e66\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-book\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"1\",\"online\":\"1\"}',1490451088),(12,'admin','ADD','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/panel\\/addbook.php\",\"module_id\":\"2\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490451166),(13,'admin','MODIFY','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/panel\\/addbook.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"3\"}',1490451180),(14,'admin','MODIFY','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/book\\/addbook.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"104\",\"module_id\":\"3\"}',1490451763),(15,'admin','MODIFY','MenuUrl','104','{\"menu_name\":\"\\u6dfb\\u52a0\\u56fe\\u4e66\",\"menu_url\":\"\\/book\\/addbook.php\",\"is_show\":\"1\",\"online\":\"1\",\"menu_desc\":\"\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\",\"module_id\":\"3\"}',1490451896),(16,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104\"}',1490452270),(17,'admin','ADD','Module','4','{\"module_name\":\"\\u4e66\\u5355\\u7ba1\\u7406\",\"module_desc\":\"\\u4e66\\u5355\\u7ba1\\u7406\\u6a21\\u5757\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":1,\"module_icon\":\"icon-th-list\"}',1490454526),(18,'admin','MODIFY','Module','4','{\"module_name\":\"\\u4e66\\u5355\\u7ba1\\u7406\",\"module_desc\":\"\\u4e66\\u5355\\u7ba1\\u7406\\u6a21\\u5757\",\"module_icon\":\"icon-th-list\",\"module_url\":\"\\/panel\\/index.php\",\"module_sort\":\"2\",\"online\":\"1\"}',1490454583),(19,'admin','ADD','MenuUrl','105','{\"menu_name\":\"\\u6d4b\\u8bd5\\u9898\\u7ba1\\u7406\",\"menu_url\":\"\\/book\\/question.php\",\"module_id\":\"3\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u7ba1\\u7406\\u56fe\\u4e66\\u6d4b\\u8bd5\\u9898\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490454770),(20,'admin','ADD','MenuUrl','106','{\"menu_name\":\"\\u4e66\\u5355\\u7ba1\\u7406\",\"menu_url\":\"\\/list\\/booklist.php\",\"module_id\":\"4\",\"is_show\":\"1\",\"online\":1,\"menu_desc\":\"\\u7ba1\\u7406\\u4e66\\u5355\",\"shortcut_allowed\":\"1\",\"father_menu\":\"0\"}',1490454827),(21,'admin','MODIFY','UserGroup','1','{\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106\"}',1490454833);
/*!40000 ALTER TABLE `osa_sys_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osa_system`
--

DROP TABLE IF EXISTS `osa_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_system` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osa_system`
--

LOCK TABLES `osa_system` WRITE;
/*!40000 ALTER TABLE `osa_system` DISABLE KEYS */;
INSERT INTO `osa_system` VALUES ('timezone','\"Asia/Shanghai\"');
/*!40000 ALTER TABLE `osa_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osa_user`
--

DROP TABLE IF EXISTS `osa_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_user` (
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
-- Dumping data for table `osa_user`
--

LOCK TABLES `osa_user` WRITE;
/*!40000 ALTER TABLE `osa_user` DISABLE KEYS */;
INSERT INTO `osa_user` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','SomewhereYu','13800138001','admin@osadmin.org','初始的超级管理员!',1490449876,1,'127.0.0.1',1,'default','2,7,10,11,13,18,21,24,101',0),(26,'demo','e10adc3949ba59abbe56e057f20f883e','SomewhereYu','15812345678','yuwenqi@osadmin.org','默认用户组成员',1371605873,1,'127.0.0.1',2,'schoolpainting','',1);
/*!40000 ALTER TABLE `osa_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `osa_user_group`
--

DROP TABLE IF EXISTS `osa_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `osa_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初始权限为1,5,17,18,22,23,24,25',
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='账号组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `osa_user_group`
--

LOCK TABLES `osa_user_group` WRITE;
/*!40000 ALTER TABLE `osa_user_group` DISABLE KEYS */;
INSERT INTO `osa_user_group` VALUES (1,'超级管理员组','1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103,104,105,106',1,'万能的不是神，是程序员'),(2,'默认账号组','1,5,17,18,20,22,23,24,25,101',1,'默认账号组');
/*!40000 ALTER TABLE `osa_user_group` ENABLE KEYS */;
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

-- Dump completed on 2017-03-25 23:16:20
