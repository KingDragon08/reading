<?php
if(!defined('ACCESS')) {exit('Access denied.');}

class Question extends Base{
	// 表名
	private static $table_name = 'book_question_obj';
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
	 * 所有详细信息
	 * @param  string $start     [description]
	 * @param  string $page_size [description]
	 * @return [type]            [description]
	 */
	public static function getAllInfos( $start ='' ,$page_size='' ) {
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
				$item['addtime']= date('Y-m-d', $item['addtime']);
				$item['book_name']= Book::getBookById($item['book_id'])['name'];
				$item['view_name']= self::getViewName($item['view']);
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
				return '信息获取';
				break;

			case '3':
				return '直接推论';
				break;

			case '4':
				return '组织概括';
				break;

			case '5':
				return '批判思考';
				break;

			default:
				return '无';
				break;
		}
	}


	public static function countSearch($book_id,$question) {
		$db=self::__instance();
		$condition = array();
		$where = 'where 1=1';
		if($book_id >0  && $question!=""){
			$where .= " and book_id = '$book_id' and question like '%$question%'";
		}else{
			if($book_id>0){
				$where .= " and book_id = '$book_id'";
			}
			if($question!=""){
				$where .= " and question like '%$question%'";
			}
		}

		$sql = "select count(*) as count from ".self::getTableName()." $where ";

		$num=$db->query($sql)->fetchAll();
		$num = $num[0]['count'];
;
		return $num;
	}


	public static function search($book_id,$question,$start , $page_size) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$where = " where 1=1";
		if($book_id >0 && $question!=""){
			$where .= " and book_id = '$book_id' and question like '%$question%'";
		}else{
			if($book_id>0){
				$where .= " and book_id =$book_id ";
			}
			if($question!=""){
				$where .= " and question like '%$question%' ";
			}
		}
		$sql = "select * from ".self::getTableName()." $where order by id $limit";

		$list=$db->query($sql)->fetchAll();
		if(!empty($list)){
			foreach($list as &$item){
				$item['addtime']= date('Y-m-d', $item['addtime']);
				$item['book_name']= Book::getBookById($item['book_id'])['name'];
				$item['view_name']= self::getViewName($item['view']);
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
			'2' => '信息获取',
			'3' => '直接推论',
			'4' => '组织该哟',
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
