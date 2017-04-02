<?php
require ('../include/init.inc.php');
$list_id = $book_id = $method = $page_no = $search = '';
$book_name = $author = $press = $grade_id = $type_id = '';

extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($_REQUEST);
// exit();
if ($method == 'add' && ! empty ( $book_id )&& ! empty ( $list_id )) {
	$exist = ListBook::getInfoByListBook($book_id, $list_id);
    // var_dump($exist);
	if($exist){

		// OSAdmin::alert("error",ErrorMessage::NAME_CONFLICT);
		Common::exitWithSuccess ('重复添加','list/viewlist.php?list_id='.$list_id);
		exit();
	}
	else {
		$input_data = array ('book_id' => $book_id,//系统管理员
							'list_id' => $list_id,
						 );
		//  var_dump($input_data);
		$info_id = ListBook::addBook ($input_data);

		if ($info_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'listbook' ,$info_id, json_encode($input_data) );
			Common::exitWithSuccess ('图书添加成功','list/viewlist.php?list_id='.$list_id);
		}else{
			OSAdmin::alert("error");
		}
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
	$where .= " and id not in (select book_id from rd_book_list where list_id = '$list_id')";
	$row_count = Book::countSearch($where);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$book_infos = Book::search($where, $start , $page_size);

}else{
	$row_count = Book::notinlistcount ($list_id);
	// var_dump($row_count);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$book_infos = Book::getNotinListBooks ($list_id, $start , $page_size );
	// var_dump($book_infos);
}

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

$page_html=Pagination::showPager("listbook.php?list_id=$list_id&search=$search",$page_no,$page_size,$row_count);


$type_options = BookType::getGroupForOptions();
$type_options[0] = '全部';
ksort($type_options);
$grade_options = Grade::getGradeForOptions();
$grade_options[0] = '全部';
ksort($grade_options);

Template::assign ( 'type_options', $type_options );
Template::assign ( 'grade_options', $grade_options );

Template::assign ( 'type', 'listbook_add' );
Template::assign ( 'list_id', $list_id );
Template::assign ( 'book_infos', $book_infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'list/viewlist.tpl' );
