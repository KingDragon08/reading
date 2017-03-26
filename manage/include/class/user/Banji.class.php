<?php
if (!defined('ACCESS')) {exit('Access denied.');}

class Banji extends Base
{
	private static $table_name = 'class';

	private static $columns = 'id, banjiname';

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
    public static function getAllBanjis( $start ='' ,$page_size='' ) {
        $db=self::__instance();
        $limit ="";
        if($page_size){
            $limit =" limit $start,$page_size ";
        }
        $sql = "select a.*, b.schoolname, c.name as teaname, d.grade_name as gradename ";
        $sql .= "from rd_class a left join rd_school b on a.school = b.id ";
        $sql .= "left join rd_user c on a.teacher_id = c.id ";
        $sql .= "left join rd_grade d on a.grade = d.id ";
        $sql .= "order by a.id $limit";
        $list=$db->query($sql)->fetchAll();

        if ($list) {
            return $list;
        }
        return array ();
    }


    /**
     * 删除学校
     * @param  [type]  $banji_id [description]
     * @return {[type]            [description]
     */
    public static function delBanji($banji_id) {
		if (! $banji_id || ! is_numeric ( $banji_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("id"=>$banji_id);
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
     * @param  [type]  $banji_name [description]
     * @return {[type]              [description]
     */
    public static function getBanjiByName($banji_name) {
        $db=self::__instance();
        $sql= "select * from ".self::getTableName() ." where banjiname = '$banji_name'";
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
	public static function addBanji($data) {
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();
		$id = $db->insert ( self::getTableName(), $data );
		return $id;
	}


    /**
     * 根据id获取学校
     * @param  [type]  $banji_id [description]
     * @return {[type]            [description]
     */
	public static function getBanjiById($banji_id) {
		if (! $banji_id || ! is_numeric ( $banji_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("AND" =>
						array("id[=]" => $banji_id,
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
     * @param  [type]  $banji_id [description]
     * @param  [type]  $data      [description]
     * @return {[type]            [description]
     */
    public static function updateBanji($banji_id,$data) {

        if (! $data || ! is_array ( $data )) {
            return false;
        }
        $db=self::__instance();
        $condition=array("id"=>$banji_id);

        $id = $db->update ( self::getTableName(), $data, $condition );
        return $id;
    }

}
