<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写班级资料</a></li>
    </ul>

	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="" autocomplete="off">
				<label>班级名称</label>
				<input type="text" name="class_name" value="<{$_POST.classname}>" class="input-xlarge" autofocus="true" required="true" >
                <label>学校名称</label>
				<{html_options name=school_id id="DropDownTimezone" class="input-xlarge" options=$school_options selected=0}>
                <label>年级名称</label>
				<{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=0}>
                <label>教师名称</label>
				<{html_options name=teacher_id id="DropDownTimezone" class="input-xlarge" options=$teacher_options selected=0}>
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
