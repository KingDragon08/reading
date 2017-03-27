<?php
require ('../include/init.inc.php');
$class_id = $class_name = $school_id = $teacher_id = $grade_id = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );
// var_dump($class_id);
Common::checkParam($class_id);
$banji = Banji::getBanjiById ( $class_id );

if(empty($banji)){
	Common::exitWithError('班级不存在',"user/banji.php");
}
if (Common::isPost ()) {

	if($class_name =="" || (empty($class_id)) ){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{

		$update_data = array ('classname' => $class_name, 'school' => $school_id, 'teacher_id' => $teacher_id, 'grade' => $grade_id);

		$result = Banji::updateBanji ( $class_id, $update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'banji' , $class_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成','user/banji.php');
		} else {

			OSAdmin::alert("error");
		}
	}
}

$school_options = School::getSchoolForOptions();
$grade_options = Grade::getGradeForOptions();
$teacher_options = Teacher::getTeacherForOptions();

Template::assign ( 'banji', $banji );
Template::assign ( 'school_options', $school_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'teacher_options', $teacher_options );
Template::display ( 'user/banji_modify.tpl' );
