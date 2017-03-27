<?php
if (!defined('ACCESS')) {exit('Access denied.');}

class Grade extends Base
{
	private static $table_name = 'grade';

	private static $columns = 'id, grade_name';

	public static function getTableName()
	{
        return parent::$table_prefix.self::$table_name;
	}


    /**
     * 分页获取所有年级
     * @param  string  $start     [description]
     * @param  string  $page_size [description]
     * @return {[type]            [description]
     */
    public static function getAllGrades( $start ='' ,$page_size='' ) {
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
     * 删除年级
     * @param  [type]  $grade_id [description]
     * @return {[type]            [description]
     */
    public static function delGrade($grade_id) {
		if (! $grade_id || ! is_numeric ( $grade_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$grade_id);
		$result = $db->delete ( self::getTableName(), $condition );
		return $result;
	}


    /**
     * 年级总数
     * @param  string  $condition [description]
     * @return {[type]            [description]
     */
	public static function count($condition = '') {
		$db=self::__instance();
		$num = $db->count ( self::getTableName(), $condition );
		return $num;
	}


    /**
     * 根据名称查询年级
     * @param  [type]  $grade_name [description]
     * @return {[type]              [description]
     */
    public static function getGradeByName($grade_name) {
        $db=self::__instance();
        $sql= "select * from ".self::getTableName() ." where grade_name = '$grade_name'";
        $list = $db->query($sql)->fetch();
        if ($list) {
            // $list['login_time']=Common::getDateTime($list['login_time']);
            return $list;
        }
        return array ();
    }


    /**
     * 添加年级
     * @param [type] $data [description]
     */
	public static function addGrade($data) {
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $data );
		return $id;
	}


    /**
     * 根据id获取年级
     * @param  [type]  $grade_id [description]
     * @return {[type]            [description]
     */
	public static function getGradeById($grade_id) {
		if (! $grade_id || ! is_numeric ( $grade_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("AND" =>
						array("id[=]" => $grade_id,
						)
					);
		$list = $db->select ( self::getTableName(), self::$columns, $condition );
        // var_dump(urlencode($list)w);

		if ($list) {
			// $list[0]['login_time']=Common::getDateTime($list[0]['login_time']);
			return $list [0];
		}
		return array ();
	}


    /**
     * 更新年级信息
     * @param  [type]  $grade_id [description]
     * @param  [type]  $data      [description]
     * @return {[type]            [description]
     */
    public static function updateGrade($grade_id,$data) {

        if (! $data || ! is_array ( $data )) {
            return false;
        }
        $db=self::__instance();
        $condition=array("id"=>$grade_id);

        $id = $db->update ( self::getTableName(), $data, $condition );
        return $id;
    }


	public static function getGradeForOptions() {
		$option_list = self::getAllGrades ();

		foreach ( $option_list as $option ) {
			$options_array [$option ['id']] = $option ['grade_name'];
		}

		return $options_array;
	}
}
