<?php
require ('../include/init.inc.php');
$class_name = $school_id = $teacher_id = $grade_id = '';
extract ( $_POST, EXTR_IF_EXISTS );

if (Common::isPost ()) {
	if($class_name == "" || $grade_id =="" || $teacher_id =="" || $grade_id ==""){

		OSAdmin::alert("error",ErrorMessage::NEED_PARAM);
	}else{
		$input_data = array ('classname' => $class_name, 'school' => $school_id, 'teacher_id' => $teacher_id, 'grade' => $grade_id, 'addtime' => time());
		$banji_id = Banji::addBanji ( $input_data );

		if ($banji_id) {
			SysLog::addLog ( UserSession::getUserName(), 'ADD', 'Banji' ,$banji_id, json_encode($input_data) );
			Common::exitWithSuccess ('班级添加成功','user/banji.php');
		}else{
			OSAdmin::alert("error");
		}
	}
}
$school_options = School::getSchoolForOptions();
$grade_options = Grade::getGradeForOptions();
$teacher_options = Teacher::getTeacherForOptions();


Template::assign("_POST" ,$_POST);
Template::assign ( 'school_options', $school_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'grade_options', $grade_options );
Template::display ( 'panel/user_add.tpl' );
