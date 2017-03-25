<?php /* Smarty version Smarty-3.1.15, created on 2017-03-25 23:14:01
         compiled from "/var/www/html/reading/manage/include/template/sample/read_excel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:113173244858d689396085d0-61520128%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '154c889d5d0ba906d9650e3d423ce7b13e38f968' => 
    array (
      0 => '/var/www/html/reading/manage/include/template/sample/read_excel.tpl',
      1 => 1490448094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113173244858d689396085d0-61520128',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_58d6893960e2d0_47704451',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d6893960e2d0_47704451')) {function content_58d6893960e2d0_47704451($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- TPLSTART 以上内容不需更改，保证该TPL页内的标签匹配即可 -->
<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">读取Excel.xls</a>
	<div id="page-stats" class="block-body collapse in">
	
	<form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<hr />
				<label>只限于xls文件</label>
				<input type="file" name="excel"  id="DropDownTimezone"  class="input-xlarge">
				 
				<div class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
				</div>
		</form>
		<pre>
		读取Excel.xls文件输出结果
		<?php echo $_smarty_tpl->tpl_vars['output']->value;?>

		</pre>
	</div>
</div>
<!-- TPLEND 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
