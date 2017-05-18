<?php
	include_once "ez_sql_core.php";
	include_once "ez_sql_mysql.php";
	// $db_host = "127.0.0.1";
	// $db_name = "reading";
	// $db_user = "root";
	// $db_password = "(@~1723li-YC45+)";
	$db_host = "www.lezhireading.com";
	$db_name = "reading";
	$db_user = "KingDragon";
	$db_password = "939407Lq252324";
	$db = new ezSQL_mysql($db_user,$db_password,$db_name,$db_host,'utf-8');
	$GLOBALS['db'] = $db;
?>
