<?php
require ('../include/init.inc.php');
$method = $book_id = $page_no = $search = '';
$book_name = $author = $press = $grade_id = $type_id = '';

extract ( $_REQUEST, EXTR_IF_EXISTS );

if ($method == 'del' && ! empty ( $book_id )) {
	$result = Book::delBook ( $book_id );
	if ($result>=0) {
		$user['password']=null;
		SysLog::addLog ( UserSession::getUserName(), 'DELETE',  'Book' ,$book_id ,'' );
		Common::exitWithSuccess ( '已删除','book/books.php' );
	}else{
		OSAdmin::alert("error");
	}
}

//START 数据库查询及分页数据
// $page_size = PAGE_SIZE;
$page_size = 10;
$page_no=$page_no<1?1:$page_no;

if($search){
	$where = ' where 1=1';
	if ($book_name != '') {
		$where .= " and name like '%$book_name%'";
	}
	if ($author != '') {
		$where .= " and author like '%$author%'";
	}
	if ($press != '') {
		$where .= " and press like '%$press%'";
	}
	if ($grade_id > 0) {
		$where .= " and grade = '$grade_id'";
	}
	if ($type_id > 0) {
		$where .= " and type = '$type_id'";
	}
	$row_count = Book::countSearch($where);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$book_infos = Book::search($where, $start , $page_size);
}else{
	$row_count = Book::count ();
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$book_infos = Book::getAllBooks ( $start , $page_size );
}

$page_html=Pagination::showPager("books.php?user_group=$user_group&book_name=$book_name&search=$search",$page_no,$page_size,$row_count);

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

// 设置模板变量

$type_options = BookType::getGroupForOptions();
$type_options[0] = '全部';
ksort($type_options);
$grade_options = Grade::getGradeForOptions();
$grade_options[0] = '全部';
ksort($grade_options);

Template::assign ( 'type_options', $type_options );
Template::assign ( 'grade_options', $grade_options );

Template::assign ( 'group_options', $group_options );
Template::assign ( 'book_infos', $book_infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'book/books.tpl' );
