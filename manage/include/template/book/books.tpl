<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>

<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="btn-toolbar" style="margin-bottom:2px;">
    <!-- <a href="/manage/user/read_excel.php?type=book" class="btn btn-primary">批量添加图书</a> -->
    <a href="book_add.php" class="btn btn-primary"><i class="icon-plus"></i> 图书</a>
	<a data-toggle="collapse" data-target="#search"  href="#" title= "检索"><button class="btn btn-primary" style="margin-left:5px"><i class="icon-search"></i></button></a>
</div>
<{if $_GET.search }>
<div id="search" class="collapse in">
<{else }>
<div id="search" class="collapse out" >
<{/if }>
<form class="form_search"  action="" method="GET" style="margin-bottom:0px">
    <div style="float:left;margin-right:5px">
        <label>选择图书类型</label>
        <{html_options name=type_id id="DropDownTimezone" class="input-xlarge" options=$type_options selected=$_GET.type_id}>
    </div>
    <div style="float:left;margin-right:5px">
        <label>选择图书学段</label>
        <{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=$_GET.grade_id}>
    </div>
    <div style="float:left;margin-right:5px">
        <label>出版社名称</label>
        <input type="text" name="press" value="<{$_GET.press}>" placeholder="输入出版社名称" >
    </div>
    <div style="float:left;margin-right:5px">
        <label>作者姓名</label>
        <input type="text" name="author" value="<{$_GET.author}>" placeholder="输入作者姓名" >
    </div>
    <div style="float:left;margin-right:5px">
        <label>图书名称</label>
        <input type="text" name="book_name" value="<{$_GET.book_name}>" placeholder="输入图书名称" >
    </div>
	<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
        <input type="hidden" name="search" value="1" >
		<button type="submit" class="btn btn-primary">检索</button>
	</div>
	<div style="clear:both;"></div>
</form>
</div>
    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">图书列表</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:20px">#</th>
					<th style="width:80px">封面</th>
					<th style="width:60px">名称</th>
					<th style="width:60px">作者</th>
					<th style="width:120px">出版社</th>
					<th style="width:80px">出版时间</th>
                    <th style="width:100px">图书类型</th>
                    <th style="width:100px">学段</th>
					<th style="width:80px">难度</th>
					<th style="width:80px">积分</th>
					<th style="width:80px">字数</th>
					<th style="width:100px">描述</th>
					<th style="width:80px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=book from=$book_infos item=book_info}>
					<tr style="text-align:center">
					<td><{$book_info.id}></td>
					<td><img src="<{$book_info.coverimg}>" alt="" height="80px"/></td>
					<td><{$book_info.name}></td>
					<td><{$book_info.author}></td>
					<td><{$book_info.press}></td>
					<td><{$book_info.presstime}></td>
					<td><{$book_info.type_name}></td>
					<td><{$book_info.grade_name}></td>
					<td><{$book_info.level}></td>
					<td><{$book_info.score}></td>
					<td><{$book_info.wordcount}></td>
					<td><{$book_info.short_desc}></td>
					<td>
                    <a href="/reading/manage/list/booklist.php?book_id=<{$book_info.id}>&type=addbook" title="添加到书单"><i class="icon-plus"></i></a>
					&nbsp;
					<a href="book_modify.php?book_id=<{$book_info.id}>" title= "修改" ><i class="icon-pencil"></i></a>
					&nbsp;
					<a data-toggle="modal" href="#myModal" title= "删除" ><i class="icon-remove" href="books.php?page_no=<{$page_no}>&method=del&book_id=<{$book_info.id}>" ></i></a>
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
