<?php /* Smarty version Smarty-3.1.15, created on 2017-03-25 21:55:32
         compiled from "/var/www/html/reading/manage/include/template/sample/sample.tpl" */ ?>
<?php /*%%SmartyHeaderCode:127809554358d676d429eaf8-67147572%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07acb7b3b446180d47f63ef05c50efc79cf59535' => 
    array (
      0 => '/var/www/html/reading/manage/include/template/sample/sample.tpl',
      1 => 1490448094,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '127809554358d676d429eaf8-67147572',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'samples' => 0,
    'sample' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_58d676d42a9a70_17801182',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d676d42a9a70_17801182')) {function content_58d676d42a9a70_17801182($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("navibar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="block">
	<a href="#page-stats" class="block-heading" data-toggle="collapse">图表</a>
	<div id="page-stats" class="block-body collapse in">
	<table class="table table-striped">
			<thead>
			<tr>
				<th>#</th>
				<th>所有者</th>
			</tr>
			</thead>
			<tbody>
			<?php  $_smarty_tpl->tpl_vars['sample'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sample']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['samples']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sample']->key => $_smarty_tpl->tpl_vars['sample']->value) {
$_smarty_tpl->tpl_vars['sample']->_loop = true;
?>
				<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['sample']->value['sample_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['sample']->value['sample_content'];?>
</td>
				</tr>
			<?php } ?>
		  </tbody>
		</table>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
