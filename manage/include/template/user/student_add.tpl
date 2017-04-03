<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写账号资料</a></li>
    </ul>

	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="" autocomplete="off">
				<label>登录名</label>
				<input type="text" name="teacher_name" value="<{$_POST.username}>" class="input-xlarge" autofocus="true" required="true" >
				<label>密码</label>
				<input type="password" name="password" value="<{$_POST.password}>" class="input-xlarge" required="true" >
				<label>姓名</label>
				<input type="text" name="real_name" value="<{$_POST.name}>" class="input-xlarge" required="true" >
				<label>手机</label>
				<input type="text" name="mobile" value="<{$_POST.mobile}>" class="input-xlarge" required pattern="\d{11}">
				<label>性别</label>
				男&nbsp;<input type="radio" name="sex" value="1"  class="input-xlarge" <{if $_POST.sex != '2'}>checked<{/if}> />&nbsp;&nbsp;
				女&nbsp;<input type="radio" name="sex" value="2"  class="input-xlarge" <{if $_POST.sex == '2'}>checked<{/if}> />
				<label>学校</label>
				<{html_options name=school_id id="DropDownTimezone" class="input-xlarge" options=$school_options selected=0}>
				<label>年级</label>
				<{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=0}>
				<label>班级</label>
				<{html_options name=class_id id="DropDownTimezone" class="input-xlarge" options=$class_options selected=0}>
			<div class="btn-toolbar">
				<button type="submit" class="btn btn-primary"><strong>提交</strong></button>
				<div class="btn-group"></div>
			</div>
			</form>
        </div>
    </div>
</div>
<!-- END 以下内容不需更改，请保证该TPL页内的标签匹配即可 -->
<{include file="footer.tpl" }>
