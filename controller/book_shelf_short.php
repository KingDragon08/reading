<meta charset="utf-8">
<?php
  session_start();
  include("../ezSQL/init.php");
  include_once("../class/user.php");
  $from_url =  $_SERVER['HTTP_REFERER'];
  if(!isset($_GET['action']))
  {
      header("Location:$from_url");
      exit();
  }
  $action = $_GET['action'];


  if($action == 'remove')
  {
    if(!isset($_GET['book']))
    {
      header("Location:$from_url");
      exit();
    }
    $book = intval($_GET['book']);
    $user = new User($_SESSION['username'],$_SESSION['password']);
    $user_id = $user->get_user_id();
    $sql = "update rd_user_read_book_short set removed=1 where user_id='$user_id' and book_id='$book' and type=0";
    $db->query($sql);
    // print $sql;
    echo "<script>alert('删除成功');</script>";
    header("Location:$from_url");
  }

  if($action == 'add2shelf')
  {
    if(!isset($_GET['book']))
    {
      header("Location:$from_url");
      exit();
    }
    $book = intval($_GET['book']);
    $user = new User($_SESSION['username'],$_SESSION['password']);
    $user_id = $user->get_user_id();
    $sql = "insert into rd_user_read_book_short(user_id,book_id,removed,type)values('$user_id',".
            "'$book',0,0)";
    // $sql = "insert into rd_user_read_list(user_id,book_list_id)values('$user_id','$book')";
    $db->query($sql);
    echo "<script>alert('加入书架成功');</script>";
    header("Location:$from_url");
  }



?>
