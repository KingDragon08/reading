<?php
require ('../include/init.inc.php');
$school_id = $school_name = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

Common::checkParam($school_id);
$school = School::getSchoolById ( $school_id );
if(empty($school)){
	Common::exitWithError('学校不存在',"user/school.php");
}
if (Common::isPost ()) {

	if($school_name =="" || (empty($school_id)) ){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{

		$update_data = array ('schoolname' => $school_name);

		$result = School::updateSchool ( $school_id, $update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'School' , $school_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','user/school.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

Template::assign ( 'school', $school );
Template::display ( 'user/school_modify.tpl' );
