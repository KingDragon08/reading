<?php
	include_once "ez_sql_core.php";
	include_once "ez_sql_mysql.php";
	$db_host = "lezhireading.com";
	$db_name = "reading";
	$db_user = "KingDragon";
	$db_password = "939407Lq252324";
	$db = new ezSQL_mysql($db_user,$db_password,$db_name,$db_host,'utf-8');
	$GLOBALS['db'] = $db;
?>
