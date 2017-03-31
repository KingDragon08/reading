<?php
  session_start();
  include("../ezSQL/init.php");
  include_once("../class/user.php");
  if(!isset($_POST['sk']) || !isset($_POST['scores']) || !isset($_POST['page']) || !isset($_POST['size']))
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
    $total = 0;
    for($i=0; $i<count($scores); $i++)
    {
      $total += intval($scores[$i]);
    }
    $average = $total*1.0/count($scores);
    $sql =  "insert into table values('".$_POST['scores']."','$average','$user_id','$page')";
    echo json_encode("error:$sql");
  }
?>
