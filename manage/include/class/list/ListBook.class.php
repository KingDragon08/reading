<?php
if(!defined('ACCESS')) {exit('Access denied.');}

class ListBook extends Base{
	// 表名
	private static $table_name = 'book_list';
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


	/**
	 * 所有书籍详细信息
	 * @param  string $start     [description]
	 * @param  string $page_size [description]
	 * @return [type]            [description]
	 */
	public static function getAllBooks($list_id, $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." where list_id = '$list_id' order by id $limit";

		$list=$db->query($sql)->fetchAll();
		// var_dump($list);
		if(!empty($list)){
			foreach($list as &$item){
				$info = Book::getBookById($item['book_id']);
				// var_dump($info);
				$item['name'] = $info['name'];
				$item['author'] = $info['author'];
				$item['press'] = $info['press'];
				$item['presstime'] = $info['presstime'];
				$item['coverimg'] = $info['coverimg'];
				$item['type_name'] = BookType::getGroupById($info['type'])['name'];
				$item['grade_name'] = Grade::getGradeById($info['grade'])['grade_name'];
				$item['level'] = $info['level'];
				$item['score'] = $info['score'];
				$item['wordcount'] = $info['wordcount'];
				// $item['type_name']=BookType::getGroupById($item['type'])['name'];
				// $item['grade_name']=Grade::getGradeById($item['grade'])['grade_name'];
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
	public static function delBook($item_id) {
		if (! $item_id || ! is_numeric ( $item_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$item_id);
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
			$list[0]['presstime']= date('Y-m-d', $list[0]['presstime']);
			return $list[0];
		}


		return array ();
	}

	public static function getInfoByListBook($book_id, $list_id) {
		if (! $book_id || ! is_numeric ( $book_id )) {
			return false;
		}
		if (! $list_id || ! is_numeric ( $list_id )) {
			return false;
		}
		$db=self::__instance();

		$sql = "select * from ".self::getTableName()." where book_id = '$book_id' and list_id = '$list_id'";

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

}
