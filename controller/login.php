<meta charset="utf-8">
<?php
  session_start();
  include("../ezSQL/init.php");
  $from_url =  $_SERVER['HTTP_REFERER'];
  if(isset($_POST['username']) && isset($_POST['password']))
  {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "select count(*) from rd_user where username='". $db->escape($username) ."' and ".
            "password='". $password ."'";
    $count = $db->get_var($sql);
    if($count == 1)
    {
      setcookie("username",$username,time()+7*24*3600,'/');
      setcookie("password",$password,time()+7*24*3600,'/');
      $_COOKIE['username'] = $username;
      $_COOKIE['password'] = $password;
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
    }
    else
    {
      echo "<script>alert('账号或密码不正确');</script>";
    }
  }
  header("Location:$from_url");
?>
