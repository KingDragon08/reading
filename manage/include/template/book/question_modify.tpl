<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>
<!-- START 以上内容不需更改，保证该TPL页内的标签匹配即可 -->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">请填写图书测试题</a></li>
    </ul>

	<div id="myTabContent" class="tab-content">
		  <div class="tab-pane active in" id="home">

           <form id="tab" method="post" action="" autocomplete="off">
               <label>图书名称</label>
               <{html_options name=book_id id="DropDownTimezone" class="input-xlarge" options=$book_options selected=$info.book_id}>
               <label>测试题</label>
               <textarea name="question" rows="3" class="input-xlarge" required="true"><{$info.question}></textarea>
               <label>选项一</label>
               <textarea name="choice1" rows="3" class="input-xlarge" required="true"><{$info.choice1}></textarea>
               <label>选项二</label>
               <textarea name="choice2" rows="3" class="input-xlarge" required="true"><{$info.choice2}></textarea>
               <label>选项三</label>
               <textarea name="choice3" rows="3" class="input-xlarge" required="true"><{$info.choice3}></textarea>
               <label>选项四</label>
               <textarea name="choice4" rows="3" class="input-xlarge" required="true"><{$info.choice4}></textarea>
              <label>答案选项</label>
               <{html_options name=answer id="DropDownTimezone" class="input-xlarge" options=$choice_options selected=$info.answer}>
              <label>考察能力</label>
               <{html_options name=view id="DropDownTimezone" class="input-xlarge" options=$view_options selected=$info.view}>
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
