<?php
require ('../include/init.inc.php');
$school_id = $grade_id = $class_id = $teacher_id = $method = $teacher_name = $page_no = $search = '';
extract ( $_REQUEST, EXTR_IF_EXISTS );

if ($method == 'del' && ! empty ( $teacher_id )) {
	if($teacher_id == UserSession::getUserId()){
		OSAdmin::alert("error",ErrorMessage::CAN_NOT_DO_SELF);
	}else{
		$user = Teacher::getTeacherById($teacher_id);
		$result = Teacher::delTeacher ( $teacher_id );
		if ($result>=0) {
			$user['password']=null;
			SysLog::addLog ( UserSession::getUserName(), 'DELETE',  'student' ,$teacher_id ,json_encode($user) );
			Common::exitWithSuccess ( '已删除','user/student.php' );
		}else{
			OSAdmin::alert("error");
		}
	}
}

//START 数据库查询及分页数据
$page_size = PAGE_SIZE;
$page_no=$page_no<1?1:$page_no;

if($search){
	$row_count = Teacher::countSearch($school_id, $grade_id, $class_id, $real_name, '1');
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$student_infos = Teacher::search($school_id, $grade_id, $class_id, $real_name, '1');
}else{
	$condition = array('role=' => '1');
	$row_count = Teacher::count ($condition);
	$total_page=$row_count%$page_size==0?$row_count/$page_size:ceil($row_count/$page_size);
	$total_page=$total_page<1?1:$total_page;
	$page_no=$page_no>($total_page)?($total_page):$page_no;
	$start = ($page_no - 1) * $page_size;
	$student_infos = Teacher::getAllStudents ( $start , $page_size );
	// var_dump($teacher_infos);
}

$page_html=Pagination::showPager("student.php?school_id=$school_id&grade_id=$grade_id&class_id=$class_id&teacher_name=$teacher_name&search=$search",$page_no,$page_size,$row_count);

//追加操作的确认层
$confirm_html = OSAdmin::renderJsConfirm("icon-pause,icon-play,icon-remove");

// 设置模板变量
$school_options = School::getSchoolForOptions();
$school_options[0] = "全部";
$grade_options = Grade::getGradeForOptions();
$grade_options[0] = "全部";
$class_options = Banji::getBanjiForOptions();
$class_options[0] = "全部";

Template::assign ( 'school_options', $school_options );
Template::assign ( 'grade_options', $grade_options );
Template::assign ( 'class_options', $class_options );
Template::assign ( 'student_infos', $student_infos );
Template::assign ( '_GET', $_GET );
Template::assign ( 'page_no', $page_no );
Template::assign ( 'page_html', $page_html );
Template::assign ( 'osadmin_action_confirm' , $confirm_html);
Template::display ( 'user/student.tpl' );
