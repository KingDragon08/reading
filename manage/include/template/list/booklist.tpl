<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>

<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="btn-toolbar" style="margin-bottom:2px;">
    <{if $type != 'addbook'}>
    <a href="booklist_add.php" class="btn btn-primary"><i class="icon-plus"></i> 书单</a>
    <{/if}>
    <a data-toggle="collapse" data-target="#search"  href="#" title= "检索"><button class="btn btn-primary" style="margin-left:5px"><i class="icon-search"></i></button></a>
</div>
<{if $_GET.search }>
<div id="search" class="collapse in">
<{else }>
<div id="search" class="collapse out" >
<{/if }>
<form class="form_search"  action="" method="GET" style="margin-bottom:0px">
	<div style="float:left;margin-right:5px">
		<label>书单类型</label>
		<{html_options name=type_id id="DropDownTimezone" class="input-xlarge" options=$type_options selected=$_GET.type_id}>
	</div>
	<div style="float:left;margin-right:5px">
		<label>书单学段</label>
		<{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=$_GET.grade_id}>
	</div>
	<div style="float:left;margin-right:5px">
		<label>书单名称</label>
		<input type="text" name="list_name" value="<{$_GET.question}>" placeholder="输入书单名称" >
	</div>
	<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
        <input type="hidden" name="search" value="1" >
        <input type="hidden" name="type" value="<{$type}>" >
        <input type="hidden" name="book_id" value="<{$book_id}>" >
		<button type="submit" class="btn btn-primary">检索</button>
	</div>
	<div style="clear:both;"></div>
</form>
</div>
    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">书单列表</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:20px">#</th>
					<th style="width:80px">书单名称</th>
					<th style="width:80px">书单类型</th>
					<th style="width:80px">书单学段</th>
					<th style="width:80px">创建教师</th>
					<th style="width:80px">创建时间</th>
					<th style="width:80px">截止时间</th>
					<th style="width:40px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=info from=$infos item=info}>
					<tr style="text-align:center">
					<td><{$info.id}></td>
					<td><{$info.name}></td>
					<td><{$info.type_name}></td>
					<td><{$info.grade_name}></td>
					<td><{$info.user_name}></td>
					<td><{$info.addtime}></td>
					<td><{$info.endtime}></td>
					<td>
                    <{if $type == 'addbook'}>
                    <a href="listbook_add.php?page_no=<{$page_no}>&method=add&list_id=<{$info.id}>&book_id=<{$book_id}>" title= "添加" ><i class="icon-plus" href="list/listbook_add.php?page_no=<{$page_no}>&method=add&book_id=<{$book_info.id}>&list_id=<{$list_id}>" ></i></a>
                    <{else}>
					<a href="viewlist.php?list_id=<{$info.id}>" title= "查看图书" ><i class="icon-book"></i></a>
					&nbsp;
					<a href="booklist_modify.php?item_id=<{$info.id}>" title= "修改" ><i class="icon-pencil"></i></a>
					&nbsp;
					<a data-toggle="modal" href="#myModal" title= "删除" ><i class="icon-remove" href="booklist.php?page_no=<{$page_no}>&method=del&item_id=<{$info.id}>" ></i></a>
                    <{/if}>
					</td>
					</tr>
				<{/foreach}>
              </tbody>
            </table>
				<!--- START 分页模板 --->

               <{$page_html}>

			   <!--- END --->
        </div>
    </div>

<!---操作的确认层，相当于javascript:confirm函数--->
<{$osadmin_action_confirm}>

<!--- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 --->
<{include file="footer.tpl" }>
