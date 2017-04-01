<?php
  session_start();
  include("../ezSQL/init.php");
  include_once("../class/user.php");
  if(!isset($_POST['sk']) || !isset($_POST['scores']) || !isset($_POST['page']) || !isset($_POST['size']) || !isset($_POST['type']))
  {
      echo '{"error":"error"}';
      exit();
  }
  else
  {
    $sk = $_POST['sk'];
    $scores = json_decode($_POST['scores']);
    $page = intval($_POST['page']);
    $size = intval($_POST['size']);
    $type = $_POST['type'];
    $user = new User($_SESSION['username'],$_SESSION['password']);
    $user_id = $user->get_user_id();
    if($sk !== md5($user_id))
    {
      echo json_encode("error");
      exit();
    }
    if(count($scores)!=$size)
    {
      echo json_encode("error");
      exit;
    }
    if($page<1)
    {
      echo json_encode("error");
      exit();
    }
    if($type!='zi' && $type!='ci' && $type!='ju')
    {
      echo json_encode("error");
      exit();
    }
    $total = 0;
    for($i=0; $i<count($scores); $i++)
    {
      $total += floatval($scores[$i]);
    }
    $average = $total*1.0/count($scores);
    $scores = json_encode($scores);
    $sql = "select count(*) from rd_speech_exam_results where user_id='$user_id'".
            " and page_id='$page' and type='$type'";
    if($db->get_var($sql))//update
    {
      $sql = "update rd_speech_exam_results set scores='$scores',average='$average'".
              " where user_id='$user_id' and page_id='$page' and type='$type'";
    }
    else//insert
    {
      $sql = "insert into rd_speech_exam_results(type,page_id,user_id,scores,average)values('$type',".
              "'$page','$user_id','$scores','$average')";
    }
    $db->query($sql);
    echo json_encode("error:OK");
  }
?>
