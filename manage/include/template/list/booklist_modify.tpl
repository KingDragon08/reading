<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">修改书单信息</a></li>
    </ul>

	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="" autocomplete="off">
               <label>创建教师</label>
               <input type="text" name="user_name" value="<{$info.user_name}>" class="input-xlarge" autofocus="true" required="true" readonly="true">
               <label>书单名称</label>
               <input type="text" name="item_name" value="<{$info.name}>" class="input-xlarge" autofocus="true" required="true" >
               <label>书单类型</label>
               <{html_options name=type_id id="DropDownTimezone" class="input-xlarge" options=$type_options selected=$info.type}>
               <label>书单学段</label>
               <{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=$info.grade}>
               <label>创建时间</label>
               <input type="date" name="addtime" value="<{$info.addtime}>" class="input-xlarge" autofocus="true" required="true" readonly="true">
               <label>截止时间</label>
               <input type="date" name="endtime" value="<{$info.endtime}>" class="input-xlarge" autofocus="true" required="true" >
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
