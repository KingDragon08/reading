<?php
if(!defined('ACCESS')) {exit('Access denied.');}

class Book extends Base{
	// 表名
	private static $table_name = 'book';
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

	public static function notinlistcount($list_id) {
		$db=self::__instance();
		$sql = "select count(*) as count from ".self::getTableName()." where id not in ";
		$sql .= "(select book_id from rd_book_list where list_id = '$list_id')";
		$res = $db->query($sql)->fetchAll();
		$num = $res[0]['count'];
		return $num;
	}


	/**
	 * 所有书籍详细信息
	 * @param  string $start     [description]
	 * @param  string $page_size [description]
	 * @return [type]            [description]
	 */
	public static function getAllBooks( $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." order by id $limit";

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);
		if(!empty($list)){
			foreach($list as &$item){
				// $item['addtime']= date('Y-m-d', $item['addtime']);
				// $item['presstime']= date('Y-m-d', $item['presstime']);
				$item['type_name']=BookType::getGroupById($item['type'])['name'];
				$item['grade_name']=Grade::getGradeById($item['grade'])['grade_name'];
				$item['short_desc']= mb_substr($item['bookdesc'], 0, 40).'...';
			}
		}

		if ($list) {
			return $list;
		}
		return array ();
	}


	public static function getNotinListBooks($list_id, $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." where id not in ";
		$sql .= "(select book_id from rd_book_list where list_id = '$list_id')";
		$sql .= " order by id $limit";

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);
		if(!empty($list)){
			foreach($list as &$item){
				// $item['addtime']= date('Y-m-d', $item['addtime']);
				// $item['presstime']= date('Y-m-d', $item['presstime']);
				$item['type_name']=BookType::getGroupById($item['type'])['name'];
				$item['grade_name']=Grade::getGradeById($item['grade'])['grade_name'];
				// $item['short_desc']= substr($item['bookdesc'], 10);
			}
		}

		if ($list) {
			return $list;
		}
		return array ();
	}


	/**
	 * 添加图书
	 * @param [type] $user_data [description]
	 */
	public static function addBook($data) {
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $data );
		return $id;
	}


	/**
	 * 删除图书
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public static function delBook($book_id) {
		if (! $book_id || ! is_numeric ( $book_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$book_id);
		$result = $db->delete ( self::getTableName(), $condition );
		return $result;
	}

	public static function getBookById($book_id) {
		if (! $book_id || ! is_numeric ( $book_id )) {
			return false;
		}
		$db=self::__instance();

		$sql = "select * from ".self::getTableName()." where id = '$book_id'";

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);

		if ($list) {
			// $list[0]['presstime']= date('Y-m-d', $list[0]['presstime']);
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
	public static function updateBook($book_id,$data) {

		if (! $book_id || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$book_id);

		$id = $db->update ( self::getTableName(), $data, $condition );
		return $id;
	}


	public static function getInfoForOptions() {
		$option_list = self::getAllBooks ();

		foreach ( $option_list as $option ) {
			$options_array [$option ['id']] = $option ['name'];
		}

		return $options_array;
	}

	public static function countSearch($where) {
		$db=self::__instance();
		$sql = "select count(*) as count from ".self::getTableName()." ".$where;
		// var_dump($sql);
		$res = $db->query($sql)->fetchAll();
		$num = $res[0]['count'];
		return $num;
	}

	public static function search($where, $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}

		$sql = "select * from ".self::getTableName()." $where order by id $limit";

		$list=$db->query($sql)->fetchAll();
		if(!empty($list)){
			foreach($list as &$item){
				// $item['addtime']= date('Y-m-d', $item['addtime']);
				// $item['presstime']= date('Y-m-d', $item['presstime']);
				$item['type_name']=BookType::getGroupById($item['type'])['name'];
				$item['grade_name']=Grade::getGradeById($item['grade'])['grade_name'];
			}
		}
		if ($list) {
			return $list;
		}
		return array ();
	}

}
