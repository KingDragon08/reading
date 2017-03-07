<?php
class Exam
{
  var $book_id = -1;
  /**
  *init funciton
  **/
  function Exam($id)
  {
    $this->book_id = $id;
  }

  /**
  *获取测试的10个题目
  **/
  function get_questions()
  {
    global $db;
    $ret = [];
    //获取第一类题
    $sql = "select * from rd_book_question_obj where book_id='$this->book_id' and view='1'";
    $question1 = $db->get_results($sql);
    $rand1 = rand(0,5);
    $rand2 = $rand1>2?rand(0,$rand1-1):rand($rand1+1,5);
    $ret[] = $question1[$rand1];
    $ret[] = $question1[$rand2];
    $sql = "select * from rd_book_question_obj where book_id='$this->book_id' and view='2'";
    $question2 = $db->get_results($sql);
    $ret[] = $question2[$rand1];
    $ret[] = $question2[$rand2];
    $sql = "select * from rd_book_question_obj where book_id='$this->book_id' and view='3'";
    $question3 = $db->get_results($sql);
    $ret[] = $question3[$rand1];
    $ret[] = $question3[$rand2];
    $sql = "select * from rd_book_question_obj where book_id='$this->book_id' and view='4'";
    $question4 = $db->get_results($sql);
    $ret[] = $question4[$rand1];
    $ret[] = $question4[$rand2];
    $sql = "select * from rd_book_question_obj where book_id='$this->book_id' and view='5'";
    $question5 = $db->get_results($sql);
    $ret[] = $question5[$rand1];
    $ret[] = $question5[$rand2];
    return $ret;
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
        $ret[] = $db->get_var("select count(*) from rd_book_question_obj where id='".$question_ids[$counter].
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
    $sql = "select count(*) from rd_user_exam_scores where user_id=$user_id and book_id=$book_id and hege=1";
    if($db->get_var($sql)>0)
    {
      return 1;
    }
    //检查当天答题次数是否超过3次
    $sql = "select count(*) from rd_user_exam_scores where user_id=$user_id and book_id=$book_id ".
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
    foreach($scores as $score)
    {
      if(intval($score)==1)
      {
        $hege++;
      }
    }
    if($hege>=6)
    {
      $hege=1;
    }
    else
    {
      $hege=0;
    }
    $scores = implode(",",$scores);
    $answers = implode(",",$answers);
    $question_ids = implode(",",$question_ids);
    $time_string = time();
    $sql = "insert into rd_user_exam_scores(user_id,book_id,scores,hege,use_time,exam_time,answers,question_ids)values(".
            "$user_id,$book_id,'$scores',$hege,$use_time,'$time_string','$answers','$question_ids')";
    $db->query($sql);
    //获取刚插入记录的id
    $sql = "select id from rd_user_exam_scores where user_id=$user_id and book_id=$book_id ".
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
    $sql = "select * from rd_user_exam_scores where user_id='$user_id' and id='$id'";
    $result = $db->get_row($sql);
    if(!$result)
    {
      return 0;
    }
    else
    {
      //获取用时情况
      $use_time = $result->use_time;
      $hours = floor($use_time/3600);
      if($hours<10)
      {
        $hours = "0".$hours;
      }
      $use_time = $use_time%3600;
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
      $result->use_time = $hours.":".$minutes.":".$seconds;
      //获取书的名字
      $result->book_name = $db->get_var("select name from rd_book where id=".$result->book_id);
      //获取得分情况
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
      //将选择答案的1，2，3，4转换为A,B,C,D
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
      }
      $result->answers = $temp;
      return $result;
    }
  }
}
?>
