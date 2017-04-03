<?php
require ('../include/init.inc.php');
$ques_id = $question = $book_id = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
Common::checkParam($ques_id);
$info = Objques::getInfoById ( $ques_id );
// var_dump($book);
if(empty($info)){
	Common::exitWithError(ErrorMessage::USER_NOT_EXIST,"book/objques.php");
}
if (Common::isPost ()) {
	if($question=="" || $book_id==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$update_data = array('book_id' => $book_id,
							'question' => $question,
						 );

		$result = Objques::updateInfo ( $ques_id,$update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'question' , $ques_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','book/objques.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

$book_options=Book::getInfoForOptions();


Template::assign("_POST" ,$_POST);
Template::assign ( 'book_options', $book_options );
Template::assign ( 'info', $info );
Template::display ( 'book/objques_modify.tpl' );
