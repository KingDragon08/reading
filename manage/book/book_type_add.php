<?php
require ('../include/init.inc.php');
$type_name = '';
extract ( $_POST, EXTR_IF_EXISTS );

if (Common::isPost ()) {
	$exist = BookType::getTypeByName($type_name);
    // var_dump($exist);
	if($exist){

		OSAdmin::alert("error",ErrorMessage::NAME_CONFLICT);
	}else if($type_name ==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('name' => $type_name);
		$type_id = BookType::addType ( $input_data );

		if ($type_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'booktype' ,$type_id, json_encode($input_data) );
			Common::exitWithSuccess ('图书类型添加成功','book/book_type.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}
Template::assign("_POST" ,$_POST);
Template::display ( 'book/book_type_add.tpl' );
