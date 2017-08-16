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
    <title>乐智悦读-个人中心</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        if(!isLogin())//如果没有登录则跳转到首页
        {
          header("Location:index.php");
        }
        else
        {
          $user = $GLOBALS['user'];
          $role = $user->get_user_info()->role;
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
          个人中心
        </div>
      </div>
      <br>
      <div class="container">
        <?php
          if($role == "学生")
          {
            if(isset($_GET['type']) && $_GET['type']=='unread'){
              echo '<iframe src="template/student_left.php?type=unread" id="menu" width="20%" height="auto" style="float:left;" frameborder="0"></iframe>';
              echo '<iframe src="template/msg.php" width="80%" height="auto" id="main" name="main" style="float:left; padding-left:10px; margin-top:2em;" frameborder="0"></iframe>';  
            }
            else{
              echo '<iframe src="template/student_left.php" id="menu" width="20%" height="auto" style="float:left;" frameborder="0"></iframe>';
              echo '<iframe src="template/student_right.php" width="80%" height="auto" id="main" name="main" style="float:left; padding-left:10px; margin-top:2em;" frameborder="0"></iframe>';
            }
          }
          else
          {
            if(isset($_GET['type']) && $_GET['type']=='unread'){
               echo '<iframe src="template/teacher_left.php?type=unread" width="20%" height="auto" id="menu" style="float:left;" frameborder="0"></iframe>';
               echo '<iframe src="template/msg.php" width="80%" height="auto"  id="main" name="main" style="float:left; padding-left:10px; margin-top:2em;" frameborder="0"></iframe>'; 
            }
            else{
              echo '<iframe src="template/teacher_left.php" width="20%" height="auto" id="menu" style="float:left;" frameborder="0"></iframe>';
              echo '<iframe src="template/teacher_right.php" width="80%" height="auto" id="main" name="main" style="float:left; padding-left:10px; margin-top:2em;" frameborder="0"></iframe>';
            }
          }
        ?>
      </div>
      <br>
    <!-- forget panel end -->
    <?php
      include_once("footer.php")
    ?>
  </body>
  <script type="text/javascript">
    $().ready(function(){
      $("#menu").load(function () {
          var mainheight = $(this).contents().find("body").height() + 100;
          $(this).height(mainheight);
      });
      $("#main").load(function () {
          // var mainheight = $(this).contents().find("body").offsetHeight;
          // $(this).height(mainheight);
          var iframe = document.getElementById("main");
          var bHeight = iframe.contentWindow.document.body.scrollHeight;
          var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
          var height = Math.max(bHeight, dHeight);
          iframe.height = height;
      });
    });
  </script>
</html>
