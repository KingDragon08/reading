<?php /* Smarty version Smarty-3.1.15, created on 2017-03-25 22:08:27
         compiled from "/var/www/html/reading/manage/include/template/panel/menu_modify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22969230258d679db6c0641-97349678%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4057979047bf7a257b63ebdefe2963c3677ce7fb' => 
    array (
      0 => '/var/www/html/reading/manage/include/template/panel/menu_modify.tpl',
      1 => 1490448094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22969230258d679db6c0641-97349678',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'osadmin_action_alert' => 0,
    'osadmin_quick_note' => 0,
    'menu' => 0,
    'module_options_list' => 0,
    'show_options_list' => 0,
    'father_menu_options_list' => 0,
    'online_options_list' => 0,
    'shortcut_allowed_options_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_58d679db6e3106_04607035',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d679db6e3106_04607035')) {function content_58d679db6e3106_04607035($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/var/www/html/reading/manage/include/config/../../include/lib/Smarty/plugins/function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<?php echo $_smarty_tpl->tpl_vars['osadmin_action_alert']->value;?>

<?php echo $_smarty_tpl->tpl_vars['osadmin_quick_note']->value;?>

    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写功能资料</a></li>
    </ul>	
	
	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="">
				<label>名称</label>
				<input type="text" name="menu_name" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_name'];?>
" class="input-xlarge" required="true">
				<label>链接 <span class="label label-important">不可重复</span></label>
				<input type="text" name="menu_url" value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_url'];?>
" class="input-xlarge" required="true" >
				
				<label>所属模块</label>
				<?php if ($_smarty_tpl->tpl_vars['menu']->value['menu_id']>100) {?>
				<?php echo smarty_function_html_options(array('name'=>'module_id','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['module_options_list']->value,'selected'=>$_smarty_tpl->tpl_vars['menu']->value['module_id']),$_smarty_tpl);?>

				<?php } else { ?>
				<?php echo smarty_function_html_options(array('name'=>'module_id','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['module_options_list']->value,'disabled'=>"true",'selected'=>$_smarty_tpl->tpl_vars['menu']->value['module_id']),$_smarty_tpl);?>

				<?php }?>
				<label>是否显示为左侧菜单</label>
				<?php echo smarty_function_html_options(array('name'=>'is_show','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['show_options_list']->value,'selected'=>$_smarty_tpl->tpl_vars['menu']->value['is_show']),$_smarty_tpl);?>

				<label>所属菜单</label>
				<?php echo smarty_function_html_options(array('name'=>'father_menu','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['father_menu_options_list']->value,'selected'=>$_smarty_tpl->tpl_vars['menu']->value['father_menu']),$_smarty_tpl);?>

				<label>是否有效</label>
				<?php echo smarty_function_html_options(array('name'=>'online','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['online_options_list']->value,'selected'=>$_smarty_tpl->tpl_vars['menu']->value['online']),$_smarty_tpl);?>
			 
				<label>是否允许快捷菜单 <span class="label label-important">修改/ 删除类链接不允许</span></label>
				<?php echo smarty_function_html_options(array('name'=>'shortcut_allowed','id'=>"DropDownTimezone",'class'=>"input-xlarge",'options'=>$_smarty_tpl->tpl_vars['shortcut_allowed_options_list']->value,'selected'=>$_smarty_tpl->tpl_vars['menu']->value['shortcut_allowed']),$_smarty_tpl);?>

				<label>描述</label>
				<textarea name="menu_desc" rows="3" class="input-xlarge"><?php echo $_smarty_tpl->tpl_vars['menu']->value['menu_desc'];?>
</textarea>
				<div class="btn-toolbar">
					<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				</div>
			</form>
        </div>
    </div>
</div>
<!-- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
