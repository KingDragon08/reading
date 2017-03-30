<?php
require ('../include/init.inc.php');
$method = $item_id = $page_no = $search = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

if ($method == 'del' && ! empty ( $item_id )) {
	$result = BookList::delInfo ( $item_id );
	if ($result) {
		SysLog::addLog ( UserSession::getUserName(), 'DELETE',  'question' ,$item_id ,'' );
		Common::exitWithSuccess ( '已删除','list/booklist.php' );
	}else{
		OSAdmin::alert("error");
	}
}

//START 数据库查询及分页数据
$page_size = PAGE_SIZE;
// $page_size = 10;
$page_no=$page_no<1?1:$page_no;

if($search){
	$row_count = Question::countSearch($book_id,$question);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$question_infos = Question::search($book_id,$question,$start , $page_size);

}else{
	// echo "string";
	$row_count = BookList::count();
	// var_dump($row_count);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$infos = BookList::getAllInfos ( $start , $page_size );
	// var_dump($infos);
}

$page_html=Pagination::showPager("booklist.php?search=$search",$page_no,$page_size,$row_count);

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

// 设置模板变量

Template::assign ( 'infos', $infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'list/booklist.tpl' );
