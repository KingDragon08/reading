<?php
require ('../include/init.inc.php');
$item_id = $item_name = $type_id = $grade_id = $endtime = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($_POST);
// exit();
Common::checkParam($item_id);
$info = BookList::getInfoById ( $item_id );
// var_dump($info);
if(empty($info)){
	Common::exitWithError(ErrorMessage::USER_NOT_EXIST,"list/booklist.php");
}
if (Common::isPost ()) {
	if($item_name=="" || $item_id==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$update_data = array(
							'type' => $type_id,
							'endtime' => strtotime($endtime),
							'grade' => $grade_id,
							'name' => $item_name,
						 );
		$result = BookList::updateInfo ( $item_id,$update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'question' , $item_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','list/booklist.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

$type_options = ListType::getInfoForOptions();
$grade_options = Grade::getGradeForOptions();


Template::assign("_POST" ,$_POST);
Template::assign ( 'type_options', $type_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'info', $info );
Template::display ( 'list/booklist_modify.tpl' );
