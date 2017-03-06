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


}
?>
