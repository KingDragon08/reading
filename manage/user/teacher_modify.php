<?php
require ('../include/init.inc.php');
$type = $user_id = $user_name = $real_name = $mobile = $password = $sex = $school_id = $grade_id = $class_id = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

Common::checkParam($user_id);
$user = Teacher::getTeacherById ( $user_id, $type );
// var_dump($user);
$target = ($type == '2')? 'user/teacher.php':'user/student.php';
if(empty($user)){
	Common::exitWithError(ErrorMessage::USER_NOT_EXIST, $target);
}
if (Common::isPost ()) {

	if($real_name=="" || $mobile =="" || $user_name =="" || (empty($user_id)) ){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{

		$update_data = array ('name' => $real_name,
		 					'mobile' => $mobile,
		 					'username' => $user_name,
							'sex' => $sex,
							'school_id' => $school_id,
							'grade_id' => $grade_id,
							'class_id' => $class_id,
						 );

		if (! empty ( $password )) {
			$update_data = array_merge ( $update_data, array ('password' => md5 ( $password ) ) );
		}

		$result = Teacher::updateUser ( $user_id,$update_data );

		if ($result>=0) {
			$current_user=UserSession::getSessionInfo();
			$ip = Common::getIp();
			$update_data['ip']=$ip;
			$update_data['password']= '';
			SysLog::addLog ( UserSession::getUserName(), 'MODIFY', 'User' , $user_id, json_encode($update_data) );
			Common::exitWithSuccess ('更新完成', $target);
		} else {

			OSAdmin::alert("error");
		}
	}
}

$school_options = School::getSchoolForOptions();
$grade_options = Grade::getGradeForOptions();
$class_options = Banji::getBanjiForOptions();

Template::assign ( 'school_options', $school_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'class_options', $class_options );


Template::assign ( 'user', $user );
Template::display ( 'user/teacher_modify.tpl' );
