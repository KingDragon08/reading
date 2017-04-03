<?php
if(!defined('ACCESS')) {exit('Access denied.');}

class Teacher extends Base{
	// 表名
	private static $table_name = 'user';
	// 查询字段
	private static $columns = array('id', 'user_name', 'password', 'name', 'sex', 'mobile', 'grade', 'class', 'school', 'headimg', 'score', 'role', 'addtime', 'item1_score', 'item2_score', 'item3_score', 'item4_score', 'item5_score', 'chinese_score', 'list_id');
	//状态定义
	const ACTIVE = 1;
	const DEACTIVE = 0;
	public static function getTableName(){
		return parent::$table_prefix.self::$table_name;
	}


	public static function getAllTeachers( $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." where role = '2' order by id $limit";

		$list=$db->query($sql)->fetchAll();
		if(!empty($list)){
			foreach($list as &$item){
				$item['grade_name'] = Grade::getGradeById($item['grade'])['grade_name'];
				$item['class_name'] = Banji::getBanjiById($item['class'])['classname'];
				$item['school_name'] = School::getSchoolById($item['school'])['schoolname'];
				$item['addtime'] = date('Y-m-d', $item['addtime']);
			}
		}

		if ($list) {
			return $list;
		}
		return array ();
	}

	public static function getAllStudents( $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." where role = '1' order by id $limit";

		$list=$db->query($sql)->fetchAll();
		if(!empty($list)){
			foreach($list as &$item){
				$item['grade_name'] = Grade::getGradeById($item['grade'])['grade_name'];
				$item['class_name'] = Banji::getBanjiById($item['class'])['classname'];
				$item['school_name'] = School::getSchoolById($item['school'])['schoolname'];
				$item['addtime'] = date('Y-m-d', $item['addtime']);
			}
		}

		if ($list) {
			return $list;
		}
		return array ();
	}


	public static function getTeacherForOptions() {
		$option_list = self::getAllTeachers ();

		foreach ( $option_list as $option ) {
			$options_array [$option ['id']] = $option ['name'];
		}

		return $options_array;
	}



	/**
	 * 获取数据总数
	 * @param  string $condition [description]
	 * @return [type]            [description]
	 */
	public static function count($condition = '') {
		$db=self::__instance();
		$num = $db->count ( self::getTableName(), $condition );
		return $num;
	}


	public static function getTeacherById($user_id, $type = '2') {
		if (! $user_id || ! is_numeric ( $user_id )) {
			return false;
		}
		$db=self::__instance();
		// $condition = array("AND" =>
		// 				array("id[=]" => $user_id,
		// 					"role[=]" => $type,)
		// 			);
		// var_dump($condition);
		// $list = $db->select ( self::getTableName(), self::$columns, $condition );
		$sql = "select * from ".self::getTableName()." where role = '$type' and id = '$user_id'";
		// var_dump($sql);

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);

		if ($list) {
			// $list[0]['login_time']=Common::getDateTime($list[0]['login_time']);
			return $list [0];
		}
		return array ();
	}

	public static function delTeacher($user_id) {
		if (! $user_id || ! is_numeric ( $user_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$user_id);
		$result = $db->delete ( self::getTableName(), $condition );
		return $result;
	}

	public static function getTeacherByName($user_name) {
		$db=self::__instance();
		$sql= "select * from ".self::getTableName() ." where username='$user_name'";
		$list = $db->query($sql)->fetch();// self::getTableName(), self::$columns, $condition );
		if ($list) {
			// $list['login_time']=Common::getDateTime($list['login_time']);
			return $list;
		}
		return array ();
	}

	public static function addTeacher($user_data) {
		if (! $user_data || ! is_array ( $user_data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $user_data );
		return $id;
	}


	public static function updateUser($user_id,$user_data) {

		if (! $user_data || ! is_array ( $user_data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$user_id);

		$id = $db->update ( self::getTableName(), $user_data, $condition );
		return $id;
	}

	public static function countSearch($school_id, $grade_id, $class_id, $real_name, $type) {
		$db=self::__instance();
		$where = " where role = $type ";
		if($school_id >0 && $grade_id && $class_id && $real_name!=""){
			$where .= " and grade = $grade and class = $class and name like '%$real_name%'";
		}else{
			if($school_id>0){
				$where .= " and school =$school_id ";
			}
			if($grade_id>0){
				$where .= " and grade=$grade_id ";
			}
			if($class_id>0){
				$where .= " and class=$class_id ";
			}
			if($real_name!=""){
				$where .= " and name like '%$real_name%' ";
			}
		}
		$sql = "select count(*) as count from ".self::getTableName()." $where ";
		// var_dump($sql);

		$num=$db->query($sql)->fetchAll();
		$num = $num[0]['count'];
;
		return $num;
	}

	public static function search($school_id, $grade_id, $class_id, $real_name, $type) {
		$db=self::__instance();
		$limit ="";
		$where = "";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$where = " where role = $type ";
		if($school_id >0 && $grade_id && $class_id && $real_name!=""){
			$where .= " and grade = $grade and class = $class and name like '%$real_name%'";
		}else{
			if($school_id>0){
				$where .= " and school =$school_id ";
			}
			if($grade_id>0){
				$where .= " and grade=$grade_id ";
			}
			if($class_id>0){
				$where .= " and class=$class_id ";
			}
			if($real_name!=""){
				$where .= " and name like '%$real_name%' ";
			}
		}
		$sql = "select * from ".self::getTableName()." $where order by id $limit";

		$list=$db->query($sql)->fetchAll();
		if(!empty($list)){
			foreach($list as &$item){
				$item['grade_name'] = Grade::getGradeById($item['grade'])['grade_name'];
				$item['class_name'] = Banji::getBanjiById($item['class'])['classname'];
				$item['school_name'] = School::getSchoolById($item['school'])['schoolname'];
				$item['addtime'] = date('Y-m-d', $item['addtime']);
			}
		}
		if ($list) {
			return $list;
		}
		return array ();
	}
}
