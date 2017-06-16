<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css" media="screen">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <title>乐智悦读-校长端</title>
  </head>
  <body>
    <!-- top nav start-->
      <?php
        include_once("top.php");
        if(!isLogin())
        {
          header("Location:index.php");
        }
      ?>
    <!-- top nav end -->
    <!-- main nav start -->
      <div class="container main-nav">
        <div class="brand">
            <img src="../img/nav-brand.png" alt="">
        </div>
        <ul class="navigator"></ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          校长端
        </div>
      </div>
      <br>
      <div class="container" style="margin:50px auto; text-align:center; margin-top:0;">
          <iframe src="menu.php" id="menu" width="20%" height="auto" style="float:left;" frameborder="0"></iframe>
          <iframe src="main.php" width="80%" height="auto" id="main" name="main" style="float:left; padding-left:10px; margin-top:2em;" frameborder="0"></iframe>
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
