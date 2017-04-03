<?php
require ('../include/init.inc.php');
$item_name = $type_id = $grade_id = $endtime = $addtime = '';
extract ( $_POST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
if (Common::isPost ()) {
	if($type_id=="" || $item_name==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('user_id' => '0',//系统管理员
							'type' => $type_id,
							'endtime' => strtotime($endtime),
							'addtime' => strtotime($addtime),
							'grade' => $grade_id,
							'name' => $item_name,
						 );
		//  var_dump($input_data);
		$info_id = BookList::addInfo ( $input_data );

		if ($info_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'booklist' ,$info_id, json_encode($input_data) );
			Common::exitWithSuccess ('书单添加成功','list/booklist.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}

$currenttime = date('Y-m-d', time());
$nextweek = date('Y-m-d', strtotime('1 week'));
$user_name = '系统管理员';

$type_options = ListType::getInfoForOptions();
$grade_options = Grade::getGradeForOptions();

Template::assign("_POST" ,$_POST);
Template::assign ( 'type_options', $type_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'currenttime', $currenttime );
Template::assign ( 'nextweek', $nextweek );
Template::assign ( 'user_name', $user_name );
Template::display ( 'list/booklist_add.tpl' );
