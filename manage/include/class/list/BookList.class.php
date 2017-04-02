<?php
if(!defined('ACCESS')) {exit('Access denied.');}

class BookList extends Base{
	// 表名
	private static $table_name = 'read_list';
	// 查询字段
	private static $columns = array('*');

	public static function getTableName(){
		return parent::$table_prefix.self::$table_name;
	}


	/**
	 * 总数
	 * @param  string $condition [description]
	 * @return [type]            [description]
	 */
	public static function count($condition = '') {
		$db=self::__instance();
		$num = $db->count ( self::getTableName(), $condition );
		return $num;
	}

	public static function booknotincout($book_id) {
		$db=self::__instance();
		$sql = "select count(*) as count from ".self::getTableName();
		$sql .= " where id not in ";
		$sql .= "(select list_id from rd_book_list where book_id = '$book_id')";
		$list=$db->query($sql)->fetchAll();
		$num = $list[0]['count'];
		// $num = $db->count ( self::getTableName(), $condition );
		return $num;
	}


	/**
	 * 所有详细信息
	 * @param  string $start     [description]
	 * @param  string $page_size [description]
	 * @return [type]            [description]
	 */
	public static function getAllInfos( $start ='' ,$page_size='', $book_id = '' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName();
		if ($book_id > 0) {
			$sql .= " where id not in ";
			$sql .= "(select list_id from rd_book_list where book_id = '$book_id')";
		}
		$sql .= " order by id $limit";

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);
		if(!empty($list)){
			foreach($list as &$item){
				$item['addtime']= date('Y-m-d', $item['addtime']);
				$item['endtime']= date('Y-m-d', $item['endtime']);
				$item['type_name']= ListType::getInfoById($item['type'])['name'];
				$item['grade_name']= Grade::getGradeById($item['grade'])['grade_name'];
				$item['user_name'] = ($item['user_id'] == '0')? '系统管理员':Teacher::getTeacherById($item['user_id'], '2')['name'];
			}
		}

		if ($list) {
			return $list;
		}
		return array ();
	}



















	public function getViewName($view = '0')
	{
		switch ($view) {
			case '1':
				return '细节认知';
				break;

			case '2':
				return '信息提取';
				break;

			case '3':
				return '意义构建';
				break;

			case '4':
				return '直接推论';
				break;

			case '5':
				return '评判思考';
				break;

			default:
				return '无';
				break;
		}
	}


	public static function countSearch($where) {
		$db=self::__instance();

		$sql = "select count(*) as count from ".self::getTableName()." $where ";

		$num=$db->query($sql)->fetchAll();
		$num = $num[0]['count'];
;
		return $num;
	}


	public static function search($where, $start , $page_size) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." $where order by id $limit";

		$list=$db->query($sql)->fetchAll();
		if(!empty($list)){
			foreach($list as &$item){
				$item['addtime']= date('Y-m-d', $item['addtime']);
				$item['endtime']= date('Y-m-d', $item['endtime']);
				$item['type_name']= ListType::getInfoById($item['type'])['name'];
				$item['grade_name']= Grade::getGradeById($item['grade'])['grade_name'];
				$item['user_name'] = ($item['user_id'] == '0')? '系统管理员':Teacher::getTeacherById($item['user_id'], '2')['name'];
			}
		}
		if ($list) {
			return $list;
		}
		return array ();
	}

	/**
	 * 删除图书
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public static function delInfo($item_id) {
		if (! $item_id || ! is_numeric ( $item_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$item_id);
		$result = $db->delete ( self::getTableName(), $condition );
		return $result;
	}


	public static function getChoiceForOptions() {

		$options_array = array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4'
		);

		return $options_array;
	}


	public static function getViewForOptions() {

		$options_array = array(
			'1' => '细节认知',
			'2' => '信息提取',
			'3' => '意义构建',
			'4' => '直接推论',
			'5' => '批判思考'
		);

		return $options_array;
	}


	/**
	 * 添加图书
	 * @param [type] $user_data [description]
	 */
	public static function addInfo($data) {
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $data );
		return $id;
	}


	public static function getInfoById($info_id) {
		if (! $info_id || ! is_numeric ( $info_id )) {
			return false;
		}
		$db=self::__instance();

		$sql = "select * from ".self::getTableName()." where id = '$info_id'";

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);

		if ($list) {
			$list[0]['addtime']= date('Y-m-d', $list[0]['addtime']);
			$list[0]['endtime']= date('Y-m-d', $list[0]['endtime']);
			$list[0]['type_name']= ListType::getInfoById($list['type'])['name'];
			$list[0]['grade_name']= Grade::getGradeById($list['grade'])['grade_name'];
			$list[0]['user_name']= ($list[0]['user_id'] == '0')? '系统管理员':Teacher::getTeacherById($list[0]['user_id'], '2')['name'];
			return $list[0];
		}

		return array ();
	}



	/**
	 * 修改图书信息
	 * @param  [type] $book_id [description]
	 * @param  [type] $data    [description]
	 * @return [type]          [description]
	 */
	public static function updateInfo($info_id,$data) {

		if (! $info_id || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$info_id);

		$id = $db->update ( self::getTableName(), $data, $condition );
		return $id;
	}

}
