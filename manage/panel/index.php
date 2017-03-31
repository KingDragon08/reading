<?php
require('../include/init.inc.php');
 // echo "string";
// exit();
$user_info = UserSession::getSessionInfo();
// var_dump($user_info);
$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
Template::assign('menus', $menus);
Template::display('index.tpl');
