<?php
require ('../include/init.inc.php');
$school_name = '';
extract ( $_POST, EXTR_IF_EXISTS );

if (Common::isPost ()) {
	$exist = School::getSchoolByName($school_name);
    var_dump($exist);
	if($exist){

		OSAdmin::alert("error",ErrorMessage::NAME_CONFLICT);
	}else if($school_name ==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('schoolname' => $school_name);
		$school_id = School::addSchool ( $input_data );

		if ($school_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'School' ,$school_id, json_encode($input_data) );
			Common::exitWithSuccess ('账号添加成功','user/school.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}
Template::assign("_POST" ,$_POST);
Template::display ( 'user/school_add.tpl' );
