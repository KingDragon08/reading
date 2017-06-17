<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>

<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="btn-toolbar" style="margin-bottom:2px;">
    <a href="/manage/user/read_excel.php?type=objques" class="btn btn-primary">批量添加客观题</a>
    <a href="question_add.php" class="btn btn-primary"><i class="icon-plus"></i> 测试题</a>
	<a data-toggle="collapse" data-target="#search"  href="#" title= "检索"><button class="btn btn-primary" style="margin-left:5px"><i class="icon-search"></i></button></a>
</div>
<{if $_GET.search }>
<div id="search" class="collapse in">
<{else }>
<div id="search" class="collapse out" >
<{/if }>
<form class="form_search"  action="" method="GET" style="margin-bottom:0px">
	<div style="float:left;margin-right:5px">
		<label>选择图书</label>
		<{html_options name=book_id id="DropDownTimezone" class="input-xlarge" options=$book_options selected=$_GET.book_id}>
	</div>
	<div style="float:left;margin-right:5px">
		<label>查询所有题目请留空</label>
		<input type="text" name="questiond" value="<{$_GET.question}>" placeholder="输入问题" >
		<input type="hidden" name="search" value="1" >
	</div>
	<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
		<button type="submit" class="btn btn-primary">检索</button>
	</div>
	<div style="clear:both;"></div>
</form>
</div>
    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">测试题列表</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:20px">#</th>
					<th style="width:80px">图书名称</th>
					<th style="width:100px">测试题</th>
					<th style="width:100px">选项一</th>
					<th style="width:100px">选项二</th>
					<th style="width:100px">选项三</th>
                    <th style="width:100px">选项四</th>
                    <th style="width:80px">答案</th>
					<th style="width:80px">考察能力</th>
					<th style="width:40px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=ques from=$question_infos item=question_info}>
					<tr style="text-align:center">
					<td><{$question_info.id}></td>
					<td><{$question_info.book_name}></td>
					<td><{$question_info.question}></td>
					<td><{$question_info.choice1}></td>
					<td><{$question_info.choice2}></td>
					<td><{$question_info.choice3}></td>
					<td><{$question_info.choice4}></td>
					<td><{$question_info.answer}></td>
					<td><{$question_info.view_name}></td>
					<td>
					<a href="question_modify.php?ques_id=<{$question_info.id}>" title= "修改" ><i class="icon-pencil"></i></a>
					&nbsp;
					<a data-toggle="modal" href="#myModal" title= "删除" ><i class="icon-remove" href="question.php?page_no=<{$page_no}>&method=del&ques_id=<{$question_info.id}>" ></i></a>
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
