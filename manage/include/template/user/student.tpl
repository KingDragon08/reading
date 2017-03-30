<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>

<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="btn-toolbar" style="margin-bottom:2px;">
    <a href="student_add.php" class="btn btn-primary"><i class="icon-plus"></i> 账号</a>
	<a data-toggle="collapse" data-target="#search"  href="#" title= "检索"><button class="btn btn-primary" style="margin-left:5px"><i class="icon-search"></i></button></a>
</div>
<{if $_GET.search }>
<div id="search" class="collapse in">
<{else }>
<div id="search" class="collapse out" >
<{/if }>
<form class="form_search"  action="" method="GET" style="margin-bottom:0px">
    <div style="float:left;margin-right:5px">
		<label>选择学校</label>
		<{html_options name=school_id id="DropDownTimezone" class="input-xlarge" options=$school_options selected=$_GET.school_id}>
	</div>
	<div style="float:left;margin-right:5px">
		<label>选择年级</label>
		<{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=$_GET.grade_id}>
	</div>
	<div style="float:left;margin-right:5px">
		<label>选择班级</label>
		<{html_options name=class_id id="DropDownTimezone" class="input-xlarge" options=$class_options selected=$_GET.class_id}>
	</div>
	<div style="float:left;margin-right:5px">
		<label>查询所有用户请留空</label>
		<input type="text" name="real_name" value="<{$_GET.name}>" placeholder="输入真实姓名" >
		<input type="hidden" name="search" value="1" >
	</div>
	<div class="btn-toolbar" style="padding-top:25px;padding-bottom:0px;margin-bottom:0px">
		<button type="submit" class="btn btn-primary">检索</button>
	</div>
	<div style="clear:both;"></div>
</form>
</div>
    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">账号列表</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:20px">#</th>
					<th style="width:80px">登录名</th>
					<th style="width:100px">姓名</th>
					<th style="width:100px">手机</th>
					<th style="width:80px">学校</th>
					<th style="width:80px">年级</th>
					<th style="width:80px">班级</th>
					<th style="width:80px">注册时间</th>
					<th style="width:80px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=user from=$student_infos item=user_info}>
					<tr>
					<td><{$user_info.id}></td>
					<td><{$user_info.username}></td>
					<td><{$user_info.name}></td>
					<td><{$user_info.mobile}></td>
					<td><{$user_info.school_name}></td>
					<td><{$user_info.grade_name}></td>
					<td><{$user_info.class_name}></td>
					<td><{$user_info.addtime}></td>
					<td>
					<a href="teacher_modify.php?user_id=<{$user_info.id}>&type=1" title= "修改" ><i class="icon-pencil"></i></a>
					&nbsp;
					<a data-toggle="modal" href="#myModal" title= "删除" ><i class="icon-remove" href="student.php?page_no=<{$page_no}>&method=del&teacher_id=<{$user_info.id}>" ></i></a>
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
