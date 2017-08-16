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
    <title>乐智悦读-注册</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include("top.php");
      ?>
    <!-- top nav end -->
    <!-- main nav start -->
      <div class="container main-nav">
        <div class="brand">
            <img src="img/nav-brand.png" alt="">
        </div>
        <ul class="navigator">
          <li><a href="index.php">首页</a></li>
          <li><a href="full_reading.php">全本阅读</a></li>
          <li><a href="page_reading.php">短篇阅读</a></li>
          <li><a href="ing.php">语音朗读</a></li>
          <li><a href="report.php">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          注册
        </div>
      </div>
      <br>
      <div class="container">
        <h5>请务必填入真实手机号码哟</h5><br>
        <form action="controller/register.php" method="post" onsubmit="return check_register();">
            <div class="input_group_div">
              <i class="glyphicon glyphicon-user f20 gray">&nbsp;</i>
              <input type="tel" name="username" class="input" id="f_username" placeholder="请输入你的注册手机号">
            </div>
            <div class="input_group_div">
              <i class="glyphicon glyphicon-th f20 gray">&nbsp;</i>
              <input type="tel" class="input" name="verify_code" id="f_verify_code" placeholder="请输入验证码" style="width:180px;">
              <span class="label label-lg label-info float_right" id="get_verify_code" style="margin-top:8px;" onclick="get_verify_code()">获取验证码</span>
            </div>
            <div class="input_group_div">
              <i class="glyphicon glyphicon-lock f20 gray">&nbsp;</i>
              <input type="password" name="password" class="input" id="f_new_password" placeholder="请输入密码" maxlength="20">
            </div>
            <div class="input_group_div">
              <i class="glyphicon glyphicon-lock f20 gray">&nbsp;</i>
              <input type="password" class="input" name="re_password" id="f_new_password_repeat" placeholder="请再次输入新密码" maxlength="20">
            </div>
            <input type="submit" name="f_submit" id="f_submit" class="btn btn-success lear_more" value="立即注册" style="width:350px; height:40px;">
        </form>
      </div>
      <br>
    <!-- forget panel end -->
    <?php
      include_once("footer.php")
    ?>
  </body>
</html>
