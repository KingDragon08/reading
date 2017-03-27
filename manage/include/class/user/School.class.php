<?php
if (!defined('ACCESS')) {exit('Access denied.');}

class School extends Base
{
	private static $table_name = 'school';

	private static $columns = 'id, schoolname';

	public static function getTableName()
	{
        return parent::$table_prefix.self::$table_name;
	}


    /**
     * 分页获取所有学校
     * @param  string  $start     [description]
     * @param  string  $page_size [description]
     * @return {[type]            [description]
     */
    public static function getAllSchools( $start ='' ,$page_size='' ) {
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


    /**
     * 删除学校
     * @param  [type]  $school_id [description]
     * @return {[type]            [description]
     */
    public static function delSchool($school_id) {
		if (! $school_id || ! is_numeric ( $school_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$school_id);
		$result = $db->delete ( self::getTableName(), $condition );
		return $result;
	}


    /**
     * 学校总数
     * @param  string  $condition [description]
     * @return {[type]            [description]
     */
	public static function count($condition = '') {
		$db=self::__instance();
		$num = $db->count ( self::getTableName(), $condition );
		return $num;
	}


    /**
     * 根据名称查询学校
     * @param  [type]  $school_name [description]
     * @return {[type]              [description]
     */
    public static function getSchoolByName($school_name) {
        $db=self::__instance();
        $sql= "select * from ".self::getTableName() ." where schoolname = '$school_name'";
        $list = $db->query($sql)->fetch();
        if ($list) {
            // $list['login_time']=Common::getDateTime($list['login_time']);
            return $list;
        }
        return array ();
    }


    /**
     * 添加学校
     * @param [type] $data [description]
     */
	public static function addSchool($data) {
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $data );
		return $id;
	}


    /**
     * 根据id获取学校
     * @param  [type]  $school_id [description]
     * @return {[type]            [description]
     */
	public static function getSchoolById($school_id) {
		if (! $school_id || ! is_numeric ( $school_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("AND" =>
						array("id[=]" => $school_id,
						)
					);
		$list = $db->select ( self::getTableName(), self::$columns, $condition );

		if ($list) {
			// $list[0]['login_time']=Common::getDateTime($list[0]['login_time']);
			return $list [0];
		}
		return array ();
	}


    /**
     * 更新学校信息
     * @param  [type]  $school_id [description]
     * @param  [type]  $data      [description]
     * @return {[type]            [description]
     */
    public static function updateSchool($school_id,$data) {

        if (! $data || ! is_array ( $data )) {
            return false;
        }
        $db=self::__instance();
        $condition=array("id"=>$school_id);

        $id = $db->update ( self::getTableName(), $data, $condition );
        return $id;
    }

}
