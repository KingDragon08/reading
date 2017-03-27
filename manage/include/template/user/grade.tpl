<{include file ="header.tpl"}>
<{include file ="navibar.tpl"}>
<{include file ="sidebar.tpl"}>

<!--- START 以上内容不需更改，保证该TPL页内的标签匹配即可 --->

<{$osadmin_action_alert}>
<{$osadmin_quick_note}>

<div class="btn-toolbar" style="margin-bottom:2px;">
    <a href="grade_add.php" class="btn btn-primary"><i class="icon-plus"></i> 年级</a>
	<!-- <a data-toggle="collapse" data-target="#search"  href="#" title= "检索"><button class="btn btn-primary" style="margin-left:5px"><i class="icon-search"></i></button></a> -->
</div>
</div>
    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">账号列表</a>
        <div id="page-stats" class="block-body collapse in">
               <table class="table table-striped">
              <thead>
                <tr>
					<th style="width:20px">#</th>
					<th style="width:80px">年级名称</th>
					<th style="width:80px">操作</th>
                </tr>
              </thead>
              <tbody>
                <{foreach name=sch from=$grades item=grade}>
					<tr>
					<td><{$grade.id}></td>
					<td><{$grade.grade_name}></td>
					<td>
					<a href="grade_modify.php?grade_id=<{$grade.id}>" title= "修改" ><i class="icon-pencil"></i></a>
					&nbsp;
					<a data-toggle="modal" href="#myModal" title= "删除" ><i class="icon-remove" href="grade.php?page_no=<{$page_no}>&method=del&grade_id=<{$grade.id}>" ></i></a>
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
