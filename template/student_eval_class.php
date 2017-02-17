<?php
  include_once("common.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css" media="screen">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <title>乐智悦读-测评结果</title>
  </head>
  <body>
    <?php
      if(isLogin())
      {
        include_once("../ezSQL/init.php");
        include_once("../class/user.php");
        $user = new User($_SESSION['username'],$_SESSION['password']);
        $user_info = $user->get_user_info();
      }
      else
      {
        echo "Not exist";
        exit();
      }
    ?>
    <center style="height:50px; background:#71cba4; color:#fff;">
      <h4 style="line-height:50px;">
        <div style="float:left; margin-left:1em;"><?php echo $user_info->name?>个人测评动态结果展示台-[全班]</div>
        <div class="float_right" style="margin-right:1em;">
          <button class="btn btn-success" onclick="location.href='student_eval_school.php'">全校</button>
          <button class="btn btn-success active" onclick="location.href='studnet_eval_class.php'">全班</button>
        </div>
      </h4>
    </center>
    <br><br>
    <div class="col-lg-12 col-md-12 cols-sm-12 col-xs-12">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <center><h4 class="gray"><?php echo $user_info->name?>的阅读－图书项测评结果</h4></center>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <center><h4 class="gray"><?php echo $user_info->name?>的普通话测评结果</h4></center>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 cols-sm-12 col-xs-12">

    </div>
  </body>
</html>
