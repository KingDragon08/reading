<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css" media="screen">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <title>乐智悦读-登录</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        if(isLogin())
        {
          header("Location:home.php");
        }
        include("ezSQL/init.php");
        if(isset($_POST['username']) && isset($_POST['password']))
        {
          $username = $_POST['username'];
          $password = md5($_POST['password']);
          $sql = "select count(*) from rd_user where username='". $db->escape($username) ."' and ".
                  "password='". $password ."'";
          $count = $db->get_var($sql);
          if($count == 1)//登录成功
          {
            setcookie("username",$username,time()+7*24*3600,'/');
            setcookie("password",$password,time()+7*24*3600,'/');
            $_COOKIE['username'] = $username;
            $_COOKIE['password'] = $password;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header("Location:home.php");
          }
          else//登录失败
          {
            echo "<script>alert('账号或密码不正确');</script>";
          }
        }
      ?>
    <!-- top nav end -->
    <!-- main nav start -->
      <div class="container main-nav">
        <div class="brand">
            <img src="img/nav-brand.png" alt="">
        </div>
        <ul class="navigator">
          <li><a href="index.php">首页</a></li>
          <li><a href="＃">全本阅读</a></li>
          <li><a href="＃">语音朗读</a></li>
          <li><a href="＃">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          登录
        </div>
      </div>
      <br>
      <div class="container">
        <form action="" method="post" onsubmit="return login_register();">
            <div class="input_group_div">
              <i class="glyphicon glyphicon-user f20 gray">&nbsp;</i>
              <input type="tel" name="username" class="input" id="f_username" placeholder="请输入你的手机号">
            </div>
            <div class="input_group_div">
              <i class="glyphicon glyphicon-lock f20 gray">&nbsp;</i>
              <input type="password" name="password" class="input" id="f_new_password" placeholder="请输入密码">
            </div>
            <input type="submit" name="f_submit" id="f_submit" class="btn btn-success lear_more" value="立即登录" style="width:350px; height:40px;">
        </form>
      </div>
      <br>
    <!-- forget panel end -->
    <?php
      include_once("footer.php")
    ?>
  </body>
</html>
