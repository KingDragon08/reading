<?php
require ('../include/init.inc.php');
$ques_id = $question = $book_id = $choice1 = $choice2 = $choice3 = $choice4 = $answer  = $view = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
Common::checkParam($ques_id);
$info = Question::getInfoById ( $ques_id );
// var_dump($book);
if(empty($info)){
	Common::exitWithError(ErrorMessage::USER_NOT_EXIST,"book/question.php");
}
if (Common::isPost ()) {
	if($question=="" || $book_id==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$update_data = array('book_id' => $book_id,
							'question' => $question,
							'choice1' => $choice1,
							'choice2' => $choice2,
							'choice3' => $choice3,
							'choice4' => $choice4,
							'answer' => $answer,
							'view' => $view,
						 );

		$result = Question::updateInfo ( $ques_id,$update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'question' , $ques_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','book/question.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

$choice_options = Question::getChoiceForOptions();
$view_options = Question::getViewForOptions();
$book_options=Book::getInfoForOptions();


Template::assign("_POST" ,$_POST);
Template::assign ( 'choice_options', $choice_options );
Template::assign ( 'view_options', $view_options );
Template::assign ( 'book_options', $book_options );
Template::assign ( 'info', $info );
Template::display ( 'book/question_modify.tpl' );
