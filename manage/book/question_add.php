<?php
require ('../include/init.inc.php');
$question = $book_id = $choice1 = $choice2 = $choice3 = $choice4 = $answer  = $view = '';
extract ( $_POST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
if (Common::isPost ()) {
	if($book_id=="" || $question==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('book_id' => intval($book_id),
							'question' => $question,
							'choice1' => $choice1,
							'choice2' => $choice2,
							'choice3' => $choice3,
							'choice4' => $choice4,
							'answer' => $answer,
							'view' => $view,
							'score' => '0',
							'addtime' => time(),
						 );
		//  var_dump($input_data);
		$info_id = Question::addInfo ( $input_data );

		if ($info_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'question' ,$info_id, json_encode($input_data) );
			Common::exitWithSuccess ('测试题添加成功','book/question.php');
		}else{
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
Template::display ( 'book/question_add.tpl' );
