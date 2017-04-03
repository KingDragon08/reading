<?php
require ('../include/init.inc.php');
$list_id = $item_id = $method = $page_no = $search = '';
$book_name = $author = $press = $grade_id = $type_id = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($list_id);
if ($method == 'del' && ! empty ( $item_id )) {
	$result = ListBook::delBook ($item_id);
	if ($result>=0) {
		SysLog::addLog ( UserSession::getUserName(), 'DELETE',  'listbook' ,$item_id ,'' );
		Common::exitWithSuccess ( '已删除',"list/viewlist.php?page_no=$page_no&list_id=$list_id" );
	}else{
		OSAdmin::alert("error");
	}
}

//START 数据库查询及分页数据
// $page_size = PAGE_SIZE;
$page_size = 10;
$page_no=$page_no<1?1:$page_no;

if($search){
	$row_count = User::countSearch($book_name, $author, $press, $grade_id, $type_id);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$user_infos = User::search($user_group,$user_name,$start , $page_size);

}else{
	$condition = array('list_id' => $list_id);
	$row_count = ListBook::count ($condition);
	// var_dump($row_count);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$book_infos = ListBook::getAllBooks ($list_id, $start , $page_size );
	// var_dump($book_infos);
}

$page_html=Pagination::showPager("viewlist.php?list_id=$list_id&search=$search",$page_no,$page_size,$row_count);

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

Template::assign ( 'list_id', $list_id );
Template::assign ( 'book_infos', $book_infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'list/viewlist.tpl' );
