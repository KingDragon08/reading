<?php
require ('../include/init.inc.php');
$grade_id = $grade_name = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

Common::checkParam($grade_id);
$grade = Grade::getGradeById ( $grade_id );
// var_dump(urlencode($grade['name']));
// exit();
if(empty($grade)){
	Common::exitWithError('年级不存在',"user/grade.php");
}
if (Common::isPost ()) {

	if($grade_name =="" || (emtpy($grade_id)) ){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{

        // echo "string";
		$update_data = array ('grade_name' => $grade_name);

		$result = Grade::updateGrade ( $grade_id, $update_data );
        // var_dump($result);

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'Grade' , $grade_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','user/grade.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

Template::assign ( 'grade', $grade );
Template::display ( 'user/grade_modify.tpl' );
