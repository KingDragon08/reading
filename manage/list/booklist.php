<?php
require ('../include/init.inc.php');
$method = $item_id = $page_no = $search = '';
$book_id = $type = '';
$type_id = $grade_id = $list_name = '';
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
	$where = "where 1=1";
	if ($type_id > 0) {
		$where .= " and type = '$type_id'";
	}
	if ($grade_id > 0) {
		$where .= " and grade = '$grade_id'";
	}
	if ($list_name != '') {
		$where .= " and like '%$list_name%'";
	}

	if (!empty($type) && !empty($book_id)) {
		$where .= " and id not in ";
		$where .= "(select list_id from rd_book_list where book_id = '$book_id')";
	}
	// var_dump($where);
	$row_count = BookList::countSearch($where);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$infos = BookList::search($where, $start , $page_size);

}else{
	// echo "string";

	$row_count = empty($book_id)? BookList::count():BookList::booknotincout($book_id);
	// var_dump($row_count);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$infos = BookList::getAllInfos ( $start , $page_size, $book_id );
	// var_dump($infos);
}

$page_html=Pagination::showPager("booklist.php?search=$search",$page_no,$page_size,$row_count);

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

// 设置模板变量

Template::assign ( 'type', $type );
Template::assign ( 'book_id', $book_id );

$grade_options = Grade::getGradeForOptions();
$grade_options[0] = '全部';
ksort($grade_options);
$type_options = ListType::getInfoForOptions();
$type_options[0] = '全部';
ksort($type_options);

Template::assign ( 'type_options', $type_options );
Template::assign ( 'grade_options', $grade_options );

Template::assign ( 'infos', $infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'list/booklist.tpl' );
