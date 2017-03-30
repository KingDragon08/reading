<?php
require ('../include/init.inc.php');
$grade_name = '';
extract ( $_POST, EXTR_IF_EXISTS );

if (Common::isPost ()) {
	$exist = Grade::getGradeByName($grade_name);
    // var_dump($exist);
	if($exist){

		OSAdmin::alert("error",ErrorMessage::NAME_CONFLICT);
	}else if($grade_name ==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('grade_name' => $grade_name);
		$grade_id = Grade::addGrade ( $input_data );

		if ($grade_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'Grade' ,$grade_id, json_encode($input_data) );
			Common::exitWithSuccess ('年级添加成功','user/grade.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}
Template::assign("_POST" ,$_POST);
Template::display ( 'user/grade_add.tpl' );
