<?php
class Speech
{
  //init function
  function Speech()
  {

  }

  /**
  *获取所有的教材版本
  **/
  function get_textbooks()
  {
    global $db;
    $sql = "select * from rd_speech_textbook_version";
    return $db->get_results($sql);
  }

  /**
  *获取教材版本下的年级信息
  **/
  function get_grades($textbook)
  {
    global $db;
    $sql = "select * from rd_speech_grade where textbook_version_id=$textbook";
    return $db->get_results($sql);
  }

  /**
  *获取年级下的单元列表
  **/
  function get_units($grade)
  {
    global $db;
    $sql = "select * from rd_speech_unit where grade_id=$grade";
    return $db->get_results($sql);
  }

  /**
  *获取单元下边所有的课文列表
  **/
  function get_pages($unit)
  {
    global $db;
    $sql = "select * from rd_speech_page where unit_id=$unit";
    return $db->get_results($sql);
  }

  /**
  *获取单元下边所有的课文列表
  *新版本
  **/
  function get_pages_ju($unit)
  {
    global $db;
    $sql = "select * from rd_speech_page_ju where unit_id=$unit";
    return $db->get_results($sql);
  }

  /**
  *获取单元下边所有的课文列表
  *明星领读
  **/
  function get_pages_du($unit)
  {
    global $db;
    $sql = "select * from rd_speech_page_du where unit_id=$unit";
    return $db->get_results($sql);
  }

  /**
  *检查语音测评页的路径是否合法
  **/
  function check_path($textbook,$grade,$unit,$page)
  {
    global $db;
    //检查textbook是否存在
    $sql = "select count(id) from rd_speech_textbook_version where id=$textbook";
    if($db->get_var($sql)<1)
    {
      return false;
    }
    //检查textbook下边是否存在grade
    $sql = "select count(id) from rd_speech_grade where textbook_version_id=$textbook and id=$grade";
    if($db->get_var($sql)<1)
    {
      return false;
    }
    //检查grade下边是否有unit
    $sql = "select count(id) from rd_speech_unit where grade_id=$grade and id=$unit";
    if($db->get_var($sql)<1)
    {
      return false;
    }
    //检查unit下边是否有page
    //$sql = "select count(id) from rd_speech_page where unit_id=$unit and id=$page";
    //if($db->get_var($sql)<1)
    //{
    //  return false;
    //}
    return true;
  }

  /**
  *获取测评书籍的面包屑路径
  **/
  function get_path($type,$textbook,$grade,$unit,$page)
  {
    global $db;
    $corum = "";
    if($type=='ju')
    {
      $corum .= $db->get_var("select name from rd_speech_textbook_version where id=$textbook");
      $corum .= ">";
      $corum .= $db->get_var("select name from rd_speech_grade where id=$grade");
      $corum .= ">";
      $corum .= $db->get_var("select name from rd_speech_unit where id=$unit");
      $corum .= ">";
      // $corum .= $db->get_var("select name from rd_speech_page where id=$page");
      $corum .= $db->get_var("select name from rd_speech_page_ju where id=$page");
    }
    else
    {
      $corum .= $db->get_var("select name from rd_speech_textbook_version where id=$textbook");
      $corum .= ">";
      $corum .= $db->get_var("select name from rd_speech_grade where id=$grade");
      $corum .= ">";
      $corum .= $db->get_var("select name from rd_speech_unit where id=$unit");
    }
    return $corum;
  }

  /**
  *获取语音测评的语料
  *type zi=>字 ci=>词 ju=>句
  **/
  function get_test($type,$page)
  {
    global $db;
    $table = "rd_speech_".$type;
    $sql = "select * from $table where page_id=$page";
    $result = $db->get_results($sql);
    //字词的测评要随机抽取10个,当总的个数大于10的时候
    if(count($result)>10 && $type!='ju')
    {
      shuffle($result);
      $ret = [];
      $i=0;
      while($i<10)
      {
        $ret[] = $result[$i];
        $i++;
      }
      return $ret;
    }
    return $result;

  }



}
?>
