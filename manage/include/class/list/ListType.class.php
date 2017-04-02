<?php
if(!defined('ACCESS')) {exit('Access denied.');}
class ListType extends Base {
	// 表名
	private static $table_name = 'list_type';
	// 查询字段
	private static $columns = array('id', 'name');

	public static function getTableName(){
		return parent::$table_prefix.self::$table_name;
	}

	public static function getInfoById($item_id) {
		if (! $item_id || ! is_numeric ( $item_id )) {
			return false;
		}
		$db=self::__instance();
		$condition['id'] = $item_id;
		$list = $db->select ( self::getTableName(), self::$columns, $condition );
		if ($list) {
			return $list [0];
		}
		return array ();
	}


	public static function getAllGroup( $start ='' ,$page_size='' ) {
		$db=self::__instance();
		$limit ="";
		if($page_size){
			$limit =" limit $start,$page_size ";
		}
		$sql = "select * from ".self::getTableName()." order by id $limit";

		$list=$db->query($sql)->fetchAll();

		if ($list) {

			return $list;
		}
		return array ();
	}


	public static function getInfoForOptions() {
		$group_list = self::getAllGroup ();

		foreach ( $group_list as $group ) {
			$group_options_array [$group ['id']] = $group ['name'];
		}

		return $group_options_array;
	}

    public static function delType($type_id) {
        if (! $type_id || ! is_numeric ( $type_id )) {
            return false;
        }
        $db=self::__instance();
        $condition = array("id" => $type_id);
        $result = $db->delete ( self::getTableName(), $condition );
        return $result;
    }


    public static function count($condition = '') {
        $db=self::__instance();
        $num = $db->count ( self::getTableName(), $condition );
        return $num;
    }

    public static function getTypeByName($type_name) {
		if ( $type_name == "" ) {
			return false;
		}
		$db=self::__instance();
		$condition['name'] = $type_name;
		$list = $db->select ( self::getTableName(), self::$columns, $condition );
		if ($list) {
			return $list [0];
		}
		return array ();
	}

	public static function addType($data) {
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $data );
		return $id;
	}

	public static function updateType($type_id,$data) {
		if (! $type_id || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$condition=array("id"=>$type_id);
		$id = $db->update ( self::getTableName(), $data,$condition );

		return $id;
	}

}
