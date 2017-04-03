<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写图书资料</a></li>
    </ul>

	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="" autocomplete="off" ENCTYPE="multipart/form-data">
				<label>图书封面</label>
                <input type="file" name="coverimg"  id="DropDownTimezone"  class="input-xlarge">
				<label>图书名称</label>
				<input type="text" name="book_name" value="<{$_POST.book_name}>" class="input-xlarge" autofocus="true" required="true" >
				<label>作者</label>
				<input type="text" name="author_name" value="<{$_POST.author_name}>" class="input-xlarge" autofocus="true" required="true" >
				<label>出版社</label>
				<input type="text" name="press" value="<{$_POST.press}>" class="input-xlarge" autofocus="true" required="true" >
				<label>出版时间</label>
				<input type="date" name="presstime" value="<{$_POST.presstime}>" class="input-xlarge" autofocus="true" required="true" >
				<label>图书类型</label>
				<{html_options name=book_type id="DropDownTimezone" class="input-xlarge" options=$book_type_options selected=0}>
				<label>学段</label>
				<{html_options name=grade_id id="DropDownTimezone" class="input-xlarge" options=$grade_options selected=0}>
				<label>难度</label>
				<input type="text" name="level" value="<{$_POST.level}>" class="input-xlarge" required pattern="\d+">
				<label>积分</label>
				<input type="text" name="score" value="<{$_POST.score}>" class="input-xlarge" required pattern="\d+">
				<label>字数</label>
				<input type="text" name="wordcount" value="<{$_POST.wordcount}>" class="input-xlarge" pattern="\d+">
				<label>描述</label>
				<textarea name="bookdesc" rows="3" class="input-xlarge"><{$_POST.bookdesc}></textarea>
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
