<?php /* Smarty version Smarty-3.1.15, created on 2017-03-25 22:00:28
         compiled from "/var/www/html/reading/manage/include/template/message.tpl" */ ?>
<?php /*%%SmartyHeaderCode:114208304258d677fc1ed0e2-99740155%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1834d8402061a9ef1e735ab274e48e5838a18931' => 
    array (
      0 => '/var/www/html/reading/manage/include/template/message.tpl',
      1 => 1490448094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '114208304258d677fc1ed0e2-99740155',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'message_detail' => 0,
    'forward_url' => 0,
    'forward_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_58d677fc1fb4b6_31129334',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d677fc1fb4b6_31129334')) {function content_58d677fc1fb4b6_31129334($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("simple_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <body class="simple_body">

    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                </ul>
                <a class="brand" href="<?php echo @constant('ADMIN_URL');?>
/index.php"><span class="first"></span> <span class="second"><?php echo @constant('COMPANY_NAME');?>
</span></a>
        </div>
    </div>
<div>
<div class="container-fluid">	
        <div class="row-fluid">
			<div class="http-error">
				
				<?php if ($_smarty_tpl->tpl_vars['type']->value=="success") {?>
				<h1>Yep!</h1>
				<?php } elseif ($_smarty_tpl->tpl_vars['type']->value=="error") {?>
				<h1>Oops!</h1>
				<?php } else { ?>
				<h1>O~!</h1>
				<?php }?>
				<p class="info"><?php echo $_smarty_tpl->tpl_vars['message_detail']->value;?>
</p>
				<h2>返回 <a href="<?php echo @constant('ADMIN_URL');?>
<?php echo $_smarty_tpl->tpl_vars['forward_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['forward_title']->value;?>
</a></h2>
			</div>
	<div>	
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<?php }} ?>
