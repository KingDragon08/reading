<?php
class Exam_short
{
  var $book_id = -1;
  /**
  *init funciton
  **/
  function Exam_short($id)
  {
    $this->book_id = $id;
  }

  /**
  *1,2年级
  *获取测试的10个题目
  **/
  function get_questions()
  {
    global $db;
    $ret = [];
    //获取第一类题
    $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='1'";
    $question1 = $db->get_results($sql);
    if(count($question1)<3){
      return [];
    }
    $rand1 = rand(0,2);
    $ret[] = $question1[$rand1];
    $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='2'";
    $question2 = $db->get_results($sql);
    if(count($question2)<3){
      return [];
    }
    $ret[] = $question2[$rand1];
    $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='3'";
    $question3 = $db->get_results($sql);
    if(count($question3)<3){
      return [];
    }
    $ret[] = $question3[$rand1];
    $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='4'";
    $question4 = $db->get_results($sql);
    if(count($question4)<3){
      return [];
    }
    $ret[] = $question4[$rand1];
    $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='5'";
    $question5 = $db->get_results($sql);
    if(count($question5)<3){
      return [];
    }
    $ret[] = $question5[$rand1];
    //获取书的封面
    $ret[] = $db->get_var("select coverimg from rd_book_short where id='$this->book_id'");
    return $ret;
  }
  /**
  *3,4,5,6年级
  *获取测试的15个题目
  **/
  function get_questions_2()
  {
    return $this->get_questions();
    // global $db;
    // $ret = [];
    // $rand1 = rand(0,8);
    // $rand2 = $rand1;
    // while($rand2==$rand1)
    // {
    //   $rand2 = rand(0,8);
    // }
    // $rand3 = $rand2;
    // while($rand3==$rand2 || $rand3==$rand1)
    // {
    //   $rand3 = rand(0,8);
    // }
    // //获取第一类题
    // $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='1'";
    // $question1 = $db->get_results($sql);
    // if(count($question1)<9){
    //   return [];
    // }
    // $ret[] = $question1[$rand1];
    // $ret[] = $question1[$rand2];
    // $ret[] = $question1[$rand3];
    // $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='2'";
    // $question2 = $db->get_results($sql);
    // if(count($question2)<9){
    //   return [];
    // }
    // $ret[] = $question2[$rand1];
    // $ret[] = $question2[$rand2];
    // $ret[] = $question2[$rand3];
    // $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='3'";
    // $question3 = $db->get_results($sql);
    // if(count($question3)<9){
    //   return [];
    // }
    // $ret[] = $question3[$rand1];
    // $ret[] = $question3[$rand2];
    // $ret[] = $question3[$rand3];
    // $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='4'";
    // $question4 = $db->get_results($sql);
    // if(count($question4)<9){
    //   return [];
    // }
    // $ret[] = $question4[$rand1];
    // $ret[] = $question4[$rand2];
    // $ret[] = $question4[$rand3];
    // $sql = "select * from rd_book_question_obj_short where book_id='$this->book_id' and view='5'";
    // $question5 = $db->get_results($sql);
    // if(count($question5)<9){
    //   return [];
    // }
    // $ret[] = $question5[$rand1];
    // $ret[] = $question5[$rand2];
    // $ret[] = $question5[$rand3];
    // //获取书的封面
    // $ret[] = $db->get_var("select coverimg from rd_book_short where id='$this->book_id'");
    // return $ret;
  }

  /**
  *计算得分
  **/
  function scores($question_ids,$answers)
  {
    global $db;
    $ret = [];
    for($counter=0;$counter<count($question_ids);$counter++)
    {
        $ret[] = $db->get_var("select count(*) from rd_book_question_obj_short where id='".$question_ids[$counter].
                              "' and answer='".$answers[$counter]."'");
    }
    return $ret;
  }

  /**
  *检查当天是否有答题权限
  *0 可以答题
  *1 已经通过
  *2 当天答题次数已经达到3次
  **/
  function can_exam($user_id,$book_id)
  {
    global $db;
    $y = date("Y");
    $m = date("m");
    $d = date("d");
    $day_start = mktime(0,0,0,$m,$d,$y);
    $day_end= mktime(23,59,59,$m,$d,$y);
    //首先检查是否有合格数据
    $sql = "select count(*) from rd_user_exam_scores_short where user_id=$user_id and book_id=$book_id and hege=1";
    if($db->get_var($sql)>0)
    {
      return 1;
    }
    //检查当天答题次数是否超过3次
    $sql = "select count(*) from rd_user_exam_scores_short where user_id=$user_id and book_id=$book_id ".
            "and hege=0 and exam_time>$day_start and exam_time<$day_end";
    if($db->get_var($sql)>=3)
    {
      return 2;
    }
    return 0;
  }

