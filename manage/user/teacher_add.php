<?php
require ('../include/init.inc.php');
$sex = $teacher_name = $real_name = $mobile = $password  = $sex = $grade_id = $class_id = $school_id = '';
extract ( $_POST, EXTR_IF_EXISTS );
if (Common::isPost ()) {
	var_dump($_POST);

	$exist = Teacher::getTeacherByName($teacher_name);
	if($exist){

		OSAdmin::alert("error",ErrorMessage::NAME_CONFLICT);
	}else if($password=="" || $real_name=="" || $mobile =="" || $teacher_name ==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('username' => $teacher_name,
							'password' => md5 ( $password ),
							'name' => $real_name,
							'mobile' => $mobile,
							'sex' => $sex,
							'grade' => $grade_id,
							'school' => $school_id,
							'class' => $class_id,
							'role' => '2',
							'addtime' => time(),
						);
		$user_id = Teacher::addTeacher ( $input_data );

		if ($user_id) {
			$input_data['password']="";
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'User' ,$user_id, json_encode($input_data) );
			Common::exitWithSuccess ('账号添加成功','user/teacher.php');
		}else{
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

Template::assign("_POST" ,$_POST);
Template::display ( 'user/teacher_add.tpl' );
