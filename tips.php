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
    <title>乐智悦读</title>
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
          <li><a href="＃">全本阅读</a></li>
          <li><a href="＃">语音朗读</a></li>
          <li><a href="＃">测评中心</a></li>
        </ul>
      </div>
    <!-- main nav end -->
    <!-- forget panel start -->
      <div class="w100 forget">
        <div class="forget_cover">
          提示信息
        </div>
      </div>
      <br>
      <div class="container" style="min-height:248px;">
        <h5><?php echo json_decode($_GET['error'])?></h5><br>
        <div style="padding-left:2em;">
          <h5>接下来您可以</h5><br>
          <?php
            if($_GET['type'] != 1)
            {
          ?>
            <a href="<?php echo $_GET['from']?>" id="next_go">点我返回</a>
            <span id="count_down">(5s)</span>
          <?php
            }
            else
            {
          ?>
            <a href="<?php echo $_GET['from']?>" id="next_go">立即登录</a>
            <span id="count_down">(5s)</span>
          <?php
            }
          ?>
        </div>
      </div>
      <br>
    <!-- forget panel end -->
    <!-- footer start -->
      <div class="footer">
        <table width="90%" height="160" align="center">
          <tr>
            <td width="65%" align="left" height="160" valign="middle">
              Copyright (c) 2016 北京乐智起航文化发展有限公司 All Rights Reserved.
            </td>
            <td width="35%" align="left" height="160" valign="middle">
                <p>
                  <i class="glyphicon glyphicon-map-marker"></i>
                  地址：北京市海淀区首都师范大学出版社
                </p>
                <p>
                  <i class="glyphicon glyphicon-earphone"></i>
                  电话：123-456-7890
                </p>
                <p>
                  <i class="glyphicon glyphicon-envelope"></i>
                  邮箱：helloworld@gmail.com
                </p>
            </td>
          </tr>
        </table>
      </div>
    <!-- footer end -->
  </body>
</html>
<script type="text/javascript">
counter = 5;
$().ready(function(){
  setInterval("count()",1000);
});
function count()
{
  counter--;
  if(counter>=0)
  {
    $("#count_down").html("("+counter+"s)");
  }
  else {
    location.href = $("#next_go").attr("href");
  }
}
</script>
