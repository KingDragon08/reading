<?php
require ('../include/init.inc.php');
$method = $ques_id = $question = $book_id = $page_no = $search = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

if ($method == 'del' && ! empty ( $ques_id )) {
	$result = Question::delInfo ( $ques_id );
	if ($result>=0) {
		SysLog::addLog ( UserSession::getUserName(), 'DELETE',  'question' ,$ques_id ,'' );
		Common::exitWithSuccess ( '已删除','book/question.php' );
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
	$row_count = Question::count ();
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$question_infos = Question::getAllInfos ( $start , $page_size );
}

$page_html=Pagination::showPager("question.php?book_id=$book_id&question=$question&search=$search",$page_no,$page_size,$row_count);

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

// 设置模板变量
$book_options=Book::getInfoForOptions();
$book_options[0] = "全部";
ksort($book_options);

Template::assign ( 'book_options', $book_options );
Template::assign ( 'question_infos', $question_infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'book/question.tpl' );
