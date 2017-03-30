<?php
require ('../include/init.inc.php');
$question = $book_id = '';
extract ( $_POST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
if (Common::isPost ()) {
	if($book_id=="" || $question==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('book_id' => $book_id,
							'question' => $question,
							'addtime' => time(),
						 );
		//  var_dump($input_data);
		$info_id = Objques::addInfo ( $input_data );

		if ($info_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'question' ,$info_id, json_encode($input_data) );
			Common::exitWithSuccess ('测试题添加成功','book/objques.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}

$book_options=Book::getInfoForOptions();

Template::assign("_POST" ,$_POST);
Template::assign ( 'book_options', $book_options );
Template::display ( 'book/objques_add.tpl' );
