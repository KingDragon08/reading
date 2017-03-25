<?php /* Smarty version Smarty-3.1.15, created on 2017-03-25 21:49:36
         compiled from "/var/www/html/reading/manage/include/template/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150973248458d671f5e64764-13999979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92e0b33430e191b1079ed8daf44e005197d9783b' => 
    array (
      0 => '/var/www/html/reading/manage/include/template/footer.tpl',
      1 => 1490449772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150973248458d671f5e64764-13999979',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_58d671f5e664a2_93863626',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d671f5e664a2_93863626')) {function content_58d671f5e664a2_93863626($_smarty_tpl) {?>					<footer style="text-align:center">
                        <hr>
                        <p >&copy; 2016 北京乐智起航文化发展有限公司</p>
                    </footer>
				</div>
			</div>
		</div>
    <script src="<?php echo @constant('ADMIN_URL');?>
/assets/lib/bootstrap/js/bootstrap.js"></script>

<!-- 捷径的提示 -->

		<script type="text/javascript">
			alertDismiss("alert-success", 3);
			alertDismiss("alert-info", 10);

			listenShortCut("icon-plus");
			listenShortCut("icon-minus");

			doSidebar();
		</script>
        <script type="text/javascript">
            console.log('author: moonsea');
        </script>
	</body>
</html>
<?php }} ?>
