<?php /* Smarty version Smarty-3.1.15, created on 2017-03-25 21:34:45
         compiled from "/var/www/html/reading/manage/include/template/simple_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:115863040758d671f5e56d88-95206733%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5eddfd4e548ad34a4803d03f5cabfd0d08e5b1fe' => 
    array (
      0 => '/var/www/html/reading/manage/include/template/simple_header.tpl',
      1 => 1490448094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115863040758d671f5e56d88-95206733',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 0,
    'user_info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_58d671f5e63755_92299696',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d671f5e63755_92299696')) {function content_58d671f5e63755_92299696($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh">
	<head>
		<meta charset="utf-8">
		<title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
 - <?php echo @constant('ADMIN_TITLE');?>
</title>
		<meta content="IE=edge, chrome=1" http-equiv="X-UA-Compatible">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="stylesheet" href="<?php echo @constant('ADMIN_URL');?>
/assets/lib/bootstrap/css/bootstrap.css">

		<link rel="stylesheet" href="<?php echo @constant('ADMIN_URL');?>
/assets/stylesheets_<?php if ($_smarty_tpl->tpl_vars['user_info']->value) {?><?php echo $_smarty_tpl->tpl_vars['user_info']->value['template'];?>
<?php } else { ?>default<?php }?>/theme.css">
		<link rel="stylesheet" href="<?php echo @constant('ADMIN_URL');?>
/assets/lib/font-awesome/css/font-awesome.css">

		<script src="<?php echo @constant('ADMIN_URL');?>
/assets/lib/jquery-1.8.1.min.js" ></script>
	<script src="<?php echo @constant('ADMIN_URL');?>
/assets/js/other.js" ></script>

		<!-- Demo page code -->

		<style type="text/css">
				#line-chart {
						height:300px;
						width:800px;
						margin: 0px auto;
						margin-top: 1em;
				}
				.brand { font-family: georgia, serif; }
				.brand .first {
						color: #ccc;
						font-style: italic;
				}
				.brand .second {
						color: #fff;
						font-weight: bold;
				}
		</style>

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
<?php }} ?>