  /**
  *写测试结果
  *返回测试结果的id
  **/
  function write_scores($user_id,$book_id,$scores,$use_time,$answers,$question_ids)
  {
    global $db;
    $hege = 0;
    $total_score = 0;
    foreach($scores as $score)
    {
      if(intval($score)==1)
      {
        $hege++;
        $total_score++;
      }
    }
    if($hege>=intval(count($scores)*0.6))
    {
      $hege=1;
    }
    else
    {
      $hege=0;
    }
    $temp_scores = implode(",",$scores);
    $answers = implode(",",$answers);
    $question_ids = implode(",",$question_ids);
    $time_string = time();
    //向测试结果表中写入数据
    $sql = "insert into rd_user_exam_scores_short(user_id,book_id,scores,hege,use_time,exam_time,answers,question_ids,score)values(".
            "$user_id,$book_id,'$temp_scores',$hege,$use_time,'$time_string','$answers','$question_ids','$total_score')";
    $db->query($sql);
    //如果合格则更新用户表的score_short,item1_socre_short,item2_socre_short,item3_socre_short,item4_socre_short,item5_socre_short字段，方便排名
    if($hege==1)
    {
        $sql = "update rd_user set score_short=score_short+$total_score,".
                "item1_score_short=item1_score_short+$scores[0],".
                "item2_score_short=item2_score_short+$scores[1],".
                "item3_score_short=item3_score_short+$scores[2],".
                "item4_score_short=item4_score_short+$scores[3],".
                "item5_score_short=item5_score_short+$scores[4]".
                " where id=$user_id";
        $db->query($sql);
    }
    //获取刚插入记录的id
    $sql = "select id from rd_user_exam_scores_short where user_id=$user_id and book_id=$book_id ".
            "and exam_time='$time_string'";
    $id = $db->get_var($sql);
    return $id;
  }

  /**
  *展示测评结果
  **/
  function get_exam_report($user_id,$id)
  {
    global $db;
    $sql = "select * from rd_user_exam_scores_short where user_id='$user_id' and id='$id'";
    $result = $db->get_row($sql);
    if(!$result)
    {
      return 0;
    }
    else
    {
      //获取书的名字
      $result->book_name = $db->get_var("select name from rd_book_short where id=".$result->book_id);

      //获取得分情况,添加新字段后可优化
      $scores = $result->scores;
      $scores = explode(",",$scores);
      $total_score = 0;
      foreach($scores as $score)
      {
        if($score==1)
        {
          $total_score++;
        }
      }
      $result->total_score = $total_score;
      $result->scores = $scores;

      //获取用时情况
      $use_time = 40*count($scores)-$result->use_time;
      $minutes = floor($use_time/60);
      if($minutes<10)
      {
        $minutes = "0".$minutes;
      }
      $seconds = $use_time%60;
      if($seconds<10)
      {
        $seconds = "0".$seconds;
      }
      $result->use_time = $minutes.":".$seconds;

      //将选择答案的1，2，3，4,5转换为A,B,C,D,未作答
      $answers = $result->answers;
      $answers = explode(",",$answers);
      $temp = [];
      foreach($answers as $answer)
      {
        if($answer==1)
        {
          $temp[] = "A";
        }
        if($answer==2)
        {
          $temp[] = "B";
        }
        if($answer==3)
        {
          $temp[] = "C";
        }
        if($answer==4)
        {
          $temp[] = "D";
        }
        if($answer==5)
        {
          $temp[] = "未做答";
        }
      }
      $result->answers = $temp;
      return $result;
    }
  }

  /**
  *获取书的名称
  **/
  function get_book_name($book)
  {
    global $db;
    return $db->get_var("select name from rd_book_short where id='$book'");
  }

  /**
  *获取短篇的文字内容
  **/
  public function get_text(){
    global $db;
    $id = $this->book_id;
    $sql = "select bookdesc from rd_book_short where id='$id'";
    return $db->get_var($sql);
  }


}
?>
